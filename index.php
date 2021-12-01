<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Exemplos Receitas</title>
</head>
<body>
    <div class="container">
        <h1>Receitas cadastardas</h1>
        <div class="container p-3">
            <div class="row">
                <!-- Receita -->
                <?php
                    include "conexao.php";

                    $sql = "select 
                                Receita.codigo,
                                Receita.titulo, 
                                Receita.nota, 
                                Receita.descricao, 
                                Receita.foto, 
                                Autor.nome as nome_autor, 
                                Autor.foto as foto_autor,
                                count(*) as num_comentarios 
                            from Receita inner join Autor
                            on Autor.email = Receita.email_autor
                            inner join Comentario 
                            on Comentario.codigo_receita = Receita.codigo
                            group by Comentario.codigo_receita;";

                    $resultados_receitas = $conector->query($sql);
                    $num_receitas = $resultados_receitas->num_rows;
                    if($num_receitas <= 0){
                        echo "Nenhum registro encontrado!";
                    } else {
                        for($j=0;$j<$num_receitas;$j++){
                            $resultados_receitas->data_seek($j);
                            $receita = $resultados_receitas->fetch_assoc();

                ?> 
                <div class="col">
                    <div class="card" style="width: 36rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <h3><?php echo $receita['titulo']?></h3>
                                </div>
                                <div class="col-5">
                                    <a class="btn star star1" href="#">
                                        
                                    </a>
                                    <a class="btn star star2" href="#">
                                        
                                    </a>
                                    <a class="btn star star3" href="#">
                                        
                                    </a>
                                    <a class="btn star star4" href="#">
                                        
                                    </a>
                                    <a class="btn star star5" href="#">
                                        
                                    </a>
                                    <?php echo $receita['nota']?>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-5" >
                                    <?php echo '<img src="img/receitas/'.$receita['foto'].'" class="img-thumbnail">';  ?>
                                    
                                </div>
                                <div class="col-7">
                                <p><?php echo $receita['descricao']?></p>
                                </div>
                            </div>
                            <div class="row align-items-center" >
                                <div class="col-9">
                                    <?php echo $receita['num_comentarios']?> comentário(s)
                                </div>
                                <div class="col-3">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <p> <?php echo $receita['nome_autor']?> </p>
                                        </div>
                                        <div class="col-6">
                                            <?php echo '<img src="img/usuarios/'.$receita['foto_autor'].'" class="rounded-circle" style="height:40px">'; ?>                                
                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Comentário -->
                            <?php
                                

                                $sql = "select 
                                            Autor.nome, 
                                            Autor.foto, 
                                            Comentario.titulo, 
                                            Comentario.texto, 
                                            Comentario.avaliacoes_positivas, 
                                            Comentario.avaliacoes_negativas,
                                            Comentario.codigo 
                                        from Comentario, Autor
                                        where Comentario.codigo_receita = '"
                                        .$receita['codigo'].
                                        "' and Autor.email = Comentario.email_autor;";

                                $resultados = $conector->query($sql);
                                $num_rows = $resultados->num_rows;
                                if($num_rows <= 0){
                                    echo "Nenhum comentário encontrado!";
                                } else {
                                    for($i=0;$i<$num_rows;$i++){
                                        $resultados->data_seek($i);
                                        $row = $resultados->fetch_assoc();
                                       
                            ?>
                            <div class="row align-items-center p-3" >
                                <div class="col-3">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <p> <?php echo $row['nome'] ?> </p>
                                        </div>
                                        <div class="col-6">  
                                            <?php echo '<img src="img/usuarios/'.$row['foto'].'" class="rounded-circle" style="height:40px">'  ?>                              
                                             
                                        </div>
                                    </div>                                 
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <?php echo $row['titulo'] ?>
                                    </div>
                                    <div class="row align-items-center">
                                        <?php echo $row['texto'] ?>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            
                                            <?php echo '<a class="btn" href="atualiza-comentario?codigo='. 
                                            $row['codigo'].'&curtir=true">'?>
                                                <img src="img/icon/hand-thumbs-up.svg" alt="Curtir">
                                                <?php echo $row['avaliacoes_positivas'] ?>
                                            </a>
                                        </div>
                                        <div class="col-6">                                
                                        <?php echo '<a class="btn" href="atualiza-comentario?codigo='. 
                                            $row['codigo'].'&curtir=false">'?>    
                                                <img src="img/icon/hand-thumbs-down.svg" alt="Descurtir">
                                                <?php echo $row['avaliacoes_negativas'] ?>
                                            </a>
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                            <?php  
                                    }
                                }

                            ?>
                            <!-- Novo Comentário -->
                            <form method="post" action="novo-comentario">
                                <div class="row align-items-center p-3" >
                                    <div class="col-3">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <p> João </p>
                                            </div>
                                            <div class="col-6">                                
                                                <img src="img/usuarios/j.jpg" class="rounded-circle" style="height:40px"> 
                                            </div>
                                        </div>                                 
                                    </div>
                                
                                    <div class="col-6">
                                        <div class="row align-items-center p-1">
                                            <input type="text" name="titulo" placeholder="Insira um título"/>
                                        </div>
                                        <div class="row align-items-center p-1">
                                            <input type="text" name="texto" placeholder="Insira um comentário"/>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <input class='btn btn-primary' name='comentar' type="submit" value="Comentar"/>
                                    </div>
                                
                                </div>
                            </form>                           
                        </div>
                    </div>
                    
                </div>
                <?php
                        }
                    }

                    $conector->close();
                ?>
            </div>                        
        </div>
    </div>
</body>
</html>