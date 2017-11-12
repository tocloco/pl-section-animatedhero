NodeList.prototype.forEach = Array.prototype.forEach;
var x;
var y;

jQuery(function($) {
	$(document).ready(function(){
		
	    x = document.getElementsByClassName("pl_animated_hero");
	    y = document.getElementsByClassName("pl_animated_herotext");
	    
	    for (i = 0; i < x.length; ++i) {
			x[i].setAttribute('onscreen', '0');
		}
	    for (i = 0; i < y.length; ++i) {
			y[i].setAttribute('onscreen', '0');
		}
	    jQuery(window).scroll(function(){
		    for (i = 0; i < x.length; ++i) {
				if(jQuery(x[i]).isOnScreen()){
					//jQuery(x[i]).fadeIn(2000);
					jQuery(x[i]).addClass(jQuery(x[i]).data('animationcss'));
				}
			}
			for (i = 0; i < y.length; ++i) {
				if(jQuery(y[i]).isOnScreen()){
					//jQuery(x[i]).fadeIn(2000);
					jQuery(y[i]).addClass(jQuery(y[i]).data('animationcss'));
				}
			}
		});
	});
});

function isVisible(el){
	//console.log(el);
    var windowScrollTopView = jQuery(window).scrollTop();
    //console.log(windowScrollTopView);
    var windowBottomView = windowScrollTopView + jQuery(window).height();
    //console.log(windowBottomView);
    var elemTop = jQuery(el).offset().top;
    //console.log(elemTop);
    var elemBottom = elemTop + jQuery(el).height();   
    //console.log(elemBottom);
    return ((elemBottom <= windowBottomView) && (elemTop >= windowScrollTopView));
}

jQuery.fn.isOnScreen = function(){

    var win = jQuery(window);

    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};