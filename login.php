<?php include('../config/constants.php');
?>
<html>
    <head>
        <title>Login - Bookstore Website</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <section class="admin-page">
            <div class="login">
                <br>
                <h1 class="text-center">Login</h1>
                <br>
                <?php 

                    if(isset($_SESSION['no-login-message']))
                    {
                        echo $_SESSION['no-login-message']; //Displaying session message: Please Log in to access Admin Panel
                        unset($_SESSION['no-login-message']); // Removing session message
                    }

                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login']; //Displaying session message: Login successfull
                        unset($_SESSION['login']); // Removing session message
                    }

                    
                ?>

                <br>
                
                <br>

                <!--Login Form starts here-->
                <form action="" method="POST" class="text-center">
                    Username: <br>
                    <input type="text" name="username" placeholder="Enter Your Username" class="input-responsive" required>
                    <br>
                    <br>
                    Password: <br>
                    <input type="password" name="password" placeholder="Enter Your Password" class="input-responsive" required>
                    <br>
                    <br>
                    <input type="submit" name="submit" value="Login" class="btn btn-login">
                    <br>
                    <br>
                    <br>
                    <br>
                  
                </form>
                <!--Login Form ends here-->


                <p class="text-center">Created By : <a href="US.html" class="btn btn-primary">Bookberries Official</a></p>
                <br>
            </div>
        </section>    
    </body>

</html>

<?php 

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Process the login
        // 1. Get data from login
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 2. SQL Query to check whether the user with the given username and password exist or not
        $sql= "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the SQL query
        $res = mysqli_query($conn,$sql);

        // 4. Count rows to check whether the user exist or not
        $count = mysqli_num_rows($res);

        //if count==1: user exist.  If count==0: user does not exist
        if($count == 1)
        {
            //There exists a user with the given credentials .Send message: Login successfull
            $_SESSION['login'] = "<div class='success text-center'>Login Successful . Welcome $username</div>";

            //Redirect to Home page (Dashboard)
            header('location:'.SITEURL.'admin/index.php');
            echo '<script>window.location.href="'.SITEURL.'admin/index.php"</script>';
        }

        else
        {
            //User not avalible. Send message: Login failed
            $_SESSION['login'] = "<div class='error text-center'>Login Failed <br>Username or Password did not match  </div>";
            $user = $_GET['user'];
            $_SESSION['user'] = $username ; //To check whether the user is logged in or not and logout will unset it
                //This username value will only be unset when the user logs out
            //Redirect to Home page (Dashboard)
            header('location:'.SITEURL.'admin/login.php');
            echo '<script>window.location.href="'.SITEURL.'admin/login.php"</script>';
        }
    }

?>