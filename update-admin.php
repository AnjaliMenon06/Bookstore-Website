<?php include('partials/menu.php');?>
<section class="admin-page">
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>
        <br>

        <?php 
            //1.Get the id of selected admin
            $id= $_GET['id'];

            //2.Create an SQL query to get the details
            $sql= "SELECT * FROM tbl_admin WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn,$sql);

            //Check whether the query is executed or not
            if($res==TRUE)
            {
                //Check whether the data is avilable or not
                $count=mysqli_num_rows($res);

                //Check whether we have admin data or not
                if($count==1)
                {
                    //Get the details
                    //echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }

                else
                {
                    //Redirect to Manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
                }

            }

            else
            {
                //Failed to execute query- failed to update admin
                //echo "Failed to Update Admin";
                $_SESSION['update'] = "<div class='error text-center'>Failed to Update Admin. Try again later.</div>";
                //Redirect to manage admin page
                header('location:'.SITEURL.'admin/update-admin.php');
                echo '<script>window.location.href="'.SITEURL.'admin/update-admin.php"</script>';
            }

        
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name ;?>" >
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <br>
                    <td>
                        <input type="text" name="username" value="<?php echo $username ;?>">
                    </td>
                </tr>

                <tr> 
                                
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-update">
                    </td>
                </tr>
            </table>   

        </form>
    </div>    
</div>
</section>


<?php

    //Check whether the submit button is clicked or not
    if(isset ($_POST['submit']))
    {
        //echo "Button Clicked";
        //Get all the values from the form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //Create an SQL Query to Update Admin
        $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id = '$id'

        ";

        //Execute the Query
        $res = mysqli_query($conn,$sql);

        //Check whether the query is executed successfully or not
        if($res==TRUE)
        {
            //Query executed and admin updated
            $_SESSION['update'] = "<div class='success'>Admin updated successfully.</div>";

            //Redirect to Manage Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';

        }

        else
        {
            //Failed to execute query.Redirect back to manage admin page
            $_SESSION['update'] = "<div class='error'>Failed to Update Admin.Try again later</div>";

            //Redirect to manage Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
            echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';
        }

    }

?>

<?php include('partials/footer.php');?>