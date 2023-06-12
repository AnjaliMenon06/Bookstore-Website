<?php include('partials/menu.php');?>

<section class="admin-page">
    <div class="main-content"> 
        <div class='wrapper'>
            <h1>Update Book</h1>
            <br />
            <br />

            <?php

                if(isset($_GET['id']))
                {
                    //Get all the details
                    $id = $_GET['id'];
                    //echo "getting the data";
                    //Create an sql query to get all other details
                    $sql = "SELECT * FROM tbl_book WHERE id=$id ";
                    //Execute the query
                    $res = mysqli_query($conn,$sql);

                    //Get the value based on query executed
                    $row = mysqli_fetch_assoc($res);

                    //Get the individual values of selected food
                    $title = $row['title'];
                    $about = $row['about'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $current_category = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //Redirect to manage book page
                    $_SESSION['no-book-found'] = "<div class='error text-center'>Book Not Found</div>";
                    header('location:'.SITEURL.'admin/manage-book.php');
                    echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
                }


            ?>

            <form action="" method="POST" class="text-center" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title : </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="title gor=es here">
                        </td>
                    </tr>

                    <tr>
                        <td>About: </td>
                        <td>
                            <textarea name="about" cols="30" rows="5" ><?php echo $about; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price : </td>
                        <td>
                            <input type="number" name="price" value="<?php echo $price; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image : </td>
                        <td>
                            <?php
                                if($current_image == "")
                                {
                                    //Display message
                                    echo "<div class='error text-center'> Image Not Available </div>";
                                }

                                else
                                {
                                    
                                    //Display the image
                                    ?>
                                    <img src="<?php echo SITEURL;?>images/book/<?php echo $current_image;?>" width="150px" >
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image : </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category : </td>
                        <td>
                            <select name="category">

                                <?php
                                    //Create php code to display categories from database
                                    // 1. Create sql query to get all active categories from database
                                    $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    
                                    //Execute the query
                                    $res2 = mysqli_query($conn,$sql2);

                                    //Count Rows to check whether we have categories or not
                                    $count = mysqli_num_rows($res2);

                                    //If count is greater than 0, we have categories; else, we dont
                                    if($count>0)
                                    {
                                        //We have categories    
                                        while($row=mysqli_fetch_assoc($res2))
                                        {
                                            //Get the details of the categories
                                            $category_id = $row['id'];
                                            $category_title = $row['title'];
                                            ?>
                                                <option 
                                                <?php
                                                    if($current_category==$category_id)
                                                    {
                                                        echo "selected";
                                                    }
                                                ?>
                                                value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                            <?php
                                        }                                    
                                    }
                                    else
                                    {
                                        //We do not have categories
                                        echo"<option value = '0'>No category available</option>";                                        
                                        
                                    }
                                    
                                    // 2. Display on Dropdown
                                ?> 
                                   

                                
                                
                            </select>
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
                        <td >
                            <input type="hidden" name="current_image" value="<?php echo $current_image ; ?>" > 
                            <input type="hidden" name="id" value="<?php echo $id ; ?>" >   
                            <input type="submit" name="submit" value="Update Book" class="btn-primary">
                        </td>
                    </tr>

                </table> 
            </form>       

            <?php
                if(isset($_POST['submit']))
                {
                    //echo "clicked";
                    $id=$_GET['id'];

                    // 1. Get all the details from the form
                    $title = $_POST['title'];
                    $about = $_POST['about'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    // 2. Upload image if selected
                    //Check whether the image is selected or not
                    if(isset($_FILES['image']['name']))
                    {
                        $image_name = $_FILES['image']['name'];
                        if($image_name !="")
                        {
                            //Image is available
                            // A. Upload the new image
                                //Auto rename our image
                                //Get the extension of our image(jpg,jpeg,png....etc;)  eg: "book1.jpg"
                                $ext= end(explode('.', $image_name));// Break the name before and after '.' in the image name => book1 and jpg
                                                                 //end is used to get the pasrt at the end after '.'
                            
                                //Rename the image
                                $image_name = "Book_Name_".rand(000,999).'.'.$ext; //eg:Book_Name_454.jpg

                                $src_path = $_FILES['image']['tmp_name'];

                                $dest_path = "../images/book/".$image_name;

                                //Finally, upload the image
                                $upload = move_uploaded_file($src_path,$dest_path);

                                //Check whether the image is uploaded or not
                                //And if the image is not uploaded, we will stop and redirect with error message
                                if($upload==FALSE)
                                {
                                    //Send message
                                    $_SESSION['upload'] = "<div class='error text-center'>Failed to upload image</div>";
                                    header('location:'.SITEURL.'admin/manage-book.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';

                                    //Stop the process(if we fail to add the image, we dont want the data to be added to the database)
                                    die(); 
                                }
                            //3. Remove the current image if available
                            if($current_image !="")
                            {
                                $remove_path = "../images/book/".$current_image;
                                $remove = unlink($remove_path);

                                //Check whether the image is removed or not
                                //If failed to remove, then display message and stop the process
                                if($remove==FALSE)
                                {
                                    //Failed to remove the image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                    //Redirect to manage book page                        
                                    header('location:'.SITEURL.'admin/manage-book.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
                                    die();

                                }
                            }
                            
                        }
                        else
                        {
                            $image_name = $current_image;// Default image when image is not selected
                        }
                    }
                    else
                    {
                        $image_name = $current_image; // Default image when button is not clicked
                    }

                    

                    // 4. Update the book in the database
                    $sql = "UPDATE tbl_book SET
                    title = '$title',
                    about = '$about',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id= $id
                    ";
                    //Execute the query
                    $res = mysqli_query($conn,$sql);

                    // 4. Redirect to Manage Book page
                    //Check whether the query is executed or not
                    if($res==TRUE)
                    {
                        //Book updated suuccessfully
                        $_SESSION['update'] = "<div class='success text-center'>Book updated successfully.</div>";
                        //echo "yes";
                        //Redirect to Manage Book page
                        header('location:'.SITEURL.'admin/manage-book.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';

                    }
                    else
                    {
                        //Failed to update Book
                        $_SESSION['update'] = "<div class='error'>Failed to update book.</div>";
                        //Redirect to manage Book page                        
                        header('location:'.SITEURL.'admin/manage-book.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';
                        //echo "no";
                    }

                    // 5. Redirect to manage book page with session message
                }
            ?>
        </div>
    </div>
</section>            

<?php include('partials/footer.php')?>