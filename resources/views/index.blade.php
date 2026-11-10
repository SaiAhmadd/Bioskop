@extends('layout')
@section('title', 'Sedang Tayang - Layar Kita')
@section('step', 1)
@section('css')
.hero h1{font-size:clamp(2.2rem,7vw,4rem);font-weight:800;max-width:11ch}
.tools{display:flex;gap:10px;flex-wrap:wrap;margin:24px 0}
.tools input{max-width:260px}
.chip{background:none;color:var(--paper);border:1px solid var(--line);border-radius:99px;padding:6px 14px;cursor:pointer;font:inherit}
.chip.on{background:var(--paper);color:var(--ink)}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:20px}
.film{text-decoration:none;display:block}
.poster{aspect-ratio:2/3;border-radius:10px;padding:16px;display:flex;align-items:flex-end;font:800 1.7rem/1 'Bricolage Grotesque',sans-serif}
.film:hover .poster{outline:3px solid var(--corn)}
.film h3{font-size:1.05rem;margin:10px 0 2px}
.kosong{display:none;padding:40px 0}
@endsection
@section('content')
<section class="hero">
<h1>Malam ini nonton apa?</h1>
<p class="muted">Pilih film, pilih kursi, tiket langsung jadi.</p>
</section>
<div class="tools">
<input type="text" id="cari" placeholder="Cari judul film" aria-label="Cari judul film">
<button class="chip on" data-g="">Semua</button>
@foreach($genres as $g)<button class="chip" data-g="{{ $g }}">{{ $g }}</button>@endforeach
</div>
<div class="grid" id="grid">
@foreach($films as $f)
<a class="film" href="{{ route('film.show', $f['id']) }}" data-judul="{{ strtolower($f['judul']) }}" data-genre="{{ $f['genre'] }}">
<div class="poster" style="background:linear-gradient(160deg,{{ $f['warna'][0] }},{{ $f['warna'][1] }})">{{ $f['judul'] }}</div>
<h3>{{ $f['judul'] }}</h3>
<span class="muted">{{ $f['genre'] }}, {{ $f['rating'] }}, Rp {{ number_format($f['harga'],0,',','.') }}</span>
</a>
@endforeach
</div>
<p class="kosong muted" id="kosong">Tidak ada film yang cocok. Coba kata kunci atau genre lain.</p>
@endsection
@section('js')
<script>
let genre = '';
const cari = document.getElementById('cari');
function saring(){
  let n = 0;
  document.querySelectorAll('.film').forEach(el => {
    const ok = el.dataset.judul.includes(cari.value.toLowerCase().trim()) && (!genre || el.dataset.genre === genre);
    el.style.display = ok ? '' : 'none';
    if (ok) n++;
  });
  document.getElementById('kosong').style.display = n ? 'none' : 'block';
}
cari.addEventListener('input', saring);
document.querySelectorAll('.chip').forEach(b => b.addEventListener('click', () => {
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('on'));
  b.classList.add('on'); genre = b.dataset.g; saring();
}));
</script>
@endsection
