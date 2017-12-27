<?php
$source = file("src/content.tex");
$lines = count($source);
$actor = array();
$actor["MC"] = "Main Character";
$actor["W"] = "Women";
// continue this
$actors = count($actor);
$write = array();



function file_cache($file,$content)
{
  global $write;
  if(isset($write[$file]))
  {
    $write[$file] .= $content;
  } else {
    $write[$file] = $content;
  }
}




for($i=0;$i < $lines; $i++)
{
  $line = $source[$i];
  if (strpos($line,"\dir"))
  {
    foreach($actor as $a => $v)
    {
      $line = str_replace($a,$v,$line);
    }
  } elseif (strpos($line,":"))
  {
    foreach($actor as $a => $v)
    {
      $c_actor = explode(":",$line);
      $c_actor[0] = str_replace($a,$v,$c_actor[0]);
      $line = implode(":",$c_actor);
    }
  }
  if (strlen($line) > 2 && strpos($line,"section") === false)
  {
    $line = str_replace("\n","\\vspace{0.3cm}\\newline\n", $line); # 0.43cm for original screenplay
  }
  $line = str_replace(array("&", "π"),array("\\&", "\$\\pi\$"),$line);   
  foreach($actor as $a => $v)
  {
    $tmpline = $line;
    //echo "Debug: " + $tmpline . " - " . $v;
    if ((strpos($line,":") or strpos($line,"\dir")) && !strpos($line,"section") && strpos($line,"%") === false)
    {
      if (substr_count($line,$v))
      {
        $tmpline = "\\textbf{" . $line;
        $tmpline = str_replace("\\newline","}\\newline", $tmpline);
      }
    }
    file_cache($v,$tmpline);  
  }
  file_cache("Main",$line);
}
foreach($write as $fn => $fc)
{
  file_put_contents("tmp/$fn.tex",$fc);
}
