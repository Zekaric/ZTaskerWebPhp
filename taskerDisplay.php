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
   // Before display sort the list.
   if (taskerVarIsDisplayingProjectList())
   {
      taskerProjectSort();
   }
   else
   {
      taskerTaskSort();
   }

   ////////////////////////////////////////////////////////////////////////////
   // Print the header.
   print <<<END
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

 <head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="style_reset.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Zekaric:Tasker</title>
 </head>

 <body>
  
  <h1>Zekaric : Tasker 
END;
   
   if (taskerVarIsDisplayingProjectList())
   {
      print "Projects";
   }
   else
   {
      print "Tasks";
   }

   print <<<END
</h1>

  <table>
   <tbody>
END;

   // Get the project list.  It's always needed.
   $countProject = taskerVarGetListProjectCount();

   ////////////////////////////////////////////////////////////////////////////
   // Printing the project list.
   if (taskerVarIsDisplayingProjectList())
   {
      /////////////////////////////////////////////////////////////////////////
      // Print the table header.

      print <<< END
    <tr>
     <th></th>
      <th><nobr>n:P ID</nobr></th>
       <th><nobr>v:Vis</nobr></th>
        <th><nobr>j:Project</nobr></th>
         <th class="fill"><nobr>d:Description</nobr></th>
    </tr>
END;

      /////////////////////////////////////////////////////////////////////////
      // Print the table contents.

      // For all projects...
      for ($index = 0; $index < $countProject; $index++)
      {
         // Get the visibilty string.
         $projIsVis = "<img class=sized src=rankBit0.svg />";
         if (taskerProjectIsVisible($index))
         {
            $projIsVis = "<img class=sized src=rankBit1.svg />";
         }

         // Get the project name.
         $projId   = taskerProjectGetId($index);
         $projName = str_replace(" ", "&nbsp;", taskerProjectGetName($index));
         $projDesc = taskerProjectGetDescription($index);

         // Display the project data.
         print "" .
            "    <tr>\n" .
            "     <td class=\"num\">"        . ($index + 1) . "</td>\n" .
            "      <td class=\"num\">"       . $projId      . "</td>\n" .
            "       <td class=\"bool\">"     . $projIsVis   . "</td>\n" .
            "        <td>"                   . $projName    . "</td>\n" .
            "         <td class=\"fill\">"   . $projDesc    . "</td>\n" .
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
     <td> 
      <table class="narrow">
       <tbody>
        <tr>
         <th><nobr>P ID</nobr></th>
          <th><nobr>Vis</nobr></th>
           <th><nobr>Project</nobr></th>
        </tr>
END;
      
      // For all projects...
      for ($index = 0; $index < $countProject; $index++)
      {
         // Get the visibilty string.
         $projIsVis = "<img class=sized src=rankBit0.svg />";
         if (taskerProjectIsVisible($index))
         {
            $projIsVis = "<img class=sized src=rankBit1.svg />";
         }

         // Get the project name.
         $projId   = taskerProjectGetId($index);
         $projName = str_replace(" ", "&nbsp;", taskerProjectGetName($index));

         // Display the project data.
         print "" .
            "         <tr>\n" .
            "          <td class=\"num\">"   . $projId      . "</td>\n" .
            "           <td class=\"bool\">" . $projIsVis   . "</td>\n" .
            "            <td>"               . $projName    . "</td>\n" .
            "         </tr>\n";
      }

      print <<< END
       </tbody>
      </table>
     </td>
     <td class="fillNoPad">
      <table class="wide">
       <tbody>
        <tr>
         <th></th>
          <th>i:ID</th>
           <th>n:P&nbsp;ID</th>
            <th>j:Project</th>
             <th>p:Priority</th>
              <th>e:Effort</th>
               <th>s:Status</th>
                <th class="fill">d:Description</th>
        </tr>
END;

      /////////////////////////////////////////////////////////////////////////
      // Print the table contents.

      // For all tasks.
      $count = taskerVarGetListTaskCount();

      $rowIndex = 0;
      for ($index = 0; $index < $count; $index++)
      {
         // Get the data.
         $taskId   = taskerTaskGetId($index);
         $projId   = taskerTaskGetIdProject($index);

         if (!taskerProjectIsVisibleFromId($projId))
         {
            continue;
         }

         $projName = str_replace(" ", "&nbsp;", taskerProjectGetNameFromId($projId));

         // Get the priority image.
         switch (taskerTaskGetPriority($index))
         {
         default:
         case 1: $taskPriority = "<img class=sized src= rank1.svg />"; break;
         case 2: $taskPriority = "<img class=sized src= rank2.svg />"; break;
         case 3: $taskPriority = "<img class=sized src= rank3.svg />"; break;
         case 4: $taskPriority = "<img class=sized src= rank4.svg />"; break;
         case 5: $taskPriority = "<img class=sized src= rank5.svg />"; break;
         }

         // Get the effort image.
         switch (taskerTaskGetEffort($index))
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
         switch (taskerTaskGetStatus($index))
         {
         default:
         case "nw": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NW); break;
         case "iw": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IW); break;
         case "nt": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NT); break;
         case "it": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IT); break;
         case "nd": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_ND); break;
         case "id": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_ID); break;
         case "nr": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_NR); break;
         case "ir": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_IR); break;
         case "ar": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AR); break;
         case "ad": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AD); break;
         case "an": $taskStatus = str_replace(" ", "&nbsp;", CMD_STATUS_AN); break;
         }

         // Get the description
         $taskDesc = taskerTaskGetDescription($index);

         // Display the task.
         $rowIndex++;
         print "" .
            "        </tr>\n" .
            "         <td class=\"num\">"         . $rowIndex      . "</td>\n" .
            "          <td class=\"num\">"        . $taskId        . "</td>\n" .
            "           <td class=\"num\">"       . $projId        . "</td>\n" .
            "            <td>"                    . $projName      . "</td>\n" .
            "             <td>"                   . $taskPriority  . "</td>\n" .
            "              <td>"                  . $taskEffort    . "</td>\n" .
            "               <td>"                 . $taskStatus    . "</td>\n" .
            "                <td class=\"fill\">" . $taskDesc      . "</td>\n" .
            "        </tr>\n";
      }
   }

   ////////////////////////////////////////////////////////////////////////////
   // Print the rest of the page.
   print <<< END
        </tr>
       </tbody>
      </table>
     </td>
    </tr>
   </tbody>
  </table>
END;
   
   $defaultPid     = taskerVarGetDefaultIdProject();
   $defaultProject = taskerProjectGetNameFromId($defaultPid);
   switch (taskerVarGetDefaultPriority($index))
   {
   default:
   case 1: $defaultPriority = "<img class=sized src= rank1.svg />"; break;
   case 2: $defaultPriority = "<img class=sized src= rank2.svg />"; break;
   case 3: $defaultPriority = "<img class=sized src= rank3.svg />"; break;
   case 4: $defaultPriority = "<img class=sized src= rank4.svg />"; break;
   case 5: $defaultPriority = "<img class=sized src= rank5.svg />"; break;
   }

   // Get the effort image.
   switch (taskerVarGetDefaultEffort($index))
   {
   default:
   case 0: $defaultEffort = "<img class=sized src= rank0.svg />"; break;
   case 1: $defaultEffort = "<img class=sized src= rank1.svg />"; break;
   case 2: $defaultEffort = "<img class=sized src= rank2.svg />"; break;
   case 3: $defaultEffort = "<img class=sized src= rank3.svg />"; break;
   case 4: $defaultEffort = "<img class=sized src= rank4.svg />"; break;
   case 5: $defaultEffort = "<img class=sized src= rank5.svg />"; break;
   }

   print "<p><nobr>Defaults:" .
      "&nbsp;&nbsp;&nbsp;n:" . $defaultPid . " " . $defaultProject .
      "&nbsp;&nbsp;&nbsp;p:" . $defaultPriority .
      "&nbsp;&nbsp;&nbsp;e:" . $defaultEffort . 
      "</nobr></p>\n";

   print <<< END
  <form method="GET">
   <p><input name="cmd" id="cmd" type="text" size="150" autofocus /></p>
   <input type="submit" hidden />
  </form>

  <table>
   <tr>
    <th>Commands</th>
     <th class="desc">Description</th>
   </tr><tr>
    <td><nobr>"l"["t" | "p"]</nobr></td>
     <td>switch between t)ask and p)roject lists.  "l" by itself will cycle between the views.</td>
   </tr><tr>
    <td>"h."</td>
     <td>hide all projects' tasks.</td>
   </tr><tr>
    <td><nobr>"h"[project id]</nobr></td>
     <td>hide a specific project's task.</td>
   </tr><tr>
    <td>"d."</td>
     <td>display all projects' tasks.</td>
   </tr><tr>
    <td><nobr>"d"[project id]</nobr></td>
     <td>display a specific project's task.</td>
   </tr><tr>
    <td>"v."</td>
     <td>toggle the visibility of all projects' tasks.</td>
   </tr><tr>
    <td><nobr>"v"[project id]</nobr></td>
     <td>toggle the visibility of a specific project's task.</td>
   </tr><tr>
    <td><nobr>"o"[col characters]</nobr></td>
     <td>sort order the list in the order of the columns listed.  User uppercase letter for reverse order.  You can list multiple column characters.</td>
END;

   if (taskerVarIsDisplayingProjectList())
   {
      print <<< END
   </tr><tr>
    <td><nobr>"a" "n"[string] "`"[string]</nobr></td>
     <td>add a new project. "`" option must be last.</td>
   </tr><tr>
    <td><nobr>"e"[pid] "n"[string] "`"[string]</nobr></td>
     <td>change a project.  "n" and "`" options but one must be present.  "`" option must be last.</td>
END;
   }
   else
   {
      print <<< END
   </tr><tr>
    <td><nobr>"a" "n"[pid] "p"["0" - "5"] "e"["0" - "5", "?"] "s"[2char] "`"[string]</nobr></td>
     <td>add a new task.  If a value is missing then last known value is used. "`" option must be last.</td>
   </tr><tr>
    <td><nobr>"e"[id] "n"[pid] "p"["0" - "5"] "e"["0" - "5", "?"] "s"[2char] "`"[string]</nobr></td>
     <td>change a task.  All are optional but one must exist.  "`" option must be last.</td>
   </tr><tr>
    <td><nobr>"s"[id] [[2char] | "+" | "-"]</nobr></td>
     <td>quick change status to a specific status, or the next logical status, or the previous logical status.</td>
   </tr>
  </table>

  <table>
   <tr>
    <th colspan="6"><nobr>Status Values</nobr></th>
    <th class="desc"></th>
   </tr><tr>
    <td>"nw":</td><td><nobr>Needs Work</nobr></td>
     <td>"iw":</td><td><nobr>In Work</nobr></td>
      <td>"ar":</td><td><nobr>Archive Released</nobr></td>
   </tr><tr>
    <td>"nt":</td><td><nobr>Needs Testing</nobr></td>
     <td>"it":</td><td><nobr>In Testing</nobr></td>
      <td>"ad":</td><td><nobr>Archive Done</nobr></td>
   </tr><tr>
    <td>"nd":</td><td><nobr>Needs Doc.</nobr></td>
     <td>"id":</td><td><nobr>In Doc.</nobr></td>
      <td>"an":</td><td><nobr>Archive None</nobr></td>
   </tr><tr>
    <td>"nr":</td><td><nobr>Needs Release</nobr></td>
     <td>"ir":</td><td><nobr>In Release</nobr></td>
   </tr>
  </table>
  
 </body>

</html>
END;
   }
}
