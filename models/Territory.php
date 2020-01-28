<?php


class Territory{
    
    const REGION = 0, CITY = 1, DISTRICT = 3;
    


    public $name;
    public $id;
    
    public function __construct($name, $id) {
        $this->name = $name;
        $this->id = $id;
    }
    
    public function getName(){
        return $this->name;
    }
    public function getId(){
        return $this->id;
    }
    public function setName($inName){
        $this->name = $inName;
    }
    public function setId($inId){
        $this->id = $inId;
    }
    
    public static function getTerritories($ter_pid = 'NULL', $ter_type_id = '0'){
        $pdo = new PDO('mysql:host=testphp;dbname=test_php_db', 'root', '');
        if ($ter_pid === 'NULL') {
            $result = $pdo->query("SELECT ter_name, ter_id from"
                . " t_koatuu_tree WHERE ter_pid IS {$ter_pid} AND ter_type_id = {$ter_type_id}");
        }
        else{
            $result = $pdo->query("SELECT ter_name, ter_id from"
                . " t_koatuu_tree WHERE ter_pid = {$ter_pid} AND ter_type_id = {$ter_type_id}");
        }
        
                
        $territoryItems = [];

        if ($result->rowCount() > 0) {
            while ($row = $result->fetchObject()){
//                print_r($row);
                $item = new Territory($row->ter_name, $row->ter_id);
                $territoryItems[] = $item;
            }
        }
        return $territoryItems;
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

