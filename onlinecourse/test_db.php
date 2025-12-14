<?php
require_once 'config/Database.php';

try 
{
    $db = Database::getInstance();
    echo "Kết nối database thành công!";
} 
catch (Exception $e) 
{
    echo "Lỗi: " . $e->getMessage();
}