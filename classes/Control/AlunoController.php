<?php
include_once 'Classes/Model/Aluno.php';
include_once 'Classes/Model/Endereco.php';
include_once 'Classes/Model/Curso.php';
include_once 'Classes/Model/PosicaoGeografica.php';
include_once 'Classes/Model/Historico.php';
include_once 'Classes/Model/Matricula.php';
include_once 'Classes/Model/EnumEscolaOrigem.php';
include_once 'Classes/Model/EnumSituacaoMatricula.php';

include_once 'Classes/DAO/AlunoDAO.php';
include_once 'Classes/DAO/EnderecoDAO.php';
include_once 'Classes/DAO/HistoricoDAO.php';



if($_REQUEST){
	$resultado = true;
	switch ($_REQUEST['acao']){
		case 'saveData':
			inseriTodos($_REQUEST['alunos']);
			break;
	}
	echo $resultado;
}

function getAlunosCSV(){
	$arquivo = fopen('ListagemdeAlunos.csv','r');
	$dados = [];
	$linha = fgets($arquivo);
	$cont = 0;

	$arrayEscolas = EnumEscolaOrigem::getConstants();
	$arraySituacao = EnumSituacaoMatricula::getConstants();	

	$alunos = array();
	while($linha != null) {
		if($cont > 0){
			$dados = explode(';',$linha);

			$cursoNome = utf8_encode($dados[9]);
			$curso = new Curso($cursoNome);


			$semestre = $dados[8];
			$numeroMatricula = $dados[0];
			$periodoAtual = $dados[10];
			$situacao = $arraySituacao[$dados[2]];
			$matricula = new Matricula($semestre, $periodoAtual, $numeroMatricula, $situacao, $curso);

			$rua = utf8_encode($dados[29]);
			$numero = $dados[30];
			$bairro = utf8_encode($dados[32]);
			$cidade_uf = explode(' - ', $dados[34]);
			$cidade = utf8_encode($cidade_uf[0]);
			$estado  = utf8_encode($cidade_uf[1]);
			$complemento = utf8_encode($dados[31]);

			$endereco = new Endereco($rua, $numero, $bairro, $cidade, $complemento, $estado);

			$date = DateTime::createFromFormat('d/m/Y',$dados[5]);

			$nome = utf8_encode($dados[1]);
			$dataNascimento = $date->format('Y-m-d');
			$sexo = $dados[7];
			$email = utf8_encode($dados[14]);
			$escolaOrigem = $arrayEscolas[utf8_encode($dados[20])];
			$renda = utf8_encode($dados[18]);

			$aluno = new Aluno($nome, $dataNascimento, $sexo, $matricula, $endereco, $escolaOrigem, $renda, $email);

			$alunos[] = $aluno;
		}

		$linha = fgets($arquivo);
		$cont++;
	}
	fclose($arquivo);
	return json_encode($alunos);
}

function inseriTodos($alunos){
	$alunoDAO = new AlunoDAO();
	foreach ($alunos as $key => $aluno) {
		$alunoDAO->insert_transaction($aluno);
	}
	$historico = new Historico();
	$historico->setData(date("m-d-y"));
	$historico->setQtdRegistros(count($alunos));
	$historicoDAO = new HistoricoDAO();
	$historicoDAO->insert($historico);
}

function getAlunosDB(){
	$alunoDAO = new AlunoDAO();
	return json_encode($alunoDAO->listAll());
}


?>