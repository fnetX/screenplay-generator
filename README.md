# screenplay-generator
A simple (and dirty!) tool to create pdf files from a screenplay input using LaTeX and PHP on Linux systems.


## What is that?
We wanted to create a little movie and used this to create the screenplay. We didn't want to spend time with the layout and we didn't want to have unstructured text files. So I did this tool in one or two nights, and accidently got it working (for me!). 
Because I noticed that it is quite useful I am going to do a more useful rewrite using a proper language (may be Rust, this is so interesting) to make it ... yes, useful.

## What does it?
If you input a screenplay file (actually it's LaTeX but it is very easy to write!) it converts them into pdf files that you can print out.

### Features: 
- markup your screenplay
- create individual screenplay files for each actor (the spoken parts are bold!)
- don't expect more!

## How to use it?
Oh ... you will need Linux or another way to run the shell script ... 
The script uses some commands like sed. You will need to install it (you can usually use your package manager). The other commands should be common.
You will need to be able to run PHP from the command line. Some package with php-cli should do that job.
You will need some stuff to run the LaTeX commands. Don't ask me which packages you'll need, I do not know that by myself.
Still questions? I will try to help you as much as I can.

## Something to remember?
This tool was not intended for public use. It was just for me and it somehow did work. I found it a while ago and managed to get it working again and decided to do a rewrite. I do not know why I am posting this crap here but as you can see I just did it.
