<!DOCTYPE html>
<html lang="zh-Hant">

<head>
<?= $this->include("backend/include/head") ?>
</head>

<body class="yuan_backend">
    <!-- =========================================================================-->
    <!-- 頁面內容  START-->
    <!-- =========================================================================-->
    <main class="page_main page-login" id="loginApp">
        <div class="bg" style="background-image: url(<?= img_url('banner-bg.jpg') ?>);"></div>
        <div class="container">
            <div class="login-logo">
                <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
            </div>
            <div class="yuan_panel login_panel">
                <div class="yuan_panel-hd"> 登入後台管理 </div>
                <div class="yuan_panel-bd">
                    <form class="yuan_frm login_frm" @submit.prevent="login($event)" data-baseurl="<?= base_url() ?>">
                        <div class="yuan_frm-bd">
                            <section class="form-group row">
                                <div class="col-12">
                                    <input-field label="帳號" id="user_id" v-model="user_id" :isrequired="1" placeholder="請輸入帳號" :error="fieldErrors.user_id"></input-field>
                                </div>
                            </section>
                            <section class="form-group row">
                                <div class="col-12">
                                    <password-field label="密碼" id="user_pw" v-model="user_pw" :isrequired="1" placeholder="請輸入密碼" :error="fieldErrors.user_pw"></password-field>
                                </div>
                            </section>
                            <div class="frm-error txt-danger text-center" v-if="frmError">{{ frmError }}</div> <!-- 顯示錯誤消息 -->
                        </div>
                        <div class="yuan_frm-ft">
                            <submit-btn default_txt="登入" sending_txt="登入中..." :isdisabled="isdisabled"></submit-btn>
                        </div>
        
                    </form>
                </div>
            </div>
        </div>

    </main>
    <?php
    // var_dump(password_hash("demo", PASSWORD_DEFAULT));
    ?>

    <!-- /.page_main END  !! -->
    <!-- =========================================================================-->
    <!-- 頁面內容  END  !!-->
    <!-- =========================================================================-->

    <script type="text/javascript" src="https://unpkg.com/external-svg-loader@latest/svg-loader.min.js" async></script>
    <!-- <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/zh-tw.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <!-- <script src="https://validatejs.org/validate.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.2/echarts.js"></script> -->
    <!-- script -->
    <script src="<?= js_url('script.js?v=' . WEB_VERSION) ?>"></script>
    <script type="module" src="<?= js_url('backend/login.js?v=' . WEB_VERSION) ?>"></script>
    
</body>

</html>