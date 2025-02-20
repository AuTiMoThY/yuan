export const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes: [
        {
            path: '/:catchAll(.*)',  // 此处使用正则表达式捕获所有路径
            beforeEnter: (to, from, next) => {
                // 可以选择重定向或什么都不做
                console.log("No match found for path:", to.path);
                next(false);  // 取消当前的导航
            }
        },
        // {
        //     path: '/demoadmin/form-datatable/home-appliances',
        //     beforeEnter: (to, from, next) => {
        //         console.log("beforeEnter");
        //         next();
        //     },
        //     beforeLeave: (to, from, next) => {
        //         console.log("beforeLeave");
        //         next();
        //     }
        // }
    ]
});