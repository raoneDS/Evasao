<?php
	session_start();
	include_once 'Classes/UsuarioController.php';

	$login = $_POST['usuario'];
	$senha = $_POST['senha'];

	$usuarioController = new UsuarioController();
	$usuario = $usuarioController->validaLogin($login, ($senha));

	if($usuario){
		$_SESSION["id_usuario"] = $usuario['id_usuario'];
		$_SESSION["nome_usuario"] = $usuario['nome'];
		$_SESSION["login"] = $usuario['login'];
		$_SESSION['sexo'] = $usuario['sexo'];

/*		$professorController = new ProfessorController();
		$professor = $professorController->listaProfessorIdUsuario($usuario['id_usuario']);		

		if(isset($professor)){
			$_SESSION["id_professor"] = $professor['id_professor'];
		}

		$alunoController = new AlunoController();
		$aluno = $alunoController->listaAlunoIdUsuario($usuario['id_usuario']);

		if(isset($aluno)){
			$_SESSION["id_aluno"] = $aluno['id_aluno'];
		}*/
		header("location:index.php");	    
	}else{

		header("location:login.php?error=1");
	}	

?>