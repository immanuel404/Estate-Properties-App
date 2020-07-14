<?php

// Initialize the session
session_start();

 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: ../index.php?status=_You_are_already_logged_in");
  exit;
}

 
// Include config file
require_once "config.php";

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <!-- CSS Links -->
    <link href="css/login.css" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" href="../img/favi.png" sizes="16x16" type="image/png">
</head>
<body>

    <!-- Hook Area -->
    <div class="hook">
        <p>Looking to buy or sell? You are at the right place.</p>
        <p id="remove">Real Estate || Property sales || Property Rentals</p>
        <p id="remove">Helpdesk: web4citizen@gmail.com</p>
    </div>

    <!-- Section One -->
    <div class="container">
    <div class="wrapper">

        <!-- Login Form -->
        <a href="../index.php"><h2><b>Estate Properties</b></h2></a>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!-- Company Name -->
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Company Name</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>"onkeyup="lettersOnly(this)">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    

            <!-- Password -->
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <!-- Submit -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>

    </div>
    </div>


    <!-- SVG WAVY DESIGN -->
     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319"><path fill="#3D5B6B" fill-opacity="1" d="M0,0L24,5.3C48,11,96,21,144,64C192,107,240,181,288,213.3C336,245,384,235,432,197.3C480,160,528,96,576,96C624,96,672,160,720,176C768,192,816,160,864,149.3C912,139,960,149,1008,170.7C1056,192,1104,224,1152,213.3C1200,203,1248,149,1296,138.7C1344,128,1392,160,1416,176L1440,192L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z"></path></svg>


    <!-- FOOTER -->
    <div class="footer">        
        <div class="webName">
            <!--  COMPANY/WEBSITE NAME -->
            <p>&copy;<a href="http://webcitizen.epizy.com/">Estate Properties <span>2020<span></a></p>
        </div>
    </div>


<!-- JS FUNCTION_VALIDATES USER CHARACTER INPUT -->
<script> 
function lettersOnly(input) {
    var regex = /[^a-z 0-9.,]/gi;
    input.value = input.value.replace(regex, "");
}
</script>

</body>
</html>