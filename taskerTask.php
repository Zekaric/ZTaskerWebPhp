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
   taskerTaskEdit(
      taskerVarGetListTaskActiveCount(),
      taskerVarGetNextIdTask(),
      $idProject,
      $priority,
      $effort,
      $status,
      $description);

   // Append the new project to the project list php.
   taskerTask_SaveNew();

   // Increment the next project id.
   taskerVarUpdateNextIdTask();

   // Save the changed next id project.
   taskerVarSave();
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function taskerTaskEdit($index, $id, $idProject, $priority, $effort, $status, $description)
{
   taskerTaskSet($index, $id, $idProject, $priority, $effort, $status, $description);

   // Save the project list.
   taskerTask_Save();
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function taskerTaskGetDescription($index)
{
   return taskerGetListTask()[$index][KEY_TASK_LIST_DESC];
}

function taskerTaskGetEffort($index)
{
   return taskerGetListTask()[$index][KEY_TASK_LIST_EFFORT];
}

function taskerTaskGetId($index)
{
   return taskerGetListTask()[$index][KEY_TASK_LIST_ID];
}

function taskerTaskGetIdProject($index)
{
   return taskerGetListTask()[$index][KEY_TASK_LIST_ID_PROJ];
}

function taskerTaskGetPriority($index)
{
   return taskerGetListTask()[$index][KEY_TASK_LIST_PRIORITY];
}

function taskerTaskGetStatus($index)
{
   return taskerGetListTask()[$index][KEY_TAK_LIST_STATUS];
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function taskerTaskSet($index, $id, $idProject, $priority, $effort, $status, $description)
{
   taskerTaskSetId(         $index, $id);
   taskerTaskSetIdProject(  $index, $idProject);
   taskerTastSetPriority(   $index, $priority);
   taskerTastSetEffort(     $index, $effort);
   taskerTastSetStatus(     $index, $status);
   taskerTaskSetDescription($index, $description);
}

function taskerTaskSetDescription($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_DESC] = $value;
}

function taskerTaskSetId($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_ID] = $value;
}

function taskerTaskSetIdProject($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_ID_PROJ] = $value;
}

function taskerTaskSetEffort($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_EFFORT] = $value;
}

function taskerTaskSetPriority($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_PRIORITY] = $value;
}

function taskerTaskSetStatus($index, $value)
{
   taskerGetListTask()[$index][KEY_TASK_LIST_STATUS] = $value;
}

///////////////////////////////////////////////////////////////////////////////
// local
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// compose the code string.
function taskerTask_Compose($list, $index)
{
   global $taskerListProject;

   $str = "\$taskerListTask[" . $index . "] = array(" .
      "\"" . KEY_TASK_LIST_ID       . "\" => " . taskerTaskGetId(         $index) . ", " .
      "\"" . KEY_TASK_LIST_ID_PROJ  . "\" => " . taskerTaskGetIdProject(  $index) . ", " .
      "\"" . KEY_TASK_LIST_PRIORITY . "\" => " . taskerTaskGetPriority(   $index) . ", " .
      "\"" . KEY_TASK_LIST_EFFORT   . "\" => " . taskerTaskGetEffort(     $index) . ", " .
      "\"" . KEY_TASK_LIST_STATUS   . "\" => " . taskerTaskGetStatus(     $index) . ", " .
      "\"" . KEY_TASK_LIST_DESC     . "\" => " . taskerTaskGetDescription($index) . ");\n";

   return $str;
}

///////////////////////////////////////////////////////////////////////////////
// Save the project list.
function taskerTask_Save()
{
   global $taskerListProject;

   $file  = "<?php\n";
   $count = count($taskerListProject);
   for ($index = 0; $index < $count; $index++)
   {
      $str = taskerTask_Compose($index);
      $file .= $str;
   }

   zFileStoreText("taskerListTask.php", $str, true);
}

///////////////////////////////////////////////////////////////////////////////
// Save only an addition to the project list.
function taskerTask_SaveNew()
{
   global $taskerListProject;

   $index = count($taskerListProject) - 1;
   $str   = taskerTask_Compose($index);

   zFileAppendText("taskerListTask.php", $str, true);
}
