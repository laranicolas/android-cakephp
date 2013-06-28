

// animate: function( value, duration, easing, callback )
// x: variable (0 -> 1)
// t: current time (0 -> animation 'duration')
// b: beginning value (y0 = 0)
// c: change in value (dx = 1)
// d: duration (animation 'duration')
// s: 
$.extend($.easing,
{
	easeInOutBackSoft: function (x, time, y0, diff, duration, s) {

		if (s == undefined) {
			s = 0.70158;
		}

		s = s * 1.525;
		time = 2*time / duration;
		$.log(time);

		if(time < 1) {
			y = (diff/2) * (time * time * ((s + 1) * time - s)) + y0;
		}else {
			time = time - 2;
			y = (diff/2) * (time * time * ((s + 1) * time + s) + 2) + y0;
		}

		$.log(x +'\t'+ y);
		return y;
	}
});


jQuery.fn.fadeIn = function(speed, callback) {
	return this.animate({opacity: 'show'}, speed, function() {
		if (jQuery.browser.msie)
			this.style.removeAttribute('filter');
		if (jQuery.isFunction(callback))
			callback();
	});
};
jQuery.fn.fadeOut = function(speed, callback) {
	return this.animate({opacity: 'hide'}, speed, function() {
		if (jQuery.browser.msie)
			this.style.removeAttribute('filter');
		if (jQuery.isFunction(callback))
			callback();
	});
};
jQuery.fn.fadeTo = function(speed,to,callback) {
	return this.animate({opacity: to}, speed, function() {
		if (to == 1 && jQuery.browser.msie)
			this.style.removeAttribute('filter');
		if (jQuery.isFunction(callback))
			callback();
	});
};


(function($) {
	$.fn.customFadeIn = function(speed, callback) {
		$(this).fadeIn(speed, function() {
			if(!$.support.opacity)
				$(this).get(0).style.removeAttribute('filter');
			if(callback != undefined)
				callback();
		});
	};
	$.fn.customFadeOut = function(speed, callback) {
		$(this).fadeOut(speed, function() {
			if(!$.support.opacity)
				$(this).get(0).style.removeAttribute('filter');
			if(callback != undefined)
				callback();
		});
	};
	$.fn.customFadeTo = function(speed,to,callback) {
		return this.animate({opacity: to}, speed, function() {
			if (to == 1 && jQuery.browser.msie)
				this.style.removeAttribute('filter');
			if (jQuery.isFunction(callback))
				callback();
		});
	};
})(jQuery);


//jQuery plugins
$.fn.extend({
	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ) );
					if ( !isNaN( value ) && value != 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	}
});

