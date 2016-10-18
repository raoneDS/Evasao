<?php
include_once 'Classes/Model/Pessoa.php';
class Usuario extends Pessoa{

  private $login;
  private $senha;
  private $ativo;

  public function __construct($login, $senha, $ativo){
    $this->login = $login;
    $this->senha = $senha;
    $this->ativo = $ativo;
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function setLogin($login)
  {
    $this->login = $login;
  }

  public function getSenha()
  {
    return $this->senha;
  }

  public function setSenha($senha)
  {
    $this->senha = $senha;
  }

  public function getAtivado()
  {
    return $this->ativado;
  }

  public function setAtivado($ativado)
  {
    $this->ativado = $ativado;
  }
}
?>