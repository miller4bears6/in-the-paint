<?php

//models/stockModel.php

//write a class to group the functions
//example was modeled after class lecture

ini_set('display_errors', 1);

class Stock {
    
    private $symbol, $name, $price, $id;
    
    public function __construct($symbol, $name, $price, $id) {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getId() {
        return $this->id;
    }

    public function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setId($id) {
        $this->id = $id;
    }

}//end of Stock class

//functions for stocks

//write a function to show a list of stocks
//add select query here from database.php from project 1
function show_stocks() {
    
    global $stockDB;
    
    //start of CRUD - READ - SELECT
    $query = "SELECT name,symbol,price,id FROM stocks";
    //$stocks = $stockDB->query($query);        

    $statement = $stockDB->prepare($query);
    //execute query
    $statement->execute();
    $stocks = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();

    //after adding a class...
    //give me an array of stocks
    $stocks_array = array(); //no stocks yet
    
    foreach ($stocks as $stock) {
        //create a new instance of Stock and populate array
        $stocks_array[] = new Stock($stock['symbol'], $stock['name'], $stock['price'], $stock['id']);
        //creates an array of objects
    }//end of set up a new stock object
    
    return $stocks_array;
    
}//end of show stocks func

//write a function to insert stocks
//what values were needed for this query? - symbol, name, price
//pass in the stock object here instead of parameters
function add_stock($stock) {
    
    global $stockDB;
    
    //use substitution to insert values via a query
    //do not directly add content to the fields - sql injection
    $query = "INSERT INTO stocks (symbol, name, price) VALUES (:symbol,:name,:price)";

    $statement = $stockDB->prepare($query);
    //sanitize, value bind in PDO to protect against SQL injection
    $statement->bindValue(':symbol',$stock->getSymbol());
    $statement->bindValue(':price',$stock->getPrice());
    $statement->bindValue(':name',$stock->getName());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();
    
    //we aren't returning anything to the html or php for an insert
    
}//end of insert stocks func

//write a function to update stocks
//what values were needed for this query? - symbol, price, name
function upd_stock($stock) {
    
    global $stockDB;
    
    //match on a symbol in the update form
    $query = "UPDATE stocks SET name = :name, price = :price WHERE symbol = :symbol";

    $statement = $stockDB->prepare($query);
    //sanitize
    $statement->bindValue(':symbol',$stock->getSymbol());
    $statement->bindValue(':price',$stock->getPrice());
    $statement->bindValue(':name',$stock->getName());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();

    //we aren't returning anything to the html or php for an insert
    
}//end of update stocks func

//write a function to delete stocks
//what values were needed for this query? - symbol
function del_stock($stock) {
    
    global $stockDB;
    
    $query2 = "DELETE FROM stocks WHERE symbol = :symbol";

    $statement = $stockDB->prepare($query2);
    //sanitize
    $statement->bindValue(':symbol',$stock->getSymbol());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor(); 
}//end of del stocks func