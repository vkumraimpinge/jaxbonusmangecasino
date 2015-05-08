<?php

$deleteimg = CASINO_PLUGIN_IMAGEURL.'image/delete.png' ; 

?>

<script language="javascript">
jQuery(document).ready(function(){
	
	jQuery('.casinoerror').each(function(){
		jQuery(this).css('display','none') ;
	}) ;
	
	
	jQuery('.casinorequire').each(function(){
		
		 jQuery(this).focusin(function(){ 	
				if(jQuery(this).next('label').css('display','block') ) 
				{
					jQuery(this).next('label').css('display','none')   ;
				}
		});	
	});
	
	jQuery('#no_deposit_codes input').each(function(){
	  
	   var chkval = jQuery(this).val() ;
	   if(jQuery.trim(chkval) != "" )
       {
		  jQuery(this).removeClass('casinohide') ;  
	   }	   
     	  
     }) ; 
	
	
	
	
	jQuery('#no_deposit_codes .casino_addinput').click(function(){
         var show_all=0;
	 jQuery('#no_deposit_codes input').each(function(){
	   if( jQuery(this).hasClass('casinohide') )
	   {
                   show_all=1;  
		   jQuery(this).removeClass('casinohide') ;
	   }
           
           
		  
           }) ;
           if(show_all==0){
               
            alert("Only 2 'No Deposit Codes' can be added for a game.");
            
           }
		
	}) ;
	
	
	
	
	jQuery('#prev_working_codes .casino_addinput').click(function(){
	  
	  var count = 1 ; 
	  
	   count =  jQuery('#prev_working_codes > div').length ;
		
	   count = count+1 ;	
	  
	  jQuery('#prev_working_codes').append('<div style="clear:both" class="prev_block"><p id="cas'+count+'" class="casinoinp"><input type="text" class="prev-working-codes" name="prev_working_codes[]"></p><p id="del_img'+count+'" class="deleteimg"><img style="cursor:pointer" src="<?php echo $deleteimg ;?>" alt="'+count+'"></p><div>') ;
		
	  jQuery('#prev_working_codes .deleteimg').delegate('img','click',function(){ 
	   
          
	   var pid = jQuery(this).attr('alt') ;  
           
           jQuery(this).parent().parent().remove() ;  
	
		  
	   });	
           
           
          
		
	}) ;
        
        jQuery('.prev_blocks_img').click(function(){
	
         jQuery(this).parent().parent().remove() ;  
	
	}) ;
        
	jQuery('#sel_countries option').click(function(){
	
	if(jQuery(this).attr('selected') == 'selected')
	{
		// jQuery(this).removeAttr('selected') ;
		// jQuery(this).css('background','none') ;
	}
		
	}) ;
	
	 jQuery('#casino_data').dataTable( {
        "aoColumnDefs": [
        {
            "bSortable": false,
            "aTargets": [ 0,4 ]
        }
        ],
        "aLengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],
        "iDisplayLength": 10,
        "sPaginationType": "full_numbers"
    });
	
	
	jQuery('.manage_casino #submit_frm').click(function(){
	
		var errors = 0 ; 
		var msg =  "" ; 
		
		  if( jQuery('#title').val() == "" )
		  {
			 msg = " Please Enter "+jQuery('#title').attr('data-value') ; 
			 jQuery('#title').next('label').text(msg) ;
			 jQuery('#title').next('label').css('display','block') ;
			 errors++ ;
		  }	
		
		  if( jQuery('#game_code').length >0 && jQuery('#game_code').val() == "" )
		  {
			 msg = " Please Enter "+jQuery('#game_code').attr('data-value') ; 
			 jQuery('#game_code').next('label').text(msg) ;
			 jQuery('#game_code').next('label').css('display','block')  ;
			 errors++ ;
		  }	 
		 
		  
		  
		 if(errors >0)
		 {
			 return false ;
		 } 	
		 else
		   {
			   return true ;
		   }
		
   }) ;
		

	

	jQuery('.deleterecord').click(function(event){
		event.preventDefault() ;
		var anchorHrefValue = jQuery(this).attr('data-value');
		var chk = confirm('Do you really want to delete the Record ?') ;
		
		if(chk)
		{
			jQuery.ajax({
				type: 'POST',
				url: anchorHrefValue,
				data: {
					action: anchorHrefValue,
					adid: anchorHrefValue
				},
				success: function(data, textStatus, XMLHttpRequest){
				    alert(XMLHttpRequest.responseText);
				    location.reload();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
					 alert(errorThrown);
				}
			});
		}
	});
	
	///////////////////////////////
	jQuery('#btn_doaction').click(function(event){
		event.preventDefault() ;
		
		var dfValue = jQuery('#casino_actions').val() ;
		var anchorHrefValue = jQuery(this).attr('data-value')  ;
		var chk = "" ;
		var rec = "" ;
		
		jQuery('#casino_data .number_check').each(function(){
		
			if( jQuery(this).is(':checked'))
			{
				var jval = jQuery(this).val() ;
				    rec  = rec+jval+',' ;
			}
			
		}) ;
		
		rec = rec.slice(0,-1) ;
				
		if(rec !="" && dfValue== 1 )
		{
			 chk  = confirm('Do you really want to delete selected Records ?') ;
		
			  if(chk)
			  {	 
					jQuery.ajax({
						type: 'POST',
						url: anchorHrefValue,
						data: {
							action: anchorHrefValue,
							recrds: rec
						},
						success: function(data, textStatus, XMLHttpRequest){
							alert(XMLHttpRequest.responseText);
							location.reload();
						},
						error: function(MLHttpRequest, textStatus, errorThrown) {
							   alert(errorThrown);
						}
					});
			  }
			  else
			     {
					$("#casino_actions").val($("#casino_actions option:first").val());
				 }	 
		}
		else
			     {
					$("#casino_actions").val($("#casino_actions option:first").val());
				 }	
	  		
	});
	
	
	
	if(jQuery('#postdivrich').length >0 &&  jQuery('#wp-description_content-wrap').length >0)
	{
		jQuery('#postdivrich').html(jQuery('#wp-description_content-wrap')) ;
    }
	
	
	
		
});
</script>
