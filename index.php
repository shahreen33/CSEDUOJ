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
        include 'submitter.php';


        echo "Hello now<br>";
        //$tmp = exec("python simple.py");
        $tmp = submit("spoj", "QTREE", "code.txt", "6");
        echo $tmp;

    ?>
    </body>
</html>
