<?php
session_start();
// close session variables - validUser to false
session_unset();
session_destroy();

// close connection object - connections stay open until closed
// redirect back to the site home page

//$conn->close(); // close a database connection
header("Location: login.php");
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Document</title>
        <!--Jeremy Brannen-->
        <script>

        </script>
        <style>
            
        </style>
    </head>

    <body>

    <h1></h1>
    <h2></h2>

    


    </body>

</html>