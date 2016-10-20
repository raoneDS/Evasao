<!DOCTYPE html>

<html>
	<?php
	error_reporting(E_ALL ^ E_NOTICE);
	dirname('C:/xampp/htdocs/Evasao/');
	include_once 'Classes/Control/AlunoController.php';

	session_start();
	if(!isset($_SESSION["id_usuario"])){
	  header("location:login.php");
	}

	// $alunos = getAlunosCSV();
	// $loadDB = json_encode(false);

	$alunos = getAlunosDB();
	$loadDB = json_encode(true);

	// if($alunos = null){
	// 	//$alunos = getAlunosCSV();
	// 	$loadDB = json_encode(false);
	// }else{
	// 	$loadDB = json_encode(true);
	// }
	
	?>
	<head>
		<title>Evasão</title>
		<meta charset="utf-8"/>
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
				<input id="fileupload" type="file" name="files[]" data-url="server/php/" multiple>
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
		<div id="mapid" style="width: 1370px; height: 400px"></div>
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

	// VARIAVEIS DE MAPA //
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

	var IconRoxo = L.icon({
	    iconUrl: 'icons/roxo.png',
	    iconSize:     [25, 40] // size of the icon
	    // shadowSize:   [50, 64], // size of the shadow
	    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
	    // shadowAnchor: [4, 62],  // the same for the shadow
	    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});

	// ------------------------------------- //

	localizacao = null;
	bancoCheio = <?php echo $loadDB ?>;
	listaAlunos = <?php echo $alunos ?>;
	length = listaAlunos.length;
	
	if(!bancoCheio){
		speed = 100;
		pontos = 0;
		st = null;
		index = 0;
		timer = setInterval(foundLocations, speed);
	}else{
		$.each(listaAlunos, function(i, aluno) {
			localizacao = [aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt];
			setLocation(localizacao, aluno);
		});
	}

	function foundLocations(){
		searchAddress(listaAlunos[index]);
	}

	function searchAddress(aluno) {
		endereco = aluno.endereco.rua +', '+aluno.endereco.numero+', '+aluno.endereco.bairro+', '+aluno.endereco.cidade+' - '+aluno.endereco.uf;
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({address: endereco}, function(results, status) {
			st = status;
			if(status == google.maps.GeocoderStatus.OK){
				localizacao = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
				setLocation(localizacao, aluno);
			}
			createStructure();
		});
	}

	function setLocation(localizacao, aluno){
		if(aluno.sexo == 'F')
			L.marker(localizacao, {icon: IconRoxo}).addTo(mymap).bindPopup(aluno.email+'<br>'+aluno.matricula.numeroMatricula);
		else
			L.marker(localizacao).addTo(mymap).bindPopup(aluno.email+'<br>'+aluno.matricula.numeroMatricula);
	}

	function createStructure(){
		if(st == google.maps.GeocoderStatus.OK){
			listaAlunos[index].endereco.ponto = localizacao;
			console.log(index);
			index++;
			pontos++;
		}else if(st == google.maps.GeocoderStatus.ZERO_RESULTS){
			console.log(listaAlunos[index].email,'endereco nao encontrado');
			index++;
		}else{
			console.log(st,"em:",listaAlunos[index].matricula.numeroMatricula,listaAlunos[index].email,' new speed: ',speed);
			clearInterval(timer);
			speed += 200;
			timer = setInterval(foundLocations, speed);
		}if(index+1 >= length){
			clearInterval(timer);
			console.log("pontos: ",pontos);
			insertDB();
		}
	}

	function insertDB(){
		$.post('classes/Control/AlunoController.php', {acao: 'saveData', alunos: listaAlunos}, function(data, textStatus, xhr){
			console.log(textStatus);
		});
	}

 	function abreModal(){
 		$('#myModal').modal('toggle');
 	}	

	$('#recarregar').click(function(event) {
		alert("Atualizar DB");
		$('#myModal').modal('toggle');
	});


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