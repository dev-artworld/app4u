<?php
session_start();
/*
 * user.class.php
 * 
 * Copyright 2016 AW115
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * Author      :  AW115
 * E-mail      :  harpreet@retouchingwork.org
 * Created on  :  4th April 2016
 * Version     :  1.0
 * Project     :  WebService
 * Page        :  User Class
 * Company     :  Art World Web Solutions
 * Modified on :   
 * Modified by :   
 */

$mysqli = new mysqli('localhost','artworl4_demo','deep&*^art');


class Users {
    
    //Declaring variables
    private $username;
    private $password;
    private $firstname;
    private $surname;
    private $company;
    private $usertype;
    private $address;
    private $postalcode;
    private $homephone;
    private $workphone;
    private $mobile;
    private $email;
    private $connection;

    //Setting username and password
    public function __construct($username, $password) {
        $this->username   = $username;
        $this->password   = $password;
        @$this->firstname  = $firstname;
        @$this->surname    = $surname;
        @$this->Company    = $company;
        @$this->usertype   = $usertype;
        @$this->address    = $address;
        @$this->postalcode = $postalcode;
        @$this->homephone  = $homephone;
        @$this->workphone  = $workphone;
        @$this->mobile     = $mobile;
        @$this->email      = $email;
    } 
    // Login Method
    public function login($connection, $database, $table, $usernameField, $passwordField) {
        $password = md5($this->password);
        $connection->select_db($database);
        $statement = $connection->query("SELECT * FROM `".$table."` WHERE `".$usernameField."` = '".$this->username."' AND `".$passwordField."` = '".$password."'");
        $results = new stdClass();
        //fetching records from database sent it to view.
        if ($statement->num_rows > 0) {
            foreach( $statement->fetch_assoc() as $key => $user ){
                $results->$key = $user;
            }
        } else {
            //error occur when someone entered incorrect details.
            $results->error = "OOPS! You Entered Incorrect Details!";
        }
        //create login user session
        $_SESSION['userdata'] = $results;
        return $results;
    }
}
?>