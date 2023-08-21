<?php

//this is the stocks controller file
//require the models, then gets parameters, and then runs querires
//use this to debug my code and use the chrome extensions

    try {
        
        ini_set('display_errors', 1);
        require_once 'utility/checkLogIn.php';
        require_once 'models/db.php';
        require_once 'models/stockModel.php'; //database interactions here
        
        //get the values from the form and check format
        $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
        $symbol= htmlspecialchars(filter_input(INPUT_POST,"symbol"));
        $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
        $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT);
        
        //start INSERT QUERY
        if ($action == "insert" && $symbol != "" && $name != "" && $price != 0) {
            
            //insert stock class object that we just created
            //using the debugger, I was getting an error for too few arguments being passed in, so I added an $id parameter
            $stock = new Stock($symbol, $name, $price, $id=0);
            //call this function and pass in values
            add_stock($stock);
            //add redirects
            header("Location: stockController.php");
        }//end of insert query
        
        
        //start UPDATE query
        else if ($action == "update" && $symbol != "" && $name != "") {
            
            //insert stock class object that we just created
            $stock = new Stock($symbol, $name, $price, $id=0);
            //call this function
            upd_stock($stock);
            header("Location: stockController.php");

        }//end of update query        
         
        //start DELETE query
        else if ($action == "delete" && $symbol != "") {
            
            //insert stock class object that we just created
            $stock = new Stock($symbol,"",0,0);
            //call this function
            del_stock($stock);
            header("Location: stockController.php");

        }//end of delete query
        
        //error check if submit button is pressed and no fields have data
        else if ($action != "") {
             $queryError = "Can't Insert, Update, or Delete from Table! Missing symbol, name, and price!";
             include ('views/error.php');
        }//end of error check for blank form
        
        //start SELECT query
        $stocks = show_stocks();
            //debugging - why is this function not found when I defined it?
        
        include('views/stockView.php');
        
    }//end of try block
    
    catch (Exception $e) {
        $error_msg = $e->getMessage();
        
        //add the error view here
        include ('views/error.php');
        exit();
    }//end of catch block
    
?>
