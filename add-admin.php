<?php include('partials/menu.php');?>
<section class="admin-page">
<div class="main-content">
    <div class="wrapper">
        <h1> Add Admin</h1>
        <br>
        <br>

        <?php
            if(isset($_SESSION['add'])) //Checking whwther the session is set or not
                {
                    echo $_SESSION['add']; //Display session message if set
                    unset($_SESSION['add']); // Removing session message
                }               
        ?>
        <br />
        <br />
        <br />

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name : </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your Full Name">
                    </td>
                </tr>

                <tr>
                    <td>User Name : </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your User Name">
                    </td>
                </tr>

                <tr>
                    <td>Password : </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your Password">
                    </td>
                </tr>
                
                <tr>                    
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</section>

<?php include('partials/footer.php'); ?>
<?php
    //process the value from form and save it in database

    //check whether the submit button is clicked or not


    if(isset($_POST['submit'])) //check whether the value is passed using post method or not
    {
        //Button clicked
        //echo "Button Clicked";

        // 1. Get the data from the form

        $full_name= $_POST['full_name'];
        $username= $_POST['username'];
        $password= md5($_POST['password']); //md5-oneway indication function => Password encryption with md5

        // 2. SQL Query to save the data into the database

        // Format : data base column name= form title
        
        $sql= "INSERT INTO tbl_admin SET
            full_name= '$full_name',
            username= '$username',
            password= '$password'

        ";

        // 3.Executing Query and saving data into database

        $res= mysqli_query($conn, $sql) or die(mysqli_error());

        // 4.Check whether the (query is executed ) data is inserted or not and display appropriate message.

        if($res==TRUE)
        {
            //Data Inserted
            // echo 'Data Inserted';
            
            // //Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Congrats..!!!    Admin Added Successfully.</div>";

            //If the Admin is added successfully, then : Redirect Page to Manage Admin 
            //header("location:".SITEURL.'admin/manage-admin.php') ;
                //The constant SITEURL already had 'http://localhost/Bookstore-Website/'. Now we are adding an
                // extension to it to redirect the page to manage-admin.php.
            echo '<script>window.location.href="'.SITEURL.'admin/manage-admin.php"</script>';

        }

        else
        {
            //Failed to insert data
            //echo 'Failed to insert data';

            //Create a session variable to display message
            //$_SESSION['add'] = "Oops...!! Failed to Add Admin";

            //If we fail to add the admin,then : Redirect Page to Add Admin
            //header("location:".SITEURL.'admin/add-admin.php') ;
                //The constant SITEURL already had 'http://localhost/Bookstore-Website/'. Now we are adding an
                // extension to it to redirect the page to manage-admin.php.

            $_SESSION['add'] = "<div class='error'>Sorry..!!!    Failed to add admin</div>";

            
            //echo '<script>window.location.href="'.SITEURL.'admin/add-admin.php"</script>';
        
        }
    } 
?> 