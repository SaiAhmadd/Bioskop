@extends('layout')
@section('title', $film['judul'] . ' - Layar Kita')
@section('step', 2)
@section('css')
.det{display:grid;grid-template-columns:260px 1fr;gap:32px}
.poster{aspect-ratio:2/3;border-radius:10px;padding:18px;display:flex;align-items:flex-end;font:800 2rem/1 'Bricolage Grotesque',sans-serif}
.det h1{font-size:clamp(2rem,5vw,3rem);margin-bottom:8px}
.meta{display:flex;gap:18px;flex-wrap:wrap;margin:14px 0 22px}
.meta b{display:block;font-size:1.1rem}
.jam{display:flex;gap:10px;flex-wrap:wrap;margin:10px 0 24px}
.jam a{border:1px solid var(--corn);color:var(--corn);padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:700}
.jam a:hover{background:var(--corn);color:#2a2000}
@media(max-width:640px){.det{grid-template-columns:1fr}.poster{max-width:220px}}
@endsection
@section('content')
<div class="det">
<div class="poster" style="background:linear-gradient(160deg,{{ $film['warna'][0] }},{{ $film['warna'][1] }})">{{ $film['judul'] }}</div>
<div>
<h1>{{ $film['judul'] }}</h1>
<p class="muted">{{ $film['genre'] }}</p>
<p style="max-width:55ch">{{ $film['sinopsis'] }}</p>
<div class="meta">
<span class="muted">Durasi<b>{{ $film['durasi'] }} menit</b></span>
<span class="muted">Rating usia<b>{{ $film['rating'] }}</b></span>
<span class="muted">Harga per kursi<b>Rp {{ number_format($film['harga'],0,',','.') }}</b></span>
</div>
<h3>Pilih jam tayang hari ini</h3>
<div class="jam">
@foreach($film['jam'] as $j)
<a href="{{ route('film.pesan', ['id' => $film['id'], 'jam' => $j]) }}">{{ $j }}</a>
@endforeach
</div>
<a class="btn ghost" href="{{ route('home') }}">Kembali ke katalog</a>
</div>
</div>
@endsection
