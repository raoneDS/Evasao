<?php

session_start();

if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

include_once 'Classes/Control/CursoController.php';

$cursoController = new CursoController();
$cursos = $cursoController->listaCursos();

$page_title = "Cursos";
include_once 'header.php';
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="main-content">

            <div class="page-title">
              <div class="title_left">
                <h3>Importar Dados de Alunos</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  	<div class="x_content">
	                    <br>

	                    <form action="processar-dados.php" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

	                      	<div class="form-group">
	                      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="caminho-arquivo">Arquivo CSV <span class="required">*</span>
	                        	</label>
	                        	<input id="caminho-arquivo" name="caminho-arquivo" type="file" title="Escolher o arquivo CSV" class="">
	                     	</div>

	                     	<div class="form-group">
		                        <label for="curso" class="control-label col-md-3 col-sm-3 col-xs-12">Curso <span class="required">*</span></label>
		                        <div class="col-md-6 col-sm-6 col-xs-12">
		                          	<select id="curso" class="form-control col-md-7 col-xs-12" type="number" required="required" name="curso">

                              			<?php 
                              			foreach ($cursos as $curso) {
                              				echo '<option value="'.$curso->getId().'">'.$curso->getNome().'</option>';
                              			}
                              			?>

                          			</select>
		                        </div>
		                    </div>
	                      
	                      <div class="ln_solid"></div>
	                      <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<input class="btn btn-primary pull-left h2 action-button" type="submit" name="submit" value="Processar" /></form>
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

<?php 
include_once 'footer.php';
?>