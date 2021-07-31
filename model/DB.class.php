<?php

/***********************************************************
 * Filename     : DB.class.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Class untuk akses database
************************************************************/

class DB {

    var $db_host     = ''; // host database
    var $db_user     = ''; // user database
    var $db_password = ''; // password database
    var $db_name     = ''; // nama database
    var $db_link     = ''; // koneksi database
    var $res         = 0;  // hasil eksekusi

    function DB($db_host = '', $db_user = '', $db_password = '', $db_name = ''){ // konstruktor

      $this->db_host     = $db_host;
      $this->db_user     = $db_user;
      $this->db_password = $db_password;
      $this->db_name     = $db_name;
    }

    function open(){ // function membuka koneksi ke database

      $this->db_link = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
    }

    function execute($query = ""){ // function untuk execute query

      $this->res = $this->db_link->query($query);
      return $this->res;
    }

    function getResult(){ // function mengambil result dari query

      return mysqli_fetch_array($this->res);
    }

    function close(){ // function untuk menutup koneksi dengan database

      mysqli_close($this->db_link);
    }

}

?>
