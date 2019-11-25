define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'team/index' + location.search,
                    add_url: 'team/add',
                    edit_url: 'team/edit',
                    del_url: 'team/del',
                    multi_url: 'team/multi',
                    table: 'team',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'team_id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'team_id', title: __('Team_id')},
                        {field: 'category_id', title: __('Category_id')},
                        {field: 'category.name', title: __('Category.name')},
                        {field: 'te_name', title: __('Te_name')},
                        {field: 'te_image', title: __('Te_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'te_label', title: __('Te_label')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'te_email', title: __('Te_email')},
                        {field: 'te_phone', title: __('Te_phone')},
                        /*{field: 'category.id', title: __('Category.id')},
                        {field: 'category.pid', title: __('Category.pid')},
                        {field: 'category.type', title: __('Category.type')},

                        {field: 'category.nickname', title: __('Category.nickname')},
                        {field: 'category.flag', title: __('Category.flag'), operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'category.image', title: __('Category.image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'category.keywords', title: __('Category.keywords')},
                        {field: 'category.description', title: __('Category.description')},
                        {field: 'category.diyname', title: __('Category.diyname')},
                        {field: 'category.createtime', title: __('Category.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'category.updatetime', title: __('Category.updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'category.weigh', title: __('Category.weigh')},
                        {field: 'category.status', title: __('Category.status'), formatter: Table.api.formatter.status},*/
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