<?php

/***********************************************************
 * Filename     : update.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Program untuk menambah dan mengupdate data player
************************************************************/

// ---------------------------------- proses include file yang diperlukan
include("../conf.php");
include("../model/DB.class.php");
include("../model/Player.class.php");
include("../model/View.class.php");

session_start(); // memulai session
if(isset($_SESSION['temp'])){

    $player = new Player($db_host, $db_user, $db_password, $db_name); // instansiasi player
    $player->open(); // --------------------------------------- membuka koenksi ke database
    if($_SESSION['temp'] == 0){ // jika nilai session temp == 0
        $player->insertPlayer($_SESSION['username'], 0); // menambah data pada database
    }
    $player->getData($_SESSION['username']); // ---------------- proses mengambil data
    $dat = $player->getResult(); // ---------------------------- proses fetch data
    if($_GET['score'] > $dat['score']){ // --------------------- jika score dari proses get > data score dari database
        
        $player->updatePlayer($_SESSION['username'], $_GET['score']); // proses update score player
    }
    $player->close(); // menutup koneksi dengan database
    session_destroy(); // mematikan session
    header("Location: ../index.php"); // mengarahkan ke halaman utama
}

?>
