<?php
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = new mysqli(
    "localhost",
    "root",
    "",
    "latihan transformasi fungsi"
);

if ($koneksi->connect_errno) {
    $pesanDatabase = "Koneksi database gagal: " . $koneksi->connect_error;
} else {
    $koneksi->set_charset("utf8mb4");
    $pesanDatabase = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["simpan_nilai"])) {
        header("Content-Type: application/json; charset=utf-8");

        $nama  = trim($_POST["nama"] ?? "");
        $kelas = trim($_POST["kelas"] ?? "");
        $absen = trim($_POST["absen"] ?? "");
        $skor  = filter_var($_POST["skor"] ?? null, FILTER_VALIDATE_INT);

        if ($nama === "" || $kelas === "" || $absen === "" || $skor === false) {
            echo json_encode([
                "success" => false,
                "message" => "Data Nama, Kelas, No. Absen, dan Skor harus lengkap."
            ]);
            exit;
        }

        $skor = max(0, min(100, (int)$skor));

        $stmt = $koneksi->prepare(
            "INSERT INTO `data_nilai_transformasi_fungsi`
            (`Nama`, `Kelas`, `No_Absen`, `Skor`)
            VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            echo json_encode([
                "success" => false,
                "message" => "Gagal menyiapkan penyimpanan: " . $koneksi->error
            ]);
            exit;
        }

        $stmt->bind_param("sssi", $nama, $kelas, $absen, $skor);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Nilai berhasil disimpan ke database."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Nilai gagal disimpan: " . $stmt->error
            ]);
        }

        $stmt->close();
        exit;
    }

    // Pemeriksaan tabel agar pesan error lebih jelas.
    $cekTabel = $koneksi->query(
        "SHOW TABLES LIKE 'data_nilai_transformasi_fungsi'"
    );

    if (!$cekTabel || $cekTabel->num_rows === 0) {
        $pesanDatabase =
            "Tabel data_nilai_transformasi_fungsi belum ada di database " .
            "latihan transformasi fungsi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Latihan Transformasi Fungsi</title>

    <!-- =========================
         MATHJAX
    ========================== -->
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['\\(', '\\)']],
                displayMath: [['\\[', '\\]']]
            },
            svg: {
                fontCache: 'global'
            },
            options: {
                skipHtmlTags: [
                    'script',
                    'noscript',
                    'style',
                    'textarea',
                    'pre',
                    'code'
                ]
            }
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #dbeafe;
            min-height: 100vh;
            padding: 30px 15px;
            color: #1e293b;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* =========================
           HEADER
        ========================== */

        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.20);
        }

        .header h1 {
            font-size: 30px;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 15px;
            line-height: 1.6;
            opacity: 0.95;
        }

        /* =========================
           IDENTITAS
        ========================== */

        .identity {
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }

        .identity h2 {
            color: #1d4ed8;
            font-size: 20px;
            line-height: 1.4;
            margin-bottom: 18px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group:last-child {
            margin-bottom: 0;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 7px;
            line-height: 1.5;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: 0.2s;
        }

        .input-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        /* =========================
           SOAL
        ========================== */

        .question {
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 20px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
        }

        .question-number {
            color: #1d4ed8;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .question-text {
            font-size: 16px;
            line-height: 1.9;
            margin-bottom: 18px;
        }

        /* =========================
           PILIHAN JAWABAN
        ========================== */

        .option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
            line-height: 1.7;
            background: #ffffff;
        }

        .option:last-child {
            margin-bottom: 0;
        }

        .option:hover {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .option input {
            margin-top: 5px;
            accent-color: #2563eb;
            flex-shrink: 0;
        }

        .option span {
            flex: 1;
            min-width: 0;
        }

        /* =========================
           EQUATION
        ========================== */

        .equation {
            width: 100%;
            margin: 14px 0;
            padding: 8px 5px;
            text-align: center;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .equation mjx-container {
            margin: 0 auto !important;
            max-width: 100%;
        }

        /* =========================
           BUTTON
        ========================== */

        .submit-area {
            text-align: center;
            margin: 30px 0;
        }

        .submit-btn {
            border: none;
            background: #2563eb;
            color: white;
            padding: 14px 35px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.25);
        }

        .submit-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* =========================
           HASIL
        ========================== */

        #hasil {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin-top: 25px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .score-title {
            color: #1d4ed8;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .score {
            font-size: 48px;
            line-height: 1.2;
            font-weight: 700;
            color: #2563eb;
            margin: 10px 0;
        }

        .score-info {
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* =========================
           PEMBAHASAN
        ========================== */

        #pembahasan {
            margin-top: 30px;
            text-align: left;
        }

        .review-title {
            color: #1d4ed8;
            font-size: 23px;
            line-height: 1.4;
            margin-bottom: 18px;
        }

        .answer-card {
            border: 1px solid #bfdbfe;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            background: white;
        }

        .answer-card:last-child {
            margin-bottom: 0;
        }

        .answer-header {
            padding: 13px 17px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 16px;
            line-height: 1.5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .answer-status {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            line-height: 1.3;
            white-space: nowrap;
            font-weight: 700;
        }

        .correct {
            background: #dcfce7;
            color: #166534;
        }

        .wrong {
            background: #fee2e2;
            color: #991b1b;
        }

        .answer-body {
            padding: 20px;
        }

        /* =========================
           JAWABAN SISWA
        ========================== */

        .your-answer {
            background: #f8fafc;
            border-left: 4px solid #94a3b8;
            padding: 12px 14px;
            border-radius: 7px;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .your-answer strong {
            display: block;
            margin-bottom: 5px;
            color: #334155;
        }

        .your-answer .student-choice {
            display: block;
            color: #475569;
        }

        /* =========================
           PEMBAHASAN DETAIL
        ========================== */

        .explanation {
            background: #eff6ff;
            border-left: 5px solid #2563eb;
            padding: 18px;
            border-radius: 10px;
        }

        .step {
            margin: 0 0 22px 0;
            line-height: 1.8;
        }

        .step:last-child {
            margin-bottom: 0;
        }

        .step-title {
            color: #1d4ed8;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 16px;
            line-height: 1.5;
        }

        .step p {
            margin: 6px 0;
            line-height: 1.9;
        }

        .step mjx-container {
            margin: 12px auto !important;
        }

        .answer-step {
            margin: 14px 0;
            padding: 3px 0;
            line-height: 1.8;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .answer-step mjx-container {
            margin: 0 auto !important;
        }

        /* =========================
           HASIL AKHIR
        ========================== */

        .final-answer {
            margin-top: 20px;
            padding: 15px;
            background: #dbeafe;
            border-radius: 10px;
            text-align: center;
            color: #1e40af;
            font-weight: 700;
            line-height: 1.8;
        }

        .final-answer-text {
            margin-bottom: 4px;
        }

        .final-answer .equation {
            margin: 8px 0 0 0;
        }

        .final-answer mjx-container {
            margin: 8px auto !important;
        }

        /* =========================
           LINK KEMBALI
        ========================== */

        .back {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .back a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            line-height: 1.6;
        }

        .back a:hover {
            text-decoration: underline;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 600px) {

            body {
                padding: 15px 10px;
            }

            .header {
                padding: 23px 15px;
                border-radius: 16px;
            }

            .header h1 {
                font-size: 24px;
            }

            .header p {
                font-size: 14px;
            }

            .question,
            .identity,
            #hasil {
                padding: 18px;
            }

            .question-text {
                font-size: 15px;
                line-height: 1.8;
            }

            .score {
                font-size: 40px;
            }

            .answer-body {
                padding: 15px;
            }

            .explanation {
                padding: 14px;
            }

            .answer-header {
                padding: 12px 14px;
            }

            .answer-status {
                font-size: 11px;
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>

    <?php if ($pesanDatabase !== ""): ?>
        <div style="
            background:#fee2e2;
            color:#991b1b;
            border:1px solid #fecaca;
            padding:14px 16px;
            border-radius:12px;
            margin-bottom:20px;
            line-height:1.6;
            font-weight:600;
        ">
            <?= htmlspecialchars($pesanDatabase, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

<div class="container">

    <!-- =========================
         HEADER
    ========================== -->

    <div class="header">

        <h1>Latihan Transformasi Fungsi</h1>

        <p>
            Kerjakan setiap soal dengan teliti.
            Pilih satu jawaban yang paling tepat.
        </p>

    </div>


    <!-- =========================
         IDENTITAS
    ========================== -->

    <div class="identity">

        <h2>Identitas Siswa</h2>

        <div class="input-group">

            <label for="nama">Nama</label>

            <input
                type="text"
                id="nama"
                name="nama"
                placeholder="Masukkan nama"
                autocomplete="off"
            >

        </div>


        <div class="input-group">

            <label for="kelas">Kelas</label>

            <input
                type="text"
                id="kelas"
                name="kelas"
                placeholder="Masukkan kelas"
                autocomplete="off"
            >

        </div>


        <div class="input-group">

            <label for="absen">No. Absen</label>

            <input
                type="number"
                id="absen"
                name="absen"
                placeholder="Masukkan nomor absen"
                min="1"
                autocomplete="off"
            >

        </div>

    </div>


    <!-- =========================
         SOAL 1
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 1
        </div>

        <div class="question-text">

            Diketahui fungsi \(f(x)=x^2\).
            Fungsi tersebut ditranslasikan 2 satuan ke kanan.
            Bentuk fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q1" value="1">
            <span>A. \(g(x)=(x-2)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q1" value="0">
            <span>B. \(g(x)=(x+2)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q1" value="0">
            <span>C. \(g(x)=x^2-2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q1" value="0">
            <span>D. \(g(x)=x^2+2\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 2
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 2
        </div>

        <div class="question-text">

            Jika grafik fungsi \(f(x)=2x+3\)
            direfleksikan terhadap sumbu-\(X\),
            maka fungsi hasil refleksi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q2" value="0">
            <span>A. \(g(x)=2x-3\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q2" value="0">
            <span>B. \(g(x)=-2x+3\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q2" value="1">
            <span>C. \(g(x)=-2x-3\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q2" value="0">
            <span>D. \(g(x)=2x+3\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 3
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 3
        </div>

        <div class="question-text">

            Fungsi \(f(x)=x^2\)
            mengalami dilatasi vertikal dengan faktor skala \(2\).
            Fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q3" value="0">
            <span>A. \(g(x)=x^2+2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q3" value="1">
            <span>B. \(g(x)=2x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q3" value="0">
            <span>C. \(g(x)=(2x)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q3" value="0">
            <span>D. \(g(x)=\frac{x^2}{2}\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 4
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 4
        </div>

        <div class="question-text">

            Grafik fungsi \(y=x^2\)
            diputar \(180^\circ\)
            terhadap titik pusat \(O(0,0)\).
            Persamaan grafik hasil rotasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q4" value="0">
            <span>A. \(y=x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q4" value="1">
            <span>B. \(y=-x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q4" value="0">
            <span>C. \(y=(x+1)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q4" value="0">
            <span>D. \(y=x^2+1\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 5
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 5
        </div>

        <div class="question-text">

            Fungsi \(f(x)=2^x\)
            ditranslasikan 1 satuan ke kiri.
            Fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q5" value="0">
            <span>A. \(g(x)=2^{x-1}\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q5" value="1">
            <span>B. \(g(x)=2^{x+1}\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q5" value="0">
            <span>C. \(g(x)=2^x+1\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q5" value="0">
            <span>D. \(g(x)=2^x-1\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 6
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 6
        </div>

        <div class="question-text">

            Fungsi \(f(x)=3^x\)
            direfleksikan terhadap sumbu-\(Y\).
            Fungsi hasil refleksi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q6" value="1">
            <span>A. \(g(x)=3^{-x}\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q6" value="0">
            <span>B. \(g(x)=-3^x\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q6" value="0">
            <span>C. \(g(x)=3^x+1\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q6" value="0">
            <span>D. \(g(x)=3^{-x}+1\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 7
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 7
        </div>

        <div class="question-text">

            Fungsi \(f(x)=x^2\)
            ditranslasikan 5 satuan ke atas.
            Fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q7" value="0">
            <span>A. \(g(x)=(x+5)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q7" value="1">
            <span>B. \(g(x)=x^2+5\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q7" value="0">
            <span>C. \(g(x)=(x-5)^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q7" value="0">
            <span>D. \(g(x)=x^2-5\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 8
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 8
        </div>

        <div class="question-text">

            Fungsi \(f(x)=x^2\)
            mengalami dilatasi vertikal dengan faktor skala
            \(\frac{1}{2}\).
            Fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q8" value="0">
            <span>A. \(g(x)=2x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q8" value="1">
            <span>B. \(g(x)=\frac{1}{2}x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q8" value="0">
            <span>C. \(g(x)=\frac{1}{4}x^2\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q8" value="0">
            <span>D. \(g(x)=x^2+\frac{1}{2}\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 9
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 9
        </div>

        <div class="question-text">

            Rotasi \(180^\circ\) terhadap titik pusat
            \(O(0,0)\)
            memiliki hasil yang sama dengan ....

        </div>

        <label class="option">
            <input type="radio" name="q9" value="0">
            <span>A. Refleksi terhadap sumbu-\(X\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q9" value="0">
            <span>B. Refleksi terhadap sumbu-\(Y\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q9" value="0">
            <span>C. Translasi ke kanan</span>
        </label>

        <label class="option">
            <input type="radio" name="q9" value="1">
            <span>D. Refleksi terhadap titik pusat \(O(0,0)\)</span>
        </label>

    </div>


    <!-- =========================
         SOAL 10
    ========================== -->

    <div class="question">

        <div class="question-number">
            Soal 10
        </div>

        <div class="question-text">

            Diketahui fungsi \(f(x)=2x+1\).
            Jika semua nilai \(y\) dikurangi 4 satuan,
            maka fungsi hasil transformasi adalah ....

        </div>

        <label class="option">
            <input type="radio" name="q10" value="0">
            <span>A. \(g(x)=2x+5\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q10" value="1">
            <span>B. \(g(x)=2x-3\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q10" value="0">
            <span>C. \(g(x)=2x+1-4x\)</span>
        </label>

        <label class="option">
            <input type="radio" name="q10" value="0">
            <span>D. \(g(x)=2x+4\)</span>
        </label>

    </div>


    <!-- =========================
         BUTTON
    ========================== -->

    <div class="submit-area">

        <button
            type="button"
            class="submit-btn"
            onclick="hitungSkor()">

            Kirim Jawaban

        </button>

    </div>


    <!-- =========================
         HASIL
    ========================== -->

    <div id="hasil">

        <div class="score-title">
            Hasil Latihan
        </div>

        <div class="score" id="nilai">
            0
        </div>

        <div class="score-info" id="jumlahBenar">
            0 dari 10 soal benar
        </div>

        <div id="pembahasan"></div>

    </div>


    <!-- =========================
         KEMBALI
    ========================== -->

    <div class="back">

        <a href="http://localhost/SKRIPSI/Untitled-1.php">
            ← Kembali ke halaman sebelumnya
        </a>

    </div>

</div>


<script>

/* =====================================================
   DATA PEMBAHASAN
===================================================== */

const pembahasan = [

    {
        nomor: 1,

        rumus: `g(x)=f(x-a)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=x^2\\) ditranslasikan
            2 satuan ke kanan, sehingga \\(a=2\\).
        `,

        ditanya: `
            Tentukan fungsi hasil translasi.
        `,

        jawab: [
            `g(x)=f(x-2)`,
            `g(x)=(x-2)^2`
        ],

        hasil: `g(x)=(x-2)^2`
    },


    {
        nomor: 2,

        rumus: `g(x)=-f(x)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=2x+3\\)
            direfleksikan terhadap sumbu-\\(X\\).
        `,

        ditanya: `
            Tentukan fungsi hasil refleksi.
        `,

        jawab: [
            `g(x)=-f(x)`,
            `g(x)=-(2x+3)`,
            `g(x)=-2x-3`
        ],

        hasil: `g(x)=-2x-3`
    },


    {
        nomor: 3,

        rumus: `g(x)=k f(x)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=x^2\\)
            mengalami dilatasi vertikal dengan faktor skala \\(k=2\\).
        `,

        ditanya: `
            Tentukan fungsi hasil dilatasi.
        `,

        jawab: [
            `g(x)=2f(x)`,
            `g(x)=2(x^2)`,
            `g(x)=2x^2`
        ],

        hasil: `g(x)=2x^2`
    },


    {
        nomor: 4,

        rumus: `(x,y)\\rightarrow(-x,-y)`,

        diketahui: `
            Diketahui grafik fungsi \\(y=x^2\\)
            diputar sebesar \\(180^\\circ\\)
            terhadap titik pusat \\(O(0,0)\\).
        `,

        ditanya: `
            Tentukan persamaan grafik hasil rotasi.
        `,

        jawab: [
            `x'=-x`,
            `y'=-y`,
            `y=x^2`,
            `y'=-(x)^2`,
            `y'=-x^2`
        ],

        hasil: `y=-x^2`
    },


    {
        nomor: 5,

        rumus: `g(x)=f(x+a)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=2^x\\)
            ditranslasikan 1 satuan ke kiri,
            sehingga \\(a=1\\).
        `,

        ditanya: `
            Tentukan fungsi hasil translasi.
        `,

        jawab: [
            `g(x)=f(x+1)`,
            `g(x)=2^{x+1}`
        ],

        hasil: `g(x)=2^{x+1}`
    },


    {
        nomor: 6,

        rumus: `g(x)=f(-x)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=3^x\\)
            direfleksikan terhadap sumbu-\\(Y\\).
        `,

        ditanya: `
            Tentukan fungsi hasil refleksi.
        `,

        jawab: [
            `g(x)=f(-x)`,
            `g(x)=3^{-x}`
        ],

        hasil: `g(x)=3^{-x}`
    },


    {
        nomor: 7,

        rumus: `g(x)=f(x)+b`,

        diketahui: `
            Diketahui fungsi \\(f(x)=x^2\\)
            ditranslasikan 5 satuan ke atas,
            sehingga \\(b=5\\).
        `,

        ditanya: `
            Tentukan fungsi hasil translasi.
        `,

        jawab: [
            `g(x)=f(x)+5`,
            `g(x)=x^2+5`
        ],

        hasil: `g(x)=x^2+5`
    },


    {
        nomor: 8,

        rumus: `g(x)=k f(x)`,

        diketahui: `
            Diketahui fungsi \\(f(x)=x^2\\)
            mengalami dilatasi vertikal dengan faktor skala
            \\(k=\\frac{1}{2}\\).
        `,

        ditanya: `
            Tentukan fungsi hasil dilatasi.
        `,

        jawab: [
            `g(x)=\\frac{1}{2}f(x)`,
            `g(x)=\\frac{1}{2}(x^2)`,
            `g(x)=\\frac{1}{2}x^2`
        ],

        hasil: `g(x)=\\frac{1}{2}x^2`
    },


    {
        nomor: 9,

        rumus: `(x,y)\\rightarrow(-x,-y)`,

        diketahui: `
            Rotasi \\(180^\\circ\\) terhadap titik pusat
            \\(O(0,0)\\) mengubah setiap titik
            \\((x,y)\\) menjadi \\((-x,-y)\\).
        `,

        ditanya: `
            Transformasi apa yang memiliki hasil yang sama
            dengan rotasi \\(180^\\circ\\) terhadap titik pusat \\(O(0,0)\\)?
        `,

        jawab: [
            `\\text{Rotasi }180^\\circ\\text{ terhadap titik pusat }O(0,0)`,
            `\\text{memiliki hasil yang sama dengan refleksi terhadap titik pusat }O(0,0)`
        ],

        hasil: `\\text{Refleksi terhadap titik pusat }O(0,0)`
    },


    {
        nomor: 10,

        rumus: `g(x)=f(x)-4`,

        diketahui: `
            Diketahui fungsi \\(f(x)=2x+1\\).
            Semua nilai \\(y\\) dikurangi 4 satuan.
        `,

        ditanya: `
            Tentukan fungsi hasil transformasi.
        `,

        jawab: [
            `g(x)=f(x)-4`,
            `g(x)=(2x+1)-4`,
            `g(x)=2x-3`
        ],

        hasil: `g(x)=2x-3`
    }

];


/* =====================================================
   HITUNG SKOR
===================================================== */

function hitungSkor() {

    const nama =
        document.getElementById("nama").value.trim();

    const kelas =
        document.getElementById("kelas").value.trim();

    const absen =
        document.getElementById("absen").value.trim();

    /* CEK IDENTITAS */
    if (
        nama === "" ||
        kelas === "" ||
        absen === ""
    ) {
        alert(
            "Silakan lengkapi Nama, Kelas, dan No. Absen terlebih dahulu."
        );
        return;
    }

    let benar = 0;

    /* CEK SEMUA JAWABAN */
    for (let i = 1; i <= 10; i++) {

        const pilihan =
            document.querySelector(
                'input[name="q' + i + '"]:checked'
            );

        if (!pilihan) {
            alert(
                "Silakan jawab semua soal terlebih dahulu."
            );
            return;
        }

        if (parseInt(pilihan.value) === 1) {
            benar++;
        }
    }

    /* HITUNG NILAI */
    const nilai = benar * 10;

    document.getElementById("nilai").innerText =
        nilai;

    document.getElementById("jumlahBenar").innerText =
        benar + " dari 10 soal benar";

    /* TAMPILKAN HASIL */
    document.getElementById("hasil").style.display =
        "block";

    /* TAMPILKAN PEMBAHASAN */
    tampilkanPembahasan();

    /* SIMPAN NILAI KE DATABASE */
    simpanNilaiKeDatabase(nama, kelas, absen, nilai);

    /* SCROLL KE HASIL */
    document.getElementById("hasil").scrollIntoView({
        behavior: "smooth",
        block: "start"
    });
}


/* =====================================================
   SIMPAN NILAI KE DATABASE
===================================================== */

let nilaiSedangDisimpan = false;

function simpanNilaiKeDatabase(nama, kelas, absen, nilai) {

    if (nilaiSedangDisimpan) {
        return;
    }

    nilaiSedangDisimpan = true;

    const data = new URLSearchParams();

    data.append("simpan_nilai", "1");
    data.append("nama", nama);
    data.append("kelas", kelas);
    data.append("absen", absen);
    data.append("skor", nilai);

    fetch(window.location.href, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data.toString()
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {

        if (data.success) {
            console.log(data.message);
        } else {
            alert(data.message);
            console.error(data.message);
        }

    })
    .catch(function(error) {

        alert(
            "Nilai sudah dihitung, tetapi gagal terhubung ke database."
        );

        console.error(
            "Kesalahan penyimpanan database:",
            error
        );

    })
    .finally(function() {
        nilaiSedangDisimpan = false;
    });
}


/* =====================================================
   TAMPILKAN PEMBAHASAN
===================================================== */

function tampilkanPembahasan() {

    const container =
        document.getElementById("pembahasan");


    container.innerHTML = `
        <h2 class="review-title">
            Pembahasan Setiap Soal
        </h2>
    `;


    pembahasan.forEach((soal) => {

        const pilihan =
            document.querySelector(
                'input[name="q' + soal.nomor + '"]:checked'
            );


        const nilai =
            parseInt(pilihan.value);


        const benar =
            nilai === 1;


        const label =
            pilihan.closest(".option");


        /*
         * Mengambil teks pilihan siswa
         * dari pilihan yang dipilih.
         */

        const jawabanSiswa =
            label.querySelector("span").innerHTML;


        /* MEMBUAT KARTU PEMBAHASAN */

        const card =
            document.createElement("div");


        card.className =
            "answer-card";


        card.innerHTML = `

            <!-- HEADER PEMBAHASAN -->

            <div class="answer-header">

                <span>
                    Soal ${soal.nomor}
                </span>

                <span class="answer-status ${benar ? "correct" : "wrong"}">
                    ${benar ? "✓ Benar" : "✗ Salah"}
                </span>

            </div>


            <!-- ISI PEMBAHASAN -->

            <div class="answer-body">


                <!-- JAWABAN SISWA -->

                <div class="your-answer">

                    <strong>
                        Jawaban Anda:
                    </strong>

                    <span class="student-choice">
                        ${jawabanSiswa}
                    </span>

                </div>


                <!-- PENJELASAN -->

                <div class="explanation">


                    <!-- RUMUS -->

                    <div class="step">

                        <div class="step-title">
                            📐 Rumus
                        </div>

                        <div class="equation">

                            \\[
                            ${soal.rumus}
                            \\]

                        </div>

                    </div>


                    <!-- DIKETAHUI -->

                    <div class="step">

                        <div class="step-title">
                            📌 Diketahui
                        </div>

                        <p>
                            ${soal.diketahui}
                        </p>

                    </div>


                    <!-- DITANYA -->

                    <div class="step">

                        <div class="step-title">
                            ❓ Ditanya
                        </div>

                        <p>
                            ${soal.ditanya}
                        </p>

                    </div>


                    <!-- DIJAWAB -->

                    <div class="step">

                        <div class="step-title">
                            ✏️ Dijawab
                        </div>

                        ${
                            soal.jawab.map(
                                langkah => `
                                    <div class="answer-step">

                                        \\[
                                        ${langkah}
                                        \\]

                                    </div>
                                `
                            ).join("")
                        }

                    </div>


                    <!-- HASIL AKHIR -->

                    <div class="final-answer">

                        <div class="final-answer-text">
                            Jadi, jawaban yang benar adalah:
                        </div>

                        <div class="equation">

                            \\[
                            \\boxed{${soal.hasil}}
                            \\]

                        </div>

                    </div>


                </div>

            </div>

        `;


        container.appendChild(card);

    });


    /* =================================================
       RENDER ULANG MATHJAX
    ================================================= */

    if (window.MathJax) {

        MathJax.typesetClear([container]);

        MathJax.typesetPromise([container])
            .catch(function(error) {

                console.error(
                    "MathJax error:",
                    error
                );

            });

    }

}

</script>

</body>
</html>
