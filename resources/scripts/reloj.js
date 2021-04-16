function dosCaracteres ( val )
{
	return ( val < 10 ) ? '0' + val : String ( val )
}

function muestraReloj()
{
	fechaActual = new Date()
	hora = dosCaracteres ( fechaActual.getHours() )
	minuto = dosCaracteres( fechaActual.getMinutes() )
	segundo = dosCaracteres( fechaActual.getSeconds() )
	
	horaEnTexto = hora + ":" + minuto + ":" + segundo
	document.getElementById ( 'reloj' ).innerHTML = horaEnTexto
	setTimeout ( "muestraReloj ()", 1000 )
}