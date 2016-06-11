<?php

namespace TCK\Odbc\Connections;

use Illuminate\Database\Connection;
use TCK\Odbc\Grammars\Query\MsAccessQueryGrammar;
use TCK\Odbc\Grammars\Schema\MsAccessSchemaGramar;

class MsAccessConnection extends Connection {

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
