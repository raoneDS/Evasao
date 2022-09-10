<?php
    class Matricula implements JsonSerializable{
    private $semestreInicial;
    private $periodoAtual;
    private $numeroMatricula;  
    private $situacao; //Enum
    private $curso; //Classe

    public function __construct($semestreInicial, $periodoAtual, $numeroMatricula, $situacao, $curso){
      $this->semestreInicial = $semestreInicial;
      $this->periodoAtual = $periodoAtual;
      $this->numeroMatricula = $numeroMatricula;
      $this->situacao = $situacao;
      $this->curso = $curso;
    }

    public function getSemestreInicial(){
      return $this->semestreInicial;
    }

    public function setSemestreInicial($semestreInicial){
      $this->semestreInicial = $semestreInicial;
    }

    public function getPeriodoAtual(){
      return $this->periodoAtual;
    } 

    public function setPeriodoAtual($periodoAtual){
      $this->periodoAtual = $periodoAtual;
    }

    public function getNumeroMatricula(){
      return $this->numeroMatricula;
    }

    public function setNumeroMatricula($numeroMatricula){
      $this->numeroMatricula = $numeroMatricula;
    }

    public function getSituacao(){
      return $this->situacao;
    }

    public function setSituacao($situacao){
      $this->situacao = $situacao;
    }

    public function getCurso(){
      return $this->curso;
    }

    public function setCurso($curso){
      $this->curso = $curso;
    }

    public function jsonSerialize() {

        return [
          'semestreInicial' => $this->semestreInicial,
          'periodoAtual' => $this->periodoAtual,
          'numeroMatricula' => $this->numeroMatricula,
          'situacao' => $this->situacao,
          'curso' => $this->curso
        ];
    }

}
?>
