<?php 

include_once 'Classes/Control/UsuarioController.php';

session_start();
if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}

if(!empty($_POST)){
  //inseriCurso($_POST["nome-curso"], $_POST["sigla"], $_POST["duracao"]);
  //header("location:usuarios.php");
}

$page_title = "Cadastrar Usuário";
include_once 'header.php';
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="main-content">

    <div class="page-title">
      <div class="title_left">
        <h3>Cadastrar Novo Usuário</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_title">
            <h2>Dados do Usuário</h2>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Confirmação</h4>
                </div>
                <div class="modal-body">
                  <p>Dados inseridos com sucesso!</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
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
                  <input type="text" id="data_nascimento" name="data_nascimento required="required" class="form-control col-md-7 col-xs-12">
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

              <div class="ln_solid"></div>

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button id="enviar" class="btn btn-primary">Cadastrar</button>
                  <button id="limpar" class="btn btn-default">Limpar Campos</button>
                  <button href="usuarios.php" id="cancelar" class="btn btn-danger">Cancelar</button>
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

<script>

  $("#limpar").click(function(event) {
    limparCampos();
  });

  function abreModal(){
    $('#myModal').modal('toggle');
  }

    function limparCampos(){
      $('#novo-usuario')[0].reset();
    } 

  $(document).ready(function() {
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
              limparCampos();
              abreModal();
            }
          }
        });
        return false;
      });
  });


</script>