$.fn.wait = function(time, type) {
	time = time || 1000;
	type = type || "fx";
	return this.queue(type, function() {
		var self = this;
		setTimeout(function() {
			$(self).dequeue();
		}, time);
	});
};

jQuery.fn.debug = function() {
	if (window.console) {
		return this.each(function() {
			console.debug(this);
		});
	} else {
		return this.each(function() {
			alert(this);
		});
	}
};

jQuery.log = function(message) {
	if (window.console) {
		console.debug(message);
	} else {
		alert(message);
	}
};

jQuery.consoleTime = function(message) {
	if (window.console) {
		console.time(message);
	} else {
		//alert(message);
	}
};

jQuery.consoleTimeEnd = function(message) {
	if (window.console) {
		console.timeEnd(message);
	} else {
		//alert(message);
	}
};

// easing function for contact form
$.extend($.easing, {
	easeInOutBackSoft: function (x, time, y0, diff, duration, s) {
		if (s == undefined) s = 0.70158;
		if ((time/=duration/2) < 1) return diff/2*(time*time*(((s*=(1.525))+1)*time - s)) + y0;
		return diff/2*((time-=2)*time*(((s*=(1.525))+1)*time + s) + 2) + y0;
	}
});

jQuery.fn.centerElement = function(parent) {
	var offsetTop = parent[0].offsetTop;
	var offsetLeft = parent[0].offsetLeft;
	(offsetTop == undefined) ? offsetTop = 0 : '';
	(offsetLeft == undefined) ? offsetLeft = 0 : '';
	this.css('position', 'absolute');
	this.css('top', offsetTop + (parent.height() - this.height()) / 2 + parent.scrollTop() + 'px');
	this.css('left', offsetLeft + (parent.width() - this.width()) / 2 + parent.scrollLeft() + 'px');
	return $(this);
};

// http://dextrose.be/2008/11/10/jquery-background-position-and-internet-explorer/
jQuery.fn.backgroundPosition = function() {
	var p = $(this).css('background-position');
	if (typeof(p) === 'undefined') {
		return $(this).css('background-position-x') + ' ' + $(this).css('background-position-y');
	}
	return p;
};
