function popup(url,ancho,alto) {
	var x, y; 
	x=(screen.width/2)-(ancho/2); 
	y=(screen.height/2)-(alto/2); 
	window.open(url, "Ventana Emergente", "width="+ancho+",height="+alto+",status=0,menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left="+x+",top="+y+"");
} 