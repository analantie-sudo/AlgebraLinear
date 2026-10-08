<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Controller\ControladorSistemaLinear;

$resultado = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $a = json_decode(
            $_POST['coeficientes'] ?? '', 
            true, 
            512, 
            JSON_THROW_ON_ERROR
        );
        
        $b = json_decode(
            $_POST['termos'] ?? '', 
            true, 
            512, 
            JSON_THROW_ON_ERROR
        );

        $resultado = (new ControladorSistemaLinear())->resolver($a, $b);
    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistemas Lineares</title>
    <link rel="stylesheet" href="../templates/css/global.css">
</head>
<body>
    <main class="container">
        <a href="../index.php">Voltar</a>
        <h1>Resolução de Sistemas Lineares</h1>

        <form method="post">
            <label>Matriz de coeficientes (JSON)</label>
            <textarea name="coeficientes">[[2,1],[-1,1]]</textarea>

            <label>Termos independentes (JSON)</label>
            <textarea name="termos">[5,1]</textarea>

            <button>Resolver</button>
        </form>

        <?php if ($erro): ?>
            <div class="erro">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?php if ($resultado !== null): ?>
            <h2>Solução</h2>
            <pre><?= htmlspecialchars(json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        <?php endif; ?>
    </main>
</body>
</html>
