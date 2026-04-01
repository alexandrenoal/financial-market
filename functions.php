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

// Sua chave da API
$token = "ik2fd2kcoDtJ3an4mVTWNy";

// Verifica se o usuário pesquisou algo
if (isset($_GET['ticker'])) {
    $ativo = strtoupper(trim($_GET['ticker'])); // Limpa e coloca em maiúsculo
    
    // URL da Brapi para um único ativo
    $url = "https://brapi.dev/api/quote/{$ativo}?token={$token}";

    // Faz a requisição (usando file_get_contents ou cURL)
    $response = file_get_contents($url);
    $dados = json_decode($response, true);

    if (isset($dados['results'][0])) {
        $resultado = $dados['results'][0];
        echo "<h5>Resultado para: " . $resultado['symbol'] . "</h5>";
        echo "Preço Atual: R$ " . $resultado['regularMarketPrice'];
        echo "<br>Variação: " . $resultado['regularMarketChangePercent'] . "%";
    } else {
        echo "<p>Ativo não encontrado. Verifique o código e tente novamente.</p>";
    }
}

?>

