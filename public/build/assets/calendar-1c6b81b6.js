document.addEventListener("DOMContentLoaded",function(){var r=document.getElementById("calendar"),e=new FullCalendar.Calendar(r,{headerToolbar:{left:"prev,next today",center:"title",right:"dayGridMonth,timeGridWeek,timeGridDay"},initialDate:"2023-01-12",navLinks:!0,selectable:!0,selectMirror:!0,select:function(t){var n=prompt("Event Title:");n&&e.addEvent({title:n,start:t.start,end:t.end,allDay:t.allDay}),e.unselect()},eventClick:function(t){confirm("Are you sure you want to delete this event?")&&t.event.remove()},editable:!0,dayMaxEvents:!0,events:[{title:"All Day Event",start:"2023-01-01"},{title:"Long Event",start:"2023-01-07",end:"2023-01-10"},{title:" Event 1",start:"2023-03-28T16:00:00"},{title:" Event 2",start:"2023-03-28T16:00:00"},{groupId:999,title:"Repeating Event",start:"2023-01-09T16:00:00"},{groupId:999,title:"Repeating Event",start:"2023-01-09T16:00:00"},{groupId:999,title:"Repeating Event",start:"2023-01-16T16:00:00"},{title:"Conference",start:"2023-01-11",end:"2023-01-13"},{title:"Meeting",start:"2023-01-12T10:30:00",end:"2023-01-12T12:30:00"},{title:"Lunch",start:"2023-01-12T12:00:00"},{title:"Meeting",start:"2023-01-12T14:30:00"},{title:"Happy Hour",start:"2023-01-12T17:30:00"},{title:"Dinner",start:"2023-01-12T20:00:00"},{title:"Birthday Party",start:"2023-01-13T07:00:00"},{title:"Click for Google",url:"http://google.com/",start:"2023-01-28"}]});e.render()});
