<?php 

//include_once 'Classes/Control/CursoController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

$page_title = "Cursos";
include_once 'header.php';
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="main-content">

            <div class="page-title">
              <div class="title_left">
                <h3>Cursos</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <!-- #top -->
                  <div id="top" class="row">
                    <div class="col-sm-6 new-button">
                        <a href="novo-curso.php" class="btn btn-primary pull-left h2 action-button">Inserir</a>
                        <a id="editar" class="btn btn-warning pull-left h2 action-button">Editar</a>
                        <a id="excluir" class="btn btn-danger pull-left h2 action-button">Excluir</a>
                    </div>  
                  </div> 
                  <!-- /#top -->

                  <div class="x_content">
                    <br />

                    <div class="tcol-md-12">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="col-sm-1 text-center">ID</th>
                          <th class="col-sm-3 text-center">Nome</th>
                          <th class="col-sm-1 text-center">Sigla</th>
                          <th class="col-sm-1 text-center">Duração</th>
                        </tr>
                      </thead>
                    </table>
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
            var dataTable = $('#datatable').DataTable( 
            {
              "language": 
                {
                  "url": "plugins/datatables.net/Portuguese-Brasil.json" 
                },
              "processing": true,
              "serverSide": true,
              "ajax":
                {
                  url :'Classes/Control/CursoController.php',
                  type: "post",
                  data: {acao: 'list'} 
                },
              "columns" :
                [
                  {"data":"id"},
                  {"data":"nome"},
                  {"data":"sigla"},
                  {"data":"duracao"} 
                ]
            });
            
        });
        </script>

<?php 
include_once 'footer.php';
?>