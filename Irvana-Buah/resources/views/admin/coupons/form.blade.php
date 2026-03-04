<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="breadcrumb-sep">/</span>
                <a href="{{ route('admin.coupons.index') }}">Kupon</a>
                <span class="breadcrumb-sep">/</span>
                <span>{{ $coupon->id ? 'Edit' : 'Baru' }}</span>
            </p>
            <h2 class="page-title">{{ $coupon->id ? 'Edit Kupon' : 'Buat Kupon Baru' }}</h2>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div style="max-width:680px;">
                <div class="card">
                    <div class="card-body" style="padding:2rem;">
                        <form action="{{ $coupon->id ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}" method="POST">
                            @csrf
                            @if($coupon->id) @method('PUT') @endif

                            @if($errors->any())
                            <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:10px;padding:12px 16px;margin-bottom:1.5rem;">
                                <ul style="margin:0;padding:0 0 0 1.2rem;font-size:.85rem;color:var(--danger);">
                                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                                </ul>
                            </div>
                            @endif

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                                <div class="form-group" style="grid-column:1/-1;">
                                    <label class="form-label">Kode Kupon <span style="color:var(--danger)">*</span></label>
                                    <input type="text" name="code" class="form-control"
                                           value="{{ old('code', $coupon->code) }}"
                                           placeholder="CONTOH20"
                                           style="text-transform:uppercase;font-weight:700;letter-spacing:.1em;"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Tipe Diskon <span style="color:var(--danger)">*</span></label>
                                    <select name="type" class="form-control" id="couponType">
                                        <option value="percent" {{ old('type',$coupon->type) === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                                        <option value="fixed"   {{ old('type',$coupon->type) === 'fixed'   ? 'selected' : '' }}>Nominal (Rp)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nilai Diskon <span style="color:var(--danger)">*</span></label>
                                    <div style="display:flex;gap:0;">
                                        <span id="typeLabel" style="display:flex;align-items:center;padding:0 12px;background:var(--surface-alt);border:1px solid var(--border);border-right:none;border-radius:8px 0 0 8px;font-size:.85rem;color:var(--text-muted);font-weight:600;">%</span>
                                        <input type="number" name="value" class="form-control"
                                               value="{{ old('value', $coupon->value) }}"
                                               min="1" step="any" required
                                               style="border-radius:0 8px 8px 0;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Minimum Order (Rp)</label>
                                    <input type="number" name="min_order" class="form-control"
                                           value="{{ old('min_order', $coupon->min_order ?? 0) }}"
                                           min="0" step="1000">
                                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:4px;">0 = tidak ada minimum</p>
                                </div>

                                <div class="form-group" id="maxDiscountGroup">
                                    <label class="form-label">Maksimal Diskon (Rp)</label>
                                    <input type="number" name="max_discount" class="form-control"
                                           value="{{ old('max_discount', $coupon->max_discount) }}"
                                           min="0" step="1000" placeholder="Kosong = tidak ada batas">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Batas Penggunaan Total</label>
                                    <input type="number" name="usage_limit" class="form-control"
                                           value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                           min="1" placeholder="Kosong = unlimited">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Batas Per User</label>
                                    <input type="number" name="per_user_limit" class="form-control"
                                           value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}"
                                           min="1">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Berlaku Mulai</label>
                                    <input type="datetime-local" name="starts_at" class="form-control"
                                           value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Berlaku Sampai</label>
                                    <input type="datetime-local" name="expires_at" class="form-control"
                                           value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}">
                                </div>

                                <div class="form-group" style="grid-column:1/-1;">
                                    <label class="form-label">Deskripsi</label>
                                    <input type="text" name="description" class="form-control"
                                           value="{{ old('description', $coupon->description) }}"
                                           placeholder="Contoh: Diskon spesial Ramadan 20%">
                                </div>

                                <div class="form-group" style="grid-column:1/-1;">
                                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" id="isActive"
                                               {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}
                                               style="width:16px;height:16px;accent-color:var(--accent);">
                                        <span class="form-label" style="margin:0;">Kupon Aktif</span>
                                    </label>
                                </div>

                            </div>

                            <div style="display:flex;gap:12px;margin-top:1.5rem;">
                                <a href="{{ route('admin.coupons.index') }}" class="btn btn-ghost" style="flex:1;justify-content:center;">Batal</a>
                                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $coupon->id ? 'Simpan Perubahan' : 'Buat Kupon' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
