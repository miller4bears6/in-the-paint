<?php

//this is the user controller file
//require the models, then gets parameters, and then runs querires

ini_set('display_errors', 1);

try {
    require_once 'utility/checkLogIn.php';
    require_once 'models/db.php';
    require_once 'models/userModel.php'; //database interactions here

    //get the values from the form and check format
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $email= htmlspecialchars(filter_input(INPUT_POST,"email"));
    $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
    $balance = filter_input(INPUT_POST,"balance",FILTER_VALIDATE_FLOAT);
    $id = filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT);

    //start INSERT QUERY
    if ($action == "insert" && $name != "" && $email != "" && $balance != 0) {    

        //insert stock class object that we just created
        //using the debugger, I was getting an error for too few arguments being passed in, so I added an $id parameter
        $user = new User($name, $email, $balance, $id=0);
        //call this function
        add_user($user);
        //add redirect
        header("Location: userController.php");

    }//end of insert func


    //start UPDATE query
    else if ($action == "update" && $id != 0) { 

        $user = new User($name, $email, $balance, $id);
        //call this function
        upd_user($user);
        header("Location: userController.php");

    }//end of update query        

    //start DELETE query
    else if ($action == "delete") {

        //insert user class object that we just created
        $user = new User("", "", 0, $id);
        //call this function
        del_user($user);
        header("Location: userController.php");

    }//end of delete query

    //error check if submit button is pressed and no fields have data
    else if ($action != "") {
         $queryError = "Can't Insert, Update, or Delete from Table! Missing data!";
         include ('views/error.php');
    }//end of error check for blank form


    //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
    //call the user select function here!!
    $users = show_users();

    include('views/userView.php');

}//end of try block

catch (Exception $e) {
    $error_msg = $e->getMessage();

    //add the error view here
    include ('views/error.php');
    exit();
}//end of catch block
    
?>