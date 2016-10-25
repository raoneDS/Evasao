<?php
include_once 'Classes/Model/Curso.php';
include_once 'Classes/DAO/CursoDAO.php';

class CursoController{

	public function __construct()
	{

	}

	public function inseriCurso($nome, $sigla, $duracao){

		$curso = new Curso($nome);
		$curso->setSigla($sigla);
		$curso->setDuracao($duracao);


		$cursoDAO = new CursoDAO();
		$cursoDAO->insert($curso);
	}

	public function listaCursos(){
		$cursoDAO = new CursoDAO();
		$lista = $cursoDAO->listAll();

		return $lista;
	}
}
?>