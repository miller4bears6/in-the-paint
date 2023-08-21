<!DOCTYPE html>
<!--
user's tweets
-->

<?php

    session_start(); //keeps the logged in menu going
    include ('view/headerLoggedIn.php');
    require_once 'model/db.php';//test db connection :)

    //$email = htmlspecialchars(filter_input(INPUT_POST,"email"));
    $loggedinEmail = $_SESSION['email'];
    
    //show tweets of your own
    $query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email WHERE t.email IN (:email) ORDER BY content DESC";
    //$query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email WHERE t.email IN (SELECT DISTINCT toUser FROM follow WHERE fromUser = :email AND followYN = 'YES') ORDER BY t.content DESC";

    $statement = $twitterDB->prepare($query2);
    $statement->bindValue(':email',$loggedinEmail);
    //execute query
    $statement->execute();
    $tweets = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //echo (is_null($tweets))
    
    //show the count of likes
    $query2 = "SELECT COUNT(likeYN) FROM contentlike WHERE toUser = :email";

    $statement = $twitterDB->prepare($query2);
    $statement->bindValue(':email',$loggedinEmail);
    //execute query
    $statement->execute();
    $userLikes = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //echo (is_null($tweets))
    
    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Your TwitterClone Tweets</title>
        <link rel="stylesheet" href="scripts/style.css">
    </head>
    <body>
        
        <h2>Your Posts</h2>
        
        <!--tweet-feed-->
        <table id = "tweet-feed">
            <?php foreach ($tweets as $tweet) : ?>
            <tr>
                <td>
                    <b><?php echo $tweet['name']." -- posted on ".$tweet['date']." -- ".$tweet['email']."<br><br></b>"; ?>
                    <?php echo $tweet['content']." -- <img src ='scripts/images/button-like2.png'>  ".$tweet['likes']." likes <br><br>"; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td><br><br></td>
            </tr>
        </table>

    </body>
</html>
