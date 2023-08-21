<!DOCTYPE html>
<!--
top nav bar for all pages
-->

<header>
    <a href="index.php">Home</a> |
    
    <?php 
        //check for session to display the full nav menu, or not
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) { ?>

    <a href="stockController.php">Stocks Page</a> | <a href="transactionController.php">Transactions Page</a> | <a href="userController.php">Users Page</a> | <a href="loginController.php?action=logout">Log Out</a>
            
        <?php }//end of check for log in 
        else { ?>
            <a href="loginController.php">Login</a>
        <?php } ?>

    <hr><br><br>
    
</header>
