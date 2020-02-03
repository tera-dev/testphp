<?php


class Territory{

    public $name;
    public $id;
    public $terr_type;
    
    public function __construct($name, $id, $terr_type) {
        $this->name = $name;
        $this->id = $id;
        $this->terr_type = $terr_type;
    }
//    
//    public function getName(){
//        return $this->name;
//    }
//    public function getId(){
//        return $this->id;
//    }
//    public function setName($inName){
//        $this->name = $inName;
//    }
//    public function setId($inId){
//        $this->id = $inId;
//    }
//    
    public static function getTerritories($ter_pid = 'NULL', $ter_type_id = '0'){
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
        if ($ter_pid === 'NULL') {
            $result = $pdo->query("SELECT ter_name, ter_id, ter_type_id from"
                . " t_koatuu_tree WHERE ter_pid IS NULL AND ter_type_id = '{$ter_type_id}'");
        }
        else{
//            $ter_types_arr = explode(',', $ter_type_id);
            $ter_types_arr = trim($ter_type_id);
            $result = $pdo->query("SELECT ter_name, ter_id, ter_type_id from"
                . " t_koatuu_tree WHERE ter_type_id IN ({$ter_types_arr})"
                . " AND ter_pid = '{$ter_pid}'");
        }
                
        $territoryItems = [];

        if ($result->rowCount() > 0) {
            while ($row = $result->fetchObject()){
//                print_r($row);
                $item = new Territory($row->ter_name, $row->ter_id, $row->ter_type_id);
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

