<?php include('partials/menu.php')?>
<section class="admin-page">
<div class="main-content"> 
    <div class='wrapper'>
        <h1>Manage Order</h1>
        <br />
                
                <br />

                <?php
                    if(isset($_SESSION['no-order-found']))
                    {
                        echo $_SESSION['no-order-found']; //Displaying session message: Order Not Found
                        unset($_SESSION['no-order-found']); // Removing session message
                    } 

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update']; //Displaying session message: Order Updated successfully
                        unset($_SESSION['update']); // Removing session message
                    } 
                ?>

                <br>
                <br>

                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Book</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>

                    </tr>

                    <?php
                        //Get all the details
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //Display the latest order on top
                        $res = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($res);
                        $sn = 1;

                        if($count>0)
                        {
                            //Order available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get all the details
                                $id=$row['id'];
                                $book=$row['book'];
                                $price=$row['price'];
                                $qty=$row['qty'];
                                $total=$row['total'];
                                $order_date=$row['order_date'];
                                $stat=$row['stat']; //Ordered(customer action),on delivery,delivered, cancelled (admin action)
                                $customer_name=$row['customer_name'];
                                $customer_contact=$row['customer_contact'];
                                $customer_email=$row['customer_email'];
                                $customer_address=$row['customer_address'];
                                ?>
                                    <tr>
                                        <td><?php echo $sn++ ; ?></td> 
                                        <td><?php echo $book ; ?></td>
                                        <td>Rs. <?php echo $price ; ?>/-</td>
                                        <td><?php echo $qty ; ?></td>
                                        <td>Rs. <?php echo $total ; ?>/-</td>
                                        <td><?php echo $order_date ; ?></td>

                                        <td>
                                            <?php
                                                //Ordered, On Delivery, Delivered, Cancelled
                                                if($stat=="ordered")
                                                {
                                                    echo "<label style='color:blue;'>$stat</label>";
                                                }
                                                elseif($stat=="on delivery")
                                                {
                                                    echo "<label style='color:orange;'>$stat</label>";
                                                }
                                                elseif($stat=="delivered")
                                                {
                                                    echo "<label style='color:green;'>$stat</label>";
                                                }
                                                elseif($stat=="cancelled")
                                                {
                                                    echo "<label style='color:red;'>$stat</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name ; ?></td>
                                        <td><?php echo $customer_contact ; ?></td>
                                        <td><?php echo $customer_email ; ?></td>
                                        <td><?php echo $customer_address ; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Order </a>                            
                                        </td>                   
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Order not available
                            echo "<tr><td colspan='12' class='error'>Orders Not Available</td></tr>";
                        }

                    ?>

                    

                    

                </table>
                

    </div>
</div>
<section class="admin-page">


<?php include('partials/footer.php'); ?> 