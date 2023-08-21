<?php

/* 
Fatima Mohammed
CIS2454 SU-23
Lab 5
 */

/* 
 log the user in or log the user out
 store user's pw in the db
 we will use a hash
 */

session_start();

try {
    
    //require_once 'utility/checkLogIn.php';
    require_once 'models/db.php';
    require_once 'models/loginModel.php'; //database interactions here
    

    //get the values from the from on the login page view...
    $email= htmlspecialchars(filter_input(INPUT_POST,"email"));
    $pw = htmlspecialchars(filter_input(INPUT_POST,"pw"));
    $pwHash = password_hash($pw, PASSWORD_DEFAULT);
    $loginMsg = "";
    $action = htmlspecialchars(filter_input(INPUT_GET, "action"));

    //next update topNav with the login page - done
    
    //if logging out
    if ($action == "logout"){
        //destroy session
        //set up a blank array
        $_SESSION = array();
        session_destroy();
    }//end of log out and clear session
    
    //f logging, in test the log in creds and log in
    if ($email !='' && $pw !='') {
        //result
        //$isLoggedIn = login($email, $pw);
        if (login($email,$pw)) {
            //store this
            //read about sessions
            //controller needs to use the session
            //this is tracked on the web server as long as the user is on the page
            $_SESSION['is_logged_in'] = true;
            $loginMsg = $email." is logged in :)<br><br>";
        }
        else {
            $loginMsg = "Wrong Credentials - Check and try again!<br><br>";
        }
    }//end of login logic

    //test output of email, pw, and pwHash
    //echo $email."<br>".$pw."<br>".$pwHash."<br><br>";

    //convert the pw to hash in the loginModel file - done

    //check if the pw is valid - done

    //show the log in page
    include ('views/loginView.php');
    
}//end of try block

catch (Exception $e) {
        $error_msg = $e->getMessage();
        
        //add the error view here
        include ('views/error.php');
        exit();

}//end of catch block