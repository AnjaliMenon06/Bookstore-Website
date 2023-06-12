<?php include('partials/menu.php')?>
<section class="admin-page">
    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>
            <br>
            <br>

            <?php 

                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                }
            
            
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Current Password : </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Enter your current password">     
                        </td>
                    </tr>

                    <tr>
                        <td>New Password : </td>
                        <td>
                            <input type="password" name="new_password" placeholder="Enter your new password">     
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password : </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm your password">     
                        </td>
                    </tr>

                    <tr> 
                                
                        <td colspan="2"> 
                            <input type="hidden" name="id" value="<?php echo $id ; ?>">                           
                            <input type="submit" name="submit" value="Change Password" class="btn-update">
                        </td>
                    </tr>
                </table>
            </form>

        </div>
    </div>       
</section>   

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //1. Get data from the form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);


        //2. Check whether a user with the entered "current password" exists or not
        $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password = '$current_password'";
            //we did not put single quotes'' for $id beacause it is an integer. But we used it for $current password
            //because it is a string
        
        //Execute the Query
        $res = mysqli_query($conn,$sql);  
        
        if($res==TRUE)
        {
            //Check whether data is available or not
            $count = mysqli_num_rows($res);

            if($count==1) //There will be only one user with one id nad one password. Even if password is same for 2 users,
                          //their ids would be different. This will help us to uniquely identify the users.
            {
                //User exists and password can be changed
                //echo "user found";

                //Check whether the new password and confirm password matches or not
                if($new_password==$confirm_password)
                {
                    //Update the password
                    //echo "pwd match";
                    $sql2 = "UPDATE tbl_admin SET
                        password = $new_password
                        WHERE id = $id
                    ";

                    //Execute the Query:
                    $res2 = mysqli_query($conn,$sql2); 

                    //Check whether the query is executed or not
                    if($res==TRUE)
                    {
                        //Display Succes message
                        //Redirect to manage admin page with success
                        $_SESSION['change-pwd'] = "<div class='success text-center'>Congrats...!! Password change was successfull</div>";
                        //Redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
                    }

                    else
                    {
                        //Display error message
                        //Redirect to manage admin page with error message
                        $_SESSION['change-pwd'] = "<div class='error text-center'>Sorry..!! Failed to change password. Try again later</div>";
                        //Redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                        echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
                    }
                    
                }

                else
                {
                    //Redirect to manage admin page with error message
                    $_SESSION['pwd-not-match'] = "<div class='error text-center'>New Password and Confirm Password did not match</div>";
                    //Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
                }
                
            }

            else
            {
                //User does not exist. Send message and redirect
                $_SESSION['user-not-found'] = "<div class='error text-center'>User not found</div>";
                //Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
                echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
                //echo "user not found";

                //User not found message will be displayed when : 
                    //(i) we give change pswd and then give some random id on top(the address bar) and then 
                        //give some random password on current password , new pass amd conf pass
                    //(ii) Given current password does not match with the original password of that user stored in the database  
        
            }
        }

        //3. Check whether the New Pasword and Confirm Password matches or not

        //4. Change the above 3 if all the above 3 is true
    }

?>

<?php include('partials/footer.php'); ?>
