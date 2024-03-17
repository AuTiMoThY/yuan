<!-- <?= WEB_VERSION ?> -->
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <?= $this->include("backend/include/head") ?>
    <?= $this->renderSection("page_head") ?>
</head>

<body id="app" class="yuan_admin">
    <!-- ========================================================================= -->
    <!-- .body_wrap  START-->
    <div class="body_wrap">

        <!-- aside START -->
        <?= $this->include("backend/layout/aside") ?>
        <!-- /aside END  !! -->
        
        <?= $this->renderSection("content") ?>
        <!-- footer START -->
        <?= $this->include("backend/layout/footer") ?>
        <!-- /footer END  !! -->
    </div>
    <!-- /.body_wrap  END  !!-->
    <!-- =========================================================================-->

    <script type="text/javascript" src="https://unpkg.com/external-svg-loader@latest/svg-loader.min.js" async></script>
    <!-- <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/zh-tw.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <!-- <script src="https://validatejs.org/validate.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.2/echarts.js"></script> -->
    <!-- script -->
    <script src="<?= js_url('script.js?v=' . WEB_VERSION) ?>"></script>
    <script src="<?= js_url('backend/admin.js?v=' . WEB_VERSION) ?>"></script>
    <?= $this->renderSection("page_script") ?>
</body>

</html>