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
        //include 'submitter.php';
        function submit($OJ, $problemID, $fileName, $language)
        {
            if($OJ == 'spoj')
                $bot = "spojBot.py";
            else if($OJ == 'codeforces')
                $bot = "codeforcesBot.py";
            echo $bot."<br>";
            $str = "python ".$bot." ".$problemID." ".$fileName." ".$language;
            echo "<br> this is str <br>";
            echo $str;
            echo "<br>";
            $verdict = exec($str);
            //$verdict = exec("python simple.py");
            if($verdict == false)
            {
                echo "here";
                $verdict = "Submission Failed";
            }
            return $verdict;
        }

        echo "Hello guys<br>";
        //$tmp = exec("python simple.py");
        $tmp = submit("spoj", "QTREE", "code.txt", "6");
        echo $tmp;

    ?>
    </body>
</html>
