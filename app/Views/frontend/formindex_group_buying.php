<?= $this->extend("frontend/layout/main") ?>


<?= $this->section("content") ?>

<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->
<main class="page_main page-intro">
    <section class="intro <?= $page_class ?>">
        <div class="container">
            <a class="logo" href="./">
                <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
            </a>
            <h1 class="page_title font-h1">新建案團購主招募</h1>
            <p class="txt font-body">
                第一次買房子的你，從挑選房子、準備頭期款、驗屋、找設計公司，許多的第一次跟不確定，我們都懂!
                <br><br>針對家電的挑選，我們樂於協助首購族，用團購的方式，購入實惠的家電，簡單、高CP值、不踩雷，團購主能夠獲得更多的折扣，你準備好了嗎?
            </p>
            <a href="/group-buying-form" class="link ">
                <span class="link-txt">填寫問卷</span>
                <span class="link-icon">
                    <span class="icon"></span>
                </span>
            </a>
        </div>
    </section>
    <div class="video">
        <img src="<?= img_url('form1-intro-video.jpg') ?>" alt="" class="video-img">
    </div>
</main>

<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>