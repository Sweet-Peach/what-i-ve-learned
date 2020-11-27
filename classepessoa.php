<?php
//criando classe
Class Pessoa {

    private $pdo;
    //criar 6 funções
    //1 função - conexão com o banco de dados
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . "; host=".  $host, $user, $senha);
            //dbname
            //host
            //usuario
            //senha
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
        } catch(Exception $e) {
            echo "Erro genérico: " . $e->getMessage();
            exit();
        }
    }

    //função para buscar todos os dados no banco de dados
    //buscar os dados e colocar no canto direito da tela
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa order by id DESC");
        $res = $cmd->fetchALL(PDO::FETCH_ASSOC);
        return $res;
    }

    //função para cadastrar pessoas
    public function cadastrarPessoa($nome, $telefone, $email){
        //antes de cadastrar, verificar se ja esta cadastrado
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindvalue(":e", $email);
        $cmd->execute();
        
        if($cmd->rowCount() > 0)//email já existe no banco de dados
        {
            return false;
        }
        else //se nao foi cadastrado
        {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
        }

    }


    //função para excluir pessoa
    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }

    //função para buscar dados de uma pessoa - atualizar pt1
    public function buscardadosPessoa($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    //função para atualizar os dados - atualizar pt2
    public function atualizardados($id, $nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindvalue(":e", $email);
        $cmd->execute();
        
        if($cmd->rowCount() > 0)//email já existe no banco de dados
        {
            return false;
        }
        else //se nao foi cadastrado
        {
            $cmd = $this->pdo->prepare("UPDATE pessoa SET nome= :n, telefone= :t, email= :e WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute(); 
            return true;
        }
    }

}

?> 