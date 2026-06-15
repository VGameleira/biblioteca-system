<?php
require_once '../conexao.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Listar Usuários - Biblioteca</title>
</head>

<body>
    <nav class="menu">
        <div class="dropdown">
            <button class="dropbtn">Usuários</button>
            <div class="dropdown-content">
                <a href="cadastrar.php">Cadastrar Usuário</a>
                <a href="listar.php">Listar Usuários</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn">Livros</button>
            <div class="dropdown-content">
                <a href="../livros/cadastrar.php">Cadastrar Livro</a>
                <a href="../livros/listar.php">Listar Livros</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn">Aluguéis</button>
            <div class="dropdown-content">
                <a href="../aluguel/listar.php">Meus Aluguéis</a>
                <a href="../aluguel/historico.php">Histórico</a>
            </div>
        </div>

        <a href="../logout.php" class="logout">Sair</a>
    </nav>

    <div class="lista-container">
        <h1>Lista de Usuários</h1>
        <table class="tabela-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $sql = "SELECT id, nome, email, tipo FROM usuarios ORDER BY id DESC";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($usuarios) > 0) {
                        foreach ($usuarios as $usuario) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                            echo "<td>" . htmlspecialchars(ucfirst($usuario['tipo'])) . "</td>";
                            echo "<td>";
                            // echo "<a href='editar.php?id=" . $usuario['id'] . "' class='btn-editar'>Editar</a> ";
                            // echo "<a href='excluir.php?id=" . $usuario['id'] . "' class='btn-excluir' onclick=\"return confirm('Deseja realmente excluir este usuário?')\">Excluir</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>Nenhum usuário cadastrado.</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5' style='text-align: center; color: #dc3545;'>Erro ao listar usuários: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="editar.php?id=<?= $u['id'] ?>">Editar</a>
        <a href="excluir.php?id=<?= $u['id'] ?>" onclick="return confirm('Deseja realmente excluir?')"></a>
        <a href="../painel.php" class="btn-voltar">Voltar ao Painel</a>
    </div>
</body>

</html>