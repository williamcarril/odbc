<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Connection;
use TCK\Odbc\MsAccess\MsAccessQueryGrammar;
use TCK\Odbc\MsAccess\MsAccessSchemaGramar;

class Connection extends Connection {

    /**
     * Get the default query grammar instance.
     *
     * @return Illuminate\Database\Query\Grammars\Grammars\Grammar
     */
    protected function getDefaultQueryGrammar() {
        return $this->withTablePrefix(new MsAccessQueryGrammar());
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return Illuminate\Database\Schema\Grammars\Grammar
     */
    protected function getDefaultSchemaGrammar() {
        return $this->withTablePrefix(new MsAccessSchemaGramar());
    }

}
