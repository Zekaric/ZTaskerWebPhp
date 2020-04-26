<?php
/* mytProject **************************************************************

Author: Robbert de Groot

Description:

Manage the mytListProject.php file.

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
// Global variable needed before myt_ListProject.php
$mytListProject = array();

///////////////////////////////////////////////////////////////////////////////
// constant
define("LIST_PROJ_FILE",      "myt_ListProject.php");
define("LIST_PROJ_VAR",       "\$mytListProject");

define("KEY_PROJ_ID",         "id");
define("KEY_PROJ_NAME",       "name");
define("KEY_PROJ_DESC",       "description");
define("KEY_PROJ_IS_VISIBLE", "isVisible");

///////////////////////////////////////////////////////////////////////////////
// include
require_once "zDataList.php";
require_once "zDebug.php";

require_once LIST_PROJ_FILE;

require_once "mytVariable.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Add project.
function mytProjectAdd($name, $isVisible, $description)
{
   global $mytListProject;

   // Get the index of the new project.
   $index = zDataListAdd($mytListProject);

   // Increment the next project id.
   $id = mytVarUpdateNextIdProject();

   // Modify that project.
   mytProjectSet(
      $index,
      $id,
      $name,
      $isVisible,
      $description);
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function mytProjectEdit($index, $name, $isVisible, $description)
{
   mytProjectSet(
      $index,
      mytProjectGetId($index),
      $name,
      $isVisible,
      $description);
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function mytProjectGetCount()
{
   global $mytListProject;

   return count($mytListProject);
}

function mytProjectGetDescription($index)
{
   global $mytListProject;

   return zDataListGet($mytListProject, $index, KEY_PROJ_DESC);
}

function mytProjectGetId($index)
{
   global $mytListProject;
   
   return zDataListGet($mytListProject, $index, KEY_PROJ_ID);
}

function mytProjectGetIndex($id)
{
   global $mytListProject;

   // For all projects...
   $count = count($mytListProject);
   for ($index = 0; $index < $count; $index++)
   {
      // Get the project id.
      $idProject = zDataListGet($mytListProject, $index, KEY_PROJ_ID);

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

function mytProjectGetName($index)
{
   global $mytListProject;

   return zDataListGet($mytListProject, $index, KEY_PROJ_NAME);
}

function mytProjectGetNameFromId($id)
{
   global $mytListProject;

   return mytProjectGetName(mytProjectGetIndex($id));
}

///////////////////////////////////////////////////////////////////////////////
// Is functions
function mytProjectIsVisible($index)
{
   global $mytListProject;

   return zDataListGet($mytListProject, $index, KEY_PROJ_IS_VISIBLE);
}

function mytProjectIsVisibleFromId($id)
{
   return mytProjectIsVisible(mytProjectGetIndex($id));
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function mytProjectSet($index, $id, $name, $isVisible, $description)
{
   global $mytListProject;

   zDataListSet($mytListProject, $index, KEY_PROJ_ID,         $id);
   zDataListSet($mytListProject, $index, KEY_PROJ_NAME,       $name);
   zDataListSet($mytListProject, $index, KEY_PROJ_IS_VISIBLE, $isVisible);
   zDataListSet($mytListProject, $index, KEY_PROJ_DESC,       $description);
   
   // Save the changed next id project.
   zDataListSave(LIST_PROJ_FILE, $mytListProject, LIST_PROJ_VAR);
}

///////////////////////////////////////////////////////////////////////////////
// Sort
function mytProjectSort()
{
   global $mytListProject;

   // List should already be in this order.
   if (mytVarGetSortOrderProject() == "i")
   {
      return;
   }

   usort($mytListProject, 'mytProjectSortFunction');
}

///////////////////////////////////////////////////////////////////////////////
// Sort function to determin how one item relates to another.
function mytProjectSortFunction($a, $b)
{
   $order = mytVarGetSortOrderProject();

   $count = strlen($order);
   for ($index = 0; $index < $count; $index++)
   {
      $letter = substr($order, $index, 1);

      switch ($letter)
      {
      case "i": 
      case "I":
      case "n":
      case "N":
         $value = $a[KEY_PROJ_ID] - $b[KEY_PROJ_ID];
         if ($letter == "I") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "j": 
      case "J":
         $value = strnatcmp($a[KEY_PROJ_NAME], $b[KEY_PROJ_NAME]);
         if ($letter == "J") $value = -$value;
         if ($value != 0)    return $value;
         break;

      case "d":
      case "D":
         $value = strnatcmp($a[KEY_PROJ_DESC], $b[KEY_PROJ_DESC]);
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
