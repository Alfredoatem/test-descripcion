// JavaScript Document
$(function(){

  $.ajax({
    type : 'POST',
    url : "../ajax/ajaxcombos.php",
    data : "list=ffin",
    success : function(html){
      $("#cboffin").html(html);
    }
  });
  
  $('#txtfi').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    useCurrent: false
  });
  
  $('#txtff').datetimepicker({
    locale: 'es',
    format: 'L',
    useCurrent: false
  });
  
  $("#txtfi").on("dp.change", function (e) {
    $('#txtff').data("DateTimePicker").minDate(e.date);
  });
  $("#txtff").on("dp.change", function (e) {
    $('#txtfi').data("DateTimePicker").maxDate(e.date);
  });

  $(".enlacerepar").attr("onclick","popup('zooms/zoomrepar.php','700','360')")
  $("#txtgest,#txtnro,#txtnroconta").numeric();
  $("#txthtd").inputmask("aaa99999");
  
  $(document).on('focusin','#hdnrepar',function(){
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxrepar.php",
      data : "valor="+$(this).val(),
      success : function(data){
        var json = eval("(" + data + ")");
        $("#txtrepar").attr('value',json.value);
      }
    });
  });
});