<?php
class Endereco implements JsonSerializable{
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $uf;
    private $posicaoGeografica;

    public function __construct($rua, $numero, $bairro, $cidade, $uf){
      $this->rua = $rua;
      $this->numero = $numero;
      $this->bairro = $bairro;
      $this->cidade = $cidade;
      $this->uf = $uf;
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

    public function getComplemento(){
      return $this->complemento;
    }

    public function setPosicaoGeografica($posicaoGeografica){
      $this->posicaoGeografica = $posicaoGeografica;
    }

    public function getEnderecoCompleto(){
      return ($this->rua.' '.$this->numero.', '.$this->bairro.', '.$this->cidade.' - '.$this->uf);
    }

    public function jsonSerialize() {

        return [
          'rua' => $this->rua,
          'numero' => $this->numero,
          'bairro' => $this->bairro,
          'cidade' => $this->cidade,
          'uf' => $this->uf,
          'ponto' => $this->posicaoGeografica,
          'endereco_completo' => $this->getEnderecoCompleto()
        ];
    }

}
?>
