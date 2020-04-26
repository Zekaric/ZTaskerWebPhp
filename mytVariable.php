<?php
/* mytVariable *************************************************************

Author: Robbert de Groot

Description:

Manage the myt_Variable.php file.

******************************************************************************/

/* MIT License ****************************************************************
Copyright (c) 2015 Robbert de Groot

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
******************************************************************************/

///////////////////////////////////////////////////////////////////////////////
// Global variable needed before myt_Variable.php
$mytVar = null;

///////////////////////////////////////////////////////////////////////////////
// constant
define("DATA_FILE",                          "myt_Variable.php");
define("DATA_VAR",                           "\$mytVar");

define("KEY_VAR_DEFAULT_EFFORT",             "DefaultEffort");
define("KEY_VAR_DEFAULT_ID_PROJECT",         "DefaultIdProject");
define("KEY_VAR_DEFAULT_PRIORITY",           "DefaultPriority");
define("KEY_VAR_NEXT_ID_PROJECT",            "NextIdProject");
define("KEY_VAR_NEXT_ID_TASK",               "NextIdTask");
define("KEY_VAR_IS_DISPLAYING_PROJECT_LIST", "IsDisplayingProjectList");
define("KEY_VAR_IS_VISIBLE_ARCHIVE",         "IsVisibleArchive");
define("KEY_VAR_IS_VISIBLE_DOCUMENTATION",   "IsVisibleDocumentation");
define("KEY_VAR_IS_VISIBLE_RELEASE",         "IsVisibleRelease");
define("KEY_VAR_IS_VISIBLE_TESTING",         "IsVisibleTesting");
define("KEY_VAR_IS_VISIBLE_WORK",            "IsVisibleWork");
define("KEY_VAR_SORT_ORDER_PROJECT",         "SortOrderProject");
define("KEY_VAR_SORT_ORDER_TASK",            "SortOrderTask");

define("IS_DISPLAYING_PROJ_LIST",            "Project");
define("IS_DISPLAYING_TASK_LIST",            "Task");

///////////////////////////////////////////////////////////////////////////////
// include
require_once "zData.php";
require_once "zDebug.php";
require_once "zFile.php";

require_once DATA_FILE;

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Get functions
function mytVarGetDefaultEffort()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_DEFAULT_EFFORT);
}

function mytVarGetDefaultIdProject()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_DEFAULT_ID_PROJECT);
}

function mytVarGetDefaultPriority()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_DEFAULT_PRIORITY);
}

function mytVarGetNextIdProject()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_NEXT_ID_PROJECT);
}

function mytVarGetNextidTask()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_NEXT_ID_TASK);
}

function mytVarGetSortOrderProject()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_SORT_ORDER_PROJECT);
}

function mytVarGetSortOrderTask()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_SORT_ORDER_TASK);
}

///////////////////////////////////////////////////////////////////////////////
// Is functions
function mytVarIsDisplayingProjectList()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_DISPLAYING_PROJECT_LIST);
}

function mytVarIsVisibleArchive()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_VISIBLE_ARCHIVE);
}

function mytVarIsVisibleDocumentation()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_VISIBLE_DOCUMENTATION);
}

function mytVarIsVisibleRelease()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_VISIBLE_RELEASE);
}

function mytVarIsVisibleTesting()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_VISIBLE_TESTING);
}

function mytVarIsVisibleWork()
{
   global $mytVar;

   return zDataGet($mytVar, KEY_VAR_IS_VISIBLE_WORK);
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function mytVarSetDefault($pid, $priority, $effort)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_DEFAULT_EFFORT,     $effort);
   zDataSet($mytVar, KEY_VAR_DEFAULT_ID_PROJECT, $pid);
   zDataSet($mytVar, KEY_VAR_DEFAULT_PRIORITY,   $priority);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsDisplayingProjectList($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_DISPLAYING_PROJECT_LIST, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsVisibleArchive($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_VISIBLE_ARCHIVE, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsVisibleDocumentation($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_VISIBLE_DOCUMENTATION, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsVisibleRelease($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_VISIBLE_RELEASE, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsVisibleTesting($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_VISIBLE_TESTING, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetIsVisibleWork($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_IS_VISIBLE_WORK, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetSortOrderProject($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_SORT_ORDER_PROJECT, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

function mytVarSetSortOrderTask($value)
{
   global $mytVar;

   zDataSet($mytVar, KEY_VAR_SORT_ORDER_TASK, $value);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);
}

///////////////////////////////////////////////////////////////////////////////
// Update next id
function mytVarUpdateNextIdProject()
{
   global $mytVar;

   $result = zDataGet($mytVar, KEY_VAR_NEXT_ID_PROJECT) + 1;

   zDataSet($mytVar, KEY_VAR_NEXT_ID_PROJECT, $result);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);

   return $result;
}

function mytVarUpdateNextIdTask()
{
   global $mytVar;

   $result = zDataGet($mytVar, KEY_VAR_NEXT_ID_TASK) + 1;
   
   zDataSet($mytVar, KEY_VAR_NEXT_ID_TASK, $result);

   zDataSave(DATA_FILE, $mytVar, DATA_VAR);

   return $result;
}
