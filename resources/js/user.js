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
        },1500)
    }

    $('#doctors-select').change(function () {
        let token = $('input[name="_token"]').val();
        let doctor = $(this).val();
        let schedule_work = [];
        $.ajax({
            url:"/user/event/new/doctor",
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
                $('select[name="doctors_date"]').empty().append(option);
                    $.each(Reflect.ownKeys(schedule_work), function (ind,val) {
                        if(val !== 'length'){
                            console.log(ind);
                            let option = "<option value=\""+val+"\">"+val+"</option>";
                            $('select[name="doctors_date"]').append(option);
                        }                        
                    })
                    $('select[name="doctors_date"]').change(function(){
                        let option = "<option value=\"\" disabled selected hidden >Выберите Время</option>";
                        $('select[name="doctors_time"]').empty().append(option);
                        let cur_day = schedule_work[$(this).val()];
                        $.each(
                            cur_day,
                            function (ind, val) {
                                let option = "<option value=\""+val.start+"\">"+ val.start + " - " + val.end +"</option>";
                                    console.log(option);
                                $('select[name="doctors_time"]').append(option);
                            }
                        );
                    })
            }
        })
    })

    // $('.animal a.download').click(function(e){
    //     e.preventDefault();
    //     let token = $(this).parent().children('input[name="_token"]').val();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },            
    //         url:'/user/download',            
    //         global: false,
    //         type: 'POST',
    //     });
    //     let _id = $(this).parent().children('input[name="id"]').val();
    //     $.ajax({
    //         data:{id:_id,_token:token},
    //         success:function(response){
    //             const data = response;
    //                 const link = document.createElement('a');
    //                 link.setAttribute('href', data);
    //                 link.setAttribute('download', 'yourfilename.pdf'); // Need to modify filename ...
    //                 link.click();
    //         }
    //     });
    // })
})