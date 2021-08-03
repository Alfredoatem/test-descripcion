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

  //$(".btn_guardaregistro").click(function(e){
  $("form.registro").submit(function(e){
      e.preventDefault();
      var form_data = $('form.registro').serialize();
      var llaves = $("form.registro").find('.llaves').serialize();
      // alert('llaves'+llaves);
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxreg1i.php",
        data : form_data+"&"+llaves,
        success : function(html){
          if(html=="Ok"){
            $('#message').html('<div class="alert alert-success fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Se Registró Correctamente!!</div>');
          }else{
            $('#message').html('<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>'+html+'</div>');
          }
        }
      });
    });


  $(".btn_canceldet, .btn_canceldesc, .btn_cancelpyv").click(function(){
    location.reload();
  })

  $(".btn_cancelar").click(function(){
    location.reload();
  })

  /*Funciones de Detalle*/
  $(document).on('click','.add',function(){
    $("tr.copy:last").clone().insertAfter('tr.copy:last');
    $("tr.copy:last input").val("");
    $(this).find("span").remove();
    $(this).append('<span class="fa fa-minus fa-2x"></span>');
    $(this).attr('class','del');

    $(".txtcant,.txtpu,.txtmonto, #monto").css('text-align','right');
    $(".txtcant").number(true,2,'.','');
    $(".txtpu").number(true,7,'.','');
    enlace();
  });

  $(document).on('click','.del',function(){
    $(this).parent().parent().remove();
    $(".txtmonto").trigger("keyup");
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

  $('#message').on('close.bs.alert', function(){
    location.reload();
  });

 //prueba
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
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxsaldocant.php",
        data : "codprod="+$(".hdncodprod:eq("+index+")").val()+"&dcto_m="+$(".txtdcto_m:eq("+index+")").val()+"&nro_m="+$(".txtnro_m:eq("+index+")").val()+"&pu="+$(".txtpu:eq("+index+")").val()+"&txtcant="+$(".txtcant:eq("+index+")").val()+"&codtip="+$("#cbotiper").val(),
        success : function(data){
          var json = eval("(" + data + ")");
          // alert('hola');
          // $('#saldocant:eq('+index+')').val(json.value+";"+json.result2+";"+json.result3+";"+json.result4+";"+json.result5+";"+json.result6+";"+json.result7);
          $('#saldocant:eq('+index+')').val(json.value);
        }
      });
    });
    $('#monto').val(importe.toFixed(2));
  });

  $(".txtcant,.txtpu").trigger("keyup");
  //fin
  $(document).on('change','#cbotiper',function(){
      enlace();
  });

});


function enlace(){
    $(".copy").each(function(index, element) {
      $(".enlacesal:eq(" + index + ")").attr("onclick", "popup('zooms/zoomsal1.php?indice=" + index + "&cbotiper=" + $("#cbotiper").val() + "&codgranalm=" + $("#hdncodgranalm").val() + "&codprod=" + $(".hdncodprod:eq(" + index + ")").val() + "&codalm=" + $(".hdncodalm:eq(" + index + ")").val() + "','700','360')")
      // $(".enlacesal:eq(" + index + ")").attr("onclick", "popup('zooms/zoomsal1.php?indice=" + index + "&cbotiper=" + $("#cbotiper").val() + "&codgranalm=" + $("#hdncodgranalm").val() + "&codprod=" + $(".hdncodprod:eq(" + index + ")").val() + "&codalm=" + $(".hdncodalm:eq(" + index + ")").val() + "','700','360')")

      //$(".enlacesal:eq("+index+")").attr("onclick","#")

      $(".mate:eq("+index+")").focusin(function() {
        var texto = $(this).val(),
            separador = ";",
            textoseparado = texto.split(separador);
            //console.log(textoseparado);
            $(".txtdcto_m:eq("+index+")").val(textoseparado[0]);
            $(".txtnro_m:eq("+index+")").val(textoseparado[1]);
            $(".txtpu:eq("+index+")").val(textoseparado[2]);
      });

    $(".enlacealm:eq("+index+")").attr("onclick","popup('zooms/zoomalm2.php?indice="+index+"','700','360')")
    //$(".enlaceprod:eq("+index+")").attr("onclick","popup('zooms/zoomprod2.php?indice="+index+"&partida="+$('.txtpart').val()+"','700','360')")
    $(".enlaceprod:eq("+index+")").attr("onclick","popup('zooms/zoomprod2.php?indice="+index+"','700','360')")
    $(".hdncodalm:eq("+index+")").focusin(function() {
      // alert('hola2');
      enlace();
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxalmarr.php",
        data : "valor="+$(".hdncodalm:eq("+index+")").val(),
        success : function(data){
          var json = eval("(" + data + ")");
          // alert('hola');
          $('.txtalm:eq('+index+')').val(json.value);
        }
      });
    });
    $(".hdncodprod:eq("+index+")").focusin(function() {
      enlace();
      $.ajax({
        type : 'POST',
        url : "../ajax/ajaxprodarr.php",
        data : "valor="+$(".hdncodprod:eq("+index+")").val(),
        success : function(data){
          var json = eval("(" + data + ")");
          $('.txtprod:eq('+index+')').val(json.value);
        }
      });
    });
  });
}