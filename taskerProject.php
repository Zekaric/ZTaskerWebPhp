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
   taskerProjectEdit(
      count($taskerListProject),
      taskerVarGetNextIdProject(),
      $name,
      $isVisible,
      $description);

   // Append the new project to the project list php.
   taskerProject_SaveNew();

   // Increment the next project id.
   taskerVarUpdateNextIdProject();

   // Save the changed next id project.
   taskerVarSave();
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function taskerProjectEdit($index, $id, $name, $isVisible, $description)
{
   taskerProjectSet($index, id, $name, $isVisible, $description);

   // Save the project list.
   taskerProject_Save();
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function taskerProjectGetDescription($index)
{
   return taskerVarGetListProject()[$index][KEY_PROJECT_LIST_DESCRIPTION];
}

function taskerProjectGetId($index)
{
   return taskerVarGetListProject()[$index][KEY_PROJECT_LIST_ID];
}

function taskerProjectGetName($index)
{
   return taskerVarGetListProject()[$index][KEY_PROJECT_LIST_NAME];
}

function taskerProjectIsVisible($index)
{
   return taskerVarGetListProject()[$index][KEY_PROJECT_LIST_IS_VISIBLE];
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function taskerProjectSet($index, $id, $name, $isVisible, $description)
{
   taskerProjectSetId(         $index, id);
   taskerProjectSetName(       $index, $name);
   taskerProjectSetIsVisible(  $index, $isVisible);
   taskerProjectSetDescription($index, $description);
}

function taskerProjectSetDescription($index, $value)
{
   taskerVarGetListProject()[$index][KEY_PROJECT_LIST_DESCRIPTION] = $value;
}

function taskerProjectSetId($index, $value)
{
   taskerVarGetListProject()[$index][KEY_PROJECT_LIST_ID] = $value;
}

function taskerProjectSetName($index, $value)
{
   taskerVarGetListProject()[$index][KEY_PROJECT_LIST_NAME] = $value;
}

function taskerProjectSetIsVisible($index, $value)
{
   taskerVarGetListProject()[$index][KEY_PROJECT_LIST_IS_VISIBLE] = $value;
}

///////////////////////////////////////////////////////////////////////////////
// local
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// compose the code string.
function taskerProject_Compose($index)
{
   $str = "\$taskerListProject[" . $index . "] = array(" .
      "\"" . KEY_PROJECT_LIST_ID          . "\" => " . taskerProjectGetId(         $index) . ", " .
      "\"" . KEY_PROJECT_LIST_IS_VISIBLE  . "\" => " . taskerProjectIsVisible(     $index) . ", " .
      "\"" . KEY_PROJECT_LIST_NAME        . "\" => " . taskerProjectGetName(       $index) . ", " .
      "\"" . KEY_PROJECT_LIST_DESCRIPTION . "\" => " . taskerProjectGetDescription($index) . ");\n";

   return $str;
}

///////////////////////////////////////////////////////////////////////////////
// Save the project list.
function taskerProject_Save()
{
   $file  = "<?php\n";
   $count = taskerVarGetListProjectCount();
   for ($index = 0; $index < $count; $index++)
   {
      $str = taskerProject_Compose($index);
      $file .= $str;
   }

   zFileStoreText("taskerListProject.php", $str, true);
}

///////////////////////////////////////////////////////////////////////////////
// Save only an addition to the project list.
function taskerProject_SaveNew()
{
   $index = taskerVarGetListProjectCount() - 1;
   $str   = taskerProject_Compose($index);

   zFileAppendText("taskerListProject.php", $str, true);
}
