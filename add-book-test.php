<?php include('partials/menu.php');?>

<section class="admin-page">
        <div class="main-content">
            <div class="wrapper">
                <h1>Add Category</h1>
                <br>
                <br>

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Displaying session message: Book successfuly added
                        unset($_SESSION['add']); // Removing session message
                    } 

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload']; //Displaying session message: Image uploaded successfully
                        unset($_SESSION['upload']); // Removing session message
                    } 

                ?>

                <!--Add Category Form Starts here-->
                <!--Add book Form Starts here-->
            <form action="" method="POST" class="text-center" enctype="multipart/form-data">
                
                <table class="tbl-30">
                    <tr>
                        <td>Title : </td>
                        <td>
                            <input type="text" name="title" placeholder="Book Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the book" ></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price : </td>
                        <td>
                            <input type="number" name="price" placeholder="Book Price">
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
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    
                                    //Execute the query
                                    $res = mysqli_query($conn,$sql);

                                    //Count Rows to check whether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //If count is greater than 0, we have categories; else, we dont
                                    if($count>0)
                                    {
                                        //We have categories    
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //Get the details of the categories
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php
                                        }                                    
                                    }
                                    else
                                    {
                                        //We do not have categories
                                        ?> 
                                            <option value="0">No Category Found</option>
                                        <?php
                                    }
                                    
                                    // 2. Display on Dropdown
                                ?>
                                
                                 
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured : </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active : </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    <tr>                    
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Book" class="btn-primary">
                        </td>
                    </tr>
                    
                </table>
            
            </form>

            <!--Add Book Form Ends here-->
    


                <!--Add Category Form Ends here-->

                <?php 
                    //Check whether the submit button is clicked or not
                    if(isset($_POST['submit']))
                    {
                        //echo "clicked";

                        // 1. Get the data from form
                         $title = $_POST['title'];
                         $about = $_POST['about'];
                         $price = $_POST['price'];
                         $category = $_POST['category'];

                        //For radio input type,we need to check whether the button is selected or not
                        if(isset($_POST['featured']))
                        {
                            //Get the value from form
                            $featured = $_POST['featured'];
                        }

                        else
                        {
                            //Set the default value
                            $featured = "No";

                        }

                        if(isset($_POST['active']))
                        {
                            //Get the value from form
                            $active = $_POST['active'];
                        }

                        else
                        {
                            //Set the default value
                            $active = "No";

                        }

                        //Check whether the image is selected or not and set the value for image name accordingly
                        //print_r($_FILES['image']); //we used print_r instead of echo because the filetype was file(array) and dnot text

                        //die(); //To break the code here
                        if(isset($_FILES['image']['name']))
                        {
                            //Upload the image
                            //To upload the image, we need image name, source path and destination path
                            $image_name = $_FILES['image']['name'];

                            //Upload image only is the image is selected ; else, add category without image
                            if($image_name !="")
                            {

                            


                                //Auto rename our image
                                //Get the extension of our image(jpg,jpeg,png....etc;)  eg: "book1.jpg"
                                $ext= end(explode('.', $image_name));// Break the name before and after '.' in the image name => book1 and jpg
                                                                 //end is used to get the pasrt at the end after '.'
                            
                                //Rename the image
                                $image_name = "Book_Name_".rand(000,999).'.'.$ext; //eg:Book_Category_454.jpg

                                $source_path = $_FILES['image']['tmp_name'];

                                $destination_path = "../images/book/".$image_name;

                                //Finally, upload the image
                                $upload = move_uploaded_file($source_path,$destination_path);

                                //Check whether the image is uploaded or not
                                //And if the image is not uploaded, we will stop and redirect with error message
                                if($upload==FALSE)
                                {
                                    //Send message
                                    $_SESSION['upload'] = "<div class='error text-center'>Failed to upload image</div>";
                                    header('location:'.SITEURL.'admin/add-book-test.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/add-book-test.php"</script>';

                                    //Stop the process(if we fail to add the image, we dont want the data to be added to the database)
                                    die(); 
                                }
                            }    
                        

                            else
                            {
                                //Don't Upload the image and set the image_name value as blank
                                $image_name="";
                            }
                        }
                        
                        // 2. Create sql query to insert book into database
                        $sql = "INSERT INTO tbl_book SET
                            title='$title',
                            price = $price,
                            about='$about',
                            image_name='$image_name',
                            category_id='$category',
                            featured='$featured',
                            active='$active'
                        ";

                        // 3. Execute the query and save in Database
                        $res = mysqli_query($conn,$sql);

                        // 4. Check whether the query is executed or not and data is added or not
                        if($res == TRUE)
                        {
                            //Query executed and BOOK added
                            $_SESSION['add'] = "<div class='success text-center'>Book Added Successfully.</div>";
                            header('location:'.SITEURL.'admin/manage-book.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/manage-book.php"</script>';

                        }

                        else
                        {
                            //Failed to execute query
                            $_SESSION['add'] = "<div class='error text-center'>Failed to add Book</div>";
                            header('location:'.SITEURL.'admin/add-book-test.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/add-book-test.php"</script>';
                        }



                    }
                    
                ?>


            </div>
        </div>
</section>

<?php include('partials/footer.php')?>