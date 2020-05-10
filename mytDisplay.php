<?php
/* mytDisplay *****************************************************************

Author: Robbert de Groot

Description:

Display the interface.

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
// constant
define("CMD_STATUS_NW",             "Needs Work");
define("CMD_STATUS_IW",             "In Work");
define("CMD_STATUS_NT",             "Needs Testing");
define("CMD_STATUS_IT",             "In Testing");
define("CMD_STATUS_ND",             "Needs Doc.");
define("CMD_STATUS_ID",             "In Doc.");
define("CMD_STATUS_NR",             "Needs Release");
define("CMD_STATUS_IR",             "In Release");
define("CMD_STATUS_AR",             "Archive Released");
define("CMD_STATUS_AD",             "Archive Done");
define("CMD_STATUS_AN",             "Archive None");

///////////////////////////////////////////////////////////////////////////////
// include
require_once "zDebug.php";

require_once "mytVariable.php";
require_once "mytProject.php";
require_once "mytTask.php";

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Display the page.
function mytDisplay()
{
   // Before display sort the list.
   mytProjectSort();

   if (!mytVarIsDisplayingProjectList())
   {
      mytTaskSort();
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
  <title>Zekaric:MYT</title>
 </head>

 <body>
  
  <h1>Zekaric : MYT 
END;
   
   if (mytVarIsDisplayingProjectList())
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
    <tr>
END;

   // Get the project list.  It's always needed.
   $countProject = mytProjectGetCount();

   ////////////////////////////////////////////////////////////////////////////
   // Printing the project list.
   if (mytVarIsDisplayingProjectList())
   {
      /////////////////////////////////////////////////////////////////////////
      // Print the table header.

      print <<< END
      <th><nobr>n:PID</nobr></th>
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
         if (mytProjectIsVisible($index))
         {
            $projIsVis = "<img class=sized src=rankBit1.svg />";
         }

         // Get the project name.
         $projId   = mytProjectGetId($index);
         $projName = str_replace(" ", "&nbsp;", mytProjectGetName($index));
         $projDesc = mytProjectGetDescription($index);

         // Display the project data.
         if (($index % 2) == 0)
         {
            print "         <tr class=\"rowAlt\">\n";
         }
         else
         {
            print "         <tr>\n";
         }
		 
         print "" .
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
      // Print the task visibility
      print <<< END
     <td> 
      <table class="narrow">
       <tbody>
        <tr>
         <th>Task Visibility</th>
        </tr>
        <tr>
         <td>
END;

      // Print the task visibilities.
      $aIsVis = "<img class=sized src=rankBit0.svg />";
      if (mytVarIsVisibleArchive())
      {
         $aIsVis = "<img class=sized src=rankBit1.svg />";
      }
      $dIsVis = "<img class=sized src=rankBit0.svg />";
      if (mytVarIsVisibleDocumentation())
      {
         $dIsVis = "<img class=sized src=rankBit1.svg />";
      }
      $rIsVis = "<img class=sized src=rankBit0.svg />";
      if (mytVarIsVisibleRelease())
      {
         $rIsVis = "<img class=sized src=rankBit1.svg />";
      }
      $tIsVis = "<img class=sized src=rankBit0.svg />";
      if (mytVarIsVisibleTesting())
      {
         $tIsVis = "<img class=sized src=rankBit1.svg />";
      }
      $wIsVis = "<img class=sized src=rankBit0.svg />";
      if (mytVarIsVisibleWork())
      {
         $wIsVis = "<img class=sized src=rankBit1.svg />";
      }

      print "" .
         "        <tr class=\"rowAlt\"><td><nobr>" . $wIsVis . " Work         </nobr></td></tr>" .
         "        <tr                 ><td><nobr>" . $tIsVis . " Testing      </nobr></td></tr>" .
         "        <tr class=\"rowAlt\"><td><nobr>" . $dIsVis . " Documentation</nobr></td></tr>" .
         "        <tr                 ><td><nobr>" . $rIsVis . " Release      </nobr></td></tr>" .
         "        <tr class=\"rowAlt\"><td><nobr>" . $aIsVis . " Archive      </nobr></td></tr>" .
         "       </tbody>\n" .
         "      </table>\n" .
         "     </td>\n";

      /////////////////////////////////////////////////////////////////////////
      // Print the table header

      print <<< END
     <td> 
      <table class="narrow">
       <tbody>
        <tr>
         <th><nobr>PID</nobr></th>
          <th><nobr>Vis</nobr></th>
           <th><nobr>Project</nobr></th>
        </tr>
END;
      
      // For all projects...
      for ($index = 0; $index < $countProject; $index++)
      {
         // Get the visibilty string.
         $projIsVis = "<img class=sized src=rankBit0.svg />";
         if (mytProjectIsVisible($index))
         {
            $projIsVis = "<img class=sized src=rankBit1.svg />";
         }

         // Get the project name.
         $projId   = mytProjectGetId($index);
         $projName = str_replace(" ", "&nbsp;", mytProjectGetName($index));

         // Display the project data.
         if (($index % 2) == 0)
         {
            print "         <tr class=\"rowAlt\">\n";
         }
         else
         {
            print "         <tr>\n";
         }

         print "" . 
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
          <th>i:ID</th>
           <th>n:PID</th>
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
      $count = mytTaskGetCount();

      $rowIndex = 0;
      for ($index = 0; $index < $count; $index++)
      {
         // Get the data.
         $taskId   = mytTaskGetId($index);
         $projId   = mytTaskGetIdProject($index);

         // Check if we should be displaying this task.
         if (!mytProjectIsVisibleFromId($projId))
         {
            continue;
         }

         $status = mytTaskGetStatus($index);
         if (($status == "nw" || $status == "iw") &&
             !mytVarIsVisibleWork())
         {
            continue;
         }
         if (($status == "nt" || $status == "it") &&
             !mytVarIsVisibleTesting())
         {
            continue;
         }
         if (($status == "nd" || $status == "id") &&
             !mytVarIsVisibleDocumentation())
         {
            continue;
         }
         if (($status == "nr" || $status == "ir") &&
             !mytVarIsVisibleRelease())
         {
            continue;
         }
         if (($status == "ar" || $status == "ad" || $status == "an") &&
             !mytVarIsVisibleArchive())
         {
            continue;
         }

         $projName = str_replace(" ", "&nbsp;", mytProjectGetNameFromId($projId));

         // Get the priority image.
         switch (mytTaskGetPriority($index))
         {
         default:
         case 1: $taskPriority = "<img class=sized src= rank1.svg />"; break;
         case 2: $taskPriority = "<img class=sized src= rank2.svg />"; break;
         case 3: $taskPriority = "<img class=sized src= rank3.svg />"; break;
         case 4: $taskPriority = "<img class=sized src= rank4.svg />"; break;
         case 5: $taskPriority = "<img class=sized src= rank5.svg />"; break;
         }

         // Get the effort image.
         switch (mytTaskGetEffort($index))
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
         switch ($status)
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
         $taskDesc = mytTaskGetDescription($index);

         // Display the task.
         $alt = "";
         if (($rowIndex % 2) == 0) 
         {
            $alt = "Alt";
         }

         switch ($status)
         {
         default:
         case "nw": print "        <tr class=\"rowStyle1" . $alt . "\">\n"; break;
         case "iw": print "        <tr class=\"rowStyle2" . $alt . "\">\n"; break;
         case "nt": print "        <tr class=\"rowStyle3" . $alt . "\">\n"; break;
         case "it": print "        <tr class=\"rowStyle4" . $alt . "\">\n"; break;
         case "nd": print "        <tr class=\"rowStyle5" . $alt . "\">\n"; break;
         case "id": print "        <tr class=\"rowStyle6" . $alt . "\">\n"; break;
         case "nr": print "        <tr class=\"rowStyle7" . $alt . "\">\n"; break;
         case "ir": print "        <tr class=\"rowStyle8" . $alt . "\">\n"; break;
         case "ar": print "        <tr class=\"rowStyle9" . $alt . "\">\n"; break;
         case "ad": print "        <tr class=\"rowStyle9" . $alt . "\">\n"; break;
         case "an": print "        <tr class=\"rowStyle9" . $alt . "\">\n"; break;
         }

         print "" .
            "          <td class=\"num\">"        . $taskId        . "</td>\n" .
            "           <td class=\"num\">"       . $projId        . "</td>\n" .
            "            <td>"                    . $projName      . "</td>\n" .
            "             <td>"                   . $taskPriority  . "</td>\n" .
            "              <td>"                  . $taskEffort    . "</td>\n" .
            "               <td>"                 . $taskStatus    . "</td>\n" .
            "                <td class=\"fill\">" . $taskDesc      . "</td>\n" .
            "        </tr>\n";

         $rowIndex++;
      }

      // Print a count. 
      print "" .
         "        <tr>\n" .
         "          <td class=\"num\"><nobr>Count: " . $rowIndex . "</nobr></td>\n" .
         "           <td></td>\n" .
         "            <td></td>\n" .
         "             <td></td>\n" .
         "              <td></td>\n" .
         "               <td></td>\n" .
         "                <td class=\"fill\"></td>\n" .
         "        </tr>\n";
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
   
   if (!mytVarIsDisplayingProjectList())
   {
      print <<< END
  <table>
   <tbody>
    <tr>
     <th class="fill">Default values</th>
    </tr>
    <tr>
     <td class="fill"><nobr>
END;

      // Print the defaults.
      $defaultPid     = mytVarGetDefaultIdProject();
      $defaultProject = mytProjectGetNameFromId($defaultPid);
      switch (mytVarGetDefaultPriority($index))
      {
      default:
      case 1: $defaultPriority = "<img class=sized src= rank1.svg />"; break;
      case 2: $defaultPriority = "<img class=sized src= rank2.svg />"; break;
      case 3: $defaultPriority = "<img class=sized src= rank3.svg />"; break;
      case 4: $defaultPriority = "<img class=sized src= rank4.svg />"; break;
      case 5: $defaultPriority = "<img class=sized src= rank5.svg />"; break;
      }
   
      // Get the effort image.
      switch (mytVarGetDefaultEffort($index))
      {
      default:
      case 0: $defaultEffort = "<img class=sized src= rank0.svg />"; break;
      case 1: $defaultEffort = "<img class=sized src= rank1.svg />"; break;
      case 2: $defaultEffort = "<img class=sized src= rank2.svg />"; break;
      case 3: $defaultEffort = "<img class=sized src= rank3.svg />"; break;
      case 4: $defaultEffort = "<img class=sized src= rank4.svg />"; break;
      case 5: $defaultEffort = "<img class=sized src= rank5.svg />"; break;
      }
   
      print "" .
         "n " . $defaultPid      . " " . $defaultProject . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
         "p " . $defaultPriority . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
         "e " . $defaultEffort;

      print <<< END
     </nobr></td>
    </tr>
   </tobdy>
  </table>
END;
   }

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
    <td><nobr>l</nobr></td>
     <td>Switch between t)ask and p)roject lists</td>
   </tr><tr>
    <td>p[. | [pid]] [ | + | -]</td>
     <td>Set the visibility of project tasks.  "." for all projects instead of a specific project.  "+" to turn on visibility.  "-" to turn off visibility.  Nothing to toggle.</td>
   </tr><tr>
    <td><nobr>P[pid]</nobr></td>
     <td>Same as performing these two commands.  "p." and "p[pid] +".</td>
   </tr><tr>
    <td><nobr>o[col character]*</nobr></td>
     <td>Sort order the list in the order of the columns listed.  User uppercase letter for reverse order.  You can list multiple column characters.</td>
END;

   if (mytVarIsDisplayingProjectList())
   {
      print <<< END
   </tr><tr>
    <td><nobr>a n[string] `[string]</nobr></td>
     <td>Add a new project. "`" option must be last.</td>
   </tr><tr>
    <td><nobr>e[pid] n[string] `[string]</nobr></td>
     <td>Edit a project.  "n" and "`" options but one must be present.  "`" option must be last.</td>
END;
   }
   else
   {
      print <<< END
   </tr><tr>
    <td><nobr>a n[pid] p[1-5] e[1-5 | ?] s[2char] `[string]</nobr></td>
     <td>Add a new task.  If a value is missing then a default value is used. "`" option must be last.</td>
   </tr><tr>
    <td><nobr>e[id] n[pid] p[1-5] e[1-5 | ?] s[2char] `[string]</nobr></td>
     <td>Edit a task.  All are optional but one must exist.  "`" option must be last.</td>
   </tr><tr>
    <td><nobr>~[id]</nobr></td>
     <td>Delete a task.</td>
   </tr><tr>
    <td><nobr>s[id] [[2char] | + | -]</nobr></td>
     <td>Quick edit the status to a specific value, or the next/previous logical status.</td>
   </tr><tr>
    <td><nobr>t[. | a | d | t | w]*</nobr></td>
     <td>Toggle the visibility of tasks.  "." to show/hide all the status.  "a" for archived task.  "d" for documentation tasks.  "t" for testing tasks.  "w" for work tasks.</td>
   </tr>
  </table>

  <table>
   <tr>
    <th colspan="6"><nobr>Status Values</nobr></th>
    <th class="desc"></th>
   </tr><tr>
    <td>nw:</td><td><nobr>Needs Work</nobr></td>
    <td>iw:</td><td><nobr>In Work</nobr></td>
    <td>ar:</td><td><nobr>Archive Released</nobr></td>
   </tr><tr>
    <td>nt:</td><td><nobr>Needs Testing</nobr></td>
    <td>it:</td><td><nobr>In Testing</nobr></td>
    <td>ad:</td><td><nobr>Archive Done</nobr></td>
   </tr><tr>
    <td>nd:</td><td><nobr>Needs Doc.</nobr></td>
    <td>id:</td><td><nobr>In Doc.</nobr></td>
    <td>an:</td><td><nobr>Archive None</nobr></td>
   </tr><tr>
    <td>nr:</td><td><nobr>Needs Release</nobr></td>
    <td>ir:</td><td><nobr>In Release</nobr></td>
   </tr>
  </table>
  
 </body>

</html>
END;
   }
}
