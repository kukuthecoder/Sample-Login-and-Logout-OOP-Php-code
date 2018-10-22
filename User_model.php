<?php

class User_Model extends main{
    public function User_Model($user_id){
        parent::__constructor();
        $this->user_id = $user_id;
    }

    public function getUser(){
        $query = "SELECT * FROM users WHERE id='$this->user_id'";
        $sql = $this->getCon()->prepare($query);
        $sql->execute();
        $count = $sql->rowCount();
        if($count==1){
            $user = $sql->fetch(PDO::FETCH_ASSOC);
            if($user['profile_picture']==""){
                $user['profile_picture'] = "images/avatar.jpg";
            }
            $user['no_of_products'] = $this->getNoOfUserProducts();
            return $user;
        }else{
            return false;
        }
    }

    //includes the user's products in the returned data
    public function getUserWithProducts(){
        $user_data = $this->getUser();
        $user_products = $this->getUserProducts();
        if($user_products){
            $user_data['products'] = $user_products;
        }
        return $user_data;
    }

    public function getUserProducts(){
        $query = "SELECT id FROM products WHERE owner_id='$this->user_id'";
        $sql = $this->getCon()->prepare($query);
        $sql->execute();
        $count = $sql->rowCount();
        if($count){
            //not getting the product details from here is an effort to maintain one source of product data
            if(file_exists('php/models/Product.php'))
                require 'php/models/Product.php';
            else
                require '../models/Product.php';
            $user_products = array();
            while($r=$sql->fetch(PDO::FETCH_ASSOC)){
                $id = $r['id'];
                $product = new Product_Model($id);
                $product_details = $product->getProduct();
                $user_products[] = $product_details;
            }
            return $user_products;
        }else{
            return false;
        }
    }

    public function getNoOfUserProducts(){
        $query = "SELECT COUNT(id) AS count FROM products WHERE owner_id='$this->user_id'";
        $sql = $this->getCon()->prepare($query);
        $sql->execute();
        $count = $sql->rowCount();
        if($count){
            return $sql->fetch(PDO::FETCH_ASSOC)['count'];
        }else{
            return 0;
        }
    }

}
