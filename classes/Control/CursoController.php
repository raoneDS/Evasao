<?php
include_once 'Classes/Model/Curso.php';
include_once 'Classes/DAO/CursoDAO.php';


if($_REQUEST['acao']){
	extract($_REQUEST);
	$resultado = true;

	$cursoController = new CursoController();
	switch ($acao){
		case 'list':
			$resultado = $cursoController->listaCursosJson();
			break;	
		case 'delete':
			//$resultado = delete($id);
			break;
		case 'insert':
			/*$usuario = new Usuario($nome, $data_nascimento, $sexo, $username, $senha);
			inseriUsuario($usuario);
			$resultado = "ok";*/
			break;			
	}
	echo $resultado;
}

class CursoController{

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
}
?>