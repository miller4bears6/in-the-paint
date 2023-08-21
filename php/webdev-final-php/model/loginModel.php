<?php

//get user and their hashed pw
function login($email, $pw) {
    
    global $twitterDB;

    //start of CRUD - READ - SELECT
    $query = "SELECT email, pwHash FROM user WHERE email = :email";

    $statement = $twitterDB->prepare($query);
    $statement->bindValue(':email',$email);
    //execute query
    $statement->execute();
    $user = $statement->fetch();
    //close cursor
    $statement->closeCursor();
    
    //if user doesn't exist
    if ($user == '') {
        return false;
    }//end of check for blank user
    
    $pwHash = $user['pwHash'];
    
    //verify pw
    return password_verify($pw, $pwHash);    

    //end CRUD - READ - SELECT
    
    
    
}//end of login func   


