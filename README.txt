CARA PASANG (Laragon)
1. Buka Terminal Laragon, masuk ke folder www:
   cd C:\laragon\www
   composer create-project laravel/laravel bioskop
2. Salin isi folder zip ini (routes, app, resources) ke dalam folder bioskop, timpa file yang sama.
3. Buka file .env di folder bioskop, ubah baris:
   SESSION_DRIVER=file
4. Jalankan:
   cd bioskop
   php artisan serve
5. Buka http://127.0.0.1:8000
