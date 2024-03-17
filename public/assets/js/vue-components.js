const { ref, watch, computed } = Vue;
const PROJECT_NAME = "yuan";

export const link = {
    props: {
        imgSrc: String,
        linkText: String,
        href: String
    },
    template: `
        <a :href="href" class="link"> 
            <span class="link-txt">{{ linkText }}</span>
            <svg :data-src="imgSrc"></svg>
        </a>
    `
}

export const submitForm = {
    props: {
        default_txt: String,
        sending_txt: String,
        isdisabled: Boolean
    },
    template: `
    <button type="submit" class="link send" :disabled="isdisabled">{{isdisabled ? sending_txt : default_txt}}</button>
    `,
};


export const questionItem = {
    props: {
        itemKey: String,
        type: String,
        item: Object,
        index: Number,
        modelValue: [String, Number, Array]
    },
    emits: ['update:modelValue'],
    template: `
    <div :class="['question-item', type]" v-if="['radio-icon', 'radio', 'checkbox-icon'].includes(type)">
        <label :for="generateID" class="form_label">
            <input :type="inputType" :class="'form_input--' + inputType" :name="itemKey" :id="generateID" :value="item.label" v-model="value" @change="handleChange">
            <div class="question-item-inner" @mouseover="hover" @mouseout="leave" @focus="hover" @blur="leave">
                <span v-if="type === 'radio-icon' || type === 'checkbox-icon'" class="icon">
                    <img :src="currentIcon" alt="">
                </span>
                <span class="label">{{ item.label }}</span>
            </div>
        </label>
    </div>
    <div :class="['question-item', type]" v-if="['checkbox-image'].includes(type)">
        <label :for="generateID" class="form_label">
            <input type="checkbox" :class="'form_input--' + inputType" :name="itemKey" :id="generateID" :value="item.label" v-model="value" @change="handleCheckboxChange">
            <div class="question-item-inner hover_effect">
                <span class="img">
                    <img :src="item.image" alt="">
                </span>
            </div>
            <span class="label">{{ item.label }}</span>
        </label>
    </div>
    <div :class="['question-item', type]" v-if="type === 'select'">
        <label :for="generateID" class="form_label">{{ item.label }}</label>
        <div :class="['form_select', {'js-open': isOpen}]">
            <svg xmlns="http://www.w3.org/2000/svg" width="11.04" height="9.558" viewBox="0 0 11.04 9.558">
                <path id="Path_22" data-name="Path 22" d="M2944,4348.8l4.679,8.793,5.5-8.793" transform="translate(-2943.559 -4348.535)" fill="none" stroke="#102543" stroke-linejoin="round" stroke-width="1"/>
            </svg>
            <select :name="generateID" :id="generateID" v-model="value" @change="handleChange" @focus="handleSelectFocus" @blur="handleSelectBlur">
                <option v-for="option in item.options" :key="option" :value="option">{{ option }}</option>
            </select>
        </div>
    </div>
    <div :class="['question-item', type]" v-if="type === 'radio-bar'">
        <label :for="generateID" class="form_label">
            <input type="radio" :class="'form_input--' + type" :name="itemKey" :id="generateID" :value="item.label" :checked="isChecked(item)" v-model="value" @change="handleChange">
            <span class="mark"></span>
            <span class="label">{{ item.label }}</span>
        </label>
    </div>
    <div :class="['question-item', type, 'row-part-text-' + item.rowPart]" v-if="type === 'text'">
        <label :for="generateID" class="form_label">{{ item.label }}</label>
        <input type="text" :class="'form_input--' + type" :name="itemKey" :id="generateID" v-model="value" @input="handleInput" v-if="item.type === 'text'">
        <div class="question-item-radios"  v-if="item.type === 'radio'">
            <div class="question-item-radio" v-for="(subitem, subindex) in item.subitem">
                <label :for="generateID + '-' + subindex" class="form_label">
                    <input type="radio" :class="'form_input--' + inputType" :name="itemKey" :id="generateID + '-' + subindex" :value="subitem" v-model="value" @change="handleChange">
                    <div class="question-item-inner">
                        <span class="label">{{ subitem }}</span>
                    </div>
                </label>
            </div>
        </div>
    </div>
    `,

    setup(props, { emit }) {
        const value = ref(props.modelValue);
        const isOpen = ref(false);
        const isHovered = ref(false); 
        const initialIcon = props.item.icon;
        const hoverIcon = props.item.iconHover;
        // const currentIcon = ref(initialIcon);
        const currentIcon = computed(() => {
            if (isHovered.value) {
                // 如果鼠标悬停，返回hover图标
                return hoverIcon;
            } else if (isChecked(props.item)) {
                // 如果item被选中，返回checked状态的图标
                return hoverIcon;
            } else {
                // 否则返回默认图标
                return initialIcon;
            }
        });


        watch(() => props.modelValue, newValue => {
            emit('update:modelValue', newValue);
            // console.log(newValue);
        });
        const inputType = computed(() => {
            return props.type.startsWith('radio') ? 'radio' : 'checkbox';
        });
        const generateID = computed(() => {
            return props.itemKey + '-' + props.index;
        });

        const isChecked = (item) => {
            return props.modelValue.includes(item.label);
        };
        const currentIconSrc = computed(() => {
            return isChecked(props.item) ? props.item.iconHover : props.item.icon;
        });
        const hover = () => {
            isHovered.value = true; // 鼠标悬停时设置为true
        };

        const leave = () => {
            isHovered.value = false; // 鼠标离开时设置为false
        };
        
        

        const handleInput = (event) => {
            emit('update:modelValue', value.value);
        };
        const handleChange = (event) => {
            emit('update:modelValue', value.value);
        }
        const handleCheckboxChange = (event) => {
            event.target.classList.toggle("js-checked");
            const updatedValue = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
            if (event.target.checked) {
                updatedValue.push(event.target.value); // 选中时添加值
            } else {
                const index = updatedValue.indexOf(event.target.value);
                if (index > -1) {
                    updatedValue.splice(index, 1); // 取消选中时移除值
                }
            }
            emit('update:modelValue', updatedValue);
        }

        const handleSelectFocus = () => {
            isOpen.value = true;
        }

        const handleSelectBlur = () => {
            isOpen.value = false;
        }


        return {
            value,
            inputType, generateID, isChecked,
            handleInput, handleChange, handleCheckboxChange,
            isOpen, handleSelectFocus, handleSelectBlur,
            currentIcon,
            hover, 
            leave
        };
    }
}


export const InputField = {
    props: {
        'label': String,
        'id': String,
        'isrequired': Number,
        'placeholder': String,
        'modelValue': String,
        'error': String,
    },
    emits: ['update:modelValue'],
    template: `
    <module-field :class="[projectNameClass + '_field', { 'required': isrequired }]">
        <label :for="id" :class="projectNameClass + '_field-label'">{{label}}</label>
        <div :class="projectNameClass + '_field-block'">
            <div :class="projectNameClass + '_field-ctrler'">
                <input type="text" :id="id" :name="id" v-model.trim="value" class="form-control" :placeholder="placeholder" @input="handleInput">
            </div>
            <div class="error-msg" v-if="error">{{error}}</div> <!-- 顯示錯誤信息 -->
        </div>
    </module-field>
    `,
    setup(props, { emit }) {
        const value = ref(props.modelValue);
        watch(() => props.modelValue, newVal => {
            value.value = newVal;
        });
        const handleInput = () => {
            emit('update:modelValue', value.value);
        };

        const projectNameClass = `${PROJECT_NAME}`;


        return {
            projectNameClass,
            value, handleInput
        };
    }
};


export const PasswordField = {
    props: {
        'label': String,
        'id': String,
        'isrequired': Number,
        'placeholder': String,
        'modelValue': String,
        'error': String
    },
    emits: ['update:modelValue'],
    template: `
    <module-field id="password_field" :class="[projectNameClass + '_field', 'password_field', { 'required': isrequired }]">
        <label :for="id" :class="projectNameClass + '_field-label'">密碼</label>
        <div :class="projectNameClass + '_field-block'">
            <div :class="projectNameClass + '_field-ctrler'">
                <input :type="fieldType" :id="id" :name="id" v-model="value" class="form-control" :placeholder="placeholder" @input="handleInput">
                <button type="button" class="toggle_password_btn" @click="togglePassword()">
                    <i class="fa-solid fa-eye" v-if="fieldType === 'password'"></i>
                    <i class="fa-solid fa-eye-slash" v-if="fieldType === 'text'"></i>
                </button>
            </div>
            <div class="error-msg" v-if="error">{{error}}</div> <!-- 顯示錯誤信息 -->
        </div>
    </module-field>
    `,
    setup(props, { emit }) {
        const value = ref(props.modelValue);
        const handleInput = () => {
            emit('update:modelValue', value.value);
        };
        const fieldType = ref("password");
        const togglePassword = () => {
            return fieldType.value = (fieldType.value === "password") ? "text" : "password";
        }

        const projectNameClass = `${PROJECT_NAME}`;
        return { projectNameClass, 
            value, handleInput, fieldType, togglePassword };
    }
};

export const submitBtn = {
    props: {
        'default_txt': String,
        'sending_txt': String,
        'isdisabled': Boolean
    },
    template: `
    <button type="submit" :class="projectNameClass + '_btn'" :disabled="isdisabled">{{isdisabled ? sending_txt : default_txt}}</button>
    `,
    setup(props, { emit }) {
        const projectNameClass = `${PROJECT_NAME}`;
        return { projectNameClass };
    }
};

export const YuanSelect = {
    props: {
        'specialclass': String,
        'options': Array,
        'modelValue': [String, Number],
    },
    emits: ['update:modelValue'],
    template: `
    <div :class="['yuan_select', specialclass]">
        <i class="yuan_select-icon fa-solid fa-chevron-down"></i>
        <select name="" id="" class="date_range-select yuan_select-select" :value="modelValue" @change="$emit('update:modelValue', $event.target.value)">
            <option v-for="(option, index) in options" :key="index" :value="option.value">{{option.label}}</option>
        </select>
    </div>
    `,
    // setup(props, { emit }) {
    //     const value = ref(props.modelValue);

    //     // 監聽 modelValue 的變化，並更新 internalValue
    //     watch(() => props.modelValue, (newValue) => {
    //         value.value = newValue;
    //     });

    //     // 監聽 value 的變化，並通知父組件
    //     watch(value, (newValue) => {
    //         emit('update:modelValue', newValue);
    //     });

    //     return { value };
    // }
};