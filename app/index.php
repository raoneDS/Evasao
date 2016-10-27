<?php 

error_reporting(E_ALL ^ E_NOTICE);
dirname('C:/xampp/htdocs/Evasao/');
include_once 'Classes/Control/AlunoController.php';
include_once 'Classes/Control/CursoController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

$alunoController = new AlunoController();
$cursoController = new CursoController();

$alunos = $alunoController->getAlunosDB();
$cursos = $cursoController->listaCursos();

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
						<select id="categorizeSelect" class="categorizeSelect">
							<option selected value="Sexo">Sexo</option>
							<option value="Situacao">Situação Matricula</option>
						</select>
					</div>
				</div>

				<div class="filters">
					<h4 class="filters-title">Filtros:</h4>

					<div class="filter-select">
						<select id="cursoSelect" class="cursoSelect">
							<option disabled selected></option>
							<?php 
							foreach ($cursos as $curso) {
								echo '<option value='.$curso->getId().'>'.$curso->getNome().'</option>';
							}
							?>						

						</select>
					</div>

					<div class="filter-select">
						<select id="situacaoSelect" class="situacaoSelect">
							<option disabled selected></option>
							<option value=0 >Matriculado</option>
							<option value=2 >Trancado</option>
							<option value=1 >Cancelado</option>
							<option value=3 >Concluinte</option>
							<option value=4 >Concluente</option>
							<option value=5 >Concluido</option>
						</select>
					</div>

					<div class="filter-select" style="width: 150px;">
						<select id="sexoSelect" class="sexoSelect">
							<option disabled selected></option>
							<option value="M" >Masculino</option>
							<option value="F" >Feminino</option>
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
		$(".categorizeSelect").select2();

		$(".cursoSelect").select2({
			placeholder: "Curso",
		  	allowClear: true
		});

		$(".situacaoSelect").select2({
			placeholder: "Situação de Matrícula",
		  	allowClear: true
		});

		$(".sexoSelect").select2({
			placeholder: "Sexo",
		  	allowClear: true
		});

		// VARIAVEIS DE MAPA //
		var marker;
		
		var coordanadaInicial = [-20.1625356,-40.401568];
		var mymap = new L.map('mapid').setView(coordanadaInicial, 11);
		var markers = new L.FeatureGroup();;
		mymap.addLayer(markers);

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

		var matriculadoIcon = L.icon({
		    iconUrl: 'icons/matriculado.png',
		    iconSize:     [26, 46] // size of the icon
		});

		var trancadoIcon = L.icon({
		    iconUrl: 'icons/trancado.png',
		    iconSize:     [26, 46] // size of the icon
		});

		var canceladoIcon = L.icon({
		    iconUrl: 'icons/cancelado.png',
		    iconSize:     [26, 46] // size of the icon
		});

		var concluidoIcon = L.icon({
		    iconUrl: 'icons/concluido.png',
		    iconSize:     [26, 46] // size of the icon
		});

		var concluinteIcon = L.icon({
		    iconUrl: 'icons/concluinte.png',
		    iconSize:     [26, 46] // size of the icon
		});

		
		var listaAlunos = <?php echo $alunos; ?>;
		var listaAlunosFiltrada = listaAlunos;

		carregaMarkers();

		function carregaMarkers(){			
			var categorizado = $( "#categorizeSelect" ).val();
			markers.clearLayers();

			if(categorizado == "Sexo")
				carregaMarkersSexo();
			else
				carregaMarkersSituacao();
		}
		
		function carregaMarkersSexo(){
			if(listaAlunosFiltrada != null){
				for (var i = 0; i < listaAlunosFiltrada.length; i++) {
					var aluno = listaAlunosFiltrada[i];

					if(aluno.sexo == 'F')
						L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: pinkIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					else
						L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: blueIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
				}
			}
		}

		function carregaMarkersSituacao(){
			if(listaAlunosFiltrada != null){
				for (var i = 0; i < listaAlunosFiltrada.length; i++) {
					var aluno = listaAlunosFiltrada[i];

					switch (aluno.matricula.situacao) {
					    case 0:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: matriculadoIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 1:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: canceladoIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 2:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: trancadoIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 3:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluinteIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 4:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluinteIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 5:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluidoIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					        break;
					    case 6:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: matriculadoIcon}).addTo(markers).bindPopup("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);
					}
				}
			}
		}

		function filtraResultados(){
			listaAlunosFiltrada = listaAlunos;
			var filtroCurso = $( "#cursoSelect" ).val();
			var filtroSituacao = $( "#situacaoSelect" ).val();
			var filtroSexo = $( "#sexoSelect" ).val();

			var temp = listaAlunosFiltrada;
			listaAlunosFiltrada = temp.filter(function (aluno) {
			  	return (aluno.matricula.curso.id == filtroCurso) ||
			  			(filtroCurso == null);
			});

			temp = listaAlunosFiltrada;
			listaAlunosFiltrada = temp.filter(function (aluno) {
			  	return (aluno.matricula.situacao == filtroSituacao) ||
			  			(filtroSituacao == null);
			});

			temp = listaAlunosFiltrada;
			listaAlunosFiltrada = temp.filter(function (aluno) {
			  	return (aluno.sexo == filtroSexo) ||
			  			(filtroSexo == null);
			});

			carregaMarkers();
		}

		$('#categorizeSelect').change(function() {
		    carregaMarkers();
		});

		$('#cursoSelect').change(function() {
		    filtraResultados();
		});

		$('#situacaoSelect').change(function() {
		    filtraResultados();
		});

		$('#sexoSelect').change(function() {
		    filtraResultados();
		});
		
	});
	</script>

<?php 
include_once 'footer.php';
?>