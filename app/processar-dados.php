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

		                    <div class="form-group">
		                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		                          	<textarea id="feedback" rows="10" class="form-control">Progresso da importação:</textarea>
		                        </div>
		                    </div>

		                    <div class="ln_solid"></div>

							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								  	<a class="btn btn-primary" href="index.php">Voltar</a>
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

		var alunosCSV = <?php echo $alunosCSV; ?>;

		var totalProcessado = 0;
		var valorProgressoAtual = 0;
		var percentualProgressoAtual = 0;
		var percentualCadaPasso = (1/alunosCSV.length)*100;

		atualizaProgressoMaximo(alunosCSV.length);

		for (var i = 0; i < alunosCSV.length; i++) {
			
			processaAlunoCSV(alunosCSV[i]);
		}
		

		function processaAlunoCSV(aluno){
			$.post('classes/Control/AlunoController.php', {acao: 'processar', aluno: aluno}, function(data, textStatus, xhr){
				//console.log(textStatus);
				//console.log(data);
				$('#feedback').append("\n"+data.trim());
				atualizaProgresso();
				totalProcessado++;

				//$('#feedback').append(" - "+totalProcessado+" de "+alunosCSV.length);
				if(totalProcessado == alunosCSV.length){
					$('#feedback').append("\n\nImportação completa!");
				}
				$('#feedback').scrollTop($('#feedback')[0].scrollHeight);
			});
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

  	});
	 
	</script>

<?php 
include_once 'footer.php';
?>