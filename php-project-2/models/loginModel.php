<?php

//get user and their hashed pw
function login($email, $pw) {
    
    global $stockDB;

    //start of CRUD - READ - SELECT
    $query = "SELECT email, pwHash FROM user WHERE email = :email";

    $statement = $stockDB->prepare($query);
    $statement->bindValue(':email',$email);
    //execute query
    $statement->execute();
    $user2 = $statement->fetch();
    //close cursor
    $statement->closeCursor();
    
    //if user doesn't exist
    if ($user2 == '') {
        return false;
    }//end of check for blank user
    
    $pwHash = $user2['pwHash'];
    
    //verify pw
    return password_verify($pw, $pwHash);    

    //end CRUD - READ - SELECT
    
}//end of login func   


