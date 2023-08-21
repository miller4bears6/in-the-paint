<!--
Fatima Mohammed
CIS2454 SU-23
Project 2 - mvc code

https://github.com/Oakland-Community-College/cis2454-summer2023-project1-miller4bears6

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fatima's Project 2 - Login Page</title>
        <link rel="stylesheet" href="scripts/style.css">

    </head>
    
    <?php include ('topNav.php'); ?>
    
    <body>
        
        <h1>Welcome to Fatima's Project 2</h1>
        
        <h2>Stock Application with a Database - MVC - Login Page</h2>
        
        <p>Log In Below:</p>
        <?php echo "<br><br>".$loginMsg; ?>

        <form id="login" method="post" action ="loginController.php">
            <div id="loginForm">
                <label>eMail: </label>
                <input type="text" name="email" size="30" /><br><br>             
                <label>Password: </label>
                <input type="password" name="pw" size="30" /><br><br>            
            </div>
            <div id="button">
                <input id="btn_login" type="submit" name="submit" value="LOG IN"/> <br><br>
            </div>
            
        </form>        
        
        
    </body>
    
    <?php include ('footer.php'); ?>
</html>
