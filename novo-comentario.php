<?php

include "conexao.php";

$sql = 'insert into Comentario (titulo, texto, email_autor, codigo_receita) 
        values (
            "'.$_POST['titulo'].'",
            "'.$_POST['texto'].'",
            "joao@g.com",
            "1"
        );';

$resultado = $conector->query($sql);
if($resultado === TRUE){
    echo "<script language='javascript' type='text/javascript'>alert('Registro inserido!');
    window.location.href = 'index';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Falha na inserção!');
    window.location.href = 'index';</script>";
}


$conector->close();

?>