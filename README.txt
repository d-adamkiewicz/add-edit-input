Two YUI2/YUI3 widgets and corresponding php(v5.3 and above)/mysql server-side scripts 
aiming fast building and fast entering data to database.
In 'single' directory you can find an example of two input widgets 
- by means of each of them you can add/edit entries in two separate db tables.
In 'complex' directory you can find an example of widget which uses those entries
- you can add/edit complex entries to db table assigning 'single' entries to them.


'single' dir:
in order example to work you must put dir/files somewhere in WWW server directory
then set database parameters in 'config_db.php' file
then open in browser 
http://[serverpath]/single/folks/create.php
http://[serverpath]/single/people/create.php
these will create corresponding db tables for each widget
then open in browser
http://[serverpath]/single/index.php
and you have 2 input widgets to fiddle
http://[serverpath]/single/shows_params.php
will display widget params

you can build/configure your own widget quite easily
just create copy of './folks' or './people' directory
of arbitrary name and change ./folks/config.inc
then verify widget parameters using 
http://[serverpath]/single/shows_params.php
then create widget db tables
then add/edit widget parameters in index.php

'complex' dir:
is quite similar
'config_db.php', 'equip/create.php', 'equip/config.inc' works as above
however 'equip/config.inc' contains 'foreign' key which points to 
to 'single' widgets params (see: 'path' key), and define how to enter data 
(see: 'multiple' key)
ENJOY
