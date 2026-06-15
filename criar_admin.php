<?php
/**
 * Script para criar usuário administrador
 * Após criar o admin, faça login em index.php
 */

require_once 'config.php';

$mensagem = "";
$tipo_mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagem = "Preencha todos os campos!";
        $tipo_mensagem = "erro";
    } elseif (strlen($senha) < 6) {
        $mensagem = "Senha deve ter no mínimo 6 caracteres!";
        $tipo_mensagem = "erro";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Email inválido!";
        $tipo_mensagem = "erro";
    } else {
        try {
            // Verificar se já existe
            $sql = "SELECT id FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            if ($stmt->fetch()) {
                $mensagem = "Este email já está cadastrado!";
                $tipo_mensagem = "erro";
            } else {
                // Criar hash da senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                // Inserir admin
                $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, 'admin')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senha_hash
                ]);
                
                $mensagem = "✓ Administrador criado com sucesso!";
                $tipo_mensagem = "sucesso";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao criar administrador: " . $e->getMessage();
            $tipo_mensagem = "erro";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Administrador - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 20px;
        }
        
        .admin-header h1 {
            margin: 0;
            font-size: 32px;
        }
        
        .admin-header p {
            margin: 10px 0 0;
            color: #6c757d;
            font-size: 15px;
        }
        
        .admin-icon {
            font-size: 64px;
            margin-bottom: 15px;
            display: block;
        }
        
        .admin-info {
            background: linear-gradient(135deg, #e7f3ff, #d1e7ff);
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: var(--radius);
            margin-bottom: 30px;
            color: #084298;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .admin-info strong {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
        }
        
        .admin-success {
            text-align: center;
            padding: 40px 20px;
        }
        
        .admin-success .sucesso {
            font-size: 18px;
            margin-bottom: 30px;
            padding: 20px;
        }
        
        .admin-success-icon {
            font-size: 80px;
            margin: 30px 0;
            animation: bounce 0.6s ease;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .admin-success-details {
            background: var(--light);
            padding: 25px;
            border-radius: var(--radius);
            margin: 30px 0;
            border: 2px solid var(--border);
            text-align: left;
        }
        
        .admin-success-details p {
            margin: 12px 0;
            font-size: 14px;
            line-height: 1.8;
        }
        
        .admin-success-details strong {
            color: var(--primary);
            font-weight: 700;
        }
        
        .admin-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .admin-actions .btn {
            flex: 1;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php if ($tipo_mensagem === 'sucesso'): ?>
            <!-- SUCESSO -->
            <div class="admin-success">
                <div class="admin-success-icon">✅</div>
                
                <h1 style="color: #198754; margin-bottom: 10px;">Administrador Criado!</h1>
                <p style="color: #6c757d; margin-bottom: 30px; font-size: 15px;">
                    Agora você pode fazer login no sistema com suas credenciais.
                </p>
                
                <div class="admin-success-details">
                    <p>
                        <strong>📧 Email:</strong><br>
                        <?= sanitize_input($email) ?>
                    </p>
                    <p>
                        <strong>🔒 Senha:</strong><br>
                        <em>A senha que você acabou de digitar</em>
                    </p>
                    <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border); color: #dc3545; font-weight: 700;">
                        ⚠️ Guarde bem essas informações! Você precisará delas para fazer login.
                    </p>
                </div>
                
                <div class="admin-actions">
                    <a href="index.php" class="btn">🔐 Fazer Login</a>
                </div>
            </div>
        
        <?php else: ?>
            <!-- FORMULÁRIO -->
            <div class="admin-header">
                <span class="admin-icon">👑</span>
                <h1>Criar Administrador</h1>
                <p>Configure a conta do primeiro administrador do sistema</p>
            </div>
            
            <?php if (!empty($mensagem)): ?>
                <div class="<?= $tipo_mensagem ?>">
                    <?= sanitize_input($mensagem) ?>
                </div>
            <?php endif; ?>
            
            <div class="admin-info">
                <strong>ℹ️ Primeira Vez Aqui?</strong>
                Você está acessando o Sistema de Biblioteca pela primeira vez. 
                Por segurança, é necessário criar uma conta de administrador antes de prosseguir.
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label for="nome">👤 Nome Completo *</label>
                    <input type="text" 
                           id="nome" 
                           name="nome" 
                           placeholder="Seu nome completo"
                           value="<?= isset($nome) ? sanitize_input($nome) : '' ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">📧 Email *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           placeholder="seu@email.com"
                           value="<?= isset($email) ? sanitize_input($email) : '' ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="senha">🔒 Senha *</label>
                    <input type="password" 
                           id="senha" 
                           name="senha" 
                           placeholder="Mínimo 6 caracteres"
                           required>
                    <small>Escolha uma senha forte com no mínimo 6 caracteres</small>
                </div>
                
                <button type="submit" class="btn">✓ Criar Administrador</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>