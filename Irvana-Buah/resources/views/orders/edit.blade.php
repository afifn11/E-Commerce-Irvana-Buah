<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span>
                    <a href="{{ route('admin.orders.index') }}">Pesanan</a><span class="breadcrumb-sep">/</span>
                    <a href="{{ route('admin.orders.show', $order->id) }}" style="font-family:var(--font-mono)">{{ $order->order_number }}</a><span class="breadcrumb-sep">/</span>
                    <span>Edit</span>
                </p>
                <h2 class="page-title">Edit Pesanan</h2>
            </div>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-ghost btn-sm">← Kembali ke Detail</a>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
            <div style="background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.25);color:#f87171;padding:14px 18px;border-radius:10px;margin-bottom:20px;">
                <div style="font-size:.85rem;font-weight:700;margin-bottom:8px;">⚠ Terdapat kesalahan:</div>
                <ul style="margin:0;padding-left:16px;font-size:.83rem;">
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf @method('PUT')

                {{-- Nomor Pesanan (readonly) --}}
                <div class="table-wrap mb-4" style="padding:20px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--glass-border);">
                        <div style="width:28px;height:28px;background:rgba(96,165,250,.1);border:1px solid rgba(96,165,250,.2);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Identitas Pesanan</h4>
                    </div>
                    <div>
                        <label class="form-label">Nomor Pesanan</label>
                        <input type="text" value="{{ $order->order_number }}" class="form-input" readonly
                               style="background:rgba(255,255,255,.03);cursor:not-allowed;font-family:var(--font-mono);opacity:.6;">
                        <p style="font-size:.72rem;color:var(--text-muted);margin-top:4px;">Nomor pesanan tidak dapat diubah.</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="table-wrap mb-4" style="padding:20px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--glass-border);">
                        <div style="width:28px;height:28px;background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.2);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#fbbf24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Status Pesanan</h4>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label class="form-label">Status Pesanan <span style="color:#f87171">*</span></label>
                            <select name="status" class="form-input" required>
                                @foreach(\App\Enums\OrderStatus::cases() as $s)
                                    @php $cur = $order->status instanceof \BackedEnum ? $order->status->value : (string)$order->status; @endphp
                                    <option value="{{ $s->value }}" {{ old('status', $cur) === $s->value ? 'selected' : '' }}>
                                        {{ $s->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Status Pembayaran <span style="color:#f87171">*</span></label>
                            <select name="payment_status" class="form-input" required>
                                @foreach(\App\Enums\PaymentStatus::cases() as $p)
                                    @php $curP = $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string)$order->payment_status; @endphp
                                    <option value="{{ $p->value }}" {{ old('payment_status', $curP) === $p->value ? 'selected' : '' }}>
                                        {{ $p->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" class="form-input">
                                @foreach(\App\Enums\PaymentMethod::cases() as $m)
                                    @php $curM = $order->payment_method instanceof \BackedEnum ? $order->payment_method->value : (string)$order->payment_method; @endphp
                                    <option value="{{ $m->value }}" {{ old('payment_method', $curM) === $m->value ? 'selected' : '' }}>
                                        {{ $m->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Pengiriman --}}
                <div class="table-wrap mb-4" style="padding:20px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--glass-border);">
                        <div style="width:28px;height:28px;background:rgba(52,211,153,.1);border:1px solid rgba(52,211,153,.2);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Info Pengiriman</h4>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div>
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea name="shipping_address" class="form-input" rows="3"
                                      style="resize:vertical;">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                            @error('shipping_address') <p style="font-size:.72rem;color:#f87171;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="shipping_phone" class="form-input"
                                   value="{{ old('shipping_phone', $order->shipping_phone) }}" placeholder="08xxxxxxxxxx">
                            @error('shipping_phone') <p style="font-size:.72rem;color:#f87171;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Catatan Pesanan</label>
                            <textarea name="notes" class="form-input" rows="2"
                                      style="resize:vertical;" placeholder="Catatan dari pelanggan (opsional)">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <style>
    .form-label { display:block;font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px; }
    .form-input { width:100%;padding:9px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.85rem;background:var(--surface);color:var(--text-primary);transition:border-color .15s; }
    .form-input:focus { outline:none;border-color:rgba(96,165,250,.5);box-shadow:0 0 0 3px rgba(96,165,250,.08); }
    select.form-input option { background:#1a1f2e;color:var(--text-primary); }
    </style>

</x-app-layout>
