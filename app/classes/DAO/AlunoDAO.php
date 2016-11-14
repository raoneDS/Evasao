<?php
include_once 'DB.php';
include_once 'IDAO.php';
include_once 'Classes/DAO/MatriculaDAO.php';
include_once 'Classes/DAO/EnderecoDAO.php';

class AlunoDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM alunos WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function findByCpf($cpf) {
	 	$sql = "SELECT * FROM alunos WHERE cpf = :cpf";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":cpf", $cpf);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getLastId(){
		$sql = "SELECT id_aluno FROM alunos ORDER BY id_aluno DESC LIMIT 1";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll(){
		$sql = "SELECT 

				alunos.id_aluno, cpf, alunos.nome, sexo, data_nascimento, renda_familiar, escola_origem, matriculas.id_curso, nome_curso,
				numero_matricula, situacao_matricula, semestre_inicial, periodo_atual,
				rua,  numero, bairro, complemento, municipios.nome as nome_cidade, municipios.gid, enderecos.uf, ST_X(ponto_mapa) as lat, ST_Y(ponto_mapa) as lgt

				from alunos
				inner join enderecos on alunos.id_aluno = enderecos.id_aluno
				inner join matriculas on alunos.id_aluno = matriculas.id_aluno 
				inner join cursos on matriculas.id_curso = cursos.id_curso
				inner join municipios on municipios.gid = enderecos.id_cidade";
				
		$stmt = DB::prepare($sql);
		$stmt->execute();

		if($stmt->rowCount() == 0)
			return null;

		$alunos = array();
		while ($fetch = $stmt->fetch(PDO::FETCH_ASSOC)){		
			
			$curso = new Curso();
			$curso->setNome($fetch['nome_curso']);
			$curso->setId($fetch['id_curso']);


			$matricula = new Matricula($fetch['semestre_inicial'], $fetch['periodo_atual'], 
										$fetch['numero_matricula'], $fetch['situacao_matricula'],$curso);

			$ponto = new PosicaoGeografica($fetch['lat'],$fetch['lgt']);
			$endereco = new Endereco($fetch['rua'], $fetch['numero'], $fetch['bairro'], $fetch['nome_cidade'], $fetch['uf']);
			$endereco->setPosicaoGeografica($ponto);

			$aluno = new Aluno($fetch['nome'],$fetch['data_nascimento'],$fetch['sexo'], $matricula, $endereco, $fetch['escola_origem'], $fetch['renda_familiar'], $fetch['cpf']);

			$alunos[] = $aluno;
		}
		return ($alunos);
	}

	// Formatação de inserção para Javascript
	public function insert($aluno) {
		$id_aluno = null;
		try{

		    $sqlAluno = "INSERT INTO alunos (data_nascimento, sexo, nome, renda_familiar, escola_origem, cpf) 
		    				VALUES 	(:data_nascimento, :sexo, :nome, :renda_familiar, :escola_origem, :cpf)";

			$stmt = $this->prepare($sqlAluno);

			$stmt->bindParam(":data_nascimento", $aluno['data_nascimento']);
			$stmt->bindParam(":sexo", $aluno['sexo']);
			$stmt->bindParam(":nome", $aluno['nome']);
		   	$stmt->bindParam(":renda_familiar", $aluno['renda_familiar']);
		    $stmt->bindParam(":escola_origem", $aluno['escola_origem']);
		    $stmt->bindParam(":cpf", $aluno['cpf']);

		    $stmt->execute();

		    $id_aluno = $this->getLastId();
		    $id_aluno = $id_aluno['id_aluno'];

		    
		}catch (Exception $e) {
		    echo "Error!: " . $e->getMessage() . "</br>";
		}
		return $id_aluno;
	}

	public function update($aluno, $idAluno) {

		$id_aluno = null;
		try{

		    $sqlAluno = "UPDATE alunos 
		    				SET renda_familiar = :renda_familiar, escola_origem = :escola_origem
		    				WHERE id_aluno = :id_aluno";

			$stmt = $this->prepare($sqlAluno);
		   	$stmt->bindParam(":renda_familiar",$aluno['renda_familiar']);
		    $stmt->bindParam(":escola_origem",$aluno['escola_origem']);
		    $stmt->bindParam(":id_aluno",$idAluno);
		    $stmt->execute();

		}catch (Exception $e) {
		    echo "Error!: " . $e->getMessage() . "</br>"; 
		}
	}

	public function insert_transaction($aluno) {

		try{
		    $con = $this->getInstance();
		    $con->beginTransaction();

		    $matriculaDAO = new MatriculaDAO();
	    	$enderecoDAO  = new EnderecoDAO();

		    $id_aluno = $this->insert($aluno);
    		$enderecoDAO->insert($aluno['endereco'],$id_aluno);
    		$matriculaDAO->insert($aluno['matricula'],$id_aluno);
    		$con->commit();
		}catch (Exception $e) {
		    $con->rollback();
		    echo "Error!: " . $e->getMessage() . "</br>"; 
		}
	}
}
?>