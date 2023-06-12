<html>
    <head>
        <title>Login - Bookstore Website</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

        <body>
        <section class="admin-page">
            <?php 
                //Include constants.php for SITEURL
                include('../config/constants.php');
                // 1.Destroy the session
                session_destroy();

                // 2.Redirect to Login page
                header('location:'.SITEURL.'admin/login.php');
                echo '<script>window.location.href="'.SITEURL.'admin/login.php"</script>';
            ?>
        </section>    
        </body>

</html>        
