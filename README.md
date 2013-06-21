# St George's Healthcare NHS Trust Wordpress theme #

An epically awesome theme for the St George's website.

## Getting the code ##

This project uses the submodule feature of git which allows for otehr projects to be dynamically cloned when cloning this directory.

To use this feature you need to use the `--recursive` flag when cloning the repository. The following code will bring in this project and all submodules.

`git clone --recursive https://github.com/lukeoatham/StGeorgesHospital.git`

## Compiling the themes CSS & JS ##

The sghstrap submodule contains Colin's bootstrap based style and JS files. These need to be compiled into the `style.css` file required by Wordpress and the JS files need to be moved into the `js/` folder for it to all work. 

Luckily Colin has created a little bash script that will automate this task which can be found at `sghstrap/compile`. Just drag the `sghstrap/` folder into Terminal and type `./compile`.

This script assess if LESS is installed and installs it it isn't then compiles the CSS and puts it in the root folder of theme and moves the compiled JS into the `js/` folder of the theme ready for use.
