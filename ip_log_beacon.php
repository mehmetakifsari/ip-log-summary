<?php
// ip_log_beacon.php — sendBeacon ile gelen süreyi kaydeder

declare(strict_types=1);
ini_set('default_charset','UTF-8');
header('Content-Type: text/plain; charset=UTF-8');

$logFile = __DIR__ . '/ip_log.txt';

function client_ip(): string {
  $h = $_SERVER;
  if (!empty($h['HTTP_CF_CONNECTING_IP'])) return $h['HTTP_CF_CONNECTING_IP'];
  if (!empty($h['HTTP_X_FORWARDED_FOR']))  return trim(explode(',', $h['HTTP_X_FORWARDED_FOR'])[0]);
  return $h['REMOTE_ADDR'] ?? 'unknown';
}

$ip   = client_ip();
$ua   = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$time = date('Y-m-d H:i:s');

$sid = isset($_POST['sid']) ? substr(preg_replace('/[^a-zA-Z0-9]/','', (string)$_POST['sid']), 0, 64) : '';
$durMs = isset($_POST['duration_ms']) ? (int)$_POST['duration_ms'] : 0;
$durMs = max(0, min($durMs, 1000*60*60*24)); // 0..24h
$durSec = (int) round($durMs / 1000);
$durMin = round($durSec / 60, 2);
$path   = isset($_POST['path']) ? substr((string)$_POST['path'], 0, 2048) : '';

$line = "[END]   $time | IP=$ip | SID=$sid | PATH=$path | DURATION=${durSec}s (~${durMin}dk) | UA=$ua" . PHP_EOL;

if (!file_exists($logFile)) {
  touch($logFile);
  @chmod($logFile, 0666);
}
file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

// sendBeacon cevapları önemli değildir; kısa OK verelim
echo "OK\n";
