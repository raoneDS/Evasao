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

$page_title = "Home";
include_once 'header.php';

?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
            <div class="filters-bar">

				<div class="categorize">
					<h4 class="categorize-title">Categorizar:</h4>
					<div class="categorize-select">
						<select class="categorizeSelect">
							<option value="Sexo">Sexo</option>
							<option value="Situacao">Situação Matricula</option>
						</select>
					</div>
				</div>

				<div class="filters">
					<h4 class="filters-title">Filtros:</h4>
					<div class="situacao-select">
						<select class="situacaoSelect">
							<option disabled selected value></option>
							<option value="Matriculado">Matriculado</option>
							<option value="Trancado">Trancado</option>
							<option value="Cancelado">Cancelado</option>
							<option value="Concluinte">Concluinte</option>
							<option value="Concluente">Concluente</option>
							<option value="Concluido">Concluido</option>
						</select>
					</div>

				</div>

            </div>
          </div>

          <div id="mapid"></div>
        </div>
        <!-- /page content -->

	<script>
	$(window).load(function(){
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

		var blueIcon = L.icon({
		    iconUrl: 'icons/blue_marker.png',
		    iconSize:     [36, 36] // size of the icon
		});

		var pinkIcon = L.icon({
		    iconUrl: 'icons/pink_marker.png',
		    iconSize:     [36, 36] // size of the icon
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
				L.marker(localizacao, {icon: pinkIcon}).addTo(mymap).bindPopup(aluno.nome+'<br>'+aluno.matricula.numeroMatricula);
			else
				L.marker(localizacao, {icon: blueIcon}).addTo(mymap).bindPopup(aluno.nome+'<br>'+aluno.matricula.numeroMatricula);
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

		$('#recarregar').click(function(event) {
			alert("Atualizar DB");
			$('#myModal').modal('toggle');
		});

		$(".categorizeSelect").select2();

		$(".situacaoSelect").select2({
			placeholder: "Situação de Matrícula",
		  	allowClear: true
		});
	});
	</script>

<?php 
include_once 'footer.php';
?>