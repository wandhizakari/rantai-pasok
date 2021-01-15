<?php
session_start();
        
include 'koneksi.php';

$code =$_GET['code'];

switch($code){
    case 1:
       
        
        
        // menangkap data yang dikirim dari form login
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
        // menyeleksi data user dengan username dan password yang sesuai
        $login = mysqli_query($koneksi,"select * from user where username='$username' and password='$password'");
        // menghitung jumlah data yang ditemukan
        $cek = mysqli_num_rows($login);
        
        // cek apakah username dan password di temukan pada database
        if($cek > 0){
        
            $data = mysqli_fetch_assoc($login);
        
            // cek jika user login sebagai admin
            if($data['level']=="admin"){
        
                // buat session login dan username
                $_SESSION['username'] = $username;
                $_SESSION['level'] = "admin";
                // alihkan ke halaman dashboard admin
                header("location:halaman_admin.php");
        
            // cek jika user login sebagai pegawai
            }else if($data['level']=="pegawai"){
                // buat session login dan username
                $_SESSION['username'] = $username;
                $_SESSION['level'] = "pegawai";
                // alihkan ke halaman dashboard pegawai
                header("location:halaman_pegawai.php");
        
            // cek jika user login sebagai pengurus
            }else if($data['level']=="pengurus"){
                // buat session login dan username
                $_SESSION['username'] = $username;
                $_SESSION['level'] = "pengurus";
                // alihkan ke halaman dashboard pengurus
                header("location:halaman_pengurus.php");
        
            }else{
        
                // alihkan ke halaman login kembali
                header("location:index.php?pesan=gagal");
            }
        
            
        }else{
            header("location:index.php?pesan=gagal");
        }
        
        
        
       

    break;
    case 'log meja':
        echo"masuk";
        $meja= $_POST['imeja'];
        $sqlCekMeja = mysqli_query($koneksi,"select * from log_meja where nomer_meja = '$meja' and status ='0'");
        // menghitung jumlah data yang ditemukan
        $cek = mysqli_num_rows($sqlCekMeja);

        
        if($cek > 0){
            header("location:index.php?messageError=Meja Telah Terisi");
        }else{
            header("location:indexCustomer.php?");
            $sqlLogMeja=mysqli_query($koneksi,"INSERT INTO log_meja(nomer_meja,status) VALUES ('$meja','0')");
            $sqlCekMeja = mysqli_query($koneksi,"select * from log_meja where nomer_meja = '$meja'");

            $data = mysqli_fetch_assoc($sqlCekMeja);
            echo $data['id_log'];
            $_SESSION['id_log'] = $data['id_log'];   
        }
    break;
    case 'out_table':
        mysqli_query($koneksi,"UPDATE log_meja set status = 3 where id_log =  '$_SESSION[id_log]'");
        header("location:index.php");
        echo  $_SESSION['id_log'];   

    break;
}
?>