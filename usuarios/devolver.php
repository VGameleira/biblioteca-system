<?php
require '../conexao.php';
session_start();

if(!isset($_SESSION['usuario'])){
    header("location:../index.php");
    exit;
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("location: listar.php");
    exit;
}

$id_aluguel = intval($_GET['id']);

try{
    // Iniciar transação
    $pdo->beginTransaction();
    
    // Buscar informações do aluguel
    $sql = "SELECT id_livro FROM alugueis WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_aluguel]);
    $aluguel = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$aluguel){
        header("location: listar.php");
        exit;
    }
    
    // Marcar aluguel como devolvido
    $sql = "UPDATE alugueis SET devolvido = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_aluguel]);
    
    // Marcar livro como disponível novamente
    $sql = "UPDATE livros SET disponivel = 1 WHERE id = :id_livro";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_livro' => $aluguel['id_livro']]);
    
    $pdo->commit();
    
    header("location: listar.php");
    exit;
    
}catch(PDOException $e){
    $pdo->rollBack();
    die("Erro ao devolver livro: " . $e->getMessage());
}
?>