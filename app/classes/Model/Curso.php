<?php
class Curso implements JsonSerializable{

  private $idCurso;
  private $nome;
  private $sigla;
  private $duracao;

  public function __construct(){
  }

  public function getId()
  {
    return $this->idCurso;
  }

  public function setId($idCurso)
  {
    $this->idCurso = $idCurso;
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function getSigla()
  {
    return $this->sigla;
  }

  public function setSigla($sigla)
  {
    $this->sigla = $sigla;
  }

  public function getDuracao()
  {
    return $this->duracao;
  }

  public function setDuracao($duracao)
  {
    $this->duracao = $duracao;
  }

  public function jsonSerialize() {
      return [
        'id' => $this->idCurso,
        'nome' => $this->nome,
        'sigla' => $this->sigla,
        'duracao' => $this->duracao
      ];
  }


}
?>