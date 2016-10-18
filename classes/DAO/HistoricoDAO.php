<?php
include_once 'DB.php';
include_once 'IDAO.php';

class HistoricoDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM historico_atualizacao WHERE id_historico = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM historico_atualizacao";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($historico) {
		
		$sql = "INSERT INTO alunos (data, registros_inseridos) VALUES 
								(:email, :matricula, :situacao, :data_nascimento, :sexo, :curso)";

	    $stmt = DB::prepare($sql);

	    $curso = 1;

	    $stmt->bindParam(":email",$aluno['email']);
	    $stmt->bindParam(":matricula",$aluno['matricula']);
	    $stmt->bindParam(":situacao",$aluno['situacao']);
	   	$stmt->bindParam(":data_nascimento",$aluno['$data_nascimento']);
	    $stmt->bindParam(":sexo",$aluno['sexo']);
	    $stmt->bindParam(":curso",$curso);
	    $stmt->execute();
	   
	}

}
?>