<?php
include "curl.php";
echo "Thanks : Pandu Aji ft Muhammad Ikhsan Aprilyadi\n";
echo "Auto Register Gojek & Auto Claim Vocher\n\n";
sleep(1);
define("Uniqueid",string(16));

function regis()
{
    echo "\n[+] Nomor HP 1 / 62 : ";
    $number       = trim(fgets(STDIN));
    $nam          = nama();
    $nama         = explode(" ",$nam);
    $namadepan    = $nama[0];
    $namabelakang = $nama[1];
    $rand         = rand(0,999);
    $user         = $namadepan.$rand;
    $email        = $user."@gmail.com";
    $headers1     = array(
                        "X-Appversion: 3.33.1",
                        "X-Uniqueid: ".Uniqueid,
                        "X-Platform: Android",
                        "X-Appid: com.gojek.app",
                        "Accept: application/json",
                        "X-Session-Id: 346527b1-73ee-4e8a-bf2b-97b6f18ab9e4",
                        "D1: 51:35:12:20:97:58:97:D1:76:21:4A:16:B1:DD:53:E8:6B:7F:82:0E:8C:E9:31:8C:6E:17:C5:8C:EB:7F:7F:35",
                        "X-PhoneModel: xiaomi,Redmi 6",
                        "X-Pushtokentype: FCM",
                        "X-DeviceOS: Android,8.1.0",
                        "User-Uuid: ",
                        "X-Devicetoken: fjlOA9ocjOQ:APA91bEwZU6OXIoWzyIKq35k9c7yX8OJZVHbxOhtRhSaOJ-sgDxa2GppI3RqokfYzMvZvYH9cgDrM6a74x5KCNFpWF6q53iu6iIBJvPul7g8hWsYRhmJp9a-ZSzC3IBgaifgO1_QThVY",
                        "Authorization: Bearer",
                        "Accept-Language: id-ID",
                        "X-User-Locale: id_ID",
                        "X-Location: 31.24916,121.4878983",
                        "X-Location-Accuracy: 3.9",
                        "X-M1: 1:__4d102b720e0b4c2f8ac6a6c697bff417,2:48331203,3:1559436825749-3935752393102334594,4:9434,5:|2400|2,6:UNKNOWN,7:\"jrtq051350\",8:720x1280,9:passive,gps,10:0,11:UNKNOWN",
                        "Content-Type: application/json; charset=UTF-8",
                        "Host: api.gojekapi.com",
                        "User-Agent: okhttp/3.12.1",
                    );
    $sendotp      = curl("https://api.gojekapi.com/v5/customers",'{"email":"'.$email.'","name":"'.$namadepan.' '.$namabelakang.'","phone":"'.$number.'","signed_up_country":"ID"}',$headers1);

    if (strpos($sendotp,"Masukkan kode yang kami SMS")) {
        echo "[+] Kode verifikasi sudah dikirim";
        sleep(1);
        $otptoken = fetch_value($sendotp,'"otp_token":"','"');
        echo "\n[+] Otp : ";
        $otp      = trim(fgets(STDIN));
        $verifotp = curl("https://api.gojekapi.com/v5/customers/phone/verify",
                         '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp.',"otp_token":"'.$otptoken.'"}}',$headers1);

        if (strpos($verifotp,'"access_token"')) {
            echo "[+] Kode verifikasi benar";
            sleep(1);
            echo "\n[+] Proses Suntik Promo";

            for ($a = 1; $a <= 3; $a++) {
                sleep(1);
                echo ".";
            }

            $result1  = fetch_value($verifotp,'"access_token":"','"');
            $headers2 = array(
                            "X-Appversion: 3.33.1",
                            "X-Uniqueid: ".Uniqueid,
                            "X-Platform: Android",
                            "X-Appid: com.gojek.app",
                            "Accept: application/json",
                            "X-Session-Id: 346527b1-73ee-4e8a-bf2b-97b6f18ab9e4",
                            "D1: 51:35:12:20:97:58:97:D1:76:21:4A:16:B1:DD:53:E8:6B:7F:82:0E:8C:E9:31:8C:6E:17:C5:8C:EB:7F:7F:35",
                            "X-PhoneModel: xiaomi,Redmi 6",
                            "X-Pushtokentype: FCM",
                            "X-DeviceOS: Android,8.1.0",
                            "User-Uuid: ",
                            "X-Devicetoken: fjlOA9ocjOQ:APA91bEwZU6OXIoWzyIKq35k9c7yX8OJZVHbxOhtRhSaOJ-sgDxa2GppI3RqokfYzMvZvYH9cgDrM6a74x5KCNFpWF6q53iu6iIBJvPul7g8hWsYRhmJp9a-ZSzC3IBgaifgO1_QThVY",
                            "Authorization: Bearer ".$result1,
                            "Accept-Language: id-ID",
                            "X-User-Locale: id_ID",
                            "X-Location: 31.24916,121.4878983",
                            "X-Location-Accuracy: 3.9",
                            "X-M1: 1:__4d102b720e0b4c2f8ac6a6c697bff417,2:48331203,3:1559436825749-3935752393102334594,4:9434,5:|2400|2,6:UNKNOWN,7:\"jrtq051350\",8:720x1280,9:passive,gps,10:0,11:UNKNOWN",
                            "Content-Type: application/json; charset=UTF-8",
                            "Host: api.gojekapi.com",
                            "User-Agent: okhttp/3.12.1",
                        );
            $promo    = curl("https://api.gojekapi.com/go-promotions/v1/promotions/enrollments",
                             '{"promo_code":"GOFOODNASGOR07"}',$headers2);

            if (strpos($promo,"Promo kamu sudah bisa dipakai")) {
                $message = fetch_value($promo,'"message":"','"');

                echo "\n[+] Promo kamu sudah bisa dipakai. Yuk, cobain!";
                sleep(1);
                echo "\n[+] Mau suntik rp 1 (y/n) : ";

                $rp = trim(fgets(STDIN));

                if ($rp == "y") {
                    echo "[+] Cie Kena Tipu";
                } else {
                    die();
                }
            }
        }
    }
}

echo regis();
echo "\n";
?>
