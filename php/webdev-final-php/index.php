<!DOCTYPE html>
<!--
Fatima Mohammed
CIS2454 SU-23
Final Project

index page

https://github.com/Oakland-Community-College/cis2454-summer2023-finalproject-miller4bears6
-->

<?php

    require_once 'model/db.php';//test db connection :)
    require 'model/loginModel.php';
    include ('view/headerLoggedIn.php');
    
    //error messages
    ini_set('display_errors', 1);

?>

<html>
    <head>
        <title>Fatima's Final Project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <h1>Welcome to TwitterClone!</h1><br>

        <h2>Log in or Sign Up!</h2>

        <br><br>
        
        <div class="row">
            <div class="column1">
                <form id ="login" method="post" action="login.php">
                    <label>eMail: </label>
                    <input type="text" name="email" size='35' required><br><br>
                    <label>password: </label>
                    <input type="password" name="pw" type="password" size='30' required><br><br>
                    <input type="submit" id="btn_add"  name="submit" value="Log in"/><br>
                </form>
            </div>
            
            <div class="column2">
                <form id ="registerForm" method="post" action="createAcct.php">
                    <label>First Name: </label>
                    <input name = "name" size='27' required><br><br>
                    <label>eMail: </label>
                    <input name = "email" size='35' required><br><br>
                    <label>password: </label>
                    <input name = "pw" size='30' required><br><br>

                    <input type="submit" id="btn_add" name = "newAcct" value="Sign up"/><br>
                </form>                    
            </div>
        </div>       
       
        <div id="left"></div>
        <div id="right"></div>
        <div id="top"></div>
        <div id="bottom"></div>

    </body>
    <?php include ('view/footer.php'); ?>
    
</html>
