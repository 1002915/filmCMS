<!DOCTYPE html>
<html lang="en" >

<head>

	
	<script>
window.ts_endpoint_url = "https:\/\/slack.com\/beacon\/timing";

(function(e) {
	var n=Date.now?Date.now():+new Date,r=e.performance||{},t=[],a={},i=function(e,n){for(var r=0,a=t.length,i=[];a>r;r++)t[r][e]==n&&i.push(t[r]);return i},o=function(e,n){for(var r,a=t.length;a--;)r=t[a],r.entryType!=e||void 0!==n&&r.name!=n||t.splice(a,1)};r.now||(r.now=r.webkitNow||r.mozNow||r.msNow||function(){return(Date.now?Date.now():+new Date)-n}),r.mark||(r.mark=r.webkitMark||function(e){var n={name:e,entryType:"mark",startTime:r.now(),duration:0};t.push(n),a[e]=n}),r.measure||(r.measure=r.webkitMeasure||function(e,n,r){n=a[n].startTime,r=a[r].startTime,t.push({name:e,entryType:"measure",startTime:n,duration:r-n})}),r.getEntriesByType||(r.getEntriesByType=r.webkitGetEntriesByType||function(e){return i("entryType",e)}),r.getEntriesByName||(r.getEntriesByName=r.webkitGetEntriesByName||function(e){return i("name",e)}),r.clearMarks||(r.clearMarks=r.webkitClearMarks||function(e){o("mark",e)}),r.clearMeasures||(r.clearMeasures=r.webkitClearMeasures||function(e){o("measure",e)}),e.performance=r,"function"==typeof define&&(define.amd||define.ajs)&&define("performance",[],function(){return r}) // eslint-disable-line
})(window);

</script>
<script>;(function() {

'use strict';


window.TSMark = function(mark_label) {
	if (!window.performance || !window.performance.mark) return;
	performance.mark(mark_label);
};
window.TSMark('start_load');


window.TSMeasureAndBeacon = function(measure_label, start_mark_label) {
	if (start_mark_label === 'start_nav' && window.performance && window.performance.timing) {
		window.TSBeacon(measure_label, (new Date()).getTime() - performance.timing.navigationStart);
		return;
	}
	if (!window.performance || !window.performance.mark || !window.performance.measure) return;
	performance.mark(start_mark_label + '_end');
	try {
		performance.measure(measure_label, start_mark_label, start_mark_label + '_end');
		window.TSBeacon(measure_label, performance.getEntriesByName(measure_label)[0].duration);
	} catch(e) { return; }
};


window.TSBeacon = function(label, value) {
	var endpoint_url = window.ts_endpoint_url || 'https://slack.com/beacon/timing';
	(new Image()).src = endpoint_url + '?data=' + encodeURIComponent(label + ':' + value);
};

})();
</script>
 

<script>
window.TSMark('step_load');
</script>	<noscript><meta http-equiv="refresh" content="0; URL=/files/tatiana/F0ZFS5Y5V/jquery.form-validator.js?nojsmode=1" /></noscript>
<script type="text/javascript">
(function() {
	var start_time = Date.now();
	var logs = [];
	var connecting = true;
	var ever_connected = false;
	var log_namespace;
		
	var logWorker = function(ob) {
		var log_str = ob.secs+' start_label:'+ob.start_label+' measure_label:'+ob.measure_label+' description:'+ob.description;
		
		if (TS.timing.getLatestMark(ob.start_label)){
			TS.timing.measure(ob.measure_label, ob.start_label);
			TS.log(88, log_str);
			
			if (ob.do_reset) {
				window.TSMark(ob.start_label);
			}
		} else {
			TS.maybeWarn(88, 'not timing: '+log_str);
		}
	}
	
	var log = function(k, description) {
		var secs = (Date.now()-start_time)/1000;

		logs.push({
			k: k,
			d: description,
			t: secs,
			c: !!connecting
		})
	
		if (!window.boot_data) return;
		if (!window.TS) return;
		if (!TS.timing) return;
		if (!connecting) return;
		
		// lazy assignment
		log_namespace = log_namespace || (function() {
			if (boot_data.app == 'client') return 'client';
			if (boot_data.app == 'space') return 'post';
			if (boot_data.app == 'api') return 'apisite';
			if (boot_data.app == 'mobile') return 'mobileweb';
			if (boot_data.app == 'web' || boot_data.app == 'oauth') return 'web';
			return 'unknown';
		})();
		
		var modifier = (TS.boot_data.feature_no_rollups) ? '_no_rollups' : '';
		
		logWorker({
			k: k,
			secs: secs,
			description: description,
			start_label: ever_connected ? 'start_reconnect' : 'start_load',
			measure_label: 'v2_'+log_namespace+modifier+(ever_connected ? '_reconnect__' : '_load__')+k,
			do_reset: false,
		});
	}
	
	var setConnecting = function(val) {
		val = !!val;
		if (val == connecting) return;
		
		if (val) {
			log('start');
			if (ever_connected) {
				// we just started reconnecting, so reset timing
				window.TSMark('start_reconnect');
				window.TSMark('step_reconnect');
				window.TSMark('step_load');
			}
		
			connecting = val;
			log('start');
		} else {
			log('over');
			ever_connected = true;
			connecting = val;
		}
	}
	
	window.TSConnLogger = {
		log: log,
		logs: logs,
		start_time: start_time,
		setConnecting: setConnecting
	}
})();

if(self!==top)window.document.write("\u003Cstyle>body * {display:none !important;}\u003C\/style>\u003Ca href=\"#\" onclick="+
"\"top.location.href=window.location.href\" style=\"display:block !important;padding:10px\">Go to Slack.com\u003C\/a>");
</script>


<script type="text/javascript">
window.callSlackAPIUnauthed = function(method, args, callback) {
	var url = '/api/'+method+'?t='+Date.now();
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			req.onreadystatechange = null;
			var obj;
			
			if (req.status == 200) {
				if (req.responseText.indexOf('{') == 0) {
					try {
						eval('obj = '+req.responseText);
					} catch (err) {
						console.warn('unable to do anything with api rsp');
					}
				}
			}
			
			obj = obj || {
				ok: false	
			}
			
			callback(obj.ok, obj, args);
		}
	}
	
	req.open('POST', url, 1);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	var args2 = [];
	for (i in args) {
		args2[args2.length] = encodeURIComponent(i)+'='+encodeURIComponent(args[i]);
	}

	req.send(args2.join('&'));
}
</script>

						
	
		<script>
			if (window.location.host == 'slack.com' && window.location.search.indexOf('story') < 0) {
				document.cookie = '__cvo_skip_doc=' + escape(document.URL) + '|' + escape(document.referrer) + ';path=/';
			}
		</script>
	

	
	<script type="text/javascript">

				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', "UA-106458-17", 'slack.com');

				
		ga('send', 'pageview');
	
		(function(e,c,b,f,d,g,a){e.SlackBeaconObject=d;
		e[d]=e[d]||function(){(e[d].q=e[d].q||[]).push([1*new Date(),arguments])};
		e[d].l=1*new Date();g=c.createElement(b);a=c.getElementsByTagName(b)[0];
		g.async=1;g.src=f;a.parentNode.insertBefore(g,a)
		})(window,document,"script","https://a.slack-edge.com/dcf8/js/libs/beacon.js","sb");
		sb('set', 'token', '3307f436963e02d4f9eb85ce5159744c');

					sb('set', 'user_id', "U0MRF6CA0");
							sb('set', 'user_' + "batch", "signup_api");
							sb('set', 'user_' + "created", "2016-02-17");
						sb('set', 'name_tag', "saebneweb" + '/' + "matthew_neal");
				sb('track', 'pageview');

		function track(a){ga('send','event','web',a);sb('track',a);}

	</script>


		<script type='text/javascript'>
		
		(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
		for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
		

		mixpanel.init("12d52d8633a5b432975592d13ebd3f34");

		
			function mixpanel_track(){if(window.mixpanel)mixpanel.track.apply(mixpanel, arguments);}
			function mixpanel_track_forms(){if(window.mixpanel)mixpanel.track_forms.apply(mixpanel, arguments);}
			function mixpanel_track_links(){if(window.mixpanel)mixpanel.track_links.apply(mixpanel, arguments);}
		
	</script>
	
	<meta name="referrer" content="no-referrer">
		<meta name="superfish" content="nofish">

	<script type="text/javascript">



var TS_last_log_date = null;
var TSMakeLogDate = function() {
	var date = new Date();

	var y = date.getFullYear();
	var mo = date.getMonth()+1;
	var d = date.getDate();

	var time = {
	  h: date.getHours(),
	  mi: date.getMinutes(),
	  s: date.getSeconds(),
	  ms: date.getMilliseconds()
	};

	Object.keys(time).map(function(moment, index) {
		if (moment == 'ms') {
			if (time[moment] < 10) {
				time[moment] = time[moment]+'00';
			} else if (time[moment] < 100) {
				time[moment] = time[moment]+'0';
			}
		} else if (time[moment] < 10) {
			time[moment] = '0' + time[moment];
		}
	});

	var str = y + '/' + mo + '/' + d + ' ' + time.h + ':' + time.mi + ':' + time.s + '.' + time.ms;
	if (TS_last_log_date) {
		var diff = date-TS_last_log_date;
		//str+= ' ('+diff+'ms)';
	}
	TS_last_log_date = date;
	return str+' ';
}

var parseDeepLinkRequest = function(code) {
	var m = code.match(/"id":"([CDG][A-Z0-9]{8})"/);
	var id = m ? m[1] : null;

	m = code.match(/"team":"(T[A-Z0-9]{8})"/);
	var team = m ? m[1] : null;

	m = code.match(/"message":"([0-9]+\.[0-9]+)"/);
	var message = m ? m[1] : null;

	return { id: id, team: team, message: message };
}

if ('rendererEvalAsync' in window) {
	var origRendererEvalAsync = window.rendererEvalAsync;
	window.rendererEvalAsync = function(blob) {
		try {
			var data = JSON.parse(decodeURIComponent(atob(blob)));
			if (data.code.match(/handleDeepLink/)) {
				var request = parseDeepLinkRequest(data.code);
				if (!request.id || !request.team || !request.message) return;

				request.cmd = 'channel';
				TSSSB.handleDeepLinkWithArgs(JSON.stringify(request));
				return;
			} else {
				origRendererEvalAsync(blob);
			}
		} catch (e) {
		}
	}
}
</script>



<script type="text/javascript">

	var TSSSB = {
		call: function() {
			return false;
		}
	};

</script>
<script>TSSSB.env = (function() {
	var v = {
		win_ssb_version: null,
		win_ssb_version_minor: null,
		mac_ssb_version: null,
		mac_ssb_version_minor: null,
		mac_ssb_build: null,
		lin_ssb_version: null,
		lin_ssb_version_minor: null
	};
	
	var is_win = (navigator.appVersion.indexOf("Windows") !== -1);
	var is_lin = (navigator.appVersion.indexOf("Linux") !== -1);
	var is_mac = !!(navigator.userAgent.match(/(OS X)/g));

	if (navigator.userAgent.match(/(Slack_SSB)/g) || navigator.userAgent.match(/(Slack_WINSSB)/g)) {
		
		var parts = navigator.userAgent.split('/');
		var version_str = parts[parts.length-1];
		var version_float = parseFloat(version_str);
		var versionA = version_str.split('.');
		var version_minor = (versionA.length == 3) ? parseInt(versionA[2]) : 0;

		if (navigator.userAgent.match(/(AtomShell)/g)) {
			
			if (is_lin) {
				v.lin_ssb_version = version_float;
				v.lin_ssb_version_minor = version_minor;
			} else {
				v.win_ssb_version = version_float;
				v.win_ssb_version_minor = version_minor;
			}
		} else {
			
			v.mac_ssb_version = version_float;
			v.mac_ssb_version_minor = version_minor;
			
			
			
			var app_ver = window.macgap && macgap.app && macgap.app.buildVersion && macgap.app.buildVersion();
			var matches = String(app_ver).match(/(?:\()(.*)(?:\))/);
			v.mac_ssb_build = (matches && matches.length == 2) ? parseInt(matches[1] || 0) : 0;
		}
	}

	return v;
})();
</script>


	<script type="text/javascript">
		
		var was_TS = window.TS;
		delete window.TS;
		TSSSB.call('didFinishLoading');
		if (was_TS) window.TS = was_TS;
	</script>
	    <title>jquery.form-validator.js | SAEBNEWeb Slack</title>
    <meta name="author" content="Slack">

	
		
	
	
					
	
				
	
	
	
	
			<!-- output_css "core" -->
    <link href="https://a.slack-edge.com/63eeb/style/rollup-plastic.css" rel="stylesheet" type="text/css">

		<!-- output_css "before_file_pages" -->
    <link href="https://a.slack-edge.com/4821/style/libs/codemirror.css" rel="stylesheet" type="text/css">
    <link href="https://a.slack-edge.com/838e/style/codemirror_overrides.css" rel="stylesheet" type="text/css">

	<!-- output_css "file_pages" -->
    <link href="https://a.slack-edge.com/3a14/style/rollup-file_pages.css" rel="stylesheet" type="text/css">

	<!-- output_css "regular" -->
    <link href="https://a.slack-edge.com/d64a/style/print.css" rel="stylesheet" type="text/css">
    <link href="https://a.slack-edge.com/1d9c/style/libs/lato-1-compressed.css" rel="stylesheet" type="text/css">

	

	
	
	
	

	
<link id="favicon" rel="shortcut icon" href="https://a.slack-edge.com/66f9/img/icons/favicon-32.png" sizes="16x16 32x32 48x48" type="image/png" />

<link rel="icon" href="https://a.slack-edge.com/0180/img/icons/app-256.png" sizes="256x256" type="image/png" />

<link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://a.slack-edge.com/66f9/img/icons/ios-152.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://a.slack-edge.com/66f9/img/icons/ios-144.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://a.slack-edge.com/66f9/img/icons/ios-120.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://a.slack-edge.com/66f9/img/icons/ios-114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://a.slack-edge.com/0180/img/icons/ios-72.png" />
<link rel="apple-touch-icon-precomposed" href="https://a.slack-edge.com/66f9/img/icons/ios-57.png" />

<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="https://a.slack-edge.com/66f9/img/icons/app-144.png" />	<script>
!function(a,b){function c(a,b){try{if("function"!=typeof a)return a;if(!a.bugsnag){var c=e();a.bugsnag=function(d){if(b&&b.eventHandler&&(u=d),v=c,!y){var e=a.apply(this,arguments);return v=null,e}try{return a.apply(this,arguments)}catch(f){throw l("autoNotify",!0)&&(x.notifyException(f,null,null,"error"),s()),f}finally{v=null}},a.bugsnag.bugsnag=a.bugsnag}return a.bugsnag}catch(d){return a}}function d(){B=!1}function e(){var a=document.currentScript||v;if(!a&&B){var b=document.scripts||document.getElementsByTagName("script");a=b[b.length-1]}return a}function f(a){var b=e();b&&(a.script={src:b.src,content:l("inlineScript",!0)?b.innerHTML:""})}function g(b){var c=l("disableLog"),d=a.console;void 0===d||void 0===d.log||c||d.log("[Bugsnag] "+b)}function h(b,c,d){if(d>=5)return encodeURIComponent(c)+"=[RECURSIVE]";d=d+1||1;try{if(a.Node&&b instanceof a.Node)return encodeURIComponent(c)+"="+encodeURIComponent(r(b));var e=[];for(var f in b)if(b.hasOwnProperty(f)&&null!=f&&null!=b[f]){var g=c?c+"["+f+"]":f,i=b[f];e.push("object"==typeof i?h(i,g,d):encodeURIComponent(g)+"="+encodeURIComponent(i))}return e.join("&")}catch(j){return encodeURIComponent(c)+"="+encodeURIComponent(""+j)}}function i(a,b){if(null==b)return a;a=a||{};for(var c in b)if(b.hasOwnProperty(c))try{a[c]=b[c].constructor===Object?i(a[c],b[c]):b[c]}catch(d){a[c]=b[c]}return a}function j(a,b){a+="?"+h(b)+"&ct=img&cb="+(new Date).getTime();var c=new Image;c.src=a}function k(a){var b={},c=/^data\-([\w\-]+)$/;if(a)for(var d=a.attributes,e=0;e<d.length;e++){var f=d[e];if(c.test(f.nodeName)){var g=f.nodeName.match(c)[1];b[g]=f.value||f.nodeValue}}return b}function l(a,b){C=C||k(J);var c=void 0!==x[a]?x[a]:C[a.toLowerCase()];return"false"===c&&(c=!1),void 0!==c?c:b}function m(a){return a&&a.match(D)?!0:(g("Invalid API key '"+a+"'"),!1)}function n(b,c){var d=l("apiKey");if(m(d)&&A){A-=1;var e=l("releaseStage"),f=l("notifyReleaseStages");if(f){for(var h=!1,k=0;k<f.length;k++)if(e===f[k]){h=!0;break}if(!h)return}var n=[b.name,b.message,b.stacktrace].join("|");if(n!==w){w=n,u&&(c=c||{},c["Last Event"]=q(u));var o={notifierVersion:H,apiKey:d,projectRoot:l("projectRoot")||a.location.protocol+"//"+a.location.host,context:l("context")||a.location.pathname,userId:l("userId"),user:l("user"),metaData:i(i({},l("metaData")),c),releaseStage:e,appVersion:l("appVersion"),url:a.location.href,userAgent:navigator.userAgent,language:navigator.language||navigator.userLanguage,severity:b.severity,name:b.name,message:b.message,stacktrace:b.stacktrace,file:b.file,lineNumber:b.lineNumber,columnNumber:b.columnNumber,payloadVersion:"2"},p=x.beforeNotify;if("function"==typeof p){var r=p(o,o.metaData);if(r===!1)return}return 0===o.lineNumber&&/Script error\.?/.test(o.message)?g("Ignoring cross-domain script error. See https://bugsnag.com/docs/notifiers/js/cors"):(j(l("endpoint")||G,o),void 0)}}}function o(){var a,b,c=10,d="[anonymous]";try{throw new Error("")}catch(e){a="<generated>\n",b=p(e)}if(!b){a="<generated-ie>\n";var f=[];try{for(var h=arguments.callee.caller.caller;h&&f.length<c;){var i=E.test(h.toString())?RegExp.$1||d:d;f.push(i),h=h.caller}}catch(j){g(j)}b=f.join("\n")}return a+b}function p(a){return a.stack||a.backtrace||a.stacktrace}function q(a){var b={millisecondsAgo:new Date-a.timeStamp,type:a.type,which:a.which,target:r(a.target)};return b}function r(a){if(a){var b=a.attributes;if(b){for(var c="<"+a.nodeName.toLowerCase(),d=0;d<b.length;d++)b[d].value&&"null"!=b[d].value.toString()&&(c+=" "+b[d].name+'="'+b[d].value+'"');return c+">"}return a.nodeName}}function s(){z+=1,a.setTimeout(function(){z-=1})}function t(a,b,c){var d=a[b],e=c(d);a[b]=e}var u,v,w,x={},y=!0,z=0,A=10;x.noConflict=function(){return a.Bugsnag=b,x},x.refresh=function(){A=10},x.notifyException=function(a,b,c,d){b&&"string"!=typeof b&&(c=b,b=void 0),c||(c={}),f(c),n({name:b||a.name,message:a.message||a.description,stacktrace:p(a)||o(),file:a.fileName||a.sourceURL,lineNumber:a.lineNumber||a.line,columnNumber:a.columnNumber?a.columnNumber+1:void 0,severity:d||"warning"},c)},x.notify=function(b,c,d,e){n({name:b,message:c,stacktrace:o(),file:a.location.toString(),lineNumber:1,severity:e||"warning"},d)};var B="complete"!==document.readyState;document.addEventListener?(document.addEventListener("DOMContentLoaded",d,!0),a.addEventListener("load",d,!0)):a.attachEvent("onload",d);var C,D=/^[0-9a-f]{32}$/i,E=/function\s*([\w\-$]+)?\s*\(/i,F="https://notify.bugsnag.com/",G=F+"js",H="2.4.7",I=document.getElementsByTagName("script"),J=I[I.length-1];if(a.atob){if(a.ErrorEvent)try{0===new a.ErrorEvent("test").colno&&(y=!1)}catch(K){}}else y=!1;if(l("autoNotify",!0)){t(a,"onerror",function(b){return function(c,d,e,g,h){var i=l("autoNotify",!0),j={};!g&&a.event&&(g=a.event.errorCharacter),f(j),v=null,i&&!z&&n({name:h&&h.name||"window.onerror",message:c,file:d,lineNumber:e,columnNumber:g,stacktrace:h&&p(h)||o(),severity:"error"},j),b&&b(c,d,e,g,h)}});var L=function(a){return function(b,d){if("function"==typeof b){b=c(b);var e=Array.prototype.slice.call(arguments,2);return a(function(){b.apply(this,e)},d)}return a(b,d)}};t(a,"setTimeout",L),t(a,"setInterval",L),a.requestAnimationFrame&&t(a,"requestAnimationFrame",function(a){return function(b){return a(c(b))}}),a.setImmediate&&t(a,"setImmediate",function(a){return function(){var b=Array.prototype.slice.call(arguments);return b[0]=c(b[0]),a.apply(this,b)}}),"EventTarget Window Node ApplicationCache AudioTrackList ChannelMergerNode CryptoOperation EventSource FileReader HTMLUnknownElement IDBDatabase IDBRequest IDBTransaction KeyOperation MediaController MessagePort ModalWindow Notification SVGElementInstance Screen TextTrack TextTrackCue TextTrackList WebSocket WebSocketWorker Worker XMLHttpRequest XMLHttpRequestEventTarget XMLHttpRequestUpload".replace(/\w+/g,function(b){var d=a[b]&&a[b].prototype;d&&d.hasOwnProperty&&d.hasOwnProperty("addEventListener")&&(t(d,"addEventListener",function(a){return function(b,d,e,f){return d&&d.handleEvent&&(d.handleEvent=c(d.handleEvent,{eventHandler:!0})),a.call(this,b,c(d,{eventHandler:!0}),e,f)}}),t(d,"removeEventListener",function(a){return function(b,d,e,f){return a.call(this,b,d,e,f),a.call(this,b,c(d),e,f)}}))})}a.Bugsnag=x,"function"==typeof define&&define.amd?define([],function(){return x}):"object"==typeof module&&"object"==typeof module.exports&&(module.exports=x)}(window,window.Bugsnag);
Bugsnag.apiKey = "2a86b308af5a81d2c9329fedfb4b30c7";
Bugsnag.appVersion = "9fbe87666e87cb4161d238f7868871797e8b2f58" + '-' + "1460330883";
Bugsnag.endpoint = "https://errors-webapp.slack-core.com/js";
Bugsnag.releaseStage = "prod";
Bugsnag.autoNotify = false;
Bugsnag.user = {id:"U0MRF6CA0",name:"matthew_neal",email:"1002915@student.sae.edu.au"};
Bugsnag.metaData = {};
Bugsnag.metaData.team = {id:"T0MFS1C1X",name:"SAEBNEWeb",domain:"saebneweb"};
Bugsnag.refresh_interval = setInterval(function () { (window.TS && window.TS.client) ? Bugsnag.refresh() : clearInterval(Bugsnag.refresh_interval); }, 15 * 60 * 1000);
</script>
	
	<!--[if lt IE 9]>
	<script src="https://a.slack-edge.com/ef0d/js/libs/html5shiv.js"></script>
	<![endif]-->

</head>

<body class="		">

		  			<script>
		
			var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
			if (w > 1440) document.querySelector('body').classList.add('widescreen');
		
		</script>
	
  	
	

			<nav id="site_nav" class="no_transition">

	<div id="site_nav_contents">

		<div id="user_menu">
			<div id="user_menu_contents">
				<div id="user_menu_avatar">
										<span class="member_image thumb_48" style="background-image: url('https://avatars.slack-edge.com/2016-02-18/21872958295_24ee33803810f0cd11b7_192.jpg')" data-thumb-size="48" data-member-id="U0MRF6CA0"></span>
					<span class="member_image thumb_36" style="background-image: url('https://avatars.slack-edge.com/2016-02-18/21872958295_24ee33803810f0cd11b7_72.jpg')" data-thumb-size="36" data-member-id="U0MRF6CA0"></span>
				</div>
				<h3>Signed in as</h3>
				<span id="user_menu_name">matthew_neal</span>
			</div>
		</div>

		<div class="nav_contents">

			<ul class="primary_nav">
				<li><a href="/home" data-qa="home"><i class="ts_icon ts_icon_home"></i>Home</a></li>
				<li><a href="/account" data-qa="account_profile"><i class="ts_icon ts_icon_user"></i>Account & Profile</a></li>
				<li><a href="/apps/manage" data-qa="configure_apps" target="_blank"><i class="ts_icon ts_icon_plug"></i>Configure Apps</a></li>
				<li><a href="/archives"data-qa="archives"><i class="ts_icon ts_icon_archive" ></i>Message Archives</a></li>
				<li><a href="/files" data-qa="files"><i class="ts_icon ts_icon_all_files clear_blue"></i>Files</a></li>
				<li><a href="/team" data-qa="team_directory"><i class="ts_icon ts_icon_team_directory"></i>Team Directory</a></li>
									<li><a href="/stats" data-qa="statistics"><i class="ts_icon ts_icon_dashboard"></i>Statistics</a></li>
													<li><a href="/customize" data-qa="customize"><i class="ts_icon ts_icon_magic"></i>Customize</a></li>
													<li><a href="/account/team" data-qa="team_settings"><i class="ts_icon ts_icon_cog_o"></i>Team Settings</a></li>
							</ul>

			
		</div>

		<div id="footer">

			<ul id="footer_nav">
				<li><a href="/is" data-qa="tour">Tour</a></li>
				<li><a href="/downloads" data-qa="download_apps">Download Apps</a></li>
				<li><a href="/brand-guidelines" data-qa="brand_guidelines">Brand Guidelines</a></li>
				<li><a href="/help" data-qa="help">Help</a></li>
				<li><a href="https://api.slack.com" target="_blank" data-qa="api">API<i class="ts_icon ts_icon_external_link small_left_margin ts_icon_inherit"></i></a></li>
								<li><a href="/pricing" data-qa="pricing">Pricing</a></li>
				<li><a href="/help/requests/new" data-qa="contact">Contact</a></li>
				<li><a href="/terms-of-service" data-qa="policies">Policies</a></li>
				<li><a href="http://slackhq.com/" target="_blank" data-qa="our_blog">Our Blog</a></li>
				<li><a href="https://slack.com/signout/21536046065?crumb=s-1460341060-ecbded3a41-%E2%98%83" data-qa="sign_out">Sign Out<i class="ts_icon ts_icon_sign_out small_left_margin ts_icon_inherit"></i></a></li>
			</ul>

			<p id="footer_signature">Made with <i class="ts_icon ts_icon_heart"></i> by Slack</p>

		</div>

	</div>
</nav>	
			<header>
			<a id="menu_toggle" class="no_transition" data-qa="menu_toggle_hamburger">
			<span class="menu_icon"></span>
			<span class="menu_label">Menu</span>
			<span class="vert_divider"></span>
		</a>
		<h1 id="header_team_name" class="inline_block no_transition" data-qa="header_team_name">
			<a href="/home">
				<i class="ts_icon ts_icon_home" /></i>
				SAEBNEWeb
			</a>
		</h1>
		<div class="header_nav">
			<div class="header_btns float_right">
				<a id="team_switcher" data-qa="team_switcher">
					<i class="ts_icon ts_icon_th_large ts_icon_inherit"></i>
					<span class="block label">Teams</span>
				</a>
				<a href="/help" id="help_link" data-qa="help_link">
					<i class="ts_icon ts_icon_life_ring ts_icon_inherit"></i>
					<span class="block label">Help</span>
				</a>
									<a href="/messages" data-qa="launch">
						<img src="https://a.slack-edge.com/66f9/img/icons/ios-64.png" srcset="https://a.slack-edge.com/66f9/img/icons/ios-32.png 1x, https://a.slack-edge.com/66f9/img/icons/ios-64.png 2x" />
						<span class="block label">Launch</span>
					</a>
							</div>
				                    <ul id="header_team_nav" data-qa="team_switcher_menu">
	                        	                            <li class="active">
	                            	<a href="https://saebneweb.slack.com/home" target="https://saebneweb.slack.com/">
	                            			                            			<i class="ts_icon small ts_icon_check_circle_o active_icon s"></i>
	                            			                            				                            		<i class="team_icon small" style="background-image: url('https://s3-us-west-2.amazonaws.com/slack-files2/avatars/2016-02-17/21701475441_1a50db4e22c1cf9ca4ca_88.png');"></i>
		                            		                            		<span class="switcher_label team_name">SAEBNEWeb</span>
	                            	</a>
	                            </li>
	                        	                        <li id="add_team_option"><a href="https://slack.com/signin" target="_blank"><i class="ts_icon ts_icon_plus team_icon small"></i> <span class="switcher_label">Sign in to another team...</span></a></li>
	                    </ul>
	                		</div>
	
	
</header>	
	<div id="page" >

		<div id="page_contents" data-qa="page_contents" class="">

<p class="print_only">
	<strong>Created by tatiana on April 11, 2016 at 12:10 PM</strong><br />
	<span class="subtle_silver break_word">https://saebneweb.slack.com/files/tatiana/F0ZFS5Y5V/jquery.form-validator.js</span>
</p>

<div class="file_header_container no_print"></div>

<div class="alert_container">
		<div class="file_public_link_shared alert" style="display: none;">
		
	<i class="ts_icon ts_icon_link"></i> Public Link: <a class="file_public_link" href="https://slack-files.com/T0MFS1C1X-F0ZFS5Y5V-169670f89f" target="new">https://slack-files.com/T0MFS1C1X-F0ZFS5Y5V-169670f89f</a>
</div></div>

<div id="file_page" class="card top_padding">

	<p class="small subtle_silver no_print meta">
		71KB JavaScript/JSON snippet created on <span class="date">April 11th 2016</span>.
		This file is private.		<span class="file_share_list"></span>
	</p>

	<a id="file_action_cog" class="action_cog action_cog_snippet float_right no_print">
		<span>Actions </span><i class="ts_icon ts_icon_cog"></i>
	</a>
	<a id="snippet_expand_toggle" class="float_right no_print">
		<i class="ts_icon ts_icon_expand "></i>
		<i class="ts_icon ts_icon_compress hidden"></i>
	</a>

	<div class="large_bottom_margin clearfix">
		<pre id="file_contents">(function (root, factory) {
  if (typeof define === &#039;function&#039; &amp;&amp; define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define([&quot;jquery&quot;], function (a0) {
      return (factory(a0));
    });
  } else if (typeof exports === &#039;object&#039;) {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require(&quot;jquery&quot;));
  } else {
    factory(jQuery);
  }
}(this, function (jQuery) {

/** File generated by Grunt -- do not modify
 *  JQUERY-FORM-VALIDATOR
 *
 *  @version 2.2.201
 *  @website http://formvalidator.net/
 *  @author Victor Jonsson, http://victorjonsson.se
 *  @license MIT
 */
/**
 * Deprecated functions and attributes
 * @todo: Remove in release of 3.0
 */
(function ($, undefined) {

  &#039;use strict&#039;;

  /**
   * @deprecated
   * @param language
   * @param conf
   */
  $.fn.validateForm = function (language, conf) {
    $.formUtils.warn(&#039;Use of deprecated function $.validateForm, use $.isValid instead&#039;);
    return this.isValid(language, conf, true);
  };

  $(window).on(&#039;validatorsLoaded formValidationSetup&#039;, function(evt, $form, config) {
    if( !$form ) {
      $form = $(&#039;form&#039;);
    }

    addSupportForCustomErrorMessageCallback(config);
    addSupportForElementReferenceInPositionParam(config);
    addSupportForValidationDependingOnCheckedInput($form);
  });


  function addSupportForCustomErrorMessageCallback(config) {
    if (config &amp;&amp;
        config.errorMessagePosition === &#039;custom&#039; &amp;&amp;
        typeof config.errorMessageCustom === &#039;function&#039;) {

      $.formUtils.warn(&#039;Use of deprecated function errorMessageCustom, use config.submitErrorMessageCallback instead&#039;);

      config.submitErrorMessageCallback = function($form, errorMessages) {
        config.errorMessageCustom(
            $form,
            config.language.errorTitle,
            errorMessages,
            config
        );
      };
    }
  }

  function addSupportForElementReferenceInPositionParam(config) {
    if (config.errorMessagePosition &amp;&amp; typeof config.errorMessagePosition === &#039;object&#039;) {
      $.formUtils.warn(&#039;Deprecated use of config parameter errorMessagePosition, use config.submitErrorMessageCallback instead&#039;);
      var $errorMessageContainer = config.errorMessagePosition;
      config.errorMessagePosition = &#039;top&#039;;
      config.submitErrorMessageCallback = function() {
        return $errorMessageContainer;
      };
    }
  }

  function addSupportForValidationDependingOnCheckedInput($form) {
    var $inputsDependingOnCheckedInputs = $form.find(&#039;[data-validation-if-checked]&#039;);
    if ($inputsDependingOnCheckedInputs.length) {
      $.formUtils.warn(
        &#039;Detected use of attribute &quot;data-validation-if-checked&quot; which is &#039;+
        &#039;deprecated. Use &quot;data-validation-depends-on&quot; provided by module &quot;logic&quot;&#039;
      );
    }

    $inputsDependingOnCheckedInputs
      .on(&#039;beforeValidation&#039;, function() {

        var $elem = $(this),
          nameOfDependingInput = $elem.valAttr(&#039;if-checked&#039;);

        // Set the boolean telling us that the validation depends
        // on another input being checked
        var $dependingInput = $(&#039;input[name=&quot;&#039; + nameOfDependingInput + &#039;&quot;]&#039;, $form),
          dependingInputIsChecked = $dependingInput.is(&#039;:checked&#039;),
          valueOfDependingInput = ($.formUtils.getValue($dependingInput) || &#039;&#039;).toString(),
          requiredValueOfDependingInput = $elem.valAttr(&#039;if-checked-value&#039;);

        if (!dependingInputIsChecked || !(
              !requiredValueOfDependingInput ||
              requiredValueOfDependingInput === valueOfDependingInput
          )) {
          $elem.valAttr(&#039;skipped&#039;, true);
        }

      });
    }

})(jQuery);

/**
 * Utility methods used for displaying error messages (attached to $.formUtils)
 */
(function ($) {

  &#039;use strict&#039;;

  var dialogs = {

    resolveErrorMessage: function($elem, validator, validatorName, conf, language) {
      var errorMsgAttr = conf.validationErrorMsgAttribute + &#039;-&#039; + validatorName.replace(&#039;validate_&#039;, &#039;&#039;),
        validationErrorMsg = $elem.attr(errorMsgAttr);

      if (!validationErrorMsg) {
        validationErrorMsg = $elem.attr(conf.validationErrorMsgAttribute);
        if (!validationErrorMsg) {
          if (typeof validator.errorMessageKey !== &#039;function&#039;) {
            validationErrorMsg = language[validator.errorMessageKey];
          }
          else {
            validationErrorMsg = language[validator.errorMessageKey(conf)];
          }
          if (!validationErrorMsg) {
            validationErrorMsg = validator.errorMessage;
          }
        }
      }
      return validationErrorMsg;
    },
    getParentContainer: function ($elem) {
      if ($elem.valAttr(&#039;error-msg-container&#039;)) {
        return $($elem.valAttr(&#039;error-msg-container&#039;));
      } else {
        var $parent = $elem.parent();
        if (!$parent.hasClass(&#039;form-group&#039;) &amp;&amp; !$parent.closest(&#039;form&#039;).hasClass(&#039;form-horizontal&#039;)) {
          var $formGroup = $parent.closest(&#039;.form-group&#039;);
          if ($formGroup.length) {
            return $formGroup.eq(0);
          }
        }
        return $parent;
      }
    },
    applyInputErrorStyling: function ($input, conf) {
      $input
        .addClass(conf.errorElementClass)
        .removeClass(&#039;valid&#039;);

      this.getParentContainer($input)
        .addClass(conf.inputParentClassOnError)
        .removeClass(conf.inputParentClassOnSuccess);

      if (conf.borderColorOnError !== &#039;&#039;) {
        $input.css(&#039;border-color&#039;, conf.borderColorOnError);
      }
    },
    applyInputSuccessStyling: function($input, conf) {
      $input.addClass(&#039;valid&#039;);
      this.getParentContainer($input)
        .addClass(conf.inputParentClassOnSuccess);
    },
    removeInputStylingAndMessage: function($input, conf) {

      // Reset input css
      $input
        .removeClass(&#039;valid&#039;)
        .removeClass(conf.errorElementClass)
        .css(&#039;border-color&#039;, &#039;&#039;);

      var $parentContainer = dialogs.getParentContainer($input);

      // Reset parent css
      $parentContainer
        .removeClass(conf.inputParentClassOnError)
        .removeClass(conf.inputParentClassOnSuccess);

      // Remove possible error message
      if (typeof conf.inlineErrorMessageCallback === &#039;function&#039;) {
        var $errorMessage = conf.inlineErrorMessageCallback($input, conf);
        if ($errorMessage) {
          $errorMessage.html(&#039;&#039;);
        }
      } else {
        $parentContainer
          .find(&#039;.&#039; + conf.errorMessageClass)
          .remove();
      }

    },
    removeAllMessagesAndStyling: function($form, conf) {

      // Remove error messages in top of form
      if (typeof conf.submitErrorMessageCallback === &#039;function&#039;) {
        var $errorMessagesInTopOfForm = conf.submitErrorMessageCallback($form, conf);
        if ($errorMessagesInTopOfForm) {
          $errorMessagesInTopOfForm.html(&#039;&#039;);
        }
      } else {
        $form.find(&#039;.&#039; + conf.errorMessageClass + &#039;.alert&#039;).remove();
      }

      // Remove input css/messages
      $form.find(&#039;.&#039; + conf.errorElementClass + &#039;,.valid&#039;).each(function() {
        dialogs.removeInputStylingAndMessage($(this), conf);
      });
    },
    setInlineMessage: function ($input, errorMsg, conf) {

      this.applyInputErrorStyling($input, conf);

      var custom = document.getElementById($input.attr(&#039;name&#039;) + &#039;_err_msg&#039;),
        $messageContainer = false,
        setErrorMessage = function ($elem) {
          $.formUtils.$win.trigger(&#039;validationErrorDisplay&#039;, [$input, $elem]);
          $elem.html(errorMsg);
        },
        addErrorToMessageContainer = function() {
          var $found = false;
          $messageContainer.find(&#039;.&#039; + conf.errorMessageClass).each(function () {
            if (this.inputReferer === $input[0]) {
              $found = $(this);
              return false;
            }
          });
          console.log($found);
          if ($found) {
            if (!errorMsg) {
              $found.remove();
            } else {
              setErrorMessage($found);
            }
          } else if(errorMsg !== &#039;&#039;) {
            $message = $(&#039;&lt;div class=&quot;&#039; + conf.errorMessageClass + &#039; alert&quot;&gt;&lt;/div&gt;&#039;);
            setErrorMessage($message);
            $message[0].inputReferer = $input[0];
            $messageContainer.prepend($message);
          }
        },
        $message;

      if (custom) {
        // Todo: remove in 3.0
        $.formUtils.warn(&#039;Using deprecated element reference &#039; + custom.id);
        $messageContainer = $(custom);
        addErrorToMessageContainer();
      } else if (typeof conf.inlineErrorMessageCallback === &#039;function&#039;) {
        $messageContainer = conf.inlineErrorMessageCallback($input, conf);
        if (!$messageContainer) {
          // Error display taken care of by inlineErrorMessageCallback
          return;
        }
        addErrorToMessageContainer();
      } else {
        var $parent = this.getParentContainer($input);
        $message = $parent.find(&#039;.&#039; + conf.errorMessageClass + &#039;.help-block&#039;);
        if ($message.length === 0) {
          $message = $(&#039;&lt;span&gt;&lt;/span&gt;&#039;).addClass(&#039;help-block&#039;).addClass(conf.errorMessageClass);
          $message.appendTo($parent);
        }
        setErrorMessage($message);
      }
    },
    setMessageInTopOfForm: function ($form, errorMessages, conf, lang) {
      var view = &#039;&lt;div class=&quot;{errorMessageClass} alert alert-danger&quot;&gt;&#039;+
                    &#039;&lt;strong&gt;{errorTitle}&lt;/strong&gt;&#039;+
                    &#039;&lt;ul&gt;{fields}&lt;/ul&gt;&#039;+
                &#039;&lt;/div&gt;&#039;,
          $container = false;

      if (typeof conf.submitErrorMessageCallback === &#039;function&#039;) {
        $container = conf.submitErrorMessageCallback($form, errorMessages, conf);
        console.log($container);
        if (!$container) {
          // message display taken care of by callback
          return;
        }
      }

      var viewParams = {
            errorTitle: lang.errorTitle,
            fields: &#039;&#039;,
            errorMessageClass: conf.errorMessageClass
          };

      $.each(errorMessages, function (i, msg) {
        viewParams.fields += &#039;&lt;li&gt;&#039;+msg+&#039;&lt;/li&gt;&#039;;
      });

      $.each(viewParams, function(param, value) {
        view = view.replace(&#039;{&#039;+param+&#039;}&#039;, value);
      });

      if ($container) {
        $container.html(view);
      } else {
        $form.children().eq(0).before($(view));
      }
    }
  };

  $.formUtils = $.extend($.formUtils || {}, {
    dialogs: dialogs
  });

})(jQuery);

/**
 * File declaring all methods if this plugin which is applied to $.fn.
 */
(function($, window) {

  &#039;use strict&#039;;

  var _helpers = 0;


  /**
   * Assigns validateInputOnBlur function to elements blur event
   *
   * @param {Object} language Optional, will override $.formUtils.LANG
   * @param {Object} conf Optional, will override the default settings
   * @return {jQuery}
   */
  $.fn.validateOnBlur = function (language, conf) {
    this.find(&#039;*[data-validation]&#039;)
      .bind(&#039;blur.validation&#039;, function () {
        $(this).validateInputOnBlur(language, conf, true, &#039;blur&#039;);
      });
    if (conf.validateCheckboxRadioOnClick) {
      // bind click event to validate on click for radio &amp; checkboxes for nice UX
      this.find(&#039;input[type=checkbox][data-validation],input[type=radio][data-validation]&#039;)
        .bind(&#039;click.validation&#039;, function () {
          $(this).validateInputOnBlur(language, conf, true, &#039;click&#039;);
        });
    }

    return this;
  };

  /*
   * Assigns validateInputOnBlur function to elements custom event
   * @param {Object} language Optional, will override $.formUtils.LANG
   * @param {Object} settings Optional, will override the default settings
   * * @return {jQuery}
   */
  $.fn.validateOnEvent = function (language, config) {
    var $elements = this[0].nodeName === &#039;FORM&#039; ? this.find(&#039;*[data-validation-event]&#039;) : this;
    $elements
      .each(function () {
        var $el = $(this),
          etype = $el.valAttr(&#039;event&#039;);
        if (etype) {
          $el
            .unbind(etype + &#039;.validation&#039;)
            .bind(etype + &#039;.validation&#039;, function (evt) {
              if( (evt || {}).keyCode !== 9 ) {
                $(this).validateInputOnBlur(language, config, true, etype);
              }
            });
        }
      });
    return this;
  };

  /**
   * fade in help message when input gains focus
   * fade out when input loses focus
   * &lt;input data-help=&quot;The info that I want to display for the user when input is focused&quot; ... /&gt;
   *
   * @param {String} attrName - Optional, default is data-help
   * @return {jQuery}
   */
  $.fn.showHelpOnFocus = function (attrName) {
    if (!attrName) {
      attrName = &#039;data-validation-help&#039;;
    }

    // Remove previously added event listeners
    this.find(&#039;.has-help-txt&#039;)
      .valAttr(&#039;has-keyup-event&#039;, false)
      .removeClass(&#039;has-help-txt&#039;);

    // Add help text listeners
    this.find(&#039;textarea,input&#039;).each(function () {
      var $elem = $(this),
        className = &#039;jquery_form_help_&#039; + (++_helpers),
        help = $elem.attr(attrName);

      if (help) {
        $elem
          .addClass(&#039;has-help-txt&#039;)
          .unbind(&#039;focus.help&#039;)
          .bind(&#039;focus.help&#039;, function () {
            var $help = $elem.parent().find(&#039;.&#039; + className);
            if ($help.length === 0) {
              $help = $(&#039;&lt;span /&gt;&#039;)
                .addClass(className)
                .addClass(&#039;help&#039;)
                .addClass(&#039;help-block&#039;) // twitter bs
                .text(help)
                .hide();

              $elem.after($help);
            }
            $help.fadeIn();
          })
          .unbind(&#039;blur.help&#039;)
          .bind(&#039;blur.help&#039;, function () {
            $(this)
              .parent()
              .find(&#039;.&#039; + className)
              .fadeOut(&#039;slow&#039;);
          });
      }
    });

    return this;
  };

  /**
   * @param {Function} cb
   * @param {Object} [conf]
   * @param {Object} [lang]
   */
  $.fn.validate = function(cb, conf, lang) {
    var language = $.extend({}, $.formUtils.LANG, lang || {});
    this.each(function() {
      var $elem = $(this),
        formDefaultConfig = $elem.closest(&#039;form&#039;).get(0).validationConfig || {};

      $elem.one(&#039;validation&#039;, function(evt, isValid) {
        if ( typeof cb === &#039;function&#039; ) {
          cb(isValid, this, evt);
        }
      });

      $elem.validateInputOnBlur(
        language,
        $.extend({}, formDefaultConfig, conf || {}),
        true
      );
    });
  };

  /**
   * Tells whether or not validation of this input will have to postpone the form submit ()
   * @returns {Boolean}
   */
  $.fn.willPostponeValidation = function() {
    return (this.valAttr(&#039;suggestion-nr&#039;) ||
      this.valAttr(&#039;postpone&#039;) ||
      this.hasClass(&#039;hasDatepicker&#039;)) &amp;&amp;
      !window.postponedValidation;
  };

  /**
   * Validate single input when it loses focus
   * shows error message in a span element
   * that is appended to the parent element
   *
   * @param {Object} [language] Optional, will override $.formUtils.LANG
   * @param {Object} [conf] Optional, will override the default settings
   * @param {Boolean} attachKeyupEvent Optional
   * @param {String} eventType
   * @return {jQuery}
   */
  $.fn.validateInputOnBlur = function (language, conf, attachKeyupEvent, eventType) {

    $.formUtils.eventType = eventType;

    if ( this.willPostponeValidation() ) {
      // This validation has to be postponed
      var _self = this,
        postponeTime = this.valAttr(&#039;postpone&#039;) || 200;

      window.postponedValidation = function () {
        _self.validateInputOnBlur(language, conf, attachKeyupEvent, eventType);
        window.postponedValidation = false;
      };

      setTimeout(function () {
        if (window.postponedValidation) {
          window.postponedValidation();
        }
      }, postponeTime);

      return this;
    }

    language = $.extend({}, $.formUtils.LANG, language || {});
    $.formUtils.dialogs.removeInputStylingAndMessage(this, conf);

    var $elem = this,
      $form = $elem.closest(&#039;form&#039;),
      result = $.formUtils.validateInput(
        $elem,
        language,
        conf,
        $form,
        eventType
      );

    if (attachKeyupEvent) {
      $elem.unbind(&#039;keyup.validation&#039;);
    }

    if (result.shouldChangeDisplay) {
      if (result.isValid) {
        $.formUtils.dialogs.applyInputSuccessStyling($elem, conf);
      } else {
        $.formUtils.dialogs.setInlineMessage($elem, result.errorMsg, conf);
      }
    }

    if (!result.isValid &amp;&amp; attachKeyupEvent) {
      $elem.bind(&#039;keyup.validation&#039;, function (evt) {
        if( evt.keyCode !== 9 ) {
          $(this).validateInputOnBlur(language, conf, false, &#039;keyup&#039;);
        }
      });
    }

    return this;
  };

  /**
   * Short hand for fetching/adding/removing element attributes
   * prefixed with &#039;data-validation-&#039;
   *
   * @param {String} name
   * @param {String|Boolean} [val]
   * @return {String|undefined|jQuery}
   * @protected
   */
  $.fn.valAttr = function (name, val) {
    if (val === undefined) {
      return this.attr(&#039;data-validation-&#039; + name);
    } else if (val === false || val === null) {
      return this.removeAttr(&#039;data-validation-&#039; + name);
    } else {
      name = ((name.length &gt; 0) ? &#039;-&#039; + name : &#039;&#039;);
      return this.attr(&#039;data-validation&#039; + name, val);
    }
  };

  /**
   * Function that validates all inputs in active form
   *
   * @param {Object} [language]
   * @param {Object} [conf]
   * @param {Boolean} [displayError] Defaults to true
   */
  $.fn.isValid = function (language, conf, displayError) {

    if ($.formUtils.isLoadingModules) {
      var $self = this;
      setTimeout(function () {
        $self.isValid(language, conf, displayError);
      }, 200);
      return null;
    }

    conf = $.extend({}, $.formUtils.defaultConfig(), conf || {});
    language = $.extend({}, $.formUtils.LANG, language || {});
    displayError = displayError !== false;

    if ($.formUtils.errorDisplayPreventedWhenHalted) {
      // isValid() was called programmatically with argument displayError set
      // to false when the validation was halted by any of the validators
      delete $.formUtils.errorDisplayPreventedWhenHalted;
      displayError = false;
    }

    $.formUtils.isValidatingEntireForm = true;
    $.formUtils.haltValidation = false;

    /**
     * Adds message to error message stack if not already in the message stack
     *
     * @param {String} mess
     * @para {jQuery} $elem
     */
    var addErrorMessage = function (mess, $elem) {
        if ($.inArray(mess, errorMessages) &lt; 0) {
          errorMessages.push(mess);
        }
        errorInputs.push($elem);
        $elem.attr(&#039;current-error&#039;, mess);
        if (displayError) {
          $.formUtils.dialogs.applyInputErrorStyling($elem, conf);
        }
      },

      /** Holds inputs (of type checkox or radio) already validated, to prevent recheck of mulitple checkboxes &amp; radios */
      checkedInputs = [],

      /** Error messages for this validation */
      errorMessages = [],

      /** Input elements which value was not valid */
      errorInputs = [],

      /** Form instance */
      $form = this,

      /**
       * Tells whether or not to validate element with this name and of this type
       *
       * @param {String} name
       * @param {String} type
       * @return {Boolean}
       */
      ignoreInput = function (name, type) {
        if (type === &#039;submit&#039; || type === &#039;button&#039; || type === &#039;reset&#039;) {
          return true;
        }
        return $.inArray(name, conf.ignore || []) &gt; -1;
      };

    // Reset style and remove error class
    if (displayError) {
      $.formUtils.dialogs.removeAllMessagesAndStyling($form, conf);
    }

    // Validate element values
    $form.find(&#039;input,textarea,select&#039;).filter(&#039;:not([type=&quot;submit&quot;],[type=&quot;button&quot;])&#039;).each(function () {
      var $elem = $(this),
        elementType = $elem.attr(&#039;type&#039;),
        isCheckboxOrRadioBtn = elementType === &#039;radio&#039; || elementType === &#039;checkbox&#039;,
        elementName = $elem.attr(&#039;name&#039;);

      if (!ignoreInput(elementName, elementType) &amp;&amp; (!isCheckboxOrRadioBtn || $.inArray(elementName, checkedInputs) &lt; 0)) {

        if (isCheckboxOrRadioBtn) {
          checkedInputs.push(elementName);
        }

        var result = $.formUtils.validateInput(
          $elem,
          language,
          conf,
          $form,
          &#039;submit&#039;
        );

        if (result.shouldChangeDisplay) {
          if (!result.isValid) {
            addErrorMessage(result.errorMsg, $elem);
          } else if (result.isValid) {
            $elem.valAttr(&#039;current-error&#039;, false);
            $.formUtils.dialogs.applyInputSuccessStyling($elem, conf);
          }
        }
      }

    });

    // Run validation callback
    if (typeof conf.onValidate === &#039;function&#039;) {
      var errors = conf.onValidate($form);
      if ($.isArray(errors)) {
        $.each(errors, function (i, err) {
          addErrorMessage(err.message, err.element);
        });
      }
      else if (errors &amp;&amp; errors.element &amp;&amp; errors.message) {
        addErrorMessage(errors.message, errors.element);
      }
    }

    // Reset form validation flag
    $.formUtils.isValidatingEntireForm = false;

    // Validation failed
    if (!$.formUtils.haltValidation &amp;&amp; errorInputs.length &gt; 0) {

      if (displayError) {

        if (conf.errorMessagePosition === &#039;top&#039;) {
          $.formUtils.dialogs.setMessageInTopOfForm($form, errorMessages, conf, language);
        } else {
          $.each(errorInputs, function (i, $input) {
            $.formUtils.dialogs.setInlineMessage($input, $input.attr(&#039;current-error&#039;), conf);
          });
        }
        if (conf.scrollToTopOnError) {
          $.formUtils.$win.scrollTop($form.offset().top - 20);
        }

      }

      return false;
    }

    if (!displayError &amp;&amp; $.formUtils.haltValidation) {
      $.formUtils.errorDisplayPreventedWhenHalted = true;
    }

    return !$.formUtils.haltValidation;
  };

  /**
   * Plugin for displaying input length restriction
   */
  $.fn.restrictLength = function (maxLengthElement) {
    new $.formUtils.lengthRestriction(this, maxLengthElement);
    return this;
  };

  /**
   * Add suggestion dropdown to inputs having data-suggestions with a comma
   * separated string with suggestions
   * @param {Array} [settings]
   * @returns {jQuery}
   */
  $.fn.addSuggestions = function (settings) {
    var sugs = false;
    this.find(&#039;input&#039;).each(function () {
      var $field = $(this);

      sugs = $.split($field.attr(&#039;data-suggestions&#039;));

      if (sugs.length &gt; 0 &amp;&amp; !$field.hasClass(&#039;has-suggestions&#039;)) {
        $.formUtils.suggest($field, sugs, settings);
        $field.addClass(&#039;has-suggestions&#039;);
      }
    });
    return this;
  };


})(jQuery, window);

/**
 * Utility methods used for handling loading of modules (attached to $.formUtils)
 */
(function($) {

  &#039;use strict&#039;;

  $.formUtils = $.extend($.formUtils || {}, {

    /**
     * @var {Boolean}
     */
    isLoadingModules: false,

    /**
     * @var {Object}
     */
    loadedModules: {},

    /**
     * @example
     *  $.formUtils.loadModules(&#039;date, security.dev&#039;);
     *
     * Will load the scripts date.js and security.dev.js from the
     * directory where this script resides. If you want to load
     * the modules from another directory you can use the
     * path argument.
     *
     * The script will be cached by the browser unless the module
     * name ends with .dev
     *
     * @param {String} modules - Comma separated string with module file names (no directory nor file extension)
     * @param {String} [path] - Optional, path where the module files is located if their not in the same directory as the core modules
     * @param {function} [callback] - Optional, whether or not to fire event &#039;load&#039; when modules finished loading
     */
    loadModules: function (modules, path, callback) {

      if ($.formUtils.isLoadingModules) {
        setTimeout(function () {
          $.formUtils.loadModules(modules, path, callback);
        }, 10);
        return;
      }

      var hasLoadedAnyModule = false,
        loadModuleScripts = function (modules, path) {

          var moduleList = $.split(modules),
            numModules = moduleList.length,
            moduleLoadedCallback = function () {
              numModules--;
              if (numModules === 0) {
                $.formUtils.isLoadingModules = false;
                if (callback &amp;&amp; hasLoadedAnyModule) {
                  if( typeof callback === &#039;function&#039; ) {
                    callback();
                  }
                }
              }
            };


          if (numModules &gt; 0) {
            $.formUtils.isLoadingModules = true;
          }

          var cacheSuffix = &#039;?_=&#039; + ( new Date().getTime() ),
            appendToElement = document.getElementsByTagName(&#039;head&#039;)[0] || document.getElementsByTagName(&#039;body&#039;)[0];

          $.each(moduleList, function (i, modName) {
            modName = $.trim(modName);
            if (modName.length === 0) {
              moduleLoadedCallback();
            }
            else {
              var scriptUrl = path + modName + (modName.slice(-3) === &#039;.js&#039; ? &#039;&#039; : &#039;.js&#039;),
                script = document.createElement(&#039;SCRIPT&#039;);

              if (scriptUrl in $.formUtils.loadedModules) {
                // already loaded
                moduleLoadedCallback();
              }
              else {

                // Remember that this script is loaded
                $.formUtils.loadedModules[scriptUrl] = 1;
                hasLoadedAnyModule = true;

                // Load the script
                script.type = &#039;text/javascript&#039;;
                script.onload = moduleLoadedCallback;
                script.src = scriptUrl + ( scriptUrl.slice(-7) === &#039;.dev.js&#039; ? cacheSuffix : &#039;&#039; );
                script.onerror = function() {
                  $.formUtils.warn(&#039;Unable to load form validation module &#039;+scriptUrl);
                };
                script.onreadystatechange = function () {
                  // IE 7 fix
                  if (this.readyState === &#039;complete&#039; || this.readyState === &#039;loaded&#039;) {
                    moduleLoadedCallback();
                    // Handle memory leak in IE
                    this.onload = null;
                    this.onreadystatechange = null;
                  }
                };
                appendToElement.appendChild(script);
              }
            }
          });
        };

      if (path) {
        loadModuleScripts(modules, path);
      } else {
        var findScriptPathAndLoadModules = function () {
          var foundPath = false;
          $(&#039;script[src*=&quot;form-validator&quot;]&#039;).each(function () {
            foundPath = this.src.substr(0, this.src.lastIndexOf(&#039;/&#039;)) + &#039;/&#039;;
            if (foundPath === &#039;/&#039;) {
              foundPath = &#039;&#039;;
            }
            return false;
          });

          if (foundPath !== false) {
            loadModuleScripts(modules, foundPath);
            return true;
          }
          return false;
        };

        if (!findScriptPathAndLoadModules()) {
          $(findScriptPathAndLoadModules);
        }
      }
    }

  });

})(jQuery);

/**
 * Setup function for the plugin
 */
(function ($) {

  &#039;use strict&#039;;


  /**
   * A bit smarter split function
   * delimiter can be space, comma, dash or pipe
   * @param {String} val
   * @param {Function|String} [callback]
   * @returns {Array|void}
   */
  $.split = function (val, callback) {
    if (typeof callback !== &#039;function&#039;) {
      // return array
      if (!val) {
        return [];
      }
      var values = [];
      $.each(val.split(callback ? callback : /[,|\-\s]\s*/g),
        function (i, str) {
          str = $.trim(str);
          if (str.length) {
            values.push(str);
          }
        }
      );
      return values;
    } else if (val) {
      // exec callback func on each
      $.each(val.split(/[,|\-\s]\s*/g),
        function (i, str) {
          str = $.trim(str);
          if (str.length) {
            return callback(str, i);
          }
        }
      );
    }
  };

  /**
   * Short hand function that makes the validation setup require less code
   * @param conf
   */
  $.validate = function (conf) {

    var defaultConf = $.extend($.formUtils.defaultConfig(), {
      form: &#039;form&#039;,
      validateOnEvent: false,
      validateOnBlur: true,
      validateCheckboxRadioOnClick: true,
      showHelpOnFocus: true,
      addSuggestions: true,
      modules: &#039;&#039;,
      onModulesLoaded: null,
      language: false,
      onSuccess: false,
      onError: false,
      onElementValidate: false
    });

    conf = $.extend(defaultConf, conf || {});

    if( conf.lang &amp;&amp; conf.lang !== &#039;en&#039; ) {
      var langModule = &#039;lang/&#039;+conf.lang+&#039;.js&#039;;
      conf.modules += conf.modules.length ? &#039;,&#039;+langModule : langModule;
    }

    // Add validation to forms
    $(conf.form).each(function (i, form) {

      // Make a reference to the config for this form
      form.validationConfig = conf;

      // Trigger jQuery event that we&#039;re about to setup validation
      var $form = $(form);
      // $.formUtils.$win.trigger(&#039;formValidationSetup&#039;, [$form, conf]);
      $form.trigger(&#039;formValidationSetup&#039;, [$form, conf]);

      // Remove classes and event handlers that might have been
      // added by a previous call to $.validate
      $form.find(&#039;.has-help-txt&#039;)
          .unbind(&#039;focus.validation&#039;)
          .unbind(&#039;blur.validation&#039;);

      $form
        .removeClass(&#039;has-validation-callback&#039;)
        .unbind(&#039;submit.validation&#039;)
        .unbind(&#039;reset.validation&#039;)
        .find(&#039;input[data-validation],textarea[data-validation]&#039;)
          .unbind(&#039;blur.validation&#039;);

      // Validate when submitted
      $form.bind(&#039;submit.validation&#039;, function () {

        var $form = $(this);

        if ($.formUtils.haltValidation) {
          // pressing several times on submit button while validation is halted
          return false;
        }

        if ($.formUtils.isLoadingModules) {
          setTimeout(function () {
            $form.trigger(&#039;submit.validation&#039;);
          }, 200);
          return false;
        }

        var valid = $form.isValid(conf.language, conf);

        if ($.formUtils.haltValidation) {
          // Validation got halted by one of the validators
          return false;
        } else {
          if (valid &amp;&amp; typeof conf.onSuccess === &#039;function&#039;) {
            var callbackResponse = conf.onSuccess($form);
            if (callbackResponse === false) {
              return false;
            }
          } else if (!valid &amp;&amp; typeof conf.onError === &#039;function&#039;) {
            conf.onError($form);
            return false;
          } else {
            return valid;
          }
        }
      })
      .bind(&#039;reset.validation&#039;, function () {
        $.formUtils.dialogs.removeAllMessagesAndStyling($form, conf);
      })
      .addClass(&#039;has-validation-callback&#039;);

      if (conf.showHelpOnFocus) {
        $form.showHelpOnFocus();
      }
      if (conf.addSuggestions) {
        $form.addSuggestions();
      }
      if (conf.validateOnBlur) {
        $form.validateOnBlur(conf.language, conf);
        $form.bind(&#039;html5ValidationAttrsFound&#039;, function () {
          $form.validateOnBlur(conf.language, conf);
        });
      }
      if (conf.validateOnEvent) {
        $form.validateOnEvent(conf.language, conf);
      }
    });

    if (conf.modules !== &#039;&#039;) {
      $.formUtils.loadModules(conf.modules, false, function() {
        if (typeof conf.onModulesLoaded === &#039;function&#039;) {
          conf.onModulesLoaded();
        }
        var $form = typeof conf.form === &#039;string&#039; ? $(conf.form) : conf.form;
        $.formUtils.$win.trigger(&#039;validatorsLoaded&#039;, [$form, conf]);
      });
    }
  };

})(jQuery);

/**
 * Utility methods and properties attached to $.formUtils
 */
(function($, window) {

  &#039;use strict&#039;;

  var $win = $(window);

  $.formUtils = $.extend($.formUtils || {}, {

    $win: $win,

    /**
     * Default config for $(...).isValid();
     */
    defaultConfig: function () {
      return {
        ignore: [], // Names of inputs not to be validated even though `validationRuleAttribute` containing the validation rules tells us to
        errorElementClass: &#039;error&#039;, // Class that will be put on elements which value is invalid
        borderColorOnError: &#039;#b94a48&#039;, // Border color of elements which value is invalid, empty string to not change border color
        errorMessageClass: &#039;form-error&#039;, // class name of div containing error messages when validation fails
        validationRuleAttribute: &#039;data-validation&#039;, // name of the attribute holding the validation rules
        validationErrorMsgAttribute: &#039;data-validation-error-msg&#039;, // define custom err msg inline with element
        errorMessagePosition: &#039;element&#039;, // Can be either &quot;top&quot; or &quot;element&quot; or &quot;custom&quot;
        errorMessageTemplate: {
          container: &#039;&lt;div class=&quot;{errorMessageClass} alert alert-danger&quot;&gt;{messages}&lt;/div&gt;&#039;,
          messages: &#039;&lt;strong&gt;{errorTitle}&lt;/strong&gt;&lt;ul&gt;{fields}&lt;/ul&gt;&#039;,
          field: &#039;&lt;li&gt;{msg}&lt;/li&gt;&#039;
        },
        scrollToTopOnError: true,
        dateFormat: &#039;yyyy-mm-dd&#039;,
        addValidClassOnAll: false, // whether or not to apply class=&quot;valid&quot; even if the input wasn&#039;t validated
        decimalSeparator: &#039;.&#039;,
        inputParentClassOnError: &#039;has-error&#039;, // twitter-bootstrap default class name
        inputParentClassOnSuccess: &#039;has-success&#039;, // twitter-bootstrap default class name
        validateHiddenInputs: false, // whether or not hidden inputs should be validated
        inlineErrorMessageCallback: false,
        submitErrorMessageCallback: false
      };
    },

    /**
     * Available validators
     */
    validators: {},

    /**
     * Events triggered by form validator
     */
    _events: {load: [], valid: [], invalid: []},

    /**
     * Setting this property to true during validation will
     * stop further validation from taking place and form will
     * not be sent
     */
    haltValidation: false,

    /**
     * This variable will be true $.fn.isValid() is called
     * and false when $.fn.validateOnBlur is called
     */
    isValidatingEntireForm: false,

    /**
     * Function for adding a validator
     * @param {Object} validator
     */
    addValidator: function (validator) {
      // prefix with &quot;validate_&quot; for backward compatibility reasons
      var name = validator.name.indexOf(&#039;validate_&#039;) === 0 ? validator.name : &#039;validate_&#039; + validator.name;
      if (validator.validateOnKeyUp === undefined) {
        validator.validateOnKeyUp = true;
      }
      this.validators[name] = validator;
    },

    /**
     * Warn user via the console if available
     */
    warn: function(msg) {
      if( &#039;console&#039; in window ) {
        if( typeof window.console.warn === &#039;function&#039; ) {
          window.console.warn(msg);
        } else if( typeof window.console.log === &#039;function&#039; ) {
          window.console.log(msg);
        }
      } else {
        alert(msg);
      }
    },

    /**
     * Same as input $.fn.val() but also supporting input of typ radio or checkbox
     * @example
     *
     *  $.formUtils.getValue(&#039;.myRadioButtons&#039;, $(&#039;#some-form&#039;));
     *  $.formUtils.getValue($(&#039;#some-form&#039;).find(&#039;.check-boxes&#039;));
     *
     * @param query
     * @param $parent
     * @returns {String|Boolean}
     */
    getValue: function(query, $parent) {
      var $inputs = $parent ? $parent.find(query) : query;
      if ($inputs.length &gt; 0 ) {
        var type = $inputs.eq(0).attr(&#039;type&#039;);
        if (type === &#039;radio&#039; || type === &#039;checkbox&#039;) {
          return $inputs.filter(&#039;:checked&#039;).val();
        } else {
          return $inputs.val();
        }
      }
      return false;
    },

    /**
     * Validate the value of given element according to the validation rules
     * found in the attribute data-validation. Will return an object representing
     * a validation result, having the props shouldChangeDisplay, isValid and errorMsg
     * @param {jQuery} $elem
     * @param {Object} language ($.formUtils.LANG)
     * @param {Object} conf
     * @param {jQuery} $form
     * @param {String} [eventContext]
     * @return {Object}
     */
    validateInput: function ($elem, language, conf, $form, eventContext) {

      conf = conf || $.formUtils.defaultConfig();
      language = language || $.formUtils.LANG;

      var value = this.getValue($elem);

      $elem
        .valAttr(&#039;skipped&#039;, false)
        .one(&#039;beforeValidation&#039;, function() {
          // Skip input because its hidden or disabled
          // Doing this in a callback makes it possible for others to prevent the default
          // behaviour by binding to the same event and call evt.stopImmediatePropagation()
          if ($elem.attr(&#039;disabled&#039;) || (!$elem.is(&#039;:visible&#039;) &amp;&amp; !conf.validateHiddenInputs)) {
            $elem.valAttr(&#039;skipped&#039;, 1);
          }
        })
        .trigger(&#039;beforeValidation&#039;, [value, conf, language]);

      var inputIsOptional = $elem.valAttr(&#039;optional&#039;) === &#039;true&#039;,
          skipBecauseItsEmpty = !value &amp;&amp; inputIsOptional,
          validationRules = $elem.attr(conf.validationRuleAttribute),
          isValid = true,
          errorMsg = &#039;&#039;,
          result = {isValid: true, shouldChangeDisplay:true, errorMsg:&#039;&#039;};

      // For input type=&quot;number&quot;, browsers attempt to parse the entered value into a number.
      // If the input is not numeric, browsers handle the situation differently:
      // Chrome 48 simply disallows non-numeric input; FF 44 clears out the input box on blur;
      // Safari 5 parses the entered string to find a leading number.
      // If the input fails browser validation, the browser sets the input value equal to an empty string.
      // Therefore, we cannot distinguish (apart from hacks) between an empty input type=&quot;text&quot; and one with a
      // value that can&#039;t be parsed by the browser.

      if (!validationRules || skipBecauseItsEmpty || $elem.valAttr(&#039;skipped&#039;)) {
        result.shouldChangeDisplay = conf.addValidClassOnAll;
        return result;
      }

      // Filter out specified characters
      var ignore = $elem.valAttr(&#039;ignore&#039;);
      if (ignore) {
        $.each(ignore.split(&#039;&#039;), function(i, char) {
          value = value.replace(new RegExp(&#039;\\&#039;+char), &#039;&#039;);
        });
      }

      $.split(validationRules, function (rule) {

        if (rule.indexOf(&#039;validate_&#039;) !== 0) {
          rule = &#039;validate_&#039; + rule;
        }

        var validator = $.formUtils.validators[rule];

        if (validator) {

          // special change of element for checkbox_group rule
          if (rule === &#039;validate_checkbox_group&#039;) {
            // set element to first in group, so error msg attr doesn&#039;t need to be set on all elements in group
            $elem = $form.find(&#039;[name=&quot;&#039; + $elem.attr(&#039;name&#039;) + &#039;&quot;]:eq(0)&#039;);
          }

          if (eventContext !== &#039;keyup&#039; || validator.validateOnKeyUp) {
            // A validator can prevent itself from getting triggered on keyup
            isValid = validator.validatorFunction(value, $elem, conf, language, $form);
          }

          if (!isValid) {
            errorMsg = $.formUtils.dialogs.resolveErrorMessage($elem, validator, rule, conf, language);
            return false; // break iteration
          }

        } else {

          // todo: Add some validator lookup function and tell immediately which module is missing
          throw new Error(&#039;Using undefined validator &quot;&#039; + rule +
            &#039;&quot;. Maybe you have forgotten to load the module that &quot;&#039; + rule +&#039;&quot; belongs to?&#039;);

        }

      }, &#039; &#039;);


      if (isValid === false) {
        $elem.trigger(&#039;validation&#039;, false);
        result.errorMsg = errorMsg;
        result.isValid = false;
        result.shouldChangeDisplay = true;
      } else if (isValid === null) {
        // A validatorFunction returning null means that it&#039;s not able to validate
        // the input at this time. Most probably some async stuff need to gets finished
        // first and then the validator will re-trigger the validation.
        result.shouldChangeDisplay = false;
      } else {
        $elem.trigger(&#039;validation&#039;, true);
        result.shouldChangeDisplay = true;
      }

      // Run element validation callback
      if (typeof conf.onElementValidate === &#039;function&#039; &amp;&amp; errorMsg !== null) {
        conf.onElementValidate(result.isValid, $elem, $form, errorMsg);
      }

      $elem.trigger(&#039;afterValidation&#039;, [result, eventContext]);

      return result;
    },

    /**
     * Is it a correct date according to given dateFormat. Will return false if not, otherwise
     * an array 0=&gt;year 1=&gt;month 2=&gt;day
     *
     * @param {String} val
     * @param {String} dateFormat
     * @param {Boolean} [addMissingLeadingZeros]
     * @return {Array}|{Boolean}
     */
    parseDate: function (val, dateFormat, addMissingLeadingZeros) {
      var divider = dateFormat.replace(/[a-zA-Z]/gi, &#039;&#039;).substring(0, 1),
        regexp = &#039;^&#039;,
        formatParts = dateFormat.split(divider || null),
        matches, day, month, year;

      $.each(formatParts, function (i, part) {
        regexp += (i &gt; 0 ? &#039;\\&#039; + divider : &#039;&#039;) + &#039;(\\d{&#039; + part.length + &#039;})&#039;;
      });

      regexp += &#039;$&#039;;

      if (addMissingLeadingZeros) {
        var newValueParts = [];
        $.each(val.split(divider), function(i, part) {
          if(part.length === 1) {
            part = &#039;0&#039;+part;
          }
          newValueParts.push(part);
        });
        val = newValueParts.join(divider);
      }

      matches = val.match(new RegExp(regexp));
      if (matches === null) {
        return false;
      }

      var findDateUnit = function (unit, formatParts, matches) {
        for (var i = 0; i &lt; formatParts.length; i++) {
          if (formatParts[i].substring(0, 1) === unit) {
            return $.formUtils.parseDateInt(matches[i + 1]);
          }
        }
        return -1;
      };

      month = findDateUnit(&#039;m&#039;, formatParts, matches);
      day = findDateUnit(&#039;d&#039;, formatParts, matches);
      year = findDateUnit(&#039;y&#039;, formatParts, matches);

      if ((month === 2 &amp;&amp; day &gt; 28 &amp;&amp; (year % 4 !== 0 || year % 100 === 0 &amp;&amp; year % 400 !== 0)) ||
        (month === 2 &amp;&amp; day &gt; 29 &amp;&amp; (year % 4 === 0 || year % 100 !== 0 &amp;&amp; year % 400 === 0)) ||
        month &gt; 12 || month === 0) {
        return false;
      }
      if ((this.isShortMonth(month) &amp;&amp; day &gt; 30) || (!this.isShortMonth(month) &amp;&amp; day &gt; 31) || day === 0) {
        return false;
      }

      return [year, month, day];
    },

    /**
     * skum fix. är talet 05 eller lägre ger parseInt rätt int annars får man 0 när man kör parseInt?
     *
     * @param {String} val
     * @return {Number}
     */
    parseDateInt: function (val) {
      if (val.indexOf(&#039;0&#039;) === 0) {
        val = val.replace(&#039;0&#039;, &#039;&#039;);
      }
      return parseInt(val, 10);
    },

    /**
     * Has month only 30 days?
     *
     * @param {Number} m
     * @return {Boolean}
     */
    isShortMonth: function (m) {
      return (m % 2 === 0 &amp;&amp; m &lt; 7) || (m % 2 !== 0 &amp;&amp; m &gt; 7);
    },

    /**
     * Restrict input length
     *
     * @param {jQuery} $inputElement Jquery Html object
     * @param {jQuery} $maxLengthElement jQuery Html Object
     * @return void
     */
    lengthRestriction: function ($inputElement, $maxLengthElement) {
      // read maxChars from counter display initial text value
      var maxChars = parseInt($maxLengthElement.text(), 10),
        charsLeft = 0,

      // internal function does the counting and sets display value
        countCharacters = function () {
          var numChars = $inputElement.val().length;
          if (numChars &gt; maxChars) {
            // get current scroll bar position
            var currScrollTopPos = $inputElement.scrollTop();
            // trim value to max length
            $inputElement.val($inputElement.val().substring(0, maxChars));
            $inputElement.scrollTop(currScrollTopPos);
          }
          charsLeft = maxChars - numChars;
          if (charsLeft &lt; 0) {
            charsLeft = 0;
          }

          // set counter text
          $maxLengthElement.text(charsLeft);
        };

      // bind events to this element
      // setTimeout is needed, cut or paste fires before val is available
      $($inputElement).bind(&#039;keydown keyup keypress focus blur&#039;, countCharacters)
        .bind(&#039;cut paste&#039;, function () {
          setTimeout(countCharacters, 100);
        });

      // count chars on pageload, if there are prefilled input-values
      $(document).bind(&#039;ready&#039;, countCharacters);
    },

    /**
     * Test numeric against allowed range
     *
     * @param $value int
     * @param $rangeAllowed str; (1-2, min1, max2, 10)
     * @return array
     */
    numericRangeCheck: function (value, rangeAllowed) {
      // split by dash
      var range = $.split(rangeAllowed),
      // min or max
        minmax = parseInt(rangeAllowed.substr(3), 10);

      if( range.length === 1 &amp;&amp; rangeAllowed.indexOf(&#039;min&#039;) === -1 &amp;&amp; rangeAllowed.indexOf(&#039;max&#039;) === -1 ) {
        range = [rangeAllowed, rangeAllowed]; // only a number, checking agains an exact number of characters
      }

      // range ?
      if (range.length === 2 &amp;&amp; (value &lt; parseInt(range[0], 10) || value &gt; parseInt(range[1], 10) )) {
        return [ &#039;out&#039;, range[0], range[1] ];
      } // value is out of range
      else if (rangeAllowed.indexOf(&#039;min&#039;) === 0 &amp;&amp; (value &lt; minmax )) // min
      {
        return [&#039;min&#039;, minmax];
      } // value is below min
      else if (rangeAllowed.indexOf(&#039;max&#039;) === 0 &amp;&amp; (value &gt; minmax )) // max
      {
        return [&#039;max&#039;, minmax];
      } // value is above max
      // since no other returns executed, value is in allowed range
      return [ &#039;ok&#039; ];
    },


    _numSuggestionElements: 0,
    _selectedSuggestion: null,
    _previousTypedVal: null,

    /**
     * Utility function that can be used to create plugins that gives
     * suggestions when inputs is typed into
     * @param {jQuery} $elem
     * @param {Array} suggestions
     * @param {Object} settings - Optional
     * @return {jQuery}
     */
    suggest: function ($elem, suggestions, settings) {
      var conf = {
          css: {
            maxHeight: &#039;150px&#039;,
            background: &#039;#FFF&#039;,
            lineHeight: &#039;150%&#039;,
            textDecoration: &#039;underline&#039;,
            overflowX: &#039;hidden&#039;,
            overflowY: &#039;auto&#039;,
            border: &#039;#CCC solid 1px&#039;,
            borderTop: &#039;none&#039;,
            cursor: &#039;pointer&#039;
          },
          activeSuggestionCSS: {
            background: &#039;#E9E9E9&#039;
          }
        },
        setSuggsetionPosition = function ($suggestionContainer, $input) {
          var offset = $input.offset();
          $suggestionContainer.css({
            width: $input.outerWidth(),
            left: offset.left + &#039;px&#039;,
            top: (offset.top + $input.outerHeight()) + &#039;px&#039;
          });
        };

      if (settings) {
        $.extend(conf, settings);
      }

      conf.css.position = &#039;absolute&#039;;
      conf.css[&#039;z-index&#039;] = 9999;
      $elem.attr(&#039;autocomplete&#039;, &#039;off&#039;);

      if (this._numSuggestionElements === 0) {
        // Re-position suggestion container if window size changes
        $win.bind(&#039;resize&#039;, function () {
          $(&#039;.jquery-form-suggestions&#039;).each(function () {
            var $container = $(this),
              suggestID = $container.attr(&#039;data-suggest-container&#039;);
            setSuggsetionPosition($container, $(&#039;.suggestions-&#039; + suggestID).eq(0));
          });
        });
      }

      this._numSuggestionElements++;

      var onSelectSuggestion = function ($el) {
        var suggestionId = $el.valAttr(&#039;suggestion-nr&#039;);
        $.formUtils._selectedSuggestion = null;
        $.formUtils._previousTypedVal = null;
        $(&#039;.jquery-form-suggestion-&#039; + suggestionId).fadeOut(&#039;fast&#039;);
      };

      $elem
        .data(&#039;suggestions&#039;, suggestions)
        .valAttr(&#039;suggestion-nr&#039;, this._numSuggestionElements)
        .unbind(&#039;focus.suggest&#039;)
        .bind(&#039;focus.suggest&#039;, function () {
          $(this).trigger(&#039;keyup&#039;);
          $.formUtils._selectedSuggestion = null;
        })
        .unbind(&#039;keyup.suggest&#039;)
        .bind(&#039;keyup.suggest&#039;, function () {
          var $input = $(this),
            foundSuggestions = [],
            val = $.trim($input.val()).toLocaleLowerCase();

          if (val === $.formUtils._previousTypedVal) {
            return;
          }
          else {
            $.formUtils._previousTypedVal = val;
          }

          var hasTypedSuggestion = false,
            suggestionId = $input.valAttr(&#039;suggestion-nr&#039;),
            $suggestionContainer = $(&#039;.jquery-form-suggestion-&#039; + suggestionId);

          $suggestionContainer.scrollTop(0);

          // Find the right suggestions
          if (val !== &#039;&#039;) {
            var findPartial = val.length &gt; 2;
            $.each($input.data(&#039;suggestions&#039;), function (i, suggestion) {
              var lowerCaseVal = suggestion.toLocaleLowerCase();
              if (lowerCaseVal === val) {
                foundSuggestions.push(&#039;&lt;strong&gt;&#039; + suggestion + &#039;&lt;/strong&gt;&#039;);
                hasTypedSuggestion = true;
                return false;
              } else if (lowerCaseVal.indexOf(val) === 0 || (findPartial &amp;&amp; lowerCaseVal.indexOf(val) &gt; -1)) {
                foundSuggestions.push(suggestion.replace(new RegExp(val, &#039;gi&#039;), &#039;&lt;strong&gt;$&amp;&lt;/strong&gt;&#039;));
              }
            });
          }

          // Hide suggestion container
          if (hasTypedSuggestion || (foundSuggestions.length === 0 &amp;&amp; $suggestionContainer.length &gt; 0)) {
            $suggestionContainer.hide();
          }

          // Create suggestion container if not already exists
          else if (foundSuggestions.length &gt; 0 &amp;&amp; $suggestionContainer.length === 0) {
            $suggestionContainer = $(&#039;&lt;div&gt;&lt;/div&gt;&#039;).css(conf.css).appendTo(&#039;body&#039;);
            $elem.addClass(&#039;suggestions-&#039; + suggestionId);
            $suggestionContainer
              .attr(&#039;data-suggest-container&#039;, suggestionId)
              .addClass(&#039;jquery-form-suggestions&#039;)
              .addClass(&#039;jquery-form-suggestion-&#039; + suggestionId);
          }

          // Show hidden container
          else if (foundSuggestions.length &gt; 0 &amp;&amp; !$suggestionContainer.is(&#039;:visible&#039;)) {
            $suggestionContainer.show();
          }

          // add suggestions
          if (foundSuggestions.length &gt; 0 &amp;&amp; val.length !== foundSuggestions[0].length) {

            // put container in place every time, just in case
            setSuggsetionPosition($suggestionContainer, $input);

            // Add suggestions HTML to container
            $suggestionContainer.html(&#039;&#039;);
            $.each(foundSuggestions, function (i, text) {
              $(&#039;&lt;div&gt;&lt;/div&gt;&#039;)
                .append(text)
                .css({
                  overflow: &#039;hidden&#039;,
                  textOverflow: &#039;ellipsis&#039;,
                  whiteSpace: &#039;nowrap&#039;,
                  padding: &#039;5px&#039;
                })
                .addClass(&#039;form-suggest-element&#039;)
                .appendTo($suggestionContainer)
                .click(function () {
                  $input.focus();
                  $input.val($(this).text());
                  $input.trigger(&#039;change&#039;);
                  onSelectSuggestion($input);
                });
            });
          }
        })
        .unbind(&#039;keydown.validation&#039;)
        .bind(&#039;keydown.validation&#039;, function (e) {
          var code = (e.keyCode ? e.keyCode : e.which),
            suggestionId,
            $suggestionContainer,
            $input = $(this);

          if (code === 13 &amp;&amp; $.formUtils._selectedSuggestion !== null) {
            suggestionId = $input.valAttr(&#039;suggestion-nr&#039;);
            $suggestionContainer = $(&#039;.jquery-form-suggestion-&#039; + suggestionId);
            if ($suggestionContainer.length &gt; 0) {
              var newText = $suggestionContainer.find(&#039;div&#039;).eq($.formUtils._selectedSuggestion).text();
              $input.val(newText);
              $input.trigger(&#039;change&#039;);
              onSelectSuggestion($input);
              e.preventDefault();
            }
          }
          else {
            suggestionId = $input.valAttr(&#039;suggestion-nr&#039;);
            $suggestionContainer = $(&#039;.jquery-form-suggestion-&#039; + suggestionId);
            var $suggestions = $suggestionContainer.children();
            if ($suggestions.length &gt; 0 &amp;&amp; $.inArray(code, [38, 40]) &gt; -1) {
              if (code === 38) { // key up
                if ($.formUtils._selectedSuggestion === null) {
                  $.formUtils._selectedSuggestion = $suggestions.length - 1;
                }
                else{
                  $.formUtils._selectedSuggestion--;
                }
                if ($.formUtils._selectedSuggestion &lt; 0) {
                  $.formUtils._selectedSuggestion = $suggestions.length - 1;
                }
              }
              else if (code === 40) { // key down
                if ($.formUtils._selectedSuggestion === null) {
                  $.formUtils._selectedSuggestion = 0;
                }
                else {
                  $.formUtils._selectedSuggestion++;
                }
                if ($.formUtils._selectedSuggestion &gt; ($suggestions.length - 1)) {
                  $.formUtils._selectedSuggestion = 0;
                }
              }

              // Scroll in suggestion window
              var containerInnerHeight = $suggestionContainer.innerHeight(),
                containerScrollTop = $suggestionContainer.scrollTop(),
                suggestionHeight = $suggestionContainer.children().eq(0).outerHeight(),
                activeSuggestionPosY = suggestionHeight * ($.formUtils._selectedSuggestion);

              if (activeSuggestionPosY &lt; containerScrollTop || activeSuggestionPosY &gt; (containerScrollTop + containerInnerHeight)) {
                $suggestionContainer.scrollTop(activeSuggestionPosY);
              }

              $suggestions
                .removeClass(&#039;active-suggestion&#039;)
                .css(&#039;background&#039;, &#039;none&#039;)
                .eq($.formUtils._selectedSuggestion)
                .addClass(&#039;active-suggestion&#039;)
                .css(conf.activeSuggestionCSS);

              e.preventDefault();
              return false;
            }
          }
        })
        .unbind(&#039;blur.suggest&#039;)
        .bind(&#039;blur.suggest&#039;, function () {
          onSelectSuggestion($(this));
        });

      return $elem;
    },

    /**
     * Error dialogs
     *
     * @var {Object}
     */
    LANG: {
      errorTitle: &#039;Form submission failed!&#039;,
      requiredField: &#039;This is a required field&#039;,
      requiredFields: &#039;You have not answered all required fields&#039;,
      badTime: &#039;You have not given a correct time&#039;,
      badEmail: &#039;Please check your email address (It must be an SAE valid email)&#039;,
      badTelephone: &#039;You have not given a correct phone number&#039;,
      badSecurityAnswer: &#039;You have not given a correct answer to the security question&#039;,
      badDate: &#039;You have not given a correct date&#039;,
      lengthBadStart: &#039;The input value must be between &#039;,
      lengthBadEnd: &#039; characters&#039;,
      lengthTooLongStart: &#039;The input value is longer than &#039;,
      lengthTooShortStart: &#039;The input value is shorter than &#039;,
      notConfirmed: &#039;Input values could not be confirmed&#039;,
      badDomain: &#039;Incorrect domain value&#039;,
      badUrl: &#039;The input value is not a correct URL&#039;,
      badCustomVal: &#039;The input value is incorrect&#039;,
      andSpaces: &#039; and spaces &#039;,
      badInt: &#039;The input value was not a correct number&#039;,
      badSecurityNumber: &#039;Your social security number was incorrect&#039;,
      badUKVatAnswer: &#039;Incorrect UK VAT Number&#039;,
      badUKNin: &#039;Incorrect UK NIN&#039;,
      badUKUtr: &#039;Incorrect UK UTR Number&#039;,
      badStrength: &#039;The password isn\&#039;t strong enough&#039;,
      badNumberOfSelectedOptionsStart: &#039;You have to choose at least &#039;,
      badNumberOfSelectedOptionsEnd: &#039; answers&#039;,
      badAlphaNumeric: &#039;The input value can only contain alphanumeric characters &#039;,
      badAlphaNumericExtra: &#039; and &#039;,
      wrongFileSize: &#039;The file you are trying to upload is too large (max %s)&#039;,
      wrongFileType: &#039;Only files of type %s is allowed&#039;,
      groupCheckedRangeStart: &#039;Please choose between &#039;,
      groupCheckedTooFewStart: &#039;Please choose at least &#039;,
      groupCheckedTooManyStart: &#039;Please choose a maximum of &#039;,
      groupCheckedEnd: &#039; item(s)&#039;,
      badCreditCard: &#039;The credit card number is not correct&#039;,
      badCVV: &#039;The CVV number was not correct&#039;,
      wrongFileDim : &#039;Incorrect image dimensions,&#039;,
      imageTooTall : &#039;the image can not be taller than&#039;,
      imageTooWide : &#039;the image can not be wider than&#039;,
      imageTooSmall : &#039;the image was too small&#039;,
      min : &#039;min&#039;,
      max : &#039;max&#039;,
      imageRatioNotAccepted : &#039;Image ratio is not be accepted&#039;,
      badBrazilTelephoneAnswer: &#039;The phone number entered is invalid&#039;,
      badBrazilCEPAnswer: &#039;The CEP entered is invalid&#039;,
      badBrazilCPFAnswer: &#039;The CPF entered is invalid&#039;,
      badPlPesel: &#039;The PESEL entered is invalid&#039;,
      badPlNip: &#039;The NIP entered is invalid&#039;,
      badPlRegon: &#039;The REGON entered is invalid&#039;,
      badreCaptcha: &#039;Please confirm that you are not a bot&#039;
    }
  });

})(jQuery, window);

/**
 * File declaring all default validators.
 */
(function($) {

  /*
   * Validate email
   */
  $.formUtils.addValidator({
    name: &#039;email&#039;,
    validatorFunction: function (email) {

      var emailParts = email.toLowerCase().split(&#039;@&#039;),
        localPart = emailParts[0],
        domain = emailParts[1];
        var email_student = &quot;student.sae.edu&quot;;
        var email_staff = &quot;sae.edu&quot;;

      if (localPart &amp;&amp; domain &amp;&amp; domain == email_student || localPart &amp;&amp; domain &amp;&amp; domain == email_staff) {

        if( localPart.indexOf(&#039;&quot;&#039;) === 0 ) {
          var len = localPart.length;
          localPart = localPart.replace(/\&quot;/g, &#039;&#039;);
          if( localPart.length !== (len-2) ) {
            return false; // It was not allowed to have more than two apostrophes
          }
        }

        return $.formUtils.validators.validate_domain.validatorFunction(emailParts[1]) &amp;&amp;
          localPart.indexOf(&#039;.&#039;) !== 0 &amp;&amp;
          localPart.substring(localPart.length-1, localPart.length) !== &#039;.&#039; &amp;&amp;
          localPart.indexOf(&#039;..&#039;) === -1 &amp;&amp;
          !(/[^\w\+\.\-\#\-\_\~\!\$\&amp;\&#039;\(\)\*\+\,\;\=\:]/.test(localPart));
      }

      return false;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badEmail&#039;
  });

  /*
   * Validate domain name
   */
  $.formUtils.addValidator({
    name: &#039;domain&#039;,
    validatorFunction: function (val) {
      return val.length &gt; 0 &amp;&amp;
        val.length &lt;= 253 &amp;&amp; // Including sub domains
        !(/[^a-zA-Z0-9]/.test(val.slice(-2))) &amp;&amp; !(/[^a-zA-Z0-9]/.test(val.substr(0, 1))) &amp;&amp; !(/[^a-zA-Z0-9\.\-]/.test(val)) &amp;&amp;
        val.split(&#039;..&#039;).length === 1 &amp;&amp;
        val.split(&#039;.&#039;).length &gt; 1;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badDomain&#039;
  });

  /*
   * Validate required
   */
  $.formUtils.addValidator({
    name: &#039;required&#039;,
    validatorFunction: function (val, $el, config, language, $form) {
      switch ($el.attr(&#039;type&#039;)) {
        case &#039;checkbox&#039;:
          return $el.is(&#039;:checked&#039;);
        case &#039;radio&#039;:
          return $form.find(&#039;input[name=&quot;&#039; + $el.attr(&#039;name&#039;) + &#039;&quot;]&#039;).filter(&#039;:checked&#039;).length &gt; 0;
        default:
          return $.trim(val) !== &#039;&#039;;
      }
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: function(config) {
      if (config.errorMessagePosition === &#039;top&#039; || typeof config.errorMessagePosition === &#039;function&#039;) {
        return &#039;requiredFields&#039;;
      }
      else {
        return &#039;requiredField&#039;;
      }
    }
  });

  /*
   * Validate length range
   */
  $.formUtils.addValidator({
    name: &#039;length&#039;,
    validatorFunction: function (val, $el, conf, lang) {
      var lengthAllowed = $el.valAttr(&#039;length&#039;),
        type = $el.attr(&#039;type&#039;);

      if (lengthAllowed === undefined) {
        alert(&#039;Please add attribute &quot;data-validation-length&quot; to &#039; + $el[0].nodeName + &#039; named &#039; + $el.attr(&#039;name&#039;));
        return true;
      }

      // check if length is above min, below max or within range.
      var len = type === &#039;file&#039; &amp;&amp; $el.get(0).files !== undefined ? $el.get(0).files.length : val.length,
        lengthCheckResults = $.formUtils.numericRangeCheck(len, lengthAllowed),
        checkResult;

      switch (lengthCheckResults[0]) {   // outside of allowed range
        case &#039;out&#039;:
          this.errorMessage = lang.lengthBadStart + lengthAllowed + lang.lengthBadEnd;
          checkResult = false;
          break;
        // too short
        case &#039;min&#039;:
          this.errorMessage = lang.lengthTooShortStart + lengthCheckResults[1] + lang.lengthBadEnd;
          checkResult = false;
          break;
        // too long
        case &#039;max&#039;:
          this.errorMessage = lang.lengthTooLongStart + lengthCheckResults[1] + lang.lengthBadEnd;
          checkResult = false;
          break;
        // ok
        default:
          checkResult = true;
      }

      return checkResult;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;&#039;
  });

  /*
   * Validate url
   */
  $.formUtils.addValidator({
    name: &#039;url&#039;,
    validatorFunction: function (url) {
      // written by Scott Gonzalez: http://projects.scottsplayground.com/iri/
      // - Victor Jonsson added support for arrays in the url ?arg[]=sdfsdf
      // - General improvements made by Stéphane Moureau &lt;https://github.com/TraderStf&gt;

      var urlFilter = /^(https?|ftp):\/\/((((\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;&#039;\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])(\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])(\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/(((\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;&#039;\(\)\*\+,;=]|:|@)+(\/((\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;&#039;\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|\[|\]|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;&#039;\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#(((\w|-|\.|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;&#039;\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
      if (urlFilter.test(url)) {
        var domain = url.split(&#039;://&#039;)[1],
          domainSlashPos = domain.indexOf(&#039;/&#039;);

        if (domainSlashPos &gt; -1) {
          domain = domain.substr(0, domainSlashPos);
        }

        return $.formUtils.validators.validate_domain.validatorFunction(domain); // todo: add support for IP-addresses
      }
      return false;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badUrl&#039;
  });

  /*
   * Validate youtube
   */
  $.formUtils.addValidator({
    name: &#039;youtube&#039;,
    validatorFunction: function (url) {

      var youtubeFilter = /^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/;
      var vimeoFilter = /https?:\/\/(?:www\.|player\.)?vimeo.com\/(.*)$/;

      if (youtubeFilter.test(url)) {
        console.log(&#039;youtube validate worked&#039;);
        return true;

      } if (vimeoFilter.test(url)) {
        console.log(&#039;vimeo validate worked&#039;);
        return true;
      }

      console.log(&#039;video validation did not work&#039;);
      return false;
    },
    errorMessage: &#039;incorrect link&#039;,
    errorMessageKey: &#039;badUrl&#039;
  });

  /*
   * Validate number (floating or integer)
   */
  $.formUtils.addValidator({
    name: &#039;number&#039;,
    validatorFunction: function (val, $el, conf) {
      if (val !== &#039;&#039;) {
        var allowing = $el.valAttr(&#039;allowing&#039;) || &#039;&#039;,
          decimalSeparator = $el.valAttr(&#039;decimal-separator&#039;) || conf.decimalSeparator,
          allowsRange = false,
          begin, end,
          steps = $el.valAttr(&#039;step&#039;) || &#039;&#039;,
          allowsSteps = false,
          sanitize = $el.attr(&#039;data-sanitize&#039;) || &#039;&#039;,
          isFormattedWithNumeral = sanitize.match(/(^|[\s])numberFormat([\s]|$)/i);

        if (isFormattedWithNumeral) {
          if (!window.numeral) {
            throw new ReferenceError(&#039;The data-sanitize value numberFormat cannot be used without the numeral&#039; +
              &#039; library. Please see Data Validation in http://www.formvalidator.net for more information.&#039;);
          }
          //Unformat input first, then convert back to String
          if (val.length) {
            val = String(numeral().unformat(val));
          }
        }

        if (allowing.indexOf(&#039;number&#039;) === -1) {
          allowing += &#039;,number&#039;;
        }

        if (allowing.indexOf(&#039;negative&#039;) === -1 &amp;&amp; val.indexOf(&#039;-&#039;) === 0) {
          return false;
        }

        if (allowing.indexOf(&#039;range&#039;) &gt; -1) {
          begin = parseFloat(allowing.substring(allowing.indexOf(&#039;[&#039;) + 1, allowing.indexOf(&#039;;&#039;)));
          end = parseFloat(allowing.substring(allowing.indexOf(&#039;;&#039;) + 1, allowing.indexOf(&#039;]&#039;)));
          allowsRange = true;
        }

        if (steps !== &#039;&#039;) {
          allowsSteps = true;
        }

        if (decimalSeparator === &#039;,&#039;) {
          if (val.indexOf(&#039;.&#039;) &gt; -1) {
            return false;
          }
          // Fix for checking range with floats using ,
          val = val.replace(&#039;,&#039;, &#039;.&#039;);
        }
        if (val.replace(/[0-9-]/g, &#039;&#039;) === &#039;&#039; &amp;&amp; (!allowsRange || (val &gt;= begin &amp;&amp; val &lt;= end)) &amp;&amp; (!allowsSteps || (val % steps === 0))) {
          return true;
        }

        if (allowing.indexOf(&#039;float&#039;) &gt; -1 &amp;&amp; val.match(new RegExp(&#039;^([0-9-]+)\\.([0-9]+)$&#039;)) !== null &amp;&amp; (!allowsRange || (val &gt;= begin &amp;&amp; val &lt;= end)) &amp;&amp; (!allowsSteps || (val % steps === 0))) {
          return true;
        }
      }
      return false;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badInt&#039;
  });

  /*
   * Validate alpha numeric
   */
  $.formUtils.addValidator({
    name: &#039;alphanumeric&#039;,
    validatorFunction: function (val, $el, conf, language) {
      var patternStart = &#039;^([a-zA-Z0-9&#039;,
        patternEnd = &#039;]+)$&#039;,
        additionalChars = $el.valAttr(&#039;allowing&#039;),
        pattern = &#039;&#039;;

      if (additionalChars) {
        pattern = patternStart + additionalChars + patternEnd;
        var extra = additionalChars.replace(/\\/g, &#039;&#039;);
        if (extra.indexOf(&#039; &#039;) &gt; -1) {
          extra = extra.replace(&#039; &#039;, &#039;&#039;);
          extra += language.andSpaces || $.formUtils.LANG.andSpaces;
        }
        this.errorMessage = language.badAlphaNumeric + language.badAlphaNumericExtra + extra;
      } else {
        pattern = patternStart + patternEnd;
        this.errorMessage = language.badAlphaNumeric;
      }

      return new RegExp(pattern).test(val);
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;&#039;
  });

  /*
   * Validate against regexp
   */
  $.formUtils.addValidator({
    name: &#039;custom&#039;,
    validatorFunction: function (val, $el) {
      var regexp = new RegExp($el.valAttr(&#039;regexp&#039;));
      return regexp.test(val);
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badCustomVal&#039;
  });

  /*
   * Validate date
   */
  $.formUtils.addValidator({
    name: &#039;date&#039;,
    validatorFunction: function (date, $el, conf) {
      var dateFormat = $el.valAttr(&#039;format&#039;) || conf.dateFormat || &#039;yyyy-mm-dd&#039;,
        addMissingLeadingZeros = $el.valAttr(&#039;require-leading-zero&#039;) === &#039;false&#039;;
      return $.formUtils.parseDate(date, dateFormat, addMissingLeadingZeros) !== false;
    },
    errorMessage: &#039;&#039;,
    errorMessageKey: &#039;badDate&#039;
  });


  /*
   * Validate group of checkboxes, validate qty required is checked
   * written by Steve Wasiura : http://stevewasiura.waztech.com
   * element attrs
   *    data-validation=&quot;checkbox_group&quot;
   *    data-validation-qty=&quot;1-2&quot;  // min 1 max 2
   *    data-validation-error-msg=&quot;chose min 1, max of 2 checkboxes&quot;
   */
  $.formUtils.addValidator({
    name: &#039;checkbox_group&#039;,
    validatorFunction: function (val, $el, conf, lang, $form) {
      // preset return var
      var isValid = true,
      // get name of element. since it is a checkbox group, all checkboxes will have same name
        elname = $el.attr(&#039;name&#039;),
      // get checkboxes and count the checked ones
        $checkBoxes = $(&#039;input[type=checkbox][name^=&quot;&#039; + elname + &#039;&quot;]&#039;, $form),
        checkedCount = $checkBoxes.filter(&#039;:checked&#039;).length,
      // get el attr that specs qty required / allowed
        qtyAllowed = $el.valAttr(&#039;qty&#039;);

      if (qtyAllowed === undefined) {
        var elementType = $el.get(0).nodeName;
        alert(&#039;Attribute &quot;data-validation-qty&quot; is missing from &#039; + elementType + &#039; named &#039; + $el.attr(&#039;name&#039;));
      }

      // call Utility function to check if count is above min, below max, within range etc.
      var qtyCheckResults = $.formUtils.numericRangeCheck(checkedCount, qtyAllowed);

      // results will be array, [0]=result str, [1]=qty int
      switch (qtyCheckResults[0]) {
        // outside allowed range
        case &#039;out&#039;:
          this.errorMessage = lang.groupCheckedRangeStart + qtyAllowed + lang.groupCheckedEnd;
          isValid = false;
          break;
        // below min qty
        case &#039;min&#039;:
          this.errorMessage = lang.groupCheckedTooFewStart + qtyCheckResults[1] + lang.groupCheckedEnd;
          isValid = false;
          break;
        // above max qty
        case &#039;max&#039;:
          this.errorMessage = lang.groupCheckedTooManyStart + qtyCheckResults[1] + lang.groupCheckedEnd;
          isValid = false;
          break;
        // ok
        default:
          isValid = true;
      }

      if( !isValid ) {
        var _triggerOnBlur = function() {
          $checkBoxes.unbind(&#039;click&#039;, _triggerOnBlur);
          $checkBoxes.filter(&#039;*[data-validation]&#039;).validateInputOnBlur(lang, conf, false, &#039;blur&#039;);
        };
        $checkBoxes.bind(&#039;click&#039;, _triggerOnBlur);
      }

      return isValid;
    }
    //   errorMessage : &#039;&#039;, // set above in switch statement
    //   errorMessageKey: &#039;&#039; // not used
  });

})(jQuery);


}));
</pre>

		<p class="file_page_meta no_print" style="line-height: 1.5rem;">
			<label class="checkbox normal mini float_right no_top_padding no_min_width">
				<input type="checkbox" id="file_preview_wrap_cb"> wrap long lines
			</label>
		</p>

	</div>

	<div id="comments_holder" class="clearfix clear_both">
	<div class="col span_1_of_6"></div>
	<div class="col span_4_of_6 no_right_padding">
		<div id="file_page_comments">
					</div>	
		<form action="https://saebneweb.slack.com/files/tatiana/F0ZFS5Y5V/jquery.form-validator.js"
		id="file_comment_form"
					class="comment_form"
				method="post">
			<a href="/team/matthew_neal" class="member_preview_link" data-member-id="U0MRF6CA0" >
			<span class="member_image thumb_36" style="background-image: url('https://avatars.slack-edge.com/2016-02-18/21872958295_24ee33803810f0cd11b7_72.jpg')" data-thumb-size="36" data-member-id="U0MRF6CA0"></span>
		</a>
		<input type="hidden" name="addcomment" value="1" />
	<input type="hidden" name="crumb" value="s-1460341060-c293d89467-☃" />

	<textarea id="file_comment" data-el-id-to-keep-in-view="file_comment_submit_btn" class="small comment_input small_bottom_margin autogrow-short" name="comment" wrap="virtual" ></textarea>
	<span class="input_note float_left cloud_silver file_comment_tip">shift+enter to add a new line</span>	<button id="file_comment_submit_btn" type="submit" class="btn float_right  ladda-button" data-style="expand-right"><span class="ladda-label">Add Comment</span></button>
</form>

<form
		id="file_edit_comment_form"
					class="edit_comment_form hidden"
				method="post">
		<textarea id="file_edit_comment" class="small comment_input small_bottom_margin" name="comment" wrap="virtual"></textarea><br>
	<span class="input_note float_left cloud_silver file_comment_tip">shift+enter to add a new line</span>	<input type="submit" class="save btn float_right " value="Save" />
	<button class="cancel btn btn_outline float_right small_right_margin ">Cancel</button>
</form>	
	</div>
	<div class="col span_1_of_6"></div>
</div>
</div>



		
	</div>
	<div id="overlay"></div>
</div>





<script type="text/javascript">
var cdn_url = "https:\/\/slack.global.ssl.fastly.net";
var inc_js_setup_data = {
	emoji_sheets: {
		apple: 'https://a.slack-edge.com/e4cee/img/emoji_2016_02_06/sheet_apple_64_indexed_256colors.png',
		google: 'https://a.slack-edge.com/93405/img/emoji_2016_02_06/sheet_google_64_indexed_128colors.png',
		twitter: 'https://a.slack-edge.com/93405/img/emoji_2016_02_06/sheet_twitter_64_indexed_128colors.png',
		emojione: 'https://a.slack-edge.com/3e24/img/emoji_2016_02_06/sheet_emojione_64_indexed_128colors.png',
	},
};
</script>
			<script type="text/javascript">
<!--
	// common boot_data
	var boot_data = {
		start_ms: Date.now(),
		app: 'web',
		user_id: 'U0MRF6CA0',
		no_login: false,
		version_ts: '1460330883',
		version_uid: '9fbe87666e87cb4161d238f7868871797e8b2f58',
		cache_version: "v13-tiger",
		cache_ts_version: "v1-cat",
		redir_domain: 'slack-redir.net',
		signin_url: 'https://slack.com/signin',
		abs_root_url: 'https://slack.com/',
		api_url: '/api/',
		team_url: 'https://saebneweb.slack.com/',
		image_proxy_url: 'https://slack-imgs.com/',
		beacon_timing_url: "https:\/\/slack.com\/beacon\/timing",
		beacon_error_url: "https:\/\/slack.com\/beacon\/error",
		api_token: 'xoxs-21536046065-21865216340-27285723024-c5a5c23bd3',
		ls_disabled: false,

		feature_status: false,

		notification_sounds: [{"value":"b2.mp3","label":"Ding","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/b2.mp3"},{"value":"animal_stick.mp3","label":"Boing","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/animal_stick.mp3"},{"value":"been_tree.mp3","label":"Drop","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/been_tree.mp3"},{"value":"complete_quest_requirement.mp3","label":"Ta-da","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/complete_quest_requirement.mp3"},{"value":"confirm_delivery.mp3","label":"Plink","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/confirm_delivery.mp3"},{"value":"flitterbug.mp3","label":"Wow","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/flitterbug.mp3"},{"value":"here_you_go_lighter.mp3","label":"Here you go","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/here_you_go_lighter.mp3"},{"value":"hi_flowers_hit.mp3","label":"Hi","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/hi_flowers_hit.mp3"},{"value":"item_pickup.mp3","label":"Yoink","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/item_pickup.mp3"},{"value":"knock_brush.mp3","label":"Knock Brush","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/knock_brush.mp3"},{"value":"save_and_checkout.mp3","label":"Woah!","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/save_and_checkout.mp3"},{"value":"none","label":"None"}],
		alert_sounds: [{"value":"frog.mp3","label":"Frog","url":"https:\/\/slack.global.ssl.fastly.net\/a34a\/sounds\/frog.mp3"}],
		call_sounds: [{"value":"call\/alert_v2.mp3","label":"Alert","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/alert_v2.mp3"},{"value":"call\/incoming_ring_v2.mp3","label":"Incoming ring","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/incoming_ring_v2.mp3"},{"value":"call\/outgoing_ring_v2.mp3","label":"Outgoing ring","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/outgoing_ring_v2.mp3"},{"value":"call\/pop_v2.mp3","label":"Incoming reaction","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/pop_v2.mp3"},{"value":"call\/they_left_call_v2.mp3","label":"They left call","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/they_left_call_v2.mp3"},{"value":"call\/you_left_call_v2.mp3","label":"You left call","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/you_left_call_v2.mp3"},{"value":"call\/they_joined_call_v2.mp3","label":"They joined call","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/they_joined_call_v2.mp3"},{"value":"call\/you_joined_call_v2.mp3","label":"You joined call","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/you_joined_call_v2.mp3"},{"value":"call\/confirmation_v2.mp3","label":"Confirmation","url":"https:\/\/slack.global.ssl.fastly.net\/08f7\/sounds\/call\/confirmation_v2.mp3"}],
		call_sounds_version: "v2",

		feature_tinyspeck: false,
		feature_dm_yahself: false,
		feature_dm_yahself_ios: false,
		feature_dm_yahself_android: false,
		feature_dm_yahself_winphone: false,
		feature_feat_full_names: true,
		feature_signup_email_confirmation: true,
		feature_create_team_google_auth: false,
		feature_api_extended_2fa_backup: false,
		feature_api_queue_depth_warning: true,
		feature_ms_batch_presence_changes: false,
		feature_exp_ls: false,
		feature_perf_defer_initial_msg_check: false,
		feature_message_replies: false,
		feature_no_rollups: false,
		feature_ephemeral_attachments: false,
		feature_web_lean: false,
		feature_web_lean_all_users: false,
		feature_reminders_v3: false,
		feature_all_skin_tones: false,
		feature_a11y_keyboard_shortcuts: false,
		feature_email_integration: true,
		feature_email_ingestion: false,
		feature_msg_consistency: false,
		feature_emoji_keywords: false,
		feature_attachments_inline: false,
		feature_ms_events_always_use_promises: true,
		feature_billing_netsuite: true,
		feature_fix_files: true,
		feature_files_list: true,
		feature_chat_sounds: false,
		feature_channel_eventlog_client: true,
		feature_macssb1_banner: true,
		feature_macssb2_banner: true,
		feature_winssb1_banner: true,
		feature_latest_event_ts: true,
		feature_elide_closed_dms: true,
		feature_no_redirects_in_ssb: true,
		feature_referer_policy: true,
		feature_more_field_in_message_attachments: false,
		feature_user_hidden_msgs: false,
		feature_calls: true,
		feature_calls_no_rtm_start: false,
		feature_non_admin_invites: true,
		feature_integrations_message_preview: false,
		feature_paging_api: false,
		feature_enterprise_dashboard: true,
		feature_enterprise_api: true,
		feature_enterprise_create: true,
		feature_enterprise_api_auth: false,
		feature_enterprise_profile: true,
		feature_enterprise_search: true,
		feature_enterprise_team_invite: true,
		feature_bot_profile: false,
		feature_private_channels: true,
		feature_mpim_restrictions: false,
		feature_subteams: true,
		feature_subteams_hard_delete: false,
		feature_no_unread_counts: true,
		feature_js_raf_queue: false,
		feature_shared_channels: false,
		feature_join_channel_overlay_redesign: false,
		feature_shared_channels_ui: false,
		feature_external_shared_channels_ui: false,
		feature_fast_files_flexpane: false,
		feature_no_has_files: true,
		feature_tab_complete_search_changed: true,
		feature_custom_saml_signin_button_label: true,
		feature_services_jira_1_5: true,
		feature_channel_header_refresh: true,
		feature_winssb_beta_channel: false,
		feature_inline_video: false,
		feature_help_modal_refresh: false,
		feature_developers_lp: false,
		feature_homepage_ssb_download: false,
		feature_ssb_download_confirmation: false,
		feature_one_click_handler: true,
		feature_upload_file_switch_channel: true,
		feature_live_support: true,
		feature_slackbot_goes_to_college: false,
		feature_hbs_templates_version: true,
		feature_popover_dismiss_only: false,
		feature_jumbomoji: true,
		feature_jumbomoji_tsf: true,
		feature_attachment_actions: false,
		feature_remind_attachment_actions: false,
		feature_shared_invites: true,
		feature_lato_2_ssb: true,
		feature_refactor_buildmsghtml: false,
		feature_defer_client_bind_ui: true,
		feature_defer_localstorage_io: false,
		feature_allow_cdn_experiments: false,
		feature_omit_localstorage_users_bots: false,
		feature_disable_ls_compression: false,
		feature_sign_in_with_slack: false,
		feature_attachments_makeover: false,
		feature_slack_menu_improvements: true,
		feature_app_review: false,
		feature_name_tagging_client: false,
		feature_browse_date: false,
		feature_day_div_no_display: false,
		feature_no_ls_msgs_cache: false,
		feature_use_imgproxy_resizing: false,
		feature_update_message_file: false,
		feature_intercept_format_copy: false,
		feature_show_skin_tone_label: true,
		feature_calls_linux: false,
		feature_dont_send_internal_args: false,
		feature_client_save_cursor: false,
		feature_twilio_copilot: false,

		img: {
			app_icon: 'https://a.slack-edge.com/272a/img/slack_growl_icon.png'
		},
		page_needs_custom_emoji: false,
		page_needs_team_profile_fields: false,
		page_needs_enterprise: false,
	};

	
	
	
	
	// client boot data
	
//-->
</script>	
	
	
	<!-- output_js "core" -->
<script type="text/javascript" src="https://a.slack-edge.com/b7e8/js/rollup-core_required_libs.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/a8718/js/rollup-core_required_ts.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/7ab04/js/TS.web.js" crossorigin="anonymous"></script>

	<!-- output_js "core_web" -->
<script type="text/javascript" src="https://a.slack-edge.com/32de7/js/rollup-core_web.js" crossorigin="anonymous"></script>

	<!-- output_js "secondary" -->
<script type="text/javascript" src="https://a.slack-edge.com/bc8ac/js/rollup-secondary_a_required.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/7278d/js/rollup-secondary_b_required.js" crossorigin="anonymous"></script>

			<!-- output_js "regular" -->
<script type="text/javascript" src="https://a.slack-edge.com/1636/js/TS.web.comments.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/fbd4/js/TS.web.file.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/5183/js/libs/codemirror.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://a.slack-edge.com/e826/js/codemirror_load.js" crossorigin="anonymous"></script>

		<script type="text/javascript">
	<!--
		boot_data.page_needs_custom_emoji = true;

		boot_data.file = {"id":"F0ZFS5Y5V","created":1460340613,"timestamp":1460340613,"name":"jquery.form-validator.js","title":"jquery.form-validator.js","mimetype":"text\/plain","filetype":"javascript","pretty_type":"JavaScript\/JSON","user":"U0MLKCL8H","editable":true,"size":72583,"mode":"snippet","is_external":false,"external_type":"","is_public":false,"public_url_shared":false,"display_as_bot":false,"username":"","url_private":"https:\/\/files.slack.com\/files-pri\/T0MFS1C1X-F0ZFS5Y5V\/jquery.form-validator.js","url_private_download":"https:\/\/files.slack.com\/files-pri\/T0MFS1C1X-F0ZFS5Y5V\/download\/jquery.form-validator.js","permalink":"https:\/\/saebneweb.slack.com\/files\/tatiana\/F0ZFS5Y5V\/jquery.form-validator.js","permalink_public":"https:\/\/slack-files.com\/T0MFS1C1X-F0ZFS5Y5V-169670f89f","edit_link":"https:\/\/saebneweb.slack.com\/files\/tatiana\/F0ZFS5Y5V\/jquery.form-validator.js\/edit","preview":"(function (root, factory) {\r\n  if (typeof define === 'function' && define.amd) {\r\n    \/\/ AMD. Register as an anonymous module unless amdModuleId is set\r\n    define([\"jquery\"], function (a0) {\r\n      return (factory(a0));\r","preview_highlight":"\u003Cdiv class=\"CodeMirror cm-s-default CodeMirrorServer\"\u003E\n\u003Cdiv class=\"CodeMirror-code\"\u003E\n\u003Cdiv\u003E\u003Cpre\u003E(\u003Cspan class=\"cm-keyword\"\u003Efunction\u003C\/span\u003E (\u003Cspan class=\"cm-def\"\u003Eroot\u003C\/span\u003E, \u003Cspan class=\"cm-def\"\u003Efactory\u003C\/span\u003E) {\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E  \u003Cspan class=\"cm-keyword\"\u003Eif\u003C\/span\u003E (\u003Cspan class=\"cm-keyword\"\u003Etypeof\u003C\/span\u003E \u003Cspan class=\"cm-variable\"\u003Edefine\u003C\/span\u003E \u003Cspan class=\"cm-operator\"\u003E===\u003C\/span\u003E \u003Cspan class=\"cm-string\"\u003E'function'\u003C\/span\u003E \u003Cspan class=\"cm-operator\"\u003E&amp;&amp;\u003C\/span\u003E \u003Cspan class=\"cm-variable\"\u003Edefine\u003C\/span\u003E.\u003Cspan class=\"cm-property\"\u003Eamd\u003C\/span\u003E) {\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E    \u003Cspan class=\"cm-comment\"\u003E\/\/ AMD. Register as an anonymous module unless amdModuleId is set\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E    \u003Cspan class=\"cm-variable\"\u003Edefine\u003C\/span\u003E([\u003Cspan class=\"cm-string\"\u003E&quot;jquery&quot;\u003C\/span\u003E], \u003Cspan class=\"cm-keyword\"\u003Efunction\u003C\/span\u003E (\u003Cspan class=\"cm-def\"\u003Ea0\u003C\/span\u003E) {\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E      \u003Cspan class=\"cm-keyword\"\u003Ereturn\u003C\/span\u003E (\u003Cspan class=\"cm-variable-2\"\u003Efactory\u003C\/span\u003E(\u003Cspan class=\"cm-variable-2\"\u003Ea0\u003C\/span\u003E));\u003C\/pre\u003E\u003C\/div\u003E\n\u003C\/div\u003E\n\u003C\/div\u003E\n","lines":2121,"lines_more":2116,"channels":[],"groups":[],"ims":["D0MRMFX46"],"comments_count":0};
		boot_data.file.comments = [];

		

		var g_editor;

		$(function(){

			var wrap_long_lines = !!TS.model.code_wrap_long_lines;

			g_editor = CodeMirror(function(elt){
				var content = document.getElementById("file_contents");
				content.parentNode.replaceChild(elt, content);
			}, {
				value: $('#file_contents').text(),
				lineNumbers: true,
				matchBrackets: true,
				indentUnit: 4,
				indentWithTabs: true,
				enterMode: "keep",
				tabMode: "shift",
				viewportMargin: Infinity,
				readOnly: true,
				lineWrapping: wrap_long_lines
			});

			$('#file_preview_wrap_cb').bind('change', function(e) {
				TS.model.code_wrap_long_lines = $(this).prop('checked');
				g_editor.setOption('lineWrapping', TS.model.code_wrap_long_lines);
			})

			$('#file_preview_wrap_cb').prop('checked', wrap_long_lines);

			CodeMirror.switchSlackMode(g_editor, "javascript");
		});

		
		$('#file_comment').css('overflow', 'hidden').autogrow();
	//-->
	</script>

			<script type="text/javascript">TS.boot(boot_data);</script>
	<!-- slack-www549 / 2016-04-10 19:17:40 / v9fbe87666e87cb4161d238f7868871797e8b2f58 -->
<style>.color_9f69e7:not(.nuc) {color:#9F69E7;}.color_4bbe2e:not(.nuc) {color:#4BBE2E;}.color_e7392d:not(.nuc) {color:#E7392D;}.color_3c989f:not(.nuc) {color:#3C989F;}.color_674b1b:not(.nuc) {color:#674B1B;}.color_e96699:not(.nuc) {color:#E96699;}.color_e0a729:not(.nuc) {color:#E0A729;}.color_684b6c:not(.nuc) {color:#684B6C;}.color_5b89d5:not(.nuc) {color:#5B89D5;}.color_2b6836:not(.nuc) {color:#2B6836;}.color_99a949:not(.nuc) {color:#99A949;}.color_df3dc0:not(.nuc) {color:#DF3DC0;}.color_4cc091:not(.nuc) {color:#4CC091;}.color_9b3b45:not(.nuc) {color:#9B3B45;}.color_d58247:not(.nuc) {color:#D58247;}.color_bb86b7:not(.nuc) {color:#BB86B7;}.color_5a4592:not(.nuc) {color:#5A4592;}.color_db3150:not(.nuc) {color:#DB3150;}.color_235e5b:not(.nuc) {color:#235E5B;}.color_9e3997:not(.nuc) {color:#9E3997;}.color_53b759:not(.nuc) {color:#53B759;}.color_c386df:not(.nuc) {color:#C386DF;}.color_385a86:not(.nuc) {color:#385A86;}.color_a63024:not(.nuc) {color:#A63024;}.color_5870dd:not(.nuc) {color:#5870DD;}.color_ea2977:not(.nuc) {color:#EA2977;}.color_50a0cf:not(.nuc) {color:#50A0CF;}.color_d55aef:not(.nuc) {color:#D55AEF;}.color_d1707d:not(.nuc) {color:#D1707D;}.color_43761b:not(.nuc) {color:#43761B;}.color_e06b56:not(.nuc) {color:#E06B56;}.color_8f4a2b:not(.nuc) {color:#8F4A2B;}.color_902d59:not(.nuc) {color:#902D59;}.color_de5f24:not(.nuc) {color:#DE5F24;}.color_a2a5dc:not(.nuc) {color:#A2A5DC;}.color_827327:not(.nuc) {color:#827327;}.color_3c8c69:not(.nuc) {color:#3C8C69;}.color_8d4b84:not(.nuc) {color:#8D4B84;}.color_84b22f:not(.nuc) {color:#84B22F;}.color_4ec0d6:not(.nuc) {color:#4EC0D6;}.color_e23f99:not(.nuc) {color:#E23F99;}.color_e475df:not(.nuc) {color:#E475DF;}.color_619a4f:not(.nuc) {color:#619A4F;}.color_a72f79:not(.nuc) {color:#A72F79;}.color_7d414c:not(.nuc) {color:#7D414C;}.color_aba727:not(.nuc) {color:#ABA727;}.color_965d1b:not(.nuc) {color:#965D1B;}.color_4d5e26:not(.nuc) {color:#4D5E26;}.color_dd8527:not(.nuc) {color:#DD8527;}.color_bd9336:not(.nuc) {color:#BD9336;}.color_e85d72:not(.nuc) {color:#E85D72;}.color_dc7dbb:not(.nuc) {color:#DC7DBB;}.color_bc3663:not(.nuc) {color:#BC3663;}.color_9d8eee:not(.nuc) {color:#9D8EEE;}.color_8469bc:not(.nuc) {color:#8469BC;}.color_73769d:not(.nuc) {color:#73769D;}.color_b14cbc:not(.nuc) {color:#B14CBC;}</style>
</body>
</html>