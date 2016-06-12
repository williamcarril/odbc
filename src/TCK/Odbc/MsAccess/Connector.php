<?php

namespace TCK\Odbc\MsAccess;

use Illuminate\Database\Connectors\Connector as IlluminateConnector;
use Illuminate\Database\Connectors\ConnectorInterface;

class Connector extends IlluminateConnector implements ConnectorInterface {

    public function connect(array $config) {
        $options = $this->getOptions($config);

        $dsn = $this->getDsn($config);
        $conn = $this->createConnection($dsn, $config, $options);

        return $conn;
    }

    protected function getDsn(array $config) {
        $dsn = $this->parseDsn(array_get($config, 'dsn'));
        if (is_null($dsn)) {
            throw new \Exception("Invalid DSN");
        }

        extract($config, EXTR_SKIP);

        if (!isset($dsn["attributes"]["dbq"]) && !empty($database)) {
            $dsn["attributes"]["dbq"] = array_get($config, "database");
        }

        if (!isset($dsn["attributes"]["uid"]) && !empty($username)) {
            $dsn["attributes"]["uid"] = array_get($config, "username", "");
        }

        if (!isset($dsn["attributes"]["pwd"]) && !empty($password)) {
            $dsn["attributes"]["pwd"] = array_get($config, "password", "");
        }

        return "{$dsn["type"]}:" . implode(";", array_map(function($v, $k) {
                            return "$k=$v";
                        }, $dsn["attributes"], array_keys($dsn["attributes"])));
    }

    private function parseDsn($dsn) {
        $parsed = [];
        try {
            $explodedDsn = explode(":", $dsn);
            $type = $explodedDsn[0];
            $parsed["type"] = $type;
            $parsed["attributes"] = [];
            $attributes = $explodedDsn[1];
            foreach (explode(";", $attributes) as $attr) {
                if (empty($attr)) {
                    continue;
                }
                $keyValue = explode("=", $attr);
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);
                $parsed["attributes"][$key] = $value;
            }
            return $parsed;
        } catch (\Exception $ex) {
            return null;
        }
    }

}
