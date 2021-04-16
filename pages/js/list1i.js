// JavaScript Document
$(function(){
  /*Funciones Iniciales*/
  $('form.maestro').find('input[type=text]').each(function(){
    $(this).attr('readonly','readonly')
  });

  $('form.maestro').find('select').each(function(){
    $(this).attr('disabled','true')
  });

  $('div.guardar').hide();

  $('.pagination .disabled a, .pagination .active a').on('click', function(e) {
    e.preventDefault();
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

  /*Funciones de Edicion*/
  $(".btn_edit").click(function(){
    var anio = (new Date).getFullYear();
    if($("#txtgest").val()>=anio){
      $('form.maestro').find('input[type=text]').each(function(){
        $(this).removeAttr('readonly')
      });
      $('form.maestro').find('select').each(function(){
        $(this).removeAttr('disabled')
      });
    }

    $(".llaves,#txtrepar").attr('readonly','readonly');     
    $('div.guardar').show();

    $('#txtfec').datetimepicker({
      locale: 'es',
      format: 'L',
      minDate: moment("01/01/"+anio),
      maxDate: moment(),
      useCurrent: false
    });

    $(".enlacerepar").attr("onclick","popup('zooms/zoomrepar.php','700','360')")
    $("#txtgest,#txtnro,#txtnroconta").numeric();
    $("#txthtd").inputmask("aaa99999");
    $("#txtipo").alpha({nchars:"ABCDEGHIJKLMÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890"});

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

  $("form.maestro").submit(function(e){
    e.preventDefault();
    var form_data = $('form.maestro').serialize();
    $.ajax({
      type : 'POST',
      url : "../ajax/ajaxupd1i.php",
      data : form_data,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizo Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>'); 
        }
      }
    });
  });

  $(".btn_cancelar").click(function(){
    location.reload();
  })


  /*Funciones de Detalle*/
  $('[data-toggle="tooltip"]').tooltip();
  $(".txtcant,.txtpu,.txtmonto, #monto").css('text-align','right');
  $(".txtcant").number(true,2,'.','');
  $(".txtpu").number(true,7,'.','');
    
  $(document).on('click','.add',function(){
    $("tr.copy:last").clone().insertAfter('tr.copy:last');
    $("tr.copy:last input").val("");
    $(this).find("span").remove();
    $(this).append('<span class="fa fa-minus fa-2x"></span>');
    $(this).attr('class','del');

    $(".txtcant").number(true,2,'.','');
    $(".txtpu").number(true,7,'.','');
    $(".txtcant,.txtpu").trigger("keyup");
    //genera el id del selector
    var indice = $("tr.copy:last input.txtalm").attr("id").indexOf("_")+1;
    var valor = $("tr.copy:last input.txtalm").attr("id").substring(indice);
    $("tr.copy:last input.txtalm").attr("id","txtalm_"+(parseInt(valor)+1));
    $("tr.copy:last input.txtprod").attr("id","txtprod_"+(parseInt(valor)+1));
    $("tr.copy:last input.hdncodalm").attr("id","hdncodalm_"+(parseInt(valor)+1));
    $("tr.copy:last input.hdncodprod").attr("id","hdncodprod_"+(parseInt(valor)+1));
    zoomalm();
    zoomprod();
  });
  zoomalm();
  zoomprod();
  
  $(document).on('click','.del',function(){
    $(this).parent().parent().remove();
    $(".txtcant,.txtpu").trigger("keyup");
  });
  
  $(document).on('keyup','.txtcant,.txtpu',function(){
    var importe = 0;
    $('.txtcant').each(function(index, element){
      var c = eval($(this).val());
      var p = eval($('.txtpu:eq('+index+')').val())
      if(c==null || c=='') c=0;
      if(p==null || p=='') p=0;
      importe = importe + (c*p);
      var cal = $('.txtcant:eq('+index+')').val() * $('.txtpu:eq('+index+')').val()
			$('.txtmonto:eq('+index+')').val(cal.toFixed(2))
    });
    $('#monto').val(importe.toFixed(2));
  });

  $(".txtcant,.txtpu").trigger("keyup");

  $(".btn_guardadet").click(function(e){
    e.preventDefault();
    var form_data = $('form.detalle').serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxupdet.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizo Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });

  /*Funciones de Eliminacion*/
  $('.btn_delete').on('click', function(e) {
    e.preventDefault();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxdelprev.php",
      data : llaves,
      success : function(html){
        if(html=="Ok"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Eliminó Correctamente!!</div>');
        }else{
          $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
        }
      }
    });
  });

  /*Funcion Descargo*/
  var llavedesc = $("form.maestro").find('.llaves').serialize();
  $.ajax({
    type : 'POST',
    url : "ajaxestdesc.php",
    data : llavedesc,
    success : function(data){
      var json = eval("(" + data + ")");
      $('#txtrevisor').attr('value',json.revisor);
      $('#txtrevisor').attr('readonly','readonly');
      if(json.value==""){
        $('#txtestado').attr('value','R');
        $('#txtfdesc,#txtestado,#txtfsal').attr('readonly','readonly');
        $('#txtanexo').removeAttr('readonly');
      }else{
        if(json.value=="D" || json.value=="J" || json.value=="O" || json.value=="R"){
          $('#txtfdesc').attr('readonly','readonly');
          $('#txtanexo,#txtfsal').removeAttr('readonly');
        }else{
          $('input[type=text]').attr('readonly','readonly');
          $('.btn_guardadesc').attr('class','btn btn-success btn_guardadesc disabled')
          $('.btn_guardadesc').on('click', function(e) {
            e.preventDefault();
          });
        }
      }
    }
  });

  $('#txtfecde').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    defaultDate: moment()
  });

  $('#txtfecds').datetimepicker({
    locale: 'es',
    format: 'DD/MM/YYYY',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    defaultDate: moment()
  });

  $("#txthtddesc").inputmask("aaa99999");
  $("#txtestado").alpha({nchars:"BCEFGHIJKLMNÑPQSTUVWYZabcdefghijklmnñopqrstuvwxyz1234567890"});
  $(document).on('keyup','#txthtddesc, #txtanexo',function(){
    this.value = this.value.toUpperCase();
  });

  $("form.descargo").submit(function(e){
    e.preventDefault();
    var form_data = $(this).serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxdescprev.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Actualizado"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizó el Descargo Correctamente!!</div>');
        }else{
          if(html=="Registrado"){
            $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Registró el Descargo Correctamente!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>'); 
          }
        }
        $(".modalvobo").modal('toggle');
      }
    });
  });

  /*Funcion Pasajes*/
  $('#txtfecini').datetimepicker({
    locale: 'es',
    format: 'L',
    minDate: moment("01/01/2015"),
    maxDate: moment(),
    useCurrent: false
  });

  $('#txtfecfin').datetimepicker({
    locale: 'es',
    format: 'L',
    useCurrent: false
  });

  $("#txtfecini").on("dp.change", function (e) {
    $('#txtfecfin').data("DateTimePicker").minDate(e.date);
  });
  $("#txtfecfin").on("dp.change", function (e) {
    $('#txtfecini').data("DateTimePicker").maxDate(e.date);
  });

  $(document).on('keyup','#txtobs',function(){
    this.value = this.value.toUpperCase();
  });

  $("form.pasajes").submit(function(e){
    e.preventDefault();
    var form_data = $(this).serialize();
    var llaves = $("form.maestro").find('.llaves').serialize();
    $.ajax({
      type : 'POST',
      url : "ajaxpyvprev.php",
      data : form_data+"&"+llaves,
      success : function(html){
        if(html=="Actualizado"){
          $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Actualizó las fechas de pasajes Correctamente!!</div>');
        }else{
          if(html=="Registrado"){
            $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Registró las fechas de pasajes Correctamente!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
          }
        }
        $(".modalgenconta").modal('toggle');
      }
    });
  });

  $('#message').on('close.bs.alert', function(){
    location.reload();
  });

  $(".btn_canceldet, .btn_canceldesc, .btn_cancelpyv").click(function(){
    location.reload();
  })

});

function zoomalm(){
  $(".enlacealm").each(function(index,element){
    var ida = $(this).parent().parent().find('input').attr("id");
    var indice = $(this).parent().parent().find('input').attr("id").indexOf("_")+1;
    var valor = $(this).parent().parent().find('input').attr("id").substring(indice);
    $(this).attr("onclick","popup('zooms/zoomalm.php?indice="+ida+"','700','360')");
    $(document).on('focusin','#hdncodalm_'+valor,function(){
      $("#txtalm_"+valor).prop("title",$(this).val());
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxalmarr.php",
        data : "valor="+$(this).val(),
        success : function(data){
          var json = eval("(" + data + ")");
          $("#txtalm_"+valor).val(json.value);
          $("#txtalm_"+valor).removeData($(this).data('original-title'));
          $("#txtalm_"+valor).data("placement","left");
          $('[data-toggle="tooltip"]').tooltip();
        }
      });
    });
  })
}

function zoomprod(){
  $(".enlaceprod").each(function(index,element){
    var idp = $(this).parent().parent().find('input').attr("id");
    var indice = $(this).parent().parent().find('input').attr("id").indexOf("_")+1;
    var valor = $(this).parent().parent().find('input').attr("id").substring(indice);
    $(this).attr("onclick","popup('zooms/zoomprod.php?indice="+idp+"','700','360')");
    $(document).on('focusin','#hdncodprod_'+valor,function(){
      $("#txtprod_"+valor).prop("title",$(this).val());
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxprodarr.php",
        data : "valor="+$(this).val(),
        success : function(data){
          var json = eval("(" + data + ")");
          $("#txtprod_"+valor).val(json.value);
          $("#txtprod_"+valor).removeData($(this).data('original-title'));
          $("#txtprod_"+valor).data("placement","left");
          $('[data-toggle="tooltip"]').tooltip();
        }
      });
    });
  })
}