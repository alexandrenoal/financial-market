<?php

// functions.php

// Função de consulta do valor das cotações
function buscarCotacoes(array $ativos, string $api_token): array {
    $resultados = [];

    foreach ($ativos as $ticker) {
        $url = "https://brapi.dev/api/quote/{$ticker}?token={$api_token}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $dados_temp = json_decode($response, true);
            if (isset($dados_temp['results'][0])) {
                $resultados[] = $dados_temp['results'][0];
            }
        }
    }

    return $resultados; // <-- retorna em vez de depender de variável global
}

// Consulta de ativo
$token = "ik2fd2kcoDtJ3an4mVTWNy";

if (isset($_GET['ticker'])) {
    $ativo = strtoupper(trim($_GET['ticker'])); 
    
    $url = "https://brapi.dev/api/quote/{$ativo}?token={$token}";
    $response = @file_get_contents($url); // O @ evita exibir erro caso a API falhe
    $dados = json_decode($response, true);

    if (isset($dados['results'][0])) {
        $resultado = $dados['results'][0];
        
        // Exibe os dados de texto
        echo "<h5>Resultado para: " . $resultado['symbol'] . "</h5>";
        echo "Preço Atual: R$ " . $resultado['regularMarketPrice'];
        echo "<br>Variação: " . $resultado['regularMarketChangePercent'] . "%";

        // --- INÍCIO DO CÓDIGO DO GRÁFICO ---
        echo '
        <div id="tradingview_chart" style="height: 400px; margin-top: 20px;"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
          new TradingView.widget({
            "autosize": true,
            "symbol": "BMFBOVESPA:' . $ativo . '",
            "interval": "D",
            "timezone": "America/Sao_Paulo",
            "theme": "light",
            "style": "1",
            "locale": "br",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "container_id": "tradingview_chart"
          });
        </script>';
        // --- FIM DO CÓDIGO DO GRÁFICO ---

    } else {
        echo "<p>Ativo não encontrado. Verifique o código e tente novamente.</p>";
    }
}

?>

