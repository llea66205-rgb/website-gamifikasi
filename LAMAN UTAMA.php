<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Awal</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgb(255, 168, 223);
            color: white;
            text-align: center;
        }
        .container {
            max-width: 500px;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .button {
            text-decoration: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            color: rgb(0, 0, 0);
            background-color: white;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color: #ff788f;
            color: white;
            border: 2px solid white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang!</h1>
        <p>Klik tombol di bawah untuk melanjutkan ke halaman berikutnya.</p>
        <a href="http://localhost/SKRIPSI/Untitled-1.php" class="button">Halaman Selanjutnya</a>
    </div>
</body>
</html>
