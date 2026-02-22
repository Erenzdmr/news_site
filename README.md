📰 Haber Sitesi Projesi

Bu proje, PHP ve MySQL kullanılarak geliştirilmiş basit bir haber sitesidir.
Harici RSS kaynaklarından otomatik olarak haber çekerek veritabanına kaydeder ve web arayüzünde listeler.

🚀 Özellikler

RSS kaynağından otomatik haber çekme

Haberleri MySQL veritabanına kaydetme

Web arayüzünde haber listeleme

Kategori bazlı içerik (spor kategorisi)

Otomasyon için n8n entegrasyonu

XAMPP ile lokal geliştirme ortamı

🛠️ Kullanılan Teknolojiler

PHP

HTML / CSS

MySQL

XAMPP

n8n (otomasyon)

RSS Feed

⚙️ Kurulum

Projeyi kendi bilgisayarınızda çalıştırmak için:

XAMPP kurun ve Apache + MySQL servislerini başlatın

Projeyi htdocs klasörüne kopyalayın

phpMyAdmin üzerinden veritabanını oluşturun

Projede bulunan SQL dosyasını içe aktarın

Tarayıcıdan projeyi açın:

http://localhost/proje-klasoru
🔄 RSS Otomasyonu

Projede haberler, n8n otomasyon aracı kullanılarak RSS kaynağından çekilir ve veritabanına eklenir.

Akış mantığı:

RSS → n8n → MySQL → Web Sitesi

📂 Proje Yapısı
/haber-sitesi
│
├── index.php
├── haber.php
├── db.php
├── assets/
├── admin/
└── README.md
🎯 Amaç

Bu proje, PHP ile dinamik web sitesi geliştirme, veritabanı kullanımı ve RSS veri entegrasyonu konularında pratik yapmak amacıyla geliştirilmiştir.

👨‍💻 Geliştirici

Taha Eren Özdemir
Bilgisayar Mühendisliği Öğrencisi
