<?php
include_once 'DB.php';
include_once 'IDAO.php';

class MatriculaDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM matriculas WHERE id_aluno = :id_aluno";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id_aluno",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM matriculas";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($matricula, $id_aluno) {
		
		$situacao = $matricula['situacao'];
		$numeroMatricula = $matricula['numeroMatricula'];
		$curso = 1;

		$sql = "INSERT INTO matriculas (situacao_matricula, semestre_inicial, periodo_atual, id_aluno, id_curso, numero_matricula) 
								VALUES ($situacao, :semestre_inicial, :periodo_atual, :id_aluno, $curso, '$numeroMatricula')";

	    $stmt = DB::prepare($sql);

	    
	    $stmt->bindParam(":semestre_inicial", $matricula['semestreInicial']);
	    $stmt->bindParam(":periodo_atual", $matricula['periodoAtual']);
	   	$stmt->bindParam(":id_aluno", $id_aluno);

	   	//var_dump($sql);
	    $stmt->execute();
	   
	}

	public function update($matricula) {

		$sql = "UPDATE matriculas 
				SET situacao_matricula = :situacao_matricula, semestre_inicial = :semestre_inicial, periodo_atual = :periodo_atual
				WHERE numero_matricula = :numero_matricula";

	    $stmt = DB::prepare($sql);

	    $stmt->bindParam(":situacao_matricula",$matricula['situacao']);
	    $stmt->bindParam(":semestre_inicial",$matricula['semestreInicial']);
	    $stmt->bindParam(":periodo_atual",$matricula['periodoAtual']);
	   	$stmt->bindParam(":numero_matricula", $matricula['numero_matricula']);

	   	//var_dump($sql);
	    $stmt->execute();
	   
	}

}
?>