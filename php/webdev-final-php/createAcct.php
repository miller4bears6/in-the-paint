<?php

//tested account creation, hash pw, and logging in with new details
//WORKS!!!


//error messages
ini_set('display_errors', 1);

try {
    require_once 'model/db.php';

    //get the values from the from on the index page view...
    $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
    $email = htmlspecialchars(filter_input(INPUT_POST,"email"));
    $pw = htmlspecialchars(filter_input(INPUT_POST,"pw"));
    $pwHash = password_hash($pw, PASSWORD_DEFAULT);
    $loginMsg = "";
    $action = htmlspecialchars(filter_input(INPUT_GET, "action"));

    //If file upload form is submitted 
    //validate account details are correctly pulling in
    //validate a hash pw is generated correctly here
    echo $name." - ".$email." - ".$pw." - ".$pwHash."<br><br>";
    
    //insert new account details to the db
    $query = "INSERT INTO user (name, email, pw, pwHash) VALUES (:name,:email,:pw, :pwHash)";

    $statement = $twitterDB->prepare($query);
    //sanitize, value bind in PDO to protect against SQL injection
    $statement->bindValue(':name',$name);
    $statement->bindValue(':email',$email);
    $statement->bindValue(':pw',$pw);
    $statement->bindValue(':pwHash',$pwHash);
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();

    echo "user is creating an account here...<br><br>";
    echo "Enter your new login below";
    include ('index.php');
    
    
    
}//end of try block

catch (Exception $e) {
        $error_msg = $e->getMessage();
        
        //add the error view here
        include ('view/error.php');
        exit();

}//end of catch block


