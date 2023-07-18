<!--
Fatima Mohammed
CIS2454 SU-23
Lab 7
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Fatima's Lab 7</title>
        <link rel="stylesheet" href="scripts/style.css">
    </head>
    <body>
        <h1>Welcome to Fatima's Lab 7</h1>
        
        <h2>Form that submits to a servlet</h2>

        <form id=hairApptForm method="post" action ="index.php">
            <u>Set Up Your Hair Consultation Here</u>:<br><br><br>
                
                <label>Your Name:</label>
                <input type="text" name="name" size="30"/><br><br>
                <label>eMail:</label>
                <input type="text" name="email" size="30"/><br><br>
                <label>Date Desired:</label>
                <input type="date" name="date"><br><br>
                
                Services:<br><br>
                
                <input type = "checkbox" name="services[]" value ="haircut" /> <label>Haircut</label> <br>
                <input type = "checkbox" name="services[]" value ="color" /> <label>Color</label> <br>
                <input type = "checkbox" name="services[]" value ="highlights" /> <label>Highlights</label> <br>
                <input type = "checkbox" name="services[]" value ="gloss" /> <label>Gloss</label> <br>
                <input type = "checkbox" name="services[]" value ="updo" /> <label>Formal Event Hair</label> <br>
            <br><br>

            <input id="btn_add" type="submit" name="submit" value="Get your Consultation Appt!!"/>
        </form><br><br><br><br>
        <hr>

        <div id = "results">
            
        </div> 
    </body>
</html>
