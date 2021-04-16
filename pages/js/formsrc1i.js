// JavaScript Document
$(function(){
  /*Funciones de Maestro*/
  $.ajax({
    type : 'POST',
    url : "../ajax/ajaxcombos.php",
    data : "list=tiper",
    success : function(html){
      $("#cbotiper").html(html);
    }
  });
  
  $(document).on('keyup','#txthtd, #txtglosa, #txtemp, #txtfact, #txtsolpor, #txtcotpor',function(){
		this.value = this.value.toUpperCase();
	});
  
  $("#txtpedi").numeric();
});