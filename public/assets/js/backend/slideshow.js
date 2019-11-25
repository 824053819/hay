define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'slideshow/index' + location.search,
                    add_url: 'slideshow/add',
                    edit_url: 'slideshow/edit',
                    del_url: 'slideshow/del',
                    multi_url: 'slideshow/multi',
                    table: 'slideshow',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'sl_id',
                sortName: 'sl_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'sl_id', title: __('Sl_id')},
                        {field: 'sl_ce', title: __('Sl_ce'), searchList: {"0":__('Sl_ce 0'),"1":__('Sl_ce 1')}, formatter: Table.api.formatter.normal},
                        {field: 'sl_title', title: __('Sl_title')},
                        {field: 'sl_image', title: __('Sl_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'sl_link', title: __('Sl_link')},
                        {field: 'sl_sort', title: __('Sl_sort')},
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