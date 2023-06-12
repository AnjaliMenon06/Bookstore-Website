<?php

define('SITEURL','http://localhost/Bookstore-Website/');
define('LOCALHOST','localhost');
define('DB_USERNAME','root'); //root is the user name
define('DB_PASSWORD',''); //we have not passed any password here
define('DB_NAME','book-order');

if(!$con = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD,DB_NAME))
{

	die("failed to connect!");
}
