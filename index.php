<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sırt Köyü Web Sitesi - Yapım Aşamasında</title>
    <!-- Tailwind CSS CDN'i -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter fontunu projenize dahil edin -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Inter fontunu varsayılan olarak ayarla */
            /* Arka plan görseli ve efektleri */
            background-image: url('https://rizedeyizcom.teimg.com/crop/1280x720/rizedeyiz-com/uploads/2024/08/a-w277333-05.jpg'); /* Ağaran Şelalesi için placeholder görseli. Buraya kendi görsel URL'nizi eklemelisiniz. */
            background-size: cover; /* Görselin tüm alanı kaplamasını sağlar */
            background-position: center; /* Görseli ortalar */
            background-repeat: no-repeat; /* Görselin tekrar etmesini engeller */
            background-attachment: fixed; /* Arka planın kaydırma ile sabit kalmasını sağlar */
            position: relative; /* Overlay için gerekli */
            min-height: 100vh; /* Sayfanın en az viewport yüksekliği kadar olmasını sağlar */
            display: flex; /* İçeriği ortalamak için flexbox kullanır */
            justify-content: center; /* Yatayda ortalar */
            align-items: center; /* Dikeyde ortalar */
            color: #fff; /* Metin rengi */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Metne gölge ekler */
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Arka plan görselinin okunurluğunu artırmak için koyu overlay */
            z-index: 1; /* İçeriğin arkasında kalmasını sağlar */
        }
        .container {
            position: relative;
            z-index: 2; /* İçeriğin overlay'in üzerinde olmasını sağlar */
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6); /* İçerik kutusu için hafif şeffaf arka plan */
            padding: 2rem;
            border-radius: 0.75rem; /* Yuvarlak köşeler */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Kutuya gölge ekler */
            max-width: 90%; /* Küçük ekranlarda içeriğin taşmasını önler */
        }
        h1 {
            font-size: 2.5rem; /* Başlık boyutu */
            margin-bottom: 1rem; /* Başlık altındaki boşluk */
        }
        p {
            font-size: 1.25rem; /* Paragraf boyutu */
        }
        /* Küçük ekranlar için responsive ayarlar */
        @media (min-width: 768px) {
            h1 {
                font-size: 4rem; /* Tablet ve üzeri ekranlarda başlık boyutu */
            }
            p {
                font-size: 1.5rem; /* Tablet ve üzeri ekranlarda paragraf boyutu */
            }
        }
    </style>
</head>
<body class="selection:bg-fuchsia-300 selection:text-fuchsia-900">
    <div class="container rounded-lg p-8 shadow-xl">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 animate-bounce">
            Sırt Köyü Web Sitesi
        </h1>
        <p class="text-xl md:text-2xl font-semibold opacity-90">
             <br>
            Sitemiz şu anda yapım aşamasındadır. En kısa sürede geri döneceğiz!
        </p>
        <p class="text-lg md:text-xl mt-6 opacity-80">
            Anlayışınız için teşekkür ederiz.
        </p>
    </div>

    <!-- Bu kısım PHP ile sayfa içeriğini dinamik hale getirmek için kullanılabilir,
         şimdilik basit bir HTML yapısı yeterlidir. -->
    <?php
        // Gelecekte buraya veritabanı bağlantısı, dinamik içerik yüklemesi vb. eklenebilir.
        // echo "<p>Geliştirme ekibi sıkı çalışıyor...</p>";
    ?>
</body>
</html>
