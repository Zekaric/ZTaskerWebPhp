<?php
/* taskerVariable *************************************************************

Author: Robbert de Groot

Description:

Manage the tasker_Variable.php file.

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
// include
require_once "zDebug.php";
require_once "zFile.php";

require_once "tasker_Constant.php";
require_once "tasker_Variable.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Get functions
function &taskerVarGetListProject()
{
   global $taskerListProject;
   return $taskerListProject;
}

function taskerVarGetListProjectCount()
{
   return count(taskerVarGetListProject());
}

function &taskerVarGetListTask()
{
   global $taskerListTask;
   return $taskerListTask;
}

function taskerVarGetListTaskCount()
{
   return count(taskerVarGetListTask());
}

function taskerVarGetNextIdProject()
{
   global $taskerNextIdProject;
   return $taskerNextIdProject;
}

function taskerVarGetNextidTask()
{
   global $taskerNextIdTask;
   return $taskerNextIdTask;
}

function taskerVarGetIsDisplaying()
{
   global $taskerIsDisplaying;
   return $taskerIsDisplaying;
}

function taskerVarGetSortOrderProject()
{
   global $taskerSortOrderProject;
   return $taskerSortOrderProject;
}

function taskerVarGetSortOrderTask()
{
   global $taskerSortOrderTask;
   return $taskerSortOrderTask;
}

///////////////////////////////////////////////////////////////////////////////
// Is functions
function taskerVarIsDisplayingProjectList()
{
   global $taskerIsDisplaying;

   if ($taskerIsDisplaying == IS_DISPLAYING_PROJ_LIST)
   {
      return true;
   }
   return false;
}

function taskerVarIsDisplayingTaskList()
{
   global $taskerIsDisplaying;

   if ($taskerIsDisplaying == IS_DISPLAYING_TASK_LIST)
   {
      return true;
   }
   return false;
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function taskerVarSetIsDisplaying($value)
{
   global $taskerIsDisplaying;
   $taskerIsDisplaying = $value;
}

function taskerVarSetSortOrderProject($value)
{
   global $taskerSortOrderProject;
   $taskerSortOrderProject = $value;
}

function taskerVarSetSortOrderTask($value)
{
   global $taskerSortOrderTask;
   $taskerSortOrderTask = $value;
}

///////////////////////////////////////////////////////////////////////////////
// Update next id
function taskerVarUpdateNextIdProject()
{
   global $taskerNextIdProject;

   $taskerNextIdProject++;
}

function taskerVarUpdateNextIdTask()
{
   global $taskerNextIdTask;

   $taskerNextIdTask++;
}

///////////////////////////////////////////////////////////////////////////////
// Save the variables
function taskerVarSave()
{
   global $taskerNextIdProject;
   global $taskerNextIdTask;
   global $taskerIsDisplaying;
   global $taskerSortOrderProject;
   global $taskerSortOrderTask;

   $str = "<?php\n\n" .
      "\$taskerListProject      = array();\n" .
      "\$taskerListTask         = array();\n" .
      "\$taskerNextIdProject    = " . $taskerNextIdProject      . ";\n"     .
      "\$taskerNextIdTask       = " . $taskerNextIdTask         . ";\n\n"   .
      "\$taskerIsDisplaying     = \"" . $taskerIsDisplaying     . "\";\n\n" .
      "\$taskerSortOrderProject = \"" . $taskerSortOrderProject . "\";\n"   .
      "\$taskerSortOrderTask    = \"" . $taskerSortOrderTask    . "\";\n";

   zFileStoreText("tasker_Variable.php", $str, true);
}
