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
                    $sql = "SELECT * FROM tbl_order WHERE id=$id ";
                    //Execute the query
                    $res = mysqli_query($conn,$sql);
                    //Count the rows to check whether the id is valid or not
                    $count = mysqli_num_rows($res);
                    if($count==1)
                    {
                        //Get the details                    
                        $row = mysqli_fetch_assoc($res);
                        
                        $book = $row['book'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $stat = $row['stat'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        
                    }

                    else
                    {
                        //Redirect to Manage Category page with session message
                        $_SESSION['no-order-found'] = "<div class='error text-center'>Order Not Found</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-order.php"</script>';
                    }

                }

                else
                {
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-order.php');
                    echo '<script>window.location.href="'.SITEURL.'admin/manage-order.php"</script>';

                }
            ?>

            <form action="" method="POST"  >
                    <div class="tbl-30">
                        <tr>
                            <td> Book Name :  </td>                           
                            <td> <b style='color:orange;'><?php echo $book; ?></b> </td>                            
                        </tr>
                        <br>
                        <tr>
                            <td>Price: </td>
                            <td><b style='color:orange;'>Rs. <?php echo $price; ?>/-</b></td>
                        </tr>
                        
                        <br> 
                        <tr>
                            <td>Qty : </td>
                            <td>
                                <input type="number" name="qty" value="<?php echo $qty; ?>">
                            </td>
                        </tr>
                        
                        <br>

                        <tr>
                            <td>Status : </td>
                            <td>
                                <select name="stat" >
                                    <option <?php if($stat=="ordered"){echo "selected";} ?> value="ordered">Ordered</option>
                                    <option <?php if($stat=="on delivery"){echo "selected";} ?> value="on delivery">On Delivery</option>
                                    <option <?php if($stat=="delivered"){echo "selected";} ?> value="delivered">Delivered</option>
                                    <option <?php if($stat=="cancelled"){echo "selected";} ?> value="cancelled">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        
                        <br>

                        <tr>
                            <td>Customer Name :  </td>
                            <td>
                                <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                            </td>
                        </tr>
                       
                        <br>

                        <tr>
                            <td>Customer_Contact :  </td>
                            <td>
                                <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                            </td>
                        </tr>
                        
                        <br>
                        

                        <tr>
                            <td>Customer email :  </td>
                            <td>
                                <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                            </td>
                        </tr>
                        
                        <br>

                        <tr>
                            <td>Customer Address :  </td>
                            <td>
                                <textarea type="text" name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                            </td>
                        </tr>
                        
                        <br>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="price" value="<?php echo $price; ?>">
                                <input type="submit" name="submit" value="Update Order" class="btn-primary">
                            </td>                            
                        </tr>
                    </div>
                </form> 

                <?php
                    //Check whether the update button is clicked or not
                    if(isset($_POST['submit']))
                    {
                        //echo "clicked";
                        //Get all the values from form

                        $id = $_POST['id'];
                        $price = $_POST['price'];
                        $qty = $_POST['qty'];

                        $total =$price * $qty;

                        $stat = $_POST['stat'];

                        $customer_name = $_POST['customer_name'];
                        $customer_contact = $_POST['customer_contact'];
                        $customer_email = $_POST['customer_email'];
                        $customer_address = $_POST['customer_address'];


                        //Update the values
                        $sql2 = "UPDATE tbl_order SET
                            qty = $qty,
                            total = $total,
                            stat = '$stat',
                            customer_name = '$customer_name',
                            customer_contact = '$customer_contact',
                            customer_email = '$customer_email',
                            customer_address = '$customer_address'
                            WHERE id = $id
                        ";

                        //Execute the query

                        $res2 = mysqli_query($conn,$sql2);

                        // 4. Redirect to Manage Order page
                        //Check whether the query is executed or not
                        if($res2==TRUE)
                        {
                            //Order updated suuccessfully
                            $_SESSION['update'] = "<div class='success text-center'>Order updated successfully.</div>";
                            //echo "yes";
                            //Redirect to Manage Order page
                            header('location:'.SITEURL.'admin/manage-order.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/manage-order.php"</script>';

                        }
                        else
                        {
                            //Failed to update order
                            $_SESSION['update'] = "<div class='error'>Failed to update order.</div>";
                            //Redirect to manage order page                        
                            header('location:'.SITEURL.'admin/manage-order.php');
                            echo '<script>window.location.href="'.SITEURL.'admin/manage-order.php"</script>';
                            //echo "no";
                        }

                        

                    }
                ?> 

             

        </div>
    </div>
</section>

<?php include('partials/footer.php')?>