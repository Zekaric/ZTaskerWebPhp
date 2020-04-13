<?php
/* taskerTask *****************************************************************

Author: Robbert de Groot

Description:

Manage the taskerListTask[Active|Archive].php file.

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
require_once "zList.php";

require_once "tasker_Constant.php";
require_once "tasker_Variable.php";
require_once "tasker_ListProject.php";
require_once "tasker_ListTask.php";

require_once "taskerVariable.php";
require_once "taskerProject.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Add project.
function taskerTaskAdd($idProject, $priority, $effort, $status, $description)
{
   // Get the task list.
   $list = &taskerVarGetListTask();

   // Get the index of the new task.
   $index = zListAdd($list);

   // Increment the next project id.
   $id = taskerVarUpdateNextIdTask();

   // Modify that task.
   taskerTaskSet(
      $list,
      $index,
      $id,
      $idProject,
      $priority,
      $effort,
      $status,
      $description);

   // Save the changed next id project.
   zListSave(FILE_LIST_TASK, $list, VAR_LIST_TASK);
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function taskerTaskEdit($index, $idProject, $priority, $effort, $status, $description)
{
   // Get the task list.
   $list = &taskerVarGetListTask();

   // Modify that task.
   taskerTaskSet(
      $list,
      $index,
      taskerTaskGetId($index),
      $idProject,
      $priority,
      $effort,
      $status,
      $description);

   // Save the changed next id project.
   zListSave(FILE_LIST_TASK, $list, VAR_LIST_TASK);
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function taskerTaskGetDescription($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_DESC);
}

function taskerTaskGetEffort($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_EFFORT);
}

function taskerTaskGetId($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_ID);
}

function taskerTaskGetIndex($id)
{
   // Get the task list
   $list = taskerVarGetListTask();

   // For all tasks...
   $count = count($list);
   for ($index = 0; $index < $count; $index++)
   {
      // Get the task id.
      $idTask = zListGet($list, $index, KEY_TASK_ID);
      
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

function taskerTaskGetIdProject($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_ID_PROJ);
}

function taskerTaskGetPriority($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_PRIORITY);
}

function taskerTaskGetStatus($index)
{
   return zListGet(taskerVarGetListTask(), $index, KEY_TASK_STATUS);
}

function taskerTaskGetStatusValue($status)
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
function taskerTaskSet(&$list, $index, $id, $idProject, $priority, $effort, $status, $description)
{
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_ID,       $id);
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_ID_PROJ,  $idProject);
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_PRIORITY, $priority);
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_EFFORT,   $effort);
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_STATUS,   $status);
   zListSet(taskerVarGetListTask(), $index, KEY_TASK_DESC,     $description);
}

///////////////////////////////////////////////////////////////////////////////
// Sort
function taskerTaskSort()
{
   // List should already be in this order.
   if (taskerVarGetSortOrderTask() == "i")
   {
      return;
   }

   // Get the project list.
   $list = &taskerVarGetListTask();

   usort($list, 'taskerTaskSortFunction');
}

function taskerTaskSortFunction($a, $b)
{
   $order = taskerVarGetSortOrderTask();

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
         $aProj = taskerProjectGetNameFromId($a[KEY_TASK_ID_PROJ]);
         $bProj = taskerProjectGetNameFromId($b[KEY_TASK_ID_PROJ]);
         $value = strnatcmp($aProj < $bProj);
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
         $value = taskerTaskGetStatusValue($a[KEY_TASK_STATUS]) - taskerTaskGetStatusValue($b[KEY_TASK_STATUS]);
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