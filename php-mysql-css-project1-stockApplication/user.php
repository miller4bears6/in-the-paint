<!--
Fatima Mohammed
CIS2454 SU-23
Project 1

https://github.com/Oakland-Community-College/cis2454-summer2023-project1-miller4bears6

-->

<?php

    //connect to db with an external php file
    require_once 'scripts/database-user.php';

    //next set up a loop in the body of the html to display data
    
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Fatima's Project 1</title>
        <link rel="stylesheet" href="scripts/style.css">
        <a href="transaction.php">Transactions Page</a> | <a href="index.php">Stocks Page</a>
    </head>
    <body>
        <h1>Welcome to Fatima's Project 1</h1>
        
        <h2>Stock Application with a Database - Users</h2>
        
        <p id="queryError"><?php echo $queryError; ?></p>

        
        <!--select operation-->
        
        <p>SELECT from User Table:</p>
        
        <table>
            <tr>
                <th>Name</th>
                <th>eMail</th>
                <th>Balance</th>
                <th>ID</th>
            </tr>

            <?php foreach ($users as $user) : ?>

            <tr>
                <td><?php echo $user['name']; ?></td> 
                <td><?php echo $user['email']; ?></td>
                <td><?php echo '$'.$user['cash_balance']; ?></td>
                <td><?php echo $user['id']; ?></td>
            </tr>

            <?php endforeach; ?> 
        </table><br>
        <hr>
        
        <!--insert operation-->
        <!--add a form to input data-->
        <p>INSERT to User Table:</p>

        <form id="insert_form" method="post" action ="user.php">
              
            <div id="userForm1">
                <label>Name: </label>
                <input type="text" name="name" size="30" /><br><br>             
                <label>eMail: </label>
                <input type="text" name="email" size="30" /><br><br>            
                <label>Balance: </label>
                $ <input type="text" name="balance" size="10" /><br><br>
                <input type="hidden" name='action' value='insert' />
            </div>
            <div id="button">
                <input id="btn_add" type="submit" name="submit" value="ADD"/> <br><br>
            </div>
            
        </form>
        
        <hr>
        
        <p>UPDATE User Table:</p>

        <form id="update_form" method="post" action ="user.php">
              
            <div id="userForm2">
                <label>ID: </label>
                <input type="text" name="id" size="10" /><br><br>                  
                <label>Name: </label>
                <input type="text" name="name" size="30" /><br><br>  
                
                <label>eMail: </label>
                <input type="text" name="email" size="30" /><br><br>            
                <label>Balance: </label>
                $ <input type="text" name="balance" size="10" /><br><br>
                <input type="hidden" name='action' value='update' />
            </div>
            <div id="button2">
                <input id="btn_upd" type="submit"  value="UPDATE"/> <br><br>
            </div>
            
        </form>
        
        <hr>
        
        <p>DELETE From The User Table:</p>

        <form id="delete_form" method="post" action ="user.php">
              
            <div id="userForm3">
                <label>User ID: </label>
                <input type="text" name="id" size="30" required/><br><br>
                <input type="hidden" name='action' value='delete' />
            </div>
            <div id="button3">
                <input id="btn_del" type="submit" name="submit" value="DELETE"/> <br><br>
            </div>
            
        </form>
        
        
        <?php ?>
        <br><br>
        
        <div id = "results">
            
        </div>
        
    </body>
</html>
