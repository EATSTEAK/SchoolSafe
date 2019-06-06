<?php
    exec("python /home/pi/googletts.py ".$_POST["text"]." 2>&1", $output);
    die("true");
?>