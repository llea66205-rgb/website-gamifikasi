
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Transformasi Fungsi Interaktif</title>

<style>

/* =========================================================
   DASAR
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

html{
    scroll-behavior:smooth;
}

body{
    background:linear-gradient(135deg,#dbeafe,#eff6ff);
    color:#444;
    line-height:1.7;
}

header{
    background:linear-gradient(135deg,#2563eb,#3b82f6);
    color:white;
    text-align:center;
    padding:32px 20px;
    box-shadow:0 4px 15px rgba(37,99,235,.25);
}

header h1{
    font-size:32px;
    margin-bottom:4px;
}

header p{
    font-size:15px;
}


/* =========================================================
   NAVIGASI
========================================================= */

nav{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:9px;
    padding:13px;
    background:white;
    position:sticky;
    top:0;
    z-index:100;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
}

nav button{
    border:none;
    background:#dbeafe;
    color:#1d4ed8;
    padding:9px 17px;
    border-radius:22px;
    cursor:pointer;
    font-weight:bold;
    transition:.25s;
}

nav button:hover,
nav button.active{
    background:#2563eb;
    color:white;
    transform:translateY(-2px);
}


/* =========================================================
   CONTAINER
========================================================= */

.container{
    width:92%;
    max-width:1100px;
    margin:auto;
    padding:28px 0;
}

.box{
    background:white;
    padding:28px;
    border-radius:22px;
    box-shadow:0 10px 30px rgba(37,99,235,.14);
    display:none;
    animation:fade .35s ease;
}

.box.active{
    display:block;
}

h2{
    color:#1d4ed8;
    font-size:27px;
    margin-bottom:18px;
}

h3{
    color:#1d4ed8;
    margin-bottom:10px;
}

h4{
    color:#1d4ed8;
    margin-bottom:7px;
}

p{
    margin-bottom:12px;
    text-align:justify;
}


/* =========================================================
   PENGERTIAN
========================================================= */

.intro{
    background:#eff6ff;
    border-left:5px solid #2563eb;
    padding:18px;
    border-radius:13px;
    margin-bottom:22px;
}

.definition{
    background:#e0efff;
    border-left:6px solid #2563eb;
    padding:18px;
    border-radius:13px;
    margin:20px 0;
}

.definition-title{
    font-weight:bold;
    color:#1d4ed8;
    font-size:18px;
    margin-bottom:7px;
}


/* =========================================================
   JENIS TRANSFORMASI
========================================================= */

.transform-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-top:20px;
}

.transform-card{
    background:linear-gradient(145deg,#f8fbff,#e5efff);
    border:1px solid #bfdbfe;
    border-radius:17px;
    padding:20px 14px;
    text-align:center;
    transition:.3s;
    cursor:pointer;
}

.transform-card:hover{
    transform:translateY(-5px);
    box-shadow:0 9px 20px rgba(37,99,235,.16);
}

.transform-icon{
    font-size:35px;
    margin-bottom:7px;
}

.transform-card h3{
    font-size:17px;
}

.transform-card p{
    text-align:center;
    font-size:13px;
    margin:0;
}


/* =========================================================
   SUBMATERI
========================================================= */

.submateri{
    background:#fff;
    border:1px solid #bfdbfe;
    border-radius:17px;
    padding:22px;
    margin:23px 0;
    box-shadow:0 5px 16px rgba(37,99,235,.07);
}

.submateri-title{
    display:flex;
    align-items:center;
    gap:9px;
    background:#dbeafe;
    border-radius:11px;
    padding:10px 15px;
    color:#1d4ed8;
    font-size:18px;
    font-weight:bold;
    margin-bottom:15px;
}


/* =========================================================
   RUMUS
========================================================= */

.rumus{
    background:#e0efff;
    border:2px dashed #93c5fd;
    padding:17px;
    border-radius:14px;
    margin:17px 0;
    color:#1e40af;
    font-size:18px;
    font-weight:bold;
    text-align:center;
}

.rumus small{
    display:block;
    font-size:13px;
    color:#666;
    font-weight:normal;
    margin-top:7px;
}


/* =========================================================
   CONTOH
========================================================= */

.contoh{
    background:#f8fbff;
    border-left:5px solid #60a5fa;
    padding:17px;
    border-radius:12px;
    margin-top:20px;
}

.contoh-title{
    color:#1d4ed8;
    font-weight:bold;
    font-size:17px;
    margin-bottom:8px;
}

.langkah{
    background:white;
    border:1px solid #dbeafe;
    padding:12px 15px;
    border-radius:10px;
    margin:8px 0;
}

.jawaban{
    background:#e5efff;
    padding:12px;
    border-radius:10px;
    color:#1e40af;
    font-weight:bold;
    text-align:center;
}


/* =========================================================
   VISUALISASI
========================================================= */

.graph-box{
    background:#f8fbff;
    border:1px solid #bfdbfe;
    border-radius:17px;
    padding:15px;
    margin-top:20px;
}

.graph-title{
    text-align:center;
    color:#1d4ed8;
    font-size:17px;
    font-weight:bold;
    margin-bottom:10px;
}

.graph-container{
    width:100%;
    max-width:760px;
    height:330px;
    margin:auto;
    overflow:hidden;
    border-radius:12px;
    background:#f8fbff;
    border:1px solid #dbeafe;
}

canvas{
    width:100%;
    height:100%;
    display:block;
}


/* =========================================================
   CONTROL
========================================================= */

.control-panel{
    max-width:760px;
    margin:12px auto 0;
    background:white;
    border-radius:13px;
    padding:12px 15px;
    box-shadow:0 3px 10px rgba(37,99,235,.08);
}

.control-row{
    display:flex;
    align-items:center;
    gap:12px;
    margin:8px 0;
}

.control-row label{
    min-width:160px;
    font-size:14px;
    font-weight:bold;
    color:#1d4ed8;
}

input[type="range"]{
    flex:1;
    accent-color:#2563eb;
    cursor:pointer;
}

.value{
    min-width:58px;
    background:#dbeafe;
    color:#1d4ed8;
    padding:5px 9px;
    border-radius:8px;
    text-align:center;
    font-weight:bold;
    font-size:14px;
}

.formula-display{
    background:#e0efff;
    border-radius:10px;
    padding:9px;
    text-align:center;
    font-size:16px;
    font-weight:bold;
    color:#1e40af;
    margin-top:10px;
}


/* =========================================================
   LEGEND
========================================================= */

.legend{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:18px;
    margin-top:10px;
}

.legend-item{
    display:flex;
    align-items:center;
    gap:7px;
    font-size:13px;
}

.legend-line{
    width:27px;
    height:4px;
    border-radius:5px;
}

.original{
    background:#777;
}

.transform{
    background:#2563eb;
}


/* =========================================================
   HIGHLIGHT
========================================================= */

.highlight{
    background:#e5efff;
    border-left:5px solid #1d4ed8;
    padding:13px 16px;
    border-radius:10px;
    margin:15px 0;
}


/* =========================================================
   TABEL
========================================================= */

.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#2563eb;
    color:white;
    padding:11px;
}

td{
    padding:10px;
    border:1px solid #bfdbfe;
    text-align:center;
}

tr:nth-child(even){
    background:#f8fbff;
}


/* =========================================================
   CP
========================================================= */

.cp-container{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.cp-card{
    background:#f8fbff;
    border-left:6px solid #2563eb;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 15px rgba(37,99,235,.10);
}

.cp-card h3{
    font-size:19px;
}

ul,
ol{
    margin-left:22px;
}

li{
    margin-bottom:7px;
}


/* =========================================================
   BUTTON KEMBALI
========================================================= */

.back-btn{
    text-align:center;
    margin:10px 0 25px;
}

.back-btn a{
    display:inline-block;
    padding:10px 23px;
    background:#1d4ed8;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

.back-btn a:hover{
    background:#1e40af;
}

.footer{
    text-align:center;
    padding:20px;
    color:#777;
    font-size:13px;
}


/* =========================================================
   ANIMASI
========================================================= */

@keyframes fade{

    from{
        opacity:0;
        transform:translateY(8px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:800px){

    .transform-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .cp-container{
        grid-template-columns:1fr;
    }

}

@media(max-width:600px){

    header h1{
        font-size:25px;
    }

    .container{
        width:95%;
    }

    .box{
        padding:18px;
    }

    .graph-container{
        height:280px;
    }

    .control-row{
        flex-wrap:wrap;
    }

    .control-row label{
        width:100%;
    }

    .transform-grid{
        grid-template-columns:1fr 1fr;
    }

}

</style>

</head>


<body>


<!-- =========================================================
HEADER
========================================================= -->

<header>

<h1>📚 Transformasi Fungsi</h1>

<p>Kurikulum Merdeka - Fase F - Kelas XI</p>

</header>


<!-- =========================================================
NAVIGASI
========================================================= -->

<nav>

<button class="tab active"
onclick="show('cp',this)">
Capaian
</button>

<button class="tab"
onclick="show('pengertian',this)">
Pengertian
</button>

<button class="tab"
onclick="show('translasi',this)">
Translasi
</button>

<button class="tab"
onclick="show('refleksi',this)">
Refleksi
</button>

<button class="tab"
onclick="show('dilatasi',this)">
Dilatasi
</button>

<button class="tab"
onclick="show('rotasi',this)">
Rotasi
</button>

<button class="tab"
onclick="show('ringkasan',this)">
Ringkasan
</button>

</nav>


<div class="container">


<!-- =========================================================
CAPAIAN
========================================================= -->

<div id="cp" class="box active">

<h2>📚 Capaian & Tujuan Pembelajaran</h2>

<div class="cp-container">

<div class="cp-card">

<h3>🎯 Capaian Pembelajaran</h3>

<p>
Siswa dapat menentukan transformasi fungsi untuk
memodelkan situasi dunia nyata menggunakan fungsi yang sesuai
(linear, kuadrat, eksponensial).
</p>

</div>


<div class="cp-card">

<h3>📖 Tujuan Pembelajaran</h3>

<ul>

<li>
Siswa mampu menentukan hasil transformasi fungsi
pada grafik fungsi.
</li>

<li>
Siswa mampu menyelesaikan masalah kontekstual
yang berkaitan dengan transformasi fungsi.
</li>

</ul>

</div>

</div>

</div>


<!-- =========================================================
PENGERTIAN
========================================================= -->

<div id="pengertian" class="box">

<h2>📖 Pengertian Transformasi Fungsi</h2>

<div class="intro">

<p>
Transformasi merupakan perubahan posisi atau ukuran suatu objek,
baik berupa titik, garis, kurva, ataupun bidang.
</p>

<p>
Transformasi fungsi merupakan proses mengubah posisi atau bentuk
grafik suatu fungsi melalui operasi tertentu tanpa menghilangkan
karakteristik dasar fungsi tersebut.
</p>

</div>


<div class="definition">

<div class="definition-title">
📌 Kesimpulan
</div>

<p>
Transformasi fungsi merupakan perubahan posisi atau bentuk grafik
suatu fungsi pada bidang Kartesius melalui operasi tertentu.
Transformasi dapat digunakan untuk mengetahui bagaimana suatu
grafik berubah ketika digeser, dicerminkan, diperbesar,
diperkecil, atau diputar.
</p>

</div>


<h3>🔄 Jenis-Jenis Transformasi Fungsi</h3>

<div class="transform-grid">


<div class="transform-card"
onclick="show('translasi',document.querySelectorAll('.tab')[2])">

<div class="transform-icon">🔵</div>

<h3>Translasi</h3>

<p>
Menggeser grafik tanpa mengubah bentuknya.
</p>

</div>


<div class="transform-card"
onclick="show('refleksi',document.querySelectorAll('.tab')[3])">

<div class="transform-icon">🔵</div>

<h3>Refleksi</h3>

<p>
Mencerminkan grafik terhadap sumbu.
</p>

</div>


<div class="transform-card"
onclick="show('dilatasi',document.querySelectorAll('.tab')[4])">

<div class="transform-icon">🔵</div>

<h3>Dilatasi</h3>

<p>
Mengubah ukuran grafik.
</p>

</div>


<div class="transform-card"
onclick="show('rotasi',document.querySelectorAll('.tab')[5])">

<div class="transform-icon">🔵</div>

<h3>Rotasi</h3>

<p>
Memutar grafik terhadap pusat tertentu.
</p>

</div>

</div>

</div>


<!-- =========================================================
TRANSLASI
========================================================= -->

<div id="translasi" class="box">

<h2>🔵 1. Translasi (Pergeseran)</h2>

<div class="intro">

<p>
Translasi adalah transformasi yang memindahkan setiap titik
pada grafik dengan arah dan jarak tertentu.
</p>

<p>
Bentuk grafik tetap sama, tetapi posisinya berubah.
Translasi dapat dilakukan secara vertikal maupun horizontal.
</p>

</div>


<!-- ATAS -->

<div class="submateri">

<div class="submateri-title">
⬆️ a. Translasi Vertikal ke Atas
</div>

<p>
Translasi vertikal ke atas menyebabkan setiap titik pada grafik
bergerak ke atas sejauh b satuan.
</p>

<div class="rumus">

g(x) = f(x) + b

<small>
b &gt; 0 → grafik bergeser ke atas
</small>

</div>


<div class="graph-box">

<div class="graph-title">
📈 Atur nilai translasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasAtas"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Jarak ke atas (b)</label>

<input
type="range"
id="sliderAtas"
min="0"
max="6"
step="1"
value="2"
oninput="drawAtas()">

<span class="value" id="nilaiAtas">2</span>

</div>


<div class="formula-display"
id="formulaAtas">

g(x) = x² + 2

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(x) + b

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui fungsi f(x) = x². Grafik ditranslasikan 2 satuan
ke atas. Tentukan fungsi hasil transformasinya.
</p>

<div class="langkah">

<strong>Langkah 1:</strong><br>

Gunakan rumus:

<br>

g(x) = f(x) + b

</div>


<div class="langkah">

<strong>Langkah 2:</strong><br>

Karena b = 2:

<br>

g(x) = x² + 2

</div>


<div class="jawaban">

Jadi, g(x) = x² + 2.

</div>

</div>

</div>


<!-- BAWAH -->

<div class="submateri">

<div class="submateri-title">
⬇️ b. Translasi Vertikal ke Bawah
</div>

<p>
Translasi vertikal ke bawah menyebabkan grafik bergeser ke bawah
sejauh b satuan.
</p>

<div class="rumus">

g(x) = f(x) - b

<small>
b &gt; 0 → grafik bergeser ke bawah
</small>

</div>


<div class="graph-box">

<div class="graph-title">
📉 Atur nilai translasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasBawah"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Jarak ke bawah (b)</label>

<input
type="range"
id="sliderBawah"
min="0"
max="6"
step="1"
value="3"
oninput="drawBawah()">

<span class="value"
id="nilaiBawah">3</span>

</div>


<div class="formula-display"
id="formulaBawah">

g(x) = x² - 3

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(x) - b

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui f(x) = x². Grafik digeser 3 satuan ke bawah.
</p>

<div class="langkah">

g(x) = f(x) - b

<br>

g(x) = x² - 3

</div>


<div class="jawaban">

Jadi, g(x) = x² - 3.

</div>

</div>

</div>


<!-- KANAN -->

<div class="submateri">

<div class="submateri-title">
➡️ c. Translasi Horizontal ke Kanan
</div>

<p>
Translasi horizontal ke kanan menggeser grafik sejauh a satuan
tanpa mengubah bentuk grafik.
</p>

<div class="rumus">

g(x) = f(x - a)

<small>
a &gt; 0 → grafik bergeser ke kanan
</small>

</div>


<div class="graph-box">

<div class="graph-title">
➡️ Atur nilai translasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasKanan"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Jarak ke kanan (a)</label>

<input
type="range"
id="sliderKanan"
min="0"
max="6"
step="1"
value="3"
oninput="drawKanan()">

<span class="value"
id="nilaiKanan">3</span>

</div>


<div class="formula-display"
id="formulaKanan">

g(x) = (x - 3)²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(x - a)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Grafik f(x) = x² digeser 3 satuan ke kanan.
</p>

<div class="langkah">

g(x) = f(x - a)

<br>

g(x) = f(x - 3)

<br>

g(x) = (x - 3)²

</div>


<div class="jawaban">

Jadi, g(x) = (x - 3)².

</div>

</div>

</div>


<!-- KIRI -->

<div class="submateri">

<div class="submateri-title">
⬅️ d. Translasi Horizontal ke Kiri
</div>

<p>
Translasi horizontal ke kiri menggeser grafik sejauh a satuan
ke arah kiri.
</p>

<div class="rumus">

g(x) = f(x + a)

<small>
a &gt; 0 → grafik bergeser ke kiri
</small>

</div>


<div class="graph-box">

<div class="graph-title">
⬅️ Atur nilai translasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasKiri"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Jarak ke kiri (a)</label>

<input
type="range"
id="sliderKiri"
min="0"
max="6"
step="1"
value="3"
oninput="drawKiri()">

<span class="value"
id="nilaiKiri">3</span>

</div>


<div class="formula-display"
id="formulaKiri">

g(x) = (x + 3)²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(x + a)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Grafik f(x) = x² digeser 3 satuan ke kiri.
</p>

<div class="langkah">

g(x) = f(x + a)

<br>

g(x) = f(x + 3)

<br>

g(x) = (x + 3)²

</div>


<div class="jawaban">

Jadi, g(x) = (x + 3)².

</div>

</div>

</div>

</div>


<!-- =========================================================
REFLEKSI
========================================================= -->

<div id="refleksi" class="box">

<h2>🔵 2. Refleksi (Pencerminan)</h2>

<div class="intro">

<p>
Refleksi adalah transformasi yang mencerminkan grafik terhadap
suatu sumbu sehingga grafik hasil memiliki jarak yang sama
terhadap sumbu pencerminan.
</p>

</div>


<!-- REFLEKSI X -->

<div class="submateri">

<div class="submateri-title">
↕️ a. Refleksi terhadap Sumbu X
</div>

<p>
Pada refleksi terhadap sumbu X, nilai y berubah tanda,
sedangkan nilai x tetap.
</p>

<div class="rumus">

g(x) = -f(x)

<small>
(x,y) → (x,-y)
</small>

</div>


<div class="graph-box">

<div class="graph-title">
↕️ Atur persentase untuk melihat proses pencerminan
</div>

<div class="graph-container">

<canvas id="canvasRefleksiX"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Derajat pencerminan</label>

<input
type="range"
id="sliderRefleksiX"
min="0"
max="100"
step="5"
value="100"
oninput="drawRefleksiX()">

<span class="value"
id="nilaiRefleksiX">

100%

</span>

</div>


<div class="formula-display"
id="formulaRefleksiX">

g(x) = -x²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = -f(x)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui f(x) = x². Tentukan hasil refleksi terhadap
sumbu X.
</p>

<div class="langkah">

Rumus:

<br>

g(x) = -f(x)

</div>


<div class="langkah">

Substitusi:

<br>

g(x) = -(x²)

</div>


<div class="jawaban">

Jadi, g(x) = -x².

</div>

</div>

</div>


<!-- REFLEKSI Y -->

<div class="submateri">

<div class="submateri-title">
↔️ b. Refleksi terhadap Sumbu Y
</div>

<p>
Pada refleksi terhadap sumbu Y, nilai x berubah tanda,
sedangkan nilai y tetap.
</p>

<div class="rumus">

g(x) = f(-x)

<small>
(x,y) → (-x,y)
</small>

</div>


<div class="graph-box">

<div class="graph-title">
↔️ Atur persentase untuk melihat proses pencerminan
</div>

<div class="graph-container">

<canvas id="canvasRefleksiY"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Derajat pencerminan</label>

<input
type="range"
id="sliderRefleksiY"
min="0"
max="100"
step="5"
value="100"
oninput="drawRefleksiY()">

<span class="value"
id="nilaiRefleksiY">

100%

</span>

</div>


<div class="formula-display"
id="formulaRefleksiY">

g(x) = (-x - 2)²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = (x - 2)²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(-x)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui f(x) = (x - 2)². Tentukan hasil refleksi
terhadap sumbu Y.
</p>

<div class="langkah">

g(x) = f(-x)

</div>


<div class="langkah">

g(x) = (-x - 2)²

</div>


<div class="jawaban">

Jadi, g(x) = (-x - 2)².

</div>

</div>

</div>

</div>


<!-- =========================================================
DILATASI
========================================================= -->

<div id="dilatasi" class="box">

<h2>🔵 3. Dilatasi (Perubahan Ukuran)</h2>

<div class="intro">

<p>
Dilatasi merupakan transformasi yang mengubah ukuran grafik
berdasarkan suatu faktor skala tertentu.
</p>

<p>
Dilatasi dapat terjadi secara vertikal maupun horizontal.
</p>

</div>


<!-- DILATASI V -->

<div class="submateri">

<div class="submateri-title">
↕️ a. Dilatasi Vertikal
</div>

<p>
Dilatasi vertikal mengubah nilai y pada grafik. Jika faktor
dilatasi semakin besar, grafik semakin tinggi atau semakin
jauh dari sumbu X.
</p>

<div class="rumus">

g(x) = k · f(x)

<small>

k &gt; 1 → grafik diperbesar secara vertikal

<br>

0 &lt; k &lt; 1 → grafik diperkecil secara vertikal

</small>

</div>


<div class="graph-box">

<div class="graph-title">
↕️ Atur faktor dilatasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasDilatasiV"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Faktor dilatasi (k)</label>

<input
type="range"
id="sliderDilatasiV"
min="0.5"
max="5"
step="0.5"
value="2"
oninput="drawDilatasiV()">

<span class="value"
id="nilaiDilatasiV">

2×

</span>

</div>


<div class="formula-display"
id="formulaDilatasiV">

g(x) = 2x²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = kf(x)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui f(x) = x². Grafik mengalami dilatasi vertikal
dengan faktor skala 4.
</p>

<div class="langkah">

Rumus:

<br>

g(x) = kf(x)

</div>


<div class="langkah">

Substitusi k = 4:

<br>

g(x) = 4(x²)

<br>

g(x) = 4x²

</div>


<div class="jawaban">

Jadi, g(x) = 4x².

</div>

</div>

</div>


<!-- DILATASI H -->

<div class="submateri">

<div class="submateri-title">
↔️ b. Dilatasi Horizontal
</div>

<p>
Dilatasi horizontal mengubah posisi titik-titik pada arah
horizontal atau sejajar sumbu X.
</p>

<div class="rumus">

g(x) = f(x / k)

<small>

k &gt; 1 → grafik melebar secara horizontal

<br>

0 &lt; k &lt; 1 → grafik menyempit secara horizontal

</small>

</div>


<div class="graph-box">

<div class="graph-title">
↔️ Atur faktor dilatasi untuk melihat perubahan grafik
</div>

<div class="graph-container">

<canvas id="canvasDilatasiH"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Faktor dilatasi (k)</label>

<input
type="range"
id="sliderDilatasiH"
min="0.5"
max="5"
step="0.5"
value="2"
oninput="drawDilatasiH()">

<span class="value"
id="nilaiDilatasiH">

2×

</span>

</div>


<div class="formula-display"
id="formulaDilatasiH">

g(x) = (x / 2)²

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

f(x) = x²

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

g(x) = f(x / k)

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal
</div>

<p>
Diketahui f(x) = x². Grafik mengalami dilatasi horizontal
dengan faktor 2.
</p>

<div class="langkah">

Rumus:

<br>

g(x) = f(x / k)

</div>


<div class="langkah">

Substitusi:

<br>

g(x) = f(x / 2)

<br>

g(x) = (x / 2)²

<br>

g(x) = x² / 4

</div>


<div class="jawaban">

Jadi, g(x) = x² / 4.

</div>

</div>

</div>

</div>


<!-- =========================================================
ROTASI
========================================================= -->

<div id="rotasi" class="box">

<h2>🔵 4. Rotasi (Perputaran)</h2>

<div class="intro">

<p>
Rotasi merupakan transformasi yang memutar suatu grafik terhadap
titik pusat tertentu dengan besar sudut tertentu.
</p>

<p>
Rotasi berlawanan arah jarum jam bernilai positif, sedangkan
rotasi searah jarum jam bernilai negatif.
</p>

</div>


<div class="rumus">

Rotasi θ terhadap pusat (0,0):

<br><br>

x' = x cos θ - y sin θ

<br>

y' = x sin θ + y cos θ

</div>


<div class="highlight">

<strong>Perhatikan:</strong>

Pada bagian ini yang diputar adalah
<strong>grafik fungsi</strong>, bukan hanya satu titik.
Atur slider untuk melihat perubahan grafik dari -360°
sampai 360°.

</div>


<div class="submateri">

<div class="submateri-title">
🔄 Visualisasi Rotasi Grafik Fungsi
</div>

<p>

Sebagai contoh digunakan fungsi kuadrat
<strong>y = x² - 2</strong>. Grafik akan diputar terhadap
titik pusat O(0,0).

</p>


<div class="graph-box">

<div class="graph-title">
🔄 Atur sudut rotasi untuk melihat perubahan posisi grafik
</div>

<div class="graph-container">

<canvas id="canvasRotasi"></canvas>

</div>


<div class="control-panel">

<div class="control-row">

<label>Sudut rotasi</label>

<input
type="range"
id="sliderRotasi"
min="-360"
max="360"
step="5"
value="0"
oninput="drawRotasi()">

<span class="value"
id="nilaiRotasi">

0°

</span>

</div>


<div class="formula-display"
id="formulaRotasi">

Rotasi grafik y = x² - 2 sebesar 0°

</div>

</div>


<div class="legend">

<div class="legend-item">

<span class="legend-line original"></span>

Grafik awal

</div>


<div class="legend-item">

<span class="legend-line transform"></span>

Grafik hasil rotasi

</div>

</div>

</div>


<div class="contoh">

<div class="contoh-title">
💡 Contoh Soal Rotasi 180°
</div>

<p>

Diketahui grafik fungsi y = x² - 2 diputar 180°
terhadap titik pusat O(0,0).

</p>


<div class="langkah">

Rotasi 180° memiliki aturan:

<br><br>

(x,y) → (-x,-y)

</div>


<div class="langkah">

Untuk grafik:

<br>

y = x² - 2

<br><br>

Setelah rotasi 180°, posisi grafik berubah sehingga grafik
berada pada sisi berlawanan terhadap titik pusat.

</div>


<div class="jawaban">

Visualisasi pada grafik menunjukkan perubahan posisi grafik
sebagai akibat rotasi 180°.

</div>

</div>

</div>

</div>


<!-- =========================================================
RINGKASAN
========================================================= -->

<div id="ringkasan" class="box">

<h2>📋 Ringkasan Transformasi Fungsi</h2>

<p>
Gunakan tabel berikut untuk mengingat bentuk dasar transformasi
fungsi.
</p>


<div class="table-wrapper">

<table>

<tr>

<th>Transformasi</th>

<th>Bentuk Fungsi</th>

<th>Keterangan</th>

</tr>


<tr>

<td>Translasi Atas</td>

<td>g(x) = f(x) + b</td>

<td>Naik b satuan</td>

</tr>


<tr>

<td>Translasi Bawah</td>

<td>g(x) = f(x) - b</td>

<td>Turun b satuan</td>

</tr>


<tr>

<td>Translasi Kanan</td>

<td>g(x) = f(x - a)</td>

<td>Ke kanan a satuan</td>

</tr>


<tr>

<td>Translasi Kiri</td>

<td>g(x) = f(x + a)</td>

<td>Ke kiri a satuan</td>

</tr>


<tr>

<td>Refleksi Sumbu X</td>

<td>g(x) = -f(x)</td>

<td>Pencerminan terhadap X</td>

</tr>


<tr>

<td>Refleksi Sumbu Y</td>

<td>g(x) = f(-x)</td>

<td>Pencerminan terhadap Y</td>

</tr>


<tr>

<td>Dilatasi Vertikal</td>

<td>g(x) = kf(x)</td>

<td>Mengubah ukuran vertikal</td>

</tr>


<tr>

<td>Dilatasi Horizontal</td>

<td>g(x) = f(x / k)</td>

<td>Mengubah ukuran horizontal</td>

</tr>


<tr>

<td>Rotasi</td>

<td>
x' = x cos θ - y sin θ
</td>

<td>Memutar grafik</td>

</tr>

</table>

</div>


<div class="highlight">

<strong>💡 Ingat:</strong>

<br><br>

🔵 <strong>Translasi</strong> → menggeser grafik.

<br>

🔵 <strong>Refleksi</strong> → mencerminkan grafik.

<br>

🔵 <strong>Dilatasi</strong> → mengubah ukuran grafik.

<br>

🔵 <strong>Rotasi</strong> → memutar grafik.

</div>

</div>

</div>


<!-- =========================================================
KEMBALI
========================================================= -->

<div class="back-btn">

<a href="http://localhost/SKRIPSI/Untitled-1.php">
← Kembali
</a>

</div>


<div class="footer">

© 2026 Media Pembelajaran Transformasi Fungsi

</div>


<script>


/* =========================================================
   NAVIGASI
   DIPERBAIKI AGAR CANVAS TIDAK 0 x 0
========================================================= */

function show(id,el){

    /* sembunyikan semua box */

    document.querySelectorAll(".box").forEach(box=>{
        box.classList.remove("active");
    });


    /* tampilkan box yang dipilih */

    const currentBox=document.getElementById(id);

    currentBox.classList.add("active");


    /* atur tombol aktif */

    document.querySelectorAll(".tab").forEach(btn=>{
        btn.classList.remove("active");
    });

    el.classList.add("active");


    /* scroll ke atas */

    window.scrollTo({
        top:0,
        behavior:"smooth"
    });


    /*
       PENTING:
       canvas harus digambar setelah box menjadi
       display:block agar width dan height terbaca benar.
    */

    setTimeout(()=>{

        if(id==="translasi"){

            drawAtas();
            drawBawah();
            drawKanan();
            drawKiri();

        }


        if(id==="refleksi"){

            drawRefleksiX();
            drawRefleksiY();

        }


        if(id==="dilatasi"){

            drawDilatasiV();
            drawDilatasiH();

        }


        if(id==="rotasi"){

            drawRotasi();

        }

    },80);

}


/* =========================================================
   SISTEM CANVAS
========================================================= */

function setupCanvas(id){

    const canvas=document.getElementById(id);

    const rect=canvas.getBoundingClientRect();

    const dpr=window.devicePixelRatio || 1;

    const width=rect.width;

    const height=rect.height;


    /*
       Mencegah canvas berukuran 0
       jika browser belum selesai menghitung ukuran.
    */

    if(width<=0 || height<=0){

        return null;

    }


    canvas.width=width*dpr;

    canvas.height=height*dpr;


    const ctx=canvas.getContext("2d");

    ctx.setTransform(dpr,0,0,dpr,0,0);


    const scale=Math.min(
        width/18,
        height/12
    );


    const centerX=width/2;

    const centerY=height/2;


    ctx.clearRect(
        0,
        0,
        width,
        height
    );


    /* =====================================================
       BACKGROUND
    ===================================================== */

    ctx.fillStyle="#f8fbff";

    ctx.fillRect(
        0,
        0,
        width,
        height
    );


    /* =====================================================
       GRID
    ===================================================== */

    ctx.strokeStyle="#dbeafe";

    ctx.lineWidth=1;


    const minX=
        Math.floor(-centerX/scale)-1;

    const maxX=
        Math.ceil((width-centerX)/scale)+1;

    const minY=
        Math.floor(-(height-centerY)/scale)-1;

    const maxY=
        Math.ceil(centerY/scale)+1;


    for(let i=minX;i<=maxX;i++){

        const px=
            centerX+i*scale;

        ctx.beginPath();

        ctx.moveTo(px,0);

        ctx.lineTo(px,height);

        ctx.stroke();

    }


    for(let i=minY;i<=maxY;i++){

        const py=
            centerY-i*scale;

        ctx.beginPath();

        ctx.moveTo(0,py);

        ctx.lineTo(width,py);

        ctx.stroke();

    }


    /* =====================================================
       SUMBU X
    ===================================================== */

    ctx.strokeStyle="#555";

    ctx.lineWidth=2;

    ctx.beginPath();

    ctx.moveTo(
        0,
        centerY
    );

    ctx.lineTo(
        width,
        centerY
    );

    ctx.stroke();


    /* =====================================================
       SUMBU Y
    ===================================================== */

    ctx.beginPath();

    ctx.moveTo(
        centerX,
        0
    );

    ctx.lineTo(
        centerX,
        height
    );

    ctx.stroke();


    /* =====================================================
       ANGKA
    ===================================================== */

    ctx.fillStyle="#666";

    ctx.font="11px Segoe UI";


    for(let i=minX;i<=maxX;i++){

        if(i===0) continue;

        const px=
            centerX+i*scale;


        if(
            px>5 &&
            px<width-20
        ){

            ctx.fillText(
                i,
                px-4,
                centerY+15
            );

        }

    }


    for(let i=minY;i<=maxY;i++){

        if(i===0) continue;

        const py=
            centerY-i*scale;


        if(
            py>10 &&
            py<height-5
        ){

            ctx.fillText(
                i,
                centerX+7,
                py+4
            );

        }

    }


    /* =====================================================
       LABEL SUMBU
    ===================================================== */

    ctx.font="bold 13px Segoe UI";

    ctx.fillStyle="#444";


    ctx.fillText(
        "x",
        width-18,
        centerY-8
    );


    ctx.fillText(
        "y",
        centerX+8,
        15
    );


    return{

        ctx,
        width,
        height,
        scale,
        centerX,
        centerY

    };

}


/* =========================================================
   GAMBAR FUNGSI
========================================================= */

function drawFunction(
    graph,
    func,
    dashed=false
){

    if(!graph) return;


    const ctx=graph.ctx;

    const scale=graph.scale;

    const centerX=graph.centerX;

    const centerY=graph.centerY;


    ctx.save();

    ctx.beginPath();


    ctx.strokeStyle=
        dashed
        ? "#777"
        : "#2563eb";


    ctx.lineWidth=
        dashed
        ? 2.2
        : 3.2;


    if(dashed){

        ctx.setLineDash([
            7,
            6
        ]);

    }


    let started=false;


    for(
        let px=0;
        px<=graph.width;
        px+=1
    ){

        const x=
            (px-centerX)/scale;


        let y;


        try{

            y=func(x);

        }

        catch(e){

            started=false;

            continue;

        }


        const py=
            centerY-y*scale;


        if(
            !Number.isFinite(py) ||
            py < -graph.height*3 ||
            py > graph.height*4
        ){

            started=false;

            continue;

        }


        if(!started){

            ctx.moveTo(
                px,
                py
            );

            started=true;

        }

        else{

            ctx.lineTo(
                px,
                py
            );

        }

    }


    ctx.stroke();

    ctx.restore();

}


/* =========================================================
   TRANSLASI ATAS
========================================================= */

function drawAtas(){

    const slider=
        document.getElementById(
            "sliderAtas"
        );


    if(!slider) return;


    const b=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiAtas"
    ).innerText=b;


    document.getElementById(
        "formulaAtas"
    ).innerText=
        "g(x) = x² + "+b;


    const graph=
        setupCanvas(
            "canvasAtas"
        );


    if(!graph) return;


    /* grafik awal */

    drawFunction(
        graph,
        x=>x*x,
        true
    );


    /* grafik hasil */

    drawFunction(
        graph,
        x=>x*x+b
    );

}


/* =========================================================
   TRANSLASI BAWAH
========================================================= */

function drawBawah(){

    const slider=
        document.getElementById(
            "sliderBawah"
        );


    if(!slider) return;


    const b=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiBawah"
    ).innerText=b;


    document.getElementById(
        "formulaBawah"
    ).innerText=
        "g(x) = x² - "+b;


    const graph=
        setupCanvas(
            "canvasBawah"
        );


    if(!graph) return;


    drawFunction(
        graph,
        x=>x*x,
        true
    );


    drawFunction(
        graph,
        x=>x*x-b
    );

}


/* =========================================================
   TRANSLASI KANAN
========================================================= */

function drawKanan(){

    const slider=
        document.getElementById(
            "sliderKanan"
        );


    if(!slider) return;


    const a=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiKanan"
    ).innerText=a;


    document.getElementById(
        "formulaKanan"
    ).innerText=
        "g(x) = (x - "+a+")²";


    const graph=
        setupCanvas(
            "canvasKanan"
        );


    if(!graph) return;


    drawFunction(
        graph,
        x=>x*x,
        true
    );


    drawFunction(
        graph,
        x=>(x-a)*(x-a)
    );

}


/* =========================================================
   TRANSLASI KIRI
========================================================= */

function drawKiri(){

    const slider=
        document.getElementById(
            "sliderKiri"
        );


    if(!slider) return;


    const a=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiKiri"
    ).innerText=a;


    document.getElementById(
        "formulaKiri"
    ).innerText=
        "g(x) = (x + "+a+")²";


    const graph=
        setupCanvas(
            "canvasKiri"
        );


    if(!graph) return;


    drawFunction(
        graph,
        x=>x*x,
        true
    );


    drawFunction(
        graph,
        x=>(x+a)*(x+a)
    );

}


/* =========================================================
   REFLEKSI X
========================================================= */

function drawRefleksiX(){

    const slider=
        document.getElementById(
            "sliderRefleksiX"
        );


    if(!slider) return;


    const persen=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiRefleksiX"
    ).innerText=
        persen+"%";


    const t=
        persen/100;


    const graph=
        setupCanvas(
            "canvasRefleksiX"
        );


    if(!graph) return;


    /* grafik awal */

    drawFunction(
        graph,
        x=>x*x,
        true
    );


    /*
       Interpolasi dari grafik awal
       menuju grafik hasil refleksi.
    */

    drawFunction(
        graph,
        x=>x*x*(1-2*t)
    );


    document.getElementById(
        "formulaRefleksiX"
    ).innerText=
        t===1
        ? "g(x) = -x²"
        : "Proses refleksi: "+persen+"%";

}


/* =========================================================
   REFLEKSI Y
========================================================= */

function drawRefleksiY(){

    const slider=
        document.getElementById(
            "sliderRefleksiY"
        );


    if(!slider) return;


    const persen=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiRefleksiY"
    ).innerText=
        persen+"%";


    const t=
        persen/100;


    const graph=
        setupCanvas(
            "canvasRefleksiY"
        );


    if(!graph) return;


    /*
       Fungsi tidak simetris agar
       refleksi terhadap sumbu Y terlihat jelas.
    */

    const original=
        x=>(x-2)*(x-2);


    drawFunction(
        graph,
        original,
        true
    );


    /*
       Perubahan posisi grafik
       dari awal menuju hasil refleksi.
    */

    drawFunction(
        graph,
        x=>{

            const reflected=-x;

            const current=
                x*(1-t)+
                reflected*t;

            return original(current);

        }
    );


    document.getElementById(
        "formulaRefleksiY"
    ).innerText=
        t===1
        ? "g(x) = (-x - 2)²"
        : "Proses refleksi: "+persen+"%";

}


/* =========================================================
   DILATASI VERTIKAL
========================================================= */

function drawDilatasiV(){

    const slider=
        document.getElementById(
            "sliderDilatasiV"
        );


    if(!slider) return;


    const k=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiDilatasiV"
    ).innerText=
        k+"×";


    document.getElementById(
        "formulaDilatasiV"
    ).innerText=
        "g(x) = "+k+"x²";


    const graph=
        setupCanvas(
            "canvasDilatasiV"
        );


    if(!graph) return;


    drawFunction(
        graph,
        x=>x*x,
        true
    );


    drawFunction(
        graph,
        x=>k*x*x
    );

}


/* =========================================================
   DILATASI HORIZONTAL
========================================================= */

function drawDilatasiH(){

    const slider=
        document.getElementById(
            "sliderDilatasiH"
        );


    if(!slider) return;


    const k=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiDilatasiH"
    ).innerText=
        k+"×";


    document.getElementById(
        "formulaDilatasiH"
    ).innerText=
        "g(x) = (x / "+k+")²";


    const graph=
        setupCanvas(
            "canvasDilatasiH"
        );


    if(!graph) return;


    drawFunction(
        graph,
        x=>x*x,
        true
    );


    /*
       Sesuai dengan rumus:

       g(x) = f(x/k)

       Untuk f(x)=x²:

       g(x) = (x/k)²
    */

    drawFunction(
        graph,
        x=>(x/k)*(x/k)
    );

}


/* =========================================================
   ROTASI GRAFIK FUNGSI
========================================================= */

function drawRotasi(){

    const slider=
        document.getElementById(
            "sliderRotasi"
        );


    if(!slider) return;


    const angle=
        parseFloat(slider.value);


    document.getElementById(
        "nilaiRotasi"
    ).innerText=
        angle+"°";


    document.getElementById(
        "formulaRotasi"
    ).innerText=
        "Rotasi grafik y = x² - 2 sebesar "
        +angle+"°";


    const graph=
        setupCanvas(
            "canvasRotasi"
        );


    if(!graph) return;


    const ctx=graph.ctx;

    const scale=graph.scale;

    const cx=graph.centerX;

    const cy=graph.centerY;


    /* =====================================================
       GRAFIK AWAL
    ===================================================== */

    drawFunction(
        graph,
        x=>x*x-2,
        true
    );


    /* =====================================================
       SUDUT RADIAN
    ===================================================== */

    const rad=
        angle*Math.PI/180;


    const cos=
        Math.cos(rad);

    const sin=
        Math.sin(rad);


    /* =====================================================
       GRAFIK HASIL ROTASI
    ===================================================== */

    ctx.save();

    ctx.beginPath();

    ctx.strokeStyle="#2563eb";

    ctx.lineWidth=3.2;


    let started=false;


    for(
        let x=-6;
        x<=6;
        x+=0.015
    ){

        const y=
            x*x-2;


        /*
           Matriks rotasi:

           x' = x cosθ - y sinθ
           y' = x sinθ + y cosθ
        */


        const newX=
            x*cos-y*sin;


        const newY=
            x*sin+y*cos;


        const px=
            cx+newX*scale;


        const py=
            cy-newY*scale;


        if(
            px < -50 ||
            px > graph.width+50 ||
            py < -50 ||
            py > graph.height+50
        ){

            started=false;

            continue;

        }


        if(!started){

            ctx.moveTo(
                px,
                py
            );

            started=true;

        }

        else{

            ctx.lineTo(
                px,
                py
            );

        }

    }


    ctx.stroke();

    ctx.restore();


    /* =====================================================
       TITIK PUSAT ROTASI
    ===================================================== */

    ctx.fillStyle="#1d4ed8";

    ctx.beginPath();

    ctx.arc(
        cx,
        cy,
        4,
        0,
        Math.PI*2
    );

    ctx.fill();

}


/* =========================================================
   RESPONSIVE RESIZE
========================================================= */

let resizeTimer;


window.addEventListener(
    "resize",
    ()=>{

        clearTimeout(
            resizeTimer
        );


        resizeTimer=
            setTimeout(()=>{

                drawAtas();

                drawBawah();

                drawKanan();

                drawKiri();

                drawRefleksiX();

                drawRefleksiY();

                drawDilatasiV();

                drawDilatasiH();

                drawRotasi();

            },150);

    }
);


/* =========================================================
   JALANKAN SAAT HALAMAN SELESAI DIMUAT
========================================================= */

window.addEventListener(
    "load",
    ()=>{

        /*
           Nilai slider langsung digunakan
           sehingga grafik mempunyai kondisi awal.
        */

        drawAtas();

        drawBawah();

        drawKanan();

        drawKiri();

        drawRefleksiX();

        drawRefleksiY();

        drawDilatasiV();

        drawDilatasiH();

        drawRotasi();

    }
);

</script>

</body>

</html>