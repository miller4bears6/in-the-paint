<?php

    //this code was made using the class lecture

    //configuration of the data source name
    //mysql:host=host_address;dbname=database_name;

    //set up connection variables to connect to the twitter db

    //create PDO object with the variables defined ^
    $dsn = 'mysql:host=localhost; dbname=twitter';
    $username = 'user';
    $password = 'test';
    
    //configuration of the data source name
    //mysql:host=host_address;dbname=database_name;
    try {
    //connect to the database
    $twitterDB = new PDO($dsn, $username, $password);
    //echo "<p>Database Connection Status: CONNECTED to Twitter DB! :) </p>";
    }
    
    catch (PDOException $e) {
        $error_msg = $e->getMessage();
        include('error.php');
        exit();
    }
    
?>