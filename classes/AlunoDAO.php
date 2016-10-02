<?php
include_once 'DB.php';
include_once 'IDAO.php';

class AlunoDAO extends DB implements IDAO {

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

	public function listAllFromTurma($id) {
		$sql = "SELECT usuarios.nome, alunos_turmas.id_aluno

				FROM turmas

				LEFT JOIN alunos_turmas ON alunos_turmas.id_turma = turmas.id_turma
				LEFT JOIN alunos ON alunos.id_aluno = alunos_turmas.id_aluno
				LEFT JOIN usuarios on usuarios.id_usuario = alunos.id_usuario

				WHERE turmas.id_turma = :id
				ORDER BY usuarios.nome";

		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findByUserId($id) {
		$sql = "SELECT * FROM alunos WHERE id_usuario = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function insert($aluno) {
		/*
		$sql = "INSERT INTO avaliacoes (tipo_avaliacao, peso, data, id_turma) VALUES (:tipo_avaliacao, :peso, :data, :id_turma)";
	    $stmt = DB::prepare($sql);
	    $stmt->bindParam(":tipo_avaliacao", $avaliacao->getTipoAvaliacao());
	    $stmt->bindParam(":peso", $avaliacao->getPeso());
	    $stmt->bindParam(":data", $avaliacao->getData());
	    $stmt->bindParam(":id_turma", $avaliacao->getTurma()->getId());

	    $stmt->execute();
	    */
	}

	public function update($aluno) {
		/*
		$sql = "UPDATE avaliacoes SET tipo_avaliacao = :tipo_avaliacao, peso = :peso, data = :data, id_turma = :id_turma WHERE id_avaliacao = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":tipo_avaliacao", $avaliacao->getTipoAvaliacao());
	    $stmt->bindParam(":peso", $avaliacao->getPeso());
	    $stmt->bindParam(":data", $avaliacao->getData());
	    $stmt->bindParam(":id_turma", $avaliacao->getTurma()->getId());
	    $stmt->bindParam(":id", $avaliacao->getId());

		$stmt->execute();
		*/
	}


	public function delete($id) {
		$sql = "DELETE FROM alunos WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id_aluno",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
}
?>