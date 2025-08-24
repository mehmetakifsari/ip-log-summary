# IP Logger Projesi

Bu proje basit bir **IP loglama ve takip sistemi** sağlar.  
Üç ana dosyadan oluşmaktadır:

## 📂 Dosya Özeti

### 1. `ip_logger.php`
- İstemcinin IP adresini, user agent bilgisini ve istek zamanını kaydeder.  
- Kayıtları yapılandırılmış bir formatta (JSON / text) saklar.  
- Ziyaretleri takip etmek ve trafik analizi yapmak için kullanılabilir.  

### 2. `log.php`
- Kaydedilen IP kayıtlarını okunabilir formatta görüntüler.  
- Yakalanan IP’ler ve metadata için filtreleme ve görselleştirme içerir.  
- Yöneticilerin logları kontrol etmesi için temel bir arayüz sunar.  

### 3. `ip_log_beacon.php`
- Hafif bir takip beacon’ı (pixel tracker gibi) olarak çalışır.  
- Web sitelerine veya uygulamalara gömülerek sessizce ziyaretleri kaydedebilir.  
- Arka plan etkinliklerini veya gizli takibi izlemek için kullanılabilir.  

## 🚀 Özellikler

- Hafif ve basit PHP tabanlı sistem (veritabanı gerektirmez).  
- **IP, User Agent, Zaman Damgası** takibi.  
- **Doğrudan erişim** ve **beacon ile loglama** desteği.  
- Logların veritabanına kaydedilmesi için genişletilebilir.  

## ⚙️ Kurulum

1. Depoyu klonlayın:  
   ```bash
   git clone https://github.com/mehmetakifsari/ip-log-summary.git
   cd ip-log-summary
   ```
2. Dosyaları PHP destekli bir sunucuya yükleyin.  
3. Web sunucusunun logların kaydedildiği dizine **yazma izni** olduğundan emin olun.  
4. Logger’a erişim:  
   - Takip: `https://alanadiniz.com/ip_logger.php`  
   - Log Paneli: `https://alanadiniz.com/log.php`  
   - Beacon: `<img src="https://alanadiniz.com/ip_log_beacon.php" style="display:none;">`  

## 🔒 Güvenlik Notları

- `log.php` dosyasını yetkisiz erişime karşı koruyun.  
- Hassas logları mümkünse public root dışında saklayın.  
- Verilerin güvenliği için HTTPS kullanın.  

## 📜 Lisans

Bu proje **MIT Lisansı** ile lisanslanmıştır.  

---

# IP Logger Project

This project provides a simple **IP logging and tracking system** using PHP.  
It includes three main files:

## 📂 Files Overview

### 1. `ip_logger.php`
- Captures and logs the client’s IP address, user agent, and request time.  
- Stores logs in a structured format (JSON / text file).  
- Can be used to track visits and analyze traffic.  

### 2. `log.php`
- Displays logged IP records in a readable format.  
- Includes filtering and visualization of captured IPs and metadata.  
- Provides a basic interface for administrators to check logs.  

### 3. `ip_log_beacon.php`
- Works as a lightweight tracking beacon (similar to a pixel tracker).  
- Can be embedded in websites or applications to silently log visits.  
- Useful for monitoring hidden activity or background tracking.  

## 🚀 Features

- Lightweight and simple PHP-based system (no database required).  
- Tracks **IP, User Agent, Timestamp**.  
- Supports **logging via direct access** and **tracking via beacon**.  
- Can be extended to save logs into a database.  

## ⚙️ Installation

1. Clone the repository:  
   ```bash
   git clone https://github.com/mehmetakifsari/ip-log-summary.git
   cd ip-log-summary
   ```
2. Deploy the files on a PHP-enabled server.  
3. Ensure the web server has **write permissions** to the directory where logs are stored.  
4. Access the logger:  
   - Tracking: `https://yourdomain.com/ip_logger.php`  
   - Logs Panel: `https://yourdomain.com/log.php`  
   - Beacon: `<img src="https://yourdomain.com/ip_log_beacon.php" style="display:none;">`  

## 🔒 Security Notes

- Protect `log.php` with authentication (to prevent unauthorized access).  
- Store sensitive logs outside the public root if possible.  
- Consider using HTTPS to secure transmitted data.  

## 📜 License

This project is licensed under the **MIT License**.
