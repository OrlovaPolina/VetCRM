$(document).ready(function () {
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
        },2000)
    }

    if($('#current-schedule li').length > 0 ){
        let events = $('#current-schedule li');
        let events_arr = [];
        events.each(function(){
            let start_a = $(this).data('start');
            let end_a = $(this).data('end');
            let title = $(this).text();
            let url = '/doctor/event/now?id=' + $(this).data('url');
            events_arr.push({
                title:title,
                start:start_a,
                end:end_a,
                url:url
            });
        });
        var calendarEl = document.getElementById('calendar-curent-schedule');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'ru',
            contentHeight:"auto",
        headerToolbar: {
            left: 'prev,next today',
            center:'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialDate: new Date(),
        eventClassNames: 'time-td',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        select: function(arg) {
            // var title = prompt('Расписание:');
            if (title) {
            calendar.addEvent({
                title: arg.title,
                start: arg.start,
                end: arg.end
            })
            }
            calendar.unselect()
        },
        editable: false,
        dayMaxEventRows: 6, // allow "more" link when too many events
        events:events_arr
        });
        calendar.render();
    }
    
    $('#doctors-select').change(function () {
        let token = $('input[name="_token"]').val();
        let doctor = $(this).val();
        let schedule_work = [];
        $.ajax({
            url:"/doctor/event/new/doctor",
            method:"POST",
            cache:false,
            data:{_token:token,doctor:doctor},
            success:function(response){
                var schedule = Object.keys(response.doctor).map((key) => [key, response.doctor[key]]);
                $.each(schedule, function (index,value) {
                    let val = Object.keys(value).map((key) => [key, value[key]]);
                    let i = 0;
                    let day_arr = [];
                    $.each(value[1],function(d_ind,d_value){
                        let day = $.map(value[1][d_ind], function(value, index) {
                            return [[index,value]];
                        });
                        day_arr.push({
                                start:day[0][1],
                                end: day[1][1]
                            }
                        );
                        
                    })
                    schedule_work[val[0][1]] = day_arr;
                    
                  })
                let option = "<option value=\"\" disabled selected hidden >Выберите Дату</option>";
                $('select[name="reAdmission[doctors_date]"]').empty().append(option);
                    $.each(Reflect.ownKeys(schedule_work), function (ind,val) {
                        if(val !== 'length'){
                            console.log(ind);
                            let option = "<option value=\""+val+"\">"+val+"</option>";
                            $('select[name="reAdmission[doctors_date]"]').append(option);
                        }                        
                    })
                    $('select[name="reAdmission[doctors_date]"]').change(function(){
                        let option = "<option value=\"\" disabled selected hidden >Выберите Время</option>";
                        $('select[name="reAdmission[doctors_time]"]').empty().append(option);
                        let cur_day = schedule_work[$(this).val()];
                        $.each(
                            cur_day,
                            function (ind, val) {
                                let option = "<option value=\""+val.start+"\">"+ val.start + " - " + val.end +"</option>";
                                    console.log(option);
                                $('select[name="reAdmission[doctors_time]"]').append(option);
                            }
                        );
                    })
            }
        })
    })
})