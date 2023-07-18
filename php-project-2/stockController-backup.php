<?php

//this is the stocks controller file
//require the models, then gets parameters, and then runs querires

    try {
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
            //call this function
            add_stock($symbol, $name, $price);
            //add redirects to the home page
            header("Location: stockController.php");
        
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
        else if ($action == "update" && $symbol != "" && $name != "") {     
            //call this function
            upd_stock($symbol, $price, $name);
            header("Location: stockController.php");

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
        else if ($action == "delete" && $symbol != "") {
            
            //call this function
            del_stock($symbol);
            header("Location: stockController.php");
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
             $queryError = "Can't Insert, Update, or Delete from Table! Missing symbol, name, and price!";
             include ('views/error.php');
        }//end of error check for blank form
        
        
        //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
        //call the stock select function here!!
        $stocks = show_stocks();
        
        include('views/stocksView.php');
        
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
    //$price = filter_input(INPUT_POST,'price',FILTER_VALIDATE_FLOAT);
    
    
?>