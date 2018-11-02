function WaitingOpen(texto){
	if(texto == '' || texto == null){
		$('#waitingText').html('Cargando ...');
	}
	else{
		$('#waitingText').html(texto);
	}
	$('#waiting').fadeIn('slow');
}

function WaitingClose(){
	$('#waiting').fadeOut('slow');
}

function LoadIconAction(idTag, action){
	var icon = "";
	var actt = "";

	switch(action){
		case	'Add':
			icon = '<i class="fa fa-fw fa-plus-square" style="color: #00a65a"></i>';
			actt = 'Agregar ';
			break;
		case 	'Edit':
			icon = '<i class="fa fa-fw fa-pencil" style="color: #f39c12;"></i>';
			actt = 'Editar ';
			break;
		case 	'Del':
			icon = '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39;"></i>';
			actt = 'Eliminar ';
			break;
		case 	'View':
			icon = '<i class="fa fa-fw fa-search" style="color: #3c8dbc"></i>';
			actt = 'Consultar ';
			break;
		case 	'Program':
			icon = '<i class="fa fa-fw fa-clock-o" style="color: #D81B60"></i>';
			actt = 'Programar ';
			break;
		case 	'ReProgram':
			icon = '<i class="fa fa-fw fa-clock-o" style="color: #D81B60"></i>';
			actt = 'Re-Programar ';
			break;
	}

	$('#'+idTag).html(icon + actt);
}

/* Devuelve Fecha Hora formateado para input date */
function getFechaHoraFormateada(date) {
	/* date es objeto fecha */
	var str = date.getFullYear() + "-" + getDosDigitos(date.getMonth()) + "-" + getDosDigitos(date.getDate()) + " " +  getDosDigitos(date.getHours()) + ":" + getDosDigitos(date.getMinutes()) + ":" + getDosDigitos(date.getSeconds());
	return str;
}
/* Devuelve Fecha Hora formateado para input date */
function getFechaFormateada(date) {
	/* date es objeto fecha */
	var str = date.getFullYear() + "-" + getDosDigitos(date.getMonth()) + "-" + getDosDigitos(date.getDate());
	return str;
}
/* Devuelve fecha con dos digitos */
function getDosDigitos(partTime) {
	if (partTime<10)
		return "0"+partTime;
	return partTime;
}





function ActiveCamera() {

	$("#botonDetener").removeAttr("disabled", "disabled");
	$("#botonFoto").removeAttr("disabled", "disabled");
	$("#botonIniciar").attr("disabled", "disabled");
  	init();
  	function init(){
	    var video = document.querySelector('#camara'), canvas = document.querySelector('#foto'), btn = document.querySelector('#botonFoto'), img = document.querySelector('#imgCamera');

	    navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUSerMedia || navigator.msGetUserMedia);

	    if(navigator.getUserMedia){
	      navigator.getUserMedia({video:true},function(stream){
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	      },function(e){console.log(e)});

	      video.addEventListener('loadedmetadata',function(){canvas.width = video.videoWidth, canvas.height = video.videoHeight;},false);
	      btn.addEventListener('click',function(){
	      	$('#updatePicture').val('1');
	        canvas.getContext('2d').drawImage(video,0,0);
	        var imgData = canvas.toDataURL('image/png');
	        img.setAttribute('src',imgData);

	      });

	    }else{
	      alert("Actualiza tu nvegador");
	    }
  	}
}

function StopCamera() {
	$("#botonDetener").attr("disabled", "disabled");
    $("#botonFoto").attr("disabled", "disabled");
    $("#botonIniciar").removeAttr("disabled", "disabled");

	var video = document.querySelector('#camara');
	navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUSerMedia || navigator.msGetUserMedia);

	if(navigator.getUserMedia){
	      navigator.getUserMedia({video:true},function(stream){
	        video.pause();
	      },function(e){console.log(e)});
	}
}


function ActiveCameraArt() {

	$("#botonDetener").removeAttr("disabled", "disabled");
	$("#botonFoto1").removeAttr("disabled", "disabled");
	$("#botonFoto2").removeAttr("disabled", "disabled");
	$("#botonFoto3").removeAttr("disabled", "disabled");
	$("#botonFoto4").removeAttr("disabled", "disabled");
	$("#botonIniciar").attr("disabled", "disabled");
  	init();
  	function init(){
	    var video = document.querySelector('#camara'), 
	    canvas = document.querySelector('#foto'), 
	    btn1 = document.querySelector('#botonFoto1'), 
	    btn2 = document.querySelector('#botonFoto2'), 
	    btn3 = document.querySelector('#botonFoto3'), 
	    btn4 = document.querySelector('#botonFoto4'), 
	    img1 = document.querySelector('#imgCamera1'),
	    img2 = document.querySelector('#imgCamera2'),
	    img3 = document.querySelector('#imgCamera3'),
	    img4 = document.querySelector('#imgCamera4');

	    navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUSerMedia || navigator.msGetUserMedia);

	    if(navigator.getUserMedia){
	      navigator.getUserMedia({video:true},function(stream){
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	      },function(e){console.log(e)});

	      video.addEventListener('loadedmetadata',function(){canvas.width = video.videoWidth, canvas.height = video.videoHeight;},false);
	      btn1.addEventListener('click',function(){
	      	$('#updatePicture1').val('1');
	        canvas.getContext('2d').drawImage(video,0,0);
	        var imgData = canvas.toDataURL('image/png');
	        img1.setAttribute('src',imgData);

	      });
	      btn2.addEventListener('click',function(){
	      	$('#updatePicture2').val('1');
	        canvas.getContext('2d').drawImage(video,0,0);
	        var imgData = canvas.toDataURL('image/png');
	        img2.setAttribute('src',imgData);

	      });
	      btn3.addEventListener('click',function(){
	      	$('#updatePicture3').val('1');
	        canvas.getContext('2d').drawImage(video,0,0);
	        var imgData = canvas.toDataURL('image/png');
	        img3.setAttribute('src',imgData);

	      });
	      btn4.addEventListener('click',function(){
	      	$('#updatePicture4').val('1');
	        canvas.getContext('2d').drawImage(video,0,0);
	        var imgData = canvas.toDataURL('image/png');
	        img4.setAttribute('src',imgData);

	      });

	    }else{
	      alert("Actualiza tu nvegador");
	    }
  	}
}