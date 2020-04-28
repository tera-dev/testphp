<?php

include_once _CORE_.'Controller.php';
include_once _MODELS_DIR_.'Territory.php';
include_once _MODELS_DIR_.'User.php';


class UserController extends Controller{
    
    public function actionIndex(){
        $territoryItems = Territory::getTerritories();
        $this->renderView('index', compact('territoryItems'));
    }
    
    public function actionCreate(){
        if (isset($_POST)) {
            if (isset($_POST['user'])) {
                $user;
                $userData = $_POST['user'];

                $territoryId = explode('-', end($userData));
                if(!User::isAlreadyRegistered($userData['email'])) {
                    $user = new User($userData['name'], $userData['email'], $territoryId[0]);
                    $user->save();
                    $this->redirect('index');
                }
                else {
                    $userData = User::findUser($userData['email']);
                    $this->renderView('view', compact('userData'));
                }
            }
        }
    }
    
    public function actionGetTerritories(){
        if (isset($_GET)) {
            if (isset($_GET['ter_pid'])) {
                echo json_encode(Territory::getTerritories($_GET['ter_pid']));
            }
        }
    }
    
    public static function actionGetCitiesWithSprecialStatus() {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
        $result = $pdo->query("SELECT ter_id FROM `t_koatuu_tree` WHERE ter_pid IS NULL && ter_name LIKE 'м.%';");
        $citiesIDs = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetchObject()){
                $citiesIDs[] = $row->ter_id;
            }
        }
        echo json_encode($citiesIDs);
    }
 
}

