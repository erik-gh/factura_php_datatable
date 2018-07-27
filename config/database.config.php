<?php

class Database {

    private $_host;
    private $_user;
    private $_password;
    private $_db_name;
    private $_charset;

    function __construct() {
        $this->_host = 'localhost:4040';
        $this->_user = 'root';
        $this->_password = '';
        $this->_db_name = 'db_factura';
        $this->_charset = 'utf8';
    }

    function getConnecion() {
        $_connection = null;
        if ($_connection == null) {
            $dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_db_name . ';charset=' . $this->_charset;
            $_connection = new PDO($dsn, $this->_user, $this->_password);
            $_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return $_connection;
    }

    public function __clone() {
        
    }

}
