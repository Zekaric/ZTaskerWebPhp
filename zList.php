<?php
/* zList **********************************************************************

Author: Robbert de Groot

Description:

Manage a list.php file.

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

///////////////////////////////////////////////////////////////////////////////
// global
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Add to the list.
function zListAdd(&$list)
{
   // Get the index of the new project.
   $index = count($list);

   // Add a new project to the list.
   $list[$index] = array();

   return $index;
}

///////////////////////////////////////////////////////////////////////////////
// Get functions
function zListGet($list, $index, $key)
{
   //zDebugPrint($index." ".$key);
   $array = $list[$index];
   //zDebugPrintArray($array);
   return $array[$key];
}

///////////////////////////////////////////////////////////////////////////////
// Set functions
function zListSet(&$list, $index, $key, $value)
{
   $array = &$list[$index];
   $array[$key] = $value;
}

///////////////////////////////////////////////////////////////////////////////
// local
// function
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// compose the code string.
function zListCompose($varName, $parentIndex, $array)
{
   // Cell is an array.  Get the number of elements.
   $count   = count($array);
   $keyList = array_keys($array);

   // Start the assignment string.
   $str = $varName . "[" . $parentIndex . "] = array(";

   // For each key/value...
   for ($index = 0; $index < $count; $index++)
   {
      // Get the key and value.
      $key   = $keyList[$index];
      $value = $array[$key];
      
      switch (gettype($value))
      {
      case "boolean":   
         if ($value)
         {
            $str .= "\"" . $key . "\" => true ";
         }
         else
         {
            $str .= "\"" . $key . "\" => false";
         }
         break;

      case "integer":
      case "double":
         $str .= "\"" . $key . "\" => " . $value;
         break;

      case "string":
         $str .= "\"" . $key . "\" => \"" . $value . "\"";
         break;
      }

      // Separator or terminator.
      if ($index < $count - 1)
      {
         $str .= ", ";
      }
      else
      {
         $str .= ");\n";
      }
   }

   return $str;
}

///////////////////////////////////////////////////////////////////////////////
// Save the project list.
function zListSave($file, $list, $varName)
{
   $count = count($list);

   $content = "<?php\n";

   for ($index = 0; $index < $count; $index++)
   {
      $content .= zListCompose($varName, $index, $list[$index]);
   }

   zFileStoreText($file, $content, true);
}
