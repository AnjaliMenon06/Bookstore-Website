<?php include('partials-front/menu.php')?>

<?php
    //Check whether id is pased or not
    if(isset($_GET['user_id']))
    {
        //Category id is set. Get the id
        $user_id = $_GET['user_id'];
        //Get the category title based on category id
        $sql = "SELECT user_email From tbl_users WHERE user_id=$user_id";
        $res = mysqli_query($conn,$sql);
        //Get the value from database
        $row = mysqli_fetch_assoc($res);
        //Get the email
        $user_email = $row['email'];
    }
    else
    {
        //user id not passed. redirect to home page
        header('location:'.SITEURL);
        echo '<script>window.location.href='.SITEURL;
    }
?>


<!-- Main Content Section starts-->
<section class="categories">
    <div class="container">
        <div class="wrapper">
                
        <h1 class="text-center text-white" style="font-size: 40px;">My Cart</h1>
            <br />
            <br />


        </div>   
    </div>     
</section>    