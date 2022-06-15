# NEAR Fungible Token ICO Exchange II (Vue.js Frontend + PHP Laravel Gateway)

![Fungible Token ICo Exchange](https://github.com/AGNICO/near-ncd-I-ft-ico-rs/blob/master/docs/ncd-1.png)

<p align="center">
  <img src="https://github.com/AGNICO/near-ncd-II-ico-exchange-vue-php/blob/master/docs/fe-2.png" width="40%" />
  <img src="https://github.com/AGNICO/near-ncd-II-ico-exchange-vue-php/blob/master/docs/fe-1.png" width="40%" />
</p>

<!-- <p align="center">
Video demo: https://youtu.be/I4O6GRAgrXk
</p> -->

## ⚠️ Warning

Any content produced by NEAR, or developer resources that NEAR provides, are for educational and inspiration purposes only. NEAR does not encourage, induce or sanction the deployment of any such applications in violation of applicable laws or regulations.

## Vue.js Frontend installation + usage

It's standard fresh Vue 3 framework installation...[Vue v.3 docs](https://v3.vuejs.org/guide/installation.html)

Create and update `.env.local` file with your local values:

    VUE_APP_ICO_CONTRACT=<FT ICO dev contract account dev-XXXX-XXXX>
    VUE_APP_EXCHANGE_CONTRACT=<EXCHANGE dev contract account dev-XXXX-XXXX>
    VUE_APP_GATEWAY_API_URL=<local url of the PHP API gateway>
    VUE_APP_COINGECKO_API_URL="https://api.coingecko.com/api/v3/simple/price?ids=near&vs_currencies=usd"

Please check `package.json` file, to see installed packages. The most important ones are: `near-api-js`, `axios`, `vue-router` and `tailwindcss`.

## PHP Laravel Gateway installation + usage

It's standard fresh Laravel 8 framework installation...[See official docs](https://laravel.com/docs/8.x)

Update `.env` to allow requests from localhost (see `.env.example` file). The IP middleware is located in `PHP-LARAVEL-GATEWAY\app\Http\Middleware\ClientIPsMiddleware.php` and registered for `API` routes in `PHP-LARAVEL-GATEWAY\app\Http\Kernel.php`:

    CLIENT_IPS=127.0.0.1

The main Near service class is using `NEAR` facade and is located in `PHP-LARAVEL-GATEWAY\app\Services\Near.php`. The service provider is located in `PHP-LARAVEL-GATEWAY\app\Providers\NearServiceProvider.php`.

You can see a brief walk through the code in the attached video.

---

## Credits and links

#### [Part 1: NEAR Fungible Token ICO Exchange I (Rust)](https://github.com/AGNICO/near-ncd-I-ft-ico-rs)

#### [NEAR Protocol](https://near.org)

#### [NEAR University](https://near.university)

#### [<°}))>{ AGNICO.io | Happy BLOCKCHAIN Apps](https://agnico.io)
