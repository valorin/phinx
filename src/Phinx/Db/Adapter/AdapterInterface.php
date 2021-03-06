<?php
/**
 * Phinx
 *
 * (The MIT license)
 * Copyright (c) 2012 Rob Morgan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated * documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 * 
 * @package    Phinx
 * @subpackage Phinx\Db\Adapter
 */
namespace Phinx\Db\Adapter;

use Phinx\Db\Table,
    Phinx\Db\Table\Column,
    Phinx\Db\Table\Index,
    Phinx\Db\Table\ForeignKey,
    Phinx\Migration\MigrationInterface;

/**
 * Adapter interface
 *
 * @author      Rob Morgan <robbym@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Get all migrated version numbers.
     *
     * @return array
     */
    public function getVersions();
    
    /**
     * Records a migration being run.
     *
     * @param MigrationInterface $migration Migration
     * @param string $direction Direction
     * @param int $startTime Start Time
     * @param int $endTime End Time
     * @return AdapterInterface
     */
    public function migrated(MigrationInterface $migration, $direction, $startTime, $endTime);

    /**
     * Does the schema table exist?
     *
     * @return boolean
     */
    public function hasSchemaTable();

    /**
     * Creates the schema table.
     *
     * @return void
     */
    public function createSchemaTable();
    
    /**
     * Returns the adapter type.
     *
     * @return string
     */
    public function getAdapterType();
    
    /**
     * Initializes the database connection.
     *
     * @throws \RuntimeException When the requested database driver is not installed.
     * @return void
     */
    public function connect();
    
    /**
     * Closes the database connection.
     *
     * @return void
     */
    public function disconnect();
    
    /**
     * Does the adapter support transactions?
     *
     * @return boolean
     */
    public function hasTransactions();
    
    /**
     * Begin a transaction.
     *
     * @return void
     */
    public function beginTransaction();
    
    /**
     * Commit a transaction.
     *
     * @return void
     */
    public function commitTransaction();
    
    /**
     * Rollback a transaction.
     *
     * @return void
     */
    public function rollbackTransaction();
    
    /**
     * Executes a SQL statement and returns the number of affected rows.
     * 
     * @param string $sql SQL
     * @return int
     */
    public function execute($sql);
    
    /**
     * Executes a SQL statement and returns the result as an array. 
     *
     * @param string $sql SQL
     * @return array
     */
    public function query($sql);
    
    /**
     * Executes a query and returns only one row as an array.
     *
     * @param string $sql SQL
     * @return array
     */
    public function fetchRow($sql);
    
    /**
     * Executes a query and returns an array of rows.
     *
     * @param string $sql SQL
     * @return array
     */
    public function fetchAll($sql);
    
    /**
     * Quotes a table name for use in a query.
     * 
     * @param string $tableName Table Name
     * @return string
     */
    public function quoteTableName($tableName);
    
    /**
     * Quotes a column name for use in a query.
     * 
     * @param string $columnName Table Name
     * @return string
     */
    public function quoteColumnName($columnName);
    
    /**
     * Checks to see if a table exists.
     *
     * @param string $tableName Table Name
     * @return boolean
     */
    public function hasTable($tableName);
    
    /**
     * Creates the specified database table.
     *
     * @param Table $table Table
     * @return void
     */
    public function createTable(Table $table);
    
    /**
     * Renames the specified database table.
     *
     * @param string $tableName Table Name
     * @param string $newName   New Name
     * @return void
     */
    public function renameTable($tableName, $newName);
    
    /**
     * Drops the specified database table.
     * 
     * @param string $tableName Table Name
     * @return void
     */
    public function dropTable($tableName);

    /**
     * Returns table columns
     *
     * @param string $tableName Table Name
     * @return Column[]
     */
    public function getColumns($tableName);
    
    /**
     * Checks to see if a column exists.
     *
     * @param string $tableName  Table Name
     * @param string $columnName Column Name
     * @param array  $options    Options
     * @return boolean
     */
    public function hasColumn($tableName, $columnName, $options = array());
    
    /**
     * Adds the specified column to a database table.
     * 
     * @param Table  $table  Table
     * @param Column $column Column
     * @return void
     */
    public function addColumn(Table $table, Column $column);
    
    /**
     * Renames the specified column.
     *
     * @param string $tableName Table Name
     * @param string $columnName Column Name
     * @param string $newColumnName New Column Name
     * @return void
     */
    public function renameColumn($tableName, $columnName, $newColumnName);
    
    /**
     * Change a table column type.
     *
     * @param string $tableName  Table Name
     * @param string $columnName Column Name
     * @param Column $newColumn  New Column
     * @return Table
     */
    public function changeColumn($tableName, $columnName, Column $newColumn);
    
    /**
     * Drops the specified column.
     *
     * @param string $tableName Table Name
     * @param string $columnName Column Name
     * @return void
     */
    public function dropColumn($tableName, $columnName);
    
    /**
     * Checks to see if an index exists.
     *
     * @param string $tableName Table Name
     * @param mixed  $columns   Column(s)
     * @return boolean
     */
    public function hasIndex($tableName, $columns);
    
    /**
     * Adds the specified index to a database table.
     * 
     * @param Table $table Table
     * @param Index $index Index
     * @return void
     */
    public function addIndex(Table $table, Index $index);
    
    /**
     * Drops the specified index from a database table.
     * 
     * @param string $tableName
     * @param mixed  $columns Column(s)
     * @param array  $options
     * @return void
     */
    public function dropIndex($tableName, $columns, $options = array());

    /**
     * Checks to see if a foreign key exists.
     *
     * @param string   $tableName
     * @param string[] $columns    Column(s)
     * @param string   $constraint Constraint name
     * @return boolean
     */
    public function hasForeignKey($tableName, $columns, $constraint = null);

    /**
     * Adds the specified foreign key to a database table.
     *
     * @param Table      $table
     * @param ForeignKey $foreignKey
     * @return void
     */
    public function addForeignKey(Table $table, ForeignKey $foreignKey);

    /**
     * Drops the specified foreign key from a database table.
     *
     * @param string   $tableName
     * @param string[] $columns    Column(s)
     * @param string   $constraint Constraint name
     * @return void
     */
    public function dropForeignKey($tableName, $columns, $constraint = null);

    /**
     * Returns an array of the supported Phinx column types.
     * 
     * @return array
     */
    public function getColumnTypes();
    
    /**
     * Converts the Phinx logical type to the adapter's SQL type.
     * 
     * @param string $type Type
     * @return string
     */
    public function getSqlType($type);
    
    /**
     * Creates a new database.
     *
     * @param string $name Database Name
     * @param array $options Options
     * @return void
     */
    public function createDatabase($name, $options = array());
    
    /**
     * Checks to see if a database exists.
     *
     * @param string $name Database Name
     * @return boolean
     */
    public function hasDatabase($name);
    
    /**
     * Drops the specified database.
     *
     * @param string $name Database Name
     * @return void
     */
    public function dropDatabase($name);
}