<?php

//models/userModel.php

//write a class to group the functions
//example was modeled after class lecture

ini_set('display_errors', 1);

class User {

    private $name, $email, $cash_balance, $id;
    
    public function __construct($name, $email, $cash_balance, $id) {
        $this->name = $name;
        $this->email = $email;
        $this->cash_balance = $cash_balance;
        $this->id = $id;
    }

    public function getName() {
    return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }
    public function getCash_balance() {
        return $this->cash_balance;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setId($id){
        $this->id = $id;
    }
    
    public function setCash_balance($cash_balance) {
        $this->cash_balance = $cash_balance;
    }


}//end of user class

function show_users() {
    
    global $stockDB;
    
    //start of CRUD - READ - SELECT
    $query = "SELECT name,email,cash_balance,id FROM user";
    //$stocks = $stockDB->query($query);        

    $statement = $stockDB->prepare($query);
    //execute query
    $statement->execute();
    $users = $statement->fetchAll();
    //close cursor
    $statement->closeCursor();
    //end CRUD - READ - SELECT
    
    //after adding a class...
    //give me an array of stocks
    $user_array = array(); //no users yet
    
    foreach ($users as $user) {
        //create a new instance of Stock and populate array
        $user_array[] = new User($user['name'], $user['email'], $user['cash_balance'], $user['id']);
        //creates an array of objects
    }//end of set up a new user object
    
    return $user_array;
        
}//end of show user func

//write a function to insert user
//what values were needed for this query? - symbol, name, price
function add_user($user){
    
    global $stockDB;
    
    //use substitution to insert values via a query
    //do not directly add content to the fields - sql injection
    $query = "INSERT INTO user (name, email, cash_balance) VALUES (:name,:email,:balance)";

    $statement = $stockDB->prepare($query);
    //sanitize, value bind in PDO to protect against SQL injection
    $statement->bindValue(':name',$user->getName());
    $statement->bindValue(':email',$user->getEmail());
    $statement->bindValue(':balance',$user->getCash_balance());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();
    
    //we aren't returning anything to the html or php for an insert
    
}//end of insert user func

//write a function to update user
//what values were needed for this query? - symbol, price, name
function upd_user($user) {
    
    global $stockDB;
    
    //match on a symbol in the update form
    $query = "UPDATE user SET name = :name, email = :email, cash_balance = :balance WHERE id = :id";

    $statement = $stockDB->prepare($query);
    //sanitize
    $statement->bindValue(':name',$user->getName());
    $statement->bindValue(':email',$user->getEmail());
    $statement->bindValue(':balance',$user->getCash_balance());
    $statement->bindValue(':id',$user->getId());
    //execute query
    $statement->execute();
    //close cursor
    $statement->closeCursor();

    //we aren't returning anything to the html or php for an update
    
}//end of update user func

//write a function to delete user
//what values were needed for this query? - symbol
function del_user($user) {
    
    global $stockDB;
    
    $query2 = "DELETE FROM user WHERE id = :id";

    $statement = $stockDB->prepare($query2);
    //sanitize
    $statement->bindValue(':id',$user->getId());

    //execute query
    $statement->execute();

    //close cursor
    $statement->closeCursor();
}//end of del user func