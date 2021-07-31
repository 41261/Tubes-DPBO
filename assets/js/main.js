/***********************************************************
 * Filename     : main.js
 * Programmer   : Muhammad Argi Nafisa
 * Date         : 01-06-2020
 * Email        : argiargi@upi.edu / arginafisa@gmail.com
 * Deskripsi    : Program utama game
************************************************************/

var kotak; // variabel cube dalam game
var virus = []; // array virus dalam game
var score; // variabel untuk menampilkan score
var backgroundMusic; // background music dalam game
var end = 0; // variabel temp jika game berakhir

// function untuk memulai game
function startGame() {
    kotak = new component(30, 30, "green", 10, 120); // komponen player
    score = new component("30px", "Agency FB", "white", 280, 40, "text"); // komponen tampilan score
    backgroundMusic = new Audio("../assets/audio/play.mp3"); // audio dari assets
    backgroundMusic.loop = true; // diputar secara loop
    backgroundMusic.play(); // memulai memutar musik
    myGameArea.start(); // proses memulai game
}

// area game
var myGameArea = {
    canvas : document.createElement("canvas"), // membuat canvas
    // function start untuk tampilan awal game
    start : function() {
        this.canvas.width = 480; // lebar canvas
        this.canvas.height = 270; // tinggi canvas
        this.context = this.canvas.getContext("2d"); // context canvas 2d
        document.body.insertBefore(this.canvas, document.body.childNodes[0]); // posisi penempatan canvas
        this.frameNo = 0; // jumlah frame
        this.interval = setInterval(updateGameArea, 20); // set interval untuk update area game
        this.gameended = false; // kondisi awal game
        
        // addEventListener untuk menerima inputan keyboard
        window.addEventListener('keydown', function (e) {
            myGameArea.keys = (myGameArea.keys || []);
            myGameArea.keys[e.keyCode] = (e.type == "keydown");
        })
        window.addEventListener('keyup', function (e) {
            myGameArea.keys[e.keyCode] = (e.type == "keydown");
        })
        },
    
        // function clear untuk menghapus object pada canvas
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}

// function untuk membuat komponen dalam game
function component(width, height, color, x, y, type) {
    this.type = type; // jenis object
    this.score = 0;
    this.width = width;
    this.height = height;

    // kecepatan object
    this.speedX = 0;
    this.speedY = 0;   
    
    // posisi object
    this.x = x;
    this.y = y;

    // function untuk mengupdate game setiap frame
    this.update = function() {
        ctx = myGameArea.context;
        if (this.type == "text") {
            ctx.font = this.width + " " + this.height;
            ctx.fillStyle = color;
            ctx.fillText(this.text, this.x, this.y);
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }
    }

    // function untuk mengupdate posisi komponen
    this.newPos = function() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.hitBottom();
    }

    // function untuk komponen ketika menyentuh frame bawah
    this.hitBottom = function() {
        var rockbottom = myGameArea.canvas.height - this.height;
        if (this.y > rockbottom) {
            this.y = rockbottom;
        }
    }

    // function untuk mengetahui adanya komponen yang bertabrakan
    this.crashWith = function(otherobj) {
        var myleft = this.x;
        var myright = this.x + (this.width);
        var mytop = this.y;
        var mybottom = this.y + (this.height);
        var otherleft = otherobj.x;
        var otherright = otherobj.x + (otherobj.width);
        var othertop = otherobj.y;
        var otherbottom = otherobj.y + (otherobj.height);
        var crash = true;

        // jika player tidak menabrak virus
        if ((mybottom < othertop) || (mytop > otherbottom) || (myright < otherleft) || (myleft > otherright)) {
            crash = false;
        }
        return crash;
    }
}

// function untuk mengupdate area game
function updateGameArea() {
    var x, height, gap, minHeight, maxHeight, minGap, maxGap
    for (i = 0; i < virus.length; i += 1) {
        if (kotak.crashWith(virus[i])) { // jika player bertabrakan dengan virus
            if(end == 0){ // jika variabel end == 0
                end = 1; // end menjadi 1
                backgroundMusic.pause(); // background music berhenti
                alert("GAME OVER"); // memunculkan alert berpesan "GAME OVER"
                location.replace("update.php?score="+myGameArea.frameNo); // menuju controller update.php
            }
            // return;
        } 
    }
    myGameArea.clear(); // refresh tampilan game
    myGameArea.frameNo += 1; // nomor frame bertambah 1

    if (myGameArea.frameNo == 1 || everyinterval(150)) {
        x = myGameArea.canvas.width;
        minHeight = 20;
        maxHeight = 200;
        height = Math.floor(Math.random()*(maxHeight-minHeight+1)+minHeight); // random tinggi virus
        minGap = 50;
        maxGap = 200;
        gap = Math.floor(Math.random()*(maxGap-minGap+1)+minGap); // random gap virus

        // setiap virus muncul dengan height dan gap bervariasi secara random
        virus.push(new component(10, height, "red", x, 0));
        virus.push(new component(10, x - height - gap, "red", x, height + gap));
    }

    if(myGameArea.keys && myGameArea.keys[40]){ // jika menekan ArrowUp pada keyboard
        kotak.y += 3; // komponen akan naik
    }
    if(myGameArea.keys && myGameArea.keys[38]){ // jika menekan ArrowDown pada keyboard
        kotak.y -= 3; // komponen akan turun
    }

    for (i = 0; i < virus.length; i += 1) {
        virus[i].x += -1;
        virus[i].update(); // refresh tampilan virus
    }

    score.text="SCORE: " + myGameArea.frameNo; // menampilkan score pada game
    score.update(); // refresh tampilan score
    kotak.newPos(); // refresh posisi komponen
    kotak.update(); // refresh tampilan komponen
}

function everyinterval(n) {
    if ((myGameArea.frameNo / n) % 1 == 0) {return true;}
    return false;
}