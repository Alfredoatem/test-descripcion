// JavaScript Document
$(function(){
  /*Funciones de Maestro*/
  $("#cboffin").change(function(){
		$("#cboffin option:selected").each(function () {
			$.ajax({
        type : 'POST',
				url: "../ajax/ajaxcombos.php",
				data:"list=ofin&valor="+$(this).val(),
				success: function(html){
					 $("#cboofin").html(html);
				 }
			});
		});
	});
  
  $(document).on('keyup','#txthtd, #txtglosa, #txtemp, #txtdocent, #txtsolpor',function(){
		this.value = this.value.toUpperCase();
	});
  
  $("#txtpedi").numeric();
});