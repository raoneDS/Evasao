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

	public function getLastId(){
		$sql = "SELECT id_aluno FROM alunos ORDER BY id_aluno DESC LIMIT 1";
		$stmt = DB::prepare($sql);
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

	public function insert($aluno) {

		$sql = "INSERT INTO alunos (email, matricula, situacao, data_nascimento, sexo, id_curso) VALUES 
								(:email, :matricula, :situacao, :data_nascimento, :sexo, :curso)";

	    $stmt = DB::prepare($sql);

	    $email = $aluno->getEmail();
	    $matricula = $aluno->getMatricula();
	    $situacao = $aluno->getSituacao();
	    $data_nascimento = $aluno->getDataNascimento();
	    $sexo = $aluno->getSexo();
	    $curso = 1;

	    $stmt->bindParam(":email",$email);
	    $stmt->bindParam(":matricula",$matricula);
	    $stmt->bindParam(":situacao",$situacao);
	   	$stmt->bindParam(":data_nascimento",$data_nascimento);
	    $stmt->bindParam(":sexo",$sexo);
	    $stmt->bindParam(":curso",$curso);
	    $stmt->execute();

	}

}
?>