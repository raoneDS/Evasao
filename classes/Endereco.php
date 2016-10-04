<?php
class Endereco implements JsonSerializable{
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $uf;
    private $ponto;

    public function __construct(){

    }

    public function getRua(){
      return $this->rua;
    }

    public function setRua($rua){
      $this->rua = $rua;
    }    

    public function getNumero(){
      return $this->numero;
    }

    public function setNumero($numero){
      $this->numero = $numero;
    }    

    public function getBairro(){
      return $this->bairro;
    }

    public function setBairro($bairro){
      $this->bairro = $bairro;
    }    

    public function getCidade(){
      return $this->cidade;
    }

    public function setCidade($cidade){
      $this->cidade = $cidade;
    }    

    public function getUF(){
      return $this->uf;
    }

    public function setUF($uf){
      $this->uf = $uf;
    }

    public function getPonto(){
      return $this->ponto;
    }

    public function setPonto($ponto){
      $this->ponto = $ponto;
    }

    public function getEnderecoCompleto(){
      return ($this->rua.' '.$this->numero.', '.$this->bairro.', '.$this->cidade.' - '.$this->uf);
      //$aluno->setEndereco(utf8_encode($dados[29].' '.$dados[30].', '.$dados[32].', '.$dados[34]));
    }

    public function jsonSerialize() {

        return [
          'rua' => $this->rua,
          'numero' => $this->numero,
          'bairro' => $this->bairro,
          'cidade' => $this->cidade,
          'uf' => $this->uf
        ];
    }

}
?>
