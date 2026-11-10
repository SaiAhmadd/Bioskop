@extends('layout')
@section('title', 'E-Ticket ' . $b['kode'])
@section('step', 4)
@section('css')
.stub{display:grid;grid-template-columns:1fr 210px;background:var(--paper);color:var(--ink);border-radius:16px;position:relative;max-width:760px;margin:12px auto 28px}
.stub:before,.stub:after{content:"";position:absolute;right:195px;width:30px;height:30px;border-radius:50%;background:var(--ink)}
.stub:before{top:-15px}.stub:after{bottom:-15px}
.kiri{padding:28px}
.kiri h2{font-size:2rem;margin-bottom:14px}
.kiri dl{display:grid;grid-template-columns:auto 1fr;gap:6px 18px;margin:0}
.kiri dt{color:#6b6990}.kiri dd{margin:0;font-weight:600}
.kanan{border-left:2px dashed #b9b6d6;padding:28px 18px;text-align:center;display:flex;flex-direction:column;justify-content:center;gap:12px}
.kode{font:800 1.5rem 'Bricolage Grotesque',sans-serif;letter-spacing:.04em}
.bar{height:56px;background:repeating-linear-gradient(90deg,var(--ink) 0 2px,transparent 2px 5px,var(--ink) 5px 6px,transparent 6px 10px)}
.aksi{display:flex;gap:10px;justify-content:center;flex-wrap:wrap}
@media(max-width:640px){.stub{grid-template-columns:1fr}.stub:before,.stub:after{display:none}.kanan{border-left:0;border-top:2px dashed #b9b6d6}}
@endsection
@section('content')
<h2 style="text-align:center" class="noprint">Pemesanan berhasil</h2>
<p class="muted noprint" style="text-align:center">Tunjukkan e-ticket ini di pintu studio. Simpan atau cetak tiket ini.</p>
<div class="stub">
<div class="kiri">
<h2>{{ $b['judul'] }}</h2>
<dl>
<dt>Pukul</dt><dd>{{ $b['jam'] }}</dd>
<dt>Kursi</dt><dd>{{ implode(', ', $b['kursi']) }}</dd>
<dt>Pemesan</dt><dd>{{ $b['nama'] }}</dd>
<dt>Nomor HP</dt><dd>{{ $b['hp'] }}</dd>
<dt>Total bayar</dt><dd>Rp {{ number_format($b['total'],0,',','.') }}</dd>
</dl>
</div>
<div class="kanan">
<span style="color:#6b6990">Kode booking</span>
<div class="kode">{{ $b['kode'] }}</div>
<div class="bar" aria-hidden="true"></div>
</div>
</div>
<div class="aksi noprint">
<button class="btn" onclick="window.print()">Cetak tiket</button>
<a class="btn ghost" href="{{ route('home') }}">Pesan film lain</a>
</div>
@endsection
