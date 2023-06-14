<?php


//configuration of the data source name
//mysql:host=host_address;dbname=database_name;

    //set up connection variables to connect to the stock db

    //create PDO object with the variables defined ^
    $dsn = 'mysql:host=localhost; dbname=stock';
    $username = 'testUser';
    $password = 'test';
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    

    
    //try-catch to test the connection
    //run queries here
    try {
        //connect to the database
        $stockDB = new PDO($dsn, $username, $password);
        echo '<p>Database Connection Status: CONNECTED to Stock Table! :) </p>';
        
        //get the values from the form and check format
        $symbol= htmlspecialchars(filter_input(INPUT_POST,"symbol"));
        $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
        $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT);
        
        //start INSERT QUERY
        if ($action == "insert" && $symbol != "" && $name != "" && $price != 0) {
            
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

        }//end of insert query
        
        //start UPDATE query
        else if ($action == "update" && $symbol != "" && $name != "") {

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

        }//end of update query        
         
        
        else if ($action == "delete" && $symbol != "") {

            $query2 = "DELETE FROM stocks WHERE symbol = :symbol";

            $statement = $stockDB->prepare($query2);
            //sanitize
            $statement->bindValue(':symbol',$symbol);

            //execute query
            $statement->execute();

            //close cursor
            $statement->closeCursor();

        }//end of delete record        

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
        
        /*
        //error check if submit button is pressed and no fields have data
        if ($action != "") {
             $queryError = "Can't Insert, Update, or Delete from Table! Missing symbol, name, and price!";
        }//end of error check
         * 
         */
        
    }//end of try block
    
    catch (Exception $e) {
        $error_msg = $e->getMessage();
        echo '<p>NOT CONNECTED! Check Settings for Stock table :( </p>';
        echo "<p>Error Msg: $error_msg </p>";
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
