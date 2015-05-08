<?php

require_once('defines.php') ; 
require_once('casino.js.php') ; 
 

function links_pages()
{
   	global $wpdb;
 
	$wpu = $_GET['wpu'];
	
	
	if(isset($_GET['title']))
	{
	$title = trim($_GET['title']) ; 
	}
   		
		switch($wpu) {

		case 'addcasino':
		addform_link('');
		break;


		case 'insert' :	
		 add_new_link($mode='');  
		break;

		case 'edit': 
		if(isset($_GET['linkid']))
		{
		edit_record($_GET['linkid']);
		}
		break;

		case 'update':
		add_new_link($mode='update');
		break;

	/*	case 'delete' : delete_link();
		break; */

		case 'enable' :
		enable_record_link();
		break;

		case 'disable':
		disable_record_link();
		break;
 
		default :
		show_data_admin('');
		break;
		}

}



function get_admin_countries_options($first=false,$countries="")
{
	global $wpdb ;

	$table = $wpdb->prefix.TBL_COUNTRIES ; 

	$qry = " select * from ".$table." where enable='1'" ;
	$res   =  $wpdb->get_results($qry)  ;
    
    $countries  = trim($countries) ;
   
    $strlen = strlen($countries) ;
  
     
    if($countries!="" && $strlen > 0 )
    {
	   if(strpos($countries,",")) // case for multile countries
	   {
		$countries = explode(",",$countries) ;
		$countries = array_filter($countries) ;
	   }
	   else  // case for single country
	   {
	   $countries = array($countries);
	   }
	} 
	else // case no country
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
			 
			 /*
			 echo $result->id;
			 echo '<pre>';
			 print_r($countries);
			 echo '</pre>';
			 die('Tesing ');
			 */
			 
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



function get_admin_games_options($first=false,$game="")
{
	global $wpdb ;

	$table  	= $wpdb->prefix.TBL_GAMES ; 
	
	$qry = " select * from ".$table." where enable='1'" ;
	$res   =  $wpdb->get_results($qry)  ;
	
	$link  =  $_GET['linkid'] ;
	
	$strlen = strlen($game) ;
	
	if($game!="" && $strlen > 0 )
    {
	   if(strpos($game,",")) // case for multiple countries
	   {
		$game = explode(",",$game) ;
		$game = array_filter($game) ;
	   }
	   else  // case for single country
	   {
	   $game = array($game);
	   }
	}
	else
	   {
		   $game = "" ;
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
			 
			 if( $strlen >0  && in_array($result->id,$game) )
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
	

function addform_link($datamsg)
{
$pg   =  trim($pg)  ;
 
$form    =  "" ;
$content =  "" ; 
 

$options = get_admin_countries_options($first=false) ;

$options_games = get_admin_games_options($first=false) ;

$action = "?page=manage-casino&wpu=insert" ; 

$form .= "<div class='wrap manage_casino'>"  ; 

$form .= '<h2> Add New Casino Infomation </h2>' ; // Title of Form

$form .= '<form  onSubmit="return valide_manage_casino()" id="manage_casino_form" name="form1" method="post" action="'.$action.'"  enctype="multipart/form-data" >' ;

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
			<input type="text" autocomplete="off" id="title" required="true" value="" placeholder="Enter Title" size="30" name="post_title">
			 
			</div>
                        
                        <div id="titlediv">
			 
			<!-- label for="description_content" id="title-prompt-text">Name </label -->
			<input type="text" autocomplete="off" id="title" required="true" value="" placeholder="Enter Casino Link" size="30" name="description_content">
			 
			</div>
                        
			
	
	        <div class="post_casino_image"><label> Upload Image </label><input required="true" type="file" name="casinoimage" id="casinoimage"></div>
	
                <div style="clear:both"></div>
		<div class="submit_form_btn">
		 <input type="submit" name="submit_frm" id="submit_frm" value="Submit" class="button button-primary button-large">
		</div>
                

		
	</div>
	
		<div id="rightsidebar_content">
			  
				<div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span>Select Countries</span></h3>
				<div class="inside">
				<div id="select-countries">
				<select required="true" name="sel_countries[]" id="sel_countries" class="select_countries" multiple="multiple">'.$options.'</select> 

				</div>
				</div>
				</div>	  
		
		
		        <div class="rightsidebox " isel_countriesd="formatdiv2">
				<h3 class="hndle"><span>Select Game</span></h3>
				<div class="inside">
				<div id="select-casions">
				<select style="height:auto;min-height:30px" name="sel_games[]" id="sel_games" required="true" data-value="Select Game for Code" class="select_casions casinorequire" >'.$options_games.'</select> 
				<label class="casinoerror2"></label>
				</div>
				</div>
				</div>	  
				
				
							<div class="rightsidebox" id="formatdiv">
							<h3 class="hndle"><span> No Deposit Codes</span> </h3>
							<div class="inside">
							<div id="no_deposit_codes">
							   <p> <img style="cursor:pointer" src="'.CASINO_PLUGIN_IMAGEURL.'/image/plus.png" class="casino_addinput" ></p>
							 <input type="text" name="no_deposit_code1" class="no-deposit-codes">
							 <input type="text" name="no_deposit_code2" class="no-deposit-codes casinohide"> 
							</div>
							</div>
							</div>	
							
							
							<div class="rightsidebox " id="formatdiv" style="max-height:1000px">
							<h3 class="hndle"><span> Previous Working Codes </span></h3>
							<div class="inside">
							<div id="prev_working_codes">
							 <p> <img style="cursor:pointer" src="'.CASINO_PLUGIN_IMAGEURL.'/image/plus.png" class="casino_addinput" ></p>
							 <input type="text" name="prev_working_codes[]" class="prev-working-codes">
							
							</div>
							</div>
							</div>	
							
							
							<div class="rightsidebox " id="formatdiv">
							<h3 class="hndle"><span> Daily Desposit Promo </span></h3>
							<div class="inside">
							<div id="daily_promo">
							  <input type="text" name="daily_promo_codes" class="daily-promo-codes">
							
							</div>
							</div>
							</div>	
							
		 
		
		        <div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span> Status </span></h3>
				<div class="inside">
				<div id="select-status">
				 Disable <input type="radio" name="casino_enable" checked="checked" class="rad_enable" value="0"> 
				 Enabled <input type="radio" name="casino_enable" class="rad_enable" value="1"> 
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

function  show_data_admin($datamsg)
{
	
global $wpdb ;
$table_name = $wpdb->prefix .TBL_CASINO ;

$type_data = "<div id='show_data'>" ;

$type_data .= "<div id='addnewlink'> <label>Casino</label><a href='?page=manage-casino&wpu=addcasino' class='addnewbutton'>Add New</a></div>" ;

$type_data .= "<table cellpadding='0' cellspacing='0' border='0' class='display' id='casino_data'>" ; 

// $type_data .= "<tr><td colspan='6'><div id='datamsg'>".$datamsg." </div> </td></tr>" ; 

        
	   $data = $wpdb->get_row("select count(name) as countr from ".$table_name);   
       $count = $data->countr ; 

		 if($count>0)
         {		  
               $type_data .= "<thead><tr> <th><input type='checkbox' id='selectall'/></th>    <th id='title'>Name</th><th>Description </th> <th>Image</th>
	             <th>Status</th> <th>Actions</th> <th>Date</th></tr></thead><tbody>" ;
              	
				   
				   $sql = $wpdb->get_results("select * from ".$table_name);
				     
				 $i = 1 ;	
					  foreach($sql as $row_data)
					  {
							
							
							$linkenable = "" ;
							 
							if($row_data->enable==0)
							{
							$linkenable = "<a href='?page=manage-casino&wpu=enable&linkid=".$row_data->id."'>Enable</a>" ;
							}	
							else 
							 {
							  $linkenable = "<a href='?page=manage-casino&wpu=disable&linkid=".$row_data->id."'>Disable</a>" ;	 
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
					               <td><a href='?page=manage-casino&wpu=edit&linkid=".$row_data->id."&type=&pg=".$pg."'> Edit</a>  | <a href='#' data-value='".admin_url()."index.php?doaction=deletecasino&linkid=".$row_data->id."' class='deleterecord' data-linkd=".$row_data->id."> Delete </a> </td>
						           <td>".date('Y M-d',strtotime($row_data->date_created))."</td>
						           </tr> " ;
						  $i++ ; 
						}
	      }
            
          $type_data .= "</tbody> </table>
          
          <div id='do_theaction'><select name='casino_actions' id='casino_actions'><option value=''> Bulk Actions </option> <option value='1'> Delete</option> </select>  <input type='button' name='btn_doaction' id='btn_doaction' value='Apply' data-value='".admin_url()."index.php?doaction=deletecasino'></div> </div>  " ;
  
     echo $type_data ; 
     
     if(trim($datamsg)!="")
     {
	   echo "<script>alert('".$datamsg."') ;</script>" ;
	 }
     
     
 }
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////

            function add_new_link($mode) 
            {
			 //this function is used to insert new records \ update records into database
			   global $wpdb;
		  			  
			   $table_name 		  =  $wpdb->prefix .TBL_CASINO ;
		       $table_gamecasino  =  $wpdb->prefix.TBL_GAME_CASINO ;
		       $table_codecasino  =  $wpdb->prefix.TBL_CODE_CASINO ;
		      
			   $name   =  trim($_POST['post_title']) ;
			   $desc   =  trim($_POST['description_content']) ; 
			   
			   $countries = "" ; 
			   $games   = "" ;   
			  
			  
			   if(isset($_POST['sel_countries']))
			   {
				   $countries = $_POST['sel_countries'] ;
				   $countries = @implode(',',@$countries) ;
			   }	
		   
		          if(isset($_POST['sel_games']))
			   {
				   $games = $_POST['sel_games'] ;
				   $games = array_filter($games) ;
			   }
		       
		        $nodeposit = array() ; 
		        $preworking= array() ;
		        $daily_promo_codes = "" ; 
		        
		       if(isset($_POST['no_deposit_code1']) && trim($_POST['no_deposit_code1'])!="" )
		       {
				  $nodeposit[] =  trim($_POST['no_deposit_code1']) ;
			   }
			   
			   if( isset($_POST['no_deposit_code2'])  && trim($_POST['no_deposit_code2'])!="" )
		       {
				  $nodeposit[] =  trim($_POST['no_deposit_code2']) ;
			   }
			   
			  
			   if(isset($_POST['prev_working_codes'] ))
			   {
			   $preworking = $_POST['prev_working_codes'] ;
			   }
			   
			   if(isset($_POST['daily_promo_codes']))
			   {
		       $daily_promo_codes  = trim($_POST['daily_promo_codes']) ; 
		       }
		   
			   $enable  =  0 ;
	 	       $datamsg =  '' ;
			   $image   =  $_FILES['casinoimage']['name'] ;
			   $upload  = false ;
			   $target  =  ""; 
			    
                if(isset($_POST['casino_enable']))
                {			  
			    $enable = $_POST['casino_enable'] ; // state 0 means Disabled // state 1  means Enabled 	
				}
			    
			    if($image!='')
			    {
					$target =  WP_CONTENT_DIR."/casino/casino_images/" ;
					
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
				
				$chk_qry = $wpdb->get_row("select count(name) as countr from ".$table_name." where name='".$name."' and description='".$desc."' and countries='".$countries."' and enable='".$enable."' and image='".$target."'") ;
				
				$chk = $chk_qry->countr ; 
				
				if($chk=="" || $chk==0) // do actions if record is not existing 
				{
				  
						if(trim($name)!="" && trim($desc)!="")
						{
							  if($mode=='' || $mode == 'insert')
							  {
								  $qry  =  "INSERT INTO " . $table_name ." (name,description,image,countries,date_created,enable) " . 
								"VALUES ('". $name."','".$desc."','".$target."','".$countries."',NOW(),".$enable.")";
							        $wpdb->query($qry) ;
							        
							        $casino_id = $wpdb->insert_id;
									
									if($casino_id != "" && $casino_id >0)
									{
											foreach($games as $gm)
											{ 
												$qry_games  = "INSERT INTO ".$table_gamecasino." (game_id,casino_id) VALUES('". $gm."','".$casino_id."')"; 
												$wpdb->query($qry_games)  ;
											} 	
											
											$nodeposit = array_filter($nodeposit) ;
											if(count($nodeposit)>0)
											{
												  foreach($nodeposit as $nd)
												  {
												$qrynd  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','nodepst','".$nd."')"; 
												$wpdb->query($qrynd)  ;  
												  }	  
											}
											
											$preworking = @array_filter($preworking) ;
											if(count($preworking)>0)
											{
												  foreach($preworking as $pv)
												  {
												$qrypv  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','prev','".$pv."')"; 
												$wpdb->query($qrypv)  ;  
												  }	  
											}
											
											if(trim($daily_promo_codes)!="")
											{
											   $qrydaily  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','daily','".$daily_promo_codes."')"; 
											   $wpdb->query($qrydaily)  ; 
											} 
							        }
							   }
						}	
						
						$datamsg =  " New Casino Information Added successfully ";
								 
					}	
							 
							  
							   if($mode=='update')
							   {
								  $link = $_GET['linkid'] ;
								  
								  $qry  =  "update " . $table_name ." set name='".$name."',description='".$desc."'," ;
								  
								  if($target!="")
								  $qry .=  "image='".$target."'," ;
								  
								  $qry .= "countries='".$countries."',enable='".$enable."' where id=".$link ; 
							    
                                                                  $wpdb->query($qry) ;
							       
							      $games = array_filter($games) ;
                                                                  
                                                                  if(count($games)>0)
                                                                    {
                                                                                    $sel_game_qry = $wpdb->get_results("select * from ".$table_gamecasino." where casino_id=".$link) ;

                                                                                    $oldgames = array() ;

                                                                                    foreach($sel_game_qry as $gqry)
                                                                                    {
                                                                                    $oldgames[] = $gqry->game_id ;	
                                                                                    }

                                                                                    foreach($oldgames as $gm)
                                                                                    { 
                                                                                    if(!in_array($gm,$games)) 
                                                                                    {
                                                                                            $qry_games  = "delete from ".$table_gamecasino." where game_id='".$gm."' and casino_id='".$link."'"; 
                                                                                            //echo $qry_games."<br/>" ;
                                                                                            $wpdb->query($qry_games)  ;
                                                                                    }
                                                                                    }

                                                                                    foreach($games as $ngm)
                                                                                    { 
                                                                                    if(!in_array($ngm,$oldgames)) 
                                                                                    {
                                                                                            $qry_ins  = "insert into ".$table_gamecasino." (game_id, casino_id) values('".$ngm."','".$link."')" ; 
                                                                                            //echo $qry_ins."<br/>" ;
                                                                                            $wpdb->query($qry_ins)  ;
                                                                                    }
                                                                                    }
                                                                    }
                                                                    
                                                                    
                                                                    /*First delete all types of codes of a casino*/
                                                                    
                                                                    $qry_casino_codes  = "delete from ".$table_codecasino." where casino_id='".$link."'"; 
                                                                                            
                                                                    $wpdb->query($qry_casino_codes)  ;
                                                                    
                                                                    $casino_id=$link;
                                                                    
                                                                    /*add new codes for casino */
                                                                    $nodeposit = array_filter($nodeposit) ;
                                                                    if(count($nodeposit)>0)
                                                                    {
                                                                                foreach($nodeposit as $nd)
                                                                                {
                                                                            $qrynd  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','nodepst','".$nd."')"; 
                                                                            $wpdb->query($qrynd)  ;  
                                                                                }	  
                                                                    }

                                                                    $preworking = @array_filter($preworking) ;
                                                                    if(count($preworking)>0)
                                                                    {
                                                                                foreach($preworking as $pv)
                                                                                {
                                                                            $qrypv  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','prev','".$pv."')"; 
                                                                            $wpdb->query($qrypv)  ;  
                                                                                }	  
                                                                    }

                                                                    if(trim($daily_promo_codes)!="")
                                                                    {
                                                                        $qrydaily  = "INSERT INTO ".$table_codecasino."(casino_id,type,code) VALUES('".$casino_id."','daily','".$daily_promo_codes."')"; 
                                                                        $wpdb->query($qrydaily)  ; 
                                                                    } 
							                                     $datamsg =  " Casino has been updated successfully ";
							   } 
					
								show_data_admin($datamsg) ;
                                $redirect= menu_page_url('manage-casino',false );
                                
                                force_redirect($redirect);
                                exit;
	       }


////////////////////////////////////// ENABLE LINKS ///////////////////////////////////////////////

function enable_record_link()
{
  $linkid = "" ;
 
  global $wpdb;
  $table_name = $wpdb->prefix .TBL_CASINO ;
			
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
  
  show_data_admin($datamsg) ;
  
  $redirect= menu_page_url('manage-casino',false );
                                
    force_redirect($redirect);
    exit;

}

/////////////////////////////    DISABLE  LINKS   /////////////////////////////////////////////


function disable_record_link()
{
  $linkid = "" ;
  $form  = "" ;
  
 
  global $wpdb;
  $table_name = $wpdb->prefix .TBL_CASINO ;
			
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
  
  show_data_admin($datamsg) ;
  
  $redirect= menu_page_url('manage-casino',false );
                                
    force_redirect($redirect);
    exit;

}

///////////////   DELETE A  AD ////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////

function edit_record($id) 
{
 //die('Testing ...');
 
	global $wpdb ;
	
	$table_name        =  $wpdb->prefix .TBL_CASINO ;
	$table_gamecasino  =  $wpdb->prefix.TBL_GAME_CASINO ;
	$table_codecasino  =  $wpdb->prefix.TBL_CODE_CASINO ;
	 
	$chk_qry2  = $wpdb->get_results("select  game_id from ".$table_gamecasino." where casino_id=".$id) ;
        foreach($chk_qry2 as $res)
	{
		        $game = $game.$res->game_id.","  ;
	}
	
	$options_games  = get_admin_games_options($first=false,$game) ;
		
	$chk_qry = $wpdb->get_results("select * from ".$table_name." where id=".$id) ;

	$res_qry = $chk_qry[0] ;
	
	
	$nodeposit = array() ; 
	$preworking= array() ;
	$daily_promo_codes = "" ; 
	
	$chk_qry3 = $wpdb->get_results("select * from ".$table_codecasino." where casino_id=".$id." order by id asc") ;
   
        foreach($chk_qry3 as $chkq)
        {
                    if($chkq->type=='nodepst')
                    {
                            $nodeposit[] =  $chkq->code ;
                    }

                    if($chkq->type=='prev')
                    {
                            $preworking[] =  $chkq->code ;
                    }

                    if($chkq->type=='daily')
                    {
                            $daily_promo_codes =  $chkq->code ;
                    }

         }

	
	if($id!="" && $chk_qry)
	{
		$form       =  "" ;
		$content    =  $res_qry->description ; 
		$name       =  $res_qry->name ;
		$oldimage   =  $res_qry->image ;
		$countries  =  $res_qry->countries ;
		$enable     =  $res_qry->enable ;
		
		$enabl = array() ;
		 
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
		
		$action = "?page=manage-casino&wpu=update&linkid=".$_GET['linkid'] ; 

		$form .= "<div class='wrap manage_casino'>"  ; 

		$form .= '<h2> Update Casino Infomation </h2>' ; // Title of Form

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
                                        
                                        <div id="titlediv">

                                        <!-- label for="description_content" id="title-prompt-text">Name </label -->
                                        <input type="text" autocomplete="off" id="title" required="true" value="'.$content.'" placeholder="Enter Casino Link" size="30" name="description_content">

                                        </div>
                                        
					
					<div class="image_container">
					<div class="post_casino_image"><label> Upload Image </label><input  type="file" name="casinoimage" id="casinoimage"></div>'.$current_image.'<div></div></div>
			      
			     <div class="submit_form_btn">
				 <input type="submit" name="submit_frm" id="submit_frm" value="Update" class="button button-primary button-large">
				</div>
				
			</div>
			
				<div id="rightsidebar_content">
					  
						<div class="rightsidebox " id="formatdiv" >
						<h3 class="hndle"><span>Select Countries</span></h3>
						<div class="inside">
						<div id="select-countries">
						<select name="sel_countries[]" id="sel_countries" required="true" class="select_countries" multiple="multiple">'.$options.'</select> 

						</div>
						</div>
						</div>	  
				
							<div class="rightsidebox " isel_countriesd="formatdiv2">
							<h3 class="hndle"><span>Select Game</span></h3>
							<div class="inside">
							<div id="select-casions">
							<select style="height:auto;min-height:30px" name="sel_games[]" id="sel_games" required="true" data-value="Select Game for Code" class="select_casions casinorequire" >'.$options_games.'</select> 
							<label class="casinoerror2"></label>
							</div>
							</div>
							</div>	  
				 
				 
							<div class="rightsidebox " id="formatdiv">
							<h3 class="hndle"><span> No Deposit Codes </span></h3>
							<div class="inside">
							<div id="no_deposit_codes">
                                                         <p> <img  style="cursor:pointer" src="'.CASINO_PLUGIN_IMAGEURL.'/image/plus.png" class="casino_addinput" ></p>
							 <input type="text" name="no_deposit_code1" value="'.$nodeposit[0].'" class="no-deposit-codes">' ;
                                                            if($nodeposit[1]=="" || !isset($nodeposit[1]))
                                                            {		
                                                            $form .= '<input type="text" name="no_deposit_code2" class="no-deposit-codes casinohide"> ' ;
                                                            }
                                                            else  
                                                            {
                                                                    $form .= '<input type="text" name="no_deposit_code2" value="'.$nodeposit[1].'" class="no-deposit-codes"> ' ;  
                                                            }		

					$form .=	'</div>
								</div>
								</div>	
							<div class="rightsidebox " id="formatdiv" style="max-height:1000px;">
							<h3 class="hndle"><span> Previous Working Codes </span></h3>
							<div class="inside">
							<div id="prev_working_codes">
							 <p> <img style="cursor:pointer" src="'.CASINO_PLUGIN_IMAGEURL.'/image/plus.png" class="casino_addinput" ></p> ' ;
							
					if(count($preworking)>0)
					{	
                                                $count_pre=1;
						foreach($preworking as $prv)
						{	
                                                   
                                                    if($count_pre==1){
                                                        $form .=   '<input type="text" name="prev_working_codes[]" value="'.$prv.'" class="prev-working-codes">' ;
                                                    }
                                                    else{
                                                        $form .=   '<div style="clear:both" class="prev_block"><p id="cas'.$count_pre.'" class="casinoinp"><input type="text" name="prev_working_codes[]" value="'.$prv.'" class="prev-working-codes"></p><p id="del_img'.$count_pre.'" class="deleteimg"><img class="prev_blocks_img" style="cursor:pointer" src="'.CASINO_PLUGIN_IMAGEURL.'image/delete.png'.'" alt="'.$count_pre.'"></p> </div>' ; 
                                                    }
                                                    $count_pre++;
                                                
                                                }
					}
					else 
					  {
							$form .=   '<input type="text" name="prev_working_codes[]" class="prev-working-codes"> ' ;  
					  }		
				
				$form .='	</div>
							</div>
							</div>	
							
							
							<div class="rightsidebox " id="formatdiv">
							<h3 class="hndle"><span> Daily Desposit Promo </span></h3>
							<div class="inside">
							<div id="daily_promo">' ; 
							 
					$form .='<input type="text" name="daily_promo_codes" value="'.$daily_promo_codes.'" class="daily-promo-codes">' ; 
							
			 	    $form .=   '</div>
							    </div>
							    </div>	
						<div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span> Casino Status </span></h3>
						<div class="inside">
						<div id="select-status">
						 Disable <input type="radio" name="casino_enable" '.$enabl[0].'  class="rad_enable" value="0"> 
						 Enabled <input type="radio" name="casino_enable" '.$enabl[1].' class="rad_enable" value="1"> 
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

links_pages() ; 



?>
