<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $selected_date = $_POST["selected_date"];

    
    // $api_key = "0927a7f4e3f475dc35574ce435faddd2";

    
    // $api_url = "https://api.exchangeratesapi.io/v1?$selected_date/access_key=$api_key";

    
    $curl = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $api_url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://currency-conversion-and-exchange-rates.p.rapidapi.com/$selected_date?base=TRY",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: currency-conversion-and-exchange-rates.p.rapidapi.com",
            "X-RapidAPI-Key: bca50605a4mshc6af7f2c99ce0bfp1c5d6cjsn0c0a1c54c50e"
        ],
    ]);



    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // echo $response;
    }
    // if (curl_error($ch)) {
    //     echo 'Error:' . curl_error($ch);
    // }
    // curl_close($ch);

    $data = json_decode($response, true);

    if ($data && isset($data["rates"])) {
        
        $table = "<table border='1'>
                    <tr>
                        <th>Döviz Birimi</th>
                        <th>Kur Değeri</th>
                    </tr>";

        foreach ($data["rates"] as $currency => $rate) {
            $table .= "<tr>
                        <td>$currency</td>
                        <td>$rate</td>
                      </tr>";
        }

        $table .= "</table>";
    } else {
        $table = "Veri alınamadı. Lütfen tarihi kontrol edin ve tekrar deneyin.";
    }

    
    echo $table;
}
?>