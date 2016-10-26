<?php

session_start();

if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

include_once 'Classes/Control/AlunoController.php';

$page_title = "Processar Dados do Arquivo CSV";
include_once 'header.php';

if(isset($_POST['caminho-arquivo'])){

	
	$caminhoArquivo = $_POST['caminho-arquivo'];

	$alunoController = new alunoController();
	$alunosBD = $alunoController->getAlunosDB();
	$alunosCSV = $alunoController->getAlunosCSV($caminhoArquivo);

	$idCurso = $_POST['curso'];
}
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="main-content">

            <div class="page-title">
              <div class="title_left">
                <h3>Importando Dados de Alunos</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  	<div class="x_content">
	                    <br>

	                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

		                    <div class="form-group">
		                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		                          	<div class="progress">
									  <div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
									    <span class="sr-only">0% Completo</span>
									  </div>
									</div>
		                        </div>		                      
		                    </div>

	                    </form>

                  	</div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /page content -->        

	<script type="text/javascript">

	$(window).load(function(){
		var alunosBD = <?php echo $alunosBD; ?>;
		var alunosCSV = <?php echo $alunosCSV; ?>;

		var achou = false;
		var idPessoa = 0;

		var valorProgressoAtual = 0;
		var percentualProgressoAtual = 0;
		var percentualCadaPasso = (1/alunosCSV.length)*100;

		atualizaProgressoMaximo(alunosCSV.length);

		for (var i = 0; alunosCSV && i < alunosCSV.length; i++) {

			for (var j = 0; alunosBD && j < alunosBD.length; j++) {

				console.log(alunosBD[j]);
				if(alunosCSV[i].cpf == alunosBD[j].cpf){
					achou = true;

					console.log("achou");
				}
			}

			if(achou) {
				atualizaAlunoBD(alunosCSV[i], idAluno);
			}
			else {
				inserirAlunoBD(alunosCSV[i]);
				//console.log(alunosCSV[i]);
				//searchAddress(alunosCSV[i]);
			}
		}		

		function atualizaProgressoMaximo(valor){
			$('.progress-bar').attr('aria-valuemax', valor);
		}

		function atualizaProgresso(){
			valorProgressoAtual++;
			percentualProgressoAtual = percentualProgressoAtual+percentualCadaPasso;
			$('.progress-bar').css('width', percentualProgressoAtual+'%').attr('aria-valuenow', valorProgressoAtual);
			//$('.progress-bar').attr('aria-valuenow', valor);
		}

		function inserirAlunoBD(aluno){
			$.post('classes/Control/AlunoController.php', {acao: 'inserir', aluno: aluno}, function(data, textStatus, xhr){
				console.log(textStatus);
				atualizaProgresso();
			});
		}

		function atualizaAlunoBD(aluno){
			$.post('classes/Control/AlunoController.php', {acao: 'atualizar', aluno: aluno}, function(data, textStatus, xhr){
				console.log(textStatus);
				atualizaProgresso();
			});
		}

  	});
	 
	</script>

<?php 
include_once 'footer.php';
?>