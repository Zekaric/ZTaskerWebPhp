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
require_once "taskerTask.php";

///////////////////////////////////////////////////////////////////////////////
// function

// Return: array
// 0 = param letter
// 1 = param value
// 2 = rest of the string.
function _ParseCommand($str)
{
   // strip off leading space.
   $str    = trim($str);
   $letter = substr($str, 0, 1);
   $str    = trim(substr($str, 1));

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
      $result[1] = $str;
      $result[2] = "";

      return $result;
   }

   // priority or effort value.
   if ($param == "p" ||
       $param == "e" ||
       $param == "n")
   {
      $parseResult = _ParseId($str);

      $result[0] = $param;
      $result[1] = $parseResult[0];
      $result[2] = $parseResult[1];

      return $result;
   }

   // status value.
   if ($param == "s")
   {
      $result[0] = $param;
      $result[1] = substr($str, 0, 2);
      $result[2] = substr($str, 2);

      return $result;
   }
   
   // String to the end of the line or "`"
   if ($param == "j")
   {
      $result[0] = $param;

      $val = "";
      while ($str != "")
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

// Return: array
// 0 = id as a string
// 1 = rest of the string.
function _ParseId($str)
{
   // strip off leading space.
   $str = trim($str);

   // Strip off the number.
   $val = "";
   while ($str != "")
   {
      $letter = substr($str, 0, 1);

      if ($letter == " ")
      {
         break;
      }

      $val .= $letter;
      $str  = substr($str, 1);
   }

   // Prepare the result.
   $result    = array();
   $result[0] = $val;
   $result[1] = $str;

   return $result;
}

///////////////////////////////////////////////////////////////////////////////
// The main page processing.

$isSomethingSet = false;

// Get the operation and command to process.
$str = zUtilGetValue("cmd");

// if there is a command...
if ($str != "")
{
   // Process the command.
   $op  = substr($str, 0, 1);
   $str = substr($str, 1);

   // Change lists.
   if      ($op == "l")
   {
      $list = substr($str, 0, 1);

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
   else if ($op == "a" ||
            $op == "e")
   {
      // Get the id of the project to change.
      unset($id);
      if ($op == "e")
      {
         $parse = _ParseId($str);
         $id    = (int) $parse[0];
         $str   = $parse[1];
      }

      // ... projects
      if (taskerVarIsDisplayingProjectList())      
      {
         unset($name);
         unset($desc);

         while (true)
         {
            $parse  = _ParseCommand($str);
            if ($parse[0] == "")
            {
               break;
            }

            $param = $parse[0];
            $str   = $parse[2];

            if      ($param == "j")
            {
               $isSomethingSet = true;
               $name = $parse[1];
            }
            else if ($param == "`")
            {
               $isSomethingSet = true;
               $desc = $parse[1];
               break;
            }
         }

         // Add the new project.
         if ($op == "a")
         {
            if (!isset($name)) $name  = "[missing]";
            if (!isset($desc)) $desc  = "[missing]";

            taskerProjectAdd($name, true, $desc);
         }
         // Edit the project.
         else
         {
            // Get the index of the project.
            $index = taskerProjectGetIndex($id);

            if (!$isSomethingSet ||
                $index == -1)
            {
               // Nothing to do.
            }
            else 
            {
                                  $isVis = taskerProjectIsVisible(     $index);
               if (!isset($name)) $name  = taskerProjectGetName(       $index);
               if (!isset($desc)) $desc  = taskerProjectGetDescription($index);
   
               taskerProjectEdit($index, $name, $isVis, $desc);
            }
         }
      }
      else
      {
         unset($projId);
         unset($desc);
         unset($priority);
         unset($effort);
         unset($status);

         while (true)
         {
            $parse  = _ParseCommand($str);
            if ($parse[0] == "")
            {
               break;
            }

            $param = $parse[0];
            $str   = $parse[2];

            if      ($param == "n")
            {
               $isSomethingSet = true;
               $projId = (int) $parse[1];
            }
            else if ($param == "p")
            {
               $isSomethingSet = true;
               $priority = (int) $parse[1];

               if ($priority < 1) $priority = 1;
               if ($priority > 5) $priority = 5;
            }
            else if ($param == "e")
            {
               $isSomethingSet = true;
               $effort = $parse[1];

               if ($effort == "?")              $effort = 0;
               if ($effort < 0 || 5 < $effort)  $effort = 0;
            }
            else if ($param == "s")
            {
               $isSomethingSet = true;
               $status = $parse[1];
            }
            else if ($param == "`")
            {
               $isSomethingSet = true;
               $desc = $parse[1];
               break;
            }
         }

         // Add the new project.
         if ($op == "a")
         {
            if (!isset($projId))    $projId     = 1;
            if (!isset($priority))  $priority   = 1;
            if (!isset($effort))    $effort     = 0;
            if (!isset($status))    $status     = "nw";
            if (!isset($desc))      $desc       = "[missing]";

            taskerTaskAdd($projId, $priority, $effort, $status, $desc);
         }
         // Edit the project.
         else
         {
            $index = taskerTaskGetIndex($id);

            if (!$isSomethingSet ||
                $index == -1)
            {
               // Nothing to do.
            }
            else 
            {
               if (!isset($projId))    $projId     = taskerTaskGetIdProject(     $index);
               if (!isset($priority))  $priority   = taskerTaskGetPriority(      $index);
               if (!isset($effort))    $effort     = taskerTaskGetEffort(        $index);
               if (!isset($status))    $status     = taskerTaskGetStatus(        $index);
               if (!isset($desc))      $desc       = taskerProjectGetDescription($index);
   
               taskerTaskEdit($index, $projId, $priority, $effort, $status, $desc);
            }
         }
      }
   }
   // Visibility of a project.
   else if ($op == "h" ||
            $op == "d" ||
            $op == "v")
   {
      $parse = _ParseId($str);
      
      $id = $parse[0];
           
      if ($id == ".")
      {
         $count = taskerVarGetListProjectCount();
         for ($index = 0; $index < $count; $index++)
         {
            // Hide
            if      ($op == "h")
            {
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  false,
                  taskerProjectGetDescription($index));
            }
            // Show
            else if ($op == "d")
            {
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  true,
                  taskerProjectGetDescription($index));
            }
            // Toggle
            else if ($op == "v")
            {
               $val = taskerProjectIsVisible($index);
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  !$val,
                  taskerProjectGetDescription($index));
            }
         }
      }
      else
      {
         $index = taskerProjectGetIndex($id);
         
         if ($index != -1)
         {
            // Hide
            if      ($op == "h")
            {
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  false,
                  taskerProjectGetDescription($index));
            }
            // Show
            else if ($op == "d")
            {
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  true,
                  taskerProjectGetDescription($index));
            }
            // Toggle
            else if ($op == "v")
            {
               $val = taskerProjectIsVisible($index);
               taskerProjectEdit(
                  $index,
                  taskerProjectGetName(       $index),
                  !$val,
                  taskerProjectGetDescription($index));
            }
         }
      }
   }
   else if ($op == "s")
   {
      unset($status);

      $parse = _ParseId($str);
      $id    = (int) $parse[0];
      $index = taskerTaskGetIndex($id);

      $str   = $parse[1];
      $val   = substr(trim($str), 0, 2);

      if      (substr($val, 0, 1) == "+")
      {
         $status = taskerTaskGetStatus($index);
         switch ($status)
         {
         case "nw": $status = "iw"; break;
         case "iw": $status = "nt"; break;
         case "nt": $status = "it"; break;
         case "it": $status = "nd"; break;
         case "nd": $status = "id"; break;
         case "id": $status = "nr"; break;
         case "nr": $status = "ir"; break;
         case "ir": $status = "ar"; break;
         default:   unset($status);
         }
      }
      else if (substr($val, 0, 1) == "-")
      {
         $status = taskerTaskGetStatus($index);
         switch ($status)
         {
         case "iw": $status = "nw"; break;
         case "nt": $status = "iw"; break;
         case "it": $status = "nt"; break;
         case "nd": $status = "it"; break;
         case "id": $status = "nd"; break;
         case "nr": $status = "id"; break;
         case "ir": $status = "nr"; break;
         case "ar": $status = "ir"; break;
         default:   unset($status);
         }
      }
      else
      {
         $status = $val;
         switch ($status)
         {
         case "nw": 
         case "iw": 
         case "nt": 
         case "it": 
         case "nd": 
         case "id": 
         case "nr": 
         case "ir": 
         case "ar":
         case "ad":
         case "an": break;
         default:   unset($status);
         }
      }

      if (isset($status))
      {
         taskerTaskEdit(
            $index, 
            taskerTaskGetIdProject(  $index),
            taskerTaskGetPriority(   $index),
            taskerTaskGetEffort(     $index),
            $status,
            taskerTaskGetDescription($index));
      }
   }
   else if ($op == "o")
   {
      $order = trim($str);
      if (taskerVarIsDisplayingProjectList())
      {
         taskerVarSetSortOrderProject($order);
      }
      else
      {
         taskerVarSetSortOrderTask($order);
      }
      taskerVarSave();
   }
}

// Display the result page.
taskerDisplay();
