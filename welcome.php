<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif;
            background-repeat: no-repeat;
    background-size: 100%;}
        button{padding : 25px}
        img{border-radius: 0px}
        .wrapper{height: 400px; width: 300px;padding: 10px;margin: 10px; display: inline-block;border-width:thin;border-radius: 25px;align:center; color:white;}
    </style>
</head>

<body background="https://images.pexels.com/photos/2914550/pexels-photo-2914550.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
    <div style="text-align: right; padding-right: 20px; padding-top:20px" class=button>
        <a href="reset-password.php" class="btn btn-primary">Reset Your Password</a>
        <a href="logout.php" class="btn btn-primary">Sign Out</a>
</div>
<h1 class="my-5" style="text-align:left; color:white; padding: 20px">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>  <br></b>Welcome to CAFE PALACE.</h1>
<br>

<h5 style="color:white; text-align:left; padding: 30px">Be it any occasion, we all love to eat pizza. Pizza is one of the most sought-after dishes of Italian cuisine and is one of the easy dishes. The sweetness of the luscious tomato sauce, the softness of crispy baked dough, a variety of toppings to choose from and to top it all, lots of cheese! - What's not to like?
Order yours now!</h5>
<b><h2 style="text-align:center; color:white; padding: 20px"> Today's Menu</b> </h2>
<center>
<form action="confirm.html" method="get">
<div class="wrapper">
    <img src="https://images.pexels.com/photos/1653877/pexels-photo-1653877.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" width="175px" height="150px" >
    <h3>Chicken Pizza</h3>
    <h3>Rs 150/-</h3>
    <h4>
    <input type="number" id="chickenpizza" name="chickenpizza" min="0" max="10">
</div>
<div class="wrapper">
    <img src="https://images.pexels.com/photos/365459/pexels-photo-365459.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" width="175px" height="150px" >
    <h3>Paneer Pizza</h3>
    <h3>Rs 130/-</h3>
    <h4>
    <input type="number" id="paneerpizza" name="paneerpizza" min="0" max="10">
</div>
<div class="wrapper">
    <img src="https://images.pexels.com/photos/1292294/pexels-photo-1292294.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" width="175px" height="150px" >
    <h3>Pepsi</h3>
    <h3>Rs 50/-</h3>
    <h4>
    <input type="number" id="pepsi" name="pepsi" min="0" max="10">
</div>
<div class="wrapper">
    <img src="https://images.pexels.com/photos/7550135/pexels-photo-7550135.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" width="175px" height="150px" >
    <h3>Choco Lava Cake</h3>
    <h3>Rs 85/-</h3>
    <h4>
    <input type="number" id="chocolavacake" name="chocolavacake" min="0" max="10">
</div>
<div>
    <input type="submit" class="btn btn-primary" value="Order">
</div>
</form>
</center>


    
</body>
</html>