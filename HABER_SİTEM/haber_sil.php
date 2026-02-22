<?php

include('baglanti.php');

echo "<pre>";
print_r($_GET); // kontrol
echo "</pre>";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    echo "ID geldi: $id<br>";

    //GÖRSEL SİLMEK
    $haber = $conn->query("SELECT gorsel FROM haberler WHERE id = $id")->fetch_assoc();
    if ($haber && file_exists($haber['gorsel'])) {
        unlink($haber['gorsel']);
    }

    //HABER SİLMEK
    $stmt = $conn->prepare("DELETE FROM haberler WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Silindi, yönlendiriliyor...";
        header("Location: haber_listele.php");
        exit;
    } else {
        echo "Silme hatası: " . $stmt->error;
    }
} else {
    echo "Geçersiz istek.";
}
