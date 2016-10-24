<?php 

//include_once 'Classes/Control/CursoController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

$page_title = "Usuários";
include_once 'header.php';
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="main-content">

            <div class="page-title">
              <div class="title_left">
                <h3>Usuários</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <!-- #top -->
                  <div id="top" class="row">
                    <div class="col-sm-1 new-button">
                        <a href="cadUsuario.php" class="btn btn-primary pull-left h2">Inserir</a>
                    </div>  
                    <div class="col-sm-1 new-button">
                        <a id="editar" class="btn btn-primary pull-left h2">Editar</a>
                    </div>
                    <div class="col-sm-1 new-button">
                        <a id="excluir" class="btn btn-danger pull-left h2">Excluir</a>
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
                          <th class="col-sm-1 text-center">Sexo</th>
                          <th class="col-sm-1 text-center">Data Nascimento</th>
                          <th class="actions col-sm-1 text-center">Username</th>
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

    $(document).ready(function() {
      var dataTable = $('#datatable').DataTable( {
          "language": {
            "url": "plugins/datatables.net/Portuguese-Brasil.json"
          },
          "processing": true,
          "serverSide": true,
          "ajax":{
              url :'Classes/Control/UsuarioController.php',
              type: "post",
              data: {acao: 'list'}
          },
          "columns" :[
          {"data":"id_usuario"},
          {"data":"nome"},
          {"data":"sexo"},
          {"data":"data_nascimento"},
          {"data":"login"}
          ]
      });

    $('#datatable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#editar').click( function () {
        alert( dataTable.rows('.selected').data().length +' row(s) selected' );
    });

    $('#excluir').click( function () {
        var user = dataTable.row('.selected').data();
        //console.log(user.id_usuario);
        if(user){
          $.post('classes/Control/UsuarioController.php', {acao: 'delete', id: user.id_usuario}, function(data, textStatus, xhr){
            console.log(textStatus);
          });
        }
    });


    });


</script>

<?php 
include_once 'footer.php';
?>