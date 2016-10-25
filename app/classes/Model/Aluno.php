<?php
include_once 'Pessoa.php';
class Aluno extends Pessoa implements JsonSerializable{
 
    private $matricula; //Classe
    private $endereco; //Classe
    private $escolaOrigem; //Enum
    private $rendaFamiliar;
    private $email;

    public function __construct($nome, $dataNascimento, $sexo, $matricula, $endereco, $escolaOrigem, $rendaFamiliar, $email){
        parent::__construct($nome, $dataNascimento, $sexo);
        $this->matricula = $matricula;
        $this->endereco = $endereco;
        $this->escolaOrigem = $escolaOrigem;
        $this->rendaFamiliar = $rendaFamiliar;
        $this->email = $email;
    }

    public function getMatricula(){
      return $this->matricula;
    }

    public function setMatricula($matricula){
      $this->matricula = $matricula;
    }

    public function setEmail($email){
      $this->email = $email;
    }

    public function getEmail(){
      return $this->email;
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
          'data_nascimento' => $this->dataNascimento,
          'sexo' => $this->sexo,
          'email' => $this->email,
          'matricula' => $this->matricula,
          'situacao' => $this->situacao,
          'endereco' => $this->endereco,
          'renda_familiar' => $this->rendaFamiliar,
          'escola_origem' => $this->escolaOrigem
        ];
    }
}
?>
