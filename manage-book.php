<?php include('partials/menu.php')?>
<section class="admin-page-book">
<div class="main-content"> 
    <div class='wrapper'>
        <h1>Manage Book</h1>
        <br />
                <br />

                <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; //Displaying session message: Book added successfuly
                    unset($_SESSION['add']); // Removing session message
                } 

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize']; //Displaying session message: Unauthorized access
                    unset($_SESSION['unauthorize']); // Removing session message
                } 

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload']; //Displaying session message: Failed to remove book image file
                    unset($_SESSION['upload']); // Removing session message
                } 

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; //Displaying session message: Book deleted successfully
                    unset($_SESSION['delete']); // Removing session message
                }

                if(isset($_SESSION['no-book-found']))
                {
                    echo $_SESSION['no-book-found']; //Displaying session message: Book not found
                    unset($_SESSION['no-book-found']); // Removing session message
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; //Displaying session message: Book Updated successfully
                    unset($_SESSION['update']); // Removing session message
                } 

                if(isset($_SESSION['remove-failed']))
                {
                    echo $_SESSION['remove-failed']; //Displaying session message: Book Updated successfully
                    unset($_SESSION['remove-failed']); // Removing session message
                } 

                
                    
                ?>    
                <br>
                <br>
                <br>
                <br>

                <!--Button to add Admin-->
                <a href="<?php echo SITEURL; ?>admin/add-book-test.php" class="btn-primary"> Add Book </a>
                
                <br />
                <br />
                <br />

                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php

                        //Create SQL Query to get all the books
                        $sql = "SELECT * FROM tbl_book";

                        //Execute the query
                        $res = mysqli_query($conn,$sql);

                        //Count the rows to check whether we have books or not
                        $count = mysqli_num_rows($res);

                        //Create a serial number variable and assign value 1
                        $sn = 1;

                        if($count > 0)
                        {
                            //We have books in the database
                            //Get the boooks from database and display
                            while($row = mysqli_fetch_assoc($res))
                            {
                                //Get values from individual columns
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?>
                                    <tr>
                                        <td><?php echo $sn++; ?>.</td> 
                                        <td><?php echo $title; ?></td>
                                        <td> <?php echo $price; ?></td>
                                        <td> 
                                        
                                            <?php
                                                //Check whether we have image name or not
                                                if($image_name=="")
                                                {
                                                    //We do not have image. Display error message
                                                    echo "<div class='error text-center'> Image Not Added </div>";
                                                }  
                                                else
                                                {
                                                    //We have image. Display the image
                                                    ?>
                                                    <img src="<?php echo SITEURL;?>images/book/<?php echo $image_name;?>"  width="130px">
                                                    <?php
                                                }
                                            ?>                                      
                                        </td>
                                        <td> <?php echo $featured; ?></td>
                                        <td> <?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-book.php?id=<?php echo $id; ?> " class="btn-secondary"> Update Book </a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-book.php ?id=<?php echo $id; ?> & image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Book </a>
                                        </td>                   
                                    </tr>
                                <?php
                            }
                        }
                        else
                        {
                            //Books not added in database
                            echo "<tr><td colspan='7' class='error'>Book Not Added Yet</td></tr>";
                            //This is how we write html inside php
                        }

                    ?>


                    

                    
                </table>
                

    </div>
</div>
</section>


<?php include('partials/footer.php'); ?> 