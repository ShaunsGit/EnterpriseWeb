<?php
session_start();
?>

    <?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml11.dtd" >
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb">

    <head></head>

    <body><?php 
        if($_SESSION['loggedIn'] == true)
        {
            session_unset();
            header("location: Home.php");
        }else 
        {
              header("location: Home.php");
        }?></body>

    </html>
