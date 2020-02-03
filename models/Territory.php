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
 
    public static function getTerritories($ter_pid = 'NULL'){
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
        if ($ter_pid === 'NULL') {
            $result = $pdo->query("SELECT ter_name, ter_id, ter_type_id from"
                . " t_koatuu_tree WHERE ter_pid IS NULL");
        }
        else{
            $result = $pdo->query("SELECT ter_name, ter_id, ter_type_id from"
                . " t_koatuu_tree WHERE ter_pid = '{$ter_pid}'");
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
