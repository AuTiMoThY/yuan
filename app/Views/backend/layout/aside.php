<aside class="admin_aside" id="adminAside">
    <div class="admin_aside-hd">
        <div class="logo">
            <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
        </div>
    </div>
    <ul class="admin_aside-list">
        <li class="admin_aside-item">
            <a href="<?= base_url() ?>" target="_blank">
                <span class="icon"><i class="fa-solid fa-house"></i></span>
                <span class="txt">前台頁面</span>
                <div class="new_window_icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
            </a>
        </li>
        <li :class="['admin_aside-item', {'js-active': getType == 'home-appliances'}]">
            <a href="<?= base_url('yuanadmin/form-datatable/home-appliances') ?>">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <span class="txt">精品家電問卷</span>
            </a>
        </li>
        <li :class="['admin_aside-item', {'js-active': getType == 'group-buying'}]">
            <a href="<?= base_url('yuanadmin/form-datatable/group-buying') ?>">
                <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                <span class="txt">新建案團購主</span>
            </a>
        </li>
    </ul>
    <div class="admin_aside-ft">
        <a href="/yuanadmin/logout" class="yuan_btn">登出</a>
    </div>
</aside>