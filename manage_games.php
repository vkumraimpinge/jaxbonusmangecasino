<?php

require_once('defines.php') ; 
require_once('casino.js.php') ; 
 
  
function link_pages_games()
{
   	global $wpdb;
 
	$wpu = $_GET['wpu'];

		switch($wpu) {

		case 'addgame':
		addform_link_games('');
		break;


		case 'insertgame' :	
		 add_new_link_games($mode='');  
		break;

		case 'editgame': 
                   
		if(isset($_GET['linkid']))
		{
		edit_record_games($_GET['linkid']);
		}
		break;

		case 'updategame':
		add_new_link_games($mode='updategame');
		break;

		case 'enablegame' :
		enable_record_link_games();
		break;

		case 'disablegame':
		disable_record_link_games();
		break;
 
		default :
		
		show_data_admin_games('');
		break;
		}

}

function get_admin_countries_options($first=false,$countries="")
{
	global $wpdb ;

	$table = $wpdb->prefix.TBL_COUNTRIES ; 
	//$table_game_country = $wpdb->prefix.TBL_GAME_COUNTRY ; 
    
	$qry = " select * from ".$table." where enable='1'" ;
	$res   =  $wpdb->get_results($qry)  ;
    
   // $qry2 = " select * from ".$table_game_country." where game_id=" ;
	// $res2   =  $wpdb->get_results($qry)  ;
    
    $countries  = trim($countries) ;
   
    $strlen = strlen($countries) ;
  
     
    if($countries!="" && $strlen > 0 )
    {
	   if(strpos($countries,",")) // case for multiple countries
	   {
		$countries = explode(",",$countries) ;
		$countries = array_filter($countries) ;
	   }
	   else  // case for single country
	   {
	   $countries = array($countries);
	   }
	}
	else
	   {
		   $countries = "" ;
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
				    $return  = "<option value=''> Select Countries </option>"  ; 
			   }
			 
			 if( $strlen >0  && in_array($result->id,$countries) )
			 {
			  $check = "selected='selected'  class='showselected'" ; 
			 }
			 else 
			   {
				   $check =  ''; 
			   }
			 
			  if($return == "")
			  {
				 $return  = "<option value='". $result->id."' ".$check." >".$result->country_name.' ( '.$result->country_code.' )' ."</option>" ; 
			  } 
			  else
				 {
					$return .= "<option value='". $result->id."' ".$check." >".$result->country_name.' ( '.$result->country_code.' )' ."</option>"  ;  
				 }
			  $i++ ;	 
			}	
		}	
	return $return ;	
}


function get_admin_casino_options($first=false,$countries="")
{
	global $wpdb ;

	$table = $wpdb->prefix.TBL_CASINO ; 

	$qry = " select * from ".$table." where enable='1'" ;
	$res   =  $wpdb->get_results($qry)  ;
    
    $countries  = trim($countries) ;
   
    $strlen = strlen($countries) ;
  
     
    if($countries!="" && $strlen > 0 )
    {
	   if(strpos($countries,",")) // case for multiple countries
	   {
		$countries = explode(",",$countries) ;
		$countries = array_filter($countries) ;
	   }
	   else  // case for single country
	   {
	   $countries = array($countries);
	   }
	}
	else
	   {
		   $countries = "" ;
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
				    $return  = "<option value=''> Select Casinos </option>"  ; 
			   }
			 
			 if( $strlen >0  && in_array($result->id,$countries) )
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
	return $return ;	
}	
	

/*
function get_admin_casino_options($casinos="")
{
	global $wpdb ;

	$table = $wpdb->prefix.TBL_GAMES ; 
	
	
}
*/
function addform_link_games($datamsg)
{
//die('Testing by admin ...');

$pg   =  trim($pg)  ;
 
$form    =  "" ;
$content =  "" ; 

$options = get_admin_countries_options($first=false,"") ;
$options_casino = get_admin_casino_options($first=false) ;

$action = "?page=manage-games&wpu=insertgame" ; 

$form .= "<div class='wrap manage_casino'>"  ; 

$form .= '<h2> Add New Game Infomation </h2>' ; // Title of Form

$form .= '<form name="form1" method="post" action="'.$action.'"  enctype="multipart/form-data" >' ;

$settings = array(
'media_buttons' => false
) ;

$content = '' ;
$editor_id = 'description_content' ;


$form .= '<div id="poststuff">
<div class="metabox-holder" id="post-body">
	<div id="post-body-content">
	
	<div id="leftsidebar_content">
			<div id="titlediv">
			 
			<!-- label for="title" id="title-prompt-text">Name </label -->
			<input type="text" autocomplete="off" required="true" id="title" value="" size="30" name="post_title">
			 </div>';
			
		$form .= '<div id="postdivrich" class="postdivrich">'.wp_editor($content, $editor_id, $settings = array('media_buttons' => false)).'</div>';
			
		$form .='<div class="post_casino_image"><label> Upload Image </label><input type="file" required="true" name="casinoimage" id="casinoimage"></div>
	
	
		<div class="submit_form_btn">
		 <input type="submit" name="submit_frm" id="submit_frm" value="Submit" class="button button-primary button-large">
		</div>
		
	</div>
	
		<div id="rightsidebar_content">
			  	
				 
				
		        <div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span> Game Type </span></h3>
				<div class="inside">
				<div id="select-status">
				 Free Casino Game <input type="radio" name="game_type" checked="checked" class="rad_enable" value="0"> <br/>
				Free Casino Cash Game <input type="radio" name="game_type" class="rad_enable" value="1"> 
				</div>
				</div>
				</div>	  
		      
		         
		
		        <div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span> Status </span></h3>
				<div class="inside">
				<div id="select-status">
				 Disable <input type="radio" name="game_enable" checked="checked" class="rad_enable" value="0"> 
				 Enabled <input type="radio" name="game_enable" class="rad_enable" value="1"> 
				</div>
				</div>
				</div>	 
		
		
		</div>	
		
		
		
	</div><!-- /post-body-content -->
	
</div><!-- /post-body -->

</div>' ;

$form .= '</form>' ;


$form .= '</div> ' ;
 

echo $form ; 

}


//////////////////////////////////////////////////////////////////////////////////////////////////

function  show_data_admin_games($datamsg)
{
	
global $wpdb ;

$table_name = $wpdb->prefix .TBL_GAMES ;

$type_data  = "<div id='show_data'>" ;

$type_data .= "<div id='addnewlink'> <label>Games</label><a href='?page=manage-games&wpu=addgame' class='addnewbutton'>Add New</a></div>" ;

$type_data .= "<table cellpadding='0' cellspacing='0' border='0' class='display' id='casino_data'>" ; 
        
      $data = $wpdb->get_row("select count(name) as countr from ".$table_name);   

     $count = $data->countr ; 

		 if($count>0)
         {		  
               $type_data .= "<thead><tr> <th><input type='checkbox' id='selectall'/></th>    <th id='title'>Name</th><th>Description </th> <th>Image</th>
	             <th>Status</th> <th>Actions</th> <th>Date</th></tr></thead><tbody>" ;
              	
				   $table_name = $wpdb->prefix .TBL_GAMES ;
				   $sql = $wpdb->get_results("select * from ".$table_name);
				     
				   $i = 1 ;	
					  foreach($sql as $row_data)
					  {
							
							
							$linkenable = "" ;
							 
							if($row_data->enable==0)
							{
							$linkenable = "<a href='?page=manage-games&wpu=enablegame&linkid=".$row_data->id."'>Enable</a>" ;
							}	
							else 
							 {
							  $linkenable = "<a href='?page=manage-games&wpu=disablegame&linkid=".$row_data->id."'>Disable</a>" ;	 
							 }  
					      
					      $date = $row_data->date_created ;
					      $len = "";
					      if(strlen($row_data->description) >90 ) 
					      {
							  $len = '[...]' ;
						  }
						  else
						    {
								$len = "";
							}
						  
					      $type_data .= "<tr id='casino_".$row_data->id."'>  <td><input class='number_check' type='checkbox' name='doaction[]' value='".$row_data->id."' /></td>
					                    <td>".$row_data->name."</td>
					                    <td>".substr($row_data->description,0,90).$len."</td>" ; 
					                    
					       if(trim($row_data->image)!="")
					       {
							 $url = get_option('siteurl') ;
							 $type_data .= " <td> <img src='".$url.$row_data->image."' class='showmedium_image'></td> " ; 
						   } 
						   else 
						     {
								$type_data .= " <td> &nbsp;</td>" ;  
							 }	                
					       
					       $type_data .= "<td><b>".$linkenable."</b></td>
					               <td><a href='?page=manage-games&wpu=editgame&linkid=".$row_data->id."'> Edit</a>  | <a href='#' data-value='".admin_url()."index.php?doaction=deletegame&linkid=".$row_data->id."'  class='deleterecord' data-linkd=".$row_data->id."> Delete </a> </td>
						           <td>".date('Y M-d',strtotime($row_data->date_created))."</td>
						           </tr> " ;
						 
						  $i++ ; 
						
						}
			
          }
            
          $type_data .= "</tbody> </table>
          
          <div id='do_theaction'><select name='casino_actions' id='casino_actions'><option value=''> Bulk Actions </option> <option value='1'> Delete</option> </select>  <input type='button' name='btn_doaction' id='btn_doaction' value='Apply' data-value='".admin_url()."index.php?doaction=deletegame'></div> </div>  " ;
  
     echo $type_data ; 
      
      if(trim($datamsg)!="")
      {
		 echo "<script> alert('".$datamsg."') ;</script>"  ;
      }	  
      
      
 }
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////

            function add_new_link_games($mode) 
            {
			 
			 //this function is used to insert new records \ update records into database
			   global $wpdb;
		
						  
			   $table_name 			=   $wpdb->prefix.TBL_GAMES ;
			   $table_game_casino 	=	$wpdb->prefix.TBL_GAME_CASINO  ;
			   $table_game_country	=	$wpdb->prefix.TBL_GAME_COUNTRY ;
		      
			   $name   =  trim($_POST['post_title']) ;
			   $desc   =  trim($_POST['description_content']) ; 
			   
			   $countries = "" ; 
                           
			   
			   if(isset($_POST['sel_countries']))
			   {
				   $countries = $_POST['sel_countries'] ;
				  // $countries = @implode(',',@$countries) ;
			   }	
			   
			   if(isset($_POST['sel_casions']))
			   {
				   $sel_casions = $_POST['sel_casions'] ;
				  // $sel_casions = @implode(',',@$sel_casions) ;
				  // $sel_casions = @implode(',',@$sel_casions) ;
			   }
		       
		       $type    = $_POST['game_type'] ;
		       
		       if($type==0)
		       {
				 $type = "casino" ;   
			   }
			   
			   if($type==1)
		       {
				 $type = "cash" ;   
			   }	   
		       
			   $enable  =  0 ;
	 	       $datamsg =  '' ;
			   $image   =  $_FILES['casinoimage']['name'] ;
			   $upload  = false ;
			   $target  =  ""; 
			   $link = "" ; 
			   
			   if(isset($_GET['linkid']))
			   {
				   $link =  $_GET['linkid'] ;
			   }
			    
                if(isset($_POST['game_enable']))
                {			  
			    $enable = $_POST['game_enable'] ; // state 0 means Disabled // state 1  means Enabled 	
				}
			    
			    if($image!='')
			    {
					$target =  WP_CONTENT_DIR."/casino/games_images/" ;
					
					if (!file_exists($target)) {
				     mkdir($target, 0777);
					} 
					else 
					  {
						 $target = $target.$image  ;
						 $length = strlen($target) ;
						 if(move_uploaded_file($_FILES['casinoimage']['tmp_name'],$target)) 
						 $target = substr($target,(strpos($target,'/wp-content/casino/')),$length) ;
					  }	  
				} 
				
				$chk_qry = $wpdb->get_row("select count(name) as countr from ".$table_name." where name='".$name."' and description='".$desc."' and enable='".$enable."' and type='".$type."' and image='".$target."'") ;
				$chk = $chk_qry->countr ; 
				
				if($chk=="" || $chk==0) // do actions if record is not existing 
				{
					  if($mode=='' || $mode == 'insertgame')
					  {
							$qry  =  "INSERT INTO " . $table_name ." (name,description,image,type,date_created,enable) " . 
							"VALUES ('". $name."','".$desc."','".$target."','".$type."',NOW(),".$enable.")";
					  
							$wpdb->query($qry)	;
					  
							$gameid = $wpdb->insert_id;	


							if(count($sel_casions) >0 && is_array($sel_casions))
							{
								foreach($sel_casions as $res)
								 {	
								$qry2  =  "INSERT INTO ".$table_game_casino." (game_id,casino_id) VALUES ('".$gameid."','".$res."')" ;
								$wpdb->query($qry2) ;
								 }
							}
							else
							  {
								$qry2  =  "INSERT INTO ".$table_game_casino." (game_id,casino_id) VALUES ('".$gameid."','".$sel_casions."')" ;
								$wpdb->query($qry2) ; 
							  }
							  
						  
                                                     
                                                            if(count($countries) >0 && is_array($countries))
                                                            {
                                                                    foreach($countries as $res)
                                                                    {	
                                                                    $qry2  =  "INSERT INTO ".$table_game_country." (game_id,country_id) VALUES ('".$gameid."','".$res."')" ;
                                                                    $wpdb->query($qry2) ;
                                                                    }
                                                            }
                                                            else
                                                            {
                                                                   // $qry2  =  "INSERT INTO ".$table_game_country." (game_id,country_id) VALUES ('".$gameid."','".$countries."')" ;
                                                                   // $wpdb->query($qry2) ; 
                                                            }
						  
							$datamsg =  " New Game Added successfully ";
					  }
				 }
				   if($mode=='updategame')
				   {
						 
						$qry  =  "update " .$table_name." set name='".$name."',description='".$desc."',type='".$type."'," ;
						if($target!="")
						$qry .=  "image='".$target."'," ;
						$qry .=  "enable='".$enable."',date_updated= NOW() where id=".$link ;  
						 
					    $wpdb->query($qry) ;
						  
						//  $qry_sel1 = "select * from ".$table_game_casino." where game_id=".$link ;
						//  $res1  =   $wpdb->get_results($qry_sel1) ;
						//  foreach($res1 as $result)
						//	   //if(!in_array($result->casino_id,$sel_casions) )
								//{
								//	$qry_del = "delete * from ".$table_game_casino." where game_id=".$link." and casino_id=".$result->casino_id ;
								//	@$wpdb->query($qry_del) ;
								//}
						//  }
						
						//  foreach($sel_casions as $casino)
						//  {
							//  $qry_sel = $wpdb->get_var("select * from ".$table_game_casino." where game_id=".$link." and casino_id=".$casino) ;
							  
							//  if(!($qry_sel > 0) ||  $qry_sel=="" )
							//  {
							//	$qry3  =  "INSERT INTO " .$table_game_casino." (game_id,casino_id) VALUES ('". $link."','".$casino."')";	
							//	$wpdb->query($qry3) ; 
							//  }
						//  }	   
						 
						// $qry_sel1 = "select * from ".$table_game_country." where game_id=".$link ;
						 // $res1  =   $wpdb->get_results($qry_sel1) ;
						//  foreach($res1 as $result)
						 // {
							   //if(!in_array($result->country_id,$countries) )
								//{
									//$qry_del = "delete * from ".$table_game_country." where game_id=".$link." and country_id=".$result->country_id ;
									//@$wpdb->query($qry_del) ;
								//}
						//  }
						
                                               // if(count($countries) >0 && is_array($countries))
                                                //    {
                                                            //foreach($countries as $country)
                                                           // {
                                                               //     $qry_sel = $wpdb->get_var("select * from ".$table_game_country." where game_id=".$link." and country_id=".$country) ;

                                                            //        if(!($qry_sel > 0) ||  $qry_sel=="" )
                                                            //        {
                                                               //             $qry3  =  "INSERT INTO " .$table_game_country." (game_id,country_id) VALUES ('". $link."','".$country."')";	
                                                              //              $wpdb->query($qry3) ; 
                                                            //        }
                                                          //  }	
                                                            
                                                            
                                                 //   }
                                                  
						$datamsg =  " Game Updated successfully ";
				   }
				 
				show_data_admin_games($datamsg) ;
                                
                                 $redirect= menu_page_url('manage-games',false );
                                
                                 force_redirect($redirect);
                                 exit;
	       }


////////////////////////////////////// ENABLE LINKS ///////////////////////////////////////////////

function enable_record_link_games()
{
  $linkid = "" ;
 
  global $wpdb;
  $table_name = $wpdb->prefix.TBL_GAMES ;
			
  if( (isset($_GET['linkid'])) && ($_GET['linkid']>0))
  {
  $linkid = trim($_GET['linkid']) ;
  }
   
  
  $sql = "update " . $table_name ."  set enable=1  where  id=".$linkid  ;
   
 
  $datamsg = "" ;
   
  if($wpdb->query($sql))
  {
				$datamsg =  " Record  Updated successfully ";
  }
  
   show_data_admin_games($datamsg) ;
   
    $redirect= menu_page_url('manage-games',false );
                                
    force_redirect($redirect);
    exit;

}

/////////////////////////////    DISABLE  LINKS   /////////////////////////////////////////////


function disable_record_link_games()
{
  $linkid = "" ;
  $form  = "" ;
  
 
  global $wpdb;
  $table_name = $wpdb->prefix.TBL_GAMES ;
			
  if( (isset($_GET['linkid'])) && ($_GET['linkid']>0))
  {
  $linkid = trim($_GET['linkid']) ;
  }
  
  if(isset($_GET['type']))
  {
  $form = trim($_GET['type']) ;
  }
   
  
  $sql = "update " . $table_name ." set  enable=0  where  id=".$linkid   ;

  $datamsg = "" ;
   
  if($wpdb->query($sql))
  {
				$datamsg =  " Record Updated successfully ";
  }
  
  show_data_admin_games($datamsg) ;

  $redirect= menu_page_url('manage-games',false );
                                
   force_redirect($redirect);
   exit;
}

///////////////   DELETE A  AD ////////////////////////////////////

 

/////////////////////////////////////////////////////////////////////////////

function edit_record_games($id) 
{
	global $wpdb ;
	$tbl_gm    = $wpdb->prefix .TBL_GAMES ;
	$tbl_gcnt  = $wpdb->prefix.TBL_GAME_COUNTRY ; 
	$tbl_gcas  = $wpdb->prefix.TBL_GAME_CASINO ; 
	
	
	$countries = "" ; 
	$casino    = "" ; 
	
	$chk_qry = $wpdb->get_results("select * from ".$tbl_gm." where id=".$id) ;
        $res_qry = $chk_qry[0] ;
	
	$chk_qry2  = $wpdb->get_results("select  country_id from ".$tbl_gcnt." where game_id=".$id) ;
	
	foreach($chk_qry2 as $res)
	{
		$countries = $countries.$res->country_id.","  ;
	}
	
	$countries = substr($countries,0,-1) ;
	
	
	$chk_qry3  = $wpdb->get_results("select  casino_id from ".$tbl_gcas." where game_id=".$id) ;
	
	foreach($chk_qry3 as $res)
	{
		$casino = $casino.$res->casino_id.","  ;
	}
	
	$casino = substr($casino,0,-1) ;
	
	if($id!="" && $res_qry)
	{
		
		$form       =  "" ;
		$content    =  $res_qry->description ; 
		$name       =  $res_qry->name ;
		$oldimage   =  $res_qry->image ;
		
		$enable     =  $res_qry->enable ;
		
		$type = array() ;
		$enabl = array() ;
		
		if($res_qry->type=='casino')
		{
			$type[0] = "checked=checked" ;	
		}
		else 
		  {
			 $type[0] = "" ; 
		  }
		
		if($res_qry->type=='cash')
		{
			$type[1] = "checked=checked" ;	
		}
		else 
		  {
			 $type[1] = "" ; 
		  }
		
		 
		if($enable== 0)
		{
		$enabl[0] = "checked=checked" ;	
		}
		else
		  {
			  $enabl[0] = "" ;	
		  }
		  
		if($enable== 1)
		{
		$enabl[1] = "checked=checked" ;	
		}
		else
		  {
			  $enabl[1] = "" ;	
		  }
		
		$url = get_option('siteurl') ;      
	 
		$editor_id = 'description_content' ;	 
		
		$options = get_admin_countries_options($first=false,$countries) ;
		$options_casino = get_admin_casino_options($first=false,$casino) ;
		
		$action = "?page=manage-games&wpu=updategame&linkid=".$_GET['linkid'] ; 

		$form .= "<div class='wrap manage_casino'>"  ; 

		$form .= '<h2> Update Game Infomation </h2>' ; // Title of Form

		$form .= '<form name="form_update" method="post" action="'.$action.'"  enctype="multipart/form-data" >' ;

        $current_image = ""; 
        
        if($oldimage!="")
        {
		  $target = $url.$oldimage ;	 
		 $current_image = "<span class='current_image'> <img src='".$target."' class='showmedium_image'></span>"	;
		}
		

		$form .= '<div id="poststuff">
		<div class="metabox-holder" id="post-body">
			<div id="post-body-content">
			
			<div id="leftsidebar_content">
					<div id="titlediv">
					 
					<!-- label for="title" id="title-prompt-text">Name </label -->
					<input type="text" autocomplete="off" required="true" id="title" value="'.$name.'" size="30" name="post_title">
					 
					</div>
					<div id="postdivrich" class="postdivrich">'.wp_editor( $content, $editor_id, $settings = array('media_buttons' => false) ).' </div>
			
					<div class="image_container">
					<div class="post_casino_image"><label> Upload Image </label><input type="file" name="casinoimage" id="casinoimage"></div>'.$current_image.'</div>
			      
			     <div class="submit_form_btn">
				 <input type="submit" name="submit_frm" id="submit_frm" value="Update" class="button button-primary button-large">
				</div>
				
			</div>
			
                        <div id="rightsidebar_content">
					  
						 			
				 
						<div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span> Game Type </span></h3>
						<div class="inside">
						<div id="select-status">
						Free Casino Game <input type="radio" name="game_type" checked="checked" class="rad_enable" '.$type[0].' value="0"> <br/>
						Free Casino Cash Game <input type="radio" name="game_type" class="rad_enable" '.$type[1].'  value="1"> 
						</div>
						</div>
						</div>	

				
						<div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span> Status </span></h3>
						<div class="inside">
						<div id="select-status">
						 Disable <input type="radio" name="game_enable" '.$enabl[0].'  class="rad_enable" value="0"> 
						 Enabled <input type="radio" name="game_enable" '.$enabl[1].' class="rad_enable" value="1"> 
						</div>
						</div>
						</div>	 
				
				
				</div>	
				
				
				
			</div><!-- /post-body-content -->
			
		</div><!-- /post-body -->

		</div>' ;

		$form .= '</form>' ;


		$form .= '</div> ' ;
   
       echo $form ;
   
	}
}

link_pages_games() ;


?>
