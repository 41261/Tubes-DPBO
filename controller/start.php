<?php

/***********************************************************
 * Filename     : start.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Program untuk memulai game
************************************************************/

if($_POST['username'] != ''){ // jika data yang di post bukan NULL

    // ----------------------------------- proses include file yang dibutuhkan
    include("../conf.php");
    include("../model/DB.class.php");
    include("../model/Player.class.php");
    include("../model/View.class.php");

    session_start(); // memulai session 
    $temp = 0; // variabel temp;
    $player = new Player($db_host, $db_user, $db_password, $db_name); // instansiasi player
    $player->open(); // ------------------------------ membuka koneksi ke database 
    $player->getData(); // --------------------------------------- mengambil data dari database
    while(list($id, $username, $score) = $player->getResult()){
        if($username == $_POST['username']){ // jika username yang diinput sama dengan username dalam database
            $temp = 1;
        }
    }
    $player->close(); // ----------------------------- menutup koneksi dengan database
    $_SESSION['temp'] = $temp; // inisialisasi session temp
    $_SESSION['username'] = $_POST['username']; // inisialisasi session username

    $view = new View("../view/play.html"); // instansiasi tampilan play game
    $view->replace("USERNAME", $_SESSION['username']); // USERNAME pada tampilan diganti oleh session username
    $view->write(); // proses menulis ke halaman tampilan play game

}else{ // jika data yang di post NULL
    header("Location: ../index.php"); // mengarahkan kembali ke program utama
}

?>
