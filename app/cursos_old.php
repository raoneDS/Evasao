<?php 

include_once 'Classes/Control/CursoController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

$cursoController = new CursoController();
$listaCursos = $cursoController->listaCursos();

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
                        <a href="novo-curso.php" class="btn btn-primary pull-left h2">Novo Curso</a>
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
                          <th class="actions col-sm-1 text-center">Ações</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      foreach ($listaCursos as $row) {
                        echo '<tr>';
                          echo '<td class="text-center">'.$row['id_curso'].'</td>';
                          echo '<td>'.$row['nome_curso'].'</td>';
                          echo '<td class="text-center">'.$row['sigla'].'</td>';
                          echo '<td class="text-center">'.$row['duracao'].'</td>';
                          echo '<td class="actions text-center">
                            <a class="btn btn-warning btn-xs" href="edit.html">Editar</a>
                            <a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" data-target="#delete-modal">Excluir</a>';
                          echo '</td>';
                        echo '</tr>';
                      }
                      ?>
                      </tbody>
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

          $(document).ready(function() {
            var dataTable = $('#datatable').DataTable( {
                "language": {
                    "url": "plugins/datatables.net/Portuguese-Brasil.json"
                }
            } );

      $('#datatable tbody').on( 'click', 'tr', function () {
        console.log( dataTable.row(this).data() );

        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }   
        else {
            //dataTable.$('tr.selected').removeClass('selected');
            var ok = $(this).addClass('selected');
            console.log(ok);
        }
      });


            
          } );

        </script>

<?php 
include_once 'footer.php';
?>