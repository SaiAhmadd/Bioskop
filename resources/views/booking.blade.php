@extends('layout')
@section('title', 'Pilih Kursi - Layar Kita')
@section('step', 3)
@section('css')
.cols{display:grid;grid-template-columns:1.2fr 1fr;gap:36px}
.layar{height:8px;border-radius:99px;background:var(--paper);margin:0 8% 6px;box-shadow:0 8px 24px rgba(246,244,251,.35)}
.layar-l{text-align:center;font-size:.8rem;margin-bottom:22px}
.row{display:flex;gap:8px;justify-content:center;align-items:center;margin-bottom:8px}
.row span{width:20px;color:var(--mute);font-size:.85rem}
.seat{width:36px;height:34px;border-radius:8px 8px 4px 4px;border:1.5px solid var(--mute);background:none;color:var(--paper);cursor:pointer;font-size:.75rem;font-family:inherit}
.seat:hover:not(:disabled){border-color:var(--corn)}
.seat.pilih{background:var(--corn);border-color:var(--corn);color:#2a2000;font-weight:700}
.seat:disabled{background:var(--line);border-color:var(--line);color:var(--mute);cursor:not-allowed}
.legend{display:flex;gap:16px;justify-content:center;margin-top:18px;font-size:.85rem;color:var(--mute)}
.legend i{display:inline-block;width:14px;height:14px;border-radius:4px;margin-right:6px;vertical-align:-2px;border:1.5px solid var(--mute)}
.total{display:flex;justify-content:space-between;margin:22px 0 14px;font-size:1.1rem}
.ringkas{background:#14132b;border-radius:10px;padding:14px 16px;margin-bottom:6px}
@media(max-width:760px){.cols{grid-template-columns:1fr}.seat{width:32px}}
@endsection
@section('content')
<h2>{{ $film['judul'] }}</h2>
<p class="muted">Tayang pukul {{ $jam }}, Rp {{ number_format($film['harga'],0,',','.') }} per kursi, maksimal 6 kursi</p>
<form method="POST" action="{{ route('film.simpan', $film['id']) }}" novalidate>
@csrf
<input type="hidden" name="jam" value="{{ $jam }}">
<input type="hidden" name="kursi" id="kursi" value="{{ old('kursi') }}">
<div class="cols" style="margin-top:24px">
<div>
<div class="layar"></div><div class="layar-l muted">Layar</div>
@foreach($baris as $b)
<div class="row"><span>{{ $b }}</span>
@foreach($kolom as $k)
@php $id = $b.$k; @endphp
<button type="button" class="seat" data-k="{{ $id }}" aria-label="Kursi {{ $id }}" {{ in_array($id, $film['terisi']) ? 'disabled' : '' }}>{{ $k }}</button>
@endforeach
</div>
@endforeach
<div class="legend"><span><i></i>Kosong</span><span><i style="background:var(--corn);border-color:var(--corn)"></i>Dipilih</span><span><i style="background:var(--line);border-color:var(--line)"></i>Terisi</span></div>
@error('kursi')<p class="err" style="text-align:center">{{ $message }}</p>@enderror
</div>
<div>
<div class="ringkas"><span class="muted">Kursi:</span> <b id="daftar">belum dipilih</b></div>
<div class="total"><span>Total</span><b id="total">Rp 0</b></div>
@foreach([['nama','Nama lengkap','text'],['email','Email','email'],['hp','Nomor HP','tel']] as [$n,$l,$t])
<label for="{{ $n }}">{{ $l }}</label>
<input type="{{ $t }}" id="{{ $n }}" name="{{ $n }}" value="{{ old($n) }}" class="{{ $errors->has($n) ? 'salah' : '' }}">
@error($n)<p class="err">{{ $message }}</p>@enderror
@endforeach
<div style="margin-top:22px;display:flex;gap:10px">
<button class="btn" id="kirim" type="submit">Pesan tiket</button>
<a class="btn ghost" href="{{ route('film.show', $film['id']) }}">Ganti jam</a>
</div>
</div>
</div>
</form>
@endsection
@section('js')
<script>
const harga = {{ $film['harga'] }}, maks = 6;
const input = document.getElementById('kursi');
const dipilih = new Set(input.value.split(',').filter(Boolean));
function tampil(){
  document.querySelectorAll('.seat').forEach(s => s.classList.toggle('pilih', dipilih.has(s.dataset.k)));
  input.value = [...dipilih].join(',');
  document.getElementById('daftar').textContent = dipilih.size ? [...dipilih].join(', ') : 'belum dipilih';
  document.getElementById('total').textContent = 'Rp ' + (harga * dipilih.size).toLocaleString('id-ID');
  document.getElementById('kirim').disabled = dipilih.size === 0;
}
document.querySelectorAll('.seat').forEach(s => s.addEventListener('click', () => {
  const k = s.dataset.k;
  if (dipilih.has(k)) dipilih.delete(k);
  else if (dipilih.size < maks) dipilih.add(k);
  else alert('Maksimal ' + maks + ' kursi per pemesanan.');
  tampil();
}));
tampil();
</script>
@endsection
