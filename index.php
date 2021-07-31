<?php

/***********************************************************
 * Filename     : index.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Program utama
************************************************************/

// ------------------------------------- proses include file yang diperlukan
include("conf.php");
include("./model/DB.class.php");
include("./model/Player.class.php");
include("./model/View.class.php");

$player = new Player($db_host, $db_user, $db_password, $db_name); // instansiasi player
$player->open(); // membuka koneksi ke database
$dat = NULL; // variabel untuk menampung hasil query dan ditampilkan ke halaman utama

$vw = new View("view/menu.html"); // instansiasi tampilan menu

$player->getData(); // proses fetch data dari tabel table_player
$i = 1;
while(list($id, $username, $score) = $player->getResult()){ // proses menampilkan ke halaman utama
    $dat .= '
        <tr>
            <td>'.$i.'</td>
            <td>'.$username.'</td>
            <td>'.$score.'</td>
        </tr>
    ';
    $i++;
}

$player->close(); // menutup koneksi dengan database

$vw->replace("TABLE_DATA", $dat); // TABLE_DATA pada halaman utama diisi oleh $dat
$vw->write(); // proses menulis ke halaman utama

?>
