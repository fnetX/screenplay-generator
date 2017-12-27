<?php
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
