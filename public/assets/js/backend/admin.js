const { ref, createApp } = Vue;
const adminAsideSetup = {

    setup() {
        const getType = ref(formType);

        return {
            getType
        }
    }

}

const adminAside = createApp(adminAsideSetup);
adminAside.config.compilerOptions.isCustomElement = (tag) => {
    return tag.startsWith('module-')
}
adminAside.mount("#adminAside");
