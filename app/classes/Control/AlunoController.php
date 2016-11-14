<?php
include_once 'Classes/Model/Aluno.php';
include_once 'Classes/Model/Endereco.php';
include_once 'Classes/Model/Curso.php';
include_once 'Classes/Model/PosicaoGeografica.php';
include_once 'Classes/Model/Historico.php';
include_once 'Classes/Model/Matricula.php';
include_once 'Classes/Model/EnumEscolaOrigem.php';
include_once 'Classes/Model/EnumSituacaoMatricula.php';

include_once 'Classes/DAO/AlunoDAO.php';
include_once 'Classes/DAO/HistoricoDAO.php';
include_once 'Classes/DAO/EnderecoDAO.php';


if(isset($_REQUEST['acao'])){
	$resultado = true;
	$alunoController = new AlunoController();
	switch ($_REQUEST['acao']){
		case 'saveData':
			$alunoController->inseriTodos($_REQUEST['alunos']);
			break;
		case 'inserir':
			$alunoController->inseriAluno($_REQUEST['aluno']);
			break;
		case 'processar':
			$alunoController->processaAluno($_REQUEST['aluno']);
			break;
	}
}

class AlunoController{

	public function getAlunosCSV($caminhoArquivo){
		$arquivo = fopen($caminhoArquivo,'r');
		$dados = [];
		$linha = fgets($arquivo);
		$cont = 0;

		$arrayEscolas = EnumEscolaOrigem::getConstants();
		$arraySituacao = EnumSituacaoMatricula::getConstants();	

		$alunos = array();
		while($linha != null) {
			if($cont > 0){

				$dados = explode(';',$linha);

				$cursoNome = utf8_encode($dados[9]);
				$curso = new Curso($cursoNome);

				$semestre = $dados[8];
				$numeroMatricula = $dados[0];

				$periodoAtual = $dados[10];
				$situacao = $arraySituacao[$dados[2]];
				$matricula = new Matricula($semestre, $periodoAtual, $numeroMatricula, $situacao, $curso);

				//testa se o endereco esta preenchido
				if(!empty($dados[29]) && !empty($dados[30]) && !empty($dados[32]) && !empty($dados[34])){
					$rua = utf8_encode($dados[29]);
					$numero = $dados[30];
					$bairro = utf8_encode($dados[32]);
					$cidade_uf = explode(' - ', $dados[34]);
					$cidade = utf8_encode($cidade_uf[0]);
					$estado  = utf8_encode($cidade_uf[1]);

				}
				//se nao, preencher com o endereco do ifes
				else{
					$rua = "ES-010";
					$numero = "Km-6,5";
					$bairro = "Manguinhos";
					$cidade = "Serra";
					$estado  = "ES";					
				}

				$endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado);	

				$date = DateTime::createFromFormat('d/m/Y',$dados[5]);

				$nome = utf8_encode($dados[1]);
				$cpf = utf8_encode($dados[23]);
				$dataNascimento = $date->format('Y-m-d');
				$sexo = $dados[7];

				if(!empty($dados[20]))
					$escolaOrigem = $arrayEscolas[utf8_encode($dados[20])];
				else
					$escolaOrigem = (int) 4;

				$renda = utf8_encode($dados[18]);
				$aluno = new Aluno($nome, $dataNascimento, $sexo, $matricula, $endereco, $escolaOrigem, $renda, $cpf);

				$alunos[] = $aluno;
			}

			$linha = fgets($arquivo);
			$cont++;
		}
		fclose($arquivo);

		return json_encode($alunos);
	}

	public function inseriTodos($alunos){
		$alunoDAO = new AlunoDAO();
		foreach ($alunos as $key => $aluno) {
			$alunoDAO->insert_transaction($aluno);
		}
	}	

	public function getAlunosDB(){
		$alunoDAO = new AlunoDAO();
		return json_encode($alunoDAO->listAll());
	}

	public function processaAluno($alunoCSV){
		$alunoDAO = new AlunoDAO();
		$alunoBD = $alunoDAO->findByCpf($alunoCSV['cpf']);
		if($alunoBD){
			//atualiza
			echo 'Atualizando o cadastro do aluno '.$alunoCSV['nome'];
			$this->atualizaAluno($alunoCSV, $alunoBD);
			
		}
		else{
			//inseri aluno novo
			echo 'Cadastrando o aluno '.$alunoCSV['nome'];
			var_dump($alunoCSV);
			$this->inseriAluno($alunoCSV);
			
		}

	}

	public function inseriAluno($aluno){
		$alunoDAO = new AlunoDAO();
		$idAluno = $alunoDAO->insert($aluno);

		$aluno = $this->localizarEnderecoAluno($aluno);
		echo "\n".'Pesquisando o endereço do aluno '.$aluno['nome'];

		$enderecoDao = new EnderecoDAO();
		$enderecoDao->insert($aluno['endereco'], $idAluno);

		$matriculaDAO = new MatriculaDAO();
		$matriculaDAO->insert($aluno['matricula'],$idAluno);
	}

	public function atualizaAluno($alunoCSV, $alunoBD){

		//atualiza a tabela alunos
		$alunoDAO = new AlunoDAO();
		$alunoDAO->update($alunoCSV, $alunoBD['id_aluno']);

		//consulta o endereco atual
		$enderecoDao = new EnderecoDAO();
		$enderecoBD = $enderecoDao->findByIdAluno($alunoBD['id_aluno']);
		
		if($enderecoBD['rua'] != $alunoCSV['endereco']['rua'] || 
								$enderecoBD['numero'] != $alunoCSV['endereco']['numero'] ||
								$enderecoBD['bairro'] != $alunoCSV['endereco']['bairro'] ||
								$enderecoBD['cidade'] != $alunoCSV['endereco']['cidade'] ||
								$enderecoBD['uf'] != $alunoCSV['endereco']['uf'] ) {

			echo "\n".'Atualizando endereço do aluno '.$alunoCSV['nome'];
			$alunoCSV = $this->localizarEnderecoAluno($alunoCSV);

			if(isset($enderecoBD["id_aluno"]) &&  !empty($enderecoBD["id_aluno"])){
				$enderecoDao->update($alunoCSV['endereco'], $alunoBD['id_aluno']);
			}
			else{
				$enderecoDao->insert($alunoCSV['endereco'], $alunoBD['id_aluno']);
			}

		}		

		$matriculaDAO = new MatriculaDAO();
		$matriculaBD = $matriculaDAO->findById($alunoBD['id_aluno']);

		if(isset($matriculaBD['numero_matricula'])){

			var_dump($alunoCSV['matricula']['numeroMatricula']);
			var_dump($matriculaBD['numero_matricula']);

			if(trim($alunoCSV['matricula']['numeroMatricula']) == trim($matriculaBD['numero_matricula'])){
				$matriculaDAO->update($alunoCSV['matricula'], $alunoBD['id_aluno']);
			}
			else{
				$matriculaDAO->insert($alunoCSV['matricula'], $alunoBD['id_aluno']);
			}

		}		
	}

	public function localizarEnderecoAluno($aluno){
		$endereco = $aluno['endereco']['endereco_completo'];

		$resultado = $this->geocode($endereco);
 
    	// if able to geocode the address
    	if($resultado){         
        	$latitude = $resultado[0];
        	$longitude = $resultado[1];
        	$formatted_address = $resultado[2];

        	$aluno['endereco']['ponto'][0] = $latitude;
        	$aluno['endereco']['ponto'][1] = $longitude;
    	}

    	return $aluno;
	}

	public function geocode($address){
 
	    // url encode the address
	    $address = urlencode($address);
	    
	    sleep(1);
	    // google map geocode api url
	    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
	 
	    // get the json response
	    $resp_json = file_get_contents($url);
	     
	    // decode the json
	    $resp = json_decode($resp_json, true);

	    //var_dump($resp['status']);
	 
	    // response status will be 'OK', if able to geocode given address 
	    if($resp['status']=='OK'){
	 
	        // get the important data
	        $lati = $resp['results'][0]['geometry']['location']['lat'];
	        $longi = $resp['results'][0]['geometry']['location']['lng'];
	        $formatted_address = $resp['results'][0]['formatted_address'];
	         
	        // verify if data is complete
	        if($lati && $longi && $formatted_address){
	         
	            // put the data in the array
	            $data_arr = array();            
	             
	            array_push(
	                $data_arr, 
	                    $lati, 
	                    $longi, 
	                    $formatted_address
	                );
	            
	            return $data_arr;
	             
	        }else{
	        	
	            return false;
	        }
	    
	    }else{
	    	echo "\n".'Endereço não encontrado: '.$resp['status'];
	        return false;
	    }
	}

	public function getCidades(){
		$enderecoDAO = new EnderecoDAO();
		return $enderecoDAO->listCities();
	}



}


?>