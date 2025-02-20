<?= $this->extend("frontend/layout/main") ?>


<?= $this->section("content") ?>

<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->
<main class="page_main page-send-success">
    <div class="logo-container container">
        <a class="logo" href="/">
            <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
        </a>
    </div>
    <section class="banner">
        <div class="container">
            <hgroup>
                <h1 class="slogan font-h1">元式生活</h1>
                <h2 class="subslogan font-h2">結合豪宅家電服務經驗與盤商背景</h2>
            </hgroup>
            <p class="txt font-body">
                問卷答復已經送出<br>
                請靜待我們的聯繫<br>
                謝謝
            </p>
        </div>
    </section>

</main>

<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>