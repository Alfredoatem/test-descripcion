// JavaScript Document
$(function(){
  /*Funciones de Maestro*/
  $(".enlaceubic").attr("onclick","popup('zooms/zoomubic.php','700','360')")
  
  $(document).on('focusin','#hdnubic',function(){
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxubic.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        $("#txtubic").attr('value',json.value);
      }
    });
  });
  
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

  $(document).on('keyup','#txtglosa, #txtsolpor, #txtresp',function(){
		this.value = this.value.toUpperCase();
	});
  
  $("#txtpedi").numeric();
});