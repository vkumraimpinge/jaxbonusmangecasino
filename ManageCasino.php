<?php

/*
Plugin Name: Manage Casino
Plugin URI: http://impingesolutions.com
Description: This plugin show the Casino listing to users . Admin can enable \ dislable the listing for Casino .

Version: 1.0 
Author:  Upinder Singh
Author URI:  http://impingesolutions.com

*/



/*

 Add css file

*/

require_once('defines.php') ; 
require_once('functions.php') ; 


// Table creation code start here
register_activation_hook(__FILE__,'links_installs');
    
function links_installs () {
   global $wpdb;
    
   $table_name		 	 =  $wpdb->prefix.TBL_CASINO ;
  
   $table_countries  	 =  $wpdb->prefix.TBL_COUNTRIES ;
   
   $table_games 	 	 =  $wpdb->prefix.TBL_GAMES ;
   $table_game_casino 	 =  $wpdb->prefix.TBL_GAME_CASINO ;
   $table_game_country 	 =  $wpdb->prefix.TBL_GAME_COUNTRY ;
   
  // $table_codes  	     =  $wpdb->prefix.TBL_CODES ;
  // $table_code_game  	 =  $wpdb->prefix.TBL_CODE_GAME ;
  // $table_code_country   =  $wpdb->prefix.TBL_CODE_COUNTRY ;
     
   
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  name varchar(200) NOT NULL,
	  description TEXT NULL,
	  image   TINYTEXT,
	  countries  TINYTEXT,
	  date_created DATETIME,
	  enable VARCHAR(1) ,
	  
	  PRIMARY KEY (id)
	);";
      dbDelta($sql);
   }
   
   
			if($wpdb->get_var("show tables like '$table_games'") != $table_games) {
				$sql2 = "CREATE TABLE ".$table_games." (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(200) NOT NULL,
				description TEXT NULL,
				image   TINYTEXT,
				type  enum('casino','cash'),
				deposit enum('0','1'),
				date_created DATETIME,
				date_updated DATETIME,
				enable VARCHAR(1) ,
				PRIMARY KEY (id)
				);";
				dbDelta($sql2);
			}
	 
		   if($wpdb->get_var("show tables like '$table_game_casino'") != $table_game_casino) {
			$sql3 =  "CREATE TABLE ".$table_game_casino." (
			game_id int(11) NOT NULL,
			casino_id TINYTEXT,
			enable VARCHAR(1)
			);";
			dbDelta($sql3);
		  }

		  if($wpdb->get_var("show tables like '$table_game_country'") != $table_game_country) {
			$sql4 =  "CREATE TABLE ".$table_game_country." (
			game_id int(11) NOT NULL,
			country_id TINYTEXT,
			enable VARCHAR(1)
			);";
			dbDelta($sql4);	 
		  }
	  
	
   
   
   if($wpdb->get_var("show tables like '$table_codes'") != $table_codes) {
      $sql5 = "CREATE TABLE " . $table_codes . " (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  name varchar(200) NOT NULL,
	  description TEXT NULL,
	  code   varchar(255),
	  deposit enum ('0','1'),
	  expire  enum('0','1'),
	  date_created DATETIME,
	  date_updated DATETIME,
	  enable VARCHAR(1) ,
	  PRIMARY KEY (id)
	);";
	
      dbDelta($sql5);
   }
    
    
    /*
	 if($wpdb->get_var("show tables like '$table_code_game'") != $table_code_game) {
		$sql6 =  "CREATE TABLE ".$table_code_game." (
		code_id int(11) NOT NULL,
		game_id TINYTEXT,
		enable VARCHAR(1)
		);";
	dbDelta($sql6);
	}
	
	 if($wpdb->get_var("show tables like '$table_code_country'") != $table_code_country)  {
	 $sql7 =  "CREATE TABLE ".$table_code_country." (
		code_id int(11) NOT NULL,
		country_id TINYTEXT,
		enable VARCHAR(1) );" ;
	    dbDelta($sql7);
	}
	
    
    if($wpdb->get_var("show tables like '$table_countries'") != $table_countries) {
		   
      $sql8 = " CREATE TABLE ".$table_countries."(
				id int(11) NOT NULL  AUTO_INCREMENT,
				country_code varchar(2) NOT NULL,
				country_name varchar(100) NOT NULL,
				flag  varchar(200),
				enable enum ('1','0'), 
				PRIMARY KEY (id)
				);" ;
			  dbDelta($sql8);
    }
    */
    
}



///////////////////  Install Countries //////////////////////////// 
if(is_admin())
{
	install_countries() ;
	create_upload_dir() ;
}

function create_upload_dir()
{
		$dirname  = 'casino' ;  // main directory to store images
		$filename = WP_CONTENT_DIR.'/'.$dirname ;

		if (!file_exists($filename)) 
		{
			mkdir(WP_CONTENT_DIR.'/'.$dirname, 0777)	;
		} 
		
		$dirname2   = 'casino_images' ;  // main directory to store images
		$filename2  =  WP_CONTENT_DIR.'/casino/'.$dirname2 ;

		if (!file_exists($filename2)) 
		{
			mkdir(WP_CONTENT_DIR.'/casino/'.$dirname2, 0777) ;
		} 
		
		$dirname3   = 'games_images' ;  // main directory to store images
		$filename3  =  WP_CONTENT_DIR.'/casino/'.$dirname3 ;

		if (!file_exists($filename3)) 
		{
			mkdir(WP_CONTENT_DIR.'/casino/'.$dirname3, 0777);
		} 
		
		$dirname4   = 'flags' ;  // main directory to store images
		$filename4  =  WP_CONTENT_DIR.'/casino/'.$dirname4 ;

		if (!file_exists($filename4)) 
		{
		mkdir(WP_CONTENT_DIR.'/casino/'.$dirname4, 0777);
		} 
}


function install_countries()
{
 	 global $wpdb;	
	 $table_countries  =  $wpdb->prefix ."countries" ;
				$qry   = "select * from ".$table_countries ;
				$res   =  $wpdb->query($qry) ;
	
		if(!$res)
		{ 
			$current = dirname( __FILE__)  ; 
			$current = $current.'\countries.sql' ; 
			$filep 	 = @fopen($current, "r");
			if($filep) 
			{
				while (($sql3 = fgets($filep, 4096)) !== false) 
				{
					if(strpos($sql3,'--CountryName--'))
					{
						$sql3 = str_replace('--CountryName--','`'.$table_countries.'`',$sql3) ;
					}
					$wpdb->query($sql3) ;
				}
				fclose($filep);
			}
		}		
}
/////////////////////////////////////////////////////////////////// 

//////////////////   SHOW ADMIN MENU  in Admin section ////////////////////////

if (!function_exists('ap_admin_menu')) 
{
    function ap_admin_menu() {
        // Add the top-level admin menu
        $page_title = 'Casino' ;
        $menu_title = 'Casino' ;
        $capability = 'manage_options' ;
        $menu_slug  = 'manage-casino'  ;
        $function   = 'manage_casino'  ; 
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function) ;
         
        // Now add the submenu page
        $submenu_page_title = 'Games' ;
        $submenu_title      = 'Manage Games' ; 
        $submenu_slug       = 'manage-games' ;
        $submenu_function   = 'manage_games' ;
        add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function) ;       
         
        // Add submenu page with same slug as parent to ensure no duplicates
        $sub_menu_title = 'Manage Casino' ;
        add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function) ;
    }
    add_action('admin_menu', 'ap_admin_menu');
}


if (!function_exists('manage_casino')) {
    function manage_casino() {
        require_once 'manage_casino.php';
    }

}

if (!function_exists('manage_games')) {
    function manage_games() {
        require_once 'manage_games.php';
    }

}

 


//////////////////   ENDED ADMIN MENU  in Admin section ////////////////////////

?>
