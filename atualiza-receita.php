<?php 

include "conexao.php";

$sql = "update Receita set nota =
        case 
            when nota > 0 then (nota + ".$_GET['nota'].")/2
            when nota < 1 then ".$_GET['nota']."
        end 
        where codigo = ".$_GET['codigo'].";";


$resultado = $conector->query($sql);
if($resultado === TRUE){
    echo "<script language='javascript' type='text/javascript'>alert('Nota atualizada!');
    window.location.href = 'index';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Falha na atualização!');
    window.location.href = 'index';</script>";
}

$conector->close();

?>