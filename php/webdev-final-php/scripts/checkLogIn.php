<?php

/* 
protect access to other pages if not logged in if directly typing in the url
 */

//session_start();

//if someone is not logged in....
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] == false) {
    header("Location: index.php");
}//end of login check



