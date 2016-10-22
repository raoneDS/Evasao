<?php
include_once 'DB.php';
include_once 'IDAO.php';

class EnderecoDAO extends DB implements IDAO {

	public function findById($id) {
	 	$sql = "SELECT * FROM alunos WHERE id_aluno = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	 
	public function listAll() {
		$sql = "SELECT * FROM enderecos";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($endereco, $id_aluno) {

		if(!empty($endereco['ponto'])){

			$lat = $endereco['ponto'][0];
			$lgt = $endereco['ponto'][1];

			//ST_GeomFromText('POINT($lat $lgt)')

			$sql = "INSERT INTO enderecos (id_aluno, rua, numero, bairro, cidade, uf, ponto_mapa) 
							VALUES (:id_aluno, :rua, :numero, :bairro, :cidade, :uf, ST_MakePoint($lat,$lgt))";


			//echo $sql;
		    $stmt = DB::prepare($sql);

		    $stmt->bindParam(":id_aluno",$id_aluno);
		    $stmt->bindParam(":rua", $endereco['rua']);
		    $stmt->bindParam(":numero", $endereco['numero']);
		    $stmt->bindParam(":bairro", $endereco['bairro']);
		    $stmt->bindParam(":cidade", $endereco['cidade']);
		    $stmt->bindParam(":uf", $endereco['uf']);

		    $stmt->execute();
		}
	   
	}

}
?>