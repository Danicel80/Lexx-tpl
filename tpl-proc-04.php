<?php
/*
------------------------------------
 - TPL File Processor
 - Version 04, 19.01.2026
 - Created by Danicel Alexandru
------------------------------------
*/
class tpl
	{
	// tpl file location
	protected $loc_f_tpl = "";
	
	// main tpl file name
	protected $file_name = "";
  
	// $info stores all the values ​​that need to be replaced
	protected $info = array();
	
	private $fragment_cache = [];

	// the constructor function receives the name of the tpl file as a parameter (optional)
	public function __construct($name = "")
	{
	$this->file_name = $name;
	}

	// the function sets the tpl directory
	public function set_template_dir($tpl_dir)
		{
		if(!file_exists($tpl_dir))
			{
			echo "ERROR! template dir ".$tpl_dir." does not exist.";
			}
		    else
			{
			$this->loc_f_tpl=$tpl_dir;
			}
  		}

	// sets the value of each key
	public function set($key, $value)
		{
		$this->info[$key] = $value;
		}

	// search for tpl files that must be included
	private function search_include($text, $s_bg, $s_end)
  		{
		$dim_s_bg = strlen($s_bg);
  		$dim_s_end = strlen($s_end);
  		$fname_list = array();
  		$start_pos = 0;
		do
			{
			$start_pos = strpos($text, $s_bg, $start_pos);
			if($start_pos !== false)
				{
				$end_pos = strpos($text, $s_end, $start_pos);
  				$fname_list[] = substr($text, $start_pos+$dim_s_bg, $end_pos-$dim_s_bg-$start_pos);
  				$start_pos = $end_pos+$dim_s_end;
				}
		}while($start_pos !== false);
  		return $fname_list;
  		}

	// include other tpl files in the main file
	private function include_tpl($main_tpl)
  		{
  		$tpl_name_list = $this->search_include($main_tpl, "{include=", "}");
  		foreach ($tpl_name_list as $value)
  			{
  			if(!file_exists($this->loc_f_tpl."/".$value))
  				{
  				$main_tpl = str_replace("{include=".$value."}", "ERROR! File ".$value." does not exist.", $main_tpl);
  				}
  				else
  				{
  				$main_tpl = str_replace("{include=".$value."}", file_get_contents($this->loc_f_tpl."/".$value), $main_tpl);
  				}
  			}
  		return $main_tpl;
  		}

	//removes all tags from a file
	private function remove_tags($tpl)
		{ 
		return preg_replace("/{[a-zA-Z0-9_-]+}/", "", $tpl);
		}

	//include a fragment tpl once or more times if it is in a loop
	//this function can be output in echo or used with $object->set("key", $fragment_result); in a larger template
	public function include_fragment($fragment, $arr_values, $remove = false)
		{
		if(!isset($this->fragment_cache[$fragment]))
			{
			$file_path = $this->loc_f_tpl . "/" . $fragment;
			if(!file_exists($file_path))
				{
				return "ERROR! File: ".$file_path." does not exist.";
				}
			//create a cache so file_exists() and file_get_contents() will not be repeated
			$this->fragment_cache[$fragment] = file_get_contents($file_path);
			}
		$fragment_content = $this->fragment_cache[$fragment];
		foreach($arr_values as $key => $value)
			{
			$fragment_content = str_replace("{".$key."}", $value, $fragment_content);
			}
		//remove empty tags
		if($remove)
			{
			$this->remove_tags($fragment_content);
			}
		return $fragment_content;
		}

	//the main part, we replace all the keywords in tpl, after any other files have been included
	public function exe($remove = false)
		{
		if(!file_exists($this->loc_f_tpl."/".$this->file_name))
			{
			return "ERROR! File ".$this->file_name." does not exist.";
			}
		   else
			{
			$tpl = file_get_contents($this->loc_f_tpl."/".$this->file_name);
			$tpl = $this->include_tpl($tpl);
			foreach($this->info as $key => $value)
				{
				$tpl=str_replace("{".$key."}", $value, $tpl);
				}
			if($remove)
				{
				$tpl = $this->remove_tags($tpl);
				}
			return $tpl;
			}
		}
	}
?>