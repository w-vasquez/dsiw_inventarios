$(document).ready(function(){

	//buscar producto

	$('#txt_cod_producto').keyup(function(e){
		e.preventDefault(); //prevenir que se recargue la página
		var prodc = $(this).val(); //obtener valor
		var action = 'searchProdc';
		$.ajax({
			url: 'vista/includes/ajax.php',
			type: "post",
			async: true,
			data: {action:action,producto:prodc},
			success: function(response)
			{
				console.log(response);
			}
		})
	})
})