$(document).ready(function(){if($(".alert")&&setTimeout(()=>{$(".alert").animate({top:"-100%",opacity:"0"},1500,"linear",function(){$(this).remove()})},2e3),$("#current-schedule li").length>0){let c=$("#current-schedule li"),i=[];c.each(function(){let t=$(this).data("start"),d=$(this).data("end"),r=$(this).text(),u="/doctor/event/now?id="+$(this).data("url");i.push({title:r,start:t,end:d,url:u})});var p=document.getElementById("calendar-curent-schedule"),s=new FullCalendar.Calendar(p,{locale:"ru",contentHeight:"auto",headerToolbar:{left:"prev,next today",center:"title",right:"dayGridMonth,timeGridWeek,timeGridDay"},initialDate:new Date,eventClassNames:"time-td",navLinks:!0,selectable:!0,selectMirror:!0,select:function(t){title&&s.addEvent({title:t.title,start:t.start,end:t.end}),s.unselect()},editable:!1,dayMaxEventRows:6,events:i});s.render()}$("#doctors-select").change(function(){let c=$('input[name="_token"]').val(),i=$(this).val(),t=[];$.ajax({url:"/doctor/event/new/doctor",method:"POST",cache:!1,data:{_token:c,doctor:i},success:function(d){var r=Object.keys(d.doctor).map(n=>[n,d.doctor[n]]);$.each(r,function(n,e){let l=Object.keys(e).map(o=>[o,e[o]]),a=[];$.each(e[1],function(o,v){let h=$.map(e[1][o],function(m,f){return[[f,m]]});a.push({start:h[0][1],end:h[1][1]})}),t[l[0][1]]=a});let u='<option value="" disabled selected hidden >Выберите Дату</option>';$('select[name="reAdmission[doctors_date]"]').empty().append(u),$.each(Reflect.ownKeys(t),function(n,e){if(e!=="length"){console.log(n);let l='<option value="'+e+'">'+e+"</option>";$('select[name="reAdmission[doctors_date]"]').append(l)}}),$('select[name="reAdmission[doctors_date]"]').change(function(){let n='<option value="" disabled selected hidden >Выберите Время</option>';$('select[name="reAdmission[doctors_time]"]').empty().append(n);let e=t[$(this).val()];$.each(e,function(l,a){let o='<option value="'+a.start+'">'+a.start+" - "+a.end+"</option>";console.log(o),$('select[name="reAdmission[doctors_time]"]').append(o)})})}})})});
