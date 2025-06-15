# ⚽ Hakem Maç Atama Sistemi

Bu proje, belirli bir admin tarafından futbol maçlarına hakem atamalarının yapılabildiği, sisteme kayıtlı hakemlerin ise kendilerine atanmış maçları görebildiği, kullanıcı kayıt ve giriş işlemlerinin yönetildiği basit bir web tabanlı uygulamadır. Uygulama PHP (Vanilla), MySQL ve Bootstrap kullanılarak geliştirilmiştir.

## 🔧 Kullanılan Teknolojiler

- PHP (Vanilla)
- MySQL 
- HTML5, CSS
- Bootstrap 5

## 📋 Özellikler

### 👥 Kullanıcı Sistemi
- Kullanıcılar kayıt olabilir, giriş yapabilir.
- Her kullanıcı `users` tablosuna kayıt edilir.
- Hakemler ayrıca `referees` tablosunda tutulur.
- `admin` rolündeki kullanıcılar tüm atama işlemlerini yapabilir.

### 🏟️ Maç Yönetimi
- Admin yeni maç ekleyebilir.
- Tüm kullanıcılar maçları listeleyebilir.
- Admin, maç listesinde güncelleme veya silme işlemi yapabilir.

### ⚖️ Hakem Atamaları
- Admin, sistemde kayıtlı hakemleri maçlara atayabilir.
- Atamalar `assignments` tablosunda tutulur.
- Admin, yapılan atamaları görüntüleyebilir, güncelleyebilir veya silebilir.
- Hakem kullanıcılar, tüm maçları veya sadece kendilerine atanmış maçları görüntüleyebilir.

### 🧑‍⚖️ Rol Sistemi
- `users` tablosunda her kullanıcının bir `role` bilgisi (`admin` veya `referee`) vardır.
- Sadece admin yetkisine sahip kullanıcılar:
  - Maç ekleyebilir.
  - Atama yapabilir.
  - Atama silebilir veya güncelleyebilir.

## 🗂️ Veritabanı Yapısı

### `users`  
| Alan         | Tür          | Açıklama                     |
|--------------|--------------|------------------------------|
| id           | INT (PK)     | Otomatik arttırılan ID       |
| username     | VARCHAR      | Kullanıcı adı                |
| email        | VARCHAR      | Kullanıcı e-posta            |
| password     | VARCHAR      | Hashlenmiş şifre             |
| role         | ENUM         | `admin` veya `referee`       |

### `referees`  
| Alan         | Tür          | Açıklama                     |
|--------------|--------------|------------------------------|
| user_id      | INT (PK/FK)  | `users.id` ile ilişkilidir   |
| name         | VARCHAR      | Hakemin adı-soyadı           |

### `matches`  
| Alan         | Tür          | Açıklama                     |
|--------------|--------------|------------------------------|
| id           | INT (PK)     | Maç ID                       |
| match_name   | VARCHAR      | Maçın adı                    |
| match_date   | DATE         | Maç tarihi                   |
| match_time   | TIME         | Maç saati                    |
| location     | VARCHAR      | Maçın oynanacağı yer         |

### `assignments`  
| Alan         | Tür          | Açıklama                     |
|--------------|--------------|------------------------------|
| id           | INT (PK)     | Atama ID                     |
| match_id     | INT (FK)     | `matches.id` ile ilişkili    |
| referee_id   | INT (FK)     | `users.id` ile ilişkili      |
| assigned_at  | TIMESTAMP    | Atama yapılma zamanı         |

## 📷 Ekran Görüntüleri

- Kayıt ol ekranı  
![kayıt olma](img/kayıt_ol_ekranı.png)

- Admin ekranı  
![admin](img/admin_ekranı.png)  

- Kullanıcı(hakem) ekranı  
![hakem](img/kullanici_ekrani.png)  

- Var olan hakemlerin listesi
![hakem-listesi](img/hakem_listesi.png)  

- Kullanıcının yalnızca atanmış oldugu maçların listesini gördüğü ekran
![kullanici-maclari](img/kullanici_maclari.png)  

- Adminin maç ataması yaptığı ekran  
![mac-atamasi](img/mac_atamalari.png)  

- Tüm maçların listelendiği ekran  
![maclar](img/tum_maclar.png)  


## 🚀 Kurulum

1. **Veritabanını oluşturun**
   - `database.sql` dosyasını içeri aktarın (örneğin phpMyAdmin ile).
   - Tablolar: `users`, `referees`, `matches`, `assignments`

2. **Proje klasörünü sunucunuza yerleştirin**
   - XAMPP, MAMP ya da canlı bir Apache sunucusu kullanabilirsiniz.
   - Klasörü `htdocs/` içine koymayı unutmayın (XAMPP için).

3. **Veritabanı bağlantısını ayarlayın**
   - `db.php` dosyasında gerekli veritabanı kullanıcı adı ve şifre bilgilerini kendi sisteminize göre güncelleyin:
     ```php
     $pdo = new PDO("mysql:host=localhost;dbname=hakem_sistemi;charset=utf8", "root", "");
     ```

4. **Projeyi çalıştırın**
   - Tarayıcıya `http://localhost/hakem_sistemi/login.php` yazarak giriş yapabilirsiniz.

5. **Admin kullanıcı oluşturun**
   - `register.php` üzerinden kayıt olduktan sonra `users` tablosundan ilgili kullanıcının `role` değerini `admin` olarak güncelleyin.

