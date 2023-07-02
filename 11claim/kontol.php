<?php
date_default_timezone_set("Asia/Jakarta");
require('./helper/app.php');
echo color('green',"[" . date("H:i:s") . "] ")."Input File example (token.txt) : ";
$file = trim(fgets(STDIN));
for ($i=0; $i <500 ; $i++) { 
    echo"\n";
    $list = explode("\n", str_replace("\r", "", file_get_contents($file)));
    foreach ($list as $key => $token) {
    $cekuser = curl('https://api.im2019.com/api/userinfo',null, $token);
    if(strpos($cekuser,'"ok"')){
        echo  color('green',"[" . date("H:i:s") . "] ")."Token Valid..\n";
        $account = json_decode($cekuser)->data->nickname;
        $saldo = json_decode($cekuser)->data->now_money;

        echo  color('green',"[" . date("H:i:s") . "] ")."Data Account :\n";
        echo  color('green',"[" . date("H:i:s") . "] ")."Nick name : $account\n";
        echo  color('green',"[" . date("H:i:s") . "] ")."saldo : $saldo\n";

        $codeclaim = "asu" ;

        $claimcode = curl('https://api.im2019.com/api/activity/active_code', '{"verification_code":"' . $codeclaim . '"}', $token);
        echo $claimcode;

            
         
            
        }else{
            echo  color('red',"[" . date("H:i:s") . "] ")."Token Tidak Valid..\n";

        }  
        
    }
}
