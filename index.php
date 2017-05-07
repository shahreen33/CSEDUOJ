<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo "Hello<br>";
        $item1='QTREE';
        $item2='code.txt';
        $item3='6';
        //$tmp = exec("python simple.py");
        $tmp = exec("python spojBot.py ".$item1." ".$item2." ".$item3);
        if($tmp == false)
            echo "Error";
        else
            echo $tmp;

    ?>
    </body>
</html>
