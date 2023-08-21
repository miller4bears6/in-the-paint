<!DOCTYPE html>
<!--

-->
<?php
    session_start();
    require_once 'model/db.php';//test db connection :)
    include ('view/headerLoggedIn.php');
    $loggedinEmail = $_SESSION['email'];
    //$emailView = $_SESSION['emailView'];
    $emailView = htmlspecialchars(filter_input(INPUT_POST,"emailView"));
    //$toEmail = htmlspecialchars(filter_input(INPUT_POST,"followEmail"));
    //$action = htmlspecialchars(filter_input(INPUT_POST,"action"));
    
    //show their profile page
    //don't use this - it breaks everything
    //$email = htmlspecialchars(filter_input(INPUT_POST,"email"));
    $query = "SELECT * FROM user WHERE email = :email";
    $statement = $twitterDB->prepare($query);
    $statement->bindValue(':email',$emailView);
    //execute query
    $statement->execute();
    $user = $statement->fetch();
    //close cursor
    $statement->closeCursor();
    
    //show user's tweets
    $query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email WHERE t.email IN (:email) ORDER BY content DESC";
    //$query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email WHERE t.email IN (SELECT DISTINCT toUser FROM follow WHERE fromUser = :email AND followYN = 'YES') ORDER BY t.content DESC";

    $statement = $twitterDB->prepare($query2);
    $statement->bindValue(':email',$emailView);
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
        <title>User's Feed!</title>
    </head>
    <body>
        <h2>User's Profile View</h2>

        <!--set up a table here for content-->
        <!--user's pic, name, and email-->
        <table>
            <tr>
                <td>
                    <!--pic code-->
                    <?php 
                        echo $user['pic-code'];
                        echo $user['picture'];
                    ?>
                </td>
                <td width = 120px><!--empty space--></td>
                <!--post a tweet
                <td width = 500px>
                    <h3>Post a Tweet!</h3><br><br>
                    <form id = "post-a-tweet" method="post" action = "feedView.php" enctype="multipart/form-data" >
                        <label>Your Tweet: </label>
                        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
                        <input type="file" name="attachPic" id="attachPic" /><br><br>
                        <input type="hidden" name='action' value='insert' />
                        <input type="submit" id="add-pix"  name = "postTweet" value="Post a Tweet"/><br>
                    </form>                   
                </td>
                -->
                <td>
                    <!--tweet-feed-->
                    <!--show content from people you follow only!-->
                    <table id = "tweet-feed">
                        <?php foreach ($tweets as $tweet) : ?>
                        <tr id ="tweet-box" style = "width:600px">     
                            <td>
                                <b><?php echo $tweet['name']." -- posted on ".$tweet['date']." -- ".$tweet['email']."<br><br></b>"; ?>
                                <?php echo $tweet['content']." <img src ='scripts/images/button-like2.png'> -- ".$tweet['likes']." likes<br><br>"; ?>    


                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td><?php echo $queryMsg; ?></td>
                            <td><br><br><br><br></td>
                        </tr>
                    </table>  
             
                </td>
            </tr>
            <tr id = "user-details">
                <td>
                    <?php echo $user['name']."<br>".$user['email']; ?>
                </td>
            </tr>
        </table>
        
     
        
        
        
        
    </body>
    <?php include ('view/footer.php'); ?>
</html>
