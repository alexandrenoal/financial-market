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
// 1. Configuração: Lista de ativos que você deseja
$ativos = ["IVVB11", "BIVB39","HASH11", "IBIT39","PETR4", "BBAS3", "MXRF11" ,"CPTS11", "XPML11", "HGLG11", "JURO11", "CRAA11", "KNCR11", "BTLG11" ]; 
$api_token = "ik2fd2kcoDtJ3an4mVTWNy"; 

$resultados = []; // Array para guardar os dados de cada chamada

// 2. O Loop: Faz uma requisição separada para cada ativo
foreach ($ativos as $ticker) {
    $url = "https://brapi.dev/api/quote/{$ticker}?token={$api_token}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // 3. Verifica se a resposta foi válida (Código 200) e guarda no array
    if ($http_code == 200) {
        $dados_temp = json_decode($response, true);
        if (isset($dados_temp['results'][0])) {
            $resultados[] = $dados_temp['results'][0];
        }
    }
}
?>

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
        <h4>Atualizações</h4>
        <?php if (!empty($resultados)): ?>
        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
                <tr style="background-color: #f2f2f2;">
                    <th>Ativo</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Variação</th>
                </tr>
            </thead>
                <?php foreach ($resultados as $info): ?>
                    <tr>
                        <td><strong><?php echo $info['symbol']; ?></strong></td>
                        <td><?php echo $info['longName'] ?? 'N/A'; ?></td>
                        <td>R$ <?php echo number_format($info['regularMarketPrice'], 2, ',', '.'); ?></td>
                        <td style="color: <?php echo $info['regularMarketChangePercent'] >= 0 ? 'green' : 'red'; ?>">
                            <?php echo number_format($info['regularMarketChangePercent'], 2, ',', '.'); ?>%
                        </td>
                    </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum dado encontrado. Verifique sua conexão ou o limite da API.</p>
    <?php endif; ?>
    </div>
</div>


    
</body>
</html>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>