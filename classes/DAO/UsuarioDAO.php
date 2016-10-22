<?php
include_once 'DB.php';
include_once 'IDAO.php';

class UsuarioDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM usuarios";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	 
	public function insert($usuario) {
		$sql = "INSERT INTO usuarios (nome, sexo, data_nascimento, cpf, indentidade, email, endereco, telefone, login, senha, ativado) VALUES (:nome, :sexo, :dataNascimento, :cpf, :identidade, :email, :endereco, :telefone, :login, :senha, :ativado)";
	    $stmt = DB::prepare($sql);
	    $stmt->bindParam(":nome", $usuario->getNome());
	    $stmt->bindParam(":sexo", $usuario->getSexo());
	    $stmt->bindParam(":dataNascimento", $usuario->getDataNascimento());
	    $stmt->bindParam(":cpf", $usuario->getCpf());
	    $stmt->bindParam(":identidade", $usuario->getIdentidade());
	    $stmt->bindParam(":email", $usuario->getEmail());
	    $stmt->bindParam(":endereco", $usuario->getEndereco());
	    $stmt->bindParam(":telefone", $usuario->getTelefone());
	    $stmt->bindParam(":login", $usuario->getLogin());
	    $stmt->bindParam(":senha", $usuario->getSenha());
	    $stmt->bindParam(":ativado", $usuario->getAtivado());

	    $stmt->execute();
	}

	public function update($usuario) {
		$sql = "UPDATE usuarios SET nome = :nome, sexo = :sexo, data_nascimento = :dataNascimento, cpf = :cpf, identidade = :identidade, email = :email, endereco = :endereco, telefone = :telefone, login = :login, senha = :senha, ativado = :ativado WHERE id_usuario = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":nome", $usuario->getNome());
		$stmt->bindParam(":sexo", $usuario->getSexo);
		$stmt->bindParam(":dataNascimento", $usuario->getDataNascimento);
		$stmt->bindParam(":cpf", $usuario->getCpf);
		$stmt->bindParam(":identidade", $usuario->getIdentidade);
		$stmt->bindParam(":email", $usuario->getEmail);
		$stmt->bindParam(":endereco", $usuario->getEndereco);
		$stmt->bindParam(":telefone", $usuario->getTelefone);
		$stmt->bindParam(":login", $usuario->getLogin);
		$stmt->bindParam(":senha", $usuario->getSenha);
		$stmt->bindParam(":ativado", $usuario->getAtivado);
		$stmt->bindParam(":id", $usuario->$getId);

		$stmt->execute();
	}

	public function delete($id) {
		$sql = "DELETE FROM usuarios WHERE id_usuario = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function validaLogin($login, $senha){
	    $sql = "SELECT * FROM usuarios WHERE login = :login and senha = :senha";
	    $stmt = DB::prepare($sql);
	    $stmt->bindParam(":login",$login);
	    $stmt->bindParam(":senha",$senha);
	    $stmt->execute();

	    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
	    return $usuario;
  	}

}
?>