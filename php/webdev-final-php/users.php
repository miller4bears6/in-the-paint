<?php

    //error messages
    ini_set('display_errors', 1);

    try {
        session_start();
        require_once 'model/db.php';//test db connection :)
        include ('view/headerLoggedIn.php');
        
        $email = htmlspecialchars(filter_input(INPUT_POST,"email"));
        $loggedinEmail = $_SESSION['email'];
        $action = htmlspecialchars(filter_input(INPUT_POST,"action"));
        $toEmail = htmlspecialchars(filter_input(INPUT_POST,"followEmail"));
        $emailView = htmlspecialchars(filter_input(INPUT_POST,"emailView"));

        //test values are being pulled in ^
        //echo $toEmail." is being followed<br>";
        //echo $action;

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
        
        //follow button logic, when clicked
        if ($action == "follow" && $loggedinEmail != "")
        {
            //use substitution to insert values via a query
            //add the follow flag to the table for this user
            $query = "INSERT INTO follow (fromUser,followYN,toUser) VALUES (:email,'YES',:toUser)";
            
            $statement = $twitterDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':email',$loggedinEmail);
            $statement->bindValue(':toUser',$toEmail);   
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
            
            $successFollow = "<img src = 'scripts/images/icon-following.gif'> You are following this user! ";
            //echo $successFollow;
        }//end if for follow button

        //follow button logic, when clicked
        if ($action == "unfollow" && $loggedinEmail != "")
        {
            //use substitution to insert values via a query
            //add the follow flag to the table for this user
            $query = "UPDATE follow SET followYN = 'NO' WHERE toUser = :toUser";
            
            $statement = $twitterDB->prepare($query);
            //sanitize, value bind in PDO to protect against SQL injection
            //$statement->bindValue(':email',$loggedinEmail);
            $statement->bindValue(':toUser',$toEmail);   
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
        }//end of update query
        
    }//end of try block
    catch (Exception $e) 
    {
        $error_msg = $e->getMessage();
        //add the error view here
        include ('view/error.php');
    }//end of catch block

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bad Twitter Clone Users</title>
    </head>
    <body>
        
        <h2>List of <?php echo count($people);?> Other Users here!!</h2>
        
        <br><br>
        
        <table>
            <?php foreach ($people as $person) : ?>
            <tr>
                <td id = "mini-pic"><?php echo $person['pic-code'];
                    echo $person['picture'];
                    ?><br>
                </td>
                <td width = 50px;></td>
                <td><?php echo $person['name']; ?><br></td>
                <td><?php echo $personEmail = $person['email']; ?><br></td>
                <td id = "follow-box">
                    <form method="post" action="users.php">
                        <input type="hidden" name='action' value='follow' />
                        <input type="hidden" name='followEmail' value= "<?php echo $person['email']; ?>" />
                        <button type="submit" id="btn_follow" name="follow">
                            <img src="scripts/images/button-follow.png">
                        </button>
                    </form>
                </td>
                <td>
                    <form method="post" action="userFeed.php">
                        <input type="hidden" name='action' value='viewPage' />
                        <input type="hidden" name='emailView' value= "<?php echo $person['email']; ?>" />
                        <button type="submit" id="btn_viewProfile" name="viewPage">
                            <img src="scripts/images/button-viewProfile2.png">
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </body>
    <?php include('view/footer.php'); ?>
</html>

