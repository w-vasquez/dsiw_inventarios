$(document).ready(function(e){

	//console.log('funcioando')
	//podemas acceder por class
	//por etiquetas html $('h1').html('Etiqueta h1');
	//$('.container').html('desde clase');
	//a traves de un id en el html $('#idh1').html('desde id');

	//mediante javascript
	//document.querySelector('h1').innerHTML = 'Etiqueta h1';

	//utilizando todo lo que este en container
	//$('.container h1').html('herencia');
	//primer h1 dentro de container
	//$('.container h1:first').html('herencia');

	$('#bodega').change(function(){

		var parametros = "id="+$("#bodega").val()
		
		$.ajax({
			data: parametros,
			url: 'vista/includes/ajax_estante.php',
			type: 'post',
			beforeSend: function(){
				//alert("ok")
			},
			success: function (response){
				$("#estante").html(response)
			}
		})

	})

	$('#departamento').change(function(){
		var parametros = "id="+$("#departamento").val()
		//alert("ok");
		$.ajax({
			data: parametros,
			url: 'vista/includes/ajax_municipio.php',
			type: 'post',
			beforeSend: function(){
			},
			success: function (response){
				$("#municipio").html(response)
			}
		})

	})


})
