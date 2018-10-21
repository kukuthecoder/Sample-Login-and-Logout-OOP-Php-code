<?php

class Logout_Model extends main{
    var $page_data;
    private $user_id;
    var $name, $profile_picture, $username;

    public function Logout_Model(){
        parent::__constructor();
    }

    public function logoutUser($u){
        $this->setUserID($u);
        $this->setLastLogout();
        return true;
    }

    public function setUserID($u){
        $this->user_id = $u;
    }

    public function getUserID(){
        return $this->user_id;
    }

    public function setLastLogout(){
        global $time;
        $user_id = $this->getUserID();
        $sql = $this->getCon()->prepare("SELECT name, profile_picture, username FROM admin_users WHERE id='$user_id'");
        $sql->execute();
        $this->name = $sql->fetch(PDO::FETCH_ASSOC)['name'];
        $this->username = $sql->fetch(PDO::FETCH_ASSOC)['username'];
        if($sql->fetch(PDO::FETCH_ASSOC)['profile_picture']=='')
            $this->profile_picture = $this->env['avatars_root'].'avatar.jpg';
        else
            $this->profile_picture = $this->env['avatars_root'].$sql->fetch(PDO::FETCH_ASSOC)['profile_picture'];

        $query = "UPDATE admin_users SET last_logout='$time' WHERE id='$user_id'";
        return $this->getCon()->query($query);
    }

}
