<?php
class Aluno implements JsonSerializable{
    private $nome;
    private $email;
    private $matricula;
    private $situacao;
    private $dataNascimento;
    private $sexo;
    private $curso;
    private $endereco;

    public function __construct()
    {

    }

    public function getMatricula(){
      return $this->matricula;
    }

    public function setMatricula($matricula){
      $this->matricula = $matricula;
    }

    public function getSituacao(){
      return $this->situacao;
    }

    public function setSituacao($situacao){
      $this->situacao = $situacao;
    }

    public function setEmail($email){
      $this->email = $email;
    }

    public function getEmail(){
      return $this->email;
    }

    public function setDataNascimento($dataNascimento){
      $this->dataNascimento = $dataNascimento;
    }

    public function getDataNascimento(){
      return $this->dataNascimento;
    }

    public function getSexo(){
      return $this->sexo;
    }

    public function setSexo($sexo){
      $this->sexo = $sexo;
    }    

    public function getCurso(){
      return $this->curso;
    }

    public function setCurso($curso){
      $this->curso = $curso;
    }   

    public function getEndereco(){
      return $this->endereco;
    }

    public function setEndereco($endereco){
      $this->endereco = $endereco;
    }    

    public function jsonSerialize() {

        return [
          'nome' => $this->nome,
          'email' => $this->email,
          'matricula' => $this->matricula,
          'situacao' => $this->situacao,
          'dataNascimento' => $this->dataNascimento,
          'sexo' => $this->sexo,
          'curso' => $this->curso,
          'endereco' => $this->endereco
        ];
    }

}
?>
