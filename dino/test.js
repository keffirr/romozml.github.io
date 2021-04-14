var h = setInterval(function(){
           $(".c.active").each(function(){
               var c = +$(this).data('current') || 50;
               var max = +$(this).data('max');
               if(++c <= max){
                    $(this).data('current', c).text(c);
               }
               else $(this).removeClass('active');
           });
           if(!$(".c.active").length){
               clearInterval(h);
               console.log('the end');
           }
        }, 100);
.c { 
   display: inline-block;
   width: 30%;
   font-size: 30px;
   color: red;
   font-weight: bold;
   text-align: center;
}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="c active" data-max="0"></div>
