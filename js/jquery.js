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
				//console.log(response);	
				if(response != 0)
				{

					//append agrega html 

					var info = JSON.parse(response);
					$('#txt_producto').html(info.producto);
					$('#cod_producto').val(info.id_producto);
					//$("#txt_existencia").html(info.Cantidad_existencia);
					$('#cto_uni').val(info.costo_unitario);
					
					//activar campos
					$('#select_bodega_add').removeAttr('disabled');
					//$('#select_estante_add').removeAttr('disabled');
					//$('#select_nivel_add').removeAttr('disabled');
					//$('#txt_cant_producto').removeAttr('disabled');
					//$('#add_product_venta').slideDown();
					//var_dump(info);	
					//console.log(info)
				}
				else
				{
					$('#txt_producto').html('--');
					$('#cod_producto').val("");
					$("#txt_existencia").html("--");
					$('#cto_uni').val("");
					$('#select_bodega_add').attr('disabled','disabled');
					$('#select_estante_add').attr('disabled','disabled');
					$('#select_nivel_add').attr('disabled','disabled');
					$('#txt_cant_producto').attr('disabled','disabled');
					$('#add_product_venta').slideUp();
					$("#txt_precio").html('');
					$('#txt_cant_producto').val('');

				}
			}
		})
	})

	//para activar select bodega
	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault(); //prevenir que se recargue la página
		var prodc = $(this).val() //obtener valor
		var action = 'searchBodega'
		//console.log(prodc);
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			success: function(response)
			{
				if(response != 'error')
				{
					//console.log(response)
					$("#select_bodega_add").html(response);
					$('#select_estante_add').removeAttr('disabled');
				}else{
					$("#select_bodega_add").find('option').remove();
					$("#select_estante_add").find('option').remove();
					$("#select_nivel_add").find('option').remove();
					$('#select_estante_add').attr('disabled','disabled');
					$('#select_nivel_add').attr('disabled','disabled');
					
					$("#select_bodega_add").append('<option value=0 selected="selected"></option>');
					$("#select_estante_add").append('<option value=0 selected="selected"></option>');
					$("#select_nivel_add").append('<option value=0 selected="selected"></option>');
					//append agrega html 	
				}
				
			}
		})
	})

	//para activar select estantes
	$('#select_bodega_add').click(function(e){
		e.preventDefault();
		var bodega_id = $(this).val(); //obtener valor
		var producto_id = $('#txt_cod_producto').val();
		//console.log(producto_id)
		var action = 'searchEstante'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,bodega_id:bodega_id,producto_id:producto_id},
			beforeSend: function(){
			},
			success: function (response){
				if (response != 'error') {
					$('#select_estante_add').html(response);
					$('#select_nivel_add').removeAttr('disabled');
				}else{
					$("#select_bodega_add").find('option').remove();
					$("#select_estante_add").find('option').remove();
					$("#select_nivel_add").find('option').remove();
					$('#select_estante_add').attr('disabled','disabled');
					$('#select_nivel_add').attr('disabled','disabled');
					
					$("#select_bodega_add").append('<option value=0 selected="selected"></option>');
					$("#select_estante_add").append('<option value=0 selected="selected"></option>');
					$("#select_nivel_add").append('<option value=0 selected="selected"></option>');
				}
				
				
			}
		})
	})

	

	//para activar select niveles
	$('#select_estante_add').click(function(e){
		e.preventDefault();
		
		var estante_id = $(this).val(); //obtener valor
		var bodega_id = $('#select_bodega_add').val();
		var producto_id = $('#txt_cod_producto').val();
		//console.log(estante_id);
		var action = 'searchNivel'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,estante_id:estante_id,bodega_id:bodega_id,producto_id:producto_id},
			beforeSend: function(){
			},
			success: function (response){
				//alert(response);
				if (response != 'error') {

					$("#select_nivel_add").html(response);
					$('#select_nivel_add').removeAttr('disabled');
				}else{
					$("#select_bodega_add").find('option').remove();
					$("#select_estante_add").find('option').remove();
					$("#select_nivel_add").find('option').remove();
					$("#select_estante_add").attr('disabled','disabled');
					$("#select_nivel_add").attr('disabled','disabled');
					
					$("#select_bodega_add").append('<option value=0 selected="selected"></option>');
					$("#select_estante_add").append('<option value=0 selected="selected"></option>');
					$("#select_nivel_add").append('<option value=0 selected="selected"></option>');
				}
				
			}
		})
	})

	//para activar existencias por nivel
	$('#select_nivel_add').click(function(e){
		e.preventDefault();
		var producto_id = $('#txt_cod_producto').val()
		var bodega_id = $('#select_bodega_add').val()
		var estante_id = $('#select_estante_add').val()
		var nivel_id = $(this).val()
		var action = 'searchExistencia'
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto_id:producto_id,bodega_id:bodega_id,estante_id:estante_id,nivel_id:nivel_id},
			beforeSend: function(){
			},
			success: function (response){
				if(response != 'error')
				{
					$("#txt_existencia").html(response);
					$('#txt_cant_producto').removeAttr('disabled');
				}else{
					$("#txt_cant_producto").attr('disabled','disabled');
					//----------------------
				}
				
			}
		})
	})

	//para activar existencias por estante
	// $('#select_estante').change(function(e){
	// 	e.preventDefault();
	// 	var prodc = $('#txt_cod_producto').val()
	// 	var bodega = $('#select_bodega').val()
	// 	var estante = $('#select_estante').val()
	// 	var nivel = $(this).val()
	// 	var action = 'searchExistencia'
	// 	$.ajax({
	// 		url: 'vista/includes/ajax.php',
	// 		type: "post",
	// 		async: true,
	// 		data: {action:action,producto:prodc,bodega:bodega,estante:estante,nivel:nivel},
	// 		beforeSend: function(){
	// 		},
	// 		success: function (response){
	// 			$("#txt_existencia").html(response)
	// 		}
	// 	})
	// })

	//para activar validacion existencias y cantidad
	$('#txt_cant_producto').keyup(function(e){
		e.preventDefault();
		var cantidad = parseFloat($(this).val());
		var costo_articulo = cantidad * parseFloat($("#cto_uni").val());
		var existencia = parseFloat($("#txt_existencia").html());
		
		//ocultar el boton agregar si la cantidad en menor

		console.log( costo_articulo );
		if( (existencia < cantidad) || isNaN(cantidad) || (cantidad<1)) 
		{
			
				$('#add_product_venta').slideUp();
				$("#txt_precio").html('');
				
		}else{
			
			$('#add_product_venta').slideDown();
			$("#txt_precio").html(costo_articulo);
			
		}
		
	})

	$('#add_product_venta').click(function(e){
		e.preventDefault();
		
		if( $('#cod_producto').val() > 0)
		{

			var producto_id = $('#cod_producto').val();
			var cantidad = parseFloat($('#txt_cant_producto').val());
			var costo = parseFloat( $('#txt_precio').html() );
			var nivel_id = $('#txt_cant_producto').val();
			var orden_id = 4//$('#orden_id').val();
			var action = 'addProductoDetalle';

			$.ajax({
				url: 'vista/includes/ajax.php',
				type: "post",
				async: true,
				data: {action:action,producto_id:producto_id,cantidad:cantidad,costo:costo,nivel_id:nivel_id,orden_id:orden_id},
				beforeSend: function(){
				},
				success: function (response){
					//console.log(response);
					if(response != 'error')
					{
						var info = JSON.parse(response);	
						//console.log(info);
						$('#detalle_venta').html(info.detalle);
						$('#detalle_total').html(info.totales);

						//limpiar formulario

						$('#txt_cod_producto').val('');


					}else{
						console.log('no data');
					}
				}
			})
		}
		
		
	})

}) //Fin READY

function searchForDetalle(id){
	var action = 'searchForDetalle';
	var user = id;


	$.ajax({
		url: 'vista/includes/ajax.php',
		type: 'POST',
		async: true,
		data: {action:action,user:user},	
	
		success: function(response){
			//console.log(response); //para observar datos que vienen del ajax
			if(response != 'error')
			{
				var info = JSON.parse(response);	
				//console.log(info);
				$('#detalle_venta').html(info.detalle);
				$('#detalle_total').html(info.totales);


			}else{
				console.log('no data');
			}
			
		},

		error: function(error){
			console.log(error);
		}
	});
}
