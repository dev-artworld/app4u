<?php
/*
 * getresults.php
 * 
 * Copyright 2013 AW115
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * Author      :  AW115
 * E-mail      :  harpreet@retouchingwork.org
 * Created on  :  4th August 2016
 * Version     :  1.0
 * Project     :  WebService
 * Page        :  GetResults
 * Company     :  Art World Web Solutions
 * Modified on :   
 * Modified by :   
 */
 
 
// Includes the class which have the all functions
ini_set('display_errors', '1');
include_once("user.class.php");


if(!empty($_REQUEST) && (($_REQUEST['username'] != "") && ($_REQUEST['password']!="") && ($_REQUEST['action']=="login")) ){

    /* 
     * Created object for User class
     * This file return the sucess or failure with provided details ( username, password ) 
     * USER NAME - username
     * PASSWORD - password
	 */

    $user = new Users($_REQUEST['username'],$_REQUEST['password']);
    
    // Calling the login method and store the output in result variable
    $result = $user->login($mysqli, 'artworl4_terance', 'user_details', 'User_Name', 'Password');
    
    // Converted it into JSON encode and display it 
    echo json_encode(array('results'=>$result));
    
    /* 
     * Output will be 
     * If it true  - {"results":1}
     * If it false - {"results":0}
     */
}else{
	
	echo "<div style='text-align:left;padding:10%;padding-left:30%;font-size:13px;font-family:verdina;'><h3 style='color:red;font-size:20px;'>Something went wrong</h3>
	<p>Call the method as </p>
	<code style='color:blue'>getresults.php?action=login&username=[username]&password=[password]</code> 
	
	<address>[username] replace with your username</address>
	<address>[password] replace with your password</address>
    <address>[action] replace with your action</address>
	</div>";
	
}


/* 
 * Provided output in the json encoded format 
 * Call the database disconnection method
 */

$mysqli->close();

?>
