<!DOCTYPE html>
<html>

<head>
    <title>Saglık</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>


<body>
    <!-- NAVBAR -->
    <div class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <h2>Kategoriler</h2>
            <a href="index.php" class="btn btn-dark btn-sm">HABER.COM</a>
            <?php
            // Tüm kategorileri çek ve butonları oluştur
            $kategoriListesi = $conn->query("SELECT * FROM kategoriler");
            while ($kat = $kategoriListesi->fetch_assoc()):
                ?>
                <a href="index.php?kategori_id=<?= $kat['id'] ?>"
                    class="btn btn-outline-primary btn-sm"><?= htmlspecialchars($kat['ad']) ?></a>
            <?php endwhile; ?>
        </nav>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>