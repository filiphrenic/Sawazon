<?php

namespace DB;

use Sawazon\Model;

abstract class DBModel extends Model
{

    /** @var  string */
    private $tableName;

    /** @var  string */
    private $primaryKeyColumn;

    /** @var mixed Table row */
    private $model;

    public function __construct()
    {
        $classname = get_class($this);
        if ($pos = strrpos($classname, '\\'))
            $classname = substr($classname, $pos + 1);

        $this->tableName = $classname;
        $this->primaryKeyColumn = strtolower($classname) . '_id';
    }

    /**
     * @return array
     */
    public abstract function getColumnNames();

    /**
     * Default implementation
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Default implementation
     * @return string
     */
    public function getPrimaryKeyColumn()
    {
        return $this->primaryKeyColumn;
    }

    public function load($primary_key)
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE " .
            $this->getPrimaryKeyColumn() . " = ?";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$primary_key]);

        if (1 !== $statement->rowCount()) {
            return null;
        }

        $this->model = $statement->fetch();
        $this->primary_key = $primary_key;
        return $this;
    }

    public function loadAll($where = "")
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " " . $where;

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute();

        if (1 > $statement->rowCount()) {
            return [];
        }

        $resources = $statement->fetchAll();
        $collection = [];

        $className = get_class($this);
        foreach ($resources as $singleRow) {
            $model = new $className();
            $model->primary_key = $singleRow->{$this->getPrimaryKeyColumn()};
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
            "DELETE FROM " . $this->getTableName() . " WHERE " .
            $this->getPrimaryKeyColumn() . " = ?"
        )->execute([$this->primary_key]);
        $this->primary_key = null;
    }

    public function save()
    {
        $columns = $this->getColumnNames();

        if (null === $this->primary_key) {

            $values = array();
            $placeHolders = array();

            foreach ($columns as $column) {
                $values[] = $this->model->$column;
                $placeHolders[] = "?";
            }

            $sql = "INSERT INTO " . $this->getTableName() . " (" . implode(", ", $columns)
                . ") VALUES (" . implode(", ", $placeHolders) . ")";

            DB::getPDO()->prepare($sql)->execute($values);
            $this->primary_key = DB::getPDO()->lastInsertId();

        } else {

            $values = array();
            $placeHolders = array();

            foreach ($columns as $column) {
                $values[] = $this->model->$column;
                $placeHolders[] = $column . " = ?";
            }

            $values[] = $this->primary_key;

            $sql = "UPDATE " . $this->getTableName() . " SET " . implode(", ", $placeHolders)
                . " WHERE " . $this->getPrimaryKeyColumn() . " = ?";

            DB::getPDO()->prepare($sql)->execute($values);
        }
    }

    public function serialize()
    {
        return serialize($this->model);
    }

    public function unserialize($serialized)
    {
        $this->model = unserialize($serialized);
    }

    public function __get($name)
    {
        return $this->model->$name;
    }

    public function __set($name, $value)
    {
        $this->model->$name = $value;
    }


}