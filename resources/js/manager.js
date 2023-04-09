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
        },1500)
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

    $('#reset').click(function () {
        $('form.filter-form input').each(function(i,e){
            $(this).val("");
            location.href = '/manager';
        })
    })

    $('.image').each(function () {
        if($(this).attr('value')){
            let name = $(this).attr('value').split(/\//);
            name = name[name.length - 1];
            let file = new File([$(this).attr('value')], name,{type:"image/png, image/gif, image/jpeg, image/jpg", lastModified:new Date().getTime()});
            let container = new DataTransfer();
            container.items.add(file);
            $(this).prop('files',container.files);
        }
      })

    $(document).on('change','.images .image:not(:last-child)',function(){  
        let count = parseInt($(this).prop('name').split(/(\[)|(\])/)[3]);  
        setPreview(count);

        let countImages = $('input.image').length;
        console.log('количество = '+countImages);
        console.log('номер текущего = '+count);
        if(countImages < 2 )
        {
            dublicateFileBlock(0)
        }
        else if((count  + 1) == (countImages)){
            dublicateFileBlock(count)
        }
        
    });    
})

function dublicateFileBlock(count){
    count = count + 1;
    let newImage = '<div class="input-group">'+
    '<input type="file" name="images['+count+']" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">'+
    '<img src="preview-image.png" id="image-'+count+'" alt="Preview">'+
    '</div>';
    $('#images').append(newImage);
}

function setPreview(count){
   count = count;
    const [file] = $('input.image[name="images['+count+']"]').prop('files');
    if (file) {
      $('img#image-'+count).prop('src',URL.createObjectURL(file));
    }
}