YUI2/YUI3 widget and php/mysql server-side script aiming fast building and fast entering data to database
NOTICE: In order this to work you need to have php version earlier than 5.3!!!

in order example to work you must put dir/files somewhere in WWW server directory
then set database parameters in 'config_db.php' file
then open in browser 
http://[serverpath]/folks/create.php
http://[serverpath]/people/create.php
these will create corresponding db tables for each widget
then open in obrowser
http://[serverpath]/index.php
and you have 2 input widgets to fiddle
http://[serverpath]/shows_params.php
will display widget params

you can build/configure your own widget quite easily
just create copy of './folks' or './people' directory
of arbitrary name and change ./folks/config.inc
then verify widget parameters using 
http://[serverpath]/shows_params.php
then create widget db tables
then add/edit widget parameters in index.php
ENJOY
