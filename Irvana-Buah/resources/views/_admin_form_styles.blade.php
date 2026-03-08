<style>
.fsh{display:flex;align-items:center;gap:10px;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--glass-border);}
.fsi{width:30px;height:30px;border:1px solid;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.fsi.blue{background:rgba(96,165,250,.1);border-color:rgba(96,165,250,.25);color:#60a5fa;}
.fsi.green{background:rgba(52,211,153,.1);border-color:rgba(52,211,153,.25);color:#34d399;}
.fsi.yellow{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.25);color:#fbbf24;}
.fsi.purple{background:rgba(167,139,250,.1);border-color:rgba(167,139,250,.25);color:#a78bfa;}
.fsi.red{background:rgba(248,113,113,.1);border-color:rgba(248,113,113,.25);color:#f87171;}
.fst{font-size:.88rem;font-weight:700;color:var(--text-primary);margin:0;}
.fl{display:block;font-size:.7rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;}
.fi{width:100%;padding:9px 13px;border:1px solid var(--glass-border);border-radius:8px;font-size:.85rem;background:rgba(255,255,255,.04);color:var(--text-primary);transition:border-color .15s,box-shadow .15s;box-sizing:border-box;}
.fi:focus{outline:none;border-color:rgba(96,165,250,.5);box-shadow:0 0 0 3px rgba(96,165,250,.07);}
.fie{border-color:rgba(248,113,113,.5)!important;}
select.fi option{background:#1a2035;color:var(--text-primary);}
textarea.fi{resize:vertical;}
.fe{font-size:.72rem;color:#f87171;margin-top:4px;}
.req{color:#f87171;}
.tl{display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;}
.ti{display:none;}
.tt{width:38px;height:21px;background:rgba(255,255,255,.08);border:1px solid var(--glass-border);border-radius:11px;position:relative;transition:all .2s;flex-shrink:0;}
.tt::after{content:'';position:absolute;top:2px;left:2px;width:15px;height:15px;background:rgba(255,255,255,.4);border-radius:50%;transition:all .2s;}
.ti:checked+.tt{background:rgba(52,211,153,.2);border-color:rgba(52,211,153,.5);}
.ti:checked+.tt::after{left:21px;background:#34d399;}
.tab-btn{padding:7px 16px;border-radius:8px;font-size:.8rem;font-weight:600;border:1px solid var(--glass-border);background:transparent;color:var(--text-muted);cursor:pointer;transition:all .15s;}
.tab-btn.tab-active{border-color:rgba(96,165,250,.4);background:rgba(96,165,250,.1);color:#60a5fa;}
.alert-error{background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.25);color:#f87171;padding:12px 16px;border-radius:10px;font-size:.83rem;}
.detail-card{background:rgba(255,255,255,.03);border:1px solid var(--glass-border);border-radius:10px;padding:14px 16px;}
.detail-label{font-size:.68rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;}
.detail-value{font-size:.88rem;font-weight:600;color:var(--text-primary);}
.detail-sub{font-size:.75rem;color:var(--text-secondary);margin-top:2px;}
.delete-modal{position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,.7);backdrop-filter:blur(4px);}
.delete-modal-box{background:rgba(12,17,24,.97);border:1px solid var(--glass-border-strong);border-radius:var(--radius-2xl);padding:2rem;max-width:26rem;width:100%;text-align:center;box-shadow:var(--shadow-lg);}
</style>