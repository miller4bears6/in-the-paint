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
        echo '<p>Database Connection Status: CONNECTED to User Table! :) </p>';
        
        //get the values from the form and check format
        $email= htmlspecialchars(filter_input(INPUT_POST,"email"));
        $name = htmlspecialchars(filter_input(INPUT_POST,"name"));
        $balance = filter_input(INPUT_POST,"balance",FILTER_VALIDATE_FLOAT);
        $id = $_POST['id'];
        
        //start INSERT QUERY
        if ($action == "insert" && $name != "" && $email != "" && $balance != 0) {
            
        //use substitution to insert values via a query
        //do not directly add content to the fields - sql injection
            $query = "INSERT INTO user (name, email, cash_balance) VALUES (:name,:email,:balance)";

            $statement = $stockDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':name',$name);
            $statement->bindValue(':email',$email);
            $statement->bindValue(':balance',$balance);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();

        }//end of insert query
        
        //start UPDATE query
        else if ($action == "update") {

            //match on a symbol in the update form
            $query = "UPDATE user SET name = :name, email = :email, cash_balance = :balance WHERE id = :id";

            $statement = $stockDB->prepare($query);
            //sanitize
            $statement->bindValue(':name',$name);
            $statement->bindValue(':email',$email);
            $statement->bindValue(':balance',$balance);
            $statement->bindValue(':id',$id);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();

        }//end of update query        
         
        
        else if ($action == "delete" && $id != 0) {

            $query2 = "DELETE FROM user WHERE id = :id";

            $statement = $stockDB->prepare($query2);
            //sanitize
            $statement->bindValue(':id',$id);

            //execute query
            $statement->execute();

            //close cursor
            $statement->closeCursor();

        }//end of delete record        

        //start of CRUD - READ - SELECT
        $query = "SELECT name,email,cash_balance,id FROM user";
        //$stocks = $stockDB->query($query);        
        
        $statement = $stockDB->prepare($query);
        //execute query
        $statement->execute();
        $users = $statement->fetchAll();
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
        echo '<p>NOT CONNECTED! Check Settings for User table :( </p>';
        echo "<p>Error Msg: $error_msg </p>";
        exit();
    }//end of catch block


    
    
?>


