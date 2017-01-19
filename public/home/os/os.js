window.APPS = [
    {
        name: 'app.home',
        path: '/dashboard',
        url: '/dashboard',
        icon: 'fa fa-tree',
        title: '仪表板',
        templateUrl: 'dashboard/dashboard.html',
        resolve: { deps: ['dashboard/dashboard.js'] }
    },
    {
        name: 'app.chart',
        path: '/chart',
        url : '/chart',
        icon: 'fa fa-tree',
        title: '图表',
        templateUrl: 'chart/chart.html',
        resolve: { deps: ['chart/chart.js'] }
    },
    {
        name: 'app.table',
        path: '/table',
        url: '/table',
        icon: 'fa fa-tree',
        title: '表格',
        templateUrl: 'table/table.html',
        resolve: { deps: ['table/table.js'] }
    },
    {
        name: 'app.widgets',
        path: '/widgets',
        url: '/widgets',
        icon: 'fa fa-tree',
        title: '窗口小部件',
        templateUrl: 'widgets/widgets.html',
        resolve: { deps: ['widgets/widgets.js'] }
    },
    {
        name: 'app.grid',
        path: '/grid',
        url: '/grid',
        icon: 'fa fa-tree',
        title: '全宽度',
        templateUrl: 'widgets/widgets.html',
        resolve: { deps: ['widgets/widgets.js'] }
    },
    {
        name: 'app.basicform',
        path: '/basicform',
        url: '/basicform',
        icon: 'fa fa-tree',
        title: '基本表单',
        templateUrl: 'basicform/basicform.html',
        resolve: { deps: ['basicform/basicform.js'] }
    },
    // 奇葩路由一
    {
        name: 'app.form-validation',
        path: '/form-validation',
        url: '/form-validation',
        icon: 'fa fa-tree',
        title: '表单验证',
        templateUrl: 'form-validation/form-validation.html',
        resolve: { deps: ['form-validation/form-validation.js'] }
    },
    // 奇葩路由二
    {
        name: 'app.form-wizard.html',
        path: '/form-wizard.html',
        url: '/form-wizard.html',
        icon: 'fa fa-tree',
        title: '表单向导',
        templateUrl: 'form-wizard/form-wizard.html',
        resolve: { deps: ['form-wizard/form-wizard.js'] }
    },
    {
        name: 'app.buttons',
        path: '/buttons',
        url: '/buttons',
        icon: 'fa fa-tree',
        title: '表单向导',
        templateUrl: 'buttons/buttons.html',
        resolve: { deps: ['buttons/buttons.js'] }
    },
    {
        name: 'app.interface',
        path: '/interface',
        url: '/interface',
        icon: 'fa fa-tree',
        title: '元素',
        templateUrl: 'interface/interface.html',
        resolve: { deps: ['interface/interface.js'] }
    },
    {
        name: 'app.dashboard2',
        path: '/dashboard2',
        url: '/dashboard2',
        icon: 'fa fa-tree',
        title: '仪表盘2',
        templateUrl: 'dashboard2/dashboard2.html',
        resolve: { deps: ['dashboard2/dashboard2.js'] }
    },
    {
        name: 'app.gallery',
        path: '/gallery',
        url: '/gallery',
        icon: 'fa fa-tree',
        title: '画廊',
        templateUrl: 'gallery/gallery.html',
        resolve: { deps: ['gallery/gallery.js'] }
    },
    {
        name: 'app.calendar',
        path: '/calendar',
        url: '/calendar',
        icon: 'fa fa-tree',
        title: '日历',
        templateUrl: 'calendar/calendar.html',
        resolve: { deps: ['calendar/calendar.js'] }
    },
    {
        name: 'app.invoice',
        path: '/invoice',
        url: '/invoice',
        icon: 'fa fa-tree',
        title: '发票联',
        templateUrl: 'invoice/invoice.html',
        resolve: { deps: ['invoice/invoice.js'] }
    },
    {
        name: 'app.chat',
        path: '/chat',
        url: '/chat',
        icon: 'fa fa-tree',
        title: '聊天选项',
        templateUrl: 'chat/chat.html',
        resolve: { deps: ['chat/chat.js'] }
    },


    {
        name: 'app.error403.html',
        path: '/error403.html',
        url: '/error403.html',
        icon: 'fa fa-tree',
        title: 'error403',
        templateUrl: 'error/403.html',
        resolve: { deps: ['error/403.js'] }
    },
    {
        name: 'app.error404.html',
        path: '/error404.html',
        url: '/error404.html',
        icon: 'fa fa-tree',
        title: 'error404',
        templateUrl: 'error/404.html',
        resolve: { deps: ['error/404.js'] }
    },
    {
        name: 'app.error405.html',
        path: '/error405.html',
        url: '/error405.html',
        icon: 'fa fa-tree',
        title: 'error405',
        templateUrl: 'error/405.html',
        resolve: { deps: ['error/405.js'] }
    },
    {
        name: 'app.error500.html',
        path: '/error500.html',
        url: '/error500.html',
        icon: 'fa fa-tree',
        title: 'error500',
        templateUrl: 'error/500.html',
        resolve: { deps: ['error/500.js'] }
    },
    {
        name: 'app.test',
        path: '/test',
        url: '/test',
        icon: 'fa fa-tree',
        title: '开发者',
        templateUrl: 'test/test.html',
        resolve: { deps: ['test/test.js'] }
    }
];