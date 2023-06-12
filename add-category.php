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
                        echo $_SESSION['add']; //Displaying session message: Category successfuly
                        unset($_SESSION['add']); // Removing session message
                    } 

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload']; //Displaying session message: Category successfuly
                        unset($_SESSION['upload']); // Removing session message
                    } 

                ?>

                <!--Add Category Form Starts here-->
                <form action="" method="POST" class="text-center" enctype="multipart/form-data">
                
                    <table class="tbl-30">
                        <tr>
                            <td>Title : </td>
                            <td>
                                <input type="text" name="title" placeholder="Category Title">
                            </td>
                        </tr>

                        <tr>
                            <td>Select Image : </td>
                            <td>
                                <input type="file" name="image">
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
                                <input type="submit" name="submit" value="Add Category" class="btn-primary">
                            </td>
                        </tr>
                    </table>
                
                </form>

                <!--Add Category Form Ends here-->

                <?php 
                    //Check whether the submit button is clicked or not
                    if(isset($_POST['featured']))
                    {
                        //echo "clicked";

                        //1. Get the values from Category Form
                        $title = $_POST['title'];

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
                                    header('location:'.SITEURL.'admin/add-category.php');
                                    echo '<script>window.location.href="'.SITEURL.'admin/add-category.php"</script>';

                                    //Stop the process(if we fail to add the image, we dont want the data to be added to the database)
                                    die(); 
                                }
                            }    
                        }

                        else
                        {
                            //Don't Upload the image and set the image_name value as blank
                            $image_name="";
                        }

                        // 2. Create sql query to insert Category into database
                        $sql = "INSERT INTO tbl_category SET
                            title='$title',
                            image_name='$image_name',
                            featured='$featured',
                            active='$active'
                        ";

                        // 3. Execute the query and save in Database
                        $res = mysqli_query($conn,$sql);

                        // 4. Check whether the query is executed or not and data is added or not
                        if($res == TRUE)
                        {
                            //Query executed and category added
                            $_SESSION['add'] = "<div class='success text-center'>Category Added Successfully.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/manage-category.php"</script>';

                        }

                        else
                        {
                            //Failed to execute query
                            $_SESSION['add'] = "<div class='error text-center'>Failed to add Category</div>";
                            header('location:'.SITEURL.'admin/add-category.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/add-category.php"</script>';
                        }



                    }
                    
                ?>


            </div>
        </div>
</section>

<?php include('partials/footer.php')?>