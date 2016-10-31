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
							<option value="Heatmap">Mapa de Calor</option>
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

		//transforma os selects em Select2
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
		
		//coordenada central do mapa na inicialização da página		
		var coordanadaInicial = [-20.1625356,-40.401568];

		//criação do objeto mapa do Leaflet
		var mymap = new L.map('mapid').setView(coordanadaInicial, 11);

		//camada para guardar todos os marcadores
		var markers = new L.FeatureGroup();

		//adiciona a camada no mapa
		mymap.addLayer(markers);

		//adiciona a camada base do mapa utilizando as imagens do MapBox
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			id: 'mapbox.streets'
		}).addTo(mymap);

		var heat = L.heatLayer([], {
				radius: 25,
				gradient: {0.1: 'blue', 0.5: 'lime', 0.8: 'red'},
				blur: 15,
				minOpacity: 0.2
			}).addTo(mymap);


		//inicializacao dos icones utlizados para exibir por sexo
		var blueIcon = L.icon({
		    iconUrl: 'icons/blue_marker.png',
		    iconSize:     [36, 36],// size of the icon
		    iconAnchor:   [17.5, 34]
		});

		var pinkIcon = L.icon({
		    iconUrl: 'icons/pink_marker.png',
		    iconSize:     [36, 36],// size of the icon
		    iconAnchor:   [17.5, 34]
		});

		//inicializacao dos icones utlizados para exibir por situação de matrícula
		var matriculadoIcon = L.icon({
		    iconUrl: 'icons/matriculado.png',
		    iconSize:     [26, 46], // size of the icon
		    iconAnchor:   [13, 44]
		});

		var trancadoIcon = L.icon({
		    iconUrl: 'icons/trancado.png',
		    iconSize:     [26, 46], // size of the icon
		    iconAnchor:   [13, 44]
		});

		var canceladoIcon = L.icon({
		    iconUrl: 'icons/cancelado.png',
		    iconSize:     [26, 46], // size of the icon
		    iconAnchor:   [13, 44]
		});

		var concluidoIcon = L.icon({
		    iconUrl: 'icons/concluido.png',
		    iconSize:     [26, 46], // size of the icon
		    iconAnchor:   [13, 44]
		});

		var concluinteIcon = L.icon({
		    iconUrl: 'icons/concluinte.png',
		    iconSize:     [26, 46], // size of the icon
		    iconAnchor:   [13, 44]
		});

		//pega os alunos cadastrados no banco
		var listaAlunos = <?php echo $alunos; ?>;

		//seta a visualizacao inicial para todos os alunos sem filtro
		var listaAlunosFiltrada = listaAlunos;

		//carrega os marcadores quando a página for carregada
		carregaDadosMapa();

		

		//funcao que decide qual o categorizacao deve ser utilizada
		function carregaDadosMapa(){				
			var categorizado = $( "#categorizeSelect" ).val();

			limpaDadosMapa();			

			if(categorizado == "Sexo")
				carregaMarkersSexo();
			else if(categorizado == "Situacao")
				carregaMarkersSituacao();
			else
				carregaHeatmap();
		}

		function limpaDadosMapa(){
			markers.clearLayers();
			heat._latlngs = [];
			heat.redraw();
		}
		
		//essa função carrega os marcadores no caso de opção de mostrar por sexo esteja ativada
		function carregaMarkersSexo(){
			if(listaAlunosFiltrada != null){
				for (var i = 0; i < listaAlunosFiltrada.length; i++) {
					var aluno = listaAlunosFiltrada[i];

					var popup = L.popup({offset: [0, -12]}).setContent("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);

					if(aluno.sexo == 'F')
						L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: pinkIcon}).addTo(markers).bindPopup(popup);
					else
						L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: blueIcon}).addTo(markers).bindPopup(popup);
				}
			}
		}

		//essa função carrega os marcadores no caso de opção de mostrar por situacao esteja ativada
		function carregaMarkersSituacao(){
			if(listaAlunosFiltrada != null){
				for (var i = 0; i < listaAlunosFiltrada.length; i++) {
					var aluno = listaAlunosFiltrada[i];

					var popup = L.popup({offset: [0, -25]}).setContent("<b>Nome: </b>"+aluno.nome+"<br><b>Matrícula: </b>"+aluno.matricula.numeroMatricula);


					switch (aluno.matricula.situacao) {
					    case 0:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: matriculadoIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 1:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: canceladoIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 2:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: trancadoIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 3:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluinteIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 4:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluinteIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 5:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: concluidoIcon}).addTo(markers).bindPopup(popup);
					        break;
					    case 6:
					        L.marker([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt], {icon: matriculadoIcon}).addTo(markers).bindPopup(popup);
					}
				}
			}
		}

		//essa função carrega os marcadores no caso de opção de mostrar por sexo esteja ativada
		function carregaHeatmap(){
			if(listaAlunosFiltrada != null){


				for (var i = 0; i < listaAlunosFiltrada.length; i++) {
					var aluno = listaAlunosFiltrada[i];

					heat.addLatLng([aluno.endereco.ponto.lat, aluno.endereco.ponto.lgt, 10]);
				}
			}
		}

		function filtraResultados(){
			//reseta a lista
			listaAlunosFiltrada = listaAlunos;

			//pega os valores selecionados dos selects
			var filtroCurso = $( "#cursoSelect" ).val();
			var filtroSituacao = $( "#situacaoSelect" ).val();
			var filtroSexo = $( "#sexoSelect" ).val();

			//filtra por curso
			if(filtroCurso != null){
				var temp = listaAlunosFiltrada;
				listaAlunosFiltrada = temp.filter(function (aluno) {
				  	return aluno.matricula.curso.id == filtroCurso;
				});
			}

			//filtra por situacao de matricula
			if(filtroSituacao != null){
				temp = listaAlunosFiltrada;
				listaAlunosFiltrada = temp.filter(function (aluno) {
				  	return aluno.matricula.situacao == filtroSituacao;
				});
			}

			//filtra por sexo
			if(filtroSexo != null){
				temp = listaAlunosFiltrada;
				listaAlunosFiltrada = temp.filter(function (aluno) {
				  	return aluno.sexo == filtroSexo
				});
			}

			carregaDadosMapa();
		}

		//eventos para ativar o filtro
		$('#categorizeSelect').change(function() {
		    carregaDadosMapa();
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