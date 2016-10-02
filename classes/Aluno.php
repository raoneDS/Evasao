<?php
class Aluno{
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

    public function setDataNascimento($situacao){
      $this->situacao = $situacao;
    }

    public function getDataNascimento(){
      return $this->dataNascimento;
    }

    public function setSituacao($dataNascimento){
      $this->dataNascimento = $dataNascimento;
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

}
?>
