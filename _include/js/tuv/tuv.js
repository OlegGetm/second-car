$(document).ready(function() {
						   
		//On Click Event для табуляторов
		$('#set_tuv div').click(function() {
		$('#set_tuv div').removeClass().css('text-decoration', 'underline');      //Remove any "active" class
		$(this).css('text-decoration', 'none').addClass('selected');		  //Add "active" class to selected tab
  		
		sendTUV (this.id);
		});

		$("#onTop").click(function() { window.location.hash = "top" });
}); 


	function sendTUV(idd)	{
				$("#onTop").hide();
				$('#table_1').fadeOut("normal", function(){ 
				$.ajax({
									'url': 				'_include/js/tuv/tables_edit.php',
									'data': 					{	'age': 		idd  },
									'dataType':	 'json',
									'type':			 'POST',
									'success':		 responseTUV
									});
	 				})
	}


function responseTUV(data)  {
	
	$('#table_1').remove();
	var tabl = $('<table></table>');
	tabl.attr('id', 'table_1').css({
											'width': 620,
											'background-color': '#efefef'
											})
	
	var tr0 = $('<tr></tr>');
	$('<td></td>').css('width', '10px').css('height', '10px').appendTo(tr0);
	$('<td></td>').css('width', '70px').appendTo(tr0);
	$('<td></td>').css('width', '220px').appendTo(tr0);	
	$('<td></td>').css('width', '120px').appendTo(tr0);
	$('<td></td>').css('width', '120px').appendTo(tr0);	
	tr0.appendTo(tabl);
	
	$.each(data, function(i, val) {
	
	var tr = $('<tr></tr>');
	var txt = val.brand + ' ' + val.model;

	$('<td></td>').appendTo(tr);
	$('<td></td>').text(val.mesto).appendTo(tr);
	$('<td></td>').text(txt).appendTo(tr);
	$('<td></td>').text(val.otsev + ' %').appendTo(tr);
	$('<td></td>').text(val.probeg).appendTo(tr);
	
	tr.appendTo(tabl);

	} );
	tabl.appendTo($("#area_load"));
	
	$('#table_1 tr:odd').css('background-color', '#f3f3f3');

	$("#area_load").fadeIn();
	$("#onTop").show();
 }
