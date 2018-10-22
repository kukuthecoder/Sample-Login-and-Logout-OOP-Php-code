<?php

class User extends main{
    var $user_model;   //instance of the User Model
    var $add_info;  //used for passing extra params

    public function User($params){
        if(isset($_REQUEST['i'])){
            $user_id = $_REQUEST['i'];
            parent::__constructor();
            if(!$this->userExistsByID($user_id))
                throw new Exception("User Does'nt Exist.");
            else{
                $this->user_id = $user_id;
                if(file_exists('php/models/User.php'))
                    require 'php/models/User.php';
                else
                    require '../models/User.php';
                $this->user_model = new User_Model($user_id);
            }
        }else{
            throw new Exception('ERRPR #4538.');
        }
    }

    public function getUser(){
        return $this->user_model->getUser();
    }

    public function getUserWithProducts(){
        return $this->user_model->getUserWithProducts();
    }

    public function view(){
        $page_data = $this->page_data;
        $page_data['user'] = $this->getUserWithProducts();
        require 'php/views/User.php';
    }





}
