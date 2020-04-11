<?php
/* taskerConstant *************************************************************

Author: Robbert de Groot

Description:

Contants for the program.

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

define("IS_DISPLAYING_PROJ_LIST",   "Project");
define("IS_DISPLAYING_TASK_LIST",   "Task");

define("KEY_PROJ_LIST_NAME",        "name");
define("KEY_PROJ_LIST_DESC",        "description");
define("KEY_PROJ_LIST_IS_VISIBLE",  "isVisible");

define("KEY_TASK_LIST_ID_PROJ",     "idProject");
define("KEY_TASK_LIST_PRIORITY",    "priority");
define("KEY_TASK_LIST_EFFORT",      "effort");
define("KEY_TASK_LIST_STATUS",      "status");
define("KEY_TASK_LIST_DESC",        "description");

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
