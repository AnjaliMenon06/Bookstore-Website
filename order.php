<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether the id is set or not
    if(isset($_GET['book_id']))
    {
        //Get the book id and details of the book
        $book_id = $_GET['book_id'];
        //Get the details of the selected food
        $sql = "SELECT * FROM tbl_book WHERE id=$book_id ";
        $res = mysqli_query($conn,$sql);
        //Count rows to check whether book is available or not
        $count = mysqli_num_rows($res);
        //Check whether the data is available or not
        if($count==1)
        {
            //We have data
            //Get the data from the database
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];                                  
            $image_name = $row['image_name'];
        }
        else
        {
            //We do not have data
            //Redirect to home page
            header('location:'.SITEURL);
            echo '<script>window.location.href='.SITEURL;
        }
        
    }
    else
    {
        //Redirect to home page
        header('location:'.SITEURL);
        echo '<script>window.location.href="'.SITEURL;
    }

?>


    <!-- book sEARCH Section Starts Here -->
    <section class="book-order">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method = "POST" class="order">
                <fieldset>
                    <h2>Selected Book</h2>

                    <div class="something-menu-img">
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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="book" value="<?php echo $title; ?>">
                        <p class="book-price-ord">Rs. <?php echo $price; ?>/-</p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <h2>Delivery Details</h2>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Emma Watson" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hello@onetakewatson.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    //Button is clicked
                    //Get all the details from the form
                    $book=$_POST['book'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty'];
                    $total=$price * $qty;
                    $order_date=date("Y-m-d h:i:sa");
                    $stat="ordered"; //Ordered(customer action),on delivery,delivered, cancelled (admin action)
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $customer_address=$_POST['address'];

                    //Save the order in database
                    $sql2="INSERT INTO tbl_order SET
                        book='$book',
                        price=$price,
                        qty=$qty,
                        total=$total,
                        order_date='$order_date',
                        stat='$stat',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'

                    ";

                    //echo $sql2; die();

                    //Execute the query
                    $res2 = mysqli_query($conn,$sql2);
                    //Check whether the query is executed successsfullly or not
                    if($res2==TRUE)
                    {
                        //Query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Congrats..!!<br> Your order has bee placed successfully.
                        <br>Bookberries Team will contact yo personally for further details.Keep Shopping :)</div>";
                        header('location:'.SITEURL.'home.php');
                        echo '<script>window.location.href="'.SITEURL.'home.php"</script>';
                    }
                    else
                    {
                        //Failed to execute query. Order not saved
                        $_SESSION['order'] = "<div class='error text-center'>Sorry..!!<br> Failed to place your order.Try again later :(</div>";
                        header('location:'.SITEURL.'home.php');
                        echo '<script>window.location.href="'.SITEURL.'home.php"</script>';
                    }
                
                }                    

            ?>

        </div>
    </section>
    <!-- book sEARCH Section Ends Here -->
<?php include('partials-front/footer.php'); ?>