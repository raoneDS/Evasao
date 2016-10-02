<?php
include_once 'Aluno.php';
include_once 'AlunoDAO.php';

class AlunoController{

	public function __construct()
	{

	}

	public function inseriAluno(){

		$aluno = new Aluno();

		$alunoDAO = new AlunoDAO();
		$alunoDAO->insert($aluno);
	}

	public function listaAlunoIdUsuario($id){
		$alunoDAO = new AlunoDAO();
		$aluno = $alunoDAO->findByUserId($id);

		return $aluno;
	}

	public function listaAlunos(){
		$alunoDAO = new AlunoDAO();
		$lista = $alunoDAO->listAll();

		return $lista;
	}	

	public function listaAlunosPorTurma($id){
		$alunoDAO = new AlunoDAO();
		$lista = $alunoDAO->listAllFromTurma($id);

		return $lista;
	}
}
?>