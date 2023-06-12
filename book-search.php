<?php include('partials-front/menu.php'); ?>

    <!-- book sEARCH Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">

            <?php 
                //Get the search keyword
                $search = $_POST['search'];
            ?>
            
            <h2>Books on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- book sEARCH Section Ends Here -->



    <!-- book MEnu Section Starts Here -->
    <section class="book-menu">
        <div class="container">
            <h2 class="text-center">Book Menu</h2>

            <?php         
                //SQL query to get book based on search keyword
                $sql = "SELECT * FROM tbl_book WHERE title LIKE '%$search%' OR about LIKE '%$search%' ";

                //Execute the query
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

    </section>
    <!-- book Menu Section Ends Here -->

    
<?php include('partials-front/footer.php'); ?>