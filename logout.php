<?php
//logout page
session_start();
session_destroy();


header("Location: login.php");

exit();


