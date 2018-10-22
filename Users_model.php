<?php

class Users_Model extends main{
    var $page_data;
    public function Users_Model(){
        parent::__constructor();
    }

    public function getAllUsers(){
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

}
