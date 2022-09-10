<?php
class Historico{

  private $data;
  private $qtdRegistros;

  public function __construct()
  {

  }

  public function getData()
  {
    return $this->data;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function getQtdRegistros()
  {
    return $this->qtdRegistros;
  }

  public function setQtdRegistros($total)
  {
    $this->setQtdRegistros = $total;
  }

}
?>