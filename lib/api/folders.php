<?php

function get_folder_base_query($type, $user_id) {
    switch ($type) {
    case 'user':
        return FolderQuery::create()->filterByUserId($user_id);
    case 'organization':
        // unimplmented
        return false;
    default:
        error('no-such-folder-type', "We don't have that type of folder(, yet?)");
        return false;
    }
}

// you should have verified $type is usable before calling this!
function verify_path($type, $path, $parent_id, $user_id, $forbidden_id = false) {
    $base_query = get_folder_base_query($type, $user_id);
    $segment = array_shift($path);
    if (empty($segment))
        return array(
            'verified' => true,
            'pid' => $parent_id
        );

    $db_seg = $base_query->filterByParentId($parent_id)->findOneByFolderName($segment);
    if (empty($db_seg))
        return array('verified' => false);

    $folder_id = $db_seg->getFolderId();
    // This is used to verify that a certain folder is not part of the path.
    // Knowing this is important for "Move".
    if (!empty($forbidden_id) && $folder_id == $forbidden_id)
        return array('verified' => false);

    return verify_path($type, $path, $folder_id, $user_id);
}


/**
 * make a chart available in a certain folder
 *
 * @param type the type of folder
 * @param chart_id the charts id?
 * @param path the destination folder
 */
$app->put('/folders/chart/:type/:chart_id/:path+', function($type, $chart_id, $path) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $accessible = false;
    if_chart_is_writable($chart_id, function($user, $chart) use (&$accessible) {
        $accessible = true;
    });
    if(!$accessible) {
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) {
        return;
    }

    $folders = $base_query->find();
    if ($folders->count() == 0) {
        error('no-folders', "This user hasn't got any folders of the requested type.");
        return;
    }

    // this should be save, because noone can delete his root folder manually (without DB access)
    $root_id = $base_query->findOneByParentId(null)->getFolderId();
    $pv = verify_path($type, $path, $root_id, $user_id);

    if (!$pv['verified']) {
        error('no-such-path', 'Path does not exist.');
        return;
    }

    $chart = ChartQuery::create()->findPK($chart_id);
    $chart->setInFolder($pv['pid'])->save();
    ok();
});


/**
 * remove a chart from a folder
 * when a chart is removed, its in_folder field will be set to NULL making it go back to all charts
 * bacause the chart can only be located in one folder it is not necessary to specify the path
 *
 * @param type the type of folder
 * @param chart_id the charts id?
 */
$app->delete('/folders/chart/:type/:chart_id', function($type, $chart_id) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $accessible = false;
    if_chart_is_writable($chart_id, function($user, $chart) use (&$accessible) {
        $accessible = true;
    });
    if(!$accessible) {
        error('access-denied', 'You may not (re)move this chart.');
        return;
    }

    $chart = ChartQuery::create()->findPK($chart_id);
    $chart->setInFolder(null)->save();

    ok();
});


/**
 * get an array of all chart ids in a folder
 *
 * @param type the type of folder
 * @param path the destination folder
 */
$app->get('/folders/chart/:type/(:path+|)/?', function($type, $path = false) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) return;

    if (!$path) {
        error('no-path', 'Will not list charts in root - use /api/charts.');
        return;
    }

    $root_id = $base_query->findOneByParentId(null)->getFolderId();
    if (empty($root_id)) {
        error('no-folders', 'This user hasn\'t got any folders');
        return;
    }

    $pv = verify_path($type, $path, $root_id, $user_id);

    if (!$pv['verified']) {
        error('no-such-path', 'Path does not exist.');
        return;
    }

    $res = ChartQuery::create()->findByInFolder($pv['pid']);
    $mapped = array_map(function($entry) {
        return $entry->getId();
    }, (array)$res);
    ok($mapped);
});


/**
 * create a new folder
 *
 * @param type the type of folder which should be created
 * @param path the absolue path where the directory should be created
 * @param dirname the name of the directory to be created
 */
$app->post('/folders/dir/:type/(:path+/|):dirname/?', function($type, $path, $dirname) use ($app){
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) return;

    $folders = $base_query->find();
    // Does the user have a root folder?
    if ($folders->count() == 0) {
        $rootfolder = new Folder();
        $rootfolder->setUserId($user_id)->setFolderName('ROOT')->save();
    }
    // find root
    $root_id = $base_query->findOneByParentId(null)->getFolderId();

    // does path exists? ("" is ok, too)
    $pv = verify_path($type, $path, $root_id, $user_id);
    if (!$pv['verified']) {
        error('no-such-path', 'Path does not exist.');
        return;
    }

    // We need a fresh base_query here! Don't ask me why, but we do. (tested)
    $base_query = get_folder_base_query($type, $user_id);
    $parent_id = $pv['pid'];
    if (empty($base_query->filterByParentId($parent_id)->findOneByFolderName($dirname))) {
        // Does not exist → create it!
        $new_folder = new Folder();
        $new_folder->setUserId($user_id)->setFolderName($dirname)->setParentId($parent_id)->save();
    }
    // does exists → that's ok, too
    ok();
});

function list_subdirs($type, $parent_id, $user_id, $org_id = false) {
    $base_query = get_folder_base_query($type, $user_id);
    $subdirs = $base_query->findByParentId($parent_id);

    $node = new stdClass();

    if ($subdirs->count() == 0) {
        return false;
    }

    foreach ($subdirs as $dir) {
        $name = $dir->getFolderName();
        $dir_id = $dir->getFolderId();
        $data = new stdClass();
        $data->id = $dir_id;
        $data->charts = ChartQuery::create()->findByInFolder($dir_id)->count();
        $data->sub = list_subdirs($type, $dir_id, $user_id);
        $node->$name = $data;
    }

    return $node;
}

/**
 * list all subdirectorys
 *
 * @param type the type of folder which should be listed
 * @param path the startding point in the dir tree
 */
$app->get('/folders/dir/:type/(:path+|)/?', function($type, $path = []) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) return;

    // find root
    $root_id = $base_query->findOneByParentId(null)->getFolderId();
    if (empty($root_id)) {
        error('no-folders', "This user hasn\'t got any folders");
        return;
    }

    // does path exists? ("" is ok, too)
    $pv = verify_path($type, $path, $root_id, $user_id);
    if (!$pv['verified']) {
        error('no-such-path', 'Path does not exist.');
        return;
    }

    ok(list_subdirs($type, $pv['pid'], $user_id));
});


/**
 * delete a subfolder
 * root can not be removed
 * folders which still contain other subfolders can not be removed
 * if a folder contains charts, all of those will be moved to the parent folder
 *
 * @param type the type of folder which should be deleted
 * @param path the folder to be deleted
 */
$app->delete('/folders/dir/:type/:path+/?', function($type, $path) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) return;

    // find root
    $root_id = $base_query->findOneByParentId(null)->getFolderId();
    if (empty($root_id)) {
        error('no-folders', "This user hasn\'t got any folders");
        return;
    }

    // does path exists? ("" can not happen!)
    $pv = verify_path($type, $path, $root_id, $user_id);
    if (!$pv['verified']) {
        error('no-such-path', 'Path does not exist.');
        return;
    }

    $current_id = $pv['pid'];
    $tree = list_subdirs($type, $current_id, $user_id);
    if ($tree) {
        error('remaining-subfolders', 'You have to remove all subdfolders, before you can delete a folder.');
        return;
    }

    $current_folder = FolderQuery::create()->findOneByFolderId($current_id);
    $parent_id = $current_folder->getParentId();
    if ($parent_id == $root_id) {
        // prevent charts to go back to the virtual root folder
        $parent_id = null;
    }
    $charts = ChartQuery::create()->findByInFolder($current_id);
    foreach ($charts as $chart) {
        $chart->setInFolder($parent_id)->save();
    }
    //finally delete folder
    $current_folder->delete();
    ok();
});


/**
 * move a folder to another folder
 * basically this means just to change the parent id of the folder
 *
 * @param type the type of folder which should be moved
 * @param path the folder to be moved
 * @param dst (query string!) the destination folder
 */

$app->put('/folders/dir/:type/:path+/?', function($type, $path) use ($app) {
    disable_cache($app);
    $user = DatawrapperSession::getUser();

    if (!$user->isLoggedIn()) {
        error('access-denied', 'User is not logged in.');
        return;
    }

    $user_id = $user->getId();
    $base_query = get_folder_base_query($type, $user_id);
    if (!$base_query) return;

    $dst = $app->request()->get('dst');
    if (empty($dst)) {
        error('no-destination', 'The destination to move this dir to was not set.');
        return;
    }

    $dst_path = explode('/', trim($dst,'/'));

    $root_id = $base_query->findOneByParentId(null)->getFolderId();
    if (empty($root_id)) {
        error('no-folders', 'This user hasn\'t got any folders');
        return;
    }

    // do paths exists? ("" can not happen!)
    $pv = verify_path($type, $path, $root_id, $user_id);
    if (!$pv['verified']) {
        error('no-source-path', 'Source path does not exist.');
        return;
    }

    $current_id = $pv['pid'];
    // if current folder is part of the path, verification will fail
    $pv = verify_path($type, $dst_path, $root_id, $user_id, $current_id);
    if (!$pv['verified']) {
        error('no-destination-path', 'Destination path does not exist.');
        return;
    }

    $dst_id = $pv['pid'];
    FolderQuery::create()->findOneByFolderId($current_id)->setParentId($dst_id)->save();
    ok();
});