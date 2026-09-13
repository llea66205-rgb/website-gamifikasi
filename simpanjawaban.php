<?php
$conn = new mysqli("localhost","root","","latihan transformasi fungsi");

if($conn->connect_error){
    die("Koneksi gagal");
}

$nama  = $_POST['nama'];
$kelas = $_POST['kelas'];
$absen = $_POST['absen'];
$skor  = $_POST['skor'];

$sql = "INSERT INTO data_nilai_transformasi_fungsi (Nama, Kelas, No_Absen, Skor)
VALUES ('$nama','$kelas','$absen','$skor')";

$conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Hasil Skor</title>

<style>
body{
    font-family:Arial;
    background:#ffe6f3;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:30px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

h1{
    color:#ff4f8b;
}

.score{
    font-size:40px;
    font-weight:bold;
    margin:20px 0;
}

/* LINK DI BAWAH */
.back-link{
    margin-top:20px;
}

.back-link a{
    display:inline-block;
    padding:10px 20px;
    background:#ff7fd9;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:16px;
    transition:0.3s;
}

.back-link a:hover{
    background:#ff4f8b;
}
</style>

</head>

<body>

<div class="box">
    <h1>Hasil Kamu</h1>

    <div class="score">
        <?php echo $skor; ?>
    </div>

    <p>Skor kamu dari 100</p>

    <!-- INI YANG BENAR (DI DALAM BOX) -->
    <div class="back-link">
        <a href="http://localhost/SKRIPSI/Untitled-1.php">
            Kembali
        </a>
    </div>

</div>

</body>
</html>