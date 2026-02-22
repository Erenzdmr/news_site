<?php

//ANASAYFA BÖLÜMÜ 

include('baglanti.php');

//Slider da sadece bir tane reklam olur
$sliderResult = $conn->query("SELECT * FROM haberler ORDER BY tarih DESC LIMIT 3");

?>




<!DOCTYPE html>
<html>

<head>
    <title>Anasayfa</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"   />
    <link rel="stylesheet" href="style.css">

    <!-- Yazı Tipleri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libertinus+Mono&family=Playwrite+AU+QLD:wght@100..400&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lavishly+Yours&display=swap" rel="stylesheet">



</head>

<body>

    <!-- NAVBAR -->
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg rounded px-3">
                    <a class="navbar-brand fw-bold" href="index.php">📰 HABER.COM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </nav>
            </div>

            <!-- <h2>Kategoriler</h2> -->
            <!-- <a href="index.php" class="btn btn-dark btn-sm"></a> -->
            <?php
            // Tüm kategorileri çek ve butonları oluştur
            $kategoriListesi = $conn->query("SELECT * FROM kategoriler");
            while ($kat = $kategoriListesi->fetch_assoc()):
                ?>

                <a href="index.php?kategori_id=<?= $kat['id'] ?>" class="btn btn-outline btn-sm kategori-link">
                    <?= htmlspecialchars($kat['ad']) ?>
                </a>
            <?php endwhile; ?>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ≡
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="kategoriDropdown">
                            <?php
                            $kategoriListesi = $conn->query("SELECT * FROM kategoriler");
                            while ($kat = $kategoriListesi->fetch_assoc()):
                                ?>
                                <li>
                                    <a class="dropdown-item" href="index.php?kategori_id=<?= $kat['id'] ?>">
                                        <?= htmlspecialchars($kat['ad']) ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                </ul>
                <div class="form-check form-switch ms-auto me-3">
                    <input class="form-check-input" type="checkbox" id="geceModuToggle">
                    <label class="form-check-label" for="geceModuToggle" id="geceModuLabel">White</label>
                </div>

            </div>
        </nav>
    </div>






    <!-- SLİDER KISMI -->
    <div class="container-fluid">
        <div id="haberSlider" class="carousel slide mt-3" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $first = true;
                while ($row = $sliderResult->fetch_assoc()):
                    $firstClass = $first ? 'active' : '';
                    $first = false;
                    ?>
                    <div class="carousel-item <?= $firstClass ?>">
                        <!-- ✅ Resim ve metni link içine al -->
                        <a href="detay.php?id=<?= $row['id'] ?>" class="text-decoration-none text-white">
                            <img src="<?= $row['gorsel'] ?>" class="d-block w-100"
                                style="max-height: 500px; object-fit: cover;" alt="<?= htmlspecialchars($row['baslik']) ?>">

                            <div class="carousel-caption bg-dark bg-opacity-50 p-2 rounded">
                                <p class="fw-bold mb-0">
                                    <?= htmlspecialchars(mb_strimwidth($row['aciklama'], 0, 100, '...')) ?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#haberSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#haberSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>






    <div class="container mt-5">
        <div class="row">
            <?php
            // Filtreleme varsa: kategori_id GET ile alınır
            if (isset($_GET['kategori_id'])) {
                $kategori_id = intval($_GET['kategori_id']);

                // Seçilen kategori adını çek
                $kategoriSorgu = $conn->prepare("SELECT ad FROM kategoriler WHERE id = ?");
                $stmt = $conn->prepare("
                SELECT haberler.*, kategoriler.ad AS kategori_adi
                FROM haberler
                JOIN kategoriler ON haberler.kategori_id = kategoriler.id
                WHERE kategori_id = ?
                ORDER BY tarih DESC
            ");
                $stmt->bind_param("i", $kategori_id);
                $stmt->execute();
                $cardsResult = $stmt->get_result();
            } else {
                $cardsResult = $conn->query("
                SELECT haberler.*, kategoriler.ad AS kategori_adi
                FROM haberler
                LEFT JOIN kategoriler ON haberler.kategori_id = kategoriler.id
                ORDER BY tarih DESC
            ");
                // left join ile sadece id'si olanları değil bütün haberleri getiriyor   
            }


            // GİRİLEN HABERLERİ KART HALİNDE GÖSTERİR
            while ($row = $cardsResult->fetch_assoc()):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $row['gorsel'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['baslik']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(mb_strimwidth($row['aciklama'], 0, 100, "...")) ?>
                            </p>
                            <p class="text-muted"><small><strong>≡</strong>
                                    <?= htmlspecialchars($row['kategori_adi']) ?></small></p>
                            <a href="detay.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Devamını Oku</a>
                        </div>
                    </div>
                </div>


            <?php endwhile; ?>
        </div>
    </div>

    <!-- FOOTER BOLUMU  -->
    <footer class="bg-light text-center text-muted py-3 mt-4">
        &copy; <?php echo date('Y'); ?> HABER.COM | Tüm hakları saklıdır.
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>







<script>
  const toggle = document.getElementById("geceModuToggle");
  const body = document.body;
  const label = document.getElementById("geceModuLabel");

  // Sayfa yüklenince önceki tercih kontrolü
  if (localStorage.getItem("geceModu") === "acik") {
    body.classList.add("dark-mode");
    toggle.checked = true;
    label.textContent = "Dark";
  }

  toggle.addEventListener("change", () => {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
      localStorage.setItem("geceModu", "acik");
      label.textContent = "Dark";
    } else {
      localStorage.setItem("geceModu", "kapali");
      label.textContent = "White";
    }
  });
</script>



