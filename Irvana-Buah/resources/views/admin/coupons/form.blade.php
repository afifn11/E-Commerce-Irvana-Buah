<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><a href="{{ route('admin.coupons.index') }}">Kupon</a><span class="breadcrumb-sep">/</span><span>{{ $coupon->id ? 'Edit' : 'Buat Baru' }}</span></p>
                <h2 class="page-title">{{ $coupon->id ? 'Edit Kupon' : 'Buat Kupon Baru' }}</h2>
            </div>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
            <div class="alert-error mb-5">⚠ @foreach($errors->all() as $e){{ $e }}. @endforeach</div>
            @endif

            <form action="{{ $coupon->id ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}" method="POST">
                @csrf
                @if($coupon->id) @method('PUT') @endif

                {{-- Kode & Tipe --}}
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh">
                        <div class="fsi yellow"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg></div>
                        <h4 class="fst">Kode & Diskon</h4>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div style="grid-column:1/-1;">
                            <label class="fl">Kode Kupon <span class="req">*</span></label>
                            <input type="text" name="code" value="{{ old('code', $coupon->code) }}"
                                   class="fi{{ $errors->has('code') ? ' fie' : '' }}"
                                   placeholder="CONTOH20" style="text-transform:uppercase;font-weight:700;letter-spacing:.1em;" required>
                            @error('code')<p class="fe">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="fl">Tipe Diskon <span class="req">*</span></label>
                            <select name="type" id="couponType" class="fi">
                                <option value="percent" {{ old('type',$coupon->type)==='percent' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="fixed"   {{ old('type',$coupon->type)==='fixed'   ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                        </div>
                        <div>
                            <label class="fl">Nilai Diskon <span class="req">*</span></label>
                            <div style="display:flex;">
                                <span id="typeLabel" style="display:flex;align-items:center;padding:0 12px;background:rgba(255,255,255,.06);border:1px solid var(--glass-border);border-right:none;border-radius:8px 0 0 8px;font-size:.85rem;color:var(--text-muted);font-weight:700;white-space:nowrap;">%</span>
                                <input type="number" name="value" value="{{ old('value', $coupon->value) }}"
                                       class="fi{{ $errors->has('value') ? ' fie' : '' }}"
                                       style="border-radius:0 8px 8px 0;" min="1" step="any" required>
                            </div>
                            @error('value')<p class="fe">{{ $message }}</p>@enderror
                        </div>
                        <div id="maxDiscountGroup">
                            <label class="fl">Maks. Diskon (Rp)</label>
                            <input type="number" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}"
                                   class="fi" min="0" step="1000" placeholder="Kosong = tidak ada batas">
                            <p style="font-size:.72rem;color:var(--text-muted);margin-top:4px;">Untuk tipe persen: batas nominal maksimum</p>
                        </div>
                        <div>
                            <label class="fl">Deskripsi</label>
                            <input type="text" name="description" value="{{ old('description', $coupon->description) }}"
                                   class="fi" placeholder="Contoh: Diskon spesial Ramadan">
                        </div>
                    </div>
                </div>

                {{-- Batasan --}}
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh">
                        <div class="fsi blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                        <h4 class="fst">Batasan Penggunaan</h4>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label class="fl">Minimum Order (Rp)</label>
                            <input type="number" name="min_order" value="{{ old('min_order', $coupon->min_order ?? 0) }}"
                                   class="fi" min="0" step="1000">
                            <p style="font-size:.72rem;color:var(--text-muted);margin-top:4px;">0 = tidak ada minimum</p>
                        </div>
                        <div>
                            <label class="fl">Batas Total Penggunaan</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                   class="fi" min="1" placeholder="Kosong = unlimited">
                        </div>
                        <div>
                            <label class="fl">Batas Per Pengguna</label>
                            <input type="number" name="per_user_limit" value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}"
                                   class="fi" min="1">
                        </div>
                    </div>
                </div>

                {{-- Masa Berlaku --}}
                <div class="table-wrap mb-4" style="padding:22px 26px;">
                    <div class="fsh">
                        <div class="fsi green"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <h4 class="fst">Masa Berlaku</h4>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label class="fl">Berlaku Mulai</label>
                            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}" class="fi">
                        </div>
                        <div>
                            <label class="fl">Berlaku Sampai</label>
                            <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}" class="fi">
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="table-wrap mb-5" style="padding:22px 26px;">
                    <div class="fsh">
                        <div class="fsi purple"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <h4 class="fst">Status Kupon</h4>
                    </div>
                    <input type="hidden" name="is_active" value="0">
                    <label class="tl">
                        <input type="checkbox" name="is_active" value="1" id="isActive"
                               {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }} class="ti">
                        <span class="tt"></span>
                        <span style="font-size:.85rem;font-weight:500;color:var(--text-primary);">Kupon Aktif</span>
                    </label>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;padding-bottom:2rem;">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $coupon->id ? 'Simpan Perubahan' : 'Buat Kupon' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('_admin_form_styles')
    @push('scripts')
    <script>
    const typeSelect = document.getElementById('couponType');
    const typeLabel  = document.getElementById('typeLabel');
    const maxGroup   = document.getElementById('maxDiscountGroup');
    function updateType() {
        const v = typeSelect.value;
        typeLabel.textContent = v === 'percent' ? '%' : 'Rp';
        maxGroup.style.display = v === 'percent' ? '' : 'none';
    }
    typeSelect.addEventListener('change', updateType);
    updateType();
    document.querySelector('[name=code]').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    </script>
    @endpush
</x-app-layout>