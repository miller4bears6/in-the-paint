<?php

//models/transactionModel.php

//functions for transactions table
//write a class to group the functions
//example was modeled after class lecture

ini_set('display_errors', 1);

global $stockDB;
global $noFundsMsg;
global $flag;
global $userBalance;
global $yesFundsMsg;
global $deleteMsg;
global $confirmDelete;

class Transaction {

    private $id, $user_id, $name, $stock_id, $symbol, $qty, $price, $timestamp;
    
    //some variables that aren't used anywhere, then don't need to declare it here in the class
    
    public function __construct($id, $user_id, $name, $stock_id, $symbol, $qty, $price, $timestamp) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->stock_id = $stock_id;
        $this->symbol = $symbol;
        $this->qty = $qty;
        $this->price = $price;
        $this->timestamp = $timestamp;
    }
    public function getCashBalance() {
        return $this->cashBalance;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getStock_id() {
        return $this->stock_id;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function getQty() {
        return $this->qty;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStock_id($stock_id) {
        $this->stock_id = $stock_id;
    }

    public function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    public function setQty($qty) {
        $this->qty = $qty;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }    
 
}//end of transaction class

//tested - this actually worked, wow
function show_transaction() {
    
    global $stockDB;
    
    //start of SELECT Query
    $query = "SELECT t.user_id, u.name, t.stock_id, s.symbol, t.qty, s.price, t.timestamp, t.id FROM transaction t INNER JOIN stocks s ON t.stock_id = s.id INNER JOIN user u ON t.user_id = u.id ORDER BY t.id ASC";

    $statement = $stockDB->prepare($query);
    //execute query
    $statement->execute();
    $transactions = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //end CRUD - READ - SELECT
    
    $transaction_array = array(); //no users yet
    
    foreach ($transactions as $transaction) {
        //create a new instance of Stock and populate array
       $transaction_array[] = new Transaction($transaction['id'], $transaction['user_id'], $transaction['name'], $transaction['stock_id'],$transaction['symbol'],$transaction['qty'],$transaction['price'],$transaction['timestamp']);
        //creates an array of objects
    }//end of set up a new stock object
    
    return $transaction_array;

}//end of show transaction func

//write a function to insert transactions
//what values were needed for this query? - symbol, name, price
//tested - works
function add_transaction($transaction){
    
    //clean this up
    
    global $stockDB;
    global $noFundsMsg;
    global $flag;
    global $userBalance;
    global $yesFundsMsg;
    
    //pass the values in instead of using global vars
    
    //get price of stock to be bought
    $query1 = "SELECT name,price FROM stocks WHERE id = :stock_id";

    $statement = $stockDB->prepare($query1);
    //sanitize, value bind in PDO to protect against SQL injection
    $statement->bindValue(':stock_id',$transaction->getStock_id());
    //$statement->bindValue(':name',$transaction->getName());
    
    //execute query
    $statement->execute();
    $namePrices = $statement->fetch();
    //sanitize, value bind in PDO to protect against SQL injection
    //$statement->bindValue(':stock_id',$transaction->getStock_id());
    //$statement->bindValue(':name',$transaction->getName());
    //close cursor
    //$statement->closeCursor();

    //check user balance if they can buy the stock
    $query2 = "SELECT name,cash_balance FROM user WHERE id = :user_id";

    $statement = $stockDB->prepare($query2);

    //sanitize, value bind in PDO to protect against SQL injection
    //$statement->bindValue(':user_id',$user_id);
    $statement->bindValue(':user_id',$transaction->getUser_id());
    //$statement->bindValue(':cash_balance',$cashBalance);
    //$statement->bindValue(':qty',$qty);
    //
    //execute query
    $statement->execute();
    $userBalance = $statement->fetch();
    //close cursor
    //$statement->closeCursor();

    //cost of transaction & cash balance vars
    $cashBalance = $userBalance['cash_balance'];
    $totalCost = $namePrices['price'] * $transaction->getQty();

    //check user balance and update it
    if ($cashBalance >= $totalCost) {

        //update query - user's balance after transaction
        $query5 = "UPDATE user SET cash_balance = ($cashBalance - $totalCost) WHERE id = :user_id";

        $statement = $stockDB->prepare($query5);
        $statement->bindValue(':user_id',$transaction->getUser_id());
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
        $statement->bindValue(':user_id',$transaction->getUser_id());
        $statement->bindValue(':stock_id',$transaction->getStock_id());
        $statement->bindValue(':qty',$transaction->getQty());
        //execute query
        $statement->execute();
        //close cursor
        $statement->closeCursor();

        $flag=1;
        
        return $yesFundsMsg;
            

    }

    else {
        //print a low balance message here
        $noFundsMsg = "Transaction cancelled. ".$userBalance['name']." does not have enough funds.<br><br>";
        $flag=0;
        
        return $noFundsMsg;
    }

    //we aren't returning anything to the html or php for an insert
    
}//end of insert transaction func

//write a function to update transactions
//what values were needed for this query?
//tested - works - wow
function upd_transaction($transaction) {
    
    global $stockDB;

    //match on a symbol in the update form
    $query = "UPDATE transaction SET user_id = :user_id, stock_id = :stock_id, qty = :qty WHERE id = :id";

    $statement = $stockDB->prepare($query);
    //sanitize
    $statement->bindValue(':id',$transaction->getID());
    $statement->bindValue(':user_id',$transaction->getUser_id());
    $statement->bindValue(':stock_id',$transaction->getStock_id());
    $statement->bindValue(':qty',$transaction->getQty());

    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();

    //we aren't returning anything to the html or php for an update
    
}//end of update user func

//write a function to delete transaction
//what values were needed for this query?
//THIS FUNCTION IS WORKING!!!
function del_transaction($transaction) {
    
    global $stockDB;
    global $deleteMsg;
    global $confirmDelete;

//get the qty of stock from the record to be deleted
    $query1 = "SELECT t.id, s.name, t.qty, s.price FROM transaction t INNER JOIN stocks s ON t.stock_id = s.id WHERE t.id = :id";

    $statement = $stockDB->prepare($query1);
    //sanitize
    $statement->bindValue(':id',$transaction->getId());

    //execute query
    $statement->execute();

    $qtySearch = $statement->fetch();

    //get the price of the stock
    $query2 = "SELECT s.id, s.name, s.price FROM stocks s INNER JOIN transaction t ON t.stock_id = s.id WHERE t.id = :id";

    $statement = $stockDB->prepare($query2);
    //sanitize
    $statement->bindValue(':id',$transaction->getId());
    //execute query
    $statement->execute();
    $priceSearch = $statement->fetch();

    //calculate return aka a sale of the stock
    $sellPrice = $qtySearch['qty'] * $priceSearch['price'];

    //get the user's balance
    $query3 = "SELECT u.id, u.name, u.cash_balance FROM user u INNER JOIN transaction t ON t.user_id = u.id WHERE t.id = :id";

    $statement = $stockDB->prepare($query3);
    //sanitize
    $statement->bindValue(':id',$transaction->getId());
    //execute query
    $statement->execute();
    $cashSearch = $statement->fetch();

    $newBalance = $cashSearch['cash_balance'] + $sellPrice;

    $deleteMsg = $cashSearch['name']." 's cash balance will be updated from $".number_format($cashSearch['cash_balance'],2)." to $".number_format($newBalance,2)."<br><br>";

    //update user's cash_balance by the total ^
    $query4 = "UPDATE user SET cash_balance = $newBalance WHERE id = (SELECT u.id FROM user u INNER JOIN transaction t ON t.user_id=u.id WHERE t.id= :id)";

    $statement = $stockDB->prepare($query4);
    //sanitize
    $statement->bindValue(':id',$transaction->getId());
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
    $statement->bindValue(':id',$transaction->getId());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();

    $confirmDelete = number_format($qtySearch['qty'],2)." shares of ".$priceSearch['name']." stocks will be sold at $". number_format($priceSearch['price'],2)." per share.<p>The total of the deleted transaction = $".$sellPrice."<br><br><p>";

}//end of del transaction func