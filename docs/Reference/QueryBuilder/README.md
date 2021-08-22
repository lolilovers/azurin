# Introduction

This Builder is based on latitude/latitude, SQL query builder with zero dependencies and a fluent interface.

```php

$factory = $this->builder();

$query = $factory
    ->select('id', 'username')
    ->from('users')
    ->where(field('id')->eq(5))
    ->compile();

$query->sql(); // SELECT "id" FROM "users" WHERE "id" = ?
$query->params(); // [5]
```

# [](#documentation)Documentation

Latitude includes both a query builder and a powerful set of escaping helpers.
The query builder allows the fluent generation of `SELECT`, `INSERT`, `UPDATE`,
and `DELETE` statements. The escaping helpers assist in protecting against SQL
injection and identifier quoting for MySQL, SQL Server, Postgres, and other
databases that follow SQL standards.

Getting Started

- [Quick Reference](cheatsheet.md)

Query Types

- [SELECT](query-select.md)
- [INSERT](query-insert.md)
- [UPDATE](query-update.md)
- [DELETE](query-delete.md)
