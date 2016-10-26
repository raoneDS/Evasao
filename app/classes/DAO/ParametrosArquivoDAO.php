<?php
include_once 'DB.php';
include_once 'IDAO.php';

class ParametrosArquivoDAO extends DB implements IDAO {

	 
	public function listAll() {
		$sql = "SELECT * FROM parametros_arquivo";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}
?>