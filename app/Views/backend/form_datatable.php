<?= $this->extend("backend/layout/main") ?>


<?= $this->section("page_head") ?>
<script>
    const baseUrl = '<?= base_url() ?>';
    const formType = '<?= $form_type ?>';
    const statusOptions_json = <?= json_encode($status_options) ?>;
    console.log("statusOptions_json", statusOptions_json);
</script>
<?= $this->endSection() ?>
<?= $this->section("content") ?>
<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->
<main class="page_main page-form" id="datatable">
    <h2 class="page_title"><?= $page_title ?></h2>
    <div class="tool_bar">
        <div class="tool">
            <div class="tool-title">匯出</div>
            <div class="tool-ctrl">
                <yuan-select :options="exportDateRangeOptions" v-model="exportDateRange"></yuan-select>
                <button class="yuan_btn yuan_btn-s yuan_btn-main-color" @click="exportCsv">
                    <div class="icon"> <i class="fa-solid fa-download"></i> </div>
                    <div class="txt">匯出CSV</div>
                </button>
            </div>
        </div>
        <div class="tool">
            <div class="tool-title">查詢</div>
            <div class="tool-ctrl">
                <date-picker v-model="filterDate" range :format="filterDateFormat" :enable-time-picker="false" placeholder="選擇日期"></date-picker>
                <yuan-select :options="filterStatusOptions" :model-value="filterStatus"  @update:model-value="filterStatus = $event"></yuan-select>
                <button class="yuan_btn yuan_btn-s yuan_btn-main-color" @click="sendFilter">
                    <div class="icon"> <i class="fa-solid fa-magnifying-glass"></i> </div>
                    <div class="txt">查詢</div>
                </button>
                <button class="yuan_btn yuan_btn-s yuan_btn-danger" @click="clearFilters" v-if="showClearFilters">
                    <div class="icon"> <i class="fa-solid fa-xmark"></i> </div>
                    <div class="txt">清除查詢</div>
                </button>
            </div>
        </div>
    </div>
    <div class="yuan_panel yuan_panel-nobg">

        <div class="yuan_panel-bd">
            <table class="datatable">
                <tr>
                    <th class="datatable-heading no">編號</th>
                    <th class="datatable-heading name">姓名</th>
                    <th class="datatable-heading phone">連絡電話</th>
                    <th class="datatable-heading no_contact">不方便聯絡時間</th>
                    <th class="datatable-heading budget sortable" @click="updateSorting('budget')">
                        預算
                        <i :class="['fa-solid', sortIconClass('budget')]"></i>
                    </th>
                    <th class="datatable-heading location sortable" @click="updateSorting('location')">
                        使用地點
                        <i :class="['fa-solid', sortIconClass('location')]"></i>
                    </th>

                    <th class="datatable-heading date">日期</th>
                    <th class="datatable-heading status">狀態</th>
                    <th class="datatable-heading action">操作</th>
                </tr>
                <tr v-for="(item, index) in data" :key="index">
                    <td class="datatable-cell no" data-rel="編號">{{index + 1}}</td>
                    <td class="datatable-cell name" data-rel="姓名">{{item.u_name}}</td>
                    <td class="datatable-cell phone" data-rel="連絡電話">{{item.u_phone}}</td>
                    <td class="datatable-cell no_contact" data-rel="不方便聯絡時間">{{item.no_contact}}</td>
                    <td class="datatable-cell budget" data-rel="預算">{{item.u_budget}}</td>
                    <td class="datatable-cell location" data-rel="使用地點">{{item.u_location}}</td>
                    <td class="datatable-cell date" data-rel="日期">{{item.created_at}}</td>
                    <td class="datatable-cell status" data-rel="狀態">
                        <yuan-select :specialclass="selectClass(item.status)" :options="datatableStatusOptions" :model-value="item.status" @update:model-value="newValue => updateStatus(newValue, item)"></yuan-select>
                    </td>
                    <td class="datatable-cell action" data-rel="操作">
                        <button type="button" class="yuan_btn yuan_btn-s" @click="openDetail(item.id)">查看</button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="yuan_panel-ft" v-if="data">
            <div class="datatable-info">共{{totalDataNumber}}筆資料</div>
            <? //= $pager 
            ?>
            <div class="pagination">
                <button v-for="page in totalPages" :key="page" :class="['pagination-btn', { active: page === currentPage }]" @click="changePage(page)">
                    {{ page }}
                </button>
            </div>
        </div>
    </div>
    <div v-if="showPopup" class="popup">
        <div class="popup-block">
            <div class="popup-hd">問卷明細</div>
            <div class="popup-bd">
                <div id="questionDetails">
                    <div class="question-container" v-for="(question, key) in questions" :key="key">
                        <div class="question-title">
                            <span class="txt">{{ formatQuestionKey(key) + '.' + question.title }}</span>
                        </div>
                        <div class="question-value">{{formatQuestionValue(question.value)}}</div>
                    </div>
                </div>
            </div>
            <button @click="showPopup = false" class="popup-close"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="notification" v-if="showNotification">
        <div class="notification-block">
            <div class="notification-icon">
                <svg data-src="<?= img_url('check_circle.svg') ?>"></svg>
            </div>
            <div class="notification-txt">{{notificationTxt}}</div>
        </div>
    </div>
</main>
<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<script type="module" src="<?= js_url('backend/form_datatable.js?v=' . WEB_VERSION) ?>"></script>
<?= $this->endSection() ?>