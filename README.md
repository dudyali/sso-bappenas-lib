# SSO Bappenas

Sebuah *library* PHP untuk memudahkan aplikasi menggunakan fasilitas login SSO Bappenas.

## Instalasi

### Instalasi menggunakan Composer (disarankan)

Metode yang disarankan untuk menginstall *library* ini adalah dengan menggunakan Composer. Composer adalah sebuah *package manager* untuk PHP. Keuntungan metode ini adalah Anda dapat dengan mudah mendapatkan update melalui satu perintah `composer update`. Selain itu, Anda juga dapat mengakses *library* ini dengan mudah apabila Anda menggunakan framework yang juga menggunakan Composer, misalnya Laravel. Anda dapat membaca lebih lanjut tentang Composer [di sini](https://getcomposer.org/).

Untuk meng-*install* *library* ini, ikuti langkah berikut.

1. *Install* Composer. ([Lihat caranya](https://getcomposer.org/doc/00-intro.md))

2. Jalankan perintah berikut di project anda:

        composer require dudyali/sso-bappenas-lib

3. Jalankan perintah berikut untuk mem-publish Service Provider:

        php artisan vendor:publish --provider="Dudyali\SsoBappenasLib\SSOServiceProvider"

4. Jalankan perintah berikut untuk memasukkan required url routes ke file routes anda:

        php artisan add-route-to-web

5. Terakhir, jalankan perintah berikut untuk clear cache pada config anda:

        php artisan config:clear
