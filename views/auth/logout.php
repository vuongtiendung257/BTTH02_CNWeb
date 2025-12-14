<?php
session_start();
session_destroy();
header('Location: ../views/courses/index.php');
exit();
?>