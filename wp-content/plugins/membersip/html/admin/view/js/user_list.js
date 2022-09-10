
var f_data = null;
var i_data = null;
var u_data = null;
var d_data = null;
var changeKey = {
    "ユーザーID": "userid",
    "ログインID": "loginid",
    "パスワード": "password",
    "姓": "sei",
    "名": "mei",
    "電話番号": "tel",
    "メール": "mail",
    "性別": "gender",
    "退会": "del_flg"
};

function keyChange(args) {
    var param = {};
    $.each(args, 
        function(index, val) {
            param[changeKey[index]] = val;
        }
    );
    return param;
}

function keyChangeSingle(key) {
    var keyValue = changeKey[key];
    return keyValue;
}

function createFormInput(param) {

    // パラメータを付与する場合
    var inputs = '';
    $.each(param, function(key, val){
        inputs += '<input type="hidden" name="' + key + '" value="' + val + '" />';
    });

    // POST遷移
    $("body").append('<form action="" method="post" id="post">'+inputs+'</form>');
}

function searching(item) {

    // パラメーター設定
    search = keyChange(item);
    search['type'] = 'user-search';
    createFormInput(search);

    // パラメーター送信
    $("#post").submit();
}

function registing(item) {

    retist = keyChange(item);
    retist['type'] = 'user-regist';
    createFormInput(retist);

    // パラメーター送信
    $("#post").submit();
}

function editing(item) {

    edit = keyChange(item);
    edit['type'] = 'user-edit';
    edit['del_flg'] = new Boolean(edit.del_flg);

    createFormInput(edit);

    // パラメーター送信
    $("#post").submit();
}


/**
 * 
 * @param {*} config 
 */
var MyDateField = function(config) {
    jsGrid.Field.call(this, config);
};

MyDateField.prototype = new jsGrid.Field({

    filterTemplate: function() {
        return this.filterInput = $("<input>").attr({"type":"text"});
    },
    itemTemplate: function(value) {
        return value;
    },

    insertTemplate: function(value) {
        return this.insertInput = $("<input>").attr({"type":"text", "value":regist[keyChangeSingle(this.name)]});
    },

    editTemplate: function(value) {
        return this.editInput = $("<input>").attr({"type":"text","value":value});
    },

    filterValue: function() {
        return this.filterInput.val();
    },

    insertValue: function() {
        return this.insertInput.val();
    },

    editValue: function() {
        return this.editInput.val();
    }
});

jsGrid.fields.myDateField = MyDateField;


/**
 * 
 * @param {*} config 
 */
var UserIdField = function(config) {
    jsGrid.Field.call(this, config);
};

UserIdField.prototype = new jsGrid.Field({

    filterTemplate: function() {
        return this.filterInput = $("<input>").attr({"type":"text"});
    },
    itemTemplate: function(value) {
        return value;
    },

    insertTemplate: function(value) {
        return "自動採番されます";
    },

    editTemplate: function(value) {
        return this.editInput = $("<input>").attr({"type":"text","value":value, "readonly":"ture"});
    },

    filterValue: function() {
        return this.filterInput.val();
    },

    insertValue: function() {
        return "";
    },

    editValue: function() {
        return this.editInput.val();
    }
});

jsGrid.fields.useridField = UserIdField;


/**
 * 
 * @param {*} config 
 */
 var LoginField = function(config) {
    jsGrid.Field.call(this, config);
};

LoginField.prototype = new jsGrid.Field({

    filterTemplate: function() {
        return this.filterInput = $("<input>").attr({"type":"text"});
    },
    itemTemplate: function(value) {
        return value;
    },

    insertTemplate: function(value) {
        return "自動採番されます";
    },

    editTemplate: function(value) {
        return this.editInput = $("<input>").attr({"type":"text","value":value});
    },

    filterValue: function() {
        return this.filterInput.val();
    },

    insertValue: function() {
        return "";
    },

    editValue: function() {
        return this.editInput.val();
    }
});

jsGrid.fields.loginField = LoginField;

gender = [
    { Name: "", Id: "" },
    { Name: "男性", Id: "男性" },
    { Name: "女性", Id: "女性" },
];

function showDetails(userid){
    window.location.href = "admin.php?page=user_admin_page&type=user-details&userid="+userid;
}


/**
 * jsGrid(ユーザー一覧)メイン処理
 */
$("#jsGrid").jsGrid({

    width: "100%",
    height: "auto",
    inserting: true,
    filtering: true,
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 20,
    pageButtonCount: 5,
    controller: {
        loadData: (filter)=>{
            f_data = filter;

            // 削除フラグをbooleanへ変換
            let user_lists = [];
            $.each(user_list, function(key, val){
                val.削除 =  !!Number(val.削除);
                user_lists.push(val);
            });

            return user_lists;
        },
        insertItem: (item)=>{
            i_data = item;
            item.cancel = true;
        },
        updateItem: (item)=>{
            u_data = item;
        },
        deleteItem: (item)=>{
            d_data = item;
            item.cancel = true;
        }
    },
    onDataLoaded: function(args) {
        $('tr.jsgrid-row:has(input[type="checkbox"]:checked) td').addClass("test");
        $('tr.jsgrid-alt-row:has(input[type="checkbox"]:checked) td').addClass("test");
    },
    onItemInserting: function(args) {
        i_data = args;
        args.cancel = true;
    },
    // rowClick: function(args) {
    //     showDetails(args.item.ユーザーID);
    // },
    fields: [
        { name: "ユーザーID",type: "useridField"},
        { name: "ログインID", type: "loginField" },
        { name: "パスワード", type: "loginField"},
        { name: "姓", type: "myDateField",  },
        { name: "名", type: "myDateField",  },
        { name: "電話番号", type: "myDateField",  },
        { name: "メール", type: "myDateField",  },
        { name: "性別", type: "select", items: gender, valueField: "Id", textField: "Name"},
        { name: "退会", type: "checkbox"  },
        { type: "control",
            filterTemplate: function(value) {

                var filter = $("<input>").attr({
                    "type": "button",
                    "class": "jsgrid-button jsgrid-search-button"
                    }).on("click",async function(e){
                
                        // フィルター内容を取得
                        var $grid = $("#jsGrid");
                        $grid.jsGrid("loadData");
                        searching(f_data);
                
                        e.preventDefault;
                        return false;
                    });
                return [filter]
            }
            , 
            editTemplate: function(_, value) {

                var edit = $("<input>").attr({
                    "type": "button",
                    "class": "jsgrid-button jsgrid-update-button"
                }).on("click",function(e){
                
                    var val = JSON.stringify(value);
                    var $grid = $("#jsGrid");
                    $grid.jsGrid("updateItem");

                    // 編集前と一致する場合は編集をしない
                    if (JSON.stringify(u_data) === val){
                        return;
                    }

                    // 編集処理
                    editing(u_data);
                });

                var cancel = $("<input>").attr({
                    "type": "button",
                    "class": "jsgrid-button jsgrid-cancel-edit-button"
                }).on("click",function(e){
                    $("tr.jsgrid-alt-row").show();
                    $("tr.jsgrid-row").show();
                    $("tr.jsgrid-edit-row").remove();
                });

                return [edit, cancel ];
            }
            , 
            insertTemplate: function(value) { 
                var insert = $("<input>").attr({
                    "type": "button",
                    "class": "jsgrid-button jsgrid-insert-button"
                    }).on("click",function(e){
                
                        // 登録処理
                        var $grid = $("#jsGrid");
                        $grid.jsGrid("insertItem");
                        registing(i_data.item);
                
                        e.preventDefault;
                        return false;
                    });

                return [insert]
            }
            ,
            itemTemplate: function(_, item) {

                var edit_mode = $("<input>").attr({
                    "type": "button",
                    "class": "jsgrid-button jsgrid-edit-button",
                    "userid": item.ユーザーID
                }).on("click",function(e){

                    var userid = $(this).attr("userid");
                    showDetails(userid);
                    e.preventDefault;
                    return false;
                });

                return edit_mode;
            },
        },
    ],
});