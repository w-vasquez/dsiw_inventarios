
	
	</body>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="js/jquery.js"></script>
	<script src="js/functions.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(e){
		var usuarioid = "<?php  echo $_SESSION['idUsu']; ?>";
		searchForDetalle(usuarioid);
	})

</script>
</html>