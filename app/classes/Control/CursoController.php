<?php
include_once 'Classes/Model/Curso.php';
include_once 'Classes/DAO/CursoDAO.php';

if(isset($_REQUEST['acao'])){
	if($_REQUEST['acao']){
		extract($_REQUEST);
		$resultado = true;
		$cursoController = new CursoController();
		switch ($acao){
			case 'list':
				$resultado = $cursoController->listaCursosJson();
				break;	
			case 'delete':
				$resultado = $cursoController->delete($id_curso);
				break;
			case 'insert':
				$cursoController->inseriCurso($nome, $sigla, $duracao);
				$resultado = "ok";
				break;	
		}
		echo $resultado;
	}
}

class CursoController{

	public function __construct()
	{

	}

	public function inseriCurso($nome, $sigla, $duracao){

		$curso = new Curso();
		$curso->setNome($nome);
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

	public function listaCursosJson(){
		$cursoDAO = new CursoDAO();
		$listaCursos = $cursoDAO->listAll();
		$totaldata = $totalfiltered = $listaCursos->count();

		$json_data = array(
	        "draw"            => intval( $_REQUEST['draw'] ),
	        "recordsTotal"    => intval( $totaldata ),
	        "recordsFiltered" => intval( $totalfiltered ),
	        "data"            => (array) $listaCursos
	    );

		return json_encode($json_data);
	}

	public function delete($id){
		$cursoDAO = new CursoDAO();
		$cursoDAO->delete($id);
	}
}
?>