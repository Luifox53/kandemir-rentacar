<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kandemir Rent a Car</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css"> <!-- CSS dosyası ayrı istersen -->
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #222;
      padding: 15px 30px;
      color: white;
    }

    .navbar .logo {
      font-size: 24px;
      font-weight: bold;
    }

    .navbar .menu a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }

    /* Slider */
    .slider {
      position: relative;
      width: 100%;
      height: 300px;
      overflow: hidden;
    }

    .slides {
      display: flex;
      width: 300%;
      animation: slide 6s infinite;
    }

    .slides img {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    @keyframes slide {
      0%   { transform: translateX(0); }
      33%  { transform: translateX(-100%); }
      66%  { transform: translateX(-200%); }
      100% { transform: translateX(0); }
    }

    /* Form */
    .reservation-form {
      padding: 30px;
      background-color: #f5f5f5;
    }

    .reservation-form h2 {
      margin-bottom: 15px;
    }

    .reservation-form form {
      display: flex;
      flex-direction: column;
      max-width: 500px;
    }

    .reservation-form label {
      margin-top: 10px;
    }

    .reservation-form select,
    .reservation-form input {
      padding: 10px;
      margin-top: 5px;
    }

    .reservation-form button {
      margin-top: 20px;
      padding: 12px;
      background-color: #25d366;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }

    .reservation-form button:hover {
      background-color: #1ebc59;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">🚗 Kandemir Rent a Car</div>
    <div class="menu">
      <a href="#">İletişim</a>
      <a href="#">S.S.S</a>
      <a href="#">Lokasyonlar</a>
    </div>
  </div>

  <!-- Slider -->
  <div class="slider">
    <div class="slides">
      <img src="img/araba1.jpg" alt="Araba 1">
      <img src="img/araba2.jpg" alt="Araba 2">
      <img src="img/araba3.jpg" alt="Araba 3">
    </div>
  </div>

  <!-- Rezervasyon Formu -->
  <div class="reservation-form">
    <h2>Rezervasyon Yap</h2>
    <form action="cars.php" method="GET">
      <label for="kisiler">Kişi Sayısı</label>
      <select name="kisiler" id="kisiler">
        <?php for($i=1; $i<=10; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
      </select>

      <label for="nereden">Alınacak Yer</label>
      <input type="text" id="nereden" name="nereden" placeholder="İstanbul Havalimanı" required>

      <label for="nereye">Varış Noktası</label>
      <input type="text" id="nereye" name="nereye" placeholder="Ankara Merkez" required>

      <button type="submit">Araba Bul</button>
    </form>
  </div>

</body>
</html>
