
# Currículo CIC

Este projeto busca desenvolver um site interativo, simples e visualmente atraente a fim de apresentar o novo currículo do curso de Ciência da Computação da UFRGS e facilitar o compreendimento dos componentes de sua grade curricular.


## Deploy

Para fazer o deploy desse projeto rode:


- criar o .env
```bash
  cp .env.example .env
```

- instalar o composer no projeto
```bash
  composer install
```
- gerar a chave
```bash
  php artisan key:generate
```
- conectar os storages
```bash
  php artisan storage:link
```
- criar as tabelas e popular a base de dados com o seeder
```bash
  php artisan migrate:fresh --seed
```
- instalar a biblioteca utiizada
```bash
  npm install --save @panzoom/panzoom
```
- iniciar o servidor de desenvolvimento
```bash
  npm run dev
```
## 🛠️ Tecnologias Utilizadas

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>