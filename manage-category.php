<?php include('partials/menu.php');?>
<section class="admin-page">
<div class="main-content"> 
    <div class='wrapper'>
        <h1>Manage Category</h1>
        <br />
        <br />
                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Displaying session message: Category added successfuly
                        unset($_SESSION['add']); // Removing session message
                    } 

                    if(isset($_SESSION['remove']))
                    {
                        echo $_SESSION['remove']; //Displaying session message: Failed to remove category image
                        unset($_SESSION['remove']); // Removing session message
                    } 

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete']; //Displaying session message: Category deleted successfuly
                        unset($_SESSION['delete']); // Removing session message
                    } 

                    if(isset($_SESSION['no-category-found']))
                    {
                        echo $_SESSION['no-category-found']; //Displaying session message: Category Not Found
                        unset($_SESSION['no-category-found']); // Removing session message
                    } 

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update']; //Displaying session message: Category updated successfully
                        unset($_SESSION['update']); // Removing session message
                    } 

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload']; //Displaying session message: Image Uploaded successfully
                        unset($_SESSION['upload']); // Removing session message
                    } 

                    if(isset($_SESSION['failed-remove']))
                    {
                        echo $_SESSION['failed-remove']; //Displaying session message: Failed to remove image
                        unset($_SESSION['failed-remove']); // Removing session message
                    } 

                ?>

                <br>
                
                <!--Button to add Admin-->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary"> Add Category </a>
                
                <br />
                <br />
                <br />

                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //Query to get all categories from database
                        $sql = "SELECT * FROM tbl_category";

                        //Execute the query
                        $res = mysqli_query($conn,$sql);

                        //Count the rows
                        $count = mysqli_num_rows($res);

                        //Create a serial number variable and assign value 1
                        $sn = 1;


                        //Check whether we have data in the database or not
                        if($count>0)
                        {
                            //We have data in the database
                            //Get the data and display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>
                                    <tr>
                                        <td><?php echo $sn++; ?>.</td> 
                                        <td><?php echo $title; ?></td>

                                        <td>
                                        <a href="<?php echo SITEURL; ?>category-books.php?category_id=<?php echo $id; ?>">
                                            <?php
                                                //Check whether the image name is available or not
                                                if($image_name !="")
                                                {
                                                    //Display the image
                                                    ?>
                                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" width="130px" >
                                                    
                                                    <?php
                                                }

                                                else
                                                {
                                                    //Display the message:Image not available
                                                    echo "<div class='error text-center'> Image Not Added </div>";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?> " class="btn-secondary"> Update Category </a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php ?id=<?php echo $id; ?> & image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Category </a>
                                        </td>                   
                                    </tr>

                                <?php
                            }
                        }

                        else
                        {
                            //We do not have data in the database
                            //We will display the message inside the table
                            ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="error text-center"> No Category Added </div>
                                    </td>
                                </tr>
                            <?php
                        }

                    ?>

                    

                    
                </table>
                
    </div>
</div>
</section>

<?php include('partials/footer.php'); ?> 