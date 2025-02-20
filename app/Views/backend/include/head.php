<title><?= esc($page_title) ?> | 元式生活後台介面</title>

<meta http-equiv="Cache-Control" content="no-store" />

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#102543">
<meta name="apple-mobile-web-app-status-bar-style" content="#102543">
<?= $this->include("frontend/include/favicon") ?>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="robots" content="index,follow">
<meta name="viewport" content="width=device-width, user-scalable=no">
<!-- 讓手機不判斷它是電話號碼變顏色-->
<meta name="format-detection" content="telephone=no">

<!-- google font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<!-- <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/flatpickr.min.css"> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

<?= link_tag(css_url("backend.css?v=" . WEB_VERSION)) ?>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<link rel="stylesheet" href="https://unpkg.com/@vuepic/vue-datepicker@latest/dist/main.css">
<script src="https://unpkg.com/@vuepic/vue-datepicker@latest"></script>
<script src="https://unpkg.com/vue-router@4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
