<?php
include_once 'DB.php';
include_once 'IDAO.php';
include_once 'Classes/DAO/PessoaDAO.php';

class UsuarioDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function listAll() {

		$sql = "SELECT *

			from usuarios

			inner join pessoas on pessoas.id_pessoa = usuarios.id_pessoa";

		$stmt = DB::prepare($sql);
		$stmt->execute();
		
		$totaldata = $totalfiltered = $stmt->rowCount();


		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$json_data = array(
		                "draw"            => intval( $_REQUEST['draw'] ),
		                "recordsTotal"    => intval( $totaldata ),
		                "recordsFiltered" => intval( $totalfiltered ),
		                "data"            => $data);

		echo json_encode($json_data);
	}	
	 
	public function insert_transction($usuario){
		try{
		    $con = $this->getInstance();
		    $con->beginTransaction();

		    $pessoaDAO = new PessoaDAO();

		    $id_pessoa = $pessoaDAO->insert($usuario);
		    $this->insert($usuario, $id_pessoa);

    		$con->commit();
		}catch (Exception $e) {
		    $con->rollback();
		    echo "Error!: " . $e->getMessage() . "</br>"; 
		}
	}


	private function insert($usuario, $id_pessoa) {
		$sql = "INSERT INTO usuarios (id_pessoa, login, senha) 
					VALUES ($id_pessoa, :login, :senha)";

	    $stmt = DB::prepare($sql);

	    $login = $usuario->getLogin();
	    $senha = $usuario->getSenha();

	    $stmt->bindParam(":login", $login);
	    $stmt->bindParam(":senha", $senha);
	    $stmt->execute();
	}

	public function update($usuario) {
		$sql = "UPDATE usuarios SET nome = :nome, sexo = :sexo, data_nascimento = :dataNascimento, login = :login, senha = :senha WHERE id_usuario = :id";

		$stmt = DB::prepare($sql);
		$stmt->bindParam(":nome", $usuario->getNome());
		$stmt->bindParam(":sexo", $usuario->getSexo());
		$stmt->bindParam(":dataNascimento", $usuario->getDataNascimento());
		$stmt->bindParam(":login", $usuario->getLogin());
		$stmt->bindParam(":senha", $usuario->getSenha());

		$stmt->execute();
	}

	public function delete($id) {
		$sql = "DELETE FROM usuarios WHERE id_pessoa = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		return $stmt->execute();
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