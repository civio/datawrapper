<?php


/**
 * Base class that represents a row from the 'basemap' table.
 *
 *
 *
 * @package    propel.generator.datawrapper.om
 */
abstract class BaseBasemap extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'BasemapPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BasemapPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the key field.
     * @var        string
     */
    protected $key;

    /**
     * The value for the region_id field.
     * @var        string
     */
    protected $region_id;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $version;

    /**
     * The value for the last_version field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $last_version;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the version_title field.
     * @var        string
     */
    protected $version_title;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the regions field.
     * @var        string
     */
    protected $regions;

    /**
     * The value for the borders field.
     * @var        string
     */
    protected $borders;

    /**
     * The value for the keys field.
     * @var        string
     */
    protected $keys;

    /**
     * The value for the raw_data field.
     * @var        string
     */
    protected $raw_data;

    /**
     * The value for the mapshaper_parameters field.
     * @var        string
     */
    protected $mapshaper_parameters;

    /**
     * The value for the topojson field.
     * @var        string
     */
    protected $topojson;

    /**
     * The value for the is_public field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $is_public;

    /**
     * @var        Region
     */
    protected $aRegion;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 1;
        $this->last_version = 1;
        $this->is_public = true;
    }

    /**
     * Initializes internal state of BaseBasemap object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [key] column value.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the [region_id] column value.
     *
     * @return string
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [last_version] column value.
     *
     * @return int
     */
    public function getLastVersion()
    {
        return $this->last_version;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [version_title] column value.
     *
     * @return string
     */
    public function getVersionTitle()
    {
        return $this->version_title;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [regions] column value.
     *
     * @return string
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Get the [borders] column value.
     *
     * @return string
     */
    public function getBorders()
    {
        return $this->borders;
    }

    /**
     * Get the [keys] column value.
     *
     * @return string
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Get the [raw_data] column value.
     *
     * @return string
     */
    public function getRawData()
    {
        return $this->raw_data;
    }

    /**
     * Get the [mapshaper_parameters] column value.
     *
     * @return string
     */
    public function getMapshaperParameters()
    {
        return $this->mapshaper_parameters;
    }

    /**
     * Get the [topojson] column value.
     *
     * @return string
     */
    public function getTopojson()
    {
        return $this->topojson;
    }

    /**
     * Get the [is_public] column value.
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = BasemapPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [key] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->key !== $v) {
            $this->key = $v;
            $this->modifiedColumns[] = BasemapPeer::KEY;
        }


        return $this;
    } // setKey()

    /**
     * Set the value of [region_id] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = BasemapPeer::REGION_ID;
        }

        if ($this->aRegion !== null && $this->aRegion->getId() !== $v) {
            $this->aRegion = null;
        }


        return $this;
    } // setRegionId()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[] = BasemapPeer::VERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [last_version] column.
     *
     * @param int $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setLastVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->last_version !== $v) {
            $this->last_version = $v;
            $this->modifiedColumns[] = BasemapPeer::LAST_VERSION;
        }


        return $this;
    } // setLastVersion()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = BasemapPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [version_title] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setVersionTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->version_title !== $v) {
            $this->version_title = $v;
            $this->modifiedColumns[] = BasemapPeer::VERSION_TITLE;
        }


        return $this;
    } // setVersionTitle()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Basemap The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = BasemapPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [regions] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setRegions($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->regions !== $v) {
            $this->regions = $v;
            $this->modifiedColumns[] = BasemapPeer::REGIONS;
        }


        return $this;
    } // setRegions()

    /**
     * Set the value of [borders] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setBorders($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->borders !== $v) {
            $this->borders = $v;
            $this->modifiedColumns[] = BasemapPeer::BORDERS;
        }


        return $this;
    } // setBorders()

    /**
     * Set the value of [keys] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setKeys($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->keys !== $v) {
            $this->keys = $v;
            $this->modifiedColumns[] = BasemapPeer::KEYS;
        }


        return $this;
    } // setKeys()

    /**
     * Set the value of [raw_data] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setRawData($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->raw_data !== $v) {
            $this->raw_data = $v;
            $this->modifiedColumns[] = BasemapPeer::RAW_DATA;
        }


        return $this;
    } // setRawData()

    /**
     * Set the value of [mapshaper_parameters] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setMapshaperParameters($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->mapshaper_parameters !== $v) {
            $this->mapshaper_parameters = $v;
            $this->modifiedColumns[] = BasemapPeer::MAPSHAPER_PARAMETERS;
        }


        return $this;
    } // setMapshaperParameters()

    /**
     * Set the value of [topojson] column.
     *
     * @param string $v new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setTopojson($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->topojson !== $v) {
            $this->topojson = $v;
            $this->modifiedColumns[] = BasemapPeer::TOPOJSON;
        }


        return $this;
    } // setTopojson()

    /**
     * Sets the value of the [is_public] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Basemap The current object (for fluent API support)
     */
    public function setIsPublic($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_public !== $v) {
            $this->is_public = $v;
            $this->modifiedColumns[] = BasemapPeer::IS_PUBLIC;
        }


        return $this;
    } // setIsPublic()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->version !== 1) {
                return false;
            }

            if ($this->last_version !== 1) {
                return false;
            }

            if ($this->is_public !== true) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->key = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->region_id = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->version = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->last_version = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->title = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->version_title = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->created_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->regions = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->borders = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->keys = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->raw_data = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->mapshaper_parameters = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->topojson = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->is_public = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 15; // 15 = BasemapPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Basemap object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aRegion !== null && $this->region_id !== $this->aRegion->getId()) {
            $this->aRegion = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BasemapPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = BasemapPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRegion = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BasemapPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = BasemapQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BasemapPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BasemapPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aRegion !== null) {
                if ($this->aRegion->isModified() || $this->aRegion->isNew()) {
                    $affectedRows += $this->aRegion->save($con);
                }
                $this->setRegion($this->aRegion);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = BasemapPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BasemapPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BasemapPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(BasemapPeer::KEY)) {
            $modifiedColumns[':p' . $index++]  = '`key`';
        }
        if ($this->isColumnModified(BasemapPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }
        if ($this->isColumnModified(BasemapPeer::VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`version`';
        }
        if ($this->isColumnModified(BasemapPeer::LAST_VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`last_version`';
        }
        if ($this->isColumnModified(BasemapPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(BasemapPeer::VERSION_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`version_title`';
        }
        if ($this->isColumnModified(BasemapPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(BasemapPeer::REGIONS)) {
            $modifiedColumns[':p' . $index++]  = '`regions`';
        }
        if ($this->isColumnModified(BasemapPeer::BORDERS)) {
            $modifiedColumns[':p' . $index++]  = '`borders`';
        }
        if ($this->isColumnModified(BasemapPeer::KEYS)) {
            $modifiedColumns[':p' . $index++]  = '`keys`';
        }
        if ($this->isColumnModified(BasemapPeer::RAW_DATA)) {
            $modifiedColumns[':p' . $index++]  = '`raw_data`';
        }
        if ($this->isColumnModified(BasemapPeer::MAPSHAPER_PARAMETERS)) {
            $modifiedColumns[':p' . $index++]  = '`mapshaper_parameters`';
        }
        if ($this->isColumnModified(BasemapPeer::TOPOJSON)) {
            $modifiedColumns[':p' . $index++]  = '`topojson`';
        }
        if ($this->isColumnModified(BasemapPeer::IS_PUBLIC)) {
            $modifiedColumns[':p' . $index++]  = '`is_public`';
        }

        $sql = sprintf(
            'INSERT INTO `basemap` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`key`':
                        $stmt->bindValue($identifier, $this->key, PDO::PARAM_STR);
                        break;
                    case '`region_id`':
                        $stmt->bindValue($identifier, $this->region_id, PDO::PARAM_STR);
                        break;
                    case '`version`':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case '`last_version`':
                        $stmt->bindValue($identifier, $this->last_version, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`version_title`':
                        $stmt->bindValue($identifier, $this->version_title, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`regions`':
                        $stmt->bindValue($identifier, $this->regions, PDO::PARAM_STR);
                        break;
                    case '`borders`':
                        $stmt->bindValue($identifier, $this->borders, PDO::PARAM_STR);
                        break;
                    case '`keys`':
                        $stmt->bindValue($identifier, $this->keys, PDO::PARAM_STR);
                        break;
                    case '`raw_data`':
                        $stmt->bindValue($identifier, $this->raw_data, PDO::PARAM_STR);
                        break;
                    case '`mapshaper_parameters`':
                        $stmt->bindValue($identifier, $this->mapshaper_parameters, PDO::PARAM_STR);
                        break;
                    case '`topojson`':
                        $stmt->bindValue($identifier, $this->topojson, PDO::PARAM_STR);
                        break;
                    case '`is_public`':
                        $stmt->bindValue($identifier, (int) $this->is_public, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aRegion !== null) {
                if (!$this->aRegion->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aRegion->getValidationFailures());
                }
            }


            if (($retval = BasemapPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BasemapPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getKey();
                break;
            case 2:
                return $this->getRegionId();
                break;
            case 3:
                return $this->getVersion();
                break;
            case 4:
                return $this->getLastVersion();
                break;
            case 5:
                return $this->getTitle();
                break;
            case 6:
                return $this->getVersionTitle();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
                return $this->getRegions();
                break;
            case 9:
                return $this->getBorders();
                break;
            case 10:
                return $this->getKeys();
                break;
            case 11:
                return $this->getRawData();
                break;
            case 12:
                return $this->getMapshaperParameters();
                break;
            case 13:
                return $this->getTopojson();
                break;
            case 14:
                return $this->getIsPublic();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Basemap'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Basemap'][serialize($this->getPrimaryKey())] = true;
        $keys = BasemapPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getKey(),
            $keys[2] => $this->getRegionId(),
            $keys[3] => $this->getVersion(),
            $keys[4] => $this->getLastVersion(),
            $keys[5] => $this->getTitle(),
            $keys[6] => $this->getVersionTitle(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getRegions(),
            $keys[9] => $this->getBorders(),
            $keys[10] => $this->getKeys(),
            $keys[11] => $this->getRawData(),
            $keys[12] => $this->getMapshaperParameters(),
            $keys[13] => $this->getTopojson(),
            $keys[14] => $this->getIsPublic(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aRegion) {
                $result['Region'] = $this->aRegion->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BasemapPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setKey($value);
                break;
            case 2:
                $this->setRegionId($value);
                break;
            case 3:
                $this->setVersion($value);
                break;
            case 4:
                $this->setLastVersion($value);
                break;
            case 5:
                $this->setTitle($value);
                break;
            case 6:
                $this->setVersionTitle($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
                $this->setRegions($value);
                break;
            case 9:
                $this->setBorders($value);
                break;
            case 10:
                $this->setKeys($value);
                break;
            case 11:
                $this->setRawData($value);
                break;
            case 12:
                $this->setMapshaperParameters($value);
                break;
            case 13:
                $this->setTopojson($value);
                break;
            case 14:
                $this->setIsPublic($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = BasemapPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setKey($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setRegionId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVersion($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setLastVersion($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setVersionTitle($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setRegions($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBorders($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setKeys($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setRawData($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setMapshaperParameters($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setTopojson($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setIsPublic($arr[$keys[14]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BasemapPeer::DATABASE_NAME);

        if ($this->isColumnModified(BasemapPeer::ID)) $criteria->add(BasemapPeer::ID, $this->id);
        if ($this->isColumnModified(BasemapPeer::KEY)) $criteria->add(BasemapPeer::KEY, $this->key);
        if ($this->isColumnModified(BasemapPeer::REGION_ID)) $criteria->add(BasemapPeer::REGION_ID, $this->region_id);
        if ($this->isColumnModified(BasemapPeer::VERSION)) $criteria->add(BasemapPeer::VERSION, $this->version);
        if ($this->isColumnModified(BasemapPeer::LAST_VERSION)) $criteria->add(BasemapPeer::LAST_VERSION, $this->last_version);
        if ($this->isColumnModified(BasemapPeer::TITLE)) $criteria->add(BasemapPeer::TITLE, $this->title);
        if ($this->isColumnModified(BasemapPeer::VERSION_TITLE)) $criteria->add(BasemapPeer::VERSION_TITLE, $this->version_title);
        if ($this->isColumnModified(BasemapPeer::CREATED_AT)) $criteria->add(BasemapPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(BasemapPeer::REGIONS)) $criteria->add(BasemapPeer::REGIONS, $this->regions);
        if ($this->isColumnModified(BasemapPeer::BORDERS)) $criteria->add(BasemapPeer::BORDERS, $this->borders);
        if ($this->isColumnModified(BasemapPeer::KEYS)) $criteria->add(BasemapPeer::KEYS, $this->keys);
        if ($this->isColumnModified(BasemapPeer::RAW_DATA)) $criteria->add(BasemapPeer::RAW_DATA, $this->raw_data);
        if ($this->isColumnModified(BasemapPeer::MAPSHAPER_PARAMETERS)) $criteria->add(BasemapPeer::MAPSHAPER_PARAMETERS, $this->mapshaper_parameters);
        if ($this->isColumnModified(BasemapPeer::TOPOJSON)) $criteria->add(BasemapPeer::TOPOJSON, $this->topojson);
        if ($this->isColumnModified(BasemapPeer::IS_PUBLIC)) $criteria->add(BasemapPeer::IS_PUBLIC, $this->is_public);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(BasemapPeer::DATABASE_NAME);
        $criteria->add(BasemapPeer::ID, $this->id);
        $criteria->add(BasemapPeer::KEY, $this->key);
        $criteria->add(BasemapPeer::VERSION_TITLE, $this->version_title);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getKey();
        $pks[2] = $this->getVersionTitle();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setKey($keys[1]);
        $this->setVersionTitle($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getKey()) && (null === $this->getVersionTitle());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Basemap (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setKey($this->getKey());
        $copyObj->setRegionId($this->getRegionId());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setLastVersion($this->getLastVersion());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setVersionTitle($this->getVersionTitle());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setRegions($this->getRegions());
        $copyObj->setBorders($this->getBorders());
        $copyObj->setKeys($this->getKeys());
        $copyObj->setRawData($this->getRawData());
        $copyObj->setMapshaperParameters($this->getMapshaperParameters());
        $copyObj->setTopojson($this->getTopojson());
        $copyObj->setIsPublic($this->getIsPublic());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Basemap Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return BasemapPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BasemapPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Region object.
     *
     * @param             Region $v
     * @return Basemap The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRegion(Region $v = null)
    {
        if ($v === null) {
            $this->setRegionId(NULL);
        } else {
            $this->setRegionId($v->getId());
        }

        $this->aRegion = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Region object, it will not be re-added.
        if ($v !== null) {
            $v->addBasemap($this);
        }


        return $this;
    }


    /**
     * Get the associated Region object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Region The associated Region object.
     * @throws PropelException
     */
    public function getRegion(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aRegion === null && (($this->region_id !== "" && $this->region_id !== null)) && $doQuery) {
            $this->aRegion = RegionQuery::create()->findPk($this->region_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRegion->addBasemaps($this);
             */
        }

        return $this->aRegion;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->key = null;
        $this->region_id = null;
        $this->version = null;
        $this->last_version = null;
        $this->title = null;
        $this->version_title = null;
        $this->created_at = null;
        $this->regions = null;
        $this->borders = null;
        $this->keys = null;
        $this->raw_data = null;
        $this->mapshaper_parameters = null;
        $this->topojson = null;
        $this->is_public = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->aRegion instanceof Persistent) {
              $this->aRegion->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aRegion = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BasemapPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
