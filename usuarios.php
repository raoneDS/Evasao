<?php 

include_once 'Classes/Control/CursoController.php';

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
                    <div class="col-sm-6 new-button">
                        <a href="novo-curso.php" class="btn btn-primary pull-left h2">Novo Usuário</a>
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
          //   buttons: [
          //     'selectRows',
          //     'selectColumns',
          //     'selectCells'
          // ],
          select: true,
          "language": {
            "url": "plugins/datatables.net/Portuguese-Brasil.json"
          },
          "processing": true,
          "serverSide": true,
          "ajax":{
              url :'Classes/Control/UsuarioController.php', // json datasource
              type: "post",  // method  , by default get
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

    //   $('#datatable').on( 'click', 'tbody tr', function () {
    //     if ( dataTable.row( this, { selected: true } ).any() ) {
    //         dataTable.row( this ).deselect();
    //     }
    //     else {
    //         dataTable.row( this ).select();
    //     }
    // });

    $('#datatable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });


    });


</script>

<?php 
include_once 'footer.php';
?>