
# Zekaric: PHP: z*.php

## Table Of Contents
**1 - Summary**<br />
**2 - Licence: MIT**<br />
**3 - zData**<br />
 3.1 - zDataGet<br />
 3.2 - zDataSave<br />
 3.3 - zDataSet<br />
**4 - zDataList**<br />
 4.1 - zDataListAdd<br />
 4.2 - zDataListGet<br />
 4.3 - zDataListSave<br />
 4.4 - zDataListSet<br />
**5 - zFile**<br />
 5.1 - zDirCreate<br />
 5.2 - zDirIsExsiting<br />
 5.3 - zFileAppendText<br />
 5.4 - zFileConnect<br />
 5.5 - zFileConnectIsGood<br />
 5.6 - zFileDisconnect<br />
 5.7 - zFileIsExisting<br />
 5.8 - zFileLoadText<br />
 5.9 - zFileLoadTextArray<br />
 5.10 - zFileStoreText<br />
 5.11 - zFileStoreTextArray<br />
 5.12 - zFileWriteText<br />
**6 - zLock**<br />
 6.1 - zLockCreate<br />
 6.2 - zLockCreateFile<br />
 6.3 - zLockDestroy<br />
**7 - zUtil**<br />
 7.1 - zUtilGetValue<br />

# 1 - Summary

A collection of generic php functions.  Basically defining a library of useful, lightweight functions for php development.

# 2 - Licence: MIT

```
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
```

# 3 - zData

Functions for managing an array of records.  This will handle the fetching, adding, updating, removal of records in the array of records and for the writing the php file for the array.

## 3.1 - zDataGet

Get a data's key'ed value.

### Use:

```
$value = zDataListGet($data, $key);
```

### Parameter:

|
| **$data** | The data structure. |
| **$key** | The key value in the record we want the value for. |


### Return:

|
| ***** | The value associated with the key for the data.  Type will depend on what is stored there. |


## 3.2 - zDataSave

Save the array of records to a php file.

### Use:

```
zDataSave($file, $data, $varName);
```

### Parameter:

|
| **$file** | The file name to use to write to. |
| **$list** | The list of records. |
| **$varName** | The name of the php variable to be used for the array of records. |


### Return:

No return value.

## 3.3 - zDataSet

Set a data's key'ed value.

### Use:

```
zDataGet($data, $key, $value);
```

### Parameter:

|
| **$data** | The data structure. |
| **$key** | The key value in the data we want to set. |
| **$value** | The value we want to associate with the key. |


### Return:

No return value.

# 4 - zDataList

Functions for managing an array of records.  This will handle the fetching, adding, updating, removal of records in the array of records and for the writing the php file for the array.

## 4.1 - zDataListAdd

Add a new record to the array.

### Use:

```
$index = zDataListAdd($list);
```

### Parameter:

|
| **$list** | The list to modify.  Pass in by reference. |


### Return:

|
| **integer** | The index of the new record. |


## 4.2 - zDataListGet

Get a record's key'ed value from the array.

### Use:

```
$value = zDataListGet($list, $index, $key);
```

### Parameter:

|
| **$list** | The list of records. |
| **$index** | The index of the record in the list. |
| **$key** | The key value in the record we want the value for. |


### Return:

|
| ***** | The value associated with the key for the record.  Type will depend on what is stored there. |


## 4.3 - zDataListSave

Save the array of records to a php file.

### Use:

```
zDataListSave($file, $list, $varName);
```

### Parameter:

|
| **$file** | The file name to use to write to. |
| **$list** | The list of records. |
| **$varName** | The name of the php variable to be used for the array of records. |


### Return:

No return value.

## 4.4 - zDataListSet

Set a record's key'ed value in the array.

### Use:

```
zDataListGet($list, $index, $key, $value);
```

### Parameter:

|
| **$list** | The list of records. |
| **$index** | The index of the record in the list. |
| **$key** | The key value in the record we want to set. |
| **$value** | The value we want to associate with the key. |


### Return:

No return value.

# 5 - zFile

Functions for file io with optional file locking.

## 5.1 - zDirCreate

Create a directory

### Use:

```
$result = zDirCreate($dirName);
```

### Parameter:

|
| **$dirName** | The name of the directory to create. |


### Result:

|
| **bool** | **true** if the directory was created.  **false** if not. |


## 5.2 - zDirIsExsiting

Check if a directory exists.

### Use:

```
$result = zDirIsExisting($dirName);
```

### Parameter:

|
| **$dirName** | The name of the directory. |


### Result:

|
| **bool** | **true** if the directory exists.  **false** if not. |


## 5.3 - zFileAppendText

Append a string to a file.

### Use:

```
zFileAppendText($filePath, $string, $isLocking)
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$string** | The string to append to the file. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **bool** | **true** if the append happened.  **false** if a lock could not be obtained or the file could not be openned. |


## 5.4 - zFileConnect

Connect to a file for reading or writing.

### Use:

```
$fileConnection = zFileConnect($filePath, $mode, $isLocking)
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$mode** | See php fopen() for mode value. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **File Connection Array** | An array of key values. |


## 5.5 - zFileConnectIsGood

Check to see if the file connection was made.

### Use:

```
$result = zFileConnectIsGood($fileCon);
```

### Parameter:

|
| **$fileCon** | The file connection array returned from zFileConnect. |


### Result:

|
| **bool** | **true** if the file is open.  **false** if not. |


## 5.6 - zFileDisconnect

Disconnect from a file.

### Use:

```
zFileDisconnect($fileCon);
```

### Parameter:

|
| **$fileCon** | The file connection array returned from zFileConnect. |


### Result:

No return value;

## 5.7 - zFileIsExisting

Test to see if a file exits.

### Use:

```
$result = zFileIsExisting($filePath);
```

### Parameter:

|
| **$filePath** | Path to the file. |


### Result:

|
| **bool** | **true** if the file exists.  **false** if not. |


## 5.8 - zFileLoadText

Load the entire text file into one giant string.  This routine will open, read, and close the file.  You do not need a file connection array.

### Use:

```
$string = zFileLoadText($filePath, $isLocking);
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **string** | The entire file loaded into a string.  This is assuming the file is a text file. |


## 5.9 - zFileLoadTextArray

Load the entire text file into an array of strings, one line of text file per string.  This routine will open, read, and close the file.  You do not need a file connection array.

### Use:

```
$stringArray = zFileLoadTextArray($filePath, $isLocking);
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **array of strings** | The entire file loaded into an array of strings.  One line per string. |


## 5.10 - zFileStoreText

Replaces the entire file with the provided string.  This routine will open, write, and close the file.  You do not need a file connection array.

### Use:

```
$result = zFileStoreText($filePath, $string, $isLocking);
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$string** | The string to write to the file. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **bool** | **true** when everything was ok.  **false** otherwise. |


## 5.11 - zFileStoreTextArray

Replaces the entire file with the provided array of strings.  This routine will open, write, and close the file.  You do not need a file connection array.

### Use:

```
$result = zFileStoreTextArray($filePath, $lineArray, $isLocking);
```

### Parameter:

|
| **$filePath** | Path to the file. |
| **$lineArray** | The array of strings to write to the file. |
| **$isLocking** | When in doubt pass in true. |


### Result:

|
| **bool** | **true** when everything was ok.  **false** otherwise. |


## 5.12 - zFileWriteText

Write to a file.

### Use:

```
zFileWriteText($fileCon, $string)
```

### Parameter:

|
| **$fileCon** | The file connection array returned from zFileConnect. |
| **$string** | The string to write to the file. |


### Result:

|
| **bool** | always true. |


# 6 - zLock

File/Folder locking at a file/folder level.  This is very simple locking in that it uses and operating system trick of making a folder in the folder you want to make a lock in.  If two processes try to create the same folder, only one process will be successful.  The other will fail.  The one which is successful will be able to proceed.  Releasing the lock will mean the deletion of the folder.  Eventually the other process will be able to create the folder an 'obtain' a lock.

## 6.1 - zLockCreate

Create a lock.

### Use:

```
$lock = zLockCreate($name);
```

### Parameter:

|
| **$name** | Just a generic lock name.  Programmer choice what the name means.  A folder named "lock_" . $name will be created. |


### Return:

|
| **string** | Name of the lock on success.  "" on failure. |


## 6.2 - zLockCreateFile

Create a lock on a specific file name.

### Use:

```
$lock = zLockCreateFile($fileName);
```

### Parameter:

|
| **$fileName** | Name of the file you wish to lock.  A folder named "lock_file_" . $fileName will be created. |


### Return:

|
| **string** | Name of the lock on success.  "" on failure. |


## 6.3 - zLockDestroy

Release a lock.

### Use:

```
zLockDestroy($name);
```

### Parameter:

|
| **$name** | Whatever string you get back from zLockCreate() and zLockCreateFile() is what you need to pass into this function to properly destroy the lock. |


### Return:

No return value.

# 7 - zUtil

A collection of routines that are generic that do not have a dedicated heading for them.

## 7.1 - zUtilGetValue

Fetch the value for a key from a GET or POST message.

### Use:

```
$value = zUtilGetValue($key);
```

### Parameter:

|
| **$key** | The string key you want to find the value for. |


### Result:

|
| **string** | The string for the key.  "" no defined key or value. |

