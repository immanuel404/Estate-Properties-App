<?php 

// Include config file
require_once "config.php";

 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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

    <title>Sign Up</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <!-- CSS LINK -->
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

        <!-- SignUp Form -->
        <a href="../index.php"><h2><b>Estate Properties</b></h2></a>
        <h2>Sign Up</h2>
        
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
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <!-- Confirm Password -->
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <!-- Form Submit || Reset -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
    </div>


    <!-- SVG DESIGN -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319"><path fill="#3D5B6B" fill-opacity="1" d="M0,288L144,128L288,64L432,224L576,224L720,160L864,288L1008,288L1152,224L1296,32L1440,64L1440,320L1296,320L1152,320L1008,320L864,320L720,320L576,320L432,320L288,320L144,320L0,320Z"></path></svg>



    <!-- Footer Area -->
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