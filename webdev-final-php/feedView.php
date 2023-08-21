<?php

//feedView

    try {
        session_start();
        require 'model/db.php';
        include ('view/headerLoggedIn.php');
        //require 'yourTweets.php';
        //error messages
        ini_set('display_errors', 1);
        
        $loggedinEmail = $_SESSION['email'];
        //get the values from the form and check format
        $toEmailLike = htmlspecialchars(filter_input(INPUT_POST,"likeEmail"));
        $likedContent = htmlspecialchars(filter_input(INPUT_POST,"likeContent"));
        $content = htmlspecialchars(filter_input(INPUT_POST,"content"));
        $action = htmlspecialchars(filter_input(INPUT_POST,"action"));
        $likeMsg = "";

        //show profile stuff for logged in user
        //don't use this - it breaks everything
        //$email = htmlspecialchars(filter_input(INPUT_POST,"email"));
        
        $query = "SELECT * FROM user WHERE email = :email";

        $statement = $twitterDB->prepare($query);
        $statement->bindValue(':email',$loggedinEmail);
        //execute query
        $statement->execute();
        $user = $statement->fetch();
        //close cursor
        $statement->closeCursor();
        
        //show tweets of others, not your own
        //must be people with the follow flag!
        //join that query to this table
        //of the all the people you follow, select their tweet content
        //add the tweet like info here...
        $query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email INNER JOIN contentLike c ON t.content = c.content WHERE t.email IN (SELECT DISTINCT toUser FROM follow WHERE fromUser = :email AND followYN = 'YES') ORDER BY t.content DESC";

        $statement = $twitterDB->prepare($query2);
        $statement->bindValue(':email',$loggedinEmail);
        //execute query
        $statement->execute();
        $tweets = $statement->fetchAll();
        //close cursor
        $statement->closeCursor();
        $queryMsg = "Follow more people to see content here";
        
        //echo count($tweets['likeYN'])." - tweet count?";
        
        //count of all likes for content in the feed
        $query4 = "SELECT likeYN FROM contentLike WHERE content = :content";
        $statement = $twitterDB->prepare($query4);
        //sanitize, value bind in PDO to protect against SQL injection
        $statement->bindValue(':content',$likedContent);
        //execute query
        $statement->execute();
        $likes = $statement->fetch();
        //close cursor
        $statement->closeCursor();
     
        //attaching images code not working because of mac permissions
        //$image_file = $_FILES["attachPic"];
        
        //tests
        //echo $content." is content for the table<br>";
        //echo $loggedinEmail."<br><br>";
        

        
        //start like logic
        if ($action == "like" && $loggedinEmail != "")
        {
            //use substitution to insert values via a query
            //do not directly add content to the fields - sql injection
            //check if loggedin user has an existing like for the content or not
            $query = "SELECT DISTINCT content, likeYN, fromUser, toUser FROM contentLike WHERE likeYN = 'YES' AND content = :content AND fromUser = :email";

            $statement = $twitterDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':content',$likedContent);
            $statement->bindValue(':email',$loggedinEmail);
            //execute query
            $statement->execute();
            $findLikes = $statement->fetchAll();
            //close cursor
            $statement->closeCursor();
            //end of check for likes
           
            $flagLikes = count($findLikes);
           
            
            //if a like exists, then unlike the post
            if (count($findLikes) > 0) {
                $query = "DELETE FROM contentLike WHERE content = :content AND fromUser = :email AND toUser = :toEmail";
                $statement = $twitterDB->prepare($query);
                //sanitize, value bind in PDO to protect against SQL injection
                //execute query
                $statement->bindValue(':content',$likedContent);
                $statement->bindValue(':email',$loggedinEmail);   
                $statement->bindValue(':toEmail',$toEmailLike);
                $statement->execute();
                //close cursor
                $statement->closeCursor();
                
                //echo count($findLikes)." like(s) deleted.";
                $likeMsg = "you unliked this tweet!";
            }
            
            
            //if no likes exist, then add a like
            if ($flagLikes == 0) {
                //$query = "UPDATE contentLike SET likeYN = 'YES' WHERE content = :content AND fromUser = :email and toUser = :toEmail";
                $query3 = "INSERT INTO contentLike (likeYN,fromUser,toUser,content) VALUES ('YES',:email,:toEmail,:content)";
                //"INSERT INTO contentLike (likeYN,fromUser,toUser,content) VALUES ("YES","user@email.com","test3@user.com","TEST CONTENT!")";
                //"UPDATE like SET like_flag = like_flag + 1, fromUser = :email, toUser = :toEmail WHERE content = :content"; 
                $statement = $twitterDB->prepare($query3);
                //sanitize, value bind in PDO to protect against SQL injection
                $statement->bindValue(':email',$loggedinEmail);
                $statement->bindValue(':toEmail',$toEmailLike);
                $statement->bindValue(':content',$likedContent);
                //execute query
                $statement->execute();
                //close cursor
                $statement->closeCursor();
                
                //echo count($findLikes)." -  a like was added to the table";
                $likeMsg = "you liked this tweet!";
                
                //update like count for the tweet!!
                $query5 = "UPDATE tweet SET likes = likes + 1 WHERE content = :content";
                //"UPDATE like SET like_flag = like_flag + 1, fromUser = :email, toUser = :toEmail WHERE content = :content"; 
                $statement = $twitterDB->prepare($query5);
                //sanitize, value bind in PDO to protect against SQL injection
                //$statement->bindValue(':email',$loggedinEmail);
                //$statement->bindValue(':toEmail',$toEmailLike);
                $statement->bindValue(':content',$likedContent);
                //execute query
                $statement->execute();
                //close cursor
                $statement->closeCursor();
                
                //echo count($findLikes)." -  a like was added to the table";
                $likeMsg = "you liked this tweet!";

            }//end of add a like

            
            /*
            //upload a picture in the post!
            //$action = htmlspecialchars(filter_input(INPUT_POST,"action"));
            
            //$target_dir = "scripts/images";
            //$target_file = $target_dir . basename($_FILES["attachPic"]["name"]);
            //$uploadOk = 1;
            //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Move the temp image file to the images/ directory
            $image_file = $_FILES["attachPic"];
            move_uploaded_file(
                // Temp image location
                $image_file["tmp_name"],

                // New image location, __DIR__ is the location of the current PHP file
                __DIR__ . "/scripts/images/" . $image_file["name"]
            );
             */
            
        }//end of like logic
        
        //show tweets of others, not your own
        //must be people with the follow flag!
        //join that query to this table
        //of the all the people you follow, select their tweet content
        //add the tweet like info here...
        $query2 = "SELECT * FROM tweet t INNER JOIN user u ON t.email = u.email WHERE t.email IN (SELECT DISTINCT toUser FROM follow WHERE fromUser = :email AND followYN = 'YES') ORDER BY t.content DESC";

        $statement = $twitterDB->prepare($query2);
        $statement->bindValue(':email',$loggedinEmail);
        //execute query
        $statement->execute();
        $tweets = $statement->fetchAll();
        //close cursor
        $statement->closeCursor();
        $queryMsg = "Follow more people to see content here";
        
        
}//end of try block

catch (Exception $e) {
        $error_msg = $e->getMessage();
        //add the error view here
        include ('view/error.php');
}//end of catch block
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Your Twitter Clone Feed</title>
    </head>
    <body>
        <h2>Your Bad TwitterClone Feed</h2>
        
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
                <!--post a tweet-->
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
            </tr>
            <tr id = "user-details">
                <td>
                    <?php echo $user['name']."<br>".$user['email']; ?>
                </td>
            </tr>
        </table>

        <b><?php echo $likeMsg; ?></b>
        
        <!--tweet-feed-->
        <!--show content from people you follow only!-->
        <table id = "tweet-feed">
            <?php foreach ($tweets as $tweet) : ?>
            <tr id ="tweet-box" style = "width:600px">     
                <td>
                    <b><?php echo $tweet['name']." -- posted on ".$tweet['date']." -- ".$tweet['email']."<br><br></b>"; ?>
                    <?php echo $tweet['content']."<br><br>"; ?>
                    <?php echo $tweet['likes']."<br><br>"; ?>    
                        
                        
                        
                </td>
            </tr>
            <tr id = "like-box">
                <td>
                    <form method="post" action="feedView.php">
                        <input type="hidden" name='action' value='like' />
                        <input type="hidden" name='likeEmail' value= "<?php echo $tweet['email']; ?>" />
                        <input type="hidden" name='likeContent' value= "<?php echo $tweet['content']; ?>" />
                        <button type="submit" id="btn_like" name="follow">
                            <img src ="scripts/images/button-like2.png"> 
                        </button>
                    </form>
                </td>
                <td>
                </td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <td><?php echo $queryMsg; ?></td>
                <td><br><br><br><br></td>
            </tr>
        </table>
        <br><br>
    </body>
    <?php include ('view/footer.php'); ?>
</html>
