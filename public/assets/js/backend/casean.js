define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'casean/index' + location.search,
                    add_url: 'casean/add',
                    edit_url: 'casean/edit',
                    del_url: 'casean/del',
                    multi_url: 'casean/multi',
                    table: 'casean',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'cd_id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'cd_id', title: __('Cd_id')},
                        {field: 'category_id', title: __('Category_id')},
                        {field: 'category.name', title: __('Category.name')},
                        {field: 'cd_title', title: __('Cd_title'),operate: 'LIKE'},
                        {field: 'cd_images', title: __('Cd_images'), events: Table.api.events.image, formatter: Table.api.formatter.images},
                        {field: 'cd_times', title: __('Cd_times')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'cd_click', title: __('Cd_click')},
                        {field: 'cd_site', title: __('Cd_site')},
                        {field: 'cd_scope', title: __('Cd_scope')},
                        {field: 'weigh', title: __('Weigh')},

                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});