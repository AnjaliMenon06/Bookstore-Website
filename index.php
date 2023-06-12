<!DOCTYPE html>
<?php include('config/constants.php'); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<?php
    if(isset($_SESSION['logout']))
    {
        echo $_SESSION['logout']; //Displaying session message: Login Successfull
        unset($_SESSION['logout']); // Removing session message
    }
?>

<body>    



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Welcome To Bookberries Official...!!<br>Login To Continue</h2>

            <a href="<?php echo SITEURL; ?>admin/login.php">
            <div class="box-3 float-container">
                <img src="images/ad.jpg" alt="Admin" class="img-responsive img-curve">

                <h3 class="float-text text-col">Admin</h3>
            </div>
            </a>

            
            <div class="box-3 float-container">
                <img src="images/logo.jpeg" alt="Logo" class="img-responsive img-curve">

                <h3 class="float-text text-color"></h3>
            </div>
            
            

            <a href="<?php echo SITEURL; ?>cust-login/cust-login-test.php">
            <div class="box-3 float-container">
                <img src="images/cus.png" alt="Customer" class="img-responsive img-curve">

                <h3 class="float-text text-col">Customer</h3>
            </div>
            </a>

            

            
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


  

</body>
</html>