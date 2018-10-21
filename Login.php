<?php

class Login_Model extends main{
    var $page_data;
    private $user_id;
    public function Login_Model(){
        parent::__constructor();
    }

    public function getAllLogin(){
         $query = "SELECT
                         users.*,
                         cities.name AS city,
                         provincies.name AS province,
                         store_countries.name AS country

                  FROM users, cities, provincies, store_countries
                  WHERE
                         users.city = cities.id AND
                         users.province = provincies.id AND
                         users.country = store_countries.id";

        $sql = $this->getCon()->prepare($query);
        $sql->execute();
        $count = $sql->rowCount();
        if($count){
            $users = array();
            $x=0;
            while($r=$sql->fetch(PDO::FETCH_ASSOC)){
                $users[$x] = $r;
            }
        }else{
            $users = false;
        }
        return $users;
    }

    public function loginUser($u, $p){
        $p = md5($p);
        $sql = $this->getCon()->prepare("SELECT id FROM admin_users WHERE username='$u' AND pwd='$p'");
        $sql->execute();
        $count = $sql->rowCount();
        if($count==1){
            $this->setUserID($sql->fetch(PDO::FETCH_ASSOC)['id']);
            $this->setLastLogin();
            return true;
        }else{
            return false;
        }
    }

    public function setUserID($u){
        $this->user_id = $u;
    }
    public function getUserID(){
        return $this->user_id;
    }

    public function setLastLogin(){
        global $time;
        $user_id = $this->getUserID();
        $query = "UPDATE admin_users SET last_login='$time' WHERE id='$user_id'";
        return $this->getCon()->query($query);
    }
}