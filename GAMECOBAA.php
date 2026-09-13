<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$conn = new mysqli("localhost", "root", "", "game");
$conn->set_charset("utf8mb4");

$conn->query("
    CREATE TABLE IF NOT EXISTS game_tfungsi_level (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Nama VARCHAR(100) NOT NULL,
        Kelas VARCHAR(50) NOT NULL,
        No_Absen VARCHAR(20) NOT NULL,
        Level_Game INT NOT NULL,
        Skor INT NOT NULL DEFAULT 0,
        Waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'save_level'
) {
    header('Content-Type: application/json; charset=utf-8');

    $nama  = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $absen = trim($_POST['absen'] ?? '');
    $level = (int)($_POST['level'] ?? 0);
    $skor  = (int)($_POST['skor'] ?? 0);

    if (
        $nama === '' ||
        $kelas === '' ||
        $absen === '' ||
        $level < 1 ||
        $level > 3
    ) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Data belum lengkap.'
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO game_tfungsi_level
        (Nama, Kelas, No_Absen, Level_Game, Skor)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssii", $nama, $kelas, $absen, $level, $skor);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success']);
    exit;
}

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'leaderboard'
) {
    header('Content-Type: application/json; charset=utf-8');

    $data = [];

    $result = $conn->query("
        SELECT
            Nama,
            Kelas,
            No_Absen,
            MAX(CASE WHEN Level_Game = 1 THEN Skor ELSE 0 END) AS Level1,
            MAX(CASE WHEN Level_Game = 2 THEN Skor ELSE 0 END) AS Level2,
            MAX(CASE WHEN Level_Game = 3 THEN Skor ELSE 0 END) AS Level3,
            (
                MAX(CASE WHEN Level_Game = 1 THEN Skor ELSE 0 END) +
                MAX(CASE WHEN Level_Game = 2 THEN Skor ELSE 0 END) +
                MAX(CASE WHEN Level_Game = 3 THEN Skor ELSE 0 END)
            ) AS Total
        FROM game_tfungsi_level
        GROUP BY Nama, Kelas, No_Absen
        ORDER BY Total DESC, Nama ASC
        LIMIT 50
    ");

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

$questions = [

    1 => [
        ['q' => 'Grafik fungsi g(x) = f(x) + 5 diperoleh dari grafik f(x) melalui translasi vertikal sejauh 5 satuan ke arah ...', 'options' => ['Atas','Bawah','Kanan','Kiri','Tidak bergeser'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>g(x) = f(x) + 5<br><br><b>Ditanya:</b><br>Arah pergeseran grafik.<br><br><b>Rumus:</b><br>g(x) = f(x) + b<br><br><b>Penyelesaian:</b><br>Nilai b = 5 > 0, sehingga grafik bergeser ke atas sejauh 5 satuan.<br><br><b>Kesimpulan:</b><br>Grafik bergeser ke <b>ATAS</b> sejauh 5 satuan.'],
        ['q' => 'Diketahui fungsi kuadrat f(x) = x² ditranslasikan menjadi g(x) = x² − 3. Pernyataan yang tepat mengenai translasi tersebut adalah ...', 'options' => ['Bergeser 3 satuan ke atas','Bergeser 3 satuan ke bawah','Bergeser 3 satuan ke kanan','Bergeser 3 satuan ke kiri','Tidak mengalami translasi'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>f(x) = x² dan g(x) = x² − 3<br><br><b>Ditanya:</b><br>Jenis dan arah translasi.<br><br><b>Rumus:</b><br>g(x) = f(x) + b<br><br><b>Penyelesaian:</b><br>x² − 3 = f(x) + b, sehingga b = −3. Karena b < 0, grafik bergeser ke bawah sejauh 3 satuan.<br><br><b>Kesimpulan:</b><br>Grafik bergeser <b>3 satuan ke BAWAH</b>.'],
        ['q' => 'Grafik g(x) = f(x − 4) merupakan translasi horizontal dari grafik f(x) sejauh 4 satuan ke arah ...', 'options' => ['Atas','Bawah','Kanan','Kiri','Tidak bergeser'], 'answer' => 'C', 'explain' => '<b>Diketahui:</b><br>g(x) = f(x − 4)<br><br><b>Rumus:</b><br>g(x) = f(x − a)<br><br><b>Penyelesaian:</b><br>Diperoleh a = 4. Karena a > 0, grafik bergeser ke kanan sejauh 4 satuan.<br><br><b>Kesimpulan:</b><br>Grafik bergeser ke <b>KANAN</b> sejauh 4 satuan.'],
        ['q' => 'Fungsi g(x) = f(x + 6) adalah hasil translasi horizontal grafik f(x) sejauh 6 satuan ke arah ...', 'options' => ['Atas','Bawah','Kanan','Kiri','Tidak bergeser'], 'answer' => 'D', 'explain' => '<b>Diketahui:</b><br>g(x) = f(x + 6) = f(x − (−6))<br><br><b>Rumus:</b><br>g(x) = f(x − a)<br><br><b>Penyelesaian:</b><br>a = −6. Karena a < 0, grafik bergeser ke kiri sejauh 6 satuan.<br><br><b>Kesimpulan:</b><br>Grafik bergeser ke <b>KIRI</b> sejauh 6 satuan.'],
        ['q' => 'Jika grafik fungsi f(x) direfleksikan terhadap sumbu x, maka bayangannya dinyatakan dengan ...', 'options' => ['g(x) = f(−x)','g(x) = −f(x)','g(x) = f(x) + 1','g(x) = f(x − 1)','g(x) = 2f(x)'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>Transformasi berupa refleksi terhadap sumbu x.<br><br><b>Rumus:</b><br>Refleksi terhadap sumbu x: g(x) = −f(x).<br><br><b>Penyelesaian:</b><br>Nilai y berubah tanda, sedangkan x tetap.<br><br><b>Kesimpulan:</b><br>Bayangannya adalah <b>g(x) = −f(x)</b>.'],
        ['q' => 'Bayangan grafik f(x) hasil refleksi terhadap sumbu y dinyatakan dengan rumus ...', 'options' => ['g(x) = −f(x)','g(x) = f(−x)','g(x) = f(x) − 1','g(x) = f(x + 1)','g(x) = −f(−x)'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>Transformasi berupa refleksi terhadap sumbu y.<br><br><b>Rumus:</b><br>Refleksi terhadap sumbu y: g(x) = f(−x).<br><br><b>Penyelesaian:</b><br>Variabel x diganti dengan −x, sedangkan nilai fungsi tetap.<br><br><b>Kesimpulan:</b><br>Bayangannya adalah <b>g(x) = f(−x)</b>.'],
        ['q' => 'Grafik g(x) = 3f(x) merupakan hasil dilatasi grafik f(x) dengan faktor skala 3 yang sejajar sumbu ...', 'options' => ['x, grafik diperbesar','y, grafik diperbesar','y, grafik diperkecil','x, grafik diperkecil','tidak mengalami dilatasi'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>g(x) = 3f(x), sehingga k = 3.<br><br><b>Rumus:</b><br>Dilatasi vertikal: g(x) = kf(x).<br><br><b>Penyelesaian:</b><br>k = 3 > 1, sehingga grafik diperbesar secara vertikal atau sejajar sumbu y.<br><br><b>Kesimpulan:</b><br>Dilatasi sejajar sumbu <b>y</b>, grafik diperbesar.'],
        ['q' => 'Grafik g(x) = f(x/2) merupakan hasil dilatasi horizontal grafik f(x) dengan faktor skala 2 sejajar sumbu x. Grafik hasil dilatasi tersebut akan tampak ...', 'options' => ['Diperbesar secara horizontal','Diperkecil secara horizontal','Diperbesar secara vertikal','Diperkecil secara vertikal','Tidak berubah'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>g(x) = f(x/k), dengan k = 2.<br><br><b>Rumus:</b><br>Dilatasi horizontal: g(x) = f(x/k).<br><br><b>Penyelesaian:</b><br>Karena k = 2 > 1, grafik diperbesar secara horizontal.<br><br><b>Kesimpulan:</b><br>Grafik <b>diperbesar secara horizontal</b>.'],
        ['q' => 'Rotasi grafik fungsi yang searah jarum jam memiliki sudut rotasi bertanda ...', 'options' => ['Positif','Negatif','Nol','Tidak tentu','Selalu 90°'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>Arah rotasi searah jarum jam.<br><br><b>Rumus:</b><br>Searah jarum jam → sudut negatif.<br>Berlawanan arah jarum jam → sudut positif.<br><br><b>Kesimpulan:</b><br>Sudut rotasi bertanda <b>NEGATIF</b>.'],
        ['q' => 'Perhatikan hubungan g(x) = f(x) − 7. Jenis transformasi yang dialami grafik f(x) adalah ...', 'options' => ['Refleksi terhadap sumbu x','Dilatasi vertikal','Translasi vertikal','Translasi horizontal','Rotasi'], 'answer' => 'C', 'explain' => '<b>Diketahui:</b><br>g(x) = f(x) − 7.<br><br><b>Rumus:</b><br>Translasi vertikal: g(x) = f(x) + b.<br><br><b>Penyelesaian:</b><br>b = −7. Variabel x tidak berubah dan hanya nilai fungsi yang berkurang, sehingga terjadi translasi vertikal.<br><br><b>Kesimpulan:</b><br>Jenis transformasinya adalah <b>TRANSLASI VERTIKAL</b>.']
    ],

    2 => [
        ['q' => 'Diketahui f(x) = 2x + 1. Tentukan fungsi g(x) hasil translasi f(x) sejauh 4 satuan ke atas.', 'options' => ['g(x) = 2x + 5','g(x) = 2x − 3','g(x) = 2x + 4','g(x) = 2(x − 4) + 1','g(x) = 2(x + 4) + 1'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = 2x + 1, translasi ke atas 4 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x) + b.<br><br><b>Penyelesaian:</b><br>g(x) = (2x + 1) + 4 = 2x + 5.<br><br><b>Kesimpulan:</b><br>g(x) = <b>2x + 5</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) ditranslasikan 6 satuan ke bawah. Tentukan fungsi hasil translasi g(x).', 'options' => ['g(x) = x² + 6','g(x) = x² − 6','g(x) = (x − 6)²','g(x) = (x + 6)²','g(x) = 6x²'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>f(x) = x², translasi ke bawah 6 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x) + b, dengan b = −6.<br><br><b>Penyelesaian:</b><br>g(x) = x² − 6.<br><br><b>Kesimpulan:</b><br>g(x) = <b>x² − 6</b>.'],
        ['q' => 'Diketahui f(x) = x² − 2x. Fungsi tersebut ditranslasikan 3 satuan ke kanan. Tentukan g(x).', 'options' => ['g(x) = (x − 3)² − 2(x − 3)','g(x) = (x + 3)² − 2(x + 3)','g(x) = x² − 2x + 3','g(x) = x² − 2x − 3','g(x) = (x − 3)² − 2x'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² − 2x dan translasi ke kanan 3 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x − a), a = 3.<br><br><b>Penyelesaian:</b><br>g(x) = f(x − 3) = (x − 3)² − 2(x − 3).<br><br><b>Kesimpulan:</b><br>g(x) = <b>(x − 3)² − 2(x − 3)</b>.'],
        ['q' => 'Diketahui f(x) = x² + 4x. Fungsi tersebut ditranslasikan 2 satuan ke kiri. Tentukan g(x).', 'options' => ['g(x) = (x + 2)² + 4(x + 2)','g(x) = (x − 2)² + 4(x − 2)','g(x) = x² + 4x + 2','g(x) = x² + 4x − 2','g(x) = (x + 2)² + 4x'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² + 4x, translasi ke kiri 2 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x − a), dengan a = −2.<br><br><b>Penyelesaian:</b><br>g(x) = f(x + 2) = (x + 2)² + 4(x + 2).<br><br><b>Kesimpulan:</b><br>g(x) = <b>(x + 2)² + 4(x + 2)</b>.'],
        ['q' => 'Diketahui f(x) = x² − 4x + 3. Tentukan hasil refleksi f(x) terhadap sumbu x.', 'options' => ['g(x) = x² − 4x + 3','g(x) = −x² + 4x − 3','g(x) = x² + 4x + 3','g(x) = −x² − 4x − 3','g(x) = −x² + 4x + 3'], 'answer' => 'B', 'explain' => '<b>Diketahui:</b><br>f(x) = x² − 4x + 3.<br><br><b>Rumus:</b><br>Refleksi terhadap sumbu x: g(x) = −f(x).<br><br><b>Penyelesaian:</b><br>g(x) = −(x² − 4x + 3) = −x² + 4x − 3.<br><br><b>Kesimpulan:</b><br>g(x) = <b>−x² + 4x − 3</b>.'],
        ['q' => 'Diketahui f(x) = x² − 3x + 2. Tentukan hasil refleksi f(x) terhadap sumbu y.', 'options' => ['g(x) = x² + 3x + 2','g(x) = x² − 3x + 2','g(x) = −x² + 3x − 2','g(x) = −x² − 3x − 2','g(x) = x² − 3x − 2'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² − 3x + 2.<br><br><b>Rumus:</b><br>Refleksi terhadap sumbu y: g(x) = f(−x).<br><br><b>Penyelesaian:</b><br>g(x) = (−x)² − 3(−x) + 2 = x² + 3x + 2.<br><br><b>Kesimpulan:</b><br>g(x) = <b>x² + 3x + 2</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) mengalami dilatasi vertikal dengan faktor skala 3 (sejajar sumbu y). Tentukan g(x).', 'options' => ['g(x) = 3x²','g(x) = x²/3','g(x) = (3x)²','g(x) = x² + 3','g(x) = (x/3)²'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² dan k = 3.<br><br><b>Rumus:</b><br>g(x) = k · f(x).<br><br><b>Penyelesaian:</b><br>g(x) = 3 · x² = 3x².<br><br><b>Kesimpulan:</b><br>g(x) = <b>3x²</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) mengalami dilatasi horizontal dengan faktor skala 1/2 sejajar sumbu x. Tentukan g(x).', 'options' => ['g(x) = 4x²','g(x) = x²/4','g(x) = 2x²','g(x) = x²/2','g(x) = (x/2)²'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² dan k = 1/2.<br><br><b>Rumus:</b><br>g(x) = f(x/k).<br><br><b>Penyelesaian:</b><br>g(x) = f(x/(1/2)) = f(2x) = (2x)² = 4x².<br><br><b>Kesimpulan:</b><br>g(x) = <b>4x²</b>.'],
        ['q' => 'Titik A(2, 3) terletak pada grafik fungsi kuadrat f(x). Titik tersebut dirotasikan sejauh 90° berlawanan arah jarum jam terhadap titik pusat O(0, 0). Tentukan koordinat bayangan titik A.', 'options' => ['(−3, 2)','(3, −2)','(−2, 3)','(2, −3)','(3, 2)'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>A(2, 3), rotasi 90° berlawanan arah jarum jam.<br><br><b>Rumus:</b><br>Rotasi 90° berlawanan arah jarum jam: (x, y) → (−y, x).<br><br><b>Penyelesaian:</b><br>x′ = −3, y′ = 2.<br><br><b>Kesimpulan:</b><br>Bayangan titik A adalah <b>(−3, 2)</b>.'],
        ['q' => 'Diberikan dua fungsi kuadrat f(x) = x² dan g(x) = x² − 4x + 7. Tentukan komponen translasi (a, b) sehingga grafik g merupakan hasil translasi grafik f oleh (a, b).', 'options' => ['(2, 3)','(−2, 3)','(2, −3)','(4, 7)','(−2, −3)'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x², g(x) = x² − 4x + 7.<br><br><b>Rumus:</b><br>g(x) = f(x − a) + b = (x − a)² + b.<br><br><b>Penyelesaian:</b><br>x² − 4x + 7 = (x² − 4x + 4) + 3 = (x − 2)² + 3. Maka a = 2 dan b = 3.<br><br><b>Kesimpulan:</b><br>Komponen translasi adalah <b>(2, 3)</b>.']
    ],

    3 => [
        ['q' => 'Diketahui f(x) = x². Fungsi f(x) mengalami translasi 3 satuan ke kanan, kemudian dilanjutkan translasi 5 satuan ke atas. Tentukan fungsi hasil transformasi g(x).', 'options' => ['g(x) = (x − 3)² + 5','g(x) = (x + 3)² + 5','g(x) = (x − 3)² − 5','g(x) = (x − 5)² + 3','g(x) = (x + 3)² − 5'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x², translasi kanan 3 satuan dan atas 5 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x − a) + b.<br><br><b>Penyelesaian:</b><br>g(x) = f(x − 3) + 5 = (x − 3)² + 5.<br><br><b>Kesimpulan:</b><br>g(x) = <b>(x − 3)² + 5</b>.'],
        ['q' => 'Diketahui f(x) = x² − 2x − 3. Grafik f(x) direfleksikan terhadap sumbu x, kemudian ditranslasikan 4 satuan ke atas. Tentukan g(x).', 'options' => ['g(x) = −x² + 2x + 7','g(x) = −x² + 2x − 1','g(x) = x² − 2x + 1','g(x) = −x² − 2x + 7','g(x) = x² + 2x + 7'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x² − 2x − 3.<br><br><b>Rumus:</b><br>Refleksi sumbu x: h(x) = −f(x). Translasi vertikal: g(x) = h(x) + b.<br><br><b>Penyelesaian:</b><br>h(x) = −(x² − 2x − 3) = −x² + 2x + 3. g(x) = −x² + 2x + 3 + 4 = −x² + 2x + 7.<br><br><b>Kesimpulan:</b><br>g(x) = <b>−x² + 2x + 7</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) mengalami dilatasi vertikal dengan faktor 2, kemudian ditranslasikan 3 satuan ke bawah. Tentukan g(x).', 'options' => ['g(x) = 2x² − 3','g(x) = 2x² + 3','g(x) = 2(x − 3)²','g(x) = 2(x + 3)²','g(x) = (2x)² − 3'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x², dilatasi vertikal faktor 2, kemudian translasi ke bawah 3 satuan.<br><br><b>Rumus:</b><br>h(x) = kf(x), g(x) = h(x) + b.<br><br><b>Penyelesaian:</b><br>h(x) = 2x², g(x) = 2x² − 3.<br><br><b>Kesimpulan:</b><br>g(x) = <b>2x² − 3</b>.'],
        ['q' => 'Titik B(4, −2) terletak pada grafik fungsi f(x). Titik tersebut ditranslasikan oleh (2, 3), kemudian dirotasikan 180° terhadap titik pusat O(0, 0). Tentukan koordinat bayangan akhir titik B.', 'options' => ['(−6, −1)','(6, −1)','(−6, 1)','(6, 1)','(−2, −5)'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>B(4, −2), translasi (2, 3), kemudian rotasi 180°.<br><br><b>Rumus:</b><br>Translasi: (x, y) → (x + a, y + b). Rotasi 180°: (x, y) → (−x, −y).<br><br><b>Penyelesaian:</b><br>Setelah translasi: (6, 1). Setelah rotasi 180°: (−6, −1).<br><br><b>Kesimpulan:</b><br>Bayangan akhir B adalah <b>(−6, −1)</b>.'],
        ['q' => 'Lintasan bola basket dimodelkan oleh fungsi kuadrat f(x) = −x² + 4x. Karena posisi pelempar bergeser 2 meter lebih ke depan, lintasan bola yang baru merupakan hasil translasi horizontal f(x) sejauh 2 satuan ke kanan. Tentukan fungsi lintasan baru g(x).', 'options' => ['g(x) = −(x − 2)² + 4(x − 2)','g(x) = −(x + 2)² + 4(x + 2)','g(x) = −x² + 4x − 2','g(x) = −x² + 4x + 2','g(x) = −(x − 2)² + 4x'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = −x² + 4x, translasi horizontal ke kanan 2 satuan.<br><br><b>Rumus:</b><br>g(x) = f(x − a).<br><br><b>Penyelesaian:</b><br>g(x) = f(x − 2) = −(x − 2)² + 4(x − 2).<br><br><b>Kesimpulan:</b><br>Model lintasan baru adalah <b>−(x − 2)² + 4(x − 2)</b>.'],
        ['q' => 'Populasi bakteri mula-mula dimodelkan dengan f(t) = 100·2ᵗ. Karena kondisi lingkungan berubah, populasi bakteri pada setiap saat t menjadi dua kali lipat dari model semula. Tentukan model populasi bakteri yang baru, g(t).', 'options' => ['g(t) = 200·2ᵗ','g(t) = 100·2²ᵗ','g(t) = 100·2ᵗ + 2','g(t) = 50·2ᵗ','g(t) = 100·4ᵗ'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(t) = 100·2ᵗ, populasi menjadi dua kali lipat.<br><br><b>Rumus:</b><br>Dilatasi vertikal: g(t) = kf(t).<br><br><b>Penyelesaian:</b><br>g(t) = 2 · (100·2ᵗ) = 200·2ᵗ.<br><br><b>Kesimpulan:</b><br>Model populasi baru adalah <b>200·2ᵗ</b>.'],
        ['q' => 'Biaya produksi suatu barang dimodelkan dengan f(x) = 5000x + 20000. Karena adanya subsidi tetap sebesar Rp10.000, biaya produksi menjadi g(x) = f(x) − 10000. Tentukan arah beserta besar translasi tersebut, dan fungsi biaya baru g(x).', 'options' => ['Translasi 10.000 ke bawah; g(x) = 5000x + 10000','Translasi 10.000 ke atas; g(x) = 5000x + 30000','Translasi 10.000 ke bawah; g(x) = 5000x + 20000','Translasi 10.000 ke kanan; g(x) = 5000(x − 10000) + 20000','Translasi 10.000 ke kiri; g(x) = 5000x + 10000'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = 5000x + 20000, subsidi = Rp10.000.<br><br><b>Rumus:</b><br>g(x) = f(x) + b.<br><br><b>Penyelesaian:</b><br>g(x) = 5000x + 20000 − 10000 = 5000x + 10000. Karena b = −10000, grafik bergeser ke bawah sebesar 10.000 satuan.<br><br><b>Kesimpulan:</b><br>Translasi <b>10.000 ke bawah</b>, g(x) = <b>5000x + 10000</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) mengalami dilatasi vertikal dengan faktor 2 dan dilatasi horizontal dengan faktor 1/3 secara bersamaan. Tentukan fungsi hasil transformasi g(x).', 'options' => ['g(x) = 18x²','g(x) = 6x²','g(x) = 2x²/3','g(x) = (2x/3)²','g(x) = 9x²'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x², dilatasi vertikal k₁ = 2, dilatasi horizontal k₂ = 1/3.<br><br><b>Rumus:</b><br>g(x) = k₁ · f(x/k₂).<br><br><b>Penyelesaian:</b><br>g(x) = 2 · f(x/(1/3)) = 2 · f(3x) = 2 · (3x)² = 18x².<br><br><b>Kesimpulan:</b><br>g(x) = <b>18x²</b>.'],
        ['q' => 'Diketahui f(x) = x² − 2x + 1. Titik P(3, 4) terletak pada grafik f(x). Grafik dirotasikan sejauh 90° searah jarum jam terhadap titik pusat O(0, 0). Tentukan koordinat bayangan titik P.', 'options' => ['(4, −3)','(−4, 3)','(3, −4)','(−3, 4)','(4, 3)'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>P(3, 4), rotasi 90° searah jarum jam.<br><br><b>Rumus:</b><br>Rotasi 90° searah jarum jam: (x, y) → (y, −x).<br><br><b>Penyelesaian:</b><br>x′ = 4, y′ = −3.<br><br><b>Kesimpulan:</b><br>Bayangan titik P adalah <b>(4, −3)</b>.'],
        ['q' => 'Diketahui f(x) = x². Grafik f(x) mengalami transformasi berturut-turut: (1) dilatasi vertikal dengan faktor 3, (2) refleksi terhadap sumbu x, (3) translasi 2 satuan ke kanan, dan (4) translasi 5 satuan ke atas. Tentukan fungsi akhir g(x).', 'options' => ['g(x) = −3(x − 2)² + 5','g(x) = 3(x − 2)² + 5','g(x) = −3(x + 2)² + 5','g(x) = −3(x − 2)² − 5','g(x) = −3(x − 5)² + 2'], 'answer' => 'A', 'explain' => '<b>Diketahui:</b><br>f(x) = x², dilatasi vertikal 3 → refleksi sumbu x → translasi kanan 2 → translasi atas 5.<br><br><b>Rumus:</b><br>h₁(x) = 3f(x), h₂(x) = −h₁(x), h₃(x) = h₂(x − 2), g(x) = h₃(x) + 5.<br><br><b>Penyelesaian:</b><br>h₁(x) = 3x², h₂(x) = −3x², h₃(x) = −3(x − 2)², g(x) = −3(x − 2)² + 5.<br><br><b>Kesimpulan:</b><br>g(x) = <b>−3(x − 2)² + 5</b>.']
    ]
];

if (!isset($_SESSION['levelScores'])) {
    $_SESSION['levelScores'] = [1 => 0, 2 => 0, 3 => 0];
}

if (!isset($_SESSION['player'])) {
    $_SESSION['player'] = ['nama' => '', 'kelas' => '', 'absen' => ''];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edu Mario - Transformasi Fungsi</title>

<style>

*{ margin:0; padding:0; box-sizing:border-box; }

body{
    font-family:'Segoe UI',Arial,sans-serif;
    min-height:100vh;
    background:#dceeff;
    color:#123;
    overflow-x:hidden;
}

button, input{ font-family:inherit; }

.game-wrapper{
    width:1100px;
    max-width:95%;
    margin:25px auto;
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.18);
}

.header{
    background:#1976d2;
    color:white;
    padding:22px 28px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
}

.header h1{ font-size:28px; margin-bottom:5px; }
.header p{ opacity:.9; font-size:14px; }

.header-level{
    background:white;
    color:#1976d2;
    padding:10px 18px;
    border-radius:14px;
    font-weight:bold;
    white-space:nowrap;
}

.menu{ padding:35px; text-align:center; }
.menu h2{ color:#1976d2; margin-bottom:10px; }
.menu-description{ color:#667; margin-bottom:25px; }

.form-grid{
    max-width:600px;
    margin:auto;
    display:grid;
    grid-template-columns:1fr;
    gap:15px;
}

.form-group{ text-align:left; }
.form-group label{ display:block; margin-bottom:7px; font-weight:bold; color:#345; }

.form-group input{
    width:100%;
    padding:13px 15px;
    border:2px solid #d6e6f5;
    border-radius:12px;
    outline:none;
    font-size:15px;
}

.form-group input:focus{ border-color:#1976d2; }

.start-button{
    border:none;
    background:#1976d2;
    color:white;
    padding:14px 28px;
    border-radius:13px;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    margin-top:10px;
}

.start-button:hover{ background:#125da8; }

.level-select{ display:none; padding:30px; text-align:center; }
.level-select h2{ color:#1976d2; margin-bottom:20px; }

.level-cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:18px;
}

.level-card{
    border:2px solid #d8e8f8;
    border-radius:18px;
    padding:25px 15px;
    background:#f9fcff;
}

.level-card h3{ color:#1976d2; margin-bottom:8px; }
.level-card p{ color:#667; font-size:14px; min-height:42px; }

.level-card button{
    margin-top:15px;
    border:none;
    padding:11px 18px;
    border-radius:10px;
    background:#1976d2;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.level-card.locked{ opacity:.5; }
.level-card.locked button{ background:#9eabb7; cursor:not-allowed; }

.game-area{ display:none; }

.hud{
    background:#123b63;
    color:white;
    padding:13px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.hud-item{
    background:rgba(255,255,255,.12);
    padding:8px 14px;
    border-radius:10px;
    font-weight:bold;
}

#gameCanvas{
    display:block;
    width:100%;
    height:auto;
    background:#bfe5ff;
}

.game-info{
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    gap:15px;
    background:#f5faff;
    color:#456;
    font-size:14px;
}

.sound-toggle{
    background:rgba(255,255,255,.15);
    border:none;
    color:white;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
    font-size:18px;
    margin-left:10px;
}

.sound-toggle:hover{ background:rgba(255,255,255,.25); }

.overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.58);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
    padding:20px;
}

.question-box{
    background:white;
    width:700px;
    max-width:95%;
    max-height:90vh;
    overflow-y:auto;
    border-radius:20px;
    padding:28px;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
}

.question-title{ color:#1976d2; font-size:14px; font-weight:bold; margin-bottom:12px; }
.question-text{ font-size:18px; line-height:1.6; margin-bottom:20px; }

.options{ display:grid; gap:10px; }

.option-btn{
    text-align:left;
    border:2px solid #dbe9f6;
    background:#f9fcff;
    padding:13px 15px;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    transition:.2s;
}

.option-btn:hover{ background:#eaf5ff; border-color:#1976d2; }
.option-btn:disabled{ cursor:not-allowed; }

.feedback{ display:none; margin-top:20px; border-radius:14px; padding:18px; }
.feedback.correct{ background:#e8f7ed; border:2px solid #36a05a; }
.feedback.wrong{ background:#fff0f0; border:2px solid #d9534f; }

.feedback-title{ font-weight:bold; font-size:18px; margin-bottom:10px; }
.feedback-explanation{ line-height:1.7; color:#344; }

.next-button{
    margin-top:18px;
    border:none;
    background:#1976d2;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

.result-box{
    background:white;
    width:600px;
    max-width:95%;
    border-radius:20px;
    padding:35px;
    text-align:center;
}

.result-box h2{ color:#1976d2; margin-bottom:12px; }
.result-score{ font-size:42px; font-weight:bold; color:#123b63; margin:20px 0; }

.result-box button{
    border:none;
    background:#1976d2;
    color:white;
    padding:13px 22px;
    border-radius:11px;
    font-weight:bold;
    cursor:pointer;
    margin:5px;
}

.final-scores{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px;
    margin:20px 0;
}

.final-score-card{
    background:#eef7ff;
    border-radius:13px;
    padding:15px;
}

.final-score-card strong{ display:block; color:#1976d2; margin-bottom:5px; }

.total-score{
    background:#1976d2;
    color:white;
    border-radius:15px;
    padding:20px;
    margin:20px 0;
}

.total-score span{ display:block; font-size:35px; font-weight:bold; margin-top:5px; }

.leaderboard{ display:none; padding:30px; }
.leaderboard h2{ color:#1976d2; margin-bottom:20px; }

.table-wrapper{ width:100%; overflow-x:auto; }

table{ width:100%; border-collapse:collapse; min-width:750px; }
th, td{ padding:12px; border-bottom:1px solid #e2edf5; text-align:center; }
th{ background:#1976d2; color:white; }
tr:nth-child(even){ background:#f6fbff; }
.rank{ font-weight:bold; color:#1976d2; }

.back-button{
    border:none;
    background:#64748b;
    color:white;
    padding:11px 18px;
    border-radius:10px;
    cursor:pointer;
    margin-top:20px;
}

@media(max-width:800px){
    .level-cards, .final-scores{ grid-template-columns:1fr; }
    .header{ flex-direction:column; align-items:flex-start; }
    .game-info{ flex-direction:column; }
}

</style>

</head>

<body>

<div class="game-wrapper">

    <div class="header">

        <div>
            <h1>🎮 Edu Mario — Transformasi Fungsi</h1>
            <p>Game pembelajaran berbasis gamifikasi</p>
        </div>

        <div class="header-level" id="headerLevel">MENU UTAMA</div>

    </div>

    <section class="menu" id="menu">

        <h2>Mulai Permainan</h2>
        <p class="menu-description">Masukkan identitas terlebih dahulu sebelum memainkan game.</p>

        <div class="form-grid">

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" placeholder="Masukkan nama">
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" placeholder="Contoh: XI Humaniora 1">
            </div>

            <div class="form-group">
                <label for="absen">No. Absen</label>
                <input type="text" id="absen" placeholder="Masukkan nomor absen">
            </div>

            <button class="start-button" onclick="masukGame()">MULAI GAME</button>

        </div>

    </section>

    <section class="level-select" id="levelSelect">

        <h2>Pilih Level Permainan</h2>

        <div class="level-cards">

            <div class="level-card">
                <h3>LEVEL 1</h3>
                <p>Mudah<br>Soal 1–10</p>
                <button onclick="startLevel(1)" id="btnLevel1">MULAI LEVEL 1</button>
            </div>

            <div class="level-card locked" id="cardLevel2">
                <h3>LEVEL 2</h3>
                <p>Sedang<br>Soal 11–20</p>
                <button onclick="startLevel(2)" id="btnLevel2" disabled>TERKUNCI</button>
            </div>

            <div class="level-card locked" id="cardLevel3">
                <h3>LEVEL 3</h3>
                <p>Sulit<br>Soal 21–30</p>
                <button onclick="startLevel(3)" id="btnLevel3" disabled>TERKUNCI</button>
            </div>

        </div>

    </section>

    <section class="game-area" id="gameArea">

        <div class="hud">

            <div class="hud-item">Level: <span id="hudLevel">1</span></div>
            <div class="hud-item">Score: <span id="hudScore">0</span></div>
            <div class="hud-item">Nyawa: <span id="hudLife">5</span></div>
            <div class="hud-item">Soal: <span id="hudQuestion">1</span>/10</div>

            <button class="sound-toggle" id="soundToggle" onclick="toggleSound()">🔊</button>

        </div>

        <canvas id="gameCanvas" width="1100" height="500"></canvas>

        <div class="game-info">

            <span>⌨️ Gunakan tombol <b>←</b> dan <b>→</b> untuk bergerak.</span>
            <span>🪙 Ambil coin untuk mendapatkan soal.</span>
            <span>🐦 Hindari burung dan 🍄 musuh darat.</span>

        </div>

    </section>

    <section class="leaderboard" id="leaderboard">

        <h2>🏆 Leaderboard</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Absen</th>
                        <th>Level 1</th>
                        <th>Level 2</th>
                        <th>Level 3</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody id="leaderboardBody"></tbody>

            </table>

        </div>

        <button class="back-button" onclick="kembaliMenu()">Kembali</button>

    </section>

</div>

<div class="overlay" id="questionOverlay">

    <div class="question-box">

        <div class="question-title" id="questionTitle">LEVEL 1 — SOAL 1</div>
        <div class="question-text" id="questionText"></div>
        <div class="options" id="optionsContainer"></div>

        <div class="feedback" id="feedback">

            <div class="feedback-title" id="feedbackTitle"></div>
            <div class="feedback-explanation" id="feedbackExplanation"></div>

            <button class="next-button" onclick="nextQuestion()">LANJUT</button>

        </div>

    </div>

</div>

<div class="overlay" id="levelResultOverlay">

    <div class="result-box">

        <h2 id="levelResultTitle">Level Selesai!</h2>
        <p>Skor kamu pada level ini:</p>
        <div class="result-score" id="levelResultScore">0</div>
        <p id="levelResultMessage"></p>
        <div id="levelResultButtons"></div>

    </div>

</div>

<div class="overlay" id="finalOverlay">

    <div class="result-box">

        <h2>🏆 Permainan Selesai!</h2>
        <p>Selamat! Kamu telah menyelesaikan seluruh level.</p>

        <div class="final-scores">

            <div class="final-score-card">
                <strong>LEVEL 1</strong>
                <span id="finalLevel1">0</span>
            </div>

            <div class="final-score-card">
                <strong>LEVEL 2</strong>
                <span id="finalLevel2">0</span>
            </div>

            <div class="final-score-card">
                <strong>LEVEL 3</strong>
                <span id="finalLevel3">0</span>
            </div>

        </div>

        <div class="total-score">
            TOTAL NILAI
            <span id="finalTotal">0</span>
        </div>

        <button onclick="lihatLeaderboard()">🏆 LIHAT LEADERBOARD</button>
        <button onclick="location.reload()">MAIN LAGI</button>

    </div>

</div>

<script>

const questions = <?php echo json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

let playerName = "";
let playerClass = "";
let playerAbsen = "";

let currentLevel = 1;
let currentQuestion = 0;

let score = 0;
let lives = 5;

let levelScores = { 1: 0, 2: 0, 3: 0 };

let gameRunning = false;
let questionOpen = false;
let questionAnswered = false;

let allExplanations = [];

let soundEnabled = true;
let bgmPlaying = false;
let bgmInterval = null;

const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

const player = {
    x: 80, y: 380,
    width: 34, height: 44,
    vx: 0, vy: 0,
    speed: 4.5,
    gravity: .65,
    jump: -11,
    onGround: false,
    invulnerableUntil: 0
};

let cameraX = 0;

const keys = {};

document.addEventListener("keydown", function(e){
    keys[e.key] = true;
    if((e.key === "ArrowUp" || e.key === " ") && player.onGround && gameRunning){
        player.vy = player.jump;
        player.onGround = false;
    }
});

document.addEventListener("keyup", function(e){
    keys[e.key] = false;
});

let pipes = [];

function createPipes(){
    pipes = [];
    const positions = [450,850,1250,1650,2050,2450,2850,3250,3650,4050];
    positions.forEach((x,index) => {
        pipes.push({ x:x, y:390, width:65, height:80, used:false, questionIndex:index });
    });
}

let coins = [];

function createCoins(){
    coins = [];
    const positions = [280,650,1000,1380,1750,2120,2500,2880,3260,3650,4050];
    positions.forEach((x,index) => {
        coins.push({ x:x, y:350 + (index % 2) * 25, radius:12, collected:false, questionIndex:index });
    });
}

let birds = [];

function createBirds(){
    birds = [];
    const positions = [720,1200,1900,2700,3450,4100];
    positions.forEach((x,index) => {
        birds.push({ x:x, y:250 + (index % 2) * 40, width:42, height:28, speed:1.5 + currentLevel * 0.4, direction:index % 2 === 0 ? 1 : -1 });
    });
}

let goombas = [];

function createGoombas(){
    goombas = [];
    const positions = [550, 1500, 2300, 3100];
    positions.forEach((x,index) => {
        goombas.push({
            x: x,
            y: 406,
            width: 32,
            height: 32,
            speed: 0.8 + currentLevel * 0.2,
            direction: index % 2 === 0 ? 1 : -1
        });
    });
}

function drawGround(){
    ctx.fillStyle = "#63b85b";
    ctx.fillRect(0,450,canvas.width,50);
    ctx.fillStyle = "#4b9d45";
    for(let x=0; x<canvas.width; x+=45){
        ctx.fillRect(x,465,30,8);
    }
}

function drawBackground(){
    ctx.fillStyle = "#bfe5ff";
    ctx.fillRect(0,0,canvas.width,canvas.height);
    ctx.fillStyle = "white";
    for(let i=0; i<7; i++){
        const x = (i * 240 - cameraX * .25) % 1300;
        ctx.beginPath();
        ctx.arc(x,100 + (i % 2) * 30,25,0,Math.PI * 2);
        ctx.arc(x+30,95 + (i % 2) * 30,35,0,Math.PI * 2);
        ctx.arc(x+65,105 + (i % 2) * 30,23,0,Math.PI * 2);
        ctx.fill();
    }
    ctx.fillStyle = "#7bc96f";
    for(let i=0; i<5; i++){
        const x = i * 300 - cameraX * .35;
        ctx.beginPath();
        ctx.arc(x,450,180,Math.PI,0);
        ctx.fill();
    }
}

function drawPipe(pipe){
    const x = pipe.x - cameraX;
    ctx.fillStyle = "#258c42";
    ctx.fillRect(x,pipe.y,pipe.width,pipe.height);
    ctx.fillStyle = "#35aa52";
    ctx.fillRect(x-7,pipe.y,pipe.width+14,18);
}

function drawCoin(coin){
    if(coin.collected) return;
    const x = coin.x - cameraX;
    const y = coin.y;
    ctx.fillStyle = "#ffd700";
    ctx.beginPath();
    ctx.arc(x,y,coin.radius,0,Math.PI * 2);
    ctx.fill();
    ctx.strokeStyle = "#e0a800";
    ctx.lineWidth = 3;
    ctx.stroke();
    ctx.fillStyle = "#fff3a3";
    ctx.font = "bold 14px Arial";
    ctx.textAlign = "center";
    ctx.fillText("$", x, y + 5);
}

function drawBird(bird){
    const x = bird.x - cameraX;
    const y = bird.y;
    ctx.fillStyle = "#795548";
    ctx.beginPath();
    ctx.ellipse(x+21,y+14,18,10,0,0,Math.PI * 2);
    ctx.fill();
    ctx.fillStyle = "#5d4037";
    ctx.beginPath();
    ctx.moveTo(x+5,y+12);
    ctx.lineTo(x-12,y);
    ctx.lineTo(x+4,y+20);
    ctx.closePath();
    ctx.fill();
    ctx.fillStyle = "#000";
    ctx.beginPath();
    ctx.arc(x+31,y+9,3,0,Math.PI * 2);
    ctx.fill();
}

function drawGoomba(goomba){
    const x = goomba.x - cameraX;
    const y = goomba.y;
    
    // Badan goomba (coklat)
    ctx.fillStyle = "#8B4513";
    ctx.beginPath();
    ctx.arc(x + 16, y + 20, 14, 0, Math.PI * 2);
    ctx.fill();
    
    // Kepala goomba (lebih gelap)
    ctx.fillStyle = "#654321";
    ctx.beginPath();
    ctx.arc(x + 16, y + 12, 12, Math.PI, 0);
    ctx.fill();
    
    // Mata
    ctx.fillStyle = "white";
    ctx.beginPath();
    ctx.arc(x + 10, y + 10, 4, 0, Math.PI * 2);
    ctx.arc(x + 22, y + 10, 4, 0, Math.PI * 2);
    ctx.fill();
    
    ctx.fillStyle = "black";
    ctx.beginPath();
    ctx.arc(x + 10, y + 10, 2, 0, Math.PI * 2);
    ctx.arc(x + 22, y + 10, 2, 0, Math.PI * 2);
    ctx.fill();
    
    // Kaki
    ctx.fillStyle = "#000";
    ctx.beginPath();
    ctx.ellipse(x + 8, y + 30, 5, 3, 0, 0, Math.PI * 2);
    ctx.ellipse(x + 24, y + 30, 5, 3, 0, 0, Math.PI * 2);
    ctx.fill();
}

function drawPlayer(){
    const x = player.x - cameraX;
    const y = player.y;
    ctx.fillStyle = "#e53935";
    ctx.fillRect(x+8,y+8,19,25);
    ctx.fillStyle = "#f5c39a";
    ctx.beginPath();
    ctx.arc(x+18,y+8,11,0,Math.PI * 2);
    ctx.fill();
    ctx.fillStyle = "#d71920";
    ctx.fillRect(x+5,y-4,27,7);
    ctx.fillStyle = "#1d3f7a";
    ctx.fillRect(x+7,y+32,9,12);
    ctx.fillRect(x+20,y+32,9,12);
}

function updatePlayer(){
    if(keys["ArrowLeft"]){ player.vx = -player.speed; }
    else if(keys["ArrowRight"]){ player.vx = player.speed; }
    else{ player.vx *= .8; }
    player.vy += player.gravity;
    player.x += player.vx;
    player.y += player.vy;
    
    if(player.y + player.height >= 450){
        player.y = 450 - player.height;
        player.vy = 0;
        player.onGround = true;
    }
    
    cameraX = player.x - 250;
    if(cameraX < 0) cameraX = 0;
    
    checkPipeCollision();
}

function checkPipeCollision(){
    pipes.forEach(pipe => {
        const px = pipe.x;
        const py = pipe.y;
        const pw = pipe.width;
        const ph = pipe.height;
        
        const playerLeft = player.x;
        const playerRight = player.x + player.width;
        const playerTop = player.y;
        const playerBottom = player.y + player.height;
        
        const pipeLeft = px;
        const pipeRight = px + pw;
        const pipeTop = py;
        const pipeBottom = py + ph;
        
        if(
            playerRight > pipeLeft + 5 &&
            playerLeft < pipeRight - 5 &&
            playerBottom > pipeTop &&
            playerTop < pipeBottom
        ){
            if(playerBottom <= pipeTop + 20 && player.vy >= 0){
                player.y = pipeTop - player.height;
                player.vy = 0;
                player.onGround = true;
            }
            else if(playerBottom > pipeTop + 10){
                if(playerRight <= pipeLeft + pw/2 && player.vx > 0){
                    player.x = pipeLeft - player.width;
                    player.vx = 0;
                }
                else if(playerLeft >= pipeRight - pw/2 && player.vx < 0){
                    player.x = pipeRight;
                    player.vx = 0;
                }
            }
        }
    });
}

function checkCoinCollision(){
    if(questionOpen) return;
    coins.forEach(coin => {
        if(coin.collected) return;
        const dx = player.x + player.width / 2 - coin.x;
        const dy = player.y + player.height / 2 - coin.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        if(distance < coin.radius + 25){
            coin.collected = true;
            playSound("coin");
            showQuestion();
        }
    });
}

function updateBirds(){
    birds.forEach(bird => {
        bird.x += bird.speed * bird.direction;
        if(bird.x < 100 || bird.x > 4500){
            bird.direction *= -1;
        }
    });
}

function updateGoombas(){
    goombas.forEach(goomba => {
        goomba.x += goomba.speed * goomba.direction;
        if(goomba.x < 100 || goomba.x > 4500){
            goomba.direction *= -1;
        }
    });
}

function checkBirdCollision(){
    const now = Date.now();
    if(now < player.invulnerableUntil) return;
    birds.forEach(bird => {
        const hit = player.x < bird.x + bird.width && player.x + player.width > bird.x && player.y < bird.y + bird.height && player.y + player.height > bird.y;
        if(hit){
            lives--;
            player.invulnerableUntil = now + 1500;
            player.x -= 80;
            player.vy = -7;
            playSound("hit");
            updateHUD();
        }
    });
}

function checkGoombaCollision(){
    const now = Date.now();
    if(now < player.invulnerableUntil) return;
    goombas.forEach(goomba => {
        const hit = player.x < goomba.x + goomba.width && player.x + player.width > goomba.x && player.y < goomba.y + goomba.height && player.y + player.height > goomba.y;
        if(hit){
            lives--;
            player.invulnerableUntil = now + 1500;
            player.x -= 80;
            player.vy = -7;
            playSound("hit");
            updateHUD();
        }
    });
}

function masukGame(){
    playerName = document.getElementById("nama").value.trim();
    playerClass = document.getElementById("kelas").value.trim();
    playerAbsen = document.getElementById("absen").value.trim();
    if(!playerName || !playerClass || !playerAbsen){
        alert("Silakan lengkapi Nama, Kelas, dan No. Absen.");
        return;
    }
    document.getElementById("menu").style.display = "none";
    document.getElementById("levelSelect").style.display = "block";
    document.getElementById("headerLevel").textContent = "PILIH LEVEL";
    initBGM();
}

function startLevel(level){
    currentLevel = level;
    currentQuestion = 0;
    score = 0;
    lives = 5;
    questionOpen = false;
    questionAnswered = false;
    allExplanations = [];
    createPipes();
    createCoins();
    createBirds();
    createGoombas();
    resetPlayer();
    document.getElementById("levelSelect").style.display = "none";
    document.getElementById("gameArea").style.display = "block";
    document.getElementById("headerLevel").textContent = "LEVEL " + level;
    updateHUD();
    gameRunning = true;
    if(soundEnabled && !bgmPlaying){
        startBGM();
    }
    requestAnimationFrame(gameLoop);
}

function resetPlayer(){
    player.x = 80;
    player.y = 380;
    player.vx = 0;
    player.vy = 0;
    player.onGround = false;
    cameraX = 0;
}

function updateHUD(){
    document.getElementById("hudLevel").textContent = currentLevel;
    document.getElementById("hudScore").textContent = score;
    document.getElementById("hudLife").textContent = lives;
    document.getElementById("hudQuestion").textContent = Math.min(currentQuestion + 1, 10);
}

function showQuestion(){
    questionOpen = true;
    questionAnswered = false;
    const q = questions[currentLevel][currentQuestion];
    if(!q){
        finishLevel();
        return;
    }
    document.getElementById("questionTitle").textContent = "LEVEL " + currentLevel + " — SOAL " + (currentQuestion + 1);
    document.getElementById("questionText").textContent = q.q;
    const container = document.getElementById("optionsContainer");
    container.innerHTML = "";
    const letters = ["A","B","C","D","E"];
    q.options.forEach((option,index) => {
        const button = document.createElement("button");
        button.className = "option-btn";
        button.innerHTML = "<b>" + letters[index] + ".</b> " + option;
        button.onclick = () => answerQuestion(letters[index], q);
        container.appendChild(button);
    });
    document.getElementById("feedback").style.display = "none";
    document.getElementById("questionOverlay").style.display = "flex";
}

function answerQuestion(choice, q){
    if(questionAnswered) return;
    questionAnswered = true;
    const buttons = document.querySelectorAll(".option-btn");
    buttons.forEach(button => { button.disabled = true; });
    const correct = choice === q.answer;
    if(correct){
        score += 10;
        playSound("correct");
    } else {
        playSound("wrong");
    }
    updateHUD();
    const feedback = document.getElementById("feedback");
    const title = document.getElementById("feedbackTitle");
    const explanation = document.getElementById("feedbackExplanation");
    feedback.className = correct ? "feedback correct" : "feedback wrong";
    feedback.style.display = "block";
    if(correct){
        title.innerHTML = "✅ Jawaban Benar!";
    } else {
        title.innerHTML = "❌ Jawaban Kurang Tepat — Kunci: " + q.answer;
    }
    allExplanations.push({
        questionNumber: currentQuestion + 1,
        question: q.q,
        correctAnswer: q.answer,
        explanation: q.explain,
        isCorrect: correct
    });
    explanation.innerHTML = "Jawaban akan dibahas setelah level selesai.";
}

function nextQuestion(){
    document.getElementById("questionOverlay").style.display = "none";
    questionOpen = false;
    questionAnswered = false;
    currentQuestion++;
    if(currentQuestion >= 10){
        finishLevel();
        return;
    }
    updateHUD();
}

function finishLevel(){
    gameRunning = false;
    questionOpen = false;
    levelScores[currentLevel] = score;
    saveLevelScore(currentLevel, score);
    document.getElementById("levelResultTitle").textContent = "Level " + currentLevel + " Selesai!";
    document.getElementById("levelResultScore").textContent = score;
    const message = document.getElementById("levelResultMessage");
    const buttons = document.getElementById("levelResultButtons");
    buttons.innerHTML = "";
    const review = document.createElement("button");
    review.textContent = "LIHAT PEMBAHASAN";
    review.onclick = function(){ showReviewOverlay(); };
    buttons.appendChild(review);
    if(currentLevel < 3){
        message.textContent = "Level berikutnya berhasil dibuka.";
        const next = document.createElement("button");
        next.textContent = "LANJUT LEVEL " + (currentLevel + 1);
        next.onclick = function(){
            document.getElementById("levelResultOverlay").style.display = "none";
            unlockNextLevel();
        };
        buttons.appendChild(next);
    } else {
        message.textContent = "Kamu telah menyelesaikan seluruh level.";
        const finish = document.createElement("button");
        finish.textContent = "LIHAT HASIL AKHIR";
        finish.onclick = function(){
            document.getElementById("levelResultOverlay").style.display = "none";
            showFinalResult();
        };
        buttons.appendChild(finish);
    }
    document.getElementById("levelResultOverlay").style.display = "flex";
    playSound("levelComplete");
    stopBGM();
}

function showReviewOverlay(){
    const overlay = document.createElement("div");
    overlay.className = "overlay";
    overlay.style.display = "flex";
    const box = document.createElement("div");
    box.className = "question-box";
    box.style.maxHeight = "85vh";
    const title = document.createElement("h3");
    title.textContent = "Pembahasan Level " + currentLevel;
    title.style.color = "#1976d2";
    title.style.marginBottom = "15px";
    box.appendChild(title);
    allExplanations.forEach((item, index) => {
        const qDiv = document.createElement("div");
        qDiv.style.marginBottom = "20px";
        qDiv.style.paddingBottom = "15px";
        qDiv.style.borderBottom = index < allExplanations.length - 1 ? "1px solid #e2edf5" : "none";
        const qTitle = document.createElement("div");
        qTitle.innerHTML = "<b>Soal " + item.questionNumber + ":</b> " + item.question;
        qTitle.style.marginBottom = "8px";
        const status = document.createElement("div");
        status.innerHTML = item.isCorrect ? "<span style='color:#36a05a'>✅ Benar</span>" : "<span style='color:#d9534f'>❌ Salah (Kunci: " + item.correctAnswer + ")</span>";
        status.style.marginBottom = "8px";
        const explainTitle = document.createElement("div");
        explainTitle.innerHTML = "<b>Pembahasan:</b>";
        explainTitle.style.marginTop = "10px";
        explainTitle.style.marginBottom = "5px";
        const explainContent = document.createElement("div");
        explainContent.innerHTML = item.explanation;
        explainContent.style.lineHeight = "1.6";
        qDiv.appendChild(qTitle);
        qDiv.appendChild(status);
        qDiv.appendChild(explainTitle);
        qDiv.appendChild(explainContent);
        box.appendChild(qDiv);
    });
    const closeBtn = document.createElement("button");
    closeBtn.textContent = "TUTUP";
    closeBtn.className = "next-button";
    closeBtn.style.marginTop = "15px";
    closeBtn.onclick = function(){ document.body.removeChild(overlay); };
    box.appendChild(closeBtn);
    overlay.appendChild(box);
    document.body.appendChild(overlay);
}

function unlockNextLevel(){
    const nextLevel = currentLevel + 1;
    const card = document.getElementById("cardLevel" + nextLevel);
    const button = document.getElementById("btnLevel" + nextLevel);
    if(card && button){
        card.classList.remove("locked");
        button.disabled = false;
        button.textContent = "MULAI LEVEL " + nextLevel;
    }
    document.getElementById("levelSelect").style.display = "block";
    document.getElementById("gameArea").style.display = "none";
    document.getElementById("headerLevel").textContent = "PILIH LEVEL";
}

function gameOver(){
    gameRunning = false;
    document.getElementById("questionOverlay").style.display = "none";
    document.getElementById("levelResultTitle").textContent = "Game Over";
    document.getElementById("levelResultScore").textContent = score;
    document.getElementById("levelResultMessage").textContent = "Nyawa kamu habis. Level berikutnya belum dibuka.";
    const buttons = document.getElementById("levelResultButtons");
    buttons.innerHTML = "";
    const retry = document.createElement("button");
    retry.textContent = "ULANGI LEVEL";
    retry.onclick = function(){
        document.getElementById("levelResultOverlay").style.display = "none";
        startLevel(currentLevel);
    };
    buttons.appendChild(retry);
    const menu = document.createElement("button");
    menu.textContent = "KEMBALI";
    menu.onclick = function(){
        document.getElementById("levelResultOverlay").style.display = "none";
        document.getElementById("gameArea").style.display = "none";
        document.getElementById("levelSelect").style.display = "block";
    };
    buttons.appendChild(menu);
    document.getElementById("levelResultOverlay").style.display = "flex";
    stopBGM();
}

function showFinalResult(){
    const level1 = levelScores[1];
    const level2 = levelScores[2];
    const level3 = levelScores[3];
    const total = level1 + level2 + level3;
    document.getElementById("finalLevel1").textContent = level1;
    document.getElementById("finalLevel2").textContent = level2;
    document.getElementById("finalLevel3").textContent = level3;
    document.getElementById("finalTotal").textContent = total;
    document.getElementById("finalOverlay").style.display = "flex";
}

function saveLevelScore(level, levelScore){
    const formData = new FormData();
    formData.append("nama", playerName);
    formData.append("kelas", playerClass);
    formData.append("absen", playerAbsen);
    formData.append("level", level);
    formData.append("skor", levelScore);
    fetch("?action=save_level", { method:"POST", body:formData })
    .then(response => response.json())
    .then(data => { console.log("Skor tersimpan:", data); })
    .catch(error => { console.error("Gagal menyimpan skor:", error); });
}

function lihatLeaderboard(){
    document.getElementById("finalOverlay").style.display = "none";
    document.getElementById("gameArea").style.display = "none";
    document.getElementById("leaderboard").style.display = "block";
    document.getElementById("headerLevel").textContent = "LEADERBOARD";
    loadLeaderboard();
}

function loadLeaderboard(){
    fetch("?action=leaderboard")
    .then(response => response.json())
    .then(data => {
        const tbody = document.getElementById("leaderboardBody");
        tbody.innerHTML = "";
        if(data.length === 0){
            tbody.innerHTML = `<tr><td colspan="8">Belum ada data leaderboard.</td></tr>`;
            return;
        }
        data.forEach((row,index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="rank">${index + 1}</td>
                <td>${escapeHTML(row.Nama)}</td>
                <td>${escapeHTML(row.Kelas)}</td>
                <td>${escapeHTML(row.No_Absen)}</td>
                <td>${row.Level1}</td>
                <td>${row.Level2}</td>
                <td>${row.Level3}</td>
                <td><b>${row.Total}</b></td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => { console.error("Leaderboard error:", error); });
}

function escapeHTML(text){
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

function kembaliMenu(){
    document.getElementById("leaderboard").style.display = "none";
    document.getElementById("menu").style.display = "block";
    document.getElementById("headerLevel").textContent = "MENU UTAMA";
    stopBGM();
}

function gameLoop(){
    if(!gameRunning) return;
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawBackground();
    drawGround();
    pipes.forEach(pipe => { drawPipe(pipe); });
    coins.forEach(coin => { drawCoin(coin); });
    birds.forEach(bird => { drawBird(bird); });
    goombas.forEach(goomba => { drawGoomba(goomba); });
    updatePlayer();
    updateBirds();
    updateGoombas();
    checkCoinCollision();
    checkBirdCollision();
    checkGoombaCollision();
    drawPlayer();
    requestAnimationFrame(gameLoop);
}

/* =========================================================
   AUDIO SYSTEM - MARIO STYLE BGM
   ========================================================= */

const audioContext = new (window.AudioContext || window.webkitAudioContext)();

let bgmNoteIndex = 0;
const marioTheme = [
    330,330,0,330,0,261,330,0,392,0,0,0,196,0,0,0,261,0,0,0,330,0,0,0,392,0,0,0,
    330,330,0,330,0,261,330,0,392,0,0,0,196,0,0,0,261,0,0,0,330,0,0,0,392,0,0,0,
    392,0,0,0,392,0,392,0,392,0,0,0,440,392,330,0,294,0,0,0,261,0,0,0,261,0,294,0,330,0,
    261,0,0,0,220,0,0,0,220,0,261,0,330,0,0,0,392,0,0,0,196,0,0,0,261,0,0,0,330,0,0,0,392,0,0,0
];

function playNote(freq, duration, startTime){
    if(freq === 0) return;
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    oscillator.type = "square";
    oscillator.frequency.setValueAtTime(freq, startTime);
    gainNode.gain.setValueAtTime(0.15, startTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + duration * 0.9);
    oscillator.start(startTime);
    oscillator.stop(startTime + duration);
}

function startBGM(){
    if(bgmPlaying) return;
    bgmPlaying = true;
    bgmNoteIndex = 0;
    const tempo = 0.15;
    
    function playNextNote(){
        if(!bgmPlaying || !soundEnabled) return;
        const now = audioContext.currentTime;
        const freq = marioTheme[bgmNoteIndex % marioTheme.length];
        playNote(freq, tempo, now);
        bgmNoteIndex++;
        bgmInterval = setTimeout(playNextNote, tempo * 1000);
    }
    
    playNextNote();
}

function stopBGM(){
    bgmPlaying = false;
    if(bgmInterval){
        clearTimeout(bgmInterval);
        bgmInterval = null;
    }
}

function initBGM(){
    if(audioContext.state === "suspended"){
        audioContext.resume();
    }
}

function playSound(type){
    if(!soundEnabled) return;
    if(audioContext.state === "suspended"){
        audioContext.resume();
    }
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    const now = audioContext.currentTime;

    if(type === "coin"){
        oscillator.type = "sine";
        oscillator.frequency.setValueAtTime(800, now);
        oscillator.frequency.exponentialRampToValueAtTime(1200, now + 0.1);
        gainNode.gain.setValueAtTime(0.3, now);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.15);
        oscillator.start(now);
        oscillator.stop(now + 0.15);
    }
    else if(type === "hit"){
        oscillator.type = "sawtooth";
        oscillator.frequency.setValueAtTime(200, now);
        oscillator.frequency.exponentialRampToValueAtTime(100, now + 0.2);
        gainNode.gain.setValueAtTime(0.3, now);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
        oscillator.start(now);
        oscillator.stop(now + 0.25);
    }
    else if(type === "correct"){
        oscillator.type = "sine";
        oscillator.frequency.setValueAtTime(600, now);
        oscillator.frequency.setValueAtTime(800, now + 0.1);
        oscillator.frequency.setValueAtTime(1000, now + 0.2);
        gainNode.gain.setValueAtTime(0.25, now);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.35);
        oscillator.start(now);
        oscillator.stop(now + 0.35);
    }
    else if(type === "wrong"){
        oscillator.type = "square";
        oscillator.frequency.setValueAtTime(300, now);
        oscillator.frequency.exponentialRampToValueAtTime(150, now + 0.2);
        gainNode.gain.setValueAtTime(0.2, now);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
        oscillator.start(now);
        oscillator.stop(now + 0.25);
    }
    else if(type === "levelComplete"){
        oscillator.type = "triangle";
        oscillator.frequency.setValueAtTime(523, now);
        oscillator.frequency.setValueAtTime(659, now + 0.15);
        oscillator.frequency.setValueAtTime(784, now + 0.3);
        oscillator.frequency.setValueAtTime(1047, now + 0.45);
        gainNode.gain.setValueAtTime(0.25, now);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.6);
        oscillator.start(now);
        oscillator.stop(now + 0.6);
    }
}

function toggleSound(){
    soundEnabled = !soundEnabled;
    document.getElementById("soundToggle").textContent = soundEnabled ? "🔊" : "🔇";
    if(soundEnabled && gameRunning && !bgmPlaying){
        startBGM();
    } else if(!soundEnabled){
        stopBGM();
    }
}

</script>

</body>
</html>