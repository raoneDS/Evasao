<?php
//dirname('C:/xampp/htdocs/Evasao/');
include_once 'Classes/Model/Usuario.php';
include_once 'Classes/DAO/UsuarioDAO.php';



if($_REQUEST['acao']){
	$resultado = true;
	switch ($_REQUEST['acao']){
		case 'list':
			$resultado = listaUsuarios();
			break;
	}
	echo $resultado;
}


	function inseriUsuario($nome, $login, $senha, $situacao, $idProfessor){

		$usuario = new Usuario();

		//terminar

		$usuarioDAO = new UsuarioDAO();
		$usuarioDAO->insert($usuario);
	}

	function listaUsuarios(){
		$usuarioDAO = new UsuarioDAO();
		$lista = $usuarioDAO->listAll();

		return $lista;
	}

	function validaLogin($login, $senha){
		$usuarioDAO = new UsuarioDAO();
		$resultado = $usuarioDAO->validaLogin($login, $senha);

		return $resultado;
	}
?>