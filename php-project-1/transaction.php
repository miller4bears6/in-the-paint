<!--
Fatima Mohammed
CIS2454 SU-23
Project 1

https://github.com/Oakland-Community-College/cis2454-summer2023-project1-miller4bears6

-->

<?php

    //connect to db with an external php file
    require 'scripts/database-transaction.php';
    require 'scripts/database.php';

    //next set up a loop in the body of the html to display data
    
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Fatima's Project 1</title>
        <link rel="stylesheet" href="scripts/style.css">
        <a href="user.php">Users Page</a> | <a href="index.php">Stocks Page</a>
    </head>
    <body>
        <h1>Welcome to Fatima's Project 1</h1>
        
        <h2>Stock Application with a Database - Transactions</h2>
        
        <p id="queryError"><?php echo $queryError; ?></p>

        
        <!--select operation-->
        
        <p>SELECT all Records from Transaction Table:</p>
        
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>User ID</th>
                <th>User</th>
                <th>Stock ID</th>
                <th>Symbol</th>
                <th>QTY</th>
                <th>Price</th>
                <th>Timestamp</th>
                
            </tr>

            <?php foreach ($transactions as $transaction) : ?>

            <tr>
                <td><?php echo $transaction['id']; ?></td>
                <td><?php echo $transaction['user_id']; ?></td> 
                <td><?php echo $transaction['name']; ?></td>
                <td><?php echo $transaction['stock_id']; ?></td>
                <td><?php echo $transaction['symbol'] ?></td>
                <td><?php echo $transaction['qty']; ?></td>
                <td><?php echo "$ ".$transaction['price']; ?></td>
                <td><?php echo $transaction['timestamp']; ?></td>
            </tr>

            <?php endforeach; ?> 
        </table><br>
        <hr>
        
        <?php echo $confirmDelete; echo  "<b>".$deleteMsg."</b>";?>
        
        
        <!--insert operation-->
        <!--add a form to input data-->
        <p>INSERT to Transactions Table:</p>
        
        <div id="insert-stock-check">
            <?php
                if ($flag == 1) {
                    echo $transaction['symbol']." stock at $".$transaction['price']." for ".$qty." share(s) costs $".($transaction['price']*$qty)."<br><br>";

                    echo $yesFundsMsg;
                }
                else {
                    echo $noFundsMsg;
                }
            ?>
        </div>
       

        <form id="insert_form" method="post" action ="transaction.php">
              
            <div id="transactionForm1">
                <label>User ID: </label>
                <input type="text" name="user_id" size="10" required /><br><br>
                <label>Stock ID: </label>
                <input type="text" name="stock_id" size="10" required /><br><br>
                <label>Quantity: </label>
                <input type="text" name="qty" size="10"  required/><br><br>
                <input type="hidden" name='action' value='insert' />
            </div>
            <div id="button">
                <input id="btn_add" type="submit" name="submit" value="ADD"/> <br><br>
            </div>
            
        </form>
        
        <hr>
        
        
        <p>UPDATE Transactions Table:</p>

        <form id="update_form" method="post" action ="transaction.php">
              
            <div id="userForm2">
                <label>Transaction ID: </label>
                <input type="text" name="id" size="10" required/><br><br>             
                <label>User ID: </label>
                <input type="text" name="user_id" size="10" required/><br><br>            
                <label>Stock ID: </label>
                <input type="text" name="stock_id" size="10" required/><br><br>
                <label>Quantity: </label>
                <input type="text" name="qty" size="10" required/><br><br>
                <input type="hidden" name='action' value='update' />
                
            </div>
            <div id="button2">
                <input id="btn_upd" type="submit"  value="UPDATE"/> <br><br>
            </div>
            
        </form>
        
        
        <hr>
        
        <p>DELETE From The Transactions Table:</p>

        <form id="delete_form" method="post" action ="transaction.php">
              
            <div id="userForm3">
                <label>Transaction ID: </label>
                <input type="text" name="id" size="10" required/><br><br>
                <input type="hidden" name='action' value='delete' />
            </div>
            <div id="button3">
                <input id="btn_del" type="submit" name="submit" value="DELETE"/> <br><br>
            </div>
            
        </form>
        
    </body>
</html>
