<?php
require_once 'classepessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "root");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gerencias pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <!--colher informações -->
    <?php
    //--------------------------EDITAR-------------------------
    if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
        $id_upd = addslashes($_GET['id_up']);
        if (isset($_POST['telefone'])) //quando a pessoa clicou no botão cadastrar ou no botão atualizar
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if (!empty($nome) && !empty($telefone) && !empty($email)) {
                if (!$p->atualizardados($id_upd, $nome, $telefone, $email)) //checagem pra ver se o email já existe
                {
                    echo "EMAIL JÁ CADASTRADO";
                }
            }
            else{
                echo "PREENCHA TODOS OS CAMPOS";
            }
        }
    }    
    else //-----------------------------CADASTRAR------------------------
    {
        if (isset($_POST['telefone'])) //quando a pessoa clicou no botão cadastrar ou no botão atualizar
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if (!empty($nome) && !empty($telefone) && !empty($email)) {
                if (!$p->cadastrarPessoa($nome, $telefone, $email)) //checagem pra ver se o email já existe
                {
                    echo "EMAIL JÁ CADASTRADO";
                }
            }
            else{
                echo "PREENCHA TODOS OS CAMPOS";
            }
        }
    }
    ?>
    
    <?php
        if (isset($_GET['id_up']))
        {
            $idupdate = addslashes($_GET['id_up']);
            $res = $p->buscardadosPessoa($idupdate);
        }
    ?>

    <section id="esquerda">
    <form method="POST" action="">
    <h2>CADASTRAR PESSOA</h2>
    <label for="nome">Nome: </label>
    <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];} ?>">

    <label for="telefone">Telefone: </label>
    <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?>">

    <label for="email">Email: </label>
    <input type="text" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];} ?>"><br>

    <input type="submit" value="<?php if(isset($res)){echo "ATUALIZAR";}else{echo "CADASTRAR";} ?>">

    </form>
    </section>
 

    <section id="direita">

        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td> 
            </tr> 
            <?php
                $dados = $p->buscarDados();
                if(count($dados) > 0){
                    for ($i=0; $i < count($dados); $i++){
                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v){
                            if ($k != "id"){
                            echo "<td>".$v."</td>";
                            }
                        }
                        ?>
                        
                        <td>
                            <a href="index.php?id_up=<?php echo $dados[$i]['id']?>">EDITAR</a>

                            <a href="index.php?id=<?php echo $dados[$i]['id']?>">EXCLUIR</a>

                        </td>

                        <?php
                        echo "</tr>";
                    }
                }
                else //se o banco esta vazio 
                {
                    echo "Ainda não há pessoas cadastradas!";
                }
            ?>
            </tr>
        </table>
    </section>
</body>
</html>

<?php

if (isset($_GET['id'])) {
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php");
}

?>