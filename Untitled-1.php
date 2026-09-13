<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Transformasi Fungsi | Media Pembelajaran</title>

<style>

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Segoe UI', Arial, sans-serif;
    background:#f8fbff;
    color:#252525;
    overflow-x:hidden;
}


/* =========================================================
   HEADER
========================================================= */

header{
    height:72px;
    padding:0 35px 0 80px;

    display:flex;
    justify-content:flex-end;
    align-items:center;

    background:#2563eb;

    position:relative;
    z-index:10;

    box-shadow:0 5px 20px rgba(37,99,235,.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
}

.logo img{
    width:44px;
    height:auto;
}

.logo-text{
    font-size:18px;
    font-weight:800;
    color:white;
    letter-spacing:.5px;
}


/* =========================================================
   HAMBURGER
========================================================= */

.menu-toggle{
    position:fixed;
    top:15px;
    left:16px;

    width:44px;
    height:42px;

    border:none;
    background:white;
    border-radius:12px;

    cursor:pointer;
    z-index:1202;

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:5px;

    box-shadow:0 7px 20px rgba(0,0,0,.16);

    transition:.25s;
}

.menu-toggle:hover{
    transform:scale(1.05);
}

.menu-toggle span{
    width:21px;
    height:3px;

    background:#2563eb;
    border-radius:5px;
}


/* =========================================================
   OVERLAY
========================================================= */

.overlay{
    position:fixed;
    inset:0;

    background:rgba(15,23,42,.5);

    opacity:0;
    visibility:hidden;

    transition:.3s;
    z-index:1200;
}

.overlay.active{
    opacity:1;
    visibility:visible;
}


/* =========================================================
   SIDE MENU
========================================================= */

.side-menu{
    position:fixed;

    top:0;
    left:-285px;

    width:285px;
    height:100vh;

    background:white;

    z-index:1201;

    box-shadow:12px 0 35px rgba(0,0,0,.18);

    transition:left .3s ease;

    display:flex;
    flex-direction:column;

    padding:20px 15px;

    overflow-y:auto;
}

.side-menu.active{
    left:0;
}


/* =========================================================
   SIDE HEADER
========================================================= */

.side-head{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding-bottom:15px;
    margin-bottom:15px;

    border-bottom:1px solid #dbeafe;
}

.side-head h3{
    color:#1d4ed8;
    font-size:18px;
}

.close-btn{
    border:none;

    width:35px;
    height:35px;

    border-radius:10px;

    background:#dbeafe;
    color:#1d4ed8;

    font-size:21px;
    font-weight:bold;

    cursor:pointer;

    transition:.2s;
}

.close-btn:hover{
    background:#2563eb;
    color:white;
}


/* =========================================================
   MENU
========================================================= */

.side-menu > ul{
    list-style:none;

    display:flex;
    flex-direction:column;

    gap:8px;
}

.side-menu a{
    display:block;

    text-decoration:none;

    color:#374151;

    font-weight:700;

    background:#f8fbff;

    border:1px solid #dbeafe;

    padding:12px 14px;

    border-radius:12px;

    transition:.25s;

    font-size:14px;
}

.side-menu a:hover{
    background:#2563eb;
    color:white;
    border-color:#2563eb;

    transform:translateX(3px);
}


/* =========================================================
   SUBMENU
========================================================= */

.has-submenu > a{
    position:relative;
}

.has-submenu > a::after{
    content:"▾";

    position:absolute;
    right:14px;

    color:#1d4ed8;

    transition:.25s;
}

.has-submenu.open > a::after{
    transform:rotate(180deg);
}

.submenu-side{
    list-style:none;

    padding-left:10px;
    margin-top:7px;

    max-height:0;

    overflow:hidden;
    opacity:0;

    transform:translateY(-8px);

    transition:.3s ease;
}

.has-submenu.open .submenu-side{
    max-height:500px;

    opacity:1;

    transform:translateY(0);
}

.submenu-side li{
    margin-bottom:7px;
}

.submenu-side a{
    background:#f8fbff;

    color:#6b7280;

    font-size:13px;

    padding:10px 12px;

    display:flex;
    align-items:center;
    gap:9px;
}

.submenu-side a:hover{
    background:#dbeafe;
    color:#1d4ed8;
}


/* =========================================================
   ICON SUBMENU VISUALISASI
========================================================= */

.menu-visual-icon{
    width:30px;
    height:30px;

    min-width:30px;

    display:flex;

    justify-content:center;
    align-items:center;

    border-radius:9px;

    color:white;

    font-size:16px;
    font-weight:bold;
}

.menu-translasi{
    background:#2563eb;
}

.menu-refleksi{
    background:#1d4ed8;
}

.menu-dilatasi{
    background:#3b82f6;
}

.menu-rotasi{
    background:#1e40af;
}


/* =========================================================
   HERO
========================================================= */

.hero{
    position:relative;

    min-height:390px;

    display:flex;

    justify-content:center;
    align-items:center;

    text-align:center;

    padding:65px 20px 55px;

    overflow:hidden;

    background:#dbeafe;
}

.hero::before{
    content:"";

    position:absolute;

    width:180px;
    height:180px;

    border-radius:50%;

    background:rgba(255,255,255,.35);

    top:-70px;
    left:-50px;
}

.hero::after{
    content:"";

    position:absolute;

    width:220px;
    height:220px;

    border-radius:50%;

    background:rgba(255,255,255,.3);

    right:-80px;
    bottom:-100px;
}


/* =========================================================
   HERO CONTENT
========================================================= */

.hero-content{
    position:relative;
    z-index:2;

    max-width:820px;
}

.hero-badge{
    display:inline-block;

    background:white;

    color:#1d4ed8;

    padding:8px 18px;

    border-radius:30px;

    font-size:13px;
    font-weight:700;

    margin-bottom:18px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.hero-content h1{
    font-size:38px;

    line-height:1.25;

    color:#222;

    margin-bottom:18px;

    font-weight:800;
}

.hero-content h1 span{
    color:#2563eb;
}

.hero-content p{
    max-width:650px;

    margin:0 auto 25px;

    color:#374151;

    font-size:16px;

    line-height:1.7;
}


/* =========================================================
   BUTTON HERO
========================================================= */

.hero-btn{
    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:13px 25px;

    background:#2563eb;

    color:white;

    text-decoration:none;

    border-radius:14px;

    font-weight:700;

    box-shadow:0 8px 20px rgba(37,99,235,.25);

    transition:.25s;
}

.hero-btn:hover{
    background:#1d4ed8;
    transform:translateY(-3px);
}


/* =========================================================
   SECTION
========================================================= */

.about{
    padding:45px 20px 50px;

    max-width:1100px;

    margin:auto;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.section-title{
    text-align:center;

    margin-bottom:30px;
}

.section-title .small-title{
    color:#2563eb;

    font-size:13px;
    font-weight:800;

    text-transform:uppercase;

    letter-spacing:1.5px;

    margin-bottom:6px;
}

.section-title h2{
    font-size:28px;

    color:#292929;

    margin-bottom:8px;
}

.section-title p{
    color:#777;
    font-size:14px;
}


/* =========================================================
   MAIN CARDS
========================================================= */

.services{
    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    max-width:1000px;

    margin:auto;
}

.service{
    position:relative;

    background:white;

    border-radius:22px;

    padding:25px 18px;

    text-align:center;

    box-shadow:0 8px 25px rgba(30,64,175,.08);

    border:1px solid #dbeafe;

    transition:.3s;

    text-decoration:none;

    color:#222;

    cursor:pointer;

    overflow:hidden;
}

.service::before{
    content:"";

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:5px;

    background:#3b82f6;

    transform:scaleX(0);

    transform-origin:left;

    transition:.3s;
}

.service:hover{
    transform:translateY(-8px);

    border-color:#93c5fd;

    box-shadow:0 15px 35px rgba(37,99,235,.15);
}

.service:hover::before{
    transform:scaleX(1);
}


/* =========================================================
   ICON BOX
========================================================= */

.icon-box{
    width:76px;
    height:76px;

    margin:0 auto 16px;

    display:flex;

    justify-content:center;
    align-items:center;

    border-radius:20px;

    background:#eff6ff;
}

.service img{
    width:48px;
    height:48px;

    object-fit:contain;
}

.service h3{
    font-size:16px;

    line-height:1.4;

    margin-bottom:7px;

    color:#252525;
}

.service p{
    font-size:12px;

    color:#777;

    line-height:1.5;
}


/* =========================================================
   PEMBELAJARAN SECTION
========================================================= */

.learning-section{
    margin-top:55px;
}

.learning-grid{
    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:18px;
}


/* =========================================================
   LEARNING CARD
========================================================= */

.learning-card{
    position:relative;

    background:white;

    border-radius:20px;

    padding:22px;

    border:1px solid #dbeafe;

    box-shadow:0 8px 25px rgba(0,0,0,.06);

    display:flex;

    align-items:center;

    gap:18px;

    transition:.3s;

    text-decoration:none;

    color:#222;
}

.learning-card:hover{
    transform:translateY(-5px);

    box-shadow:0 14px 30px rgba(37,99,235,.12);
}

.learning-icon{
    flex-shrink:0;

    width:65px;
    height:65px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:18px;

    background:#dbeafe;

    font-size:28px;
}

.learning-card h3{
    color:#1d4ed8;

    margin-bottom:5px;

    font-size:17px;
}

.learning-card p{
    color:#777;

    font-size:13px;

    line-height:1.5;
}


/* =========================================================
   VISUALISASI CARD
========================================================= */

.visual-card{
    grid-column:1 / -1;

    position:relative;

    background:#fff;

    border:2px solid #bfdbfe;

    border-radius:22px;

    padding:25px;

    overflow:hidden;

    box-shadow:0 8px 25px rgba(30,64,175,.08);

    text-align:left;
}

.visual-card::after{
    content:"";

    position:absolute;

    width:150px;
    height:150px;

    border-radius:50%;

    background:#eff6ff;

    right:-60px;
    top:-70px;

    z-index:0;
}

.visual-card h3{
    position:relative;
    z-index:2;

    color:#1d4ed8;

    font-size:19px;

    margin-bottom:7px;
}

.visual-card > p{
    position:relative;
    z-index:2;

    margin-bottom:20px;

    color:#777;

    font-size:13px;

    line-height:1.5;
}


/* =========================================================
   PILIHAN VISUALISASI
========================================================= */

.visual-options{
    position:relative;
    z-index:3;

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:12px;

    width:100%;
}

.visual-option{
    position:relative;

    display:flex;

    flex-direction:column;

    align-items:center;
    justify-content:center;

    gap:7px;

    min-height:115px;

    padding:14px 8px;

    background:white;

    border:1px solid #dbeafe;

    border-radius:15px;

    text-decoration:none;

    color:#333;

    transition:.25s;
}

.visual-option:hover{
    transform:translateY(-5px);

    border-color:#93c5fd;

    background:#f8fbff;

    box-shadow:0 10px 22px rgba(37,99,235,.15);
}

.visual-option:active{
    transform:translateY(-2px) scale(.98);
}


/* =========================================================
   ICON VISUALISASI
========================================================= */

.visual-option-icon{
    width:46px;
    height:46px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:13px;

    color:white;

    font-size:23px;
    font-weight:bold;

    box-shadow:0 5px 12px rgba(0,0,0,.12);
}

.translasi-icon{
    background:#2563eb;
}

.refleksi-icon{
    background:#1d4ed8;
}

.dilatasi-icon{
    background:#3b82f6;
}

.rotasi-icon{
    background:#1e40af;
}


/* =========================================================
   TEXT VISUALISASI
========================================================= */

.visual-option strong{
    font-size:14px;

    color:#333;

    text-align:center;
}

.visual-option small{
    font-size:10px;

    color:#999;

    text-align:center;

    line-height:1.3;
}

.visual-option:hover strong{
    color:#1d4ed8;
}


/* =========================================================
   GUIDE
========================================================= */

.guide-section{
    margin-top:55px;

    background:#eff6ff;

    border-radius:25px;

    padding:30px;

    border:1px solid #bfdbfe;
}

.guide-content{
    display:grid;

    grid-template-columns:1fr 1.4fr;

    gap:30px;

    align-items:center;
}

.guide-text h2{
    color:#1d4ed8;

    font-size:25px;

    margin-bottom:10px;
}

.guide-text p{
    color:#666;

    line-height:1.7;

    font-size:14px;

    margin-bottom:18px;
}

.guide-btn{
    display:inline-block;

    padding:11px 20px;

    border-radius:12px;

    background:#2563eb;

    color:white;

    border:none;

    font-weight:700;

    cursor:pointer;

    transition:.25s;
}

.guide-btn:hover{
    background:#1d4ed8;

    transform:translateY(-2px);
}


/* =========================================================
   GUIDE STEPS
========================================================= */

.guide-steps{
    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:12px;
}

.step{
    background:white;

    padding:15px;

    border-radius:15px;

    border:1px solid #dbeafe;
}

.step-number{
    width:30px;
    height:30px;

    border-radius:9px;

    background:#2563eb;

    color:white;

    display:flex;

    align-items:center;
    justify-content:center;

    font-weight:bold;

    font-size:13px;

    margin-bottom:8px;
}

.step h4{
    color:#333;

    font-size:14px;

    margin-bottom:4px;
}

.step p{
    color:#777;

    font-size:12px;

    line-height:1.5;
}


/* =========================================================
   FOOTER
========================================================= */

.jumbotron{
    margin-top:50px;

    background:#2563eb;

    color:white;

    text-align:center;

    padding:18px;

    border-radius:18px;

    font-size:13px;

    box-shadow:0 8px 20px rgba(37,99,235,.15);
}

.jumbotron p{
    margin:0;
}


/* =========================================================
   POPUP
========================================================= */

.popup-overlay{
    position:fixed;

    inset:0;

    background:rgba(15,23,42,.55);

    display:none;

    justify-content:center;
    align-items:center;

    z-index:9999;

    padding:18px;

    backdrop-filter:blur(3px);
}

.popup-box{
    width:100%;

    max-width:550px;

    background:white;

    padding:28px;

    border-radius:22px;

    box-shadow:0 20px 50px rgba(0,0,0,.25);

    animation:muncul .3s ease;
}

.popup-icon{
    width:65px;
    height:65px;

    border-radius:18px;

    background:#dbeafe;

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:30px;

    margin:0 auto 15px;
}

.popup-box h2{
    color:#1d4ed8;

    margin-bottom:12px;

    text-align:center;

    font-size:22px;
}

.popup-box p{
    margin-bottom:12px;

    line-height:1.6;

    font-size:14px;

    color:#555;
}

.popup-box ol{
    padding-left:20px;

    margin-top:10px;

    display:flex;

    flex-direction:column;

    gap:9px;
}

.popup-box ol li{
    line-height:1.55;

    text-align:left;

    font-size:14px;

    color:#444;
}

.popup-box button{
    margin-top:20px;

    width:100%;

    padding:12px;

    border:none;

    border-radius:12px;

    background:#2563eb;

    color:white;

    font-size:15px;

    font-weight:700;

    cursor:pointer;

    transition:.25s;
}

.popup-box button:hover{
    background:#1d4ed8;
}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes muncul{

    from{
        transform:translateY(20px) scale(.95);
        opacity:0;
    }

    to{
        transform:translateY(0) scale(1);
        opacity:1;
    }

}


/* =========================================================
   RESPONSIVE TABLET
========================================================= */

@media(max-width:900px){

    .services{
        grid-template-columns:repeat(2,1fr);
    }

    .hero-content h1{
        font-size:32px;
    }

    .guide-content{
        grid-template-columns:1fr;
    }

    .visual-options{
        grid-template-columns:repeat(2,1fr);
    }

}


/* =========================================================
   RESPONSIVE HP
========================================================= */

@media(max-width:600px){

    header{
        height:65px;

        padding:0 16px 0 70px;
    }

    .logo img{
        width:38px;
    }

    .logo-text{
        font-size:14px;
    }

    .hero{
        min-height:360px;

        padding:50px 18px;
    }

    .hero-content h1{
        font-size:26px;
    }

    .hero-content p{
        font-size:14px;
    }

    .about{
        padding:35px 15px 40px;
    }

    .services{
        grid-template-columns:1fr;

        max-width:360px;
    }

    .service{
        padding:22px;
    }

    .learning-grid{
        grid-template-columns:1fr;
    }

    .visual-card{
        grid-column:auto;

        padding:20px;
    }

    .visual-options{
        grid-template-columns:repeat(2,1fr);

        gap:10px;
    }

    .visual-option{
        min-height:105px;
    }

    .guide-section{
        padding:22px 17px;
    }

    .guide-steps{
        grid-template-columns:1fr;
    }

    .section-title h2{
        font-size:24px;
    }

}


/* =========================================================
   EXTRA SMALL
========================================================= */

@media(max-width:380px){

    .logo-text{
        max-width:160px;

        overflow:hidden;

        text-overflow:ellipsis;

        white-space:nowrap;
    }

    .hero-content h1{
        font-size:23px;
    }

    .visual-option{
        padding:12px 5px;
    }

    .visual-option-icon{
        width:42px;
        height:42px;

        font-size:20px;
    }

}

</style>

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header>

    <div class="logo">

        <img
            src="http://localhost/SKRIPSI/Logo%20Universitas%20Mataram.png"
            alt="Logo UNRAM"
        >

        <div class="logo-text">
            TRANSFORMASI FUNGSI
        </div>

    </div>

</header>


<!-- =========================================================
     MENU BUTTON
========================================================= -->

<button
    class="menu-toggle"
    onclick="toggleMenu()"
    aria-label="Menu"
>
    <span></span>
    <span></span>
    <span></span>
</button>


<!-- =========================================================
     OVERLAY
========================================================= -->

<div
    class="overlay"
    id="overlay"
    onclick="closeMenu()">
</div>


<!-- =========================================================
     SIDE MENU
========================================================= -->

<aside
    class="side-menu"
    id="sideMenu"
>

    <div class="side-head">

        <h3>
            📚 Menu Pembelajaran
        </h3>

        <button
            class="close-btn"
            onclick="closeMenu()"
        >
            ×
        </button>

    </div>


    <ul>

        <!-- MATERI -->

        <li>
            <a href="http://localhost/SKRIPSI/materi.php">
                📖 Materi
            </a>
        </li>


        <!-- LATIHAN -->

        <li>
            <a href="http://localhost/SKRIPSI/soallatihan.php">
                📝 Latihan Soal
            </a>
        </li>


        <!-- VISUALISASI -->

        <li class="has-submenu">

            <a
                href="javascript:void(0)"
                onclick="toggleSubmenu(this)"
            >
                📊 Visualisasi Transformasi
            </a>

            <ul class="submenu-side">

                <li>
                    <a href="http://localhost/SKRIPSI/translasi%20javascript.php">

                        <span class="menu-visual-icon menu-translasi">
                            ↔
                        </span>

                        <span>
                            Translasi
                        </span>

                    </a>
                </li>


                <li>
                    <a href="http://localhost/SKRIPSI/refleksi%20javascript.php">

                        <span class="menu-visual-icon menu-refleksi">
                            ↔
                        </span>

                        <span>
                            Refleksi
                        </span>

                    </a>
                </li>


                <li>
                    <a href="http://localhost/SKRIPSI/dilatasi%20javascript.php">

                        <span class="menu-visual-icon menu-dilatasi">
                            ⤢
                        </span>

                        <span>
                            Dilatasi
                        </span>

                    </a>
                </li>


                <li>
                    <a href="http://localhost/SKRIPSI/rotasi%20javascript.php">

                        <span class="menu-visual-icon menu-rotasi">
                            ⟳
                        </span>

                        <span>
                            Rotasi
                        </span>

                    </a>
                </li>

            </ul>

        </li>


        <!-- GAME
             HANYA 1 GAME
        -->

        <li>
            <a href="http://localhost/SKRIPSI/GAMECOBAA.php">
                🎮 Game Transformasi
            </a>
        </li>


        <!-- PROFIL -->

        <li>
            <a href="http://localhost/SKRIPSI/PROFILELA.php">
                👤 Profil
            </a>
        </li>

    </ul>

</aside>


<!-- =========================================================
     HERO
========================================================= -->

<section class="hero">

    <div class="hero-content">

        <div class="hero-badge">
            📚 MEDIA PEMBELAJARAN MATEMATIKA
        </div>

        <h1>
            Ayo Belajar
            <span>
                Transformasi Fungsi
            </span>
            dengan Cara yang Seru!
        </h1>

        <p>
            Pelajari translasi, refleksi, dilatasi, dan rotasi
            melalui materi interaktif, visualisasi grafik,
            latihan soal, serta permainan edukatif.
        </p>

        <a
            href="http://localhost/SKRIPSI/materi.php"
            class="hero-btn"
        >
            🚀 Mulai Belajar
        </a>

    </div>

</section>


<!-- =========================================================
     KONTEN UTAMA
========================================================= -->

<section class="about">


    <!-- TITLE -->

    <div class="section-title">

        <div class="small-title">
            PEMBELAJARAN INTERAKTIF
        </div>

        <h2>
            Mau Belajar Apa Hari Ini?
        </h2>

        <p>
            Pilih menu pembelajaran yang ingin kamu gunakan.
        </p>

    </div>


    <!-- =====================================================
         MAIN CARDS
    ===================================================== -->

    <div class="services">


        <!-- MATERI -->

        <a
            href="http://localhost/SKRIPSI/materi.php"
            class="service"
        >

            <div class="icon-box">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/29/29302.png"
                    alt="Materi"
                >

            </div>

            <h3>
                Materi
            </h3>

            <p>
                Pelajari konsep transformasi fungsi
                secara bertahap dan sistematis.
            </p>

        </a>


        <!-- PETUNJUK -->

        <div
            class="service"
            onclick="bukaPopup()"
        >

            <div class="icon-box">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/1828/1828919.png"
                    alt="Petunjuk"
                >

            </div>

            <h3>
                Petunjuk Penggunaan
            </h3>

            <p>
                Lihat panduan menggunakan
                website pembelajaran.
            </p>

        </div>


        <!-- GAME -->

        <a
            href="http://localhost/SKRIPSI/GAMECOBAA.php"
            class="service"
        >

            <div class="icon-box">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png"
                    alt="Game"
                >

            </div>

            <h3>
                Game Transformasi
            </h3>

            <p>
                Uji pemahaman melalui permainan
                transformasi fungsi.
            </p>

        </a>

    </div>
    <!-- PENUTUP SERVICES -->


    <!-- =====================================================
         JELAJAHI PEMBELAJARAN
    ===================================================== -->

    <div class="learning-section">

        <div class="section-title">

            <div class="small-title">
                FITUR PEMBELAJARAN
            </div>

            <h2>
                Jelajahi Transformasi Fungsi
            </h2>

            <p>
                Gunakan berbagai fitur untuk memahami
                transformasi fungsi dengan lebih mudah.
            </p>

        </div>


        <div class="learning-grid">


            <!-- VISUALISASI -->

            <div class="visual-card">

                <h3>
                    📊 Visualisasi Transformasi Fungsi
                </h3>

                <p>
                    Pilih jenis transformasi untuk melihat
                    perubahan grafik secara interaktif.
                </p>


                <div class="visual-options">


                    <!-- TRANSLASI -->

                    <a
                        href="http://localhost/SKRIPSI/translasi%20javascript.php"
                        class="visual-option"
                    >

                        <span class="visual-option-icon translasi-icon">
                            ↔
                        </span>

                        <strong>
                            Translasi
                        </strong>

                        <small>
                            Pergeseran grafik
                        </small>

                    </a>


                    <!-- REFLEKSI -->

                    <a
                        href="http://localhost/SKRIPSI/refleksi%20javascript.php"
                        class="visual-option"
                    >

                        <span class="visual-option-icon refleksi-icon">
                            ↔
                        </span>

                        <strong>
                            Refleksi
                        </strong>

                        <small>
                            Pencerminan grafik
                        </small>

                    </a>


                    <!-- DILATASI -->

                    <a
                        href="http://localhost/SKRIPSI/dilatasi%20javascript.php"
                        class="visual-option"
                    >

                        <span class="visual-option-icon dilatasi-icon">
                            ⤢
                        </span>

                        <strong>
                            Dilatasi
                        </strong>

                        <small>
                            Perubahan ukuran
                        </small>

                    </a>


                    <!-- ROTASI -->

                    <a
                        href="http://localhost/SKRIPSI/rotasi%20javascript.php"
                        class="visual-option"
                    >

                        <span class="visual-option-icon rotasi-icon">
                            ⟳
                        </span>

                        <strong>
                            Rotasi
                        </strong>

                        <small>
                            Perputaran grafik
                        </small>

                    </a>

                </div>

            </div>


            <!-- LATIHAN -->

            <a
                href="http://localhost/SKRIPSI/soallatihan.php"
                class="learning-card"
            >

                <div class="learning-icon">
                    📝
                </div>

                <div>

                    <h3>
                        Latihan Soal
                    </h3>

                    <p>
                        Kerjakan soal latihan untuk
                        menguji pemahaman setelah
                        mempelajari materi.
                    </p>

                </div>

            </a>


            <!-- GAME -->

            <a
                href="http://localhost/SKRIPSI/GAMECOBAA.php"
                class="learning-card"
            >

                <div class="learning-icon">
                    🎮
                </div>

                <div>

                    <h3>
                        Game Edukatif
                    </h3>

                    <p>
                        Belajar sambil bermain melalui
                        permainan transformasi fungsi
                        yang interaktif.
                    </p>

                </div>

            </a>


            <!-- PROFIL -->

            <a
                href="http://localhost/SKRIPSI/PROFILELA.php"
                class="learning-card"
            >

                <div class="learning-icon">
                    👩‍🎓
                </div>

                <div>

                    <h3>
                        Profil
                    </h3>

                    <p>
                        Informasi mengenai pengembang
                        media pembelajaran.
                    </p>

                </div>

            </a>

        </div>

    </div>


    <!-- =====================================================
         PETUNJUK PENGGUNAAN
    ===================================================== -->

    <div class="guide-section">

        <div class="guide-content">


            <div class="guide-text">

                <h2>
                    💡 Cara Menggunakan Website
                </h2>

                <p>
                    Website ini dirancang untuk membantu
                    mempelajari transformasi fungsi secara
                    bertahap. Mulailah dari materi, amati
                    visualisasi grafik, kemudian uji
                    pemahaman melalui latihan dan game.
                </p>

                <button
                    class="guide-btn"
                    onclick="bukaPopup()"
                >
                    📖 Lihat Petunjuk
                </button>

            </div>


            <div class="guide-steps">


                <div class="step">

                    <div class="step-number">
                        1
                    </div>

                    <h4>
                        Pelajari Materi
                    </h4>

                    <p>
                        Pahami konsep dan rumus
                        transformasi fungsi.
                    </p>

                </div>


                <div class="step">

                    <div class="step-number">
                        2
                    </div>

                    <h4>
                        Amati Visualisasi
                    </h4>

                    <p>
                        Gunakan grafik interaktif
                        untuk melihat perubahan.
                    </p>

                </div>


                <div class="step">

                    <div class="step-number">
                        3
                    </div>

                    <h4>
                        Kerjakan Latihan
                    </h4>

                    <p>
                        Uji pemahaman melalui
                        latihan soal.
                    </p>

                </div>


                <div class="step">

                    <div class="step-number">
                        4
                    </div>

                    <h4>
                        Mainkan Game
                    </h4>

                    <p>
                        Perkuat pemahaman dengan
                        permainan edukatif.
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FOOTER
    ===================================================== -->

    <div class="jumbotron">

        <p>
            © 2026 Transformasi Fungsi
            : Nurlaelatul Qadri Ramdani
        </p>

    </div>

</section>


<!-- =========================================================
     POPUP PETUNJUK
========================================================= -->

<div
    id="popupPetunjuk"
    class="popup-overlay"
>

    <div class="popup-box">

        <div class="popup-icon">
            📚
        </div>

        <h2>
            Petunjuk Penggunaan Website
        </h2>

        <p>
            Berikut adalah langkah-langkah yang dapat
            dilakukan untuk menggunakan website:
        </p>

        <ol>

            <li>
                Gunakan tombol menu ☰ di kiri atas
                untuk membuka navigasi website.
            </li>

            <li>
                Pilih menu <strong>Materi</strong>
                untuk mempelajari transformasi fungsi.
            </li>

            <li>
                Gunakan menu
                <strong>Visualisasi Transformasi</strong>
                untuk melihat perubahan grafik secara
                interaktif.
            </li>

            <li>
                Pilih jenis transformasi:
                <strong>
                    Translasi, Refleksi, Dilatasi,
                    atau Rotasi
                </strong>.
            </li>

            <li>
                Pilih <strong>Latihan Soal</strong>
                untuk menguji pemahaman terhadap materi.
            </li>

            <li>
                Gunakan menu
                <strong>Game Transformasi</strong>
                untuk belajar melalui permainan edukatif.
            </li>

            <li>
                Pelajari materi secara bertahap dari
                konsep, visualisasi, latihan, hingga game.
            </li>

        </ol>

        <button onclick="tutupPopup()">
            Mengerti ✓
        </button>

    </div>

</div>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

/* =========================================================
   MENU
========================================================= */

function toggleMenu(){

    document
        .getElementById("sideMenu")
        .classList
        .toggle("active");

    document
        .getElementById("overlay")
        .classList
        .toggle("active");

}


function closeMenu(){

    document
        .getElementById("sideMenu")
        .classList
        .remove("active");

    document
        .getElementById("overlay")
        .classList
        .remove("active");

}


/* =========================================================
   SUBMENU
========================================================= */

function toggleSubmenu(el){

    const parent = el.parentElement;

    parent.classList.toggle("open");

}


/* =========================================================
   POPUP
========================================================= */

function bukaPopup(){

    document
        .getElementById("popupPetunjuk")
        .style
        .display = "flex";

}


function tutupPopup(){

    document
        .getElementById("popupPetunjuk")
        .style
        .display = "none";

}


/* =========================================================
   TUTUP POPUP KLIK LUAR
========================================================= */

document
    .getElementById("popupPetunjuk")
    .addEventListener(
        "click",
        function(e){

            if(e.target === this){

                tutupPopup();

            }

        }
    );


/* =========================================================
   ESC UNTUK TUTUP
========================================================= */

document.addEventListener(
    "keydown",
    function(e){

        if(e.key === "Escape"){

            closeMenu();
            tutupPopup();

        }

    }
);

</script>


</body>
</html>
