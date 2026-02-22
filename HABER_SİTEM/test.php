<!-- indeks -->
<!-- 🔥 EN ÇOK OKUNANLAR (Sağda - 2 kolon) -->
<div class="col-md-2">
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            🔥 En Çok Okunanlar
        </div>
        <ul class="list-group list-group-flush">
            <?php
            $populerHaberler = $conn->query("SELECT id, baslik FROM haberler ORDER BY okunma_sayisi DESC LIMIT 5");
            while ($pop = $populerHaberler->fetch_assoc()):
                ?>
                <li class="list-group-item">
                    <a href="detay.php?id=<?= $pop['id'] ?>" class="text-decoration-none">
                        <?= htmlspecialchars(mb_strimwidth($pop['baslik'], 0, 60, '...')) ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
</div>
</div>


<!-- detay  -->
//Sayfaya her girildiğinde sayı artar.
if (isset($_GET['id'])) {
$haber_id = intval($_GET['id']);

// Okunma sayısını arttır
$conn->query("UPDATE haberler SET okunma_sayisi = okunma_sayisi + 1 WHERE id = $haber_id");
}