<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connect
 *
 * @author Admin
 */
 class Connector {

    //put your code here
    private $host;
    private $user;
    private $password;
    private $database;
    private $conn;


    public function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }

    public function createConnection() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }
    public function closeConnection(){
        mysqli_close($this->conn);
    }
    public function getConn(){
        return $this->conn;
    }
    

}
