<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Refleksi Fungsi Interaktif</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    display:flex;
    background:#dbeafe;
    min-height:100vh;
    justify-content:center;
    align-items:center;
}

/* WRAPPER */
.wrapper{
    display:flex;
    height:600px;
    width:1000px;
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

h3{
    color:#1d4ed8;
    font-size:15px;
}

input, select, p{
    width:90%;
    height:38px;
    border-radius:10px;
    text-align:center;
    font-size:14px;
    display:flex;
    align-items:center;
    justify-content:center;
}

input, select{
    border:1px solid #bfdbfe;
    background:#ffffff;
    color:#1e3a8a;
    outline:none;
}

input:focus,
select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 2px rgba(37,99,235,0.12);
}

p{
    background:#eff6ff;
    border:1px solid #dbeafe;
    padding:8px 10px;
    border-radius:10px;
    font-size:13px;
    line-height:1.4;
    color:#374151;
}

/* LEGEND */
.legend{
    width:95%;
}

.legend p{
    width:100%;
    min-height:65px;
    height:auto;
    padding:12px;
    border-radius:10px;
    border:1px solid #dbeafe;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    line-height:1.5;
    background:#f8fbff;
}

.legend p + p{
    margin-top:8px;
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

<div class="left">
<h2>📈 Refleksi Fungsi Interaktif</h2>
<canvas id="canvas" width="750" height="500"></canvas>
<p id="info">Klik / geser titik</p>
</div>

<div class="right">

<h3>⚙️ Fungsi</h3>
<input id="fungsi" value="x^2+4x+4">

<h3>🔄 Jenis Refleksi</h3>
<select id="mode">
<option value="x">Sumbu X (vertikal)</option>
<option value="y">Sumbu Y (horizontal)</option>
</select>

<h3>📌 Fungsi Awal</h3>
<p id="fAwal"></p>

<h3>📌 Fungsi Hasil</h3>
<p id="fBaru"></p>

<div class="legend">
<p style="color:blue">● Biru = f(x)</p>
<p style="color:red">● Merah = hasil refleksi</p>
</div>

</div>

</div>

<script>

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let fEl = document.getElementById("fungsi");
let modeEl = document.getElementById("mode");
let info = document.getElementById("info");

let scale = 25;
let point = null;
let dragging = false;

/* PARSER */
function fparse(str){
    str = str.replace(/\^/g,"**")
             .replace(/(\d)(x)/g,"$1*$2");

    return x => eval(str);
}

/* GRID */
function grid(){

let cx=375, cy=250;

ctx.strokeStyle="#eee";
ctx.fillStyle="#999";
ctx.font="10px Segoe UI";

for(let i=-50;i<=50;i++){

    let x=cx+i*scale;
    ctx.beginPath();
    ctx.moveTo(x,0);
    ctx.lineTo(x,500);
    ctx.stroke();

    if(i%2===0 && i!==0)
        ctx.fillText(i,x-5,cy+15);
}

for(let i=-50;i<=50;i++){

    let y=cy+i*scale;
    ctx.beginPath();
    ctx.moveTo(0,y);
    ctx.lineTo(750,y);
    ctx.stroke();

    if(i%2===0 && i!==0)
        ctx.fillText(-i,cx+5,y);
}

ctx.strokeStyle="black";
ctx.beginPath();
ctx.moveTo(0,cy);
ctx.lineTo(750,cy);
ctx.stroke();

ctx.beginPath();
ctx.moveTo(cx,0);
ctx.lineTo(cx,500);
ctx.stroke();

}

/* DRAW */
function draw(){

let f=fparse(fEl.value);
let mode=modeEl.value;

ctx.clearRect(0,0,750,500);
grid();

/* ===== BIRU ===== */
ctx.strokeStyle="blue";
ctx.beginPath();

for(let px=0;px<750;px++){
    let x=(px-375)/scale;
    let y=f(x);

    let py=250-y*scale;

    if(px===0) ctx.moveTo(px,py);
    else ctx.lineTo(px,py);
}
ctx.stroke();

/* ===== MERAH ===== */
ctx.strokeStyle="red";
ctx.beginPath();

for(let px=0;px<750;px++){
    let x=(px-375)/scale;
    let y = (mode=="x") ? -f(x) : f(-x);

    let py=250-y*scale;

    if(px===0) ctx.moveTo(px,py);
    else ctx.lineTo(px,py);
}
ctx.stroke();

/* =========================
   🔥 TITIK INTERAKTIF + KOORDINAT
========================= */
if(point){

    /* titik biru (awal) */
    let apx = 375 + point.x*scale;
    let apy = 250 - point.y*scale;

    ctx.fillStyle="blue";
    ctx.beginPath();
    ctx.arc(apx,apy,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="black";
    ctx.fillText(
        "A(" + point.x.toFixed(2) + "," + point.y.toFixed(2) + ")",
        apx+8, apy-8
    );

    /* titik merah (hasil refleksi) */
    let rx = (mode=="y") ? -point.x : point.x;
    let ry = (mode=="x") ? -point.y : point.y;

    let rpx = 375 + rx*scale;
    let rpy = 250 - ry*scale;

    ctx.fillStyle="red";
    ctx.beginPath();
    ctx.arc(rpx,rpy,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="black";
    ctx.fillText(
        "A'(" + rx.toFixed(2) + "," + ry.toFixed(2) + ")",
        rpx+8, rpy-8
    );
}

/* UI */
document.getElementById("fAwal").innerText =
"f(x) = " + fEl.value;

if(mode=="x"){
document.getElementById("fBaru").innerText =
"g(x) = -(" + fEl.value + ")";
}
else{
document.getElementById("fBaru").innerText =
"g(x) = " + fEl.value.replace(/x/g,"(-x)");
}

}

/* SNAP */
function snap(mx,my){

let f=fparse(fEl.value);

let best=null;
let min=999999;

for(let x=-20;x<=20;x+=0.05){

    let y=f(x);

    let px=375+x*scale;
    let py=250-y*scale;

    let d=(mx-px)**2+(my-py)**2;

    if(d<min){
        min=d;
        best={x,y};
    }
}

return best;
}

/* INTERAKSI */
canvas.addEventListener("mousedown",e=>{

let r=canvas.getBoundingClientRect();

point=snap(e.clientX-r.left,e.clientY-r.top);
dragging=true;

info.innerText=
"("+point.x.toFixed(2)+","+point.y.toFixed(2)+")";

draw();
});

canvas.addEventListener("mousemove",e=>{

if(!dragging) return;

let r=canvas.getBoundingClientRect();

point=snap(e.clientX-r.left,e.clientY-r.top);

info.innerText=
"("+point.x.toFixed(2)+","+point.y.toFixed(2)+")";

draw();
});
canvas.addEventListener("wheel",e=>{
    e.preventDefault();

    if(e.deltaY < 0){
        scale *= 1.1; // zoom in
    }else{
        scale *= 0.9; // zoom out
    }

    if(scale < 10) scale = 10;
    if(scale > 80) scale = 80;

    draw();
});

canvas.addEventListener("mouseup",()=>dragging=false);

/* UPDATE */
fEl.oninput = modeEl.onchange = draw;

draw();

</script>
</div>
<div class="back-btn">
    <a href="http://localhost/SKRIPSI/Untitled-1.php">Kembali</a>
</div>
<div class="footer">

</body>
</html>