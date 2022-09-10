<?php
include_once 'Pessoa.php';
class Aluno extends Pessoa implements JsonSerializable{
 
    private $cpf;
    private $matricula; //Classe
    private $endereco; //Classe
    private $escolaOrigem; //Enum
    private $rendaFamiliar;
    

    public function __construct($nome, $dataNascimento, $sexo, $matricula, $endereco, $escolaOrigem, $rendaFamiliar, $cpf){
        parent::__construct($nome, $dataNascimento, $sexo);
        $this->cpf = $cpf;
        $this->matricula = $matricula;
        $this->endereco = $endereco;
        $this->escolaOrigem = $escolaOrigem;
        $this->rendaFamiliar = $rendaFamiliar;
        
    }

    public function getCpf(){
      return $this->cpf;
    }

    public function setCpf($cpf){
      $this->cpf = $cpf;
    }

    public function getMatricula(){
      return $this->matricula;
    }

    public function setMatricula($matricula){
      $this->matricula = $matricula;
    }   

    public function getEndereco(){
      return $this->endereco;
    }

    public function setEndereco($endereco){
      $this->endereco = $endereco;
    }        

    public function getEscolaOrigem(){
      return $this->escolaOrigem;
    }

    public function setEscolaOrigem($escolaOrigem){
      $this->escolaOrigem = $escolaOrigem;
    }     

    public function getRendaFamiliar(){
      return $this->rendaFamiliar;
    }

    public function setRendaFamiliarm($rendaFamiliar){
      $this->rendaFamiliar = $rendaFamiliar;
    }      

    public function jsonSerialize() {

        return [
          'nome' => $this->nome,
          'cpf' => $this->cpf,
          'data_nascimento' => $this->dataNascimento,
          'sexo' => $this->sexo,
          'matricula' => $this->matricula,
          'endereco' => $this->endereco,
          'renda_familiar' => $this->rendaFamiliar,
          'escola_origem' => $this->escolaOrigem
        ];
    }
}
?>
