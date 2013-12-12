
$(document).ready(function(){
    
		  $("#s_brand").change(function () {
										 
          $("#s_model")[0].options.length = 0;	
		  $("#s_years")[0].options.length = 0;		
		  
          var strBrand = $("#s_brand option:selected").text();
          getModels(strBrand);    
	       })

	$("#s_model").change(function () {
	$("#s_years")[0].options.length = 0;								 
	var strModel = $("#s_model option:selected").text();
 	getYears(strModel);    
	 })

});
/* ..............................................................................................................................  */
		function getModels(brand) {
					$.ajax({
							  type: "POST",   
							  url: "../_common/ajax/cars/cars.php",
							  data: "brand=" + brand,
							  dataType: "json",
							  success: respModels  
						   })
		}
/* ..............................................................................................................................  */
		function respModels(data) {
			
			var sel = $("#s_model");
			sel[0].options.length = 0;
			
			sel.append( $('<option></option>').text('Выберите:') )
			
			$.each(data, function(i, val) {
			sel.append( $('<option></option>').attr('value', val.id).html(val.model) )
			} )
		}		
/* ..............................................................................................................................  */
		function getYears(model) {
					$.ajax({
							  type: "POST",   
							  url: "../_common/ajax/cars/cars.php",
							  data: "model=" + model,
							  dataType: "json",
							  success: respYears  
						   })
		}
/* ..............................................................................................................................  */
		function respYears(data) {
			
			var sel = $("#s_years");
			sel[0].options.length = 0;
			
					if(data.length>1)	{
					sel.append( $('<option></option>').text('Выберите:') )
					}
			$.each(data, function(i, val) {
			sel.append( $('<option></option>').attr('value', val.car).html(val.years) )
			} )
		}
/* ..............................................................................................................................  */
		function toPage() {

		 var yearBegin = ($("#s_years option:selected").text()).substr(0, 4);
		
			if( !isNaN($("#s_model option:selected").val()) != 'undefined' && !isNaN($("#s_years option:selected").val())   )		{
	
			var carID = $("#s_years option:selected").val();
			location.href= 'opinion_edit.php?car=' +carID;
			}
		}
