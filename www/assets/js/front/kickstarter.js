var le = 0;
var now = 0;

function PBcorrector() {
    // коллекция столов
    var Pbars = $(".progress-bar");
    if (Pbars) {
        Pbars.each(function () {
            var Pbar = $(this);
            var PBmin = parseInt(Pbar.data("min"));
            var PBmax = parseInt(Pbar.data("max"));

            var width = (((now - PBmin) / (PBmax - PBmin)) * 100);
            if (width >= 50) {
                Pbar
                        .removeClass("progress-bar-success")
                        .addClass("progress-bar-warning");
            }
            if (width >= 75) {
                Pbar
                        .removeClass("progress-bar-warning")
                        .addClass("progress-bar-danger");
            }
            if (width > 100) {
                width = 100;
            } else {
                // поправить шкалу прогресса
                var PBdelta = PBmax - now;
                var h = PBdelta / 3600 ^ 0;
                h = h < 10 ? "0" + h : h;
                var m = (PBdelta - h * 3600) / 60 ^ 0;
                m = m < 10 ? "0" + m : m;
                var s = PBdelta - h * 3600 - m * 60 ^ 0;
                s = s < 10 ? "0" + s : s;
                var caption = h + ":" + m + ":" + s + " to remove this table!";
                Pbar
                        .attr("aria-valuenow", width)
                        .css("width", width + "%")
                        .html(caption);
            }
        });
    }
}

function tick() {
    setTimeout(function () {
        $.php("tick/" + le);
    }, 1000);
}

function cardsArrange() {
    var windowWidth = $(window).width();
    var windowHeight = $(window).height();
    
    // card geometry
    var cardHeight = windowHeight * 0.2;
    var cardWidth = $(".iCard:first").outerWidth(true);
    $(".iCard,.leftCard,.rightCard,.prikup").css("height", cardHeight + "px");
    
    // iCard
    var cardCount = $(".iCard").length;
    var iCardX0 = 0;
    var cardStep =  (windowWidth - cardWidth) / (cardCount - 1);
    $(".iCard").each(function (x) {
        $(this).stop().css("left", (iCardX0 + x * cardStep) + "px");
    });
    
    // iInfo
    $("#iInfo").css("bottom", (cardHeight + 5) + "px" );
    var iInfoHeight = $("#iInfo").outerHeight(true);
    
    // leftCard
    cardCount = $(".leftCard").length;
    var y0 = $("#leftInfo").outerHeight(true) + 10;
    var workHeight =  windowHeight - y0 - iInfoHeight - cardHeight * 2 - 10;
    cardStep =  workHeight / (cardCount - 1);
    $(".leftCard").each(function (y) {
        $(this).stop().css("top", (y0 + y * cardStep) + "px");
    });
    
    // rightCard
    cardCount = $(".rightCard").length;
    y0 = $("#rightInfo").outerHeight(true) + 10;
    var workHeight =  windowHeight - y0 - iInfoHeight - cardHeight * 2 - 10;
    cardStep =  workHeight / (cardCount - 1);
    $(".rightCard").each(function (y) {
        $(this).stop().css("top", (y0 + y * cardStep) + "px");
    });
    
    // iCommands
    var ic = $("#iCommands");
    if(ic){
        var icwidth = ic.outerWidth(true);
        var icHeight = ic.outerHeight(true);
    }
}

$(document).ready(function () {
    $("#app").hide();
    // This specifies how many messages can be pooled out at any given time.
    // If there are more notifications raised then the pool, the others are
    // placed into queue and rendered after the other have disapeared.
//    $.jGrowl.defaults.pool = 5;
//    $.jGrowl.defaults.closerTemplate = '<div>--=СТЕРЕТЬ=--</div>';
    $("h1").fitText(1.2, {minFontSize: '15px', maxFontSize: '50px'});
    $.php("start");
});
