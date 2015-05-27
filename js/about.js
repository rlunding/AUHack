$(function(){
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // Get the name of active tab
        var activeTab = $(e.target).text();
        // Get the name of previous tab
        var previousTab = $(e.relatedTarget).text();
        $(".active-tab span").html(activeTab);
        $(".previous-tab span").html(previousTab);
    });
});