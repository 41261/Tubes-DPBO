<?php

/***********************************************************
 * Filename     : View.class.php
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Class untuk membaca file untuk tampilan
************************************************************/

class View {

    var $filename = ''; // nama file
    var $content  = ''; // isi file
  
    function View($filename = ''){ // konstruktor

      $this->filename = $filename;
      $this->content = implode('', @file($filename)); // proses membaca file
    }
  
    function clear(){ // function untuk membersihkan isi file

      $this->content = preg_replace("/DATA_[A-Z]_[0-9]+/", "", $this->content); // proses mengubah isi file dengan DATA_[A-Z]_[0-9]+
    }
  
    function write(){ // function menulis ke halaman tampilan

      $this->clear(); // proses membersihkan isi file
      print $this->content; // menampilkan isi file
    }

    function getContent(){ // function mengambil isi file

      $this->clear(); // proses membersihkan isi file
      return $this->content; // mengembalikan isi file
    }
  
    function replace($old = '', $new = ''){ // function mengganti isi kode yang baru ke yang lama

      if(is_int($new)){ // jika yang baru bernilai int

        $value = sprintf("%d", $new);

      }else if(is_float($new)){ // jika yang baru bernilai float

        $value = sprintf("%f", $new);

      }else if(is_array($new)){ // jika yang baru bernilai array

        $value = ''; // inisialisasi variabel $value
        foreach ($new as $item) { // setiap yang baru diproses
          $value .= $item.' '; // inisialisasi variabel $value dengan variabel $item
        }
      }else{ // jika yang baru bukan bernilai int, float, dan array

        $value = $new; // proses inisialisasi variabel $value dengan yang baru
      }
      $this->content = preg_replace("~$old~", $value, $this->content); // proses mengganti isi file
    }  
}

?>
