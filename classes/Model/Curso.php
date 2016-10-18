<?php
class Curso implements JsonSerializable{

  private $nome;
  private $sigla;
  private $duracao;

  public function __construct($nome){
    $this->nome = $nome;
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
    return $this->duracao;
  }

  public function setSigla($duracao)
  {
    $this->duracao = $duracao;
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
        'nome' => $this->nome,
        'sigla' => $this->sigla,
        'duracao' => $this->duracao
      ];
  }


}
?>