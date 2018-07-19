$(document).ready(function(){  
  
    //When mouse rolls over  
    $("#navigation li").mouseover(function(){  
        $(this).stop().animate({height:'150px'},{queue:false, duration:600, easing: 'easeOutBounce'})  
    });  
  
    //When mouse is removed  
    $("#navigation li").mouseout(function(){  
        $(this).stop().animate({height:'50px'},{queue:false, duration:600, easing: 'easeOutBounce'})  
    });  
  
});  
