<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; background-repeat: no-repeat;
    background-size: 100%;}
        .wrapper{ width: 360px; padding: 20px;border:solid black;border-width:thin;border-radius:0px; background-attachment:fixed; background-image: url('data:image/jpeg;base64,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') }
    </style>
</head>
<body background = "https://images.pexels.com/photos/1765005/pexels-photo-1765005.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
    <center>
    </br>
</br>
</br>
</br>
</br>
</br>
</br>

    <div class="wrapper">
        <h2 style="text-align:left;">Reset Password</h2>
        <p style="text-align:left;">Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group" style="text-align:left;">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group" style="text-align:left;">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div> 
</center>   
</body>
</html>