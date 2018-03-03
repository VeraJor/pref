$("#myModal").modal("hide");
$("#welcome").hide();
$("#app").show();
var app_is_empty = $("#app").is(":empty");
if(app_is_empty){
    $.php("app/get_super_mode");
}