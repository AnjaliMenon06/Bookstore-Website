<?php include('partials-front/menu.php'); ?>
    <!-- book sEARCH Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>book-search.php" method="POST">
                <input type="search" name="search" placeholder="Find Your Favourite Book.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- book sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order']; //Displaying session message: Order placed successfully
            unset($_SESSION['order']); // Removing session message
        }
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login']; //Displaying session message: Login Successfull
            unset($_SESSION['login']); // Removing session message
        }

        
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Books</h2>

            <?php
                //Create an SQL Query to get data from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Execute the query
                $res = mysqli_query($conn,$sql);

                //Count rows to check whether category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values like id, title, image name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL; ?>category-books.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php
                                        //Check whether image is available or not
                                        if($image_name=="")
                                        {
                                            //Display message
                                            echo "<div class='error'>Image Not Available</div>";
                                        }
                                        else
                                        {
                                            //Image available
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Mythology" class="img-responsive img-curve">
                                            <?php
                                            
                                        }

                                    ?>

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php

                    }
                }
                else
                {
                    //No Category available
                    echo "<div class='error'>Category Not Added</div>";
                }
            ?>           
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- book MEnu Section Starts Here -->
    <section class="book-menu">
        <div class="container">
            <h2 class="text-center">Book Menu</h2>

            <?php
                //Getting books drom database which are both featured and active
                $sql = "SELECT * FROM tbl_book WHERE active='Yes' AND featured='Yes' LIMIT 6 ";

                $res = mysqli_query($conn,$sql);

                //Count rows to check whether book is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Book available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        //Get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $about = $row['about'];                        
                        $image_name = $row['image_name'];

                        ?>
                            <div class="book-menu-box">
                                <div class="book-menu-img">
                                    <?php
                                        //Check whether image is available or not
                                        if($image_name =="")
                                        {
                                            //Image not available
                                            echo "<div class='error'>Image Not Available</div>";
                                        }
                                        else
                                        {
                                            //Image available. Display image
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/book/<?php echo $image_name; ?>" alt="The Magic" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    
                                </div>

                                <div class="book-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="book-price">Rs. <?php echo $price; ?>/-</p>
                                    <p class="book-detail">
                                        <?php echo $about; ?>
                                    </p>
                                    <br>
                                    <a href="<?php echo SITEURL; ?>order.php?book_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div> 
                        <?php
                    }
                }
                else
                {
                    //Book not available
                    echo "<div class='text-white text-center'><h3>Book Not Available</h3></div>";
                }

            ?>    

                    
            <div class="clearfix"></div>  
        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>books.php">More to the Bucket List</a>
        </p>
    </section>
    <!-- book Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>   
   

