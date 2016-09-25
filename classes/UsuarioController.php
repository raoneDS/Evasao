<?php
include_once 'Usuario.php';
include_once 'UsuarioDAO.php';

class UsuarioController{

	public function __construct()
	{

	}

	public function inseriUsuario($nome, $login, $senha, $situacao, $idProfessor){

		$usuario = new Usuario();

		//terminar

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
}
?>