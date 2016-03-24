<?php

namespace DB;

use Sawazon\Model;

abstract class DBModel extends Model
{
    public abstract function getTableName();

    public abstract function getPrimaryKeyColumn();

    public abstract function getColumnNames();

    /** @var mixed Table row */
    private $model;

    public function get($primary_key)
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE " .
            $this->getPrimaryKeyColumn() . " = ?";

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute([$primary_key]);

        if (1 !== $statement->rowCount()) {
            throw new NotFoundException();
        }

        $this->model = $statement->fetch();
        $pkCol = $this->getPrimaryKeyColumn();
        $this->primary_key = $this->model->$pkCol;
    }

    public function getAll($where = "")
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " " . $where;

        $statement = DB::getPDO()->prepare($sql);
        $statement->execute();

        if (1 > $statement->rowCount()) {
            return null;
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
        return $this->model->$name = $value;
    }

}