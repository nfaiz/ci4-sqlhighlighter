![GitHub](https://img.shields.io/github/license/nfaiz/ci4-sqlhighlighter)
![GitHub repo size](https://img.shields.io/github/repo-size/nfaiz/ci4-sqlhighlighter?label=size)
![Hits](https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=nfaiz/ci4-sqlhighlighter)

# CodeIgniter 4 SQL Highlighter

## Description
A Better Look SQL Highlighter for CodeIgniter 4 database debug toolbar using [highlightjs](https://highlightjs.org).

> [!WARNING]
> Warning! This library will modify several CodeIgniter 4 system files. Use at your own risk.

## Table of contents
  * [Installation](#installation)
  * [Setup](#setup)
  * [ScreenShot](#screenshot)

## Installation
Install via composer:

    composer require nfaiz/sqlhighlighter

## Setup

Run following command using command prompt/terminal.

    php spark hl:setup

### Modify SQL Highlighter Assets.
Open `app/Config/Toolbar.php` and find $sqlHighlighterAssets

```php
    public array $sqlHighlighterAssets = [
        'js' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js',
        'css_light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/atom-one-light.min.css',
        'css_dark' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/atom-one-dark.min.css',
    ];
```
## Screenshot

### Before

* Light<br />
<img src="https://user-images.githubusercontent.com/1330109/193412805-a923b570-a4b1-47e6-956c-3f9f97e8c2d8.png" alt="Light mode">

* Dark<br />
<img src="https://user-images.githubusercontent.com/1330109/193412939-b132801a-a639-4d1e-a57e-c2df1d628a6d.png" alt="Dark mode">

### After

* Light
<img src="https://user-images.githubusercontent.com/1330109/193412867-83603790-0c44-402b-b790-4f3d6576c412.png" alt="Light mode">

* Dark
<img src="https://user-images.githubusercontent.com/1330109/193412970-faa3896e-8425-44a5-961e-ca9e553fecd9.png" alt="Dark mode">
