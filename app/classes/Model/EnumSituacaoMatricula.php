<?php
	include_once 'Classes/Model/BasicEnum.php';

    abstract class EnumSituacaoMatricula extends BasicEnum{

    const Matriculado = 0;
    const Cancelado = 1;
    const Trancado = 2;
    const Concluinte = 3;
    const Concludente = 4;
    const Concluido = 5;
    const Transferido_Interno = 6;

}
?>
