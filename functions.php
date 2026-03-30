<?php
// funcoes.php

// functions.php

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
?>