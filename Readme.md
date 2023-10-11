Lexx-TPL is a tpl file processor, very simple and easy to use.

Instructions:
  - Create a directory in which to copy the file tpl-proc-03.php
  - Create a directory in which to save the TPL files
  - To use a template (TPL file) in your php files, follow the steps below:
 
// to include the processor in the php
require_once('dir_name/tpl-proc-03.php');

// create a tpl object and enter the name of the template file

$site = new tpl("your-template-name.tpl");

// set the location and name of the directory where we have the TPL file or files

$site->set_template_dir("template_dir_location_and_name");

// execute $site->set() as many times as you need, this function will replace the key from the TPL file with the value

$site->set("key","value");

// in the TPL file the key will be any word enclosed in brackets {example}
// in case you want to include another tpl file in the main tpl file you set above,
// include the expression: {include=name.tpl} in the place where you want to include the file. Replace name.tpl with the name of your file

// the following statement will display the result.

echo $site->exe();

// the exe() function also receives a boolean parameter, the default is False, if True it will remove all the keys from the TPL file that
// have not been replaced with a value via the set() function