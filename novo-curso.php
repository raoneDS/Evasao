<?php 

include_once 'Classes/Control/CursoController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

if(!empty($_POST)){
	$cursoController = new CursoController();
  	$cursoController->inseriCurso($_POST["nome-curso"], $_POST["sigla"], $_POST["duracao"]);
  	header("location:cursos.php");
}

$page_title = "Cadastrar Curso";
include_once 'header.php';
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="main-content">

            <div class="page-title">
              <div class="title_left">
                <h3>Cadastrar Novo Curso</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="x_title">
                    <h2>Dados do Curso</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <br />

                    <form id="novo-curso" class="form-horizontal form-label-left"  method="POST" action="novo-curso.php">

                      <div class="form-group">
                        <label for="nome-curso" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome do Curso <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nome-curso" name="nome-curso" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="sigla" class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sigla <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="sigla" name="sigla" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="duracao" class="control-label col-md-3 col-sm-3 col-xs-12">Duração do Curso <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="duracao" class="form-control col-md-7 col-xs-12" type="number" required="required" name="duracao">
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cadastrar</button>
                          <a href="cursos.php" class="btn btn-danger">Cancelar</a>
                        </div>
                      </div>

                    </form>
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