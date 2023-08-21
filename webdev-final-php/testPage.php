<!DOCTYPE html>
<!--
test page
-->


<?php 
       
    try {
        session_start();
        include('view/headerLoggedIn.php');
        require 'model/db.php';//test db connection :)
        //require_once 'scripts/checkLogIn.php';
        //require_once 'model/loginModel.php';
        //require_once 'view/login.php';
        //require_once 'index.php';
        
        $loggedinEmail = $_SESSION['email'];

        echo $_SESSION['email']."<br>";
        echo $loggedinEmail."<br>";
        echo "ok email is working<br>";
        //echo var_dump($user);
        //$email = htmlspecialchars(filter_input(INPUT_POST,"email"));

        
        
        
        
        //start of CRUD - READ - SELECT

        $query = "SELECT * FROM user WHERE email = :email";  
        $statement = $twitterDB->prepare($query);
        $statement->bindValue(':email',$loggedinEmail);
        //execute query
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();
        //end CRUD - READ - SELECT
        
    }//end of try block
    catch (Exception $e) {
        $error_msg = $e->getMessage();

        //add the error view here
        //include ('view/error.php');
    }//end of catch block

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <h2>Test Page</h2>
    <body>

        <?php echo $user['name']." hello user!!!";
        //echo var_dump($user);
        ?>
        
        
        <?php 
        foreach ($user as $array) :?>
        <?php
            echo $array."<br><br>";
        ?>
        <?php endforeach ?>


    </body>
    
    
</html>
