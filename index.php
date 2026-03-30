<?php
   include "head.php";
   include "nav.php";
?>

<body class="bg-light">

<div class="container">
    
    <div class="mt-4">
       <?php
            require_once 'functions.php'; // importa o arquivo de funções

            $ativos = ["IVVB11", "BIVB39", "HASH11", "IBIT39", "BBAS3",
                    "MXRF11", "CPTS11", "XPML11", "HGLG11", "JURO11",
                    "CRAA11", "KNCR11", "BTLG11"];

            $api_token = "ik2fd2kcoDtJ3an4mVTWNy";

            $resultados = buscarCotacoes($ativos, $api_token); // chama a função
        ?>

        <h4>Cotações</h4>

        <table class="table table-hover bg-white shadow-sm">
            <thead class="table-dark">
                <tr style="background-color: #f2f2f2;">
                    <th>Ações</th>
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
        </table>
    </div>
</div>

</body>
<?php
   include "baseboard.php";
?>