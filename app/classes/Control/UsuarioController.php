<?php
//dirname('C:/xampp/htdocs/Evasao/');
include_once 'Classes/Model/Usuario.php';
include_once 'Classes/DAO/UsuarioDAO.php';

if($_REQUEST['acao']){
	extract($_REQUEST);
	$resultado = true;
	$usuarioController = new UsuarioController();
	switch ($acao){
		case 'list':
			$resultado = $usuarioController->listaUsuarios();
			break;	
		case 'delete':
			$resultado = $usuarioController->delete($id_pessoa);
			break;
		case 'insert':
			$usuario = new Usuario($nome, $data_nascimento, $sexo, $username, $senha);
			$usuarioController->inseriUsuario($usuario);
			$resultado = "ok";
			break;	
	}
	echo $resultado;
}

class UsuarioController{

	public function inseriUsuario($usuario){
		$usuarioDAO = new UsuarioDAO();
		$usuarioDAO->insert($usuario);
	}

	public function listaUsuarios(){
		$usuarioDAO = new UsuarioDAO();
		$lista = $usuarioDAO->listAll();

		return $lista;
	}

	public function validaLogin($login, $senha){
		$usuarioDAO = new UsuarioDAO();
		$resultado = $usuarioDAO->validaLogin($login, $senha);

		return $resultado;
	}

	public function delete($id){
		$usuarioDAO = new UsuarioDAO();
		$usuarioDAO->delete($id);
	}
}
?>