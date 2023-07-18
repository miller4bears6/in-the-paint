<?php

//this is the user transaction file
//require the models, then gets parameters, and then runs querires

    try {
        require_once 'utility/checkLogIn.php';
        require_once 'models/db.php';
        require_once 'models/transactionModel.php'; //database interactions here
        
        //get the values from the form and check format
        $stock_id = filter_input(INPUT_POST,"stock_id",FILTER_VALIDATE_INT);
        $user_id = filter_input(INPUT_POST,"user_id",FILTER_VALIDATE_INT);
        $symbol= htmlspecialchars(filter_input(INPUT_POST,"symbol"));
        $id = filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT);
        $qty = filter_input(INPUT_POST,"qty",FILTER_VALIDATE_INT);
        $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT);
        
        //start INSERT QUERY
        //buy a stock
        //query the stock with stock_id to get price of stock
        //query the user for cash_balance
        //then compare cash_balance with cost for stocks
        
        //if the form is not empty
        if ($action == "insert" && $user_id !=0  && $stock_id != 0 && $qty != 0) {
            //call this function
            add_transaction($stock_id, $name, $user_id, $cashBalance, $qty);
            
            //add redirects to the home page
            header("Location: transactionController.php");
            
        }//end of insert func

        //use substitution to insert values via a query
        //do not directly add content to the fields - sql injection
            
        //get price of stock to be bought
        /*
        $query1 = "SELECT name,price FROM stocks WHERE id = $stock_id";

        $statement = $stockDB->prepare($query1);
        //execute query
        $statement->execute();
        $namePrices = $statement->fetch();
        //sanitize, value bind in PDO to protect against SQL injection
        //$statement->bindValue(':user_id',$user_id);
        $statement->bindValue(':stock_id',$stock_id);
        $statement->bindValue(':name',$name);
        //$statement->bindValue(':qty',$qty);
        //close cursor
        //$statement->closeCursor();

        //check user balance if they can buy the stock
        $query2 = "SELECT name,cash_balance FROM user WHERE id = $user_id";

        $statement = $stockDB->prepare($query2);
        //execute query
        $statement->execute();
        $userBalance = $statement->fetch();
        //sanitize, value bind in PDO to protect against SQL injection
        //$statement->bindValue(':user_id',$user_id);
        $statement->bindValue(':user_id',$user_id);
        $statement->bindValue(':cash_balance',$cashBalance);
        //$statement->bindValue(':qty',$qty);
        //close cursor
        $statement->closeCursor();

        //cost of transaction & cash balance vars
        $cashBalance = $userBalance['cash_balance'];
        $totalCost = $namePrices['price'] * $qty;

        //check user balance and update it
        if ($cashBalance >= $totalCost) {

            //update query - user's balance after transaction
            $query5 = "UPDATE user SET cash_balance = ($cashBalance - $totalCost) WHERE id = $user_id";

            $statement = $stockDB->prepare($query5);
            $statement->execute();
            //close cursor
            $statement->closeCursor();

            //message for web page
            $yesFundsMsg = "Transaction Successful! ". $userBalance['name']." has a balance of $".($userBalance['cash_balance']-$totalCost)."<br><br>";

            //insert query finally works, no null values required
            //only insert if enough funds in user table
            $query4 = "INSERT INTO transaction (user_id, stock_id, qty) VALUES (:user_id,:stock_id,:qty)";

            $statement = $stockDB->prepare($query4);
            //sanitize, value bind in PDO to protect against SQL injection
            $statement->bindValue(':user_id',$user_id);
            $statement->bindValue(':stock_id',$stock_id);
            $statement->bindValue(':qty',$qty);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();

            $flag=1;

            }

        else {
            //print a low balance message here
            $noFundsMsg = "Transaction cancelled. ".$userBalance['name']." does not have enough funds.<br><br>";
            $flag=0;
        }

    }//end of insane code that took forever - insert transaction work

    */
        
        //start UPDATE query
        else if ($action == "update") {
            //call this function
            upd_transaction($id, $user_id, $stock_id, $qty);
            
            //add redirects to the home page
            header("Location: transactionController.php");
        }//end of function if statement

            /*
            //match on a symbol in the update form
            $query = "UPDATE transaction SET user_id = :user_id, stock_id = :stock_id, qty = :qty WHERE id = :id";

            $statement = $stockDB->prepare($query);
            //sanitize
            $statement->bindValue(':id',$id);
            $statement->bindValue(':user_id',$user_id);
            $statement->bindValue(':stock_id',$stock_id);
            $statement->bindValue(':qty',$qty);
            
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
            
        }//end of update query
             * 
             */
        
        //start delete query
        //update user's balance with qty of the row deleted * price of the stock from the table
        else if ($action == "delete" && $id !=0) {
            
            del_transaction($id);
            
            //add redirects to the home page
            header("Location: transactionController.php");   
        }//end of function if statement
                 
            /*
            //get the qty of stock from the record to be deleted
            $query1 = "SELECT t.id, s.name, t.qty, s.price FROM transaction t INNER JOIN stocks s ON t.stock_id = s.id WHERE t.id = :id";

            $statement = $stockDB->prepare($query1);
            //sanitize
            $statement->bindValue(':id',$id);

            //execute query
            $statement->execute();
            
            $qtySearch = $statement->fetch();
            
            //get the price of the stock
            $query2 = "SELECT s.id, s.name, s.price FROM stocks s INNER JOIN transaction t ON t.stock_id = s.id WHERE t.id = :id";
            
            $statement = $stockDB->prepare($query2);
            //sanitize
            $statement->bindValue(':id',$id);
            //execute query
            $statement->execute();
            $priceSearch = $statement->fetch();
            
            //calculate return aka a sale of the stock
            $sellPrice = $qtySearch['qty'] * $priceSearch['price'];
            
            //get the user's balance
            $query3 = "SELECT u.id, u.name, u.cash_balance FROM user u INNER JOIN transaction t ON t.user_id = u.id WHERE t.id = :id";
            
            $statement = $stockDB->prepare($query3);
            //sanitize
            $statement->bindValue(':id',$id);
            //execute query
            $statement->execute();
            $cashSearch = $statement->fetch();
            
            $newBalance = $cashSearch['cash_balance'] + $sellPrice;
            
            $deleteMsg = $cashSearch['name']." 's cash balance will be updated from $".number_format($cashSearch['cash_balance'],2)." to $".number_format($newBalance,2)."<br><br>";
            
            //$newCashBalance = $cashSearch['cash_balance'] + 
            
            //update user's cash_balance by the total ^
            $query4 = "UPDATE user SET cash_balance = $newBalance WHERE id = (SELECT u.id FROM user u INNER JOIN transaction t ON t.user_id=u.id WHERE t.id= :id)";
            
            $statement = $stockDB->prepare($query4);
            //sanitize
            $statement->bindValue(':id',$id);
            //execute query
            $statement->execute();
            $endUpdate = $statement->fetch();

            //close cursor
            //$statement->closeCursor();

            //finally, delete the transaction
            //run this query at the end
            $query = "DELETE FROM transaction WHERE id = :id";

            $statement = $stockDB->prepare($query);
            //sanitize
            $statement->bindValue(':id',$id);
            //execute query
            $statement->execute();
            //close cursor
            $statement->closeCursor();
            
            $confirmDelete = number_format($qtySearch['qty'],2)." shares of ".$priceSearch['name']." stocks will be sold at $". number_format($priceSearch['price'],2)." per share.<p>The total of the deleted transaction = $".$sellPrice."<br><br><p>";

        }//end of delete record 
             * 
             */       

        //CRUD - SHOW STOCK TABLE - SELECT STATEMENT
        //call the stock select function here!!
        $transactions = show_transaction();
        
        include('views/transactionView.php');
          
    }//end of try block
    
    catch (Exception $e) {
        $error_msg = $e->getMessage();
        //echo '<p>NOT CONNECTED! Check Settings for Stock table :( </p>';
        //echo "<p>Error Msg: $error_msg </p>";
        
        //add the error view here
        include ('views/error.php');
        exit();
    }//end of catch block
      
?>    
        
        