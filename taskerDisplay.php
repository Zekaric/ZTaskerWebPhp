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

require_once "tasker_Constant.php";
require_once "tasker_Variable.php";
require_once "tasker_ListProject.php";
require_once "tasker_ListTask.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Display the page.
function taskerDisplay()
{
   ////////////////////////////////////////////////////////////////////////////
   // Print the header.
   print <<<END
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

 <head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="style_reset.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Zekaric:Tracker</title>
 </head>

 <body>
  
  <h1>Zekaric : Tracker</h1>

  <table>
   <tbody>
END;

   // Get the project list.  It's always needed.
   $countProject = taskerVarGetListProjectCount();
   $listProject  = taskerVarGetListProject();

   ////////////////////////////////////////////////////////////////////////////
   // Printing the project list.
   if (taskerVarIsDisplayingProjectList())
   {
      /////////////////////////////////////////////////////////////////////////
      // Print the table header.

      print <<< END
    <tr>
     <th>n:P&nbsp;ID</th>
      <th>v:Vis</th>
       <th>N:Project</th>
        <th class="desc">d:Description</th>
    </tr>
    <tr>
END;

      /////////////////////////////////////////////////////////////////////////
      // Print the table contents.

      // For all projects...
      for ($index = 0; $index < $countProject; $index++)
      {
         // Get the project.
         $proj = $listProject[$index];

         // Get the visibilty string.
         $projIsVis = "<img class=sized src=rankBit0.svg />";
         if ($proj[KEY_PROJ_LIST_IS_VISIBLE])
         {
            $projIsVis = "<img class=sized src=rankBit1.svg />";
         }

         // Get the project name.
         $projId   = $index + 1;
         $projName = str_replace(" ", "&nbsp;", $proj[KEY_PROJ_LIST_NAME]);
         $projDesc = $proj[KEY_PROJ_LIST_DESC];

         // Display the project data.
         print "" .
            "     <td class=\"num\">" .     $projId .    "</td>\n" .
            "      <td class=\"bool\">" .   $projIsVis . "</td>\n" .
            "       <td>" .                 $projName .  "</td>\n" .
            "        <td class=\"desc\">" . $projDesc .  "</td>\n" .
            "    </tr>\n";
      }
   }
   ////////////////////////////////////////////////////////////////////////////
   // Printing the task list.
   else
   {
      /////////////////////////////////////////////////////////////////////////
      // Print the table header

      print <<< END
    <tr>
     <th>i:ID</th>
      <th>n:P&nbsp;ID</th>
       <th>N:Project</th>
        <th>p:Priority</th>
         <th>e:Effort</th>
          <th>s:Status</th>
           <th class="desc">d:Description</th>
    </tr>
    <tr>
END;

      /////////////////////////////////////////////////////////////////////////
      // Print the table contents.

      // For all tasks.
      $count = taskerVarGetListTaskCount();
      $list  = taskerVarGetListTask();

      for ($index = 0; $index < $count; $index++)
      {
         // Get the task.
         $task = $list[$index];

         // Get the task Id.
         $taskId = $index + 1;

         // Get the project.
         $projId   = $task[KEY_TASK_LIST_ID_PROJ];
         $proj     = $listProject[$projId];
         $projId  += 1;
         $projName = str_replace(" ", "&nbsp;", $proj[KEY_PROJ_LIST_NAME]);

         // Get the priority image.
         switch ($task[KEY_TASK_LIST_PRIORITY])
         {
         default:
         case 0: $taskPriority = "<img class=sized src= rank0.svg />"; break;
         case 1: $taskPriority = "<img class=sized src= rank1.svg />"; break;
         case 2: $taskPriority = "<img class=sized src= rank2.svg />"; break;
         case 3: $taskPriority = "<img class=sized src= rank3.svg />"; break;
         case 4: $taskPriority = "<img class=sized src= rank4.svg />"; break;
         case 5: $taskPriority = "<img class=sized src= rank5.svg />"; break;
         }

         // Get the effort image.
         switch ($task[KEY_TASK_LIST_EFFORT])
         {
         default:
         case 0: $taskEffort = "<img class=sized src= rank0.svg />"; break;
         case 1: $taskEffort = "<img class=sized src= rank1.svg />"; break;
         case 2: $taskEffort = "<img class=sized src= rank2.svg />"; break;
         case 3: $taskEffort = "<img class=sized src= rank3.svg />"; break;
         case 4: $taskEffort = "<img class=sized src= rank4.svg />"; break;
         case 5: $taskEffort = "<img class=sized src= rank5.svg />"; break;
         }

         // Get the status
         switch ($task[KEY_TASK_LIST_STATUS])
         {
         default:
         case  0: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NW); break;
         case  1: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IW); break;
         case  2: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NT); break;
         case  3: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IT); break;
         case  4: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_ND); break;
         case  5: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_ID); break;
         case  6: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NR); break;
         case  7: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IR); break;
         case  8: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AR); break;
         case  9: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AD); break;
         case 10: $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AN); break;
         }

         // Get the description
         $taskDesc = $task[KEY_TASK_LIST_DESC];

         // Display the task.
         print "" .
            "     <td class=\"num\">" .       $taskId .       "</td>\n" .
            "      <td class=\"num\">" .      $projId .       "</td>\n" .
            "       <td>" .                   $projName .     "</td>\n" .
            "        <td>" .                  $taskPriority . "</td>\n" .
            "         <td>" .                 $taskEffort .   "</td>\n" .
            "          <td>" .                $taskStatus .   "</td>\n" .
            "           <td class=\"desc\">". $taskDesc .     "</td>\n" .
            "    </tr>\n";
      }
   }

   ////////////////////////////////////////////////////////////////////////////
   // Print the rest of the page.
   print <<< END
   </tbody>
  </table>

  <form method="GET">
   <table>
    <tr>
     <td class="vmid">Command:</td>
     <td class="desc"><input name="cmd" id="cmd" type="text" size="100" tabindex="0" autofocus /><input type="submit" hidden /></td>
    </tr>
   </table>
  </form>

  <table>
   <tr>
    <th>Commands</th>
     <th class="desc">Description</th>
   </tr><tr>
    <td>`[t|a|p]</td>
     <td>switch between t)asks, a)rchived tasks, p)rojects lists.</td>
   </tr><tr>
    <td>h.</td>
     <td>hide all projects' tasks.</td>
   </tr><tr>
    <td>h[project&nbsp;id]</td>
     <td>hide a specific project's task.</td>
   </tr><tr>
    <td>s.</td>
     <td>show all projects' tasks.</td>
   </tr><tr>
    <td>s[project&nbsp;id]</td>
     <td>show a specific project's task.</td>
   </tr><tr>
    <td>v.</td>
     <td>toggle the visibility of all projects' tasks.</td>
   </tr><tr>
    <td>v[project&nbsp;id]</td>
     <td>toggle the visibility of a specific project's task.</td>
END;

   if (taskerVarIsDisplayingProjectList())
   {
      print <<< END
   </tr><tr>
    <td>a&nbsp;n[string]&nbsp;`[string]</td>
     <td>add a new project. ` option must be last.</td>
   </tr><tr>
    <td>c[pid]&nbsp;n[string]&nbsp;`[string]</td>
     <td>change a project.  n and ` options but one must be present.  ` option must be last.</td>
END;
   }
   else
   {
      print <<< END
   </tr><tr>
    <td>s[col&nbsp;char]*</td>
     <td>sort the list in the order of the columns listed.</td>
   </tr><tr>
    <td>a&nbsp;n[pid]&nbsp;p[...]&nbsp;e[...]&nbsp;s[2char]&nbsp;`[string]</td>
     <td>add a new task.  If a value is missing then last known value is used. ` option must be last.</td>
   </tr><tr>
    <td></td>
     <td><p>... is "0", "1", "2", "3", "4", or "5".  "?" is an option for e.</p></td>
   </tr><tr>
    <td>c[id]&nbsp;n[pid]&nbsp;p[...]&nbsp;e[...]&nbsp;s[2char]&nbsp;`[string]</td>
     <td>change a task.  All are optional but one must exist.  ` option must be last.</td>
   </tr><tr>
    <td>c[2char][id]</td>
     <td>quick change status of a task.</td>
   </tr><tr>
    <td>c+[id],c-[id]</td>
     <td>quick change status of a task to the next/previous status value.</td>
   </tr>
  </table>

  <table>
   <tr>
    <th colspan="4">Status&nbsp;Values</th>
    <th class="desc"></th>
   </tr><tr>
    <td>nw:</td><td>Needs&nbsp;Work</td>   <td>iw:</td><td>In&nbsp;Work</td>
   </tr><tr>
    <td>nt:</td><td>Needs&nbsp;Testing</td><td>it:</td><td>In&nbsp;Testing</td>
   </tr><tr>
    <td>nd:</td><td>Needs&nbsp;Doc.</td>   <td>id:</td><td>In&nbsp;Doc.</td>
   </tr><tr>
    <td>nr:</td><td>Needs&nbsp;Release</td><td>ir:</td><td>In&nbsp;Release</td>
   </tr><tr>
    <td><br />ar:</td><td><br />Archive&nbsp;Released</td>
   </tr><tr>
    <td>ad:</td><td>Archive&nbsp;Done</td>
   </tr><tr>                               
    <td>an:</td><td>Archive&nbsp;None</td>
   </tr>
  </table>
  
 </body>

</html>
END;
   }
}
