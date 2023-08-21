<?php

/* 
protect access to other pages if not logged in if directly typing in the url
 */

session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] == false) {
    header("Location: .");
}//end of login check

