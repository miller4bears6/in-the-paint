<!--
Fatima Mohammed
CIS2454 SU-23
Project 2 - mvc code and classes

https://github.com/Oakland-Community-College/cis2454-summer2023-project1-miller4bears6

-->

<?php

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Transaction List - MVC</title>
        <link rel="stylesheet" href="scripts/style.css">
    </head>
    
    <?php include ('topNav.php');?>
    
    <body>
        <h1>Welcome to Fatima's Project 2</h1>
        
        <h2>Stock Application with a Database - Transaction MVC and Class</h2>

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
                <td><?php echo $transaction->getId(); ?></td>
                <td><?php echo $transaction->getUser_id(); ?></td> 
                <td><?php echo $transaction->getName(); ?></td>
                <td><?php echo $transaction->getStock_id(); ?></td>
                <td><?php echo $transaction->getSymbol() ?></td>
                <td><?php echo $transaction->getQty(); ?></td>
                <td><?php echo "$ ".$transaction->getPrice(); ?></td>
                <td><?php echo $transaction->getTimestamp(); ?></td>
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
                    echo $transaction->getSymbol()." stock at $".$transaction->getPrice()." for ".$transaction->getQty()." share(s) costs $".($transaction['price']*$qty)."<br><br>";

                    echo $yesFundsMsg;
                    //echo $add_transaction_msg;
                }
                else {
                    echo $noFundsMsg;
                    //echo $add_transaction_msg;
                }
            ?>
        </div>
       
        <form id="insert_form" method="post" action ="transactionController.php">
              
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

        <form id="update_form" method="post" action ="transactionController.php">
              
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

        <form id="delete_form" method="post" action ="transactionController.php">
              
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
    
    <?php include ('footer.php'); ?>
</html>
