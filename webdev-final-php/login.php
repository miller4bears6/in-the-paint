<?php

/* 
Fatima Mohammed
CIS2454 SU-23
Final Project
*/

/* 
 log the user in or log the user out
 store user's pw in the db
 we will use a hash
 */

//session_start();
//do not add this or remove this

try {
    
    session_start();
    //require_once 'scripts/checkLogIn.php';
    require_once 'model/db.php';
    require 'model/loginModel.php';
    //require_once 'scripts/checkLogIn.php';
    //include ('view/headerLoggedIn.php');
    
    //get the values from the from on the index page...
    $email = htmlspecialchars(filter_input(INPUT_POST,"email"));
    $pw = htmlspecialchars(filter_input(INPUT_POST,"pw"));
    $pwHash = password_hash($pw, PASSWORD_DEFAULT);
    $loginMsg = "";
    $action = htmlspecialchars(filter_input(INPUT_GET, "action"));
    
    //if logging out with the button in the header
    if ($action == "logout"){
        //include ('index.php');
        //destroy session
        $_SESSION = array();
        session_destroy();
        $loginMsg = "You have logged out!";
        include ('view/logout.php');
        
    }//end of log out and clear session
    
    //if logging in, test the log in creds and log in
    if ($email !="" && $pw !="") {
        //result
        $isLoggedIn = login($email, $pw);
        if (login($email,$pw)) {
            //read about sessions
            //controller needs to use the session
            //this is tracked on the web server as long as the user is on the page
            //add the values to the session
            
            $_SESSION['is_logged_in'] = true;
            //require 'view/feedView.php';
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['pw'] = $_POST['pw'];
            $loginMsg = $email." is logged in :)<br><br>";
            echo $loginMsg;
            //test session storage
            //echo $_SESSION['email'];
            include('view/login.php');
            
        }//end of correct un/pw combo
        //if user/pw is wrong
        else {
            ini_set('display_errors', 1);
            $loginMsg = "Wrong Credentials - Check and try again!<br><br>";
            //echo $loginMsg; //put this on the index page
            //include ('view/wrongLogin.php');
            include ('index.php');
        }//end of wrong un/pw
    }//end of right and long login logic
    
    //no creds entered
    else if (empty($email) && empty($pw)) {    
        $loginMsg = "Enter your credentials -- <br><br>";
        //echo $loginMsg;
        include ('index.php');
    }//end of blank submission logic

    //end of login logic

    //test output of email, pw, and pwHash
    //echo $email."<br>".$pw."<br>".$pwHash."<br><br>";

    //convert the pw to hash in the loginModel file - done

    //check if the pw is valid - done
    
}//end of try block

catch (Exception $e) {
        $error_msg = $e->getMessage();
        //add the error view here
        include ('view/error.php');
        //exit();

}//end of catch block