<!DOCTYPE html>
<!--
Fatima Mohammed
CIS2454 SU-23
Project 0
-->


<?php
    //get the data from the form
    $name= $_POST['name'];
    $grossIncome = $_POST['grossIncome'];
    $deds = $_POST['deds'];
    
    //standard deduction calc
    if ($deds < 12950) {
        $deds = 12950;
    }
    

    //declare variables here
    $taxBracket;
    $taxDue = 0;
    $tax10 = 0;
    $tax12 = 0;
    $tax22 = 0;
    $tax24 = 0;
    $tax32 = 0;
    $tax35 = 0;
    $tax37 = 0;

    $agi = $grossIncome - $deds; 
   
    
    //validate the form
    //this is in the php below
    if (!is_numeric($deds)) {
        $errorMsg = 'Must be a number!';
    }
    
  if ($agi >= 0 && $agi <= 10275 ){
    $tax10 = $agi * .1;
    
  }
  elseif ($agi >= 10275 && $agi <= 41775){
    $tax12 = ($agi - 10275) * .12;
    $tax10 = 1027.50;
  }
  elseif($agi >= 41776 && $agi <= 89075){
    $tax22 = ($agi - 41777) * .22;
    $tax10 = 1027.5;
    $tax12 = 3780;
  }
  elseif($agi >= 89076 && $agi <= 170050){
    $tax24 = ($agi - 89075) * .24;
    $tax10 = 1027.5;
    $tax12 = 3780;
    $tax22 = 10406;
  }
  elseif($agi >= 170051 && $agi <= 215950){
    $tax24 = ($agi - 170050) * .32;
    $tax10 = 1027.5;
    $tax12 = 3780;
    $tax22 = 10406;
    $tax24 = 19434;
  }
  elseif($agi >= 215951 && $agi <= 539900){
    $tax35 = ($agi - 215951) * .35;
    $tax10 = 1027.5;
    $tax12 = 3780;
    $tax22 = 10406;
    $tax24 = 19434;
    $tax32 = 14688;
  }
  elseif($agi >= 539901){
    $tax37 = ($agi - 539901) * .37;
    $tax10 = 1027.5;
    $tax12 = 3780;
    $tax22 = 10406;
    $tax24 = 19434;
    $tax32 = 14688;
    $tax35 = 113382.5;
  }
    
    $sumTaxes = $tax10 + $tax12 + $tax22 + $tax24 + $tax32 + $tax35 + $tax37;

    
    if(isset($_POST['submit'])) {
        if (empty($_POST["name"])) {
            $nameError = "Name is required";
        }
        
    }
        
    //format the vars
    $grossIncome_f = '$'.number_format($grossIncome,2);
    $agi_f = '$'.number_format($agi,2);
    $deds_f = '$'.number_format($deds,2);
    $tax10_f = '$'.number_format($tax10,2);
    $tax12_f = '$'.number_format($tax12,2);
    $tax22_f = '$'.number_format($tax22,2);
    $tax24_f = '$'.number_format($tax24,2);
    $tax32_f = '$'.number_format($tax32,2);
    $tax35_f = '$'.number_format($tax35,2);
    $tax37_f = '$'.number_format($tax37,2);
    $sumTaxes_f = '$'.number_format($sumTaxes,2);
    
    //more validation
    
    /*
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
        }

        if (empty($_POST["grossIncome"])) {
            $giErr = "Gross Income is required";
        } 
        else {
            $grossIncome = test_input($_POST["grossIncome"]);
        }

        if (empty($_POST["deds"])) {
            $dedsErr = "Deductions are required";
        } 
        else {
            $deds = test_input($_POST["deds"]);
        }
    }*/

    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Fatima's Project 0</title>
        <link rel="stylesheet" href="scripts/style.css">
    </head>
    <body>
        <h1>Welcome to Fatima's Project 0</h1>
        
        <h2>Federal Income Tax Calculator</h2>
        
        <div id="text">
        </div>
        
        <form id="form" method="post"
              action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div id="userForm">
                <label>Enter your first name: </label>
                <input type="text" name="name" size="20" required/>
                    <?php 
                        if (empty($name)) {
                            $errorMsg = 'Must Enter Your Name!';
                        } 
                        echo $errorMsg;
                    ?><br><br>                    
                <label>Enter your gross income for 2022: </label>
                $ <input type="text" name="grossIncome" size="10"/> 
                    <?php 
                        if (!is_numeric($grossIncome_f)) {
                            $errorMsg = 'Must be a number!';
                        } 
                        echo $errorMsg;
                    ?><br><br>
                
                <label>Enter your total deductions for 2022: </label>
                $ <input type="text" name="deds" size="10"/>
                    <?php 
                        if (!is_numeric($deds_f)) {
                            $errorMsg = 'Must be a number!';
                        } 
                        echo $errorMsg;
                    ?><br><br>
            </div>

            <div id="button">
                <input id="btn" type="submit" name="submit" value="GET FEDERAL INCOME TAX"/> <br><br>
        </div>
            
        </form>
        
        <div id = "results">
            
            <p id="resultsHead"><?php echo "Federal Income Tax Calculator - ".htmlspecialchars($name) ?></p>
            
            <br><br>
            
            <?php echo "Gross Income: ".$grossIncome_f ?><br><br>
            <?php echo "Total Deductions: ".$deds_f ?><br><br>
            <?php echo "<b>Adusted Gross Income: ".$agi_f."</b>" ?><br><br>
            <?php echo "Taxes Owed @ 10% Bracket: ".$tax10_f ?><br><br>
            <?php echo "Taxes Owed @ 12% Bracket: ".$tax12_f ?><br><br>
            <?php echo "Taxes Owed @ 22% Bracket: ".$tax22_f ?><br><br>
            <?php echo "Taxes Owed @ 24% Bracket: ".$tax24_f ?><br><br>
            <?php echo "Taxes Owed @ 35% Bracket: ".$tax35_f ?><br><br>
            <?php echo "Taxes Owed @ 37% Bracket: ".$tax37_f ?><br><br>
            
            <?php echo "Total Taxes Owed: ".$sumTaxes_f ?><br><br>
            
            <?php echo "Taxes Owed as percentage of gross income: ".sprintf("%.2f%%",($sumTaxes/$grossIncome)*100) ?><br><br>
            <?php echo "Taxes Owed as percentage of adjusted gross income: ".sprintf("%.2f%%",($sumTaxes/$agi)*100) ?><br><br>
       
            
        </div>
    </body>
</html>
