
$(function(){
    $('.target').scroll(function(){
        $("span").css("display", "inline").fadeOut("slow");
    });
});
function triggerClick(){
    var clicl = document.getElementById('show_message');
    document.querySelector('#picture_post_icon').click();
}
function triggerClick1(){
    document.querySelector('#picture_post_icon1').click();
}
function clickicon(){
    $('#locations').on('click', 'a', function(){
        var id = $(this).attr('id');
        alert(id);
    });
}



// $(document).ready(function(){
//     $('#search').keyup(function(){
//         var name =$(this).val();
//         $.post
//     }


// }