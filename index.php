<!--Call everything untill 'Main content section starts' from the "menu" file inside the partials folder-->
<?php include('partials/menu.php'); ?> 

        <!-- Main Content Section starts-->
        <section class="admin-page">
        <div class="main-content">
            <div class="wrapper">
                
                <h1>DASHBOARD</h1>
                <br>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login']; //Displaying session message: Login successfull
                        unset($_SESSION['login']); // Removing session message
                    }
                ?>
                <br>
                <div class="col-4 text-center">
                    <h2>Total Number of Categories : </h2>
                    <br />
                    <?php
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn,$sql);                        
                        $count = mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1>
                    
                    
                </div>

                <div class="col-4 text-center">
                    <h2>Total Number of Books : </h2>
                    <br />
                    <?php
                        $sql2 = "SELECT * FROM tbl_book";
                        $res2 = mysqli_query($conn,$sql2);                        
                        $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    
                    
                </div>

                <div class="col-4 text-center">
                    <h2>Total Number of Orders : </h2>
                    <br />
                    <?php
                        $sql3 = "SELECT * FROM tbl_order";
                        $res3 = mysqli_query($conn,$sql3);                        
                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    
                </div>

                <div class="col-4 text-center">
                    <h2>Total Income Generated: </h2>
                    <br />
                    <?php
                        //Create sql query using aggregate function
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE stat='delivered'";
                        $res4= mysqli_query($conn,$sql4); 
                        $row4 = mysqli_fetch_assoc($res4);

                        //Get the total Revenue
                        $total_income = $row4['Total'] ;

                    ?>
                    <h1>Rs. <?php echo $total_income; ?>/-</h1>
                    
                </div>

                <div class="clearfix"></div>
                
            </div>
        </div>
        </section>
        <!-- Main Content Section ends-->       
       
<!--Call everything from 'Main content section ends' from the "footer" file inside the partials folder-->
<?php include('partials/footer.php'); ?> 

<!--We have broken down the homepage into 3 files: mnu and footer inside partials folder and manage-admin inside admin
for the middle block of code. This breaking down of the code helps us to avoid repetition of the same code blocks, thus
making files managable-->