<?php

session_start();

if(!isset($_SESSION["id_usuario"])){
  header("location:login.php");
}
include_once 'Classes/Control/AlunoController.php';

$alunoController = new AlunoController();
$alunos = $alunoController->getAlunosDB();

$page_title = "Dados Dinâmicos";
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

                  	<div id="output" class="x_content">

                  	</div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /page content -->

        <script type="text/javascript">
        //pega os alunos cadastrados no banco
        var listaAlunos = <?php echo $alunos; ?>;       

        $(window).load(function(){        

            $(function(){
              var derivers = $.pivotUtilities.derivers;
              var renderers = $.extend($.pivotUtilities.renderers, 
                $.pivotUtilities.c3_renderers);

              $("#output").pivotUI(
                  listaAlunos,{
                    renderers: renderers,
                    rendererOptions: { c3: { size: {width: 700, height: 300} } },
                    hiddenAttributes: ["cpf", "data_nascimento", "nome", "matricula", "sexo", "endereco", "escola_origem", "renda_familiar"],
                    derivedAttributes: {
                        "Sexo": function(aluno) {
                            if(aluno["sexo"] == null)
                              return "Não Informado";
                            else if(aluno["sexo"] == "F")
                              return "Feminino";
                            else if(aluno["sexo"] == "M")
                              return "Masculino";
                        },
                        "Escola de Origem": function(aluno) {
                            if(aluno["escola_origem"] == null)
                                return "Não Informado";
                            else if(aluno["escola_origem"] == 0)
                                return "Privada";
                            else if(aluno["escola_origem"] == 1)
                                return "Pública Municipal";
                            else if(aluno["escola_origem"] == 2)
                                return "Pública Estadual";
                            else if(aluno["escola_origem"] == 3)
                                return "Pública Federal";
                            else if(aluno["escola_origem"] == 4)
                                return "Não Informado";
                        },
                        "Renda Familiar Per Capita": function(aluno) {
                            if(aluno["renda_familiar"] == null || aluno["renda_familiar"] == "")
                                return "Não Informado";
                            else
                                return aluno["renda_familiar"];
                        },
                        "Curso": function(aluno) {
                            return aluno["matricula"]["curso"]["nome"];
                        },
                        "Bairro": function(aluno) {
                            return aluno["endereco"]["bairro"] + " - " + aluno["endereco"]["cidade"] + " - " + aluno["endereco"]["uf"];
                        },
                        "Cidade": function(aluno) {
                            return aluno["endereco"]["cidade"] + " - " + aluno["endereco"]["uf"];
                        },
                        "Estado": function(aluno) {
                            return aluno["endereco"]["uf"];
                        }
                    }
                  },
                  false, "br"
              );

           });//function


	        function calcularIdade(dateString) {
			  var birthday = +new Date(dateString);
			  return~~ ((Date.now() - birthday) / (31557600000));
			}

        });//window load
        </script>

<?php 
include_once 'footer.php';
?>