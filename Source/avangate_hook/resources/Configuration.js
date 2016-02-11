$(document).ready(function(){
		
		$("#aftervalidation").hide();
		$("#webhooks").hide();
		$("#errorkey").hide();
		$("#errorsecret").hide();
		$("#errorthreshold").hide();
		$("#errorstore").hide();
		$("#errormobile").hide();
		$("#errorhide").show(); //def`
		$("#errorfrom").hide();
		$("#getnext_div").hide();
		
    $("#validatekeys").click(function(){
        validateKeys();
    });
	
	
	$("#genwebhook").click(function(){
    	genWebHook();
    });
	
	$("#goback").click(function(){
			$("#goback").click(function(){
			$("#fromfields").show();
			$("#webhooks").hide();
			$("#msgbox").hide();
		
		});
	
    });
	
});


function validatetamount()
{

	var val=$.trim($("#thresholdamount").val()) ;
		
	if(val<0)
	{
		
		$("#errorthreshold").show();
		$("#errorthreshold").text("Please enter a valid Threshold");
	}
	else{
			$("#errorthreshold").hide();
			$("#errorthreshold").text("Please enter the Threshold value");
	}
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function genWebHook()
{
	
	
	
	if($.trim($("#key").val()) == ""){
		
		$("#errorkey").show();
		$("#key").focus();
		return;
	}
	 $("#errorkey").hide();
	if($.trim($("#secret").val()) == ""){
		$("#errorsecret").show();
		//$("#error").text("Please enter the Nexmo Secret");
		$("#secret").focus();
		return;
	}
	 $("#errorsecret").hide();
	 	var defaultFromNumber = $('#fromNumbers').find(":selected").val();
		
	if(defaultFromNumber=="")
	{
		$("#errorfrom").show();
		$('#fromNumbers').focus();
		return;
	}
	$("#errorfrom").hide();
	if($.trim($("#thresholdamount").val()) == ""){
		$("#errorthreshold").show();
		//$("#error").text("Please enter the Threshold Amount");
		$("#thresholdamount").focus();
		return;
	}
	var val=$.trim($("#thresholdamount").val()) ;
		
	if(val<0)
	{
		$("#thresholdamount").focus();
		$("#errorthreshold").show();
		$("#errorthreshold").text("Please enter a valid Threshold");
		return;
	}
	else{
			$("#errorthreshold").hide();
			$("#errorthreshold").text("Please enter the Threshold value");
	}
	
	$("#errorthreshold").hide();
	if($.trim($("#storename").val()) == ""){
		$("#errorstore").show();
		//$("#error").text("Please enter the Store Name");
		$("#storename").focus();
		return;
	}
	$("#errorstore").hide();
	
	var mobile_no=$.trim($("#storephone").val());
	if(mobile_no == ""){
		$("#errormobile").show();
	//	$("#error").text("Please enter the Store Owner Mobile Number");
		$("#storephone").focus();
		return;
	}
	var mob=$.trim($("#storephone").val()) ;
		
	if(mob<0 || mob.length!=12 || isNumeric(mob)==false)
	{
		$("#storephone").focus();
		$("#errormobile").show();
		$("#errormobile").text("Please enter valid Mobile Number");
		return;
	}
	else{
			$("#errormobile").hide();
			$("#errormobile").text("Please enter the Store Owner Mobile Number");
	}
	
	$("#errormobile").hide();
	
	
	
	validateKeys();
	$("#msgbox").show();
	$("#error").html("");
	var home=window.location;
	var api=$("#key").val();
	var secret=$("#secret").val();
	var threshold=$("#thresholdamount").val();
	var storename=$("#storename").val();
	var storephone=$("#storephone").val();

	
	
	var oc64="avangate$#$"+api+"$#$"+secret+"$#$"+defaultFromNumber+"$#$"+threshold+"$#$"+storename+"$#$"+storephone+"$#$";
	var ordercreate=home+"callback.php?query="+btoa(oc64);
	$("#ordercreate").val(ordercreate);
	$("#fromfields").hide();
	$("#webhooks").show();
}

function getFromNo(response) {
		  var obj = jQuery.parseJSON( response );
		  
		   $('#fromNumbers')
   		 .empty();
	for(i=0;i<obj.numbers.length;i++){
		
		
		   $('<option/>', {
   					 'text': obj.numbers[i].msisdn+"   "+obj.numbers[i].features,
   					 'value':obj.numbers[i].msisdn,
   					
					}).appendTo('#fromNumbers');
	}
	$("#aftervalidation").show();
	 $('#key').attr('readonly', 'true');
	  $('#secret').attr('readonly', 'true')
	 
	
	
}
function getPathFromUrl(url) {
  return url.split("?")[0];
}
function validateKeys()
  {
  
  
	
	if($.trim($("#key").val()) == ""){
		
		$("#errorkey").show();
		$("#key").focus();
		return;
	}
	$("#errorkey").hide();
	var apiKeys=$.trim($("#key").val());
   
   
    if($.trim($("#secret").val()) == ""){
		$("#errorsecret").show();
		//$("#error").text("Please enter the Nexmo Secret");
		$("#secret").focus();
		return;
	}
	$("#errorsecret").hide();
	
     var secret=$("#secret").val();
    secret=$.trim(secret);
   
	urls=window.location+"/"+"index.php?req=validate&apiKeys="+apiKeys+"&secret="+secret;
     
    $("#progressSpinner").show();
    $.ajax({
      url: urls,
      type: "GET",
      dataType: "json",
     cache: false,
     crossDomain: true,
     processData: true,
     contentType: "application/json",
	  success:function(resp){
		  $("#progressSpinner").hide();
		  if(resp==false){
			
			 alert("Please enter valid Nexmo Key and Secret.");
			 $("#aftervalidation").hide();
			  $("#validationdiv").show();
		  }
		  else{
			    $("#validationdiv").hide();
			     getFromNo(resp); 
		  }
		     
	  		 
			 
	  		 
	  },
	   error: function (XMLHttpRequest, textStatus, errorThrown) {
		    $("#progressSpinner").hide();
			 $("#validationdiv").show();
		  $("#aftervalidation").hide();	
         alert("Please enter valid Nexmo Key and Secret.");
     }
    });
  
  
  }
  
  
  
  
  