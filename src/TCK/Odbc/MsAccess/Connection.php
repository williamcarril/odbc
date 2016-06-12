<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Connection as IlluminateConnection;

class Connection extends IlluminateConnection {

    /**
     * Get the default query grammar instance.
     *
     * @return Illuminate\Database\Query\Grammars\Grammars\Grammar
     */
    protected function getDefaultQueryGrammar() {
        return $this->withTablePrefix(new QueryGrammar());
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return Illuminate\Database\Schema\Grammars\Grammar
     */
    protected function getDefaultSchemaGrammar() {
        return $this->withTablePrefix(new SchemaGramar());
    }

}
