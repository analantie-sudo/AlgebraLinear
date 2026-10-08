<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Controller\ControladorMatriz;

$resultado = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $op = $_POST['operacao'] ?? '';
        
        $a = json_decode(
            $_POST['matriz_a'] ?? '', 
            true, 
            512, 
            JSON_THROW_ON_ERROR
        );
        
        $b = !empty($_POST['matriz_b']) 
            ? json_decode($_POST['matriz_b'], true, 512, JSON_THROW_ON_ERROR) 
            : null;

        $resultado = (new ControladorMatriz())->executar($op, $a, $b);
    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Operações com Matrizes</title>
    <link rel="stylesheet" href="../templates/css/global.css">
</head>
<body>
    <main class="container">
        <a href="../index.php">Voltar</a>
        <h1>Operações com Matrizes</h1>

        <form method="post">
            <label>Operação</label>
            <select name="operacao">
                <option value="soma">Soma</option>
                <option value="subtracao">Subtração</option>
                <option value="multiplicacao">Multiplicação</option>
                <option value="transposta">Transposta</option>
                <option value="determinante">Determinante</option>
                <option value="inversa">Inversa</option>
            </select>

            <label>Matriz A (JSON)</label>
            <textarea name="matriz_a">[[1,2],[3,4]]</textarea>

            <label>Matriz B (JSON, se necessária)</label>
            <textarea name="matriz_b">[[5,6],[7,8]]</textarea>

            <button>Calcular</button>
        </form>

        <?php if ($erro): ?>
            <div class="erro">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?php if ($resultado !== null): ?>
            <h2>Resultado</h2>
            <pre><?= htmlspecialchars(json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        <?php endif; ?>
    </main>
</body>
</html>
