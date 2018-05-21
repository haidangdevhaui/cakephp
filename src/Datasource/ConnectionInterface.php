<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.1.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Datasource;

use Cake\Database\Schema\Collection;

/**
 * This interface defines the methods you can depend on in
 * a connection.
 */
interface ConnectionInterface
{
    /**
     * Get the configuration name for this connection.
     *
     * @return string
     */
    public function configName();

    /**
     * Get the configuration data used to create the connection.
     *
     * @return array
     */
    public function config();

    /**
     * Executes a callable function inside a transaction, if any exception occurs
     * while executing the passed callable, the transaction will be rolled back
     * If the result of the callable function is `false`, the transaction will
     * also be rolled back. Otherwise the transaction is committed after executing
     * the callback.
     *
     * The callback will receive the connection instance as its first argument.
     *
     * @param callable $transaction The callback to execute within a transaction.
     * @return mixed The return value of the callback.
     * @throws \Exception Will re-throw any exception raised in $callback after
     *   rolling back the transaction.
     */
    public function transactional(callable $transaction);

    /**
     * Run an operation with constraints disabled.
     *
     * Constraints should be re-enabled after the callback succeeds/fails.
     *
     * @param callable $operation The callback to execute within a transaction.
     * @return mixed The return value of the callback.
     * @throws \Exception Will re-throw any exception raised in $callback after
     *   rolling back the transaction.
     */
    public function disableConstraints(callable $operation);

    /**
     * Enables or disables query logging for this connection.
     *
     * @param bool|null $enable whether to turn logging on or disable it.
     *   Use null to read current value.
     * @return bool
     */
    public function logQueries($enable = null);

    /**
     * Sets a logger
     *
     * @param \Cake\Database\Log\QueryLogger $logger Logger object
     * @return $this
     */
    public function setLogger($logger);

    /**
     * Gets the logger object
     *
     * @return \Cake\Database\Log\QueryLogger logger instance
     */
    public function getLogger();

    /**
     * Returns whether the driver supports adding or dropping constraints
     * to already created tables.
     *
     * @return bool True if driver supports dynamic constraints.
     */
    public function supportsDynamicConstraints();

    /**
     * Gets a Schema\Collection object for this connection.
     *
     * @return \Cake\Database\Schema\Collection
     */
    public function getSchemaCollection();

    /**
     * Sets a Schema\Collection object for this connection.
     *
     * @param \Cake\Database\Schema\Collection $collection The schema collection object
     * @return $this
     */
    public function setSchemaCollection(Collection $collection);

    /**
     * Create a new Query instance for this connection.
     *
     * @return \Cake\Database\Query
     */
    public function newQuery();

    /**
     * Prepares a SQL statement to be executed.
     *
     * @param string|\Cake\Database\Query $sql The SQL to convert into a prepared statement.
     * @return \Cake\Database\StatementInterface
     */
    public function prepare($sql);

    /**
     * Executes a query using $params for interpolating values and $types as a hint for each
     * those params.
     *
     * @param string $query SQL to be executed and interpolated with $params
     * @param array $params list or associative array of params to be interpolated in $query as values
     * @param array $types list or associative array of types to be used for casting values in query
     * @return \Cake\Database\StatementInterface executed statement
     */
    public function execute($query, array $params = [], array $types = []);
}
