<!DOCTYPE html>
<html>
<?php
session_start();
if(isset($_SESSION["id_usuario"])){
	if($_SESSION['sexo'] == "M")
		$page_title = "Bem vindo, ".$_SESSION['nome_usuario'].".";
	else
		$page_title = "Bem vinda, ".$_SESSION['nome_usuario'].".";
}
else{
  header("location:login.php");
}
?>
<head>
	<title>Evasão</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css"/>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	        <img alt="Brand" src="university-pin.png">
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      <!-- ME AJUDA A ESTILIZAR A TAG SELECT COM O SELECT2, OS ARQUIVOS ESTÃO NO PROJETO, FALTA LINKAR -->
	      <select>
	      	<option>Cariacica</option>
	      	<option>Vila Velha</option>
	      </select>

<!-- 	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Filrar por Cidade <span class="caret"></span></a>
	          <ul class="dropdown-menu" id="listCidades">
	            <li><input type="checkbox">Cariacica</li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li> -->
	        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
	      </ul>
<!-- 	      <form class="navbar-form navbar-left">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-danger">Submit</button>
	      </form> -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
</head>



<body>
	<div id="mapid" style="width: 600px; height: 400px">
	</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Carregar Base de dados</h4>
      </div>
      <div class="modal-body">
        Olá <?php echo $_SESSION['nome_usuario'] ?>, <br><br>É aconselhável recarregar sua base de dados no Evasão sempre que houverem mudanças.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" id="recarregar">Open File</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>


<script src="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCigZrbTA5ahX49g6TRBYZvfHS8l-Vr7jQ"></script>
<script src="jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>
 	//$('.selectpicker').select2();
	$('#myModal').modal('toggle');

	var coordanadaInicial = [-20.1625356,-40.401568];
	var ifes = [-20.1975718,-40.2193144];
	var minhaCasa = [-20.325457, -40.394792];
	var marker;

	$('#recarregar').click(function(event) {
		alert("oi");
		$('#myModal').modal('toggle');
	});

	var mymap = new L.map('mapid').setView(coordanadaInicial, 10);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	var listaAlunos = [];

	listaAlunos.push({nome: "Luan", endereco: "Coqueiral de Itaparica, Vila Velha, ES"});
	listaAlunos.push({nome: "Raone", endereco: "Rua Vila Velha, n89, Nova Brasília, Cariacica, ES"});

	$(listaAlunos).each(function(key,aluno){
		searchAddress(aluno);
	});


/*		L.circle([51.508, -0.11], 500, {
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.5
	}).addTo(mymap).bindPopup("I am a circle.");

	L.polygon([
		[51.509, -0.08],
		[51.503, -0.06],
		[51.51, -0.047]
	]).addTo(mymap).bindPopup("I am a polygon.");*/


	var popup = L.popup();

	function searchAddress(aluno) {
		endereco = aluno.endereco;

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({address: endereco}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			var myResult = [results[0].geometry.bounds.f.b,results[0].geometry.bounds.b.b];
			L.marker(myResult).addTo(mymap).bindPopup(aluno.nome).openPopup();
		}
		});
	}

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(mymap);
	}
</script>