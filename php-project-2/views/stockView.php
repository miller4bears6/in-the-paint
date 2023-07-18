<!DOCTYPE html>
<!--

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Stocks List - MVC and Classes</title>
        <link rel="stylesheet" href="scripts/style.css">
    </head>
    
    <?php include ('topNav.php'); ?>
    
    <body>
        <h1>Welcome to Fatima's Project 2</h1>
        
        <h2>Stock Application with a Database - Stock MVC and Class </h2>

        <!--select operation-->
        
        <p>SELECT from Stocks Table:</p>
        
        <table>
            <tr>
                <th>Name</th>
                <th>Symbol</th>
                <th>Price</th>
                <th>ID</th>
            </tr>

            <?php foreach ($stocks as $stock) : ?>
            <tr>
                <td><?php echo $stock->getName(); ?></td> 
                <td><?php echo $stock->getSymbol(); ?></td>
                <td><?php echo '$'.$stock->getPrice(); ?></td>
                <td><?php echo $stock->getId(); ?></td>
            </tr>

            <?php endforeach; ?>          
            
        </table><br>
        <hr>
        
        <!--insert operation-->
        <!--add a form to input data-->
        <!--update the form action to stock controller file -->
        <p>INSERT to Stocks Table:</p>

        <form id="insert_form" method="post" action ="stockController.php">
              
            <div id="userForm1">
                <label>Symbol: </label>
                <input type="text" name="symbol" size="10" /><br><br>             
                <label>Name: </label>
                <input type="text" name="name" size="30" /><br><br>            
                <label>Market Price: </label>
                $ <input type="text" name="price" size="10" /><br><br>
                <input type="hidden" name='action' value='insert' />
            </div>
            <div id="button">
                <input id="btn_add" type="submit" name="submit" value="ADD"/> <br><br>
            </div>
            
        </form>
        
        <hr>
        
        <p>UPDATE Stocks Table:</p>

        <form id="update_form" method="post" action ="stockController.php">
              
            <div id="userForm2">
                <label>Symbol: </label>
                <input type="text" name="symbol" size="10" /><br><br>             
                <label>Name: </label>
                <input type="text" name="name" size="30" /><br><br>            
                <label>Market Price: </label>
                $ <input type="text" name="price" size="10" /><br><br>
                <input type="hidden" name='action' value='update' />
            </div>
            <div id="button2">
                <input id="btn_upd" type="submit"  value="UPDATE"/> <br><br>
            </div>
            
        </form>
        
        <hr>
        
        <p>DELETE From The Stocks Table:</p>

        <form id="delete_form" method="post" action ="stockController.php">
              
            <div id="userForm3">
                <label>Symbol: </label>
                <input type="text" name="symbol" size="10" required/><br><br>
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

    <?php include ('footer.php'); ?>
    
</html>
