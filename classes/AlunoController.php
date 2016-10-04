<?php
include_once 'Aluno.php';
include_once 'Endereco.php';
include_once 'AlunoDAO.php';

class AlunoController{

	public function __construct()
	{

	}

	// Retorna um array de alunos que foram retirados por JSON.
	public function montaEstruturaAlunos(){
		$arquivo = fopen('ListagemdeAlunos.csv','r');
		$dados = [];
		$linha = fgets($arquivo);
		$cont = 0;

		$aluno = new Aluno();
		$alunoDAO = new AlunoDAO();
		$endereco = new Endereco();

		$alunos = array();
		while($linha != null) {
			if($cont > 0){

				$dados = explode(';',$linha);

				$aluno->setMatricula($dados[0]);
				$date = DateTime::createFromFormat('d/m/Y',$dados[5]);
				$aluno->setDataNascimento($date->format('Y-m-d'));
				$aluno->setSituacao(utf8_encode($dados[2]));
				$aluno->setSexo($dados[7]);
				$aluno->setCurso(utf8_encode($dados[9]));

				$cidade_uf = explode(' - ', $dados[34]);

				$endereco->setRua(utf8_encode($dados[29]));
				$endereco->setNumero($dados[30]);
				$endereco->setBairro(utf8_encode($dados[32]));
				$endereco->setCidade(utf8_encode($cidade_uf[0]));
				$endereco->setUF(utf8_encode($cidade_uf[1]));

				$aluno->setEndereco($endereco);
				$aluno->setEmail(utf8_encode($dados[14]));

				$alunos[] = $aluno;

				//$alunoDAO->insert($aluno);
			}

			$linha = fgets($arquivo);
			$cont++;
		}
		fclose($arquivo);
		return json_encode($alunos);
	}

	public function inseriTodos($alunos){
		$alunoDAO = new AlunoDAO();
		foreach ($alunos as $key => $value) {
			$alunoDAO->insert($value);
		}
	}

	public function inseriPonto($ponto, $id){

	}	

}
?>