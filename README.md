
# Zekaric: Manage Your Tasks (ZMYT or My Tea)

## Table Of Contents
**1 - Summary**<br />
**2 - Discussion**<br />
**3 - Goals**<br />
**4 - Compormises**<br />
**5 - Design**<br />
**6 - Warning**<br />
**7 - Install**<br />

# 1 - Summary

My Tea is a web based task manager for an internal network.  I.E. hosted on a local NAS for instance

# 2 - Discussion

I had made an attempt before using more JavaScript and more client side processing but I found that maddening because of the two different languages to have to deal with.  In the end after a time away, I felt I couldn't get back into the development because I forgot how it all worked together.  So in the end, it was not simple enough.  It could be made simpler and I have learnt a few things about PHP which I was doing incorrectly with my previous work.

This project basically uses no JavaScript.  It is all PHP.  No Database.  Data is stored in PHP source files.

# 3 - Goals

*  Simple coding.

*  Simple design.

*  Simple maintenance.

*  Short development time.

# 4 - Compormises

*  Performance

When the number of tasks become large, manipulation will become quite a bit slower.  I am not too concerned about this because it isn't intended to be used in a multi-user environment or for millions of tasks.  Most people have maybe at most a hundred tasks.  At that amount the performance will never be noticeable.

# 5 - Design

Keeping it stupidly simple (KISS)

The data will be found in php files.  So that the PHP parser will be parsing the data as well as populating the internal structure at the same time instead of having the data in an external foreign format and having to write code to import/access that data.  This will include SQL or SQLite files and such.  So in a way this should be faster than importing the data from a foreign source.  It will mean sort of a weird and hacky like data access and storage though.

# 6 - Warning

This code is intended to be run internally on a secure network and not open to the public.  It is not coded in a way for public access.

This program is intended to be used by a single person.  Multiple users may work but it is not guaranteed.  There is no user tracking in this code.

# 7 - Install

Copy the files to a browser accessable folder on your web server.

Point your browser to that folder and you should be done.

The only potential gotcha may be tha you will have to ...

```
chown www-data:www-data *
```

... and maybe ...

```
chmod 755 *
```

... on the files in that folder for it to work properly.

On your web server you **will** need to update your php.ini file.  By default it will cache the last run of a file and will not look at file updates unless you tell it to.  In the php.ini file look for a variable...

```
opcache.enable = ...
opcache.revalidate_freq = ...
```

I set both to 0 but I think you only need to set either to 0.  "revalidate_freq" is basically telling PHP to check the file every time it is to use a file.  In this code base this is necessary as I'm treating a php file as the data file and updating it on the fly.  If the frequency is too slow you may end up with a display that isn't matching what you have actually changed.
