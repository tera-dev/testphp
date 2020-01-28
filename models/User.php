<?php


class User{
    
    public $id;
    public $name;
    public $email;
    public $territory;


    public function __construct($name, $email, $territory) {
        $this->name = $name;
        $this->email = $email;
        $this->territory = $territory;
    }
    

    public function save(){
        $pdo = new PDO('mysql:host=testphp;dbname=test_php_db', 'root', '');
        $pdo->exec("INSERT INTO t_users (user_name, user_email, ter_id)"
                . " VALUES ('{$this->name}', '{$this->email}', '{$this->territory}')");
    }
    
    public static function isAlreadyRegistered($email){
        $pdo = new PDO('mysql:host=testphp;dbname=test_php_db', 'root', '');
        $res = $pdo->query("SELECT user_email FROM t_users WHERE user_email = '{$email}'");
        if ($res->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
    public static function findUser($email){
        $userData = [];
        $pdo = new PDO('mysql:host=testphp;dbname=test_php_db', 'root', '');
        $res = $pdo->query("SELECT user_name, user_email, ter_address FROM t_users JOIN "
                . "t_koatuu_tree ON t_koatuu_tree.ter_id = t_users.ter_id "
                . "WHERE user_email = '{$email}'");
        if ($res->rowCount() > 0) {
            while ($row = $res->fetchObject()){
//                print_r($row);
                $userData['user_name'] = $row->user_name;
                $userData['user_email'] = $row->user_email;
                $userData['ter_address'] = $row->ter_address;
            }
        }
        
        return $userData;
    }
    
}
