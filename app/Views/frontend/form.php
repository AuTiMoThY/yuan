<?= $this->extend("frontend/layout/main") ?>


<?= $this->section("content") ?>

<!-- =========================================================================-->
<!-- 頁面內容  START-->
<!-- =========================================================================-->
<main class="page_main page-form" id="formApp">
    <div class="logo-container container">
        <a class="logo" href="/">
            <img src="<?= img_url('yuan-logo-w.png') ?>" alt="">
        </a>
    </div>
    <section class="page_heading">
        <div class="container">
            <h1 class="title font-h1">貴賓您好</h1>
            <p class="txt font-body">我們一起用30秒的時間，瞭解一下您的需求</p>
            <div class="steps">
                <div v-for="step in 4" :key="step" :class="['step', {'active': currentStage == step}]" @click="currentStage = step"></div>
            </div>
        </div>
    </section>
    <form class="form_wrap" @submit.prevent="submitForm($event)" data-formtype="<?= $form_type ?>" data-baseurl="<?= base_url() ?>">
        <section class="form_stage stage1" v-show="currentStage === 1">
            <div class="container">
                <p class="stage_title">Stage 1｜基本資料</p>
                <ul class="form_stage-inner">
                    <li class="question q1">
                        <div class="question-hd">
                            <div class="label">Question 1</div>
                            <div class="title">家電購買的緣由是？</div>
                        </div>
                        <div class="question-bd row-3-parts">
                            <question-item v-for="(item, index) in questions.q1.items" :key="'q1-' + index" :item-key="'q1'" :type="questions.q1.type" :item="item" :index="index" v-model="answers.q1"></question-item>
                        </div>
                    </li>

                    <li class="question q2">
                        <div class="question-hd">
                            <div class="label">Question 2</div>
                            <div class="title">使用地點在哪個區域呢？</div>
                        </div>
                        <div class="question-bd row-2-parts">
                            <question-item v-for="(item, index) in questions.q2.items" :key="'q2-' + index" :item-key="'q2'" :type="questions.q2.type" :item="item" :index="index" v-model="answers.q2"></question-item>
                        </div>
                    </li>

                    <li class="question q3">
                        <div class="question-hd">
                            <div class="label">Question 3</div>
                            <div class="title">建築物有配置電梯嗎？</div>
                        </div>
                        <div class="question-bd row-2-parts">
                            <question-item v-for="(item, index) in questions.q3.items" :key="'q3-' + index" :item-key="'q3'" :type="questions.q3.type" :item="item" :index="index" v-model="answers.q3"></question-item>
                        </div>
                    </li>

                    <li class="question q4">
                        <div class="question-hd">
                            <div class="label">Question 4</div>
                            <div class="title">預計常態使用人數幾位呢？</div>
                        </div>
                        <div class="question-bd row-3-parts">
                            <question-item v-for="(item, index) in questions.q4.items" :key="'q4-' + index" :item-key="'q4'" :type="questions.q4.type" :item="item" :index="index" v-model="answers.q4[index]"></question-item>
                        </div>
                    </li>

                    <li class="question q5">
                        <div class="question-hd">
                            <div class="label">Question 5</div>
                            <div class="title">家中是否有寵物呢？</div>
                        </div>
                        <div class="question-bd row-3-parts">
                            <question-item v-for="(item, index) in questions.q5.items" :key="'q5-' + index" :item-key="'q5'" :type="questions.q5.type" :item="item" :index="index" v-model="answers.q5"></question-item>
                        </div>
                    </li>
                </ul>
                <button type="button" class="link go_next_stage" @click="goToNextStage">
                    <span class="link-txt">下一頁</span>
                    <svg data-src="<?= img_url('link-arrow.svg') ?>"></svg>
                </button>
            </div>
        </section>
        <section class="form_stage stage2" v-show="currentStage === 2">
            <div class="container">
                <p class="stage_title">Stage 2｜家居設計需求</p>
                <ul class="form_stage-inner">
                    <li class="question q6">
                        <div class="question-hd">
                            <div class="label">Question 6</div>
                            <div class="title">哪個家中區域是您最注重的呢？</div>
                        </div>
                        <div class="question-bd row-2-parts">
                            <question-item v-for="(item, index) in questions.q6.items" :key="'q6-' + index" :item-key="'q6'" :type="questions.q6.type" :item="item" :index="index" v-model="answers.q6"></question-item>
                        </div>
                    </li>
                </ul>
                <button type="button" class="link go_next_stage" @click="goToNextStage">
                    <span class="link-txt">下一頁</span>
                    <svg data-src="<?= img_url('link-arrow.svg') ?>"></svg>
                </button>
            </div>
        </section>
        <section class="form_stage stage3" v-show="currentStage === 3">
            <div class="container">
                <p class="stage_title">Stage 2｜家居設計需求</p>
                <ul class="form_stage-inner">
                    <li class="question q7">
                        <div class="question-hd">
                            <div class="label">Question 7</div>
                            <div class="title">您期望獲得哪一種的生活場景？</div>
                        </div>
                        <div class="question-bd row-2-parts">
                            <question-item v-for="(item, index) in questions.q7.items" :key="'q7-' + index" :item-key="'q7'" :type="questions.q7.type" :item="item" :index="index" v-model="answers.q7"></question-item>
                        </div>
                    </li>
                </ul>
                <button type="button" class="link go_next_stage" @click="goToNextStage">
                    <span class="link-txt">下一頁</span>
                    <svg data-src="<?= img_url('link-arrow.svg') ?>"></svg>
                </button>
            </div>
        </section>
        <section class="form_stage stage4" v-show="currentStage === 4">
            <div class="container">
                <p class="stage_title">Stage 3｜執行預算</p>
                <ul class="form_stage-inner">
                    <li class="question q8">
                        <div class="question-hd">
                            <div class="label">Question 8</div>
                            <div class="title">您預計投入多少資金打造夢想中的生活場景呢？</div>
                        </div>
                        <div class="question-bd" :class="'row-part-' + questions.q8.type">
                            <div class="range-wrap">
                                <div class="range-bar"></div>
                                <!-- <question-item v-for="(item, index) in questions.q8.items" :key="'q8-' + index" :item-key="'q8'" :type="questions.q8.type" :item="item" :index="index" v-model="answers.q8"></question-item> -->
                                <input type="range" class="form_input--range" min="1" max="4" step="1" v-model="answers.q8" @input="handleRange"/>
                                <span class="range-bubble"></span>
                                <div class="range-label">
                                    <div class="range-item" v-for="item in questions.q8.items" :key="item.label">
                                        <div class="txt">{{item.label}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="question q9">
                        <div class="question-hd">
                            <div class="label">Question 9</div>
                            <div class="title">我們會在2日內與您聯繫，您準備好了嗎？</div>
                        </div>
                        <div class="question-bd row-2-parts">
                            <question-item v-for="(item, index) in questions.q9.items" :key="'q9-' + index" :item-key="'q9'" :type="questions.q9.type" :item="item" :index="index" v-model="answers.q9"></question-item>
                        </div>
                    </li>
                    <li class="question q10">
                        <div class="question-hd">
                            <div class="label">Question 10</div>
                            <div class="title">如果您已經準備好了，請留下資料，讓我們聯繫您</div>
                        </div>
                        <div class="question-bd" :class="'row-part-' + questions.q10.type">
                            <question-item v-for="(item, index) in questions.q10.items" :key="'q10-' + index" :item-key="'q10'" :type="questions.q10.type" :item="item" :index="index" v-model="answers.q10[index]"></question-item>
                        </div>
                    </li>
                </ul>
                <button type="submit" class="link send" :disabled="isdisabled">
                    <span class="link-txt">{{isdisabled ? '送出中...' : '送出'}}</span>
                    <svg data-src="<?= img_url('link-arrow.svg') ?>"></svg>
                </button>
                <div class="frm-error txt-danger text-center" v-if="frmError" v-html="frmError"></div>
            </div>
        </section>
    </form>
</main>

<!-- /.page_main END  !! -->
<!-- =========================================================================-->
<!-- 頁面內容  END  !!-->
<!-- =========================================================================-->
<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<script type="module" src="<?= js_url('form.js?v=' . WEB_VERSION) ?>"></script>

<?= $this->endSection() ?>