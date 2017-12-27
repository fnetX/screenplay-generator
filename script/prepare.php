<?php

include "inc/init.php"; # loads file and prepares stuff
include "inc/fn_file_cache.php"; # loads function: file_cache($line)
include "inc/fn_line_info.php"; # loads function: line_info($line)
include "inc/config.php"; # loads the configuration

for($i=0;$i < $lines; $i++)
{
  $line = $source[$i];
  
  $line = line_info($line);
  
  die;
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
