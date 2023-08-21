<!DOCTYPE html>
<!--
error message for the queries
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>TwitterClone Error Page</title>
        <link rel="stylesheet" href="scripts/style.css">
        
    </head>
    
    <body>
        <?php
        // put your code here
        echo "<p>Problem with the Code or Connection! </p></p>";
        echo "<p>Error Msg: ".$error_msg." </p>";
        echo ini_set('display_errors', 1);
        ?>
    </body>
    
    <?php include ('view/footer.php'); ?>
</html>
