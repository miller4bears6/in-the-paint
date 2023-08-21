<!--
this file is working don't touch it
-->

<header>
    
    <link rel="stylesheet" href="scripts/style.css">
    
    <?php 
        //check for session to display the full nav menu, or not
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) { 
    ?>

    <a href="feedView.php">Your Feed</a> | <a href="testPage.php">Test Page</a> | <a href="users.php">Find Friends</a> | <a href="followUsers.php">People You Follow</a> | <a href="yourTweets.php">Your Tweets</a> | <a href="login.php?action=logout">Log Out</a>

    <?php
    }//end of check for log in
    
    else { ?>
        <a href="index.php">Login</a>
    <?php 
    
    } ?>
        <hr>
    
</header>