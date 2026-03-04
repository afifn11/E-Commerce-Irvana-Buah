{{-- WhatsApp Floating Widget --}}
<a href="https://wa.me/6281234567890?text={{ urlencode('Halo Irvana Buah, saya ingin bertanya...') }}"
   class="wa-float" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
  <i class="bi bi-whatsapp"></i>
  <span class="wa-tooltip">Chat via WhatsApp</span>
</a>

<style>
.wa-float {
    position: fixed;
    bottom: 28px; right: 24px;
    z-index: 9990;
    width: 58px; height: 58px;
    background: #25d366;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.6rem;
    box-shadow: 0 6px 24px rgba(37,211,102,.4);
    text-decoration: none;
    transition: transform .25s, box-shadow .25s;
    animation: waEntrance .6s ease .5s both;
}
.wa-float:hover {
    transform: scale(1.1);
    box-shadow: 0 10px 32px rgba(37,211,102,.55);
    color: #fff;
}
.wa-float::before {
    content: '';
    position: absolute; inset: -6px;
    border-radius: 50%;
    border: 2px solid rgba(37,211,102,.35);
    animation: waPulse 2s ease-in-out infinite;
}
.wa-tooltip {
    position: absolute;
    right: calc(100% + 12px);
    background: #333; color: #fff;
    padding: 6px 12px; border-radius: 8px;
    font-size: .8rem; font-weight: 600; white-space: nowrap;
    opacity: 0; pointer-events: none;
    transition: opacity .2s;
}
.wa-tooltip::after {
    content: '';
    position: absolute; right: -6px; top: 50%;
    transform: translateY(-50%);
    border: 6px solid transparent;
    border-left-color: #333;
    border-right-width: 0;
}
.wa-float:hover .wa-tooltip { opacity: 1; }

@keyframes waPulse {
    0%, 100% { transform: scale(1); opacity: .5; }
    50%       { transform: scale(1.18); opacity: 0; }
}
@keyframes waEntrance {
    from { transform: scale(0) rotate(-180deg); opacity: 0; }
    to   { transform: scale(1) rotate(0); opacity: 1; }
}

/* Offset from back-to-top button if present */
@media (max-width: 575px) {
    .wa-float { bottom: 80px; right: 16px; width: 50px; height: 50px; font-size: 1.35rem; }
}
</style>
