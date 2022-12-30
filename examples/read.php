<?php

/** @noinspection ForgottenDebugOutputInspection */

use Shuchkin\SimpleXLSX;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . '/../src/SimpleXLSX.php';

echo '<h1>Parse books.xslx</h1><pre>';
if ($xlsx = SimpleXLSX::parse('Rekap Per-Prodi Afirmasi dan Mandiri.xlsx')) {
    $i = 0;


    //DB COBA
    // $servername = "smftunud.my.id";
    // $username = "smftunud_coba";
    // $password = "";
    // $dbname = "smftunud_coba";

    //DB ASLI
    $servername = "smftunud.my.id";
    $username = "smftunud_sdf";
    $password = "";
    $dbname = "smftunud_sdf";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $angkatan = 12; //2011 = 1 , 2022 = 12
    $mahasiswa_baru = 4; //1 = SNMPTN , 2 = MALA, 3 = SBMPTN, 4 = MANDIRI, 5 = Afirmasi, 6 = Prestasi, 7 = Mandiri Lanjutan
    $program_studi = 6; //1 = TA, 2 = TS, 3 = TE, 4 = TM, 5 = TI, 6 = TL, 7 = TIn

    //Perhatikan nama yg isi ', "
    //Perhatikan space nama prodi
    foreach ($xlsx->rows(6) as $r) { //rows(x) -> nomor sheet
        if ($i == 0) {
            //
        } else {
            // if ($r[3] == "Teknik Sipil") {
            //     $program_studi = 2;
            // } else if ($r[3] == "Arsitektur") {
            //     $program_studi = 1;
            // } else if ($r[3] == "Teknik Mesin") {
            //     $program_studi = 4;
            // } else if ($r[3] == "Teknik Elektro") {
            //     $program_studi = 3;
            // } else if ($r[3] == "Teknologi Informasi") {
            //     $program_studi = 5;
            // } else if ($r[3] == "Teknik Lingkungan") {
            //     $program_studi = 6;
            // } else if ($r[3] == "Teknik Industri") {
            //     $program_studi = 7;
            // }

            $password = password_hash($r[1], PASSWORD_BCRYPT);
            $sql = "INSERT INTO users(nim, password, nama, angkatan, program_studi, mahasiswa_baru) 
            VALUES ('{$r[1]}', '{$password}', '{$r[2]}', '{$angkatan}', '{$program_studi}', '{$mahasiswa_baru}')";
            // mysqli_query($conn, $sql);
            print($i . " - " . $r[1] . " - " . $r[2] . " - " . $r[3] . " - " . $password . "\n");
        }
        $i++;
    }

    mysqli_close($conn);
} else {
    echo SimpleXLSX::parseError();
}
