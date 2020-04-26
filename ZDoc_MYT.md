
# Zekaric: Manage Your Tasks (ZMYT or My Tea)

## Table Of Contents
**1 - Summary**<br />
**2 - Install**<br />
**3 - Use**<br />
 3.1 - Common Commands<br />
  3.1.1 - L Command, Change list<br />
  3.1.2 - O Command, Ordering the list<br />
  3.1.3 - P Command, Visibility setting of a Project<br />
 3.2 - Project List Commands<br />
  3.2.1 - A Command, Add a Project<br />
  3.2.2 - E Command, Edit a Project<br />
 3.3 - Task List Commands<br />
  3.3.1 - A Command, Add a Task<br />
  3.3.2 - E Command, Edit a Task<br />
  3.3.3 - S Command, Change the Status of a Task<br />
  3.3.4 - T Command, Visibility setting of a Task<br />
  3.3.5 - Tilde Command, Delete a Task<br />

# 1 - Summary

My Tea is a simple task tracker as well as a simple web program.  All work is performed on a command line prompt with simple commands.  The ideal is speed of entry and speed of keeping it all in order.

# 2 - Install

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

# 3 - Use

Once installed you should have an empty data set.  There will be no projects and no task items.  You should be seeing the Projects page.  The title will be "Zekaric : MYT Projects".

There is a text field in the middle of the web page.  It should already have focus.  Just type in your commands into this text field and hit the enter key.

There is help text below the command line to show what commands are available in the current view.

## 3.1 - Common Commands

These commands for the command line are the same no matter which list you are currently showing.

### 3.1.1 - L Command, Change list

```
l
```

This command will toggle between the project list and the task list.

### 3.1.2 - O Command, Ordering the list

```
ojV
```

Order the list by column "j" and then by column "v".  Each column has a letter prefix.  This is the letter you provide to the "o" command.  You can sort by one or more columns.

A capital letter will invert the sort order for that column.  So in the above command the visibility (vis) column will be inverted in sort order.

### 3.1.3 - P Command, Visibility setting of a Project

```
p23 +
p. -
p.
P4
```

First command includes a project id.  23 in this case.  There is no space between "p" and the number.  There is a space between the project id number and "+".  The "+" is saying we want to make project with PID 23 to be visible.

Second command has a "." for project id.  This means this visibility command applies to all projects.  The "-" meands we what to turn off the visibility.  So this command will turn off the visibility for all Projects.

Third command similar to the second one except there is no "+" or "-" that follows.  This will toggle the visibility of each project in the list.

Fourth command uses a capital "P".  This essentially performs the command "p. -" followed by a "p4 +" command.  Or in other words.  Make only the project with PID equal to 4 visible and everything else invisible.

## 3.2 - Project List Commands

### 3.2.1 - A Command, Add a Project

```
a nZMYT `A simple task manager
```

The above is a typical add command.  It will create a project named ZMYT with a description associated with that project.  n option is not optional.  ` is optional and if present must be last.

Once you type that into the command line and hit enter you should see ZMYT appear in the list.

PID values are automatically assigned.

### 3.2.2 - E Command, Edit a Project

```
e1 nZ:MYT `A simple and fast task manager.
```

The above will adjust the project with '1' as it's Project ID (PID) to "Z:MYT" and updates its description as well.  n and ` options are optional but you should have at least one for this command to do anything.

If the PID you provided doesn't exist then nothing happens.

## 3.3 - Task List Commands

### 3.3.1 - A Command, Add a Task

```
a n12 p1 e? siw `Fix problem with that thing
```

Add a task to the list.

"n" provides the project to assign the task to.

"p" sets the priority of the task.  "1" meaning low priority and "5" is high priority.

"e" sets the effort of the task.  "1" means the task is easy, small, requiring little time.  "5" mean the task is difficult, large, and requires copious amounts of time.  "?" means the task effort is unknown because there are factors for knowledge that isn't known yet.

"s" sets the initial status.

"`" sets the description of the task.

Once you type that into the command line and hit enter you should see ZMYT appear in the list.

All options are optional.  "n", "p", "e" will default to what is shown above the command line.  "s" will default to "nw" which means needs work.  "`" is optional but technically needed for this command.

PID values are automatically assigned.

### 3.3.2 - E Command, Edit a Task

```
e1 n12 p2 e3 siw `Fix problem with that thing and that other thing.
```

Edit an existing task.  Id number must be a valid task id and cannot be omitted or can be ".".

See "a" command above.  Again all options are optional.  Existing values will not change if they are not provided.

### 3.3.3 - S Command, Change the Status of a Task

```
s1 +
s2 -
s3 ad
```

First command will change the status of Task whose id is 1 to the next logical state.

Second command will change the status of Task whose id is 2 to the previous logical state.

Third command will change the status of Task whose id is 3 to "ad" which is "Archive Done"

### 3.3.4 - T Command, Visibility setting of a Task

```
ta
t.
twtdra
```

First command will toggle the visibility of archived tasks.

Second command will change toggle the visibility of all status options.

Third command will do the same thing as the second command.

Similar to the o command you can provide any combination of the letters.

"a" for archived tasks.

"d" for documentation tasks.

"r" for releas tasks.

"t" for testing tasks.

"w" for work tasks.

### 3.3.5 - Tilde Command, Delete a Task

```
~13
```

Delete task with id equal to 13.
