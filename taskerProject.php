<?php
/* taskerProject **************************************************************

Author: Robbert de Groot

Description:

Manage the taskerListProject.php file.

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

require_once "taskerVariable.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Add project.
function taskerProjectAdd($name, $isVisible, $description)
{
   // Get the project list.
   $list = &taskerVarGetListProject();
      
   // Get the index of the new project.
   $index = zListAdd($list);

   // Increment the next project id.
   $id = taskerVarUpdateNextIdProject();

   // Modify that project.
   taskerProjectSet(
      $list,
      $index,
      $id,
      $name,
      $isVisible,
      $description);
   
   // Save the changed next id project.
   zListSave(FILE_LIST_PROJ, $list, VAR_LIST_PROJ);
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function taskerProjectEdit($index, $name, $isVisible, $description)
{
   // Get the project list.
   $list = &taskerVarGetListProject();
      
   taskerProjectSet(
      $list,
      $index,
      taskerProjectGetId($index),
      $name,
      $isVisible,
      $description);

   // Save the changed next id project.
   zListSave(FILE_LIST_PROJ, $list, VAR_LIST_PROJ);
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function taskerProjectGetDescription($index)
{
   return zListGet(taskerVarGetListProject(), $index, KEY_PROJ_DESC);
}

function taskerProjectGetId($index)
{
   return zLIstGet(taskerVarGetListProject(), $index, KEY_PROJ_ID);
}

function taskerProjectGetIndex($id)
{
   // Get the project list.
   $list = taskerVarGetListProject();

   // For all projects...
   $count = count($list);
   for ($index = 0; $index < $count; $index++)
   {
      // Get the project id.
      $idProject = zListGet($list, $index, KEY_PROJ_ID);

      // If the ids match...
      if ($id == $idProject)
      {
         // Return the index.
         return $index;
      }
   }

   // Return failure.
   return -1;
}

function taskerProjectGetName($index)
{
   return zListGet(taskerVarGetListProject(), $index, KEY_PROJ_NAME);
}

function taskerProjectGetNameFromId($id)
{
   return taskerProjectGetName(taskerProjectGetIndex($id));
}

///////////////////////////////////////////////////////////////////////////////
// Is functions
function taskerProjectIsVisible($index)
{
   return zListGet(taskerVarGetListProject(), $index, KEY_PROJ_IS_VISIBLE);
}

function taskerProjectIsVisibleFromId($id)
{
   return taskerProjectIsVisible(taskerProjectGetIndex($id));
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function taskerProjectSet(&$list, $index, $id, $name, $isVisible, $description)
{
   zListSet($list, $index, KEY_PROJ_ID,         $id);
   zListSet($list, $index, KEY_PROJ_NAME,       $name);
   zListSet($list, $index, KEY_PROJ_IS_VISIBLE, $isVisible);
   zListSet($list, $index, KEY_PROJ_DESC,       $description);
}

///////////////////////////////////////////////////////////////////////////////
// Sort
function taskerProjectSort()
{
   // List should already be in this order.
   if (taskerVarGetSortOrderProject() == "i")
   {
      return;
   }

   // Get the project list.
   $list = &taskerVarGetListProject();

   usort($list, 'taskerProjectSortFunction');
}

function taskerProjectSortFunction($a, $b)
{
   $order = taskerVarGetSortOrderProject();

   $count = count($order);
   for ($index = 0; $index < $count; $index++)
   {
      $letter = substr($order, $index, 1);

      switch ($letter)
      {
      case "i": 
      case "I":
         $value = $a[KEY_PROJ_ID] - $b[KEY_PROJ_ID];
         if ($letter == "I") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "j": 
      case "J":
         $value = strnatcmp($a[KEY_PROJ_NAME] < $b[KEY_PROJ_NAME]);
         if ($letter == "J") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "d":
      case "D":
         $value = strnatcmp($a[KEY_PROJ_DESC] < $b[KEY_PROJ_DESC]);
         if ($letter == "D") $value = -$value;
         if ($value != 0)    return $value;
         break;
      }
   }

   // Exactly the same. Project Id trumps all.  No two projects will have the
   // same id.
   if ($a[KEY_PROJ_ID] < $b[KEY_PROJ_ID]) return -1;

   return 1;
}