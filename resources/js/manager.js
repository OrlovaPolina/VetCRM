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

    let current_link = location.pathname + location.search;

    // $('.nav-link').each(function(i,e){
    //     if($(this).attr('href') == current_link || $(this).attr('href') == location.pathname){
    //         $(this).addClass('active').attr('aria-current','page');
    //     }
    //     else{
    //         if($(this).hasClass('active')){
    //             $(this).removeClass('active').attr('aria-current','');
    //         }
    //     }
    // })

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
        changeImagesBlocks($(this));        
    });    

    $(document).on('click','#images > div > i',function(){
        if($('input.image').length > 1){
            removeFileBlock($(this).parent());
            changeCounterFileBlocks();
        }
    })

    let events = $('#current-schedule li');
    let events_arr = [];
    events.each(function(){
     
        if(window.location.pathname.indexOf('manager/doctor') != -1){
            let start_a = $(this).data('start');
            let end_a = $(this).data('end');
            events_arr.push({
                title:start_a,
                start:start_a,
                end:end_a,
            });
        }
        else if(window.location.pathname.indexOf('/manager/timetable') != -1){
            let start_a = $(this).data('start');
            let end_a = $(this).data('end');
            let title_a = $(this).data('title');
            let url_a = '/manager/event/delete/' + $(this).data('url');
            events_arr.push({
                title:title_a,
                start:start_a,
                end:end_a,
                url:url_a
            });
        }
       
    });
    if(window.location.pathname.indexOf('manager/doctor') != -1 || window.location.pathname.indexOf('/manager/timetable') != -1){

    
    var calendarEl = document.getElementById('calendar-curent-schedule');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ru',
        contentHeight:"auto",
      headerToolbar: {
        left: 'prev,next today',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialDate: new Date(),
      eventClassNames: 'time-td',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Расписание:');
        if (title) {
          calendar.addEvent({
            title: arg.title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      editable: true,
      dayMaxEventRows: 6, // allow "more" link when too many events
      events:events_arr,
      eventClick: function(info) {
        info.jsEvent.preventDefault(); // don't let the browser navigate
    
        if (info.event.url) {
           let confirm_ = confirm("Вы уверены, что хотите удалить запись?");
           if(confirm_ === true){
            window.open(info.event.url);
           }
        }
      }

    });
    calendar.render();
    }
    // $('.create-schedule').click(function () {
    //     $('.create-schedule-form').toggleClass('d-none').toggleClass('d-flex')
    //   })

})

function changeImagesBlocks(currenImg){
    let count = parseInt(currenImg.prop('name').split(/(\[)|(\])/)[3]);  
    setPreview(count);
    let countImages = $('input.image').length;
    if(countImages < 2 )
    {
        dublicateFileBlock(0)
    }
    else if((count  + 1) == (countImages)){
        dublicateFileBlock(count)
    }
}

function dublicateFileBlock(count){
    count = count + 1;
    let newImage = '<div class="input-group">'+
    '<input type="file" name="images['+count+']" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">'+
    '<img src="preview-image.png" id="image-'+count+'" alt="Preview">'+
    '<i class="bi bi-x-circle-fill"></i>'+
    '</div>';
    $('#images').append(newImage);
}

function removeFileBlock(currentBlock) {
    currentBlock.remove();
}

function setPreview(count){
   count = count;
    const [file] = $('input.image[name="images['+count+']"]').prop('files');
    if (file) {
      $('img#image-'+count).prop('src',URL.createObjectURL(file));
    }
}
function changeCounterFileBlocks() {
    $('.images>.input-group').each(function (index) {
        $(this).children('input').attr('name','images['+index+']');
        $(this).children('img').attr('id','image-'+index);
    })
}