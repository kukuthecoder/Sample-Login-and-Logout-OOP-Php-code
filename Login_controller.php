<?php

class Login extends main{
    var $login_model;   //instance of the Login Model

    public function Login($params){
        parent::__constructor();
        if(file_exists('php/models/Login.php'))
            require 'php/models/Login.php';
        else
            require '../models/Login.php';
        $this->login_model = new Login_Model();
    }

    public function loginUser($username, $password){
        if($this->login_model->loginUser($username, $password)){
            session_start();
            $_SESSION['user-id'] = $this->login_model->getUserID();
            return true;
        }else{
            return false;
        }
    }

    //default view passed
    public function view(){
//        $page_data = $this->$page_data;
//        $page_data['login'] = $this->getParentChildrenLoginWithProducts();
        include 'php/views/Login.php';
    }



}
