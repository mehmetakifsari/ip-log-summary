<?php
// log.php — ip_log.txt özetini gösterir + 10 sn'de bir otomatik yeniler, geri sayım gösterir.
// + Log Temizle butonu eklendi.

declare(strict_types=1);
ini_set('default_charset','UTF-8');
header('Content-Type: text/html; charset=UTF-8');
// Tarayıcı/cdn cache'ini azalt
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$REFRESH_SECONDS = 10;
$logFile = __DIR__ . '/ip_log.txt';

/* ---------- LOG TEMİZLE ---------- */
if (isset($_GET['clear']) && $_GET['clear'] === '1') {
  // Dosya yoksa oluşturup yine de boş bırakmayı dene
  if (!file_exists($logFile)) { @touch($logFile); @chmod($logFile, 0666); }
  $ok = @file_put_contents($logFile, '');
  // Temizlik sonucu için query ile ufak bir geri bildirim
  $flag = ($ok === false) ? '0' : '1';
  header('Location: '.$_SERVER['PHP_SELF'].'?cleared='.$flag);
  exit;
}
/* --------------------------------- */

function fmt_hm(int $seconds): string {
  $m = intdiv($seconds, 60);
  $s = $seconds % 60;
  return sprintf('%02d:%02d', $m, $s);
}

if (!file_exists($logFile)) {
  echo "<!doctype html><meta charset='utf-8'><style>body{font-family:system-ui,Arial;padding:24px}</style><h3>Log dosyası bulunamadı.</h3>";
  exit;
}

// IP bazlı istatistik
$stats = [];      // ip => ['count'=>int, 'total_seconds'=>int]
$lastSeen = [];   // ip => 'Y-m-d H:i:s'
$maxSession = []; // ip => max duration (s)

// Logu oku
$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
  // START: IP yakala (IPv4/IPv6 destekli)
  if (preg_match('/\[START\]\s+([0-9:\- ]+)\s+\|\s+IP=([\da-fA-F\:\.]+)/', $line, $m)) {
    $time = $m[1];
    $ip   = $m[2];
    if (!isset($stats[$ip])) {
      $stats[$ip] = ['count'=>0, 'total_seconds'=>0];
      $maxSession[$ip] = 0;
    }
    $stats[$ip]['count']++;
    $lastSeen[$ip] = $time; // en azından bir START gördük
  }

  // END: IP ve DURATION yakala
  if (preg_match('/\[END\]\s+([0-9:\- ]+)\s+\|\s+IP=([\da-fA-F\:\.]+).*DURATION=(\d+)s/', $line, $m)) {
    $time = $m[1];
    $ip   = $m[2];
    $secs = (int)$m[3];
    if (!isset($stats[$ip])) {
      $stats[$ip] = ['count'=>0, 'total_seconds'=>0];
      $maxSession[$ip] = 0;
    }
    $stats[$ip]['total_seconds'] += $secs;
    if ($secs > ($maxSession[$ip] ?? 0)) $maxSession[$ip] = $secs;
    $lastSeen[$ip] = $time; // END zamanı daha güncel olabilir
  }
}

// Gösterim: IP'leri son görülme zamanına göre (yeni → eski) sırala
uksort($stats, function($a,$b) use($lastSeen){
  return strtotime($lastSeen[$b] ?? '1970-01-01 00:00:00') <=> strtotime($lastSeen[$a] ?? '1970-01-01 00:00:00');
});

// Basit toplam sayılar
$totalHits = array_sum(array_column($stats, 'count'));
$totalTime = array_sum(array_column($stats, 'total_seconds'));
$lastMod   = @filemtime($logFile) ?: time();

// Temizlik sonrası mini bildirim
$clearedMsg = '';
if (isset($_GET['cleared'])) {
  $clearedMsg = ($_GET['cleared'] === '1')
    ? 'Log dosyası temizlendi.'
    : 'Log dosyası temizlenemedi (izin?).';
}
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>IP Log Özeti</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  :root { --fg:#111827; --muted:#6b7280; --bg:#ffffff; --line:#e5e7eb; --pill:#f3f4f6; }
  body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:var(--bg);color:var(--fg);padding:24px;max-width:1000px;margin:0 auto}
  h2{margin:0 0 8px}
  .meta{color:var(--muted);margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;align-items:center}
  table{border-collapse:collapse;width:100%;margin-top:8px}
  th,td{border-bottom:1px solid var(--line);padding:10px;text-align:center}
  th{background:#f9fafb;font-weight:600}
  tr:hover td{background:#fafafa}
  .pill{background:var(--pill);border-radius:999px;padding:4px 10px;font-size:12px;display:inline-block}
  .topbar{position:fixed;right:16px;top:16px;background:#111827;color:#fff;padding:10px 14px;border-radius:999px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.15)}
  .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin:8px 0 16px}
  .card{background:#f9fafb;border:1px solid var(--line);border-radius:12px;padding:10px;text-align:center}
  .mono{font-family:ui-monospace,Menlo,Consolas,monospace}
  .btn{display:inline-block;padding:8px 12px;border:1px solid var(--line);border-radius:8px;text-decoration:none;color:var(--fg);background:#fff}
  .btn.danger{border-color:#fecaca;background:#fee2e2}
  .flash{padding:6px 10px;border-radius:8px;background:#dcfce7;color:#065f46}
  .flash.err{background:#fee2e2;color:#991b1b}
</style>
<script>
  // Geri sayım ve otomatik yenile
  const REFRESH_SECONDS = <?= (int)$REFRESH_SECONDS ?>;
  let left = REFRESH_SECONDS;
  function tick(){
    const el = document.getElementById('countdown');
    if (el) el.textContent = left;
    if (left <= 0) { location.reload(); return; }
    left -= 1;
  }
  document.addEventListener('DOMContentLoaded', () => {
    tick();
    setInterval(tick, 1000);
  });
</script>
</head>
<body>
  <div class="topbar">Sayfa <span id="countdown" class="mono">—</span> sn sonra yenilenecek</div>

  <h2>IP Log Özeti</h2>
  <div class="meta">
    <span>Log dosyası: <span class="mono pill"><?=htmlspecialchars($logFile, ENT_QUOTES, 'UTF-8')?></span></span>
    <span>• Son güncelleme: <span class="mono"><?= date('Y-m-d H:i:s', $lastMod) ?></span></span>
    <a class="btn" href="" title="Yenile">Yenile</a>
    <a class="btn danger" href="?clear=1" onclick="return confirm('Log dosyası temizlensin mi?')">Log Temizle</a>
    <?php if ($clearedMsg !== ''): ?>
      <span class="flash <?=($_GET['cleared']==='1'?'':'err')?>"><?= htmlspecialchars($clearedMsg, ENT_QUOTES, 'UTF-8') ?></span>
    <?php endif; ?>
  </div>

  <div class="grid">
    <div class="card"><div>Toplam IP</div><div class="mono" style="font-size:20px"><?= count($stats) ?></div></div>
    <div class="card"><div>Toplam Giriş</div><div class="mono" style="font-size:20px"><?= (int)$totalHits ?></div></div>
    <div class="card"><div>Toplam Süre</div><div class="mono" style="font-size:20px"><?= fmt_hm($totalTime) ?></div></div>
    <div class="card"><div>Oto Yenile</div><div class="mono" style="font-size:20px"><?= (int)$REFRESH_SECONDS ?> sn</div></div>
  </div>

  <table>
    <tr>
      <th>IP Adresi</th>
      <th>Giriş Sayısı</th>
      <th>Ortalama Süre</th>
      <th>Toplam Süre</th>
      <th>En Uzun Tek Ziyaret</th>
      <th>Son Görülme</th>
    </tr>
    <?php foreach ($stats as $ip => $data):
      $count = (int)$data['count'];
      $totalSeconds = (int)$data['total_seconds'];
      $avgSeconds = $count > 0 ? (int)round($totalSeconds / $count) : 0;
      $maxOne = (int)($maxSession[$ip] ?? 0);
      $last = htmlspecialchars($lastSeen[$ip] ?? '-', ENT_QUOTES, 'UTF-8');
    ?>
    <tr>
      <td class="mono"><?= htmlspecialchars($ip, ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= $count ?></td>
      <td><?= fmt_hm($avgSeconds) ?></td>
      <td><?= fmt_hm($totalSeconds) ?></td>
      <td><?= fmt_hm($maxOne) ?></td>
      <td class="mono"><?= $last ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
