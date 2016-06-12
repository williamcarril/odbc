<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Query\Processors\SqlServerProcessor;
use Illuminate\Database\Query\Builder; 

class Processor extends SqlServerProcessor {

    /**
     * Process an "insert get ID" query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $sql
     * @param  array   $values
     * @param  string  $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null) {
        $connection = $query->getConnection();

        $connection->insert($sql, $values);

        $id = $this->processInsertGetIdForOdbc($connection);

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Process an "insert get ID" query for ODBC.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @return int
     */
    protected function processInsertGetIdForOdbc($connection) {
        $result = $connection->select('SELECT @@IDENTITY AS insertid');

        if (!$result) {
            throw new Exception('Unable to retrieve lastInsertID for ODBC.');
        }

        return $result[0]->insertid;
    }

}
