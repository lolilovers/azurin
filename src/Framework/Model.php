<?php

/**
 * ===========================
 * Base Model
 * ===========================
 */

namespace Src\Framework;

use Src\Framework\Services\MySQLiDriver;
use Src\Framework\Database\QueryFactory;
use Src\Framework\Database\Engine\MySqlEngine;
use function Src\Framework\Database\field;
use function Src\Framework\Database\search;
use function Src\Framework\Database\on;
use function Src\Framework\Database\group;
use function Src\Framework\Database\express;
use function Src\Framework\Database\criteria;
use function Src\Framework\Database\literal;
use function Src\Framework\Database\alias;
use function Src\Framework\Database\func;
use function Src\Framework\Database\order;
use function Src\Framework\Database\identify;
use function Src\Framework\Database\identifyAll;
use function Src\Framework\Database\param;
use function Src\Framework\Database\paramAll;
use function Src\Framework\Database\listing;

class Model 
{
    protected $table;
    protected $primaryKey;

    // Create mysqli connection
    public function mysqli()
    {
        $mysqli = new MySQLiDriver(
            DB_HOST,
            DB_USERNAME,
            DB_PASSWORD,
            DB_NAME,
            DB_PORT
        );

        return $mysqli;
    }

    // Create query builder
    public function builder()
    {
        $factory = new QueryFactory(new MySqlEngine());

        return $factory;
    }

    // SELECT
    public function select($value = null)
    {
        // Find all
        if($value == null) {
            $query = $this->builder()
            ->select()
            ->from($this->table)
            ->compile();
            $select = $this->mysqli();
            $select->query($query->sql());
            
            return $select->result();
        }
        // Find where matching value of key
        else {
            $query = $this->builder()
            ->select()
            ->from($this->table)
            ->where(field($this->primaryKey)->eq($value))
            ->compile();
            $select = $this->mysqli();
            $select->query($query->sql(), $query->params());
            
            return $select->result();
        }
    }

    // INSERT
    public function insert($data)
    {
        $query = $this->builder()
        ->insert($this->table, $data)
        ->compile();

        return $this->mysqli()->query($query->sql(), $query->params());
    }

    // UPDATE
    public function update($data, $id)
    {
        $query = $this->builder()
        ->update($this->table, $data)
        ->where(field($this->primaryKey)->eq($id))
        ->compile();

        return $this->mysqli()->query($query->sql(), $query->params());
    }

    // DELETE
    public function delete($id)
    {
        $query  = $this->builder()
        ->delete($this->table)
        ->where(field($this->primaryKey)->eq($id))
        ->compile();
        
        return $this->mysqli()->query($query->sql(), $query->params());
    }

    // COUNT
    public function count($key)
    {
        $query  = $this->builder()
        ->select(alias(func('COUNT', $key), $key))
        ->from($this->table)
        ->compile();
        $result = $this->mysqli();
        $result->query($query->sql());

        return $result->resultAssoc();
    }

    // SUM
    public function sum($key)
    {
        $query  = $this->builder()
        ->select(alias(func('SUM', $key), $key))
        ->from($this->table)
        ->compile();
        $result = $this->mysqli();
        $result->query($query->sql());

        return $result->resultAssoc();
    }

    // AVG
    public function avg($key)
    {
        $query  = $this->builder()
        ->select(alias(func('AVG', $key), $key))
        ->from($this->table)
        ->compile();
        $result = $this->mysqli();
        $result->query($query->sql());

        return $result->resultAssoc();
    }

    // MIN
    public function min($key)
    {
        $query  = $this->builder()
        ->select(alias(func('MIN', $key), $key))
        ->from($this->table)
        ->compile();
        $result = $this->mysqli();
        $result->query($query->sql());

        return $result->resultAssoc();
    }

    // MAX
    public function max($key)
    {
        $query  = $this->builder()
        ->select(alias(func('MAX', $key), $key))
        ->from($this->table)
        ->compile();
        $result = $this->mysqli();
        $result->query($query->sql());

        return $result->resultAssoc();
    }
}