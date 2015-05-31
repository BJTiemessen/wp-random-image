<?php
/*******************************************************************************
* Plugin name: WP Random Image
* Plugin URI: http://www.bjtiemessen.com/
* Description: A plugin that displays a random product image.  Designed to be used for displaying featured, new, or on sale products.
* Author: BJ Tiemessen
* Author URI: http://www.bjtiemessen.com
* Version: 1.0
* Text Domain: wp-random-image
********************************************************************************/


/**
*  Main class of our plugin
*/
class WPRandomImage
{
	//Create an array to store the paths of the pictures in
	public $pic_paths = array();
	
	/****************************
	* Constructor
	* Read in the the list of files to an array so they are ready for use by the other functions.
	* @TODO: Make this read from the Media Library so that you can easily make changes instead of having to upload pictures to a special directory
	*****************************/
	function __construct()
	{
		$dir = plugin_dir_path(__FILE__).'images/';
		$dirhandle = opendir($dir);
		if(is_dir($dir))
		{
			if($dirhandle = opendir($dir))
			{
				while(($filename = readdir($dirhandle)) !== false)
				{
					if($filename != "." && $filename != "..")
					{
						//$this->pic_paths[] = $dir.$filename;
						$this->pic_paths[] = $filename;
					}
				}
				closedir($dirhandle);
			}
		}
		//print_r($this->pic_paths);
	}

	/****************************
	* add_hooks: called to to setup and hook into wp for our class
	*****************************/
	public function add_hooks()
	{

	}

	public function random_image_shortcode()
	{
		$imageurl = plugin_dir_url(__FILE__).$this->pic_paths[mt_rand(0, count($this->pic_paths)-1)];
		$output = '<div class=wp-random-image>';
		$output .= '<img src="'.$imageurl.'" />';
		$output .= '</div>';
		return $output;
	}
}

$wpri_random_image = new WPRandomImage();
add_shortcode('wprandomimg', array($wpri_random_image, 'random_image_shortcode'));