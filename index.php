<?php
/* index *********************************************************************

Author: Robbert de Groot

Description:

The main file of the web site.

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
require_once "zUtil.php";

require_once "tasker_Constant.php";
require_once "tasker_Variable.php";
require_once "tasker_ListProject.php";
require_once "tasker_ListTask.php";

require_once "taskerVariable.php";
require_once "taskerDisplay.php";
require_once "taskerProject.php";

///////////////////////////////////////////////////////////////////////////////
// function
function _ParseCommand($str)
{
   // strip off leading space.
   while (strlen($str))
   {
      $letter = substr($str, 0, 1);
      $str    = substr($str, 1);
      if ($letter != " ")
      {
         break;
      }
   }

   // Prep the result.
   $result    = array();
   $result[0] = "";

   // Nothing left.
   if ($str == "")
   {
      return $result;
   }

   // Letter is the parameter.
   $param = $letter;

   // String to the end of the line.
   if ($param == "`")
   {
      $result[0] = $param;
      $result[1] = trim($str);
      $result[2] = "";

      return $result;
   }
   
   // String to the end of the line or "`"
   if ($param == "n")
   {
      $result[0] = $param;

      $val = "";
      while (strlen($str))
      {
         $letter = substr($str, 0, 1);
         if ($letter == "`")
         {
            $result[1] = $val;
            $result[2] = trim($str);
      
            return $result;
         }

         $val .= $letter;
         $str  = substr($str, 1);
      }
   }
}

///////////////////////////////////////////////////////////////////////////////
// The main page processing.

// Get the operation and command to process.
$cmd = zUtilGetValue("cmd");

// if there is a command...
if ($cmd != "")
{
   // Process the command.
   $op   = substr($cmd, 0, 1);
   $rest = substr($cmd, 1);

   // Change lists.
   if      ($op == "`")
   {
      $list = substr($rest, 0, 1);
      $rest = substr($rest, 1);

      // Switch to projects.
      if      ($list == "p")
      {
         taskerVarSetIsDisplaying(IS_DISPLAYING_PROJ_LIST);
         taskerVarSave();
      }
      // Switch to tasks
      else if ($list == "t")
      {
         taskerVarSetIsDisplaying(IS_DISPLAYING_TASK_LIST);
         taskerVarSave();
      }
      // Switch lists
      else if ($list == "")
      {
         if (taskerVarIsDisplayingProjectList())
         {
            taskerVarSetIsDisplaying(IS_DISPLAYING_TASK_LIST);
         }
         else
         {
            taskerVarSetIsDisplaying(IS_DISPLAYING_PROJ_LIST);
         }
         taskerVarSave();
      }
   }
   // Add a...
   else if ($op == "a")
   {
      // ... projects
      if (taskerVarIsDisplayingProjectList())      
      {
         $proj = array();
         $name = "";
         $desc = "";

         while (true)
         {
            $parse  = _ParseCommand($rest);
            if ($parse[0] == "")
            {
               break;
            }

            $param = $parse[0];
            $rest  = $parse[2];

            if      ($param == "n")
            {
               $name = $parse[1];
            }
            else if ($param == "`")
            {
               $desc = $parse[1];
               break;
            }
         }

         // Add the new project.
         taskerProjectAdd($name, true, $desc);
      }
      else
      {
      
      }
   }
   // Visibility of a project.
   else if ($op == "h" ||
            $op == "s" ||
            $op == "v")
   {
      $parse = _ParseId($rest);
      
      $id = $parse[0];

      if ($id == ".")
      {

      }
   }
}

// Display the result page.
taskerDisplay();
