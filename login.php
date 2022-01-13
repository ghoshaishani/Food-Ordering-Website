<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
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
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; background-repeat: no-repeat; background-size: 100%;}
        .wrapper{ width: 350px; padding: 20px;border:solid black;border-width:thin;border-radius: 0px ;background-image: url('data:image/jpeg;base64,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')}
    </style>
</head>
<body background="https://images.pexels.com/photos/1565982/pexels-photo-1565982.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
    <center>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
    <div class="wrapper">
        <h2 style="text-align:left;">Login</h2>
        <p style="text-align:left;">Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group" style="text-align:left;">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group" style="text-align:left;">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
    </center>
</body>
</html>