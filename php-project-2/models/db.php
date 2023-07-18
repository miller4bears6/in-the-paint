<?php

    //models/db.php 
    //connection code taken from the the project1 database.php file

    //this code was made using the class lecture

    //configuration of the data source name
    //mysql:host=host_address;dbname=database_name;

    //set up connection variables to connect to the stock db

    //create PDO object with the variables defined ^
    $dsn = 'mysql:host=localhost; dbname=stock';
    $username = 'testUser';
    $password = 'test';
    
    //configuration of the data source name
    //mysql:host=host_address;dbname=database_name;

    //set up connection variables to connect to the stock db

    //create PDO object with the variables defined ^

    //connect to the database
    $stockDB = new PDO($dsn, $username, $password);
    //echo '<p>Database Connection Status: CONNECTED to Stock Table! :) </p>';

