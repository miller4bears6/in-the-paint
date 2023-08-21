<!DOCTYPE html>

<?php
    //$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

    if (isset($_POST['submit'])) {
        echo "Following :)";
    }//end of follow action query
?>

<table>
    <tr>
        <td>
            <?php echo $user['pic-code'];
            echo $user['picture'];?><br><br>
        </td>
        <td width = 120px><!--empty space--></td>
        <td id = "follow-box">
            <form method="post" action="view/feedView.php">
                <input type="image" id="btn_follow" src="scripts/images/button-follow.png" name="submit">
            </form>

        </td>
        <td id = "follow-box" style="height:20px"> - # of Followers - </td>
    </tr>
    <tr id = "details">
        <td>
            <?php echo $user['name']; ?> <br><?php echo $user['email']; ?></td>
        <hr>
    </tr>
</table>