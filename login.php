<?php
session_start(); // allows access to the application session
    
    $validUser = false;     // invalid user until signed on
    $errMsg = "";           // global error message variable

    // Condition runs once the form has been submitted
    if(isset($_POST['submit'])){
        //echo"form has been submitted";

        // Processing the login information against the database

        //  variables
        $loginName = $_POST['loginName'];
        $loginPW = $_POST['password'];
        

        try {
			// CONNECT to the database	
            require 'dbConnect.php';	
            
            // Create the SQL command string
            $sql = "SELECT event_user_name, ";
            $sql .= "event_user_password ";
            $sql .= "FROM event_user ";
            $sql .= "WHERE event_user_name=:userName ";
            $sql .= "AND event_user_password=:userPW";
            
            // PREPARE the SQL statement
            $stmt = $conn->prepare($sql);
             
            // BIND the values to the input parameters of the prepared statement
             $stmt->bindParam(':userName', $loginName);
             $stmt->bindParam(':userPW', $loginPW);		
            
            // EXECUTE the prepared statement
            $stmt->execute();	
            
            // PDO FETCHALL stores any valid rows in the $resultArray variable
            $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Store number of matched rows in variable
            $numRows = count($resultArray);
            
            /* Condition sets user session variable and valid user variable
                to true allowing the admin options to be displayed.  Else
                will display an error message and redisplay the form.
            */
            if($numRows == 1){
                // set a session variable
                $_SESSION['validUser'] = true;
                // valid user
                $validUser = true;   
            }else{
                $errMsg = "Invalid user name or password. Please try again.";
            }
        }
        
        catch(PDOException $e)
        {
            $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
            error_log($e->getMessage());			
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Login Page</title>
        <!--Jeremy Brannen
            13-2 Login Page Assignment-->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <script>

        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
            body{
                font-family: 'Open Sans', sans-serif;
            }
            a:hover{
                color: purple;
                text-decoration: none;
            }  
        </style>
    </head>

    <body>

        <h1 class="text-center">Event Sign On Page</h1>
        <h2 class="text-center">WDV341 Intro PHP</h2>

<?php
        /*
            If you have a valid user display this block 1
            else display block 2.
        */

        if($validUser){
?> 
        <div class= "jumbotron col-md-6 mx-auto border border-dark rounded-lg m-4 p-4" style="background-color:lightgray"><!-- Block 1 if you have a valid user display this -->
            <h3 class="text-center">Welcome to the Admin Area for Valid Users</h3>

            <p>You have the following option available as an administrator</p>

            <ol>
                <li><a href="eventForm.php">Input new events</a></li>
                <li>Delete events</li>
                <li>Select events to update</li>
                <li><a href="logout.php">Log off the admin system</a></li>
            </ol>
        </div>

<?php
        }else{
            echo "<h3 class='text-center text-danger'>$errMsg</h3>"
?>

        <div class= "jumbotron col-md-4 mx-auto border border-dark rounded-lg m-4 p-4" style="background-color:lightgray">   <!--Block 2 display this block when you link to this page -->
            <form method="post" action="login.php">

                <div class="form-group">
                    <label for="loginName">User Name </label>
                    <input type="text" class="form-control form-control-sm"name="loginName" id="loginName">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-sm"name="password" id="password">
                </div>

                <div class="text-center">
                    <input type="submit" class="bg-primary text-light rounded-sm" name="submit" value="Sign On">
                    <input type="reset">
                </div>

            </form>
        </div>
<?php                      
        }

?>
        <footer>

            <p class="text-center">
                <a target="_blank"href="https://github.com/jrbrannen/Login-Logout-Pages-PHP.git">GitHub Repo Link</a>    <!--  GitHub Repo Link -->
            </p>

            <p class="text-center">
                <a href="../wdv341.php">PHP Homework Page</a>    <!-- Homework page link -->
            </p>

            </footer>

    </body>

</html>
