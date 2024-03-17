const { ref, createApp, onMounted } = Vue;
import { YuanSelect } from '../vue-components.js';
import { useNotification, useApi, useSorting } from '../vue-composable.js';
// import { router } from './router.js';


const datatableSetup = {
    components: {
        'yuan-select': YuanSelect
    },
    setup() {

        const showPopup = ref(false);
        const detailData = ref([]);
        const questions = ref([]);

        const { showNotification, notificationTxt, showNoti, closeNoti } = useNotification();

        const selectClass = (status) => {
            if (status == "1") {
                return "status-done";
            }
            else if (status == "2") {
                return "status-close";
            }
            else {
                return "";
            }
        }

        const filterDate = ref('');
        const filterStatus = ref('');
        const updatedStatusOptions = statusOptions_json.map(option => {
            return {
                value: option.value,  // 保留原始的 'value' 鍵
                label: option.text    // 將 'text' 鍵轉換為 'label'
            };
        });
        // yuanUI.log("updatedStatusOptions", updatedStatusOptions);
        const updatedStatusOptions2 = [{ "label": "請選擇狀態", "value": "" }, ...updatedStatusOptions];
        // yuanUI.log("updatedStatusOptions2", updatedStatusOptions2);
        const filterStatusOptions = ref(updatedStatusOptions2);
        // yuanUI.log("filterStatusOptions", filterStatusOptions);
        const showClearFilters = ref(false);

        const exportDateRange = ref('');
        const exportDateRangeOptions = ref([
            { "label": "請選擇日期區間", "value": "" },
            { "label": "全部", "value": "all" },
        ]);





        // const queryParams = ref(new URLSearchParams(window.location.search));

        const { data, loading, error, fetchData } = useApi();
        // const datatableData = ref([]);
        onMounted(async () => {
            // 解析 URL 查詢參數
            const queryParams = new URLSearchParams(window.location.search);
            const startDate = queryParams.get('startDate');
            const endDate = queryParams.get('endDate');
            const status = queryParams.get('status');
            const sort = queryParams.get('sort');
            const order = queryParams.get('order');

            // 根據查詢參數初始化 Vue ref
            if (startDate && endDate) {
                filterDate.value = [startDate, endDate];
            }
            if (status) {
                filterStatus.value = status;
            }

            if (startDate !== null || endDate !== null || status !== null) {
                showClearFilters.value = true;
            }

            const callback = (responseData) => {
                // 在這裡處理回調邏輯
                console.log('Callback data:', responseData);

                const paper = responseData.paper;
                totalPages.value = paper.pageCount;
                currentPage.value = paper.currentPage;
                totalDataNumber.value = paper.total;

                yuanUI.log("paper", paper);
            };
            fetchData(`/yuanadmin/api/form-datatable/${formType}`, queryParams, callback);




            // try {
            //     const response = await axios.get(`/yuanadmin/api/form-datatable/${formType}`, {
            //         params: queryParams
            //     });
            //     datatableData.value = response.data.data;
            //     yuanUI.log("response", response);

            //     const paper = response.data.paper;

            //     totalPages.value = paper.pageCount;
            //     currentPage.value = paper.currentPage;
            // } catch (error) {
            //     console.error('Failed to fetch data:', error);
            //     console.error(error.response.data.message);
            // }


            // yuanUI.log("filterStatus", filterStatus.value);
        });


        const formatQuestionKey = (key) => {
            const match = key.match(/\d+/);
            const number = match ? match[0] : '';
            return `${number}`;
        }

        const formatQuestionValue = (value) => {
            // 如果值是數組，則將其轉換為逗號分隔的字符串
            return Array.isArray(value) ? value.join(', ') : value;
        }


        const openDetail = async (id) => {
            try {
                const api_response = await axios.post(baseUrl + 'yuanadmin/getFormData', {
                    id: id
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                yuanUI.log("api_response", api_response);


                const showData = api_response.data.data.user_data;
                yuanUI.log("Detail Data:", showData);

                // 解析 user_data JSON 字串
                const formData = JSON.parse(showData);
                yuanUI.log("Parsed Form Data:", formData);


                showPopup.value = true; // 顯示彈窗
                questions.value = formData.questions;
            } catch (error) {
                console.error('Error fetching detail data:', error);
            }

        }

        const datatableStatusOptions = ref(updatedStatusOptions);
        const updateStatus = async (newValue, item) => {
            // const selectElement = event.target;
            // const data_id = id;
            // console.log(data_id);
            // // const id = selectElement.dataset.id; // 從 data-id 屬性獲取 ID
            // const selectedValue = selectElement.value; // 獲取選擇的值
            // const parentElement = selectElement.closest('.yuan_select');
            // // 更新 select 的 class
            // parentElement.classList.remove('status-done', 'status-close'); // 移除現有的 class
            // if (selectedValue == '1') {
            //     parentElement.classList.add('status-done');
            // } else if (selectedValue == '2') {
            //     parentElement.classList.add('status-close');
            // }

            yuanUI.log("item.id", item.id);

            try {
                const response = await axios.post(baseUrl + 'yuanadmin/updateStatus', {
                    id: item.id,
                    status: newValue
                });
                yuanUI.log("response:", response);

                // 根據回應更新畫面
                if (response.data.success) {
                    console.log('更新成功');

                    item.status = newValue;

                    showNoti('更新成功');
                    setTimeout(() => {
                        closeNoti();
                        // window.location.reload();
                    }, 500);
                } else {
                    // 處理錯誤情況
                    console.log('更新失敗，請稍後再試。');
                }
            } catch (error) {
                console.error('更新狀態失敗', error);
                // 處理 AJAX 請求錯誤
            }
        }

        const formatDate = (date) => {
            if (date instanceof Date) {
                // 如果是Date對象，則進行格式化
                return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
            } else {
                // 如果不是Date對象，假定它已經是正確格式的字符串，直接返回
                return date;
            }
            // return `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
        }

        // 日期區間 格式
        const filterDateFormat = (filterDate) => {
            if (filterDate && filterDate.length === 2) {
                let startDate = filterDate[0] ? formatDate(filterDate[0]) : '';
                let endDate = filterDate[1] ? formatDate(filterDate[1]) : '';
                return startDate && endDate ? `${startDate} 到 ${endDate}` : '';
            }
            return '';
        }

        const sendFilter = async () => {
            yuanUI.log("filterDate:", filterDate.value);
            yuanUI.log("filterStatus:", filterStatus.value);

            let startDate, endDate;
            if (filterDate.value && filterDate.value[0] && filterDate.value[1]) {
                startDate = formatDate(filterDate.value[0]);
                endDate = formatDate(filterDate.value[1]);
            }
            else {
                startDate = '';
                endDate = '';
            }
            let status = filterStatus.value !== '' ? filterStatus.value : '';

            const queryParams = new URLSearchParams();
            startDate = queryParams.set('startDate', startDate);
            endDate = queryParams.set('endDate', endDate);
            status = queryParams.set('status', status);

            history.pushState(null, '', '?' + queryParams.toString());

            yuanUI.log("startDate, endDate:", startDate, endDate);

            await fetchData(`/yuanadmin/api/form-datatable/${formType}`, queryParams, (response) => {
                // 你可以在这里处理响应数据或执行回调
                console.log('Callback data:', response);
                const paper = response.paper;
                totalPages.value = paper.pageCount;
                currentPage.value = paper.currentPage;
                totalDataNumber.value = paper.total;
                showClearFilters.value = true;
            });
            // try {
            //     const response = await axios.get(`/yuanadmin/api/form-datatable/${formType}`, {
            //         params: { startDate, endDate, status }
            //     });

            //     yuanUI.log("response:", response);
            //     data.value = response.data.data;
            // } catch (error) {
            //     console.error('sendFilter Error', error);
            // }
        }

        const clearFilters = async () => {
            filterDate.value = '';
            filterStatus.value = '';
            showClearFilters.value = false;
            history.pushState(null, '', window.location.pathname);
            await fetchData(`/yuanadmin/api/form-datatable/${formType}`, null, (response) => {
                // 你可以在这里处理响应数据或执行回调
                console.log('Callback data:', response);
                const paper = response.paper;
                totalPages.value = paper.pageCount;
                currentPage.value = paper.currentPage;
                totalDataNumber.value = paper.total;
            });
            // try {
            //     const response = await axios.get(`/yuanadmin/api/form-datatable/${formType}`);
            //     data.value = response.data.data;
            //     yuanUI.log("response", response);
            // } catch (error) {
            //     console.error('Failed to fetch data:', error);
            //     console.error(error.response.data.message);
            // }

        }

        const exportCsv = () => {
            window.location.href = `${baseUrl}yuanadmin/export-csv/${formType}`;
        }


        const { sorting, updateSorting, sortIconClass } = useSorting(formType, fetchData);

        const totalPages = ref('');
        const currentPage = ref('');
        const totalDataNumber = ref('');

        const changePage = async (page) => {
            currentPage.value = page;

            const queryParams = new URLSearchParams();
            queryParams.set('page', page);
            history.pushState(null, '', '?' + queryParams.toString());
            await fetchData(`/yuanadmin/api/form-datatable/${formType}`, queryParams, (response) => {
                // 你可以在这里处理响应数据或执行回调
                console.log('Callback data:', response);
            });
        }


        return {
            showPopup, showNotification, notificationTxt,
            // datatableData,
            data,
            selectClass,
            detailData,
            openDetail,
            questions, formatQuestionKey, formatQuestionValue,
            updateStatus,
            sendFilter, filterDate, filterStatus, filterStatusOptions, filterDateFormat, showClearFilters, clearFilters,
            exportCsv, exportDateRange, exportDateRangeOptions,
            datatableStatusOptions,
            // budgetSortOrder, locationSortOrder, updateBudgetSort, updateLocationSort,
            updateSorting, sortIconClass,
            totalPages, currentPage, totalDataNumber, changePage
        }
    }

}

const datatable = createApp(datatableSetup);
datatable.config.compilerOptions.isCustomElement = (tag) => {
    return tag.startsWith('module-')
}
// datatable.use(router);
datatable.component('date-picker', VueDatePicker);
datatable.mount("#datatable");