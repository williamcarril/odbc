<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Query\Grammars\SqlServerGrammar;
use Illuminate\Database\Query\Builder;

class QueryGrammar extends SqlServerGrammar {

    /**
     * Get the appropriate query parameter place-holder for a value.
     *
     * @param  mixed   $value
     * @return string
     */
    public function parameter($value) {
        return $this->isExpression($value) ? $this->getValue($value) : $this->preparePlainValue($value);
    }

    protected function preparePlainValue($value) {
        if (is_numeric($value)) {
            return $this->prepareNumeric($value);
        }

        if ($value instanceof DateTime) {
            return $this->prepareDate($value);
        }

        if (is_string($value)) {
            return $this->prepareText($value);
        }
    }

    protected function prepareNumeric($value) {
        return $value;
    }

    protected function prepareDate(DateTime $value) {
        return $value->format("Y-m-d H:i:s");
    }

    protected function prepareText($value) {
        return "'" . str_replace("'", "''", $value) . "'";
    }

}
