<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The Project

Welcome to the take-home challenge response for the FullStack web
developer position. I'm excited to demonstrate my skills and experience
in action. The challenge is to build a news aggregator website that pulls
articles from various sources and displays them in a clean, easy-to-read format.

These are guidelines for how to set up the project on local

## Requirements
- Solid skills in laravel
- Basics skills about Git, Docker and software development tools

### Clone the source

> $ git clone https//link-to-the-repo  
> $ <font color="lightblue">cd</font> project-name

### Create environment files

> cp .env.example .env
> sail build --no-cache
> 

### Install dependencies

It will install all the dependencies needed to run the project on your machine
> sail composer update


### Start your project
> sail up

### Other commands
To use any php artisan command, from now you should use sail artisan command-name
To run migrations fro example you should do :
>sail artisan migrate


Thanks