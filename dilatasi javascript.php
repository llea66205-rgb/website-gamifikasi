<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Visualisasi Dilatasi Fungsi</title>

<style>

    body{
        margin:0;
        font-family:Segoe UI;
        background:#dbeafe;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px;
    }
    
    /* WRAPPER */
    .wrapper{
        display:flex;
        height:600px;
        width:1000px;
        transform:scale(0.95);
        transform-origin:center;
        background:white;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 6px 20px rgba(30,64,175,0.2);
    }
    
    /* LEFT */
    .left{
        flex:1;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    
    /* CANVAS */
    canvas{
        width:680px;
        height:460px;
        background:white;
        border-radius:15px;
        box-shadow:0 4px 12px rgba(30,64,175,0.2);
        cursor:crosshair;
    }
    
    /* RIGHT PANEL */
    .right{
        width:400px;
        background:#ffffff;
        padding:18px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:12px;
        border-left:2px solid #dbeafe;
    }
    
    /* TITLE */
    h3{
        margin:5px 0;
        color:#1d4ed8;
        font-size:15px;
    }
    
    /* SEMUA BOX SERAGAM */
    input, p{
        width:90%;
        height:38px;
        border-radius:10px;
        text-align:center;
        font-size:14px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    
    /* INPUT KHUSUS */
    input{
        border:1px solid #bfdbfe;
        padding:0;
        background:#ffffff;
        color:#1e3a8a;
        outline:none;
    }

    input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 2px rgba(37,99,235,0.12);
    }
    
    /* PARAGRAF (KOORDINAT & FUNGSI) */
    p{
        margin:0;
        background:#eff6ff;
        border:1px solid #dbeafe;
        color:#374151;
    }
    
    /* INFO */
    #info{
        background:#ffffff;
        font-weight:bold;
        color:#1d4ed8;
    }
    
    /* LEGEND */
    .legend{
        font-size:12px;
        text-align:center;
        margin-top:5px;
        color:#64748b;
    }

    /* BODY VERTIKAL */
    body{
        flex-direction:column;
    }

    /* TOMBOL KEMBALI */
    .back-btn{
        width:100%;
        text-align:center;
        margin-top:20px;
    }

    .back-btn a{
        display:inline-block;
        padding:10px 20px;
        background:#2563eb;
        color:white;
        text-decoration:none;
        border-radius:10px;
        font-family:Segoe UI;
        transition:0.2s;
        box-shadow:0 5px 12px rgba(37,99,235,0.2);
    }

    .back-btn a:hover{
        background:#1d4ed8;
        transform:translateY(-2px);
    }

    </style>
</head>

<body>

<div class="wrapper">

<!-- KIRI -->
<div class="left">

<h2>📈 Dilatasi Fungsi Interaktif</h2>

<canvas id="canvas" width="750" height="500"></canvas>

<p id="info">Klik / geser titik | Scroll zoom</p>

</div>

<!-- KANAN -->
<div class="right">

<h3>⚙️ Fungsi</h3>
<input id="fungsi" value="x^2-4x-5">

<h3>🔵 Skala k</h3>
<input type="range" id="slider" min="0.1" max="3" step="0.1" value="1">
<p>k = <span id="kval">1</span></p>

<h3>📌 Fungsi Awal</h3>
<p id="fAwal">f(x) = x^2-4x-5</p>

<h3>📌 Setelah Dilatasi</h3>
<p id="fBaru">g(x) = 1(x^2-4x-5)</p>

<div class="legend">
<p style="color:blue">● Biru = f(x)</p>
<p style="color:red">● Merah = k·f(x)</p>
</div>

</div>

</div>

<script>

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let slider = document.getElementById("slider");
let kval = document.getElementById("kval");
let fungsiInput = document.getElementById("fungsi");

let info = document.getElementById("info");

let scale = 25;
let point = null;

/* ================= PARSER ================= */
function parseFunc(str){

    str = str
        .replace(/\^/g,"**")
        .replace(/(\d)(x)/g,"$1*$2")
        .replace(/(x)(\d)/g,"$1*$2");

    return function(x){
        try{
            return eval(str);
        }catch{
            return 0;
        }
    }
}

/* ================= GRID ================= */
function grid(){

ctx.strokeStyle="#eee";
ctx.fillStyle="#999";
ctx.font="10px Segoe UI";

let centerX = 375;
let centerY = 250;

/* ================= GRID VERTICAL + ANGKA X ================= */
for(let i=-50;i<=50;i++){

    let x = centerX + i*scale;

    ctx.beginPath();
    ctx.moveTo(x,0);
    ctx.lineTo(x,500);
    ctx.stroke();

    // angka X (di sumbu horizontal)
    if(i !== 0 && i % 2 === 0){
        ctx.fillText(i, x-5, centerY + 15);
    }
}

/* ================= GRID HORIZONTAL + ANGKA Y ================= */
for(let i=-50;i<=50;i++){

    let y = centerY + i*scale;

    ctx.beginPath();
    ctx.moveTo(0,y);
    ctx.lineTo(750,y);
    ctx.stroke();

    // angka Y (dibalik karena canvas)
    if(i !== 0 && i % 2 === 0){
        ctx.fillText(-i, centerX + 5, y+3);
    }
}

/* ================= AXIS TEBAL ================= */
ctx.strokeStyle="black";

// sumbu X
ctx.beginPath();
ctx.moveTo(0,centerY);
ctx.lineTo(750,centerY);
ctx.stroke();

// sumbu Y
ctx.beginPath();
ctx.moveTo(centerX,0);
ctx.lineTo(centerX,500);
ctx.stroke();
}

/* ================= DRAW ================= */
function draw(){

    let k = parseFloat(slider.value);
    let f = parseFunc(fungsiInput.value);

    ctx.clearRect(0,0,750,500);
    grid();

    /* BEFORE */
    ctx.strokeStyle="blue";
    ctx.beginPath();

    for(let px=0;px<750;px++){
        let x = (px-375)/scale;
        let y = f(x);

        let py = 250 - y*scale;

        if(px===0) ctx.moveTo(px,py);
        else ctx.lineTo(px,py);
    }
    ctx.stroke();

    /* AFTER */
    ctx.strokeStyle="red";
    ctx.beginPath();

    for(let px=0;px<750;px++){
        let x = (px-375)/scale;
        let y = k * f(x);

        let py = 250 - y*scale;

        if(px===0) ctx.moveTo(px,py);
        else ctx.lineTo(px,py);
    }
    ctx.stroke();

   /* titik + koordinat */
if(point){

let f = parseFunc(fungsiInput.value);
let k = parseFloat(slider.value);

let x0 = point.x;
let y0 = f(x0);

/* ===== TITIK BIRU ===== */
let px1 = 375 + x0*scale;
let py1 = 250 - y0*scale;

ctx.fillStyle="blue";
ctx.beginPath();
ctx.arc(px1,py1,6,0,Math.PI*2);
ctx.fill();

ctx.fillStyle="black";
ctx.font="12px Segoe UI";
ctx.fillText(
    "(" + x0.toFixed(2) + "," + y0.toFixed(2) + ")",
    px1 + 8,
    py1 - 8
);

/* ===== TITIK MERAH ===== */
let y1 = k * y0;

let px2 = 375 + x0*scale;
let py2 = 250 - y1*scale;

ctx.fillStyle="red";
ctx.beginPath();
ctx.arc(px2,py2,6,0,Math.PI*2);
ctx.fill();

ctx.fillText(
    "(" + x0.toFixed(2) + "," + y1.toFixed(2) + ")",
    px2 + 8,
    py2 - 8
);
}
}

/* ================= SNAP ================= */
function snap(mx,my){

    let f = parseFunc(fungsiInput.value);
    let k = parseFloat(slider.value);

    let best=null;
    let min=999999;

    for(let x=-20;x<=20;x+=0.05){

        let y = k * f(x);

        let px = 375 + x*scale;
        let py = 250 - y*scale;

        let d = (mx-px)**2 + (my-py)**2;

        if(d<min){
            min=d;
            best={x,y,px,py};
        }
    }

    return best;
}

/* ================= CLICK + DRAG ================= */
canvas.addEventListener("mousedown",e=>{

    let rect = canvas.getBoundingClientRect();

    let mx = e.clientX - rect.left;
    let my = e.clientY - rect.top;

    point = snap(mx,my);

    updateInfo();
    draw();
});

canvas.addEventListener("mousemove",e=>{

    if(!point) return;

    let rect = canvas.getBoundingClientRect();

    let mx = e.clientX - rect.left;
    let my = e.clientY - rect.top;

    point = snap(mx,my);

    updateInfo();
    draw();
});

canvas.addEventListener("mouseup",()=>{
    point=null;
});

/* ================= ZOOM ================= */
canvas.addEventListener("wheel",e=>{
    e.preventDefault();

    scale *= (e.deltaY<0)?1.1:0.9;
    draw();
});

/* ================= INFO ================= */
function updateInfo(){
    if(point){
        info.innerText =
        "Titik: ("+
        point.x.toFixed(2)+
        " , "+
        point.y.toFixed(2)+
        ")";
    }
}

/* ================= UPDATE UI ================= */
function updateUI(){

    let k = parseFloat(slider.value);
    let str = fungsiInput.value;

    document.getElementById("fAwal").innerText =
    "f(x) = " + str;

    document.getElementById("fBaru").innerText =
    "g(x) = " + k + "(" + str + ")";
}

/* EVENTS */
slider.oninput = function(){
    kval.innerText=this.value;
    updateUI();
    draw();
}

fungsiInput.oninput = function(){
    updateUI();
    draw();
}

/* INIT */
updateUI();
draw();

</script>
</div>
<div class="back-btn">
    <a href="http://localhost/SKRIPSI/Untitled-1.php">Kembali</a>
</div>
<div class="footer">

</body>
</html>