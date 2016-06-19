var main = (function () {
    doConstruct = function () {
        this.init_callbacks = [];
    };
    doConstruct.prototype = {
        add_init_callback : function (func) {
            if (typeof(func) == 'function') {
                this.init_callbacks.push(func);
                return true;
            }
            else {
                return false;
            }

        }
    };
    return new doConstruct;
})();
$(document).ready(function () {
    $.each(main.init_callbacks, function (index, func) {
        func();
    });
});
var goods = (function () {
    var doConstruct = function () {
        main.add_init_callback(this.show_upload_img_name);
        main.add_init_callback(this.valid_form);
    };
    doConstruct.prototype = {
        show_upload_img_name: function () {
            $('#btn').click(function(){
                $('#upfile').click();
            });
            $("#upfile").change(function() {
                var files = $(this)[0].files;
                for (var i = 0; i < files.length; i++) {
                    if((i + 1) !== files.length) {          //If the last cell in the array - the name of the output append without ','
                        $("#btn").append(files[i].name+',  ');
                    } else {
                        $("#btn").append(files[i].name);
                    }
                }
            });
        },
        valid_form: function () {
            $('#r_form').on('submit', function(e){
                e.preventDefault();
                var check_file = $('#upfile').val();
                //var selector
                if(check_file != 0 ) {
                    this.submit();
                } else {
                    alert('You need to upload a photo');
                }
            });
        }
    };
    return new doConstruct;
})();
