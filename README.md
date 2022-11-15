
## Elibrary V.1

Elibrary adalah aplikasi peminjaman buku dengan klasifikasi k-means

- Dikembangkan dengan Laravel 9
- Database MySQL
- Template admin Rocker
- 3 role : Admin, Petugas, dan Peminjam


## Panduan Installasi
- lakukan git clone.
- Buat database kosong dengan nama elibrary
- copas file .env-example kemudian rename menjadi .env
- setting pengaturan database di file .env
- ketikkan di terminal : composer install
- ketikkan di terminal : npm run install && run dev
- ketikkan di terminal : php artisan key:generate
- ketikkan di terminal : php artisan migrate:fresh --seed
- jalankan dengan perintah: php artisan serve

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
