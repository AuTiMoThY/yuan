<?= $this->extend("backend/layout/main") ?>

<?= $this->section("page_head") ?>
<script>
    const baseUrl = '<?= base_url() ?>';
    const formType = '<?= $form_type ?>';
</script>
<?= $this->endSection() ?>
<?= $this->section("content") ?>

<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->
<main class="page_main page-dashboard">
    <h2 class="page_title"><?= $page_title ?></h2>

</main>

<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?> 