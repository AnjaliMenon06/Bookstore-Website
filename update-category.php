<?php include('partials/menu.php');    
?>

<section class="admin-page">
    <div class="main-content"> 
        <div class='wrapper'>
            <h1>Update Category</h1>
            <br />
            <br />

            <?php
                //Check whether id is set or not
                if(isset($_GET['id']))
                {
                    //Get id and all other details
                    //echo "getting the data";
                    $id = $_GET['id'];
                    //Create an sql query to get all other details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id ";
                    //Execute the query
                    $res = mysqli_query($conn,$sql);
                    //Count the rows to check whether the id is valid or not
                    $count = mysqli_num_rows($res);
                    if($count==1)
                    {
                        //Get the details                    
                        $row = mysqli_fetch_assoc($res);
                        
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        
                    }

                    else
                    {
                        //Redirect to Manage Category page with session message
                        $_SESSION['no-category-found'] = "<div class='error text-center'>Category Not Found</div>";
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

            <form action="" method="POST" class="text-center" enctype="multipart/form-data">
                <table class="tbl-30">
                
                        <tr>
                            <td>Title : </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Current Image : </td>
                            <td>
                                <?php
                                    if($current_image != "")
                                    {
                                        //Display the image
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px" >
                                        <?php
                                    }

                                    else
                                    {
                                        //Display message
                                        echo "<div class='error text-center'> Image Not Added </div>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>New Image : </td>
                            <td>
                                <input type="file" name="image" >                                 
                            </td>
                        </tr>

                        <tr>
                            <td>Featured : </td>
                            <td>
                                <input
                                <?php
                                    if($featured =="Yes")
                                    {
                                        echo "checked";
                                    }                                
                                ?>
                                type="radio" name="featured" value="Yes"> Yes
                                <input
                                <?php
                                    if($featured =="No")
                                    {
                                        echo "checked";
                                    }                                
                                ?>
                                 type="radio" name="featured" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td>Active : </td>
                            <td>
                                <input
                                <?php
                                    if($active =="Yes")
                                    {
                                        echo "checked";
                                    }                                
                                ?>
                                type="radio" name="active" value="Yes"> Yes
                                <input
                                <?php
                                    if($active =="No")
                                    {
                                        echo "checked";
                                    }                                
                                ?>
                                type="radio" name="active" value="No"> No
                            </td>
                        </tr>

                        <tr>                    
                            <td>
                                <input type="hidden" name="current_image" value="<?php echo $current_image ; ?>" > 
                                <input type="hidden" name="id" value="<?php echo $id ; ?>" >    
                                <input type="submit" name="submit" value="Update Category" class="btn-primary">
                            </td>
                        </tr>
                </table>
            </form>   

            <?php
                if(isset($_POST['submit']))
                {
                    echo "Clicked";

                    // 1. Get all the values from our form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    // 2. Updating new image if selected
                    //Check whether the image is selected or not
                    if(isset($_FILES['image']['name']))
                    {
                        //Get the image details
                        $image_name = $_FILES['image']['name'];
                        //Check whether the image is available or not
                        if($image_name !="")
                        {
                            //Image is available
                            // A. Upload the new image
                                //Auto rename our image
                                //Get the extension of our image(jpg,jpeg,png....etc;)  eg: "book1.jpg"
                                $ext= end(explode('.', $image_name));// Break the name before and after '.' in the image name => book1 and jpg
                                                                 //end is used to get the pasrt at the end after '.'
                            
                                //Rename the image
                                $image_name = "Book_Category_".rand(000,999).'.'.$ext; //eg:Book_Category_454.jpg

                                $source_path = $_FILES['image']['tmp_name'];

                                $destination_path = "../images/category/".$image_name;

                                //Finally, upload the image
                                $upload = move_uploaded_file($source_path,$destination_path);

                                //Check whether the image is uploaded or not
                                //And if the image is not uploaded, we will stop and redirect with error message
                                if($upload==FALSE)
                                {
                                    //Send message
                                    $_SESSION['upload'] = "<div class='error text-center'>Failed to upload image</div>";
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';

                                    //Stop the process(if we fail to add the image, we dont want the data to be added to the database)
                                    die(); 
                                }
                            // B. Remove the current image if available
                            if($current_image !="")
                            {
                                $remove_path = "../images/category/".$current_image;
                                $remove = unlink($remove_path);

                                //Check whether the image is removed or not
                                //If failed to remove, then display message and stop the process
                                if($remove==FALSE)
                                {
                                    //Failed to remove the image
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                                    //Redirect to manage Category page                        
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
                                    die();

                                }
                            }
                            

                                
                        }
                        else
                        {
                            $image_name = $current_image;
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }

                    // 3. Update the Database
                    $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                        WHERE id= $id
                    ";
                    //Execute the query
                    $res2 = mysqli_query($conn,$sql2);

                    // 4. Redirect to Manage Category page
                    //Check whether the query is executed or not
                    if($res2==TRUE)
                    {
                        //Category updated suuccessfully
                        $_SESSION['update'] = "<div class='success text-center'>Category updated successfully.</div>";
                        //echo "yes";
                        //Redirect to Manage Category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';

                    }
                    else
                    {
                        //Failed to update category
                        $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
                        //Redirect to manage Category page                        
                        header('location:'.SITEURL.'admin/manage-category.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';
                        //echo "no";
                    }
                }
            ?> 

        </div>
    </div>
</section>

<?php include('partials/footer.php')?>