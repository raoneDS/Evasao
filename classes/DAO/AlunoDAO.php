<?php
include_once 'DB.php';
include_once 'IDAO.php';
include_once 'Classes/DAO/PessoaDAO.php';
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

	public function getLastId(){
		$sql = "SELECT id_aluno FROM alunos ORDER BY id_aluno DESC LIMIT 1";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll(){
		$sql = "SELECT 

				alunos.id_aluno, nome, sexo, email, data_nascimento, renda_familiar, escola_origem, nome_curso,
				numero_matricula, situacao_matricula, semestre_inicial, periodo_atual,
				rua,  numero, bairro, complemento, cidade, uf, ST_X(ponto_mapa) as lat, ST_Y(ponto_mapa) as lgt


				from alunos
				inner join pessoas on alunos.id_pessoa = pessoas.id_pessoa
				inner join enderecos on alunos.id_aluno = enderecos.id_aluno
				inner join matriculas on alunos.id_aluno = matriculas.id_aluno 
				inner join cursos on matriculas.id_curso = cursos.id_curso";
				
		$stmt = DB::prepare($sql);
		$stmt->execute();	

		$alunos = array();
		while ($fetch = $stmt->fetch(PDO::FETCH_ASSOC)){		
			
			$curso = new Curso($fetch['nome_curso']);

			$matricula = new Matricula($fetch['semestre_inicial'], $fetch['periodo_atual'], $fetch['numero_matricula'], $fetch['situacao_matricula'],$curso);

			$ponto = new PosicaoGeografica($fetch['lat'],$fetch['lgt']);

			$endereco = new Endereco($fetch['rua'],$fetch['numero'],$fetch['bairro'],$fetch['cidade'],$fetch['complemento'],$fetch['uf']);

			
			$endereco->setPosicaoGeografica($ponto);


			$aluno = new Aluno($fetch['nome'],$fetch['data_nascimento'],$fetch['sexo'], $matricula, $endereco, $fetch['escola_origem'], $fetch['renda_familiar'], $fetch['email']);

			$alunos[] = $aluno;
		}
		return ($alunos);
	}

	public function insert($aluno, $id_pessoa) {


		$id_aluno = null;
		try{

		    $sqlAluno = "INSERT INTO alunos (renda_familiar, escola_origem, id_pessoa, email) 
		    				VALUES 	(:renda_familiar, :escola_origem, $id_pessoa, :email)";

			$stmt = $this->prepare($sqlAluno);
		   	$stmt->bindParam(":renda_familiar",$aluno['renda_familiar']);
		    $stmt->bindParam(":escola_origem",$aluno['escola_origem']);
		    $stmt->bindParam(":email",$aluno['email']);
		    $stmt->execute();
		    $id_aluno = $this->getLastId();
		    $id_aluno = $id_aluno['id_aluno'];
		}catch (Exception $e) {
		    echo "Error!: " . $e->getMessage() . "</br>"; 
		}
		return $id_aluno;
	}

	public function insert_transaction($aluno) {

		try{
		    $con = $this->getInstance();
		    $con->beginTransaction();

		    $pessoaDAO    = new PessoaDAO();
		    $matriculaDAO = new MatriculaDAO();
	    	$enderecoDAO  = new EnderecoDAO();

		    $id_pessoa = $pessoaDAO->insert($aluno);
		    $id_aluno = $this->insert($aluno, $id_pessoa);
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