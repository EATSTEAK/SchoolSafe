<?php
    if(file_exists("/home/pi/SchoolSafe/sensors.txt")) {
        $file = fopen("/home/pi/SchoolSafe/sensors.txt", "r") or die("false");
        if(filesize("/home/pi/SchoolSafe/sensors.txt") > 0) {
            echo fread($file, filesize("/home/pi/SchoolSafe/sensors.txt"));
        } else {
            echo "noupdate";
        }
        fclose($myfile);
    }
?>