//este metodo es "universal" y se aplica sobre las etiquetas html y class
$(document).ready(function(e){

	//buscar producto

	// $('#txt_cod_producto').keyup(function(e){
	// 	e.preventDefault(); //prevenir que se recargue la página
	// 	var prodc = $(this).val(); //obtener valor
	// 	var action = 'searchProdc';
	// 	$.ajax({
	// 		url: 'vista/includes/ajax.php',
	// 		type: "post",
	// 		async: true,
	// 		data: {action:action,producto:prodc},
	// 		success: function(response)
	// 		{
	// 			console.log(response);
	// 		}
	// 	})
	// });

	// desde el lista_inventario addProduct
	$('.add_product').click(function(e){
		e.preventDefault();
		var producto = $(this).attr('product');//attr accede a los atributos de los elementos
		var usu = $(this).attr('usuario');
		var nivel = $(this).attr('nivel');
		var action = 'infoProducto';
		//alert(producto); //para probar si funciona nuestro jquery
		
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: 'POST',
			async: true,
			data: {action:action, producto:producto, user:usu, nivel:nivel},	
		
			success: function(response){
				//console.log(response); //para observar datos que vienen del ajax
				if(response != 'error'){
					//convertir el json a un objeto
					var info = JSON.parse(response);
					//console.log(info);
					$('#producto_id').val(info.id_producto); //val=agrega valor al input
					$('.nameProducto').html(info.producto); //html=agrega valor a una etiqueta
					
					//limpiar los select
					$("#bodega_id").find('option').remove();
					$("#estante_id").find('option').remove();
					$("#nivel_id").find('option').remove();

					//append agrega html 
					$("#bodega_id").append('<option value='+info.id_bodega+' selected="selected">'+info.bodega+'</option>');
					$("#estante_id").append('<option value='+info.id_estante+' selected="selected">'+info.estante+'</option>');
					$("#nivel_id").append('<option value='+info.id_nivel+' selected="selected">'+info.nivel+'</option>');
				}
			},

			error: function(error){
				console.log(error);
			}
		});
		$('.modal').fadeIn(500); //mostrar el modal
	});

	$('.add_NewProduct').click(function(e){
		//alert("probando botón");
		e.preventDefault();
		var action = 'addNewProdc';
		var stt = 'producto';
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,stt:stt},
		
			success: function(response){
				//console.log(response); //para observar datos que vienen del ajax
				if(response != 'error'){
					$("#producto_id_new").html('<option value="0" selected="selected">Seleccionar producto</option>');
					$('#producto_id_new').append(response);	
					$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
					$('#bodega_id_new').attr('disabled','disabled');
					$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
					$('#estante_id_new').attr('disabled','disabled');
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$('#nivel_id_new').attr('disabled','disabled');
				}else{
					$("#producto_id_new").html('<option value="0" selected="selected">Registro no identificado</option>');
					$('#producto_id_new').attr('disabled','disabled');
					$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
					$('#bodega_id_new').attr('disabled','disabled');
					$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
					$('#estante_id_new').attr('disabled','disabled');
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$('#nivel_id_new').attr('disabled','disabled');
				}
			},
			error: function(error){
				console.log(error);
			}
		});
		$('.modalNewProduct').fadeIn(400); //mostrar el modal

	});

	$('#producto_id_new').change(function(e){
		//alert("probando botón");
		e.preventDefault();
		var action = 'addNewProdc';
		var stt = 'bodega';
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: 'POST',
			async: true,
			data: {action:action,stt:stt},
		
			success: function(response){
				//console.log(response); //para observar datos que vienen del ajax
				if(response != 'error'){
					$('#bodega_id_new').removeAttr('disabled');
					$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
					$('#bodega_id_new').append(response);	
				}else{
					$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
					$('#bodega_id_new').attr('disabled','disabled');
					$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
					$('#estante_id_new').attr('disabled','disabled');
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$('#nivel_id_new').attr('disabled','disabled');
				}
			},
			error: function(error){
				console.log(error);
			}
		});
		//$('.modalNewProduct').fadeIn(400); //mostrar el modal
	});

	//para activar existencias por estante
	$('#bodega_id_new').change(function(e){
		e.preventDefault();
		var bodega_id = $(this).val();
		var action = 'addNewProdc';
		var stt = 'estante';
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,stt:stt,bodega_id:bodega_id},
			success: function (response){
				if(response != 'error')
				{
					$('#estante_id_new').removeAttr('disabled');
					$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
					$("#estante_id_new").append(response);
				}else{
					$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
					$('#estante_id_new').attr('disabled','disabled');
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$('#nivel_id_new').attr('disabled','disabled');
					$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
					$('#bodega_id_new').attr('disabled','disabled');
				}
			},
			error: function(error){
				console.log(error);
			}
		})
	});

	$('#estante_id_new').change(function(e){
		e.preventDefault();
		
		var bodega_id = $('#bodega_id_new').val();
		var estante_id = $(this).val();
		var action = 'addNewProdc';
		var stt = 'nivel';
		
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,stt:stt,estante_id:estante_id,bodega_id:bodega_id},
			success: function (response){
				if(response != 'error')
				{
					$('#nivel_id_new').removeAttr('disabled');
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$("#nivel_id_new").append(response);
				}else{
					$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
					$('#nivel_id_new').attr('disabled','disabled');
				}
			},
			error: function(error){
				console.log(error);
			}
		})
	});
});

//funcion para cerrar el modal que fue creado en el header.php
function closeModal(){
	$('.alertAddProduct').html('');
	$('#txtCantidad').val('');
	$('#txtPrecio').val('');
	$('.modal').fadeOut(); //cerrar el modal
	$('.modalNewProduct').fadeOut();
	location.reload();
	//$('.load').load('lista_inventario.php');
}

//funcion para enviar datos. Metodo aplicado en el Header (modal) y se envía por el form
//para actualizar la lista debemos actualizar los tr a traves de una class
function sendDataProduct(){
	$('.alertAddProduct').html('');
	var bodega_id = $('#bodega_id').val();
	//alert('enviar datos'); //probar si funciona
	
	$.ajax({
		url: 'vista/includes/ajax.php',
		type: 'POST',
		async: true,
		data: $('#form_add_product').serialize(),	
	
		success: function(response){
			//console.log(response); //para observar datos que vienen del ajax
			if(response == 'error')
			{
				$('.alertAddProduct').html('<p style="color: red;"> Error al agregar el producto </p>');

			}else{
				var info = JSON.parse(response);
				
				//agregar los valores nuevos a los campos en la tabla por el css
				$('.row'+info.id_inventario+' .celExistencia').html(info.Cantidad_existencia);
				$('.row'+info.id_inventario+' .celCostoTotal').html(info.Costo_total);
				$('.row'+info.id_inventario+' .celCostoUni').html(info.Costo_uni);

				//limpiamos los campos del modal
				$('#txtCantidad').val('');
				$('#txtPrecio').val('');

				//mostrar el mensaje
				$('.alertAddProduct').html('<p> producto guardado correctamente </p>');
			}
		},

		error: function(error){
			console.log(error);
		}
	});
}

function sendDataNewProduct(){
	$('.alertAddProduct').html('');
	$.ajax({
		url: 'vista/includes/ajax.php',
		type: 'POST',
		async: true,
		data: $('#form_add_NewProduct').serialize(),	
	
		success: function(response){
			console.log(response); //para observar datos que vienen del ajax
			if(response == 'error')
			{
				$('.alertAddProduct').html('<p style="color: red;"> Error al agregar el producto </p>');

			}else{
				var info = JSON.parse(response);
				//agregar los valores nuevos a los campos en la tabla por el css
				$('.row'+info.id_inventario+' .celExistencia').html(info.Cantidad_existencia);
				$('.row'+info.id_inventario+' .celCostoTotal').html(info.Costo_total);
				$('.row'+info.id_inventario+' .celCostoUni').html(info.Costo_uni);
				

				//limpiamos los campos del modal
				$('#txtCantidad_new').val('');
				$('#txtPrecio_new').val('');
				//Restablecer selects
				$("#producto_id_new").html('<option value="0" selected="selected">Seleccionar producto</option>');
				//$('#producto_id_new').attr('disabled','disabled');
				$("#bodega_id_new").html('<option value="0" selected="selected">Seleccionar bodega</option>');
				$('#bodega_id_new').attr('disabled','disabled');
				$("#estante_id_new").html('<option value="0" selected="selected">Seleccionar estante</option>');
				$('#estante_id_new').attr('disabled','disabled');
				$("#nivel_id_new").html('<option value="0" selected="selected">Seleccionar nivel</option>');
				$('#nivel_id_new').attr('disabled','disabled');

				//mostrar el mensaje
				$('.alertAddProduct').html('<p> producto guardado correctamente </p>');
				
			}
		},

		error: function(error){
			console.log(error);
		}
	});
}

function searchForDetalle(id){
	var action = 'searchForDetalle';
	var user = id;


	$.ajax({
		url: 'vista/includes/ajax.php',
		type: 'POST',
		async: true,
		data: {action:action,user:user},	
	
		success: function(response){
			console.log(response); //para observar datos que vienen del ajax
			
		},

		error: function(error){
			console.log(error);
		}
	});
}