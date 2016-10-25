<?php
include_once 'DB.php';
include_once 'IDAO.php';

class CursoDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM cursos WHERE id_curso = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM cursos c ORDER BY c.id_curso";
		$stmt = DB::prepare($sql);
		$stmt->execute();

		$listaCursos = new ArrayObject(); 

		while($registro = $stmt->fetch(PDO::FETCH_OBJ)){

			$curso = new Curso(); 

			$curso->setId($registro->id_curso);
			$curso->setNome($registro->nome_curso);
			$curso->setSigla($registro->sigla);
			$curso->setDuracao($registro->duracao);

			$listaCursos->append($curso);
		}

		return $listaCursos;
	}
	 
	public function insert($curso) {

		$nome = $curso->getNome();
		$sigla = $curso->getSigla();
		$duracao = $curso->getDuracao();

		$sql = "INSERT INTO cursos (nome_curso, sigla, duracao) VALUES (:nome, :sigla, :duracao)";
	    $stmt = DB::prepare($sql);
	    $stmt->bindParam(":nome", $nome);
	    $stmt->bindParam(":sigla", $sigla);
	    $stmt->bindParam(":duracao", $duracao);
	    $stmt->execute();
	}

	public function update($curso) {
		$sql = "UPDATE alunos SET matricula = :matricula, nome_pai = :nome_pai, nome_mae = :nome_mae, situacao = :situacao WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":matricula", $curso->getMatricula());
	    $stmt->bindParam(":nome_pai", $curso->getNomePai());
	    $stmt->bindParam(":nome_mae", $curso->getNomeMae());
	    $stmt->bindParam(":situacao", $curso->getSituacao());

		$stmt->execute();
	}

	public function delete($id) {
		$sql = "DELETE FROM cursos WHERE id_curso = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
}
?>