<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Rotasi Fungsi Interaktif (FIX)</title>

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
    width:1050px;
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
    width:700px;
    height:460px;
    background:white;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(30,64,175,0.2);
    cursor:crosshair;
}

.right{
    width:420px;
    background:#ffffff;
    padding:18px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    border-left:2px solid #dbeafe;
}

h3{
    color:#1d4ed8;
    font-size:15px;
}

input, p{
    width:92%;
    padding:10px;
    border-radius:10px;
    text-align:center;
    font-size:13px;
    border:1px solid #dbeafe;
    background:#eff6ff;
    color:#374151;
}

input{
    background:#ffffff;
    color:#1e3a8a;
    outline:none;
}

input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 2px rgba(37,99,235,0.12);
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
<h2>🔄 Rotasi Fungsi Interaktif</h2>
<canvas id="canvas" width="700" height="500"></canvas>
<p id="info">Klik / geser titik</p>
</div>

<div class="right">

<h3>⚙️ Fungsi</h3>
<input id="fungsi" value="x^2">

<h3>🔄 Sudut Rotasi</h3>
<input type="range" id="t" min="0" max="360" step="1" value="0">
<p id="valT">0°</p>

<h3>📌 Fungsi Awal</h3>
<p id="fAwal"></p>

<h3>📌 Hasil</h3>
<p id="fBaru"></p>

</div>

</div>

<script>

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let fEl = document.getElementById("fungsi");
let tEl = document.getElementById("t");
let info = document.getElementById("info");

let scale = 25;
let point = null;
let dragging = false;

/* PARSER */
function fparse(str){
    str = str.replace(/\^/g,"**").replace(/(\d)(x)/g,"$1*$2");
    return x => eval(str);
}

/* GRID + KOORDINAT ANGKA */
function grid(){

let cx=350, cy=250;

ctx.strokeStyle="#eee";
ctx.fillStyle="#aaa";
ctx.font="10px Segoe UI";

for(let i=-12;i<=12;i++){

    let x=cx+i*scale;
    ctx.beginPath();
    ctx.moveTo(x,0);
    ctx.lineTo(x,500);
    ctx.stroke();

    if(i!==0){
        ctx.fillText(i, x-5, cy+12);
    }
}

for(let i=-12;i<=12;i++){

    let y=cy+i*scale;
    ctx.beginPath();
    ctx.moveTo(0,y);
    ctx.lineTo(700,y);
    ctx.stroke();

    if(i!==0){
        ctx.fillText(-i, cx+5, y);
    }
}

ctx.strokeStyle="black";
ctx.beginPath();
ctx.moveTo(0,cy);
ctx.lineTo(700,cy);
ctx.stroke();

ctx.beginPath();
ctx.moveTo(cx,0);
ctx.lineTo(cx,500);
ctx.stroke();

}

/* ROTASI */
function rot(x,y,rad){
    return {
        x: x*Math.cos(rad) - y*Math.sin(rad),
        y: x*Math.sin(rad) + y*Math.cos(rad)
    };
}

/* DRAW */
function draw(){

let f=fparse(fEl.value);
let deg=parseFloat(tEl.value);
let rad=deg*Math.PI/180;

ctx.clearRect(0,0,700,500);
grid();

/* FUNSI AWAL */
ctx.strokeStyle="blue";
ctx.beginPath();

for(let px=0;px<700;px++){

    let x=(px-350)/scale;
    let y=f(x);

    let py=250-y*scale;

    if(px===0) ctx.moveTo(px,py);
    else ctx.lineTo(px,py);
}
ctx.stroke();

/* ROTASI */
ctx.strokeStyle="green";
ctx.beginPath();

for(let px=0;px<700;px++){

    let x=(px-350)/scale;
    let y=f(x);

    let r=rot(x,y,rad);

    let sx=350+r.x*scale;
    let sy=250-r.y*scale;

    if(px===0) ctx.moveTo(sx,sy);
    else ctx.lineTo(sx,sy);
}
ctx.stroke();

/* TITIK INTERAKTIF + LABEL */
if(point){

    // titik awal
    ctx.fillStyle="blue";
    ctx.beginPath();
    ctx.arc(point.px,point.py,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="blue";
    ctx.font="12px Arial";
    ctx.fillText(
        `(${point.x.toFixed(2)}, ${point.y.toFixed(2)})`,
        point.px+8,
        point.py-8
    );

    // titik hasil rotasi
    let r=rot(point.x,point.y,rad);

    let rpx=350+r.x*scale;
    let rpy=250-r.y*scale;

    ctx.fillStyle="green";
    ctx.beginPath();
    ctx.arc(rpx,rpy,6,0,Math.PI*2);
    ctx.fill();

    ctx.fillStyle="green";
    ctx.fillText(
        `(${r.x.toFixed(2)}, ${r.y.toFixed(2)})`,
        rpx+8,
        rpy-8
    );
}

/* UI */
document.getElementById("valT").innerText=deg+"°";

document.getElementById("fAwal").innerText=
"f(x) = " + fEl.value;

document.getElementById("fBaru").innerText=
"rotasi θ = " + deg + "°";

}

/* SNAP */
function snap(mx,my){

let f=fparse(fEl.value);

let best=null;
let min=999999;

for(let x=-20;x<=20;x+=0.05){

    let y=f(x);

    let px=350+x*scale;
    let py=250-y*scale;

    let d=(mx-px)**2+(my-py)**2;

    if(d<min){
        min=d;
        best={x,y,px,py};
    }
}

return best;
}

/* DRAG */
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
fEl.oninput = tEl.oninput = draw;

draw();

</script>
</div>
<div class="back-btn">
    <a href="http://localhost/SKRIPSI/Untitled-1.php">Kembali</a>
</div>
<div class="footer">

</body>
</html>