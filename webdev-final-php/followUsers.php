<!DOCTYPE html>
<?php
    session_start();
    require_once 'model/db.php';//test db connection :)
    include ('view/headerLoggedIn.php');
    
    $loggedinEmail = $_SESSION['email'];
    $action = htmlspecialchars(filter_input(INPUT_POST,"action"));
    $toEmailFollow = htmlspecialchars(filter_input(INPUT_POST,"followEmail"));
    $toEmailUnfollow = htmlspecialchars(filter_input(INPUT_POST,"unfollowEmail"));
    
    /*
    echo $loggedinEmail."<br>";
    echo $toEmailFollow."<br>"; //these are null
    echo $toEmailUnfollow."<br>"; //these are null
    echo $action;
     *
     */
    
    //follow button logic, when clicked
    //this is working
    if ($action == "follow" && $loggedinEmail != "")
    {
        //use substitution to insert values via a query
        //add the follow flag to the table for this user
        $query = "INSERT INTO follow (fromUser,followYN,toUser) VALUES (:email,'YES',:toUser)";

        $statement = $twitterDB->prepare($query);
        //sanitize, value bind in PDO to protect against SQL injection
        $statement->bindValue(':email',$loggedinEmail);
        $statement->bindValue(':toUser',$toEmailFollow);   
        //execute query
        $statement->execute();
        //close cursor
        $statement->closeCursor();
        //echo $successFollow;
    }//end if for follow button
    
    
    //follow button logic, when clicked
    if ($action == "unfollow" && $loggedinEmail != "")
        {
            //use substitution to insert values via a query
            //add the follow flag to the table for this user
            //$query = "UPDATE follow SET followYN = 'NO' WHERE toUser = :toUser";
            $query = "DELETE FROM follow WHERE fromUser = :email AND toUser = :toUser";
            //$query = "DELETE FROM contentLike WHERE content = :content AND fromUser = :email AND toUser = :toEmail"
            $statement = $twitterDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':email',$loggedinEmail);
            $statement->bindValue(':toUser',$toEmailUnfollow);   
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
            //echo $toEmail;
                    
        }//end of update query
        
    //show followed users and then only show their twitter feeds
    //start of CRUD - READ - SELECT
    $query = "SELECT * FROM follow f INNER JOIN user u ON f.toUser = u.email WHERE f.fromUser = :email AND f.followYN = 'YES'";

    $statement = $twitterDB->prepare($query);
    $statement->bindValue(':email',$loggedinEmail);
    //execute query
    $statement->execute();
    $followedUsers = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //end CRUD - READ - SELECT
    
    //show users with an account
    $query = "SELECT * FROM user WHERE email NOT IN (:email)";  

    $statement = $twitterDB->prepare($query);
    $statement->bindValue(':email',$loggedinEmail);
    //execute query
    $statement->execute();
    $people = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //end CRUD - READ - SELECT


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Your Followed Users!</title>
    </head>
    <body>
        <h2>Users You Are Following</h2>
       

        <table>
            <?php foreach ($followedUsers as $followedUser) : ?>
            <tr>
                <td id = "mini-pic"><?php echo $followedUser['pic-code'];echo $followedUser['picture'];;
                    ?><br>
                </td>
                <td width = 50px;></td>
                <td><?php echo $followedUser['toUser']; ?><br></td>
                <td><?php echo $personEmail = $person['email']; ?><br></td>                
                <td id = "follow-box">
                    <!--<input type="hidden" name='action' value='follow' />-->
                    <img src="scripts/images/following.jpg">
                </td>
                <td>
                    <!--unfollow form-->    
                    <form method="post" action="followUsers.php">
                        <input type="hidden" name='action' value='unfollow' />
                        <input type="hidden" name='unfollowEmail' value= "<?php echo $followedUser['toUser']; ?>" />
                        <button type="submit" id="btn_unfollow" name="unfollow">
                            <img src="scripts/images/button-unfollow.jpg">
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </body>
</html>
