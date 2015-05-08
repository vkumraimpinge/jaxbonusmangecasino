<?php

define("CASINO_PLUGIN_PATH", plugin_dir_path(__FILE__)); 

$plgurl = WP_PLUGIN_URL .'/'. str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

define("CASINO_PLUGIN_IMAGEURL",$plgurl ); 


define("TBL_CASINO", "casino") ;
define("TBL_GAMES", "games") ;
define("TBL_GAME_CASINO", "game_casino") ;
// define("TBL_GAME_COUNTRY", "game_country") ;
define("TBL_CODE_CASINO", "code_casino") ;
// define("TBL_CODES", "codes") ;
//define("TBL_CODE_COUNTRY", "code_country") ;
define("TBL_COUNTRIES", "countries") ;



/*define page size for casinos*/

define("CASINO_PAGE_SIZE", "3") ;
$permalink=0;
if (get_option('permalink_structure') == '')
$permalink=0;
else
$permalink=1;
    
define("CASINO_REWRITE", $permalink) ;

/*GET SEARCH PAGE Id*/
$args=array(
'post_type'  => 'page',  /* overrides default 'post' */
'meta_key'   => '_wp_page_template',
'meta_value' => 'page-templates/search_game_casinos.php'
);  

$pages_template = get_pages($args); 


$search_page_id=0;
$search_page_slug=0;

if($pages_template && count($pages_template)):

    $search_page_id=$pages_template[0]->ID;
    $spost = get_post($search_page_id);
    $search_page_slug = $spost->post_name;

endif;
define("CASINO_SEARCH_PAGE_ID", $search_page_id) ;
define("CASINO_SEARCH_PAGE_SLUG", $search_page_slug) ;

/*Define name of first game*/
define("FIRST_GAME_NAME",'RTG') ;


define("DO_ACTIONS","casino_action_") ;  // Don't modify this else need to modify the function names 


add_action('admin_print_styles', 'cst_add_stylesheet');

function cst_add_stylesheet() 
{
       $cst_pluginPath = WP_PLUGIN_DIR .'/'. str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
       $cst_pluginURL  = WP_PLUGIN_URL .'/'. str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
       
       $cst_styleUrl  = $cst_pluginURL . 'manage_casino_style.css';
       $cst_StyleFile = $cst_pluginPath . 'manage_casino_style.css' ;
     
       if ( file_exists($cst_StyleFile) ) 
       {
			if(is_admin() && ($_GET['page']== 'manage-casino' || $_GET['page']== 'manage-games' ) )
			{
			   wp_register_style('cst_stylesheet', $cst_styleUrl);
			   wp_enqueue_style( 'cst_stylesheet');
			}   
       }
       
       if(is_admin() && ($_GET['page']== 'manage-casino' || $_GET['page']== 'manage-games' ) )
        {
			$fileexist =  $cst_pluginPath . 'demo_table.css';
			if ( file_exists($fileexist) ) 
			{
				wp_register_style('cst_stylesheet2', $cst_pluginURL.'demo_table.css');
				wp_enqueue_style( 'cst_stylesheet2');
			} 
		} 
       
       
}
 
//////////////////////////////////////////////////////////////////////////////////////
 
/// Needed Scripts for the PLUGIN  in Admin 

 
add_action('admin_print_styles', 'cst_add_scripts');


function cst_add_scripts() 
{
       
		$cst_pluginPath = WP_PLUGIN_DIR .'/'. str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		$cst_pluginURL  = WP_PLUGIN_URL .'/'. str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

		$cst_scriptUrls  = array() ;
		$cst_ScriptFiles = array() ; 


		$cst_scriptUrls[]  =  $cst_pluginURL . 'jquery-1.8.3.min.js';
		$cst_ScriptFiles[] =  $cst_pluginPath . 'jquery-1.8.3.min.js' ;
		
        if(is_admin() && ($_GET['page']== 'manage-casino' || $_GET['page']== 'manage-games' ) )
        {
			$cst_scriptUrls[]  =  $cst_pluginURL . 'jquery.dataTables.js';
			$cst_ScriptFiles[] =  $cst_pluginPath . 'jquery.dataTables.js' ;
		}   
		 

		$count_script = 0 ;
        
        if(is_admin() && ($_GET['page']== 'manage-casino' || $_GET['page']== 'manage-games' ) )
        {
				foreach($cst_ScriptFiles as $sfile)
				{
					   if ( file_exists($sfile) ) 
					   {
						   $handler = 'cst_script'.$count_script ; 
						   
						   wp_register_script($handler,$cst_scriptUrls[$count_script] ); 
						  
						   wp_enqueue_script($handler);
						   
						   $count_script = $count_script+1 ;
					   }
				} 
		}
				   
}


///////////////////////////////////////////////////////////////////////////////////


?>
