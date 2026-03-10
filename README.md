# お問い合わせフォーム

## アプリ概要

ユーザーがお問い合わせ内容を送信できるフォームアプリです。<br>
管理画面ではお問い合わせ内容の検索・削除・エクスポートができます。

<br>

## 環境構築

### Dockerビルド

- git clone git@github.com:RumOff/coachtech-contact-form.git
- docker-compose up -d --build

### Laravel環境構築

- docker-compose exec php bash
- composer install
- cp .env.example .env ,,,環境変数を適宜変更してください
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

<br>

## 開発環境

- お問い合わせ画面: http://localhost/
- ユーザー登録: http://localhost/register
- phpMyAdmin: http://localhost:8080/

<br>

## 使用技術(実行環境)

- PHP 8.5.2
- Laravel 8.83.29
- MySQL Ver 8.0.26
- nginx 1.21.1
