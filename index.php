<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Dashboard Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<?php
// 1. Sua configuração
$ticker = "IVVB11";
$api_token = "ik2fd2kcoDtJ3an4mVTWNy"; // token https://brapi.dev/ 

// 2. Iniciando o cURL (Mais seguro que file_get_contents)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://brapi.dev/api/quote/{$ticker}?token={$api_token}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Importante para o Codespaces não barrar o SSL

$response = curl_exec($ch);
curl_close($ch);

// 3. Transformando o texto da API em um Objeto PHP
$dados = json_decode($response, true);

// 4. Verificando se deu certo antes de exibir
if (isset($dados['results'][0])) {
    $info = $dados['results'][0];
    $preco = $info['regularMarketPrice'];
    $variacao = $info['regularMarketChangePercent'];
    $nome = $info['longName'];
} else {
    $erro = "Não foi possível carregar os dados. Verifique sua chave API.";
}
?>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Dashboard finance</span>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-finance shadow-sm p-3">
                <h6 class="text-muted">Saldo em Carteira</h6>
                <h3>R$ <?php echo number_format(0.0, 2, ',', '.'); ?></h3>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left border-success shadow-sm p-3">
                <h6 class="text-muted">Rendimento Mensal</h6>
                <h3 class="text-success">+ 0%</h3>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Atualizações</h4>
        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Data</th>
                    <th>Ativo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo date('d/m/Y H:i:s'); ?></td>
                    <td><?php echo "$ticker"?></td>
                    <td>R$ <?php echo number_format($preco, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>27/03/2026</td>
                    <td>HASH11</td>
                    <td>R$ 50,00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="container mt-5">
        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php else: ?>
            <div class="card shadow" style="width: 25rem;">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $nome; ?></h6>
                    <h1 class="card-title">R$ <?php echo number_format($preco, 2, ',', '.'); ?></h1>
                    <span class="badge <?php echo $variacao >= 0 ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo number_format($variacao, 2, ',', '.') . '%'; ?>
                    </span>
                    <p class="text-muted mt-3" style="font-size: 0.8rem;">
                        Atualizado em: <?php echo date('d/m/Y H:i:s'); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>