<?= $this->extend("frontend/layout/main") ?>


<?= $this->section("content") ?>

<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->

<main class="page_main page-home">
    <div class="logo-container container">
        <a class="logo" href="/">
            <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
        </a>
    </div>
    <section class="banner">
        <div class="container">

            <hgroup>
                <h1 class="slogan font-h1">元式生活</h1>
                <h2 class="subslogan font-h2">結合盤商經驗，提供優質豪宅家電服務</h2>
            </hgroup>
            <p class="txt font-body">
                用專業省下你的每分每秒<br>
                用家電打造你的夢想生活<br>
                把一切交給元式，而你，只需負責享受生活
            </p>
        </div>
    </section>
    <section class="form_entrance">
        <a href="/home-appliances" class="entrance hover_effect" style="background-image: url(<?= img_url('form-entrance-1-bg.jpg') ?>);">
            <div class="entrance-txt">
                <div class="entrance-txt-inner">
                    <h3 class="title">精品家電顧問服務</h3>
                    <p class="txt">適合 已有購屋經驗者</p>
                </div>
                <div class="entrance-arrow"></div>
            </div>
        </a>
        <a href="/group-buying" class="entrance hover_effect" style="background-image: url(<?= img_url('form-entrance-2-bg.jpg') ?>);">
            <div class="entrance-txt">
                <div class="entrance-txt-inner">
                    <h3 class="title">新建案團購主招募</h3>
                    <p class="txt">適合 首購族</p>
                </div>
                <div class="entrance-arrow"></div>
            </div>
        </a>
    </section>
</main>

<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>