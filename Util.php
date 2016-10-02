<?php

Class Util{

	public function montaDados(){
		$arquivo = fopen('ListagemdeAlunos.csv','r');
		$dados = [];
		$linha = fgets($arquivo);
		$cont = 0;
		$contMeninas = 0;

		while($linha != null) {
			if($cont > 0){
				$dados = explode(';',$linha);
				$alunos[] = array('matricula' => $dados[0], 
								'situacao' => utf8_encode($dados[2]),
								'dt_nascimento' => $dados[5],
								'sexo' => $dados[7],
								'curso' => utf8_encode($dados[9]),
								'email' => utf8_encode($dados[14]),
								'endereco' => utf8_encode($dados[29].' '.$dados[30].', '.$dados[32].', '.$dados[34])
								);
				$cidades[utf8_encode($dados[34])] += 1;
				if($dados[7] == 'F')
					$contMeninas++;
			}
			$linha = fgets($arquivo);
			$cont++;
		}
		fclose($arquivo);
		return json_encode($alunos);
	}
}

?>