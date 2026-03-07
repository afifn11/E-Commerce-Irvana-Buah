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
    width: 340px; max-height: 480px;
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
    color: #fff; display: flex; align-items: center; gap: 10px;
}
.cb-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.cb-title   { flex: 1; }
.cb-title strong { font-size: .92rem; display: block; }
.cb-title span   { font-size: .72rem; opacity: .8; }
.cb-close { background: none; border: none; color: #fff; font-size: 1rem; cursor: pointer; opacity: .8; padding: 4px; }
.cb-close:hover { opacity: 1; }
.cb-messages {
    flex: 1; overflow-y: auto; padding: 14px; display: flex; flex-direction: column; gap: 10px;
}
.cb-msg { max-width: 85%; }
.cb-msg.bot { align-self: flex-start; }
.cb-msg.user { align-self: flex-end; }
.cb-bubble {
    padding: 10px 14px; border-radius: 16px; font-size: .84rem; line-height: 1.5;
}
.cb-msg.bot  .cb-bubble { background: #f1f5f9; color: #1e293b; border-radius: 4px 16px 16px 16px; }
.cb-msg.user .cb-bubble { background: #0a4db8; color: #fff; border-radius: 16px 4px 16px 16px; }
.cb-time { font-size: .68rem; color: #94a3b8; margin-top: 3px; }
.cb-msg.user .cb-time { text-align: right; }
.cb-quick {
    padding: 8px 14px; display: flex; flex-wrap: wrap; gap: 6px; border-top: 1px solid #f1f5f9;
}
.cb-chip {
    padding: 5px 12px; background: #eaf0fc; color: #0a4db8;
    border: 1px solid #c7d7f5; border-radius: 999px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .15s; white-space: nowrap;
}
.cb-chip:hover { background: #0a4db8; color: #fff; }
.cb-input-row {
    padding: 10px 14px; display: flex; gap: 8px; border-top: 1px solid #f1f5f9;
}
.cb-input {
    flex: 1; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 999px;
    font-size: .84rem; outline: none; transition: border-color .2s;
}
.cb-input:focus { border-color: #0a4db8; }
.cb-send {
    width: 36px; height: 36px; border-radius: 50%;
    background: #0a4db8; border: none; color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: background .2s;
}
.cb-send:hover { background: #0843a1; }
.cb-typing span {
    width: 6px; height: 6px; background: #94a3b8; border-radius: 50%; display: inline-block;
    animation: cbDot 1.2s ease-in-out infinite;
}
.cb-typing span:nth-child(2) { animation-delay: .2s; }
.cb-typing span:nth-child(3) { animation-delay: .4s; }
@keyframes cbDot { 0%,80%,100%{transform:scale(.6);opacity:.4} 40%{transform:scale(1);opacity:1} }
@keyframes cbEntrance { from{transform:scale(0) rotate(-180deg);opacity:0} to{transform:scale(1) rotate(0);opacity:1} }
@media (max-width:400px) { .chatbot-window { width: calc(100vw - 32px); right: 16px; } }
</style>

{{-- Chatbot FAB --}}
<button class="chatbot-fab" id="chatbotFab" aria-label="Bantuan">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="cb-badge" id="cbBadge">1</span>
</button>

{{-- Chatbot Window --}}
<div class="chatbot-window" id="chatbotWindow">
    <div class="cb-header">
        <div class="cb-avatar">🍊</div>
        <div class="cb-title">
            <strong>Irvana Assistant</strong>
            <span>Online — siap membantu</span>
        </div>
        <button class="cb-close" id="chatbotClose"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="cb-messages" id="cbMessages"></div>

    <div class="cb-quick" id="cbQuick"></div>

    <div class="cb-input-row">
        <input class="cb-input" id="cbInput" placeholder="Ketik pertanyaan..." autocomplete="off">
        <button class="cb-send" id="cbSend">
            <i class="bi bi-send-fill" style="font-size:.8rem;"></i>
        </button>
    </div>
</div>

<script>
(function() {
    const FAQ = [
        {
            keywords: ['harga','mahal','murah','berapa'],
            answer: 'Harga produk bervariasi mulai dari Rp 15.000/kg. Anda bisa cek harga terbaru di halaman <a href="/shop" style="color:#0a4db8;">Katalog Produk</a> ya! 🍎',
            chips: ['Lihat produk diskon','Cara pesan']
        },
        {
            keywords: ['pesan','order','beli','cara','checkout'],
            answer: 'Cara pesan di Irvana Buah sangat mudah:\n1️⃣ Pilih produk → klik "Tambah ke Keranjang"\n2️⃣ Buka keranjang → klik "Checkout"\n3️⃣ Isi alamat & metode bayar\n4️⃣ Konfirmasi pesanan ✅',
            chips: ['Metode pembayaran','Pengiriman']
        },
        {
            keywords: ['bayar','pembayaran','transfer','cod','qris','gopay','ovo'],
            answer: 'Metode pembayaran yang tersedia:\n💳 Transfer Bank (BCA, BRI, Mandiri)\n📱 QRIS, GoPay, OVO, Dana\n🤝 COD (Bayar di Tempat)\n\nSemua transaksi aman & terenkripsi! 🔒',
            chips: ['Cara pesan','Pengiriman']
        },
        {
            keywords: ['kirim','pengiriman','ongkir','delivery','sampai'],
            answer: 'Pengiriman kami:\n🚚 Gratis ongkir untuk semua pesanan!\n⏰ Estimasi tiba: 1-3 hari kerja\n📍 Tersedia di seluruh Indonesia\n\nKami pastikan buah sampai dalam kondisi segar! 🍇',
            chips: ['Cara pesan','Retur & Komplain']
        },
        {
            keywords: ['retur','komplain','rusak','kecewa','tidak puas','salah'],
            answer: 'Kami berkomitmen kepada kepuasan Anda! Jika ada masalah:\n📸 Foto produk yang bermasalah\n💬 Hubungi kami via WhatsApp dalam 24 jam\n✅ Kami akan segera menangani & memberikan solusi terbaik!',
            chips: ['Hubungi WhatsApp','Lacak pesanan']
        },
        {
            keywords: ['lacak','track','status','pesanan saya','mana'],
            answer: 'Untuk melacak pesanan, masuk ke akun → <a href="/my-orders" style="color:#0a4db8;">Pesanan Saya</a>. Status akan diupdate secara real-time dan Anda akan mendapat notifikasi email setiap perubahan status! 📦',
            chips: ['Cara pesan','Pengiriman']
        },
        {
            keywords: ['stok','tersedia','habis','ada'],
            answer: 'Stok produk diupdate setiap hari. Jika produk tidak tersedia, ada tombol "Stok Habis" di halaman produk. Anda bisa tambahkan ke wishlist ❤️ untuk diberitahu saat stok tersedia!',
            chips: ['Lihat produk','Cara pesan']
        },
        {
            keywords: ['kupon','diskon','promo','voucher','kode'],
            answer: 'Kode kupon yang tersedia:\n🎉 SELAMAT10 — diskon 10% pembelian pertama\n💸 GRATIS25K — potongan Rp 25.000 (min. Rp 100k)\n🍌 BUAH20 — diskon 20% produk premium\n\nMasukkan kode saat checkout ya!',
            chips: ['Cara pesan','Poin loyalitas']
        },
        {
            keywords: ['poin','loyalitas','reward','point'],
            answer: 'Program Poin Irvana Buah:\n⭐ Setiap Rp 1.000 belanja = 1 poin\n💰 1 poin = Rp 10 diskon\n🎯 Tukarkan poin saat checkout!\n\nCek saldo poin Anda di <a href="/my-points" style="color:#0a4db8;">menu Poin Saya</a> 🏆',
            chips: ['Cara pesan','Kupon & Promo']
        },
        {
            keywords: ['daftar','register','akun','login'],
            answer: 'Daftar akun sangat mudah! Klik tombol "Daftar" di pojok kanan atas, isi nama, email, dan password. Dengan akun, Anda bisa:\n✅ Lacak pesanan\n✅ Kumpulkan poin\n✅ Simpan wishlist',
            chips: ['Cara pesan','Poin loyalitas']
        },
    ];

    const QUICK_STARTS = ['Cara pesan','Metode pembayaran','Pengiriman','Kupon & Promo','Poin loyalitas'];
    const KEYWORD_MAP  = {
        'Cara pesan': 'cara pesan',
        'Metode pembayaran': 'bayar',
        'Pengiriman': 'pengiriman',
        'Kupon & Promo': 'kupon',
        'Poin loyalitas': 'poin',
        'Lihat produk diskon': 'diskon',
        'Retur & Komplain': 'retur',
        'Lacak pesanan': 'lacak pesanan',
        'Hubungi WhatsApp': 'whatsapp',
        'Lihat produk': 'produk',
    };

    const fab      = document.getElementById('chatbotFab');
    const win      = document.getElementById('chatbotWindow');
    const close    = document.getElementById('chatbotClose');
    const messages = document.getElementById('cbMessages');
    const quick    = document.getElementById('cbQuick');
    const input    = document.getElementById('cbInput');
    const send     = document.getElementById('cbSend');
    const badge    = document.getElementById('cbBadge');
    let opened = false;

    fab.addEventListener('click', () => {
        opened = !opened;
        win.classList.toggle('open', opened);
        badge.style.display = 'none';
        if (opened && messages.children.length === 0) {
            setTimeout(() => {
                addMessage('bot', 'Halo! 👋 Saya <strong>Irvana Assistant</strong>, siap membantu Anda. Ada yang bisa saya bantu?');
                renderChips(QUICK_STARTS);
            }, 200);
        }
    });
    close.addEventListener('click', () => { opened = false; win.classList.remove('open'); });

    send.addEventListener('click', handleInput);
    input.addEventListener('keydown', e => { if (e.key === 'Enter') handleInput(); });

    function handleInput() {
        const text = input.value.trim();
        if (!text) return;
        input.value = '';
        addMessage('user', text);
        quick.innerHTML = '';
        setTimeout(() => respond(text), 600);
    }

    function respond(text) {
        const lower = text.toLowerCase();

        // Special: WhatsApp redirect
        if (lower.includes('whatsapp') || lower.includes('wa')) {
            addMessage('bot', 'Silakan hubungi kami langsung via WhatsApp untuk bantuan lebih lanjut! 💬');
            setTimeout(() => window.open('https://wa.me/6281234567890?text=' + encodeURIComponent('Halo Irvana Buah, saya butuh bantuan.'), '_blank'), 500);
            renderChips(['Cara pesan','Pengiriman']);
            return;
        }

        // Match FAQ
        const match = FAQ.find(f => f.keywords.some(k => lower.includes(k)));
        if (match) {
            addMessage('bot', match.answer.replace(/\n/g, '<br>'));
            if (match.chips) renderChips(match.chips);
        } else {
            addMessage('bot', 'Hmm, saya belum punya jawaban untuk itu. 🤔 Mau coba pertanyaan lain, atau langsung chat ke WhatsApp kami?');
            renderChips(['Hubungi WhatsApp', ...QUICK_STARTS.slice(0,3)]);
        }
    }

    function addMessage(role, html) {
        // Show typing for bot
        if (role === 'bot') {
            const typing = document.createElement('div');
            typing.className = 'cb-msg bot';
            typing.innerHTML = '<div class="cb-bubble cb-typing"><span></span><span></span><span></span></div>';
            messages.appendChild(typing);
            scrollBottom();
            setTimeout(() => {
                messages.removeChild(typing);
                const el = createBubble(role, html);
                messages.appendChild(el);
                scrollBottom();
            }, 500);
        } else {
            messages.appendChild(createBubble(role, html));
            scrollBottom();
        }
    }

    function createBubble(role, html) {
        const el = document.createElement('div');
        el.className = 'cb-msg ' + role;
        const now = new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
        el.innerHTML = `<div class="cb-bubble">${html}</div><div class="cb-time">${now}</div>`;
        return el;
    }

    function renderChips(chips) {
        quick.innerHTML = '';
        chips.forEach(label => {
            const btn = document.createElement('button');
            btn.className = 'cb-chip';
            btn.textContent = label;
            btn.addEventListener('click', () => {
                addMessage('user', label);
                quick.innerHTML = '';
                const query = KEYWORD_MAP[label] || label.toLowerCase();
                setTimeout(() => respond(query), 400);
            });
            quick.appendChild(btn);
        });
    }

    function scrollBottom() {
        setTimeout(() => messages.scrollTop = messages.scrollHeight, 50);
    }
})();
</script>
