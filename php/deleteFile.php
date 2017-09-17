<?php
$target_dir = "/uploads/";
$target_file = $_POST["msg"];
$file = $target_dir . $target_file;

if (!unlink($file))
{
    echo ("Error deleting $file");
}
else
{
    echo ("Deleted $file");
}
?>
