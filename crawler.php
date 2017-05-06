<?php
    function crawl($URL)
    {
        if(strlen($URL)==0)
            return false;
        else
            return file_get_contents($URL);
    }
?>

 
