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

	//configuracion select concepto
	//$('#select_concepto_entrada').select(function(e){
	$('#principal_bodega_deshabilitar').click(function(e){
		e.preventDefault(); //prevenir que se recargue la página
		//var tipo = $(this).val() //omito capturar valor
		var action = 'searchTipo'
		
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action},//,tipo:tipo},
			success: function(response){
				//console.log(response);
				$("#select_concepto_entrada").html(response)
			},
			error: function(error){

			}

		})
	})

	//boton guardar orden
	$('#form_orden').submit(function(e){
		e.preventDefault();

		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: $('#form_orden').serialize(), //obtenemos todos los datos del form
			success: function(response){
				console.log(response)
				if(response == 0){
					$('mensaje').html('Identificar bodega y tipo de salida');
				}
			},
			error: function(){

			}

		})



	})


	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault(); //prevenir que se recargue la página
		var prodc = $(this).val() //obtener valor
		var action = 'searchProdc'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			success: function(response)
			{
				//console.log(response)
				if(response != 0)
				{
					var info = JSON.parse(response);
					$('#txt_producto').html(info.producto);
					$('#cod_producto').val(info.id_producto);
					$("#txt_existencia").html(info.Cantidad_existencia);
					$('#cto_uni').val(info.costo_unitario);
					
					//activar campos
					$('#select_bodega').removeAttr('disabled');
					$('#select_estante').removeAttr('disabled');
					$('#select_nivel').removeAttr('disabled');
					$('#txt_cant_producto').removeAttr('disabled');
					$('#add_product_venta').slideDown();
					//var_dump(info);	
					//console.log(info)
				}
				else
				{
					$('#txt_producto').html('--');
					$('#cod_producto').val("");
					$("#txt_existencia").html("--");
					$('#cto_uni').val("");
					$('#select_bodega').attr('disabled','disabled');
					$('#select_estante').attr('disabled','disabled');
					$('#select_nivel').attr('disabled','disabled');
					$('#add_product_venta').slideUp();
				}
			}
		})
	})

	//para activar select bodega
	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault(); //prevenir que se recargue la página
		var prodc = $(this).val() //obtener valor
		var action = 'searchBodega'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			success: function(response)
			{
				//console.log(response)
				$("#select_bodega").html(response)
			}
		})
	})

	//para activar select estantes
	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault();
		var prodc = $(this).val() //obtener valor
		//console.log(prodc)
		var action = 'searchEstante'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			beforeSend: function(){
			},
			success: function (response){
				$("#select_estante").html(response)
			}
		})
	})

	//para activar select niveles
	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault();
		var prodc = $(this).val() //obtener valor
		//console.log(prodc)
		var action = 'searchNivel'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			beforeSend: function(){
			},
			success: function (response){
				$("#select_nivel").html(response)
			}
		})
	})

	//para activar existencias por nivel
	$('#select_nivel').change(function(e){
		e.preventDefault();
		var prodc = $('#txt_cod_producto').val()
		var bodega = $('#select_bodega').val()
		var estante = $('#select_estante').val()
		var nivel = $(this).val()
		var action = 'searchExistencia'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc,bodega:bodega,estante:estante,nivel:nivel},
			beforeSend: function(){
			},
			success: function (response){
				$("#txt_existencia").html(response)
			}
		})
	})

	//para activar existencias por estante
	$('#select_estante').change(function(e){
		e.preventDefault();
		var prodc = $('#txt_cod_producto').val()
		var bodega = $('#select_bodega').val()
		var estante = $('#select_estante').val()
		var nivel = $(this).val()
		var action = 'searchExistencia'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc,bodega:bodega,estante:estante,nivel:nivel},
			beforeSend: function(){
			},
			success: function (response){
				$("#txt_existencia").html(response)
			}
		})
	})

	//para activar validacion existencias y cantidad
	$('#txt_cant_producto').keyup(function(e){
		e.preventDefault();
		var costo_articulo = $(this).val() * $("#cto_uni").val();
		var existencia = $("#txt_existencia").html();
		//ocultar el boton agregar si la cantidad en menor

		console.log( existencia );
		if($(this).val() <1 || isNaN($(this).val()) || existencia < $(this).val())
		{
			
				$('#add_product_venta').slideUp();
			
				
		}else{
			
			$('#add_product_venta').slideDown();
			
		}
		
	})

})
