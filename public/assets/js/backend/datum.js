define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'datum/index' + location.search,
                    add_url: 'datum/add',
                    edit_url: 'datum/edit',
                    del_url: 'datum/del',
                    multi_url: 'datum/multi',
                    table: 'datum',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'da_ce', title: __('Da_ce'), searchList: {"0":__('Da_ce 0'),"1":__('Da_ce 1')}, formatter: Table.api.formatter.normal},
                        {field: 'year', title: __('Year'), searchList: {"0":__('Year 0'),"1":__('Year 1'),"2":__('Year 2'),"3":__('Year 3')}, formatter: Table.api.formatter.normal},
                        {field: 'category_id', title: __('Category_id')},
                        {field: 'category.name', title: __('Category.name')},
                        {field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'title', title: __('Title'),operate: 'LIKE'},
                        {field: 'name', title: __('Name'),operate: 'LIKE'},
                        {field: 'attachfile', title: __('Attachfile')},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

                        {field: 'category.type', title: __('Category.type')},


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