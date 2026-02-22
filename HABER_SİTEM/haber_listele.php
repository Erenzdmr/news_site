<?php include('baglanti.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Haber Listele</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Haber Listesi</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>Kategori</th>
                <th>Spot</th>
                <th>Etiketler</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // KATEGORİYİ DE BİRLİKTE ÇEKİYORUZ
            $query = "SELECT haberler.id, baslik, spot, etiket, tarih, kategoriler.ad AS kategori
          FROM haberler
          JOIN kategoriler ON haberler.kategori_id = kategoriler.id
          ORDER BY tarih DESC";

            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= htmlspecialchars($row["baslik"]) ?></td>
                    <td><?= $row["kategori"] ?></td>
                    <td><?= $row["spot"] ?></td>
                    <td><?= $row["etiket"] ?></td>
                    <td><?= $row["tarih"] ?></td>
                    <td>
                        <a href="/HABER_SİTEM/haber_sil.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Haberi silmek istediğine emin misin?')">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>