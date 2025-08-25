<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSS</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/sss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">
</head>

<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--FAQ-->
<main class="wrap" id="faq-root">
    <h1 class="title">Sık Sorulan Sorular</h1>

    <section class="faq" role="tablist" aria-label="SSS">
      <!-- ÖRNEK MADDELER -->
      <article class="item" aria-expanded="false">
        <button class="question" role="tab" aria-expanded="false" aria-controls="p1" id="q1">
          Havalimanından otelinize transfer kaç dakika sürer?
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 4h2v16h-2zM4 11h16v2H4z"/></svg>
        </button>
        <div class="panel" role="region" id="p1" aria-labelledby="q1" aria-hidden="true">
          <div class="panel-inner">
            Güzergâha bağlı olarak değişir. Antalya Havalimanı → Belek ortalama <strong>35–45 dk</strong> sürer. Trafik yoğunluğu, yol çalışması ve mola gibi etkenler süreyi değiştirebilir.
          </div>
        </div>
      </article>

      <article class="item" aria-expanded="false">
        <button class="question" role="tab" aria-expanded="false" aria-controls="p2" id="q2">
          Ödeme yöntemleriniz nelerdir?
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 4h2v16h-2zM4 11h16v2H4z"/></svg>
        </button>
        <div class="panel" role="region" id="p2" aria-labelledby="q2" aria-hidden="true">
          <div class="panel-inner">
            Nakit, kredi/banka kartı ve online ödeme kabul ediyoruz. Kurumsal müşteriler için fatura kesimi yapılır.
          </div>
        </div>
      </article>

      <article class="item" aria-expanded="false">
        <button class="question" role="tab" aria-expanded="false" aria-controls="p3" id="q3">
          İptal ve iade koşulları nelerdir?
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 4h2v16h-2zM4 11h16v2H4z"/></svg>
        </button>
        <div class="panel" role="region" id="p3" aria-labelledby="q3" aria-hidden="true">
          <div class="panel-inner">
            Transfer saatinden <strong>12 saat önce</strong>ye kadar ücretsiz iptal edebilirsiniz. Daha geç iptallerde tek yön ücretinin %50’si yansıtılır.
          </div>
        </div>
      </article>

      <article class="item" aria-expanded="false">
        <button class="question" role="tab" aria-expanded="false" aria-controls="p4" id="q4">
          Antalya Havalimanı'nda şoförümü nerede bulabilirim?
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 4h2v16h-2zM4 11h16v2H4z"/></svg>
        </button>
        <div class="panel" role="region" id="p4" aria-labelledby="q4" aria-hidden="true" >
          <div class="panel-inner">
           Şoförünüz, Antalya Havalimanı terminal çıkışında, üzerinde adınızın yazılı olduğu bir tabela ile sizi bekleyecektir.
           Detaylı talimatlar rezervasyon onayınızda yer alacaktır.
          </div>
        </div>
      </article>

      <article class="item" aria-expanded="false">
        <button class="question" role="tab" aria-expanded="false" aria-controls="p5" id="q5">
          Uçuşum rötar yaparsa bekler misiniz?
          <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11 4h2v16h-2zM4 11h16v2H4z"/></svg>
        </button>
        <div class="panel" role="region" id="p5" aria-labelledby="q5" aria-hidden="true">
          <div class="panel-inner">
            Uçuş bilgilerinizi takip ediyoruz; rötarlarda ek ücret almadan bekleme sağlanır.
          </div>
        </div>
      </article>
    </section>
  </main>


<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<script src="scripts/SSS.js"></script>
<script src="scripts/script.js"></script>
</body>
</html>