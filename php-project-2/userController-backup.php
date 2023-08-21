<?php

//this is the user controller file
//require the models, then gets parameters, and then runs querires

    try {
        require_once 'utility/checkLogIn.php';
        require_once 'models/db.php';
        require_once 'models/userModel.php'; //database interactions here
        
        //get the values from the form and check format
        $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
        $email= htmlspecialchars(filter_input(INPUT_POST,"email"));
        $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
        $balance = filter_input(INPUT_POST,"balance",FILTER_VALIDATE_FLOAT);
        $id = $_POST['id'];
        
        //start INSERT QUERY
        if ($action == "insert" && $name != "" && $email != "" && $balance != 0) {       
            //call this function
            add_user($email, $name, $balance);
            
            //add redirects to the home page
            header("Location: userController.php");
        
        /* --- move this to the model/stock.php file
        //use substitution to insert values via a query
        //do not directly add content to the fields - sql injection
            $query = "INSERT INTO stocks (symbol, name, price) VALUES (:symbol,:name,:price)";

            $statement = $stockDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':symbol',$symbol);
            $statement->bindValue(':price',$price);
            $statement->bindValue(':name',$name);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
         
         */

        }//end of insert query
        
        
        //start UPDATE query
        else if ($action == "update") {     
            //call this function
            upd_user($name, $email, $balance, $id);
            header("Location: userController.php");

            /*
            //match on a symbol in the update form
            $query = "UPDATE stocks SET name = :name, price = :price WHERE symbol = :symbol";

            $statement = $stockDB->prepare($query);
            //sanitize
            $statement->bindValue(':symbol',$symbol);
            $statement->bindValue(':price',$price);
            $statement->bindValue(':name',$name);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
            */

        }//end of update query        
         
        //start DELETE query
        else if ($action == "delete" && $id != 0) {
            
            //call this function
            del_user($id);
            header("Location: userController.php");
            /*
            $query2 = "DELETE FROM stocks WHERE symbol = :symbol";

            $statement = $stockDB->prepare($query2);
            //sanitize
            $statement->bindValue(':symbol',$symbol);

            //execute query
            $statement->execute();

            //close cursor
            $statement->closeCursor();          
            */

        }//end of delete query        

            //Select query that was moved to models/stock.php
            /*
            //start of CRUD - READ - SELECT
            $query = "SELECT name,symbol,price,id FROM stocks";
            //$stocks = $stockDB->query($query);        

            $statement = $stockDB->prepare($query);
            //execute query
            $statement->execute();
            $stocks = $statement->fetchAll();
            //close cursor
            $statement->closeCursor();
            //end CRUD - READ - SELECT
            */
        
        //error check if submit button is pressed and no fields have data
        else if ($action != "") {
             $queryError = "Can't Insert, Update, or Delete from Table! Missing data!";
             include ('views/error.php');
        }//end of error check for blank form
        
        
        //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
        //call the stock select function here!!
        $users = show_users();
        
        include('views/userView.php');
        
    }//end of try block
    
    catch (Exception $e) {
        $error_msg = $e->getMessage();
        //echo '<p>NOT CONNECTED! Check Settings for Stock table :( </p>';
        //echo "<p>Error Msg: $error_msg </p>";
        
        //add the error view here
        include ('views/error.php');
        exit();
    }//end of catch block
        
    $symbol_d= htmlspecialchars(filter_input(INPUT_POST,'symbol'));
    $name_d = htmlspecialchars(filter_input(INPUT_POST,'name'));
    
?>