<?php
include_once 'DB.php';
include_once 'IDAO.php';
include_once 'AlunoDAO.php';

class EnderecoDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM alunos WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM alunos";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delete($id) {
		$sql = "DELETE FROM alunos WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id_aluno",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function insert($endereco) {
		$sql = "INSERT INTO enderecos (id_aluno, rua, numero, bairro, cidade, uf) 
						VALUES (:id_aluno, :rua, :numero, :bairro, :cidade, :uf)";

	    $stmt = DB::prepare($sql);

	    $rua    = $endereco->getRua();
		$numero = $endereco->getNumero();
		$bairro = $endereco->getBairro();
		$cidade = $endereco->getCidade();
		$uf     = $endereco->getUF();

		$alunoDAO = new AlunoDAO();
		$id_aluno = $alunoDAO->getLastId();

	    $stmt->bindParam(":id_aluno",$id_aluno);
	    $stmt->bindParam(":rua", $rua);
	    $stmt->bindParam(":numero", $numero);
	    $stmt->bindParam(":bairro", $bairro);
	    $stmt->bindParam(":cidade", $cidade);
	    $stmt->bindParam(":uf", $uf);

	    $stmt->execute();
	   
	}

}
?>