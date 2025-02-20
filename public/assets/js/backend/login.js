import { submitBtn, InputField, PasswordField } from '../vue-components.js';
import { useFormValidation } from '../vue-validation.js';

const {ref, createApp} = Vue;
const loginPageSetup = {
    components: {
        'input-field': InputField,
        'password-field': PasswordField,
        'submit-btn': submitBtn
    },
    setup() {
        const isdisabled = ref(false);
        const user_id = ref('');
        const user_pw = ref('');
        const fields = [
            { name: 'user_id', ref: user_id, label: '帳號' },
            { name: 'user_pw', ref: user_pw, label: '密碼' },
        ];
        const { fieldErrors, validate } = useFormValidation(fields);
        const frmError = ref('');
        const login = async (e) => {
            console.log("login");
            isdisabled.value = true;
            frmError.value = '';
            const formElement = e.target;
            const baseUrl = formElement.getAttribute('data-baseurl');
            console.log(baseUrl);

            // if (!validate()) {
            //     console.error('驗證失敗:', fieldErrors.value);
            //     isdisabled.value = false;
            //     return;
            // }

            if(user_id.value != '' && user_pw.value != '') {
                try {
                    const api_response = await axios.post(baseUrl + 'demoadmin/getLogin', {
                        user_id: user_id.value,
                        user_pw: user_pw.value
                    }, {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
    
                    yuanUI.log('Login response: ', api_response);

                    if (api_response.status == 200){
                        isdisabled.value = false;
                        window.location.href = `${baseUrl}demoadmin/form-datatable/home-appliances`;
                    }

                } catch (error) {
                    console.error('Login failed', error);
                    isdisabled.value = false;
                    frmError.value = '帳號或密碼輸入錯誤';
                }
            }
            else {
                isdisabled.value = false;
            }
            // window.location.href = `${baseUrl}demoadmin/dashboard`;
        };

        return {
            isdisabled,
            user_id,
            user_pw,
            login,
            fieldErrors,
            frmError
        }
    }

}

const loginPage = createApp(loginPageSetup);
loginPage.config.compilerOptions.isCustomElement = (tag) => {
    return tag.startsWith('module-')
}
loginPage.mount("#loginApp");
