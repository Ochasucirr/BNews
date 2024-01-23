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
    <link rel="stylesheet" href="css/inex.css">
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

    <!-- 5 Gambar Berita Terbaru -->
    <!---bannnerr start-->
    <div class="banner">
    <!-- Pemanggilan Berita Terbaru -->
        <?php
            // Fungsi untuk membandingkan dua artikel berdasarkan tanggal publikasi
            function compareByPublishedDate($a, $b) {
                return strtotime($b['publishedAt']) - strtotime($a['publishedAt']);
            }

            // Mengurutkan array $all_articles berdasarkan tanggal publikasi
            usort($all_articles, 'compareByPublishedDate');

            // Mengambil 5 data teratas setelah diurutkan
                $top_5_articles = array_slice($all_articles, 0, 5);
        ?>

            <!-- Menampilkan artikel setelah diurutkan -->
        <?php foreach ($top_5_articles as $row): ?>
            <img src="<?= $row["urlToImage"]; ?>" class="img-fluid rounded-start">
        <?php endforeach; ?>
     </div>
    <!-- Pemanggilan Berita Terbaru Selesai -->
    <!---bannnerr Selesai-->

    <!-- Daftar Menulis Artikel -->
    <!---list -->
    <div class="list container">
        <h1 class="title">Job For You</h1>
        <div class="cards-layout">
            <div>
                <img src="img/cuan.jpg" >
                <p>Article writing at B.News <br><span>Rp. 250.000,00</span></p>
            </div>
            <div>
                <i class="fa-solid fa-lock"></i>
                <p>Log in to start >></p>
            </div>
        </div>
    </div>
    <!---list selesai-->

    <!-- Berita Popular Teknologi dan Bisnis -->
    <!-- Pengaruh pada berita -->
    <!--- popular -->
    <div class="popular transition-item container">
            <h1 class="title">Popular News</h1>
            <h3 class="subtitle">Read it soon popular news about Technology and Business</h3>

        <div>
        <!-- Pemanggilan 2 Berita Popular Teknologi dan Bisnis -->
        <?php
            $data_tech = file_get_contents('api/tech.json');
            $data_bisnis = file_get_contents('api/bisnis.json');

            $articles_tech = json_decode($data_tech, true);
            $articles_bisnis = json_decode($data_bisnis, true);

            // Mengurutkan array $articles_tech berdasarkan tanggal publikasi
            usort($articles_tech['articles'], 'compareByPublishedDate');

            // Mengurutkan array $articles_bisnis berdasarkan tanggal publikasi
            usort($articles_bisnis['articles'], 'compareByPublishedDate');

            $top_6_tech_articles = array_slice($articles_tech['articles'], 0, 6);
            $top_3_bisnis_articles = array_slice($articles_bisnis['articles'], 0, 3);

        ?>

        <!-- Menampilkan artikel dari $articles_tech yang sudah diurutkan -->
        <?php foreach ($top_6_tech_articles as $row): ?>
            <div>
                <img src="<?= $row["urlToImage"]; ?>">
                <p class="satunew"><?= $row["title"]; ?></p>
                <p class="empatnew"><?= $row["category"]; ?></p><hr>
                <p class="duanew"><a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>">Read More >></a></p>
            </div>
        <?php endforeach; ?>

        <!-- Menampilkan artikel dari $articles_bisnis yang sudah diurutkan -->
        <?php foreach ($top_3_bisnis_articles as $row): ?>
            <div>
                <img src="<?= $row["urlToImage"]; ?>">
                <p class="satunew"><?= $row["title"]; ?></p>
                <p class="empatnew"><?= $row["category"]; ?></p><hr>
                <p class="duanew"><a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>">Read More >></a></p>
            </div>
        <?php endforeach; ?>
         <!-- Pemanggilan 2 Berita Popular Teknologi dan Bisnis Selesai -->
        </div>

    </div>
    <!---popular selesai-->

    <!-- Semua Berita -->
    <!---- all -->
    <div class="all container">
        <div class="title">All News <span class="view-all"><a href="7all.php">View All</a></span></div>
        <h3 class="subtitle">All the news is here</h3>
        <div class="articles-cards2 transition-item">

            <!-- Pemanggilan seluruh berita -->
            <?php
            $top_6_articles = array_slice($all_articles, 0, 6);
            ?>

            <?php foreach ($top_6_articles as $row): ?>
                <div>
                    <img src="<?= $row["urlToImage"]; ?>">
                    <div>
                        <h4 class="name"><?= $row["title"]; ?></h4><br>
                        <h5>
                            <span><?= $row["description"]; ?></span>
                        </h5><br><hr>
                        <p>
                            <a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>">Read More >></a>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Pemanggilan seluruh berita selesai -->

        </div>
    </div>
    <!---- all selesai-->

    <!-- Pertanyaan (FAQ) -->
    <!---question-->
    <div class="question">
        <div>
            <img src="https://assets.pharmeasy.in/apothecary/images/rx_upload.svg?dim=1024x0" alt="">
            <div>
                <h3>Question space</h3>
                <p>If you have any questions, please connect with customer service on the button below</p>
                <button>
                    <i class="fa-solid fa-paperclip"></i>
                    Start to Ask
                </button>
            </div>
        </div>
        <div>
            <h4>How does this works ?</h4>
            <div>
                <div>
                    <h3>1</h3>
                    <p>Upload you question to the form</p>
                </div>
                <div>
                    <h3>2</h3>
                    <p>Wait for customer service to contact you within 5 minutes</p>
                </div>
                <div>
                    <h3>3</h3>
                    <p>It's permissible to call customer service</p>
                </div>
                <div>
                    <h3>4</h3>
                    <p>Get the answers you want!</p>
                </div>
            </div>
        </div>
    </div>
    <!---question selesai-->

    <!-- Berita Terbaru -->
    <!---latest-->
    <div class="latest container">
        <div class="title">Latest News <span class="view-all"><a href="8terbaru.php">View All</a></div>
        <div class="subtitle">The latest news for you!</div>
        <div class="latest-cards transition-item">

            <!-- Pemanggilan seluruh berita -->
             <?php
             $top_10_articles = array_slice($all_articles, 0, 10);
             ?>

             <?php foreach ($top_10_articles as $row): ?>
                <div>
                    <img src="<?= $row["urlToImage"]; ?>">
                    <div>
                        <h4 class="name"><?= $row["title"]; ?></h4>
                        <h5>
                            <span><?= formatDate ($row["publishedAt"]); ?></span>
                        </h5><br>
                        <p class="empatnew"><?= $row["category"]; ?></p><br>
                        <hr><br>
                        <p>
                            <a href="6detail.php?article_title=<?= urlencode($row["title"]); ?>">Read More >></a>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
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
    <!---latest selesai-->

    <!-- Banner Terakhir -->
    <!---member-->
    <div class="member">
        <div>
            <h2>Become a <span><i class="fa-solid fa-plus"></i> J.member</span> B.News</h2>
            <p>And enjoy the experience of being an copywriting</p>
            <hr>
        </div>
        <div>
            <p>Earn hundreds of rupiah by writing articles anywhere!</p>
            <button>Log In Now <i class="fa-solid fa-angle-right"></i></button>
        </div>
        <div>
            <img src="https://assets.pharmeasy.in/apothecary/_next/static/media/PlusFamily.22677720.png?dim=1024x0" alt="">
        </div>
    </div>
    <!---member selesai-->

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
    <script src="news.js"></script>

</body>

</html>