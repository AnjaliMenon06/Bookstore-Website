<?php include('partials/menu.php')?>

        <!-- Main Content Section starts-->
        <section class="admin-page">
        <div class="main-content">
            <div class="wrapper">
                
                <h1>Manage Admin Panel</h1>
                <br />
                <br />

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Displaying session message: Congrats..!!!admin added successfully
                        unset($_SESSION['add']); // Removing session message
                    }  
                    
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete']; //Displaying session message: Admin deleted successfuly
                        unset($_SESSION['delete']); // Removing session message
                    } 

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update']; //Displaying session message: Admin updated successfuly
                        unset($_SESSION['update']); // Removing session message
                    } 

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found']; //Displaying session message: User not found
                        unset($_SESSION['user-not-found']); // Removing session message
                    } 

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match']; //Displaying session message: Password Not Matching(for new and confirm password)
                                                                                       //For current and database pwd not matching,
                                                                                       //the error message is 'user not found'
                        unset($_SESSION['pwd-not-match']); // Removing session message
                    } 

                    
                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd']; //Displaying session message: Password change successfull
                        unset($_SESSION['change-pwd']); // Removing session message
                    } 
                ?>
                <br />
                <br />
                <br />

                <!--Button to add Admin-->
                <a href="add-admin.php" class="btn-primary"> Add Admin </a>
                
                <br />
                <br />
                <br />

                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //Query to get all admin
                        $sql= "SELECT * FROM tbl_admin" ;

                        //Execute the Query
                        $res= mysqli_query($conn,$sql);

                        //Check whether the query is executed or not
                        if($res==TRUE)
                        {
                            //Count rows to check whether we have data in database or not
                            $count= mysqli_num_rows($res); //Function to get all the rows in database

                            $sn=1; //Create a variable and assign the value(this is to avoid getting the idas it 
                                   // is from the database since it has different numbers which are not in order)
                                   // $sn++ is used in echo (inside the while loop) to increment the count

                            //Check number of rows
                            if($count>0)
                            {
                                //We have data in database
                                while($rows=mysqli_fetch_assoc($res)) //This function will get all the data from the tbl_admin(database)
                                {                                     //and display   
                                    //Using while loop to get all the data from the database
                                    //The while loop will run as long as we have data in database

                                    //Get individual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'] //we stop with this since we should not display password since it is encrypted
                                
                                    //Display the values in our table
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td> 
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        
                                        <td>
                                            
                                            
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"> Delete Admin </a>                                        
                                                                            <!--this is a get method-->    
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Admin </a>                                                
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-password"> Change Password</a>
                                        </td>      

                                    </tr>

                                    <?php
                                
                                }

                            }

                            else
                            {
                                //We do not have data in database
                            }
                        } 
                    ?>


                    
                </table>
                
               
                
            </div>
        </div>
        </section>


        <!-- Main Content Section ends-->

<?php include('partials/footer.php'); ?>

        
       