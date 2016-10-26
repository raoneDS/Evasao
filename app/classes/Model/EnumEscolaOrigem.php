<?php
	include_once 'Classes/Model/BasicEnum.php';
	
    abstract class EnumEscolaOrigem extends BasicEnum{

    const Privada = 0;
    const Pública_Municipal = 1;
    const Pública_Estadual = 2;
    const Pública_Federal = 3;
    const Nao_Informado = 4;
}
?>


