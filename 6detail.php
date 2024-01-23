<!-- Pemanggilan API menggunakan file Json -->
<?php
$data_tech = file_get_contents('api/tech.json');
$data_jurnal = file_get_contents('api/jurnal.json');
$data_tesla = file_get_contents('api/tesla.json');
$data_bisnis = file_get_contents('api/bisnis.json');

$articles_tech = json_decode ($data_tech, true);
$articles_jurnal = json_decode ($data_jurnal, true);
$articles_tesla = json_decode ($data_tesla, true);
$articles_bisnis = json_decode ($data_bisnis, true);

    // Menggabungkan menjadi 1 array
    $all_articles = array_merge(
        $articles_tech["articles"],
        $articles_jurnal["articles"],
        $articles_tesla["articles"],
        $articles_bisnis["articles"]
    );
    // Fungsi pencarian
    function cariArtikel($kataKunci) {
        global $all_articles;
            $hasilPencarian = array_filter($all_articles, function ($article) use ($kataKunci) {
                return stripos($article['title'], $kataKunci) !== false;
            });

            return $hasilPencarian;
        }

    //Fungsi Detail
    function getArticleDetailByTitle($articleTitle) {
        global $all_articles;
    
        // Mencari artikel berdasarkan judul
        $foundArticle = array_filter($all_articles, function ($article) use ($articleTitle) {
            return $article['title'] === $articleTitle;
        });

        return $foundArticle;
    }
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<!-- HEAD => Link terkait  -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.News</title>
    <!-- Icon Google -->
    <link rel="shorcut icon" href="favicon.ico">
    <link rel="icon" type="image/png" href="ico/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="ico/favicon-16x16.png" sizes="16x16" />
    <!-- Link CSS -->
    <link rel="stylesheet" href="css/detal.css">
    <!-- Link Ajax untuk membaca Json (API) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c0adbb8084.js" crossorigin="anonymous"></script>
</head>

<!-- BODY WEB BNews-->
<body>

    <!--- navbar -->
    <nav class="navbar">
        <div class="nav">
            <!-- logo gambar atas kiri -->
            <img src="img/bnews.png" alt="logo">
            <div></div>

            <!-- Deskripsi BNews | Sidebar -->
            <div id="about" class="pincode">
                <div>
                    <img src="https://assets.pharmeasy.in/apothecary/images/ic_express%20delivery.svg?dim=16x0" alt="pin-add">
                    <p>ALL HOT NEWS</p>
                </div>
                <h4>Around the World</h4>
            </div>

            <!-- Button Login => Halaman Login -->
            <div class="download-app">
                    <i class="fa-regular fa-user"></i>
                    <p>Log In</p>
            </div>
        </div>
    </nav>
    <!--- navbar selesai -->

    <!-- Fungsi Pencaharian sumber artikel (API) -->
    <!---- search bar -->
    <div class="search-layout">
        <div>
            <div class="search-header">
                <h2>What are you looking for?</h2>
            </div>
            <form action="5cari.php" method="get" class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="kata_kunci" placeholder="Search for articles" id="#">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
    <!---- search bar selesai -->

    <!-- Semua Berita -->
    <!---- all -->
    <div class="all container">
        <div class="articles-card1">

            <!-- Pemanggilan seluruh berita -->
            <?php
            $articleTitle = isset($_GET['article_title']) ? urldecode($_GET['article_title']) : null;
            $articleDetail = getArticleDetailByTitle($articleTitle);
            ?>

            <?php if (!empty($foundArticle)): ?>
                <p>Maaf, Artikel tidak ditemukan.</p>
            <?php else: ?>
                <!-- Tampilkan hasil pencarian -->
                <?php foreach ($articleDetail as $article): ?>
                    <div class="article-detail container">
                            <h4 class="name"><?= $article["title"]; ?></h4><br>
                            <p><?= $article["author"]; ?> - <span><?= formatDate ($article["publishedAt"]); ?></p></span><br>
                            <img src="<?= $article["urlToImage"]; ?>">
                            <h5>
                               <?= $article["content"]; ?> | <span><a href="<?= $article["url"]; ?>">Read More</a></span>
                            </h5><br>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Pemanggilan seluruh berita selesai -->

        </div>
    </div>

    <?php
        // Fungsi untuk mengubah format tanggal dan waktu
        function formatDate($iso8601Date) {
            $timestamp = strtotime($iso8601Date);
            $formattedDate = date("g:i A, D F d, Y", $timestamp);
            return $formattedDate;
        }
    ?>
    <!---- all selesai-->

    <!----footer-->
    <div class="footer container">
        <div class="footer-top">
            <div>
                <ul>
                    <h3>Company</h3>
                    <li>About Us</li>
                    <li>Careers</li>
                    <li>Blog</li>
                </ul>
                <ul>
                    <h3>Our Services</h3>
                    <li>J.member</li>
                </ul>
            </div>
            <div>
                <ul>
                    <h3>Featured Categories</h3>
                    <li>Business</li>
                    <li>Technology</li>
                    <li>Otomotif</li>
                    <li>Journal</li>
                </ul>
            </div>
            <div>
                <ul>
                    <h3>Need Help</h3>
                    <li>FAQs</li>
                </ul>
                <ul>
                    <h3>Policy Info</h3>
                    <li>Customer Support Policy</li>
                </ul>
            </div>
            <div>
                <ul>
                    <h3>Follow us on</h3>
                    <li><img src="https://assets.pharmeasy.in/apothecary/images/Instagram.svg?dim=32x0"></li>
                    <li><img src="https://assets.pharmeasy.in/apothecary/images/facebook.svg?dim=32x0"></li>
                    <li><img src="https://assets.pharmeasy.in/apothecary/images/Youtube.svg?dim=32x0"></li>
                    <li><img src="https://assets.pharmeasy.in/apothecary/images/Twitter.svg?dim=32x0"></li>
                </ul>
            </div>
        </div>
    
        <div class="footer-bottom">
            <h3>Our Payment Partners</h3>
            <div>
                <div>
                    <img src="https://assets.pharmeasy.in/apothecary/images/gpay.png?dim=1024x0">
                    <img src="https://assets.pharmeasy.in/apothecary/images/visa.png?dim=1024x0">
                </div>
                <p>© 2024 Suci Rahma Rosa. All Rights Reserved</p>
            </div>
        </div>
    </div>
    <!----footer selesai-->

    <!---floating button-->
    <div class="floating-button">
        <i class="fa-solid fa-phone"></i>
    </div>
    <!---floating button selesai-->

    <!--javascript file-->
    <script src="js/berita.js"></script>

</body>

</html>