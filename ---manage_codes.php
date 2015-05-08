<?php

require_once('defines.php') ; 
require_once('casino.js.php') ; 
 
  
function link_pages_codes()
{
   	global $wpdb;
 
	$wpu = $_GET['wpu'];

		switch($wpu) {

		case 'addcode':
		addform_link_codes('');
		break;


		case 'insertcode' :	
		 add_new_link_codes($mode='');  
		break;

		case 'editcode': 
		if(isset($_GET['linkid']))
		{
		edit_record_codes($_GET['linkid']);
		}
		break;

		case 'updatecode':
		add_new_link_codes($mode='updatecode');
		break;

		case 'enablecode' :
		enable_record_link_codes();
		break;

		case 'disablecode':
		disable_record_link_codes();
		break;
 
		default :
		//die('Testing ...');
		show_data_admin_codes('');
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


function get_admin_games_options($first=false,$game="")
{
	global $wpdb ;

	$table  	= $wpdb->prefix.TBL_GAMES ; 
	
    $tablecodes = $wpdb->prefix.TBL_CODES ; 
    
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
	

function get_admin_casino_options($first=false,$casinos="")
{
	global $wpdb ;
       
	$table = $wpdb->prefix.TBL_CASINO ; 

	$qry = " select * from ".$table." where enable='1'" ;
	$res   =  $wpdb->get_results($qry)  ;
    
    $casinos  = trim($casinos) ;
   
    $strlen = strlen($casinos) ;
  
     
    if($casinos!="" && $strlen > 0 )
    {
	   if(strpos($casinos,",")) // case for multiple $casinos
	   {
		$casinos = explode(",",$casinos) ;
		$casinos = array_filter($casinos) ;
	   }
	   else  // case for single $casino
	   {
	   $casinos = array($casinos);
	   }
	}
	else
	   {
		   $casinos = "" ;
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
				    $return  = "<option value=''> Select Casino </option>"  ; 
			   }
			 
			 if( $strlen >0  && in_array($result->id,$casinos) )
			 {
			  $check = "selected='selected'  class='showselected'" ; 
			 }
			 else 
			   {
				   $check =  ''; 
			   }
			 
			  if($return == "")
			  {
				 $return  = "<option value='". $result->id."' ".$check." >".$result->name ."</option>" ; 
			  } 
			  else
				 {
					$return .= "<option value='". $result->id."' ".$check." >".$result->name ."</option>"  ;  
				 }
			  $i++ ;	 
			}	
		}	
	return $return ;	
}




function addform_link_codes($datamsg)
{
 
$form    =  "" ;
$content =  "" ; 
 

$options = get_admin_casino_options($first=false) ;
$options_games = get_admin_games_options($first=false) ;

$action = "?page=manage-codes&wpu=insertcode" ; 

$form .= "<div class='wrap manage_casino'>"  ; 

$form .= '<h2> Add New Code Infomation </h2>' ; // Title of Form

$form .= '<form name="form1" method="post" action="'.$action.'"  enctype="multipart/form-data" >' ;

$settings = array(
'media_buttons' => false
) ;

$content = '' ;
$editor_id = 'description_content' ;


$form .= '
    <input type="hidden"  id="code_id" value="0" name="code_id"  >  
    <div id="poststuff">
<div class="metabox-holder" id="post-body">
	<div id="post-body-content">
	
	<div id="leftsidebar_content">
			<div id="titlediv">
			<input type="text" autocomplete="off" required="true" id="title" data-value="Code Title" placeholder="Code Title"  value="" class="casinorequire" size="30" name="post_title">
			<label class="casinoerror"></label>
			 </div>';
	
	$form .= '<div id="casino_game_code">
			 <input type="text" autocomplete="off" required="true" id="game_code" data-value="Game Code" placeholder="Game Code" class="casinorequire" value="" size="30" name="casino_game_code">
			 <label class="casinoerror"></label>
			 </div>' ;		 
			
   $form .= '<div id="postdivrich" class="postdivrich">'.wp_editor($content, $editor_id, $settings = array('media_buttons' => false)).'</div>';
	
	
$form .= '<div class="submit_form_btn">
		 <input type="submit" name="submit_frm" id="submit_frm" value="Submit" class="button button-primary button-large">
		</div>
		
	</div>
	
		<div id="rightsidebar_content">
			  
				<!--<div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span>Select Countries</span></h3>
				<div class="inside">
				<div id="select-countries">
				<select name="sel_countries[]" id="sel_countries" required="true" data-value="Select Country for Code" class="select_countries casinorequire" multiple="multiple">'.$options.'</select> 
				<label class="casinoerror2"></label>
				</div>
				</div>
				</div>-->	
                                
                                 <div class="rightsidebox " id="formatdiv">
                                        <h3 class="hndle"><span>Select Casino</span></h3>
                                        <div class="inside">
                                            <div id="select-countriePlease fills">
                                                <select name="casino_id" id="sel_casino"  style="height:auto;width:100%" data-value="Select Casino for Code" class="sel_casino casinorequire">'.$options.'</select> 
                                                <label class="casinoerror2"></label>
                                            </div>
                                        </div>
                                </div> 
                        
				<div class="rightsidebox " isel_countriesd="formatdiv2">
				<h3 class="hndle"><span>Select Games</span></h3>
				<div class="inside">
				<div id="select-casions">
				<select style="min-width:220px" name="sel_games[]" id="sel_games" required="true" data-value="Select Game for Code" class="select_casions casinorequire" multiple="multiple">'.$options_games.'</select> 
				<label class="casinoerror2"></label>
				</div>
				</div>
				</div>	  
				
					<div class="rightsidebox " id="formatdiv">
					<h3 class="hndle"><span> Deposit </span></h3>
					<div class="inside">
					<div id="select-status">
					No <input type="radio" name="code_deposit" checked="checked" class="rad_enable" value="0"> 
					Yes <input type="radio" name="code_deposit" class="rad_enable" value="1"> 
					</div>
					</div>
					</div>	 	 
		       
		
		        <div class="rightsidebox " id="formatdiv">
				<h3 class="hndle"><span> Status </span></h3>
				<div class="inside">
				<div id="select-status">
				 Disable <input type="radio" name="code_enable" checked="checked" class="rad_enable" value="0"> 
				 Enabled <input type="radio" name="code_enable" class="rad_enable" value="1"> 
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

function  show_data_admin_codes($datamsg)
{
	
global $wpdb ;

$table_name = $wpdb->prefix .TBL_CODES ;

$type_data  = "<div id='show_data'>" ;

$type_data .= "<div id='addnewlink'> <label>Codes</label><a href='?page=manage-codes&wpu=addcode' class='addnewbutton'>Add New</a></div>" ;

$type_data .= "<table cellpadding='0' cellspacing='0' border='0' class='display' id='casino_data'>" ; 
        
      $data = $wpdb->get_row("select count(name) as countr from ".$table_name);   

     $count = $data->countr ; 

		 if($count>0)
         {		  
               $type_data .= "<thead><tr> <th><input type='checkbox' id='selectall'/></th> <th id='title'>Name</th><th>Description </th> <th> Code </th>
	             <th>Status</th> <th>Actions</th> <th>Date</th></tr></thead><tbody>" ;
              	
				   
				   $sql = $wpdb->get_results("select * from ".$table_name);
				     
				   $i = 1 ;	
					 
					 foreach($sql as $row_data)
					  {
							$linkenable = "" ;
							 
							if($row_data->enable==0)
							{
							$linkenable = "<a href='?page=manage-codes&wpu=enablecode&linkid=".$row_data->id."'>Enable</a>" ;
							}	
							else 
							 {
							  $linkenable = "<a href='?page=manage-codes&wpu=disablecode&linkid=".$row_data->id."'>Disable</a>" ;	 
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
					                    
					       if(trim($row_data->code)!="")
					       {
							 $type_data .= " <td>".$row_data->code." </td> " ; 
						   } 
						   else 
						     {
								$type_data .= " <td> &nbsp;</td>" ;  
							 }	                
					       
					       $type_data .= "<td><b>".$linkenable."</b></td>
					               <td><a href='?page=manage-codes&wpu=editcode&linkid=".$row_data->id."'> Edit</a>  | <a href='#' data-value='".admin_url()."index.php?doaction=deletecode&linkid=".$row_data->id."'  class='deleterecord' data-linkd=".$row_data->id."> Delete </a> </td>
						           <td>".date('Y M-d',strtotime($row_data->date_created))."</td>
						           </tr> " ;
						 
						  $i++ ; 
						
						}
			
          }
            
          $type_data .= "</tbody> </table>
          
          <div id='do_theaction'><select name='casino_actions' id='casino_actions'><option value=''> Bulk Actions </option> <option value='1'> Delete</option> </select>  <input type='button' name='btn_doaction' id='btn_doaction' value='Apply' data-value='".admin_url()."index.php?doaction=deletecode'></div> </div>  " ;
  
     echo $type_data ; 
    
    if($datamsg!="")
    {
	 echo "<script> alert('".$datamsg."');</script>"	 ;
	}  
	
 }
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////

            function add_new_link_codes($mode) 
            {
			   //this function is used to insert new records \ update records into database
			   global $wpdb;
			
			    $tbl_cd   = $wpdb->prefix.TBL_CODES ;
                            $tbl_cdgm = $wpdb->prefix.TBL_CODE_GAME ;
                            $tbl_cdcn = $wpdb->prefix.TBL_CODE_COUNTRY ;
		       
			   $name    =  trim($_POST['post_title']) ;
			   $desc    =  trim($_POST['description_content']) ; 
			   $code    =  trim($_POST['casino_game_code'])   ;
			   $deposit =  $_POST['code_deposit'] ; 
			   $sel_games  = "" ;
			   $countries  = "" ; 
			   $casino_id=trim($_POST['casino_id']);
                           
                           
			   if(isset($_POST['sel_countries']))
			   {
				   $countries = $_POST['sel_countries'] ;
				   // $countries = @implode(',',@$countries) ;
			   }	
			   
			   if(isset($_POST['sel_games']))
			   {
				   $sel_games = $_POST['sel_games'] ;
				   // $sel_games = @implode(',',@$sel_games) ;
			   }
		   
			   $enable  =  0 ;
	 	           $msg     =  ''; 
			   $datamsg =  '' ;
			  
			    
                if(isset($_POST['code_enable']))
                {			  
			    $enable = $_POST['code_enable'] ; // state 0 means Disabled // state 1  means Enabled 
                            
				}
			    
			    
				$chk_qry = $wpdb->get_row("select count(name) as countr from ".$tbl_cd." where name='".$name."' and description='".$desc."' and enable='".$enable."' and code='".$code."' and deposit='".$deposit."'") ;
				$chk = $chk_qry->countr ; 
				
				if($mode == "" && ($chk=="" || $chk==0) ) // do actions if record is not existing 
				{
				 		if(trim($name)!="" )
						{
									$qry  =  "INSERT INTO " .$tbl_cd." (name,description,code,deposit,date_created,enable) " . 
									"VALUES ('". $name."','".$desc."','".$code."','".$deposit."',NOW(),".$enable.")";
                                                                        $wpdb->query($qry) ;
		                            
                                                                        $codeid = $wpdb->insert_id;	
									
									
									if(count($sel_games) >0 && is_array($sel_games))
									{
									    foreach($sel_games as $res)
									     {	
										$qry2  =  "INSERT INTO ".$tbl_cdgm." (code_id,game_id,casino_id) VALUES ('".$codeid."','".$res."','".$casino_id."')" ;
										$wpdb->query($qry2) ;
                                                                             }
									}
									else
									  {
										$qry2  =  "INSERT INTO ".$tbl_cdgm." (code_id,game_id,casino_id) VALUES ('".$codeid."','".$sel_games."','".$casino_id."')" ;
										$wpdb->query($qry2) ; 
									  }
								
									
									if(count($countries) >0 && is_array($countries))
									{
									    foreach($countries as $res)
									     {	
										$qry3  =  "INSERT INTO " .$tbl_cdcn." (code_id,country_id) VALUES ('". $codeid."','".$res."')";	
										$wpdb->query($qry3) ;
										 }
									}
									else
									  {
										//$qry3  =  "INSERT INTO " .$tbl_cdcn." (code_id,country_id) VALUES ('". $codeid."','".$countries."')";	
										//$wpdb->query($qry3) ;
									  }	
								
									$datamsg =  " New Game Code Added successfully ";
						}
				 }
					  
					   if($mode=='updatecode')
					   {
						  $link = $_GET['linkid'] ;
						 
						  $qry  =  "update " . $tbl_cd ." set name='".$name."',description='".$desc."',code='".$code."',deposit='".$deposit."',enable='".$enable."',date_updated=NOW()  where id=".$link ;
						 
						  $wpdb->query($qry) ;
						  
						  $qry_del = "delete from ".$tbl_cdgm." where code_id=".$link."" ;
                                                  @$wpdb->query($qry_del) ;
						
						  foreach($sel_games as $game)
						  {
							 
								$qry3  =  "INSERT INTO " .$tbl_cdgm." (code_id,game_id,casino_id) VALUES ('". $link."','".$game."','".$casino_id."')";	
								$wpdb->query($qry3) ; 
							 
						  }	      
						
						  
						//  $qry3  =  "update " . $tbl_cdcn ." set country_id='".$countries."' where id=".$link ;
						//  $wpdb->query($qry3) ;
						
						  
						  $qry_sel1 = "select * from ".$tbl_cdcn." where code_id=".$link ;
						  $res1  =   $wpdb->get_results($qry_sel1) ;
						  foreach($res1 as $result)
						  {
							   if(!in_array($result->country_id,$countries) )
								{
									$qry_del = "delete * from ".$tbl_cdcn." where code_id=".$link." and country_id=".$result->country_id ;
									@$wpdb->query($qry_del) ;
								}
						  }
						 if(count($countries) >0 && is_array($countries))
                                                 {
						  foreach($countries as $country)
						  {
							  $qry_sel = $wpdb->get_var("select * from ".$tbl_cdcn." where code_id=".$link." and country_id=".$country) ;
							  
							  if(!($qry_sel > 0) ||  $qry_sel=="" )
							  {
								$qry3  =  "INSERT INTO " .$tbl_cdcn." (code_id,country_id) VALUES ('". $link."','".$country."')";	
								$wpdb->query($qry3) ; 
							  }
						  }	
                                                }
						 //  $qry .= "countries='".$countries."',game='".$sel_games."',enable='".$enable."' where id=".$link ; 
						 
						  $datamsg =  " Game Code Updated successfully ";
					   }
				show_data_admin_codes($datamsg) ;
	       }


////////////////////////////////////// ENABLE LINKS ///////////////////////////////////////////////

function enable_record_link_codes()
{
  $linkid = "" ;
 
  global $wpdb;
  $table_name = $wpdb->prefix.TBL_CODES ;
			
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
  
   show_data_admin_codes($datamsg) ;

}

/////////////////////////////    DISABLE  LINKS   /////////////////////////////////////////////


function disable_record_link_codes()
{
  $linkid = "" ;
  $form  = "" ;
  
  global $wpdb;
  $table_name = $wpdb->prefix.TBL_CODES ;
			
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
  
  show_data_admin_codes($datamsg) ;

}

///////////////   DELETE A  AD ////////////////////////////////////

 
function delete_link_codes()
{
  require_once('casino.js.php') ; 
  
  show_data_admin_games($datamsg) ;

}

/////////////////////////////////////////////////////////////////////////////

function edit_record_codes($id) 
{
	global $wpdb ;
	
	$tbl_cd   	=	 $wpdb->prefix.TBL_CODES ;
	$tbl_cdgm 	= 	$wpdb->prefix.TBL_CODE_GAME ;
	$tbl_cdcn 	= 	$wpdb->prefix.TBL_CODE_COUNTRY ;
	
	$countries = "" ; 
	$game = "" ;
        $casino_id=0;
	
	$chk_qry = $wpdb->get_results("select * from ".$tbl_cd." where id=".$id) ;
    $res_qry = $chk_qry[0] ;
   
    
    $chk_qry2  = $wpdb->get_results("select  game_id,casino_id from ".$tbl_cdgm." where code_id=".$id) ;
    
   
    foreach($chk_qry2 as $res)
	{
		$game = $game.$res->game_id.","  ;
                $casino_id=$res->casino_id;
	}
        
    $game = substr($game,0,-1) ;
    
   
    $chk_qry3  = $wpdb->get_results("select  country_id from ".$tbl_cdcn." where code_id=".$id) ;
	
	foreach($chk_qry3 as $res)
	{
		$countries = $countries.$res->country_id.","  ;
	}
	
	$countries = substr($countries,0,-1) ;
     
	
	if($id!="" && $chk_qry)
	{
		$form       =  "" ;
		$content    =  $res_qry->description ; 
		$name       =  $res_qry->name ;
		$code       =  $res_qry->code ;
		//$game       =  $res_qry->game_id ;
		//$countries  =  $res_qry->country_id ;
		$enable     =  $res_qry->enable ;
		
		$deposit   = array() ; 
		$enabl     = array() ;
		
		if($res_qry->deposit==0)
		{
			$deposit[0] =  "checked=checked" ;	
		}
		else 
		  {
			  $deposit[0] =  "" ;	
		  }
		  
		if($res_qry->deposit==1)
		{
			$deposit[1] =  "checked=checked" ;	
		}
		else 
		  {
			  $deposit[1] =  "" ;	
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
		
                $options = get_admin_casino_options($first=false,$casino_id) ;
		
		$options_games  = get_admin_games_options($first=false,$game) ;
		
		$action = "?page=manage-codes&wpu=updatecode&linkid=".$_GET['linkid'] ; 

		$form .= "<div class='wrap manage_casino'>"  ; 

		$form .= '<h2> Update Code Infomation </h2>' ; // Title of Form

		$form .= '<form name="form_update" method="post" action="'.$action.'"  enctype="multipart/form-data" >' ;

        $current_image = ""; 
        
                if($oldimage!="")
                {
                    $target = $url.$oldimage ;	 
                    $current_image = "<span class='current_image'> <img src='".$target."' class='showmedium_image'></span>"	;
                }
		
                
		$form .= '
                <input type="hidden"  id="code_id" value="'.$_GET['linkid'].'" name="code_id"  >    
                    
                <div id="poststuff">
		<div class="metabox-holder" id="post-body">
			<div id="post-body-content">
			
			<div id="leftsidebar_content">
					<div id="titlediv">
					 
					<!-- label for="title" id="title-prompt-text">Name </label -->
					<input type="text" autocomplete="off" required="true" id="title" value="'.$name.'" size="30" name="post_title" data-value="Code Title" value="" class="casinorequire" >
					<label class="casinoerror"></label> 
					</div>' ;
					
		$form .= '	<div id="casino_game_code">
					 <input type="text" autocomplete="off" required="true" id="game_code" data-value="Game Code" class="casinorequire" value="'.$code.'" size="30" name="casino_game_code">
					 <label class="casinoerror"></label>
					 </div>' ;					
					
		$form  .= ' <div id="postdivrich" class="postdivrich">'.wp_editor( $content, $editor_id, $settings = array('media_buttons' => false) ).' </div>
				  <div class="submit_form_btn">
				  <input type="submit" name="submit_frm" id="submit_frm" value="Update" class="button button-primary button-large">
				  </div>
		  	</div>
			
				<div id="rightsidebar_content">
					  
						<!--<div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span>Select Countries</span></h3>
						<div class="inside">
						<div id="select-countriePlease fills">
						<select name="sel_countries[]" id="sel_countries" class="select_countries" multiple="multiple" data-value="Select Country for Code" class="select_countries casinorequire">'.$options.'</select> 
                                                    <label class="casinoerror2"></label>
						</div>
						</div>
						</div>-->
                                                
                        <div class="rightsidebox " id="formatdiv">
                                <h3 class="hndle"><span>Select Casino</span></h3>
                                <div class="inside">
                                    <div id="select-countriePlease fills">
                                        <select name="casino_id" id="sel_casino"  style="height:auto;width:100%" data-value="Select Casino for Code" class="sel_casino casinorequire">'.$options.'</select> 
                                        <label class="casinoerror2"></label>
                                    </div>
                                </div>
                        </div>         
                        
                        <div class="rightsidebox " id="formatdiv2">
				        <h3 class="hndle"><span>Select Game</span></h3>
				        <div class="inside">
				        <div id="select-casions">
				        <select style="min-width:220px" name="sel_games[]" id="sel_games" required="true" class="select_casions" multiple="multiple" data-value="Select Game for Code" class="select_casions casinorequire">'.$options_games.'</select> 
						<label class="casinoerror2"></label>
				        </div>
				        </div>
				        </div>							
				
				
				        <div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span> Deposit </span></h3>
						<div class="inside">
						<div id="select-status">
						 No <input type="radio" name="code_deposit" '.$deposit[0].'  class="rad_enable" value="0"> 
						 Yes <input type="radio" name="code_deposit" '.$deposit[1].' class="rad_enable" value="1"> 
						</div>
						</div>
						</div>	 
				        
				
						<div class="rightsidebox " id="formatdiv">
						<h3 class="hndle"><span> Status </span></h3>
						<div class="inside">
						<div id="select-status">
						 Disable <input type="radio" name="code_enable" '.$enabl[0].'  class="rad_enable" value="0"> 
						 Enabled <input type="radio" name="code_enable" '.$enabl[1].' class="rad_enable" value="1"> 
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

link_pages_codes() ;


?>
