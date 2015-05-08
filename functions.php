<?php


///////////////  Ajax  Action to delete  Games \ Casino \ Codes  /////////////////////////////
if(  isset($_REQUEST['doaction'])  &&  (isset($_REQUEST['linkid']) || isset($_REQUEST['recrds'])) && is_admin()  )
{
	
	$action = trim($_REQUEST['doaction']) ;
	
    $goaction = 'casino_action_'.$action ; 
	
	$goaction() ;
	
}	


function casino_action_deletegame()
{
  $linkid = "" ;
  $sql =  "" ;
  
  global $wpdb;
  $table_name = $wpdb->prefix .TBL_GAMES ;
			
  if( (isset($_REQUEST['linkid'])) && ($_REQUEST['linkid']>0))
  {
  $linkid = trim($_REQUEST['linkid']) ;
  }
  
  
  //recrds
 if($_REQUEST['recrds'] =="" || !isset($_REQUEST['recrds']))
 {
  $sql = "delete from " . $table_name ." where id=".$linkid   ;
 }
 else 
   {
	 $linkid = $_REQUEST['recrds'] ;
	 $sql = "delete from " . $table_name ." where id IN(".$linkid.")" ;   
   }
 
  $datamsg = "" ;
   
  if($wpdb->query($sql))
  {
				$datamsg = " Record Deleted successfully ";
  }
  else 
    {
		$datamsg =  " Something went wrong , \n Can't Delete record " ;
	}
  
 echo $datamsg ;
 exit ;	
}
	
	
function casino_action_deletecasino()
{
	  $linkid = "" ;
	  $sql =  "" ;
	  
	  global $wpdb;
	  $table_name = $wpdb->prefix .TBL_CASINO ;
				
	  if( (isset($_REQUEST['linkid'])) && ($_REQUEST['linkid']>0))
	  {
	  $linkid = trim($_REQUEST['linkid']) ;
	  }
	  
	 if($_REQUEST['recrds']=="" || !isset($_REQUEST['recrds']))
	 {
	  $sql = "delete from " . $table_name ." where id=".$linkid   ;
	 }
	 else 
	   {
		 $linkid = $_REQUEST['recrds'] ;
		 $sql = "delete from " . $table_name ." where id IN(".$linkid.")" ;   
	   }   
	  
	 
	  $datamsg = "" ;
	   
	  if($wpdb->query($sql))
	  {
					$datamsg =  " Record Deleted successfully ";
	  }
	  else 
		{
		$datamsg =  " Something went wrong , \n Can't Delete record " ;
		}	
	
	echo $datamsg ;
	exit ;
	
}	


function casino_action_deletecode()
{
	 $linkid = "" ;
	  $sql =  "" ;
	  
	  global $wpdb;
	  $table_name = $wpdb->prefix .TBL_CODES ;
				
	  if( (isset($_REQUEST['linkid'])) && ($_REQUEST['linkid']>0))
	  {
	  $linkid = trim($_REQUEST['linkid']) ;
	  }
	  
	 if($_REQUEST['recrds']=="" || !isset($_REQUEST['recrds']))
	 {
	  $sql = "delete from " . $table_name ." where id=".$linkid   ;
	 }
	 else
	   {
		 $linkid = $_REQUEST['recrds'] ;
		 $sql = "delete from " . $table_name ." where id IN(".$linkid.")" ;   
	   }   
	  
	 
	  $datamsg = "" ;
	   
	  if($wpdb->query($sql))
	  {
					$datamsg =  " Record Deleted successfully ";
	  }
	  else 
		{
		$datamsg =  " Something went wrong , \n Can't Delete record " ;
		}	
	
	echo $datamsg ;
	exit ;
	
}	

function show_casino_data_frnt()
{
	return " Ok you can get the data from here "  ; 
	
}


/*code added by varun*/

add_action('admin_head', 'change_casino_javascript');

function change_casino_javascript() {
    if(isset($_GET['page']) && $_GET['page']=='manage-codes'){
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

    var casino_selected;
    var code_selected;
   
    code_selected=$("#code_id").val();
      
    casino_selected=$("#sel_casino").val();
    
    if(casino_selected!=""){
            var data = {
                action: 'get_casino_games',
                casino_id: casino_selected,
                code_id:code_selected
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
                //alert(response);
                var select = $('#sel_games');
                select.empty().append(response);
                
            });

        }
        else{
                // alert(response);
                var select = $('#sel_games');
                select.empty().append();
        }




    $('#sel_casino').change(function(){
        
        var casino_selected;
        var code_selected;
   
        code_selected=$("#code_id").val();
        casino_selected=$(this).val();
        
        if(casino_selected!=""){
            var data = {
                action: 'get_casino_games',
                casino_id: casino_selected,
                code_id:code_selected
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
                 //alert(response);
                var select = $('#sel_games');
                select.empty().append(response);
                
            });

        }
        else{
              // alert(response);
                var select = $('#sel_games');
                select.empty().append();
        }
        
        
    });


});
</script>
<?php
}
}

add_action('wp_ajax_get_casino_games', 'get_casino_games');

function get_casino_games() {
    
        global $wpdb ;
    
        $casino_id=$_POST['casino_id'];
        $code_id=$_POST['code_id'];

        $table  = $wpdb->prefix.TBL_GAMES ; 
        $table_game_casino =$wpdb->prefix.TBL_GAME_CASINO  ;
        $table_code_game =$wpdb->prefix.TBL_CODE_GAME  ;
    
	$qry = " select * from ".$table." where enable='1' AND id IN (select game_id from ".$table_game_casino." where casino_id=".$casino_id. ")" ;
      
	$res   =  $wpdb->get_results($qry)  ;
	
	$game=array();
        
        if($code_id!=0 && $code_id!="" && $casino_id!=0 && $casino_id!=""){
            
            $qry1 = " select game_id from ".$table_code_game." where  casino_id=".$casino_id. " AND code_id=".$code_id. " ";

            $res1   =  $wpdb->get_results($qry1)  ;
          
            if($res1 && count($res1)):
                 
                foreach($res1 as $selected_game):
                
                $game[]=$selected_game->game_id;
                
                endforeach;
                
            endif;
            
            
            
            
        }
        
	$return = "" ; 
        $i = 0 ;  
        $check = "" ;
         
        if(array_filter($res) > 0 )
        {
                foreach($res as $result)
                {
                    if($i==0 && $first == true )
                    {
                            $return  = "<option value=''> Select Games </option>"  ; 
                    }

                    if(  in_array($result->id,$game) )
                    {
                        
                    $check = "selected='selected'  class='showselected'" ; 
                    }
                    else 
                    {
                            $check =  ''; 
                    }

                    if($return == "")
                    {
                            $return  = "<option value='". $result->id."' ".$check." >".$result->name."</option>" ; 
                    } 
                    else
                            {
                                $return .= "<option value='". $result->id."' ".$check." >".$result->name."</option>"  ;  
                            }
                    $i++ ;	 
                }	
        }	
        
	echo $return ;	

    
}

/*
function my_htaccess_contents( $rules )
{
$my_content = <<<EOD
 \n
<IfModule mod_rewrite.c>
RewriteRule ^cat/([a-z]+)/n/([0-9]+)$ index.php?cat=$1&n=$2 [L]
RewriteRule ^cat/([a-z]+)/n/([0-9]+)/page/([0-9]+)$ index.php?cat=$1&n=$2&page=$3 [L]

RewriteRule ^searchgame/search/([a-z0-9A-Z]+)/us/([0-9]+)$ index.php/?page_id=26&search=$1&us=$2 [L]
RewriteRule ^searchgame/search/([a-z0-9A-Z]+)/ca/([0-9]+)$ index.php/?page_id=26&search=$1&ca=$2 [L]
RewriteRule ^searchgame/search/([a-z0-9A-Z]+)/us/([0-9]+)/ca/([0-9]+)$ index.php/?page_id=26&search=$1&us=$2&ca=$3 [L]

</IfModule>
\n
EOD;
    return $my_content . $rules;
}
add_filter('mod_rewrite_rules', 'my_htaccess_contents');*/

/*
add_action('init','yoursite_init');
function yoursite_init() {
  global
  $wp,$wp_rewrite;
  $wp->add_query_var('view');
  $wp_rewrite->add_rule('^cat/([a-z]+)/n/([0-9]+)$',
    'index.php?cat=$matches[1]&n=$matches[2]', 'top');

  // Once you get working, remove this next line
  $wp_rewrite->flush_rules(false);  
}*/



 
 
?>
