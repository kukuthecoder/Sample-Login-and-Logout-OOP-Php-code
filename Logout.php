<?php

class Logout extends main{
    var $Logout_model;   //instance of the Logout Model

    public function Logout($params){
        parent::__constructor();
        if(file_exists('php/models/Logout.php'))
            require 'php/models/Logout.php';
        else
            require '../models/Logout.php';
        $this->Logout_model = new Logout_Model();
    }

    public function LogoutUser($username){
        if($this->Logout_model->LogoutUser($username)){
            $_SESSION['user-id'] = $this->Logout_model->getUserID();
            return true;
        }else{
            return false;
        }
    }

    //default view passed
    public function view(){
        if($_SESSION['user-id']){
            $this->LogoutUser($_SESSION['user-id']);
            session_destroy();
            include 'php/views/Logout.php';
        }
    }



}