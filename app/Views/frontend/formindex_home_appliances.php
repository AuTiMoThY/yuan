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
            <h1 class="page_title">精品家電顧問服務</h1>
            <p class="txt">
                高顏質電視、日製冰箱、德國洗碗機到丹麥紅酒櫃，為居家空間注入品味、質感與獨特性<br>
                <br>
                我們提供專屬的個人顧問服務
            </p>
            <div class="txt2">
                <div class="txt2-inner">
                    節省您的時間<br>
                    <span class="txt-sub-color">✓</span> 不必逛百貨公司<br>
                    <span class="txt-sub-color">✓</span> 省去上網做功課的時間
                </div>
            </div>
            <a href="home-appliances-form" class="link ">
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
<script type="module" src="<?= js_url('formindex.js?v=' . WEB_VERSION) ?>"></script>
<?= $this->endSection() ?>