$(".glyphicon-wrench").click(function () {
    if($(this).parent().find("span:last:not(.field)").length > 0){
        var value = $(this).parent().find("span:last:not(.field)").text()
        $(this).parent().find("span:last:not(.field)").remove();
        console.log($(this).parent().find("span:last:not(.field)"));
        var field = $(this).parent().find(".field").text().trim();
        var input = $(document.createElement("input"));
        input.val(value);
        $(this).parent().append(input);
        $(this).attr("class", "glyphicon glyphicon-ok");
        $(this).click(function () {
            $.post("/php/changeUserInfo.php",{
                field: field.toLocaleLowerCase().trim(),
                value: input.val()
            },function (data) {
                    location.reload();
            })

        })
    }

});