<?php
// URL endpoint login
$loginUrl = 'https://api-srs.ut.ac.id/api-srs-mahasiswa/v1/auth';

// Data login
$loginData = [
    'email' => 'ut-serang@ecampus.ut.ac.id',
    'password' => 'Terbuka132'
];

// Inisialisasi cURL untuk permintaan login
$ch = curl_init();

// Set opsi cURL untuk permintaan login
curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

// Kirim permintaan dan simpan respons
$loginResponse = curl_exec($ch);

// Periksa kesalahan dalam permintaan
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Tutup cURL
curl_close($ch);

// Decode respons JSON
$loginData = json_decode($loginResponse, true);

// Debug respons login
echo "<pre>Login Response:\n";
print_r($loginData);
echo "</pre>";

// Cek apakah decoding berhasil dan token ada
if (json_last_error() === JSON_ERROR_NONE && isset($loginData['token'])) {
    $token = $loginData['token'];
    echo "Login successful. Token: $token\n";
} else {
    echo "Error decoding JSON or no token found: " . json_last_error_msg();
    exit;
}

// URL endpoint API lain yang akan diakses
$apiUrl = 'https://api-srs.ut.ac.id/api-srs-mahasiswa/v1/data-pribadi';

// Inisialisasi cURL untuk permintaan API berikutnya
$ch = curl_init();

// Set opsi cURL untuk permintaan API
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

// Kirim permintaan dan simpan respons
$apiResponse = curl_exec($ch);

// Periksa kesalahan dalam permintaan
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Tutup cURL
curl_close($ch);

// Decode respons JSON
$apiData = json_decode($apiResponse, true);


//var_dump($apiData);

// Debug respons API
//echo "<pre>API Response:\n";
//print_r($apiData);
//echo "</pre>";

// Cek apakah decoding berhasil

    // Menampilkan data 'nim' dengan nomor di sampingnya
 
        $number = 1;
        foreach ($apiData['data'] as $item) {
            if (isset($item['nim'])) {
                echo $number . ". " . $item['nim'] . "<br>";
                $number++;
            }
        }
    

?>
