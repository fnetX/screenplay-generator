#!/bin/bash
waitfor="15"
title="Example Script"
subtitle="... specified in build-classic.sh"
echo "Started Script Builder"
mode="Preparing"
echo "[$mode] ..."
sleep 0.1
echo "[$mode] Cleaning up"
rm tmp/*
rm out/*
sleep 0.1
echo "[$mode] Creating individual files ... this may take a moment!"
php -f script/classic.php
for f in tmp/*
do
  mode="Preparing"
  echo "[$mode] Processing file $f"
  sleep 0.1
  echo "[$mode] Combining files for $f"
  cat stc/head.tex >> "${f}.build"
  cat "${f}" >> "${f}.build"
  cat stc/footer.tex >> "${f}.build"
  echo "[$mode] Removing tmp file $f"
  rm "$f"
  sleep 0.1
  echo "[$mode] Giving the file a title"
  sed -i -e "s/=title/$title/g" "${f}.build"
  sed -i -e "s/=subtitle/$subtitle/g" "${f}.build"
  actor=${f//.tex/}
  actor=${actor//tmp\//}
  sed -i -e "s:=pretitle:Script - $actor:g" "${f}.build"
  echo "[$mode] Preparing latex file for $f"
  cd tmp/
  timeout $waitfor latex "../${f}.build" >> build.log
  mode="Building"
  echo "[$mode] Building pdf file for $f"
  timeout $waitfor pdflatex "../${f}.build" >> build.log
  cd ../
done
sleep 0.1 
mode="Finishing"
echo "[$mode] Copying files"
mv tmp/*.pdf out/
cd out/
rename "s/.tex/ - Script for \'$title\'/" *
mode="Done"
echo "[$mode] Everything finished"
