$(document).ready(function(){
    if($('.alert')){
        setTimeout(()=>{
            $('.alert').animate(
                {
                   top:'-100%',
                   opacity:'0'
                },
                1500,
                "linear",
                function(){
                $( this ).remove();	// изменяем текстовое содержимое нашему блоку и указываем цвет текста
                });
        },5000)
    }

    let current_link = location.pathname;
    $('.nav-link').each(function(index,element){
        if($(this).attr('href') == current_link){
            $(this).addClass('active').attr('aria-current','page');
        }
        else{
            if($(this).hasClass('active')){
                $(this).removeClass('active').attr('aria-current','');
            }
        }
    })
})