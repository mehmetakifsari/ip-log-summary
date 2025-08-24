<?php
// ip_logger.php — ziyaret başlangıcı kaydı + süre ölçümü için JS

declare(strict_types=1);
ini_set('default_charset','UTF-8');
header('Content-Type: text/html; charset=UTF-8');

session_start();

$logFile = __DIR__ . '/ip_log.txt';

// Gerçek IP (Cloudflare arkasında ise CF header'ı öncelikli)
function client_ip(): string {
  $h = $_SERVER;
  if (!empty($h['HTTP_CF_CONNECTING_IP'])) return $h['HTTP_CF_CONNECTING_IP'];
  if (!empty($h['HTTP_X_FORWARDED_FOR']))  return trim(explode(',', $h['HTTP_X_FORWARDED_FOR'])[0]);
  return $h['REMOTE_ADDR'] ?? 'unknown';
}

$ip        = client_ip();
$ua        = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$time      = date('Y-m-d H:i:s');
$sid       = session_id();                      // bu ziyareti eşleştirmek için
$path      = $_SERVER['REQUEST_URI'] ?? '';
$ref       = $_SERVER['HTTP_REFERER'] ?? '';

$startLine = "[START] $time | IP=$ip | SID=$sid | PATH=$path | REF=" . $ref . " | UA=$ua" . PHP_EOL;

// Log dosyasına ekle
if (!file_exists($logFile)) {
  touch($logFile);
  @chmod($logFile, 0666);
}
file_put_contents($logFile, $startLine, FILE_APPEND | LOCK_EX);
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>IP Logger (Süre Ölçer)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style> body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;padding:24px} code{background:#f3f4f6;padding:2px 4px;border-radius:4px} </style>
</head>
<body>
  <h2>Test Sayfası</h2>
  <p>Bu sayfa, ziyaret IP’sini ve sayfada kalma süresini logluyor.</p>
  <p>Log dosyası: <code><?=htmlspecialchars($logFile, ENT_QUOTES, 'UTF-8')?></code></p>

  <script>
  (function(){
    // Ziyaret başlangıcı (ms)
    const start = Date.now();
    // PHP oturum kimliği (bu sayfada üretildi)
    const sid = <?= json_encode($sid) ?>;

    // Bitiriş bildirimi: sayfa kapanırken/sekme arkaya giderken çalışır
    function sendDuration(){
      const durMs = Date.now() - start;
      // 0'dan küçük/çok büyük değerleri normalize et (güvenlik/sağlamlık)
      const safeMs = Math.max(0, Math.min(durMs, 1000*60*60*24));
      const data = new FormData();
      data.append('sid', sid);
      data.append('duration_ms', String(safeMs));
      data.append('path', window.location.pathname);
      // sendBeacon bağlantıyı bloklamadan post eder
      navigator.sendBeacon('ip_log_beacon.php', data);
    }

    // Çoğu modern tarayıcıda visibilitychange + pagehide kombosu güvenilir
    window.addEventListener('pagehide', sendDuration, {capture:true});
    document.addEventListener('visibilitychange', function(){
      if (document.visibilityState === 'hidden') sendDuration();
    });
  })();
  </script>
</body>
</html>
