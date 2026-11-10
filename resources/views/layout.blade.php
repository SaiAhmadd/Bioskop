<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Layar Kita')</title>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;800&display=swap" rel="stylesheet">
<style>
:root{--ink:#1c1b3a;--velvet:#b3274b;--corn:#f4c542;--paper:#f6f4fb;--mute:#9f9dc2;--line:#37355f}
*{box-sizing:border-box}
body{margin:0;background:var(--ink);color:var(--paper);font:16px/1.6 system-ui,sans-serif}
h1,h2,h3,.brand{font-family:'Bricolage Grotesque',system-ui,sans-serif;line-height:1.1;margin:0}
a{color:inherit}
.wrap{max-width:1000px;margin:0 auto;padding:0 20px}
header{border-bottom:1px solid var(--line)}
header .wrap{display:flex;justify-content:space-between;align-items:center;gap:16px;min-height:60px;flex-wrap:wrap}
.brand{font-size:1.4rem;font-weight:800;text-decoration:none}
.steps{display:flex;gap:6px;list-style:none;margin:0;padding:0;font-size:.85rem;color:var(--mute)}
.steps li{padding:2px 10px;border-radius:99px;border:1px solid var(--line)}
.steps li.on{background:var(--corn);color:#2a2000;border-color:var(--corn);font-weight:700}
.steps li.done{color:var(--paper)}
main{padding:32px 0 64px}
.btn{display:inline-block;background:var(--corn);color:#2a2000;font-weight:700;border:0;border-radius:8px;padding:12px 22px;text-decoration:none;cursor:pointer;font-size:1rem;font-family:inherit}
.btn:disabled{opacity:.4;cursor:not-allowed}
.btn.ghost{background:none;color:var(--paper);border:1px solid var(--line)}
:focus-visible{outline:3px solid var(--corn);outline-offset:2px}
.muted{color:var(--mute)}
.info{background:var(--line);padding:10px 14px;border-radius:8px;margin-bottom:20px}
label{display:block;font-weight:600;margin:14px 0 4px}
input[type=text],input[type=email],input[type=tel]{width:100%;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:#14132b;color:var(--paper);font-size:1rem}
input.salah{border-color:#ff9bb0}
.err{color:#ff9bb0;font-size:.9rem;margin:4px 0 0}
@media(prefers-reduced-motion:reduce){*{transition:none!important}}
@media print{header,.noprint{display:none}body{background:#fff}}
@yield('css')
</style>
</head>
<body>
@php $aktif = (int) $__env->yieldContent('step', 1); $nama = ['Film','Jadwal','Kursi','Tiket']; @endphp
<header>
<div class="wrap">
<a class="brand" href="{{ route('home') }}">Layar Kita</a>
<ol class="steps" aria-label="Langkah pemesanan">
@foreach($nama as $i => $n)
<li class="{{ $i+1 == $aktif ? 'on' : ($i+1 < $aktif ? 'done' : '') }}">{{ $n }}</li>
@endforeach
</ol>
</div>
</header>
<main class="wrap">
@if(session('info'))<div class="info">{{ session('info') }}</div>@endif
@yield('content')
</main>
@yield('js')
</body>
</html>
