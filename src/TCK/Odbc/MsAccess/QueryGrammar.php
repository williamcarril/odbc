<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Query\Grammars\SqlServerGrammar;
use Illuminate\Database\Query\Builder;

class QueryGrammar extends SqlServerGrammar {

    /**
     * Compile a basic where clause.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $where
     * @return string
     */
    protected function whereBasic(Builder $query, $where) {
        $value = $this->parameter($where['value']);


        return $this->wrap($where['column']) . ' ' . $where['operator'] . ' ' . $this->wrapValue($value);
    }

    protected function wrapValue($value) {
        if (is_numeric($value)) {
            return $this->wrapNumeric($value);
        }

        if ($value instanceof DateTime) {
            return $this->wrapDate($value);
        }

        if (is_string($value)) {
            return $this->wrapText($value);
        }
    }

    protected function wrapNumeric($value) {
        return $value;
    }

    protected function wrapDate(DateTime $value) {
        return $value->format("Y-m-d H:i:s");
    }

    protected function wrapText($value) {
        return "'" . str_replace("'", "''", $value) . "'";
    }

}
