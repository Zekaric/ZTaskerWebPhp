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
   global $taskerListProject;

   // Get the project list.
   $list = &taskerVarGetListProject();

   // Get the index of the new project.
   $index = count($list);

   // Add a new project to the list.
   $list[$index] = array();

   // Modify that project.
   taskerProjectEdit(
      $index,
      $name,
      $isVisible,
      $description,
      false);

   // Append the new project to the project list php.
   taskerProject_SaveNew();

   // Increment the next project id.
   taskerVarUpdateNextIdProject();

   // Save the changed next id project.
   taskerVarSave();
}

///////////////////////////////////////////////////////////////////////////////
// Edit a project.
function taskerProjectEdit($index, $name, $isVisible, $description, $isSaving)
{
   taskerProjectSet($index, $name, $isVisible, $description);

   if ($isSaving)
   {
      // Save the project list.
      taskerProject_Save();
   }
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function taskerProjectGetDescription($index)
{
   $list = &taskerVarGetListProject();
   $proj = $list[$index];
   
   return $proj[KEY_PROJ_LIST_DESC];
}

function taskerProjectGetName($index)
{
   $list = &taskerVarGetListProject();
   $proj = $list[$index];
   
   return $proj[KEY_PROJ_LIST_NAME];
}

function taskerProjectIsVisible($index)
{
   $list = &taskerVarGetListProject();
   $proj = $list[$index];
   
   return $proj[KEY_PROJ_LIST_IS_VISIBLE];
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function taskerProjectSet($index, $name, $isVisible, $description)
{
   taskerProjectSetName(       $index, $name);
   taskerProjectSetIsVisible(  $index, $isVisible);
   taskerProjectSetDescription($index, $description);
}

function taskerProjectSetDescription($index, $value)
{
   $list = &taskerVarGetListProject();
   $proj = &$list[$index];
   
   $proj[KEY_PROJ_LIST_DESC] = $value;
}

function taskerProjectSetName($index, $value)
{
   $list = &taskerVarGetListProject();
   $proj = &$list[$index];
   
   $proj[KEY_PROJ_LIST_NAME] = $value;
}

function taskerProjectSetIsVisible($index, $value)
{
   $list = &taskerVarGetListProject();
   $proj = &$list[$index];
   
   $proj[KEY_PROJ_LIST_IS_VISIBLE] = $value;
}

///////////////////////////////////////////////////////////////////////////////
// local
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// compose the code string.
function taskerProject_Compose($index)
{
   $isVis = "false";
   if (taskerProjectIsVisible($index))
   {
      $isVis = "true";
   }

   $name = taskerProjectGetName($index);
   $desc = taskerProjectGetDescription($index);

   $str = "\$taskerListProject[" . $index . "] = array(" .
      "KEY_PROJ_LIST_IS_VISIBLE => " . $isVis . ", " .
      "KEY_PROJ_LIST_NAME => \"" .     $name  . "\", " .
      "KEY_PROJ_LIST_DESC => \"" .     $desc  . "\"); \$taskerNextIdProject++;\n";

   return $str;
}

///////////////////////////////////////////////////////////////////////////////
// Save the project list.
function taskerProject_Save()
{
   $file  = "<?php\n" . 
      "\$taskerNextIdProject = 0\n";
   $count = taskerVarGetListProjectCount();
   for ($index = 0; $index < $count; $index++)
   {
      $str = taskerProject_Compose($index);
      $file .= $str;
   }

   zFileStoreText("taskerListProject.php", $file, true);
}

///////////////////////////////////////////////////////////////////////////////
// Save only an addition to the project list.
function taskerProject_SaveNew()
{
   $index = taskerVarGetListProjectCount() - 1;
   $str   = taskerProject_Compose($index);

   zFileAppendText("tasker_ListProject.php", $str, true);
}
