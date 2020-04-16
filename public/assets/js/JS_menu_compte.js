
$("#btnMenu").on("click", function () {
    $("#divMenu").toggle();
});

let content = $('#contentFav').outerHeight();
let menu = $('#menuCol').height();

if (menu < content) {
    $("#menuCol").height(content);
}
$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});