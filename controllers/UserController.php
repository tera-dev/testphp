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
                
                if(!User::isAlreadyRegistered($userData['email'])) {
                    if (isset($userData['city'])) {
                        //если в городе есть районы
                        $user = new User($userData['name'], $userData['email'], $userData['district']);
                    }
                    else{
                        //если в городе нету районов
                        $user = new User($userData['name'], $userData['email'], $userData['city']);
                    }
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
                if (isset($_GET['ter_type_id'])) {
                    echo json_encode(Territory::getTerritories($_GET['ter_pid'], $_GET['ter_type_id']));
                }
                
            }
        }
    }
}

