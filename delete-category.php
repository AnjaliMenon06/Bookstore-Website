<?php
       //Include Constants file
    include('../config/constants.php') ;

    //echo "Delete Page";
    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and delete
        //echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file, if available
        if($image_name !="") //If image name is not blank, i.e, we have the image, then remove it
        {
            //Image is available.Remove it
            $path = "../images/category/".$image_name;

            //Remove the image
            $remove = unlink($path); //This variable has boolean value
                                     //If we remove image, then true; else, false
            //If we fail to remove the image, then add an error message and stop the process
            if($remove==FALSE)
            {
                //Set the session message 
                $_SESSION['remove'] = "<div class='error text-center'>Failed to remove category image.</div>";        
        
                //redirect to manage category page with message
                header('location:'.SITEURL.'admin/manage-category.php');
                echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
                
                //Stop the process
                die();
            }                         
        }

        //Delete the data from the database
        //SQL query to delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        
        //Execute the query
        $res = mysqli_query($conn,$sql);

        //Check whether the data is deleted from database or not
        if($res==TRUE)
        {
            //Send success message and redirect
            $_SESSION['delete'] = "<div class='success text-center'>Category deleted successfully.</div>"; 
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
        }

        else
        {
            //Send fail message and redirect
            $_SESSION['delete'] = "<div class='error text-center'>Failed to delete category</div>"; 
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
        }

        
    }

    else
    {
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
        echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
    }
?>