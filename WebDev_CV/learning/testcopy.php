<?php
$file = 'example.txt';
$newfile = 'example_copy.txt';

if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}
?>