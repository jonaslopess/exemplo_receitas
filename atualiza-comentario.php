<?php 

include "conexao.php";

$sql = '';

if($_GET["curtir"] == 'true'){

    $sql = "update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 
            where codigo = '".$_GET["codigo"]."' and email_autor != 'joao@g.com';";
} else {

    $sql = "update Comentario set avaliacoes_negativas = avaliacoes_negativas + 1 
            where codigo = '".$_GET["codigo"]."' and email_autor != 'joao@g.com';";

}

$resultado = $conector->query($sql);
if($resultado === TRUE){
    echo "<script language='javascript' type='text/javascript'>alert('Registro atualizado!');
    window.location.href = 'index';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Falha na atualização!');
    window.location.href = 'index';</script>";
}

$conector->close();

?>