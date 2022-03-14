// JavaScript Document
$(function(){
    $('#txtfi').datetimepicker({
      locale: 'es',
      format: 'DD/MM/YYYY',
      minDate: moment("01/01/2015", "DD/MM/YYYY"),
      //minDate: moment(),
      maxDate: moment(),
    });
  
    $('#txtff').datetimepicker({
      locale: 'es',
      format: 'DD/MM/YYYY',
      useCurrent: false
    });
  
    $("#txtfi").on("dp.change", function (e) {
      $('#txtff').data("DateTimePicker").minDate(e.date);
    });
    $("#txtff").on("dp.change", function (e) {
      $('#txtfi').data("DateTimePicker").maxDate(e.date);
    });
  
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxcombos.php",
      data : "list=ffin&sel="+$("#hdnselffin").val(),
      success : function(html){
        $("#cboffin").html(html);
      }
    });
  
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxcombos.php",
      data : "list=tiper&sel="+$("#hdnseltiper").val(),
      success : function(html){
        $("#cbotiper").html(html);
      }
    });
    $.ajax({
        type : 'POST',
        url: "../ajax/ajaxcombos.php",
        // data:"list=ofin&valor="+$(this).val(),
      data : "list=ofin&valor="+$("#hdnselofin").val(),
        success: function(html){
          $("#cboofin").html(html);
        }
      });
    // $('#txtfecha').datetimepicker();
    $('#txtfecha').datetimepicker({
      locale: 'es',
      format: 'DD/MM/YYYY',
      minDate: moment("01/01/2015", "MM/DD/YYYY"),
      // minDate: moment(),
      maxDate: moment(),
    });
  
  
    $(".enlacerepar").attr("onclick","popup('zooms/zoomrepar.php','700','360')")
    $("#txtgest,#txtnro,#txtnroconta").numeric();
    $("#txthtd").inputmask("aaa99999");
  
    $(document).on('keyup','#txthtd, #txtglosa, #txtemp, #txtfact, #txtsolpor, #txtcotpor',function(){
      this.value = this.value.toUpperCase();
    });
  
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