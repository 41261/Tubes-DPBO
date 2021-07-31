<?php

/***********************************************************
 * Filename     : Player.class.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Class untuk akses tabel table_player
************************************************************/

class Player extends DB {

    function getData($username = '') // function untuk mengambil data dari database
    {
        if($username != ''){ // jika disertai username
            $query = "SELECT * FROM table_player WHERE username='$username'";
        }else{ // jika tidak disertai username
            $query = "SELECT * FROM table_player ORDER BY score DESC";
        }
        return $this->execute($query); // mengembalikan hasil execute query
    }

    function insertPlayer($username = '', $score = 0) // function untuk menambahkan player ke database
    {
        $query = "INSERT INTO table_player(username, score) VALUES('$username', $score)";
        $this->execute($query); // execute query
    }

    function updatePlayer($username = '', $score = 0) // function untuk mengupdate player dari database
    {
        $query = "UPDATE table_player SET score=$score WHERE username='$username'";
        $this->execute($query); // execute query
    }
}

?>
