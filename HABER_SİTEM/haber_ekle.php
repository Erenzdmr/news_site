<?php include('baglanti.php'); ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Haber Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }

        
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">📰 Haber Ekle</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="baslik" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="baslik" name="baslik" required>
                </div>

                <div class="mb-3">
                    <label for="gorsel" class="form-label">Görsel Yükle</label>
                    <input type="file" class="form-control" id="gorsel" name="gorsel">
                </div>

                <div class="mb-3">
                    <label for="kaynak_link" class="form-label">Kaynak Link</label>
                    <input type="text" class="form-control" id="kaynak_link" name="kaynak_link" required>
                </div>

                <!-- Spot alanı -->
                <div class="mb-3">
                    <label for="spot" class="form-label">Spot</label>
                    <textarea class="form-control" name="spot" id="spot" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="aciklama" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="aciklama" name="aciklama" rows="5" required></textarea>
                </div>

                <!-- Etiket alanı -->
                <div class="mb-3">
                    <label for="etiket" class="form-label">Etiketler (virgülle ayır)</label>
                    <input type="text" class="form-control" name="etiket" id="etiket"
                        placeholder="etiket1, etiket2, etiket3">
                </div>


                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori Seç</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <?php
                        $kategoriler = $conn->query("SELECT * FROM kategoriler");
                        while ($kat = $kategoriler->fetch_assoc()):
                            ?>
                            <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['ad']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">✅ Haberi Kaydet</button>
            </form>


            <?php
            // Form gönderildiyse
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $baslik = $_POST["baslik"];
                $aciklama = $_POST["aciklama"];
                $kaynak = $_POST["kaynak_link"];
                $kategori = $_POST["kategori"];
                $gorselYolu = "";

                $spot = $_POST["spot"];
                $etiket = $_POST["etiket"];


                // GÖRSEL YÜKLEME İŞLEMİ
                if (isset($_FILES["gorsel"]) && $_FILES["gorsel"]["error"] == 0) {
                    $hedef_klasor = "img/"; // img klasörü HTML kök dizinde olmalı
                    if (!file_exists($hedef_klasor)) {
                        mkdir($hedef_klasor, 0777, true); // klasör yoksa oluştur
                    }
                    $dosya_adi = time() . "_" . basename($_FILES["gorsel"]["name"]);
                    $hedef_yol = $hedef_klasor . $dosya_adi;

                    if (move_uploaded_file($_FILES["gorsel"]["tmp_name"], $hedef_yol)) {
                        $gorselYolu = $hedef_yol;
                    } else {
                        echo "<div class='alert alert-danger mt-3'>❌ Görsel yüklenemedi.</div>";
                    }
                }

                // VERİTABANINA KAYDET
                $sql = "INSERT INTO haberler (baslik, aciklama, gorsel, kaynak_link, spot, etiket, kategori_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssi", $baslik, $aciklama, $gorselYolu, $kaynak, $spot, $etiket, $kategori);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success mt-3'>✅ Haber başarıyla eklendi!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>❌ Hata: " . $stmt->error . "</div>";
                }
            }
            ?>

        </div>
    </div>
</body>

</html>