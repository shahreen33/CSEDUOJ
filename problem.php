<?php 
error_reporting(E_ERROR | E_PARSE);
include 'crawler.php';
class problem { 
    public $name; 
    public $URL, $htmlText, $doc, $responseText, $OJ;
    public $failure = false;
            
    function __construct($URL) 
    {
        $this->URL = $URL;
        $this->responseText = @crawl($URL);
        if($this->responseText === false)
        {
            $this->failure = true;
            return;
        }
        $this->doc = new DOMDocument; 
        if(strpos($URL, 'spoj.com') !== false)
        {
            $this->OJ = 'spoj';
            if(strpos($this->responseText, "<title>Sphere Online Judge (SPOJ)</title>") !== false 
                || strpos($this->responseText, "<p>In a few seconds you will be redirected to <a href=\"/\">link</a></p>") !== false)
            {
                $this->failure = true;
                return;
            }
            
        }
        else if(strpos($URL, 'codeforces.com') !== false)
        {
            if(strpos($this->responseText, "<h3>The requested URL was not found on this server.</h3>") !== false
                    || strpos($this->responseText, "<title>Codeforces</title>") !== false)
            {
                $this->failure = true;
                return;
            }
            $this->OJ = 'codeforces';
        }
        else 
        {
            $this->failure = true;
        }
        @$this->doc->loadHTML($this->responseText); 
    }
    
    
    function test() 
    { 
        print $this->URL;
    } 
    
    function getProblemBody()
    {
        if($this->failure == true)
        {
            return "No Such Problem";
        }
        if($this->OJ == "spoj")
        {
            $temp = $this->doc->getElementById("problem-body");
            $temp2 = $this->doc->getElementById("problem-meta");
            return $this->doc->saveHTML($temp) . $this->doc->saveHTML($temp2);
        }
        else if($this->OJ == "codeforces")
        {
            $finder = new DOMXPath($this->doc);
            //$className = "problem-statement";
            $className = "problemindexholder";
            $result = $finder->query("//*[contains(@class, '$className')]");
            return $result[0]->ownerDocument->saveHTML($result[0]);
            //$tempDoc = new DOMDocument;
            //$tempDoc->loadHTML($result[0]->ownerDocument->saveHTML($result[0]));
        }
    }
    
    function getProblemName()
    {
        if($this->failure == true)
        {
            return "No Such Problem";
        }
        if($this->OJ == "spoj")
        {
            $temp = $this->doc->getElementById("problem-name");
            $html = $this->doc->saveHTML($temp);
            $pattern = "/>.*</";
            preg_match($pattern, $html, $matches);
            $len = strlen($matches[0]);
            return substr($matches[0],1,$len-2);
            
        }
        else if($this->OJ == "codeforces")
        {
            $finder = new DOMXPath($this->doc);
            $className = "header";
            $result = $finder->query("//*[contains(@class, '$className')]");
            $tempDoc = new DOMDocument;
            $tempDoc->loadHTML($result[0]->ownerDocument->saveHTML($result[0]));
            
            $finder = new DOMXPath($tempDoc);
            $className = "title";
            $result = $finder->query("//*[contains(@class, '$className')]");
            $html = $result[0]->ownerDocument->saveHTML($result[0]);
            $pattern = "/>.*</";
            preg_match($pattern, $html, $matches);
            $len = strlen($matches[0]);
            return substr($matches[0],4,$len-5);
        }
    }
} 


?>