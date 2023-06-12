<?php

    //Include Constants file
    include('../config/constants.php') ;

    //echo "Delete BOOK PAGE";
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to delete option
        //echo "Process to delete";
        //Get the value and delete

        //echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file, if available
        if($image_name !="") //If image name is not blank, i.e, we have the image, then remove it
        {
            //Image is available.Remove it
            $path = "../images/book/".$image_name;

            //Remove the image
            $remove = unlink($path); //This variable has boolean value
                                     //If we remove image, then true; else, false
            //If we fail to remove the image, then add an error message and stop the process
            if($remove==FALSE)
            {
                //Set the session message 
                $_SESSION['upload'] = "<div class='error text-center'>Failed to remove the book image file.</div>";        
        
                //redirect to manage category page with message
                header('location:'.SITEURL.'admin/manage-book.php');
                echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
                
                //Stop the process
                die();
            }                         
        }

        //Delete the data from the database
        //SQL query to delete data from database
        $sql = "DELETE FROM tbl_book WHERE id=$id";
        
        //Execute the query
        $res = mysqli_query($conn,$sql);

        //Check whether the data is deleted from database or not
        if($res==TRUE)
        {
            //Send success message and redirect
            $_SESSION['delete'] = "<div class='success text-center'>Book deleted successfully.</div>"; 
            //Redirect to manage category page
            header('location:'.SITEURL.'admin/manage-book.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
        }

        else
        {
            //Send fail message and redirect
            $_SESSION['delete'] = "<div class='error text-center'>Failed to delete book</div>"; 
            //Redirect to manage book page
            header('location:'.SITEURL.'admin/manage-book.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
        }
    }
    else
    {
        //Redirect to manage book page with message
        //echo "redirect";
        $_SESSION['unauthorize'] = "<div class='error text-center'> Unauthorized access</div>"; 
        header('location:'.SITEURL.'admin/manage-book.php');
        echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
    }

?>