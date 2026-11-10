<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BioskopController extends Controller
{
    // Data contoh (tanpa database)
    private function films(): array
    {
        return [
            1 => ['id' => 1, 'judul' => 'Senja di Kota Tua', 'genre' => 'Drama', 'durasi' => 112, 'rating' => '13+', 'harga' => 45000,
                'sinopsis' => 'Seorang arsitek kembali ke kota kelahirannya untuk menyelamatkan gedung tua milik neneknya.',
                'jam' => ['13:00', '16:00', '19:30'], 'warna' => ['#b3274b', '#3a0f26'], 'terisi' => ['A3', 'A4', 'C5', 'D2']],
            2 => ['id' => 2, 'judul' => 'Kopi Terakhir', 'genre' => 'Romantis', 'durasi' => 98, 'rating' => 'SU', 'harga' => 40000,
                'sinopsis' => 'Dua barista saingan harus berbagi satu kedai di hari terakhir sebelum kedai itu ditutup.',
                'jam' => ['12:30', '15:00', '18:00'], 'warna' => ['#e08a1e', '#5a2d0c'], 'terisi' => ['B1', 'B2', 'E6', 'F3']],
            3 => ['id' => 3, 'judul' => 'Gerbang Nusantara', 'genre' => 'Aksi', 'durasi' => 128, 'rating' => '17+', 'harga' => 50000,
                'sinopsis' => 'Tim penjaga perbatasan memburu penyelundup artefak di sepanjang jalur pelabuhan kuno.',
                'jam' => ['14:00', '17:15', '20:30'], 'warna' => ['#1f7a8c', '#0b2e38'], 'terisi' => ['C3', 'C4', 'D5', 'D6', 'F1']],
            4 => ['id' => 4, 'judul' => 'Rumah di Ujung Gang', 'genre' => 'Horor', 'durasi' => 104, 'rating' => '17+', 'harga' => 45000,
                'sinopsis' => 'Keluarga baru pindah ke rumah murah dan mulai mendengar ketukan dari dinding kamar anak mereka.',
                'jam' => ['16:30', '19:00', '21:30'], 'warna' => ['#2f6b3a', '#0c2a14'], 'terisi' => ['A1', 'B4', 'E2', 'E3']],
            5 => ['id' => 5, 'judul' => 'Si Kancil Pulang', 'genre' => 'Animasi', 'durasi' => 90, 'rating' => 'SU', 'harga' => 35000,
                'sinopsis' => 'Kancil muda tersesat di kota besar dan belajar bahwa akal cerdik saja tidak cukup tanpa teman.',
                'jam' => ['10:00', '12:00', '14:30'], 'warna' => ['#7c4dff', '#2a1670'], 'terisi' => ['D1', 'D2', 'F7']],
            6 => ['id' => 6, 'judul' => 'Garis Waktu', 'genre' => 'Fiksi Ilmiah', 'durasi' => 121, 'rating' => '13+', 'harga' => 50000,
                'sinopsis' => 'Seorang teknisi menemukan pesan dari dirinya sendiri yang dikirim dari sepuluh tahun lagi.',
                'jam' => ['13:30', '16:45', '20:00'], 'warna' => ['#3b82f6', '#10264f'], 'terisi' => ['B5', 'B6', 'C1', 'E4']],
        ];
    }

    private function cari($id): array
    {
        return $this->films()[$id] ?? abort(404);
    }

    // Halaman 1: katalog
    public function index()
    {
        $films = $this->films();
        $genres = array_values(array_unique(array_column($films, 'genre')));
        return view('index', compact('films', 'genres'));
    }

    // Halaman 2: rincian film
    public function show($id)
    {
        return view('detail', ['film' => $this->cari($id)]);
    }

    // Halaman 3: pilih kursi + isi data
    public function pesan(Request $request, $id)
    {
        $film = $this->cari($id);
        $jam = $request->query('jam');
        if (!in_array($jam, $film['jam'])) {
            return redirect()->route('film.show', $id)->with('info', 'Pilih jam tayang dulu.');
        }
        return view('booking', ['film' => $film, 'jam' => $jam, 'baris' => range('A', 'F'), 'kolom' => range(1, 8)]);
    }

    public function simpan(Request $request, $id)
    {
        $film = $this->cari($id);

        $data = $request->validate([
            'jam' => ['required', 'in:' . implode(',', $film['jam'])],
            'nama' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email'],
            'hp' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'kursi' => ['required', 'string'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email belum benar, contoh: nama@email.com.',
            'hp.required' => 'Nomor HP wajib diisi.',
            'hp.regex' => 'Nomor HP harus diawali 08 dan berisi 10-13 angka.',
            'kursi.required' => 'Pilih minimal 1 kursi.',
        ]);

        $kursi = array_values(array_filter(explode(',', $data['kursi'])));
        $salah = count($kursi) > 6;
        foreach ($kursi as $k) {
            if (!preg_match('/^[A-F][1-8]$/', $k) || in_array($k, $film['terisi'])) {
                $salah = true;
            }
        }
        if ($salah) {
            return back()->withErrors(['kursi' => 'Kursi tidak valid. Pilih ulang, maksimal 6 kursi.'])->withInput();
        }

        session(['booking' => [
            'kode' => 'LK-' . strtoupper(Str::random(6)),
            'judul' => $film['judul'],
            'jam' => $data['jam'],
            'kursi' => $kursi,
            'nama' => $data['nama'],
            'email' => $data['email'],
            'hp' => $data['hp'],
            'total' => $film['harga'] * count($kursi),
        ]]);

        return redirect()->route('tiket');
    }

    // Halaman 4: ringkasan & e-ticket
    public function tiket()
    {
        $b = session('booking');
        if (!$b) {
            return redirect()->route('home');
        }
        return view('tiket', ['b' => $b]);
    }
}
