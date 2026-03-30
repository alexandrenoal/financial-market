<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Dashboard Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>



<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Dashboard finance </span><span class="dinheiro"></span>
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
       <?php
require_once 'functions.php'; // importa o arquivo de funções

$ativos = ["IVVB11", "BIVB39", "HASH11", "IBIT39", "PETR4", "BBAS3",
           "MXRF11", "CPTS11", "XPML11", "HGLG11", "JURO11",
           "CRAA11", "KNCR11", "BTLG11"];

$api_token = "ik2fd2kcoDtJ3an4mVTWNy";

$resultados = buscarCotacoes($ativos, $api_token); // chama a função
?>

<h4>Cotações</h4>

<table class="table table-hover bg-white shadow-sm">
    <thead class="table-dark">
        <tr style="background-color: #f2f2f2;">
            <th>Ticker</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Variação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultados as $ativo): ?>
        <tr>
          <td><?= htmlspecialchars($ativo['symbol']) ?></td>
            <td><?= htmlspecialchars($ativo['shortName']) ?></td>
            <td>R$ <?= number_format($ativo['regularMarketPrice'], 2, ',', '.') ?></td>            
            <td style="color: <?php echo $ativo['regularMarketChangePercent'] >= 0 ? 'green' : 'red'; ?>">
                            <?php echo number_format($ativo['regularMarketChangePercent'], 2, ',', '.'); ?>%
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>