<?php

    //Include constants.php file here
    include('../config/constants.php');

    //1. Get the id of the admin to be deleted
    $id = $_GET['id'];

    //2. Create Sql Query to Delete Admin
    $sql = "DELETE FROM tbl_admin WHERE id= $id";

    //Execute the query
    $res = mysqli_query($conn,$sql);

    //Check whether the query is executed successfully or not
    if($res==TRUE)
    {
        //Query executed successully and the particular admin is deleted
        //echo "Admin Deleted";
        //Create session variable to display the message
        $_SESSION['delete'] = "<div class='success text-center'>Admin Deleted Successfully.</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
        echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
    }

    else
    {
        //Failed to execute query- failed to delete admin
        //echo "Failed to delete Admin";
        $_SESSION['delete'] = "<div class='error text-center'>Failed to delete Admin. Try again later.</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/delete-admin.php');
        echo '<script>window.location.href="'.SITEURL.'admin/delete-admin.php"</script>';
    }

    //3. Redirect to Manage Admin page with message(success/error)

?>