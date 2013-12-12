var k=0;
var scroll_break=1;

function scroll_up(){
    if (k>=40)
        k=k-40;
    else if (k<40 && k>=0)
       k=0;
    document.getElementById('n777').scrollTop=k;
    if (scroll_break)
        setTimeout('scroll_up();', 100);
    else
        scroll_break=1;
}
function scroll_down(){
    var scroll=document.getElementById('n777').scrollTop;
    if ((k-5)<=scroll)
        k=k+40;
    else if ((k-5)>scroll)
        k=scroll;
    document.getElementById('n777').scrollTop=k;
    if (scroll_break)
        setTimeout('scroll_down();', 100);
    else
        scroll_break=1;
}
function scroll_breaker(){
    scroll_break=0;
}

