<?php
//dirname('C:/xampp/htdocs/Evasao/');
include_once 'Classes/Model/Usuario.php';
include_once 'Classes/DAO/UsuarioDAO.php';

if($_REQUEST['acao']){
	extract($_REQUEST);
	$resultado = true;
	switch ($acao){
		case 'list':
			$resultado = listaUsuarios();
			break;	
		case 'delete':
			$resultado = delete($id);
			break;
		case 'insert':
			$usuario = new Usuario($nome, $data_nascimento, $sexo, $username, $senha);
			inseriUsuario($usuario);
			$resultado = "ok";
			break;	
	}
	echo $resultado;
}


	function inseriUsuario($usuario){
		$usuarioDAO = new UsuarioDAO();
		$usuarioDAO->insert_transction($usuario);
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

	function delete($id){
		$usuarioDAO = new UsuarioDAO();
		echo $usuarioDAO->delete($id);
	}
?>