<?php
//conexão com o banco de dados
try {
    $pdo = new PDO("mysql:dbname=CRUDPDO; host=localhost", "root", "root");
    //dbname
    //host
    //usuario
    //senha
} catch (PDOException $e) {
    echo "Erro com o banco de dados: " . $e->getMessage();
} catch(Exception $e) {
    echo "Erro genérico: " . $e->getMessage();
}

//---------------------------------INSERT---------------------------------


//1ª forma - substituição de parametros
//$res = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) values(:n, :t, :e)");
//$res->bindValue(":n","Mirian");//aceita variaveis, funções
//$res->bindValue(":t","123321123");
//$res->bindValue(":e","teste@gmail.com");
//$res->execute();
//$nome = "Mirian";
//$res->bindparam(":n",$nome);//n aceita valor passado diretamente, aceita somente variaveis 

//2ª forma - passar diretamente 
//$pdo->query("INSERT INTO pessoa(nome, telefone, email) values('igor', '145789235', 'igor@gmail.com')");



//---------------------------------------DELETE E UPDATE ----------------------------------------------

// Método prepare():
//$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id= :id");
//$id = 3;
//$cmd->bindValue(":id", $id);
//$cmd->execute();

// OU

// Método query():
//$res = $pdo->query("DELETE FROM pessoa WHERE id= '1'");

//---------------------------------------SELECT--------------------------------------------------

$cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
$cmd->bindValue(":id", 4);
$cmd->execute();
$res = $cmd->fetch(PDO::FETCH_ASSOC); // ----> unica linha
//ou
//$cmd->fetchALL(); // ---> mais de um registro do banco de dados;
foreach ($res as $key => $value) {
    echo $key.": ".$value."<br>"; //mostrar a chave, ou nome da variavel, juntamente com o valor
}
?>