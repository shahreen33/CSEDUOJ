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
        error_reporting(E_ERROR | E_PARSE);
        function submit($OJ, $problemID, $fileName, $language)
        {
            
            if($OJ == 'spoj')
                $bot = "spojBot.py";
            else if($OJ == 'codeforces')
                $bot = "codeforcesBot.py";
            $command = "python ".$bot." ".$problemID." ".$fileName." ".$language;
            $verdict = exec($command);
            if($verdict == false)
                $verdict = "PHEWSubmission Failed";
            
            return $verdict;
        }
    ?>
    </body>
</html>
