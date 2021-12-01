#DML
# create, alter, drop

create schema exemplo_receitas;
use exemplo_receitas;

create table Autor(
	email varchar(45) primary key,
    nome varchar(45) not null,
    foto varchar(90)
);

create table Receita(
	codigo int primary key auto_increment,
    titulo varchar(45) not null,
    descricao text,
    foto varchar(90),
    nota decimal(3,2) default 0,
    email_autor varchar(45) not null,
    foreign key (email_autor) references Autor(email)
);

create table Comentario(
	codigo int primary key auto_increment,
    titulo varchar(45) not null,
    texto varchar(144) not null,
    avaliacoes_positivas int default 0,
    avaliacoes_negativas int default 0,
    email_autor varchar(45) not null,
    codigo_receita int not null,
    foreign key (email_autor) references Autor(email),
    foreign key (codigo_receita) references Receita(codigo)
);

#DML
# insert, update, delete

insert into Autor values("joao@g.com", "Joao", "j.jpg");
insert into Autor values("ana@g.com", "Ana", "a.jpg");
insert into Autor values("maria@g.com", "Maria", "m.jpg");

insert into Receita (titulo, descricao, email_autor, foto)
values ("Bolo de Banana",	"Melhor bolo",	"joao@g.com", "bolo.jpg");

insert into Receita (titulo, descricao, email_autor, foto)
values ("Arroz doce",	"Doce caseiro muito bom.",	"ana@g.com", "arrozdoce.jpg");

insert into Comentario (titulo, texto, email_autor, codigo_receita) 
values (
	"Bolo de Banana muito ruim",
    "Fui fazer e ficou horrível. Tem que melhorar essa receita...",
    "ana@g.com",
    "1"
);

insert into Comentario (titulo, texto, email_autor, codigo_receita) 
values (
	"Bolo de Banana muito bom",
    "Fui fazer e ficou ótimo. Não tem nada que melhorar nessa receita!",
    "maria@g.com",
    "1"
);

insert into Comentario (titulo, texto, email_autor, codigo_receita) 
values (
	"Muito doce",
    "Fui fazer a receita e achei muito doce. Recomendo diminuir a quantidade de açúcar",
    "joao@g.com",
    "3"
);

insert into Comentario (titulo, texto, email_autor, codigo_receita) 
values (
	"Canela combina com essa receita",
    "Coloquei canela para finalizar o prato! Ficou muito bom!",
    "maria@g.com",
    "3"
);

insert into Comentario (titulo, texto, email_autor, codigo_receita) 
values (
	"Não coloque cravo!",
    "Coloquei cravo e não gostei...",
    "maria@g.com",
    "3"
);

#Usuário avalia a receita 1 com nota 5
update Receita set nota = (nota + 5)/2 where codigo = 1;

#Usuário avalia a receita 1 com nota 1
update Receita set nota = (nota + 1)/2 where codigo = 1;

#Usuário avalia a receita 3 com nota 1
update Receita set nota = (nota + 1)/2 where codigo = 3;
update Receita set nota = if(nota > 0, (nota + 1)/2, 1) where codigo = 3;
update Receita set nota =
case 
	when nota > 0 then (nota + 1)/2
    when nota < 1 then 1
end 
where codigo = 3;

#Usuário avalia a receita 3 com nota 5
update Receita set nota = (nota + 5)/2 where codigo = 3;
update Receita set nota =
case 
	when nota > 0 then (nota + 5)/2
    when nota < 1 then 5
end 
where codigo = 3;

# Autor maria@g.com clica no botão de deslike do comentário 5
update Comentario set avaliacoes_negativas = avaliacoes_negativas + 1 where codigo = 5;

# maria@g.com clica no botão de like do comentário 5
update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 where codigo = 5 and email_autor != 'maria@g.com';

# joao@g.com clica no botão de like do comentário 5
update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 where codigo = 5 and email_autor != 'joao@g.com';


# maria@g.com deleta o comentário 5
delete from Comentario where codigo = 5 and email_autor = 'maria@g.com';

#DQL
select * from Autor;
select * from Receita;
select * from Comentario;


#listar as informações relevantes dos comentários da receita 3
select * from Comentario, Autor where Autor.email = Comentario.email_autor;

select titulo, texto, avaliacoes_positivas, avaliacoes_negativas 
from Comentario;

select 
	Autor.nome, 
    Autor.foto, 
    Comentario.titulo, 
    Comentario.texto, 
    Comentario.avaliacoes_positivas, 
    Comentario.avaliacoes_negativas 
from Comentario inner join Autor on Autor.email = Comentario.email_autor
where Comentario.codigo_receita = '3';

select 
	Autor.nome, 
    Autor.foto, 
    Comentario.titulo, 
    Comentario.texto, 
    Comentario.avaliacoes_positivas, 
    Comentario.avaliacoes_negativas 
from Comentario, Autor
where Comentario.codigo_receita = '3' and Autor.email = Comentario.email_autor;

#Listar as informações relevantes sobre cada uma das receitas cadastradas no sistema
select 
	Receita.titulo, 
    Receita.nota, 
    Receita.descricao, 
    Receita.foto, 
    Autor.nome, 
    Autor.foto,
    count(*) as num_comentarios 
from Receita inner join Autor
on Autor.email = Receita.email_autor
inner join Comentario 
on Comentario.codigo_receita = Receita.codigo 
group by Comentario.codigo_receita;

select 
	Receita.titulo, 
    Receita.nota, 
    Receita.descricao, 
    Receita.foto, 
    Autor.nome, 
    Autor.foto
from Receita inner join Autor
on Autor.email = Receita.email_autor;

select 
    Comentario.codigo_receita,
    count(*) as num_comentarios 
from Comentario 
group by Comentario.codigo_receita;

#select * from Comentario order by titulo; #Ordena a listagem por título

update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 where codigo = 7 and email_autor != 'ana@g.com';
update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 where codigo = 11 and email_autor != 'ana@g.com';
update Comentario set avaliacoes_positivas = avaliacoes_positivas + 1 where codigo = 12 and email_autor != 'joao@g.com';

# Quantas avaliacoes positivas têm os comentários da autora maria@g.com ?
select sum(avaliacoes_positivas) from Comentario where email_autor = "maria@g.com";


#Mostra o perfil do autor (nome, foto, email e quantidade de comentarios no sistema)
select Autor.nome, Autor.email, Autor.foto, count(*) as comentarios 
from Autor inner join Comentario on Comentario.email_autor = Autor.email group by Autor.email;