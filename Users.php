<?php

class Users extends main{
    var $users_model;   //instance of the Users Model

    public function Users($params){
        parent::__constructor();
        require 'php/models/Users.php';
        $this->users_model = new Users_Model();
    }

    public function getAllUsers(){
        return $this->users_model->getAllUsers();
    }

    public function view(){
        $page_data = $this->page_data;
        $page_data['users'] = $this->getAllUsers();
        require 'php/views/Users.php';
    }



}