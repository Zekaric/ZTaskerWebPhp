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
function taskerVarGetListProject()
{
   global $taskerListProject;
   return $taskerListProject;
}

function taskerVarGetListProjectCount()
{
   return count(taskerVarGetListProject());
}

function taskerVarGetListTaskActive()
{
   global $taskerListTaskActive;
   return $taskerListTaskActive;
}

function taskerVarGetListTaskActiveCount()
{
   return count(taskerVarGetListTaskActive());
}

function taskerVarGetListTaskArchive()
{
   global $taskerListTaskArchive;
   return $taskerListTaskArchive;
}

function taskerVarGetListTaskArchiveCount()
{
   return count(taskerVarGetListTaskArchive());
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
      "\$taskerListTaskActive   = array();\n" .
      "\$taskerListTaskArchive  = array();\n\n" .      
      "\$taskerNextIdProject    = " . $taskerNextIdProject      . ";\n"     .
      "\$taskerNextIdTask       = " . $taskerNextIdTask         . ";\n\n"   .
      "\$taskerIsDisplaying     = \"" . $taskerIsDisplaying     . "\";\n\n" .
      "\$taskerSortOrderProject = \"" . $taskerSortOrderProject . "\";\n"   .
      "\$taskerSortOrderTask    = \"" . $taskerSortOrderTask    . "\";\n";

   zFileStoreText("taskerListProject.php", $str, true);
}
