<?php
include 'createConnection.php';
$conn = OpenCon();
echo "Connected Successfully";
CloseCon($conn);
?>
