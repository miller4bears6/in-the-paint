<?php

//this should be the "controller" file

//configuration of the data source name
//mysql:host=host_address;dbname=database_name;

    //set up connection variables to connect to the stock db

    //create PDO object with the variables defined ^
    //move this to the models/db.php code

    /*
    $dsn = 'mysql:host=localhost; dbname=stock';
    $username = 'testUser';
    $password = 'test';
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
     * 
     */

    //try-catch to test the connection
    //run queries here
    try {
        //connect to the database
        $stockDB = new PDO($dsn, $username, $password);
        //echo '<p>Database Connection Status: CONNECTED to Stock Table! :) </p>';
        
        //get the values from the form and check format
        $symbol= htmlspecialchars(filter_input(INPUT_POST,"symbol"));
        $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
        $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT);
        
        //start INSERT QUERY
        if ($action == "insert" && $symbol != "" && $name != "" && $price != 0) {       
            //call this function
            add_stock($symbol, $name, $price);
        
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
        }//end of error check for blank form
        
        
        //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
        //call the stock select function here!!
        $stocks = show_stocks();
        
    }//end of try block
    
    catch (Exception $e) {
        $error_msg = $e->getMessage();
        //echo '<p>NOT CONNECTED! Check Settings for Stock table :( </p>';
        //echo "<p>Error Msg: $error_msg </p>";
        
        //add the error view here
        include ('views/error.php');
        exit();
    }//end of catch block

    

    //RUN A QUERY TO DELETE A STOCK
    //look for the input stock from the form
    
    //example from the book - works for me
    $symbol_d= htmlspecialchars(filter_input(INPUT_POST,'symbol'));
    $name_d = htmlspecialchars(filter_input(INPUT_POST,'name'));
    //$price = filter_input(INPUT_POST,'price',FILTER_VALIDATE_FLOAT);
    
    //if form is filled out and values exist...
    /*
    if ($symbol != "" && $name != "") {
        
        //use substitution to insert values via a query
        $query3 = 'DELETE FROM stocks WHERE stocks.symbol = 7';
        
        $statement = $stockDB->prepare($query3);
        //sanitize
        $statement->bindValue(':symbol',$symbol);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':name',$name);
        
        //execute query
        $statement->execute();
        
        //close cursor
        $statement->closeCursor();
        
        //$addStock = $stockDB->query($query2);

    }
     */
    
    
?>
