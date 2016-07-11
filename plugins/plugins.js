// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.



$(document).ready(function()
{
$("#firstpane p.menu_head").click(function(){
	
	$(this).css({	
		backgroundImage:"url(https://lh5.googleusercontent.com/-BBN4_uSiCs4/TlQJSAXI5CI/AAAAAAAABnk/cmdGRetC38U/flecha-arriba.png)"
	}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
	
	$(this).siblings().css({
		backgroundImage:"url(https://lh5.googleusercontent.com/-mQHPLQrjxcI/TlQJSHgEsZI/AAAAAAAABno/HbkoM9nbaWQ/flecha-abajo.png)"});
	});

});