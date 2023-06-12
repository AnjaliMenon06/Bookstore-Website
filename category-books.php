<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether id is pased or not
    if(isset($_GET['category_id']))
    {
        //Category id is set. Get the id
        $category_id = $_GET['category_id'];
        //Get the category title based on category id
        $sql = "SELECT title From tbl_category WHERE id=$category_id";
        $res = mysqli_query($conn,$sql);
        //Get the value from database
        $row = mysqli_fetch_assoc($res);
        //Get the title
        $category_title = $row['title'];
    }
    else
    {
        //Category id not passed. redirect to home page
        header('location:'.SITEURL);
        echo '<script>window.location.href='.SITEURL;
    }
?>

    <!-- book sEARCH Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            
            <h2>Books on  <a href="#" class="text-white"><?php echo $category_title; ?></a></h2>

        </div>
    </section>
    <!-- book sEARCH Section Ends Here -->



    <!-- book MEnu Section Starts Here -->
    <section class="book-menu">
        <div class="container">
            <h2 class="text-center">Book Menu</h2>

            <?php
                //Create sql query to get books based on selected category
                $sql2= "SELECT * FROM tbl_book WHERE category_id=$category_id";
                $res2 = mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($res2);

                //Check whether the book is available or not
                if($count2>0)
                {
                    //Book available
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $about = $row2['about'];                        
                        $image_name = $row2['image_name'];
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
                    echo "<div class='text-white text-center'> <h3>Book Not Available </h3> </div>";
                }
                
            ?>

            <div class="clearfix"></div>
   
        </div>

    </section>
    <!-- book Menu Section Ends Here -->

  
<?php include('partials-front/footer.php'); ?>