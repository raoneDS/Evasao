<?php 

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
            <div id="cad-modal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="cad_title"></h4>
                  </div>
                  <div class="modal-body">
                    <form id="novo-usuario" method="post" action="" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label for="nome-pessoa" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome Completo<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nome" name="nome-pessoa" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>               
                      <div class="form-group">
                        <label for="data_nascimento" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Data Nascimento<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="data_nascimento" name="data_nascimento" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="sexo" class="control-label col-md-3 col-sm-3 col-xs-12">Sexo<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="sexo" class="form-control col-md-7 col-xs-12" type="number" required="required" name="sexo">
                              <option value="M">Masculino</option>
                              <option value="F">Feminino</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="username" name="username" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>                      
                      <div class="form-group">
                        <label for="senha" class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Senha<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="senha" name="senha" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <a class="ls-label-text-prefix ls-toggle-pass ls-ico-eye" data-toggle-class="ls-ico-eye, ls-ico-eye-blocked" data-target="#senha" href="#">
                        </a>
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
  var dataTable;

  $("#limpar").click(function(event) {
    $('#novo-usuario')[0].reset()
  });

  function montaTabela(){
    dataTable = $('#datatable').DataTable( {
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
  }

  function abreModal(){
    $('#cad-modal').modal('toggle');
  }

  $('#inserir').click( function () {
    $("#cad_title").text("Novo Usuário")
    abreModal();
  });

  $('#editar').click( function () {
    var dados = dataTable.row('.selected').data();
    if(dados){
      dataTable.$('tr.selected').removeClass('selected');
      $("#nome").val(dados.nome);
      $("#data_nascimento").val(dados.data_nascimento);
      $("#username").val(dados.login);
      $("#senha").val(dados.senha);

      $("#cad_title").text("Editar Usuário")
      abreModal();
    }

  });

  $('#excluir').click( function () {
      var user = dataTable.row('.selected').data();
      if(user){
        dataTable.$('tr.selected').removeClass('selected');
        $("#texto-confirmacao").text('Deseja realmente excluir usuário '+user.login+'?');
        $('#modal_confirmacao').modal('toggle');
        $('#excluir_modal').click( function () {
          $.post('classes/Control/UsuarioController.php', {acao: 'delete', id_pessoa: user.id_pessoa}, function(data, textStatus, xhr){
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

    $("#data_nascimento").datepicker({
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      nextText: 'Próximo',
      prevText: 'Anterior'
    });
  });

  jQuery(document).ready(function() {
      jQuery('#novo-usuario').submit(function(){

        var nome = $("#nome").val();
        var data_nascimento = $("#data_nascimento").val();
        var sexo = $("#sexo").val();
        var username = $("#username").val();
        var senha = $("#senha").val();

        jQuery.ajax({
          type: "POST",
          url: "classes/Control/UsuarioController.php",
          data: {acao: 'insert', nome:nome, data_nascimento:data_nascimento, sexo:sexo, username:username, senha:senha},
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