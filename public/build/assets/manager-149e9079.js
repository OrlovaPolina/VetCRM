$(document).ready(function(){$(".alert")&&setTimeout(()=>{$(".alert").animate({top:"-100%",opacity:"0"},1500,"linear",function(){$(this).remove()})},1500);let e=location.pathname;$(".nav-link").each(function(i,t){$(this).attr("href")==e?$(this).addClass("active").attr("aria-current","page"):$(this).hasClass("active")&&$(this).removeClass("active").attr("aria-current","")}),$("#reset").click(function(){$("form.filter-form input").each(function(i,t){$(this).val(""),location.href="/manager"})}),$(".image").each(function(){if($(this).attr("value")){let i=$(this).attr("value").split(/\//);i=i[i.length-1];let t=new File([$(this).attr("value")],i,{type:"image/png, image/gif, image/jpeg, image/jpg",lastModified:new Date().getTime()}),a=new DataTransfer;a.items.add(t),$(this).prop("files",a.files)}}),$(document).on("change",".images .image:not(:last-child)",function(){l($(this))}),$(document).on("click","#images > div > i",function(){$("input.image").length>1&&(s($(this).parent()),r())})});function l(e){let i=parseInt(e.prop("name").split(/(\[)|(\])/)[3]);c(i);let t=$("input.image").length;t<2?n(0):i+1==t&&n(i)}function n(e){e=e+1;let i='<div class="input-group"><input type="file" name="images['+e+']" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg"><img src="preview-image.png" id="image-'+e+'" alt="Preview"><i class="bi bi-x-circle-fill"></i></div>';$("#images").append(i)}function s(e){e.remove()}function c(e){e=e;const[i]=$('input.image[name="images['+e+']"]').prop("files");i&&$("img#image-"+e).prop("src",URL.createObjectURL(i))}function r(){$(".images>.input-group").each(function(e){$(this).children("input").attr("name","images["+e+"]"),$(this).children("img").attr("id","image-"+e)})}