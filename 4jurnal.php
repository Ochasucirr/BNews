<!-- Pemanggilan API menggunakan file Json -->
<?php
$data = file_get_contents('api/jurnal.json');
$articles = json_decode ($data, true);

$articles = $articles["articles"];

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

    //Fungsi Pagnitation per-slide
        $articlesPerPage = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startIndex = ($page - 1) * $articlesPerPage;
        $currentPageArticles = array_slice($articles, $startIndex, $articlesPerPage);

    // Fungsi Jumlah Artikel
    function countTotalArticles() {
        global $articles;
        return count($articles);
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
    <link rel="stylesheet" href="css/start.css">
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

    <!-- Jenis Berita -->
    <!---nav card layout-->
    <div class="nav-card-layout container">
        <div>
            <div>
                <img src="img/aboutbnews.jpg" height="60"> 
                <h4>Home</h4>
                <p><a href="index.php">Read More >></a></p>
            </div>
            <div>
                <img src="img/bisnis.png" height="60"> 
                <h4>Business</h4>
                <p><a href="1bisnis.php">Read More >></a></p>
            </div>
            <div>
                <img src="img/tekn.png" height="60">
                <h4>Technology</h4>
                <p><a href="2teknologi.php">Read More >></a></p>
            </div>
            <div>
                <img src="img/otom.png" height="60">
                <h4>Automotive</h4>
                <p><a href="3otomotif.php">Read More >></a></p>
            </div>
            <div>
                <img src="img/jurnal.png" height="60">
                <h4>Journal</h4>
                <p><a href="4jurnal.php">Read More >></a></p>
            </div>
        </div>
    </div>
    <!---nav card layout selesai-->

    <!-- Semua Berita -->
    <!---- all -->
    <div class="all container">
        <hr><br>
        <center><h1>Journal News</h1></center>
        <h3 class="subtitle"><center>All the news is here</center></h3><br><br>
        
        <div class="column">
            <div class="articles-cards2">
            <!-- Pemanggilan seluruh berita -->
            <?php foreach ($currentPageArticles as $row): ?>
                <div>
                    <img src="<?= $row["urlToImage"]; ?>">
                    <div>
                        <h4 class="name"><?= $row["title"]; ?></h4><br>
                        <h5>
                            <span><?= $row["description"]; ?></span>
                        </h5>
                        <p>
                            <?= formatDate ($row["publishedAt"]); ?>
                        </p><hr>
                        <p>
                            <a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>">Read More >></a>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

            <!-- Fungsi Pagnitation -->
            <div class="pagination">
                <?php
                // Hitung total jumlah halaman
                $totalPages = ceil(count($articles) / $articlesPerPage);

                // Tampilkan tautan paginasi
                for ($i = 1; $i <= $totalPages; $i++) {
                    $isActive = $i == $page ? 'active' : '';
                    echo "<a href='4jurnal.php?page=$i' class='$isActive'>$i</a>";
                }
                ?>
            </div>
            
            <!-- Format Kanan atas -->
            <div class="articles-cards4"><br>
            <?php
                $totalArticles = countTotalArticles();
                echo "Number of articles: $totalArticles"; ?>
            </div>

            <!-- Format kanan bawah -->
            <div class="articles-cards3"><br>
                    <h2>Popular News!</h2>

                    <?php
                        // Fungsi untuk membandingkan dua artikel berdasarkan tanggal publikasi
                        function compareByPublishedDate($a, $b) {
                            return strtotime($b['publishedAt']) - strtotime($a['publishedAt']);
                        }

                        // Mengurutkan array $all_articles berdasarkan tanggal publikasi
                        usort($articles, 'compareByPublishedDate');

                        // Mengambil 5 data teratas setelah diurutkan
                        $top_5_articles = array_slice($articles, 0, 5);
                    ?>

                    <?php foreach ($top_5_articles as $row): ?>
                        <div>
                            <div><br>
                                <h4 class="name"><a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>"><?= $row["title"]; ?></a></h4>
                                <br><hr>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <!-- Pemanggilan seluruh berita selesai -->

            </div>
    </div>

    <!-- Format Tanggal -->
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


