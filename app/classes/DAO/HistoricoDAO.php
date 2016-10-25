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
		
		$sql = "INSERT INTO historico_atualizacao (data, registros_inseridos) 
									VALUES (:email, :matricula)";

	    $stmt = DB::prepare($sql);

	    $curso = 1;

	    $stmt->execute();
	   
	}

}
?>