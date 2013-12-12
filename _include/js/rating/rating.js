
var coordX;
var isBtns = 0;

var widthArray = new Array();
var rateArray 	= new Array();
var clicked		= new Array();

var widthSave = new Array();
var rateSave = new Array();
///////////////////////////////////////////////

$(function()  {  	$("#btnRate").click( function() {  rate();  } );      });
							
//   ...................................................................................................................           //
	
	function rate()	{
	
	$("#btnRate").css("visibility", "hidden");
	
	for(var i=1; i<5; i++)	{
	$("#stars_" +i).css("width", "0");	
	$("#rate_" +i).text("");
	}
		
	$("#hidden").css("background", "url(_include/pics/rate_title_new.jpg)  no-repeat").fadeIn();
		
	$("#contour_1").mousemove( function(event) 	     {  starsOver(event.pageX, 1 );  } );
	$("#contour_2").mousemove( function(event) 	     {  starsOver(event.pageX, 2 );  } );
	$("#contour_3").mousemove( function(event) 	     {  starsOver(event.pageX, 3 );  } );
	$("#contour_4").mousemove( function(event) 	     {  starsOver(event.pageX, 4 );  } );
	
	$("#contour_1").click( function(event) 	     {  starsClick(event.pageX, 1);  } );
	$("#contour_2").click( function(event) 	     {  starsClick(event.pageX, 2);  } );
	$("#contour_3").click( function(event) 	     {  starsClick(event.pageX, 3);  } );
	$("#contour_4").click( function(event) 	     {  starsClick(event.pageX, 4);  } );

	$("#contour_1").mouseout( function() 	{  starsOut(1);  } );
	$("#contour_2").mouseout( function() 	{  starsOut(2);  } );									   
	$("#contour_3").mouseout( function() 	{  starsOut(3);  } );									   
	$("#contour_4").mouseout( function() 	{  starsOut(4);  } );
	}

	
	function starsOver(eventCoord, num)	{
										$("#contour_" +num).css("cursor", "pointer");
										coordX	 = eventCoord - $("#contour_" +num).offset().left;
										rateArray[num]  =	 parseInt(coordX / 25) +1;
										widthArray[num]	= rateArray[num] *25
										$("#stars_" +num).css("width", widthArray[num]);
										$("#rate_" +num).text(rateArray[num]).css("margin-left", "14px").css("font-size", "18px");
	}
	
	
	function starsOut (num)	{								   
									   if (rateSave[num] > 0)		{
												$("#stars_" +num).css("width", widthSave[num]);	
												$("#rate_" +num).text(rateSave[num]);												
												
												}	else   {
												$("#stars_" +num).css("width", "0");	
												rateArray[num] = 0;
												$("#rate_" +num).text("");
	}    }



	function starsClick(eventCoord,num)		{	
										coordX	 = eventCoord - $("#contour_" +num).offset().left;
										rateSave[num]  =	 parseInt(coordX / 25) +1;
										widthSave[num]	= rateSave[num] *25
										$("#stars_" +num).css("width", widthSave[num]);
										$("#rate_" +num).text(rateSave[num]);
	
	if(rateSave[1]>0 && rateSave[2]>0 && rateSave[3]>0 && rateSave[4]>0 && isBtns==0)	{
			
			$('<div></div>').attr('id', 'btn_ok')											// кнопка OK
								   .css({ 'display': 'block', 'float': 'left', 
											'width': '85px', 'height': '43px',  'cursor': 'pointer',
											 'background': 'url("_include/pics/rate_btn_ok.png") no-repeat',
											 'margin': '0 20px 0 0px'
											 })
			.appendTo('#btn_area')
			.bind('click', function() 	{ 	$("#btn_ok").hide();	
														$("#btn_cancel").hide();
														sendAjax() } );
			
				
			$('<div></div>').attr('id', 'btn_cancel')										// кнопка Cancel
								   .css({ 'display': 'block', 'float': 'left',
											'width': '91px', 'height': '43px',  'cursor': 'pointer',
											 'background': 'url("_include/pics/rate_btn_cancel.png") no-repeat' })
			.appendTo('#btn_area')
			.bind('click', function() 	{ 	$("#btn_cancel").hide();
														$("#btn_ok").hide();		
														location.reload(true) 		}   );
			isBtns =1;
	}
	} 	


//   ...................................................................................................................           //

		function sendAjax()  {
		if(rateSave[1]>0 && rateSave[2]>0 && rateSave[3]>0 && rateSave[4]>0 
		&& rateSave[1]+rateSave[2]+rateSave[3]+rateSave[4]	 <39
		&& rateSave[1]+rateSave[2]+rateSave[3]+rateSave[4]	 >9	
		&& navigator.cookieEnabled   )	{	// если включены куки, можно записывать оценку в бд

		$.ajax({
		'url': 				'_include/js/rating/edit_rate.php',
		'data': 			{	'car': 				idCar, 
								'ip':					ip,
								'rate1': 				rateSave[1], 
								'rate2': 				rateSave[2],
								'rate3': 				rateSave[3],
								'rate4': 				rateSave[4]
							},
		'dataType':	 'json',
		'type':			 'POST',
		'success':		 respAjax
		});
		}	}


		function respAjax(data)  {
		
				if (data[0].good == "yes" )  {
				location.reload(true);
				}		else	 {
				alert("Ошибка при записи вашей оценки");
				}
		}