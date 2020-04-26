<?php
/* mytTask *****************************************************************

Author: Robbert de Groot

Description:

Manage the mytListTask[Active|Archive].php file.

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
// Global variable needed before myt_ListTask.php
$mytListTask = array();

///////////////////////////////////////////////////////////////////////////////
// constant
define("LIST_TASK_FILE",    "myt_ListTask.php");
define("LIST_TASK_VAR",     "\$mytListTask");

define("KEY_TASK_ID",       "id");
define("KEY_TASK_ID_PROJ",  "idProject");
define("KEY_TASK_PRIORITY", "priority");
define("KEY_TASK_EFFORT",   "effort");
define("KEY_TASK_STATUS",   "status");
define("KEY_TASK_DESC",     "description");

///////////////////////////////////////////////////////////////////////////////
// include
require_once "zDataList.php";
require_once "zDebug.php";

require_once LIST_TASK_FILE;

require_once "mytVariable.php";
require_once "mytProject.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Add a task.
function mytTaskAdd($idProject, $priority, $effort, $status, $description)
{
   global $mytListTask;

   // Get the index of the new task.
   $index = zDataListAdd($mytListTask);

   // Increment the next project id.
   $id = mytVarUpdateNextIdTask();

   // Modify that task.
   mytTaskSet(
      $index,
      $id,
      $idProject,
      $priority,
      $effort,
      $status,
      $description);
}

///////////////////////////////////////////////////////////////////////////////
// Edit a task.
function mytTaskEdit($index, $idProject, $priority, $effort, $status, $description)
{
   global $mytListTask;

   // Modify that task.
   mytTaskSet(
      $index,
      mytTaskGetId($index),
      $idProject,
      $priority,
      $effort,
      $status,
      $description);
}

///////////////////////////////////////////////////////////////////////////////
// Delete a task.
function mytTaskDelete($index)
{
   global $mytListTask;

   // Remove the task from the list.
   array_splice($mytListTask, $index, 1);

   // Save the changed next id project.
   zDataListSave(LIST_TASK_FILE, $mytListTask, LIST_TASK_VAR);
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function mytTaskGetCount()
{
   global $mytListTask;

   return count($mytListTask);
}

function mytTaskGetDescription($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_DESC);
}

function mytTaskGetEffort($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_EFFORT);
}

function mytTaskGetId($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_ID);
}

function mytTaskGetIndex($id)
{
   global $mytListTask;

   // For all tasks...
   $count = count($mytListTask);
   for ($index = 0; $index < $count; $index++)
   {
      // Get the task id.
      $idTask = zDataListGet($mytListTask, $index, KEY_TASK_ID);
      
      // if the ids match...
      if ($id == $idTask)
      {
         // return the index.
         return $index;
      }
   }

   // Return failure.
   return -1;
}

function mytTaskGetIdProject($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_ID_PROJ);
}

function mytTaskGetPriority($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_PRIORITY);
}

function mytTaskGetStatus($index)
{
   global $mytListTask;

   return zDataListGet($mytListTask, $index, KEY_TASK_STATUS);
}

function mytTaskGetStatusValue($status)
{
   switch ($status)
   {
   case "nw": return  0;
   case "iw": return  1;
   case "nt": return  2;
   case "it": return  3;
   case "nd": return  4;
   case "id": return  5;
   case "nr": return  6;
   case "ir": return  7;
   case "ar": return  8;
   case "ad": return  9;
   case "an": return 10;
   }

   // What the hell is this?
   return 11;
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function mytTaskSet($index, $id, $idProject, $priority, $effort, $status, $description)
{
   global $mytListTask;

   zDataListSet($mytListTask, $index, KEY_TASK_ID,       $id);
   zDataListSet($mytListTask, $index, KEY_TASK_ID_PROJ,  $idProject);
   zDataListSet($mytListTask, $index, KEY_TASK_PRIORITY, $priority);
   zDataListSet($mytListTask, $index, KEY_TASK_EFFORT,   $effort);
   zDataListSet($mytListTask, $index, KEY_TASK_STATUS,   $status);
   zDataListSet($mytListTask, $index, KEY_TASK_DESC,     $description);

   // Save the changed next id project.
   zDataListSave(LIST_TASK_FILE, $mytListTask, LIST_TASK_VAR);
}

///////////////////////////////////////////////////////////////////////////////
// Sort
function mytTaskSort()
{
   global $mytListTask;

   // List should already be in this order.
   if (mytVarGetSortOrderTask() == "i")
   {
      return;
   }

   usort($mytListTask, 'mytTaskSortFunction');
}

///////////////////////////////////////////////////////////////////////////////
// The actual compare function for the sort.
function mytTaskSortFunction($a, $b)
{
   $order = mytVarGetSortOrderTask();

   $count = strlen($order);
   for ($index = 0; $index < $count; $index++)
   {
      $letter = substr($order, $index, 1);

      switch ($letter)
      {
      case "i":
      case "I":
         $value = $a[KEY_TASK_ID] - $b[KEY_TASK_ID];
         if ($letter == "I") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "n": 
      case "N":
         $value = $a[KEY_TASK_ID_PROJ] - $b[KEY_TASK_ID_PROJ];
         if ($letter == "N") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "j": 
      case "J":
         $aProj = mytProjectGetNameFromId($a[KEY_TASK_ID_PROJ]);
         $bProj = mytProjectGetNameFromId($b[KEY_TASK_ID_PROJ]);
         $value = strnatcmp($aProj, $bProj);
         if ($letter == "J") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "p":
      case "P":
         $value = $a[KEY_TASK_PRIORITY] - $b[KEY_TASK_PRIORITY];
         if ($letter == "P") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "e":
      case "E":
         $value = $a[KEY_TASK_EFFORT] - $b[KEY_TASK_EFFORT];
         if ($letter == "E") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "s":
      case "S":
         $value = mytTaskGetStatusValue($a[KEY_TASK_STATUS]) - mytTaskGetStatusValue($b[KEY_TASK_STATUS]);
         if ($letter == "S") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "d":
      case "D":
         $value = strnatcmp($a[KEY_TASK_DESC], $b[KEY_TASK_DESC]);
         if ($letter == "D") $value = -$value;
         if ($value != 0)    return $value;
         break;
      }
   }

   // Exactly the same. Project Id trumps all.  No two projects will have the
   // same id.
   if ($a[KEY_TASK_ID] < $b[KEY_TASK_ID]) return -1;

   return 1;
}