import { questionItem, submitForm } from './vue-components.js';
const { ref, createApp, watch } = Vue;

gsap.registerPlugin(ScrollToPlugin);

const formApp = {
    components: {
        'question-item': questionItem,
        'submit-btn': submitForm
    },

    setup() {
        const isdisabled = ref(false);
        const currentStage = ref(1);

        const answers = ref({
            q1: '',
            q2: '',
            q3: '',
            q4: ['0', '0', '0'],
            q5: [],
            q6: [],
            q7: [],
            q8: '1',
            q9: '',
            q10: ['', '', '']
        });

        const people_numbers = Array.from({ length: 11 }, (_, i) => i);
        const questions = ref({
            q1: {
                title: '家電購買的緣由是？',
                type: 'radio-icon',
                items: [
                    { label: '首購族', icon: 'assets/images/q1-icon-1.png', iconHover: 'assets/images/q1-icon-1-hover.png', },
                    { label: '換屋族', icon: 'assets/images/q1-icon-2.png', iconHover: 'assets/images/q1-icon-2-hover.png', },
                    { label: '商業空間', icon: 'assets/images/q1-icon-3.png', iconHover: 'assets/images/q1-icon-3-hover.png', }
                ]
            },
            q2: {
                title: '使用地點在哪個區域呢？',
                type: 'radio',
                items: [
                    { label: '雙北' },
                    { label: '台南' },
                    { label: '桃竹' },
                    { label: '高雄' },
                    { label: '台中' },
                    { label: '其他' },
                ]
            },
            q3: {
                title: '建築物有配置電梯嗎？',
                type: 'radio',
                items: [
                    { label: '有' },
                    { label: '無' },
                ]
            },
            q4: {
                title: '預計常態使用人數幾位呢？',
                type: 'select',
                items: [
                    { label: '長者人數', options: people_numbers },
                    { label: '成人人數', options: people_numbers },
                    { label: '兒童人數', options: people_numbers },
                ]
            },
            q5: {
                title: '家中是否有寵物呢？',
                type: 'checkbox-icon',
                items: [
                    { label: '貓咪', icon: 'assets/images/q5-icon-1.png', iconHover: 'assets/images/q5-icon-1-hover.png', },
                    { label: '狗狗', icon: 'assets/images/q5-icon-2.png', iconHover: 'assets/images/q5-icon-2-hover.png', },
                    { label: '其他', icon: 'assets/images/q5-icon-3.png', iconHover: 'assets/images/q5-icon-3-hover.png', },
                ]
            },
            q6: {
                title: '哪個家中區域是您最注重的呢？',
                type: 'checkbox-image',
                items: [
                    { label: '客廳', image: 'assets/images/q6-image-1.png' },
                    { label: '餐廳', image: 'assets/images/q6-image-2.png' },
                    { label: '臥房', image: 'assets/images/q6-image-3.png' },
                    { label: '洗衣間', image: 'assets/images/q6-image-4.png' },
                    { label: '書房', image: 'assets/images/q6-image-5.png' },
                    { label: '品酒區', image: 'assets/images/q6-image-6.png' },
                ]
            },
            q7: {
                title: '您期望獲得哪一種的生活場景？',
                type: 'checkbox-image',
                items: [
                    { label: '影音娛樂饗宴', image: 'assets/images/q7-image-1.png' },
                    { label: '美好料理空間', image: 'assets/images/q7-image-2.png' },
                    { label: '解放雙手曬衣體驗', image: 'assets/images/q7-image-3.png' },
                    { label: '安全舒適的純淨臥房', image: 'assets/images/q7-image-4.png' },
                    { label: '可以獨處的雅居', image: 'assets/images/q7-image-5.png' },
                    { label: '優雅聚會場所', image: 'assets/images/q7-image-6.png' },
                ]
            },
            q8: {
                title: '您預計投入多少資金打造夢想中的生活場景呢？',
                type: 'range',
                items: [
                    { label: '20萬以內' },
                    { label: '20-40萬' },
                    { label: '40-80萬' },
                    { label: '80萬以上' },
                ]
            },
            q9: {
                title: '我們會在2日內與您聯繫，您準備好了嗎？',
                type: 'radio',
                items: [
                    { label: '準備好了，請與我聯繫!' },
                    { label: '沒關係，讓我再想想🙏' },
                ]
            },
            q10: {
                title: '如果您已經準備好了，請留下資料，讓我們聯繫您',
                type: 'text',
                items: [
                    { label: '手機*', rowPart: "2", type: "text" },
                    { label: '姓名*', rowPart: "2", type: "text" },
                    { label: '不方便聯繫的時間', rowPart: "1", type: "radio", subitem: ['上午', '下午', '晚上'] },
                ]
            },

        });

        const frmError = ref('');

        watch(answers, (newValues, oldValues) => {
            console.log('newValues:', newValues);
        });

        const goToNextStage = () => {
            gsap.to(window, {
                scrollTo: 0,
                duration: 0.3,
                ease: "none",
                onComplete: () => {
                    // 滚动完成后的回调函数
                    if (currentStage.value < 4) {
                        currentStage.value++; // 更新 currentStage 的值
                    }
                }
            });
        };



        const submitForm = (e) => {
            const formElement = e.target;
            const form_type = formElement.getAttribute('data-formtype');
            const baseUrl = formElement.getAttribute('data-baseurl');
            isdisabled.value = true;

            const answersData = answers.value;

            // 表單驗證
            if (!validateForm(answersData)) {
                // alert('');
                isdisabled.value = false;
                return;
            }

            // 收集表单数据
            const formData = {
                type: form_type,
                name: answersData.q10[1],
                phone: answersData.q10[0],
                u_budget: questions.value.q8.items[answersData.q8 - 1],
                u_location: answersData.q2,
                q1: {
                    title: '家電購買的緣由是？',
                    value: answersData.q1
                },
                q2: {
                    title: '使用地點在哪個區域呢？',
                    value: answersData.q2
                },
                q3: {
                    title: '建築物有配置電梯嗎？',
                    value: answersData.q3
                },
                q4: {
                    title: '預計常態使用人數幾位呢？',
                    value: `長者人數: ${answersData.q4[0]}, 成人人數: ${answersData.q4[1]}, 兒童人數: ${answersData.q4[2]}`
                },
                q5: {
                    title: '家中是否有寵物呢？',
                    value: answersData.q5
                },
                q6: {
                    title: '哪個家中區域是您最注重的呢？',
                    value: answersData.q6
                },
                q7: {
                    title: '您期望獲得哪一種的生活場景？',
                    value: answersData.q7
                },
                q8: {
                    title: '您預計投入多少資金打造夢想中的生活場景呢？',
                    value: questions.value.q8.items[answersData.q8 - 1].label
                },
                q9: {
                    title: '我們會在2日內與您聯繫，您準備好了嗎？',
                    value: answersData.q9.replace("🙏", "")
                },
                q10: {
                    title: '如果您已經準備好了，請留下資料，讓我們聯繫您',
                    value: `手機: ${answersData.q10[0]}, 姓名: ${answersData.q10[1]}, 不方便聯繫的時間: ${answersData.q10[2]}`
                },
            };

            yuanUI.log(answersData.q9);
            yuanUI.log(answersData.q9.replace("🙏", ""));
            yuanUI.log("formData", formData);

            // 发送数据到服务器
            sendDataToServer(formData, baseUrl);
        };

        const validateForm = (data) => {
            // 验证逻辑
            // 返回 true 如果表单通过验证，否则返回 false

            if (data.q10[0] == '') {
                alert("請填寫手機號碼");
                return false;
            }
            if (data.q10[1] == '') {
                alert("請填寫姓名");
                return false;
            }
            return true;
        };

        const sendDataToServer = async (formData, baseUrl) => {
            // 使用 fetch, axios 或其他方法发送数据
            console.log('formData:', formData);

            try {

                await axios.post(baseUrl + "submit-form", formData, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        // 请求成功，处理响应数据

                        if (response.data.status == "success") {
                            window.location.href = `${baseUrl}send-success`;
                        }
                    })
                    .catch(error => {
                        // 请求失败，处理错误
                        console.error('请求失败:', error);
                        // 这里可以进一步检查 error 对象，例如 error.response 来获取服务器响应的详细信息
                        if (error.response) {
                            // 服务器返回了错误状态码以外的响应
                            console.log('错误状态码:', error.response.status);
                            console.log('错误信息:', error.response.data);
                        } else if (error.request) {
                            // 请求已经发出，但没有收到响应
                            console.log('没有响应:', error.request);
                        } else {
                            // 发送请求时出现了某些问题，导致请求未能发出
                            console.log('请求错误:', error.message);
                        }
                    });

                // yuanUI.log('api_response: ', api_response);
                // alert(JSON.stringify(api_response));

                // if (api_response.data.status == "success") {
                //     window.location.href = `${baseUrl}send-success`;
                // }

            } catch (error) {
                console.error('Login failed', error);
                console.error('error: ', error.request.responseText);
                isdisabled.value = false;
                // frmError.value = '帳號或密碼輸入錯誤';

                frmError.value = error.request.responseText;
                alert("catch error");
                alert(error.request.responseText);
            }

        };


        const handleRange = () => {
            yuanUI.log('q8', answers.value.q8);
            const rangeWrap = document.querySelector('.range-wrap');
            const rangeInput = rangeWrap.children[1];
            const rangeBubble = rangeWrap.children[2];
            const thumbWidth = 24;


            positionBubble(rangeBubble, rangeInput)

            function positionBubble(bubbleElement, anchorElement) {
                const {
                    min,
                    max,
                    value,
                    offsetWidth
                } = anchorElement;

                const total = Number(max) - Number(min);

                const perc = (Number(value) - Number(min)) / total;

                const thumbPosition = perc * offsetWidth;
                const thumbCenter = thumbPosition - (thumbWidth / 2);
                bubbleElement.style.left = `${thumbCenter}px`;
            }

            // rangeInput.addEventListener('input', (e) => positionBubble(rangeBubble, e.target))
        }


        return {
            isdisabled, frmError,
            currentStage, goToNextStage, questions, answers,
            handleRange,
            submitForm
        };
    }
}

const form = createApp(formApp);
form.mount("#formApp");
