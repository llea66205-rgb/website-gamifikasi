<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Pengembang - Ela</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: #f7f9fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Background dekorasi */
        body::before {
            content: "";
            position: fixed;
            width: 300px;
            height: 300px;
            background: #dbeafe;
            border-radius: 50%;
            top: -120px;
            left: -100px;
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            width: 320px;
            height: 320px;
            background: #e0e7ff;
            border-radius: 50%;
            bottom: -150px;
            right: -100px;
            z-index: -1;
        }

        /* Card utama */
        .profile-card {
            width: 100%;
            max-width: 850px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(40, 55, 85, 0.12);
            position: relative;
        }

        /* Header */
        .profile-header {
            background: #2563eb;
            padding: 35px 30px 75px;
            text-align: center;
            color: white;
            position: relative;
        }

        .profile-header h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .profile-header p {
            font-size: 14px;
            opacity: 0.92;
        }

        /* Foto */
        .foto-wrapper {
            width: 165px;
            height: 165px;
            margin: -55px auto 20px;
            position: relative;
            z-index: 2;
        }

        .foto-profil {
            width: 165px;
            height: 165px;
            border-radius: 50%;
            background: white;
            padding: 7px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .foto-profil img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            transition: transform 0.35s ease;
        }

        .foto-profil:hover img {
            transform: scale(1.05);
        }

        /* Nama */
        .nama {
            text-align: center;
            margin-bottom: 28px;
            padding: 0 20px;
        }

        .nama h2 {
            color: #1e293b;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .nama p {
            color: #64748b;
            font-size: 14px;
        }

        /* Biodata */
        .biodata {
            padding: 0 45px 35px;
        }

        .biodata-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            color: #2563eb;
            font-size: 17px;
            font-weight: 600;
        }

        .biodata-title i {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
        }

        .biodata-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .biodata-item {
            background: #f8fafc;
            border: 1px solid #e8edf3;
            border-radius: 12px;
            padding: 15px 17px;
            transition: all 0.25s ease;
        }

        .biodata-item:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.08);
        }

        .biodata-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .biodata-value {
            display: block;
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
            word-break: break-word;
        }

        .biodata-value i {
            color: #2563eb;
            width: 20px;
            margin-right: 4px;
        }

        /* Tombol kembali */
        .back-link {
            text-align: center;
            padding: 0 45px 40px;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 12px 28px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.20);
        }

        .back-link a:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(37, 99, 235, 0.25);
        }

        /* Footer kecil */
        .footer-text {
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            padding: 0 20px 25px;
        }

        /* Responsive */
        @media (max-width: 700px) {

            body {
                padding: 20px 12px;
            }

            .profile-header {
                padding: 28px 20px 65px;
            }

            .profile-header h1 {
                font-size: 23px;
            }

            .foto-wrapper,
            .foto-profil {
                width: 140px;
                height: 140px;
            }

            .foto-wrapper {
                margin-top: -50px;
            }

            .nama h2 {
                font-size: 19px;
            }

            .biodata {
                padding: 0 20px 30px;
            }

            .biodata-list {
                grid-template-columns: 1fr;
            }

            .back-link {
                padding: 0 20px 30px;
            }
        }

        @media (max-width: 400px) {

            .profile-header h1 {
                font-size: 21px;
            }

            .biodata-item {
                padding: 13px;
            }

            .biodata-value {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <div class="profile-card">

        <!-- Header -->
        <div class="profile-header">
            <h1>PROFIL PENGEMBANG</h1>
            <p>Website Pembelajaran Interaktif Transformasi Fungsi</p>
        </div>

        <!-- Foto -->
        <div class="foto-wrapper">
            <div class="foto-profil">
                <img
                    src="http://localhost/SKRIPSI/WhatsApp%20Image%202026-09-13%20at%2020.56.00.jpeg"
                    alt="Foto Profil Ela"
                >
            </div>
        </div>

        <!-- Nama -->
        <div class="nama">
            <h2>NURLAELATUL QADRI RAMDANI</h2>
            <p>Mahasiswa Pendidikan Matematika</p>
        </div>

        <!-- Biodata -->
        <div class="biodata">

            <div class="biodata-title">
                <i class="fa-solid fa-user"></i>
                <span>Biodata Diri</span>
            </div>

            <div class="biodata-list">

                <div class="biodata-item">
                    <span class="biodata-label">Nama Lengkap</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-user"></i>
                        NURLAELATUL QADRI RAMDANI
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Nama Panggilan</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-heart"></i>
                        ELA
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">NIM</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-id-card"></i>
                        E1R022082
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Tempat, Tanggal Lahir</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-calendar"></i>
                        MASBAGIK, 26 OKTOBER 2005
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Alamat</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-location-dot"></i>
                        LOMBOK TIMUR
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Program Studi</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-graduation-cap"></i>
                        PENDIDIKAN MATEMATIKA
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Fakultas</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-building-columns"></i>
                        KEGURUAN DAN ILMU PENDIDIKAN
                    </span>
                </div>

                <div class="biodata-item">
                    <span class="biodata-label">Email</span>
                    <span class="biodata-value">
                        <i class="fa-solid fa-envelope"></i>
                        qdrirmdni@gmail.com
                    </span>
                </div>

            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="back-link">
            <a href="http://localhost/SKRIPSI/Untitled-1.php">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            © 2026 Profil Pengembang Website Pembelajaran
        </div>

    </div>

</body>
</html>
