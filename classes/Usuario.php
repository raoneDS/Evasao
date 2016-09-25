<?php
class Usuario {

  private $id;
  private $nome;
  private $sexo;
  private $dataNascimento;
  private $cpf;
  private $rg;
  private $email;
  private $endereco;
  private $telefone;
  private $login;
  private $senha;
  private $ativado;

  public function __construct()
  {

  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function getSexo()
  {
    return $this->sexo;
  }

  public function setSexo($sexo)
  {
    $this->sexo = $sexo;
  }

  public function getDataNascimento()
  {
    return $this->dataNascimento;
  }

  public function setDataNascimento($dataNascimento)
  {
    $this->dataNascimento = $dataNascimento;
  }

  public function getCpf()
  {
    return $this->cpf;
  }

  public function setCpf($cpf)
  {
    $this->cpf = $cpf;
  }

  public function getRG()
  {
    return $this->rg;
  }

  public function setRG($rg)
  {
    $this->rg = $rg;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getEndereco()
  {
    return $this->endereco;
  }

  public function setEndereco($endereco)
  {
    $this->endereco = $endereco;
  }

  public function getTelefone()
  {
    return $this->telefone;
  }

  public function setTelefone($telefone)
  {
    $this->telefone = $telefone;
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