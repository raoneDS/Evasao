<!DOCTYPE html>

<html>
	<?php
	error_reporting(E_ALL ^ E_NOTICE);

	include_once 'classes/AlunoController.php';
	include_once 'Util.php';

	session_start();
	if(isset($_SESSION["id_usuario"])){
		if($_SESSION['sexo'] == "M")
			$page_title = "Bem vindo, ".$_SESSION['nome_usuario'].".";
		else
			$page_title = "Bem vinda, ".$_SESSION['nome_usuario'].".";
	}else{
	  header("location:login.php");
	}

	$alunoController = new AlunoController();
	$alunos = $alunoController->montaEstruturaAlunos();
	?>
	<head>
		<title>Evasão</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css"/>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		        <img alt="Brand" src="university-pin.png">
		    </div>

		    <ul class="nav navbar-nav navbar-right">
				<button type="button" class="btn btn-danger navbar-btn" onclick="abreModal()">Atualizar Base</button>
				<!-- <button type="button" onclick="logout.php" class="btn btn-inverse navbar-btn">Sair</button> -->
				<a href="logout.php" class="btn btn-default">Fazer logoff</a>
			</ul>

		      <ul class="nav navbar-nav">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown<span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">One more separated link</a></li>
		          </ul>
		        </li>
		      </ul>
		</nav>

	</head>



	<body>
		<div id="mapid" style="width: 1370px; height: 400px">
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
	        Olá <?php echo $_SESSION['nome_usuario']; ?>, <br><br>É aconselhável recarregar sua base de dados no Evasão sempre que houverem mudanças.
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwUpN5IglA1uzE_E_VbwvtZtHSr5oZKP4"></script>
<script src="jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>

	var speed = 800;
	//var timer = setInterval(montaMapa, speed);
	var st = null;
	var listaAlunos = <?php echo $alunos ?>;
	console.log(listaAlunos);
	var length = listaAlunos.length;
	var index = 0;
	var pontos = 0;
	

	function montaMapa(){
		console.log(listaAlunos[index]);
		searchAddress(listaAlunos[index]);
		if(st == 'OK')
			index++;
		else{
			console.log(st);
			console.log("Erro em:",listaAlunos[index].matricula,listaAlunos[index].email);
			clearInterval(timer);
			speed += 200;
			console.log(speed);
			timer = setInterval(montaMapa, speed);
		}
		if(index >= length){
			clearInterval(timer);
			console.log("pontos: ",pontos);
		}
	}

 	function abreModal(){
 		$('#myModal').modal('toggle');
 	}	

	$('#recarregar').click(function(event) {
		clearInterval(timer);
/*		alert("Atualizar DB");
		$('#myModal').modal('toggle');*/
	});

		var marker;
		var coordanadaInicial = [-20.1625356,-40.401568];
		var mymap = new L.map('mapid').setView(coordanadaInicial, 11);

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			id: 'mapbox.streets'
		}).addTo(mymap);

	function searchAddress(aluno) {
		endereco = aluno.endereco;

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({address: endereco}, function(results, status) {
			st = status;
			if(status == 'OK'){
				var myResult = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
				L.marker(myResult).addTo(mymap).bindPopup(aluno.email+'<br>'+aluno.matricula);
				pontos++;
			}else{
				console.log('erro:', status);
			}
		});
	}


	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(mymap);
	}


	/*		L.circle([51.508, -0.11], 500, {
			color: 'red',
			fillColor: '#f03',
			fillOpacity: 0.5
		}).addTo(mymap).bindPopup("I am a circle.");*/

	/*	L.polygon([
			[51.509, -0.08],
			[51.503, -0.06],
			[51.51, -0.047]
		]).addTo(mymap).bindPopup("I am a polygon.");*/



</script>