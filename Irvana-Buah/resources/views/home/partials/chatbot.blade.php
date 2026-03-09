<style>
.chatbot-fab {
    position: fixed; bottom: 100px; right: 24px; z-index: 9989;
    width: 56px; height: 56px; border-radius: 50%;
    background: linear-gradient(135deg,#0a4db8,#3b72e0);
    border: none; cursor: pointer; color: #fff; font-size: 1.3rem;
    box-shadow: 0 6px 20px rgba(10,77,184,.4);
    display: flex; align-items: center; justify-content: center;
    transition: transform .25s, box-shadow .25s;
    animation: cbEntrance .5s ease .8s both;
}
.chatbot-fab:hover { transform: scale(1.08); box-shadow: 0 10px 28px rgba(10,77,184,.55); }
.chatbot-fab .cb-badge {
    position: absolute; top: -4px; right: -4px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #ef4444; color: #fff; font-size: .6rem; font-weight: 700;
    border: 2px solid #fff; display: flex; align-items: center; justify-content: center;
}
.chatbot-window {
    position: fixed; bottom: 170px; right: 24px; z-index: 9988;
    width: min(360px, calc(100vw - 32px)); max-height: min(540px, calc(100vh - 200px));
    background: #fff; border-radius: 20px;
    box-shadow: 0 16px 48px rgba(0,0,0,.18);
    display: flex; flex-direction: column;
    transform: scale(.85) translateY(20px); opacity: 0;
    pointer-events: none; transition: all .25s cubic-bezier(.34,1.56,.64,1);
    overflow: hidden;
}
.chatbot-window.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }
.cb-header {
    padding: 16px 18px; background: linear-gradient(135deg,#0a4db8,#3b72e0);
    color: #fff; display: flex; align-items: center; gap: 10px; flex-shrink: 0;
}
.cb-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.cb-title { flex: 1; }
.cb-title strong { font-size: .92rem; display: block; }
.cb-title span { font-size: .72rem; opacity: .8; }
.cb-close { background: none; border: none; color: #fff; font-size: 1rem; cursor: pointer; opacity: .8; padding: 4px; }
.cb-close:hover { opacity: 1; }
.cb-tabs { display: flex; border-bottom: 1px solid #f1f5f9; flex-shrink: 0; }
.cb-tab { flex: 1; padding: 9px 6px; font-size: .78rem; font-weight: 600; background: none; border: none; cursor: pointer; color: #94a3b8; border-bottom: 2px solid transparent; transition: all .15s; display: flex; align-items: center; justify-content: center; gap: 5px; }
.cb-tab.active { color: #0a4db8; border-bottom-color: #0a4db8; }
.cb-tab:hover:not(.active) { color: #475569; }
.cb-messages { flex: 1; overflow-y: auto; padding: 14px; display: flex; flex-direction: column; gap: 10px; }
.cb-msg { max-width: 88%; }
.cb-msg.bot { align-self: flex-start; }
.cb-msg.user { align-self: flex-end; }
.cb-bubble { padding: 10px 14px; border-radius: 16px; font-size: .84rem; line-height: 1.55; }
.cb-msg.bot .cb-bubble { background: #f1f5f9; color: #1e293b; border-radius: 4px 16px 16px 16px; }
.cb-msg.user .cb-bubble { background: #0a4db8; color: #fff; border-radius: 16px 4px 16px 16px; }
.cb-time { font-size: .68rem; color: #94a3b8; margin-top: 3px; }
.cb-msg.user .cb-time { text-align: right; }
.cb-products { display: flex; flex-direction: column; gap: 8px; margin-top: 10px; }
.cb-product-card { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px 10px; text-decoration: none; color: inherit; transition: border-color .15s, box-shadow .15s; }
.cb-product-card:hover { border-color: #0a4db8; box-shadow: 0 2px 10px rgba(10,77,184,.12); color: inherit; }
.cb-product-img { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; background: #f1f5f9; flex-shrink: 0; }
.cb-product-info { flex: 1; min-width: 0; }
.cb-product-name { font-size: .8rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cb-product-cat { font-size: .7rem; color: #64748b; }
.cb-product-price { font-size: .8rem; font-weight: 700; color: #0a4db8; white-space: nowrap; }
.cb-product-arrow { color: #94a3b8; font-size: .8rem; }
.cb-health-panel { flex: 1; overflow-y: auto; padding: 14px; display: flex; flex-direction: column; gap: 10px; }
.cb-health-intro { background: linear-gradient(135deg, #eef4ff, #f0fdf4); border: 1px solid #bfdbfe; border-radius: 14px; padding: 14px; text-align: center; }
.cb-health-intro .cb-hi-icon { font-size: 2rem; margin-bottom: 6px; }
.cb-health-intro p { font-size: .82rem; color: #475569; margin: 0; line-height: 1.5; }
.cb-health-intro strong { color: #0a4db8; }
.cb-health-chips { display: flex; flex-wrap: wrap; gap: 6px; }
.cb-health-chip { padding: 6px 13px; background: #eef4ff; color: #0a4db8; border: 1px solid #bfdbfe; border-radius: 999px; font-size: .78rem; font-weight: 600; cursor: pointer; transition: all .15s; white-space: nowrap; }
.cb-health-chip:hover { background: #0a4db8; color: #fff; border-color: #0a4db8; }
.cb-quick { padding: 8px 14px; display: flex; flex-wrap: wrap; gap: 6px; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
.cb-chip { padding: 5px 12px; background: #eaf0fc; color: #0a4db8; border: 1px solid #c7d7f5; border-radius: 999px; font-size: .78rem; font-weight: 600; cursor: pointer; transition: all .15s; white-space: nowrap; }
.cb-chip:hover { background: #0a4db8; color: #fff; }
.cb-input-row { padding: 10px 14px; display: flex; gap: 8px; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
.cb-input { flex: 1; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 999px; font-size: .84rem; outline: none; transition: border-color .2s; }
.cb-input:focus { border-color: #0a4db8; }
.cb-send { width: 36px; height: 36px; border-radius: 50%; background: #0a4db8; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s; flex-shrink: 0; }
.cb-send:hover { background: #0843a1; }
.cb-send:disabled { background: #cbd5e1; cursor: not-allowed; }
.cb-ai-loading { display: flex; align-items: center; gap: 8px; background: #f1f5f9; border-radius: 4px 16px 16px 16px; padding: 10px 14px; font-size: .82rem; color: #64748b; }
.cb-ai-loading .cb-spinner { width: 16px; height: 16px; border: 2px solid #e2e8f0; border-top-color: #0a4db8; border-radius: 50%; animation: cbSpin .7s linear infinite; flex-shrink: 0; }
.cb-typing span { width: 6px; height: 6px; background: #94a3b8; border-radius: 50%; display: inline-block; animation: cbDot 1.2s ease-in-out infinite; }
.cb-typing span:nth-child(2) { animation-delay: .2s; }
.cb-typing span:nth-child(3) { animation-delay: .4s; }
@keyframes cbDot { 0%,80%,100%{transform:scale(.6);opacity:.4} 40%{transform:scale(1);opacity:1} }
@keyframes cbEntrance { from{transform:scale(0) rotate(-180deg);opacity:0} to{transform:scale(1) rotate(0);opacity:1} }
@keyframes cbSpin { to { transform: rotate(360deg); } }
@media (max-width:480px) { .chatbot-window { width: calc(100vw - 32px); right: 16px; bottom: 160px; } }
</style>

<button class="chatbot-fab" id="chatbotFab" aria-label="Bantuan">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="cb-badge" id="cbBadge">1</span>
</button>

<div class="chatbot-window" id="chatbotWindow">
    <div class="cb-header">
        <div class="cb-avatar">🍊</div>
        <div class="cb-title">
            <strong>Irvana Assistant</strong>
            <span>Online — siap membantu</span>
        </div>
        <button class="cb-close" id="chatbotClose"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="cb-tabs">
        <button class="cb-tab active" id="tabFaq" onclick="switchTab('faq')">
            <i class="bi bi-chat-text"></i> Bantuan
        </button>
        <button class="cb-tab" id="tabHealth" onclick="switchTab('health')">
            <i class="bi bi-heart-pulse"></i> Analisis Kesehatan
        </button>
    </div>
    <div id="paneFaq" style="display:flex;flex-direction:column;flex:1;overflow:hidden;">
        <div class="cb-messages" id="cbMessages"></div>
        <div class="cb-quick" id="cbQuick"></div>
        <div class="cb-input-row">
            <input class="cb-input" id="cbInput" placeholder="Ketik pertanyaan..." autocomplete="off">
            <button class="cb-send" id="cbSend"><i class="bi bi-send-fill" style="font-size:.8rem;"></i></button>
        </div>
    </div>
    <div id="paneHealth" style="display:none;flex-direction:column;flex:1;overflow:hidden;">
        <div class="cb-health-panel" id="cbHealthMessages">
            <div class="cb-health-intro">
                <div class="cb-hi-icon">🥝</div>
                <p><strong>Analisis Buah untuk Kesehatan</strong><br>
                Ceritakan kondisi kesehatan atau kebutuhanmu, dan saya akan rekomendasikan buah yang tepat dari produk kami!</p>
            </div>
            <div class="cb-health-chips" id="cbHealthChips"></div>
        </div>
        <div class="cb-input-row">
            <input class="cb-input" id="cbHealthInput" placeholder="Contoh: buah untuk kulit berjerawat..." autocomplete="off">
            <button class="cb-send" id="cbHealthSend"><i class="bi bi-send-fill" style="font-size:.8rem;"></i></button>
        </div>
    </div>
</div>

<script>
(function() {
    const FAQ = [
        { keywords: ['harga','mahal','murah','berapa'], answer: 'Harga produk bervariasi mulai dari Rp 15.000/kg. Cek harga terbaru di <a href="/shop" style="color:#0a4db8;">Katalog Produk</a> ya! \ud83c\udf4e', chips: ['Lihat produk diskon','Cara pesan'] },
        { keywords: ['pesan','order','beli','cara','checkout'], answer: 'Cara pesan di Irvana Buah sangat mudah:<br>1\ufe0f\u20e3 Pilih produk \u2192 klik "Tambah ke Keranjang"<br>2\ufe0f\u20e3 Buka keranjang \u2192 klik "Checkout"<br>3\ufe0f\u20e3 Isi alamat & metode bayar<br>4\ufe0f\u20e3 Konfirmasi pesanan \u2705', chips: ['Metode pembayaran','Pengiriman'] },
        { keywords: ['bayar','pembayaran','transfer','cod','qris','gopay','ovo'], answer: 'Metode pembayaran yang tersedia:<br>\ud83d\udcb3 Transfer Bank (BCA, BRI, Mandiri)<br>\ud83d\udcf1 QRIS, GoPay, OVO, Dana<br>\ud83e\udd1d COD (Bayar di Tempat)', chips: ['Cara pesan','Pengiriman'] },
        { keywords: ['kirim','pengiriman','ongkir','delivery','sampai'], answer: 'Pengiriman kami:<br>\ud83d\ude9a Gratis ongkir untuk semua pesanan!<br>\u23f0 Estimasi tiba: 1-3 hari kerja<br>\ud83d\udccd Tersedia di seluruh Indonesia', chips: ['Cara pesan','Retur & Komplain'] },
        { keywords: ['retur','komplain','rusak','kecewa','tidak puas','salah'], answer: 'Jika ada masalah:<br>\ud83d\udcf8 Foto produk yang bermasalah<br>\ud83d\udcac Hubungi kami via WhatsApp dalam 24 jam<br>\u2705 Kami akan segera menangani!', chips: ['Hubungi WhatsApp','Lacak pesanan'] },
        { keywords: ['lacak','track','status','pesanan saya','mana'], answer: 'Untuk melacak pesanan, masuk ke akun \u2192 <a href="/my-orders" style="color:#0a4db8;">Pesanan Saya</a>. Status diupdate real-time! \ud83d\udce6', chips: ['Cara pesan','Pengiriman'] },
        { keywords: ['kupon','diskon','promo','voucher','kode'], answer: 'Kode kupon tersedia:<br>\ud83c\udf89 SELAMAT10 \u2014 diskon 10% pembelian pertama<br>\ud83d\udcb8 GRATIS25K \u2014 potongan Rp 25.000 (min. Rp 100k)<br>\ud83c\udf4c BUAH20 \u2014 diskon 20% produk premium', chips: ['Cara pesan','Poin loyalitas'] },
        { keywords: ['poin','loyalitas','reward','point'], answer: 'Program Poin Irvana Buah:<br>\u2b50 Setiap Rp 1.000 belanja = 1 poin<br>\ud83d\udcb0 1 poin = Rp 10 diskon<br>Cek saldo di <a href="/my-points" style="color:#0a4db8;">menu Poin Saya</a> \ud83c\udfc6', chips: ['Cara pesan','Kupon & Promo'] },
        { keywords: ['daftar','register','akun','login'], answer: 'Daftar akun sangat mudah! Klik "Daftar" di pojok kanan atas, isi nama, email, dan password.', chips: ['Cara pesan','Poin loyalitas'] },
    ];
    const QUICK_STARTS = ['Cara pesan','Metode pembayaran','Pengiriman','Kupon & Promo','Poin loyalitas'];
    const KEYWORD_MAP = {'Cara pesan':'cara pesan','Metode pembayaran':'bayar','Pengiriman':'pengiriman','Kupon & Promo':'kupon','Poin loyalitas':'poin','Lihat produk diskon':'diskon','Retur & Komplain':'retur','Lacak pesanan':'lacak pesanan','Hubungi WhatsApp':'whatsapp','Lihat produk':'produk'};
    const HEALTH_SUGGESTIONS = ['Buah untuk kulit berjerawat','Buah untuk meningkatkan imunitas','Buah untuk kesehatan jantung','Buah untuk diet & langsing','Buah untuk kesehatan mata','Buah untuk tulang kuat','Buah untuk penambah energi','Buah untuk ibu hamil'];

    const fab=document.getElementById('chatbotFab'), win=document.getElementById('chatbotWindow'), close=document.getElementById('chatbotClose');
    const messages=document.getElementById('cbMessages'), quick=document.getElementById('cbQuick');
    const input=document.getElementById('cbInput'), send=document.getElementById('cbSend'), badge=document.getElementById('cbBadge');
    const healthInput=document.getElementById('cbHealthInput'), healthSend=document.getElementById('cbHealthSend'), healthMsgs=document.getElementById('cbHealthMessages');
    let opened=false;

    // Health suggestion chips
    const healthChips=document.getElementById('cbHealthChips');
    HEALTH_SUGGESTIONS.forEach(s=>{
        const btn=document.createElement('button'); btn.className='cb-health-chip'; btn.textContent=s;
        btn.addEventListener('click',()=>{ healthInput.value=s; sendHealthMessage(); });
        healthChips.appendChild(btn);
    });

    fab.addEventListener('click',()=>{
        opened=!opened; win.classList.toggle('open',opened); badge.style.display='none';
        if(opened && messages.children.length===0) setTimeout(()=>{ addFaqMsg('bot','Halo! \ud83d\udc4b Saya <strong>Irvana Assistant</strong>, siap membantu Anda. Ada yang bisa saya bantu?'); renderChips(QUICK_STARTS); },200);
    });
    close.addEventListener('click',()=>{ opened=false; win.classList.remove('open'); });

    window.switchTab=function(tab){
        document.getElementById('tabFaq').classList.toggle('active',tab==='faq');
        document.getElementById('tabHealth').classList.toggle('active',tab==='health');
        document.getElementById('paneFaq').style.display=tab==='faq'?'flex':'none';
        document.getElementById('paneHealth').style.display=tab==='health'?'flex':'none';
    };

    send.addEventListener('click',handleFaq);
    input.addEventListener('keydown',e=>{ if(e.key==='Enter') handleFaq(); });
    function handleFaq(){ const t=input.value.trim(); if(!t) return; input.value=''; addFaqMsg('user',t); quick.innerHTML=''; setTimeout(()=>respondFaq(t),600); }
    function respondFaq(text){
        const lower=text.toLowerCase();
        if(lower.includes('whatsapp')||lower.includes(' wa ')){ addFaqMsg('bot','Silakan hubungi kami langsung via WhatsApp! \ud83d\udcac'); setTimeout(()=>window.open('https://wa.me/6281234567890','_blank'),500); renderChips(['Cara pesan','Pengiriman']); return; }
        const match=FAQ.find(f=>f.keywords.some(k=>lower.includes(k)));
        if(match){ addFaqMsg('bot',match.answer); if(match.chips) renderChips(match.chips); }
        else { addFaqMsg('bot','Hmm, mungkin pertanyaanmu terkait kesehatan? Coba tab <strong>Analisis Kesehatan</strong> di atas ya! \ud83c\udf4a'); renderChips(QUICK_STARTS.slice(0,3)); }
    }
    function addFaqMsg(role,html){
        if(role==='bot'){ const t=document.createElement('div'); t.className='cb-msg bot'; t.innerHTML='<div class="cb-bubble cb-typing"><span></span><span></span><span></span></div>'; messages.appendChild(t); scrollEl(messages); setTimeout(()=>{ messages.removeChild(t); messages.appendChild(mkBubble(role,html)); scrollEl(messages); },500); }
        else { messages.appendChild(mkBubble(role,html)); scrollEl(messages); }
    }
    function renderChips(chips){ quick.innerHTML=''; chips.forEach(label=>{ const b=document.createElement('button'); b.className='cb-chip'; b.textContent=label; b.addEventListener('click',()=>{ addFaqMsg('user',label); quick.innerHTML=''; setTimeout(()=>respondFaq(KEYWORD_MAP[label]||label.toLowerCase()),400); }); quick.appendChild(b); }); }

    healthSend.addEventListener('click',sendHealthMessage);
    healthInput.addEventListener('keydown',e=>{ if(e.key==='Enter') sendHealthMessage(); });
    async function sendHealthMessage(){
        const t=healthInput.value.trim(); if(!t||healthSend.disabled) return;
        healthInput.value=''; healthSend.disabled=true;
        healthMsgs.appendChild(mkBubble('user',t)); scrollEl(healthMsgs);
        const loadEl=document.createElement('div'); loadEl.className='cb-msg bot';
        loadEl.innerHTML='<div class="cb-ai-loading"><div class="cb-spinner"></div> Menganalisis dengan AI...</div>';
        healthMsgs.appendChild(loadEl); scrollEl(healthMsgs);
        try {
            const res=await fetch('/api/chatbot',{ method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''}, body:JSON.stringify({message:t}) });
            const data=await res.json();
            healthMsgs.removeChild(loadEl);
            if(data.type==='health'){
                healthMsgs.appendChild(mkBubble('bot',data.answer.replace(/\n/g,'<br>'))); scrollEl(healthMsgs);
                if(data.products&&data.products.length>0){
                    const wrap=document.createElement('div'); wrap.className='cb-msg bot'; wrap.style.maxWidth='100%';
                    const lbl=document.createElement('div'); lbl.style.cssText='font-size:.75rem;color:#64748b;margin-bottom:6px;font-weight:600;'; lbl.textContent='\ud83d\udecd\ufe0f Produk yang Direkomendasikan:';
                    const cards=document.createElement('div'); cards.className='cb-products';
                    data.products.forEach(p=>{ const c=document.createElement('a'); c.className='cb-product-card'; c.href=p.detail_url; c.target='_blank'; c.innerHTML=`<img class="cb-product-img" src="${p.image_url||''}" alt="${p.name}" onerror="this.style.background='#f1f5f9'"><div class="cb-product-info"><div class="cb-product-name">${p.name}</div><div class="cb-product-cat">${p.category}</div><div class="cb-product-price">${p.price}</div></div><i class="bi bi-chevron-right cb-product-arrow"></i>`; cards.appendChild(c); });
                    wrap.appendChild(lbl); wrap.appendChild(cards); healthMsgs.appendChild(wrap); scrollEl(healthMsgs);
                }
            } else { healthMsgs.appendChild(mkBubble('bot','Maaf, terjadi kesalahan. Silakan coba lagi! \ud83d\ude4f')); }
        } catch(e){ if(healthMsgs.contains(loadEl)) healthMsgs.removeChild(loadEl); healthMsgs.appendChild(mkBubble('bot','Koneksi bermasalah. Coba lagi dalam beberapa saat. \ud83d\ude4f')); }
        healthSend.disabled=false; scrollEl(healthMsgs);
    }

    function mkBubble(role,html){ const el=document.createElement('div'); el.className='cb-msg '+role; const now=new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); el.innerHTML=`<div class="cb-bubble">${html}</div><div class="cb-time">${now}</div>`; return el; }
    function scrollEl(el){ setTimeout(()=>el.scrollTop=el.scrollHeight,50); }
})();
</script>