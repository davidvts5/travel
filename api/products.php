<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Simple Tetris — HTML/CSS/JS (Fixed)</title>
    <style>
        :root{--bg:#0f1720;--panel:#0b1220;--accent:#22c1c3;--muted:#9aa4b2}
        *{box-sizing:border-box}
        html,body{height:100%;margin:0;font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial}
        body{display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,var(--bg),#07101a);color:#e6eef6}
        .wrap{display:grid;grid-template-columns:320px 220px;gap:24px;align-items:start}
        .board{width:320px;height:640px;background:#071425;border-radius:8px;padding:10px;box-shadow:0 8px 30px rgba(0,0,0,.6);display:grid;grid-template-rows:1fr}
        canvas{width:100%;height:100%;background:linear-gradient(180deg,#06121a,#071425);display:block;border-radius:6px}
        .panel{width:220px;padding:18px;border-radius:8px;background:linear-gradient(180deg,var(--panel),#071426);box-shadow:0 6px 20px rgba(0,0,0,.45)}
        h1{margin:0 0 12px 0;font-size:18px;color:var(--accent)}
        .score{font-size:24px;margin:8px 0;color:#fff}
        .small{color:var(--muted);font-size:13px}
        .controls{margin-top:12px}
        .controls p{margin:.4rem 0}
        .btn{display:inline-block;padding:8px 12px;border-radius:6px;background:rgba(255,255,255,.06);cursor:pointer}
        .footer{margin-top:14px;font-size:12px;color:var(--muted)}
    </style>
</head>
<body>
<div class="wrap">
    <div class="board">
        <canvas id="game" width="320" height="640"></canvas>
    </div>

    <div class="panel">
        <h1>Simple Tetris (Fixed)</h1>
        <div class="small">Score</div>
        <div id="score" class="score">0</div>
        <div class="small">Level</div>
        <div id="level" class="score">1</div>

        <div style="margin-top:10px">
            <div class="small">Next</div>
            <canvas id="next" width="160" height="160" style="background:transparent;border-radius:6px;display:block;margin-top:8px"></canvas>
        </div>

        <div class="controls">
            <div class="small">Controls</div>
            <p><span class="btn">←</span> Move left</p>
            <p><span class="btn">→</span> Move right</p>
            <p><span class="btn">↓</span> Soft drop</p>
            <p><span class="btn">Space</span> Hard drop</p>
            <p><span class="btn">Z / X</span> Rotate</p>
            <p><span class="btn">P</span> Pause</p>
        </div>

        <div class="footer">Open this file in your browser. Works offline. Want hold, sound or mobile touch controls — say the word.</div>
    </div>
</div>

<script>
    // Fixed Simple Tetris — single-file implementation
    // Grid: 10x20. Each cell 32x32px.

    const COLS = 10, ROWS = 20, CELL = 32;
    const canvas = document.getElementById('game');
    const ctx = canvas.getContext('2d');
    const nextCanvas = document.getElementById('next');
    const nctx = nextCanvas.getContext('2d');

    // Colors for pieces
    const COLORS = {
        I: '#22c1c3', J: '#6b8cff', L: '#ffb86b', O: '#ffd166', S: '#53e0a4', T: '#c080ff', Z: '#ff6b6b'
    };

    // Tetromino definitions (rotation states)
    const SHAPES = {
        I: [[0,0,0,0],[1,1,1,1],[0,0,0,0],[0,0,0,0]],
        J: [[1,0,0],[1,1,1],[0,0,0]],
        L: [[0,0,1],[1,1,1],[0,0,0]],
        O: [[1,1],[1,1]],
        S: [[0,1,1],[1,1,0],[0,0,0]],
        T: [[0,1,0],[1,1,1],[0,0,0]],
        Z: [[1,1,0],[0,1,1],[0,0,0]]
    };

    // Rotate matrix clockwise
    function rotate(mat){
        const N = mat.length;
        const res = Array.from({length:N},()=>Array(N).fill(0));
        for(let r=0;r<N;r++) for(let c=0;c<N;c++) res[c][N-1-r]=mat[r][c];
        return res;
    }

    // Create empty board
    function createBoard(){
        return Array.from({length:ROWS},()=>Array(COLS).fill(null));
    }
    let board = createBoard();

    // Piece class
    class Piece{
        constructor(type){
            this.type = type;
            const base = SHAPES[type];
            const size = base.length;
            // normalize to 4x4 matrix
            this.matrix = Array.from({length:4},()=>Array(4).fill(0));
            for(let r=0;r<size;r++) for(let c=0;c<base[r].length;c++) this.matrix[r][c]=base[r][c];
            this.x = Math.floor((COLS - 4) / 2);
            this.y = -2; // start a bit above so it can enter smoothly
        }
        rotate(){ this.matrix = rotate(this.matrix); }
        clone(){ const p = new Piece(this.type); p.matrix = this.matrix.map(r=>r.slice()); p.x=this.x; p.y=this.y; return p; }
    }

    // Random bag shuffler (7-bag)
    function newShuffler(){
        let queue = [];
        return function(){
            if(queue.length===0){
                queue = Object.keys(SHAPES).slice();
                for(let i=queue.length-1;i>0;i--){ const j=Math.floor(Math.random()*(i+1)); [queue[i],queue[j]]=[queue[j],queue[i]]; }
            }
            return queue.shift();
        }
    }
    const nextType = newShuffler();

    // Game state
    let current = new Piece(nextType());
    let upcoming = new Piece(nextType());
    let dropInterval = 800; // ms
    let dropTimer = 0;
    let lastTime = performance.now();
    let score = 0; let level = 1; let lines = 0;
    let gameOver = false; let paused=false;

    // Collision check
    function collides(piece, board, ox=0, oy=0){
        for(let r=0;r<4;r++) for(let c=0;c<4;c++){
            if(piece.matrix[r][c]){
                const x = piece.x + c + ox;
                const y = piece.y + r + oy;
                if(x<0 || x>=COLS || y>=ROWS) return true;
                if(y>=0 && board[y][x]) return true;
            }
        }
        return false;
    }

    // Lock piece into board
    function lockPiece(){
        for(let r=0;r<4;r++) for(let c=0;c<4;c++){
            if(current.matrix[r][c]){
                const x = current.x + c;
                const y = current.y + r;
                if(y<0){ // piece locked above top -> game over
                    gameOver=true; return;
                }
                board[y][x]=current.type;
            }
        }
        clearLines();
        current = upcoming;
        upcoming = new Piece(nextType());
        // if new piece collides immediately -> game over
        if(collides(current, board, 0, 0)) { gameOver = true; }
    }

    // Clear full rows
    function clearLines(){
        let cleared = 0;
        for(let r=ROWS-1;r>=0;r--){
            if(board[r].every(cell=>cell!==null)){
                board.splice(r,1); board.unshift(Array(COLS).fill(null));
                cleared++; r++; // recheck same index as rows moved down
            }
        }
        if(cleared>0){
            lines += cleared;
            score += [0,40,100,300,1200][cleared] * level; // classic scoring
            level = Math.floor(lines/10)+1;
            dropInterval = Math.max(100, 800 - (level-1)*60);
            updateHUD();
        }
    }

    function updateHUD(){
        document.getElementById('score').textContent = score;
        document.getElementById('level').textContent = level;
    }

    // Hard drop
    function hardDrop(){
        while(!collides(current,board,0,1)) current.y++;
        lockPiece();
        dropTimer = 0;
    }

    // Rotate with simple wall-kick (try shifts)
    function rotatePiece(dir=1){
        const clone = current.clone();
        current.rotate();
        // simple kicks
        const kicks = [0, -1, 1, -2, 2];
        for(const k of kicks){
            if(!collides(current,board,k,0)) { current.x += k; return; }
        }
        // fail -> revert
        current = clone;
    }

    // Draw helper
    function drawCell(x,y,color){
        ctx.fillStyle = color;
        ctx.fillRect(x*CELL+1, y*CELL+1, CELL-2, CELL-2);
        // inner highlight
        ctx.fillStyle = 'rgba(255,255,255,0.06)';
        ctx.fillRect(x*CELL+4, y*CELL+4, CELL-8, CELL-8);
    }

    function render(){
        // clear
        ctx.clearRect(0,0,canvas.width,canvas.height);
        // draw board background
        ctx.fillStyle = '#041018'; ctx.fillRect(0,0,canvas.width,canvas.height);

        // draw locked blocks
        for(let r=0;r<ROWS;r++) for(let c=0;c<COLS;c++){
            const t = board[r][c];
            if(t){ drawCell(c,r,COLORS[t]); }
        }

        // draw current piece
        for(let r=0;r<4;r++) for(let c=0;c<4;c++){
            if(current.matrix[r][c]){
                const x = current.x + c; const y = current.y + r;
                if(y>=0) drawCell(x,y,COLORS[current.type]);
            }
        }

        // subtle grid lines
        ctx.strokeStyle='rgba(255,255,255,0.02)';
        for(let x=0;x<=COLS;x++){ ctx.beginPath(); ctx.moveTo(x*CELL,0); ctx.lineTo(x*CELL,ROWS*CELL); ctx.stroke(); }
        for(let y=0;y<=ROWS;y++){ ctx.beginPath(); ctx.moveTo(0,y*CELL); ctx.lineTo(COLS*CELL,y*CELL); ctx.stroke(); }

        renderNext();
    }

    function renderNext(){
        nctx.clearRect(0,0,nextCanvas.width,nextCanvas.height);
        const scale = 28; const offsetX=10, offsetY=10;
        nctx.save(); nctx.translate(offsetX,offsetY);
        for(let r=0;r<4;r++) for(let c=0;c<4;c++){
            if(upcoming.matrix[r][c]){
                nctx.fillStyle = COLORS[upcoming.type];
                nctx.fillRect(c*scale, r*scale, scale-4, scale-4);
            }
        }
        nctx.restore();
    }

    // Game loop
    function update(time=performance.now()){
        const dt = time - lastTime; lastTime = time;

        if(!gameOver && !paused){
            dropTimer += dt;
            // allow multiple drops if frame lag
            while(dropTimer >= dropInterval){
                dropTimer -= dropInterval;
                if(!collides(current,board,0,1)){
                    current.y++;
                } else {
                    lockPiece();
                    break; // after lock, don't continue moving the just-locked piece
                }
            }
        }

        render();

        // continue loop even if paused, so unpause works
        if(gameOver){
            // final render already called
            // show a simple overlay
            ctx.fillStyle = 'rgba(0,0,0,0.5)'; ctx.fillRect(0,0,canvas.width,canvas.height);
            ctx.fillStyle = '#fff'; ctx.font = '24px system-ui'; ctx.textAlign='center';
            ctx.fillText('GAME OVER', canvas.width/2, canvas.height/2);
        }

        requestAnimationFrame(update);
    }

    // Controls
    document.addEventListener('keydown', e=>{
        if(e.key==='ArrowLeft'){ if(!collides(current,board,-1,0)) current.x--; }
        else if(e.key==='ArrowRight'){ if(!collides(current,board,1,0)) current.x++; }
        else if(e.key==='ArrowDown'){ if(!collides(current,board,0,1)) current.y++; dropTimer=0; }
        else if(e.code==='Space'){ e.preventDefault(); hardDrop(); }
        else if(e.key.toLowerCase()==='z'){ rotatePiece(-1); }
        else if(e.key.toLowerCase()==='x'){ rotatePiece(1); }
        else if(e.key.toLowerCase()==='p'){ paused = !paused; }
        updateHUD(); render();
    });

    // start
    updateHUD(); lastTime = performance.now(); requestAnimationFrame(update);

</script>
</body>
</html>
