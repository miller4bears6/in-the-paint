<!--
Fatima Mohammed
CIS2454 SU-23
Final Project
-->

<html>
    <head>
        <title>Fatima's Final Project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include ('headerLoggedIn.php'); ?>
    </head>
        
    <body>
        
        <h1>Welcome to TwitterClone!</h1><br>
        <h2>Log in or Sign Up!</h2>
        <br><br>


<!--content for the login page-->

        <div class="row">
            <div class="column1">
                <form id ="login" method="post" action="login.php">
                    <label>eMail: </label>
                    <input type="text" name="email" size='35'><br><br>
                    <label>password: </label>
                    <input type="password" name="pw" type="password" size='30'><br><br>
                    <input type="submit" id="btn_add"  name="submit" value="Log in"/><br>
                </form>
            </div>
            
            <div class="column2">
                <form id ="registerForm" method="post" action="createAcct.php">
                    <label>First Name: </label>
                    <input name = "name" size='27'><br><br>
                    <label>eMail: </label>
                    <input name = "email" size='35'><br><br>
                    <label>password: </label>
                    <input name = "pw" size='30'><br><br>

                    <input type="submit" id="btn_add" name = "newAcct" value="Sign up"/><br>
                </form>                    
            </div>
        </div>   
    </body>
    <?php include ('footer.php'); ?>

</html>