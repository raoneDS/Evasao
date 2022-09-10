<?php 

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
            <div id="cad-modal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="cad_title"></h4>
                  </div>
                  <div class="modal-body">
                    <form id="novo-curso" method="post" action="" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label for="nome-curso" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome do Curso<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nome" name="nome-curso" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="sigla" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sigla<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="sigla" name="sigla" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="duracao" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Duração<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="duracao" name="duracao" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button id="enviar" class="btn btn-success">Cadastrar</button>
                          <button id="limpar" class="btn btn-default">Limpar Campos</button>
                        </div>
                      </div>

                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="fechar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>

            <div id="modal_confirmacao" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmação</h4>
                  </div>
                  <div class="modal-body">
                    <h2 id="texto-confirmacao"></h2>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="excluir_modal" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <!-- #top -->
                  <div id="top" class="row">
                      <div class="col-sm-6 new-button">
                        <a id="inserir" class="btn btn-primary pull-left h2 action-button">Inserir</a>
                        <a id="editar" class="btn btn-primary pull-left h2 action-button">Editar</a>
                        <a id="excluir" class="btn btn-danger pull-left h2 action-button">Excluir</a>
                      </div>
                  </div> 
                  <!-- /#top -->

                  <div class="x_content">
                    <br>

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
  var dataTable;

  $("#limpar").click(function(event) {
    $('#novo-curso')[0].reset()
  });

  function montaTabela(){
    dataTable = $('#datatable').DataTable( {
      "language": {
        "url": "plugins/datatables.net/Portuguese-Brasil.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax":{
          url :'Classes/Control/CursoController.php',
          type: "post",
          data: {acao: 'list'}
      },
      "columns" :[
        {"data":"id"},
        {"data":"nome"},
        {"data":"sigla"},
        {"data":"duracao"}
      ]
    });
  }

  function abreModal(){
    $('#cad-modal').modal('toggle');
  }

  $('#inserir').click( function () {
    $("#cad_title").text("Novo Curso")
    abreModal();
  });

  $('#editar').click( function () {
    var dados = dataTable.row('.selected').data();
    if(dados){
      dataTable.$('tr.selected').removeClass('selected');
      $("#nome").val(dados.nome);
      $("#sigla").val(dados.sigla);
      $("#duracao").val(dados.duracao);

      $("#cad_title").text("Editar Curso")
      abreModal();
    }

  });

  $('#excluir').click( function () {
      var curso = dataTable.row('.selected').data();
      if(curso){
        dataTable.$('tr.selected').removeClass('selected');
        $("#texto-confirmacao").text('Deseja realmente excluir o curso '+curso.nome+'?');
        $('#modal_confirmacao').modal('toggle');
        $('#excluir_modal').click( function () {
          $.post('classes/Control/CursoController.php', {acao: 'delete', id_curso: curso.id}, function(data, textStatus, xhr){
            if(textStatus='sucess')
              $('#datatable').DataTable().ajax.reload();
            $('#modal_confirmacao').modal('toggle');
          });
        });       
      }
  });

  $(document).ready(function() {

    montaTabela();

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

  jQuery(document).ready(function() {
      jQuery('#novo-curso').submit(function(){

        var nome = $("#nome").val();
        var sigla = $("#sigla").val();
        var duracao = $("#duracao").val();

        jQuery.ajax({
          type: "POST",
          url: "classes/Control/CursoController.php",
          data: {acao: 'insert', nome:nome, sigla:sigla, duracao:duracao},
          success: function( data ){
            if(data=="ok"){
              $('#datatable').DataTable().ajax.reload();
              abreModal();

            }
          }
        });
        return false;
      });
  });

</script>

<?php 
include_once 'footer.php';
?>