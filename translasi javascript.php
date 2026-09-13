<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Translasi Fungsi Interaktif</title>

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

.wrapper{
    display:flex;
    height:600px;
    width:1000px;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(30,64,175,0.2);
}

.left{
    flex:1;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

canvas{
    width:680px;
    height:460px;
    background:white;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(30,64,175,0.2);
    cursor:crosshair;
}

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
    margin:5px 0;
    color:#1d4ed8;
    font-size:15px;
}

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

input{
    border:1px solid #bfdbfe;
    background:#ffffff;
    color:#1e3a8a;
    outline:none;
}

input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 2px rgba(37,99,235,0.12);
}

p{
    background:#eff6ff;
    border:1px solid #dbeafe;
    color:#374151;
}

body{
    flex-direction:column;
}

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
<h2>📈 Translasi Fungsi Interaktif</h2>
<canvas id="canvas" width="750" height="500"></canvas>
<p id="info">Klik / geser titik</p>
</div>

<div class="right">

<h3>⚙️ Fungsi</h3>
<input id="fungsi" value="x^2">

<h3>↔️ Geser kiri/kanan</h3>
<input type="range" id="a" min="-5" max="5" step="0.1" value="0">

<h3>↕️ Geser atas/bawah</h3>
<input type="range" id="b" min="-5" max="5" step="0.1" value="0">

<h3>📌 Fungsi Hasil</h3>
<p id="fBaru"></p>

</div>

</div>

<script>

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let aEl = document.getElementById("a");
let bEl = document.getElementById("b");
let fEl = document.getElementById("fungsi");
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

/* GRID + ANGKA */
function grid(){

let cx = 375;
let cy = 250;

ctx.strokeStyle="#eee";
ctx.fillStyle="#777";
ctx.font="10px Arial";

for(let i=-10;i<=10;i++){

    let x = cx + i*scale;
    let y = cy + i*scale;

    ctx.beginPath();
    ctx.moveTo(x,0);
    ctx.lineTo(x,500);
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(0,y);
    ctx.lineTo(750,y);
    ctx.stroke();

    if(i!==0){
        ctx.fillText(i, x-5, cy+15);
        ctx.fillText(-i, cx+5, y);
    }
}

/* axis */
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

let f = fparse(fEl.value);
let a = parseFloat(aEl.value);
let b = parseFloat(bEl.value);

ctx.clearRect(0,0,750,500);
grid();

/* fungsi awal */
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

/* translasi */
ctx.strokeStyle="red";
ctx.beginPath();

for(let px=0;px<750;px++){
    let x = (px-375)/scale;
    let y = f(x - a) + b;

    let py = 250 - y*scale;

    if(px===0) ctx.moveTo(px,py);
    else ctx.lineTo(px,py);
}
ctx.stroke();

/* 🔵 TITIK ASLI */
if(point){
    ctx.fillStyle="blue";
    ctx.beginPath();
    ctx.arc(point.px,point.py,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="black";
    ctx.fillText(
        `(${point.x.toFixed(2)}, ${point.y.toFixed(2)})`,
        point.px+8,
        point.py-8
    );

    /* 🔴 TITIK HASIL */
    let rx = point.x + a;
    let ry = point.y + b;

    let rpx = 375 + rx*scale;
    let rpy = 250 - ry*scale;

    ctx.fillStyle="red";
    ctx.beginPath();
    ctx.arc(rpx,rpy,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="black";
    ctx.fillText(
        `(${rx.toFixed(2)}, ${ry.toFixed(2)})`,
        rpx+8,
        rpy-8
    );
}

/* UI */
document.getElementById("fBaru").innerText =
"g(x) = f(x - a) + b";

}

/* SNAP */
function snap(mx,my){

let f = fparse(fEl.value);
let a = parseFloat(aEl.value);
let b = parseFloat(bEl.value);

let best=null;
let min=999999;

for(let x=-20;x<=20;x+=0.05){

    let y = f(x);

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

/* INTERAKSI */
canvas.addEventListener("mousedown",e=>{

let r=canvas.getBoundingClientRect();

let mx=e.clientX-r.left;
let my=e.clientY-r.top;

point=snap(mx,my);
dragging=true;

draw();
});

canvas.addEventListener("mousemove",e=>{

if(!dragging) return;

let r=canvas.getBoundingClientRect();

let mx=e.clientX-r.left;
let my=e.clientY-r.top;

point=snap(mx,my);

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
aEl.oninput = bEl.oninput = fEl.oninput = draw;

draw();

</script>
</div>
<div class="back-btn">
    <a href="http://localhost/SKRIPSI/Untitled-1.php">Kembali</a>
</div>
<div class="footer">

</body>
</html>