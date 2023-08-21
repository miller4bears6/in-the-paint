<?php

//this is the transaction file
//require the models, then gets parameters, and then runs querires

ini_set('display_errors', 1);


try {
    require_once 'utility/checkLogIn.php';
    require_once 'models/db.php';
    require_once 'models/transactionModel.php'; //database interactions here

    //get the values from the form and check format
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $stock_id = filter_input(INPUT_POST,"stock_id",FILTER_VALIDATE_INT);
    $user_id = filter_input(INPUT_POST,"user_id",FILTER_VALIDATE_INT);
    //$symbol= htmlspecialchars(filter_input(INPUT_POST,"symbol"));
    $id = filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT);
    $qty = filter_input(INPUT_POST,"qty",FILTER_VALIDATE_INT);
    //$price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT);
    //$timestamp="";

    //start INSERT query
    if ($action == "insert" && $stock_id != 0 && $qty != 0) {
        
        $transaction = new Transaction($id=0, $user_id, $name="", $stock_id, $symbol="", $qty, $price="", $timestamp="");
        //call this function
        $add_transaction_msg = add_transaction($transaction);
        
        //add redirects to the home page
        //header("Location: transactionController.php");
        
        //continue to the rest of the view
        //if it fails, redirect to the error page
        //if a bad thing happens, go to a bad thing page
        //if the right thing happens, continue on through the rest of the wf

    }//end of insert func

    //start UPDATE query
    else if ($action == "update") {
        
        $transaction = new Transaction($id, $user_id, $name="", $stock_id, $symbol="", $qty, $price="", $timestamp="");
        //call this function
        upd_transaction($transaction);

        //add redirects to the home page
        header("Location: transactionController.php");
    }//end of function if statement

    //start delete query
    else if ($action == "delete" && $id !=0) {
        
        $transaction = new Transaction($id, $user_id=0, $name="", $stock_id=0, $symbol="", $qty=0, $price="", $timestamp="");

        del_transaction($transaction);

        //add redirects to the home page
        header("Location: transactionController.php");   
    }//end of delete func      

    //start SELECT query
    $transactions = show_transaction();

    include('views/transactionView.php');

}//end of try block

catch (Exception $e) {
    $error_msg = $e->getMessage();

    //add the error view here
    include ('views/error.php');
    exit();
}//end of catch block
      
?>
        
        