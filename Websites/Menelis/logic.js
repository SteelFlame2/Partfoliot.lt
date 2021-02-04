var menu = document.getElementById("menu");
var startTopPosition = menu.style.top;
var startPositionType = menu.style.position;

document.addEventListener("scroll", (e) => {
    // var bounds = menu.getBoundingClientRect();
    // if (bounds.y < 0) {} else {}

    if (window.pageYOffset > 512) {
        menu.style.position = "fixed";
        menu.style.top = "0px";
    } else { 
        menu.style.position = startPositionType;
        menu.style.top = startTopPosition;
    }
});

var startScrollY = 0;
var frame = 0;

document.getElementById("to_up").addEventListener("click", (e) => {
    startScrollY = window.pageYOffset;
    var smoothScrolling = setInterval((e) => { 
        scrollTo(0, lerp(startScrollY, 0, frame));
        frame+=0.08;
        if (frame > 1) {
            clearInterval(smoothScrolling);
            frame = 0;
        } 
    }, 1000/60)
});
document.getElementById("kainos").addEventListener("click", (e) => {
    startScrollY = window.pageYOffset;
    var smoothScrolling = setInterval((e) => { 
        scrollTo(0, lerp(startScrollY, 694, frame));
        frame += 0.08;
        if (frame > 1) {
            clearInterval(smoothScrolling);
            frame = 0;
        } 
    }, 1000/60)
});

function lerp(a,b,t) { 
    return a + (b - a) * t;
}