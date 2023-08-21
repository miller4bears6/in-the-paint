<?php

//this is the stocks controller file
//require the models, then gets parameters, and then runs queries


//$queryMsg = "";

    try {
        
        //session_start();
        require_once 'model/db.php';
        
        //error messages
        ini_set('display_errors', 1);

        //show profile stuff
        $email = htmlspecialchars(filter_input(INPUT_POST,"email"));
        
        //run query for user information
        //start of CRUD - READ - SELECT
        $query = "SELECT * FROM user WHERE email = :email";

        $statement = $twitterDB->prepare($query);
        $statement->bindValue(':email',$email);
        //execute query
        $statement->execute();
        $user = $statement->fetch();
        //close cursor
        $statement->closeCursor();
        //header("Location: twitterFeed.php");
        
        
        //show tweets of others, not your own
        $query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email=u.email WHERE t.email NOT IN (:email)";
        
        $statement = $twitterDB->prepare($query2);
        $statement->bindValue(':email',$email);
        //execute query
        $statement->execute();
        $tweets = $statement->fetchAll();
        //close cursor
        $statement->closeCursor();
        
        //echo (is_null($tweets))." is null tweets boolean check";
        $queryMsg = "Follow more people to see content here";
        

}//end of try block

catch (Exception $e) {
        $error_msg = $e->getMessage();

        //add the error view here
        include ('view/error.php');


}//end of catch block


    //get the values from the from on the index page...
    /*
    $email = htmlspecialchars(filter_input(INPUT_POST,"email"));
    $pw = htmlspecialchars(filter_input(INPUT_POST,"pw"));
    $pwHash = password_hash($pw, PASSWORD_DEFAULT);
    $loginMsg = "";
    $action = htmlspecialchars(filter_input(INPUT_GET, "action"));
    */

    //connect to the db and display user information from the login


    /*
    //start INSERT tweet QUERY
    if ($action == "insert" && $symbol != "" && $name != "" && $price != 0) {       
        //call this function
        add_stock($symbol, $name, $price);
        //add redirects to the home page
        header("Location: stockController.php");

        $query = "INSERT INTO stocks (symbol, name, price) VALUES (:symbol,:name,:price)";

        $statement = $twitterDB->prepare($query);
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
        //call this function
        upd_stock($symbol, $price, $name);
        header("Location: stockController.php");

        //match on a symbol in the update form
        $query = "UPDATE stocks SET name = :name, price = :price WHERE symbol = :symbol";

        $statement = $twitterDB->prepare($query);
        //sanitize
        $statement->bindValue(':symbol',$symbol);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':name',$name);
        //execute query
        $statement->execute();
        //close cursor
        $statement->closeCursor();


    }//end of update query             

    //error check if submit button is pressed and no fields have data
    else if ($action != "") {
         $queryError = "Can't Insert, Update, or Delete from Table! Missing symbol, name, and price!";
         include ('views/error.php');
    }//end of error check for blank form


    //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
    //call the stock select function here!!
    //$stocks = show_stocks();

    //Select query that was moved to models/stock.php

    //start of CRUD - READ - SELECT
    $query = "SELECT * FROM tweet";
    //$stocks = $twitterDB->query($query);        

    $statement = $twitterDB->prepare($query);
    //execute query
    $statement->execute();
    $stocks = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //end CRUD - READ - SELECT

    //include('view/feedView.php');
     * 
     */
        
 ?>   
