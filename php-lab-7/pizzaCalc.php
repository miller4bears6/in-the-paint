<?php
/* 
Fatima Mohammed
CIS2454 SU-23
Lab 4
*/

//bring the form data in to the php logic
$total = 0;
$count = 0;
$topCharge = 0;
$pizza = 0;

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));
//toppings - check boxes
$toppings = $_POST['top'];//array
//story checkboxes as an array element
$top1 = $toppings[0];
$top2 = $toppings[1];
$top3 = $toppings[2];
$top4 = $toppings[3];
$top5 = $toppings[4];
$top6 = $toppings[5];
$top7 = $toppings[6];
$top8 = $toppings[7];

//if submit button pressed, then run this code
if  (isset($_POST['action'])) {

    //size of pizza - radio buttons
    if (isset($_POST['size'])) {
        $size = $_POST['size'];
        if ($size == "small") {
            $pizza = 5;
            $topCharge = .5;
            echo "--- Size ---<br>Small Pizza -- $".number_format($pizza, 2)."<br><br>";
        }
        if ($size == 'med') {
            $pizza = 7;
            $topCharge = 1.0;
            echo "--- Size ---<br>Medium Pizza -- $".number_format($pizza, 2)."<br><br>";
        }
        if ($size == 'large') {
            $pizza = 9;
            $topCharge = 1.5;
            echo "--- Size ---<br>Large Pizza -- $".number_format($pizza, 2)."<br><br>";
        }
    }//end of size of pizza and charges per size
    //if size not selected then...
    else {
        $size = "none";
        $errorMsgSize = "You didn't pick a pizza size?!?<br><br>";
        echo $errorMsgSize;
    }//end of no size selected

    //toppings were picked
    //loop thru toppings array
    if (isset($_POST['top'])) {
        $toppings = $_POST['top'];
        echo "---- Toppings ---- <br>";
        foreach ($toppings as $key => $value) {
            echo $value." <br>";
            $count++;//end counter when loop ends
        }
        
        //calc the bill here
        echo "<br>".$count." toppings - $".number_format($topCharge*$count, 2);
        $total = $pizza + ($count * $topCharge);
        echo "<b><br><br>$".number_format($total, 2)." is your bill.<br></b>";

    }//end of size and toppings picked logic

    //no toppings
    if (!isset($_POST['top'])) {
            $errorMsgTop = "No toppings?!?<br><br>";
            echo $errorMsgTop;
    }//no calcs done
    
}//end of submit button action code for Pizza Order Form


