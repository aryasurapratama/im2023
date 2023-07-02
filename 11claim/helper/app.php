<?php
function curl($url ,$body = null,$token = null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'authority: api.im2019.com',
        'accept: application/json, text/plain, */*',
        'accept-language: en-US,en;q=0.9',
        'authori-zation: Bearer '.$token,
        'content-type: application/json;charset=UTF-8',
        'origin: https://www.im2019.com',
        'referer: https://www.im2019.com/',
        'sec-ch-ua: "Chromium";v="110", "Not A(Brand";v="24", "Google Chrome";v="110"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-site',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',
        'accept-encoding: gzip',
    ]);
    if($body == null){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    }else{
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    $response = curl_exec($ch);
    return $response;
    curl_close($ch);
}
function save($data, $file) 
    {
        $handle = fopen($file, 'a+');
        fwrite($handle, $data);
        fclose($handle);
    }
function color($color = "default" , $text)
    {
        $arrayColor = array(
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
?>