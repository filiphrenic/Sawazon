<?php

namespace DB;

use Sawazon\Model;

abstract class DBModel extends Model
{

    /** @var  string */
    private $tableName;

    /** @var  string */
    private $primaryKeyColumn;

    /** @var array Table row */
    private $model;

    /**
     * @return array
     */
    public abstract function getColumnNames();

    /**
     * DBModel constructor.
     * @param array $properties key => value array to set properties
     */
    public function __construct($properties = [])
    {
        $class_name = short_name($this);
        $this->tableName = $class_name;
        $this->primaryKeyColumn = strtolower($class_name) . '_id';

        foreach ($properties as $property => $value)
            $this->$property = $value;
    }

    /**
     * @param string $property checks if an object with given property set to value exists
     * @param string $value value
     * @return bool if exists
     */
    public static function exists($property, $value)
    {
        $class = get_called_class();
        /** @var DBModel $obj */
        $obj = new $class();
        $objects = $obj->loadAll("WHERE $property = ? LIMIT 1", [$value]);
        return !empty($objects);
    }

    public function load($primary_key)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE " .
            $this->primaryKeyColumn . " = ?";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$primary_key]);

        if (1 !== $statement->rowCount()) {
            return null;
        }

        $this->model = $statement->fetch();
        $this->primary_key = $primary_key;
        return $this;
    }

    public function loadAll($where = "", $params = [])
    {
        $sql = "SELECT * FROM " . $this->tableName . " " . $where;

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute($params);

        if (1 > $statement->rowCount()) {
            return [];
        }

        $resources = $statement->fetchAll();
        $collection = [];

        $className = get_class($this);
        foreach ($resources as $singleRow) {
            $model = new $className();
            $model->primary_key = $singleRow[$this->primaryKeyColumn];
            $model->model = $singleRow;

            $collection[] = $model;
        }

        return $collection;
    }

    public function delete()
    {
        if (null === $this->primary_key) {
            return;
        }
        DB::getPDO()->prepare(
            "DELETE FROM " . $this->tableName . " WHERE " .
            $this->primaryKeyColumn . " = ?"
        )->execute([$this->primary_key]);
        $this->primary_key = null;
    }

    public function save()
    {
        $columns = $this->getColumnNames();

        if (null === $this->primary_key) { // insert

            $values = array();
            $placeHolders = array();

            $insert_columns = [];
            foreach ($columns as $column) {
                $val = $this->model[$column];
                if ($val == null) continue;
                $insert_columns[] = $column;
                $values[] = $val;
                $placeHolders[] = "?";
            }

            if (empty($insert_columns)) return; // nothing to insert

            $sql = "INSERT INTO " . $this->tableName . " (" . implode(", ", $insert_columns)
                . ") VALUES (" . implode(", ", $placeHolders) . ")";

            DB::getPDO()->prepare($sql)->execute($values);
            $this->primary_key = DB::getPDO()->lastInsertId();
            $this->model[$this->primaryKeyColumn] = $this->primary_key;

        } else { // update

            $values = array();
            $placeHolders = array();

            foreach ($columns as $column) {
                $val = $this->model[$column];
                if ($val == null) continue;
                $values[] = $val;
                $placeHolders[] = $column . " = ?";
            }

            if (empty($values)) return; // nothing to save

            $values[] = $this->primary_key;

            $sql = "UPDATE " . $this->tableName . " SET " . implode(", ", $placeHolders)
                . " WHERE " . $this->primaryKeyColumn . " = ?";

            DB::getPDO()->prepare($sql)->execute($values);
        }
        
        $this->afterSave();
    }


    protected function afterSave()
    {
        // called after save, override this if needed
    }

    public function serialize()
    {
        return serialize($this->model);
    }

    public function unserialize($serialized)
    {
        $this->model = unserialize($serialized);
    }

    /**
     * This function will try to return the following:
     *      model_id  => id
     *      model     => load the model object (using the model_id)
     *      model_all => load a collection of model objects that have this_class_id property
     *
     * At first, model only has id's cached.
     * When get is called with something else, it is cached in the model for next time it is needed.
     *
     * @param string $name see explanation above
     * @return string | Model | array | null
     */
    public function __get($name)
    {

        // is already stored?
        $ret = element($name, $this->model, null);
        if (null != $ret) return $ret;

        // load object?
        $ret = element($name . '_id', $this->model, null);
        if (null != $ret) {
            $class = "\\Model\\" . ucfirst($name);
            if (!class_exists($class)) return null;
            return $this->model[$name] = (new $class)->load($ret);
        }

        // load collection?
        if ($pos = strpos($name, '_all')) {
            $class_name = substr($name, 0, $pos);
            $class = "\\Model\\" . ucfirst($class_name);
            if (!class_exists($class)) return null;
            $id = short_name($this) . "_id";
            return $this->model[$name] = (new $class)->loadAll("WHERE $id = ?", [$this->primary_key]);
        }

        return null;
    }

    public function __set($name, $value)
    {
        return $this->model[$name] = $value;
    }


}