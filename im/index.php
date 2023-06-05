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



            ganjil:
            $addcart = curl("https://api.im2019.com/api/cart/add",'{"productId":"35","cartType":"Custom","cartNum":1,"new":1,"uniqueId":""}',$token);
            if(strpos($addcart,'"ok"')){
                $responen = json_decode($addcart);
                $cartId = $responen->data->cartId;
                echo  color('green',"[" . date("H:i:s") . "] ")."ID : $cartId\n";
                $confirm = curl("https://api.im2019.com/api/order/confirm",'{"cartId":"'.$cartId.'"}',$token);
                $kodetrx = json_decode($confirm)->data->orderKey;
                $createorder = curl("https://api.im2019.com/api/order/create_new/$kodetrx",'{"real_name":"","phone":"","useIntegral":0,"couponId":0,"payType":"yue","pinkId":0,"seckill_id":0,"combinationId":0,"bargainId":0,"from":"weixinh5","mark":"","shipping_type":1}',$token);
                if(strpos($createorder,'"Pembayaran berhasil"')){
                    echo  color('green',"[" . date("H:i:s") . "] ")."Pembayaran ganjil berhasil\n";
                }else{
                    echo  color('red',"[" . date("H:i:s") . "] ")."Pembayaran ganjil gagal\n";
                    goto genap;
                }
                $orderIdfinal = json_decode($createorder)->data->result->orderId;
                $trxganjil = curl("https://api.im2019.com/api/guess_odd/saveOrder",'{"order_id":"'.$orderIdfinal.'","guess":1}',$token);
            }else{
                echo  color('red',"[" . date("H:i:s") . "] ")."ID : gagal dibuat\n";

            }
            sleep(4);
            genap:
            $addcarts = curl("https://api.im2019.com/api/cart/add",'{"productId":"35","cartType":"Custom","cartNum":1,"new":1,"uniqueId":""}',$token);
            $responens = json_decode($addcarts);
            if(strpos($addcart,'"ok"')){
                $cartIds = $responens->data->cartId;
                // print_r($cartIds);
                $confirms = curl("https://api.im2019.com/api/order/confirm",'{"cartId":"'.$cartIds.'"}',$token);
                $kodetrxs = json_decode($confirms)->data->orderKey;
                $createorders = curl("https://api.im2019.com/api/order/create_new/$kodetrxs",'{"real_name":"","phone":"","useIntegral":0,"couponId":0,"payType":"yue","pinkId":0,"seckill_id":0,"combinationId":0,"bargainId":0,"from":"weixinh5","mark":"","shipping_type":1}',$token);
                if(strpos($createorders,'"Pembayaran berhasil"')){
                    echo  color('green',"[" . date("H:i:s") . "] ")."Pembayaran genap berhasil\n";
                }else{
                    echo  color('red',"[" . date("H:i:s") . "] ")."Pembayaran genap gagal\n";
                    goto genap;
                }
                $orderIdfinals = json_decode($createorders)->data->result->orderId;
                $trxgenap = curl("https://api.im2019.com/api/guess_odd/saveOrder",'{"order_id":"'.$orderIdfinals.'","guess":0}',$token);
            }else{
                echo  color('red',"[" . date("H:i:s") . "] ")."ID : gagal dibuat\n";

            }
            $listtrx = curl("https://api.im2019.com/api/order/list?page=1&limit=20&type=1",null,$token);
            $respone = json_decode($listtrx);
            $timeopen = $respone->data[0]->_game_open_time;
            $parsing = explode(" ",$timeopen);
            echo  color('green',"[" . date("H:i:s") . "] ")."Menunggu Result\n";
            ulang:
            $timeopentombok = $parsing[1];
            if($timeopentombok == date("H:i:s")){
                sleep(8);
                $listtrxs = curl("https://api.im2019.com/api/order/list?page=1&limit=20&type=1",null,$token);
                $response = json_decode($listtrxs);
                foreach ($response->data as $key){
                    if($key->_game_state === 'Promosi sukses'){
                        $claimreward = curl("https://api.im2019.com/api/order/game_refund",'{"order_id":"'.$key->order_id.'"}',$token);
                        echo  color('green',"[" . date("H:i:s") . "] ")."trx Id : $key->order_id [ status : Promosi sukses ]\n";
                    
                    }
                    if($key->_game_state === 'Promosi gagal'){
                        $claimreward = curl("https://api.im2019.com/api/order/game_integral",'{"order_id":"'.$key->order_id.'"}',$token);
                        echo  color('green',"[" . date("H:i:s") . "] ")."trx Id : $key->order_id [ status : Promosi gagal ]\n"; 

                    }

                    
                    }
                    sleep(15);
                }
                else{
                    // echo "Belum ditemukan \n";
                    // sleep(2);
                    goto ulang;
                }
         
            
        }else{
            echo  color('red',"[" . date("H:i:s") . "] ")."Token Tidak Valid..\n";

        }  
        
    }
}