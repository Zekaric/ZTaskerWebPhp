# ZTaskerWebPhp
Web based task tracker for internal network.  I.E. hosted on a local NAS for instance

## Discussion
How is this different than ZTaskerWebJS?  Not much different but after playing with making a command line version with ZTaskerCmd I feel even that project was not simple enough.  It could be made simpler and I've learnt a few things about PHP which I was doing incorrectly with my previous work.  I like ZTaskerWebJS but what I did not like is, what I dislike about a lot of web programming is, that the code is too all over the place.  After a while it becomes too annoying to keep it all straight and this project is meant to be simple and easy to maintain.  And that means easy to maintain after a long time not looking at it.  When code is placed/run in a number of locations that requires more things to juggle in my head.  My head can't juggle.

The JavaScript will be a lot less than the ZTaskerWebJS version.  So more responsibility will be placed on the PHP side, if not all of it.  Having a single code base makes things simpler.  The design will follow what I had planned with the Command line version.  So it will not be as polished looking as ZTaskerWebJS.

## Goals
- Simple coding.
- Simple design.
- Simple maintenance.
- Short development time.

## Compormises
- Performance

When the number of tasks become large, manipulation will become quite a bit slower.  I am not too concerned about this because it isn't intended to be used in a multi-user environment.  Adding tasks will be fast.  Modifying tasks will be slow.

## Design

Keeping it stupidly simple (KISS)

The data will be found in php files.  So that the PHP parser will be parsing the data as well as populating the internal structure at the same time instead of having the data in an external foreign format and having to write code to import/access that data.  This will include SQL or SQLite files and such.  So in a way this should be faster than importing the data from a foreign source.  It will mean sort of a weird and hacky like data access and storage though.

## Warning

This code is intended to be run internally on a secure network and not open to the public.  It is not coded in a way for public access.

This program is intended to be used by a single person.  Multiple users may work but it is not guaranteed.  There is no user tracking in this code.

## Install

Copy the files to a browser accessable folder on your web server.

Point your browser to that folder and you should be done.

The only potential gotcha may be tha you will have to ...

chown www-data:www-data * 

... and maybe ...

chmod 755 *

... on the files in that folder for it to work properly.
