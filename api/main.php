<?php
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    $cep = $data->cep;
    $qnt = $data->qnt;

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://portal.kangu.com.br/tms/transporte/simular",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n  \"cepOrigem\": \"82810410\",\n  \"cepDestino\": \"$cep\",\n  \"vlrMerc\": 279.00,\n  \"pesoMerc\": 0,\n  \"volumes\": [\n    {\n      \"peso\": 3,\n      \"altura\": 20,\n      \"largura\": 17,\n      \"comprimento\": 27,\n      \"valor\": 279.0,\n      \"quantidade\": 1\n    }\n  ],\n  \"produtos\": [\n    {\n      \"peso\": 3,\n      \"altura\": 20,\n      \"largura\": 17,\n      \"comprimento\": 27,\n      \"valor\": 279.0,\n      \"quantidade\": $qnt\n    }\n  ],\n  \"servicos\": [\n    \"E\"\n  ],\n\t\"ordenar\":\"preco\"\n}",
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "token: 9efa8f7560cd139f145622a9426b9fd9"
    ],
    ]);

    $response = curl_exec($curl);
    $data = json_decode($response,true);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } 

    try {
        $myObj = new stdClass();
        $myObj->valor = $data[0]["vlrFrete"];
        $myObj->prazo = $data[0]["prazoEnt"];
        echo json_encode($myObj);
    }
    catch (Exception $e) {
        $myObj = new stdClass();
        $myObj->valor = "Cep Não encotrado.";
        echo json_encode($myObj);
    }

  


  ?>