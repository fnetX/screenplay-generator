<?php
$source = file("src/content.tex");
$lines = count($source);
$actor = array();
$actor["MC"] = "Main Character";
$actor["W"] = "Women";
// continue this
$actors = count($actor);
$write = array();



function file_cache($file,$content) // this adds the input to the "cache" of the given file
{
  global $write;
  if(isset($write[$file]))
  {
    $write[$file] .= $content;
  } else {
    $write[$file] = $content;
  }
}




for($i=0;$i < $lines; $i++) // for every line
{
  $line = $source[$i]; // load the line into $line
  
  if (strpos($line,"\dir")) // if it is a direction
  {
  
    foreach($actor as $a => $v) { // replace the actors
      $line = str_replace($a,$v,$line);
    }
    
  } elseif (strpos($line,":")) // if not a dirction 
  // but someone is saying something ("Tom: ") do that
  {
    foreach($actor as $a => $v) // for every actor
    {
      $c_actor = explode(":",$line); // get the actor part from the line
      $c_actor[0] = str_replace($a,$v,$c_actor[0]); // if this actor is saying something, it is replaced by its full name
      $line = implode(":",$c_actor); // line is merged again
    }
  }
  
  
  if (strlen($line) > 2 && strpos($line,"section") === false)
  {
    $line = str_replace("\n","\\vspace{0.3cm}\\newline\n", $line); # 0.43cm for original screenplay
  }
  
  
  
  $line = str_replace(array("&", "π"),array("\\&", "\$\\pi\$"),$line); // do some character replacements
  
  
  foreach($actor as $a => $v) // for every actor
  {
    $tmpline = $line;
    //echo "Debug: " + $tmpline . " - " . $v;
    if ((strpos($line,":") or strpos($line,"\dir")) && !strpos($line,"section") && strpos($line,"%") === false) // if actor is telling something
    {
      if (substr_count($line,$v))
      {
        $tmpline = "\\textbf{" . $line; // it is marked bold
        $tmpline = str_replace("\\newline","}\\newline", $tmpline);
      }
    }
    file_cache($v,$tmpline);  // individual file is cached
  }
  file_cache("Main",$line); // main file is cached
}


foreach($write as $fn => $fc)
{
  file_put_contents("tmp/$fn.tex",$fc); // save each file
}
