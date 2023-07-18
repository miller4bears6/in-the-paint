<!DOCTYPE html>
<!--
error message for the queries
-->
<html>
    <head>
        <?php include ('views/topNav.php'); ?>
        <meta charset="UTF-8">
        <title>Fatima's Project 2 Home Page</title>
        <link rel="stylesheet" href="scripts/style.css">
        
    </head>
    
    <body>
        <?php
        // put your code here
        echo '<p>Problem with the Code or Connection! </p></p>';
        echo "<p>Error Msg: ".$error_msg." </p>";
        echo ini_set('display_errors', 1);
        ?>
    </body>
    
    <?php include ('views/footer.php'); ?>
</html>
