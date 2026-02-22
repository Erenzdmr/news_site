<?php
include('baglanti.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT haberler.*, kategoriler.ad AS kategori_adi FROM haberler
                            LEFT JOIN kategoriler ON haberler.kategori_id = kategoriler.id
                            WHERE haberler.id = ?"); //left join kullanarak tüm haberleri getirir.
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $sonuc = $stmt->get_result();
    

    if ($sonuc->num_rows > 0) {
        $haber = $sonuc->fetch_assoc();
    } else {
        echo "Haber bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz istek.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($haber['baslik']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>



<body class="container mt-5">


    <h1><?= htmlspecialchars($haber['baslik']) ?></h1>
    <p><strong>Kategori:</strong> <?= htmlspecialchars($haber['kategori_adi']) ?></p>
    <p><strong>Tarih:</strong> <?= htmlspecialchars($haber['tarih']) ?></p>
    <p><strong>Spot:</strong> <?= htmlspecialchars($haber['spot']) ?></p>
    <p><strong>Etiketler:</strong> <?= htmlspecialchars($haber['etiket']) ?></p>



    <?php if (!empty($haber['gorsel'])): ?>
        <img src="<?= $haber['gorsel'] ?>" class="img-fluid mb-3" style="max-height:400px; object-fit:cover;">
    <?php endif; ?>

    <p><?= nl2br(htmlspecialchars($haber['aciklama'])) ?></p>

    <a href="index.php" class="btn btn-secondary mt-3">⬅ Geri Dön</a>

    <footer class="text-center text-muted py-3 mt-5">
        &copy; <?= date('Y') ?> HABER.COM | Tüm hakları saklıdır.
    </footer>

</body>

</html>