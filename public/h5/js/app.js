/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/_xgplayer-hls.js@2.1.6@xgplayer-hls.js/dist/index.js":
/***/ (function(module, exports, __webpack_require__) {

!function(e,t){ true?module.exports=t(__webpack_require__("./node_modules/_xgplayer@2.6.15@xgplayer/dist/index.js")):"function"==typeof define&&define.amd?define(["xgplayer"],t):"object"==typeof exports?exports["xgplayer-hlsjs.js"]=t(require("xgplayer")):e["xgplayer-hlsjs.js"]=t(e.xgplayer)}(window,function(e){return function(e){var t={};function r(i){if(t[i])return t[i].exports;var a=t[i]={i:i,l:!1,exports:{}};return e[i].call(a.exports,a,a.exports,r),a.l=!0,a.exports}return r.m=e,r.c=t,r.d=function(e,t,i){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(r.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)r.d(i,a,function(t){return e[t]}.bind(null,a));return i},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=80)}([function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.logger=t.enableLogs=void 0;var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=r(7);function n(){}var o={trace:n,debug:n,log:n,warn:n,info:n,error:n},s=o;var l=(0,a.getSelfScope)();function u(e){for(var t=arguments.length,r=Array(t>1?t-1:0),i=1;i<t;i++)r[i-1]=arguments[i];r.forEach(function(t){s[t]=e[t]?e[t].bind(e):function(e){var t=l.console[e];return t?function(){for(var r=arguments.length,i=Array(r),a=0;a<r;a++)i[a]=arguments[a];i[0]&&(i[0]=function(e,t){return t="["+e+"] > "+t}(e,i[0])),t.apply(l.console,i)}:n}(t)})}t.enableLogs=function(e){if(!0===e||"object"===(void 0===e?"undefined":i(e))){u(e,"debug","log","info","warn","error");try{s.log()}catch(e){s=o}}else s=o},t.logger=s},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.default={MEDIA_ATTACHING:"hlsMediaAttaching",MEDIA_ATTACHED:"hlsMediaAttached",MEDIA_DETACHING:"hlsMediaDetaching",MEDIA_DETACHED:"hlsMediaDetached",BUFFER_RESET:"hlsBufferReset",BUFFER_CODECS:"hlsBufferCodecs",BUFFER_CREATED:"hlsBufferCreated",BUFFER_APPENDING:"hlsBufferAppending",BUFFER_APPENDED:"hlsBufferAppended",BUFFER_EOS:"hlsBufferEos",BUFFER_FLUSHING:"hlsBufferFlushing",BUFFER_FLUSHED:"hlsBufferFlushed",MANIFEST_LOADING:"hlsManifestLoading",MANIFEST_LOADED:"hlsManifestLoaded",MANIFEST_PARSED:"hlsManifestParsed",LEVEL_SWITCHING:"hlsLevelSwitching",LEVEL_SWITCHED:"hlsLevelSwitched",LEVEL_LOADING:"hlsLevelLoading",LEVEL_LOADED:"hlsLevelLoaded",LEVEL_UPDATED:"hlsLevelUpdated",LEVEL_PTS_UPDATED:"hlsLevelPtsUpdated",AUDIO_TRACKS_UPDATED:"hlsAudioTracksUpdated",AUDIO_TRACK_SWITCHING:"hlsAudioTrackSwitching",AUDIO_TRACK_SWITCHED:"hlsAudioTrackSwitched",AUDIO_TRACK_LOADING:"hlsAudioTrackLoading",AUDIO_TRACK_LOADED:"hlsAudioTrackLoaded",SUBTITLE_TRACKS_UPDATED:"hlsSubtitleTracksUpdated",SUBTITLE_TRACK_SWITCH:"hlsSubtitleTrackSwitch",SUBTITLE_TRACK_LOADING:"hlsSubtitleTrackLoading",SUBTITLE_TRACK_LOADED:"hlsSubtitleTrackLoaded",SUBTITLE_FRAG_PROCESSED:"hlsSubtitleFragProcessed",INIT_PTS_FOUND:"hlsInitPtsFound",FRAG_LOADING:"hlsFragLoading",FRAG_LOAD_PROGRESS:"hlsFragLoadProgress",FRAG_LOAD_EMERGENCY_ABORTED:"hlsFragLoadEmergencyAborted",FRAG_LOADED:"hlsFragLoaded",FRAG_DECRYPTED:"hlsFragDecrypted",FRAG_PARSING_INIT_SEGMENT:"hlsFragParsingInitSegment",FRAG_PARSING_USERDATA:"hlsFragParsingUserdata",FRAG_PARSING_METADATA:"hlsFragParsingMetadata",FRAG_PARSING_DATA:"hlsFragParsingData",FRAG_PARSED:"hlsFragParsed",FRAG_BUFFERED:"hlsFragBuffered",FRAG_CHANGED:"hlsFragChanged",FPS_DROP:"hlsFpsDrop",FPS_DROP_LEVEL_CAPPING:"hlsFpsDropLevelCapping",ERROR:"hlsError",DESTROYING:"hlsDestroying",KEY_LOADING:"hlsKeyLoading",KEY_LOADED:"hlsKeyLoaded",STREAM_STATE_TRANSITION:"hlsStreamStateTransition"},e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.ErrorTypes={NETWORK_ERROR:"networkError",MEDIA_ERROR:"mediaError",KEY_SYSTEM_ERROR:"keySystemError",MUX_ERROR:"muxError",OTHER_ERROR:"otherError"},t.ErrorDetails={KEY_SYSTEM_NO_KEYS:"keySystemNoKeys",KEY_SYSTEM_NO_ACCESS:"keySystemNoAccess",KEY_SYSTEM_NO_SESSION:"keySystemNoSession",KEY_SYSTEM_LICENSE_REQUEST_FAILED:"keySystemLicenseRequestFailed",MANIFEST_LOAD_ERROR:"manifestLoadError",MANIFEST_LOAD_TIMEOUT:"manifestLoadTimeOut",MANIFEST_PARSING_ERROR:"manifestParsingError",MANIFEST_INCOMPATIBLE_CODECS_ERROR:"manifestIncompatibleCodecsError",LEVEL_LOAD_ERROR:"levelLoadError",LEVEL_LOAD_TIMEOUT:"levelLoadTimeOut",LEVEL_SWITCH_ERROR:"levelSwitchError",AUDIO_TRACK_LOAD_ERROR:"audioTrackLoadError",AUDIO_TRACK_LOAD_TIMEOUT:"audioTrackLoadTimeOut",FRAG_LOAD_ERROR:"fragLoadError",FRAG_LOAD_TIMEOUT:"fragLoadTimeOut",FRAG_DECRYPT_ERROR:"fragDecryptError",FRAG_PARSING_ERROR:"fragParsingError",REMUX_ALLOC_ERROR:"remuxAllocError",KEY_LOAD_ERROR:"keyLoadError",KEY_LOAD_TIMEOUT:"keyLoadTimeOut",BUFFER_ADD_CODEC_ERROR:"bufferAddCodecError",BUFFER_APPEND_ERROR:"bufferAppendError",BUFFER_APPENDING_ERROR:"bufferAppendingError",BUFFER_STALLED_ERROR:"bufferStalledError",BUFFER_FULL_ERROR:"bufferFullError",BUFFER_SEEK_OVER_HOLE:"bufferSeekOverHole",BUFFER_NUDGE_ON_STALL:"bufferNudgeOnStall",INTERNAL_EXCEPTION:"internalException"}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),n=r(0),o=r(2),s=function(e){return e&&e.__esModule?e:{default:e}}(r(1));var l={hlsEventGeneric:!0,hlsHandlerDestroying:!0,hlsHandlerDestroyed:!0},u=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.hls=t,this.onEvent=this.onEvent.bind(this);for(var r=arguments.length,i=Array(r>1?r-1:0),a=1;a<r;a++)i[a-1]=arguments[a];this.handledEvents=i,this.useGenericHandler=!0,this.registerListeners()}return a(e,[{key:"destroy",value:function(){this.onHandlerDestroying(),this.unregisterListeners(),this.onHandlerDestroyed()}},{key:"onHandlerDestroying",value:function(){}},{key:"onHandlerDestroyed",value:function(){}},{key:"isEventHandler",value:function(){return"object"===i(this.handledEvents)&&this.handledEvents.length&&"function"==typeof this.onEvent}},{key:"registerListeners",value:function(){this.isEventHandler()&&this.handledEvents.forEach(function(e){if(l[e])throw new Error("Forbidden event-name: "+e);this.hls.on(e,this.onEvent)},this)}},{key:"unregisterListeners",value:function(){this.isEventHandler()&&this.handledEvents.forEach(function(e){this.hls.off(e,this.onEvent)},this)}},{key:"onEvent",value:function(e,t){this.onEventGeneric(e,t)}},{key:"onEventGeneric",value:function(e,t){try{(function(e,t){var r="on"+e.replace("hls","");if("function"!=typeof this[r])throw new Error("Event "+e+" has no generic handler in this "+this.constructor.name+" class (tried "+r+")");return this[r].bind(this,t)}).call(this,e,t).call()}catch(t){n.logger.error("An internal error happened while handling event "+e+'. Error message: "'+t.message+'". Here is a stacktrace:',t),this.hls.trigger(s.default.ERROR,{type:o.ErrorTypes.OTHER_ERROR,details:o.ErrorDetails.INTERNAL_EXCEPTION,fatal:!1,event:e,err:t})}}}]),e}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();t.BufferHelper=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"isBuffered",value:function(e,t){try{if(e)for(var r=e.buffered,i=0;i<r.length;i++)if(t>=r.start(i)&&t<=r.end(i))return!0}catch(e){}return!1}},{key:"bufferInfo",value:function(e,t,r){try{if(e){var i=e.buffered,a=[],n=void 0;for(n=0;n<i.length;n++)a.push({start:i.start(n),end:i.end(n)});return this.bufferedInfo(a,t,r)}}catch(e){}return{len:0,start:t,end:t,nextStart:void 0}}},{key:"bufferedInfo",value:function(e,t,r){var i=[],a=void 0,n=void 0,o=void 0,s=void 0,l=void 0;for(e.sort(function(e,t){var r=e.start-t.start;return r||t.end-e.end}),l=0;l<e.length;l++){var u=i.length;if(u){var d=i[u-1].end;e[l].start-d<r?e[l].end>d&&(i[u-1].end=e[l].end):i.push(e[l])}else i.push(e[l])}for(l=0,a=0,n=o=t;l<i.length;l++){var f=i[l].start,c=i[l].end;if(t+r>=f&&t<c)n=f,a=(o=c)-t;else if(t+r<f){s=f;break}}return{len:a,start:n,end:o,nextStart:s}}}]),e}()},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.addGroupId=function(e,t,r){switch(t){case"audio":e.audioGroupIds||(e.audioGroupIds=[]),e.audioGroupIds.push(r);break;case"text":e.textGroupIds||(e.textGroupIds=[]),e.textGroupIds.push(r)}},t.updatePTS=a,t.updateFragPTSDTS=n,t.mergeDetails=function(e,t){t.initSegment&&e.initSegment&&(t.initSegment=e.initSegment);var r=0,a=void 0;if(o(e,t,function(e,i){r=e.cc-i.cc,Number.isFinite(e.startPTS)&&(i.start=i.startPTS=e.startPTS,i.endPTS=e.endPTS,i.duration=e.duration,i.backtracked=e.backtracked,i.dropped=e.dropped,a=i),t.PTSKnown=!0}),!t.PTSKnown)return;if(r){i.logger.log("discontinuity sliding from playlist, take drift into account");for(var l=t.fragments,u=0;u<l.length;u++)l[u].cc+=r}a?n(t,a,a.startPTS,a.endPTS,a.startDTS,a.endDTS):s(e,t);t.PTSKnown=e.PTSKnown},t.mergeSubtitlePlaylists=function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0,i=-1;o(e,t,function(e,t,r){t.start=e.start,i=r});var a=t.fragments;if(i<0)return void a.forEach(function(e){e.start+=r});for(var n=i+1;n<a.length;n++)a[n].start=a[n-1].start+a[n-1].duration},t.mapFragmentIntersection=o,t.adjustSliding=s,t.computeReloadInterval=function(e,t,r){var i=1e3*(t.averagetargetduration?t.averagetargetduration:t.targetduration),a=i/2;e&&t.endSN===e.endSN&&(i=a);r&&(i=Math.max(a,i-(window.performance.now()-r)));return Math.round(i)};var i=r(0);function a(e,t,r){var a=e[t],n=e[r],o=n.startPTS;Number.isFinite(o)?r>t?(a.duration=o-a.start,a.duration<0&&i.logger.warn("negative duration computed for frag "+a.sn+",level "+a.level+", there should be some duration drift between playlist and fragment!")):(n.duration=a.start-o,n.duration<0&&i.logger.warn("negative duration computed for frag "+n.sn+",level "+n.level+", there should be some duration drift between playlist and fragment!")):n.start=r>t?a.start+a.duration:Math.max(a.start-n.duration,0)}function n(e,t,r,i,n,o){var s=r;if(Number.isFinite(t.startPTS)){var l=Math.abs(t.startPTS-r);Number.isFinite(t.deltaPTS)?t.deltaPTS=Math.max(l,t.deltaPTS):t.deltaPTS=l,s=Math.max(r,t.startPTS),r=Math.min(r,t.startPTS),i=Math.max(i,t.endPTS),n=Math.min(n,t.startDTS),o=Math.max(o,t.endDTS)}var u=r-t.start;t.start=t.startPTS=r,t.maxStartPTS=s,t.endPTS=i,t.startDTS=n,t.endDTS=o,t.duration=i-r;var d=t.sn;if(!e||d<e.startSN||d>e.endSN)return 0;var f,c=void 0,h=void 0;for(f=d-e.startSN,(c=e.fragments)[f]=t,h=f;h>0;h--)a(c,h,h-1);for(h=f;h<c.length-1;h++)a(c,h,h+1);return e.PTSKnown=!0,u}function o(e,t,r){if(e&&t)for(var i=Math.max(e.startSN,t.startSN)-t.startSN,a=Math.min(e.endSN,t.endSN)-t.startSN,n=t.startSN-e.startSN,o=i;o<=a;o++){var s=e.fragments[n+o],l=t.fragments[o];if(!s||!l)break;r(s,l,o)}}function s(e,t){var r=t.startSN-e.startSN,i=e.fragments,a=t.fragments;if(!(r<0||r>i.length))for(var n=0;n<a.length;n++)a[n].start+=i[r].start}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.FragmentTracker=t.FragmentState=void 0;var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=o(r(3)),n=o(r(1));function o(e){return e&&e.__esModule?e:{default:e}}var s=t.FragmentState={NOT_LOADED:"NOT_LOADED",APPENDING:"APPENDING",PARTIAL:"PARTIAL",OK:"OK"};t.FragmentTracker=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,n.default.BUFFER_APPENDED,n.default.FRAG_BUFFERED,n.default.FRAG_LOADED));return r.bufferPadding=.2,r.fragments=Object.create(null),r.timeRanges=Object.create(null),r.config=e.config,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default),i(t,[{key:"destroy",value:function(){this.fragments=Object.create(null),this.timeRanges=Object.create(null),this.config=null,a.default.prototype.destroy.call(this),function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"destroy",this).call(this)}},{key:"getBufferedFrag",value:function(e,t){var r=this.fragments,i=Object.keys(r).filter(function(i){var a=r[i];if(a.body.type!==t)return!1;if(!a.buffered)return!1;var n=a.body;return n.startPTS<=e&&e<=n.endPTS});if(0===i.length)return null;var a=i.pop();return r[a].body}},{key:"detectEvictedFragments",value:function(e,t){var r=this,i=void 0,a=void 0;Object.keys(this.fragments).forEach(function(n){var o=r.fragments[n];if(!0===o.buffered){var s=o.range[e];if(s){i=s.time;for(var l=0;l<i.length;l++)if(a=i[l],!1===r.isTimeBuffered(a.startPTS,a.endPTS,t)){r.removeFragment(o.body);break}}}})}},{key:"detectPartialFragments",value:function(e){var t=this,r=this.getFragmentKey(e),i=this.fragments[r];i&&(i.buffered=!0,Object.keys(this.timeRanges).forEach(function(r){if(e.hasElementaryStream(r)){var a=t.timeRanges[r];i.range[r]=t.getBufferedTimes(e.startPTS,e.endPTS,a)}}))}},{key:"getBufferedTimes",value:function(e,t,r){for(var i=[],a=void 0,n=void 0,o=!1,s=0;s<r.length;s++){if(a=r.start(s)-this.bufferPadding,n=r.end(s)+this.bufferPadding,e>=a&&t<=n){i.push({startPTS:Math.max(e,r.start(s)),endPTS:Math.min(t,r.end(s))});break}if(e<n&&t>a)i.push({startPTS:Math.max(e,r.start(s)),endPTS:Math.min(t,r.end(s))}),o=!0;else if(t<=a)break}return{time:i,partial:o}}},{key:"getFragmentKey",value:function(e){return e.type+"_"+e.level+"_"+e.urlId+"_"+e.sn}},{key:"getPartialFragment",value:function(e){var t=this,r=void 0,i=void 0,a=void 0,n=null,o=0;return Object.keys(this.fragments).forEach(function(s){var l=t.fragments[s];t.isPartial(l)&&(i=l.body.startPTS-t.bufferPadding,a=l.body.endPTS+t.bufferPadding,e>=i&&e<=a&&(r=Math.min(e-i,a-e),o<=r&&(n=l.body,o=r)))}),n}},{key:"getState",value:function(e){var t=this.getFragmentKey(e),r=this.fragments[t],i=s.NOT_LOADED;return void 0!==r&&(i=r.buffered?!0===this.isPartial(r)?s.PARTIAL:s.OK:s.APPENDING),i}},{key:"isPartial",value:function(e){return!0===e.buffered&&(void 0!==e.range.video&&!0===e.range.video.partial||void 0!==e.range.audio&&!0===e.range.audio.partial)}},{key:"isTimeBuffered",value:function(e,t,r){for(var i=void 0,a=void 0,n=0;n<r.length;n++){if(i=r.start(n)-this.bufferPadding,a=r.end(n)+this.bufferPadding,e>=i&&t<=a)return!0;if(t<=i)return!1}return!1}},{key:"onFragLoaded",value:function(e){var t=e.frag;Number.isFinite(t.sn)&&!t.bitrateTest&&(this.fragments[this.getFragmentKey(t)]={body:t,range:Object.create(null),buffered:!1})}},{key:"onBufferAppended",value:function(e){var t=this;this.timeRanges=e.timeRanges,Object.keys(this.timeRanges).forEach(function(e){var r=t.timeRanges[e];t.detectEvictedFragments(e,r)})}},{key:"onFragBuffered",value:function(e){this.detectPartialFragments(e.frag)}},{key:"hasFragment",value:function(e){var t=this.getFragmentKey(e);return void 0!==this.fragments[t]}},{key:"removeFragment",value:function(e){var t=this.getFragmentKey(e);delete this.fragments[t]}},{key:"removeAllFragments",value:function(){this.fragments=Object.create(null)}}]),t}()},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.getSelfScope=function(){return"undefined"==typeof window?self:window}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"isHeader",value:function(e,t){return t+10<=e.length&&73===e[t]&&68===e[t+1]&&51===e[t+2]&&e[t+3]<255&&e[t+4]<255&&e[t+6]<128&&e[t+7]<128&&e[t+8]<128&&e[t+9]<128}},{key:"isFooter",value:function(e,t){return t+10<=e.length&&51===e[t]&&68===e[t+1]&&73===e[t+2]&&e[t+3]<255&&e[t+4]<255&&e[t+6]<128&&e[t+7]<128&&e[t+8]<128&&e[t+9]<128}},{key:"getID3Data",value:function(t,r){for(var i=r,a=0;e.isHeader(t,r);){a+=10,a+=e._readSize(t,r+6),e.isFooter(t,r+10)&&(a+=10),r+=a}if(a>0)return t.subarray(i,i+a)}},{key:"_readSize",value:function(e,t){var r=0;return r=(127&e[t])<<21,r|=(127&e[t+1])<<14,r|=(127&e[t+2])<<7,r|=127&e[t+3]}},{key:"getTimeStamp",value:function(t){for(var r=e.getID3Frames(t),i=0;i<r.length;i++){var a=r[i];if(e.isTimeStampFrame(a))return e._readTimeStamp(a)}}},{key:"isTimeStampFrame",value:function(e){return e&&"PRIV"===e.key&&"com.apple.streaming.transportStreamTimestamp"===e.info}},{key:"_getFrameData",value:function(t){var r=String.fromCharCode(t[0],t[1],t[2],t[3]),i=e._readSize(t,4);return{type:r,size:i,data:t.subarray(10,10+i)}}},{key:"getID3Frames",value:function(t){for(var r=0,i=[];e.isHeader(t,r);){for(var a=e._readSize(t,r+6),n=(r+=10)+a;r+8<n;){var o=e._getFrameData(t.subarray(r)),s=e._decodeFrame(o);s&&i.push(s),r+=o.size+10}e.isFooter(t,r)&&(r+=10)}return i}},{key:"_decodeFrame",value:function(t){return"PRIV"===t.type?e._decodePrivFrame(t):"T"===t.type[0]?e._decodeTextFrame(t):"W"===t.type[0]?e._decodeURLFrame(t):void 0}},{key:"_readTimeStamp",value:function(e){if(8===e.data.byteLength){var t=new Uint8Array(e.data),r=1&t[3],i=(t[4]<<23)+(t[5]<<15)+(t[6]<<7)+t[7];return i/=45,r&&(i+=47721858.84),Math.round(i)}}},{key:"_decodePrivFrame",value:function(t){if(!(t.size<2)){var r=e._utf8ArrayToStr(t.data,!0),i=new Uint8Array(t.data.subarray(r.length+1));return{key:t.type,info:r,data:i.buffer}}}},{key:"_decodeTextFrame",value:function(t){if(!(t.size<2)){if("TXXX"===t.type){var r=1,i=e._utf8ArrayToStr(t.data.subarray(r));r+=i.length+1;var a=e._utf8ArrayToStr(t.data.subarray(r));return{key:t.type,info:i,data:a}}var n=e._utf8ArrayToStr(t.data.subarray(1));return{key:t.type,data:n}}}},{key:"_decodeURLFrame",value:function(t){if("WXXX"===t.type){if(t.size<2)return;var r=1,i=e._utf8ArrayToStr(t.data.subarray(r));r+=i.length+1;var a=e._utf8ArrayToStr(t.data.subarray(r));return{key:t.type,info:i,data:a}}var n=e._utf8ArrayToStr(t.data);return{key:t.type,data:n}}},{key:"_utf8ArrayToStr",value:function(e){for(var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],r=e.length,i=void 0,a=void 0,n=void 0,o="",s=0;s<r;){if(0===(i=e[s++])&&t)return o;if(0!==i&&3!==i)switch(i>>4){case 0:case 1:case 2:case 3:case 4:case 5:case 6:case 7:o+=String.fromCharCode(i);break;case 12:case 13:a=e[s++],o+=String.fromCharCode((31&i)<<6|63&a);break;case 14:a=e[s++],n=e[s++],o+=String.fromCharCode((15&i)<<12|(63&a)<<6|(63&n)<<0)}}return o}}]),e}(),n=a._utf8ArrayToStr;t.default=a,t.utf8ArrayToStr=n},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.default={search:function(e,t){for(var r=0,i=e.length-1,a=null,n=null;r<=i;){var o=t(n=e[a=(r+i)/2|0]);if(o>0)r=a+1;else{if(!(o<0))return n;i=a-1}}return null}},e.exports=t.default},function(e,t,r){!function(t){var r=/^((?:[a-zA-Z0-9+\-.]+:)?)(\/\/[^\/?#]*)?((?:[^\/\?#]*\/)*.*?)??(;.*?)?(\?.*?)?(#.*?)?$/,i=/^([^\/?#]*)(.*)$/,a=/(?:\/|^)\.(?=\/)/g,n=/(?:\/|^)\.\.\/(?!\.\.\/).*?(?=\/)/g,o={buildAbsoluteURL:function(e,t,r){if(r=r||{},e=e.trim(),!(t=t.trim())){if(!r.alwaysNormalize)return e;var a=o.parseURL(e);if(!a)throw new Error("Error trying to parse base URL.");return a.path=o.normalizePath(a.path),o.buildURLFromParts(a)}var n=o.parseURL(t);if(!n)throw new Error("Error trying to parse relative URL.");if(n.scheme)return r.alwaysNormalize?(n.path=o.normalizePath(n.path),o.buildURLFromParts(n)):t;var s=o.parseURL(e);if(!s)throw new Error("Error trying to parse base URL.");if(!s.netLoc&&s.path&&"/"!==s.path[0]){var l=i.exec(s.path);s.netLoc=l[1],s.path=l[2]}s.netLoc&&!s.path&&(s.path="/");var u={scheme:s.scheme,netLoc:n.netLoc,path:null,params:n.params,query:n.query,fragment:n.fragment};if(!n.netLoc&&(u.netLoc=s.netLoc,"/"!==n.path[0]))if(n.path){var d=s.path,f=d.substring(0,d.lastIndexOf("/")+1)+n.path;u.path=o.normalizePath(f)}else u.path=s.path,n.params||(u.params=s.params,n.query||(u.query=s.query));return null===u.path&&(u.path=r.alwaysNormalize?o.normalizePath(n.path):n.path),o.buildURLFromParts(u)},parseURL:function(e){var t=r.exec(e);return t?{scheme:t[1]||"",netLoc:t[2]||"",path:t[3]||"",params:t[4]||"",query:t[5]||"",fragment:t[6]||""}:null},normalizePath:function(e){for(e=e.split("").reverse().join("").replace(a,"");e.length!==(e=e.replace(n,"")).length;);return e.split("").reverse().join("")},buildURLFromParts:function(e){return e.scheme+e.netLoc+e.path+e.params+e.query+e.fragment}};e.exports=o}()},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.State=void 0;var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){return e&&e.__esModule?e:{default:e}}(r(17)),n=r(6),o=r(4),s=r(0);var l=t.State={STOPPED:"STOPPED",STARTING:"STARTING",IDLE:"IDLE",PAUSED:"PAUSED",KEY_LOADING:"KEY_LOADING",FRAG_LOADING:"FRAG_LOADING",FRAG_LOADING_WAITING_RETRY:"FRAG_LOADING_WAITING_RETRY",WAITING_TRACK:"WAITING_TRACK",PARSING:"PARSING",PARSED:"PARSED",BUFFER_FLUSHING:"BUFFER_FLUSHING",ENDED:"ENDED",ERROR:"ERROR",WAITING_INIT_PTS:"WAITING_INIT_PTS",WAITING_LEVEL:"WAITING_LEVEL"},u=function(e){function t(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default),i(t,[{key:"doTick",value:function(){}},{key:"startLoad",value:function(){}},{key:"stopLoad",value:function(){var e=this.fragCurrent;e&&(e.loader&&e.loader.abort(),this.fragmentTracker.removeFragment(e)),this.demuxer&&(this.demuxer.destroy(),this.demuxer=null),this.fragCurrent=null,this.fragPrevious=null,this.clearInterval(),this.clearNextTick(),this.state=l.STOPPED}},{key:"_streamEnded",value:function(e,t){var r=this.fragCurrent,i=this.fragmentTracker;if(!t.live&&r&&!r.backtracked&&r.sn===t.endSN&&!e.nextStart){var a=i.getState(r);return a===n.FragmentState.PARTIAL||a===n.FragmentState.OK}return!1}},{key:"onMediaSeeking",value:function(){var e=this.config,t=this.media,r=this.mediaBuffer,i=this.state,a=t?t.currentTime:null,n=o.BufferHelper.bufferInfo(r||t,a,this.config.maxBufferHole);if(Number.isFinite(a)&&s.logger.log("media seeking to "+a.toFixed(3)),i===l.FRAG_LOADING){var u=this.fragCurrent;if(0===n.len&&u){var d=e.maxFragLookUpTolerance,f=u.start-d,c=u.start+u.duration+d;a<f||a>c?(u.loader&&(s.logger.log("seeking outside of buffer while fragment load in progress, cancel fragment load"),u.loader.abort()),this.fragCurrent=null,this.fragPrevious=null,this.state=l.IDLE):s.logger.log("seeking outside of buffer but within currently loaded fragment range")}}else i===l.ENDED&&(0===n.len&&(this.fragPrevious=null,this.fragCurrent=null),this.state=l.IDLE);t&&(this.lastCurrentTime=a),this.loadedmetadata||(this.nextLoadPosition=this.startPosition=a),this.tick()}},{key:"onMediaEnded",value:function(){this.startPosition=this.lastCurrentTime=0}},{key:"onHandlerDestroying",value:function(){this.stopLoad(),function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"onHandlerDestroying",this).call(this)}},{key:"onHandlerDestroyed",value:function(){this.state=l.STOPPED,this.fragmentTracker=null}}]),t}();t.default=u},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.getMediaSource=function(){if("undefined"!=typeof window)return window.MediaSource||window.WebKitMediaSource}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=d(r(69)),n=d(r(68)),o=d(r(67)),s=r(2),l=r(0),u=d(r(1));function d(e){return e&&e.__esModule?e:{default:e}}var f=(0,r(7).getSelfScope)(),c=function(){function e(t,r){var i=(arguments.length>2&&void 0!==arguments[2]?arguments[2]:{}).removePKCS7Padding,a=void 0===i||i;if(function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.logEnabled=!0,this.observer=t,this.config=r,this.removePKCS7Padding=a,a)try{var n=f.crypto;n&&(this.subtle=n.subtle||n.webkitSubtle)}catch(e){}this.disableWebCrypto=!this.subtle}return i(e,[{key:"isSync",value:function(){return this.disableWebCrypto&&this.config.enableSoftwareAES}},{key:"decrypt",value:function(e,t,r,i){var s=this;if(this.disableWebCrypto&&this.config.enableSoftwareAES){this.logEnabled&&(l.logger.log("JS AES decrypt"),this.logEnabled=!1);var u=this.decryptor;u||(this.decryptor=u=new o.default),u.expandKey(t),i(u.decrypt(e,0,r,this.removePKCS7Padding))}else{this.logEnabled&&(l.logger.log("WebCrypto AES decrypt"),this.logEnabled=!1);var d=this.subtle;this.key!==t&&(this.key=t,this.fastAesKey=new n.default(d,t)),this.fastAesKey.expandKey().then(function(n){new a.default(d,r).decrypt(e,n).catch(function(a){s.onWebCryptoError(a,e,t,r,i)}).then(function(e){i(e)})}).catch(function(a){s.onWebCryptoError(a,e,t,r,i)})}}},{key:"onWebCryptoError",value:function(e,t,r,i,a){this.config.enableSoftwareAES?(l.logger.log("WebCrypto Error, disable WebCrypto API"),this.disableWebCrypto=!0,this.logEnabled=!0,this.decrypt(t,r,i,a)):(l.logger.error("decrypting error : "+e.message),this.observer.trigger(u.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.FRAG_DECRYPT_ERROR,fatal:!0,reason:e.message}))}},{key:"destroy",value:function(){var e=this.decryptor;e&&(e.destroy(),this.decryptor=void 0)}}]),e}();t.default=c,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(10)),n=function(e){return e&&e.__esModule?e:{default:e}}(r(28));function o(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var s=function(){function e(){var t;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this._url=null,this._byteRange=null,this._decryptdata=null,this.tagList=[],this.programDateTime=null,this.rawProgramDateTime=null,this._elementaryStreams=(o(t={},e.ElementaryStreamTypes.AUDIO,!1),o(t,e.ElementaryStreamTypes.VIDEO,!1),t)}return i(e,[{key:"addElementaryStream",value:function(e){this._elementaryStreams[e]=!0}},{key:"hasElementaryStream",value:function(e){return!0===this._elementaryStreams[e]}},{key:"createInitializationVector",value:function(e){for(var t=new Uint8Array(16),r=12;r<16;r++)t[r]=e>>8*(15-r)&255;return t}},{key:"fragmentDecryptdataFromLevelkey",value:function(e,t){var r=e;return e&&e.method&&e.uri&&!e.iv&&((r=new n.default).method=e.method,r.baseuri=e.baseuri,r.reluri=e.reluri,r.iv=this.createInitializationVector(t)),r}},{key:"url",get:function(){return!this._url&&this.relurl&&(this._url=a.buildAbsoluteURL(this.baseurl,this.relurl,{alwaysNormalize:!0})),this._url},set:function(e){this._url=e}},{key:"byteRange",get:function(){if(!this._byteRange&&!this.rawByteRange)return[];if(this._byteRange)return this._byteRange;var e=[];if(this.rawByteRange){var t=this.rawByteRange.split("@",2);if(1===t.length){var r=this.lastByteRangeEndOffset;e[0]=r||0}else e[0]=parseInt(t[1]);e[1]=parseInt(t[0])+e[0],this._byteRange=e}return e}},{key:"byteRangeStartOffset",get:function(){return this.byteRange[0]}},{key:"byteRangeEndOffset",get:function(){return this.byteRange[1]}},{key:"decryptdata",get:function(){return this._decryptdata||(this._decryptdata=this.fragmentDecryptdataFromLevelkey(this.levelkey,this.sn)),this._decryptdata}},{key:"endProgramDateTime",get:function(){if(!Number.isFinite(this.programDateTime))return null;var e=Number.isFinite(this.duration)?this.duration:0;return this.programDateTime+1e3*e}},{key:"encrypted",get:function(){return!(!this.decryptdata||null===this.decryptdata.uri||null!==this.decryptdata.key)}}],[{key:"ElementaryStreamTypes",get:function(){return{AUDIO:"audio",VIDEO:"video"}}}]),e}();t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.fixLineBreaks=void 0;var i=function(e){return e&&e.__esModule?e:{default:e}}(r(40));var a=function(){return{decode:function(e){if(!e)return"";if("string"!=typeof e)throw new Error("Error - expected string data.");return decodeURIComponent(encodeURIComponent(e))}}};function n(){this.window=window,this.state="INITIAL",this.buffer="",this.decoder=new a,this.regionList=[]}function o(){this.values=Object.create(null)}function s(e,t,r,i){var a=i?e.split(i):[e];for(var n in a)if("string"==typeof a[n]){var o=a[n].split(r);if(2===o.length)t(o[0],o[1])}}o.prototype={set:function(e,t){this.get(e)||""===t||(this.values[e]=t)},get:function(e,t,r){return r?this.has(e)?this.values[e]:t[r]:this.has(e)?this.values[e]:t},has:function(e){return e in this.values},alt:function(e,t,r){for(var i=0;i<r.length;++i)if(t===r[i]){this.set(e,t);break}},integer:function(e,t){/^-?\d+$/.test(t)&&this.set(e,parseInt(t,10))},percent:function(e,t){return!!(t.match(/^([\d]{1,3})(\.[\d]*)?%$/)&&(t=parseFloat(t))>=0&&t<=100)&&(this.set(e,t),!0)}};var l=new i.default(0,0,0),u="middle"===l.align?"middle":"center";function d(e,t,r){var i=e;function a(){var t=function(e){function t(e,t,r,i){return 3600*(0|e)+60*(0|t)+(0|r)+(0|i)/1e3}var r=e.match(/^(\d+):(\d{2})(:\d{2})?\.(\d{3})/);return r?r[3]?t(r[1],r[2],r[3].replace(":",""),r[4]):r[1]>59?t(r[1],r[2],0,r[4]):t(0,r[1],r[2],r[4]):null}(e);if(null===t)throw new Error("Malformed timestamp: "+i);return e=e.replace(/^[^\sa-zA-Z-]+/,""),t}function n(){e=e.replace(/^\s+/,"")}if(n(),t.startTime=a(),n(),"--\x3e"!==e.substr(0,3))throw new Error("Malformed time stamp (time stamps must be separated by '--\x3e'): "+i);e=e.substr(3),n(),t.endTime=a(),n(),function(e,t){var i=new o;s(e,function(e,t){switch(e){case"region":for(var a=r.length-1;a>=0;a--)if(r[a].id===t){i.set(e,r[a].region);break}break;case"vertical":i.alt(e,t,["rl","lr"]);break;case"line":var n=t.split(","),o=n[0];i.integer(e,o),i.percent(e,o)&&i.set("snapToLines",!1),i.alt(e,o,["auto"]),2===n.length&&i.alt("lineAlign",n[1],["start",u,"end"]);break;case"position":n=t.split(","),i.percent(e,n[0]),2===n.length&&i.alt("positionAlign",n[1],["start",u,"end","line-left","line-right","auto"]);break;case"size":i.percent(e,t);break;case"align":i.alt(e,t,["start",u,"end","left","right"])}},/:/,/\s/),t.region=i.get("region",null),t.vertical=i.get("vertical","");var a=i.get("line","auto");"auto"===a&&-1===l.line&&(a=-1),t.line=a,t.lineAlign=i.get("lineAlign","start"),t.snapToLines=i.get("snapToLines",!0),t.size=i.get("size",100),t.align=i.get("align",u);var n=i.get("position","auto");"auto"===n&&50===l.position&&(n="start"===t.align||"left"===t.align?0:"end"===t.align||"right"===t.align?100:50),t.position=n}(e,t)}function f(e){return e.replace(/<br(?: \/)?>/gi,"\n")}n.prototype={parse:function(e){var t=this;function r(){var e=t.buffer,r=0;for(e=f(e);r<e.length&&"\r"!==e[r]&&"\n"!==e[r];)++r;var i=e.substr(0,r);return"\r"===e[r]&&++r,"\n"===e[r]&&++r,t.buffer=e.substr(r),i}function a(e){s(e,function(e,t){e},/:/)}e&&(t.buffer+=t.decoder.decode(e,{stream:!0}));try{var n=void 0;if("INITIAL"===t.state){if(!/\r\n|\n/.test(t.buffer))return this;var o=(n=r()).match(/^(ï»¿)?WEBVTT([ \t].*)?$/);if(!o||!o[0])throw new Error("Malformed WebVTT signature.");t.state="HEADER"}for(var l=!1;t.buffer;){if(!/\r\n|\n/.test(t.buffer))return this;switch(l?l=!1:n=r(),t.state){case"HEADER":/:/.test(n)?a(n):n||(t.state="ID");continue;case"NOTE":n||(t.state="ID");continue;case"ID":if(/^NOTE($|[ \t])/.test(n)){t.state="NOTE";break}if(!n)continue;if(t.cue=new i.default(0,0,""),t.state="CUE",-1===n.indexOf("--\x3e")){t.cue.id=n;continue}case"CUE":try{d(n,t.cue,t.regionList)}catch(e){t.cue=null,t.state="BADCUE";continue}t.state="CUETEXT";continue;case"CUETEXT":var u=-1!==n.indexOf("--\x3e");if(!n||u&&(l=!0)){t.oncue&&t.oncue(t.cue),t.cue=null,t.state="ID";continue}t.cue.text&&(t.cue.text+="\n"),t.cue.text+=n;continue;case"BADCUE":n||(t.state="ID");continue}}}catch(e){"CUETEXT"===t.state&&t.cue&&t.oncue&&t.oncue(t.cue),t.cue=null,t.state="INITIAL"===t.state?"BADWEBVTT":"BADCUE"}return this},flush:function(){try{if(this.buffer+=this.decoder.decode(),(this.cue||"HEADER"===this.state)&&(this.buffer+="\n\n",this.parse()),"INITIAL"===this.state)throw new Error("Malformed WebVTT signature.")}catch(e){throw e}return this.onflush&&this.onflush(),this}},t.fixLineBreaks=f,t.default=n},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.sendAddTrackEvent=function(e,t){var r=null;try{r=new window.Event("addtrack")}catch(e){(r=document.createEvent("Event")).initEvent("addtrack",!1,!1)}r.track=e,t.dispatchEvent(r)},t.clearCurrentCues=function(e){if(e&&e.cues)for(;e.cues.length>0;)e.removeCue(e.cues[0])}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){return e&&e.__esModule?e:{default:e}}(r(3));var n=function(e){function t(e){var r;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);for(var i=arguments.length,a=Array(i>1?i-1:0),n=1;n<i;n++)a[n-1]=arguments[n];var o=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(r=t.__proto__||Object.getPrototypeOf(t)).call.apply(r,[this,e].concat(a)));return o._tickInterval=null,o._tickTimer=null,o._tickCallCount=0,o._boundTick=o.tick.bind(o),o}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default),i(t,[{key:"onHandlerDestroying",value:function(){this.clearNextTick(),this.clearInterval()}},{key:"hasInterval",value:function(){return!!this._tickInterval}},{key:"hasNextTick",value:function(){return!!this._tickTimer}},{key:"setInterval",value:function(e){function t(t){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e){return!this._tickInterval&&(this._tickInterval=setInterval(this._boundTick,e),!0)})},{key:"clearInterval",value:function(e){function t(){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(){return!!this._tickInterval&&(clearInterval(this._tickInterval),this._tickInterval=null,!0)})},{key:"clearNextTick",value:function(){return!!this._tickTimer&&(clearTimeout(this._tickTimer),this._tickTimer=null,!0)}},{key:"tick",value:function(){this._tickCallCount++,1===this._tickCallCount&&(this.doTick(),this._tickCallCount>1&&(this.clearNextTick(),this._tickTimer=setTimeout(this._boundTick,0)),this._tickCallCount=0)}},{key:"doTick",value:function(){}}]),t}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.findFragmentByPDT=function(e,t,r){if(!Array.isArray(e)||!e.length||!Number.isFinite(t))return null;if(t<e[0].programDateTime)return null;if(t>=e[e.length-1].endProgramDateTime)return null;r=r||0;for(var i=0;i<e.length;++i){var a=e[i];if(n(t,r,a))return a}return null},t.findFragmentByPTS=function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0,n=arguments.length>3&&void 0!==arguments[3]?arguments[3]:0,o=e?t[e.sn-t[0].sn+1]:null;if(o&&!a(r,n,o))return o;return i.default.search(t,a.bind(null,r,n))},t.fragmentWithinToleranceTest=a,t.pdtWithinToleranceTest=n;var i=function(e){return e&&e.__esModule?e:{default:e}}(r(9));function a(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,r=arguments[2],i=Math.min(t,r.duration+(r.deltaPTS?r.deltaPTS:0));return r.start+r.duration-i<=e?1:r.start-i>e&&r.start?-1:0}function n(e,t,r){var i=1e3*Math.min(t,r.duration+(r.deltaPTS?r.deltaPTS:0));return r.endProgramDateTime-i>e}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.findFirstFragWithCC=n,t.findFragWithCC=function(e,t){return i.default.search(e,function(e){return e.cc<t?1:e.cc>t?-1:0})},t.shouldAlignOnDiscontinuities=o,t.findDiscontinuousReferenceFrag=s,t.adjustPts=l,t.alignStream=function(e,t,r){u(e,r,t),!r.PTSKnown&&t&&d(r,t.details)},t.alignDiscontinuities=u,t.alignPDT=d;var i=function(e){return e&&e.__esModule?e:{default:e}}(r(9)),a=r(0);function n(e,t){for(var r=null,i=0;i<e.length;i+=1){var a=e[i];if(a&&a.cc===t){r=a;break}}return r}function o(e,t,r){var i=!1;return t&&t.details&&r&&(r.endCC>r.startCC||e&&e.cc<r.startCC)&&(i=!0),i}function s(e,t){var r=e.fragments,i=t.fragments;if(i.length&&r.length){var o=n(r,i[0].cc);if(o&&(!o||o.startPTS))return o;a.logger.log("No frag in previous level to align on")}else a.logger.log("No fragments to align")}function l(e,t){t.fragments.forEach(function(t){if(t){var r=t.start+e;t.start=t.startPTS=r,t.endPTS=r+t.duration}}),t.PTSKnown=!0}function u(e,t,r){if(o(e,r,t)){var i=s(r.details,t);i&&(a.logger.log("Adjusting PTS using last level due to CC increase within current level"),l(i.start,t))}}function d(e,t){if(t&&t.fragments.length){if(!e.hasProgramDateTime||!t.hasProgramDateTime)return;var r=t.fragments[0].programDateTime,i=(e.fragments[0].programDateTime-r)/1e3+t.fragments[0].start;Number.isFinite(i)&&(a.logger.log("adjusting PTS using programDateTime delta, sliding:"+i.toFixed(3)),l(i,e))}}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.default={toString:function(e){for(var t="",r=e.length,i=0;i<r;i++)t+="["+e.start(i).toFixed(3)+","+e.end(i).toFixed(3)+"]";return t}},e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.Observer=void 0;var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=r(57);t.Observer=function(e){function t(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.EventEmitter),i(t,[{key:"trigger",value:function(e){for(var t=arguments.length,r=Array(t>1?t-1:0),i=1;i<t;i++)r[i-1]=arguments[i];this.emit.apply(this,[e,e].concat(r))}}]),t}()},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={BitratesMap:[32,64,96,128,160,192,224,256,288,320,352,384,416,448,32,48,56,64,80,96,112,128,160,192,224,256,320,384,32,40,48,56,64,80,96,112,128,160,192,224,256,320,32,48,56,64,80,96,112,128,144,160,176,192,224,256,8,16,24,32,40,48,56,64,80,96,112,128,144,160],SamplingRateMap:[44100,48e3,32e3,22050,24e3,16e3,11025,12e3,8e3],SamplesCoefficients:[[0,72,144,12],[0,0,0,0],[0,72,144,12],[0,144,144,12]],BytesInSlot:[0,1,1,4],appendFrame:function(e,t,r,i,a){if(!(r+24>t.length)){var n=this.parseHeader(t,r);if(n&&r+n.frameLength<=t.length){var o=i+a*(9e4*n.samplesPerFrame/n.sampleRate),s={unit:t.subarray(r,r+n.frameLength),pts:o,dts:o};return e.config=[],e.channelCount=n.channelCount,e.samplerate=n.sampleRate,e.samples.push(s),e.len+=n.frameLength,{sample:s,length:n.frameLength}}}},parseHeader:function(e,t){var r=e[t+1]>>3&3,a=e[t+1]>>1&3,n=e[t+2]>>4&15,o=e[t+2]>>2&3,s=e[t+2]>>1&1;if(1!==r&&0!==n&&15!==n&&3!==o){var l=3===r?3-a:3===a?3:4,u=1e3*i.BitratesMap[14*l+n-1],d=3===r?0:2===r?1:2,f=i.SamplingRateMap[3*d+o],c=e[t+3]>>6==3?1:2,h=i.SamplesCoefficients[r][a],v=i.BytesInSlot[a],g=8*h*v;return{sampleRate:f,channelCount:c,frameLength:parseInt(h*u/f+s,10)*v,samplesPerFrame:g}}},isHeaderPattern:function(e,t){return 255===e[t]&&224==(224&e[t+1])&&0!=(6&e[t+1])},isHeader:function(e,t){return!!(t+1<e.length&&this.isHeaderPattern(e,t))},probe:function(e,t){if(t+1<e.length&&this.isHeaderPattern(e,t)){var r=this.parseHeader(e,t),i=4;r&&r.frameLength&&(i=r.frameLength);var a=t+i;if(a===e.length||a+1<e.length&&this.isHeaderPattern(e,a))return!0}return!1}};t.default=i,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.getAudioConfig=o,t.isHeaderPattern=s,t.getHeaderLength=l,t.getFullFrameLength=u,t.isHeader=function(e,t){if(t+1<e.length&&s(e,t))return!0;return!1},t.probe=function(e,t){if(t+1<e.length&&s(e,t)){var r=l(e,t),i=r;t+5<e.length&&(i=u(e,t));var a=t+i;if(a===e.length||a+1<e.length&&s(e,a))return!0}return!1},t.initTrackConfig=function(e,t,r,a,n){if(!e.samplerate){var s=o(t,r,a,n);e.config=s.config,e.samplerate=s.samplerate,e.channelCount=s.channelCount,e.codec=s.codec,e.manifestCodec=s.manifestCodec,i.logger.log("parsed codec:"+e.codec+",rate:"+s.samplerate+",nb channel:"+s.channelCount)}},t.getFrameDuration=d,t.parseFrameHeader=f,t.appendFrame=function(e,t,r,i,a){var n=d(e.samplerate),o=f(t,r,i,a,n);if(o){var s=o.stamp,l=o.headerLength,u=o.frameLength,c={unit:t.subarray(r+l,r+l+u),pts:s,dts:s};return e.samples.push(c),e.len+=u,{sample:c,length:u+l}}return};var i=r(0),a=r(2),n=function(e){return e&&e.__esModule?e:{default:e}}(r(1));r(7);function o(e,t,r,o){var s,l=void 0,u=void 0,d=void 0,f=void 0,c=navigator.userAgent.toLowerCase(),h=o,v=[96e3,88200,64e3,48e3,44100,32e3,24e3,22050,16e3,12e3,11025,8e3,7350];if(l=1+((192&t[r+2])>>>6),!((s=(60&t[r+2])>>>2)>v.length-1))return d=(1&t[r+2])<<2,d|=(192&t[r+3])>>>6,i.logger.log("manifest codec:"+o+",ADTS data:type:"+l+",sampleingIndex:"+s+"["+v[s]+"Hz],channelConfig:"+d),/firefox/i.test(c)?s>=6?(l=5,f=new Array(4),u=s-3):(l=2,f=new Array(2),u=s):-1!==c.indexOf("android")?(l=2,f=new Array(2),u=s):(l=5,f=new Array(4),o&&(-1!==o.indexOf("mp4a.40.29")||-1!==o.indexOf("mp4a.40.5"))||!o&&s>=6?u=s-3:((o&&-1!==o.indexOf("mp4a.40.2")&&(s>=6&&1===d||/vivaldi/i.test(c))||!o&&1===d)&&(l=2,f=new Array(2)),u=s)),f[0]=l<<3,f[0]|=(14&s)>>1,f[1]|=(1&s)<<7,f[1]|=d<<3,5===l&&(f[1]|=(14&u)>>1,f[2]=(1&u)<<7,f[2]|=8,f[3]=0),{config:f,samplerate:v[s],channelCount:d,codec:"mp4a.40."+l,manifestCodec:h};e.trigger(n.default.ERROR,{type:a.ErrorTypes.MEDIA_ERROR,details:a.ErrorDetails.FRAG_PARSING_ERROR,fatal:!0,reason:"invalid ADTS sampling index:"+s})}function s(e,t){return 255===e[t]&&240==(246&e[t+1])}function l(e,t){return 1&e[t+1]?7:9}function u(e,t){return(3&e[t+3])<<11|e[t+4]<<3|(224&e[t+5])>>>5}function d(e){return 9216e4/e}function f(e,t,r,i,a){var n,o=void 0,s=e.length;if(n=l(e,t),o=u(e,t),(o-=n)>0&&t+n+o<=s)return{headerLength:n,frameLength:o,stamp:r+i*a}}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=g(r(1)),n=r(2),o=g(r(13)),s=g(r(66)),l=g(r(29)),u=g(r(65)),d=g(r(62)),f=g(r(61)),c=g(r(58)),h=r(7),v=r(0);function g(e){return e&&e.__esModule?e:{default:e}}var p=(0,h.getSelfScope)(),y=void 0;try{y=p.performance.now.bind(p.performance)}catch(e){v.logger.debug("Unable to use Performance API on this environment"),y=p.Date.now}var m=function(){function e(t,r,i,a){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.typeSupported=r,this.config=i,this.vendor=a}return i(e,[{key:"destroy",value:function(){var e=this.demuxer;e&&e.destroy()}},{key:"push",value:function(e,t,r,i,n,s,l,u,d,f,c,h){var v=this;if(e.byteLength>0&&null!=t&&null!=t.key&&"AES-128"===t.method){var g=this.decrypter;null==g&&(g=this.decrypter=new o.default(this.observer,this.config));var p=y();g.decrypt(e,t.key.buffer,t.iv.buffer,function(e){var o=y();v.observer.trigger(a.default.FRAG_DECRYPTED,{stats:{tstart:p,tdecrypt:o}}),v.pushDecrypted(new Uint8Array(e),t,new Uint8Array(r),i,n,s,l,u,d,f,c,h)})}else this.pushDecrypted(new Uint8Array(e),t,new Uint8Array(r),i,n,s,l,u,d,f,c,h)}},{key:"pushDecrypted",value:function(e,t,r,i,o,h,v,g,p,y,m,b){var E=this.demuxer;if(!E||(v||g)&&!this.probe(e)){for(var _=this.observer,T=this.typeSupported,S=this.config,k=[{demux:u.default,remux:f.default},{demux:l.default,remux:c.default},{demux:s.default,remux:f.default},{demux:d.default,remux:f.default}],R=0,A=k.length;R<A;R++){var w=k[R],O=w.demux.probe;if(O(e)){var L=this.remuxer=new w.remux(_,S,T,this.vendor);E=new w.demux(_,L,S,T),this.probe=O;break}}if(!E)return void _.trigger(a.default.ERROR,{type:n.ErrorTypes.MEDIA_ERROR,details:n.ErrorDetails.FRAG_PARSING_ERROR,fatal:!0,reason:"no demux matching with content found"});this.demuxer=E}var D=this.remuxer;(v||g)&&(E.resetInitSegment(r,i,o,y),D.resetInitSegment()),v&&(E.resetTimeStamp(b),D.resetTimeStamp(b)),"function"==typeof E.setDecryptData&&E.setDecryptData(t),E.append(e,h,p,m)}}]),e}();t.default=m,e.exports=t.default},function(e,t,r){"use strict";var i,a="object"==typeof Reflect?Reflect:null,n=a&&"function"==typeof a.apply?a.apply:function(e,t,r){return Function.prototype.apply.call(e,t,r)};i=a&&"function"==typeof a.ownKeys?a.ownKeys:Object.getOwnPropertySymbols?function(e){return Object.getOwnPropertyNames(e).concat(Object.getOwnPropertySymbols(e))}:function(e){return Object.getOwnPropertyNames(e)};var o=Number.isNaN||function(e){return e!=e};function s(){s.init.call(this)}e.exports=s,s.EventEmitter=s,s.prototype._events=void 0,s.prototype._eventsCount=0,s.prototype._maxListeners=void 0;var l=10;function u(e){return void 0===e._maxListeners?s.defaultMaxListeners:e._maxListeners}function d(e,t,r,i){var a,n,o;if("function"!=typeof r)throw new TypeError('The "listener" argument must be of type Function. Received type '+typeof r);if(void 0===(n=e._events)?(n=e._events=Object.create(null),e._eventsCount=0):(void 0!==n.newListener&&(e.emit("newListener",t,r.listener?r.listener:r),n=e._events),o=n[t]),void 0===o)o=n[t]=r,++e._eventsCount;else if("function"==typeof o?o=n[t]=i?[r,o]:[o,r]:i?o.unshift(r):o.push(r),(a=u(e))>0&&o.length>a&&!o.warned){o.warned=!0;var s=new Error("Possible EventEmitter memory leak detected. "+o.length+" "+String(t)+" listeners added. Use emitter.setMaxListeners() to increase limit");s.name="MaxListenersExceededWarning",s.emitter=e,s.type=t,s.count=o.length,function(e){console&&console.warn&&console.warn(e)}(s)}return e}function f(e,t,r){var i={fired:!1,wrapFn:void 0,target:e,type:t,listener:r},a=function(){for(var e=[],t=0;t<arguments.length;t++)e.push(arguments[t]);this.fired||(this.target.removeListener(this.type,this.wrapFn),this.fired=!0,n(this.listener,this.target,e))}.bind(i);return a.listener=r,i.wrapFn=a,a}function c(e,t,r){var i=e._events;if(void 0===i)return[];var a=i[t];return void 0===a?[]:"function"==typeof a?r?[a.listener||a]:[a]:r?function(e){for(var t=new Array(e.length),r=0;r<t.length;++r)t[r]=e[r].listener||e[r];return t}(a):v(a,a.length)}function h(e){var t=this._events;if(void 0!==t){var r=t[e];if("function"==typeof r)return 1;if(void 0!==r)return r.length}return 0}function v(e,t){for(var r=new Array(t),i=0;i<t;++i)r[i]=e[i];return r}Object.defineProperty(s,"defaultMaxListeners",{enumerable:!0,get:function(){return l},set:function(e){if("number"!=typeof e||e<0||o(e))throw new RangeError('The value of "defaultMaxListeners" is out of range. It must be a non-negative number. Received '+e+".");l=e}}),s.init=function(){void 0!==this._events&&this._events!==Object.getPrototypeOf(this)._events||(this._events=Object.create(null),this._eventsCount=0),this._maxListeners=this._maxListeners||void 0},s.prototype.setMaxListeners=function(e){if("number"!=typeof e||e<0||o(e))throw new RangeError('The value of "n" is out of range. It must be a non-negative number. Received '+e+".");return this._maxListeners=e,this},s.prototype.getMaxListeners=function(){return u(this)},s.prototype.emit=function(e){for(var t=[],r=1;r<arguments.length;r++)t.push(arguments[r]);var i="error"===e,a=this._events;if(void 0!==a)i=i&&void 0===a.error;else if(!i)return!1;if(i){var o;if(t.length>0&&(o=t[0]),o instanceof Error)throw o;var s=new Error("Unhandled error."+(o?" ("+o.message+")":""));throw s.context=o,s}var l=a[e];if(void 0===l)return!1;if("function"==typeof l)n(l,this,t);else{var u=l.length,d=v(l,u);for(r=0;r<u;++r)n(d[r],this,t)}return!0},s.prototype.addListener=function(e,t){return d(this,e,t,!1)},s.prototype.on=s.prototype.addListener,s.prototype.prependListener=function(e,t){return d(this,e,t,!0)},s.prototype.once=function(e,t){if("function"!=typeof t)throw new TypeError('The "listener" argument must be of type Function. Received type '+typeof t);return this.on(e,f(this,e,t)),this},s.prototype.prependOnceListener=function(e,t){if("function"!=typeof t)throw new TypeError('The "listener" argument must be of type Function. Received type '+typeof t);return this.prependListener(e,f(this,e,t)),this},s.prototype.removeListener=function(e,t){var r,i,a,n,o;if("function"!=typeof t)throw new TypeError('The "listener" argument must be of type Function. Received type '+typeof t);if(void 0===(i=this._events))return this;if(void 0===(r=i[e]))return this;if(r===t||r.listener===t)0==--this._eventsCount?this._events=Object.create(null):(delete i[e],i.removeListener&&this.emit("removeListener",e,r.listener||t));else if("function"!=typeof r){for(a=-1,n=r.length-1;n>=0;n--)if(r[n]===t||r[n].listener===t){o=r[n].listener,a=n;break}if(a<0)return this;0===a?r.shift():function(e,t){for(;t+1<e.length;t++)e[t]=e[t+1];e.pop()}(r,a),1===r.length&&(i[e]=r[0]),void 0!==i.removeListener&&this.emit("removeListener",e,o||t)}return this},s.prototype.off=s.prototype.removeListener,s.prototype.removeAllListeners=function(e){var t,r,i;if(void 0===(r=this._events))return this;if(void 0===r.removeListener)return 0===arguments.length?(this._events=Object.create(null),this._eventsCount=0):void 0!==r[e]&&(0==--this._eventsCount?this._events=Object.create(null):delete r[e]),this;if(0===arguments.length){var a,n=Object.keys(r);for(i=0;i<n.length;++i)"removeListener"!==(a=n[i])&&this.removeAllListeners(a);return this.removeAllListeners("removeListener"),this._events=Object.create(null),this._eventsCount=0,this}if("function"==typeof(t=r[e]))this.removeListener(e,t);else if(void 0!==t)for(i=t.length-1;i>=0;i--)this.removeListener(e,t[i]);return this},s.prototype.listeners=function(e){return c(this,e,!0)},s.prototype.rawListeners=function(e){return c(this,e,!1)},s.listenerCount=function(e,t){return"function"==typeof e.listenerCount?e.listenerCount(t):h.call(e,t)},s.prototype.listenerCount=h,s.prototype.eventNames=function(){return this._eventsCount>0?i(this._events):[]}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=(r(25),function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(70))),n=c(r(1)),o=c(r(24)),s=r(0),l=r(2),u=r(12),d=r(7),f=r(21);function c(e){return e&&e.__esModule?e:{default:e}}var h=(0,d.getSelfScope)(),v=(0,u.getMediaSource)(),g=function(){function e(t,r){var i=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.hls=t,this.id=r;var u=this.observer=new f.Observer,d=t.config,c=function(e,r){(r=r||{}).frag=i.frag,r.id=i.id,t.trigger(e,r)};u.on(n.default.FRAG_DECRYPTED,c),u.on(n.default.FRAG_PARSING_INIT_SEGMENT,c),u.on(n.default.FRAG_PARSING_DATA,c),u.on(n.default.FRAG_PARSED,c),u.on(n.default.ERROR,c),u.on(n.default.FRAG_PARSING_METADATA,c),u.on(n.default.FRAG_PARSING_USERDATA,c),u.on(n.default.INIT_PTS_FOUND,c);var g={mp4:v.isTypeSupported("video/mp4"),mpeg:v.isTypeSupported("audio/mpeg"),mp3:v.isTypeSupported('audio/mp4; codecs="mp3"')},p=navigator.vendor;if(d.enableWorker&&"undefined"!=typeof Worker){s.logger.log("demuxing in webworker");var y=void 0;try{y=this.w=a(56),this.onwmsg=this.onWorkerMessage.bind(this),y.addEventListener("message",this.onwmsg),y.onerror=function(e){t.trigger(n.default.ERROR,{type:l.ErrorTypes.OTHER_ERROR,details:l.ErrorDetails.INTERNAL_EXCEPTION,fatal:!0,event:"demuxerWorker",err:{message:e.message+" ("+e.filename+":"+e.lineno+")"}})},y.postMessage({cmd:"init",typeSupported:g,vendor:p,id:r,config:JSON.stringify(d)})}catch(e){s.logger.warn("Error in worker:",e),s.logger.error("Error while initializing DemuxerWorker, fallback on DemuxerInline"),y&&h.URL.revokeObjectURL(y.objectURL),this.demuxer=new o.default(u,g,d,p),this.w=void 0}}else this.demuxer=new o.default(u,g,d,p)}return i(e,[{key:"destroy",value:function(){var e=this.w;if(e)e.removeEventListener("message",this.onwmsg),e.terminate(),this.w=null;else{var t=this.demuxer;t&&(t.destroy(),this.demuxer=null)}var r=this.observer;r&&(r.removeAllListeners(),this.observer=null)}},{key:"push",value:function(e,t,r,i,a,n,o,l){var u=this.w,d=Number.isFinite(a.startPTS)?a.startPTS:a.start,f=a.decryptdata,c=this.frag,h=!(c&&a.cc===c.cc),v=!(c&&a.level===c.level),g=c&&a.sn===c.sn+1,p=!v&&g;if(h&&s.logger.log(this.id+":discontinuity detected"),v&&s.logger.log(this.id+":switch detected"),this.frag=a,u)u.postMessage({cmd:"demux",data:e,decryptdata:f,initSegment:t,audioCodec:r,videoCodec:i,timeOffset:d,discontinuity:h,trackSwitch:v,contiguous:p,duration:n,accurateTimeOffset:o,defaultInitPTS:l},e instanceof ArrayBuffer?[e]:[]);else{var y=this.demuxer;y&&y.push(e,f,t,r,i,d,h,v,p,n,o,l)}}},{key:"onWorkerMessage",value:function(e){var t=e.data,r=this.hls;switch(t.event){case"init":h.URL.revokeObjectURL(this.w.objectURL);break;case n.default.FRAG_PARSING_DATA:t.data.data1=new Uint8Array(t.data1),t.data2&&(t.data.data2=new Uint8Array(t.data2));default:t.data=t.data||{},t.data.frag=this.frag,t.data.id=this.id,r.trigger(t.event,t.data)}}}]),e}();t.default=g,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={audio:{a3ds:!0,"ac-3":!0,"ac-4":!0,alac:!0,alaw:!0,dra1:!0,"dts+":!0,"dts-":!0,dtsc:!0,dtse:!0,dtsh:!0,"ec-3":!0,enca:!0,g719:!0,g726:!0,m4ae:!0,mha1:!0,mha2:!0,mhm1:!0,mhm2:!0,mlpa:!0,mp4a:!0,"raw ":!0,Opus:!0,samr:!0,sawb:!0,sawp:!0,sevc:!0,sqcp:!0,ssmv:!0,twos:!0,ulaw:!0},video:{avc1:!0,avc2:!0,avc3:!0,avc4:!0,avcp:!0,drac:!0,dvav:!0,dvhe:!0,encv:!0,hev1:!0,hvc1:!0,mjp2:!0,mp4v:!0,mvc1:!0,mvc2:!0,mvc3:!0,mvc4:!0,resv:!0,rv60:!0,s263:!0,svc1:!0,svc2:!0,"vc-1":!0,vp08:!0,vp09:!0}};t.isCodecType=function(e,t){var r=i[t];return!!r&&!0===r[e.slice(0,4)]},t.isCodecSupportedInMp4=function(e,t){return window.MediaSource.isTypeSupported((t||"video")+'/mp4;codecs="'+e+'"')}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(10));var n=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.method=null,this.key=null,this.iv=null,this._uri=null}return i(e,[{key:"uri",get:function(){return!this._uri&&this.reluri&&(this._uri=a.buildAbsoluteURL(this.baseuri,this.reluri,{alwaysNormalize:!0})),this._uri}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=r(0),n=function(e){return e&&e.__esModule?e:{default:e}}(r(1));var o=Math.pow(2,32)-1,s=function(){function e(t,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.remuxer=r}return i(e,[{key:"resetTimeStamp",value:function(e){this.initPTS=e}},{key:"resetInitSegment",value:function(t,r,i,a){if(t&&t.byteLength){var o=this.initData=e.parseInitSegment(t);null==r&&(r="mp4a.40.5"),null==i&&(i="avc1.42e01e");var s={};o.audio&&o.video?s.audiovideo={container:"video/mp4",codec:r+","+i,initSegment:a?t:null}:(o.audio&&(s.audio={container:"audio/mp4",codec:r,initSegment:a?t:null}),o.video&&(s.video={container:"video/mp4",codec:i,initSegment:a?t:null})),this.observer.trigger(n.default.FRAG_PARSING_INIT_SEGMENT,{tracks:s})}else r&&(this.audioCodec=r),i&&(this.videoCodec=i)}},{key:"append",value:function(t,r,i,a){var o=this.initData;o||(this.resetInitSegment(t,this.audioCodec,this.videoCodec,!1),o=this.initData);var s,l=this.initPTS;if(void 0===l){var u=e.getStartDTS(o,t);this.initPTS=l=u-r,this.observer.trigger(n.default.INIT_PTS_FOUND,{initPTS:l})}e.offsetStartDTS(o,t,l),s=e.getStartDTS(o,t),this.remuxer.remux(o.audio,o.video,null,null,s,i,a,t)}},{key:"destroy",value:function(){}}],[{key:"probe",value:function(t){return e.findBox({data:t,start:0,end:Math.min(t.length,16384)},["moof"]).length>0}},{key:"bin2str",value:function(e){return String.fromCharCode.apply(null,e)}},{key:"readUint16",value:function(e,t){e.data&&(t+=e.start,e=e.data);var r=e[t]<<8|e[t+1];return r<0?65536+r:r}},{key:"readUint32",value:function(e,t){e.data&&(t+=e.start,e=e.data);var r=e[t]<<24|e[t+1]<<16|e[t+2]<<8|e[t+3];return r<0?4294967296+r:r}},{key:"writeUint32",value:function(e,t,r){e.data&&(t+=e.start,e=e.data),e[t]=r>>24,e[t+1]=r>>16&255,e[t+2]=r>>8&255,e[t+3]=255&r}},{key:"findBox",value:function(t,r){var i=[],a=void 0,n=void 0,o=void 0,s=void 0,l=void 0,u=void 0,d=void 0;if(t.data?(u=t.start,s=t.end,t=t.data):(u=0,s=t.byteLength),!r.length)return null;for(a=u;a<s;)n=e.readUint32(t,a),o=e.bin2str(t.subarray(a+4,a+8)),d=n>1?a+n:s,o===r[0]&&(1===r.length?i.push({data:t,start:a+8,end:d}):(l=e.findBox({data:t,start:a+8,end:d},r.slice(1))).length&&(i=i.concat(l))),a=d;return i}},{key:"parseSegmentIndex",value:function(t){var r=e.findBox(t,["moov"])[0],i=r?r.end:null,a=0,n=e.findBox(t,["sidx"]),o=void 0;if(!n||!n[0])return null;o=[];var s=(n=n[0]).data[0];a=0===s?8:16;var l=e.readUint32(n,a);a+=4;a+=0===s?8:16,a+=2;var u=n.end+0,d=e.readUint16(n,a);a+=2;for(var f=0;f<d;f++){var c=a,h=e.readUint32(n,c);c+=4;var v=2147483647&h;if(1===(2147483648&h)>>>31)return void console.warn("SIDX has hierarchical references (not supported)");var g=e.readUint32(n,c);c+=4,o.push({referenceSize:v,subsegmentDuration:g,info:{duration:g/l,start:u,end:u+v-1}}),u+=v,a=c+=4}return{earliestPresentationTime:0,timescale:l,version:s,referencesCount:d,references:o,moovEndOffset:i}}},{key:"parseInitSegment",value:function(t){var r=[];return e.findBox(t,["moov","trak"]).forEach(function(t){var i=e.findBox(t,["tkhd"])[0];if(i){var n=i.data[i.start],o=0===n?12:20,s=e.readUint32(i,o),l=e.findBox(t,["mdia","mdhd"])[0];if(l){o=0===(n=l.data[l.start])?12:20;var u=e.readUint32(l,o),d=e.findBox(t,["mdia","hdlr"])[0];if(d){var f={soun:"audio",vide:"video"}[e.bin2str(d.data.subarray(d.start+8,d.start+12))];if(f){var c=e.findBox(t,["mdia","minf","stbl","stsd"]);if(c.length){c=c[0];var h=e.bin2str(c.data.subarray(c.start+12,c.start+16));a.logger.log("MP4Demuxer:"+f+":"+h+" found")}r[s]={timescale:u,type:f},r[f]={timescale:u,id:s}}}}}}),r}},{key:"getStartDTS",value:function(t,r){var i,a,n=void 0;return n=e.findBox(r,["moof","traf"]),i=[].concat.apply([],n.map(function(r){return e.findBox(r,["tfhd"]).map(function(i){var a,n;return a=e.readUint32(i,4),n=t[a].timescale||9e4,e.findBox(r,["tfdt"]).map(function(t){var r,i=void 0;return r=t.data[t.start],i=e.readUint32(t,4),1===r&&(i*=Math.pow(2,32),i+=e.readUint32(t,8)),i})[0]/n})})),a=Math.min.apply(null,i),isFinite(a)?a:0}},{key:"offsetStartDTS",value:function(t,r,i){e.findBox(r,["moof","traf"]).map(function(r){return e.findBox(r,["tfhd"]).map(function(a){var n=e.readUint32(a,4),s=t[n].timescale||9e4;e.findBox(r,["tfdt"]).map(function(t){var r=t.data[t.start],a=e.readUint32(t,4);if(0===r)e.writeUint32(t,4,a-i*s);else{a*=Math.pow(2,32),a+=e.readUint32(t,8),a-=i*s,a=Math.max(a,0);var n=Math.floor(a/(o+1)),l=Math.floor(a%(o+1));e.writeUint32(t,4,n),e.writeUint32(t,8,l)}})})})}}]),e}();t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=d(r(1)),n=d(r(3)),o=r(2),s=r(0),l=d(r(29)),u=d(r(76));function d(e){return e&&e.__esModule?e:{default:e}}var f=window.performance,c={MANIFEST:"manifest",LEVEL:"level",AUDIO_TRACK:"audioTrack",SUBTITLE_TRACK:"subtitleTrack"},h={MAIN:"main",AUDIO:"audio",SUBTITLE:"subtitle"},v=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MANIFEST_LOADING,a.default.LEVEL_LOADING,a.default.AUDIO_TRACK_LOADING,a.default.SUBTITLE_TRACK_LOADING));return r.loaders={},r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"createInternalLoader",value:function(e){var t=this.hls.config,r=t.pLoader,i=t.loader,a=new(r||i)(t);return e.loader=a,this.loaders[e.type]=a,a}},{key:"getInternalLoader",value:function(e){return this.loaders[e.type]}},{key:"resetInternalLoader",value:function(e){this.loaders[e]&&delete this.loaders[e]}},{key:"destroyInternalLoaders",value:function(){for(var e in this.loaders){var t=this.loaders[e];t&&t.destroy(),this.resetInternalLoader(e)}}},{key:"destroy",value:function(){this.destroyInternalLoaders(),function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"destroy",this).call(this)}},{key:"onManifestLoading",value:function(e){this.load(e.url,{type:c.MANIFEST,level:0,id:null})}},{key:"onLevelLoading",value:function(e){this.load(e.url,{type:c.LEVEL,level:e.level,id:e.id})}},{key:"onAudioTrackLoading",value:function(e){this.load(e.url,{type:c.AUDIO_TRACK,level:null,id:e.id})}},{key:"onSubtitleTrackLoading",value:function(e){this.load(e.url,{type:c.SUBTITLE_TRACK,level:null,id:e.id})}},{key:"load",value:function(e,t){var r=this.hls.config;s.logger.debug("Loading playlist of type "+t.type+", level: "+t.level+", id: "+t.id);var i=this.getInternalLoader(t);if(i){var a=i.context;if(a&&a.url===e)return s.logger.trace("playlist request ongoing"),!1;s.logger.warn("aborting previous loader for type: "+t.type),i.abort()}var n=void 0,o=void 0,l=void 0,u=void 0;switch(t.type){case c.MANIFEST:n=r.manifestLoadingMaxRetry,o=r.manifestLoadingTimeOut,l=r.manifestLoadingRetryDelay,u=r.manifestLoadingMaxRetryTimeout;break;case c.LEVEL:n=0,o=r.levelLoadingTimeOut;break;default:n=r.levelLoadingMaxRetry,o=r.levelLoadingTimeOut,l=r.levelLoadingRetryDelay,u=r.levelLoadingMaxRetryTimeout}i=this.createInternalLoader(t),t.url=e,t.responseType=t.responseType||"";var d={timeout:o,maxRetry:n,retryDelay:l,maxRetryDelay:u},f={onSuccess:this.loadsuccess.bind(this),onError:this.loaderror.bind(this),onTimeout:this.loadtimeout.bind(this)};return s.logger.debug("Calling internal loader delegate for URL: "+e),i.load(t,d,f),!0}},{key:"loadsuccess",value:function(e,t,r){var i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null;if(r.isSidxRequest)return this._handleSidxRequest(e,r),void this._handlePlaylistLoaded(e,t,r,i);this.resetInternalLoader(r.type);var a=e.data;t.tload=f.now(),0===a.indexOf("#EXTM3U")?a.indexOf("#EXTINF:")>0||a.indexOf("#EXT-X-TARGETDURATION:")>0?this._handleTrackOrLevelPlaylist(e,t,r,i):this._handleMasterPlaylist(e,t,r,i):this._handleManifestParsingError(e,r,"no EXTM3U delimiter",i)}},{key:"loaderror",value:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this._handleNetworkError(t,r,!1,e)}},{key:"loadtimeout",value:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;this._handleNetworkError(t,r,!0)}},{key:"_handleMasterPlaylist",value:function(e,r,i,n){var o=this.hls,l=e.data,d=t.getResponseUrl(e,i),f=u.default.parseMasterPlaylist(l,d);if(f.length){var c=f.map(function(e){return{id:e.attrs.AUDIO,codec:e.audioCodec}}),h=u.default.parseMasterPlaylistMedia(l,d,"AUDIO",c),v=u.default.parseMasterPlaylistMedia(l,d,"SUBTITLES");if(h.length){var g=!1;h.forEach(function(e){e.url||(g=!0)}),!1===g&&f[0].audioCodec&&!f[0].attrs.AUDIO&&(s.logger.log("audio codec signaled in quality level, but no embedded audio track signaled, create one"),h.unshift({type:"main",name:"main"}))}o.trigger(a.default.MANIFEST_LOADED,{levels:f,audioTracks:h,subtitles:v,url:d,stats:r,networkDetails:n})}else this._handleManifestParsingError(e,i,"no level found in manifest",n)}},{key:"_handleTrackOrLevelPlaylist",value:function(e,r,i,n){var o=this.hls,s=i.id,l=i.level,d=i.type,h=t.getResponseUrl(e,i),v=Number.isFinite(s)?s:0,g=Number.isFinite(l)?l:v,p=t.mapContextToLevelType(i),y=u.default.parseLevelPlaylist(e.data,h,g,p,v);if(y.tload=r.tload,d===c.MANIFEST){var m={url:h,details:y};o.trigger(a.default.MANIFEST_LOADED,{levels:[m],audioTracks:[],url:h,stats:r,networkDetails:n})}if(r.tparsed=f.now(),y.needSidxRanges){var b=y.initSegment.url;this.load(b,{isSidxRequest:!0,type:d,level:l,levelDetails:y,id:s,rangeStart:0,rangeEnd:2048,responseType:"arraybuffer"})}else i.levelDetails=y,this._handlePlaylistLoaded(e,r,i,n)}},{key:"_handleSidxRequest",value:function(e,t){var r=l.default.parseSegmentIndex(new Uint8Array(e.data));if(r){var i=r.references,a=t.levelDetails;i.forEach(function(e,t){var r=e.info,i=a.fragments[t];0===i.byteRange.length&&(i.rawByteRange=String(1+r.end-r.start)+"@"+String(r.start))}),a.initSegment.rawByteRange=String(r.moovEndOffset)+"@0"}}},{key:"_handleManifestParsingError",value:function(e,t,r,i){this.hls.trigger(a.default.ERROR,{type:o.ErrorTypes.NETWORK_ERROR,details:o.ErrorDetails.MANIFEST_PARSING_ERROR,fatal:!0,url:e.url,reason:r,networkDetails:i})}},{key:"_handleNetworkError",value:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]&&arguments[2],i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null;s.logger.info("A network error occured while loading a "+e.type+"-type playlist");var n=void 0,l=void 0,u=this.getInternalLoader(e);switch(e.type){case c.MANIFEST:n=r?o.ErrorDetails.MANIFEST_LOAD_TIMEOUT:o.ErrorDetails.MANIFEST_LOAD_ERROR,l=!0;break;case c.LEVEL:n=r?o.ErrorDetails.LEVEL_LOAD_TIMEOUT:o.ErrorDetails.LEVEL_LOAD_ERROR,l=!1;break;case c.AUDIO_TRACK:n=r?o.ErrorDetails.AUDIO_TRACK_LOAD_TIMEOUT:o.ErrorDetails.AUDIO_TRACK_LOAD_ERROR,l=!1;break;default:l=!1}u&&(u.abort(),this.resetInternalLoader(e.type));var d={type:o.ErrorTypes.NETWORK_ERROR,details:n,fatal:l,url:u.url,loader:u,context:e,networkDetails:t};i&&(d.response=i),this.hls.trigger(a.default.ERROR,d)}},{key:"_handlePlaylistLoaded",value:function(e,r,i,n){var o=i.type,s=i.level,l=i.id,u=i.levelDetails;if(u.targetduration)if(t.canHaveQualityLevels(i.type))this.hls.trigger(a.default.LEVEL_LOADED,{details:u,level:s||0,id:l||0,stats:r,networkDetails:n});else switch(o){case c.AUDIO_TRACK:this.hls.trigger(a.default.AUDIO_TRACK_LOADED,{details:u,id:l,stats:r,networkDetails:n});break;case c.SUBTITLE_TRACK:this.hls.trigger(a.default.SUBTITLE_TRACK_LOADED,{details:u,id:l,stats:r,networkDetails:n})}else this._handleManifestParsingError(e,i,"invalid target duration",n)}}],[{key:"canHaveQualityLevels",value:function(e){return e!==c.AUDIO_TRACK&&e!==c.SUBTITLE_TRACK}},{key:"mapContextToLevelType",value:function(e){switch(e.type){case c.AUDIO_TRACK:return h.AUDIO;case c.SUBTITLE_TRACK:return h.SUBTITLE;default:return h.MAIN}}},{key:"getResponseUrl",value:function(e,t){var r=e.url;return void 0!==r&&0!==r.indexOf("data:")||(r=t.url),r}},{key:"ContextType",get:function(){return c}},{key:"LevelType",get:function(){return h}}]),t}();t.default=v,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={getBrowserVersion:function(){var e=navigator.userAgent;if(e.toLowerCase().indexOf("mobile")>-1)return"Unknown";if(e.indexOf("Firefox")>-1)return"Firefox "+e.match(/firefox\/[\d.]+/gi)[0].match(/[\d]+/)[0];if(e.indexOf("Edge")>-1)return"Edge "+e.match(/edge\/[\d.]+/gi)[0].match(/[\d]+/)[0];if(e.indexOf("rv:11")>-1)return"IE 11";if(e.indexOf("Opera")>-1||e.indexOf("OPR")>-1){if(e.indexOf("Opera")>-1)return"Opera "+e.match(/opera\/[\d.]+/gi)[0].match(/[\d]+/)[0];if(e.indexOf("OPR")>-1)return"Opera "+e.match(/opr\/[\d.]+/gi)[0].match(/[\d]+/)[0]}else{if(e.indexOf("Chrome")>-1)return"Chrome "+e.match(/chrome\/[\d.]+/gi)[0].match(/[\d]+/)[0];if(e.indexOf("Safari")>-1)return"Safari "+e.match(/safari\/[\d.]+/gi)[0].match(/[\d]+/)[0];if(!(e.indexOf("MSIE")>-1||e.indexOf("Trident")>-1))return"Unknown";if(e.indexOf("MSIE")>-1)return"IE "+e.match(/msie [\d.]+/gi)[0].match(/[\d]+/)[0];if(e.indexOf("Trident")>-1){var t=e.match(/trident\/[\d.]+/gi)[0].match(/[\d]+/)[0];return"IE "+(parseInt(t)+4)}}}};t.default=i,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i="undefined"!=typeof window&&window.navigator&&window.navigator.requestMediaKeySystemAccess?window.navigator.requestMediaKeySystemAccess.bind(window.navigator):null;t.requestMediaKeySystemAccess=i},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(3)),n=l(r(1)),o=r(2),s=r(0);function l(e){return e&&e.__esModule?e:{default:e}}var u=window.XMLHttpRequest,d="com.widevine.alpha",f="com.microsoft.playready",c=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,n.default.MEDIA_ATTACHED,n.default.MANIFEST_PARSED));return r._widevineLicenseUrl=e.config.widevineLicenseUrl,r._licenseXhrSetup=e.config.licenseXhrSetup,r._emeEnabled=e.config.emeEnabled,r._requestMediaKeySystemAccess=e.config.requestMediaKeySystemAccessFunc,r._mediaKeysList=[],r._media=null,r._hasSetMediaKeys=!1,r._isMediaEncrypted=!1,r._requestLicenseFailureCount=0,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default),i(t,[{key:"getLicenseServerUrl",value:function(e){var t=void 0;switch(e){case d:t=this._widevineLicenseUrl;break;default:t=null}return t||(s.logger.error('No license server URL configured for key-system "'+e+'"'),this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_LICENSE_REQUEST_FAILED,fatal:!0})),t}},{key:"_attemptKeySystemAccess",value:function(e,t,r){var i=this,a=function(e,t,r){switch(e){case d:return function(e,t,r){var i={videoCapabilities:[]};return t.forEach(function(e){i.videoCapabilities.push({contentType:'video/mp4; codecs="'+e+'"'})}),[i]}(0,r);default:throw Error("Unknown key-system: "+e)}}(e,0,r);a?(s.logger.log("Requesting encrypted media key-system access"),this.requestMediaKeySystemAccess(e,a).then(function(t){i._onMediaKeySystemAccessObtained(e,t)}).catch(function(t){s.logger.error('Failed to obtain key-system "'+e+'" access:',t)})):s.logger.warn("Can not create config for key-system (maybe because platform is not supported):",e)}},{key:"_onMediaKeySystemAccessObtained",value:function(e,t){var r=this;s.logger.log('Access for key-system "'+e+'" obtained');var i={mediaKeys:null,mediaKeysSession:null,mediaKeysSessionInitialized:!1,mediaKeySystemAccess:t,mediaKeySystemDomain:e};this._mediaKeysList.push(i),t.createMediaKeys().then(function(t){i.mediaKeys=t,s.logger.log('Media-keys created for key-system "'+e+'"'),r._onMediaKeysCreated()}).catch(function(e){s.logger.error("Failed to create media-keys:",e)})}},{key:"_onMediaKeysCreated",value:function(){var e=this;this._mediaKeysList.forEach(function(t){t.mediaKeysSession||(t.mediaKeysSession=t.mediaKeys.createSession(),e._onNewMediaKeySession(t.mediaKeysSession))})}},{key:"_onNewMediaKeySession",value:function(e){var t=this;s.logger.log("New key-system session "+e.sessionId),e.addEventListener("message",function(r){t._onKeySessionMessage(e,r.message)},!1)}},{key:"_onKeySessionMessage",value:function(e,t){s.logger.log("Got EME message event, creating license request"),this._requestLicense(t,function(t){s.logger.log("Received license data, updating key-session"),e.update(t)})}},{key:"_onMediaEncrypted",value:function(e,t){s.logger.log('Media is encrypted using "'+e+'" init data type'),this._isMediaEncrypted=!0,this._mediaEncryptionInitDataType=e,this._mediaEncryptionInitData=t,this._attemptSetMediaKeys(),this._generateRequestWithPreferredKeySession()}},{key:"_attemptSetMediaKeys",value:function(){if(!this._hasSetMediaKeys){var e=this._mediaKeysList[0];if(!e||!e.mediaKeys)return s.logger.error("Fatal: Media is encrypted but no CDM access or no keys have been obtained yet"),void this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_NO_KEYS,fatal:!0});s.logger.log("Setting keys for encrypted media"),this._media.setMediaKeys(e.mediaKeys),this._hasSetMediaKeys=!0}}},{key:"_generateRequestWithPreferredKeySession",value:function(){var e=this,t=this._mediaKeysList[0];if(!t)return s.logger.error("Fatal: Media is encrypted but not any key-system access has been obtained yet"),void this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_NO_ACCESS,fatal:!0});if(t.mediaKeysSessionInitialized)s.logger.warn("Key-Session already initialized but requested again");else{var r=t.mediaKeysSession;r||(s.logger.error("Fatal: Media is encrypted but no key-session existing"),this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_NO_SESSION,fatal:!0}));var i=this._mediaEncryptionInitDataType,a=this._mediaEncryptionInitData;s.logger.log('Generating key-session request for "'+i+'" init data type'),t.mediaKeysSessionInitialized=!0,r.generateRequest(i,a).then(function(){s.logger.debug("Key-session generation succeeded")}).catch(function(t){s.logger.error("Error generating key-session request:",t),e.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_NO_SESSION,fatal:!1})})}}},{key:"_createLicenseXhr",value:function(e,t,r){var i=new u,a=this._licenseXhrSetup;try{if(a)try{a(i,e)}catch(t){i.open("POST",e,!0),a(i,e)}i.readyState||i.open("POST",e,!0)}catch(e){return s.logger.error("Error setting up key-system license XHR",e),void this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_LICENSE_REQUEST_FAILED,fatal:!0})}return i.responseType="arraybuffer",i.onreadystatechange=this._onLicenseRequestReadyStageChange.bind(this,i,e,t,r),i}},{key:"_onLicenseRequestReadyStageChange",value:function(e,t,r,i){switch(e.readyState){case 4:if(200===e.status)this._requestLicenseFailureCount=0,s.logger.log("License request succeeded"),i(e.response);else{if(s.logger.error("License Request XHR failed ("+t+"). Status: "+e.status+" ("+e.statusText+")"),this._requestLicenseFailureCount++,this._requestLicenseFailureCount<=3){var a=3-this._requestLicenseFailureCount+1;return s.logger.warn("Retrying license request, "+a+" attempts left"),void this._requestLicense(r,i)}this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_LICENSE_REQUEST_FAILED,fatal:!0})}}}},{key:"_generateLicenseRequestChallenge",value:function(e,t){var r=void 0;return e.mediaKeySystemDomain===f?s.logger.error("PlayReady is not supported (yet)"):e.mediaKeySystemDomain===d?r=t:s.logger.error("Unsupported key-system:",e.mediaKeySystemDomain),r}},{key:"_requestLicense",value:function(e,t){s.logger.log("Requesting content license for key-system");var r=this._mediaKeysList[0];if(!r)return s.logger.error("Fatal error: Media is encrypted but no key-system access has been obtained yet"),void this.hls.trigger(n.default.ERROR,{type:o.ErrorTypes.KEY_SYSTEM_ERROR,details:o.ErrorDetails.KEY_SYSTEM_NO_ACCESS,fatal:!0});var i=this.getLicenseServerUrl(r.mediaKeySystemDomain),a=this._createLicenseXhr(i,e,t);s.logger.log("Sending license request to URL: "+i),a.send(this._generateLicenseRequestChallenge(r,e))}},{key:"onMediaAttached",value:function(e){var t=this;if(this._emeEnabled){var r=e.media;this._media=r,r.addEventListener("encrypted",function(e){t._onMediaEncrypted(e.initDataType,e.initData)})}}},{key:"onManifestParsed",value:function(e){if(this._emeEnabled){var t=e.levels.map(function(e){return e.audioCodec}),r=e.levels.map(function(e){return e.videoCodec});this._attemptKeySystemAccess(d,t,r)}}},{key:"requestMediaKeySystemAccess",get:function(){if(!this._requestMediaKeySystemAccess)throw new Error("No requestMediaKeySystemAccess function configured");return this._requestMediaKeySystemAccess}}]),t}();t.default=c,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.SubtitleStreamController=void 0;var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=h(r(1)),n=r(0),o=h(r(13)),s=r(4),l=r(18),u=r(6),d=r(11),f=h(d),c=r(5);function h(e){return e&&e.__esModule?e:{default:e}}var v=window.performance;t.SubtitleStreamController=function(e){function t(e,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var i=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHED,a.default.MEDIA_DETACHING,a.default.ERROR,a.default.KEY_LOADED,a.default.FRAG_LOADED,a.default.SUBTITLE_TRACKS_UPDATED,a.default.SUBTITLE_TRACK_SWITCH,a.default.SUBTITLE_TRACK_LOADED,a.default.SUBTITLE_FRAG_PROCESSED,a.default.LEVEL_UPDATED));return i.fragmentTracker=r,i.config=e.config,i.state=d.State.STOPPED,i.tracks=[],i.tracksBuffered=[],i.currentTrackId=-1,i.decrypter=new o.default(e,e.config),i.lastAVStart=0,i._onMediaSeeking=i.onMediaSeeking.bind(i),i}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,f.default),i(t,[{key:"onSubtitleFragProcessed",value:function(e){var t=e.frag,r=e.success;if(this.fragPrevious=t,this.state=d.State.IDLE,r){var i=this.tracksBuffered[this.currentTrackId];if(i){for(var a=void 0,n=t.start,o=0;o<i.length;o++)if(n>=i[o].start&&n<=i[o].end){a=i[o];break}var s=t.start+t.duration;a?a.end=s:(a={start:n,end:s},i.push(a))}}}},{key:"onMediaAttached",value:function(e){var t=e.media;this.media=t,t.addEventListener("seeking",this._onMediaSeeking),this.state=d.State.IDLE}},{key:"onMediaDetaching",value:function(){this.media.removeEventListener("seeking",this._onMediaSeeking),this.media=null,this.state=d.State.STOPPED}},{key:"onError",value:function(e){var t=e.frag;t&&"subtitle"===t.type&&(this.state=d.State.IDLE)}},{key:"onSubtitleTracksUpdated",value:function(e){var t=this;n.logger.log("subtitle tracks updated"),this.tracksBuffered=[],this.tracks=e.subtitleTracks,this.tracks.forEach(function(e){t.tracksBuffered[e.id]=[]})}},{key:"onSubtitleTrackSwitch",value:function(e){if(this.currentTrackId=e.id,this.tracks&&-1!==this.currentTrackId){var t=this.tracks[this.currentTrackId];t&&t.details&&this.setInterval(500)}else this.clearInterval()}},{key:"onSubtitleTrackLoaded",value:function(e){var t=e.id,r=e.details,i=this.currentTrackId,a=this.tracks,n=a[i];t>=a.length||t!==i||!n||(r.live&&(0,c.mergeSubtitlePlaylists)(n.details,r,this.lastAVStart),n.details=r,this.setInterval(500))}},{key:"onKeyLoaded",value:function(){this.state===d.State.KEY_LOADING&&(this.state=d.State.IDLE)}},{key:"onFragLoaded",value:function(e){var t=this.fragCurrent,r=e.frag.decryptdata,i=e.frag,n=this.hls;if(this.state===d.State.FRAG_LOADING&&t&&"subtitle"===e.frag.type&&t.sn===e.frag.sn&&e.payload.byteLength>0&&r&&r.key&&"AES-128"===r.method){var o=v.now();this.decrypter.decrypt(e.payload,r.key.buffer,r.iv.buffer,function(e){var t=v.now();n.trigger(a.default.FRAG_DECRYPTED,{frag:i,payload:e,stats:{tstart:o,tdecrypt:t}})})}}},{key:"onLevelUpdated",value:function(e){var t=e.details.fragments;this.lastAVStart=t.length?t[0].start:0}},{key:"doTick",value:function(){if(this.media)switch(this.state){case d.State.IDLE:var e=this.config,t=this.currentTrackId,r=this.fragmentTracker,i=this.media,o=this.tracks;if(!o||!o[t]||!o[t].details)break;var f=e.maxBufferHole,c=e.maxFragLookUpTolerance,h=Math.min(e.maxBufferLength,e.maxMaxBufferLength),v=s.BufferHelper.bufferedInfo(this._getBuffered(),i.currentTime,f),g=v.end,p=v.len,y=o[t].details,m=y.fragments,b=m.length,E=m[b-1].start+m[b-1].duration;if(p>h)return;var _=void 0,T=this.fragPrevious;g<E?(T&&y.hasProgramDateTime&&(_=(0,l.findFragmentByPDT)(m,T.endProgramDateTime,c)),_||(_=(0,l.findFragmentByPTS)(T,m,g,c))):_=m[b-1],_&&_.encrypted?(n.logger.log("Loading key for "+_.sn),this.state=d.State.KEY_LOADING,this.hls.trigger(a.default.KEY_LOADING,{frag:_})):_&&r.getState(_)===u.FragmentState.NOT_LOADED&&(this.fragCurrent=_,this.state=d.State.FRAG_LOADING,this.hls.trigger(a.default.FRAG_LOADING,{frag:_}))}else this.state=d.State.IDLE}},{key:"stopLoad",value:function(){this.lastAVStart=0,function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"stopLoad",this).call(this)}},{key:"_getBuffered",value:function(){return this.tracksBuffered[this.currentTrackId]||[]}},{key:"onMediaSeeking",value:function(){this.fragPrevious=null}}]),t}()},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(3)),o=r(0),s=r(5);function l(e){return e&&e.__esModule?e:{default:e}}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHED,a.default.MEDIA_DETACHING,a.default.MANIFEST_LOADED,a.default.SUBTITLE_TRACK_LOADED));return r.tracks=[],r.trackId=-1,r.media=null,r.stopped=!0,r.subtitleDisplay=!0,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){n.default.prototype.destroy.call(this)}},{key:"onMediaAttached",value:function(e){var t=this;this.media=e.media,this.media&&(this.queuedDefaultTrack&&(this.subtitleTrack=this.queuedDefaultTrack,delete this.queuedDefaultTrack),this.trackChangeListener=this._onTextTracksChanged.bind(this),this.useTextTrackPolling=!(this.media.textTracks&&"onchange"in this.media.textTracks),this.useTextTrackPolling?this.subtitlePollingInterval=setInterval(function(){t.trackChangeListener()},500):this.media.textTracks.addEventListener("change",this.trackChangeListener))}},{key:"onMediaDetaching",value:function(){this.media&&(this.useTextTrackPolling?clearInterval(this.subtitlePollingInterval):this.media.textTracks.removeEventListener("change",this.trackChangeListener),this.media=null)}},{key:"onManifestLoaded",value:function(e){var t=this,r=e.subtitles||[];this.tracks=r,this.hls.trigger(a.default.SUBTITLE_TRACKS_UPDATED,{subtitleTracks:r}),r.forEach(function(e){e.default&&(t.media?t.subtitleTrack=e.id:t.queuedDefaultTrack=e.id)})}},{key:"onSubtitleTrackLoaded",value:function(e){var t=this,r=e.id,i=e.details,a=this.trackId,n=this.tracks,l=n[a];if(r>=n.length||r!==a||!l||this.stopped)this._clearReloadTimer();else if(o.logger.log("subtitle track "+r+" loaded"),i.live){var u=(0,s.computeReloadInterval)(l.details,i,e.stats.trequest);o.logger.log("Reloading live subtitle playlist in "+u+"ms"),this.timer=setTimeout(function(){t._loadCurrentTrack()},u)}else this._clearReloadTimer()}},{key:"startLoad",value:function(){this.stopped=!1,this._loadCurrentTrack()}},{key:"stopLoad",value:function(){this.stopped=!0,this._clearReloadTimer()}},{key:"_clearReloadTimer",value:function(){this.timer&&(clearTimeout(this.timer),this.timer=null)}},{key:"_loadCurrentTrack",value:function(){var e=this.trackId,t=this.tracks,r=this.hls,i=t[e];e<0||!i||i.details&&!i.details.live||(o.logger.log("Loading subtitle track "+e),r.trigger(a.default.SUBTITLE_TRACK_LOADING,{url:i.url,id:e}))}},{key:"_toggleTrackModes",value:function(e){var t=this.media,r=this.subtitleDisplay,i=this.trackId;if(t){var a=d(t.textTracks);if(-1===e)[].slice.call(a).forEach(function(e){e.mode="disabled"});else{var n=a[i];n&&(n.mode="disabled")}var o=a[e];o&&(o.mode=r?"showing":"hidden")}}},{key:"_setSubtitleTrackInternal",value:function(e){var t=this.hls,r=this.tracks;!Number.isFinite(e)||e<-1||e>=r.length||(this.trackId=e,o.logger.log("Switching to subtitle track "+e),t.trigger(a.default.SUBTITLE_TRACK_SWITCH,{id:e}),this._loadCurrentTrack())}},{key:"_onTextTracksChanged",value:function(){if(this.media){for(var e=-1,t=d(this.media.textTracks),r=0;r<t.length;r++)if("hidden"===t[r].mode)e=r;else if("showing"===t[r].mode){e=r;break}this.subtitleTrack=e}}},{key:"subtitleTracks",get:function(){return this.tracks}},{key:"subtitleTrack",get:function(){return this.trackId},set:function(e){this.trackId!==e&&(this._toggleTrackModes(e),this._setSubtitleTrackInternal(e))}}]),t}();function d(e){for(var t=[],r=0;r<e.length;r++){var i=e[r];"subtitles"===i.kind&&i.label&&t.push(e[r])}return t}t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(e){return e&&e.__esModule?e:{default:e}}(r(15)),a=r(8);var n=function(e,t,r){return e.substr(r||0,t.length)===t},o=function(e){for(var t=5381,r=e.length;r;)t=33*t^e.charCodeAt(--r);return(t>>>0).toString()},s={parse:function(e,t,r,s,l,u){var d=(0,a.utf8ArrayToStr)(new Uint8Array(e)).trim().replace(/\r\n|\n\r|\n|\r/g,"\n").split("\n"),f="00:00.000",c=0,h=0,v=0,g=[],p=void 0,y=!0,m=new i.default;m.oncue=function(e){var t=r[s],i=r.ccOffset;t&&t.new&&(void 0!==h?i=r.ccOffset=t.start:function(e,t,r){var i=e[t],a=e[i.prevCC];if(!a||!a.new&&i.new)return e.ccOffset=e.presentationOffset=i.start,void(i.new=!1);for(;a&&a.new;)e.ccOffset+=i.start-a.start,i.new=!1,a=e[(i=a).prevCC];e.presentationOffset=r}(r,s,v)),v&&(i=v-r.presentationOffset),e.startTime+=i-h,e.endTime+=i-h,e.id=o(e.startTime.toString())+o(e.endTime.toString())+o(e.text),e.text=decodeURIComponent(encodeURIComponent(e.text)),e.endTime>0&&g.push(e)},m.onparsingerror=function(e){p=e},m.onflush=function(){p&&u?u(p):l(g)},d.forEach(function(e){if(y){if(n(e,"X-TIMESTAMP-MAP=")){y=!1,e.substr(16).split(",").forEach(function(e){n(e,"LOCAL:")?f=e.substr(6):n(e,"MPEGTS:")&&(c=parseInt(e.substr(7)))});try{t+(9e4*r[s].start||0)<0&&(t+=8589934592),c-=t,h=function(e){var t=parseInt(e.substr(-3)),r=parseInt(e.substr(-6,2)),i=parseInt(e.substr(-9,2)),a=e.length>9?parseInt(e.substr(0,e.indexOf(":"))):0;return Number.isFinite(t)&&Number.isFinite(r)&&Number.isFinite(i)&&Number.isFinite(a)?(t+=1e3*r,t+=6e4*i,t+=36e5*a):-1}(f)/1e3,v=c/9e4,-1===h&&(p=new Error("Malformed X-TIMESTAMP-MAP: "+e))}catch(t){p=new Error("Malformed X-TIMESTAMP-MAP: "+e)}return}""===e&&(y=!1)}m.parse(e+"\n")}),m.flush()}};t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(t,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.timelineController=t,this.trackName=r,this.startTime=null,this.endTime=null,this.screen=null}return i(e,[{key:"dispatchCue",value:function(){null!==this.startTime&&(this.timelineController.addCues(this.trackName,this.startTime,this.endTime,this.screen),this.startTime=null)}},{key:"newCue",value:function(e,t,r){(null===this.startTime||this.startTime>e)&&(this.startTime=e),this.endTime=t,this.screen=r,this.timelineController.createCaptionsTrack(this.trackName)}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var n={42:225,92:233,94:237,95:243,96:250,123:231,124:247,125:209,126:241,127:9608,128:174,129:176,130:189,131:191,132:8482,133:162,134:163,135:9834,136:224,137:32,138:232,139:226,140:234,141:238,142:244,143:251,144:193,145:201,146:211,147:218,148:220,149:252,150:8216,151:161,152:42,153:8217,154:9473,155:169,156:8480,157:8226,158:8220,159:8221,160:192,161:194,162:199,163:200,164:202,165:203,166:235,167:206,168:207,169:239,170:212,171:217,172:249,173:219,174:171,175:187,176:195,177:227,178:205,179:204,180:236,181:210,182:242,183:213,184:245,185:123,186:125,187:92,188:94,189:95,190:124,191:8764,192:196,193:228,194:214,195:246,196:223,197:165,198:164,199:9475,200:197,201:229,202:216,203:248,204:9487,205:9491,206:9495,207:9499},o=function(e){var t=e;return n.hasOwnProperty(e)&&(t=n[e]),String.fromCharCode(t)},s=15,l=100,u={17:1,18:3,21:5,22:7,23:9,16:11,19:12,20:14},d={17:2,18:4,21:6,22:8,23:10,19:13,20:15},f={25:1,26:3,29:5,30:7,31:9,24:11,27:12,28:14},c={25:2,26:4,29:6,30:8,31:10,27:13,28:15},h=["white","green","blue","cyan","red","yellow","magenta","black","transparent"],v={verboseFilter:{DATA:3,DEBUG:3,INFO:2,WARNING:2,TEXT:1,ERROR:0},time:null,verboseLevel:0,setTime:function(e){this.time=e},log:function(e,t){this.verboseFilter[e];this.verboseLevel}},g=function(e){for(var t=[],r=0;r<e.length;r++)t.push(e[r].toString(16));return t},p=function(){function e(t,r,i,n,o){a(this,e),this.foreground=t||"white",this.underline=r||!1,this.italics=i||!1,this.background=n||"black",this.flash=o||!1}return i(e,[{key:"reset",value:function(){this.foreground="white",this.underline=!1,this.italics=!1,this.background="black",this.flash=!1}},{key:"setStyles",value:function(e){for(var t=["foreground","underline","italics","background","flash"],r=0;r<t.length;r++){var i=t[r];e.hasOwnProperty(i)&&(this[i]=e[i])}}},{key:"isDefault",value:function(){return"white"===this.foreground&&!this.underline&&!this.italics&&"black"===this.background&&!this.flash}},{key:"equals",value:function(e){return this.foreground===e.foreground&&this.underline===e.underline&&this.italics===e.italics&&this.background===e.background&&this.flash===e.flash}},{key:"copy",value:function(e){this.foreground=e.foreground,this.underline=e.underline,this.italics=e.italics,this.background=e.background,this.flash=e.flash}},{key:"toString",value:function(){return"color="+this.foreground+", underline="+this.underline+", italics="+this.italics+", background="+this.background+", flash="+this.flash}}]),e}(),y=function(){function e(t,r,i,n,o,s){a(this,e),this.uchar=t||" ",this.penState=new p(r,i,n,o,s)}return i(e,[{key:"reset",value:function(){this.uchar=" ",this.penState.reset()}},{key:"setChar",value:function(e,t){this.uchar=e,this.penState.copy(t)}},{key:"setPenState",value:function(e){this.penState.copy(e)}},{key:"equals",value:function(e){return this.uchar===e.uchar&&this.penState.equals(e.penState)}},{key:"copy",value:function(e){this.uchar=e.uchar,this.penState.copy(e.penState)}},{key:"isEmpty",value:function(){return" "===this.uchar&&this.penState.isDefault()}}]),e}(),m=function(){function e(){a(this,e),this.chars=[];for(var t=0;t<l;t++)this.chars.push(new y);this.pos=0,this.currPenState=new p}return i(e,[{key:"equals",value:function(e){for(var t=!0,r=0;r<l;r++)if(!this.chars[r].equals(e.chars[r])){t=!1;break}return t}},{key:"copy",value:function(e){for(var t=0;t<l;t++)this.chars[t].copy(e.chars[t])}},{key:"isEmpty",value:function(){for(var e=!0,t=0;t<l;t++)if(!this.chars[t].isEmpty()){e=!1;break}return e}},{key:"setCursor",value:function(e){this.pos!==e&&(this.pos=e),this.pos<0?(v.log("ERROR","Negative cursor position "+this.pos),this.pos=0):this.pos>l&&(v.log("ERROR","Too large cursor position "+this.pos),this.pos=l)}},{key:"moveCursor",value:function(e){var t=this.pos+e;if(e>1)for(var r=this.pos+1;r<t+1;r++)this.chars[r].setPenState(this.currPenState);this.setCursor(t)}},{key:"backSpace",value:function(){this.moveCursor(-1),this.chars[this.pos].setChar(" ",this.currPenState)}},{key:"insertChar",value:function(e){e>=144&&this.backSpace();var t=o(e);this.pos>=l?v.log("ERROR","Cannot insert "+e.toString(16)+" ("+t+") at position "+this.pos+". Skipping it!"):(this.chars[this.pos].setChar(t,this.currPenState),this.moveCursor(1))}},{key:"clearFromPos",value:function(e){var t=void 0;for(t=e;t<l;t++)this.chars[t].reset()}},{key:"clear",value:function(){this.clearFromPos(0),this.pos=0,this.currPenState.reset()}},{key:"clearToEndOfRow",value:function(){this.clearFromPos(this.pos)}},{key:"getTextString",value:function(){for(var e=[],t=!0,r=0;r<l;r++){var i=this.chars[r].uchar;" "!==i&&(t=!1),e.push(i)}return t?"":e.join("")}},{key:"setPenStyles",value:function(e){this.currPenState.setStyles(e),this.chars[this.pos].setPenState(this.currPenState)}}]),e}(),b=function(){function e(){a(this,e),this.rows=[];for(var t=0;t<s;t++)this.rows.push(new m);this.currRow=s-1,this.nrRollUpRows=null,this.reset()}return i(e,[{key:"reset",value:function(){for(var e=0;e<s;e++)this.rows[e].clear();this.currRow=s-1}},{key:"equals",value:function(e){for(var t=!0,r=0;r<s;r++)if(!this.rows[r].equals(e.rows[r])){t=!1;break}return t}},{key:"copy",value:function(e){for(var t=0;t<s;t++)this.rows[t].copy(e.rows[t])}},{key:"isEmpty",value:function(){for(var e=!0,t=0;t<s;t++)if(!this.rows[t].isEmpty()){e=!1;break}return e}},{key:"backSpace",value:function(){this.rows[this.currRow].backSpace()}},{key:"clearToEndOfRow",value:function(){this.rows[this.currRow].clearToEndOfRow()}},{key:"insertChar",value:function(e){this.rows[this.currRow].insertChar(e)}},{key:"setPen",value:function(e){this.rows[this.currRow].setPenStyles(e)}},{key:"moveCursor",value:function(e){this.rows[this.currRow].moveCursor(e)}},{key:"setCursor",value:function(e){v.log("INFO","setCursor: "+e),this.rows[this.currRow].setCursor(e)}},{key:"setPAC",value:function(e){v.log("INFO","pacData = "+JSON.stringify(e));var t=e.row-1;if(this.nrRollUpRows&&t<this.nrRollUpRows-1&&(t=this.nrRollUpRows-1),this.nrRollUpRows&&this.currRow!==t){for(var r=0;r<s;r++)this.rows[r].clear();var i=this.currRow+1-this.nrRollUpRows,a=this.lastOutputScreen;if(a){var n=a.rows[i].cueStartTime;if(n&&n<v.time)for(var o=0;o<this.nrRollUpRows;o++)this.rows[t-this.nrRollUpRows+o+1].copy(a.rows[i+o])}}this.currRow=t;var l=this.rows[this.currRow];if(null!==e.indent){var u=e.indent,d=Math.max(u-1,0);l.setCursor(e.indent),e.color=l.chars[d].penState.foreground}var f={foreground:e.color,underline:e.underline,italics:e.italics,background:"black",flash:!1};this.setPen(f)}},{key:"setBkgData",value:function(e){v.log("INFO","bkgData = "+JSON.stringify(e)),this.backSpace(),this.setPen(e),this.insertChar(32)}},{key:"setRollUpRows",value:function(e){this.nrRollUpRows=e}},{key:"rollUp",value:function(){if(null!==this.nrRollUpRows){v.log("TEXT",this.getDisplayText());var e=this.currRow+1-this.nrRollUpRows,t=this.rows.splice(e,1)[0];t.clear(),this.rows.splice(this.currRow,0,t),v.log("INFO","Rolling up")}else v.log("DEBUG","roll_up but nrRollUpRows not set yet")}},{key:"getDisplayText",value:function(e){e=e||!1;for(var t=[],r="",i=-1,a=0;a<s;a++){var n=this.rows[a].getTextString();n&&(i=a+1,e?t.push("Row "+i+": '"+n+"'"):t.push(n.trim()))}return t.length>0&&(r=e?"["+t.join(" | ")+"]":t.join("\n")),r}},{key:"getTextAndFormat",value:function(){return this.rows}}]),e}(),E=function(){function e(t,r){a(this,e),this.chNr=t,this.outputFilter=r,this.mode=null,this.verbose=0,this.displayedMemory=new b,this.nonDisplayedMemory=new b,this.lastOutputScreen=new b,this.currRollUpRow=this.displayedMemory.rows[s-1],this.writeScreen=this.displayedMemory,this.mode=null,this.cueStartTime=null}return i(e,[{key:"reset",value:function(){this.mode=null,this.displayedMemory.reset(),this.nonDisplayedMemory.reset(),this.lastOutputScreen.reset(),this.currRollUpRow=this.displayedMemory.rows[s-1],this.writeScreen=this.displayedMemory,this.mode=null,this.cueStartTime=null,this.lastCueEndTime=null}},{key:"getHandler",value:function(){return this.outputFilter}},{key:"setHandler",value:function(e){this.outputFilter=e}},{key:"setPAC",value:function(e){this.writeScreen.setPAC(e)}},{key:"setBkgData",value:function(e){this.writeScreen.setBkgData(e)}},{key:"setMode",value:function(e){e!==this.mode&&(this.mode=e,v.log("INFO","MODE="+e),"MODE_POP-ON"===this.mode?this.writeScreen=this.nonDisplayedMemory:(this.writeScreen=this.displayedMemory,this.writeScreen.reset()),"MODE_ROLL-UP"!==this.mode&&(this.displayedMemory.nrRollUpRows=null,this.nonDisplayedMemory.nrRollUpRows=null),this.mode=e)}},{key:"insertChars",value:function(e){for(var t=0;t<e.length;t++)this.writeScreen.insertChar(e[t]);var r=this.writeScreen===this.displayedMemory?"DISP":"NON_DISP";v.log("INFO",r+": "+this.writeScreen.getDisplayText(!0)),"MODE_PAINT-ON"!==this.mode&&"MODE_ROLL-UP"!==this.mode||(v.log("TEXT","DISPLAYED: "+this.displayedMemory.getDisplayText(!0)),this.outputDataUpdate())}},{key:"ccRCL",value:function(){v.log("INFO","RCL - Resume Caption Loading"),this.setMode("MODE_POP-ON")}},{key:"ccBS",value:function(){v.log("INFO","BS - BackSpace"),"MODE_TEXT"!==this.mode&&(this.writeScreen.backSpace(),this.writeScreen===this.displayedMemory&&this.outputDataUpdate())}},{key:"ccAOF",value:function(){}},{key:"ccAON",value:function(){}},{key:"ccDER",value:function(){v.log("INFO","DER- Delete to End of Row"),this.writeScreen.clearToEndOfRow(),this.outputDataUpdate()}},{key:"ccRU",value:function(e){v.log("INFO","RU("+e+") - Roll Up"),this.writeScreen=this.displayedMemory,this.setMode("MODE_ROLL-UP"),this.writeScreen.setRollUpRows(e)}},{key:"ccFON",value:function(){v.log("INFO","FON - Flash On"),this.writeScreen.setPen({flash:!0})}},{key:"ccRDC",value:function(){v.log("INFO","RDC - Resume Direct Captioning"),this.setMode("MODE_PAINT-ON")}},{key:"ccTR",value:function(){v.log("INFO","TR"),this.setMode("MODE_TEXT")}},{key:"ccRTD",value:function(){v.log("INFO","RTD"),this.setMode("MODE_TEXT")}},{key:"ccEDM",value:function(){v.log("INFO","EDM - Erase Displayed Memory"),this.displayedMemory.reset(),this.outputDataUpdate(!0)}},{key:"ccCR",value:function(){v.log("CR - Carriage Return"),this.writeScreen.rollUp(),this.outputDataUpdate(!0)}},{key:"ccENM",value:function(){v.log("INFO","ENM - Erase Non-displayed Memory"),this.nonDisplayedMemory.reset()}},{key:"ccEOC",value:function(){if(v.log("INFO","EOC - End Of Caption"),"MODE_POP-ON"===this.mode){var e=this.displayedMemory;this.displayedMemory=this.nonDisplayedMemory,this.nonDisplayedMemory=e,this.writeScreen=this.nonDisplayedMemory,v.log("TEXT","DISP: "+this.displayedMemory.getDisplayText())}this.outputDataUpdate(!0)}},{key:"ccTO",value:function(e){v.log("INFO","TO("+e+") - Tab Offset"),this.writeScreen.moveCursor(e)}},{key:"ccMIDROW",value:function(e){var t={flash:!1};if(t.underline=e%2==1,t.italics=e>=46,t.italics)t.foreground="white";else{var r=Math.floor(e/2)-16;t.foreground=["white","green","blue","cyan","red","yellow","magenta"][r]}v.log("INFO","MIDROW: "+JSON.stringify(t)),this.writeScreen.setPen(t)}},{key:"outputDataUpdate",value:function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=v.time;null!==t&&this.outputFilter&&(null!==this.cueStartTime||this.displayedMemory.isEmpty()?this.displayedMemory.equals(this.lastOutputScreen)||(this.outputFilter.newCue&&(this.outputFilter.newCue(this.cueStartTime,t,this.lastOutputScreen),!0===e&&this.outputFilter.dispatchCue&&this.outputFilter.dispatchCue()),this.cueStartTime=this.displayedMemory.isEmpty()?null:t):this.cueStartTime=t,this.lastOutputScreen.copy(this.displayedMemory))}},{key:"cueSplitAtTime",value:function(e){this.outputFilter&&(this.displayedMemory.isEmpty()||(this.outputFilter.newCue&&this.outputFilter.newCue(this.cueStartTime,e,this.displayedMemory),this.cueStartTime=e))}}]),e}(),_=function(){function e(t,r,i){a(this,e),this.field=t||1,this.outputs=[r,i],this.channels=[new E(1,r),new E(2,i)],this.currChNr=-1,this.lastCmdA=null,this.lastCmdB=null,this.bufferedData=[],this.startTime=null,this.lastTime=null,this.dataCounters={padding:0,char:0,cmd:0,other:0}}return i(e,[{key:"getHandler",value:function(e){return this.channels[e].getHandler()}},{key:"setHandler",value:function(e,t){this.channels[e].setHandler(t)}},{key:"addData",value:function(e,t){var r=void 0,i=void 0,a=void 0,n=!1;this.lastTime=e,v.setTime(e);for(var o=0;o<t.length;o+=2)if(i=127&t[o],a=127&t[o+1],0!==i||0!==a){if(v.log("DATA","["+g([t[o],t[o+1]])+"] -> ("+g([i,a])+")"),(r=this.parseCmd(i,a))||(r=this.parseMidrow(i,a)),r||(r=this.parsePAC(i,a)),r||(r=this.parseBackgroundAttributes(i,a)),!r)if(n=this.parseChars(i,a))if(this.currChNr&&this.currChNr>=0)this.channels[this.currChNr-1].insertChars(n);else v.log("WARNING","No channel found yet. TEXT-MODE?");r?this.dataCounters.cmd+=2:n?this.dataCounters.char+=2:(this.dataCounters.other+=2,v.log("WARNING","Couldn't parse cleaned data "+g([i,a])+" orig: "+g([t[o],t[o+1]])))}else this.dataCounters.padding+=2}},{key:"parseCmd",value:function(e,t){var r=null;if(!((20===e||28===e)&&t>=32&&t<=47)&&!((23===e||31===e)&&t>=33&&t<=35))return!1;if(e===this.lastCmdA&&t===this.lastCmdB)return this.lastCmdA=null,this.lastCmdB=null,v.log("DEBUG","Repeated command ("+g([e,t])+") is dropped"),!0;r=20===e||23===e?1:2;var i=this.channels[r-1];return 20===e||28===e?32===t?i.ccRCL():33===t?i.ccBS():34===t?i.ccAOF():35===t?i.ccAON():36===t?i.ccDER():37===t?i.ccRU(2):38===t?i.ccRU(3):39===t?i.ccRU(4):40===t?i.ccFON():41===t?i.ccRDC():42===t?i.ccTR():43===t?i.ccRTD():44===t?i.ccEDM():45===t?i.ccCR():46===t?i.ccENM():47===t&&i.ccEOC():i.ccTO(t-32),this.lastCmdA=e,this.lastCmdB=t,this.currChNr=r,!0}},{key:"parseMidrow",value:function(e,t){var r=null;return(17===e||25===e)&&t>=32&&t<=47&&((r=17===e?1:2)!==this.currChNr?(v.log("ERROR","Mismatch channel in midrow parsing"),!1):(this.channels[r-1].ccMIDROW(t),v.log("DEBUG","MIDROW ("+g([e,t])+")"),!0))}},{key:"parsePAC",value:function(e,t){var r,i=null;if(!((e>=17&&e<=23||e>=25&&e<=31)&&t>=64&&t<=127)&&!((16===e||24===e)&&t>=64&&t<=95))return!1;if(e===this.lastCmdA&&t===this.lastCmdB)return this.lastCmdA=null,this.lastCmdB=null,!0;r=e<=23?1:2,i=t>=64&&t<=95?1===r?u[e]:f[e]:1===r?d[e]:c[e];var a=this.interpretPAC(i,t);return this.channels[r-1].setPAC(a),this.lastCmdA=e,this.lastCmdB=t,this.currChNr=r,!0}},{key:"interpretPAC",value:function(e,t){var r=t,i={color:null,italics:!1,indent:null,underline:!1,row:e};return r=t>95?t-96:t-64,i.underline=1==(1&r),r<=13?i.color=["white","green","blue","cyan","red","yellow","magenta","white"][Math.floor(r/2)]:r<=15?(i.italics=!0,i.color="white"):i.indent=4*Math.floor((r-16)/2),i}},{key:"parseChars",value:function(e,t){var r=null,i=null,a=null;if(e>=25?(r=2,a=e-8):(r=1,a=e),a>=17&&a<=19){var n=t;n=17===a?t+80:18===a?t+112:t+144,v.log("INFO","Special char '"+o(n)+"' in channel "+r),i=[n]}else e>=32&&e<=127&&(i=0===t?[e]:[e,t]);if(i){var s=g(i);v.log("DEBUG","Char codes =  "+s.join(",")),this.lastCmdA=null,this.lastCmdB=null}return i}},{key:"parseBackgroundAttributes",value:function(e,t){var r,i=void 0,a=void 0;return((16===e||24===e)&&t>=32&&t<=47||(23===e||31===e)&&t>=45&&t<=47)&&(i={},16===e||24===e?(a=Math.floor((t-32)/2),i.background=h[a],t%2==1&&(i.background=i.background+"_semi")):45===t?i.background="transparent":(i.foreground="black",47===t&&(i.underline=!0)),r=e<24?1:2,this.channels[r-1].setBkgData(i),this.lastCmdA=null,this.lastCmdB=null,!0)}},{key:"reset",value:function(){for(var e=0;e<this.channels.length;e++)this.channels[e]&&this.channels[e].reset();this.lastCmdA=null,this.lastCmdB=null}},{key:"cueSplitAtTime",value:function(e){for(var t=0;t<this.channels.length;t++)this.channels[t]&&this.channels[t].cueSplitAtTime(e)}}]),e}();t.default=_,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=f(r(1)),n=f(r(3)),o=f(r(38)),s=f(r(37)),l=f(r(36)),u=r(0),d=r(16);function f(e){return e&&e.__esModule?e:{default:e}}function c(e,t){return e&&e.label===t.name&&!(e.textTrack1||e.textTrack2)}function h(e,t,r,i){return Math.min(t,i)-Math.max(e,r)}var v=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHING,a.default.MEDIA_DETACHING,a.default.FRAG_PARSING_USERDATA,a.default.FRAG_DECRYPTED,a.default.MANIFEST_LOADING,a.default.MANIFEST_LOADED,a.default.FRAG_LOADED,a.default.LEVEL_SWITCHING,a.default.INIT_PTS_FOUND));if(r.hls=e,r.config=e.config,r.enabled=!0,r.Cues=e.config.cueHandler,r.textTracks=[],r.tracks=[],r.unparsedVttFrags=[],r.initPTS=[],r.cueRanges=[],r.captionsTracks={},r.captionsProperties={textTrack1:{label:r.config.captionsTextTrack1Label,languageCode:r.config.captionsTextTrack1LanguageCode},textTrack2:{label:r.config.captionsTextTrack2Label,languageCode:r.config.captionsTextTrack2LanguageCode}},r.config.enableCEA708Captions){var i=new s.default(r,"textTrack1"),n=new s.default(r,"textTrack2");r.cea608Parser=new o.default(0,i,n)}return r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"addCues",value:function(e,t,r,i){for(var a=this.cueRanges,n=!1,o=a.length;o--;){var s=a[o],l=h(s[0],s[1],t,r);if(l>=0&&(s[0]=Math.min(s[0],t),s[1]=Math.max(s[1],r),n=!0,l/(r-t)>.5))return}n||a.push([t,r]),this.Cues.newCue(this.captionsTracks[e],t,r,i)}},{key:"onInitPtsFound",value:function(e){var t=this;if("main"===e.id&&(this.initPTS[e.frag.cc]=e.initPTS),this.unparsedVttFrags.length){var r=this.unparsedVttFrags;this.unparsedVttFrags=[],r.forEach(function(e){t.onFragLoaded(e)})}}},{key:"getExistingTrack",value:function(e){var t=this.media;if(t)for(var r=0;r<t.textTracks.length;r++){var i=t.textTracks[r];if(i[e])return i}return null}},{key:"createCaptionsTrack",value:function(e){var t=this.captionsProperties[e],r=t.label,i=t.languageCode,a=this.captionsTracks;if(!a[e]){var n=this.getExistingTrack(e);if(n)a[e]=n,(0,d.clearCurrentCues)(a[e]),(0,d.sendAddTrackEvent)(a[e],this.media);else{var o=this.createTextTrack("captions",r,i);o&&(o[e]=!0,a[e]=o)}}}},{key:"createTextTrack",value:function(e,t,r){var i=this.media;if(i)return i.addTextTrack(e,t,r)}},{key:"destroy",value:function(){n.default.prototype.destroy.call(this)}},{key:"onMediaAttaching",value:function(e){this.media=e.media,this._cleanTracks()}},{key:"onMediaDetaching",value:function(){var e=this.captionsTracks;Object.keys(e).forEach(function(t){(0,d.clearCurrentCues)(e[t]),delete e[t]})}},{key:"onManifestLoading",value:function(){this.lastSn=-1,this.prevCC=-1,this.vttCCs={ccOffset:0,presentationOffset:0,0:{start:0,prevCC:-1,new:!1}},this._cleanTracks()}},{key:"_cleanTracks",value:function(){var e=this.media;if(e){var t=e.textTracks;if(t)for(var r=0;r<t.length;r++)(0,d.clearCurrentCues)(t[r])}}},{key:"onManifestLoaded",value:function(e){var t=this;if(this.textTracks=[],this.unparsedVttFrags=this.unparsedVttFrags||[],this.initPTS=[],this.cueRanges=[],this.config.enableWebVTT){this.tracks=e.subtitles||[];var r=this.media?this.media.textTracks:[];this.tracks.forEach(function(e,i){var a=void 0;if(i<r.length){for(var n=null,o=0;o<r.length;o++)if(c(r[o],e)){n=r[o];break}n&&(a=n)}a||(a=t.createTextTrack("subtitles",e.name,e.lang)),e.default?a.mode=t.hls.subtitleDisplay?"showing":"hidden":a.mode="disabled",t.textTracks.push(a)})}}},{key:"onLevelSwitching",value:function(){this.enabled="NONE"!==this.hls.currentLevel.closedCaptions}},{key:"onFragLoaded",value:function(e){var t=e.frag,r=e.payload;if("main"===t.type){var i=t.sn;if(i!==this.lastSn+1){var n=this.cea608Parser;n&&n.reset()}this.lastSn=i}else if("subtitle"===t.type)if(r.byteLength){if(!Number.isFinite(this.initPTS[t.cc]))return this.unparsedVttFrags.push(e),void(this.initPTS.length&&this.hls.trigger(a.default.SUBTITLE_FRAG_PROCESSED,{success:!1,frag:t}));var o=t.decryptdata;null!=o&&null!=o.key&&"AES-128"===o.method||this._parseVTTs(t,r)}else this.hls.trigger(a.default.SUBTITLE_FRAG_PROCESSED,{success:!1,frag:t})}},{key:"_parseVTTs",value:function(e,t){var r=this.vttCCs;r[e.cc]||(r[e.cc]={start:e.start,prevCC:this.prevCC,new:!0},this.prevCC=e.cc);var i=this.textTracks,n=this.hls;l.default.parse(t,this.initPTS[e.cc],r,e.cc,function(t){var r=i[e.level];"disabled"!==r.mode?(t.forEach(function(e){if(!r.cues.getCueById(e.id))try{r.addCue(e)}catch(i){var t=new window.TextTrackCue(e.startTime,e.endTime,e.text);t.id=e.id,r.addCue(t)}}),n.trigger(a.default.SUBTITLE_FRAG_PROCESSED,{success:!0,frag:e})):n.trigger(a.default.SUBTITLE_FRAG_PROCESSED,{success:!1,frag:e})},function(t){u.logger.log("Failed to parse VTT cue: "+t),n.trigger(a.default.SUBTITLE_FRAG_PROCESSED,{success:!1,frag:e})})}},{key:"onFragDecrypted",value:function(e){var t=e.payload,r=e.frag;if("subtitle"===r.type){if(!Number.isFinite(this.initPTS[r.cc]))return void this.unparsedVttFrags.push(e);this._parseVTTs(r,t)}}},{key:"onFragParsingUserdata",value:function(e){if(this.enabled&&this.config.enableCEA708Captions)for(var t=0;t<e.samples.length;t++){var r=this.extractCea608Data(e.samples[t].bytes);this.cea608Parser.addData(e.samples[t].pts,r)}}},{key:"extractCea608Data",value:function(e){for(var t=31&e[0],r=2,i=void 0,a=void 0,n=void 0,o=[],s=0;s<t;s++)i=e[r++],a=127&e[r++],n=127&e[r++],0===a&&0===n||0!=(4&i)&&0===(3&i)&&(o.push(a),o.push(n));return o}}]),t}();t.default=v,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(){if("undefined"!=typeof window&&window.VTTCue)return window.VTTCue;var e="auto",t={"":!0,lr:!0,rl:!0},r={start:!0,middle:!0,end:!0,left:!0,right:!0};function i(e){return"string"==typeof e&&(!!r[e.toLowerCase()]&&e.toLowerCase())}function a(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var i in r)e[i]=r[i]}return e}function n(r,n,o){var s=this,l=function(){if("undefined"!=typeof navigator)return/MSIE\s8\.0/.test(navigator.userAgent)}(),u={};l?s=document.createElement("custom"):u.enumerable=!0,s.hasBeenReset=!1;var d="",f=!1,c=r,h=n,v=o,g=null,p="",y=!0,m="auto",b="start",E=50,_="middle",T=50,S="middle";if(Object.defineProperty(s,"id",a({},u,{get:function(){return d},set:function(e){d=""+e}})),Object.defineProperty(s,"pauseOnExit",a({},u,{get:function(){return f},set:function(e){f=!!e}})),Object.defineProperty(s,"startTime",a({},u,{get:function(){return c},set:function(e){if("number"!=typeof e)throw new TypeError("Start time must be set to a number.");c=e,this.hasBeenReset=!0}})),Object.defineProperty(s,"endTime",a({},u,{get:function(){return h},set:function(e){if("number"!=typeof e)throw new TypeError("End time must be set to a number.");h=e,this.hasBeenReset=!0}})),Object.defineProperty(s,"text",a({},u,{get:function(){return v},set:function(e){v=""+e,this.hasBeenReset=!0}})),Object.defineProperty(s,"region",a({},u,{get:function(){return g},set:function(e){g=e,this.hasBeenReset=!0}})),Object.defineProperty(s,"vertical",a({},u,{get:function(){return p},set:function(e){var r=function(e){return"string"==typeof e&&!!t[e.toLowerCase()]&&e.toLowerCase()}(e);if(!1===r)throw new SyntaxError("An invalid or illegal string was specified.");p=r,this.hasBeenReset=!0}})),Object.defineProperty(s,"snapToLines",a({},u,{get:function(){return y},set:function(e){y=!!e,this.hasBeenReset=!0}})),Object.defineProperty(s,"line",a({},u,{get:function(){return m},set:function(t){if("number"!=typeof t&&t!==e)throw new SyntaxError("An invalid number or illegal string was specified.");m=t,this.hasBeenReset=!0}})),Object.defineProperty(s,"lineAlign",a({},u,{get:function(){return b},set:function(e){var t=i(e);if(!t)throw new SyntaxError("An invalid or illegal string was specified.");b=t,this.hasBeenReset=!0}})),Object.defineProperty(s,"position",a({},u,{get:function(){return E},set:function(e){if(e<0||e>100)throw new Error("Position must be between 0 and 100.");E=e,this.hasBeenReset=!0}})),Object.defineProperty(s,"positionAlign",a({},u,{get:function(){return _},set:function(e){var t=i(e);if(!t)throw new SyntaxError("An invalid or illegal string was specified.");_=t,this.hasBeenReset=!0}})),Object.defineProperty(s,"size",a({},u,{get:function(){return T},set:function(e){if(e<0||e>100)throw new Error("Size must be between 0 and 100.");T=e,this.hasBeenReset=!0}})),Object.defineProperty(s,"align",a({},u,{get:function(){return S},set:function(e){var t=i(e);if(!t)throw new SyntaxError("An invalid or illegal string was specified.");S=t,this.hasBeenReset=!0}})),s.displayState=void 0,l)return s}return n.prototype.getCueAsHTML=function(){return window.WebVTT.convertCueToDOMTree(window,this.text)},n}(),e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.newCue=function(e,t,r,a){for(var n=void 0,o=void 0,s=void 0,l=void 0,u=void 0,d=window.VTTCue||window.TextTrackCue,f=0;f<a.rows.length;f++)if(n=a.rows[f],s=!0,l=0,u="",!n.isEmpty()){for(var c=0;c<n.chars.length;c++)n.chars[c].uchar.match(/\s/)&&s?l++:(u+=n.chars[c].uchar,s=!1);n.cueStartTime=t,t===r&&(r+=1e-4),o=new d(t,r,(0,i.fixLineBreaks)(u.trim())),l>=16?l--:l++,navigator.userAgent.match(/Firefox\//)?o.line=f+1:o.line=f>7?f-2:f+1,o.align="left",o.position=Math.max(0,Math.min(100,l/32*100+(navigator.userAgent.match(/Firefox\//)?50:0))),e.addCue(o)}};var i=r(15)},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=y(r(9)),n=r(4),o=y(r(26)),s=y(r(1)),l=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(5)),u=y(r(20)),d=r(2),f=r(0),c=r(19),h=r(6),v=y(r(14)),g=r(11),p=y(g);function y(e){return e&&e.__esModule?e:{default:e}}var m=window.performance,b=function(e){function t(e,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var i=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,s.default.MEDIA_ATTACHED,s.default.MEDIA_DETACHING,s.default.AUDIO_TRACKS_UPDATED,s.default.AUDIO_TRACK_SWITCHING,s.default.AUDIO_TRACK_LOADED,s.default.KEY_LOADED,s.default.FRAG_LOADED,s.default.FRAG_PARSING_INIT_SEGMENT,s.default.FRAG_PARSING_DATA,s.default.FRAG_PARSED,s.default.ERROR,s.default.BUFFER_RESET,s.default.BUFFER_CREATED,s.default.BUFFER_APPENDED,s.default.BUFFER_FLUSHED,s.default.INIT_PTS_FOUND));return i.fragmentTracker=r,i.config=e.config,i.audioCodecSwap=!1,i._state=g.State.STOPPED,i.initPTS=[],i.waitingFragment=null,i.videoTrackCC=null,i}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,p.default),i(t,[{key:"onInitPtsFound",value:function(e){var t=e.id,r=e.frag.cc,i=e.initPTS;"main"===t&&(this.initPTS[r]=i,this.videoTrackCC=r,f.logger.log("InitPTS for cc: "+r+" found from video track: "+i),this.state===g.State.WAITING_INIT_PTS&&this.tick())}},{key:"startLoad",value:function(e){if(this.tracks){var t=this.lastCurrentTime;this.stopLoad(),this.setInterval(100),this.fragLoadError=0,t>0&&-1===e?(f.logger.log("audio:override startPosition with lastCurrentTime @"+t.toFixed(3)),this.state=g.State.IDLE):(this.lastCurrentTime=this.startPosition?this.startPosition:e,this.state=g.State.STARTING),this.nextLoadPosition=this.startPosition=this.lastCurrentTime,this.tick()}else this.startPosition=e,this.state=g.State.STOPPED}},{key:"doTick",value:function(){var e=void 0,t=void 0,r=void 0,i=this.hls,o=i.config;switch(this.state){case g.State.ERROR:case g.State.PAUSED:case g.State.BUFFER_FLUSHING:break;case g.State.STARTING:this.state=g.State.WAITING_TRACK,this.loadedmetadata=!1;break;case g.State.IDLE:var l=this.tracks;if(!l)break;if(!this.media&&(this.startFragRequested||!o.startFragPrefetch))break;if(this.loadedmetadata)e=this.media.currentTime;else if(void 0===(e=this.nextLoadPosition))break;var u=this.mediaBuffer?this.mediaBuffer:this.media,d=this.videoBuffer?this.videoBuffer:this.media,v=n.BufferHelper.bufferInfo(u,e,o.maxBufferHole),p=n.BufferHelper.bufferInfo(d,e,o.maxBufferHole),y=v.len,b=v.end,E=this.fragPrevious,_=Math.min(o.maxBufferLength,o.maxMaxBufferLength),T=Math.max(_,p.len),S=this.audioSwitch,k=this.trackId;if((y<T||S)&&k<l.length){if(void 0===(r=l[k].details)){this.state=g.State.WAITING_TRACK;break}if(!S&&this._streamEnded(v,r))return this.hls.trigger(s.default.BUFFER_EOS,{type:"audio"}),void(this.state=g.State.ENDED);var R=r.fragments,A=R.length,w=R[0].start,O=R[A-1].start+R[A-1].duration,L=void 0;if(S)if(r.live&&!r.PTSKnown)f.logger.log("switching audiotrack, live stream, unknown PTS,load first fragment"),b=0;else if(b=e,r.PTSKnown&&e<w){if(!(v.end>w||v.nextStart))return;f.logger.log("alt audio track ahead of main track, seek to start of alt audio track"),this.media.currentTime=w+.05}if(r.initSegment&&!r.initSegment.data)L=r.initSegment;else if(b<=w){if(L=R[0],null!==this.videoTrackCC&&L.cc!==this.videoTrackCC&&(L=(0,c.findFragWithCC)(R,this.videoTrackCC)),r.live&&L.loadIdx&&L.loadIdx===this.fragLoadIdx){var D=v.nextStart?v.nextStart:w;return f.logger.log("no alt audio available @currentTime:"+this.media.currentTime+", seeking @"+(D+.05)),void(this.media.currentTime=D+.05)}}else{var P=void 0,I=o.maxFragLookUpTolerance,C=E?R[E.sn-R[0].sn+1]:void 0,x=function(e){var t=Math.min(I,e.duration);return e.start+e.duration-t<=b?1:e.start-t>b&&e.start?-1:0};b<O?(b>O-I&&(I=0),P=C&&!x(C)?C:a.default.search(R,x)):P=R[A-1],P&&(L=P,w=P.start,E&&L.level===E.level&&L.sn===E.sn&&(L.sn<r.endSN?(L=R[L.sn+1-r.startSN],f.logger.log("SN just loaded, load next one: "+L.sn)):L=null))}L&&(L.encrypted?(f.logger.log("Loading key for "+L.sn+" of ["+r.startSN+" ,"+r.endSN+"],track "+k),this.state=g.State.KEY_LOADING,i.trigger(s.default.KEY_LOADING,{frag:L})):(f.logger.log("Loading "+L.sn+", cc: "+L.cc+" of ["+r.startSN+" ,"+r.endSN+"],track "+k+", currentTime:"+e+",bufferEnd:"+b.toFixed(3)),this.fragCurrent=L,(S||this.fragmentTracker.getState(L)===h.FragmentState.NOT_LOADED)&&(this.startFragRequested=!0,Number.isFinite(L.sn)&&(this.nextLoadPosition=L.start+L.duration),i.trigger(s.default.FRAG_LOADING,{frag:L}),this.state=g.State.FRAG_LOADING)))}break;case g.State.WAITING_TRACK:(t=this.tracks[this.trackId])&&t.details&&(this.state=g.State.IDLE);break;case g.State.FRAG_LOADING_WAITING_RETRY:var M=m.now(),F=this.retryDate,N=(u=this.media)&&u.seeking;(!F||M>=F||N)&&(f.logger.log("audioStreamController: retryDate reached, switch back to IDLE state"),this.state=g.State.IDLE);break;case g.State.WAITING_INIT_PTS:var U=this.videoTrackCC;if(void 0===this.initPTS[U])break;var B=this.waitingFragment;if(B){var G=B.frag.cc;U!==G?(t=this.tracks[this.trackId]).details&&t.details.live&&(f.logger.warn("Waiting fragment CC ("+G+") does not match video track CC ("+U+")"),this.waitingFragment=null,this.state=g.State.IDLE):(this.state=g.State.FRAG_LOADING,this.onFragLoaded(this.waitingFragment),this.waitingFragment=null)}else this.state=g.State.IDLE;break;case g.State.STOPPED:case g.State.FRAG_LOADING:case g.State.PARSING:case g.State.PARSED:case g.State.ENDED:}}},{key:"onMediaAttached",value:function(e){var t=this.media=this.mediaBuffer=e.media;this.onvseeking=this.onMediaSeeking.bind(this),this.onvended=this.onMediaEnded.bind(this),t.addEventListener("seeking",this.onvseeking),t.addEventListener("ended",this.onvended);var r=this.config;this.tracks&&r.autoStartLoad&&this.startLoad(r.startPosition)}},{key:"onMediaDetaching",value:function(){var e=this.media;e&&e.ended&&(f.logger.log("MSE detaching and video ended, reset startPosition"),this.startPosition=this.lastCurrentTime=0),e&&(e.removeEventListener("seeking",this.onvseeking),e.removeEventListener("ended",this.onvended),this.onvseeking=this.onvseeked=this.onvended=null),this.media=this.mediaBuffer=this.videoBuffer=null,this.loadedmetadata=!1,this.stopLoad()}},{key:"onAudioTracksUpdated",value:function(e){f.logger.log("audio tracks updated"),this.tracks=e.audioTracks}},{key:"onAudioTrackSwitching",value:function(e){var t=!!e.url;this.trackId=e.id,this.fragCurrent=null,this.state=g.State.PAUSED,this.waitingFragment=null,t?this.setInterval(100):this.demuxer&&(this.demuxer.destroy(),this.demuxer=null),t&&(this.audioSwitch=!0,this.state=g.State.IDLE),this.tick()}},{key:"onAudioTrackLoaded",value:function(e){var t=e.details,r=e.id,i=this.tracks[r],a=t.totalduration,n=0;if(f.logger.log("track "+r+" loaded ["+t.startSN+","+t.endSN+"],duration:"+a),t.live){var o=i.details;o&&t.fragments.length>0?(l.mergeDetails(o,t),n=t.fragments[0].start,t.PTSKnown?f.logger.log("live audio playlist sliding:"+n.toFixed(3)):f.logger.log("live audio playlist - outdated PTS, unknown sliding")):(t.PTSKnown=!1,f.logger.log("live audio playlist - first load, unknown sliding"))}else t.PTSKnown=!1;if(i.details=t,!this.startFragRequested){if(-1===this.startPosition){var s=t.startTimeOffset;Number.isFinite(s)?(f.logger.log("start time offset found in playlist, adjust startPosition to "+s),this.startPosition=s):this.startPosition=0}this.nextLoadPosition=this.startPosition}this.state===g.State.WAITING_TRACK&&(this.state=g.State.IDLE),this.tick()}},{key:"onKeyLoaded",value:function(){this.state===g.State.KEY_LOADING&&(this.state=g.State.IDLE,this.tick())}},{key:"onFragLoaded",value:function(e){var t=this.fragCurrent,r=e.frag;if(this.state===g.State.FRAG_LOADING&&t&&"audio"===r.type&&r.level===t.level&&r.sn===t.sn){var i=this.tracks[this.trackId],a=i.details,n=a.totalduration,l=t.level,u=t.sn,d=t.cc,c=this.config.defaultAudioCodec||i.audioCodec||"mp4a.40.2",h=this.stats=e.stats;if("initSegment"===u)this.state=g.State.IDLE,h.tparsed=h.tbuffered=m.now(),a.initSegment.data=e.payload,this.hls.trigger(s.default.FRAG_BUFFERED,{stats:h,frag:t,id:"audio"}),this.tick();else{this.state=g.State.PARSING,this.appended=!1,this.demuxer||(this.demuxer=new o.default(this.hls,"audio"));var v=this.initPTS[d],p=a.initSegment?a.initSegment.data:[];if(a.initSegment||void 0!==v){this.pendingBuffering=!0,f.logger.log("Demuxing "+u+" of ["+a.startSN+" ,"+a.endSN+"],track "+l);this.demuxer.push(e.payload,p,c,null,t,n,!1,v)}else f.logger.log("unknown video PTS for continuity counter "+d+", waiting for video PTS before demuxing audio frag "+u+" of ["+a.startSN+" ,"+a.endSN+"],track "+l),this.waitingFragment=e,this.state=g.State.WAITING_INIT_PTS}}this.fragLoadError=0}},{key:"onFragParsingInitSegment",value:function(e){var t=this.fragCurrent,r=e.frag;if(t&&"audio"===e.id&&r.sn===t.sn&&r.level===t.level&&this.state===g.State.PARSING){var i=e.tracks,a=void 0;if(i.video&&delete i.video,a=i.audio){a.levelCodec=a.codec,a.id=e.id,this.hls.trigger(s.default.BUFFER_CODECS,i),f.logger.log("audio track:audio,container:"+a.container+",codecs[level/parsed]=["+a.levelCodec+"/"+a.codec+"]");var n=a.initSegment;if(n){var o={type:"audio",data:n,parent:"audio",content:"initSegment"};this.audioSwitch?this.pendingData=[o]:(this.appended=!0,this.pendingBuffering=!0,this.hls.trigger(s.default.BUFFER_APPENDING,o))}this.tick()}}}},{key:"onFragParsingData",value:function(e){var t=this,r=this.fragCurrent,i=e.frag;if(r&&"audio"===e.id&&"audio"===e.type&&i.sn===r.sn&&i.level===r.level&&this.state===g.State.PARSING){var a=this.trackId,n=this.tracks[a],o=this.hls;Number.isFinite(e.endPTS)||(e.endPTS=e.startPTS+r.duration,e.endDTS=e.startDTS+r.duration),r.addElementaryStream(v.default.ElementaryStreamTypes.AUDIO),f.logger.log("parsed "+e.type+",PTS:["+e.startPTS.toFixed(3)+","+e.endPTS.toFixed(3)+"],DTS:["+e.startDTS.toFixed(3)+"/"+e.endDTS.toFixed(3)+"],nb:"+e.nb),l.updateFragPTSDTS(n.details,r,e.startPTS,e.endPTS);var u=this.audioSwitch,c=this.media,h=!1;if(u&&c)if(c.readyState){var p=c.currentTime;f.logger.log("switching audio track : currentTime:"+p),p>=e.startPTS&&(f.logger.log("switching audio track : flushing all audio"),this.state=g.State.BUFFER_FLUSHING,o.trigger(s.default.BUFFER_FLUSHING,{startOffset:0,endOffset:Number.POSITIVE_INFINITY,type:"audio"}),h=!0,this.audioSwitch=!1,o.trigger(s.default.AUDIO_TRACK_SWITCHED,{id:a}))}else this.audioSwitch=!1,o.trigger(s.default.AUDIO_TRACK_SWITCHED,{id:a});var y=this.pendingData;if(!y)return f.logger.warn("Apparently attempt to enqueue media payload without codec initialization data upfront"),void o.trigger(s.default.ERROR,{type:d.ErrorTypes.MEDIA_ERROR,details:null,fatal:!0});this.audioSwitch||([e.data1,e.data2].forEach(function(t){t&&t.length&&y.push({type:e.type,data:t,parent:"audio",content:"data"})}),!h&&y.length&&(y.forEach(function(e){t.state===g.State.PARSING&&(t.pendingBuffering=!0,t.hls.trigger(s.default.BUFFER_APPENDING,e))}),this.pendingData=[],this.appended=!0)),this.tick()}}},{key:"onFragParsed",value:function(e){var t=this.fragCurrent,r=e.frag;t&&"audio"===e.id&&r.sn===t.sn&&r.level===t.level&&this.state===g.State.PARSING&&(this.stats.tparsed=m.now(),this.state=g.State.PARSED,this._checkAppendedParsed())}},{key:"onBufferReset",value:function(){this.mediaBuffer=this.videoBuffer=null,this.loadedmetadata=!1}},{key:"onBufferCreated",value:function(e){var t=e.tracks.audio;t&&(this.mediaBuffer=t.buffer,this.loadedmetadata=!0),e.tracks.video&&(this.videoBuffer=e.tracks.video.buffer)}},{key:"onBufferAppended",value:function(e){if("audio"===e.parent){var t=this.state;t!==g.State.PARSING&&t!==g.State.PARSED||(this.pendingBuffering=e.pending>0,this._checkAppendedParsed())}}},{key:"_checkAppendedParsed",value:function(){if(!(this.state!==g.State.PARSED||this.appended&&this.pendingBuffering)){var e=this.fragCurrent,t=this.stats,r=this.hls;if(e){this.fragPrevious=e,t.tbuffered=m.now(),r.trigger(s.default.FRAG_BUFFERED,{stats:t,frag:e,id:"audio"});var i=this.mediaBuffer?this.mediaBuffer:this.media;f.logger.log("audio buffered : "+u.default.toString(i.buffered)),this.audioSwitch&&this.appended&&(this.audioSwitch=!1,r.trigger(s.default.AUDIO_TRACK_SWITCHED,{id:this.trackId})),this.state=g.State.IDLE}this.tick()}}},{key:"onError",value:function(e){var t=e.frag;if(!t||"audio"===t.type)switch(e.details){case d.ErrorDetails.FRAG_LOAD_ERROR:case d.ErrorDetails.FRAG_LOAD_TIMEOUT:var r=e.frag;if(r&&"audio"!==r.type)break;if(!e.fatal){var i=this.fragLoadError;i?i++:i=1;var a=this.config;if(i<=a.fragLoadingMaxRetry){this.fragLoadError=i;var o=Math.min(Math.pow(2,i-1)*a.fragLoadingRetryDelay,a.fragLoadingMaxRetryTimeout);f.logger.warn("AudioStreamController: frag loading failed, retry in "+o+" ms"),this.retryDate=m.now()+o,this.state=g.State.FRAG_LOADING_WAITING_RETRY}else f.logger.error("AudioStreamController: "+e.details+" reaches max retry, redispatch as fatal ..."),e.fatal=!0,this.state=g.State.ERROR}break;case d.ErrorDetails.AUDIO_TRACK_LOAD_ERROR:case d.ErrorDetails.AUDIO_TRACK_LOAD_TIMEOUT:case d.ErrorDetails.KEY_LOAD_ERROR:case d.ErrorDetails.KEY_LOAD_TIMEOUT:this.state!==g.State.ERROR&&(this.state=e.fatal?g.State.ERROR:g.State.IDLE,f.logger.warn("AudioStreamController: "+e.details+" while loading frag, now switching to "+this.state+" state ..."));break;case d.ErrorDetails.BUFFER_FULL_ERROR:if("audio"===e.parent&&(this.state===g.State.PARSING||this.state===g.State.PARSED)){var l=this.mediaBuffer,u=this.media.currentTime;if(l&&n.BufferHelper.isBuffered(l,u)&&n.BufferHelper.isBuffered(l,u+.5)){var c=this.config;c.maxMaxBufferLength>=c.maxBufferLength&&(c.maxMaxBufferLength/=2,f.logger.warn("AudioStreamController: reduce max buffer length to "+c.maxMaxBufferLength+"s")),this.state=g.State.IDLE}else f.logger.warn("AudioStreamController: buffer full error also media.currentTime is not buffered, flush audio buffer"),this.fragCurrent=null,this.state=g.State.BUFFER_FLUSHING,this.hls.trigger(s.default.BUFFER_FLUSHING,{startOffset:0,endOffset:Number.POSITIVE_INFINITY,type:"audio"})}}}},{key:"onBufferFlushed",value:function(){var e=this,t=this.pendingData;t&&t.length?(f.logger.log("AudioStreamController: appending pending audio data after buffer flushed"),t.forEach(function(t){e.hls.trigger(s.default.BUFFER_APPENDING,t)}),this.appended=!0,this.pendingData=[],this.state=g.State.PARSED):(this.state=g.State.IDLE,this.fragPrevious=null,this.tick())}},{key:"state",set:function(e){if(this.state!==e){var t=this.state;this._state=e,f.logger.log("audio stream:"+t+"->"+e)}},get:function(){return this._state}}]),t}();t.default=b,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(17)),o=r(0),s=r(2);function l(e){return e&&e.__esModule?e:{default:e}}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MANIFEST_LOADING,a.default.MANIFEST_PARSED,a.default.AUDIO_TRACK_LOADED,a.default.AUDIO_TRACK_SWITCHED,a.default.LEVEL_LOADED,a.default.ERROR));return r._trackId=-1,r._selectDefaultTrack=!0,r.tracks=[],r.trackIdBlacklist=Object.create(null),r.audioGroupId=null,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"onManifestLoading",value:function(){this.tracks=[],this._trackId=-1,this._selectDefaultTrack=!0}},{key:"onManifestParsed",value:function(e){var t=this.tracks=e.audioTracks||[];this.hls.trigger(a.default.AUDIO_TRACKS_UPDATED,{audioTracks:t})}},{key:"onAudioTrackLoaded",value:function(e){if(e.id>=this.tracks.length)o.logger.warn("Invalid audio track id:",e.id);else{if(o.logger.log("audioTrack "+e.id+" loaded"),this.tracks[e.id].details=e.details,e.details.live&&!this.hasInterval()){var t=1e3*e.details.targetduration;this.setInterval(t)}!e.details.live&&this.hasInterval()&&this.clearInterval()}}},{key:"onAudioTrackSwitched",value:function(e){var t=this.tracks[e.id].groupId;t&&this.audioGroupId!==t&&(this.audioGroupId=t)}},{key:"onLevelLoaded",value:function(e){var t=this.hls.levels[e.level];if(t.audioGroupIds){var r=t.audioGroupIds[t.urlId];this.audioGroupId!==r&&(this.audioGroupId=r,this._selectInitialAudioTrack())}}},{key:"onError",value:function(e){e.type===s.ErrorTypes.NETWORK_ERROR&&(e.fatal&&this.clearInterval(),e.details===s.ErrorDetails.AUDIO_TRACK_LOAD_ERROR&&(o.logger.warn("Network failure on audio-track id:",e.context.id),this._handleLoadError()))}},{key:"_setAudioTrack",value:function(e){if(this._trackId===e&&this.tracks[this._trackId].details)o.logger.debug("Same id as current audio-track passed, and track details available -> no-op");else if(e<0||e>=this.tracks.length)o.logger.warn("Invalid id passed to audio-track controller");else{var t=this.tracks[e];o.logger.log("Now switching to audio-track index "+e),this.clearInterval(),this._trackId=e;var r=t.url,i=t.type,n=t.id;this.hls.trigger(a.default.AUDIO_TRACK_SWITCHING,{id:n,type:i,url:r}),this._loadTrackDetailsIfNeeded(t)}}},{key:"doTick",value:function(){this._updateTrack(this._trackId)}},{key:"_selectInitialAudioTrack",value:function(){var e=this,t=this.tracks;if(t.length){var r=this.tracks[this._trackId],i=null;if(r&&(i=r.name),this._selectDefaultTrack){var n=t.filter(function(e){return e.default});n.length?t=n:o.logger.warn("No default audio tracks defined")}var l=!1,u=function(){t.forEach(function(t){l||e.audioGroupId&&t.groupId!==e.audioGroupId||i&&i!==t.name||(e._setAudioTrack(t.id),l=!0)})};u(),l||(i=null,u()),l||(o.logger.error("No track found for running audio group-ID: "+this.audioGroupId),this.hls.trigger(a.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.AUDIO_TRACK_LOAD_ERROR,fatal:!0}))}}},{key:"_needsTrackLoading",value:function(e){var t=e.details,r=e.url;return!(t&&!t.live)&&!!r}},{key:"_loadTrackDetailsIfNeeded",value:function(e){if(this._needsTrackLoading(e)){var t=e.url,r=e.id;o.logger.log("loading audio-track playlist for id: "+r),this.hls.trigger(a.default.AUDIO_TRACK_LOADING,{url:t,id:r})}}},{key:"_updateTrack",value:function(e){if(!(e<0||e>=this.tracks.length)){this.clearInterval(),this._trackId=e,o.logger.log("trying to update audio-track "+e);var t=this.tracks[e];this._loadTrackDetailsIfNeeded(t)}}},{key:"_handleLoadError",value:function(){this.trackIdBlacklist[this._trackId]=!0;var e=this._trackId,t=this.tracks[e],r=t.name,i=t.language,a=t.groupId;o.logger.warn("Loading failed on audio track id: "+e+", group-id: "+a+', name/language: "'+r+'" / "'+i+'"');for(var n=e,s=0;s<this.tracks.length;s++){if(!this.trackIdBlacklist[s])if(this.tracks[s].name===r){n=s;break}}n!==e?(o.logger.log("Attempting audio-track fallback id:",n,"group-id:",this.tracks[n].groupId),this._setAudioTrack(n)):o.logger.warn('No fallback audio-track found for name/language: "'+r+'" / "'+i+'"')}},{key:"audioTracks",get:function(){return this.tracks}},{key:"audioTrack",get:function(){return this._trackId},set:function(e){this._setAudioTrack(e),this._selectDefaultTrack=!1}}]),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=r(0);var n=window,o=n.performance,s=n.XMLHttpRequest,l=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),t&&t.xhrSetup&&(this.xhrSetup=t.xhrSetup)}return i(e,[{key:"destroy",value:function(){this.abort(),this.loader=null}},{key:"abort",value:function(){var e=this.loader;e&&4!==e.readyState&&(this.stats.aborted=!0,e.abort()),window.clearTimeout(this.requestTimeout),this.requestTimeout=null,window.clearTimeout(this.retryTimeout),this.retryTimeout=null}},{key:"load",value:function(e,t,r){this.context=e,this.config=t,this.callbacks=r,this.stats={trequest:o.now(),retry:0},this.retryDelay=t.retryDelay,this.loadInternal()}},{key:"loadInternal",value:function(){var e=void 0,t=this.context;e=this.loader=new s;var r=this.stats;r.tfirst=0,r.loaded=0;var i=this.xhrSetup;try{if(i)try{i(e,t.url)}catch(r){e.open("GET",t.url,!0),i(e,t.url)}e.readyState||e.open("GET",t.url,!0)}catch(r){return void this.callbacks.onError({code:e.status,text:r.message},t,e)}t.rangeEnd&&e.setRequestHeader("Range","bytes="+t.rangeStart+"-"+(t.rangeEnd-1)),e.onreadystatechange=this.readystatechange.bind(this),e.onprogress=this.loadprogress.bind(this),e.responseType=t.responseType,this.requestTimeout=window.setTimeout(this.loadtimeout.bind(this),this.config.timeout),e.send()}},{key:"readystatechange",value:function(e){var t=e.currentTarget,r=t.readyState,i=this.stats,n=this.context,s=this.config;if(!i.aborted&&r>=2)if(window.clearTimeout(this.requestTimeout),0===i.tfirst&&(i.tfirst=Math.max(o.now(),i.trequest)),4===r){var l=t.status;if(l>=200&&l<300){i.tload=Math.max(i.tfirst,o.now());var u=void 0,d=void 0;d="arraybuffer"===n.responseType?(u=t.response).byteLength:(u=t.responseText).length,i.loaded=i.total=d;var f={url:t.responseURL,data:u};this.callbacks.onSuccess(f,i,n,t)}else i.retry>=s.maxRetry||l>=400&&l<499?(a.logger.error(l+" while loading "+n.url),this.callbacks.onError({code:l,text:t.statusText},n,t)):(a.logger.warn(l+" while loading "+n.url+", retrying in "+this.retryDelay+"..."),this.destroy(),this.retryTimeout=window.setTimeout(this.loadInternal.bind(this),this.retryDelay),this.retryDelay=Math.min(2*this.retryDelay,s.maxRetryDelay),i.retry++)}else this.requestTimeout=window.setTimeout(this.loadtimeout.bind(this),s.timeout)}},{key:"loadtimeout",value:function(){a.logger.warn("timeout while loading "+this.context.url),this.callbacks.onTimeout(this.stats,this.context,null)}},{key:"loadprogress",value:function(e){var t=e.currentTarget,r=this.stats;r.loaded=e.loaded,e.lengthComputable&&(r.total=e.total);var i=this.callbacks.onProgress;i&&i(r,this.context,null,t)}}]),e}();t.default=l,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=s(r(1)),n=s(r(3)),o=r(0);function s(e){return e&&e.__esModule?e:{default:e}}var l=window.performance,u=function(e){function t(e){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHING))}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){this.timer&&clearInterval(this.timer),this.isVideoPlaybackQualityAvailable=!1}},{key:"onMediaAttaching",value:function(e){var t=this.hls.config;t.capLevelOnFPSDrop&&("function"==typeof(this.video=e.media instanceof window.HTMLVideoElement?e.media:null).getVideoPlaybackQuality&&(this.isVideoPlaybackQualityAvailable=!0),clearInterval(this.timer),this.timer=setInterval(this.checkFPSInterval.bind(this),t.fpsDroppedMonitoringPeriod))}},{key:"checkFPS",value:function(e,t,r){var i=l.now();if(t){if(this.lastTime){var n=i-this.lastTime,s=r-this.lastDroppedFrames,u=t-this.lastDecodedFrames,d=1e3*s/n,f=this.hls;if(f.trigger(a.default.FPS_DROP,{currentDropped:s,currentDecoded:u,totalDroppedFrames:r}),d>0&&s>f.config.fpsDroppedMonitoringThreshold*u){var c=f.currentLevel;o.logger.warn("drop FPS ratio greater than max allowed value for currentLevel: "+c),c>0&&(-1===f.autoLevelCapping||f.autoLevelCapping>=c)&&(c-=1,f.trigger(a.default.FPS_DROP_LEVEL_CAPPING,{level:c,droppedLevel:f.currentLevel}),f.autoLevelCapping=c,f.streamController.nextLevelSwitch())}}this.lastTime=i,this.lastDroppedFrames=r,this.lastDecodedFrames=t}}},{key:"checkFPSInterval",value:function(){var e=this.video;if(e)if(this.isVideoPlaybackQualityAvailable){var t=e.getVideoPlaybackQuality();this.checkFPS(e,t.totalVideoFrames,t.droppedVideoFrames)}else this.checkFPS(e,e.webkitDecodedFrameCount,e.webkitDroppedFrameCount)}}]),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=o(r(1)),n=o(r(3));function o(e){return e&&e.__esModule?e:{default:e}}var s=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.FPS_DROP_LEVEL_CAPPING,a.default.MEDIA_ATTACHING,a.default.MANIFEST_PARSED,a.default.BUFFER_CODECS,a.default.MEDIA_DETACHING));return r.autoLevelCapping=Number.POSITIVE_INFINITY,r.firstLevel=null,r.levels=[],r.media=null,r.restrictedLevels=[],r.timer=null,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){this.hls.config.capLevelToPlayerSize&&(this.media=null,this._stopCapping())}},{key:"onFpsDropLevelCapping",value:function(e){t.isLevelAllowed(e.droppedLevel,this.restrictedLevels)&&this.restrictedLevels.push(e.droppedLevel)}},{key:"onMediaAttaching",value:function(e){this.media=e.media instanceof window.HTMLVideoElement?e.media:null}},{key:"onManifestParsed",value:function(e){var t=this.hls;this.restrictedLevels=[],this.levels=e.levels,this.firstLevel=e.firstLevel,t.config.capLevelToPlayerSize&&e.video&&this._startCapping()}},{key:"onBufferCodecs",value:function(e){this.hls.config.capLevelToPlayerSize&&e.video&&this._startCapping()}},{key:"onLevelsUpdated",value:function(e){this.levels=e.levels}},{key:"onMediaDetaching",value:function(){this._stopCapping()}},{key:"detectPlayerSize",value:function(){if(this.media){var e=this.levels?this.levels.length:0;if(e){var t=this.hls;t.autoLevelCapping=this.getMaxLevel(e-1),t.autoLevelCapping>this.autoLevelCapping&&t.streamController.nextLevelSwitch(),this.autoLevelCapping=t.autoLevelCapping}}}},{key:"getMaxLevel",value:function(e){var r=this;if(!this.levels)return-1;var i=this.levels.filter(function(i,a){return t.isLevelAllowed(a,r.restrictedLevels)&&a<=e});return t.getMaxLevelByMediaSize(i,this.mediaWidth,this.mediaHeight)}},{key:"_startCapping",value:function(){this.timer||(this.autoLevelCapping=Number.POSITIVE_INFINITY,this.hls.firstLevel=this.getMaxLevel(this.firstLevel),clearInterval(this.timer),this.timer=setInterval(this.detectPlayerSize.bind(this),1e3),this.detectPlayerSize())}},{key:"_stopCapping",value:function(){this.restrictedLevels=[],this.firstLevel=null,this.autoLevelCapping=Number.POSITIVE_INFINITY,this.timer&&(this.timer=clearInterval(this.timer),this.timer=null)}},{key:"mediaWidth",get:function(){var e=void 0,r=this.media;return r&&(e=r.width||r.clientWidth||r.offsetWidth,e*=t.contentScaleFactor),e}},{key:"mediaHeight",get:function(){var e=void 0,r=this.media;return r&&(e=r.height||r.clientHeight||r.offsetHeight,e*=t.contentScaleFactor),e}}],[{key:"isLevelAllowed",value:function(e){return-1===(arguments.length>1&&void 0!==arguments[1]?arguments[1]:[]).indexOf(e)}},{key:"getMaxLevelByMediaSize",value:function(e,t,r){if(!e||e&&!e.length)return-1;for(var i=function(e,t){return!t||(e.width!==t.width||e.height!==t.height)},a=e.length-1,n=0;n<e.length;n+=1){var o=e[n];if((o.width>=t||o.height>=r)&&i(o,e[n+1])){a=n;break}}return a}},{key:"contentScaleFactor",get:function(){var e=1;try{e=window.devicePixelRatio}catch(e){}return e}}]),t}();t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(3)),o=r(0),s=r(2);function l(e){return e&&e.__esModule?e:{default:e}}var u=(0,r(12).getMediaSource)(),d=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHING,a.default.MEDIA_DETACHING,a.default.MANIFEST_PARSED,a.default.BUFFER_RESET,a.default.BUFFER_APPENDING,a.default.BUFFER_CODECS,a.default.BUFFER_EOS,a.default.BUFFER_FLUSHING,a.default.LEVEL_PTS_UPDATED,a.default.LEVEL_UPDATED));return r._msDuration=null,r._levelDuration=null,r._levelTargetDuration=10,r._live=null,r._objectUrl=null,r.bufferCodecEventsExpected=0,r.onsbue=r.onSBUpdateEnd.bind(r),r.onsbe=r.onSBUpdateError.bind(r),r.pendingTracks={},r.tracks={},r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){n.default.prototype.destroy.call(this)}},{key:"onLevelPtsUpdated",value:function(e){var t=e.type,r=this.tracks.audio;if("audio"===t&&r&&"audio/mpeg"===r.container){var i=this.sourceBuffer.audio;if(Math.abs(i.timestampOffset-e.start)>.1){var a=i.updating;try{i.abort()}catch(e){o.logger.warn("can not abort audio buffer: "+e)}a?this.audioTimestampOffset=e.start:(o.logger.warn("change mpeg audio timestamp offset from "+i.timestampOffset+" to "+e.start),i.timestampOffset=e.start)}}}},{key:"onManifestParsed",value:function(e){this.bufferCodecEventsExpected=e.altAudio?2:1,o.logger.log(this.bufferCodecEventsExpected+" bufferCodec event(s) expected")}},{key:"onMediaAttaching",value:function(e){var t=this.media=e.media;if(t){var r=this.mediaSource=new u;this.onmso=this.onMediaSourceOpen.bind(this),this.onmse=this.onMediaSourceEnded.bind(this),this.onmsc=this.onMediaSourceClose.bind(this),r.addEventListener("sourceopen",this.onmso),r.addEventListener("sourceended",this.onmse),r.addEventListener("sourceclose",this.onmsc),t.src=window.URL.createObjectURL(r),this._objectUrl=t.src}}},{key:"onMediaDetaching",value:function(){o.logger.log("media source detaching");var e=this.mediaSource;if(e){if("open"===e.readyState)try{e.endOfStream()}catch(e){o.logger.warn("onMediaDetaching:"+e.message+" while calling endOfStream")}e.removeEventListener("sourceopen",this.onmso),e.removeEventListener("sourceended",this.onmse),e.removeEventListener("sourceclose",this.onmsc),this.media&&(window.URL.revokeObjectURL(this._objectUrl),this.media.src===this._objectUrl?(this.media.removeAttribute("src"),this.media.load()):o.logger.warn("media.src was changed by a third party - skip cleanup")),this.mediaSource=null,this.media=null,this._objectUrl=null,this.pendingTracks={},this.tracks={},this.sourceBuffer={},this.flushRange=[],this.segments=[],this.appended=0}this.onmso=this.onmse=this.onmsc=null,this.hls.trigger(a.default.MEDIA_DETACHED)}},{key:"onMediaSourceOpen",value:function(){o.logger.log("media source opened"),this.hls.trigger(a.default.MEDIA_ATTACHED,{media:this.media});var e=this.mediaSource;e&&e.removeEventListener("sourceopen",this.onmso),this.checkPendingTracks()}},{key:"checkPendingTracks",value:function(){var e=this.bufferCodecEventsExpected,t=this.pendingTracks,r=Object.keys(t).length;(r&&!e||2===r)&&(this.createSourceBuffers(t),this.pendingTracks={},this.doAppending())}},{key:"onMediaSourceClose",value:function(){o.logger.log("media source closed")}},{key:"onMediaSourceEnded",value:function(){o.logger.log("media source ended")}},{key:"onSBUpdateEnd",value:function(){if(this.audioTimestampOffset){var e=this.sourceBuffer.audio;o.logger.warn("change mpeg audio timestamp offset from "+e.timestampOffset+" to "+this.audioTimestampOffset),e.timestampOffset=this.audioTimestampOffset,delete this.audioTimestampOffset}this._needsFlush&&this.doFlush(),this._needsEos&&this.checkEos(),this.appending=!1;var t=this.parent,r=this.segments.reduce(function(e,r){return r.parent===t?e+1:e},0),i={},n=this.sourceBuffer;for(var s in n)i[s]=n[s].buffered;if(!1===this._paused&&i.video&&i.video.length>0&&i.audio&&i.audio.length>0)if(i.video.end(0)-i.video.start(0)>1&&i.audio.end(0)-i.audio.start(0)>1){var l=Math.max(i.video.start(0),i.audio.start(0));this.media.currentTime=l,this.media.play(),delete this._paused}else{var u=Math.max(i.video.end(0),i.audio.end(0));this.media.currentTime=u,this.media.play()}this.hls.trigger(a.default.BUFFER_APPENDED,{parent:t,pending:r,timeRanges:i}),this._needsFlush||this.doAppending(),this.updateMediaElementDuration(),0===r&&this.flushLiveBackBuffer()}},{key:"onSBUpdateError",value:function(e){o.logger.error("sourceBuffer error:",e),this.hls.trigger(a.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.BUFFER_APPENDING_ERROR,fatal:!1})}},{key:"onBufferReset",value:function(){var e=this.sourceBuffer;for(var t in e){var r=e[t];try{this.mediaSource.removeSourceBuffer(r),r.removeEventListener("updateend",this.onsbue),r.removeEventListener("error",this.onsbe)}catch(e){}}this.sourceBuffer={},this.flushRange=[],this.segments=[],this.appended=0}},{key:"onBufferCodecs",value:function(e){var t=this;Object.keys(e).forEach(function(r){t.pendingTracks[r]=e[r]});var r=this.mediaSource;this.bufferCodecEventsExpected=Math.max(this.bufferCodecEventsExpected-1,0),r&&"open"===r.readyState&&this.checkPendingTracks()}},{key:"createSourceBuffers",value:function(e){var t=this.sourceBuffer,r=this.mediaSource;for(var i in e)if(!t[i]){var n=e[i],l=n.levelCodec||n.codec,d=n.container+";codecs="+l;o.logger.log("creating sourceBuffer("+d+")");try{var f=t[i]=r.addSourceBuffer(d);f.addEventListener("updateend",this.onsbue),f.addEventListener("error",this.onsbe),this.tracks[i]={codec:l,container:n.container},n.buffer=f}catch(e){if(22==e.code){o.logger.log("Found new track, try to rebuild"),this._paused=!1;var c=this.mediaSource=new u;this.onmso=this.onMediaSourceOpen.bind(this),this.onmse=this.onMediaSourceEnded.bind(this),this.onmsc=this.onMediaSourceClose.bind(this);for(var h=0;h<Object.keys(this.tracks).length;h++){var v=this.tracks[Object.keys(this.tracks)[h]];this.pendingTracks[Object.keys(this.tracks)[h]]=v}this.tracks={},this.sourceBuffer={},c.addEventListener("sourceopen",this.onmso),c.addEventListener("sourceended",this.onmse),c.addEventListener("sourceclose",this.onmsc),this.media.src=window.URL.createObjectURL(c),this._objectUrl=media.src}else o.logger.error("error while trying to add sourceBuffer:"+e.message),this.hls.trigger(a.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.BUFFER_ADD_CODEC_ERROR,fatal:!1,err:e,mimeType:d})}}this.hls.trigger(a.default.BUFFER_CREATED,{tracks:e})}},{key:"onBufferAppending",value:function(e){this._needsFlush||(this.segments?this.segments.push(e):this.segments=[e],this.doAppending())}},{key:"onBufferAppendFail",value:function(e){o.logger.error("sourceBuffer error:",e.event),this.hls.trigger(a.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.BUFFER_APPENDING_ERROR,fatal:!1})}},{key:"onBufferEos",value:function(e){var t=this.sourceBuffer,r=e.type;for(var i in t)r&&i!==r||t[i].ended||(t[i].ended=!0,o.logger.log(i+" sourceBuffer now EOS"));this.checkEos()}},{key:"checkEos",value:function(){var e=this.sourceBuffer,t=this.mediaSource;if(t&&"open"===t.readyState){for(var r in e){var i=e[r];if(!i.ended)return;if(i.updating)return void(this._needsEos=!0)}o.logger.log("all media data are available, signal endOfStream() to MediaSource and stop loading fragment");try{t.endOfStream()}catch(e){o.logger.warn("exception while calling mediaSource.endOfStream()")}this._needsEos=!1}else this._needsEos=!1}},{key:"onBufferFlushing",value:function(e){this.flushRange.push({start:e.startOffset,end:e.endOffset,type:e.type}),this.flushBufferCounter=0,this.doFlush()}},{key:"flushLiveBackBuffer",value:function(){if(this._live){var e=this.hls.config.liveBackBufferLength;if(isFinite(e)&&!(e<0))for(var t=this.media.currentTime,r=this.sourceBuffer,i=Object.keys(r),a=t-Math.max(e,this._levelTargetDuration),n=i.length-1;n>=0;n--){var o=i[n],s=r[o].buffered;s.length>0&&a>s.start(0)&&this.removeBufferRange(o,r[o],0,a)}}}},{key:"onLevelUpdated",value:function(e){var t=e.details;t.fragments.length>0&&(this._levelDuration=t.totalduration+t.fragments[0].start,this._levelTargetDuration=t.averagetargetduration||t.targetduration||10,this._live=t.live,this.updateMediaElementDuration())}},{key:"updateMediaElementDuration",value:function(){var e,t=this.hls.config;if(null!==this._levelDuration&&this.media&&this.mediaSource&&this.sourceBuffer&&0!==this.media.readyState&&"open"===this.mediaSource.readyState){for(var r in this.sourceBuffer)if(!0===this.sourceBuffer[r].updating)return;e=this.media.duration,null===this._msDuration&&(this._msDuration=this.mediaSource.duration),!0===this._live&&!0===t.liveDurationInfinity?(o.logger.log("Media Source duration is set to Infinity"),this._msDuration=this.mediaSource.duration=1/0):(this._levelDuration>this._msDuration&&this._levelDuration>e||!Number.isFinite(e))&&(o.logger.log("Updating Media Source duration to "+this._levelDuration.toFixed(3)),this._msDuration=this.mediaSource.duration=this._levelDuration)}}},{key:"doFlush",value:function(){for(;this.flushRange.length;){var e=this.flushRange[0];if(!this.flushBuffer(e.start,e.end,e.type))return void(this._needsFlush=!0);this.flushRange.shift(),this.flushBufferCounter=0}if(0===this.flushRange.length){this._needsFlush=!1;var t=0,r=this.sourceBuffer;try{for(var i in r)t+=r[i].buffered.length}catch(e){o.logger.error("error while accessing sourceBuffer.buffered")}this.appended=t,this.hls.trigger(a.default.BUFFER_FLUSHED)}}},{key:"doAppending",value:function(){var e=this.hls,t=this.segments,r=this.sourceBuffer;if(Object.keys(r).length){if(this.media.error)return this.segments=[],void o.logger.error("trying to append although a media error occured, flush segment and abort");if(this.appending)return;if(t&&t.length){var i=t.shift();try{var n=r[i.type];n?n.updating?t.unshift(i):(n.ended=!1,this.parent=i.parent,n.appendBuffer(i.data),this.appendError=0,this.appended++,this.appending=!0):this.onSBUpdateEnd()}catch(r){o.logger.error("error while trying to append buffer:"+r.message),t.unshift(i);var l={type:s.ErrorTypes.MEDIA_ERROR,parent:i.parent};22!==r.code?(this.appendError?this.appendError++:this.appendError=1,l.details=s.ErrorDetails.BUFFER_APPEND_ERROR,this.appendError>e.config.appendErrorMaxRetry?(o.logger.log("fail "+e.config.appendErrorMaxRetry+" times to append segment in sourceBuffer"),this.segments=[],l.fatal=!0,e.trigger(a.default.ERROR,l)):(l.fatal=!1,e.trigger(a.default.ERROR,l))):(this.segments=[],l.details=s.ErrorDetails.BUFFER_FULL_ERROR,l.fatal=!1,e.trigger(a.default.ERROR,l))}}}}},{key:"flushBuffer",value:function(e,t,r){var i=void 0,a=this.sourceBuffer;if(Object.keys(a).length){if(o.logger.log("flushBuffer,pos/start/end: "+this.media.currentTime.toFixed(3)+"/"+e+"/"+t),this.flushBufferCounter<this.appended){for(var n in a)if(!r||n===r){if((i=a[n]).ended=!1,i.updating)return o.logger.warn("cannot flush, sb updating in progress"),!1;if(this.removeBufferRange(n,i,e,t))return this.flushBufferCounter++,!1}}else o.logger.warn("abort flushing too many retries");o.logger.log("buffer flushed")}return!0}},{key:"removeBufferRange",value:function(e,t,r,i){try{for(var a=0;a<t.buffered.length;a++){var n=t.buffered.start(a),s=t.buffered.end(a),l=Math.max(n,r),u=Math.min(s,i);if(Math.min(u,s)-l>.5)return o.logger.log("sb remove "+e+" ["+l+","+u+"], of ["+n+","+s+"], pos:"+this.media.currentTime),t.remove(l,u),!0}}catch(e){o.logger.warn("removeBufferRange failed",e)}return!1}}]),t}();t.default=d,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.alpha_=t?Math.exp(Math.log(.5)/t):0,this.estimate_=0,this.totalWeight_=0}return i(e,[{key:"sample",value:function(e,t){var r=Math.pow(this.alpha_,e);this.estimate_=t*(1-r)+r*this.estimate_,this.totalWeight_+=e}},{key:"getTotalWeight",value:function(){return this.totalWeight_}},{key:"getEstimate",value:function(){if(this.alpha_){var e=1-Math.pow(this.alpha_,this.totalWeight_);return this.estimate_/e}return this.estimate_}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){return e&&e.__esModule?e:{default:e}}(r(48));var n=function(){function e(t,r,i,n){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.hls=t,this.defaultEstimate_=n,this.minWeight_=.001,this.minDelayMs_=50,this.slow_=new a.default(r),this.fast_=new a.default(i)}return i(e,[{key:"sample",value:function(e,t){var r=8e3*t/(e=Math.max(e,this.minDelayMs_)),i=e/1e3;this.fast_.sample(i,r),this.slow_.sample(i,r)}},{key:"canEstimate",value:function(){var e=this.fast_;return e&&e.getTotalWeight()>=this.minWeight_}},{key:"getEstimate",value:function(){return this.canEstimate()?Math.min(this.fast_.getEstimate(),this.slow_.getEstimate()):this.defaultEstimate_}},{key:"destroy",value:function(){}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=d(r(1)),n=d(r(3)),o=r(4),s=r(2),l=r(0),u=d(r(49));function d(e){return e&&e.__esModule?e:{default:e}}var f=window.performance,c=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.FRAG_LOADING,a.default.FRAG_LOADED,a.default.FRAG_BUFFERED,a.default.ERROR));return r.lastLoadedFragLevel=0,r._nextAutoLevel=-1,r.hls=e,r.timer=null,r._bwEstimator=null,r.onCheck=r._abandonRulesCheck.bind(r),r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){this.clearTimer(),n.default.prototype.destroy.call(this)}},{key:"onFragLoading",value:function(e){var t=e.frag;if("main"===t.type&&(this.timer||(this.fragCurrent=t,this.timer=setInterval(this.onCheck,100)),!this._bwEstimator)){var r=this.hls,i=r.config,a=t.level,n=void 0,o=void 0;r.levels[a].details.live?(n=i.abrEwmaFastLive,o=i.abrEwmaSlowLive):(n=i.abrEwmaFastVoD,o=i.abrEwmaSlowVoD),this._bwEstimator=new u.default(r,o,n,i.abrEwmaDefaultEstimate)}}},{key:"_abandonRulesCheck",value:function(){var e=this.hls,t=e.media,r=this.fragCurrent;if(r){var i=r.loader,n=e.minAutoLevel;if(!i||i.stats&&i.stats.aborted)return l.logger.warn("frag loader destroy or aborted, disarm abandonRules"),this.clearTimer(),void(this._nextAutoLevel=-1);var s=i.stats;if(t&&s&&(!t.paused&&0!==t.playbackRate||!t.readyState)&&r.autoLevel&&r.level){var u=f.now()-s.trequest,d=Math.abs(t.playbackRate);if(u>500*r.duration/d){var c=e.levels,h=Math.max(1,s.bw?s.bw/8:1e3*s.loaded/u),v=c[r.level],g=v.realBitrate?Math.max(v.realBitrate,v.bitrate):v.bitrate,p=s.total?s.total:Math.max(s.loaded,Math.round(r.duration*g/8)),y=t.currentTime,m=(p-s.loaded)/h,b=(o.BufferHelper.bufferInfo(t,y,e.config.maxBufferHole).end-y)/d;if(b<2*r.duration/d&&m>b){var E=void 0,_=void 0;for(_=r.level-1;_>n;_--){var T=c[_].realBitrate?Math.max(c[_].realBitrate,c[_].bitrate):c[_].bitrate;if((E=r.duration*T/(6.4*h))<b)break}E<m&&(l.logger.warn("loading too slow, abort fragment loading and switch to level "+_+":fragLoadedDelay["+_+"]<fragLoadedDelay["+(r.level-1)+"];bufferStarvationDelay:"+E.toFixed(1)+"<"+m.toFixed(1)+":"+b.toFixed(1)),e.nextLoadLevel=_,this._bwEstimator.sample(u,s.loaded),i.abort(),this.clearTimer(),e.trigger(a.default.FRAG_LOAD_EMERGENCY_ABORTED,{frag:r,stats:s}))}}}}}},{key:"onFragLoaded",value:function(e){var t=e.frag;if("main"===t.type&&Number.isFinite(t.sn)){if(this.clearTimer(),this.lastLoadedFragLevel=t.level,this._nextAutoLevel=-1,this.hls.config.abrMaxWithRealBitrate){var r=this.hls.levels[t.level],i=(r.loaded?r.loaded.bytes:0)+e.stats.loaded,a=(r.loaded?r.loaded.duration:0)+e.frag.duration;r.loaded={bytes:i,duration:a},r.realBitrate=Math.round(8*i/a)}if(e.frag.bitrateTest){var n=e.stats;n.tparsed=n.tbuffered=n.tload,this.onFragBuffered(e)}}}},{key:"onFragBuffered",value:function(e){var t=e.stats,r=e.frag;if(!0!==t.aborted&&"main"===r.type&&Number.isFinite(r.sn)&&(!r.bitrateTest||t.tload===t.tbuffered)){var i=t.tparsed-t.trequest;l.logger.log("latency/loading/parsing/append/kbps:"+Math.round(t.tfirst-t.trequest)+"/"+Math.round(t.tload-t.tfirst)+"/"+Math.round(t.tparsed-t.tload)+"/"+Math.round(t.tbuffered-t.tparsed)+"/"+Math.round(8*t.loaded/(t.tbuffered-t.trequest))),this._bwEstimator.sample(i,t.loaded),t.bwEstimate=this._bwEstimator.getEstimate(),r.bitrateTest?this.bitrateTestDelay=i/1e3:this.bitrateTestDelay=0}}},{key:"onError",value:function(e){switch(e.details){case s.ErrorDetails.FRAG_LOAD_ERROR:case s.ErrorDetails.FRAG_LOAD_TIMEOUT:this.clearTimer()}}},{key:"clearTimer",value:function(){clearInterval(this.timer),this.timer=null}},{key:"_findBestLevel",value:function(e,t,r,i,a,n,o,s,u){for(var d=a;d>=i;d--){var f=u[d];if(f){var c=f.details,h=c?c.totalduration/c.fragments.length:t,v=!!c&&c.live,g=void 0;g=d<=e?o*r:s*r;var p=u[d].realBitrate?Math.max(u[d].realBitrate,u[d].bitrate):u[d].bitrate,y=p*h/g;if(l.logger.trace("level/adjustedbw/bitrate/avgDuration/maxFetchDuration/fetchDuration: "+d+"/"+Math.round(g)+"/"+p+"/"+h+"/"+n+"/"+y),g>p&&(!y||v&&!this.bitrateTestDelay||y<n))return d}}return-1}},{key:"nextAutoLevel",get:function(){var e=this._nextAutoLevel,t=this._bwEstimator;if(!(-1===e||t&&t.canEstimate()))return e;var r=this._nextABRAutoLevel;return-1!==e&&(r=Math.min(e,r)),r},set:function(e){this._nextAutoLevel=e}},{key:"_nextABRAutoLevel",get:function(){var e=this.hls,t=e.maxAutoLevel,r=e.levels,i=e.config,a=e.minAutoLevel,n=e.media,s=this.lastLoadedFragLevel,u=this.fragCurrent?this.fragCurrent.duration:0,d=n?n.currentTime:0,f=n&&0!==n.playbackRate?Math.abs(n.playbackRate):1,c=this._bwEstimator?this._bwEstimator.getEstimate():i.abrEwmaDefaultEstimate,h=(o.BufferHelper.bufferInfo(n,d,i.maxBufferHole).end-d)/f,v=this._findBestLevel(s,u,c,a,t,h,i.abrBandWidthFactor,i.abrBandWidthUpFactor,r);if(v>=0)return v;l.logger.trace("rebuffering expected to happen, lets try to find a quality level minimizing the rebuffering");var g=u?Math.min(u,i.maxStarvationDelay):i.maxStarvationDelay,p=i.abrBandWidthFactor,y=i.abrBandWidthUpFactor;if(0===h){var m=this.bitrateTestDelay;if(m)g=(u?Math.min(u,i.maxLoadingDelay):i.maxLoadingDelay)-m,l.logger.trace("bitrate test took "+Math.round(1e3*m)+"ms, set first fragment max fetchDuration to "+Math.round(1e3*g)+" ms"),p=y=1}return v=this._findBestLevel(s,u,c,a,t,h+g,p,y,r),Math.max(v,0)}}]),t}();t.default=c,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.hlsDefaultConfig=void 0;var i=p(r(50)),a=p(r(47)),n=p(r(46)),o=p(r(45)),s=p(r(44)),l=p(r(43)),u=p(r(42)),d=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(41)),f=p(r(39)),c=p(r(35)),h=r(34),v=p(r(33)),g=r(32);function p(e){return e&&e.__esModule?e:{default:e}}var y=t.hlsDefaultConfig={autoStartLoad:!0,startPosition:-1,defaultAudioCodec:void 0,debug:!1,capLevelOnFPSDrop:!1,capLevelToPlayerSize:!1,initialLiveManifestSize:1,maxBufferLength:30,maxBufferSize:6e7,maxBufferHole:.5,lowBufferWatchdogPeriod:.5,highBufferWatchdogPeriod:3,nudgeOffset:.1,nudgeMaxRetry:3,maxFragLookUpTolerance:.25,liveSyncDurationCount:3,liveMaxLatencyDurationCount:1/0,liveSyncDuration:void 0,liveMaxLatencyDuration:void 0,liveDurationInfinity:!1,liveBackBufferLength:1/0,maxMaxBufferLength:600,enableWorker:!0,enableSoftwareAES:!0,manifestLoadingTimeOut:1e4,manifestLoadingMaxRetry:1,manifestLoadingRetryDelay:1e3,manifestLoadingMaxRetryTimeout:64e3,startLevel:void 0,levelLoadingTimeOut:1e4,levelLoadingMaxRetry:4,levelLoadingRetryDelay:1e3,levelLoadingMaxRetryTimeout:64e3,fragLoadingTimeOut:2e4,fragLoadingMaxRetry:6,fragLoadingRetryDelay:1e3,fragLoadingMaxRetryTimeout:64e3,startFragPrefetch:!1,fpsDroppedMonitoringPeriod:5e3,fpsDroppedMonitoringThreshold:.2,appendErrorMaxRetry:3,loader:s.default,fLoader:void 0,pLoader:void 0,xhrSetup:void 0,licenseXhrSetup:void 0,abrController:i.default,bufferController:a.default,capLevelController:n.default,fpsController:o.default,stretchShortVideoTrack:!1,maxAudioFramesDrift:1,forceKeyFrameOnDiscontinuity:!0,abrEwmaFastLive:3,abrEwmaSlowLive:9,abrEwmaFastVoD:3,abrEwmaSlowVoD:9,abrEwmaDefaultEstimate:5e5,abrBandWidthFactor:.95,abrBandWidthUpFactor:.7,abrMaxWithRealBitrate:!1,maxStarvationDelay:4,maxLoadingDelay:4,minAutoBitrate:0,emeEnabled:!1,widevineLicenseUrl:void 0,requestMediaKeySystemAccessFunc:g.requestMediaKeySystemAccess};y.subtitleStreamController=h.SubtitleStreamController,y.subtitleTrackController=c.default,y.timelineController=f.default,y.cueHandler=d,y.enableCEA708Captions=!0,y.enableWebVTT=!0,y.captionsTextTrack1Label="English",y.captionsTextTrack1LanguageCode="en",y.captionsTextTrack2Label="Spanish",y.captionsTextTrack2LanguageCode="es",y.audioStreamController=u.default,y.audioTrackController=l.default,y.emeController=v.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.isSupported=function(){var e=(0,i.getMediaSource)(),t=window.SourceBuffer||window.WebKitSourceBuffer,r=e&&"function"==typeof e.isTypeSupported&&e.isTypeSupported('video/mp4; codecs="avc1.42E01E,mp4a.40.2"'),a=!t||t.prototype&&"function"==typeof t.prototype.appendBuffer&&"function"==typeof t.prototype.remove;return!!r&&!!a};var i=r(12)},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(3)),o=l(r(8)),s=r(16);function l(e){return e&&e.__esModule?e:{default:e}}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.MEDIA_ATTACHED,a.default.MEDIA_DETACHING,a.default.FRAG_PARSING_METADATA));return r.id3Track=void 0,r.media=void 0,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){n.default.prototype.destroy.call(this)}},{key:"onMediaAttached",value:function(e){this.media=e.media,this.media}},{key:"onMediaDetaching",value:function(){(0,s.clearCurrentCues)(this.id3Track),this.id3Track=void 0,this.media=void 0}},{key:"getID3Track",value:function(e){for(var t=0;t<e.length;t++){var r=e[t];if("metadata"===r.kind&&"id3"===r.label)return(0,s.sendAddTrackEvent)(r,this.media),r}return this.media.addTextTrack("metadata","id3")}},{key:"onFragParsingMetadata",value:function(e){var t=e.frag,r=e.samples;this.id3Track||(this.id3Track=this.getID3Track(this.media.textTracks),this.id3Track.mode="hidden");for(var i=window.WebKitDataCue||window.VTTCue||window.TextTrackCue,a=0;a<r.length;a++){var n=o.default.getID3Frames(r[a].data);if(n){var s=r[a].pts,l=a<r.length-1?r[a+1].pts:t.endPTS;s===l&&(l+=1e-4);for(var u=0;u<n.length;u++){var d=n[u];if(!o.default.isTimeStampFrame(d)){var f=new i(s,l,"");f.value=d,this.id3Track.addCue(f)}}}}}}]),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),n=f(r(1)),o=f(r(3)),s=r(0),l=r(2),u=r(27),d=r(5);function f(e){return e&&e.__esModule?e:{default:e}}window.performance;var c=void 0,h=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,n.default.MANIFEST_LOADED,n.default.LEVEL_LOADED,n.default.AUDIO_TRACK_SWITCHED,n.default.FRAG_LOADED,n.default.ERROR));return r.canload=!1,r.currentLevelIndex=null,r.manualLevelIndex=-1,r.timer=null,c=/chrome|firefox/.test(navigator.userAgent.toLowerCase()),r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,o.default),a(t,[{key:"onHandlerDestroying",value:function(){this.clearTimer(),this.manualLevelIndex=-1}},{key:"clearTimer",value:function(){null!==this.timer&&(clearTimeout(this.timer),this.timer=null)}},{key:"startLoad",value:function(){var e=this._levels;this.canload=!0,this.levelRetryCount=0,e&&e.forEach(function(e){e.loadError=0;var t=e.details;t&&t.live&&(e.details=void 0)}),null!==this.timer&&this.loadLevel()}},{key:"stopLoad",value:function(){this.canload=!1}},{key:"onManifestLoaded",value:function(e){var t=[],r=[],i=void 0,a={},o=null,f=!1,h=!1;if(e.levels.forEach(function(e){var r=e.attrs;e.loadError=0,e.fragmentError=!1,f=f||!!e.videoCodec,h=h||!!e.audioCodec,c&&e.audioCodec&&-1!==e.audioCodec.indexOf("mp4a.40.34")&&(e.audioCodec=void 0),(o=a[e.bitrate])?o.url.push(e.url):(e.url=[e.url],e.urlId=0,a[e.bitrate]=e,t.push(e)),r&&(r.AUDIO&&(h=!0,(0,d.addGroupId)(o||e,"audio",r.AUDIO)),r.SUBTITLES&&(0,d.addGroupId)(o||e,"text",r.SUBTITLES))}),f&&h&&(t=t.filter(function(e){return!!e.videoCodec})),t=t.filter(function(e){var t=e.audioCodec,r=e.videoCodec;return(!t||(0,u.isCodecSupportedInMp4)(t,"audio"))&&(!r||(0,u.isCodecSupportedInMp4)(r,"video"))}),e.audioTracks&&(r=e.audioTracks.filter(function(e){return!e.audioCodec||(0,u.isCodecSupportedInMp4)(e.audioCodec,"audio")})).forEach(function(e,t){e.id=t}),t.length>0){i=t[0].bitrate,t.sort(function(e,t){return e.bitrate-t.bitrate}),this._levels=t;for(var v=0;v<t.length;v++)if(t[v].bitrate===i){this._firstLevel=v,s.logger.log("manifest loaded,"+t.length+" level(s) found, first bitrate:"+i);break}this.hls.trigger(n.default.MANIFEST_PARSED,{levels:t,audioTracks:r,firstLevel:this._firstLevel,stats:e.stats,audio:h,video:f,altAudio:r.some(function(e){return!!e.url})})}else this.hls.trigger(n.default.ERROR,{type:l.ErrorTypes.MEDIA_ERROR,details:l.ErrorDetails.MANIFEST_INCOMPATIBLE_CODECS_ERROR,fatal:!0,url:this.hls.url,reason:"no level with compatible codecs found in manifest"})}},{key:"setLevelInternal",value:function(e){var t=this._levels,r=this.hls;if(e>=0&&e<t.length){if(this.clearTimer(),this.currentLevelIndex!==e){s.logger.log("switching to level "+e),this.currentLevelIndex=e;var i=t[e];i.level=e,r.trigger(n.default.LEVEL_SWITCHING,i)}var a=t[e],o=a.details;if(!o||o.live){var u=a.urlId;r.trigger(n.default.LEVEL_LOADING,{url:a.url[u],level:e,id:u})}}else r.trigger(n.default.ERROR,{type:l.ErrorTypes.OTHER_ERROR,details:l.ErrorDetails.LEVEL_SWITCH_ERROR,level:e,fatal:!1,reason:"invalid level idx"})}},{key:"onError",value:function(e){if(e.fatal)e.type===l.ErrorTypes.NETWORK_ERROR&&this.clearTimer();else{var t=!1,r=!1,i=void 0;switch(e.details){case l.ErrorDetails.FRAG_LOAD_ERROR:case l.ErrorDetails.FRAG_LOAD_TIMEOUT:case l.ErrorDetails.KEY_LOAD_ERROR:case l.ErrorDetails.KEY_LOAD_TIMEOUT:i=e.frag.level,r=!0;break;case l.ErrorDetails.LEVEL_LOAD_ERROR:case l.ErrorDetails.LEVEL_LOAD_TIMEOUT:i=e.context.level,t=!0;break;case l.ErrorDetails.REMUX_ALLOC_ERROR:i=e.level,t=!0}void 0!==i&&this.recoverLevel(e,i,t,r)}}},{key:"recoverLevel",value:function(e,t,r,i){var a=this,n=this.hls.config,o=e.details,l=this._levels[t],u=void 0,d=void 0,f=void 0;if(l.loadError++,l.fragmentError=i,r){if(!(this.levelRetryCount+1<=n.levelLoadingMaxRetry))return s.logger.error("level controller, cannot recover from "+o+" error"),this.currentLevelIndex=null,this.clearTimer(),void(e.fatal=!0);d=Math.min(Math.pow(2,this.levelRetryCount)*n.levelLoadingRetryDelay,n.levelLoadingMaxRetryTimeout),this.timer=setTimeout(function(){return a.loadLevel()},d),e.levelRetry=!0,this.levelRetryCount++,s.logger.warn("level controller, "+o+", retry in "+d+" ms, current retry count is "+this.levelRetryCount)}(r||i)&&((u=l.url.length)>1&&l.loadError<u?(l.urlId=(l.urlId+1)%u,l.details=void 0,s.logger.warn("level controller, "+o+" for level "+t+": switching to redundant URL-id "+l.urlId)):-1===this.manualLevelIndex?(f=0===t?this._levels.length-1:t-1,s.logger.warn("level controller, "+o+": switch to "+f),this.hls.nextAutoLevel=this.currentLevelIndex=f):i&&(s.logger.warn("level controller, "+o+": reload a fragment"),this.currentLevelIndex=null))}},{key:"onFragLoaded",value:function(e){var t=e.frag;if(void 0!==t&&"main"===t.type){var r=this._levels[t.level];void 0!==r&&(r.fragmentError=!1,r.loadError=0,this.levelRetryCount=0)}}},{key:"onLevelLoaded",value:function(e){var t=this,r=e.level,i=e.details;if(r===this.currentLevelIndex){var a=this._levels[r];if(a.fragmentError||(a.loadError=0,this.levelRetryCount=0),i.live){var n=(0,d.computeReloadInterval)(a.details,i,e.stats.trequest);s.logger.log("live playlist, reload in "+Math.round(n)+" ms"),this.timer=setTimeout(function(){return t.loadLevel()},n)}else this.clearTimer()}}},{key:"onAudioTrackSwitched",value:function(e){var t=this.hls.audioTracks[e.id].groupId,r=this.hls.levels[this.currentLevelIndex];if(r&&r.audioGroupIds){for(var i=-1,a=0;a<r.audioGroupIds.length;a++)if(r.audioGroupIds[a]===t){i=a;break}i!==r.urlId&&(r.urlId=i,this.startLoad())}}},{key:"loadLevel",value:function(){if(s.logger.debug("call to loadLevel"),null!==this.currentLevelIndex&&this.canload){var e=this._levels[this.currentLevelIndex];if("object"===(void 0===e?"undefined":i(e))&&e.url.length>0){var t=this.currentLevelIndex,r=e.urlId,a=e.url[r];s.logger.log("Attempt loading level index "+t+" with URL-id "+r),this.hls.trigger(n.default.LEVEL_LOADING,{url:a,level:t,id:r})}}}},{key:"levels",get:function(){return this._levels}},{key:"level",get:function(){return this.currentLevelIndex},set:function(e){var t=this._levels;t&&(e=Math.min(e,t.length-1),this.currentLevelIndex===e&&t[e].details||this.setLevelInternal(e))}},{key:"manualLevel",get:function(){return this.manualLevelIndex},set:function(e){this.manualLevelIndex=e,void 0===this._startLevel&&(this._startLevel=e),-1!==e&&(this.level=e)}},{key:"firstLevel",get:function(){return this._firstLevel},set:function(e){this._firstLevel=e}},{key:"startLevel",get:function(){if(void 0===this._startLevel){var e=this.hls.config.startLevel;return void 0!==e?e:this._firstLevel}return this._startLevel},set:function(e){this._startLevel=e}},{key:"nextLoadLevel",get:function(){return-1!==this.manualLevelIndex?this.manualLevelIndex:this.hls.nextAutoLevel},set:function(e){this.level=e,-1===this.manualLevelIndex&&(this.hls.nextAutoLevel=e)}}]),t}();t.default=h,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=r(4),n=r(2),o=function(e){return e&&e.__esModule?e:{default:e}}(r(1)),s=r(0);var l=function(){function e(t,r,i,a){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.config=t,this.media=r,this.fragmentTracker=i,this.hls=a,this.stallReported=!1}return i(e,[{key:"poll",value:function(e,t){var r=this.config,i=this.media,n=i.currentTime,o=window.performance.now();if(n!==e)return this.stallReported&&(s.logger.warn("playback not stuck anymore @"+n+", after "+Math.round(o-this.stalled)+"ms"),this.stallReported=!1),this.stalled=null,void(this.nudgeRetry=0);if(!(i.ended||!i.buffered.length||i.readyState>2||i.seeking&&a.BufferHelper.isBuffered(i,n))){var l=o-this.stalled,u=a.BufferHelper.bufferInfo(i,n,r.maxBufferHole);this.stalled?(l>=1e3&&this._reportStall(u.len),this._tryFixBufferStall(u,l)):this.stalled=o}}},{key:"_tryFixBufferStall",value:function(e,t){var r=this.config,i=this.fragmentTracker,a=this.media.currentTime,n=i.getPartialFragment(a);n&&this._trySkipBufferHole(n),e.len>.5&&t>1e3*r.highBufferWatchdogPeriod&&(this.stalled=null,this._tryNudgeBuffer())}},{key:"_reportStall",value:function(e){var t=this.hls,r=this.media;this.stallReported||(this.stallReported=!0,s.logger.warn("Playback stalling at @"+r.currentTime+" due to low buffer"),t.trigger(o.default.ERROR,{type:n.ErrorTypes.MEDIA_ERROR,details:n.ErrorDetails.BUFFER_STALLED_ERROR,fatal:!1,buffer:e}))}},{key:"_trySkipBufferHole",value:function(e){for(var t=this.hls,r=this.media,i=r.currentTime,a=0,l=0;l<r.buffered.length;l++){var u=r.buffered.start(l);if(i>=a&&i<u)return r.currentTime=Math.max(u,r.currentTime+.1),s.logger.warn("skipping hole, adjusting currentTime from "+i+" to "+r.currentTime),this.stalled=null,void t.trigger(o.default.ERROR,{type:n.ErrorTypes.MEDIA_ERROR,details:n.ErrorDetails.BUFFER_SEEK_OVER_HOLE,fatal:!1,reason:"fragment loaded with buffer holes, seeking from "+i+" to "+r.currentTime,frag:e});a=r.buffered.end(l)}}},{key:"_tryNudgeBuffer",value:function(){var e=this.config,t=this.hls,r=this.media,i=r.currentTime,a=(this.nudgeRetry||0)+1;if(this.nudgeRetry=a,a<e.nudgeMaxRetry){var l=i+a*e.nudgeOffset;s.logger.log("adjust currentTime from "+i+" to "+l),r.currentTime=l,t.trigger(o.default.ERROR,{type:n.ErrorTypes.MEDIA_ERROR,details:n.ErrorDetails.BUFFER_NUDGE_ON_STALL,fatal:!1})}else s.logger.error("still stuck in high buffer @"+i+" after "+e.nudgeMaxRetry+", raise fatal error"),t.trigger(o.default.ERROR,{type:n.ErrorTypes.MEDIA_ERROR,details:n.ErrorDetails.BUFFER_STALLED_ERROR,fatal:!0})}}]),e}();t.default=l,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=s(r(24)),a=s(r(1)),n=r(0),o=r(25);function s(e){return e&&e.__esModule?e:{default:e}}t.default=function(e){var t=new o.EventEmitter;t.trigger=function(e){for(var r=arguments.length,i=Array(r>1?r-1:0),a=1;a<r;a++)i[a-1]=arguments[a];t.emit.apply(t,[e,e].concat(i))},t.off=function(e){for(var r=arguments.length,i=Array(r>1?r-1:0),a=1;a<r;a++)i[a-1]=arguments[a];t.removeListener.apply(t,[e].concat(i))};var r=function(t,r){e.postMessage({event:t,data:r})};e.addEventListener("message",function(a){var o=a.data;switch(o.cmd){case"init":var s=JSON.parse(o.config);e.demuxer=new i.default(t,o.typeSupported,s,o.vendor),(0,n.enableLogs)(s.debug),r("init",null);break;case"demux":e.demuxer.push(o.data,o.decryptdata,o.initSegment,o.audioCodec,o.videoCodec,o.timeOffset,o.discontinuity,o.trackSwitch,o.contiguous,o.duration,o.accurateTimeOffset,o.defaultInitPTS)}}),t.on(a.default.FRAG_DECRYPTED,r),t.on(a.default.FRAG_PARSING_INIT_SEGMENT,r),t.on(a.default.FRAG_PARSED,r),t.on(a.default.ERROR,r),t.on(a.default.FRAG_PARSING_METADATA,r),t.on(a.default.FRAG_PARSING_USERDATA,r),t.on(a.default.INIT_PTS_FOUND,r),t.on(a.default.FRAG_PARSING_DATA,function(t,r){var i=[],a={event:t,data:r};r.data1&&(a.data1=r.data1.buffer,i.push(r.data1.buffer),delete r.data1),r.data2&&(a.data2=r.data2.buffer,i.push(r.data2.buffer),delete r.data2),e.postMessage(a,i)})},e.exports=t.default},function(e,t,r){"use strict";var i=Object.prototype.hasOwnProperty,a="~";function n(){}function o(e,t,r,i,n){if("function"!=typeof r)throw new TypeError("The listener must be a function");var o=new function(e,t,r){this.fn=e,this.context=t,this.once=r||!1}(r,i||e,n),s=a?a+t:t;return e._events[s]?e._events[s].fn?e._events[s]=[e._events[s],o]:e._events[s].push(o):(e._events[s]=o,e._eventsCount++),e}function s(e,t){0==--e._eventsCount?e._events=new n:delete e._events[t]}function l(){this._events=new n,this._eventsCount=0}Object.create&&(n.prototype=Object.create(null),(new n).__proto__||(a=!1)),l.prototype.eventNames=function(){var e,t,r=[];if(0===this._eventsCount)return r;for(t in e=this._events)i.call(e,t)&&r.push(a?t.slice(1):t);return Object.getOwnPropertySymbols?r.concat(Object.getOwnPropertySymbols(e)):r},l.prototype.listeners=function(e){var t=a?a+e:e,r=this._events[t];if(!r)return[];if(r.fn)return[r.fn];for(var i=0,n=r.length,o=new Array(n);i<n;i++)o[i]=r[i].fn;return o},l.prototype.listenerCount=function(e){var t=a?a+e:e,r=this._events[t];return r?r.fn?1:r.length:0},l.prototype.emit=function(e,t,r,i,n,o){var s=a?a+e:e;if(!this._events[s])return!1;var l,u,d=this._events[s],f=arguments.length;if(d.fn){switch(d.once&&this.removeListener(e,d.fn,void 0,!0),f){case 1:return d.fn.call(d.context),!0;case 2:return d.fn.call(d.context,t),!0;case 3:return d.fn.call(d.context,t,r),!0;case 4:return d.fn.call(d.context,t,r,i),!0;case 5:return d.fn.call(d.context,t,r,i,n),!0;case 6:return d.fn.call(d.context,t,r,i,n,o),!0}for(u=1,l=new Array(f-1);u<f;u++)l[u-1]=arguments[u];d.fn.apply(d.context,l)}else{var c,h=d.length;for(u=0;u<h;u++)switch(d[u].once&&this.removeListener(e,d[u].fn,void 0,!0),f){case 1:d[u].fn.call(d[u].context);break;case 2:d[u].fn.call(d[u].context,t);break;case 3:d[u].fn.call(d[u].context,t,r);break;case 4:d[u].fn.call(d[u].context,t,r,i);break;default:if(!l)for(c=1,l=new Array(f-1);c<f;c++)l[c-1]=arguments[c];d[u].fn.apply(d[u].context,l)}}return!0},l.prototype.on=function(e,t,r){return o(this,e,t,r,!1)},l.prototype.once=function(e,t,r){return o(this,e,t,r,!0)},l.prototype.removeListener=function(e,t,r,i){var n=a?a+e:e;if(!this._events[n])return this;if(!t)return s(this,n),this;var o=this._events[n];if(o.fn)o.fn!==t||i&&!o.once||r&&o.context!==r||s(this,n);else{for(var l=0,u=[],d=o.length;l<d;l++)(o[l].fn!==t||i&&!o[l].once||r&&o[l].context!==r)&&u.push(o[l]);u.length?this._events[n]=1===u.length?u[0]:u:s(this,n)}return this},l.prototype.removeAllListeners=function(e){var t;return e?(t=a?a+e:e,this._events[t]&&s(this,t)):(this._events=new n,this._eventsCount=0),this},l.prototype.off=l.prototype.removeListener,l.prototype.addListener=l.prototype.on,l.prefixed=a,l.EventEmitter=l,e.exports=l},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){return e&&e.__esModule?e:{default:e}}(r(1));var n=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t}return i(e,[{key:"destroy",value:function(){}},{key:"resetTimeStamp",value:function(){}},{key:"resetInitSegment",value:function(){}},{key:"remux",value:function(e,t,r,i,n,o,s,l){var u=this.observer,d="";e&&(d+="audio"),t&&(d+="video"),u.trigger(a.default.FRAG_PARSING_DATA,{data1:l,startPTS:n,startDTS:n,type:d,hasAudio:!!e,hasVideo:!!t,nb:1,dropped:0}),u.trigger(a.default.FRAG_PARSED)}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=Math.pow(2,32)-1,n=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"init",value:function(){e.types={avc1:[],avcC:[],btrt:[],dinf:[],dref:[],esds:[],ftyp:[],hdlr:[],mdat:[],mdhd:[],mdia:[],mfhd:[],minf:[],moof:[],moov:[],mp4a:[],".mp3":[],mvex:[],mvhd:[],pasp:[],sdtp:[],stbl:[],stco:[],stsc:[],stsd:[],stsz:[],stts:[],tfdt:[],tfhd:[],traf:[],trak:[],trun:[],trex:[],tkhd:[],vmhd:[],smhd:[]};var t=void 0;for(t in e.types)e.types.hasOwnProperty(t)&&(e.types[t]=[t.charCodeAt(0),t.charCodeAt(1),t.charCodeAt(2),t.charCodeAt(3)]);var r=new Uint8Array([0,0,0,0,0,0,0,0,118,105,100,101,0,0,0,0,0,0,0,0,0,0,0,0,86,105,100,101,111,72,97,110,100,108,101,114,0]),i=new Uint8Array([0,0,0,0,0,0,0,0,115,111,117,110,0,0,0,0,0,0,0,0,0,0,0,0,83,111,117,110,100,72,97,110,100,108,101,114,0]);e.HDLR_TYPES={video:r,audio:i};var a=new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,12,117,114,108,32,0,0,0,1]),n=new Uint8Array([0,0,0,0,0,0,0,0]);e.STTS=e.STSC=e.STCO=n,e.STSZ=new Uint8Array([0,0,0,0,0,0,0,0,0,0,0,0]),e.VMHD=new Uint8Array([0,0,0,1,0,0,0,0,0,0,0,0]),e.SMHD=new Uint8Array([0,0,0,0,0,0,0,0]),e.STSD=new Uint8Array([0,0,0,0,0,0,0,1]);var o=new Uint8Array([105,115,111,109]),s=new Uint8Array([97,118,99,49]),l=new Uint8Array([0,0,0,1]);e.FTYP=e.box(e.types.ftyp,o,l,o,s),e.DINF=e.box(e.types.dinf,e.box(e.types.dref,a))}},{key:"box",value:function(e){for(var t=Array.prototype.slice.call(arguments,1),r=8,i=t.length,a=i,n=void 0;i--;)r+=t[i].byteLength;for((n=new Uint8Array(r))[0]=r>>24&255,n[1]=r>>16&255,n[2]=r>>8&255,n[3]=255&r,n.set(e,4),i=0,r=8;i<a;i++)n.set(t[i],r),r+=t[i].byteLength;return n}},{key:"hdlr",value:function(t){return e.box(e.types.hdlr,e.HDLR_TYPES[t])}},{key:"mdat",value:function(t){return e.box(e.types.mdat,t)}},{key:"mdhd",value:function(t,r){r*=t;var i=Math.floor(r/(a+1)),n=Math.floor(r%(a+1));return e.box(e.types.mdhd,new Uint8Array([1,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,t>>24&255,t>>16&255,t>>8&255,255&t,i>>24,i>>16&255,i>>8&255,255&i,n>>24,n>>16&255,n>>8&255,255&n,85,196,0,0]))}},{key:"mdia",value:function(t){return e.box(e.types.mdia,e.mdhd(t.timescale,t.duration),e.hdlr(t.type),e.minf(t))}},{key:"mfhd",value:function(t){return e.box(e.types.mfhd,new Uint8Array([0,0,0,0,t>>24,t>>16&255,t>>8&255,255&t]))}},{key:"minf",value:function(t){return"audio"===t.type?e.box(e.types.minf,e.box(e.types.smhd,e.SMHD),e.DINF,e.stbl(t)):e.box(e.types.minf,e.box(e.types.vmhd,e.VMHD),e.DINF,e.stbl(t))}},{key:"moof",value:function(t,r,i){return e.box(e.types.moof,e.mfhd(t),e.traf(i,r))}},{key:"moov",value:function(t){for(var r=t.length,i=[];r--;)i[r]=e.trak(t[r]);return e.box.apply(null,[e.types.moov,e.mvhd(t[0].timescale,t[0].duration)].concat(i).concat(e.mvex(t)))}},{key:"mvex",value:function(t){for(var r=t.length,i=[];r--;)i[r]=e.trex(t[r]);return e.box.apply(null,[e.types.mvex].concat(i))}},{key:"mvhd",value:function(t,r){r*=t;var i=Math.floor(r/(a+1)),n=Math.floor(r%(a+1)),o=new Uint8Array([1,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,t>>24&255,t>>16&255,t>>8&255,255&t,i>>24,i>>16&255,i>>8&255,255&i,n>>24,n>>16&255,n>>8&255,255&n,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,64,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,255,255,255,255]);return e.box(e.types.mvhd,o)}},{key:"sdtp",value:function(t){var r=t.samples||[],i=new Uint8Array(4+r.length),a=void 0,n=void 0;for(n=0;n<r.length;n++)a=r[n].flags,i[n+4]=a.dependsOn<<4|a.isDependedOn<<2|a.hasRedundancy;return e.box(e.types.sdtp,i)}},{key:"stbl",value:function(t){return e.box(e.types.stbl,e.stsd(t),e.box(e.types.stts,e.STTS),e.box(e.types.stsc,e.STSC),e.box(e.types.stsz,e.STSZ),e.box(e.types.stco,e.STCO))}},{key:"avc1",value:function(t){var r=[],i=[],a=void 0,n=void 0,o=void 0;for(a=0;a<t.sps.length;a++)o=(n=t.sps[a]).byteLength,r.push(o>>>8&255),r.push(255&o),r=r.concat(Array.prototype.slice.call(n));for(a=0;a<t.pps.length;a++)o=(n=t.pps[a]).byteLength,i.push(o>>>8&255),i.push(255&o),i=i.concat(Array.prototype.slice.call(n));var s=e.box(e.types.avcC,new Uint8Array([1,r[3],r[4],r[5],255,224|t.sps.length].concat(r).concat([t.pps.length]).concat(i))),l=t.width,u=t.height,d=t.pixelRatio[0],f=t.pixelRatio[1];return e.box(e.types.avc1,new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,l>>8&255,255&l,u>>8&255,255&u,0,72,0,0,0,72,0,0,0,0,0,0,0,1,18,100,97,105,108,121,109,111,116,105,111,110,47,104,108,115,46,106,115,0,0,0,0,0,0,0,0,0,0,0,0,0,0,24,17,17]),s,e.box(e.types.btrt,new Uint8Array([0,28,156,128,0,45,198,192,0,45,198,192])),e.box(e.types.pasp,new Uint8Array([d>>24,d>>16&255,d>>8&255,255&d,f>>24,f>>16&255,f>>8&255,255&f])))}},{key:"esds",value:function(e){var t=e.config.length;return new Uint8Array([0,0,0,0,3,23+t,0,1,0,4,15+t,64,21,0,0,0,0,0,0,0,0,0,0,0,5].concat([t]).concat(e.config).concat([6,1,2]))}},{key:"mp4a",value:function(t){var r=t.samplerate;return e.box(e.types.mp4a,new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,t.channelCount,0,16,0,0,0,0,r>>8&255,255&r,0,0]),e.box(e.types.esds,e.esds(t)))}},{key:"mp3",value:function(t){var r=t.samplerate;return e.box(e.types[".mp3"],new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,t.channelCount,0,16,0,0,0,0,r>>8&255,255&r,0,0]))}},{key:"stsd",value:function(t){return"audio"===t.type?t.isAAC||"mp3"!==t.codec?e.box(e.types.stsd,e.STSD,e.mp4a(t)):e.box(e.types.stsd,e.STSD,e.mp3(t)):e.box(e.types.stsd,e.STSD,e.avc1(t))}},{key:"tkhd",value:function(t){var r=t.id,i=t.duration*t.timescale,n=t.width,o=t.height,s=Math.floor(i/(a+1)),l=Math.floor(i%(a+1));return e.box(e.types.tkhd,new Uint8Array([1,0,0,7,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,r>>24&255,r>>16&255,r>>8&255,255&r,0,0,0,0,s>>24,s>>16&255,s>>8&255,255&s,l>>24,l>>16&255,l>>8&255,255&l,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,64,0,0,0,n>>8&255,255&n,0,0,o>>8&255,255&o,0,0]))}},{key:"traf",value:function(t,r){var i=e.sdtp(t),n=t.id,o=Math.floor(r/(a+1)),s=Math.floor(r%(a+1));return e.box(e.types.traf,e.box(e.types.tfhd,new Uint8Array([0,0,0,0,n>>24,n>>16&255,n>>8&255,255&n])),e.box(e.types.tfdt,new Uint8Array([1,0,0,0,o>>24,o>>16&255,o>>8&255,255&o,s>>24,s>>16&255,s>>8&255,255&s])),e.trun(t,i.length+16+20+8+16+8+8),i)}},{key:"trak",value:function(t){return t.duration=t.duration||4294967295,e.box(e.types.trak,e.tkhd(t),e.mdia(t))}},{key:"trex",value:function(t){var r=t.id;return e.box(e.types.trex,new Uint8Array([0,0,0,0,r>>24,r>>16&255,r>>8&255,255&r,0,0,0,1,0,0,0,0,0,0,0,0,0,1,0,1]))}},{key:"trun",value:function(t,r){var i=t.samples||[],a=i.length,n=12+16*a,o=new Uint8Array(n),s=void 0,l=void 0,u=void 0,d=void 0,f=void 0,c=void 0;for(r+=8+n,o.set([0,0,15,1,a>>>24&255,a>>>16&255,a>>>8&255,255&a,r>>>24&255,r>>>16&255,r>>>8&255,255&r],0),s=0;s<a;s++)u=(l=i[s]).duration,d=l.size,f=l.flags,c=l.cts,o.set([u>>>24&255,u>>>16&255,u>>>8&255,255&u,d>>>24&255,d>>>16&255,d>>>8&255,255&d,f.isLeading<<2|f.dependsOn,f.isDependedOn<<6|f.hasRedundancy<<4|f.paddingValue<<1|f.isNonSync,61440&f.degradPrio,15&f.degradPrio,c>>>24&255,c>>>16&255,c>>>8&255,255&c],12+16*s);return e.box(e.types.trun,o)}},{key:"initSegment",value:function(t){e.types||e.init();var r=e.moov(t),i=void 0;return(i=new Uint8Array(e.FTYP.byteLength+r.byteLength)).set(e.FTYP),i.set(r,e.FTYP.byteLength),i}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"getSilentFrame",value:function(e,t){switch(e){case"mp4a.40.2":if(1===t)return new Uint8Array([0,200,0,128,35,128]);if(2===t)return new Uint8Array([33,0,73,144,2,25,0,35,128]);if(3===t)return new Uint8Array([0,200,0,128,32,132,1,38,64,8,100,0,142]);if(4===t)return new Uint8Array([0,200,0,128,32,132,1,38,64,8,100,0,128,44,128,8,2,56]);if(5===t)return new Uint8Array([0,200,0,128,32,132,1,38,64,8,100,0,130,48,4,153,0,33,144,2,56]);if(6===t)return new Uint8Array([0,200,0,128,32,132,1,38,64,8,100,0,130,48,4,153,0,33,144,2,0,178,0,32,8,224]);break;default:if(1===t)return new Uint8Array([1,64,34,128,163,78,230,128,186,8,0,0,0,28,6,241,193,10,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,94]);if(2===t)return new Uint8Array([1,64,34,128,163,94,230,128,186,8,0,0,0,0,149,0,6,241,161,10,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,94]);if(3===t)return new Uint8Array([1,64,34,128,163,94,230,128,186,8,0,0,0,0,149,0,6,241,161,10,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,90,94])}return null}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=u(r(60)),n=u(r(59)),o=u(r(1)),s=r(2),l=r(0);function u(e){return e&&e.__esModule?e:{default:e}}var d=function(){function e(t,r,i,a){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.config=r,this.typeSupported=i;var n=navigator.userAgent;this.isSafari=a&&a.indexOf("Apple")>-1&&n&&!n.match("CriOS"),this.ISGenerated=!1}return i(e,[{key:"destroy",value:function(){}},{key:"resetTimeStamp",value:function(e){this._initPTS=this._initDTS=e}},{key:"resetInitSegment",value:function(){this.ISGenerated=!1}},{key:"remux",value:function(e,t,r,i,a,n,s){if(this.ISGenerated||this.generateIS(e,t,a),this.ISGenerated){var u=e.samples.length,d=t.samples.length,f=a,c=a;if(u&&d){var h=(e.samples[0].pts-t.samples[0].pts)/t.inputTimeScale;f+=Math.max(0,h),c+=Math.max(0,-h)}if(u){e.timescale||(l.logger.warn("regenerate InitSegment as audio detected"),this.generateIS(e,t,a));var v=this.remuxAudio(e,f,n,s);if(d){var g=void 0;v&&(g=v.endPTS-v.startPTS),t.timescale||(l.logger.warn("regenerate InitSegment as video detected"),this.generateIS(e,t,a)),this.remuxVideo(t,c,n,g,s)}}else if(d){var p=this.remuxVideo(t,c,n,0,s);p&&e.codec&&this.remuxEmptyAudio(e,f,n,p)}}r.samples.length&&this.remuxID3(r,a),i.samples.length&&this.remuxText(i,a),this.observer.trigger(o.default.FRAG_PARSED)}},{key:"generateIS",value:function(e,t,r){var i=this.observer,a=e.samples,u=t.samples,d=this.typeSupported,f="audio/mp4",c={},h={tracks:c},v=void 0===this._initPTS,g=void 0,p=void 0;if(v&&(g=p=1/0),e.config&&a.length&&(e.timescale=e.samplerate,l.logger.log("audio sampling rate : "+e.samplerate),e.isAAC||(d.mpeg?(f="audio/mpeg",e.codec=""):d.mp3&&(e.codec="mp3")),c.audio={container:f,codec:e.codec,initSegment:!e.isAAC&&d.mpeg?new Uint8Array:n.default.initSegment([e]),metadata:{channelCount:e.channelCount}},v&&(g=p=a[0].pts-e.inputTimeScale*r)),t.sps&&t.pps&&u.length){var y=t.inputTimeScale;t.timescale=y,c.video={container:"video/mp4",codec:t.codec,initSegment:n.default.initSegment([t]),metadata:{width:t.width,height:t.height}},v&&(g=Math.min(g,u[0].pts-y*r),p=Math.min(p,u[0].dts-y*r),this.observer.trigger(o.default.INIT_PTS_FOUND,{initPTS:g}))}Object.keys(c).length?(i.trigger(o.default.FRAG_PARSING_INIT_SEGMENT,h),this.ISGenerated=!0,v&&(this._initPTS=g,this._initDTS=p)):i.trigger(o.default.ERROR,{type:s.ErrorTypes.MEDIA_ERROR,details:s.ErrorDetails.FRAG_PARSING_ERROR,fatal:!1,reason:"no audio/video samples found"})}},{key:"remuxVideo",value:function(e,t,r,i,a){var u,d,f,c=8,h=void 0,v=void 0,g=void 0,p=void 0,y=e.timescale,m=e.samples,b=[],E=m.length,_=this._PTSNormalize,T=this._initPTS,S=this.nextAvcDts,k=this.isSafari;if(0!==E){k&&(r|=m.length&&S&&(a&&Math.abs(t-S/y)<.1||Math.abs(m[0].pts-S-T)<y/5)),r||(S=t*y),m.forEach(function(e){e.pts=_(e.pts-T,S),e.dts=_(e.dts-T,S)}),m.sort(function(e,t){var r=e.dts-t.dts,i=e.pts-t.pts;return r||i||e.id-t.id});var R=m.reduce(function(e,t){return Math.max(Math.min(e,t.pts-t.dts),-18e3)},0);if(R<0){l.logger.warn("PTS < DTS detected in video samples, shifting DTS by "+Math.round(R/90)+" ms to overcome this issue");for(var A=0;A<m.length;A++)m[A].dts+=R}var w=m[0];p=Math.max(w.dts,0),g=Math.max(w.pts,0);var O=Math.round((p-S)/90);r&&O&&(O>1?l.logger.log("AVC:"+O+" ms hole between fragments detected,filling it"):O<-1&&l.logger.log("AVC:"+-O+" ms overlapping between fragments detected"),p=S,m[0].dts=p,g=Math.max(g-O,S),m[0].pts=g,l.logger.log("Video/PTS/DTS adjusted: "+Math.round(g/90)+"/"+Math.round(p/90)+",delta:"+O+" ms")),w=m[m.length-1],f=Math.max(w.dts,0),d=Math.max(w.pts,0,f),k&&(h=Math.round((f-p)/(m.length-1)));for(var L=0,D=0,P=0;P<E;P++){for(var I=m[P],C=I.units,x=C.length,M=0,F=0;F<x;F++)M+=C[F].data.length;D+=M,L+=x,I.length=M,I.dts=k?p+P*h:Math.max(I.dts,p),I.pts=Math.max(I.pts,I.dts)}var N=D+4*L+8;try{v=new Uint8Array(N)}catch(e){return void this.observer.trigger(o.default.ERROR,{type:s.ErrorTypes.MUX_ERROR,details:s.ErrorDetails.REMUX_ALLOC_ERROR,fatal:!1,bytes:N,reason:"fail allocating video mdat "+N})}var U=new DataView(v.buffer);U.setUint32(0,N),v.set(n.default.types.mdat,4);for(var B=0;B<E;B++){for(var G=m[B],j=G.units,K=0,H=void 0,V=0,W=j.length;V<W;V++){var Y=j[V],q=Y.data,X=Y.data.byteLength;U.setUint32(c,X),c+=4,v.set(q,c),c+=X,K+=4+X}if(k)H=Math.max(0,h*Math.round((G.pts-G.dts)/h));else{if(B<E-1)h=m[B+1].dts-G.dts;else{var z=this.config,Q=G.dts-m[B>0?B-1:B].dts;if(z.stretchShortVideoTrack){var $=z.maxBufferHole,J=Math.floor($*y),Z=(i?g+i*y:this.nextAudioPts)-G.pts;Z>J?((h=Z-Q)<0&&(h=Q),l.logger.log("It is approximately "+Z/90+" ms to the next segment; using duration "+h/90+" ms for the last video frame.")):h=Q}else h=Q}H=Math.round(G.pts-G.dts)}b.push({size:K,duration:h,cts:H,flags:{isLeading:0,isDependedOn:0,hasRedundancy:0,degradPrio:0,dependsOn:G.key?2:1,isNonSync:G.key?0:1}})}this.nextAvcDts=f+h;var ee=e.dropped;if(e.len=0,e.nbNalu=0,e.dropped=0,b.length&&navigator.userAgent.toLowerCase().indexOf("chrome")>-1){var te=b[0].flags;te.dependsOn=2,te.isNonSync=0}e.samples=b,u=n.default.moof(e.sequenceNumber++,p,e),e.samples=[];var re={data1:u,data2:v,startPTS:g/y,endPTS:(d+h)/y,startDTS:p/y,endDTS:this.nextAvcDts/y,type:"video",hasAudio:!1,hasVideo:!0,nb:b.length,dropped:ee};return this.observer.trigger(o.default.FRAG_PARSING_DATA,re),re}}},{key:"remuxAudio",value:function(e,t,r,i){var u=e.inputTimeScale,d=e.timescale,f=u/d,c=(e.isAAC?1024:1152)*f,h=this._PTSNormalize,v=this._initPTS,g=!e.isAAC&&this.typeSupported.mpeg,p=void 0,y=void 0,m=void 0,b=void 0,E=void 0,_=void 0,T=void 0,S=e.samples,k=[],R=this.nextAudioPts;if(r|=S.length&&R&&(i&&Math.abs(t-R/u)<.1||Math.abs(S[0].pts-R-v)<20*c),S.forEach(function(e){e.pts=e.dts=h(e.pts-v,t*u)}),0!==(S=S.filter(function(e){return e.pts>=0})).length){if(r||(R=i?t*u:S[0].pts),e.isAAC)for(var A=this.config.maxAudioFramesDrift,w=0,O=R;w<S.length;){var L,D=S[w];L=D.pts-O;var P=Math.abs(1e3*L/u);if(L<=-A*c)l.logger.warn("Dropping 1 audio frame @ "+(O/u).toFixed(3)+"s due to "+Math.round(P)+" ms overlap."),S.splice(w,1),e.len-=D.unit.length;else if(L>=A*c&&P<1e4&&O){var I=Math.round(L/c);l.logger.warn("Injecting "+I+" audio frame @ "+(O/u).toFixed(3)+"s due to "+Math.round(1e3*L/u)+" ms gap.");for(var C=0;C<I;C++){var x=Math.max(O,0);(m=a.default.getSilentFrame(e.manifestCodec||e.codec,e.channelCount))||(l.logger.log("Unable to get silent frame for given audio codec; duplicating last frame instead."),m=D.unit.subarray()),S.splice(w,0,{unit:m,pts:x,dts:x}),e.len+=m.length,O+=c,w++}D.pts=D.dts=O,O+=c,w++}else Math.abs(L),D.pts=D.dts=O,O+=c,w++}for(var M=0,F=S.length;M<F;M++){var N=S[M],U=N.unit,B=N.pts;if(void 0!==T)y.duration=Math.round((B-T)/f);else{var G=Math.round(1e3*(B-R)/u),j=0;if(r&&e.isAAC&&G){if(G>0&&G<1e4)j=Math.round((B-R)/c),l.logger.log(G+" ms hole between AAC samples detected,filling it"),j>0&&((m=a.default.getSilentFrame(e.manifestCodec||e.codec,e.channelCount))||(m=U.subarray()),e.len+=j*m.length);else if(G<-12){l.logger.log("drop overlapping AAC sample, expected/parsed/delta:"+(R/u).toFixed(3)+"s/"+(B/u).toFixed(3)+"s/"+-G+"ms"),e.len-=U.byteLength;continue}B=R}if(_=B,!(e.len>0))return;var K=g?e.len:e.len+8;p=g?0:8;try{b=new Uint8Array(K)}catch(e){return void this.observer.trigger(o.default.ERROR,{type:s.ErrorTypes.MUX_ERROR,details:s.ErrorDetails.REMUX_ALLOC_ERROR,fatal:!1,bytes:K,reason:"fail allocating audio mdat "+K})}g||(new DataView(b.buffer).setUint32(0,K),b.set(n.default.types.mdat,4));for(var H=0;H<j;H++)(m=a.default.getSilentFrame(e.manifestCodec||e.codec,e.channelCount))||(l.logger.log("Unable to get silent frame for given audio codec; duplicating this frame instead."),m=U.subarray()),b.set(m,p),p+=m.byteLength,y={size:m.byteLength,cts:0,duration:1024,flags:{isLeading:0,isDependedOn:0,hasRedundancy:0,degradPrio:0,dependsOn:1}},k.push(y)}b.set(U,p);var V=U.byteLength;p+=V,y={size:V,cts:0,duration:0,flags:{isLeading:0,isDependedOn:0,hasRedundancy:0,degradPrio:0,dependsOn:1}},k.push(y),T=B}var W=0,Y=k.length;if(Y>=2&&(W=k[Y-2].duration,y.duration=W),Y){this.nextAudioPts=R=T+f*W,e.len=0,e.samples=k,E=g?new Uint8Array:n.default.moof(e.sequenceNumber++,_/f,e),e.samples=[];var q=_/u,X=R/u,z={data1:E,data2:b,startPTS:q,endPTS:X,startDTS:q,endDTS:X,type:"audio",hasAudio:!0,hasVideo:!1,nb:Y};return this.observer.trigger(o.default.FRAG_PARSING_DATA,z),z}return null}}},{key:"remuxEmptyAudio",value:function(e,t,r,i){var n=e.inputTimeScale,o=n/(e.samplerate?e.samplerate:n),s=this.nextAudioPts,u=(void 0!==s?s:i.startDTS*n)+this._initDTS,d=i.endDTS*n+this._initDTS,f=1024*o,c=Math.ceil((d-u)/f),h=a.default.getSilentFrame(e.manifestCodec||e.codec,e.channelCount);if(l.logger.warn("remux empty Audio"),h){for(var v=[],g=0;g<c;g++){var p=u+g*f;v.push({unit:h,pts:p,dts:p}),e.len+=h.length}e.samples=v,this.remuxAudio(e,t,r)}else l.logger.trace("Unable to remuxEmptyAudio since we were unable to get a silent frame for given audio codec!")}},{key:"remuxID3",value:function(e){var t=e.samples.length,r=void 0,i=e.inputTimeScale,a=this._initPTS,n=this._initDTS;if(t){for(var s=0;s<t;s++)(r=e.samples[s]).pts=(r.pts-a)/i,r.dts=(r.dts-n)/i;this.observer.trigger(o.default.FRAG_PARSING_METADATA,{samples:e.samples})}e.samples=[]}},{key:"remuxText",value:function(e){e.samples.sort(function(e,t){return e.pts-t.pts});var t=e.samples.length,r=void 0,i=e.inputTimeScale,a=this._initPTS;if(t){for(var n=0;n<t;n++)(r=e.samples[n]).pts=(r.pts-a)/i;this.observer.trigger(o.default.FRAG_PARSING_USERDATA,{samples:e.samples})}e.samples=[]}},{key:"_PTSNormalize",value:function(e,t){var r=void 0;if(void 0===t)return e;for(r=t<e?-8589934592:8589934592;Math.abs(e-t)>4294967296;)e+=r;return e}}]),e}();t.default=d,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=s(r(8)),n=r(0),o=s(r(22));function s(e){return e&&e.__esModule?e:{default:e}}var l=function(){function e(t,r,i){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.config=i,this.remuxer=r}return i(e,[{key:"resetInitSegment",value:function(e,t,r,i){this._audioTrack={container:"audio/mpeg",type:"audio",id:-1,sequenceNumber:0,isAAC:!1,samples:[],len:0,manifestCodec:t,duration:i,inputTimeScale:9e4}}},{key:"resetTimeStamp",value:function(){}},{key:"append",value:function(e,t,r,i){for(var n=a.default.getID3Data(e,0),s=a.default.getTimeStamp(n),l=s?90*s:9e4*t,u=n.length,d=e.length,f=0,c=0,h=this._audioTrack,v=[{pts:l,dts:l,data:n}];u<d;)if(o.default.isHeader(e,u)){var g=o.default.appendFrame(h,e,u,l,f);if(!g)break;u+=g.length,c=g.sample.pts,f++}else a.default.isHeader(e,u)?(n=a.default.getID3Data(e,u),v.push({pts:c,dts:c,data:n}),u+=n.length):u++;this.remuxer.remux(h,{samples:[]},{samples:v,inputTimeScale:9e4},{samples:[]},t,r,i)}},{key:"destroy",value:function(){}}],[{key:"probe",value:function(e){var t=void 0,r=void 0,i=a.default.getID3Data(e,0);if(i&&void 0!==a.default.getTimeStamp(i))for(t=i.length,r=Math.min(e.length-1,t+100);t<r;t++)if(o.default.probe(e,t))return n.logger.log("MPEG Audio sync word found !"),!0;return!1}}]),e}();t.default=l,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){return e&&e.__esModule?e:{default:e}}(r(13));var n=function(){function e(t,r,i,n){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.decryptdata=i,this.discardEPB=n,this.decrypter=new a.default(t,r,{removePKCS7Padding:!1})}return i(e,[{key:"decryptBuffer",value:function(e,t){this.decrypter.decrypt(e,this.decryptdata.key.buffer,this.decryptdata.iv.buffer,t)}},{key:"decryptAacSample",value:function(e,t,r,i){var a=e[t].unit,n=a.subarray(16,a.length-a.length%16),o=n.buffer.slice(n.byteOffset,n.byteOffset+n.length),s=this;this.decryptBuffer(o,function(n){n=new Uint8Array(n),a.set(n,16),i||s.decryptAacSamples(e,t+1,r)})}},{key:"decryptAacSamples",value:function(e,t,r){for(;;t++){if(t>=e.length)return void r();if(!(e[t].unit.length<32)){var i=this.decrypter.isSync();if(this.decryptAacSample(e,t,r,i),!i)return}}}},{key:"getAvcEncryptedData",value:function(e){for(var t=16*Math.floor((e.length-48)/160)+16,r=new Int8Array(t),i=0,a=32;a<=e.length-16;a+=160,i+=16)r.set(e.subarray(a,a+16),i);return r}},{key:"getAvcDecryptedUnit",value:function(e,t){t=new Uint8Array(t);for(var r=0,i=32;i<=e.length-16;i+=160,r+=16)e.set(t.subarray(r,r+16),i);return e}},{key:"decryptAvcSample",value:function(e,t,r,i,a,n){var o=this.discardEPB(a.data),s=this.getAvcEncryptedData(o),l=this;this.decryptBuffer(s.buffer,function(s){a.data=l.getAvcDecryptedUnit(o,s),n||l.decryptAvcSamples(e,t,r+1,i)})}},{key:"decryptAvcSamples",value:function(e,t,r,i){for(;;t++,r=0){if(t>=e.length)return void i();for(var a=e[t].units;!(r>=a.length);r++){var n=a[r];if(!(n.length<=48||1!==n.type&&5!==n.type)){var o=this.decrypter.isSync();if(this.decryptAvcSample(e,t,r,i,n,o),!o)return}}}}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=r(0);var n=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.data=t,this.bytesAvailable=t.byteLength,this.word=0,this.bitsAvailable=0}return i(e,[{key:"loadWord",value:function(){var e=this.data,t=this.bytesAvailable,r=e.byteLength-t,i=new Uint8Array(4),a=Math.min(4,t);if(0===a)throw new Error("no bytes available");i.set(e.subarray(r,r+a)),this.word=new DataView(i.buffer).getUint32(0),this.bitsAvailable=8*a,this.bytesAvailable-=a}},{key:"skipBits",value:function(e){var t=void 0;this.bitsAvailable>e?(this.word<<=e,this.bitsAvailable-=e):(e-=this.bitsAvailable,e-=(t=e>>3)>>3,this.bytesAvailable-=t,this.loadWord(),this.word<<=e,this.bitsAvailable-=e)}},{key:"readBits",value:function(e){var t=Math.min(this.bitsAvailable,e),r=this.word>>>32-t;return e>32&&a.logger.error("Cannot read more than 32 bits at a time"),this.bitsAvailable-=t,this.bitsAvailable>0?this.word<<=t:this.bytesAvailable>0&&this.loadWord(),(t=e-t)>0&&this.bitsAvailable?r<<t|this.readBits(t):r}},{key:"skipLZ",value:function(){var e=void 0;for(e=0;e<this.bitsAvailable;++e)if(0!=(this.word&2147483648>>>e))return this.word<<=e,this.bitsAvailable-=e,e;return this.loadWord(),e+this.skipLZ()}},{key:"skipUEG",value:function(){this.skipBits(1+this.skipLZ())}},{key:"skipEG",value:function(){this.skipBits(1+this.skipLZ())}},{key:"readUEG",value:function(){var e=this.skipLZ();return this.readBits(e+1)-1}},{key:"readEG",value:function(){var e=this.readUEG();return 1&e?1+e>>>1:-1*(e>>>1)}},{key:"readBoolean",value:function(){return 1===this.readBits(1)}},{key:"readUByte",value:function(){return this.readBits(8)}},{key:"readUShort",value:function(){return this.readBits(16)}},{key:"readUInt",value:function(){return this.readBits(32)}},{key:"skipScalingList",value:function(e){var t=8,r=8,i=void 0;for(i=0;i<e;i++)0!==r&&(r=(t+this.readEG()+256)%256),t=0===r?t:r}},{key:"readSPS",value:function(){var e,t,r,i,a=0,n=0,o=0,s=0,l=void 0,u=void 0,d=void 0,f=this.readUByte.bind(this),c=this.readBits.bind(this),h=this.readUEG.bind(this),v=this.readBoolean.bind(this),g=this.skipBits.bind(this),p=this.skipEG.bind(this),y=this.skipUEG.bind(this),m=this.skipScalingList.bind(this);if(f(),e=f(),c(5),g(3),f(),y(),100===e||110===e||122===e||244===e||44===e||83===e||86===e||118===e||128===e){var b=h();if(3===b&&g(1),y(),y(),g(1),v())for(u=3!==b?8:12,d=0;d<u;d++)v()&&m(d<6?16:64)}y();var E=h();if(0===E)h();else if(1===E)for(g(1),p(),p(),l=h(),d=0;d<l;d++)p();y(),g(1),t=h(),r=h(),0===(i=c(1))&&g(1),g(1),v()&&(a=h(),n=h(),o=h(),s=h());var _=[1,1];if(v()&&v())switch(f()){case 1:_=[1,1];break;case 2:_=[12,11];break;case 3:_=[10,11];break;case 4:_=[16,11];break;case 5:_=[40,33];break;case 6:_=[24,11];break;case 7:_=[20,11];break;case 8:_=[32,11];break;case 9:_=[80,33];break;case 10:_=[18,11];break;case 11:_=[15,11];break;case 12:_=[64,33];break;case 13:_=[160,99];break;case 14:_=[4,3];break;case 15:_=[3,2];break;case 16:_=[2,1];break;case 255:_=[f()<<8|f(),f()<<8|f()]}return{width:Math.ceil(16*(t+1)-2*a-2*n),height:(2-i)*(r+1)*16-(i?2:4)*(o+s),pixelRatio:_}}},{key:"readSliceType",value:function(){return this.readUByte(),this.readUEG(),this.readUEG()}}]),e}();t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(23)),n=f(r(22)),o=f(r(1)),s=f(r(64)),l=f(r(63)),u=r(0),d=r(2);function f(e){return e&&e.__esModule?e:{default:e}}var c={video:1,audio:2,id3:3,text:4},h=function(){function e(t,r,i,a){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.config=i,this.typeSupported=a,this.remuxer=r,this.sampleAes=null}return i(e,[{key:"setDecryptData",value:function(e){null!=e&&null!=e.key&&"SAMPLE-AES"===e.method?this.sampleAes=new l.default(this.observer,this.config,e,this.discardEPB):this.sampleAes=null}},{key:"resetInitSegment",value:function(t,r,i,a){this.pmtParsed=!1,this._pmtId=-1,this._avcTrack=e.createTrack("video",a),this._audioTrack=e.createTrack("audio",a),this._id3Track=e.createTrack("id3",a),this._txtTrack=e.createTrack("text",a),this.aacOverFlow=null,this.aacLastPTS=null,this.avcSample=null,this.audioCodec=r,this.videoCodec=i,this._duration=a}},{key:"resetTimeStamp",value:function(){}},{key:"append",value:function(t,r,i,a){var n=void 0,s=t.length,l=void 0,f=void 0,c=void 0,h=void 0,v=!1;this.contiguous=i;var g=this.pmtParsed,p=this._avcTrack,y=this._audioTrack,m=this._id3Track,b=p.pid,E=y.pid,_=m.pid,T=this._pmtId,S=p.pesData,k=y.pesData,R=m.pesData,A=this._parsePAT,w=this._parsePMT,O=this._parsePES,L=this._parseAVCPES.bind(this),D=this._parseAACPES.bind(this),P=this._parseMPEGPES.bind(this),I=this._parseID3PES.bind(this),C=e._syncOffset(t);for(s-=(s+C)%188,n=C;n<s;n+=188)if(71===t[n]){if(l=!!(64&t[n+1]),f=((31&t[n+1])<<8)+t[n+2],(48&t[n+3])>>4>1){if((c=n+5+t[n+4])===n+188)continue}else c=n+4;switch(f){case b:l&&(S&&(h=O(S))&&void 0!==h.pts&&L(h,!1),S={data:[],size:0}),S&&(S.data.push(t.subarray(c,n+188)),S.size+=n+188-c);break;case E:l&&(k&&(h=O(k))&&void 0!==h.pts&&(y.isAAC?D(h):P(h)),k={data:[],size:0}),k&&(k.data.push(t.subarray(c,n+188)),k.size+=n+188-c);break;case _:l&&(R&&(h=O(R))&&void 0!==h.pts&&I(h),R={data:[],size:0}),R&&(R.data.push(t.subarray(c,n+188)),R.size+=n+188-c);break;case 0:l&&(c+=t[c]+1),T=this._pmtId=A(t,c);break;case T:l&&(c+=t[c]+1);var x=w(t,c,!0===this.typeSupported.mpeg||!0===this.typeSupported.mp3,null!=this.sampleAes);(b=x.avc)>0&&(p.pid=b),(E=x.audio)>0&&(y.pid=E,y.isAAC=x.isAAC),(_=x.id3)>0&&(m.pid=_),v&&!g&&(u.logger.log("reparse from beginning"),v=!1,n=C-188),g=this.pmtParsed=!0;break;case 17:case 8191:break;default:v=!0}}else this.observer.trigger(o.default.ERROR,{type:d.ErrorTypes.MEDIA_ERROR,details:d.ErrorDetails.FRAG_PARSING_ERROR,fatal:!1,reason:"TS packet did not start with 0x47"});S&&(h=O(S))&&void 0!==h.pts?(L(h,!0),p.pesData=null):p.pesData=S,k&&(h=O(k))&&void 0!==h.pts?(y.isAAC?D(h):P(h),y.pesData=null):(k&&k.size&&u.logger.log("last AAC PES packet truncated,might overlap between fragments"),y.pesData=k),R&&(h=O(R))&&void 0!==h.pts?(I(h),m.pesData=null):m.pesData=R,null==this.sampleAes?this.remuxer.remux(y,p,m,this._txtTrack,r,i,a):this.decryptAndRemux(y,p,m,this._txtTrack,r,i,a)}},{key:"decryptAndRemux",value:function(e,t,r,i,a,n,o){if(e.samples&&e.isAAC){var s=this;this.sampleAes.decryptAacSamples(e.samples,0,function(){s.decryptAndRemuxAvc(e,t,r,i,a,n,o)})}else this.decryptAndRemuxAvc(e,t,r,i,a,n,o)}},{key:"decryptAndRemuxAvc",value:function(e,t,r,i,a,n,o){if(t.samples){var s=this;this.sampleAes.decryptAvcSamples(t.samples,0,0,function(){s.remuxer.remux(e,t,r,i,a,n,o)})}else this.remuxer.remux(e,t,r,i,a,n,o)}},{key:"destroy",value:function(){this._initPTS=this._initDTS=void 0,this._duration=0}},{key:"_parsePAT",value:function(e,t){return(31&e[t+10])<<8|e[t+11]}},{key:"_parsePMT",value:function(e,t,r,i){var a,n=void 0,o={audio:-1,avc:-1,id3:-1,isAAC:!0};for(a=t+3+((15&e[t+1])<<8|e[t+2])-4,t+=12+((15&e[t+10])<<8|e[t+11]);t<a;){switch(n=(31&e[t+1])<<8|e[t+2],e[t]){case 207:if(!i){u.logger.log("unkown stream type:"+e[t]);break}case 15:-1===o.audio&&(o.audio=n);break;case 21:-1===o.id3&&(o.id3=n);break;case 219:if(!i){u.logger.log("unkown stream type:"+e[t]);break}case 27:-1===o.avc&&(o.avc=n);break;case 3:case 4:r?-1===o.audio&&(o.audio=n,o.isAAC=!1):u.logger.log("MPEG audio found, not supported in this browser for now");break;case 36:u.logger.warn("HEVC stream type found, not supported for now");break;default:u.logger.log("unkown stream type:"+e[t])}t+=5+((15&e[t+3])<<8|e[t+4])}return o}},{key:"_parsePES",value:function(e){var t=0,r=void 0,i=void 0,a=void 0,n=void 0,o=void 0,s=void 0,l=void 0,d=void 0,f=e.data;if(!e||0===e.size)return null;for(;f[0].length<19&&f.length>1;){var c=new Uint8Array(f[0].length+f[1].length);c.set(f[0]),c.set(f[1],f[0].length),f[0]=c,f.splice(1,1)}if(1===((r=f[0])[0]<<16)+(r[1]<<8)+r[2]){if((a=(r[4]<<8)+r[5])&&a>e.size-6)return null;192&(i=r[7])&&((s=536870912*(14&r[9])+4194304*(255&r[10])+16384*(254&r[11])+128*(255&r[12])+(254&r[13])/2)>4294967295&&(s-=8589934592),64&i?((l=536870912*(14&r[14])+4194304*(255&r[15])+16384*(254&r[16])+128*(255&r[17])+(254&r[18])/2)>4294967295&&(l-=8589934592),s-l>54e5&&(u.logger.warn(Math.round((s-l)/9e4)+"s delta between PTS and DTS, align them"),s=l)):l=s),d=(n=r[8])+9,e.size-=d,o=new Uint8Array(e.size);for(var h=0,v=f.length;h<v;h++){var g=(r=f[h]).byteLength;if(d){if(d>g){d-=g;continue}r=r.subarray(d),g-=d,d=0}o.set(r,t),t+=g}return a&&(a-=n+3),{data:o,pts:s,dts:l,len:a}}return null}},{key:"pushAccesUnit",value:function(e,t){if(e.units.length&&e.frame){var r=t.samples,i=r.length;!this.config.forceKeyFrameOnDiscontinuity||!0===e.key||t.sps&&(i||this.contiguous)?(e.id=i,r.push(e)):t.dropped++}e.debug.length&&u.logger.log(e.pts+"/"+e.dts+":"+e.debug)}},{key:"_parseAVCPES",value:function(e,t){var r=this,i=this._avcTrack,a=this._parseAVCNALu(e.data),n=void 0,o=this.avcSample,l=void 0,u=!1,d=void 0,f=this.pushAccesUnit.bind(this),c=function(e,t,r,i){return{key:e,pts:t,dts:r,units:[],debug:i}};e.data=null,o&&a.length&&!i.audFound&&(f(o,i),o=this.avcSample=c(!1,e.pts,e.dts,"")),a.forEach(function(t){switch(t.type){case 1:l=!0,o||(o=r.avcSample=c(!0,e.pts,e.dts,"")),o.frame=!0;var a=t.data;if(u&&a.length>4){var h=new s.default(a).readSliceType();2!==h&&4!==h&&7!==h&&9!==h||(o.key=!0)}break;case 5:l=!0,o||(o=r.avcSample=c(!0,e.pts,e.dts,"")),o.key=!0,o.frame=!0;break;case 6:l=!0,(n=new s.default(r.discardEPB(t.data))).readUByte();for(var v=0,g=0,p=!1,y=0;!p&&n.bytesAvailable>1;){v=0;do{v+=y=n.readUByte()}while(255===y);g=0;do{g+=y=n.readUByte()}while(255===y);if(4===v&&0!==n.bytesAvailable){if(p=!0,181===n.readUByte())if(49===n.readUShort())if(1195456820===n.readUInt())if(3===n.readUByte()){var m=n.readUByte(),b=31&m,E=[m,n.readUByte()];for(d=0;d<b;d++)E.push(n.readUByte()),E.push(n.readUByte()),E.push(n.readUByte());r._insertSampleInOrder(r._txtTrack.samples,{type:3,pts:e.pts,bytes:E})}}else if(g<n.bytesAvailable)for(d=0;d<g;d++)n.readUByte()}break;case 7:if(l=!0,u=!0,!i.sps){var _=(n=new s.default(t.data)).readSPS();i.width=_.width,i.height=_.height,i.pixelRatio=_.pixelRatio,i.sps=[t.data],i.duration=r._duration;var T=t.data.subarray(1,4),S="avc1.";for(d=0;d<3;d++){var k=T[d].toString(16);k.length<2&&(k="0"+k),S+=k}i.codec=S}break;case 8:l=!0,i.pps||(i.pps=[t.data]);break;case 9:l=!1,i.audFound=!0,o&&f(o,i),o=r.avcSample=c(!1,e.pts,e.dts,"");break;case 12:l=!1;break;default:l=!1,o&&(o.debug+="unknown NAL "+t.type+" ")}o&&l&&o.units.push(t)}),t&&o&&(f(o,i),this.avcSample=null)}},{key:"_insertSampleInOrder",value:function(e,t){var r=e.length;if(r>0){if(t.pts>=e[r-1].pts)e.push(t);else for(var i=r-1;i>=0;i--)if(t.pts<e[i].pts){e.splice(i,0,t);break}}else e.push(t)}},{key:"_getLastNalUnit",value:function(){var e=this.avcSample,t=void 0;if(!e||0===e.units.length){var r=this._avcTrack.samples;e=r[r.length-1]}if(e){var i=e.units;t=i[i.length-1]}return t}},{key:"_parseAVCNALu",value:function(e){var t=0,r=e.byteLength,i=void 0,a=void 0,n=this._avcTrack,o=n.naluState||0,s=o,l=[],u=void 0,d=-1,f=void 0;for(-1===o&&(d=0,f=31&e[0],o=0,t=1);t<r;)if(i=e[t++],o)if(1!==o)if(i)if(1===i){if(d>=0)u={data:e.subarray(d,t-o-1),type:f},l.push(u);else{var c=this._getLastNalUnit();if(c&&(s&&t<=4-s&&c.state&&(c.data=c.data.subarray(0,c.data.byteLength-s)),(a=t-o-1)>0)){var h=new Uint8Array(c.data.byteLength+a);h.set(c.data,0),h.set(e.subarray(0,a),c.data.byteLength),c.data=h}}t<r?(d=t,f=31&e[t],o=0):o=-1}else o=0;else o=3;else o=i?0:2;else o=i?0:1;if(d>=0&&o>=0&&(u={data:e.subarray(d,r),type:f,state:o},l.push(u)),0===l.length){var v=this._getLastNalUnit();if(v){var g=new Uint8Array(v.data.byteLength+e.byteLength);g.set(v.data,0),g.set(e,v.data.byteLength),v.data=g}}return n.naluState=o,l}},{key:"discardEPB",value:function(e){for(var t,r=e.byteLength,i=[],a=1,n=void 0;a<r-2;)0===e[a]&&0===e[a+1]&&3===e[a+2]?(i.push(a+2),a+=2):a++;if(0===i.length)return e;t=r-i.length,n=new Uint8Array(t);var o=0;for(a=0;a<t;o++,a++)o===i[0]&&(o++,i.shift()),n[a]=e[o];return n}},{key:"_parseAACPES",value:function(e){var t,r,i=this._audioTrack,n=e.data,s=e.pts,l=this.aacOverFlow,f=this.aacLastPTS,c=void 0,h=void 0,v=void 0;if(l){var g=new Uint8Array(l.byteLength+n.byteLength);g.set(l,0),g.set(n,l.byteLength),n=g}for(h=0,r=n.length;h<r-1&&!a.isHeader(n,h);h++);if(h){var p=void 0,y=void 0;if(h<r-1?(p="AAC PES did not start with ADTS header,offset:"+h,y=!1):(p="no ADTS header found in AAC PES",y=!0),u.logger.warn("parsing error:"+p),this.observer.trigger(o.default.ERROR,{type:d.ErrorTypes.MEDIA_ERROR,details:d.ErrorDetails.FRAG_PARSING_ERROR,fatal:y,reason:p}),y)return}if(a.initTrackConfig(i,this.observer,n,h,this.audioCodec),c=0,t=a.getFrameDuration(i.samplerate),l&&f){var m=f+t;Math.abs(m-s)>1&&(u.logger.log("AAC: align PTS for overlapping frames by "+Math.round((m-s)/90)),s=m)}for(;h<r;)if(a.isHeader(n,h)&&h+5<r){var b=a.appendFrame(i,n,h,s,c);if(!b)break;h+=b.length,v=b.sample.pts,c++}else h++;l=h<r?n.subarray(h,r):null,this.aacOverFlow=l,this.aacLastPTS=v}},{key:"_parseMPEGPES",value:function(e){for(var t=e.data,r=t.length,i=0,a=0,o=e.pts;a<r;)if(n.default.isHeader(t,a)){var s=n.default.appendFrame(this._audioTrack,t,a,o,i);if(!s)break;a+=s.length,i++}else a++}},{key:"_parseID3PES",value:function(e){this._id3Track.samples.push(e)}}],[{key:"probe",value:function(t){var r=e._syncOffset(t);return!(r<0)&&(r&&u.logger.warn("MPEG2-TS detected but first sync word found @ offset "+r+", junk ahead ?"),!0)}},{key:"_syncOffset",value:function(e){for(var t=Math.min(1e3,e.length-564),r=0;r<t;){if(71===e[r]&&71===e[r+188]&&71===e[r+376])return r;r++}return-1}},{key:"createTrack",value:function(e,t){return{container:"video"===e||"audio"===e?"video/mp2t":void 0,type:e,id:c[e],pid:-1,inputTimeScale:9e4,sequenceNumber:0,samples:[],len:0,dropped:"video"===e?0:void 0,isAAC:"audio"===e||void 0,duration:"audio"===e?t:void 0}}}]),e}();t.default=h,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(23)),n=r(0),o=function(e){return e&&e.__esModule?e:{default:e}}(r(8));var s=function(){function e(t,r,i){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.observer=t,this.config=i,this.remuxer=r}return i(e,[{key:"resetInitSegment",value:function(e,t,r,i){this._audioTrack={container:"audio/adts",type:"audio",id:0,sequenceNumber:0,isAAC:!0,samples:[],len:0,manifestCodec:t,duration:i,inputTimeScale:9e4}}},{key:"resetTimeStamp",value:function(){}},{key:"append",value:function(e,t,r,i){for(var s=this._audioTrack,l=o.default.getID3Data(e,0)||[],u=o.default.getTimeStamp(l),d=Number.isFinite(u)?90*u:9e4*t,f=0,c=d,h=e.length,v=l.length,g=[{pts:c,dts:c,data:l}];v<h-1;)if(a.isHeader(e,v)&&v+5<h){a.initTrackConfig(s,this.observer,e,v,s.manifestCodec);var p=a.appendFrame(s,e,v,d,f);if(!p){n.logger.log("Unable to parse AAC frame");break}v+=p.length,c=p.sample.pts,f++}else o.default.isHeader(e,v)?(l=o.default.getID3Data(e,v),g.push({pts:c,dts:c,data:l}),v+=l.length):v++;this.remuxer.remux(s,{samples:[]},{samples:g,inputTimeScale:9e4},{samples:[]},t,r,i)}},{key:"destroy",value:function(){}}],[{key:"probe",value:function(e){if(!e)return!1;for(var t=(o.default.getID3Data(e,0)||[]).length,r=e.length;t<r;t++)if(a.probe(e,t))return n.logger.log("ADTS sync word found !"),!0;return!1}}]),e}();t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();function a(e){var t=e.byteLength,r=t&&new DataView(e).getUint8(t-1);return r?e.slice(0,t-r):e}t.removePadding=a;var n=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.rcon=[0,1,2,4,8,16,32,64,128,27,54],this.subMix=[new Uint32Array(256),new Uint32Array(256),new Uint32Array(256),new Uint32Array(256)],this.invSubMix=[new Uint32Array(256),new Uint32Array(256),new Uint32Array(256),new Uint32Array(256)],this.sBox=new Uint32Array(256),this.invSBox=new Uint32Array(256),this.key=new Uint32Array(0),this.initTable()}return i(e,[{key:"uint8ArrayToUint32Array_",value:function(e){for(var t=new DataView(e),r=new Uint32Array(4),i=0;i<4;i++)r[i]=t.getUint32(4*i);return r}},{key:"initTable",value:function(){var e=this.sBox,t=this.invSBox,r=this.subMix,i=r[0],a=r[1],n=r[2],o=r[3],s=this.invSubMix,l=s[0],u=s[1],d=s[2],f=s[3],c=new Uint32Array(256),h=0,v=0,g=0;for(g=0;g<256;g++)c[g]=g<128?g<<1:g<<1^283;for(g=0;g<256;g++){var p=v^v<<1^v<<2^v<<3^v<<4;p=p>>>8^255&p^99,e[h]=p,t[p]=h;var y=c[h],m=c[y],b=c[m],E=257*c[p]^16843008*p;i[h]=E<<24|E>>>8,a[h]=E<<16|E>>>16,n[h]=E<<8|E>>>24,o[h]=E,E=16843009*b^65537*m^257*y^16843008*h,l[p]=E<<24|E>>>8,u[p]=E<<16|E>>>16,d[p]=E<<8|E>>>24,f[p]=E,h?(h=y^c[c[c[b^y]]],v^=c[c[v]]):h=v=1}}},{key:"expandKey",value:function(e){for(var t=this.uint8ArrayToUint32Array_(e),r=!0,i=0;i<t.length&&r;)r=t[i]===this.key[i],i++;if(!r){this.key=t;var a=this.keySize=t.length;if(4!==a&&6!==a&&8!==a)throw new Error("Invalid aes key size="+a);var n=this.ksRows=4*(a+6+1),o=void 0,s=void 0,l=this.keySchedule=new Uint32Array(n),u=this.invKeySchedule=new Uint32Array(n),d=this.sBox,f=this.rcon,c=this.invSubMix,h=c[0],v=c[1],g=c[2],p=c[3],y=void 0,m=void 0;for(o=0;o<n;o++)o<a?y=l[o]=t[o]:(m=y,o%a==0?(m=d[(m=m<<8|m>>>24)>>>24]<<24|d[m>>>16&255]<<16|d[m>>>8&255]<<8|d[255&m],m^=f[o/a|0]<<24):a>6&&o%a==4&&(m=d[m>>>24]<<24|d[m>>>16&255]<<16|d[m>>>8&255]<<8|d[255&m]),l[o]=y=(l[o-a]^m)>>>0);for(s=0;s<n;s++)o=n-s,m=3&s?l[o]:l[o-4],u[s]=s<4||o<=4?m:h[d[m>>>24]]^v[d[m>>>16&255]]^g[d[m>>>8&255]]^p[d[255&m]],u[s]=u[s]>>>0}}},{key:"networkToHostOrderSwap",value:function(e){return e<<24|(65280&e)<<8|(16711680&e)>>8|e>>>24}},{key:"decrypt",value:function(e,t,r,i){for(var n=this.keySize+6,o=this.invKeySchedule,s=this.invSBox,l=this.invSubMix,u=l[0],d=l[1],f=l[2],c=l[3],h=this.uint8ArrayToUint32Array_(r),v=h[0],g=h[1],p=h[2],y=h[3],m=new Int32Array(e),b=new Int32Array(m.length),E=void 0,_=void 0,T=void 0,S=void 0,k=void 0,R=void 0,A=void 0,w=void 0,O=void 0,L=void 0,D=void 0,P=void 0,I=void 0,C=void 0,x=this.networkToHostOrderSwap;t<m.length;){for(O=x(m[t]),L=x(m[t+1]),D=x(m[t+2]),P=x(m[t+3]),k=O^o[0],R=P^o[1],A=D^o[2],w=L^o[3],I=4,C=1;C<n;C++)E=u[k>>>24]^d[R>>16&255]^f[A>>8&255]^c[255&w]^o[I],_=u[R>>>24]^d[A>>16&255]^f[w>>8&255]^c[255&k]^o[I+1],T=u[A>>>24]^d[w>>16&255]^f[k>>8&255]^c[255&R]^o[I+2],S=u[w>>>24]^d[k>>16&255]^f[R>>8&255]^c[255&A]^o[I+3],k=E,R=_,A=T,w=S,I+=4;E=s[k>>>24]<<24^s[R>>16&255]<<16^s[A>>8&255]<<8^s[255&w]^o[I],_=s[R>>>24]<<24^s[A>>16&255]<<16^s[w>>8&255]<<8^s[255&k]^o[I+1],T=s[A>>>24]<<24^s[w>>16&255]<<16^s[k>>8&255]<<8^s[255&R]^o[I+2],S=s[w>>>24]<<24^s[k>>16&255]<<16^s[R>>8&255]<<8^s[255&A]^o[I+3],I+=3,b[t]=x(E^v),b[t+1]=x(S^g),b[t+2]=x(T^p),b[t+3]=x(_^y),v=O,g=L,p=D,y=P,t+=4}return i?a(b.buffer):b.buffer}},{key:"destroy",value:function(){this.key=void 0,this.keySize=void 0,this.ksRows=void 0,this.sBox=void 0,this.invSBox=void 0,this.subMix=void 0,this.invSubMix=void 0,this.keySchedule=void 0,this.invKeySchedule=void 0,this.rcon=void 0}}]),e}();t.default=n},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(t,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.subtle=t,this.key=r}return i(e,[{key:"expandKey",value:function(){return this.subtle.importKey("raw",this.key,{name:"AES-CBC"},!1,["encrypt","decrypt"])}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(t,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.subtle=t,this.aesIV=r}return i(e,[{key:"decrypt",value:function(e,t){return this.subtle.decrypt({name:"AES-CBC",iv:this.aesIV},t,e)}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){function i(e){var t={};function r(i){if(t[i])return t[i].exports;var a=t[i]={i:i,l:!1,exports:{}};return e[i].call(a.exports,a,a.exports,r),a.l=!0,a.exports}r.m=e,r.c=t,r.i=function(e){return e},r.d=function(e,t,i){r.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:i})},r.r=function(e){Object.defineProperty(e,"__esModule",{value:!0})},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r.oe=function(e){throw console.error(e),e};var i=r(r.s=ENTRY_MODULE);return i.default||i}var a="[\\.|\\-|\\+|\\w|/|@]+",n="\\(\\s*(/\\*.*?\\*/)?\\s*.*?("+a+").*?\\)";function o(e){return(e+"").replace(/[.?*+^$[\]\\(){}|-]/g,"\\$&")}function s(e){return!isNaN(1*e)}function l(e,t,i){var l={};l[i]=[];var u=t.toString(),d=u.match(/^function\s?\w*\(\w+,\s*\w+,\s*(\w+)\)/);if(!d)return l;for(var f,c=d[1],h=new RegExp("(\\\\n|\\W)"+o(c)+n,"g");f=h.exec(u);)"dll-reference"!==f[3]&&l[i].push(f[3]);for(h=new RegExp("\\("+o(c)+'\\("(dll-reference\\s('+a+'))"\\)\\)'+n,"g");f=h.exec(u);)e[f[2]]||(l[i].push(f[1]),e[f[2]]=r(f[1]).m),l[f[2]]=l[f[2]]||[],l[f[2]].push(f[4]);for(var v=Object.keys(l),g=0;g<v.length;g++)for(var p=0;p<l[v[g]].length;p++)s(l[v[g]][p])&&(l[v[g]][p]=1*l[v[g]][p]);return l}function u(e){return Object.keys(e).reduce(function(t,r){return t||e[r].length>0},!1)}e.exports=function(e,t){t=t||{};var a={main:r.m},n=t.all?{main:Object.keys(a.main)}:function(e,t){for(var r={main:[t]},i={main:[]},a={main:{}};u(r);)for(var n=Object.keys(r),o=0;o<n.length;o++){var s=n[o],d=r[s].pop();if(a[s]=a[s]||{},!a[s][d]&&e[s][d]){a[s][d]=!0,i[s]=i[s]||[],i[s].push(d);for(var f=l(e,e[s][d],s),c=Object.keys(f),h=0;h<c.length;h++)r[c[h]]=r[c[h]]||[],r[c[h]]=r[c[h]].concat(f[c[h]])}}return i}(a,e),o="";Object.keys(n).filter(function(e){return"main"!==e}).forEach(function(e){for(var t=0;n[e][t];)t++;n[e].push(t),a[e][t]="(function(module, exports, __webpack_require__) { module.exports = __webpack_require__; })",o=o+"var "+e+" = ("+i.toString().replace("ENTRY_MODULE",JSON.stringify(t))+")({"+n[e].map(function(t){return JSON.stringify(t)+": "+a[e][t].toString()}).join(",")+"});\n"}),o=o+"new (("+i.toString().replace("ENTRY_MODULE",JSON.stringify(e))+")({"+n.main.map(function(e){return JSON.stringify(e)+": "+a.main[e].toString()}).join(",")+"}))(self);";var s=new window.Blob([o],{type:"text/javascript"});if(t.bare)return s;var d=(window.URL||window.webkitURL||window.mozURL||window.msURL).createObjectURL(s),f=new window.Worker(d);return f.objectURL=d,f}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=E(r(9)),n=r(4),o=E(r(26)),s=E(r(1)),l=r(6),u=E(r(14)),d=E(r(30)),f=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(5)),c=E(r(20)),h=r(2),v=r(0),g=r(19),p=r(18),y=E(r(55)),m=r(11),b=E(m);function E(e){return e&&e.__esModule?e:{default:e}}var _=function(e){function t(e,r){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var i=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,s.default.MEDIA_ATTACHED,s.default.MEDIA_DETACHING,s.default.MANIFEST_LOADING,s.default.MANIFEST_PARSED,s.default.LEVEL_LOADED,s.default.KEY_LOADED,s.default.FRAG_LOADED,s.default.FRAG_LOAD_EMERGENCY_ABORTED,s.default.FRAG_PARSING_INIT_SEGMENT,s.default.FRAG_PARSING_DATA,s.default.FRAG_PARSED,s.default.ERROR,s.default.AUDIO_TRACK_SWITCHING,s.default.AUDIO_TRACK_SWITCHED,s.default.BUFFER_CREATED,s.default.BUFFER_APPENDED,s.default.BUFFER_FLUSHED));return i.fragmentTracker=r,i.config=e.config,i.audioCodecSwap=!1,i._state=m.State.STOPPED,i.stallReported=!1,i.gapController=null,i}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,b.default),i(t,[{key:"startLoad",value:function(e){if(this.levels){var t=this.lastCurrentTime,r=this.hls;if(this.stopLoad(),this.setInterval(100),this.level=-1,this.fragLoadError=0,!this.startFragRequested){var i=r.startLevel;-1===i&&(i=0,this.bitrateTest=!0),this.level=r.nextLoadLevel=i,this.loadedmetadata=!1}t>0&&-1===e&&(v.logger.log("override startPosition with lastCurrentTime @"+t.toFixed(3)),e=t),this.state=m.State.IDLE,this.nextLoadPosition=this.startPosition=this.lastCurrentTime=e,this.tick()}else this.forceStartLoad=!0,this.state=m.State.STOPPED}},{key:"stopLoad",value:function(){this.forceStartLoad=!1,function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"stopLoad",this).call(this)}},{key:"doTick",value:function(){switch(this.state){case m.State.BUFFER_FLUSHING:this.fragLoadError=0;break;case m.State.IDLE:this._doTickIdle();break;case m.State.WAITING_LEVEL:var e=this.levels[this.level];e&&e.details&&(this.state=m.State.IDLE);break;case m.State.FRAG_LOADING_WAITING_RETRY:var t=window.performance.now(),r=this.retryDate;(!r||t>=r||this.media&&this.media.seeking)&&(v.logger.log("mediaController: retryDate reached, switch back to IDLE state"),this.state=m.State.IDLE);break;case m.State.ERROR:case m.State.STOPPED:case m.State.FRAG_LOADING:case m.State.PARSING:case m.State.PARSED:case m.State.ENDED:}this._checkBuffer(),this._checkFragmentChanged()}},{key:"_doTickIdle",value:function(){var e=this.hls,t=e.config,r=this.media;if(void 0!==this.levelLastLoaded&&(r||!this.startFragRequested&&t.startFragPrefetch)){var i=void 0;i=this.loadedmetadata?r.currentTime:this.nextLoadPosition;var a=e.nextLoadLevel,o=this.levels[a];if(o){var l=o.bitrate,u=void 0;u=l?Math.max(8*t.maxBufferSize/l,t.maxBufferLength):t.maxBufferLength,u=Math.min(u,t.maxMaxBufferLength);var d=n.BufferHelper.bufferInfo(this.mediaBuffer?this.mediaBuffer:r,i,t.maxBufferHole),f=d.len;if(!(f>=u)){v.logger.trace("buffer length of "+f.toFixed(3)+" is below max of "+u.toFixed(3)+". checking for more payload ..."),this.level=e.nextLoadLevel=a;var c=o.details;if(!c||c.live&&this.levelLastLoaded!==a)this.state=m.State.WAITING_LEVEL;else{if(this._streamEnded(d,c)){var h={};return this.altAudio&&(h.type="video"),this.hls.trigger(s.default.BUFFER_EOS,h),void(this.state=m.State.ENDED)}this._fetchPayloadOrEos(i,d,c)}}}}}},{key:"_fetchPayloadOrEos",value:function(e,t,r){var i=this.fragPrevious,a=this.level,n=r.fragments,o=n.length;if(0!==o){var s=n[0].start,l=n[o-1].start+n[o-1].duration,u=t.end,d=void 0;if(r.initSegment&&!r.initSegment.data)d=r.initSegment;else if(r.live){var f=this.config.initialLiveManifestSize;if(o<f)return void v.logger.warn("Can not start playback of a level, reason: not enough fragments "+o+" < "+f);if(null===(d=this._ensureFragmentAtLivePoint(r,u,s,l,i,n,o)))return}else u<s&&(d=n[0]);d||(d=this._findFragment(s,i,o,n,u,l,r)),d&&(d.encrypted?(v.logger.log("Loading key for "+d.sn+" of ["+r.startSN+" ,"+r.endSN+"],level "+a),this._loadKey(d)):(v.logger.log("Loading "+d.sn+" of ["+r.startSN+" ,"+r.endSN+"],level "+a+", currentTime:"+e.toFixed(3)+",bufferEnd:"+u.toFixed(3)),this._loadFragment(d)))}}},{key:"_ensureFragmentAtLivePoint",value:function(e,t,r,i,n,o,s){var l=this.hls.config,u=this.media,d=void 0,f=void 0!==l.liveMaxLatencyDuration?l.liveMaxLatencyDuration:l.liveMaxLatencyDurationCount*e.targetduration;if(t<Math.max(r-l.maxFragLookUpTolerance,i-f)){var c=this.liveSyncPosition=this.computeLivePosition(r,e);v.logger.log("buffer end: "+t.toFixed(3)+" is located too far from the end of live sliding playlist, reset currentTime to : "+c.toFixed(3)),t=c,u&&u.readyState&&u.duration>c&&(u.currentTime=c),this.nextLoadPosition=c}if(e.PTSKnown&&t>i&&u&&u.readyState)return null;if(this.startFragRequested&&!e.PTSKnown){if(n)if(e.hasProgramDateTime)v.logger.log("live playlist, switching playlist, load frag with same PDT: "+n.programDateTime),d=(0,p.findFragmentByPDT)(o,n.endProgramDateTime,l.maxFragLookUpTolerance);else{var h=n.sn+1;if(h>=e.startSN&&h<=e.endSN){var g=o[h-e.startSN];n.cc===g.cc&&(d=g,v.logger.log("live playlist, switching playlist, load frag with next SN: "+d.sn))}d||(d=a.default.search(o,function(e){return n.cc-e.cc}))&&v.logger.log("live playlist, switching playlist, load frag with same CC: "+d.sn)}d||(d=o[Math.min(s-1,Math.round(s/2))],v.logger.log("live playlist, switching playlist, unknown, load middle frag : "+d.sn))}return d}},{key:"_findFragment",value:function(e,t,r,i,a,n,o){var s=this.hls.config,l=void 0;if(a<n){var u=a>n-s.maxFragLookUpTolerance?0:s.maxFragLookUpTolerance;l=(0,p.findFragmentByPTS)(t,i,a,u)}else l=i[r-1];if(l){var d=l.sn-o.startSN,f=t&&l.level===t.level,c=i[d-1],h=i[d+1];if(t&&l.sn===t.sn)if(f&&!l.backtracked)if(l.sn<o.endSN){var g=t.deltaPTS;g&&g>s.maxBufferHole&&t.dropped&&d?(l=c,v.logger.warn("SN just loaded, with large PTS gap between audio and video, maybe frag is not starting with a keyframe ? load previous one to try to overcome this")):(l=h,v.logger.log("SN just loaded, load next one: "+l.sn,l))}else l=null;else l.backtracked&&(h&&h.backtracked?(v.logger.warn("Already backtracked from fragment "+h.sn+", will not backtrack to fragment "+l.sn+". Loading fragment "+h.sn),l=h):(v.logger.warn("Loaded fragment with dropped frames, backtracking 1 segment to find a keyframe"),l.dropped=0,c?(l=c).backtracked=!0:d&&(l=null)))}return l}},{key:"_loadKey",value:function(e){this.state=m.State.KEY_LOADING,this.hls.trigger(s.default.KEY_LOADING,{frag:e})}},{key:"_loadFragment",value:function(e){var t=this.fragmentTracker.getState(e);this.fragCurrent=e,this.startFragRequested=!0,Number.isFinite(e.sn)&&!e.bitrateTest&&(this.nextLoadPosition=e.start+e.duration),e.backtracked||t===l.FragmentState.NOT_LOADED||t===l.FragmentState.PARTIAL?(e.autoLevel=this.hls.autoLevelEnabled,e.bitrateTest=this.bitrateTest,this.hls.trigger(s.default.FRAG_LOADING,{frag:e}),this.demuxer||(this.demuxer=new o.default(this.hls,"main")),this.state=m.State.FRAG_LOADING):t===l.FragmentState.APPENDING&&this._reduceMaxBufferLength(e.duration)&&this.fragmentTracker.removeFragment(e)}},{key:"getBufferedFrag",value:function(e){return this.fragmentTracker.getBufferedFrag(e,d.default.LevelType.MAIN)}},{key:"followingBufferedFrag",value:function(e){return e?this.getBufferedFrag(e.endPTS+.5):null}},{key:"_checkFragmentChanged",value:function(){var e=void 0,t=void 0,r=this.media;if(r&&r.readyState&&!1===r.seeking&&((t=r.currentTime)>this.lastCurrentTime&&(this.lastCurrentTime=t),n.BufferHelper.isBuffered(r,t)?e=this.getBufferedFrag(t):n.BufferHelper.isBuffered(r,t+.1)&&(e=this.getBufferedFrag(t+.1)),e)){var i=e;if(i!==this.fragPlaying){this.hls.trigger(s.default.FRAG_CHANGED,{frag:i});var a=i.level;this.fragPlaying&&this.fragPlaying.level===a||this.hls.trigger(s.default.LEVEL_SWITCHED,{level:a}),this.fragPlaying=i}}}},{key:"immediateLevelSwitch",value:function(){if(v.logger.log("immediateLevelSwitch"),!this.immediateSwitch){this.immediateSwitch=!0;var e=this.media,t=void 0;e?(t=e.paused,e.pause()):t=!0,this.previouslyPaused=t}var r=this.fragCurrent;r&&r.loader&&r.loader.abort(),this.fragCurrent=null,this.flushMainBuffer(0,Number.POSITIVE_INFINITY)}},{key:"immediateLevelSwitchEnd",value:function(){var e=this.media;e&&e.buffered.length&&(this.immediateSwitch=!1,n.BufferHelper.isBuffered(e,e.currentTime)&&(e.currentTime-=1e-4),this.previouslyPaused||e.play())}},{key:"nextLevelSwitch",value:function(){var e=this.media;if(e&&e.readyState){var t,r=void 0,i=void 0;if((t=this.getBufferedFrag(e.currentTime))&&t.startPTS>1&&this.flushMainBuffer(0,t.startPTS-1),e.paused)r=0;else{var a=this.hls.nextLoadLevel,n=this.levels[a],o=this.fragLastKbps;r=o&&this.fragCurrent?this.fragCurrent.duration*n.bitrate/(1e3*o)+1:0}if((i=this.getBufferedFrag(e.currentTime+r))&&(i=this.followingBufferedFrag(i))){var s=this.fragCurrent;s&&s.loader&&s.loader.abort(),this.fragCurrent=null,this.flushMainBuffer(i.maxStartPTS,Number.POSITIVE_INFINITY)}}}},{key:"flushMainBuffer",value:function(e,t){this.state=m.State.BUFFER_FLUSHING;var r={startOffset:e,endOffset:t};this.altAudio&&(r.type="video"),this.hls.trigger(s.default.BUFFER_FLUSHING,r)}},{key:"onMediaAttached",value:function(e){var t=this.media=this.mediaBuffer=e.media;this.onvseeking=this.onMediaSeeking.bind(this),this.onvseeked=this.onMediaSeeked.bind(this),this.onvended=this.onMediaEnded.bind(this),t.addEventListener("seeking",this.onvseeking),t.addEventListener("seeked",this.onvseeked),t.addEventListener("ended",this.onvended);var r=this.config;this.levels&&r.autoStartLoad&&this.hls.startLoad(r.startPosition),this.gapController=new y.default(r,t,this.fragmentTracker,this.hls)}},{key:"onMediaDetaching",value:function(){var e=this.media;e&&e.ended&&(v.logger.log("MSE detaching and video ended, reset startPosition"),this.startPosition=this.lastCurrentTime=0);var t=this.levels;t&&t.forEach(function(e){e.details&&e.details.fragments.forEach(function(e){e.backtracked=void 0})}),e&&(e.removeEventListener("seeking",this.onvseeking),e.removeEventListener("seeked",this.onvseeked),e.removeEventListener("ended",this.onvended),this.onvseeking=this.onvseeked=this.onvended=null),this.media=this.mediaBuffer=null,this.loadedmetadata=!1,this.stopLoad()}},{key:"onMediaSeeked",value:function(){var e=this.media,t=e?e.currentTime:void 0;Number.isFinite(t)&&v.logger.log("media seeked to "+t.toFixed(3)),this.tick()}},{key:"onManifestLoading",value:function(){v.logger.log("trigger BUFFER_RESET"),this.hls.trigger(s.default.BUFFER_RESET),this.fragmentTracker.removeAllFragments(),this.stalled=!1,this.startPosition=this.lastCurrentTime=0}},{key:"onManifestParsed",value:function(e){var t=!1,r=!1,i=void 0;e.levels.forEach(function(e){(i=e.audioCodec)&&(-1!==i.indexOf("mp4a.40.2")&&(t=!0),-1!==i.indexOf("mp4a.40.5")&&(r=!0))}),this.audioCodecSwitch=t&&r,this.audioCodecSwitch&&v.logger.log("both AAC/HE-AAC audio found in levels; declaring level codec as HE-AAC"),this.levels=e.levels,this.startFragRequested=!1;var a=this.config;(a.autoStartLoad||this.forceStartLoad)&&this.hls.startLoad(a.startPosition)}},{key:"onLevelLoaded",value:function(e){var t=e.details,r=e.level,i=this.levels[this.levelLastLoaded],a=this.levels[r],n=t.totalduration,o=0;if(v.logger.log("level "+r+" loaded ["+t.startSN+","+t.endSN+"],duration:"+n),t.live){var l=a.details;l&&t.fragments.length>0?(f.mergeDetails(l,t),o=t.fragments[0].start,this.liveSyncPosition=this.computeLivePosition(o,l),t.PTSKnown&&Number.isFinite(o)?v.logger.log("live playlist sliding:"+o.toFixed(3)):(v.logger.log("live playlist - outdated PTS, unknown sliding"),(0,g.alignStream)(this.fragPrevious,i,t))):(v.logger.log("live playlist - first load, unknown sliding"),t.PTSKnown=!1,(0,g.alignStream)(this.fragPrevious,i,t))}else t.PTSKnown=!1;if(a.details=t,this.levelLastLoaded=r,this.hls.trigger(s.default.LEVEL_UPDATED,{details:t,level:r}),!1===this.startFragRequested){if(-1===this.startPosition||-1===this.lastCurrentTime){var u=t.startTimeOffset;Number.isFinite(u)?(u<0&&(v.logger.log("negative start time offset "+u+", count from end of last fragment"),u=o+n+u),v.logger.log("start time offset found in playlist, adjust startPosition to "+u),this.startPosition=u):t.live?(this.startPosition=this.computeLivePosition(o,t),v.logger.log("configure startPosition to "+this.startPosition)):this.startPosition=0,this.lastCurrentTime=this.startPosition}this.nextLoadPosition=this.startPosition}this.state===m.State.WAITING_LEVEL&&(this.state=m.State.IDLE),this.tick()}},{key:"onKeyLoaded",value:function(){this.state===m.State.KEY_LOADING&&(this.state=m.State.IDLE,this.tick())}},{key:"onFragLoaded",value:function(e){var t=this.fragCurrent,r=this.hls,i=this.levels,a=this.media,n=e.frag;if(this.state===m.State.FRAG_LOADING&&t&&"main"===n.type&&n.level===t.level&&n.sn===t.sn){var l=e.stats,u=i[t.level],d=u.details;if(this.bitrateTest=!1,this.stats=l,v.logger.log("Loaded "+t.sn+" of ["+d.startSN+" ,"+d.endSN+"],level "+t.level),n.bitrateTest&&r.nextLoadLevel)this.state=m.State.IDLE,this.startFragRequested=!1,l.tparsed=l.tbuffered=window.performance.now(),r.trigger(s.default.FRAG_BUFFERED,{stats:l,frag:t,id:"main"}),this.tick();else if("initSegment"===n.sn)this.state=m.State.IDLE,l.tparsed=l.tbuffered=window.performance.now(),d.initSegment.data=e.payload,r.trigger(s.default.FRAG_BUFFERED,{stats:l,frag:t,id:"main"}),this.tick();else{v.logger.log("Parsing "+t.sn+" of ["+d.startSN+" ,"+d.endSN+"],level "+t.level+", cc "+t.cc),this.state=m.State.PARSING,this.pendingBuffering=!0,this.appended=!1,n.bitrateTest&&(n.bitrateTest=!1,this.fragmentTracker.onFragLoaded({frag:n}));var f=!(a&&a.seeking)&&(d.PTSKnown||!d.live),c=d.initSegment?d.initSegment.data:[],h=this._getAudioCodec(u);(this.demuxer=this.demuxer||new o.default(this.hls,"main")).push(e.payload,c,h,u.videoCodec,t,d.totalduration,f)}}this.fragLoadError=0}},{key:"onFragParsingInitSegment",value:function(e){var t=this.fragCurrent,r=e.frag;if(t&&"main"===e.id&&r.sn===t.sn&&r.level===t.level&&this.state===m.State.PARSING){var i=e.tracks,a=void 0,n=void 0;if(i.audio&&this.altAudio&&delete i.audio,n=i.audio){var o=this.levels[this.level].audioCodec,l=navigator.userAgent.toLowerCase();o&&this.audioCodecSwap&&(v.logger.log("swapping playlist audio codec"),o=-1!==o.indexOf("mp4a.40.5")?"mp4a.40.2":"mp4a.40.5"),this.audioCodecSwitch&&1!==n.metadata.channelCount&&-1===l.indexOf("firefox")&&(o="mp4a.40.5"),-1!==l.indexOf("android")&&"audio/mpeg"!==n.container&&(o="mp4a.40.2",v.logger.log("Android: force audio codec to "+o)),n.levelCodec=o,n.id=e.id}for(a in(n=i.video)&&(n.levelCodec=this.levels[this.level].videoCodec,n.id=e.id),this.hls.trigger(s.default.BUFFER_CODECS,i),i){n=i[a],v.logger.log("main track:"+a+",container:"+n.container+",codecs[level/parsed]=["+n.levelCodec+"/"+n.codec+"]");var u=n.initSegment;u&&(this.appended=!0,this.pendingBuffering=!0,this.hls.trigger(s.default.BUFFER_APPENDING,{type:a,data:u,parent:"main",content:"initSegment"}))}this.tick()}}},{key:"onFragParsingData",value:function(e){var t=this,r=this.fragCurrent,i=e.frag;if(r&&"main"===e.id&&i.sn===r.sn&&i.level===r.level&&("audio"!==e.type||!this.altAudio)&&this.state===m.State.PARSING){var a=this.levels[this.level],n=r;if(Number.isFinite(e.endPTS)||(e.endPTS=e.startPTS+r.duration,e.endDTS=e.startDTS+r.duration),!0===e.hasAudio&&n.addElementaryStream(u.default.ElementaryStreamTypes.AUDIO),!0===e.hasVideo&&n.addElementaryStream(u.default.ElementaryStreamTypes.VIDEO),v.logger.log("Parsed "+e.type+",PTS:["+e.startPTS.toFixed(3)+","+e.endPTS.toFixed(3)+"],DTS:["+e.startDTS.toFixed(3)+"/"+e.endDTS.toFixed(3)+"],nb:"+e.nb+",dropped:"+(e.dropped||0)),"video"===e.type)if(n.dropped=e.dropped,n.dropped)if(n.backtracked)v.logger.warn("Already backtracked on this fragment, appending with the gap",n.sn);else{var o=a.details;if(!o||n.sn!==o.startSN)return v.logger.warn("missing video frame(s), backtracking fragment",n.sn),this.fragmentTracker.removeFragment(n),n.backtracked=!0,this.nextLoadPosition=e.startPTS,this.state=m.State.IDLE,this.fragPrevious=n,void this.tick();v.logger.warn("missing video frame(s) on first frag, appending with gap",n.sn)}else n.backtracked=!1;var l=f.updateFragPTSDTS(a.details,n,e.startPTS,e.endPTS,e.startDTS,e.endDTS),d=this.hls;d.trigger(s.default.LEVEL_PTS_UPDATED,{details:a.details,level:this.level,drift:l,type:e.type,start:e.startPTS,end:e.endPTS}),[e.data1,e.data2].forEach(function(r){r&&r.length&&t.state===m.State.PARSING&&(t.appended=!0,t.pendingBuffering=!0,d.trigger(s.default.BUFFER_APPENDING,{type:e.type,data:r,parent:"main",content:"data"}))}),this.tick()}}},{key:"onFragParsed",value:function(e){var t=this.fragCurrent,r=e.frag;t&&"main"===e.id&&r.sn===t.sn&&r.level===t.level&&this.state===m.State.PARSING&&(this.stats.tparsed=window.performance.now(),this.state=m.State.PARSED,this._checkAppendedParsed())}},{key:"onAudioTrackSwitching",value:function(e){var t=!!e.url,r=e.id;if(!t){if(this.mediaBuffer!==this.media){v.logger.log("switching on main audio, use media.buffered to schedule main fragment loading"),this.mediaBuffer=this.media;var i=this.fragCurrent;i.loader&&(v.logger.log("switching to main audio track, cancel main fragment load"),i.loader.abort()),this.fragCurrent=null,this.fragPrevious=null,this.demuxer&&(this.demuxer.destroy(),this.demuxer=null),this.state=m.State.IDLE}var a=this.hls;a.trigger(s.default.BUFFER_FLUSHING,{startOffset:0,endOffset:Number.POSITIVE_INFINITY,type:"audio"}),a.trigger(s.default.AUDIO_TRACK_SWITCHED,{id:r}),this.altAudio=!1}}},{key:"onAudioTrackSwitched",value:function(e){var t=e.id,r=!!this.hls.audioTracks[t].url;if(r){var i=this.videoBuffer;i&&this.mediaBuffer!==i&&(v.logger.log("switching on alternate audio, use video.buffered to schedule main fragment loading"),this.mediaBuffer=i)}this.altAudio=r,this.tick()}},{key:"onBufferCreated",value:function(e){var t=e.tracks,r=void 0,i=void 0,a=!1;for(var n in t){var o=t[n];"main"===o.id?(i=n,r=o,"video"===n&&(this.videoBuffer=t[n].buffer)):a=!0}a&&r?(v.logger.log("alternate track found, use "+i+".buffered to schedule main fragment loading"),this.mediaBuffer=r.buffer):this.mediaBuffer=this.media}},{key:"onBufferAppended",value:function(e){if("main"===e.parent){var t=this.state;t!==m.State.PARSING&&t!==m.State.PARSED||(this.pendingBuffering=e.pending>0,this._checkAppendedParsed())}}},{key:"_checkAppendedParsed",value:function(){if(!(this.state!==m.State.PARSED||this.appended&&this.pendingBuffering)){var e=this.fragCurrent;if(e){var t=this.mediaBuffer?this.mediaBuffer:this.media;v.logger.log("main buffered : "+c.default.toString(t.buffered)),this.fragPrevious=e;var r=this.stats;r.tbuffered=window.performance.now(),this.fragLastKbps=Math.round(8*r.total/(r.tbuffered-r.tfirst)),this.hls.trigger(s.default.FRAG_BUFFERED,{stats:r,frag:e,id:"main"}),this.state=m.State.IDLE}this.tick()}}},{key:"onError",value:function(e){var t=e.frag||this.fragCurrent;if(!t||"main"===t.type){var r=!!this.media&&n.BufferHelper.isBuffered(this.media,this.media.currentTime)&&n.BufferHelper.isBuffered(this.media,this.media.currentTime+.5);switch(e.details){case h.ErrorDetails.FRAG_LOAD_ERROR:case h.ErrorDetails.FRAG_LOAD_TIMEOUT:case h.ErrorDetails.KEY_LOAD_ERROR:case h.ErrorDetails.KEY_LOAD_TIMEOUT:if(!e.fatal)if(this.fragLoadError+1<=this.config.fragLoadingMaxRetry){var i=Math.min(Math.pow(2,this.fragLoadError)*this.config.fragLoadingRetryDelay,this.config.fragLoadingMaxRetryTimeout);v.logger.warn("mediaController: frag loading failed, retry in "+i+" ms"),this.retryDate=window.performance.now()+i,this.loadedmetadata||(this.startFragRequested=!1,this.nextLoadPosition=this.startPosition),this.fragLoadError++,this.state=m.State.FRAG_LOADING_WAITING_RETRY}else v.logger.error("mediaController: "+e.details+" reaches max retry, redispatch as fatal ..."),e.fatal=!0,this.state=m.State.ERROR;break;case h.ErrorDetails.LEVEL_LOAD_ERROR:case h.ErrorDetails.LEVEL_LOAD_TIMEOUT:this.state!==m.State.ERROR&&(e.fatal?(this.state=m.State.ERROR,v.logger.warn("streamController: "+e.details+",switch to "+this.state+" state ...")):e.levelRetry||this.state!==m.State.WAITING_LEVEL||(this.state=m.State.IDLE));break;case h.ErrorDetails.BUFFER_FULL_ERROR:"main"!==e.parent||this.state!==m.State.PARSING&&this.state!==m.State.PARSED||(r?(this._reduceMaxBufferLength(this.config.maxBufferLength),this.state=m.State.IDLE):(v.logger.warn("buffer full error also media.currentTime is not buffered, flush everything"),this.fragCurrent=null,this.flushMainBuffer(0,Number.POSITIVE_INFINITY)))}}}},{key:"_reduceMaxBufferLength",value:function(e){var t=this.config;return t.maxMaxBufferLength>=e&&(t.maxMaxBufferLength/=2,v.logger.warn("main:reduce max buffer length to "+t.maxMaxBufferLength+"s"),!0)}},{key:"_checkBuffer",value:function(){var e=this.media;if(e&&0!==e.readyState){var t=(this.mediaBuffer?this.mediaBuffer:e).buffered;!this.loadedmetadata&&t.length?(this.loadedmetadata=!0,this._seekToStartPos()):this.immediateSwitch?this.immediateLevelSwitchEnd():this.gapController.poll(this.lastCurrentTime,t)}}},{key:"onFragLoadEmergencyAborted",value:function(){this.state=m.State.IDLE,this.loadedmetadata||(this.startFragRequested=!1,this.nextLoadPosition=this.startPosition),this.tick()}},{key:"onBufferFlushed",value:function(){var e=this.mediaBuffer?this.mediaBuffer:this.media;e&&this.fragmentTracker.detectEvictedFragments(u.default.ElementaryStreamTypes.VIDEO,e.buffered),this.state=m.State.IDLE,this.fragPrevious=null}},{key:"swapAudioCodec",value:function(){this.audioCodecSwap=!this.audioCodecSwap}},{key:"computeLivePosition",value:function(e,t){var r=void 0!==this.config.liveSyncDuration?this.config.liveSyncDuration:this.config.liveSyncDurationCount*t.targetduration;return e+Math.max(0,t.totalduration-r)}},{key:"_seekToStartPos",value:function(){var e=this.media,t=e.currentTime,r=e.seeking?t:this.startPosition;t!==r&&(v.logger.log("target start position not buffered, seek to buffered.start(0) "+r+" from current time "+t+" "),e.currentTime=r)}},{key:"_getAudioCodec",value:function(e){var t=this.config.defaultAudioCodec||e.audioCodec;return this.audioCodecSwap&&(v.logger.log("swapping playlist audio codec"),t&&(t=-1!==t.indexOf("mp4a.40.5")?"mp4a.40.2":"mp4a.40.5")),t}},{key:"state",set:function(e){if(this.state!==e){var t=this.state;this._state=e,v.logger.log("main stream:"+t+"->"+e),this.hls.trigger(s.default.STREAM_STATE_TRANSITION,{previousState:t,nextState:e})}},get:function(){return this._state}},{key:"currentLevel",get:function(){var e=this.media;if(e){var t=this.getBufferedFrag(e.currentTime);if(t)return t.level}return-1}},{key:"nextBufferedFrag",get:function(){var e=this.media;return e?this.followingBufferedFrag(this.getBufferedFrag(e.currentTime)):null}},{key:"nextLevel",get:function(){var e=this.nextBufferedFrag;return e?e.level:-1}},{key:"liveSyncPosition",get:function(){return this._liveSyncPosition},set:function(e){this._liveSyncPosition=e}}]),t}();t.default=_,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(3)),o=r(2),s=r(0);function l(e){return e&&e.__esModule?e:{default:e}}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.KEY_LOADING));return r.loaders={},r.decryptkey=null,r.decrypturl=null,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){for(var e in this.loaders){var t=this.loaders[e];t&&t.destroy()}this.loaders={},n.default.prototype.destroy.call(this)}},{key:"onKeyLoading",value:function(e){var t=e.frag,r=t.type,i=this.loaders[r],n=t.decryptdata,o=n.uri;if(o!==this.decrypturl||null===this.decryptkey){var l=this.hls.config;i&&(s.logger.warn("abort previous key loader for type:"+r),i.abort()),t.loader=this.loaders[r]=new l.loader(l),this.decrypturl=o,this.decryptkey=null;var u,d,f;u={url:o,frag:t,responseType:"arraybuffer"},d={timeout:l.fragLoadingTimeOut,maxRetry:0,retryDelay:l.fragLoadingRetryDelay,maxRetryDelay:l.fragLoadingMaxRetryTimeout},f={onSuccess:this.loadsuccess.bind(this),onError:this.loaderror.bind(this),onTimeout:this.loadtimeout.bind(this)},t.loader.load(u,d,f)}else this.decryptkey&&(n.key=this.decryptkey,this.hls.trigger(a.default.KEY_LOADED,{frag:t}))}},{key:"loadsuccess",value:function(e,t,r){var i=r.frag;this.decryptkey=i.decryptdata.key=new Uint8Array(e.data),i.loader=void 0,this.loaders[i.type]=void 0,this.hls.trigger(a.default.KEY_LOADED,{frag:i})}},{key:"loaderror",value:function(e,t){var r=t.frag,i=r.loader;i&&i.abort(),this.loaders[t.type]=void 0,this.hls.trigger(a.default.ERROR,{type:o.ErrorTypes.NETWORK_ERROR,details:o.ErrorDetails.KEY_LOAD_ERROR,fatal:!1,frag:r,response:e})}},{key:"loadtimeout",value:function(e,t){var r=t.frag,i=r.loader;i&&i.abort(),this.loaders[t.type]=void 0,this.hls.trigger(a.default.ERROR,{type:o.ErrorTypes.NETWORK_ERROR,details:o.ErrorDetails.KEY_LOAD_TIMEOUT,fatal:!1,frag:r})}}]),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=l(r(1)),n=l(r(3)),o=r(2),s=r(0);function l(e){return e&&e.__esModule?e:{default:e}}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a.default.FRAG_LOADING));return r.loaders={},r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,n.default),i(t,[{key:"destroy",value:function(){var e=this.loaders;for(var r in e){var i=e[r];i&&i.destroy()}this.loaders={},function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0}(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"destroy",this).call(this)}},{key:"onFragLoading",value:function(e){var t=e.frag,r=t.type,i=this.loaders,a=this.hls.config,n=a.fLoader,o=a.loader;t.loaded=0;var l=i[r];l&&(s.logger.warn("abort previous fragment loader for type: "+r),l.abort()),l=i[r]=t.loader=a.fLoader?new n(a):new o(a);var u,d,f=void 0;f={url:t.url,frag:t,responseType:"arraybuffer",progressData:!1};var c=t.byteRangeStartOffset,h=t.byteRangeEndOffset;Number.isFinite(c)&&Number.isFinite(h)&&(f.rangeStart=c,f.rangeEnd=h),u={timeout:a.fragLoadingTimeOut,maxRetry:0,retryDelay:0,maxRetryDelay:a.fragLoadingMaxRetryTimeout},d={onSuccess:this.loadsuccess.bind(this),onError:this.loaderror.bind(this),onTimeout:this.loadtimeout.bind(this),onProgress:this.loadprogress.bind(this)},l.load(f,u,d)}},{key:"loadsuccess",value:function(e,t,r){var i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,n=e.data,o=r.frag;o.loader=void 0,this.loaders[o.type]=void 0,this.hls.trigger(a.default.FRAG_LOADED,{payload:n,frag:o,stats:t,networkDetails:i})}},{key:"loaderror",value:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,i=t.frag,n=i.loader;n&&n.abort(),this.loaders[i.type]=void 0,this.hls.trigger(a.default.ERROR,{type:o.ErrorTypes.NETWORK_ERROR,details:o.ErrorDetails.FRAG_LOAD_ERROR,fatal:!1,frag:t.frag,response:e,networkDetails:r})}},{key:"loadtimeout",value:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,i=t.frag,n=i.loader;n&&n.abort(),this.loaders[i.type]=void 0,this.hls.trigger(a.default.ERROR,{type:o.ErrorTypes.NETWORK_ERROR,details:o.ErrorDetails.FRAG_LOAD_TIMEOUT,fatal:!1,frag:t.frag,networkDetails:r})}},{key:"loadprogress",value:function(e,t,r){var i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,n=t.frag;n.loaded=e.loaded,this.hls.trigger(a.default.FRAG_LOAD_PROGRESS,{frag:n,stats:e,networkDetails:i})}}]),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=/^(\d+)x(\d+)$/,n=/\s*(.+?)\s*=((?:\".*?\")|.*?)(?:,|$)/g,o=function(){function e(t){for(var r in function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),"string"==typeof t&&(t=e.parseAttrList(t)),t)t.hasOwnProperty(r)&&(this[r]=t[r])}return i(e,[{key:"decimalInteger",value:function(e){var t=parseInt(this[e],10);return t>Number.MAX_SAFE_INTEGER?1/0:t}},{key:"hexadecimalInteger",value:function(e){if(this[e]){var t=(this[e]||"0x").slice(2);t=(1&t.length?"0":"")+t;for(var r=new Uint8Array(t.length/2),i=0;i<t.length/2;i++)r[i]=parseInt(t.slice(2*i,2*i+2),16);return r}return null}},{key:"hexadecimalIntegerAsNumber",value:function(e){var t=parseInt(this[e],16);return t>Number.MAX_SAFE_INTEGER?1/0:t}},{key:"decimalFloatingPoint",value:function(e){return parseFloat(this[e])}},{key:"enumeratedString",value:function(e){return this[e]}},{key:"decimalResolution",value:function(e){var t=a.exec(this[e]);if(null!==t)return{width:parseInt(t[1],10),height:parseInt(t[2],10)}}}],[{key:"parseAttrList",value:function(e){var t=void 0,r={};for(n.lastIndex=0;null!==(t=n.exec(e));){var i=t[2];0===i.indexOf('"')&&i.lastIndexOf('"')===i.length-1&&(i=i.slice(1,-1)),r[t[1]]=i}return r}}]),e}();t.default=o,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}();var a=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.endCC=0,this.endSN=0,this.fragments=[],this.initSegment=null,this.live=!0,this.needSidxRanges=!1,this.startCC=0,this.startSN=0,this.startTimeOffset=null,this.targetduration=0,this.totalduration=0,this.type=null,this.url=t,this.version=null}return i(e,[{key:"hasProgramDateTime",get:function(){return!(!this.fragments[0]||!Number.isFinite(this.fragments[0].programDateTime))}}]),e}();t.default=a,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(10)),n=f(r(14)),o=f(r(75)),s=f(r(28)),l=f(r(74)),u=r(0),d=r(27);function f(e){return e&&e.__esModule?e:{default:e}}var c=/#EXT-X-STREAM-INF:([^\n\r]*)[\r\n]+([^\r\n]+)/g,h=/#EXT-X-MEDIA:(.*)/g,v=new RegExp([/#EXTINF:\s*(\d*(?:\.\d+)?)(?:,(.*)\s+)?/.source,/|(?!#)([\S+ ?]+)/.source,/|#EXT-X-BYTERANGE:*(.+)/.source,/|#EXT-X-PROGRAM-DATE-TIME:(.+)/.source,/|#.*/.source].join(""),"g"),g=/(?:(?:#(EXTM3U))|(?:#EXT-X-(PLAYLIST-TYPE):(.+))|(?:#EXT-X-(MEDIA-SEQUENCE): *(\d+))|(?:#EXT-X-(TARGETDURATION): *(\d+))|(?:#EXT-X-(KEY):(.+))|(?:#EXT-X-(START):(.+))|(?:#EXT-X-(ENDLIST))|(?:#EXT-X-(DISCONTINUITY-SEQ)UENCE:(\d+))|(?:#EXT-X-(DIS)CONTINUITY))|(?:#EXT-X-(VERSION):(\d+))|(?:#EXT-X-(MAP):(.+))|(?:(#)([^:]*):(.*))|(?:(#)(.*))(?:.*)\r?\n?/,p=/\.(mp4|m4s|m4v|m4a)$/i,y=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"findGroup",value:function(e,t){if(!e)return null;for(var r=null,i=0;i<e.length;i++){var a=e[i];a.id===t&&(r=a)}return r}},{key:"convertAVC1ToAVCOTI",value:function(e){var t=void 0,r=e.split(".");return r.length>2?(t=r.shift()+".",t+=parseInt(r.shift()).toString(16),t+=("000"+parseInt(r.shift()).toString(16)).substr(-4)):t=e,t}},{key:"resolve",value:function(e,t){return a.buildAbsoluteURL(t,e,{alwaysNormalize:!0})}},{key:"parseMasterPlaylist",value:function(t,r){var i=[],a=void 0;function n(e,t){["video","audio"].forEach(function(r){var i=e.filter(function(e){return(0,d.isCodecType)(e,r)});if(i.length){var a=i.filter(function(e){return 0===e.lastIndexOf("avc1",0)||0===e.lastIndexOf("mp4a",0)});t[r+"Codec"]=a.length>0?a[0]:i[0],e=e.filter(function(e){return-1===i.indexOf(e)})}}),t.unknownCodecs=e}for(c.lastIndex=0;null!=(a=c.exec(t));){var o={},s=o.attrs=new l.default(a[1]);o.url=e.resolve(a[2],r);var u=s.decimalResolution("RESOLUTION");u&&(o.width=u.width,o.height=u.height),o.bitrate=s.decimalInteger("AVERAGE-BANDWIDTH")||s.decimalInteger("BANDWIDTH"),o.name=s.NAME,n([].concat((s.CODECS||"").split(/[ ,]+/)),o),o.videoCodec&&-1!==o.videoCodec.indexOf("avc1")&&(o.videoCodec=e.convertAVC1ToAVCOTI(o.videoCodec)),i.push(o)}return i}},{key:"parseMasterPlaylistMedia",value:function(t,r,i){var a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:[],n=void 0,o=[],s=0;for(h.lastIndex=0;null!==(n=h.exec(t));){var u={},d=new l.default(n[1]);if(d.TYPE===i){if(u.groupId=d["GROUP-ID"],u.name=d.NAME,u.type=i,u.default="YES"===d.DEFAULT,u.autoselect="YES"===d.AUTOSELECT,u.forced="YES"===d.FORCED,d.URI&&(u.url=e.resolve(d.URI,r)),u.lang=d.LANGUAGE,u.name||(u.name=u.lang),a.length){var f=e.findGroup(a,u.groupId);u.audioCodec=f?f.codec:a[0].codec}u.id=s++,o.push(u)}}return o}},{key:"parseLevelPlaylist",value:function(e,t,r,i,a){var d=0,f=0,c=new o.default(t),h=new s.default,y=0,b=null,E=new n.default,_=void 0,T=void 0,S=null;for(v.lastIndex=0;null!==(_=v.exec(e));){var k=_[1];if(k){E.duration=parseFloat(k);var R=(" "+_[2]).slice(1);E.title=R||null,E.tagList.push(R?["INF",k,R]:["INF",k])}else if(_[3]){if(Number.isFinite(E.duration)){var A=d++;E.type=i,E.start=f,E.levelkey=h,E.sn=A,E.level=r,E.cc=y,E.urlId=a,E.baseurl=t,E.relurl=(" "+_[3]).slice(1),m(E,b),c.fragments.push(E),b=E,f+=E.duration,E=new n.default}}else if(_[4]){if(E.rawByteRange=(" "+_[4]).slice(1),b){var w=b.byteRangeEndOffset;w&&(E.lastByteRangeEndOffset=w)}}else if(_[5])E.rawProgramDateTime=(" "+_[5]).slice(1),E.tagList.push(["PROGRAM-DATE-TIME",E.rawProgramDateTime]),null===S&&(S=c.fragments.length);else{for(_=_[0].match(g),T=1;T<_.length&&void 0===_[T];T++);var O=(" "+_[T+1]).slice(1),L=(" "+_[T+2]).slice(1);switch(_[T]){case"#":E.tagList.push(L?[O,L]:[O]);break;case"PLAYLIST-TYPE":c.type=O.toUpperCase();break;case"MEDIA-SEQUENCE":d=c.startSN=parseInt(O);break;case"TARGETDURATION":c.targetduration=parseFloat(O);break;case"VERSION":c.version=parseInt(O);break;case"EXTM3U":break;case"ENDLIST":c.live=!1;break;case"DIS":y++,E.tagList.push(["DIS"]);break;case"DISCONTINUITY-SEQ":y=parseInt(O);break;case"KEY":var D=O,P=new l.default(D),I=P.enumeratedString("METHOD"),C=P.URI,x=P.hexadecimalInteger("IV");I&&(h=new s.default,C&&["AES-128","SAMPLE-AES","SAMPLE-AES-CENC"].indexOf(I)>=0&&(h.method=I,h.baseuri=t,h.reluri=C,h.key=null,h.iv=x));break;case"START":var M=O,F=new l.default(M).decimalFloatingPoint("TIME-OFFSET");Number.isFinite(F)&&(c.startTimeOffset=F);break;case"MAP":var N=new l.default(O);E.relurl=N.URI,E.rawByteRange=N.BYTERANGE,E.baseurl=t,E.level=r,E.type=i,E.sn="initSegment",c.initSegment=E,(E=new n.default).rawProgramDateTime=c.initSegment.rawProgramDateTime;break;default:u.logger.warn("line parsed but not handled: "+_)}}}return(E=b)&&!E.relurl&&(c.fragments.pop(),f-=E.duration),c.totalduration=f,c.averagetargetduration=f/c.fragments.length,c.endSN=d-1,c.startCC=c.fragments[0]?c.fragments[0].cc:0,c.endCC=y,!c.initSegment&&c.fragments.length&&c.fragments.every(function(e){return p.test(e.relurl)})&&(u.logger.warn("MP4 fragments found but no init segment (probably no MAP, incomplete M3U8), trying to fetch SIDX"),(E=new n.default).relurl=c.fragments[0].relurl,E.baseurl=t,E.level=r,E.type=i,E.sn="initSegment",c.initSegment=E,c.needSidxRanges=!0),S&&function(e,t){for(var r=e[t],i=t-1;i>=0;i--){var a=e[i];a.programDateTime=r.programDateTime-1e3*a.duration,r=a}}(c.fragments,S),c}}]),e}();function m(e,t){e.rawProgramDateTime?e.programDateTime=Date.parse(e.rawProgramDateTime):t&&t.programDateTime&&(e.programDateTime=t.endProgramDateTime),Number.isFinite(e.programDateTime)||(e.programDateTime=null,e.rawProgramDateTime=null)}t.default=y,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r]);return t.default=e,t}(r(10)),n=r(2),o=m(r(30)),s=m(r(73)),l=m(r(72)),u=r(6),d=m(r(71)),f=m(r(54)),c=m(r(53)),h=r(52),v=r(0),g=r(51),p=m(r(1)),y=r(21);function m(e){return e&&e.__esModule?e:{default:e}}var b=function(e){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this)),i=t.DefaultConfig;if((e.liveSyncDurationCount||e.liveMaxLatencyDurationCount)&&(e.liveSyncDuration||e.liveMaxLatencyDuration))throw new Error("Illegal hls.js config: don't mix up liveSyncDurationCount/liveMaxLatencyDurationCount and liveSyncDuration/liveMaxLatencyDuration");for(var a in i)a in e||(e[a]=i[a]);if(void 0!==e.liveMaxLatencyDurationCount&&e.liveMaxLatencyDurationCount<=e.liveSyncDurationCount)throw new Error('Illegal hls.js config: "liveMaxLatencyDurationCount" must be gt "liveSyncDurationCount"');if(void 0!==e.liveMaxLatencyDuration&&(e.liveMaxLatencyDuration<=e.liveSyncDuration||void 0===e.liveSyncDuration))throw new Error('Illegal hls.js config: "liveMaxLatencyDuration" must be gt "liveSyncDuration"');(0,v.enableLogs)(e.debug),r.config=e,r._autoLevelCapping=-1;var n=r.abrController=new e.abrController(r),h=new e.bufferController(r),g=new e.capLevelController(r),p=new e.fpsController(r),y=new o.default(r),m=new s.default(r),b=new l.default(r),E=new c.default(r),_=r.levelController=new f.default(r),T=new u.FragmentTracker(r),S=[_,r.streamController=new d.default(r,T)],k=e.audioStreamController;k&&S.push(new k(r,T)),r.networkControllers=S;var R=[y,m,b,n,h,g,p,E,T];if(k=e.audioTrackController){var A=new k(r);r.audioTrackController=A,R.push(A)}if(k=e.subtitleTrackController){var w=new k(r);r.subtitleTrackController=w,S.push(w)}if(k=e.emeController){var O=new k(r);r.emeController=O,R.push(O)}return(k=e.subtitleStreamController)&&S.push(new k(r,T)),(k=e.timelineController)&&R.push(new k(r)),r.coreComponents=R,r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,y.Observer),i(t,null,[{key:"isSupported",value:function(){return(0,h.isSupported)()}},{key:"version",get:function(){return __VERSION__}},{key:"Events",get:function(){return p.default}},{key:"ErrorTypes",get:function(){return n.ErrorTypes}},{key:"ErrorDetails",get:function(){return n.ErrorDetails}},{key:"DefaultConfig",get:function(){return t.defaultConfig?t.defaultConfig:g.hlsDefaultConfig},set:function(e){t.defaultConfig=e}}]),i(t,[{key:"destroy",value:function(){v.logger.log("destroy"),this.trigger(p.default.DESTROYING),this.detachMedia(),this.coreComponents.concat(this.networkControllers).forEach(function(e){e.destroy()}),this.url=null,this.removeAllListeners(),this._autoLevelCapping=-1}},{key:"attachMedia",value:function(e){v.logger.log("attachMedia"),this.media=e,this.trigger(p.default.MEDIA_ATTACHING,{media:e})}},{key:"detachMedia",value:function(){v.logger.log("detachMedia"),this.trigger(p.default.MEDIA_DETACHING),this.media=null}},{key:"loadSource",value:function(e){e=a.buildAbsoluteURL(window.location.href,e,{alwaysNormalize:!0}),v.logger.log("loadSource:"+e),this.url=e,this.trigger(p.default.MANIFEST_LOADING,{url:e})}},{key:"startLoad",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:-1;v.logger.log("startLoad("+e+")"),this.networkControllers.forEach(function(t){t.startLoad(e)})}},{key:"stopLoad",value:function(){v.logger.log("stopLoad"),this.networkControllers.forEach(function(e){e.stopLoad()})}},{key:"swapAudioCodec",value:function(){v.logger.log("swapAudioCodec"),this.streamController.swapAudioCodec()}},{key:"recoverMediaError",value:function(){v.logger.log("recoverMediaError");var e=this.media;this.detachMedia(),this.attachMedia(e)}},{key:"levels",get:function(){return this.levelController.levels}},{key:"currentLevel",get:function(){return this.streamController.currentLevel},set:function(e){v.logger.log("set currentLevel:"+e),this.loadLevel=e,this.streamController.immediateLevelSwitch()}},{key:"nextLevel",get:function(){return this.streamController.nextLevel},set:function(e){v.logger.log("set nextLevel:"+e),this.levelController.manualLevel=e,this.streamController.nextLevelSwitch()}},{key:"loadLevel",get:function(){return this.levelController.level},set:function(e){v.logger.log("set loadLevel:"+e),this.levelController.manualLevel=e}},{key:"nextLoadLevel",get:function(){return this.levelController.nextLoadLevel},set:function(e){this.levelController.nextLoadLevel=e}},{key:"firstLevel",get:function(){return Math.max(this.levelController.firstLevel,this.minAutoLevel)},set:function(e){v.logger.log("set firstLevel:"+e),this.levelController.firstLevel=e}},{key:"startLevel",get:function(){return this.levelController.startLevel},set:function(e){v.logger.log("set startLevel:"+e);-1!==e&&(e=Math.max(e,this.minAutoLevel)),this.levelController.startLevel=e}},{key:"autoLevelCapping",get:function(){return this._autoLevelCapping},set:function(e){v.logger.log("set autoLevelCapping:"+e),this._autoLevelCapping=e}},{key:"autoLevelEnabled",get:function(){return-1===this.levelController.manualLevel}},{key:"manualLevel",get:function(){return this.levelController.manualLevel}},{key:"minAutoLevel",get:function(){for(var e=this.levels,t=this.config.minAutoBitrate,r=e?e.length:0,i=0;i<r;i++){if((e[i].realBitrate?Math.max(e[i].realBitrate,e[i].bitrate):e[i].bitrate)>t)return i}return 0}},{key:"maxAutoLevel",get:function(){var e=this.levels,t=this.autoLevelCapping;return-1===t&&e&&e.length?e.length-1:t}},{key:"nextAutoLevel",get:function(){return Math.min(Math.max(this.abrController.nextAutoLevel,this.minAutoLevel),this.maxAutoLevel)},set:function(e){this.abrController.nextAutoLevel=Math.max(this.minAutoLevel,e)}},{key:"audioTracks",get:function(){var e=this.audioTrackController;return e?e.audioTracks:[]}},{key:"audioTrack",get:function(){var e=this.audioTrackController;return e?e.audioTrack:-1},set:function(e){var t=this.audioTrackController;t&&(t.audioTrack=e)}},{key:"liveSyncPosition",get:function(){return this.streamController.liveSyncPosition}},{key:"subtitleTracks",get:function(){var e=this.subtitleTrackController;return e?e.subtitleTracks:[]}},{key:"subtitleTrack",get:function(){var e=this.subtitleTrackController;return e?e.subtitleTrack:-1},set:function(e){var t=this.subtitleTrackController;t&&(t.subtitleTrack=e)}},{key:"subtitleDisplay",get:function(){var e=this.subtitleTrackController;return!!e&&e.subtitleDisplay},set:function(e){var t=this.subtitleTrackController;t&&(t.subtitleDisplay=e)}}]),t}();t.default=b,e.exports=t.default},function(t,r){t.exports=e},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=function(){function e(e,t){for(var r=0;r<t.length;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(t,r,i){return r&&e(t.prototype,r),i&&e(t,i),t}}(),a=s(r(78)),n=s(r(77)),o=s(r(31));function s(e){return e&&e.__esModule?e:{default:e}}function l(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}var u=function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var r=l(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e));r.hlsOpts=e.hlsOpts||{};var i=a.default.util,s=r;if(r.browser=o.default.getBrowserVersion(),void 0===s.config.useHls){if("mobile"===a.default.sniffer.device&&"MacIntel"!==navigator.platform&&"Win32"!==navigator.platform||r.browser.indexOf("Safari")>-1)return l(r)}else if(!s.config.useHls)return l(r);Number.isFinite=Number.isFinite||function(e){return"number"==typeof e&&isFinite(e)};var u=void 0;return u=new n.default(r.hlsOpts),r.hls=u,Object.defineProperty(s,"src",{get:function(){return s.currentSrc},set:function(e){i.removeClass(s.root,"xgplayer-is-live");var t=document.querySelector(".xgplayer-live");t&&t.parentNode.removeChild(t);var r=s.paused;s.hls.stopLoad(),s.hls.detachMedia(),s.hls.destroy(),s.hls=new n.default(s.hlsOpts),s.register(e),r?s.hls.loadSource(e):(s.pause(),s.once("pause",function(){s.hls.loadSource(e)}),s.once("canplay",function(){var e=s.video.play();void 0!==e&&e&&e.catch(function(e){})})),s.hls.attachMedia(s.video),s.once("canplay",function(){s.currentTime=0})},configurable:!0}),r.register(r.config.url),r.once("complete",function(){if(u.attachMedia(s.video),s.once("canplay",function(){var e=s.video.play();void 0!==e&&e&&e.catch(function(e){})}),s.config.isLive&&(i.addClass(s.root,"xgplayer-is-live"),!i.findDom(s.root,".xgplayer-live"))){var e=i.createDom("xg-live","正在直播",{},"xgplayer-live");s.controls.appendChild(e)}}),r.once("destroy",function(){u.stopLoad()}),r}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default),i(t,[{key:"register",value:function(e){var t=this.hls,r=a.default.util,i=this;t.on(n.default.Events.MEDIA_ATTACHED,function(){t.loadSource(e)}),t.on(n.default.Events.LEVEL_LOADED,function(e,a){if(!t.inited&&(t.inited=!0,a&&a.details&&a.details.live&&(r.addClass(i.root,"xgplayer-is-live"),!r.findDom(i.root,".xgplayer-live")))){var n=r.createDom("xg-live","正在直播",{},"xgplayer-live");i.controls.appendChild(n)}}),t.on(n.default.Events.ERROR,function(e,r){if(i.emit("HLS_ERROR",{errorType:r.type,errorDetails:r.details,errorFatal:r.fatal}),r.fatal)switch(r.type){case n.default.ErrorTypes.NETWORK_ERROR:t.startLoad();break;case n.default.ErrorTypes.MEDIA_ERROR:t.recoverMediaError();break;default:i.emit("error",r)}}),this._statistics()}},{key:"_statistics",value:function(){var e={speed:0,playerType:"HlsPlayer"},t={videoDataRate:0,audioDataRate:0},r=this.hls,i=this;r.on(n.default.Events.FRAG_LOAD_PROGRESS,function(t,r){e.speed=r.stats.loaded/1e3}),r.on(n.default.Events.FRAG_PARSING_DATA,function(e,r){"video"===r.type&&(t.fps=parseInt(r.nb/(r.endPTS-r.startPTS)))}),r.on(n.default.Events.FRAG_PARSING_INIT_SEGMENT,function(e,r){if(t.hasAudio=!(!r.tracks||!r.tracks.audio),t.hasVideo=!(!r.tracks||!r.tracks.audio),t.hasAudio){var a=r.tracks.audio;t.audioChannelCount=a.metadata&&a.metadata.channelCount?a.metadata.channelCount:0,t.audioCodec=a.codec}if(t.hasVideo){var n=r.tracks.video;t.videoCodec=n.codec,t.width=n.metadata&&n.metadata.width?n.metadata.width:0,t.height=n.metadata&&n.metadata.height?n.metadata.height:0}t.duration=r.frag&&r.frag.duration?r.frag.duration:0,t.level=r.frag&&r.frag.level?r.frag.level:0,(t.videoCodec||t.audioCodec)&&(t.mimeType='video/hls; codecs="'+t.videoCodec+";"+t.audioCodec+'"'),i.mediainfo=t,i.emit("media_info",t)}),this._statisticsTimmer=setInterval(function(){i.emit("statistics_info",e),e.speed=0},1e3)}},{key:"destroy",value:function(){(function e(t,r,i){null===t&&(t=Function.prototype);var a=Object.getOwnPropertyDescriptor(t,r);if(void 0===a){var n=Object.getPrototypeOf(t);return null===n?void 0:e(n,r,i)}if("value"in a)return a.value;var o=a.get;return void 0!==o?o.call(i):void 0})(t.prototype.__proto__||Object.getPrototypeOf(t.prototype),"destroy",this).call(this),clearInterval(this._statisticsTimmer)}}]),t}();u.isSupported=n.default.isSupported,t.default=u,e.exports=t.default},function(e,t,r){e.exports=r(79)}])});

/***/ }),

/***/ "./node_modules/_xgplayer-mp4@1.1.8@xgplayer-mp4/dist/index.js":
/***/ (function(module, exports, __webpack_require__) {

!function(e,t){ true?module.exports=t(__webpack_require__("./node_modules/_xgplayer@2.6.15@xgplayer/dist/index.js")):"function"==typeof define&&define.amd?define(["xgplayer"],t):"object"==typeof exports?exports["xgplayer-mp4"]=t(require("xgplayer")):e["xgplayer-mp4"]=t(e.xgplayer)}(window,function(e){return function(e){var t={};function r(n){if(t[n])return t[n].exports;var i=t[n]={i:n,l:!1,exports:{}};return e[n].call(i.exports,i,i.exports,r),i.l=!0,i.exports}return r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)r.d(n,i,function(t){return e[t]}.bind(null,i));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=38)}([function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=o(r(1)),a=o(r(7));function o(e){return e&&e.__esModule?e:{default:e}}var u=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.headSize=8,this.size=0,this.type="",this.subBox=[],this.start=-1}return n(e,[{key:"readHeader",value:function(e){if(this.start=e.position,this.size=e.readUint32(),this.type=String.fromCharCode(e.readUint8(),e.readUint8(),e.readUint8(),e.readUint8()),1===this.size)this.size=e.readUint64();else if(0===this.size&&"mdat"!==this.type)throw new a.default("parse","",{line:19,handle:"[Box] readHeader",msg:"parse mp4 mdat box failed"});if("uuid"===this.type)for(var t=[],r=0;r<16;r++)t.push(e.readUint8())}},{key:"readBody",value:function(t){var r=this.size-t.position+this.start,n=this.type;this.data=t.buffer.slice(t.position,t.position+r),t.position+=this.data.byteLength;var i=void 0;(i=e.containerBox.find(function(e){return e===n})?e.containerParser:e[n])&&i instanceof Function&&i.call(this)}},{key:"read",value:function(e){this.readHeader(e),this.readBody(e)}}],[{key:"containerParser",value:function(){for(var t=new i.default(this.data),r=t.buffer.byteLength;t.position<r;){var n=new e;n.readHeader(t),this.subBox.push(n),n.readBody(t)}delete this.data,t=null}}]),e}();u.containerBox=["moov","trak","edts","mdia","minf","dinf","stbl","mvex","moof","traf","mfra"],t.default=u,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n,i=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),a=r(7),o=(n=a)&&n.__esModule?n:{default:n};var u=function(){function e(t){if(function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),!(t instanceof ArrayBuffer))throw new o.default("parse","",{line:9,handle:"[Stream] constructor",msg:"data is valid"});this.buffer=t,this.dataview=new DataView(t),this.dataview.position=0}return i(e,[{key:"skip",value:function(t){for(var r=Math.floor(t/4),n=t%4,i=0;i<r;i++)e.readByte(this.dataview,4);n>0&&e.readByte(this.dataview,n)}},{key:"readUint8",value:function(){return e.readByte(this.dataview,1)}},{key:"readUint16",value:function(){return e.readByte(this.dataview,2)}},{key:"readUint32",value:function(){return e.readByte(this.dataview,4)}},{key:"readUint64",value:function(){return e.readByte(this.dataview,8)}},{key:"readInt8",value:function(){return e.readByte(this.dataview,1,!0)}},{key:"readInt16",value:function(){return e.readByte(this.dataview,2,!0)}},{key:"readInt32",value:function(){return e.readByte(this.dataview,4,!0)}},{key:"position",set:function(e){this.dataview.position=e},get:function(){return this.dataview.position}}],[{key:"readByte",value:function(e,t,r){var n=void 0;switch(t){case 1:n=r?e.getInt8(e.position):e.getUint8(e.position);break;case 2:n=r?e.getInt16(e.position):e.getUint16(e.position);break;case 3:if(r)throw"not supported for readByte 3";n=e.getUint8(e.position)<<16,n|=e.getUint8(e.position+1)<<8,n|=e.getUint8(e.position+2);break;case 4:n=r?e.getInt32(e.position):e.getUint32(e.position);break;case 8:if(r)throw new o.default("parse","",{line:73,handle:"[Stream] readByte",msg:"not supported for readBody 8"});n=e.getUint32(e.position)<<32,n|=e.getUint32(e.position+4);break;default:n=""}return e.position+=t,n}}]),e}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";var n=e.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(e,t,r){"use strict";var n=r(19)("wks"),i=r(20),a=r(2).Symbol,o="function"==typeof a;(e.exports=function(e){return n[e]||(n[e]=o&&a[e]||(o?a:i)("Symbol."+e))}).store=n},function(e,t,r){"use strict";var n=e.exports={version:"2.6.9"};"number"==typeof __e&&(__e=n)},function(e,t,r){"use strict";var n=r(6);e.exports=function(e){if(!n(e))throw TypeError(e+" is not an object!");return e}},function(e,t,r){"use strict";var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};e.exports=function(e){return"object"===(void 0===e?"undefined":n(e))?null!==e:"function"==typeof e}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n,i=r(34),a=(n=i)&&n.__esModule?n:{default:n},o=r(84);var u=function(e){function t(e,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"";!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),n.version=o.version;var a=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,r,n));return a.url=i,a}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a.default.Errors),t}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";var n=r(9);e.exports=function(e,t,r){if(n(e),void 0===t)return e;switch(r){case 1:return function(r){return e.call(t,r)};case 2:return function(r,n){return e.call(t,r,n)};case 3:return function(r,n,i){return e.call(t,r,n,i)}}return function(){return e.apply(t,arguments)}}},function(e,t,r){"use strict";e.exports=function(e){if("function"!=typeof e)throw TypeError(e+" is not a function!");return e}},function(e,t,r){"use strict";e.exports=!r(23)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(e,t,r){"use strict";var n={}.toString;e.exports=function(e){return n.call(e).slice(8,-1)}},function(e,t,r){"use strict";var n=r(5),i=r(41),a=r(42),o=Object.defineProperty;t.f=r(10)?Object.defineProperty:function(e,t,r){if(n(e),t=a(t,!0),n(r),i)try{return o(e,t,r)}catch(e){}if("get"in r||"set"in r)throw TypeError("Accessors not supported!");return"value"in r&&(e[t]=r.value),e}},function(e,t,r){"use strict";var n,i,a,o,u,s,f,c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},d=r(64),l=r(81),h=Function.prototype.apply,p=Function.prototype.call,v=Object.create,m=Object.defineProperty,y=Object.defineProperties,b=Object.prototype.hasOwnProperty,g={configurable:!0,enumerable:!1,writable:!0};i=function(e,t){var r,i;return l(t),i=this,n.call(this,e,r=function(){a.call(i,e,r),h.call(t,this,arguments)}),r.__eeOnceListener__=t,this},u={on:n=function(e,t){var r;return l(t),b.call(this,"__ee__")?r=this.__ee__:(r=g.value=v(null),m(this,"__ee__",g),g.value=null),r[e]?"object"===c(r[e])?r[e].push(t):r[e]=[r[e],t]:r[e]=t,this},once:i,off:a=function(e,t){var r,n,i,a;if(l(t),!b.call(this,"__ee__"))return this;if(!(r=this.__ee__)[e])return this;if("object"===(void 0===(n=r[e])?"undefined":c(n)))for(a=0;i=n[a];++a)i!==t&&i.__eeOnceListener__!==t||(2===n.length?r[e]=n[a?0:1]:n.splice(a,1));else n!==t&&n.__eeOnceListener__!==t||delete r[e];return this},emit:o=function(e){var t,r,n,i,a;if(b.call(this,"__ee__")&&(i=this.__ee__[e]))if("object"===(void 0===i?"undefined":c(i))){for(r=arguments.length,a=new Array(r-1),t=1;t<r;++t)a[t-1]=arguments[t];for(i=i.slice(),t=0;n=i[t];++t)h.call(n,this,a)}else switch(arguments.length){case 1:p.call(i,this);break;case 2:p.call(i,this,arguments[1]);break;case 3:p.call(i,this,arguments[1],arguments[2]);break;default:for(r=arguments.length,a=new Array(r-1),t=1;t<r;++t)a[t-1]=arguments[t];h.call(i,this,a)}}},s={on:d(n),once:d(i),off:d(a),emit:d(o)},f=y({},s),e.exports=t=function(e){return null==e?v(f):y(Object(e),s)},t.methods=u},function(e,t,r){"use strict";var n=r(75)();e.exports=function(e){return e!==n&&null!==e}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}();var i=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e);var t=new Date;t.setFullYear(1904),t.setMonth(0),t.setDate(1),t.setHours(0),t.setMinutes(0),t.setSeconds(0),this.time=t}return n(e,[{key:"setTime",value:function(e){return this.time.setTime(this.time.getTime()+1*e),this.time.toLocaleString()}}]),e}();t.default=i,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n,i=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),a=r(36),o=(n=a)&&n.__esModule?n:{default:n};var u=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.buffer=new Uint8Array(0)}return i(e,[{key:"write",value:function(){for(var e=this,t=arguments.length,r=Array(t),n=0;n<t;n++)r[n]=arguments[n];r.forEach(function(t){t?e.buffer=(0,o.default)(Uint8Array,e.buffer,t):window.console.error(t)})}}],[{key:"writeUint32",value:function(e){return new Uint8Array([e>>24,e>>16&255,e>>8&255,255&e])}}]),e}();t.default=u,e.exports=t.default},function(e,t,r){"use strict";e.exports=!1},function(e,t,r){"use strict";var n=r(11),i=r(3)("toStringTag"),a="Arguments"==n(function(){return arguments}());e.exports=function(e){var t,r,o;return void 0===e?"Undefined":null===e?"Null":"string"==typeof(r=function(e,t){try{return e[t]}catch(e){}}(t=Object(e),i))?r:a?n(t):"Object"==(o=n(t))&&"function"==typeof t.callee?"Arguments":o}},function(e,t,r){"use strict";var n=r(4),i=r(2),a=i["__core-js_shared__"]||(i["__core-js_shared__"]={});(e.exports=function(e,t){return a[e]||(a[e]=void 0!==t?t:{})})("versions",[]).push({version:n.version,mode:r(17)?"pure":"global",copyright:"© 2019 Denis Pushkarev (zloirock.ru)"})},function(e,t,r){"use strict";var n=0,i=Math.random();e.exports=function(e){return"Symbol(".concat(void 0===e?"":e,")_",(++n+i).toString(36))}},function(e,t,r){"use strict";var n=r(2),i=r(4),a=r(22),o=r(25),u=r(8),s=function e(t,r,s){var f,c,d,l,h=t&e.F,p=t&e.G,v=t&e.P,m=t&e.B,y=p?n:t&e.S?n[r]||(n[r]={}):(n[r]||{}).prototype,b=p?i:i[r]||(i[r]={}),g=b.prototype||(b.prototype={});for(f in p&&(s=r),s)d=((c=!h&&y&&void 0!==y[f])?y:s)[f],l=m&&c?u(d,n):v&&"function"==typeof d?u(Function.call,d):d,y&&o(y,f,d,t&e.U),b[f]!=d&&a(b,f,l),v&&g[f]!=d&&(g[f]=d)};n.core=i,s.F=1,s.G=2,s.S=4,s.P=8,s.B=16,s.W=32,s.U=64,s.R=128,e.exports=s},function(e,t,r){"use strict";var n=r(12),i=r(43);e.exports=r(10)?function(e,t,r){return n.f(e,t,i(1,r))}:function(e,t,r){return e[t]=r,e}},function(e,t,r){"use strict";e.exports=function(e){try{return!!e()}catch(e){return!0}}},function(e,t,r){"use strict";var n=r(6),i=r(2).document,a=n(i)&&n(i.createElement);e.exports=function(e){return a?i.createElement(e):{}}},function(e,t,r){"use strict";var n=r(2),i=r(22),a=r(26),o=r(20)("src"),u=r(44),s=(""+u).split("toString");r(4).inspectSource=function(e){return u.call(e)},(e.exports=function(e,t,r,u){var f="function"==typeof r;f&&(a(r,"name")||i(r,"name",t)),e[t]!==r&&(f&&(a(r,o)||i(r,o,e[t]?""+e[t]:s.join(String(t)))),e===n?e[t]=r:u?e[t]?e[t]=r:i(e,t,r):(delete e[t],i(e,t,r)))})(Function.prototype,"toString",function(){return"function"==typeof this&&this[o]||u.call(this)})},function(e,t,r){"use strict";var n={}.hasOwnProperty;e.exports=function(e,t){return n.call(e,t)}},function(e,t,r){"use strict";e.exports={}},function(e,t,r){"use strict";var n=r(29),i=Math.min;e.exports=function(e){return e>0?i(n(e),9007199254740991):0}},function(e,t,r){"use strict";var n=Math.ceil,i=Math.floor;e.exports=function(e){return isNaN(e=+e)?0:(e>0?i:n)(e)}},function(e,t,r){"use strict";var n,i,a,o=r(8),u=r(51),s=r(52),f=r(24),c=r(2),d=c.process,l=c.setImmediate,h=c.clearImmediate,p=c.MessageChannel,v=c.Dispatch,m=0,y={},b=function(){var e=+this;if(y.hasOwnProperty(e)){var t=y[e];delete y[e],t()}},g=function(e){b.call(e.data)};l&&h||(l=function(e){for(var t=[],r=1;arguments.length>r;)t.push(arguments[r++]);return y[++m]=function(){u("function"==typeof e?e:Function(e),t)},n(m),m},h=function(e){delete y[e]},"process"==r(11)(d)?n=function(e){d.nextTick(o(b,e,1))}:v&&v.now?n=function(e){v.now(o(b,e,1))}:p?(a=(i=new p).port2,i.port1.onmessage=g,n=o(a.postMessage,a,1)):c.addEventListener&&"function"==typeof postMessage&&!c.importScripts?(n=function(e){c.postMessage(e+"","*")},c.addEventListener("message",g,!1)):n="onreadystatechange"in f("script")?function(e){s.appendChild(f("script")).onreadystatechange=function(){s.removeChild(this),b.call(e)}}:function(e){setTimeout(o(b,e,1),0)}),e.exports={set:l,clear:h}},function(e,t,r){"use strict";var n=r(9);function i(e){var t,r;this.promise=new e(function(e,n){if(void 0!==t||void 0!==r)throw TypeError("Bad Promise constructor");t=e,r=n}),this.resolve=n(t),this.reject=n(r)}e.exports.f=function(e){return new i(e)}},function(e,t,r){"use strict";var n=r(2).navigator;e.exports=n&&n.userAgent||""},function(e,t,r){"use strict";e.exports=function(e){if(null==e)throw TypeError("Can't call method on  "+e);return e}},function(t,r){t.exports=e},function(e,t,r){"use strict";e.exports=function(e){return null!=e}},function(e,t,r){"use strict";var n,i=r(85),a=(n=i)&&n.__esModule?n:{default:n};e.exports=a.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=o(r(13)),a=o(r(7));function o(e){return e&&e.__esModule?e:{default:e}}var u=function(){function e(t,r,n,o){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),(0,i.default)(this),this.url=t,this.range=r,this.withCredentials=n,this.id=r.join("-"),this.on=!1;var u=new window.XMLHttpRequest;u.target=this,u.responseType="arraybuffer",u.withCredentials=this.withCredentials||!1,u.open("get",t),u.setRequestHeader("Range","bytes="+r[0]+"-"+r[1]),u.onload=function(){200!==u.status&&206!==u.status||o&&o instanceof Function&&o(u.response),u.target.remove()},u.onerror=function(e){u.target.emit("error",new a.default("network","",{line:25,handle:"[Task] constructor",msg:e.message,url:t})),u.target.remove()},u.onabort=function(){u.target.remove()},this.xhr=u,e.queue.push(this),this.update()}return n(e,[{key:"cancel",value:function(){this.xhr.abort()}},{key:"remove",value:function(){var t=this;e.queue.filter(function(r,n){return r.url===t.url&&r.id===t.id&&(e.queue.splice(n,1),!0)}),this.update()}},{key:"update",value:function(){var t=e.queue,r=t.filter(function(e){return e.on}),n=t.filter(function(e){return!e.on}),i=e.limit-r.length;n.forEach(function(e,t){t<i&&e.run()})}},{key:"run",value:function(){1===this.xhr.readyState?(this.on=!0,this.xhr.send()):this.remove()}}],[{key:"clear",value:function(){e.queue.forEach(function(e){e.on&&e.cancel()}),e.queue.length=0}}]),e}();u.queue=[],u.limit=2,window.Task=u,t.default=u,e.exports=t.default},function(e,t,r){e.exports=r(39)},function(e,t,r){"use strict";var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};r(40),r(60);var i=f(r(34)),a=f(r(63)),o=f(r(129)),u=f(r(37)),s=f(r(16));function f(e){return e&&e.__esModule?e:{default:e}}i.default.install("mp4player",function(){var e=this,t=i.default.sniffer,r=i.default.util,f=i.default.Errors,c=void 0,d=void 0,l=e.config.preloadTime||15,h=void 0,p=e.config.url,v=e.config.pluginRule||function(){return!0};if(p){"String"===r.typeOf(p)?c=p:"Array"===r.typeOf(p)&&p.length&&(c=p[0].src,p.length>1&&(d=p[1].src)),e.config._mainURL=c,e.config._backupURL=d;var m=function t(){var r=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e.currentTime;e.timer&&clearTimeout(e.timer),n=Math.max(n,e.currentTime),e.timer=setTimeout(function(){e.mp4.seek(n+.1*r).then(function(t){if(t){var r=e.mse;r.updating=!0,r.appendBuffer(t),r.once("updateend",function(){r.updating=!1})}},function(){r<10&&setTimeout(function(){t(r+1)},2e3)})},50)},y=function(t){var r=new a.default(t,e.config.withCredentials),n=void 0;return new Promise(function(t,i){r.once("moovReady",function(){(n=new o.default).on("sourceopen",function(){n.appendBuffer(r.packMeta()),n.once("updateend",m.bind(e))}),n.on("error",function(e){i(e)}),t([r,n])}),r.on("error",function(e){i(e)})})};if(["chrome","firfox","safari"].some(function(e){return e===t.browser})&&o.default.isSupported('video/mp4; codecs="avc1.64001E, mp4a.40.5"')){if(e._start=e.start,!v.call(e))return!1;var b=function(e,t){t.vid=e.config.vid,t.url=e.src,t.errd&&"object"===n(t.errd)&&e.mp4&&(t.errd.url=e.mp4.url,t.url=e.mp4.url,e.mp4.canDownload=!1),e.emit("DATA_REPORT",t),u.default.clear(),e.mp4&&e.mp4.bufferCache&&e.mp4.bufferCache.clear(),e.currentTime&&(e._currentTime=e.currentTime),e._start&&(e.start=e._start,e._start=null),e.switchURL=null,e._replay=null,clearInterval(e.mp4ProgressTimer),e.off("seeking",w),e.off("pause",_),e.off("playing",x),e.off("waiting",U),e.off("ended",k),e.off("destroy",S),"network"===t.errt&&e.config._backupURL?e.src=e.config._backupURL:e.src=e.config._mainURL,e.once("canplay",function(){e._currentTime&&(e.currentTime=e._currentTime),e.play()})};e.start=function(){var r=arguments.length>0&&void 0!==arguments[0]?arguments[0]:c;y(r).then(function(t){var n=t[0],i=t[1];e._start(i.url),e.logParams.pluginSrc=r,e.mp4=n,e.mse=i,n.on("error",function(t){b(e,t)})},function(t){e._start(r),b(e,t)}),e.once("canplay",function(){if("safari"===t.browser&&e.buffered){var r=e.buffered.start(0);e.currentTime=r+.1}})},e.cut=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,r=arguments[1],n=new s.default,o=new a.default(p,e.config.withCredentials);return new Promise(function(e,a){o.once("moovReady",function(){(!r||r<=t)&&(r=t+15),r>o.meta.duration&&(t=o.meta.duration-(r-t),r=o.meta.duration),o.cut(t,r).then(function(a){if(a){var u=i.default.util.deepCopy({duration:r-t,audioDuration:r-t,endTime:r-t},o.meta);u.duration=r-t,u.videoDuration=r-t,u.audioDuration=r-t,u.endTime=r-t,n.write(o.packMeta(u),a),e(new Blob([n.buffer],{type:'video/mp4; codecs="avc1.64001E, mp4a.40.5"'}))}})}),o.on("error",function(e){a(e)})})},e.switchURL=function(r){var n=new a.default(r,e.config.withCredentials),o=e.mp4;n.on("moovReady",function(){o.timeRage;var a=e.currentTime,u=o.timeRage.find(function(e){return e[0]-a>2})[0],s=e.getBufferedRange()[1];s-u>0&&"safari"!==t.browser&&e.mse.removeBuffer(u,s),i.default.util.hasClass(e.root,"xgplayer-ended")||e.emit("urlchange",JSON.parse(JSON.stringify(e.logParams))),e.logParams={bc:0,bu_acu_t:0,played:[{begin:e.video.currentTime,end:-1}],pt:(new Date).getTime(),vt:(new Date).getTime(),vd:0},e.mp4=n,e.mse.appendBuffer(n.packMeta()),e.logParams.pt=(new Date).getTime(),e.logParams.vt=(new Date).getTime(),e.logParams.vd=e.video.duration,e.logParams.pluginSrc=r}),n.on("error",function(t){b(e,t)})},e.playNext=function(t){var r=new a.default(t,e.config.withCredentials),n=e.mp4;r.on("moovReady",function(){var t=[0,0],i=e.video.buffered,a=e.video.currentTime,o=0;if(i)for(var u=0,s=i.length;u<s;u++)t[0]=i.start(u),t[1]=i.end(u),t[0]<=a&&t[1]<=a&&(o=t[1]>o?t[1]:o,e.mse.removeBuffer(t[0],t[1]));e.mp4=r,e.mse.appendBuffer(r.packMeta());var f=!0;e.on("timeupdate",function(){if(f&&n.meta.endTime-e.currentTime<2){var t=e.getBufferedRange();if(e.currentTime-t[1]<.1&&(f=!1,e.currentTime=0,i=e.video.buffered))for(var r=0,a=i.length;r<a;r++)t[0]=i.start(r),t[1]=i.end(r),t[0]>=o&&e.mse.removeBuffer(t[0],t[1])}})}),r.on("error",function(t){b(e,t)})};var g=function(){var t=e.mse,r=e.mp4;if(t&&!t.updating&&r.canDownload){var n=r.timeRage,i=e.getBufferedRange(),a=e.currentTime+l;if(i[1]-a>0)return;n.every(function(e,t){var n=(e[0]+e[1])/2;return 0!==i[1]&&(!(n>i[1]&&!r.bufferCache.has(t))||void m(0,n))}),function(e,t){if(t.meta.endTime-e.currentTime<2){var r=e.getBufferedRange();e.currentTime-r[1]<.1&&e.mse.endOfStream()}}(e,r)}};e.mp4ProgressTimer=setInterval(g,e.config.mp4ProgressTimer||300);var w=function(){var t=e.buffered,r=!1,n=e.currentTime;if(u.default.clear(),t.length){for(var i=0,a=t.length;i<a;i++)if(n>=t.start(i)&&n<=t.end(i)){r=!0;break}r||m(0,n)}else m(0,e.currentTime)};e.on("seeking",w);var _=function(){u.default.clear()};e.on("pause",_);var x=function(){h&&clearTimeout(h)};e.on("playing",x);var U=function(){var t=e.mp4;if(t&&t.meta){var r=e.getBufferedRange(),n=t.meta.videoDuration;n-e.currentTime<.5&&n-r[1]<.5?e.mse.endOfStream():(m(0,r[1]+1),h=setTimeout(function(){for(var t=e.buffered,r=void 0,n=0,i=t.length;n<i;n++)if((r=t.start(n))>=e.currentTime){e.currentTime=r;break}},1500))}};e.on("waiting",U);var k=function(){e.off("waiting",U),clearInterval(e.mp4ProgressTimer)};e.on("ended",k);var S=function(){u.default.clear(),e.timer&&clearTimeout(e.timer)};e.once("destroy",S),e._replay=function(){u.default.clear(),e.mp4.bufferCache.clear(),y(e.mp4.url).then(function(t){var r=t[0],n=t[1];e._start(n.url),e.mp4=r,e.mse=n,e.currentTime=0,e.play(),e.once("canplay",function(){e.on("waiting",U),e.mp4ProgressTimer=setInterval(g,e.config.mp4ProgressTimer||300)})},function(t){b(e,t)})}}}else e.emit("error",new f("other",e.config.vid))})},function(e,t,r){"use strict";var n,i,a,o,u=r(17),s=r(2),f=r(8),c=r(18),d=r(21),l=r(6),h=r(9),p=r(45),v=r(46),m=r(50),y=r(30).set,b=r(53)(),g=r(31),w=r(54),_=r(32),x=r(55),U=s.TypeError,k=s.process,S=k&&k.versions,T=S&&S.v8||"",B=s.Promise,M="process"==c(k),O=function(){},C=i=g.f,P=!!function(){try{var e=B.resolve(1),t=(e.constructor={})[r(3)("species")]=function(e){e(O,O)};return(M||"function"==typeof PromiseRejectionEvent)&&e.then(O)instanceof t&&0!==T.indexOf("6.6")&&-1===_.indexOf("Chrome/66")}catch(e){}}(),j=function(e){var t;return!(!l(e)||"function"!=typeof(t=e.then))&&t},z=function(e,t){if(!e._n){e._n=!0;var r=e._c;b(function(){for(var n=e._v,i=1==e._s,a=0,o=function(t){var r,a,o,u=i?t.ok:t.fail,s=t.resolve,f=t.reject,c=t.domain;try{u?(i||(2==e._h&&F(e),e._h=1),!0===u?r=n:(c&&c.enter(),r=u(n),c&&(c.exit(),o=!0)),r===t.promise?f(U("Promise-chain cycle")):(a=j(r))?a.call(r,s,f):s(r)):f(n)}catch(e){c&&!o&&c.exit(),f(e)}};r.length>a;)o(r[a++]);e._c=[],e._n=!1,t&&!e._h&&E(e)})}},E=function(e){y.call(s,function(){var t,r,n,i=e._v,a=A(e);if(a&&(t=w(function(){M?k.emit("unhandledRejection",i,e):(r=s.onunhandledrejection)?r({promise:e,reason:i}):(n=s.console)&&n.error&&n.error("Unhandled promise rejection",i)}),e._h=M||A(e)?2:1),e._a=void 0,a&&t.e)throw t.v})},A=function(e){return 1!==e._h&&0===(e._a||e._c).length},F=function(e){y.call(s,function(){var t;M?k.emit("rejectionHandled",e):(t=s.onrejectionhandled)&&t({promise:e,reason:e._v})})},D=function(e){var t=this;t._d||(t._d=!0,(t=t._w||t)._v=e,t._s=2,t._a||(t._a=t._c.slice()),z(t,!0))},L=function e(t){var r,n=this;if(!n._d){n._d=!0,n=n._w||n;try{if(n===t)throw U("Promise can't be resolved itself");(r=j(t))?b(function(){var i={_w:n,_d:!1};try{r.call(t,f(e,i,1),f(D,i,1))}catch(e){D.call(i,e)}}):(n._v=t,n._s=1,z(n,!1))}catch(e){D.call({_w:n,_d:!1},e)}}};P||(B=function(e){p(this,B,"Promise","_h"),h(e),n.call(this);try{e(f(L,this,1),f(D,this,1))}catch(e){D.call(this,e)}},(n=function(e){this._c=[],this._a=void 0,this._s=0,this._d=!1,this._v=void 0,this._h=0,this._n=!1}).prototype=r(56)(B.prototype,{then:function(e,t){var r=C(m(this,B));return r.ok="function"!=typeof e||e,r.fail="function"==typeof t&&t,r.domain=M?k.domain:void 0,this._c.push(r),this._a&&this._a.push(r),this._s&&z(this,!1),r.promise},catch:function(e){return this.then(void 0,e)}}),a=function(){var e=new n;this.promise=e,this.resolve=f(L,e,1),this.reject=f(D,e,1)},g.f=C=function(e){return e===B||e===o?new a(e):i(e)}),d(d.G+d.W+d.F*!P,{Promise:B}),r(57)(B,"Promise"),r(58)("Promise"),o=r(4).Promise,d(d.S+d.F*!P,"Promise",{reject:function(e){var t=C(this);return(0,t.reject)(e),t.promise}}),d(d.S+d.F*(u||!P),"Promise",{resolve:function(e){return x(u&&this===o?B:this,e)}}),d(d.S+d.F*!(P&&r(59)(function(e){B.all(e).catch(O)})),"Promise",{all:function(e){var t=this,r=C(t),n=r.resolve,i=r.reject,a=w(function(){var r=[],a=0,o=1;v(e,!1,function(e){var u=a++,s=!1;r.push(void 0),o++,t.resolve(e).then(function(e){s||(s=!0,r[u]=e,--o||n(r))},i)}),--o||n(r)});return a.e&&i(a.v),r.promise},race:function(e){var t=this,r=C(t),n=r.reject,i=w(function(){v(e,!1,function(e){t.resolve(e).then(r.resolve,n)})});return i.e&&n(i.v),r.promise}})},function(e,t,r){"use strict";e.exports=!r(10)&&!r(23)(function(){return 7!=Object.defineProperty(r(24)("div"),"a",{get:function(){return 7}}).a})},function(e,t,r){"use strict";var n=r(6);e.exports=function(e,t){if(!n(e))return e;var r,i;if(t&&"function"==typeof(r=e.toString)&&!n(i=r.call(e)))return i;if("function"==typeof(r=e.valueOf)&&!n(i=r.call(e)))return i;if(!t&&"function"==typeof(r=e.toString)&&!n(i=r.call(e)))return i;throw TypeError("Can't convert object to primitive value")}},function(e,t,r){"use strict";e.exports=function(e,t){return{enumerable:!(1&e),configurable:!(2&e),writable:!(4&e),value:t}}},function(e,t,r){"use strict";e.exports=r(19)("native-function-to-string",Function.toString)},function(e,t,r){"use strict";e.exports=function(e,t,r,n){if(!(e instanceof t)||void 0!==n&&n in e)throw TypeError(r+": incorrect invocation!");return e}},function(e,t,r){"use strict";var n=r(8),i=r(47),a=r(48),o=r(5),u=r(28),s=r(49),f={},c={},d=e.exports=function(e,t,r,d,l){var h,p,v,m,y=l?function(){return e}:s(e),b=n(r,d,t?2:1),g=0;if("function"!=typeof y)throw TypeError(e+" is not iterable!");if(a(y)){for(h=u(e.length);h>g;g++)if((m=t?b(o(p=e[g])[0],p[1]):b(e[g]))===f||m===c)return m}else for(v=y.call(e);!(p=v.next()).done;)if((m=i(v,b,p.value,t))===f||m===c)return m};d.BREAK=f,d.RETURN=c},function(e,t,r){"use strict";var n=r(5);e.exports=function(e,t,r,i){try{return i?t(n(r)[0],r[1]):t(r)}catch(t){var a=e.return;throw void 0!==a&&n(a.call(e)),t}}},function(e,t,r){"use strict";var n=r(27),i=r(3)("iterator"),a=Array.prototype;e.exports=function(e){return void 0!==e&&(n.Array===e||a[i]===e)}},function(e,t,r){"use strict";var n=r(18),i=r(3)("iterator"),a=r(27);e.exports=r(4).getIteratorMethod=function(e){if(null!=e)return e[i]||e["@@iterator"]||a[n(e)]}},function(e,t,r){"use strict";var n=r(5),i=r(9),a=r(3)("species");e.exports=function(e,t){var r,o=n(e).constructor;return void 0===o||null==(r=n(o)[a])?t:i(r)}},function(e,t,r){"use strict";e.exports=function(e,t,r){var n=void 0===r;switch(t.length){case 0:return n?e():e.call(r);case 1:return n?e(t[0]):e.call(r,t[0]);case 2:return n?e(t[0],t[1]):e.call(r,t[0],t[1]);case 3:return n?e(t[0],t[1],t[2]):e.call(r,t[0],t[1],t[2]);case 4:return n?e(t[0],t[1],t[2],t[3]):e.call(r,t[0],t[1],t[2],t[3])}return e.apply(r,t)}},function(e,t,r){"use strict";var n=r(2).document;e.exports=n&&n.documentElement},function(e,t,r){"use strict";var n=r(2),i=r(30).set,a=n.MutationObserver||n.WebKitMutationObserver,o=n.process,u=n.Promise,s="process"==r(11)(o);e.exports=function(){var e,t,r,f=function(){var n,i;for(s&&(n=o.domain)&&n.exit();e;){i=e.fn,e=e.next;try{i()}catch(n){throw e?r():t=void 0,n}}t=void 0,n&&n.enter()};if(s)r=function(){o.nextTick(f)};else if(!a||n.navigator&&n.navigator.standalone)if(u&&u.resolve){var c=u.resolve(void 0);r=function(){c.then(f)}}else r=function(){i.call(n,f)};else{var d=!0,l=document.createTextNode("");new a(f).observe(l,{characterData:!0}),r=function(){l.data=d=!d}}return function(n){var i={fn:n,next:void 0};t&&(t.next=i),e||(e=i,r()),t=i}}},function(e,t,r){"use strict";e.exports=function(e){try{return{e:!1,v:e()}}catch(e){return{e:!0,v:e}}}},function(e,t,r){"use strict";var n=r(5),i=r(6),a=r(31);e.exports=function(e,t){if(n(e),i(t)&&t.constructor===e)return t;var r=a.f(e);return(0,r.resolve)(t),r.promise}},function(e,t,r){"use strict";var n=r(25);e.exports=function(e,t,r){for(var i in t)n(e,i,t[i],r);return e}},function(e,t,r){"use strict";var n=r(12).f,i=r(26),a=r(3)("toStringTag");e.exports=function(e,t,r){e&&!i(e=r?e:e.prototype,a)&&n(e,a,{configurable:!0,value:t})}},function(e,t,r){"use strict";var n=r(2),i=r(12),a=r(10),o=r(3)("species");e.exports=function(e){var t=n[e];a&&t&&!t[o]&&i.f(t,o,{configurable:!0,get:function(){return this}})}},function(e,t,r){"use strict";var n=r(3)("iterator"),i=!1;try{var a=[7][n]();a.return=function(){i=!0},Array.from(a,function(){throw 2})}catch(e){}e.exports=function(e,t){if(!t&&!i)return!1;var r=!1;try{var a=[7],o=a[n]();o.next=function(){return{done:r=!0}},a[n]=function(){return o},e(a)}catch(e){}return r}},function(e,t,r){"use strict";var n=r(21),i=r(61),a=r(32),o=/Version\/10\.\d+(\.\d+)?( Mobile\/\w+)? Safari\//.test(a);n(n.P+n.F*o,"String",{padStart:function(e){return i(this,e,arguments.length>1?arguments[1]:void 0,!0)}})},function(e,t,r){"use strict";var n=r(28),i=r(62),a=r(33);e.exports=function(e,t,r,o){var u=String(a(e)),s=u.length,f=void 0===r?" ":String(r),c=n(t);if(c<=s||""==f)return u;var d=c-s,l=i.call(f,Math.ceil(d/f.length));return l.length>d&&(l=l.slice(0,d)),o?l+u:u+l}},function(e,t,r){"use strict";var n=r(29),i=r(33);e.exports=function(e){var t=String(i(this)),r="",a=n(e);if(a<0||a==1/0)throw RangeError("Count can't be negative");for(;a>0;(a>>>=1)&&(t+=t))1&a&&(r+=t);return r}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=l(r(13)),a=l(r(82)),o=l(r(83)),u=l(r(16)),s=l(r(127)),f=l(r(37)),c=l(r(128)),d=l(r(7));function l(e){return e&&e.__esModule?e:{default:e}}var h=function(){function e(t,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:Math.pow(25,4);!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),(0,i.default)(this),this.url=t,this.withCredentials=r,this.CHUNK_SIZE=n,this.init(t),this.once("moovReady",this.moovParse.bind(this)),this.cache=new u.default,this.bufferCache=new Set,this.timeRage=[],this.canDownload=!0}return n(e,[{key:"getData",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:t+this.CHUNK_SIZE,n=this;return new Promise(function(i,a){new f.default(e.url,[t,r],e.withCredentials,i).once("error",function(e){n.emit("error",e)})})}},{key:"moovParse",value:function(){var e=this,t=this,r=this.moovBox,n=c.default.findBox(r,"mvhd"),i=c.default.findBox(r,"trak"),o=void 0,u=void 0,s=void 0,f=void 0,l=void 0,h=void 0,p=void 0,v=void 0,m=void 0,y=void 0,b=void 0,g=void 0,w=void 0,_=void 0;i.forEach(function(e){var r=c.default.findBox(e,"hdlr"),n=c.default.findBox(e,"mdhd");if(r&&n){var i=c.default.findBox(e,"stsd").subBox[0];if("vide"===r.handleType){var a=c.default.findBox(e,"avcC"),x=c.default.findBox(e,"tkhd");o=e,l=n.timescale,a?(s=i.type+"."+c.default.toHex(a.profile,a.profileCompatibility,a.AVCLevelIndication).join(""),p=a.sequence&&a.sequence.map(function(e){return Number("0x"+e)}),v=a.pps&&a.pps.map(function(e){return Number("0x"+e)}),m=a.profile):s=""+i.type,x&&(y=x.width,b=x.height)}if("soun"===r.handleType){u=e;var U=c.default.findBox(e,"esds"),k=c.default.findBox(e,"mp4a"),S=c.default.findBox(e,5);h=n.timescale,f=U?i.type+"."+c.default.toHex(U.subBox[0].subBox[0].typeID)+"."+U.subBox[0].subBox[0].subBox[0].type:""+i.type,S&&S.EScode&&(_=S.EScode.map(function(e){return Number("0x"+e)})),k&&(g=k.channelCount,w=k.sampleRate)}}else t.emit("error",new d.default("parse","",{line:72,handle:"[MP4] moovParse",url:t.url}))}),this.videoTrak=(0,a.default)({},o),this.audioTrak=(0,a.default)({},u);var x=this._boxes.find(function(e){return"mdat"===e.type}),U=c.default.seekTrakDuration(o,l),k=c.default.seekTrakDuration(u,h);this.mdatStart=x.start;var S=this.videoKeyFrames,T=S.length-1;S.forEach(function(t,r){r<T?e.timeRage.push([t.time.time/l,S[r+1].time.time/l]):e.timeRage.push([t.time.time/l,-1])}),this.meta={videoCodec:s,audioCodec:f,createTime:n.createTime,modifyTime:n.modifyTime,duration:n.duration/n.timeScale,timeScale:n.timeScale,videoDuration:U,videoTimeScale:l,audioDuration:k,audioTimeScale:h,endTime:Math.min(U,k),sps:p,pps:v,width:y,height:b,profile:m,pixelRatio:[1,1],channelCount:g,sampleRate:w,audioConfig:_}}},{key:"init",value:function(){var e=this;e.getData().then(function(t){var r=void 0,n=0,i=void 0,a=void 0;try{r=new o.default(t)}catch(t){return e.emit("error",t.type?t:new d.default("parse","",{line:176,handle:"[MP4] init",msg:t.message})),!1}if(e._boxes=a=r.boxes,a.every(function(t){return n+=t.size,"moov"!==t.type||(i=t,e.moovBox=i,e.emit("moovReady",i),!1)}),!i){var u=r.nextBox;u?"moov"===u.type?e.getData(n,n+u.size+28).then(function(t){var r=new o.default(t);e._boxes=e._boxes.concat(r.boxes),(i=r.boxes.filter(function(e){return"moov"===e.type})).length?(e.moovBox=i[0],e.emit("moovReady",i)):e.emit("error",new d.default("parse","",{line:203,handle:"[MP4] init",msg:"not find moov box"}))}):e.emit("error",new d.default("parse","",{line:207,handle:"[MP4] init",msg:"not find moov box"})):e.getData(n,"").then(function(t){var r=new o.default(t);r?(e._boxes=e._boxes.concat(r.boxes),r.boxes.every(function(t){return"moov"!==t.type||(i=t,e.moovBox=i,e.emit("moovReady",i),!1)})):e.emit("error",new d.default("parse","",{line:225,handle:"[MP4] init",msg:"not find moov box"}))})}}).catch(function(){e.emit("error",new d.default("network","",{line:231,handle:"[MP4] getData",msg:"getData failed"}))})}},{key:"getSamplesByOrders",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"video",t=arguments[1],r=arguments[2],n="video"===e?this.videoTrak:this.audioTrak,i=c.default.findBox(n,"stsc"),a=c.default.findBox(n,"stsz"),o=c.default.findBox(n,"stts"),u=c.default.findBox(n,"stco"),s=c.default.findBox(n,"ctts"),f=this.mdatStart,d=[];if(r=void 0!==r?r:a.entries.length,t instanceof Array)t.forEach(function(e,t){d.push({idx:e,size:a.entries[e],time:c.default.seekSampleTime(o,s,e),offset:c.default.seekSampleOffset(i,u,a,e,f)})});else if(0!==r)for(var l=t;l<r;l++)d.push({idx:l,size:a.entries[l],time:c.default.seekSampleTime(o,s,l),offset:c.default.seekSampleOffset(i,u,a,l,f)});else d={idx:t,size:a.entries[t],time:c.default.seekSampleTime(o,s,t),offset:c.default.seekSampleOffset(i,u,a,t,f)};return d}},{key:"packMeta",value:function(){if(this.meta){var e=new u.default;return e.write(s.default.ftyp()),e.write(s.default.moov(this.meta)),this.cache.write(e.buffer),e.buffer}}},{key:"seek",value:function(e){var t=e*this.meta.videoTimeScale,r=void 0,n=this.videoKeyFrames,i=this.audioKeyFrames;return n.every(function(e,i){var a=e.time.time,o=n[i+1]?n[i+1].time.time:Number.MAX_SAFE_INTEGER;return!(a<=t&&t<o)||(r=i,!1)}),i.every(function(e,n){var a=e.startTime,o=i[n+1]?i[n+1].startTime:Number.MAX_SAFE_INTEGER;return!(a<=t&&t<o)||(r=Math.min(n,r),!1)}),this.bufferCache.has(r)?Promise.resolve(null):this.loadFragment(r)}},{key:"loadFragment",value:function(e){var t,r=void 0,n=this.videoKeyFrames[e],i=this.getSamplesByOrders("audio",this.audioKeyFrames[e].order,0);if(t=Math.min(n.offset,i.offset),e<this.videoKeyFrames.length-1){var a=this.videoKeyFrames[e+1],o=this.getSamplesByOrders("audio",this.audioKeyFrames[e+1].order,0);r=Math.max(a.offset,o.offset)}var u=this;return window.isNaN(t)||void 0!==r&&window.isNaN(r)?(u.emit("error",new d.default("parse","",{line:366,handle:"[MP4] loadFragment",url:u.url})),!1):this.bufferCache.has(e)?Promise.resolve(null):this.getData(t+u.mdatStart,r?u.mdatStart+r:"").then(function(r){return u.createFragment(new Uint8Array(r),t,e)})}},{key:"addFragment",value:function(e){var t=new u.default;return t.write(s.default.moof(e)),t.write(s.default.mdat(e)),this.cache.write(t.buffer),t.buffer}},{key:"createFragment",value:function(e,t,r){var n=[];this.bufferCache.add(r);var i=this.videoKeyFrames.map(function(e){return e.idx}),a=this.getSamplesByOrders("video",i[r],i[r+1]),o=a.map(function(r,n){return{size:r.size,duration:r.time.duration,offset:r.time.offset,buffer:new Uint8Array(e.slice(r.offset-t,r.offset-t+r.size)),key:0===n}});n.push(this.addFragment({id:1,time:a[0].time.time,firstFlags:33554432,flags:3841,samples:o}));var u=this.getSamplesByOrders("audio",this.audioKeyFrames[r].order,this.audioKeyFrames[r+1]?this.audioKeyFrames[r+1].order:void 0),s=u.map(function(r,n){return{size:r.size,duration:r.time.duration,offset:r.time.offset,buffer:new Uint8Array(e.slice(r.offset-t,r.offset-t+r.size)),key:0===n}});n.push(this.addFragment({id:2,time:u[0].time.time,firstFlags:0,flags:1793,samples:s}));var f=0;n.every(function(e){return f+=e.byteLength,!0});var c=new Uint8Array(f),d=0;return n.every(function(e){return c.set(e,d),d+=e.byteLength,!0}),Promise.resolve(c)}},{key:"download",value:function(){}},{key:"cut",value:function(e,t){this.bufferCache.clear();var r=e*this.meta.videoTimeScale,n=t*this.meta.videoTimeScale,i=void 0,a=void 0,o=this.videoKeyFrames,u=this.audioKeyFrames;return o.every(function(e,t){var u=e.time.time,s=o[t+1]?o[t+1].time.time:Number.MAX_SAFE_INTEGER;return u<=r&&r<s?(i=t,!0):!(u<=n&&n<s)||(a=t,!1)}),u.every(function(e,t){var o=e.startTime,s=u[t+1]?u[t+1].startTime:Number.MAX_SAFE_INTEGER;return o<=r&&r<s?(i=Math.min(t,i),!0):!(o<=n&&n<s)||(a=Math.min(t,a),!1)}),a||(a=o.length),this.loadFragmentForCut(i,a)}},{key:"loadFragmentForCut",value:function(e,t){var r,n,i=this.videoKeyFrames[e],a=this.getSamplesByOrders("audio",this.audioKeyFrames[e].order,0);r=Math.min(i.offset,a.offset);var o=this.videoKeyFrames[t],u=this.getSamplesByOrders("audio",this.audioKeyFrames[t].order,0);n=Math.max(o.offset,u.offset);var s=this;return window.isNaN(r)||void 0!==n&&window.isNaN(n)?(s.emit("error",new d.default("parse","",{line:366,handle:"[MP4] loadFragment",url:s.url})),!1):this.getData(r+s.mdatStart,n?s.mdatStart+n:"").then(function(i){return s.createFragmentForCut(new Uint8Array(i),r,e,n,t)})}},{key:"createFragmentForCut",value:function(e,t,r,n,i){var a=[],o=this.videoKeyFrames.map(function(e){return e.idx}),u=this.getSamplesByOrders("video",o[r],o[i]).map(function(r,n){return{size:r.size,duration:r.time.duration,offset:r.time.offset,buffer:new Uint8Array(e.slice(r.offset-t,r.offset-t+r.size)),key:0===n}});a.push(this.addFragment({id:1,time:0,firstFlags:33554432,flags:3841,samples:u}));var s=this.getSamplesByOrders("audio",this.audioKeyFrames[r].order,this.audioKeyFrames[i]?this.audioKeyFrames[i].order:void 0).map(function(r,n){return{size:r.size,duration:r.time.duration,offset:r.time.offset,buffer:new Uint8Array(e.slice(r.offset-t,r.offset-t+r.size)),key:0===n}});a.push(this.addFragment({id:2,time:0,firstFlags:0,flags:1793,samples:s}));var f=0;a.every(function(e){return f+=e.byteLength,!0});var c=new Uint8Array(f),d=0;return a.every(function(e){return c.set(e,d),d+=e.byteLength,!0}),Promise.resolve(c)}},{key:"videoKeyFrames",get:function(){if(this._videoFrames)return this._videoFrames;var e=this.videoTrak,t=c.default.findBox(e,"stss"),r=this.getSamplesByOrders("video",t.entries.map(function(e){return e-1}));return this._videoFrames=r,r}},{key:"audioKeyFrames",get:function(){if(this._audioFrames)return this._audioFrames;var e,t=c.default.findBox(this.videoTrak,"mdhd").timescale,r=c.default.findBox(this.audioTrak,"mdhd").timescale,n=c.default.findBox(this.audioTrak,"stts").entry;return e=this.videoKeyFrames.map(function(e){return c.default.seekOrderSampleByTime(n,r,e.time.time/t)}),this._audioFrames=e,this._audioFrames}}]),e}();t.default=h,e.exports=t.default},function(e,t,r){"use strict";var n=r(35),i=r(65),a=r(69),o=r(77),u=r(78);(e.exports=function(e,t){var r,i,s,f,c;return arguments.length<2||"string"!=typeof e?(f=t,t=e,e=null):f=arguments[2],n(e)?(r=u.call(e,"c"),i=u.call(e,"e"),s=u.call(e,"w")):(r=s=!0,i=!1),c={value:t,configurable:r,enumerable:i,writable:s},f?a(o(f),c):c}).gs=function(e,t,r){var s,f,c,d;return"string"!=typeof e?(c=r,r=t,t=e,e=null):c=arguments[3],n(t)?i(t)?n(r)?i(r)||(c=r,r=void 0):r=void 0:(c=t,t=r=void 0):t=void 0,n(e)?(s=u.call(e,"c"),f=u.call(e,"e")):(s=!0,f=!1),d={get:t,set:r,configurable:s,enumerable:f},c?a(o(c),d):d}},function(e,t,r){"use strict";var n=r(66),i=/^\s*class[\s{\/}]/,a=Function.prototype.toString;e.exports=function(e){return!!n(e)&&!i.test(a.call(e))}},function(e,t,r){"use strict";var n=r(67);e.exports=function(e){if("function"!=typeof e)return!1;if(!hasOwnProperty.call(e,"length"))return!1;try{if("number"!=typeof e.length)return!1;if("function"!=typeof e.call)return!1;if("function"!=typeof e.apply)return!1}catch(e){return!1}return!n(e)}},function(e,t,r){"use strict";var n=r(68);e.exports=function(e){if(!n(e))return!1;try{return!!e.constructor&&e.constructor.prototype===e}catch(e){return!1}}},function(e,t,r){"use strict";var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},i=r(35),a={object:!0,function:!0,undefined:!0};e.exports=function(e){return!!i(e)&&hasOwnProperty.call(a,void 0===e?"undefined":n(e))}},function(e,t,r){"use strict";e.exports=r(70)()?Object.assign:r(71)},function(e,t,r){"use strict";e.exports=function(){var e,t=Object.assign;return"function"==typeof t&&(t(e={foo:"raz"},{bar:"dwa"},{trzy:"trzy"}),e.foo+e.bar+e.trzy==="razdwatrzy")}},function(e,t,r){"use strict";var n=r(72),i=r(76),a=Math.max;e.exports=function(e,t){var r,o,u,s=a(arguments.length,2);for(e=Object(i(e)),u=function(n){try{e[n]=t[n]}catch(e){r||(r=e)}},o=1;o<s;++o)t=arguments[o],n(t).forEach(u);if(void 0!==r)throw r;return e}},function(e,t,r){"use strict";e.exports=r(73)()?Object.keys:r(74)},function(e,t,r){"use strict";e.exports=function(){try{return Object.keys("primitive"),!0}catch(e){return!1}}},function(e,t,r){"use strict";var n=r(14),i=Object.keys;e.exports=function(e){return i(n(e)?Object(e):e)}},function(e,t,r){"use strict";e.exports=function(){}},function(e,t,r){"use strict";var n=r(14);e.exports=function(e){if(!n(e))throw new TypeError("Cannot use null or undefined");return e}},function(e,t,r){"use strict";var n=r(14),i=Array.prototype.forEach,a=Object.create,o=function(e,t){var r;for(r in e)t[r]=e[r]};e.exports=function(e){var t=a(null);return i.call(arguments,function(e){n(e)&&o(Object(e),t)}),t}},function(e,t,r){"use strict";e.exports=r(79)()?String.prototype.contains:r(80)},function(e,t,r){"use strict";var n="razdwatrzy";e.exports=function(){return"function"==typeof n.contains&&(!0===n.contains("dwa")&&!1===n.contains("foo"))}},function(e,t,r){"use strict";var n=String.prototype.indexOf;e.exports=function(e){return n.call(this,e,arguments[1])>-1}},function(e,t,r){"use strict";e.exports=function(e){if("function"!=typeof e)throw new TypeError(e+" is not a function");return e}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},i=function(e){return function(e){return!!e&&"object"===(void 0===e?"undefined":n(e))}(e)&&!function(e){var t=Object.prototype.toString.call(e);return"[object RegExp]"===t||"[object Date]"===t||function(e){return e.$$typeof===a}(e)}(e)};var a="function"==typeof Symbol&&Symbol.for?Symbol.for("react.element"):60103;function o(e,t){return!1!==t.clone&&t.isMergeableObject(e)?s((r=e,Array.isArray(r)?[]:{}),e,t):e;var r}function u(e,t,r){return e.concat(t).map(function(e){return o(e,r)})}function s(e,t,r){(r=r||{}).arrayMerge=r.arrayMerge||u,r.isMergeableObject=r.isMergeableObject||i;var n=Array.isArray(t);return n===Array.isArray(e)?n?r.arrayMerge(e,t,r):function(e,t,r){var n={};return r.isMergeableObject(e)&&Object.keys(e).forEach(function(t){n[t]=o(e[t],r)}),Object.keys(t).forEach(function(i){r.isMergeableObject(t[i])&&e[i]?n[i]=s(e[i],t[i],r):n[i]=o(t[i],r)}),n}(e,t,r):o(t,r)}s.all=function(e,t){if(!Array.isArray(e))throw new Error("first argument should be an array");return e.reduce(function(e,r){return s(e,r,t)},{})};var f=s;t.default=f,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=V(r(0)),i=V(r(36)),a=V(r(1)),o=V(r(86)),u=V(r(87)),s=V(r(88)),f=V(r(89)),c=V(r(90)),d=V(r(91)),l=V(r(92)),h=V(r(93)),p=V(r(94)),v=V(r(95)),m=V(r(96)),y=V(r(97)),b=V(r(98)),g=V(r(99)),w=V(r(100)),_=V(r(101)),x=V(r(102)),U=V(r(103)),k=V(r(104)),S=V(r(105)),T=V(r(106)),B=V(r(107)),M=V(r(108)),O=V(r(109)),C=V(r(110)),P=V(r(111)),j=V(r(112)),z=V(r(113)),E=V(r(114)),A=V(r(115)),F=V(r(116)),D=V(r(117)),L=V(r(118)),R=V(r(119)),I=V(r(120)),N=V(r(121)),K=V(r(122)),q=V(r(123)),H=V(r(124)),G=V(r(125));function V(e){return e&&e.__esModule?e:{default:e}}var X={};function J(e,t,r){var n=e;t.map(function(e,i){n[e]=i==t.length-1?r:n[e]||{},n=n[e]})}J(X,["box","avc1"],V(r(126)).default),J(X,["box","avcC"],G.default),J(X,["box","btrt"],H.default),J(X,["box","co64"],q.default),J(X,["box","ctts"],K.default),J(X,["box","dref"],N.default),J(X,["box","elst"],I.default),J(X,["box","esds"],R.default),J(X,["box","ftyp"],L.default),J(X,["box","hdlr"],D.default),J(X,["box","hmhd"],F.default),J(X,["box","iods"],A.default),J(X,["box","mdat"],E.default),J(X,["box","mdhd"],z.default),J(X,["box","mfhd"],j.default),J(X,["box","mp4a"],P.default),J(X,["box","MP4DecConfigDescrTag"],C.default),J(X,["box","MP4DecSpecificDescrTag"],O.default),J(X,["box","MP4ESDescrTag"],M.default),J(X,["box","mvhd"],B.default),J(X,["box","nmhd"],T.default),J(X,["box","pasp"],S.default),J(X,["box","sbgp"],k.default),J(X,["box","sdtp"],U.default),J(X,["box","SLConfigDescriptor"],x.default),J(X,["box","smhd"],_.default),J(X,["box","stco"],w.default),J(X,["box","stsc"],g.default),J(X,["box","stsd"],b.default),J(X,["box","stsh"],y.default),J(X,["box","stss"],m.default),J(X,["box","stsz"],v.default),J(X,["box","stts"],p.default),J(X,["box","stz2"],h.default),J(X,["box","tfhd"],l.default),J(X,["box","tkhd"],d.default),J(X,["box","traf"],c.default),J(X,["box","trun"],f.default),J(X,["box","udta"],s.default),J(X,["box","url"],u.default),J(X,["box","vmhd"],o.default);t.default=function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.buffer=null,this.boxes=[],this.nextBox=null,this.start=0;this.buffer?(0,i.default)(Uint8Array,this.buffer,t):this.buffer=t;var r=t.byteLength;t.position=0;for(var o=new a.default(t);r-o.position>=8;){var u=new n.default;if(u.readHeader(o),u.size-8<=r-o.position)u.readBody(o),this.boxes.push(u);else{if("mdat"!==u.type){this.nextBox=u,o.position-=8;break}u.readBody(o),this.boxes.push(u)}}this.buffer=new Uint8Array(this.buffer.slice(o.position))},e.exports=t.default},function(e){e.exports=JSON.parse('{"name":"xgplayer-mp4","version":"1.1.8","description":"xgplayer plugin for mp4 transform to fmp4","main":"./dist/index.js","scripts":{"prepare":"npm run build","build":"webpack --progress --display-chunks -p","watch":"webpack --progress --display-chunks -p --watch","test":"karma start --single-run","test:watch":"karma start"},"repository":{"type":"git","url":"git@github.com:bytedance/xgplayer.git"},"babel":{"presets":["es2015"],"plugins":["add-module-exports","babel-plugin-bulk-import"]},"keywords":["mp4","fmp4","player","video"],"author":"yinguohui@bytedance.com","license":"MIT","dependencies":{"concat-typed-array":"^1.0.2","deepmerge":"^2.0.1","event-emitter":"^0.3.5"},"peerDependency":{"xgplayer":"^0.1.0"},"devDependencies":{"babel-core":"^6.26.3","babel-loader":"^7.1.4","babel-plugin-add-module-exports":"^0.2.1","babel-plugin-bulk-import":"^1.0.2","babel-preset-es2015":"^6.24.1","chai":"^4.1.2","json-loader":"^0.5.7","karma":"^3.0.0","karma-mocha":"^1.3.0","karma-sourcemap-loader":"^0.3.7","karma-spec-reporter":"0.0.32","karma-chrome-launcher":"^2.2.0","karma-webpack":"^4.0.0-rc.1","mocha":"^5.2.0","webpack":"^4.11.0"}}')},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){for(var t=0,r=arguments.length,n=Array(r>1?r-1:0),i=1;i<r;i++)n[i-1]=arguments[i];var a=!0,o=!1,u=void 0;try{for(var s,f=n[Symbol.iterator]();!(a=(s=f.next()).done);a=!0){var c=s.value;t+=c.length}}catch(e){o=!0,u=e}finally{try{!a&&f.return&&f.return()}finally{if(o)throw u}}var d=new e(t),l=0,h=!0,p=!1,v=void 0;try{for(var m,y=n[Symbol.iterator]();!(h=(m=y.next()).done);h=!0){var b=m.value;d.set(b,l),l+=b.length}}catch(e){p=!0,v=e}finally{try{!h&&y.return&&y.return()}finally{if(p)throw v}}return d}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.vmhd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=[e.readUint8(),e.readUint8(),e.readUint8()],this.graphicsmode=e.readUint16(),this.opcolor=[e.readUint16(),e.readUint16(),e.readUint16()],delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default["url "]=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=[e.readUint8(),e.readUint8(),e.readUint8()];for(var t=[],r=e.buffer.byteLength;e.position<r;)t.push(e.readUint8());this.location=t,delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n,i=r(0);((n=i)&&n.__esModule?n:{default:n}).default.udta=function(){delete this.subBox}},function(e,t,r){},function(e,t,r){},function(e,t,r){"use strict";var n=o(r(0)),i=o(r(1)),a=o(r(15));function o(e){return e&&e.__esModule?e:{default:e}}n.default.tkhd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3,0),1===this.version?(this.create=e.readUint64(),this.modify=e.readUint64(),this.createTime=(new a.default).setTime(1e3*this.create),this.modifyTime=(new a.default).setTime(1e3*this.modify),this.trackID=e.readUint32(),this.reserverd=e.readUint32(),this.duration=e.readUint64()):(this.create=e.readUint32(),this.modify=e.readUint32(),this.createTime=(new a.default).setTime(1e3*this.create),this.modifyTime=(new a.default).setTime(1e3*this.modify),this.trackID=e.readUint32(),this.reserverd=e.readUint32(),this.duration=e.readUint32()),e.readUint64(),this.layer=e.readInt16(),this.alternate_group=e.readInt16(),this.volume=e.readInt16()>>8,e.readUint16();for(var t=[],r=0;r<9;r++)t.push(e.readUint16()+"."+e.readUint16());this.matrix=t,this.width=e.readUint16()+"."+e.readUint16(),this.height=e.readUint16()+"."+e.readUint16(),delete this.data,delete this.subBox,e=null}},function(e,t,r){},function(e,t,r){},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stts=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.count=e.readUint32();for(var t=[],r=0,n=this.count;r<n;r++)t.push({sampleCount:e.readUint32(),sampleDuration:e.readUint32()});this.entry=t,delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stsz=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.sampleSize=e.readUint32(),this.count=e.readUint32();var t=[];this.entries=t;for(var r=0,n=this.count;r<n;r++)t.push(e.readUint32());delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stss=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.count=e.readUint32();var t=[];this.entries=t;for(var r=0,n=this.count;r<n;r++)t.push(e.readUint32());delete this.subBox,delete this.data,e=null}},function(e,t,r){},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stsd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.entryCount=e.readUint32();var t=new n.default;t.readHeader(e),this.subBox.push(t),t.readBody(e),delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stsc=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.count=e.readUint32();var t=[];this.entries=t;for(var r=0,n=this.count;r<n;r++)t.push({first_chunk:e.readUint32(),samples_per_chunk:e.readUint32(),sample_desc_index:e.readUint32()});for(var a,o,u=0,s=this.count;u<s-1;u++)a=t[u],o=t[u-1],a.chunk_count=t[u+1].first_chunk-a.first_chunk,a.first_sample=0===u?1:o.first_sample+o.chunk_count*o.samples_per_chunk;if(1===this.count){var f=t[0];f.first_sample=1,f.chunk_count=0}else if(this.count>1){var c=t[this.count-1],d=t[this.count-2];c.first_sample=d.first_sample+d.chunk_count*d.samples_per_chunk,c.chunk_count=0}delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.stco=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.count=e.readUint32();var t=[];this.entries=t;for(var r=0,n=this.count;r<n;r++)t.push(e.readUint32());delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.smhd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.balance=e.readInt8()+"."+e.readInt8(),delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n,i=r(0),a=(n=i)&&n.__esModule?n:{default:n};a.default.SLConfigDescriptor=function(e){var t=new a.default,r=void 0;return t.type=e.readUint8(),128===(r=e.readUint8())?(t.extend=!0,e.skip(2),r=e.readUint8()+5):r+=2,t.size=r,t.SL=e.readUint8(),delete t.subBox,t}},function(e,t,r){},function(e,t,r){},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.pasp=function(){var e=new i.default(this.data);this.content=e.buffer.slice(0,this.size-8),delete this.subBox,delete this.data,e=null}},function(e,t,r){},function(e,t,r){"use strict";var n=o(r(0)),i=o(r(1)),a=o(r(15));function o(e){return e&&e.__esModule?e:{default:e}}n.default.mvhd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.create=e.readUint32(),this.modify=e.readUint32(),this.createTime=(new a.default).setTime(1e3*this.create),this.modifyTime=(new a.default).setTime(1e3*this.modify),this.timeScale=e.readUint32(),this.duration=e.readUint32(),this.rate=e.readUint16()+"."+e.readUint16(),this.volume=e.readUint8()+"."+e.readUint8(),i.default.readByte(e.dataview,8),i.default.readByte(e.dataview,2);for(var t=[],r=0;r<9;r++)t.push(e.readUint16()+"."+e.readUint16());this.matrix=t,i.default.readByte(e.dataview,24),this.nextTrackID=e.readUint32(),delete this.subBox,delete this.data}},function(e,t,r){"use strict";var n,i=r(0),a=(n=i)&&n.__esModule?n:{default:n};a.default.MP4ESDescrTag=function(e){var t=new a.default,r=void 0;return t.type=e.readUint8(),128===(r=e.readUint8())?(t.extend=!0,e.skip(2),r=e.readUint8()+5):r+=2,t.size=r,t.esID=e.readUint16(),t.priority=e.readUint8(),t.subBox.push(a.default.MP4DecConfigDescrTag(e)),t.subBox.push(a.default.SLConfigDescriptor(e)),t}},function(e,t,r){"use strict";var n,i=r(0),a=(n=i)&&n.__esModule?n:{default:n};a.default.MP4DecSpecificDescrTag=function(e){var t=new a.default,r=void 0,n=void 0;t.type=e.readUint8(),128===(r=e.readUint8())?(t.extend=!0,e.skip(2),n=(r=e.readUint8()+5)-5):(n=r,r+=2),t.size=r;for(var i=[],o=0;o<n;o++)i.push(Number(e.readUint8()).toString(16).padStart(2,"0"));return t.EScode=i,delete t.subBox,t}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.MP4DecConfigDescrTag=function(e){var t=new n.default,r=void 0;return t.type=e.readUint8(),128===(r=e.readUint8())?(t.extend=!0,e.skip(2),r=e.readUint8()+5):r+=2,t.size=r,t.typeID=e.readUint8(),t.streamUint=e.readUint8(),t.bufferSize=i.default.readByte(e.dataview,3),t.maximum=e.readUint32(),t.average=e.readUint32(),t.subBox.push(n.default.MP4DecSpecificDescrTag(e)),t}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.mp4a=function(){var e=new i.default(this.data);e.skip(6),this.dataReferenceIndex=e.readUint16(),e.skip(8),this.channelCount=e.readUint16(),this.sampleSize=e.readUint16(),e.skip(4),this.sampleRate=e.readUint32()>>16;var t=new n.default;t.readHeader(e),this.subBox.push(t),t.readBody(e),delete this.data,e=null}},function(e,t,r){},function(e,t,r){"use strict";var n=o(r(0)),i=o(r(1)),a=o(r(15));function o(e){return e&&e.__esModule?e:{default:e}}n.default.mdhd=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),1===this.version?(this.create=e.readUint64(),this.modify=e.readUint64(),this.createTime=(new a.default).setTime(1e3*this.create),this.modifyTime=(new a.default).setTime(1e3*this.modify),this.timescale=e.readUint32(),this.duration=e.readUint64()):(this.create=e.readUint32(),this.modify=e.readUint32(),this.createTime=(new a.default).setTime(1e3*this.create),this.modifyTime=(new a.default).setTime(1e3*this.modify),this.timescale=e.readUint32(),this.duration=e.readUint32()),this.language=e.readUint16(),e.readUint16(),delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n,i=r(0);((n=i)&&n.__esModule?n:{default:n}).default.mdat=function(){delete this.subBox}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.iods=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3);for(var t=[],r=e.buffer.byteLength;e.position<r;)t.push(e.readUint8());this.content=t,delete this.subBox,delete this.data,e=null}},function(e,t,r){},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.hdlr=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),e.skip(4),this.handleType=""+String.fromCharCode(e.readUint8())+String.fromCharCode(e.readUint8())+String.fromCharCode(e.readUint8())+String.fromCharCode(e.readUint8()),e.skip(12);for(var t=[];e.position<this.size-8;)t.push(String.fromCharCode(e.readUint8()));this.name=t.join(""),delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.ftyp=function(){var e=new i.default(this.data);this.major_brand=String.fromCharCode(e.readUint8(),e.readUint8(),e.readUint8(),e.readUint8()),this.minor_version=e.readUint32();for(var t=[],r=0,n=Math.floor((e.buffer.byteLength-8)/4);r<n;r++)t.push(String.fromCharCode(e.readUint8(),e.readUint8(),e.readUint8(),e.readUint8()));this.compatible_brands=t,e=null,delete this.subBox,delete this.data}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.esds=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3);var t=n.default.MP4ESDescrTag(e);this.subBox.push(t),delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.elst=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3);var t=[],r=e.readUint32();this.entries=t;for(var n=0;n<r;n++){var a={};t.push(a),1===this.version?(a.segment_duration=e.readUint64(),a.media_time=e.readUint64()):(a.segment_duration=e.readUint32(),a.media_time=e.readInt32()),a.media_rate_integer=e.readInt16(),a.media_rate_fraction=e.readInt16()}delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.dref=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3);var t=e.readUint32();this.entryCount=t;for(var r=0;r<t;r++){var a=new n.default;this.subBox.push(a),a.read(e)}delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.ctts=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.entryCount=e.readUint32();var t=[];this.entry=t;for(var r=0,n=this.entryCount;r<n;r++)t.push({count:e.readUint32(),offset:e.readUint32()});delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.co64=function(){var e=new i.default(this.data);this.version=e.readUint8(),this.flag=i.default.readByte(e.dataview,3),this.count=e.readUint32();var t=[];this.entries=t;for(var r=0,n=this.count;r<n;r++)t.push(e.readUint64());delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.btrt=function(){var e=new i.default(this.data);this.bufferSizeDB=e.readUint32(),this.maxBitrate=e.readUint32(),this.avgBitrate=e.readUint32(),delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.avcC=function(){var e=new i.default(this.data);this.configVersion=e.readUint8(),this.profile=e.readUint8(),this.profileCompatibility=e.readUint8(),this.AVCLevelIndication=e.readUint8(),this.lengthSizeMinusOne=1+(3&e.readUint8()),this.numOfSequenceParameterSets=31&e.readUint8();var t=e.readUint16();this.sequenceLength=t;for(var r=[],n=0;n<t;n++)r.push(Number(e.readUint8()).toString(16));this.ppsCount=e.readUint8();var a=e.readUint16();this.ppsLength=a;for(var o=[],u=0;u<a;u++)o.push(Number(e.readUint8()).toString(16));this.pps=o,this.sequence=r;for(var s=[],f=e.dataview.byteLength;e.position<f;)s.push(e.readUint8());this.last=s,delete this.subBox,delete this.data,e=null}},function(e,t,r){"use strict";var n=a(r(0)),i=a(r(1));function a(e){return e&&e.__esModule?e:{default:e}}n.default.avc1=function(){var e=new i.default(this.data);e.skip(6),this.dataReferenceIndex=e.readUint16(),e.skip(16),this.width=e.readUint16(),this.height=e.readUint16(),this.horizresolution=e.readUint32(),this.vertresolution=e.readUint32(),e.skip(4),this.frameCount=e.readUint16(),e.skip(1);for(var t=0;t<31;t++)String.fromCharCode(e.readUint8());for(this.depth=e.readUint16(),e.skip(2);e.position<e.buffer.byteLength;){var r=new n.default;r.readHeader(e),this.subBox.push(r),r.readBody(e)}delete this.data,e=null}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n,i=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),a=r(16),o=(n=a)&&n.__esModule?n:{default:n};var u=Math.pow(2,32)-1,s=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}return i(e,null,[{key:"type",value:function(e){return new Uint8Array([e.charCodeAt(0),e.charCodeAt(1),e.charCodeAt(2),e.charCodeAt(3)])}},{key:"size",value:function(e){return o.default.writeUint32(e)}},{key:"extension",value:function(e,t){return new Uint8Array([e,t>>16&255,t>>8&255,255&t])}},{key:"ftyp",value:function(){var t=new o.default;return t.write(e.size(24),e.type("ftyp"),new Uint8Array([105,115,111,109,0,0,0,1,105,115,111,109,97,118,99,49])),t.buffer}},{key:"moov",value:function(t){var r=new o.default,n=8,i=e.mvhd(t.duration,t.timeScale),a=e.videoTrak(t),u=e.audioTrak(t),s=e.mvex(t.duration,t.timeScale);return[i,a,u,s].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("moov"),i,a,u,s),r.buffer}},{key:"mvhd",value:function(t,r){var n=new o.default;t*=r;var i=Math.floor(t/(u+1)),a=Math.floor(t%(u+1)),s=new Uint8Array([1,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,r>>24&255,r>>16&255,r>>8&255,255&r,i>>24,i>>16&255,i>>8&255,255&i,a>>24,a>>16&255,a>>8&255,255&a,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,64,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,255,255,255,255]);return n.write(e.size(8+s.length),e.type("mvhd"),new Uint8Array(s)),n.buffer}},{key:"videoTrak",value:function(t){var r=new o.default,n=8,i=e.tkhd({id:1,duration:t.videoDuration,timescale:t.videoTimeScale,width:t.width,height:t.height,type:"video"}),a=e.mdia({type:"video",timescale:t.videoTimeScale,duration:t.videoDuration,sps:t.sps,pps:t.pps,pixelRatio:t.pixelRatio,width:t.width,height:t.height});return[i,a].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("trak"),i,a),r.buffer}},{key:"audioTrak",value:function(t){var r=new o.default,n=8,i=e.tkhd({id:2,duration:t.audioDuration,timescale:t.audioTimeScale,width:0,height:0,type:"audio"}),a=e.mdia({type:"audio",timescale:t.audioTimeScale,duration:t.audioDuration,channelCount:t.channelCount,samplerate:t.sampleRate,audioConfig:t.audioConfig});return[i,a].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("trak"),i,a),r.buffer}},{key:"tkhd",value:function(t){var r=new o.default,n=t.id,i=t.duration*t.timeScale,a=t.width,s=t.height,f=t.type,c=Math.floor(i/(u+1)),d=Math.floor(i%(u+1)),l=new Uint8Array([1,0,0,7,0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,n>>24&255,n>>16&255,n>>8&255,255&n,0,0,0,0,c>>24,c>>16&255,c>>8&255,255&c,d>>24,d>>16&255,d>>8&255,255&d,0,0,0,0,0,0,0,0,0,0,0,"video"===f?1:0,"audio"===f?1:0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,64,0,0,0,a>>8&255,255&a,0,0,s>>8&255,255&s,0,0]);return r.write(e.size(8+l.byteLength),e.type("tkhd"),l),r.buffer}},{key:"edts",value:function(t){var r=new o.default,n=t.duration,i=t.mediaTime;return r.write(e.size(36),e.type("edts")),r.write(e.size(28),e.type("elst")),r.write(new Uint8Array([0,0,0,1,n>>24&255,n>>16&255,n>>8&255,255&n,i>>24&255,i>>16&255,i>>8&255,255&i,0,0,0,1])),r.buffer}},{key:"mdia",value:function(t){var r=new o.default,n=8,i=e.mdhd(t.timescale),a=e.hdlr(t.type),u=e.minf(t);return[i,a,u].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("mdia"),i,a,u),r.buffer}},{key:"mdhd",value:function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,n=new o.default;r*=t;var i=Math.floor(r/(u+1)),a=Math.floor(r%(u+1)),s=new Uint8Array([0,0,0,0,0,0,0,2,0,0,0,0,0,0,0,3,t>>24&255,t>>16&255,t>>8&255,255&t,i>>24,i>>16&255,i>>8&255,255&i,a>>24,a>>16&255,a>>8&255,255&a,85,196,0,0]);return n.write(e.size(12+s.byteLength),e.type("mdhd"),e.extension(1,0),s),n.buffer}},{key:"hdlr",value:function(t){var r=new o.default,n=[0,0,0,0,0,0,0,0,118,105,100,101,0,0,0,0,0,0,0,0,0,0,0,0,86,105,100,101,111,72,97,110,100,108,101,114,0];return"audio"===t&&(n.splice.apply(n,[8,4].concat([115,111,117,110])),n.splice.apply(n,[24,13].concat([83,111,117,110,100,72,97,110,100,108,101,114,0]))),r.write(e.size(8+n.length),e.type("hdlr"),new Uint8Array(n)),r.buffer}},{key:"minf",value:function(t){var r=new o.default,n=8,i="video"===t.type?e.vmhd():e.smhd(),a=e.dinf(),u=e.stbl(t);return[i,a,u].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("minf"),i,a,u),r.buffer}},{key:"vmhd",value:function(){var t=new o.default;return t.write(e.size(20),e.type("vmhd"),new Uint8Array([0,0,0,1,0,0,0,0,0,0,0,0])),t.buffer}},{key:"smhd",value:function(){var t=new o.default;return t.write(e.size(16),e.type("smhd"),new Uint8Array([0,0,0,0,0,0,0,0])),t.buffer}},{key:"dinf",value:function(){var t=new o.default;return t.write(e.size(36),e.type("dinf"),e.size(28),e.type("dref"),new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,12,117,114,108,32,0,0,0,1])),t.buffer}},{key:"stbl",value:function(t){var r=new o.default,n=8,i=e.stsd(t),a=e.stts(),u=e.stsc(),s=e.stsz(),f=e.stco();return[i,a,u,s,f].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("stbl"),i,a,u,s,f),r.buffer}},{key:"stsd",value:function(t){var r=new o.default,n=void 0;return n="audio"===t.type?e.mp4a(t):e.avc1(t),r.write(e.size(16+n.byteLength),e.type("stsd"),e.extension(0,0),new Uint8Array([0,0,0,1]),n),r.buffer}},{key:"mp4a",value:function(t){var r=new o.default,n=new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,t.channelCount,0,16,0,0,0,0,t.samplerate>>8&255,255&t.samplerate,0,0]),i=e.esds(t.audioConfig);return r.write(e.size(8+n.byteLength+i.byteLength),e.type("mp4a"),n,i),r.buffer}},{key:"esds",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[43,146,8,0],r=t.length,n=new o.default,i=new Uint8Array([0,0,0,0,3,23+r,0,1,0,4,15+r,64,21,0,0,0,0,0,0,0,0,0,0,0,5].concat([r]).concat(t).concat([6,1,2]));return n.write(e.size(8+i.byteLength),e.type("esds"),i),n.buffer}},{key:"avc1",value:function(t){var r=new o.default,n=t.sps,i=t.pps,a=t.width,u=t.height,s=t.pixelRatio[0],f=t.pixelRatio[1],c=new Uint8Array([1,n[1],n[2],n[3],255,225].concat([n.length>>>8&255,255&n.length]).concat(n).concat(1).concat([i.length>>>8&255,255&i.length]).concat(i)),d=new Uint8Array([0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,a>>8&255,255&a,u>>8&255,255&u,0,72,0,0,0,72,0,0,0,0,0,0,0,1,18,100,97,105,108,121,109,111,116,105,111,110,47,104,108,115,46,106,115,0,0,0,0,0,0,0,0,0,0,0,0,0,0,24,17,17]),l=new Uint8Array([0,28,156,128,0,45,198,192,0,45,198,192]),h=new Uint8Array([s>>24,s>>16&255,s>>8&255,255&s,f>>24,f>>16&255,f>>8&255,255&f]);return r.write(e.size(40+d.byteLength+c.byteLength+l.byteLength),e.type("avc1"),d,e.size(8+c.byteLength),e.type("avcC"),c,e.size(20),e.type("btrt"),l,e.size(16),e.type("pasp"),h),r.buffer}},{key:"stts",value:function(){var t=new o.default,r=new Uint8Array([0,0,0,0,0,0,0,0]);return t.write(e.size(16),e.type("stts"),r),t.buffer}},{key:"stsc",value:function(){var t=new o.default,r=new Uint8Array([0,0,0,0,0,0,0,0]);return t.write(e.size(16),e.type("stsc"),r),t.buffer}},{key:"stco",value:function(){var t=new o.default,r=new Uint8Array([0,0,0,0,0,0,0,0]);return t.write(e.size(16),e.type("stco"),r),t.buffer}},{key:"stsz",value:function(){var t=new o.default,r=new Uint8Array([0,0,0,0,0,0,0,0,0,0,0,0]);return t.write(e.size(20),e.type("stsz"),r),t.buffer}},{key:"mvex",value:function(t,r){var n=new o.default,i=o.default.writeUint32(t*r);return n.write(e.size(88),e.type("mvex"),e.size(16),e.type("mehd"),e.extension(0,0),i,e.trex(1),e.trex(2)),n.buffer}},{key:"trex",value:function(t){var r=new o.default,n=new Uint8Array([0,0,0,0,t>>24,t>>16&255,t>>8&255,255&t,0,0,0,1,0,0,0,0,0,0,0,0,0,1,0,1]);return r.write(e.size(8+n.byteLength),e.type("trex"),n),r.buffer}},{key:"moof",value:function(t){var r=new o.default,n=8,i=e.mfhd(),a=e.traf(t);return[i,a].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("moof"),i,a),r.buffer}},{key:"mfhd",value:function(){var t=new o.default,r=o.default.writeUint32(e.sequence);return e.sequence+=1,t.write(e.size(16),e.type("mfhd"),e.extension(0,0),r),t.buffer}},{key:"traf",value:function(t){var r=new o.default,n=8,i=e.tfhd(t.id),a=e.tfdt(t.time),u=e.sdtp(t),s=e.trun(t,u.byteLength);return[i,a,u,s].forEach(function(e){n+=e.byteLength}),r.write(e.size(n),e.type("traf"),i,a,u,s),r.buffer}},{key:"tfhd",value:function(t){var r=new o.default,n=o.default.writeUint32(t);return r.write(e.size(16),e.type("tfhd"),e.extension(0,0),n),r.buffer}},{key:"tfdt",value:function(t){var r=new o.default,n=Math.floor(t/(u+1)),i=Math.floor(t%(u+1));return r.write(e.size(20),e.type("tfdt"),e.extension(1,0),o.default.writeUint32(n),o.default.writeUint32(i)),r.buffer}},{key:"trun",value:function(t,r){var n=t.id,i=1===n?16:12,a=new o.default,u=o.default.writeUint32(t.samples.length),s=o.default.writeUint32(96+i*t.samples.length+r);return a.write(e.size(20+i*t.samples.length),e.type("trun"),e.extension(0,t.flags),u,s),t.samples.forEach(function(e,t){a.write(o.default.writeUint32(e.duration)),a.write(o.default.writeUint32(e.size)),1===n?(a.write(o.default.writeUint32(e.key?33554432:16842752)),a.write(o.default.writeUint32(e.offset))):a.write(o.default.writeUint32(16777216))}),a.buffer}},{key:"sdtp",value:function(t){var r=new o.default;return r.write(e.size(12+t.samples.length),e.type("sdtp"),e.extension(0,0)),t.samples.forEach(function(e){r.write(new Uint8Array(1===t.id?[e.key?32:16]:[16]))}),r.buffer}},{key:"mdat",value:function(t){var r=new o.default,n=8;return t.samples.forEach(function(e){n+=e.size}),r.write(e.size(n),e.type("mdat")),t.samples.forEach(function(e){r.write(e.buffer)}),r.buffer}}]),e}();s.sequence=1,t.default=s,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n={findBox:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];if(e.type!==t){if(e&&e.subBox){var i=e.subBox.filter(function(e){return e.type===t});i.length?i.forEach(function(e){return r.push(e)}):e.subBox.forEach(function(e){return n.findBox(e,t,r)})}}else r.push(e);return(r=[].concat(r)).length>1?r:r[0]},padStart:function(e,t,r){for(var n=String(r),i=t>>0,a=Math.ceil(i/n.length),o=[],u=String(e);a--;)o.push(n);return o.join("").substring(0,i-u.length)+u},toHex:function(){for(var e=[],t=arguments.length,r=Array(t),i=0;i<t;i++)r[i]=arguments[i];return r.forEach(function(t){e.push(n.padStart(Number(t).toString(16),2,0))}),e},sum:function(){for(var e=0,t=arguments.length,r=Array(t),n=0;n<t;n++)r[n]=arguments[n];return r.forEach(function(t){e+=t}),e},stscOffset:function(e,t){var r=e.entries.filter(function(e){return e.first_sample<=t&&t<e.first_sample+e.chunk_count*e.samples_per_chunk})[0];if(r){var n=Math.floor((t-r.first_sample)/r.samples_per_chunk),i=r.first_sample+n*r.samples_per_chunk;return{chunk_index:r.first_chunk+n,samples_offset:[i,t]}}var a=e.entries.pop();e.entries.push(a);var o=Math.floor((t-a.first_sample)/a.samples_per_chunk);return{chunk_index:a.first_chunk+o,samples_offset:[a.first_sample+a.samples_per_chunk*o,t]}},seekSampleOffset:function(e,t,r,i,a){var o=n.stscOffset(e,i+1),u=t.entries[o.chunk_index-1]+n.sum.apply(null,r.entries.slice(o.samples_offset[0]-1,o.samples_offset[1]-1))-a;if(void 0===u)throw"result="+u+",stco.length="+t.entries.length+",sum="+n.sum.apply(null,r.entries.slice(0,i));if(u<0)throw"result="+u+",stco.length="+t.entries.length+",sum="+n.sum.apply(null,r.entries.slice(0,i));return u},seekSampleTime:function(e,t,r){var n=void 0,i=void 0,a=0,o=0,u=0;if(e.entry.every(function(e){return i=e.sampleDuration,r<a+e.sampleCount?(n=o+(r-a)*e.sampleDuration,!1):(a+=e.sampleCount,o+=e.sampleCount*i,!0)}),t){var s=0;t.entry.every(function(e){return s+=e.count,!(r<s)||(u=e.offset,!1)})}return n||(n=o+(r-a)*i),{time:n,duration:i,offset:u}},seekOrderSampleByTime:function(e,t,r){var n=0,i=0,a=0,o=void 0;return e.every(function(e,u){return o=e.sampleCount*e.sampleDuration/t,r<=n+o?(i=a+Math.ceil((r-n)*t/e.sampleDuration),n+=Math.ceil((r-n)*t/e.sampleDuration)*e.sampleDuration/t,!1):(n+=o,a+=e.sampleCount,!0)}),{order:i,startTime:n}},seekTrakDuration:function(e,t){var r=n.findBox(e,"stts"),i=0;return r.entry.forEach(function(e){i+=e.sampleCount*e.sampleDuration}),Number(i/t).toFixed(4)}};t.default=n,e.exports=t.default},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=o(r(13)),a=o(r(7));function o(e){return e&&e.__esModule?e:{default:e}}var u=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:'video/mp4; codecs="avc1.64001E, mp4a.40.5"';!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e);var r=this;(0,i.default)(this),this.codecs=t,this.mediaSource=new window.MediaSource,this.url=window.URL.createObjectURL(this.mediaSource),this.queue=[],this.updating=!1,this.mediaSource.addEventListener("sourceopen",function(){r.sourceBuffer=r.mediaSource.addSourceBuffer(r.codecs),r.sourceBuffer.addEventListener("error",function(e){r.emit("error",new a.default("mse","",{line:16,handle:"[MSE] constructor sourceopen",msg:e.message}))}),r.sourceBuffer.addEventListener("updateend",function(e){r.emit("updateend");var t=r.queue.shift();t&&r.sourceBuffer&&!r.sourceBuffer.updating&&"open"===r.state&&r.sourceBuffer.appendBuffer(t)}),r.emit("sourceopen")}),this.mediaSource.addEventListener("sourceclose",function(){r.emit("sourceclose")})}return n(e,[{key:"appendBuffer",value:function(e){var t=this.sourceBuffer;return t&&!t.updating&&"open"===this.state?(t.appendBuffer(e),!0):(this.queue.push(e),!1)}},{key:"removeBuffer",value:function(e,t){this.sourceBuffer.remove(e,t)}},{key:"endOfStream",value:function(){"open"===this.state&&this.mediaSource.endOfStream()}},{key:"state",get:function(){return this.mediaSource.readyState}},{key:"duration",get:function(){return this.mediaSource.duration},set:function(e){this.mediaSource.duration=e}}],[{key:"isSupported",value:function(e){return window.MediaSource&&window.MediaSource.isTypeSupported(e)}}]),e}();t.default=u,e.exports=t.default}])});
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "./node_modules/_xgplayer@2.6.15@xgplayer/dist/index.js":
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["xgplayer"] = factory();
	else
		root["xgplayer"] = factory();
})(window, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

var _proxy = __webpack_require__(10);

var _proxy2 = _interopRequireDefault(_proxy);

var _util = __webpack_require__(3);

var _util2 = _interopRequireDefault(_util);

var _database = __webpack_require__(30);

var _database2 = _interopRequireDefault(_database);

var _sniffer = __webpack_require__(6);

var _sniffer2 = _interopRequireDefault(_sniffer);

var _error = __webpack_require__(4);

var _error2 = _interopRequireDefault(_error);

var _draggabilly = __webpack_require__(31);

var _draggabilly2 = _interopRequireDefault(_draggabilly);

var _url = __webpack_require__(36);

var _downloadjs = __webpack_require__(37);

var _downloadjs2 = _interopRequireDefault(_downloadjs);

var _package = __webpack_require__(5);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var Player = function (_Proxy) {
  _inherits(Player, _Proxy);

  function Player(options) {
    _classCallCheck(this, Player);

    var _this = _possibleConstructorReturn(this, (Player.__proto__ || Object.getPrototypeOf(Player)).call(this, options));

    _this.config = _util2.default.deepCopy({
      width: 600,
      height: 337.5,
      ignores: [],
      whitelist: [],
      lang: (document.documentElement.getAttribute('lang') || navigator.language || 'zh-cn').toLocaleLowerCase(),
      inactive: 3000,
      volume: 0.6,
      controls: true,
      controlsList: ['nodownload']
    }, options);
    _this.version = _package.version;
    _this.userTimer = null;
    _this.waitTimer = null;
    _this.database = new _database2.default();
    _this.history = [];
    _this.isProgressMoving = false;
    _this.root = _util2.default.findDom(document, '#' + _this.config.id);
    _this.controls = _util2.default.createDom('xg-controls', '', {
      unselectable: 'on',
      onselectstart: 'return false'
    }, 'xgplayer-controls');
    if (_this.config.isShowControl) {
      _this.controls.style.display = 'none';
    }
    if (!_this.root) {
      var el = _this.config.el;
      if (el && el.nodeType === 1) {
        _this.root = el;
      } else {
        var _ret;

        _this.emit('error', new _error2.default({
          type: 'use',
          errd: {
            line: 45,
            handle: 'Constructor',
            msg: 'container id can\'t be empty'
          },
          vid: _this.config.vid
        }));
        console.error('container id can\'t be empty');
        return _ret = false, _possibleConstructorReturn(_this, _ret);
      }
    }
    // this.rootBackup = util.copyDom(this.root)
    _util2.default.addClass(_this.root, 'xgplayer xgplayer-' + _sniffer2.default.device + ' xgplayer-nostart ' + (_this.config.controls ? '' : 'no-controls'));
    _this.root.appendChild(_this.controls);
    if (_this.config.fluid) {
      _this.root.style['max-width'] = '100%';
      _this.root.style['width'] = '100%';
      _this.root.style['height'] = '0';
      _this.root.style['padding-top'] = _this.config.height * 100 / _this.config.width + '%';

      _this.video.style['position'] = 'absolute';
      _this.video.style['top'] = '0';
      _this.video.style['left'] = '0';
    } else {
      // this.root.style.width = `${this.config.width}px`
      // this.root.style.height = `${this.config.height}px`
      if (_this.config.width) {
        if (typeof _this.config.width !== 'number') {
          _this.root.style.width = _this.config.width;
        } else {
          _this.root.style.width = _this.config.width + 'px';
        }
      }
      if (_this.config.height) {
        if (typeof _this.config.height !== 'number') {
          _this.root.style.height = _this.config.height;
        } else {
          _this.root.style.height = _this.config.height + 'px';
        }
      }
    }
    if (_this.config.execBeforePluginsCall) {
      _this.config.execBeforePluginsCall.forEach(function (item) {
        item.call(_this, _this);
      });
    }
    if (_this.config.controlStyle && _util2.default.typeOf(_this.config.controlStyle) === 'String') {
      var self = _this;
      fetch(self.config.controlStyle, {
        method: 'GET',
        headers: {
          Accept: 'application/json'
        }
      }).then(function (res) {
        if (res.ok) {
          res.json().then(function (obj) {
            for (var prop in obj) {
              if (obj.hasOwnProperty(prop)) {
                self.config[prop] = obj[prop];
              }
            }
            self.pluginsCall();
          });
        }
      }).catch(function (err) {
        console.log('Fetch错误:' + err);
      });
    } else {
      _this.pluginsCall();
    }
    _this.ev.forEach(function (item) {
      var evName = Object.keys(item)[0];
      var evFunc = _this[item[evName]];
      if (evFunc) {
        _this.on(evName, evFunc);
      }
    });

    ['focus', 'blur'].forEach(function (item) {
      _this.on(item, _this['on' + item.charAt(0).toUpperCase() + item.slice(1)]);
    });
    var player = _this;
    _this.mousemoveFunc = function () {
      player.emit('focus');
      if (!player.config.closeFocusVideoFocus) {
        player.video.focus();
      }
    };
    _this.root.addEventListener('mousemove', _this.mousemoveFunc);
    _this.playFunc = function () {
      player.emit('focus');
      if (!player.config.closePlayVideoFocus) {
        player.video.focus();
      }
    };
    player.once('play', _this.playFunc);

    _this.getVideoSize = function () {
      if (this.video.videoWidth && this.video.videoHeight) {
        var containerSize = player.root.getBoundingClientRect();
        if (player.config.fitVideoSize === 'auto') {
          if (containerSize.width / containerSize.height > this.video.videoWidth / this.video.videoHeight) {
            player.root.style.height = this.video.videoHeight / this.video.videoWidth * containerSize.width + 'px';
          } else {
            player.root.style.width = this.video.videoWidth / this.video.videoHeight * containerSize.height + 'px';
          }
        } else if (player.config.fitVideoSize === 'fixWidth') {
          player.root.style.height = this.video.videoHeight / this.video.videoWidth * containerSize.width + 'px';
        } else if (player.config.fitVideoSize === 'fixHeight') {
          player.root.style.width = this.video.videoWidth / this.video.videoHeight * containerSize.height + 'px';
        }
      }
    };
    player.once('loadeddata', _this.getVideoSize);

    setTimeout(function () {
      _this.emit('ready');
      _this.isReady = true;
    }, 0);

    if (!_this.config.keyShortcut || _this.config.keyShortcut === 'on') {
      ['video', 'controls'].forEach(function (item) {
        player[item].addEventListener('keydown', function (e) {
          player.onKeydown(e, player);
        });
      });
    }
    if (_this.config.videoInit) {
      if (_util2.default.hasClass(_this.root, 'xgplayer-nostart')) {
        _this.start();
      }
    }
    if (player.config.rotate) {
      player.on('requestFullscreen', _this.updateRotateDeg);
      player.on('exitFullscreen', _this.updateRotateDeg);
    }

    function onDestroy() {
      player.root.removeEventListener('mousemove', player.mousemoveFunc);
      player.off('destroy', onDestroy);
    }
    player.once('destroy', onDestroy);
    return _this;
  }

  _createClass(Player, [{
    key: 'start',
    value: function start() {
      var _this2 = this;

      var url = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.config.url;

      var root = this.root;
      var player = this;
      if (!url || url === '') {
        this.emit('urlNull');
      }
      this.logParams.playSrc = url;
      this.canPlayFunc = function () {
        var playPromise = player.video.play();
        if (playPromise !== undefined && playPromise) {
          playPromise.then(function () {
            player.emit('autoplay started');
          }).catch(function () {
            player.emit('autoplay was prevented');
            Player.util.addClass(player.root, 'xgplayer-is-autoplay');
          });
        }
        player.off('canplay', player.canPlayFunc);
      };
      if (_util2.default.typeOf(url) === 'String') {
        if (url.indexOf('blob:') > -1 && url === this.video.src) {
          // 在Chromium环境下用mse url给video二次赋值会导致错误
        } else {
          this.video.src = url;
        }
      } else {
        url.forEach(function (item) {
          _this2.video.appendChild(_util2.default.createDom('source', '', {
            src: '' + item.src,
            type: '' + (item.type || '')
          }));
        });
      }
      this.logParams.pt = new Date().getTime();
      this.logParams.vt = this.logParams.pt;
      this.loadeddataFunc = function () {
        player.logParams.vt = new Date().getTime();
        if (player.logParams.pt > player.logParams.vt) {
          player.logParams.pt = player.logParams.vt;
        }
        player.logParams.vd = player.video.duration;
      };
      this.once('loadeddata', this.loadeddataFunc);
      if (this.config.autoplay) {
        this.on('canplay', this.canPlayFunc);
      }
      root.insertBefore(this.video, root.firstChild);
      setTimeout(function () {
        _this2.emit('complete');
      }, 1);
    }
  }, {
    key: 'reload',
    value: function reload() {
      this.video.load();
      this.reloadFunc = function () {
        // eslint-disable-next-line handle-callback-err
        var playPromise = this.play();
        if (playPromise !== undefined && playPromise) {
          playPromise.catch(function (err) {});
        }
      };
      this.once('loadeddata', this.reloadFunc);
    }
  }, {
    key: 'destroy',
    value: function destroy() {
      var _this3 = this;

      var isDelDom = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      var player = this;
      clearInterval(this.bulletResizeTimer);
      for (var k in this._interval) {
        clearInterval(this._interval[k]);
        this._interval[k] = null;
      }
      if (this.checkTimer) {
        clearInterval(this.checkTimer);
      }
      if (this.waitTimer) {
        clearTimeout(this.waitTimer);
      }
      this.ev.forEach(function (item) {
        var evName = Object.keys(item)[0];
        var evFunc = _this3[item[evName]];
        if (evFunc) {
          _this3.off(evName, evFunc);
        }
      });
      if (this.loadeddataFunc) {
        this.off('loadeddata', this.loadeddataFunc);
      }
      if (this.reloadFunc) {
        this.off('loadeddata', this.reloadFunc);
      }
      if (this.replayFunc) {
        this.off('play', this.replayFunc);
      }
      if (this.playFunc) {
        this.off('play', this.playFunc);
      }
      if (this.getVideoSize) {
        this.off('loadeddata', this.getVideoSize);
      };
      ['focus', 'blur'].forEach(function (item) {
        _this3.off(item, _this3['on' + item.charAt(0).toUpperCase() + item.slice(1)]);
      });
      if (!this.config.keyShortcut || this.config.keyShortcut === 'on') {
        ['video', 'controls'].forEach(function (item) {
          if (_this3[item]) {
            _this3[item].removeEventListener('keydown', function (e) {
              player.onKeydown(e, player);
            });
          }
        });
      }

      function destroyFunc() {
        this.emit('destroy');
        // this.root.id = this.root.id + '_del'
        // parentNode.insertBefore(this.rootBackup, this.root)

        // fix video destroy https://stackoverflow.com/questions/3258587/how-to-properly-unload-destroy-a-video-element
        this.video.removeAttribute('src'); // empty source
        this.video.load();
        if (isDelDom) {
          // parentNode.removeChild(this.root)
          this.root.innerHTML = '';
          var classNameList = this.root.className.split(' ');
          if (classNameList.length > 0) {
            this.root.className = classNameList.filter(function (name) {
              return name.indexOf('xgplayer') < 0;
            }).join(' ');
          } else {
            this.root.className = '';
          }
        }

        for (var _k in this) {
          // if (k !== 'config') {
          delete this[_k];
          // }
        }
        this.off('pause', destroyFunc);
      }

      if (!this.paused) {
        this.pause();
        this.once('pause', destroyFunc);
      } else {
        destroyFunc.call(this);
      }
      _get(Player.prototype.__proto__ || Object.getPrototypeOf(Player.prototype), 'destroy', this).call(this);
    }
  }, {
    key: 'replay',
    value: function replay() {
      var self = this;
      var _replay = this._replay;
      // ie9 bugfix
      _util2.default.removeClass(this.root, 'xgplayer-ended');
      this.logParams = {
        bc: 0,
        bu_acu_t: 0,
        played: [],
        pt: new Date().getTime(),
        vt: new Date().getTime(),
        vd: 0
      };
      this.logParams.pt = new Date().getTime();
      this.logParams.vt = this.logParams.pt;
      this.replayFunc = function () {
        self.logParams.vt = new Date().getTime();
        if (self.logParams.pt > self.logParams.vt) {
          self.logParams.pt = self.logParams.vt;
        }
        self.logParams.vd = self.video.duration;
      };
      this.once('play', this.replayFunc);
      this.logParams.playSrc = this.video.currentSrc;
      if (_replay && _replay instanceof Function) {
        _replay();
      } else {
        this.currentTime = 0;
        // eslint-disable-next-line handle-callback-err
        var playPromise = this.play();
        if (playPromise !== undefined && playPromise) {
          playPromise.catch(function (err) {});
        }
      }
    }
  }, {
    key: 'getFullscreen',
    value: function getFullscreen(el) {
      var player = this;
      if (el.requestFullscreen) {
        el.requestFullscreen();
      } else if (el.mozRequestFullScreen) {
        el.mozRequestFullScreen();
      } else if (el.webkitRequestFullscreen) {
        el.webkitRequestFullscreen(window.Element.ALLOW_KEYBOARD_INPUT);
      } else if (player.video.webkitSupportsFullscreen) {
        player.video.webkitEnterFullscreen();
      } else if (el.msRequestFullscreen) {
        el.msRequestFullscreen();
      } else {
        _util2.default.addClass(el, 'xgplayer-is-cssfullscreen');
      }
    }
  }, {
    key: 'exitFullscreen',
    value: function exitFullscreen(el) {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
      _util2.default.removeClass(el, 'xgplayer-is-cssfullscreen');
    }
  }, {
    key: 'getCssFullscreen',
    value: function getCssFullscreen() {
      var player = this;
      if (player.config.fluid) {
        player.root.style['padding-top'] = '';
      }
      _util2.default.addClass(player.root, 'xgplayer-is-cssfullscreen');
      player.emit('requestCssFullscreen');
    }
  }, {
    key: 'exitCssFullscreen',
    value: function exitCssFullscreen() {
      var player = this;
      if (player.config.fluid) {
        player.root.style['width'] = '100%';
        player.root.style['height'] = '0';
        player.root.style['padding-top'] = player.config.height * 100 / player.config.width + '%';
      }
      _util2.default.removeClass(player.root, 'xgplayer-is-cssfullscreen');
      player.emit('exitCssFullscreen');
    }
  }, {
    key: 'getRotateFullscreen',
    value: function getRotateFullscreen() {
      var player = this;
      document.documentElement.style.width = '100%';
      document.documentElement.style.height = '100%';
      if (player.root && !Player.util.hasClass(player.root, 'xgplayer-rotate-fullscreen')) {
        Player.util.addClass(player.root, 'xgplayer-rotate-fullscreen');
      }
      player.emit('getRotateFullscreen');
    }
  }, {
    key: 'exitRotateFullscreen',
    value: function exitRotateFullscreen() {
      var player = this;
      document.documentElement.style.width = 'unset';
      document.documentElement.style.height = 'unset';
      if (player.root && Player.util.hasClass(player.root, 'xgplayer-rotate-fullscreen')) {
        Player.util.removeClass(player.root, 'xgplayer-rotate-fullscreen');
      }
      player.emit('exitRotateFullscreen');
    }
  }, {
    key: 'download',
    value: function download() {
      var url = (0, _url.getAbsoluteURL)(this.config.url);
      (0, _downloadjs2.default)(url);
    }
  }, {
    key: 'pluginsCall',
    value: function pluginsCall() {
      var _this4 = this;

      var self = this;
      if (Player.plugins) {
        var ignores = this.config.ignores;
        Object.keys(Player.plugins).forEach(function (name) {
          var descriptor = Player.plugins[name];
          if (!ignores.some(function (item) {
            return name === item || name === 's_' + item;
          })) {
            if (['pc', 'tablet', 'mobile'].some(function (type) {
              return type === name;
            })) {
              if (name === _sniffer2.default.device) {
                setTimeout(function () {
                  descriptor.call(self, self);
                }, 0);
              }
            } else {
              descriptor.call(_this4, _this4);
            }
          }
        });
      }
    }
  }, {
    key: 'getPIP',
    value: function getPIP() {
      // let ro = this.root.getBoundingClientRect()
      // let Top = ro.top
      // let Left = ro.left
      var dragLay = _util2.default.createDom('xg-pip-lay', '<div></div>', {}, 'xgplayer-pip-lay');
      this.root.appendChild(dragLay);
      var dragHandle = _util2.default.createDom('xg-pip-drag', '<div class="drag-handle"><span>点击按住可拖动视频</span></div>', { tabindex: 9 }, 'xgplayer-pip-drag');
      this.root.appendChild(dragHandle);
      // eslint-disable-next-line no-unused-vars
      var draggie = new _draggabilly2.default('.xgplayer', {
        handle: '.drag-handle'
      });
      _util2.default.addClass(this.root, 'xgplayer-pip-active');
      this.root.style.right = 0;
      this.root.style.bottom = '200px';
      this.root.style.top = '';
      this.root.style.left = '';
      this.root.style.width = '320px';
      this.root.style.height = '180px';
      if (this.config.pipConfig) {
        if (this.config.pipConfig.top !== undefined) {
          this.root.style.top = this.config.pipConfig.top + 'px';
          this.root.style.bottom = '';
        }
        if (this.config.pipConfig.bottom !== undefined) {
          this.root.style.bottom = this.config.pipConfig.bottom + 'px';
        }
        if (this.config.pipConfig.left !== undefined) {
          this.root.style.left = this.config.pipConfig.left + 'px';
          this.root.style.right = '';
        }
        if (this.config.pipConfig.right !== undefined) {
          this.root.style.right = this.config.pipConfig.right + 'px';
        }
        if (this.config.pipConfig.width !== undefined) {
          this.root.style.width = this.config.pipConfig.width + 'px';
        }
        if (this.config.pipConfig.height !== undefined) {
          this.root.style.height = this.config.pipConfig.height + 'px';
        }
      }
      if (this.config.fluid) {
        this.root.style['padding-top'] = '';
      }
      var player = this;
      ['click', 'touchend'].forEach(function (item) {
        dragLay.addEventListener(item, function (e) {
          e.preventDefault();
          e.stopPropagation();
          player.exitPIP();
          // player.root.style.top = `${Top}px`
          // player.root.style.left = `${Left}px`
        });
      });
    }
  }, {
    key: 'exitPIP',
    value: function exitPIP() {
      _util2.default.removeClass(this.root, 'xgplayer-pip-active');
      this.root.style.right = '';
      this.root.style.bottom = '';
      this.root.style.top = '';
      this.root.style.left = '';
      if (this.config.fluid) {
        this.root.style['width'] = '100%';
        this.root.style['height'] = '0';
        this.root.style['padding-top'] = this.config.height * 100 / this.config.width + '%';
      } else {
        if (this.config.width) {
          if (typeof this.config.width !== 'number') {
            this.root.style.width = this.config.width;
          } else {
            this.root.style.width = this.config.width + 'px';
          }
        }
        if (this.config.height) {
          if (typeof this.config.height !== 'number') {
            this.root.style.height = this.config.height;
          } else {
            this.root.style.height = this.config.height + 'px';
          }
        }
      }

      var dragLay = _util2.default.findDom(this.root, '.xgplayer-pip-lay');
      if (dragLay && dragLay.parentNode) {
        dragLay.parentNode.removeChild(dragLay);
      }
      var dragHandle = _util2.default.findDom(this.root, '.xgplayer-pip-drag');
      if (dragHandle && dragHandle.parentNode) {
        dragHandle.parentNode.removeChild(dragHandle);
      }
    }
  }, {
    key: 'updateRotateDeg',
    value: function updateRotateDeg() {
      var player = this;
      if (!player.rotateDeg) {
        player.rotateDeg = 0;
      }

      var width = player.root.offsetWidth;
      var height = player.root.offsetHeight;
      var targetWidth = player.video.videoWidth;
      var targetHeight = player.video.videoHeight;

      if (!player.config.rotate.innerRotate && player.config.rotate.controlsFix) {
        player.root.style.width = height + 'px';
        player.root.style.height = width + 'px';
      }

      var scale = void 0;
      if (player.rotateDeg === 0.25 || player.rotateDeg === 0.75) {
        if (player.config.rotate.innerRotate) {
          if (targetWidth / targetHeight > height / width) {
            // 旋转后纵向撑满
            var videoWidth = 0;
            if (targetHeight / targetWidth > height / width) {
              // 旋转前是纵向撑满
              videoWidth = height * targetWidth / targetHeight;
            } else {
              // 旋转前是横向撑满
              videoWidth = width;
            }
            scale = height / videoWidth;
          } else {
            // 旋转后横向撑满
            var videoHeight = 0;
            if (targetHeight / targetWidth > height / width) {
              // 旋转前是纵向撑满
              videoHeight = height;
            } else {
              // 旋转前是横向撑满
              videoHeight = width * targetHeight / targetWidth;
            }
            scale = width / videoHeight;
          }
        } else {
          if (width >= height) {
            scale = width / height;
          } else {
            scale = height / width;
          }
        }
        scale = parseFloat(scale.toFixed(5));
      } else {
        scale = 1;
      }

      if (player.config.rotate.innerRotate) {
        player.video.style.transformOrigin = 'center center';
        player.video.style.transform = 'rotate(' + player.rotateDeg + 'turn) scale(' + scale + ')';
        player.video.style.webKitTransform = 'rotate(' + player.rotateDeg + 'turn) scale(' + scale + ')';
      } else {
        if (player.config.rotate.controlsFix) {
          player.video.style.transformOrigin = 'center center';
          player.video.style.transform = 'rotate(' + player.rotateDeg + 'turn) scale(' + scale + ')';
          player.video.style.webKitTransform = 'rotate(' + player.rotateDeg + 'turn) scale(' + scale + ')';
        } else {
          player.root.style.transformOrigin = 'center center';
          player.root.style.transform = 'rotate(' + player.rotateDeg + 'turn) scale(' + 1 + ')';
          player.root.style.webKitTransform = 'rotate(' + player.rotateDeg + 'turn) scale(' + 1 + ')';
        }
      }
    }
  }, {
    key: 'rotate',
    value: function rotate() {
      var clockwise = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var innerRotate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
      var times = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

      var player = this;
      if (!player.rotateDeg) {
        player.rotateDeg = 0;
      }
      var factor = clockwise ? 1 : -1;

      player.rotateDeg = (player.rotateDeg + 1 + factor * 0.25 * times) % 1;
      this.updateRotateDeg();

      player.emit('rotate', player.rotateDeg * 360);
    }
  }, {
    key: 'onFocus',
    value: function onFocus() {
      var player = this;
      _util2.default.removeClass(this.root, 'xgplayer-inactive');
      if (player.userTimer) {
        clearTimeout(player.userTimer);
      }
      player.userTimer = setTimeout(function () {
        player.emit('blur');
      }, player.config.inactive);
    }
  }, {
    key: 'onBlur',
    value: function onBlur() {
      // this.video.blur()
      if (!this.paused && !this.ended && !this.config.closeInactive) {
        _util2.default.addClass(this.root, 'xgplayer-inactive');
      }
    }
  }, {
    key: 'onPlay',
    value: function onPlay() {
      _util2.default.addClass(this.root, 'xgplayer-isloading');
      _util2.default.addClass(this.root, 'xgplayer-playing');
      _util2.default.removeClass(this.root, 'xgplayer-pause');
    }
  }, {
    key: 'onPause',
    value: function onPause() {
      _util2.default.addClass(this.root, 'xgplayer-pause');
      if (this.userTimer) {
        clearTimeout(this.userTimer);
      }
      this.emit('focus');
    }
  }, {
    key: 'onEnded',
    value: function onEnded() {
      _util2.default.addClass(this.root, 'xgplayer-ended');
      _util2.default.removeClass(this.root, 'xgplayer-playing');
    }
  }, {
    key: 'onSeeking',
    value: function onSeeking() {
      this.isSeeking = true;
      // 兼容IE下无法触发waiting事件的问题 seeking的时候直接出发waiting
      this.onWaiting();
      // util.addClass(this.root, 'seeking');
    }
  }, {
    key: 'onTimeupdate',
    value: function onTimeupdate() {
      // for ie,playing fired before waiting
      if (this.waitTimer) {
        clearTimeout(this.waitTimer);
      }
      _util2.default.removeClass(this.root, 'xgplayer-isloading');
    }
  }, {
    key: 'onSeeked',
    value: function onSeeked() {
      // for ie,playing fired before waiting
      this.isSeeking = false;
      if (this.waitTimer) {
        clearTimeout(this.waitTimer);
      }
      _util2.default.removeClass(this.root, 'xgplayer-isloading');
    }
  }, {
    key: 'onWaiting',
    value: function onWaiting() {
      var self = this;
      if (self.waitTimer) {
        clearTimeout(self.waitTimer);
      }
      if (self.checkTimer) {
        clearInterval(self.checkTimer);
        self.checkTimer = null;
      }
      var time = self.currentTime;
      self.waitTimer = setTimeout(function () {
        _util2.default.addClass(self.root, 'xgplayer-isloading');
        self.checkTimer = setInterval(function () {
          if (self.currentTime !== time) {
            _util2.default.removeClass(this.root, 'xgplayer-isloading');
            clearInterval(self.checkTimer);
            self.checkTimer = null;
          }
        }, 1000);
      }, 500);
    }
  }, {
    key: 'onPlaying',
    value: function onPlaying() {
      // 兼容safari下无法自动播放会触发该事件的场景
      if (this.paused) {
        return;
      }
      this.isSeeking = false;
      if (this.waitTimer) {
        clearTimeout(this.waitTimer);
      }
      _util2.default.removeClass(this.root, 'xgplayer-isloading xgplayer-nostart xgplayer-pause xgplayer-ended xgplayer-is-error xgplayer-replay');
      _util2.default.addClass(this.root, 'xgplayer-playing');
    }
  }, {
    key: 'onKeydown',
    value: function onKeydown(event, player) {
      // let player = this
      var e = event || window.event;
      if (e && (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 32)) {
        player.emit('focus');
      }
      if (e && (e.keyCode === 40 || e.keyCode === 38)) {
        if (player.controls) {
          var volumeSlider = player.controls.querySelector('.xgplayer-slider');
          if (volumeSlider) {
            if (_util2.default.hasClass(volumeSlider, 'xgplayer-none')) {
              _util2.default.removeClass(volumeSlider, 'xgplayer-none');
            }
            if (player.sliderTimer) {
              clearTimeout(player.sliderTimer);
            }
            player.sliderTimer = setTimeout(function () {
              _util2.default.addClass(volumeSlider, 'xgplayer-none');
            }, player.config.inactive);
          }
        }
        if (e && e.keyCode === 40) {
          // 按 down
          if (player.volume - 0.1 >= 0) {
            player.volume = parseFloat((player.volume - 0.1).toFixed(1));
          } else {
            player.volume = 0;
          }
        } else if (e && e.keyCode === 38) {
          // 按 up
          if (player.volume + 0.1 <= 1) {
            player.volume = parseFloat((player.volume + 0.1).toFixed(1));
          } else {
            player.volume = 1;
          }
        }
      } else if (e && e.keyCode === 39) {
        // 按 right
        if (player.currentTime + 10 <= player.duration) {
          player.currentTime += 10;
        } else {
          player.currentTime = player.duration - 1;
        }
      } else if (e && e.keyCode === 37) {
        // 按 left
        if (player.currentTime - 10 >= 0) {
          player.currentTime -= 10;
        } else {
          player.currentTime = 0;
        }
      } else if (e && e.keyCode === 32) {
        // 按 spacebar
        if (player.paused) {
          // eslint-disable-next-line handle-callback-err
          var playPromise = player.play();
          if (playPromise !== undefined && playPromise) {
            playPromise.catch(function (err) {});
          }
        } else {
          player.pause();
        }
      }
    }
  }], [{
    key: 'install',
    value: function install(name, descriptor) {
      if (!Player.plugins) {
        Player.plugins = {};
      }
      if (!Player.plugins[name]) {
        Player.plugins[name] = descriptor;
      }
    }
  }, {
    key: 'use',
    value: function use(name, descriptor) {
      if (!Player.plugins) {
        Player.plugins = {};
      }
      Player.plugins[name] = descriptor;
    }
  }]);

  return Player;
}(_proxy2.default);

Player.util = _util2.default;
Player.sniffer = _sniffer2.default;
Player.Errors = _error2.default;

exports.default = Player;
module.exports = exports['default'];

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _undefined = __webpack_require__(23)(); // Support ES3 engines

module.exports = function (val) {
  return val !== _undefined && val !== null;
};

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// ES3 safe

var _undefined = void 0;

module.exports = function (value) {
  return value !== _undefined && value !== null;
};

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
var util = {};

util.createDom = function () {
  var el = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'div';
  var tpl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  var attrs = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var cname = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : '';

  var dom = document.createElement(el);
  dom.className = cname;
  dom.innerHTML = tpl;
  Object.keys(attrs).forEach(function (item) {
    var key = item;
    var value = attrs[item];
    if (el === 'video' || el === 'audio') {
      if (value) {
        dom.setAttribute(key, value);
      }
    } else {
      dom.setAttribute(key, value);
    }
  });
  return dom;
};

util.hasClass = function (el, className) {
  if (!el) {
    return false;
  }

  if (el.classList) {
    return Array.prototype.some.call(el.classList, function (item) {
      return item === className;
    });
  } else {
    return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
  }
};

util.addClass = function (el, className) {
  if (!el) {
    return;
  }

  if (el.classList) {
    className.replace(/(^\s+|\s+$)/g, '').split(/\s+/g).forEach(function (item) {
      item && el.classList.add(item);
    });
  } else if (!util.hasClass(el, className)) {
    el.className += ' ' + className;
  }
};

util.removeClass = function (el, className) {
  if (!el) {
    return;
  }

  if (el.classList) {
    className.split(/\s+/g).forEach(function (item) {
      el.classList.remove(item);
    });
  } else if (util.hasClass(el, className)) {
    className.split(/\s+/g).forEach(function (item) {
      var reg = new RegExp('(\\s|^)' + item + '(\\s|$)');
      el.className = el.className.replace(reg, ' ');
    });
  }
};

util.toggleClass = function (el, className) {
  if (!el) {
    return;
  }

  className.split(/\s+/g).forEach(function (item) {
    if (util.hasClass(el, item)) {
      util.removeClass(el, item);
    } else {
      util.addClass(el, item);
    }
  });
};

util.findDom = function () {
  var el = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var sel = arguments[1];

  var dom = void 0;
  // fix querySelector IDs that start with a digit
  // https://stackoverflow.com/questions/37270787/uncaught-syntaxerror-failed-to-execute-queryselector-on-document
  try {
    dom = el.querySelector(sel);
  } catch (e) {
    if (sel.indexOf('#') === 0) {
      dom = el.getElementById(sel.slice(1));
    }
  }
  return dom;
};

util.padStart = function (str, length, pad) {
  var charstr = String(pad);
  var len = length >> 0;
  var maxlen = Math.ceil(len / charstr.length);
  var chars = [];
  var r = String(str);
  while (maxlen--) {
    chars.push(charstr);
  }
  return chars.join('').substring(0, len - r.length) + r;
};

util.format = function (time) {
  if (window.isNaN(time)) {
    return '';
  }
  var hour = util.padStart(Math.floor(time / 3600), 2, 0);
  var minute = util.padStart(Math.floor((time - hour * 3600) / 60), 2, 0);
  var second = util.padStart(Math.floor(time - hour * 3600 - minute * 60), 2, 0);
  return (hour === '00' ? [minute, second] : [hour, minute, second]).join(':');
};

util.event = function (e) {
  if (e.touches) {
    var touch = e.touches[0] || e.changedTouches[0];
    e.clientX = touch.clientX || 0;
    e.clientY = touch.clientY || 0;
    e.offsetX = touch.pageX - touch.target.offsetLeft;
    e.offsetY = touch.pageY - touch.target.offsetTop;
  }
  e._target = e.target || e.srcElement;
};

util.typeOf = function (obj) {
  return Object.prototype.toString.call(obj).match(/([^\s.*]+)(?=]$)/g)[0];
};

util.deepCopy = function (dst, src) {
  if (util.typeOf(src) === 'Object' && util.typeOf(dst) === 'Object') {
    Object.keys(src).forEach(function (key) {
      if (util.typeOf(src[key]) === 'Object' && !(src[key] instanceof Node)) {
        if (!dst[key]) {
          dst[key] = src[key];
        } else {
          util.deepCopy(dst[key], src[key]);
        }
      } else if (util.typeOf(src[key]) === 'Array') {
        dst[key] = util.typeOf(dst[key]) === 'Array' ? dst[key].concat(src[key]) : src[key];
      } else {
        dst[key] = src[key];
      }
    });
    return dst;
  }
};
util.getBgImage = function (el) {
  // fix: return current page url when url is none
  var url = (el.currentStyle || window.getComputedStyle(el, null)).backgroundImage;
  if (!url || url === 'none') {
    return '';
  }
  var a = document.createElement('a');
  a.href = url.replace(/url\("|"\)/g, '');
  return a.href;
};

util.copyDom = function (dom) {
  if (dom && dom.nodeType === 1) {
    var back = document.createElement(dom.tagName);
    Array.prototype.forEach.call(dom.attributes, function (node) {
      back.setAttribute(node.name, node.value);
    });
    if (dom.innerHTML) {
      back.innerHTML = dom.innerHTML;
    }
    return back;
  } else {
    return '';
  }
};

util.setInterval = function (context, eventName, intervalFunc, frequency) {
  if (!context._interval[eventName]) {
    context._interval[eventName] = setInterval(intervalFunc.bind(context), frequency);
  }
};

util.clearInterval = function (context, eventName) {
  clearInterval(context._interval[eventName]);
  context._interval[eventName] = null;
};

util.createImgBtn = function (name, imgUrl, width, height) {
  var btn = util.createDom('xg-' + name, '', {}, 'xgplayer-' + name + '-img');
  btn.style.backgroundImage = 'url("' + imgUrl + '")';
  if (width && height) {
    var w = void 0,
        h = void 0,
        unit = void 0;
    ['px', 'rem', 'em', 'pt', 'dp', 'vw', 'vh', 'vm', '%'].every(function (item) {
      if (width.indexOf(item) > -1 && height.indexOf(item) > -1) {
        w = parseFloat(width.slice(0, width.indexOf(item)).trim());
        h = parseFloat(height.slice(0, height.indexOf(item)).trim());
        unit = item;
        return false;
      } else {
        return true;
      }
    });
    btn.style.width = '' + w + unit;
    btn.style.height = '' + h + unit;
    btn.style.backgroundSize = '' + w + unit + ' ' + h + unit;
    if (name === 'start') {
      btn.style.margin = '-' + h / 2 + unit + ' auto auto -' + w / 2 + unit;
    } else {
      btn.style.margin = 'auto 5px auto 5px';
    }
  }
  return btn;
};

util.Hex2RGBA = function (hex, alpha) {
  var rgb = []; // 定义rgb数组
  if (/^\#[0-9A-F]{3}$/i.test(hex)) {
    var sixHex = '#';
    hex.replace(/[0-9A-F]/ig, function (kw) {
      sixHex += kw + kw;
    });
    hex = sixHex;
  }
  if (/^#[0-9A-F]{6}$/i.test(hex)) {
    hex.replace(/[0-9A-F]{2}/ig, function (kw) {
      rgb.push(eval('0x' + kw));
    });
    return 'rgba(' + rgb.join(',') + ', ' + alpha + ')';
  } else {
    return 'rgba(255, 255, 255, 0.1)';
  }
};

util.isWeiXin = function () {
  var ua = window.navigator.userAgent.toLowerCase();
  return ua.indexOf('micromessenger') > -1;
};

exports.default = util;
module.exports = exports['default'];

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _package = __webpack_require__(5);

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ErrorTypes = {
  network: {
    code: 1,
    msg: '视频下载错误',
    remark: '只要视频下载错误就使用此类型，无论是video本身的超时还是xhr的分段请求超时或者资源不存在'
  },
  mse: {
    code: 2,
    msg: '流追加错误',
    remark: '追加流的时候如果类型不对、无法被正确解码则会触发此类错误'
  },
  parse: {
    code: 3,
    msg: '解析错误',
    remark: 'mp4、hls、flv我们都是使用js进行格式解析，如果解析失败则会触发此类错误'
  },
  format: {
    code: 4,
    msg: '格式错误',
    remark: '如果浏览器不支持的格式导致播放错误'
  },
  decoder: {
    code: 5,
    msg: '解码错误',
    remark: '浏览器解码异常会抛出此类型错误'
  },
  runtime: {
    code: 6,
    msg: '语法错误',
    remark: '播放器语法错误'
  },
  timeout: {
    code: 7,
    msg: '播放超时',
    remark: '播放过程中无法正常请求下一个分段导致播放中断'
  },
  other: {
    code: 8,
    msg: '其他错误',
    remark: '不可知的错误或被忽略的错误类型'
  }
};

var Errors = function Errors(type, currentTime, duration, networkState, readyState, src, currentSrc, ended) {
  var errd = arguments.length > 8 && arguments[8] !== undefined ? arguments[8] : { line: '', handle: '', msg: '', version: '' };
  var errorCode = arguments[9];
  var mediaError = arguments[10];

  _classCallCheck(this, Errors);

  var r = {};
  if (arguments.length > 1) {
    r.playerVersion = _package.version; // 播放器版本
    r.errorType = type;
    r.domain = document.domain; // domain
    r.duration = duration; // 视频时长
    r.currentTime = currentTime;
    r.networkState = networkState;
    r.readyState = readyState;
    r.currentSrc = currentSrc;
    r.src = src;
    r.ended = ended;
    r.errd = errd; // 错误详情
    r.ex = (ErrorTypes[type] || {}).msg; // 补充信息
    r.errorCode = errorCode;
    r.mediaError = mediaError;
  } else {
    var arg = arguments[0];
    Object.keys(arg).map(function (key) {
      r[key] = arg[key];
    });
    r.ex = (arg.type && ErrorTypes[arg.type] || {}).msg;
  }
  return r;
};

exports.default = Errors;
module.exports = exports['default'];

/***/ }),
/* 5 */
/***/ (function(module) {

module.exports = {"name":"xgplayer","version":"2.6.15","description":"video player","main":"./dist/index.js","typings":"./types/index.d.ts","bin":{"xgplayer":"bin/xgplayer.js"},"scripts":{"prepare":"npm run build","build":"webpack --progress --display-chunks -p","watch":"webpack --progress --display-chunks -p --watch --mode development"},"keywords":["video","player"],"babel":{"presets":["es2015"],"plugins":["add-module-exports","babel-plugin-bulk-import"]},"repository":{"type":"git","url":"git+https://github.com/bytedance/xgplayer.git"},"author":"yinguohui@bytedance.com","license":"MIT","dependencies":{"chalk":"^2.3.2","commander":"^2.15.1","danmu.js":"^0.1.0","deepmerge":"^1.5.0","downloadjs":"1.4.7","draggabilly":"^2.2.0","event-emitter":"^0.3.5","fs-extra":"^5.0.0","install":"^0.13.0","pasition":"^1.0.1","request-frame":"^1.5.3"},"browserslist":["> 5%","IE 9","iOS 7","Firefox > 20"],"devDependencies":{"@types/events":"^3.0.0","autoprefixer":"^9.1.5","babel-core":"^6.26.3","babel-loader":"^7.1.4","babel-plugin-add-module-exports":"^0.2.1","babel-plugin-bulk-import":"^1.0.2","babel-plugin-transform-object-rest-spread":"^6.26.0","babel-plugin-transform-runtime":"^6.23.0","babel-preset-es2015":"^6.24.1","chai":"^4.1.2","core-js":"^2.5.4","css-loader":"^0.28.11","json-loader":"^0.5.7","node-sass":"^4.8.3","postcss-cssnext":"^3.1.0","postcss-loader":"^2.1.5","raw-loader":"^2.0.0","sass-loader":"^6.0.7","style-loader":"^0.20.3","sugarss":"^1.0.1","webpack":"^4.11.0","webpack-cli":"^3.0.2","zlib":"^1.0.5"}};

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
var sniffer = {
  get device() {
    var r = sniffer.os;
    return r.isPc ? 'pc' : 'mobile';
    // return r.isPc ? 'pc' : r.isTablet ? 'tablet' : 'mobile'
  },
  get browser() {
    var ua = navigator.userAgent.toLowerCase();
    var reg = {
      ie: /rv:([\d.]+)\) like gecko/,
      firfox: /firefox\/([\d.]+)/,
      chrome: /chrome\/([\d.]+)/,
      opera: /opera.([\d.]+)/,
      safari: /version\/([\d.]+).*safari/
    };
    return [].concat(Object.keys(reg).filter(function (key) {
      return reg[key].test(ua);
    }))[0];
  },
  get os() {
    var ua = navigator.userAgent;
    var isWindowsPhone = /(?:Windows Phone)/.test(ua);
    var isSymbian = /(?:SymbianOS)/.test(ua) || isWindowsPhone;
    var isAndroid = /(?:Android)/.test(ua);
    var isFireFox = /(?:Firefox)/.test(ua);
    var isTablet = /(?:iPad|PlayBook)/.test(ua) || isAndroid && !/(?:Mobile)/.test(ua) || isFireFox && /(?:Tablet)/.test(ua);
    var isPhone = /(?:iPhone)/.test(ua) && !isTablet;
    var isPc = !isPhone && !isAndroid && !isSymbian && !isTablet;
    return {
      isTablet: isTablet,
      isPhone: isPhone,
      isAndroid: isAndroid,
      isPc: isPc,
      isSymbian: isSymbian,
      isWindowsPhone: isWindowsPhone,
      isFireFox: isFireFox
    };
  }
};

exports.default = sniffer;
module.exports = exports['default'];

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof2 = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/* eslint-disable */
var _extends = Object.assign || function (e) {
  for (var r = 1; r < arguments.length; r++) {
    var n = arguments[r];for (var t in n) {
      if (Object.prototype.hasOwnProperty.call(n, t)) {
        e[t] = n[t];
      }
    }
  }return e;
};function _classCallCheck(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var undef = undefined;var Env = function e() {
  var A = this;_classCallCheck(this, e);this.set = function (e, r) {
    var n = e;var t = r;if (t === null) {
      return false;
    }var i = "";if (n.indexOf(".") > -1) {
      var s = n.split(".");i = s[0];n = s[1];
    }if (n === "os_version") {
      t = "" + t;
    }if (i) {
      if (i === "user" || i === "header") {
        A.envInfo[i][n] = t;
      } else if (i === "headers") {
        A.envInfo.header.headers[n] = t;
      } else {
        A.envInfo.header.headers.custom[n] = t;
      }
    } else if (A.envInfo.user.hasOwnProperty(n)) {
      if (["user_type", "device_id", "ip_addr_id"].indexOf(n) > -1) {
        A.envInfo.user[n] = Number(t);
      } else if (["user_id", "web_id", "user_unique_id", "ssid"].indexOf(n) > -1) {
        A.envInfo.user[n] = String(t);
      } else if (["user_is_auth", "user_is_login"].indexOf(n) > -1) {
        A.envInfo.user[n] = Boolean(t);
      }
    } else if (A.envInfo.header.hasOwnProperty(n)) {
      A.envInfo.header[n] = t;
    } else if (A.envInfo.header.headers.hasOwnProperty(n)) {
      A.envInfo.header.headers[n] = t;
    } else {
      A.envInfo.header.headers.custom[n] = t;
    }
  };this.get = function () {
    var e = { user: {}, header: { headers: { custom: {} } } };var r = A.envInfo;var n = r.user;var t = Object.keys(n);for (var i = t, s = Array.isArray(i), o = 0, i = s ? i : i[Symbol.iterator]();;) {
      var a;if (s) {
        if (o >= i.length) break;a = i[o++];
      } else {
        o = i.next();if (o.done) break;a = o.value;
      }var u = a;if (n[u] !== undef) {
        e.user[u] = n[u];
      }
    }var f = r.header;var c = Object.keys(f);for (var d = c, l = Array.isArray(d), _ = 0, d = l ? d : d[Symbol.iterator]();;) {
      var v;if (l) {
        if (_ >= d.length) break;v = d[_++];
      } else {
        _ = d.next();if (_.done) break;v = _.value;
      }var h = v;if (f[h] !== undef && h !== "headers") {
        e.header[h] = f[h];
      }
    }var p = r.header.headers;var g = Object.keys(p);for (var b = g, y = Array.isArray(b), m = 0, b = y ? b : b[Symbol.iterator]();;) {
      var w;if (y) {
        if (m >= b.length) break;w = b[m++];
      } else {
        m = b.next();if (m.done) break;w = m.value;
      }var O = w;if (O !== "custom" && p[O] !== undef) {
        e.header.headers[O] = p[O];
      }
    }var k = r.header.headers.custom;var C = Object.keys(k);if (C.length) {
      for (var S = C, E = Array.isArray(S), R = 0, S = E ? S : S[Symbol.iterator]();;) {
        var x;if (E) {
          if (R >= S.length) break;x = S[R++];
        } else {
          R = S.next();if (R.done) break;x = R.value;
        }var z = x;e.header.headers.custom[z] = k[z];
      }
    }var T = { user: e.user, header: _extends({}, e.header, { headers: e.header.headers }) };return T;
  };this.envInfo = { user: { user_unique_id: undef, user_type: undef, user_id: undef, user_is_auth: undef, user_is_login: undef, device_id: undef, web_id: undef, ip_addr_id: undef, ssid: undef }, header: { app_id: undef, app_name: undef, app_install_id: undef, app_package: undef, app_channel: undef, app_version: undef, os_name: undef, os_version: undef, device_model: undef, ab_client: undef, ab_version: undef, traffic_type: undef, utm_source: undef, utm_medium: undef, utm_campaign: undef, client_ip: undef, device_brand: undef, os_api: undef, access: undef, language: undef, region: undef, app_language: undef, app_region: undef, creative_id: undef, ad_id: undef, campaign_id: undef, log_type: undef, rnd: undef, platform: undef, sdk_version: undef, province: undef, city: undef, timezone: undef, tz_offset: undef, tz_name: undef, sim_region: undef, carrier: undef, resolution: undef, browser: undef, browser_version: undef, referrer: undef, referrer_host: undef, headers: { utm_term: undef, utm_content: undef, custom: {} } } };
};var parseURL = function e(r) {
  var n = document.createElement("a");n.href = r;return n;
};var parseUrlQuery = function e(r) {
  var n = parseURL(r).search;n = n.slice(1);var i = {};n.split("&").forEach(function (e) {
    var r = e.split("="),
        n = r[0],
        t = r[1];i[n] = decodeURIComponent(typeof t === "undefined" ? "" : t);
  });return i;
};var undef$1 = "";var screen_width = screen.width || 0;var screen_height = screen.height || 0;var screen_size = screen_width + " x " + screen_height;var appVersion = navigator.appVersion;var userAgent = navigator.userAgent;var language = navigator.language;var referrer = document.referrer;var referrer_host = parseURL(referrer).hostname;var urlQueryObj = parseUrlQuery(location.href);var os_name = undef$1;var os_version = undef$1;var browser = "";var browser_version = "" + parseFloat(appVersion);var versionOffset = void 0;var semiIndex = void 0;if ((versionOffset = userAgent.indexOf("Opera")) !== -1) {
  browser = "Opera";browser_version = userAgent.substring(versionOffset + 6);if ((versionOffset = userAgent.indexOf("Version")) !== -1) {
    browser_version = userAgent.substring(versionOffset + 8);
  }
}if ((versionOffset = userAgent.indexOf("Edge")) !== -1) {
  browser = "Microsoft Edge";browser_version = userAgent.substring(versionOffset + 5);
} else if ((versionOffset = userAgent.indexOf("MSIE")) !== -1) {
  browser = "Microsoft Internet Explorer";browser_version = userAgent.substring(versionOffset + 5);
} else if ((versionOffset = userAgent.indexOf("Chrome")) !== -1) {
  browser = "Chrome";browser_version = userAgent.substring(versionOffset + 7);
} else if ((versionOffset = userAgent.indexOf("Safari")) !== -1) {
  browser = "Safari";browser_version = userAgent.substring(versionOffset + 7);if ((versionOffset = userAgent.indexOf("Version")) !== -1) {
    browser_version = userAgent.substring(versionOffset + 8);
  }
} else if ((versionOffset = userAgent.indexOf("Firefox")) !== -1) {
  browser = "Firefox";browser_version = userAgent.substring(versionOffset + 8);
}if ((semiIndex = browser_version.indexOf(";")) !== -1) {
  browser_version = browser_version.substring(0, semiIndex);
}if ((semiIndex = browser_version.indexOf(" ")) !== -1) {
  browser_version = browser_version.substring(0, semiIndex);
}if ((semiIndex = browser_version.indexOf(")")) !== -1) {
  browser_version = browser_version.substring(0, semiIndex);
}var platform = /Mobile|htc|mini|Android|iP(ad|od|hone)/.test(appVersion) ? "wap" : "web";var clientOpts = [{ s: "Windows 10", r: /(Windows 10.0|Windows NT 10.0)/ }, { s: "Windows 8.1", r: /(Windows 8.1|Windows NT 6.3)/ }, { s: "Windows 8", r: /(Windows 8|Windows NT 6.2)/ }, { s: "Windows 7", r: /(Windows 7|Windows NT 6.1)/ }, { s: "Android", r: /Android/ }, { s: "Sun OS", r: /SunOS/ }, { s: "Linux", r: /(Linux|X11)/ }, { s: "iOS", r: /(iPhone|iPad|iPod)/ }, { s: "Mac OS X", r: /Mac OS X/ }, { s: "Mac OS", r: /(MacPPC|MacIntel|Mac_PowerPC|Macintosh)/ }];for (var i = 0; i < clientOpts.length; i++) {
  var cs = clientOpts[i];if (cs.r.test(userAgent)) {
    os_name = cs.s;break;
  }
}function getVersion(e, r) {
  var n = e.exec(r);if (n && n[1]) {
    return n[1];
  }return "";
}if (/Windows/.test(os_name)) {
  os_version = getVersion(/Windows (.*)/, os_name);os_name = "windows";
}function getAndroidVersion(e) {
  var r = getVersion(/Android ([\.\_\d]+)/, e);if (!r) {
    r = getVersion(/Android\/([\.\_\d]+)/, e);
  }return r;
}switch (os_name) {case "Mac OS X":
    os_version = getVersion(/Mac OS X (10[\.\_\d]+)/, userAgent);os_name = "mac";break;case "Android":
    os_version = getAndroidVersion(userAgent);os_name = "android";break;case "iOS":
    os_version = /OS (\d+)_(\d+)_?(\d+)?/.exec(appVersion);if (!os_version) {
      os_version = "";
    } else {
      os_version = os_version[1] + "." + os_version[2] + "." + (os_version[3] | 0);
    }os_name = "ios";break;}var browser$1 = { screen_size: screen_size, browser: browser, browser_version: browser_version, platform: platform, os_name: os_name, os_version: os_version, userAgent: userAgent, screen_width: screen_width, screen_height: screen_height, device_model: os_name, language: language, referrer: referrer, referrer_host: referrer_host, utm_source: urlQueryObj.utm_source, utm_medium: urlQueryObj.utm_medium, utm_campaign: urlQueryObj.utm_campaign, utm_term: urlQueryObj.utm_term, utm_content: urlQueryObj.utm_content };var StorageCache = { get: function e(r) {
    var n = 'no localStorage';if (localStorage && localStorage.getItem) {
      n = localStorage.getItem(r);
    }var t = n;try {
      if (n && typeof n === "string") {
        t = JSON.parse(n);
      }
    } catch (e) {}return t;
  }, set: function e(r, n) {
    try {
      var t = typeof n === "string" ? n : JSON.stringify(n);if (localStorage && localStorage.setItem) {
        localStorage.setItem(r, t);
      }
    } catch (e) {}
  } };var TEA_CACHE_PREFIX = "__tea_cache_";var TEA_LOGGER_PREFIX = "[tea-sdk]";var ERROR_CODE = { NO_URL_PREFIX: 4001, IMG_ON_ERROR: 4e3, IMG_CATCH_ERROR: 4002, BEACON_STATUS_FALSE: 4003, XHR_ON_ERROR: 500, RESPONSE_DATA_ERROR: 5001 };var _typeof = typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol" ? function (e) {
  return typeof e === "undefined" ? "undefined" : _typeof2(e);
} : function (e) {
  return e && typeof Symbol === "function" && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e === "undefined" ? "undefined" : _typeof2(e);
};function _classCallCheck$1(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var Logger = function e() {
  var s = this;var r = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";_classCallCheck$1(this, e);this.init = function (e) {
    s.isLog = e;
  };this.info = function (e) {
    for (var r = arguments.length, n = Array(r > 1 ? r - 1 : 0), t = 1; t < r; t++) {
      n[t - 1] = arguments[t];
    }if (s.isLog) {
      var i;(i = console).log.apply(i, [s.prefix + e].concat(n));
    }
  };this.warn = function (e) {
    for (var r = arguments.length, n = Array(r > 1 ? r - 1 : 0), t = 1; t < r; t++) {
      n[t - 1] = arguments[t];
    }if (s.isLog) {
      var i;(i = console).warn.apply(i, [s.prefix + e].concat(n));
    }
  };this.error = function (e) {
    for (var r = arguments.length, n = Array(r > 1 ? r - 1 : 0), t = 1; t < r; t++) {
      n[t - 1] = arguments[t];
    }if (s.isLog) {
      var i;(i = console).error.apply(i, [s.prefix + e].concat(n));
    }
  };this.dir = function () {
    if (s.isLog) {
      var e;(e = console).dir.apply(e, arguments);
    }
  };this.table = function (e) {
    if (s.isLog) {
      console.table(e);
    }
  };this.logJSON = function (e) {
    if ((typeof e === "undefined" ? "undefined" : _typeof(e)) === "object" && s.isLog) {
      s.info("", JSON.stringify(e, null, 2));
    }
  };this.deprecated = function (e) {
    for (var r = arguments.length, n = Array(r > 1 ? r - 1 : 0), t = 1; t < r; t++) {
      n[t - 1] = arguments[t];
    }s.warn.apply(s, ["[DEPRECATED]" + e].concat(n));
  };this.throw = function (e) {
    s.error(s.prefix);throw new Error(e);
  };var n = r ? "[" + r + "]" : "";this.prefix = TEA_LOGGER_PREFIX + n;
};var logger = new Logger();var fetchTokens = function e(r, n, t, i) {
  var s = new XMLHttpRequest();s.open("POST", r, true);s.setRequestHeader("Content-Type", "application/json; charset=utf-8");s.onload = function () {
    try {
      var e = JSON.parse(s.responseText);if (t) {
        t(e);
      }
    } catch (e) {
      if (i) {
        i();
      }
    }
  };s.onerror = function () {
    if (i) {
      i();
    }
  };s.send(JSON.stringify(n));
};function _classCallCheck$2(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}function _possibleConstructorReturn(e, r) {
  if (!e) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }return r && ((typeof r === "undefined" ? "undefined" : _typeof2(r)) === "object" || typeof r === "function") ? r : e;
}function _inherits(e, r) {
  if (typeof r !== "function" && r !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + (typeof r === "undefined" ? "undefined" : _typeof2(r)));
  }e.prototype = Object.create(r && r.prototype, { constructor: { value: e, enumerable: false, writable: true, configurable: true } });if (r) Object.setPrototypeOf ? Object.setPrototypeOf(e, r) : e.__proto__ = r;
}var date = new Date();var timeZoneMin = date.getTimezoneOffset();var timezone = parseInt(-timeZoneMin / 60, 10);var tz_offset = timeZoneMin * 60;var sdk_version = void 0;try {
  sdk_version = "3.2.7";
} catch (e) {
  sdk_version = "2.x";
}var ClientEnv = function (r) {
  _inherits(n, r);function n() {
    _classCallCheck$2(this, n);var e = _possibleConstructorReturn(this, r.call(this));e.initClientEnv = function () {
      e.set("os_name", browser$1.os_name);e.set("os_version", browser$1.os_version);e.set("device_model", browser$1.device_model);e.set("platform", browser$1.platform);e.set("sdk_version", sdk_version);e.set("browser", browser$1.browser);e.set("browser_version", browser$1.browser_version);e.set("language", browser$1.language);e.set("timezone", timezone);e.set("tz_offset", tz_offset);e.set("resolution", browser$1.screen_width + "x" + browser$1.screen_height);e.set("screen_width", browser$1.screen_width);e.set("screen_height", browser$1.screen_height);e.set("referrer", browser$1.referrer);e.set("referrer_host", browser$1.referrer_host);e.set("utm_source", browser$1.utm_source);e.set("utm_medium", browser$1.utm_medium);e.set("utm_campaign", browser$1.utm_campaign);e.set("utm_term", browser$1.utm_term);e.set("utm_content", browser$1.utm_content);
    };e.initClientEnv();return e;
  }return n;
}(Env);var clientEnvManager = new ClientEnv();function _classCallCheck$3(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var Type = function () {
  function e() {
    _classCallCheck$3(this, e);
  }e.prototype.isString = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "String";
  };e.prototype.isNumber = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Number";
  };e.prototype.isBoolean = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Boolean";
  };e.prototype.isFunction = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Function";
  };e.prototype.isNull = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Null";
  };e.prototype.isUndefined = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Undefined";
  };e.prototype.isObj = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Object";
  };e.prototype.isArray = function e(r) {
    return Object.prototype.toString.call(r).slice(8, -1) === "Array";
  };e.prototype.isFalse = function e(r) {
    if (r === "" || r === undefined || r === null || r === "null" || r === "undefined" || r === 0 || r === false || r === NaN) return true;return false;
  };e.prototype.isTrue = function e(r) {
    return !this.isFalse(r);
  };e.prototype.isLowIE = function e() {
    return window.XDomainRequest;
  };return e;
}();var types = new Type();function decrypto(e, r, n) {
  if (typeof e !== "string" || typeof r !== "number" || typeof n !== "number") {
    return;
  }var t = [];var i = [];n = n <= 25 ? n : n % 25;var s = String.fromCharCode(n + 97);t = e.split(s);for (var o = 0; o < t.length; o++) {
    var a = parseInt(t[o], n);a = a * 1 ^ r;var u = String.fromCharCode(a);i.push(u);
  }var f = i.join("");return f;
}var decodeXXX = function e(r) {
  return decrypto(r, 64, 25);
};function b(e) {
  return e ? (e ^ Math.random() * 16 >> e / 4).toString(10) : ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, b);
}var webid = function e() {
  return b().replace(/-/g, "").slice(0, 19);
};var _extends$1 = Object.assign || function (e) {
  for (var r = 1; r < arguments.length; r++) {
    var n = arguments[r];for (var t in n) {
      if (Object.prototype.hasOwnProperty.call(n, t)) {
        e[t] = n[t];
      }
    }
  }return e;
};function _classCallCheck$4(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}function _possibleConstructorReturn$1(e, r) {
  if (!e) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }return r && ((typeof r === "undefined" ? "undefined" : _typeof2(r)) === "object" || typeof r === "function") ? r : e;
}function _inherits$1(e, r) {
  if (typeof r !== "function" && r !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + (typeof r === "undefined" ? "undefined" : _typeof2(r)));
  }e.prototype = Object.create(r && r.prototype, { constructor: { value: e, enumerable: false, writable: true, configurable: true } });if (r) Object.setPrototypeOf ? Object.setPrototypeOf(e, r) : e.__proto__ = r;
}var urlPrefix = { cn: "1fz22z22z1nz21z4mz4bz4bz1kz1az21z4az21z1lz21z21z1bz1iz4az1az1mz1k", sg: "1fz22z22z1nz21z4mz4bz4bz21z1ez18z1jz1gz49z1kz1az21z4az19z27z22z1cz1mz24z1cz20z21z1cz18z4az1az1mz1k", va: "1fz22z22z1nz21z4mz4bz4bz1kz18z1jz1gz24z18z49z1kz1az21z4az19z27z22z1cz1mz24z1cz20z21z1cz18z4az1az1mz1k" };var getCookie = function e(r) {
  try {
    var n = document.cookie.match(new RegExp("(?:^|;)\\s*" + r + "=([^;]+)"));return decodeURIComponent(n ? n[1] : "");
  } catch (e) {
    return "";
  }
};var AppChannelEnv = function (e) {
  _inherits$1(r, e);function r() {
    _classCallCheck$4(this, r);var f = _possibleConstructorReturn$1(this, e.call(this));f.init = function (e) {
      var r = e.app_id,
          n = e.channel,
          t = e.log,
          i = e.channel_domain,
          s = e.name;if (typeof r !== "number") {
        throw new Error("app_id 必须是一个数字，注意检查是否是以`string`的方式传入的？");
      }f.logger = new Logger(s);f.logger.init(t);f.initConfigs(e);f.initUrls(n, i);f.setEnv("app_id", r);
    };f.initConfigs = function (e) {
      var r = e.app_id,
          n = e.disable_ssid,
          t = e.disable_webid,
          i = e.disable_sdk_monitor;f.app_id = r;f.evtDataCacheKey = TEA_CACHE_PREFIX + "events_" + r;if (n) {
        f.logger.info("ssid已禁用，设置user_unique_id不会请求ssid接口。");f.isSsidDisabled = true;
      }if (t) {
        f.logger.info("webid服务已禁用，ssid同时被禁用。将本地生成webid。");f.isWebidDisabled = true;f.isSsidDisabled = true;
      }if (i) {
        f.logger.info("SDK监控已禁用。");f.isSdkMonitorDisabled = true;
      }
    };f.initUrls = function (e, r) {
      if (e === "internal") {
        f.logger.warn("channel 的值 internal 已被废弃，已自动改为 cn。");e = "cn";
      }if (!r && !urlPrefix[e]) {
        throw new Error("channel 变量只能是 `cn`, `sg`,`va`");
      }var n = r || decodeXXX(urlPrefix[e]);n = n.replace(/\/+$/, "");f.reportUrl = n + "/v1/list";f.userTokensPrefix = "" + n;
    };f.setEnv = function (e, r) {
      if (e === "app_id") {
        f.checkUserToken(r);
      }if (e === "user_unique_id") {
        if (f.blackUuid.some(function (e) {
          return e === String(r);
        })) {
          f.logger.warn('设置了无效的值 {user_unique_id："%s"}。该操作已忽略。', r);return;
        }f.verifyTokens(r);
      }if (e === "web_id") {
        if (!r) {
          return;
        }if (!f.envInfo.user.user_unique_id || f.envInfo.user.user_unique_id && f.envInfo.user.user_unique_id === f.envInfo.user.web_id) {
          f.set("user_unique_id", r);
        }
      }f.set(e, r);
    };f.transferFromCookie = function () {
      var e = f.tokensCacheKey;var r = "tt_webid";var n = "__tea_sdk__ssid";var t = "__tea_sdk__user_unique_id";var i = getCookie(r);var s = getCookie(n);var o = getCookie(t);if (types.isLowIE()) {
        if (i) {
          var a = { web_id: i, ssid: i, user_unique_id: i };StorageCache.set(e, JSON.stringify(a));
        }return false;
      }if (i && s && o) {
        var u = { web_id: i, ssid: s, user_unique_id: o };StorageCache.set(e, JSON.stringify(u));
      }
    };f.purifyBlackUuid = function () {
      var r = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};if (f.blackUuid.some(function (e) {
        return e === r.user_unique_id;
      })) {
        var e = {};f.setUserTokens(e);f.logger.warn('检测到无效的用户标识，已重置用户状态。{user_unique_id: "%s"}', r.user_unique_id);return e;
      }return r;
    };f.getUserTokens = function () {
      return StorageCache.get(f.tokensCacheKey) || {};
    };f.setUserTokens = function () {
      var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};return StorageCache.set(f.tokensCacheKey, e);
    };f.checkUserToken = function (e) {
      var r = TEA_CACHE_PREFIX + "tokens_" + e;f.tokensCacheKey = r;f.transferFromCookie();var n = f.purifyBlackUuid(f.getUserTokens());if (n.user_unique_id && n.web_id) {
        f.envInfo.user.user_unique_id = n.user_unique_id;f.envInfo.user.web_id = n.web_id;f.envInfo.user.ssid = n.ssid || "";f.logger.info("初始化已经检测到了 webid user_unique_id，一般情况下不需要再次验证 id 了");f.unlock();
      } else {
        f.requestWebId(e);
      }
    };f.saveTokenToStorage = function (e) {
      var r = e.web_id,
          n = e.ssid,
          t = e.user_unique_id;f.setUserTokens({ web_id: r, ssid: n, user_unique_id: t });
    };f.requestWebId = function () {
      f.isRequestWebId = true;var n = function e(r) {
        var n = f.envInfo.user.web_id || r.web_id;var t = r.ssid;f.isRequestWebId = false;f.envInfo.user.ssid = t;f.envInfo.user.web_id = n;f.envInfo.user.user_unique_id = n;f.saveTokenToStorage({ web_id: n, ssid: t, user_unique_id: n });if (f.waitForVerifyTokens) {
          f.lock();f.verifyTokens(f.realUuid);
        } else {
          f.unlock();if (f.callback) {
            f.callback();
          }
        }
      };var e = function e() {
        n({ web_id: webid(), ssid: "" });
      };var r = function e() {
        var r = f.userTokensPrefix + "/v1/user/webid";fetchTokens(r, { app_id: f.app_id, url: location.href, user_agent: browser$1.userAgent, referer: browser$1.referrer, user_unique_id: "" }, function (e) {
          if (e.e !== 0) {
            f.logger.error("请求 webid 失败。请联系管理员。");
          } else {
            n(e);
          }
        }, function () {
          f.isRequestWebId = false;f.logger.error("获取 webid 失败，数据将不会被上报");
        });
      };if (f.isWebidDisabled) {
        e();
      } else {
        r();
      }
    };f.verifyTokens = function (e) {
      var r = f.tokensCacheKey;f.waitForVerifyTokens = false;f.realUuid = "" + e;if (f.isRequestWebId) {
        f.waitForVerifyTokens = true;f.logger.info("正在请求 webid，requestSsid 将会在前者请求完毕之后被调用");return false;
      }var n = f.getUserTokens();if (n.user_unique_id === f.realUuid && n.ssid && n.web_id) {
        f.logger.info("传入的 user_id/user_unique_id 与 缓存中的完全一致，无需再次请求");f.unlock();
      } else {
        f.lock();f.envInfo.user.user_unique_id = f.realUuid;var t = _extends$1({}, f.getUserTokens(), { user_unique_id: f.realUuid });StorageCache.set(r, JSON.stringify(t));if (types.isLowIE()) {
          f.unlock();return false;
        }if (f.isSsidDisabled) {
          f.unlock();if (f.callback) {
            f.callback();
          }
        } else {
          f.requestSsid();
        }
      }
    };f.requestSsid = function () {
      var n = f.getUserTokens();var e = f.userTokensPrefix + "/v1/user/ssid";fetchTokens(e, { app_id: f.app_id, web_id: n.web_id, user_unique_id: "" + n.user_unique_id }, function (e) {
        f.unlock();if (e.e !== 0) {
          f.logger.error("请求 ssid 失败~");
        } else {
          f.envInfo.user.ssid = e.ssid;var r = _extends$1({}, n, { ssid: e.ssid });f.setUserTokens(r);f.logger.info("根据 user_unique_id 更新 ssid 成功！注意：在这之前不应该有数据被发出去");if (f.callback) {
            f.callback();
          }
        }
      }, function () {
        f.unlock();f.logger.error("根据 user_unique_id 获取新 ssid 失败");
      });
    };f.setEvtParams = function (e) {
      var r = _extends$1({}, e);Object.keys(r).forEach(function (e) {
        f.evtParams[e] = r[e];
      });
    };f.mergeEnvToEvents = function (e) {
      var r = f.mergeEnv();var n = [];var t = 0;var i = void 0;e.forEach(function (e) {
        var r = !!e.params.__disable_storage__;if (typeof i === "undefined") {
          i = r;
        } else if (r !== i || n[t].length >= 5) {
          t += 1;i = !i;
        }n[t] = n[t] || [];n[t].push(e);
      });var s = n.map(function (e) {
        return { events: e.map(function (e) {
            var r = _extends$1({}, f.evtParams, e.params);delete r.__disable_storage__;return _extends$1({}, e, { params: JSON.stringify(r) });
          }), user: r.user, header: r.header, verbose: f.debugMode ? 1 : undefined, __disable_storage__: e[0].params.__disable_storage__ };
      });return s;
    };f.mergeEnv = function () {
      var e = f.get();var r = clientEnvManager.get();var n = _extends$1({}, e.user);var t = _extends$1({}, r.header.headers.custom, e.header.headers.custom);var i = _extends$1({}, r.header.headers, e.header.headers, { custom: t });var s = _extends$1({}, r.header, e.header);var o = { user: n, header: _extends$1({}, s, { headers: JSON.stringify(i) }) };return o;
    };f.evtParams = {};f.reportUrl = "";f.userTokensPrefix = "";f.isSsidDisabled = false;f.isWebidDisabled = false;f.isSdkMonitorDisabled = false;f.debugMode = false;f.blackUuid = ["null", "undefined", "0", "", "None"];f.logger = function () {};return f;
  }r.prototype.lock = function e() {
    this.isUserTokensReady = false;
  };r.prototype.unlock = function e() {
    this.isUserTokensReady = true;
  };r.prototype.enableDebugMode = function e(r) {
    this.debugMode = r;
  };return r;
}(Env);function _classCallCheck$5(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var MemoryCache = function e() {
  var n = this;_classCallCheck$5(this, e);this.set = function (e, r) {
    n.cache[e] = r;
  };this.get = function (e) {
    return n.cache[e];
  };this.clean = function (e) {
    n.cache[e] = undefined;
  };this.cache = {};
};var memoryCacheManager = new MemoryCache();function _classCallCheck$6(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var EventStorageManager = function () {
  function t(e) {
    var r = e.disable_storage,
        n = r === undefined ? false : r;_classCallCheck$6(this, t);this._isPersistent = !n;this._storage = this._isPersistent ? StorageCache : new MemoryCache();this._storageKey = "";this._data = undefined;
  }t.prototype.setStorageKey = function e(r) {
    this._storageKey = r;
  };t.prototype.getAllEvents = function e() {
    var n = this.getData();Object.keys(n).reduce(function (e, r) {
      return e.concat(n[r] || []);
    }, []);
  };t.prototype.getData = function e() {
    this._checkIsDataInit();return this._data;
  };t.prototype.add = function e(r) {
    var n = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];this._checkIsDataInit();if (n.length !== 0) {
      this._data[r] = n;this._save();
    }
  };t.prototype.delete = function e(r) {
    this._checkIsDataInit();if (this._data[r]) {
      delete this._data[r];this._save();
    }
  };t.prototype._checkIsDataInit = function e() {
    if (typeof this._data === "undefined") {
      try {
        var r = this._getDataFromStorage();if (types.isArray(r)) {
          var n;this._data = (n = {}, n[webid()] = r, n);this._save();
        } else {
          this._data = r;
        }
      } catch (e) {
        this._data = {};
      }
    }
  };t.prototype._checkStorageKey = function e() {
    if (!this._storageKey) {
      throw new Error("must call setStorageKey('xxx') first");
    }
  };t.prototype._getDataFromStorage = function e() {
    this._checkStorageKey();return this._storage.get(this._storageKey) || {};
  };t.prototype._save = function e() {
    this._checkStorageKey();this._storage.set(this._storageKey, this._data);
  };return t;
}();var encodePayload = function e(r) {
  var n = "";for (var t in r) {
    if (r.hasOwnProperty(t)) {
      n += "&" + t + "=" + encodeURIComponent(JSON.stringify(r[t]));
    }
  }n = n[0] === "&" ? n.slice(1) : n;return n;
};var sendByImg = function e(r, n) {
  try {
    var t = r.split("v1")[0];n.forEach(function (e) {
      var r = encodePayload(e);var n = new Image(1, 1);n.onload = function () {
        n = null;
      };n.onerror = function () {
        n = null;
      };n.src = t + "/v1/gif?" + r;
    });
  } catch (e) {}
};var postSdkLog = function e(r, n) {
  if (window.XDomainRequest) {
    return sendByImg(r, n);
  }var t = new XMLHttpRequest();t.open("POST", r + "?rdn=" + Math.random(), true);t.onload = function () {};t.onerror = function () {
    t.abort();
  };t.send(JSON.stringify(n));
};var encodePayload$1 = function e(r) {
  var n = "";for (var t in r) {
    if (r.hasOwnProperty(t)) {
      n += "&" + t + "=" + encodeURIComponent(JSON.stringify(r[t]));
    }
  }n = n[0] === "&" ? n.slice(1) : n;return n;
};var sendByImg$1 = function e(t, i, s, o) {
  try {
    var a = t.split("v1")[0];if (!a) {
      o(t, i, ERROR_CODE.NO_URL_PREFIX);return;
    }i.forEach(function (e) {
      var r = encodePayload$1(e);var n = new Image(1, 1);n.onload = function () {
        n = null;s();
      };n.onerror = function () {
        n = null;o(t, i, ERROR_CODE.IMG_ON_ERROR);
      };n.src = a + "/v1/gif?" + r;
    });
  } catch (e) {
    o(t, i, ERROR_CODE.IMG_CATCH_ERROR, e.message);
  }
};var request = function e(r) {
  var n = r.url,
      t = r.data,
      i = r.success,
      s = r.fail,
      o = r.notSure,
      a = r.isUnload;var u = t;if (window.XDomainRequest) {
    sendByImg$1(n, u, i, s);return;
  }if (a) {
    if (window.navigator && window.navigator.sendBeacon) {
      o();var f = window.navigator.sendBeacon(n, JSON.stringify(u));if (f) {
        i();
      } else {
        s(n, t, ERROR_CODE.BEACON_STATUS_FALSE);
      }return;
    }sendByImg$1(n, u, i, s);return;
  }var c = new XMLHttpRequest();c.open("POST", n + "?rdn=" + Math.random(), true);c.onload = function () {
    i(n, u, c.responseText);
  };c.onerror = function () {
    c.abort();s(n, u, ERROR_CODE.XHR_ON_ERROR);
  };c.send(JSON.stringify(u));
};function _classCallCheck$7(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var EventSender = function e(r) {
  var c = this;_classCallCheck$7(this, e);this.send = function (e) {
    var r = e.url,
        n = e.data,
        a = e.success,
        i = e.fail,
        u = e.eventError,
        t = e.notSure,
        s = e.isUnload;request({ url: r, data: n, success: function e(r, n, t) {
        a();try {
          var i = JSON.parse(t);var s = i.e;if (s !== 0) {
            var o = "未知错误";if (s === -2) {
              o = "事件格式错误！请检查字段类型是否正确。";
            }c.logger.error("数据上报失败！", "错误码：" + s + "。错误信息：" + o);u(n, s);sdkMonitorOnError(r, n, s);
          }
        } catch (e) {
          sdkMonitorOnError(r, n, ERROR_CODE.RESPONSE_DATA_ERROR);
        }
      }, fail: function e(r, n, t) {
        c.logger.error("数据上报失败！", "错误码：" + t);i(n, t);sdkMonitorOnError(r, n, t);
      }, notSure: t, isUnload: s });if (!c.isSdkMonitorDisabled && !c.isSdkOnLoadEventReady) {
      c.isSdkOnLoadEventReady = true;try {
        var o = n[0].header;var f = n[0].user;sdkMonitorOnload(r, { app_id: o.app_id, app_name: o.app_name, sdk_version: o.sdk_version, web_id: f.web_id });
      } catch (e) {}
    }
  };this.logger = r.logger || logger;this.isSdkOnLoadEventReady = false;this.isSdkMonitorDisabled = false;
};var sdkMonitorOnload = function e(r, n) {
  try {
    var t = { event: "onload", params: JSON.stringify({ app_id: n.app_id, app_name: n.app_name || "", sdk_version: n.sdk_version }), local_time_ms: Date.now() };var i = { events: [t], user: { user_unique_id: n.web_id }, header: { app_id: 1338 } };setTimeout(function () {
      postSdkLog(r, [i]);
    }, 16);
  } catch (e) {}
};var sdkMonitorOnError = function e(r, n, t) {
  try {
    var i = n[0].user;var s = n[0].header;var o = [];n.forEach(function (e) {
      e.events.forEach(function (e) {
        o.push(e);
      });
    });var a = o.map(function (e) {
      return { event: "on_error", params: JSON.stringify({ error_code: t, app_id: s.app_id, app_name: s.app_name || "", error_event: e.event, local_time_ms: e.local_time_ms, tea_event_index: Date.now(), params: e.params, header: JSON.stringify(s), user: JSON.stringify(i) }), local_time_ms: Date.now() };
    });var u = { events: a, user: { user_unique_id: i.user_unique_id }, header: { app_id: 1338 } };setTimeout(function () {
      postSdkLog(r, [u]);
    }, 16);
  } catch (e) {}
};function _classCallCheck$8(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}function _possibleConstructorReturn$2(e, r) {
  if (!e) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }return r && ((typeof r === "undefined" ? "undefined" : _typeof2(r)) === "object" || typeof r === "function") ? r : e;
}function _inherits$2(e, r) {
  if (typeof r !== "function" && r !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + (typeof r === "undefined" ? "undefined" : _typeof2(r)));
  }e.prototype = Object.create(r && r.prototype, { constructor: { value: e, enumerable: false, writable: true, configurable: true } });if (r) Object.setPrototypeOf ? Object.setPrototypeOf(e, r) : e.__proto__ = r;
}var AppChannel = function (u) {
  _inherits$2(f, u);function f(e) {
    _classCallCheck$8(this, f);var o = _possibleConstructorReturn$2(this, u.call(this));o.addListener = function () {
      window.addEventListener("unload", function () {
        o.report(true);
      }, false);window.addEventListener("beforeunload", function () {
        o.report(true);
      }, false);document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "hidden") {
          o.report(true);
        }
      }, false);
    };o.setReady = function (e) {
      o.isReady = e;o.eventSender.isSdkMonitorDisabled = o.isSdkMonitorDisabled;o.checkAndSendCachedStorageEvents();o.report();
    };o.eventReportTimer = null;o.event = function () {
      var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];var r = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;var n = memoryCacheManager.get(o.evtDataCacheKey) || [];var t = r ? [].concat(e, n) : [].concat(n, e);memoryCacheManager.set(o.evtDataCacheKey, t);if (t.length >= 5) {
        o.report();
      } else {
        if (o.eventReportTimer) {
          clearTimeout(o.eventReportTimer);
        }o.eventReportTimer = setTimeout(function () {
          o.report();o.eventReportTimer = null;
        }, o.waitForBatchTime);
      }
    };o.report = function () {
      var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;if (!o.isUserTokensReady) {
        return false;
      }if (!o.isReady) {
        return false;
      }var r = memoryCacheManager.get(o.evtDataCacheKey) || [];memoryCacheManager.clean(o.evtDataCacheKey);var n = o.mergeEnvToEvents(r);o.sendData(n, e);
    };o.sendData = function (e, n) {
      var t = [];var i = 0;var s = void 0;e.forEach(function (e) {
        var r = !!e.__disable_storage__;if (typeof s === "undefined") {
          s = r;
        } else if (r !== s || t[i].length >= 5) {
          i += 1;s = !s;
        }t[i] = t[i] || [];t[i].push(e);
      });t.forEach(function (e) {
        var r = webid();if (!e[0].__disable_storage__) {
          o.eventStorage.add(r, e);
        }o._sendData(r, e, n);
      });
    };o.checkAndSendCachedStorageEvents = function () {
      var r = o.eventStorage.getData();var e = Object.keys(r);if (e.length > 0) {
        e.forEach(function (e) {
          o._sendData(e, r[e]);
        });
      }
    };o._sendData = function (r, e, n) {
      o.isReporting = true;var t = function e() {
        o.isReporting = false;
      };o.eventSender.send({ url: o.reportUrl, data: e, success: function e() {
          t();o.sendDataSuccess(r);
        }, fail: function e(r, n) {
          t();o.reportErrorCallback(r, n);setTimeout(function () {
            o.report();
          }, 3e3);
        }, eventError: function e(r, n) {
          o.reportErrorCallback(r, n);
        }, notSure: t, isUnload: n });
    };o.sendDataSuccess = function (e) {
      o.eventStorage.delete(e);o.report();
    };var r = e.log,
        n = e.disable_storage,
        t = e.max_batch_num,
        i = t === undefined ? 5 : t,
        s = e.batch_time,
        a = s === undefined ? 30 : s;o.init(e);o.maxBatchNum = i;o.waitForBatchTime = a;o.isReady = false;o.addListener();o.enableDebugMode(!!r);o.eventStorage = new EventStorageManager({ disable_storage: n });o.eventStorage.setStorageKey(o.evtDataCacheKey);o.eventSender = new EventSender({ logger: o.logger });o.reportErrorCallback = function () {};return o;
  }return f;
}(AppChannelEnv);var _extends$2 = Object.assign || function (e) {
  for (var r = 1; r < arguments.length; r++) {
    var n = arguments[r];for (var t in n) {
      if (Object.prototype.hasOwnProperty.call(n, t)) {
        e[t] = n[t];
      }
    }
  }return e;
};function _classCallCheck$9(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var getEventIndex = function () {
  var e = +Date.now() + Number(("" + Math.random()).slice(2, 8));return function () {
    e += 1;return e;
  };
}();var preprocessEvent = function e(r, n) {
  var t = /^event\./;var i = r;if (t.test(r)) {
    i = r.slice(6);
  }var s = n;if (!types.isObj(s)) {
    s = {};
  }s.event_index = getEventIndex();var o = { event: i, params: s, local_time_ms: +new Date() };return o;
};var Collector = function e(r) {
  var u = this;_classCallCheck$9(this, e);this.init = function (e) {
    if (!types.isObj(e)) {
      throw new Error("init 的参数必须是Object类型");
    }u.logger.init(e.log);u.channel = new AppChannel(_extends$2({}, e, { name: u.name }));u.channel.callback = function () {
      if (u.callbackSend) {
        u.start();
      }
    };
  };this.config = function (e) {
    if (!types.isObj(e)) {
      u.logger.throw("config 参数必须是 {} 的格式");
    }if (e.log) {
      u.logger.init(true);u.channel.enableDebugMode(true);e.log = null;
    }var r = Object.keys(e);if (!r.length) {
      return false;
    }for (var n = r, t = Array.isArray(n), i = 0, n = t ? n : n[Symbol.iterator]();;) {
      var s;if (t) {
        if (i >= n.length) break;s = n[i++];
      } else {
        i = n.next();if (i.done) break;s = i.value;
      }var o = s;var a = e[o];switch (o) {case "evtParams":
          u.channel.setEvtParams(a);break;case "disable_ssid":
          u.logger.deprecated("(disable_ssid)请通过init函数来设置。");if (a) {
            u.logger.info("ssid已禁用，设置user_unique_id不会请求ssid接口。");u.channel.isSsidDisabled = a;
          }break;case "disable_auto_pv":
          if (a) {
            u.logger.info("已禁止默认上报predefine_pageview事件，需手动上报。");u._autoSendPV = false;
          }break;case "_staging_flag":
          if ("" + a === "1") {
            u.logger.info("根据_staging_flag设置，数据将会上报到stag 表。");
          }u.channel.setEvtParams({ _staging_flag: Number(a) });break;case "reportErrorCallback":
          if (typeof a === "function") {
            u.channel.reportErrorCallback = a;
          }break;default:
          u.channel.setEnv(o, a);}
    }
  };this.send = function () {
    u.start();
  };this.start = function () {
    if (u.channel.isUserTokensReady) {
      if (u._isSendFuncCalled) {
        return;
      }u._isSendFuncCalled = true;u.logger.info("看到本提示，意味着用户信息已完全就绪，上报通道打开。用户标识如下：");u.logger.logJSON(u.channel.get().user);if (u._autoSendPV) {
        u.predefinePageView();
      }u.channel.setReady(true);
    } else {
      u.callbackSend = true;
    }
  };this.predefinePageView = function () {
    var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};var r = { title: document.title || location.pathname, url: location.href, url_path: location.pathname };var n = _extends$2({}, r, e);u.event("predefine_pageview", n, true);
  };this.event = function () {
    for (var e = arguments.length, r = Array(e), n = 0; n < e; n++) {
      r[n] = arguments[n];
    }var t = types.isBoolean(r[r.length - 1]);var i = t ? r[r.length - 1] : false;var s = t ? r.slice(0, r.length - 1) : r;var o = s[0];var a = [];if (!types.isArray(o)) {
      a[0] = s;
    } else {
      a = s;
    }a = a.map(function (e) {
      return preprocessEvent.apply(undefined, e);
    });u.channel.event(a, i);
  };this._isSendFuncCalled = false;this._autoSendPV = true;this.name = r;this.logger = new Logger(r);
};Collector.exportMethods = ["init", "config", "send", "start", "predefinePageView"];function _classCallCheck$a(e, r) {
  if (!(e instanceof r)) {
    throw new TypeError("Cannot call a class as a function");
  }
}var CollectorAsync = function e(r) {
  var o = this;_classCallCheck$a(this, e);this._exportCollect = function () {
    for (var e = arguments.length, r = Array(e), n = 0; n < e; n++) {
      r[n] = arguments[n];
    }if (o._isQueueProcessed) {
      o._executeCmd.apply(o, r);return;
    }o.cmdQueue.push(r);o._processCmdQueue();
  };this._processCmdQueue = function () {
    if (o.cmdQueue.length === 0) {
      return;
    }var e = function e(r, t, i) {
      var s = -1;r.forEach(function (e, r) {
        var n = typeof i !== "undefined" ? e[i] : e;if (n === t) {
          s = r;
        }
      });return s;
    };var n = e(o.cmdQueue, "init", "0");if (n !== -1) {
      o._isQueueProcessed = true;o._executeCmd.apply(o, o.cmdQueue[n]);o.cmdQueue.forEach(function (e, r) {
        if (r !== n) {
          o._executeCmd.apply(o, e);
        }
      });o.cmdQueue = [];
    }
  };this._executeCmd = function () {
    for (var e = arguments.length, r = Array(e), n = 0; n < e; n++) {
      r[n] = arguments[n];
    }var t = r[0];if (Collector.exportMethods.indexOf(t) > -1) {
      var i;(i = o.colloctor)[t].apply(i, r.slice(1));
    } else {
      var s;(s = o.colloctor).event.apply(s, r);
    }
  };this.name = r || "Collector" + +new Date();this.cmdQueue = [];this.colloctor = new Collector(this.name);this._isQueueProcessed = false;this._processCmdQueue();this._exportCollect.init = this._exportCollect.bind(this, "init");this._exportCollect.config = this._exportCollect.bind(this, "config");this._exportCollect.send = this._exportCollect.bind(this, "send");this._exportCollect.start = this._exportCollect.bind(this, "start");this._exportCollect.predefinePageView = this._exportCollect.bind(this, "predefinePageView");return this._exportCollect;
};exports.default = CollectorAsync;
module.exports = exports["default"];

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(9);


/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _volume = __webpack_require__(38);

var _volume2 = _interopRequireDefault(_volume);

var _start = __webpack_require__(39);

var _start2 = _interopRequireDefault(_start);

var _screenShot = __webpack_require__(40);

var _screenShot2 = _interopRequireDefault(_screenShot);

var _rotate = __webpack_require__(41);

var _rotate2 = _interopRequireDefault(_rotate);

var _replay = __webpack_require__(42);

var _replay2 = _interopRequireDefault(_replay);

var _reload = __webpack_require__(43);

var _reload2 = _interopRequireDefault(_reload);

var _playNext = __webpack_require__(44);

var _playNext2 = _interopRequireDefault(_playNext);

var _play = __webpack_require__(45);

var _play2 = _interopRequireDefault(_play);

var _pip = __webpack_require__(46);

var _pip2 = _interopRequireDefault(_pip);

var _pc = __webpack_require__(47);

var _pc2 = _interopRequireDefault(_pc);

var _mobile = __webpack_require__(48);

var _mobile2 = _interopRequireDefault(_mobile);

var _memoryPlay = __webpack_require__(49);

var _memoryPlay2 = _interopRequireDefault(_memoryPlay);

var _logger = __webpack_require__(50);

var _logger2 = _interopRequireDefault(_logger);

var _localPreview = __webpack_require__(51);

var _localPreview2 = _interopRequireDefault(_localPreview);

var _i18n = __webpack_require__(52);

var _i18n2 = _interopRequireDefault(_i18n);

var _fullscreen = __webpack_require__(53);

var _fullscreen2 = _interopRequireDefault(_fullscreen);

var _errorRetry = __webpack_require__(54);

var _errorRetry2 = _interopRequireDefault(_errorRetry);

var _download = __webpack_require__(55);

var _download2 = _interopRequireDefault(_download);

var _definition = __webpack_require__(56);

var _definition2 = _interopRequireDefault(_definition);

var _danmu = __webpack_require__(57);

var _danmu2 = _interopRequireDefault(_danmu);

var _cssFullscreen = __webpack_require__(58);

var _cssFullscreen2 = _interopRequireDefault(_cssFullscreen);

var _collect = __webpack_require__(7);

var _collect2 = _interopRequireDefault(_collect);

var _skin = __webpack_require__(59);

var _skin2 = _interopRequireDefault(_skin);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var Controls = {};

function _buildTree(v, p, a) {
  var o = v;
  p.map(function (_, i) {
    o[_] = i == p.length - 1 ? a : o[_] || {};
    o = o[_];
  });
}

_buildTree(Controls, ['controls', 'collect'], _collect2.default);

_buildTree(Controls, ['controls', 'cssFullscreen'], _cssFullscreen2.default);

_buildTree(Controls, ['controls', 'danmu'], _danmu2.default);

_buildTree(Controls, ['controls', 'definition'], _definition2.default);

_buildTree(Controls, ['controls', 'download'], _download2.default);

_buildTree(Controls, ['controls', 'errorRetry'], _errorRetry2.default);

_buildTree(Controls, ['controls', 'fullscreen'], _fullscreen2.default);

_buildTree(Controls, ['controls', 'i18n'], _i18n2.default);

_buildTree(Controls, ['controls', 'localPreview'], _localPreview2.default);

_buildTree(Controls, ['controls', 'logger'], _logger2.default);

_buildTree(Controls, ['controls', 'memoryPlay'], _memoryPlay2.default);

_buildTree(Controls, ['controls', 'mobile'], _mobile2.default);

_buildTree(Controls, ['controls', 'pc'], _pc2.default);

_buildTree(Controls, ['controls', 'pip'], _pip2.default);

_buildTree(Controls, ['controls', 'play'], _play2.default);

_buildTree(Controls, ['controls', 'playNext'], _playNext2.default);

_buildTree(Controls, ['controls', 'reload'], _reload2.default);

_buildTree(Controls, ['controls', 'replay'], _replay2.default);

_buildTree(Controls, ['controls', 'rotate'], _rotate2.default);

_buildTree(Controls, ['controls', 'screenShot'], _screenShot2.default);

_buildTree(Controls, ['controls', 'start'], _start2.default);

_buildTree(Controls, ['controls', 'volume'], _volume2.default);

exports.default = _player2.default;
module.exports = exports['default'];

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _eventEmitter = __webpack_require__(11);

var _eventEmitter2 = _interopRequireDefault(_eventEmitter);

var _util = __webpack_require__(3);

var _util2 = _interopRequireDefault(_util);

var _error = __webpack_require__(4);

var _error2 = _interopRequireDefault(_error);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Proxy = function () {
  function Proxy(options) {
    _classCallCheck(this, Proxy);

    this.logParams = {
      bc: 0,
      bu_acu_t: 0,
      played: []
    };
    this._hasStart = false;
    this.videoConfig = {
      controls: !!options.isShowControl,
      autoplay: options.autoplay,
      playsinline: options.playsinline,
      'webkit-playsinline': options.playsinline,
      'x5-playsinline': options.playsinline,
      'x5-video-player-type': options['x5-video-player-type'] || options['x5VideoPlayerType'],
      'x5-video-player-fullscreen': options['x5-video-player-fullscreen'] || options['x5VideoPlayerFullscreen'],
      'x5-video-orientation': options['x5-video-orientation'] || options['x5VideoOrientation'],
      airplay: options['airplay'],
      'webkit-airplay': options['airplay'],
      tabindex: 2,
      mediaType: options.mediaType || 'video'
    };
    if (options.loop) {
      this.videoConfig.loop = 'loop';
    }
    var textTrackDom = '';
    this.textTrackShowDefault = true;
    if (options.textTrack && Array.isArray(options.textTrack) && (navigator.userAgent.indexOf('Chrome') > -1 || navigator.userAgent.indexOf('Firefox') > -1)) {
      if (options.textTrack.length > 0 && !options.textTrack.some(function (track) {
        return track.default;
      })) {
        options.textTrack[0].default = true;
        this.textTrackShowDefault = false;
      }
      options.textTrack.some(function (track) {
        if (track.src && track.label && track.default) {
          textTrackDom += '<track src="' + track.src + '" ';
          if (track.kind) {
            textTrackDom += 'kind="' + track.kind + '" ';
          }
          textTrackDom += 'label="' + track.label + '" ';
          if (track.srclang) {
            textTrackDom += 'srclang="' + track.srclang + '" ';
          }
          textTrackDom += (track.default ? 'default' : '') + '>';
          return true;
        }
      });
      this.videoConfig.crossorigin = 'anonymous';
    }
    if (options.textTrackStyle) {
      var style = document.createElement('style');
      this.textTrackStyle = style;
      document.head.appendChild(style);
      var styleStr = '';
      for (var index in options.textTrackStyle) {
        styleStr += index + ': ' + options.textTrackStyle[index] + ';';
      }
      var wrap = options.id ? '#' + options.id : options.el.id ? '#' + options.el.id : '.' + options.el.className;
      if (style.sheet.insertRule) {
        style.sheet.insertRule(wrap + ' video::cue { ' + styleStr + ' }', 0);
      } else if (style.sheet.addRule) {
        style.sheet.addRule(wrap + ' video::cue', styleStr);
      }
    }
    this.video = _util2.default.createDom(this.videoConfig.mediaType, textTrackDom, this.videoConfig, '');
    if (!this.textTrackShowDefault && textTrackDom) {
      var trackDoms = this.video.getElementsByTagName('Track');
      trackDoms[0].track.mode = 'hidden';
    }
    if (options.autoplay) {
      this.video.autoplay = true;
      if (options.autoplayMuted) {
        this.video.muted = true;
      }
    }
    this.ev = ['play', 'playing', 'pause', 'ended', 'error', 'seeking', 'seeked', 'timeupdate', 'waiting', 'canplay', 'canplaythrough', 'durationchange', 'volumechange', 'loadeddata'].map(function (item) {
      return _defineProperty({}, item, 'on' + item.charAt(0).toUpperCase() + item.slice(1));
    });
    (0, _eventEmitter2.default)(this);

    this._interval = {};
    var lastBuffer = '0,0';
    var self = this;

    this.ev.forEach(function (item) {
      self.evItem = Object.keys(item)[0];
      var name = Object.keys(item)[0];
      self.video.addEventListener(Object.keys(item)[0], function () {
        // fix when video destroy called and video reload
        if (!self.logParams) {
          return;
        }
        if (name === 'play') {
          self.hasStart = true;
        } else if (name === 'waiting') {
          self.logParams.bc++;
          self.inWaitingStart = new Date().getTime();
        } else if (name === 'playing') {
          if (self.inWaitingStart) {
            self.logParams.bu_acu_t += new Date().getTime() - self.inWaitingStart;
            self.inWaitingStart = undefined;
          }
        } else if (name === 'loadeddata') {
          self.logParams.played.push({
            begin: 0,
            end: -1
          });
        } else if (name === 'seeking') {
          self.logParams.played.push({
            begin: self.video.currentTime,
            end: -1
          });
        } else if (self && self.logParams && self.logParams.played && name === 'timeupdate') {
          if (self.logParams.played.length < 1) {
            self.logParams.played.push({
              begin: self.video.currentTime,
              end: -1
            });
          }
          self.logParams.played[self.logParams.played.length - 1].end = self.video.currentTime;
        }
        if (name === 'error') {
          // process the error
          self._onError(name);
        } else {
          self.emit(name, self);
        }

        if (self.hasOwnProperty('_interval')) {
          if (['ended', 'error', 'timeupdate'].indexOf(name) < 0) {
            clearInterval(self._interval['bufferedChange']);
            _util2.default.setInterval(self, 'bufferedChange', function () {
              if (self.video && self.video.buffered) {
                var curBuffer = [];
                for (var i = 0, len = self.video.buffered.length; i < len; i++) {
                  curBuffer.push([self.video.buffered.start(i), self.video.buffered.end(i)]);
                }
                if (curBuffer.toString() !== lastBuffer) {
                  lastBuffer = curBuffer.toString();
                  self.emit('bufferedChange', curBuffer);
                }
              }
            }, 200);
          } else {
            if (name !== 'timeupdate') {
              _util2.default.clearInterval(self, 'bufferedChange');
            }
          }
        }
      }, false);
    });
  }
  /**
   * 错误监听处理逻辑抽离
   */


  _createClass(Proxy, [{
    key: '_onError',
    value: function _onError(name) {
      if (this.video && this.video.error) {
        this.emit(name, new _error2.default('other', this.currentTime, this.duration, this.networkState, this.readyState, this.currentSrc, this.src, this.ended, {
          line: 162,
          msg: this.error,
          handle: 'Constructor'
        }, this.video.error.code, this.video.error));
      }
    }
  }, {
    key: 'destroy',
    value: function destroy() {
      if (this.textTrackStyle) {
        this.textTrackStyle.parentNode.removeChild(this.textTrackStyle);
      }
    }
  }, {
    key: 'play',
    value: function play() {
      return this.video.play();
    }
  }, {
    key: 'pause',
    value: function pause() {
      this.video.pause();
    }
  }, {
    key: 'canPlayType',
    value: function canPlayType(type) {
      return this.video.canPlayType(type);
    }
  }, {
    key: 'getBufferedRange',
    value: function getBufferedRange() {
      var range = [0, 0];
      var video = this.video;
      var buffered = video.buffered;
      var currentTime = video.currentTime;
      if (buffered) {
        for (var i = 0, len = buffered.length; i < len; i++) {
          range[0] = buffered.start(i);
          range[1] = buffered.end(i);
          if (range[0] <= currentTime && currentTime <= range[1]) {
            break;
          }
        }
      }
      if (range[0] - currentTime <= 0 && currentTime - range[1] <= 0) {
        return range;
      } else {
        return [0, 0];
      }
    }
  }, {
    key: 'hasStart',
    get: function get() {
      return this._hasStart;
    },
    set: function set(bool) {
      if (typeof bool === 'boolean' && bool === true && !this._hasStart) {
        this._hasStart = true;
        this.emit('hasstart');
      }
    }
  }, {
    key: 'autoplay',
    set: function set(isTrue) {
      this.video.autoplay = isTrue;
    },
    get: function get() {
      return this.video.autoplay;
    }
  }, {
    key: 'buffered',
    get: function get() {
      return this.video.buffered;
    }
  }, {
    key: 'crossOrigin',
    get: function get() {
      return this.video.crossOrigin;
    },
    set: function set(isTrue) {
      this.video.crossOrigin = isTrue;
    }
  }, {
    key: 'currentSrc',
    get: function get() {
      return this.video.currentSrc;
    },
    set: function set(src) {
      this.video.currentSrc = src;
    }
  }, {
    key: 'currentTime',
    get: function get() {
      return this.video.currentTime;
    },
    set: function set(time) {
      if (typeof isFinite === 'function' && !isFinite(time)) return;
      this.video.currentTime = time;
      this.emit('currentTimeChange');
    }
  }, {
    key: 'defaultMuted',
    get: function get() {
      return this.video.defaultMuted;
    },
    set: function set(isTrue) {
      this.video.defaultMuted = isTrue;
    }
  }, {
    key: 'duration',
    get: function get() {
      return this.video.duration;
    }
  }, {
    key: 'ended',
    get: function get() {
      return this.video.ended;
    }
  }, {
    key: 'error',
    get: function get() {
      var err = this.video.error;
      if (!err) {
        return null;
      }
      var status = [{
        en: 'MEDIA_ERR_ABORTED',
        cn: '取回过程被用户中止'
      }, {
        en: 'MEDIA_ERR_NETWORK',
        cn: '当下载时发生错误'
      }, {
        en: 'MEDIA_ERR_DECODE',
        cn: '当解码时发生错误'
      }, {
        en: 'MEDIA_ERR_SRC_NOT_SUPPORTED',
        cn: '不支持音频/视频'
      }];
      return this.lang ? this.lang[status[err.code - 1].en] : status[err.code - 1].en;
    }
  }, {
    key: 'loop',
    get: function get() {
      return this.video.loop;
    },
    set: function set(isTrue) {
      this.video.loop = isTrue;
    }
  }, {
    key: 'muted',
    get: function get() {
      return this.video.muted;
    },
    set: function set(isTrue) {
      this.video.muted = isTrue;
    }
  }, {
    key: 'networkState',
    get: function get() {
      var status = [{
        en: 'NETWORK_EMPTY',
        cn: '音频/视频尚未初始化'
      }, {
        en: 'NETWORK_IDLE',
        cn: '音频/视频是活动的且已选取资源，但并未使用网络'
      }, {
        en: 'NETWORK_LOADING',
        cn: '浏览器正在下载数据'
      }, {
        en: 'NETWORK_NO_SOURCE',
        cn: '未找到音频/视频来源'
      }];
      return this.lang ? this.lang[status[this.video.networkState].en] : status[this.video.networkState].en;
    }
  }, {
    key: 'paused',
    get: function get() {
      return this.video.paused;
    }
  }, {
    key: 'playbackRate',
    get: function get() {
      return this.video.playbackRate;
    },
    set: function set(rate) {
      this.video.playbackRate = rate;
    }
  }, {
    key: 'played',
    get: function get() {
      return this.video.played;
    }
  }, {
    key: 'preload',
    get: function get() {
      return this.video.preload;
    },
    set: function set(isTrue) {
      this.video.preload = isTrue;
    }
  }, {
    key: 'readyState',
    get: function get() {
      var status = [{
        en: 'HAVE_NOTHING',
        cn: '没有关于音频/视频是否就绪的信息'
      }, {
        en: 'HAVE_METADATA',
        cn: '关于音频/视频就绪的元数据'
      }, {
        en: 'HAVE_CURRENT_DATA',
        cn: '关于当前播放位置的数据是可用的，但没有足够的数据来播放下一帧/毫秒'
      }, {
        en: 'HAVE_FUTURE_DATA',
        cn: '当前及至少下一帧的数据是可用的'
      }, {
        en: 'HAVE_ENOUGH_DATA',
        cn: '可用数据足以开始播放'
      }];
      return this.lang ? this.lang[status[this.video.readyState].en] : status[this.video.readyState];
    }
  }, {
    key: 'seekable',
    get: function get() {
      return this.video.seekable;
    }
  }, {
    key: 'seeking',
    get: function get() {
      return this.video.seeking;
    }
  }, {
    key: 'src',
    get: function get() {
      return this.video.src;
    },
    set: function set(url) {
      var self = this;
      if (!_util2.default.hasClass(this.root, 'xgplayer-ended')) {
        this.emit('urlchange', JSON.parse(JSON.stringify(self.logParams)));
      }
      this.logParams = {
        bc: 0,
        bu_acu_t: 0,
        played: [],
        pt: new Date().getTime(),
        vt: new Date().getTime(),
        vd: 0
      };
      this.video.pause();
      this.video.src = url;
      this.emit('srcChange');
      this.logParams.playSrc = url;
      this.logParams.pt = new Date().getTime();
      this.logParams.vt = this.logParams.pt;
      function ldFunc() {
        self.logParams.vt = new Date().getTime();
        if (self.logParams.pt > self.logParams.vt) {
          self.logParams.pt = self.logParams.vt;
        }
        self.logParams.vd = self.video.duration;
        self.off('loadeddata', ldFunc);
      }
      this.once('loadeddata', ldFunc);
    }
  }, {
    key: 'poster',
    set: function set(posterUrl) {
      var poster = _util2.default.findDom(this.root, '.xgplayer-poster');
      if (poster) {
        poster.style.backgroundImage = 'url(' + posterUrl + ')';
      }
    }
  }, {
    key: 'volume',
    get: function get() {
      return this.video.volume;
    },
    set: function set(vol) {
      this.video.volume = vol;
    }
  }, {
    key: 'fullscreen',
    get: function get() {
      return _util2.default.hasClass(this.root, 'xgplayer-is-fullscreen') || _util2.default.hasClass(this.root, 'xgplayer-fullscreen-active');
    }
  }, {
    key: 'bullet',
    get: function get() {
      return _util2.default.findDom(this.root, 'xg-danmu') ? _util2.default.hasClass(_util2.default.findDom(this.root, 'xg-danmu'), 'xgplayer-has-danmu') : false;
    }
  }, {
    key: 'textTrack',
    get: function get() {
      return _util2.default.hasClass(this.root, 'xgplayer-is-textTrack');
    }
  }, {
    key: 'pip',
    get: function get() {
      return _util2.default.hasClass(this.root, 'xgplayer-pip-active');
    }
  }]);

  return Proxy;
}();

exports.default = Proxy;
module.exports = exports['default'];

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var d = __webpack_require__(12),
    callable = __webpack_require__(29),
    apply = Function.prototype.apply,
    call = Function.prototype.call,
    create = Object.create,
    defineProperty = Object.defineProperty,
    defineProperties = Object.defineProperties,
    hasOwnProperty = Object.prototype.hasOwnProperty,
    descriptor = { configurable: true, enumerable: false, writable: true },
    on,
    _once2,
    off,
    emit,
    methods,
    descriptors,
    base;

on = function on(type, listener) {
	var data;

	callable(listener);

	if (!hasOwnProperty.call(this, '__ee__')) {
		data = descriptor.value = create(null);
		defineProperty(this, '__ee__', descriptor);
		descriptor.value = null;
	} else {
		data = this.__ee__;
	}
	if (!data[type]) data[type] = listener;else if (_typeof(data[type]) === 'object') data[type].push(listener);else data[type] = [data[type], listener];

	return this;
};

_once2 = function once(type, listener) {
	var _once, self;

	callable(listener);
	self = this;
	on.call(this, type, _once = function once() {
		off.call(self, type, _once);
		apply.call(listener, this, arguments);
	});

	_once.__eeOnceListener__ = listener;
	return this;
};

off = function off(type, listener) {
	var data, listeners, candidate, i;

	callable(listener);

	if (!hasOwnProperty.call(this, '__ee__')) return this;
	data = this.__ee__;
	if (!data[type]) return this;
	listeners = data[type];

	if ((typeof listeners === 'undefined' ? 'undefined' : _typeof(listeners)) === 'object') {
		for (i = 0; candidate = listeners[i]; ++i) {
			if (candidate === listener || candidate.__eeOnceListener__ === listener) {
				if (listeners.length === 2) data[type] = listeners[i ? 0 : 1];else listeners.splice(i, 1);
			}
		}
	} else {
		if (listeners === listener || listeners.__eeOnceListener__ === listener) {
			delete data[type];
		}
	}

	return this;
};

emit = function emit(type) {
	var i, l, listener, listeners, args;

	if (!hasOwnProperty.call(this, '__ee__')) return;
	listeners = this.__ee__[type];
	if (!listeners) return;

	if ((typeof listeners === 'undefined' ? 'undefined' : _typeof(listeners)) === 'object') {
		l = arguments.length;
		args = new Array(l - 1);
		for (i = 1; i < l; ++i) {
			args[i - 1] = arguments[i];
		}listeners = listeners.slice();
		for (i = 0; listener = listeners[i]; ++i) {
			apply.call(listener, this, args);
		}
	} else {
		switch (arguments.length) {
			case 1:
				call.call(listeners, this);
				break;
			case 2:
				call.call(listeners, this, arguments[1]);
				break;
			case 3:
				call.call(listeners, this, arguments[1], arguments[2]);
				break;
			default:
				l = arguments.length;
				args = new Array(l - 1);
				for (i = 1; i < l; ++i) {
					args[i - 1] = arguments[i];
				}
				apply.call(listeners, this, args);
		}
	}
};

methods = {
	on: on,
	once: _once2,
	off: off,
	emit: emit
};

descriptors = {
	on: d(on),
	once: d(_once2),
	off: d(off),
	emit: d(emit)
};

base = defineProperties({}, descriptors);

module.exports = exports = function exports(o) {
	return o == null ? create(base) : defineProperties(Object(o), descriptors);
};
exports.methods = methods;

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isValue = __webpack_require__(2),
    isPlainFunction = __webpack_require__(13),
    assign = __webpack_require__(17),
    normalizeOpts = __webpack_require__(25),
    contains = __webpack_require__(26);

var d = module.exports = function (dscr, value /*, options*/) {
	var c, e, w, options, desc;
	if (arguments.length < 2 || typeof dscr !== "string") {
		options = value;
		value = dscr;
		dscr = null;
	} else {
		options = arguments[2];
	}
	if (isValue(dscr)) {
		c = contains.call(dscr, "c");
		e = contains.call(dscr, "e");
		w = contains.call(dscr, "w");
	} else {
		c = w = true;
		e = false;
	}

	desc = { value: value, configurable: c, enumerable: e, writable: w };
	return !options ? desc : assign(normalizeOpts(options), desc);
};

d.gs = function (dscr, get, set /*, options*/) {
	var c, e, options, desc;
	if (typeof dscr !== "string") {
		options = set;
		set = get;
		get = dscr;
		dscr = null;
	} else {
		options = arguments[3];
	}
	if (!isValue(get)) {
		get = undefined;
	} else if (!isPlainFunction(get)) {
		options = get;
		get = set = undefined;
	} else if (!isValue(set)) {
		set = undefined;
	} else if (!isPlainFunction(set)) {
		options = set;
		set = undefined;
	}
	if (isValue(dscr)) {
		c = contains.call(dscr, "c");
		e = contains.call(dscr, "e");
	} else {
		c = true;
		e = false;
	}

	desc = { get: get, set: set, configurable: c, enumerable: e };
	return !options ? desc : assign(normalizeOpts(options), desc);
};

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isFunction = __webpack_require__(14);

var classRe = /^\s*class[\s{/}]/,
    functionToString = Function.prototype.toString;

module.exports = function (value) {
	if (!isFunction(value)) return false;
	if (classRe.test(functionToString.call(value))) return false;
	return true;
};

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isPrototype = __webpack_require__(15);

module.exports = function (value) {
	if (typeof value !== "function") return false;

	if (!hasOwnProperty.call(value, "length")) return false;

	try {
		if (typeof value.length !== "number") return false;
		if (typeof value.call !== "function") return false;
		if (typeof value.apply !== "function") return false;
	} catch (error) {
		return false;
	}

	return !isPrototype(value);
};

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isObject = __webpack_require__(16);

module.exports = function (value) {
	if (!isObject(value)) return false;
	try {
		if (!value.constructor) return false;
		return value.constructor.prototype === value;
	} catch (error) {
		return false;
	}
};

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var isValue = __webpack_require__(2);

// prettier-ignore
var possibleTypes = { "object": true, "function": true, "undefined": true /* document.all */ };

module.exports = function (value) {
	if (!isValue(value)) return false;
	return hasOwnProperty.call(possibleTypes, typeof value === "undefined" ? "undefined" : _typeof(value));
};

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = __webpack_require__(18)() ? Object.assign : __webpack_require__(19);

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	var assign = Object.assign,
	    obj;
	if (typeof assign !== "function") return false;
	obj = { foo: "raz" };
	assign(obj, { bar: "dwa" }, { trzy: "trzy" });
	return obj.foo + obj.bar + obj.trzy === "razdwatrzy";
};

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var keys = __webpack_require__(20),
    value = __webpack_require__(24),
    max = Math.max;

module.exports = function (dest, src /*, …srcn*/) {
	var error,
	    i,
	    length = max(arguments.length, 2),
	    assign;
	dest = Object(value(dest));
	assign = function assign(key) {
		try {
			dest[key] = src[key];
		} catch (e) {
			if (!error) error = e;
		}
	};
	for (i = 1; i < length; ++i) {
		src = arguments[i];
		keys(src).forEach(assign);
	}
	if (error !== undefined) throw error;
	return dest;
};

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = __webpack_require__(21)() ? Object.keys : __webpack_require__(22);

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {
	try {
		Object.keys("primitive");
		return true;
	} catch (e) {
		return false;
	}
};

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isValue = __webpack_require__(1);

var keys = Object.keys;

module.exports = function (object) {
  return keys(isValue(object) ? Object(object) : object);
};

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// eslint-disable-next-line no-empty-function

module.exports = function () {};

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isValue = __webpack_require__(1);

module.exports = function (value) {
	if (!isValue(value)) throw new TypeError("Cannot use null or undefined");
	return value;
};

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isValue = __webpack_require__(1);

var forEach = Array.prototype.forEach,
    create = Object.create;

var process = function process(src, obj) {
	var key;
	for (key in src) {
		obj[key] = src[key];
	}
};

// eslint-disable-next-line no-unused-vars
module.exports = function (opts1 /*, …options*/) {
	var result = create(null);
	forEach.call(arguments, function (options) {
		if (!isValue(options)) return;
		process(Object(options), result);
	});
	return result;
};

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = __webpack_require__(27)() ? String.prototype.contains : __webpack_require__(28);

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var str = "razdwatrzy";

module.exports = function () {
	if (typeof str.contains !== "function") return false;
	return str.contains("dwa") === true && str.contains("foo") === false;
};

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var indexOf = String.prototype.indexOf;

module.exports = function (searchString /*, position*/) {
	return indexOf.call(this, searchString, arguments[1]) > -1;
};

/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function (fn) {
	if (typeof fn !== "function") throw new TypeError(fn + " is not a function");
	return fn;
};

/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var INDEXDB = function () {
  function INDEXDB() {
    var mydb = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : { name: 'xgplayer', version: 1, db: null, ojstore: { name: 'xg-m4a', keypath: 'vid' } };

    _classCallCheck(this, INDEXDB);

    this.indexedDB = window.indexedDB || window.webkitindexedDB;
    this.IDBKeyRange = window.IDBKeyRange || window.webkitIDBKeyRange; // 键范围
    this.myDB = mydb;
  }

  _createClass(INDEXDB, [{
    key: 'openDB',
    value: function openDB(callback) {
      var _this = this;

      // 建立或打开数据库，建立对象存储空间(ObjectStore)
      var self = this;
      var version = this.myDB.version || 1;
      var request = self.indexedDB.open(self.myDB.name, version);
      request.onerror = function (e) {
        // console.log('e.currentTarget.error.message')
      };
      request.onsuccess = function (e) {
        _this.myDB.db = e.target.result;
        // console.log('成功建立并打开数据库:' + this.myDB.name + ' version' + this.myDB.version)
        callback.call(self);
      };
      request.onupgradeneeded = function (e) {
        var db = e.target.result;
        var transaction = e.target.transaction;
        var store = void 0;
        if (!db.objectStoreNames.contains(self.myDB.ojstore.name)) {
          // 没有该对象空间时创建该对象空间
          store = db.createObjectStore(self.myDB.ojstore.name, { keyPath: self.myDB.ojstore.keypath });
          // console.log('成功建立对象存储空间：' + this.myDB.ojstore.name)
        }
      };
    }
  }, {
    key: 'deletedb',
    value: function deletedb() {
      // 删除数据库
      var self = this;
      self.indexedDB.deleteDatabase(this.myDB.name);
      // console.log(this.myDB.name + '数据库已删除')
    }
  }, {
    key: 'closeDB',
    value: function closeDB() {
      // 关闭数据库
      this.myDB.db.close();
      // console.log('数据库已关闭')
    }
  }, {
    key: 'addData',
    value: function addData(storename, data) {
      // 添加数据，重复添加会报错
      var store = this.myDB.db.transaction(storename, 'readwrite').objectStore(storename);
      var request = void 0;
      for (var i = 0; i < data.length; i++) {
        request = store.add(data[i]);
        request.onerror = function () {
          // console.error('add添加数据库中已有该数据')
        };
        request.onsuccess = function () {
          // console.log('add添加数据已存入数据库')
        };
      }
    }
  }, {
    key: 'putData',
    value: function putData(storename, data) {
      // 添加数据，重复添加会更新原有数据
      var store = this.myDB.db.transaction(storename, 'readwrite').objectStore(storename);
      var request = void 0;
      for (var i = 0; i < data.length; i++) {
        request = store.put(data[i]);
        request.onerror = function () {
          // console.error('put添加数据库中已有该数据')
        };
        request.onsuccess = function () {
          // console.log('put添加数据已存入数据库')
        };
      }
    }
  }, {
    key: 'getDataByKey',
    value: function getDataByKey(storename, key, callback) {
      var self = this;
      // 根据存储空间的键找到对应数据
      var store = this.myDB.db.transaction(storename, 'readwrite').objectStore(storename);
      var request = store.get(key);
      request.onerror = function () {
        // console.error('getDataByKey error')
        callback.call(self, null);
      };
      request.onsuccess = function (e) {
        var result = e.target.result;
        // console.log('查找数据成功')
        callback.call(self, result);
      };
    }
  }, {
    key: 'deleteData',
    value: function deleteData(storename, key) {
      // 删除某一条记录
      var store = this.myDB.db.transaction(storename, 'readwrite').objectStore(storename);
      store.delete(key);
      // console.log('已删除存储空间' + storename + '中' + key + '记录')
    }
  }, {
    key: 'clearData',
    value: function clearData(storename) {
      // 删除存储空间全部记录
      var store = this.myDB.db.transaction(storename, 'readwrite').objectStore(storename);
      store.clear();
      // console.log('已删除存储空间' + storename + '全部记录')
    }
  }]);

  return INDEXDB;
}();

exports.default = INDEXDB;
module.exports = exports['default'];

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * Draggabilly v2.2.0
 * Make that shiz draggable
 * https://draggabilly.desandro.com
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true */

(function (window, factory) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if (true) {
    // AMD
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(32), __webpack_require__(33)], __WEBPACK_AMD_DEFINE_RESULT__ = (function (getSize, Unidragger) {
      return factory(window, getSize, Unidragger);
    }).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(window, function factory(window, getSize, Unidragger) {

  'use strict';

  // -------------------------- helpers & variables -------------------------- //

  // extend objects

  function extend(a, b) {
    for (var prop in b) {
      a[prop] = b[prop];
    }
    return a;
  }

  function noop() {}

  var jQuery = window.jQuery;

  // --------------------------  -------------------------- //

  function Draggabilly(element, options) {
    // querySelector if string
    this.element = typeof element == 'string' ? document.querySelector(element) : element;

    if (jQuery) {
      this.$element = jQuery(this.element);
    }

    // options
    this.options = extend({}, this.constructor.defaults);
    this.option(options);

    this._create();
  }

  // inherit Unidragger methods
  var proto = Draggabilly.prototype = Object.create(Unidragger.prototype);

  Draggabilly.defaults = {};

  /**
   * set options
   * @param {Object} opts
   */
  proto.option = function (opts) {
    extend(this.options, opts);
  };

  // css position values that don't need to be set
  var positionValues = {
    relative: true,
    absolute: true,
    fixed: true
  };

  proto._create = function () {
    // properties
    this.position = {};
    this._getPosition();

    this.startPoint = { x: 0, y: 0 };
    this.dragPoint = { x: 0, y: 0 };

    this.startPosition = extend({}, this.position);

    // set relative positioning
    var style = getComputedStyle(this.element);
    if (!positionValues[style.position]) {
      this.element.style.position = 'relative';
    }

    // events, bridge jQuery events from vanilla
    this.on('pointerDown', this.onPointerDown);
    this.on('pointerMove', this.onPointerMove);
    this.on('pointerUp', this.onPointerUp);

    this.enable();
    this.setHandles();
  };

  /**
   * set this.handles and bind start events to 'em
   */
  proto.setHandles = function () {
    this.handles = this.options.handle ? this.element.querySelectorAll(this.options.handle) : [this.element];

    this.bindHandles();
  };

  /**
   * emits events via EvEmitter and jQuery events
   * @param {String} type - name of event
   * @param {Event} event - original event
   * @param {Array} args - extra arguments
   */
  proto.dispatchEvent = function (type, event, args) {
    var emitArgs = [event].concat(args);
    this.emitEvent(type, emitArgs);
    this.dispatchJQueryEvent(type, event, args);
  };

  proto.dispatchJQueryEvent = function (type, event, args) {
    var jQuery = window.jQuery;
    // trigger jQuery event
    if (!jQuery || !this.$element) {
      return;
    }
    // create jQuery event
    var $event = jQuery.Event(event);
    $event.type = type;
    this.$element.trigger($event, args);
  };

  // -------------------------- position -------------------------- //

  // get x/y position from style
  proto._getPosition = function () {
    var style = getComputedStyle(this.element);
    var x = this._getPositionCoord(style.left, 'width');
    var y = this._getPositionCoord(style.top, 'height');
    // clean up 'auto' or other non-integer values
    this.position.x = isNaN(x) ? 0 : x;
    this.position.y = isNaN(y) ? 0 : y;

    this._addTransformPosition(style);
  };

  proto._getPositionCoord = function (styleSide, measure) {
    if (styleSide.indexOf('%') != -1) {
      // convert percent into pixel for Safari, #75
      var parentSize = getSize(this.element.parentNode);
      // prevent not-in-DOM element throwing bug, #131
      return !parentSize ? 0 : parseFloat(styleSide) / 100 * parentSize[measure];
    }
    return parseInt(styleSide, 10);
  };

  // add transform: translate( x, y ) to position
  proto._addTransformPosition = function (style) {
    var transform = style.transform;
    // bail out if value is 'none'
    if (transform.indexOf('matrix') !== 0) {
      return;
    }
    // split matrix(1, 0, 0, 1, x, y)
    var matrixValues = transform.split(',');
    // translate X value is in 12th or 4th position
    var xIndex = transform.indexOf('matrix3d') === 0 ? 12 : 4;
    var translateX = parseInt(matrixValues[xIndex], 10);
    // translate Y value is in 13th or 5th position
    var translateY = parseInt(matrixValues[xIndex + 1], 10);
    this.position.x += translateX;
    this.position.y += translateY;
  };

  // -------------------------- events -------------------------- //

  proto.onPointerDown = function (event, pointer) {
    this.element.classList.add('is-pointer-down');
    this.dispatchJQueryEvent('pointerDown', event, [pointer]);
  };

  /**
   * drag start
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.dragStart = function (event, pointer) {
    if (!this.isEnabled) {
      return;
    }
    this._getPosition();
    this.measureContainment();
    // position _when_ drag began
    this.startPosition.x = this.position.x;
    this.startPosition.y = this.position.y;
    // reset left/top style
    this.setLeftTop();

    this.dragPoint.x = 0;
    this.dragPoint.y = 0;

    this.element.classList.add('is-dragging');
    this.dispatchEvent('dragStart', event, [pointer]);
    // start animation
    this.animate();
  };

  proto.measureContainment = function () {
    var container = this.getContainer();
    if (!container) {
      return;
    }

    var elemSize = getSize(this.element);
    var containerSize = getSize(container);
    var elemRect = this.element.getBoundingClientRect();
    var containerRect = container.getBoundingClientRect();

    var borderSizeX = containerSize.borderLeftWidth + containerSize.borderRightWidth;
    var borderSizeY = containerSize.borderTopWidth + containerSize.borderBottomWidth;

    var position = this.relativeStartPosition = {
      x: elemRect.left - (containerRect.left + containerSize.borderLeftWidth),
      y: elemRect.top - (containerRect.top + containerSize.borderTopWidth)
    };

    this.containSize = {
      width: containerSize.width - borderSizeX - position.x - elemSize.width,
      height: containerSize.height - borderSizeY - position.y - elemSize.height
    };
  };

  proto.getContainer = function () {
    var containment = this.options.containment;
    if (!containment) {
      return;
    }
    var isElement = containment instanceof HTMLElement;
    // use as element
    if (isElement) {
      return containment;
    }
    // querySelector if string
    if (typeof containment == 'string') {
      return document.querySelector(containment);
    }
    // fallback to parent element
    return this.element.parentNode;
  };

  // ----- move event ----- //

  proto.onPointerMove = function (event, pointer, moveVector) {
    this.dispatchJQueryEvent('pointerMove', event, [pointer, moveVector]);
  };

  /**
   * drag move
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.dragMove = function (event, pointer, moveVector) {
    if (!this.isEnabled) {
      return;
    }
    var dragX = moveVector.x;
    var dragY = moveVector.y;

    var grid = this.options.grid;
    var gridX = grid && grid[0];
    var gridY = grid && grid[1];

    dragX = applyGrid(dragX, gridX);
    dragY = applyGrid(dragY, gridY);

    dragX = this.containDrag('x', dragX, gridX);
    dragY = this.containDrag('y', dragY, gridY);

    // constrain to axis
    dragX = this.options.axis == 'y' ? 0 : dragX;
    dragY = this.options.axis == 'x' ? 0 : dragY;

    this.position.x = this.startPosition.x + dragX;
    this.position.y = this.startPosition.y + dragY;
    // set dragPoint properties
    this.dragPoint.x = dragX;
    this.dragPoint.y = dragY;

    this.dispatchEvent('dragMove', event, [pointer, moveVector]);
  };

  function applyGrid(value, grid, method) {
    method = method || 'round';
    return grid ? Math[method](value / grid) * grid : value;
  }

  proto.containDrag = function (axis, drag, grid) {
    if (!this.options.containment) {
      return drag;
    }
    var measure = axis == 'x' ? 'width' : 'height';

    var rel = this.relativeStartPosition[axis];
    var min = applyGrid(-rel, grid, 'ceil');
    var max = this.containSize[measure];
    max = applyGrid(max, grid, 'floor');
    return Math.max(min, Math.min(max, drag));
  };

  // ----- end event ----- //

  /**
   * pointer up
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.onPointerUp = function (event, pointer) {
    this.element.classList.remove('is-pointer-down');
    this.dispatchJQueryEvent('pointerUp', event, [pointer]);
  };

  /**
   * drag end
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.dragEnd = function (event, pointer) {
    if (!this.isEnabled) {
      return;
    }
    // use top left position when complete
    this.element.style.transform = '';
    this.setLeftTop();
    this.element.classList.remove('is-dragging');
    this.dispatchEvent('dragEnd', event, [pointer]);
  };

  // -------------------------- animation -------------------------- //

  proto.animate = function () {
    // only render and animate if dragging
    if (!this.isDragging) {
      return;
    }

    this.positionDrag();

    var _this = this;
    requestAnimationFrame(function animateFrame() {
      _this.animate();
    });
  };

  // left/top positioning
  proto.setLeftTop = function () {
    this.element.style.left = this.position.x + 'px';
    this.element.style.top = this.position.y + 'px';
  };

  proto.positionDrag = function () {
    this.element.style.transform = 'translate3d( ' + this.dragPoint.x + 'px, ' + this.dragPoint.y + 'px, 0)';
  };

  // ----- staticClick ----- //

  proto.staticClick = function (event, pointer) {
    this.dispatchEvent('staticClick', event, [pointer]);
  };

  // ----- methods ----- //

  /**
   * @param {Number} x
   * @param {Number} y
   */
  proto.setPosition = function (x, y) {
    this.position.x = x;
    this.position.y = y;
    this.setLeftTop();
  };

  proto.enable = function () {
    this.isEnabled = true;
  };

  proto.disable = function () {
    this.isEnabled = false;
    if (this.isDragging) {
      this.dragEnd();
    }
  };

  proto.destroy = function () {
    this.disable();
    // reset styles
    this.element.style.transform = '';
    this.element.style.left = '';
    this.element.style.top = '';
    this.element.style.position = '';
    // unbind handles
    this.unbindHandles();
    // remove jQuery data
    if (this.$element) {
      this.$element.removeData('draggabilly');
    }
  };

  // ----- jQuery bridget ----- //

  // required for jQuery bridget
  proto._init = noop;

  if (jQuery && jQuery.bridget) {
    jQuery.bridget('draggabilly', Draggabilly);
  }

  // -----  ----- //

  return Draggabilly;
});

/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * getSize v2.0.3
 * measure size of elements
 * MIT license
 */

/* jshint browser: true, strict: true, undef: true, unused: true */
/* globals console: false */

(function (window, factory) {
  /* jshint strict: false */ /* globals define, module */
  if (true) {
    // AMD
    !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(window, function factory() {
  'use strict';

  // -------------------------- helpers -------------------------- //

  // get a number from a string, not a percentage

  function getStyleSize(value) {
    var num = parseFloat(value);
    // not a percent like '100%', and a number
    var isValid = value.indexOf('%') == -1 && !isNaN(num);
    return isValid && num;
  }

  function noop() {}

  var logError = typeof console == 'undefined' ? noop : function (message) {
    console.error(message);
  };

  // -------------------------- measurements -------------------------- //

  var measurements = ['paddingLeft', 'paddingRight', 'paddingTop', 'paddingBottom', 'marginLeft', 'marginRight', 'marginTop', 'marginBottom', 'borderLeftWidth', 'borderRightWidth', 'borderTopWidth', 'borderBottomWidth'];

  var measurementsLength = measurements.length;

  function getZeroSize() {
    var size = {
      width: 0,
      height: 0,
      innerWidth: 0,
      innerHeight: 0,
      outerWidth: 0,
      outerHeight: 0
    };
    for (var i = 0; i < measurementsLength; i++) {
      var measurement = measurements[i];
      size[measurement] = 0;
    }
    return size;
  }

  // -------------------------- getStyle -------------------------- //

  /**
   * getStyle, get style of element, check for Firefox bug
   * https://bugzilla.mozilla.org/show_bug.cgi?id=548397
   */
  function getStyle(elem) {
    var style = getComputedStyle(elem);
    if (!style) {
      logError('Style returned ' + style + '. Are you running this code in a hidden iframe on Firefox? ' + 'See https://bit.ly/getsizebug1');
    }
    return style;
  }

  // -------------------------- setup -------------------------- //

  var isSetup = false;

  var isBoxSizeOuter;

  /**
   * setup
   * check isBoxSizerOuter
   * do on first getSize() rather than on page load for Firefox bug
   */
  function setup() {
    // setup once
    if (isSetup) {
      return;
    }
    isSetup = true;

    // -------------------------- box sizing -------------------------- //

    /**
     * Chrome & Safari measure the outer-width on style.width on border-box elems
     * IE11 & Firefox<29 measures the inner-width
     */
    var div = document.createElement('div');
    div.style.width = '200px';
    div.style.padding = '1px 2px 3px 4px';
    div.style.borderStyle = 'solid';
    div.style.borderWidth = '1px 2px 3px 4px';
    div.style.boxSizing = 'border-box';

    var body = document.body || document.documentElement;
    body.appendChild(div);
    var style = getStyle(div);
    // round value for browser zoom. desandro/masonry#928
    isBoxSizeOuter = Math.round(getStyleSize(style.width)) == 200;
    getSize.isBoxSizeOuter = isBoxSizeOuter;

    body.removeChild(div);
  }

  // -------------------------- getSize -------------------------- //

  function getSize(elem) {
    setup();

    // use querySeletor if elem is string
    if (typeof elem == 'string') {
      elem = document.querySelector(elem);
    }

    // do not proceed on non-objects
    if (!elem || (typeof elem === 'undefined' ? 'undefined' : _typeof(elem)) != 'object' || !elem.nodeType) {
      return;
    }

    var style = getStyle(elem);

    // if hidden, everything is 0
    if (style.display == 'none') {
      return getZeroSize();
    }

    var size = {};
    size.width = elem.offsetWidth;
    size.height = elem.offsetHeight;

    var isBorderBox = size.isBorderBox = style.boxSizing == 'border-box';

    // get all measurements
    for (var i = 0; i < measurementsLength; i++) {
      var measurement = measurements[i];
      var value = style[measurement];
      var num = parseFloat(value);
      // any 'auto', 'medium' value will be 0
      size[measurement] = !isNaN(num) ? num : 0;
    }

    var paddingWidth = size.paddingLeft + size.paddingRight;
    var paddingHeight = size.paddingTop + size.paddingBottom;
    var marginWidth = size.marginLeft + size.marginRight;
    var marginHeight = size.marginTop + size.marginBottom;
    var borderWidth = size.borderLeftWidth + size.borderRightWidth;
    var borderHeight = size.borderTopWidth + size.borderBottomWidth;

    var isBorderBoxSizeOuter = isBorderBox && isBoxSizeOuter;

    // overwrite width and height if we can get it from style
    var styleWidth = getStyleSize(style.width);
    if (styleWidth !== false) {
      size.width = styleWidth + (
      // add padding and border unless it's already including it
      isBorderBoxSizeOuter ? 0 : paddingWidth + borderWidth);
    }

    var styleHeight = getStyleSize(style.height);
    if (styleHeight !== false) {
      size.height = styleHeight + (
      // add padding and border unless it's already including it
      isBorderBoxSizeOuter ? 0 : paddingHeight + borderHeight);
    }

    size.innerWidth = size.width - (paddingWidth + borderWidth);
    size.innerHeight = size.height - (paddingHeight + borderHeight);

    size.outerWidth = size.width + marginWidth;
    size.outerHeight = size.height + marginHeight;

    return size;
  }

  return getSize;
});

/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * Unidragger v2.3.0
 * Draggable base class
 * MIT license
 */

/*jshint browser: true, unused: true, undef: true, strict: true */

(function (window, factory) {
  // universal module definition
  /*jshint strict: false */ /*globals define, module, require */

  if (true) {
    // AMD
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(34)], __WEBPACK_AMD_DEFINE_RESULT__ = (function (Unipointer) {
      return factory(window, Unipointer);
    }).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(window, function factory(window, Unipointer) {

  'use strict';

  // -------------------------- Unidragger -------------------------- //

  function Unidragger() {}

  // inherit Unipointer & EvEmitter
  var proto = Unidragger.prototype = Object.create(Unipointer.prototype);

  // ----- bind start ----- //

  proto.bindHandles = function () {
    this._bindHandles(true);
  };

  proto.unbindHandles = function () {
    this._bindHandles(false);
  };

  /**
   * Add or remove start event
   * @param {Boolean} isAdd
   */
  proto._bindHandles = function (isAdd) {
    // munge isAdd, default to true
    isAdd = isAdd === undefined ? true : isAdd;
    // bind each handle
    var bindMethod = isAdd ? 'addEventListener' : 'removeEventListener';
    var touchAction = isAdd ? this._touchActionValue : '';
    for (var i = 0; i < this.handles.length; i++) {
      var handle = this.handles[i];
      this._bindStartEvent(handle, isAdd);
      handle[bindMethod]('click', this);
      // touch-action: none to override browser touch gestures. metafizzy/flickity#540
      if (window.PointerEvent) {
        handle.style.touchAction = touchAction;
      }
    }
  };

  // prototype so it can be overwriteable by Flickity
  proto._touchActionValue = 'none';

  // ----- start event ----- //

  /**
   * pointer start
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.pointerDown = function (event, pointer) {
    var isOkay = this.okayPointerDown(event);
    if (!isOkay) {
      return;
    }
    // track start event position
    this.pointerDownPointer = pointer;

    event.preventDefault();
    this.pointerDownBlur();
    // bind move and end events
    this._bindPostStartEvents(event);
    this.emitEvent('pointerDown', [event, pointer]);
  };

  // nodes that have text fields
  var cursorNodes = {
    TEXTAREA: true,
    INPUT: true,
    SELECT: true,
    OPTION: true
  };

  // input types that do not have text fields
  var clickTypes = {
    radio: true,
    checkbox: true,
    button: true,
    submit: true,
    image: true,
    file: true
  };

  // dismiss inputs with text fields. flickity#403, flickity#404
  proto.okayPointerDown = function (event) {
    var isCursorNode = cursorNodes[event.target.nodeName];
    var isClickType = clickTypes[event.target.type];
    var isOkay = !isCursorNode || isClickType;
    if (!isOkay) {
      this._pointerReset();
    }
    return isOkay;
  };

  // kludge to blur previously focused input
  proto.pointerDownBlur = function () {
    var focused = document.activeElement;
    // do not blur body for IE10, metafizzy/flickity#117
    var canBlur = focused && focused.blur && focused != document.body;
    if (canBlur) {
      focused.blur();
    }
  };

  // ----- move event ----- //

  /**
   * drag move
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.pointerMove = function (event, pointer) {
    var moveVector = this._dragPointerMove(event, pointer);
    this.emitEvent('pointerMove', [event, pointer, moveVector]);
    this._dragMove(event, pointer, moveVector);
  };

  // base pointer move logic
  proto._dragPointerMove = function (event, pointer) {
    var moveVector = {
      x: pointer.pageX - this.pointerDownPointer.pageX,
      y: pointer.pageY - this.pointerDownPointer.pageY
    };
    // start drag if pointer has moved far enough to start drag
    if (!this.isDragging && this.hasDragStarted(moveVector)) {
      this._dragStart(event, pointer);
    }
    return moveVector;
  };

  // condition if pointer has moved far enough to start drag
  proto.hasDragStarted = function (moveVector) {
    return Math.abs(moveVector.x) > 3 || Math.abs(moveVector.y) > 3;
  };

  // ----- end event ----- //

  /**
   * pointer up
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto.pointerUp = function (event, pointer) {
    this.emitEvent('pointerUp', [event, pointer]);
    this._dragPointerUp(event, pointer);
  };

  proto._dragPointerUp = function (event, pointer) {
    if (this.isDragging) {
      this._dragEnd(event, pointer);
    } else {
      // pointer didn't move enough for drag to start
      this._staticClick(event, pointer);
    }
  };

  // -------------------------- drag -------------------------- //

  // dragStart
  proto._dragStart = function (event, pointer) {
    this.isDragging = true;
    // prevent clicks
    this.isPreventingClicks = true;
    this.dragStart(event, pointer);
  };

  proto.dragStart = function (event, pointer) {
    this.emitEvent('dragStart', [event, pointer]);
  };

  // dragMove
  proto._dragMove = function (event, pointer, moveVector) {
    // do not drag if not dragging yet
    if (!this.isDragging) {
      return;
    }

    this.dragMove(event, pointer, moveVector);
  };

  proto.dragMove = function (event, pointer, moveVector) {
    event.preventDefault();
    this.emitEvent('dragMove', [event, pointer, moveVector]);
  };

  // dragEnd
  proto._dragEnd = function (event, pointer) {
    // set flags
    this.isDragging = false;
    // re-enable clicking async
    setTimeout(function () {
      delete this.isPreventingClicks;
    }.bind(this));

    this.dragEnd(event, pointer);
  };

  proto.dragEnd = function (event, pointer) {
    this.emitEvent('dragEnd', [event, pointer]);
  };

  // ----- onclick ----- //

  // handle all clicks and prevent clicks when dragging
  proto.onclick = function (event) {
    if (this.isPreventingClicks) {
      event.preventDefault();
    }
  };

  // ----- staticClick ----- //

  // triggered after pointer down & up with no/tiny movement
  proto._staticClick = function (event, pointer) {
    // ignore emulated mouse up clicks
    if (this.isIgnoringMouseUp && event.type == 'mouseup') {
      return;
    }

    this.staticClick(event, pointer);

    // set flag for emulated clicks 300ms after touchend
    if (event.type != 'mouseup') {
      this.isIgnoringMouseUp = true;
      // reset flag after 300ms
      setTimeout(function () {
        delete this.isIgnoringMouseUp;
      }.bind(this), 400);
    }
  };

  proto.staticClick = function (event, pointer) {
    this.emitEvent('staticClick', [event, pointer]);
  };

  // ----- utils ----- //

  Unidragger.getPointerPoint = Unipointer.getPointerPoint;

  // -----  ----- //

  return Unidragger;
});

/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * Unipointer v2.3.0
 * base class for doing one thing with pointer event
 * MIT license
 */

/*jshint browser: true, undef: true, unused: true, strict: true */

(function (window, factory) {
  // universal module definition
  /* jshint strict: false */ /*global define, module, require */
  if (true) {
    // AMD
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(35)], __WEBPACK_AMD_DEFINE_RESULT__ = (function (EvEmitter) {
      return factory(window, EvEmitter);
    }).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(window, function factory(window, EvEmitter) {

  'use strict';

  function noop() {}

  function Unipointer() {}

  // inherit EvEmitter
  var proto = Unipointer.prototype = Object.create(EvEmitter.prototype);

  proto.bindStartEvent = function (elem) {
    this._bindStartEvent(elem, true);
  };

  proto.unbindStartEvent = function (elem) {
    this._bindStartEvent(elem, false);
  };

  /**
   * Add or remove start event
   * @param {Boolean} isAdd - remove if falsey
   */
  proto._bindStartEvent = function (elem, isAdd) {
    // munge isAdd, default to true
    isAdd = isAdd === undefined ? true : isAdd;
    var bindMethod = isAdd ? 'addEventListener' : 'removeEventListener';

    // default to mouse events
    var startEvent = 'mousedown';
    if (window.PointerEvent) {
      // Pointer Events
      startEvent = 'pointerdown';
    } else if ('ontouchstart' in window) {
      // Touch Events. iOS Safari
      startEvent = 'touchstart';
    }
    elem[bindMethod](startEvent, this);
  };

  // trigger handler methods for events
  proto.handleEvent = function (event) {
    var method = 'on' + event.type;
    if (this[method]) {
      this[method](event);
    }
  };

  // returns the touch that we're keeping track of
  proto.getTouch = function (touches) {
    for (var i = 0; i < touches.length; i++) {
      var touch = touches[i];
      if (touch.identifier == this.pointerIdentifier) {
        return touch;
      }
    }
  };

  // ----- start event ----- //

  proto.onmousedown = function (event) {
    // dismiss clicks from right or middle buttons
    var button = event.button;
    if (button && button !== 0 && button !== 1) {
      return;
    }
    this._pointerDown(event, event);
  };

  proto.ontouchstart = function (event) {
    this._pointerDown(event, event.changedTouches[0]);
  };

  proto.onpointerdown = function (event) {
    this._pointerDown(event, event);
  };

  /**
   * pointer start
   * @param {Event} event
   * @param {Event or Touch} pointer
   */
  proto._pointerDown = function (event, pointer) {
    // dismiss right click and other pointers
    // button = 0 is okay, 1-4 not
    if (event.button || this.isPointerDown) {
      return;
    }

    this.isPointerDown = true;
    // save pointer identifier to match up touch events
    this.pointerIdentifier = pointer.pointerId !== undefined ?
    // pointerId for pointer events, touch.indentifier for touch events
    pointer.pointerId : pointer.identifier;

    this.pointerDown(event, pointer);
  };

  proto.pointerDown = function (event, pointer) {
    this._bindPostStartEvents(event);
    this.emitEvent('pointerDown', [event, pointer]);
  };

  // hash of events to be bound after start event
  var postStartEvents = {
    mousedown: ['mousemove', 'mouseup'],
    touchstart: ['touchmove', 'touchend', 'touchcancel'],
    pointerdown: ['pointermove', 'pointerup', 'pointercancel']
  };

  proto._bindPostStartEvents = function (event) {
    if (!event) {
      return;
    }
    // get proper events to match start event
    var events = postStartEvents[event.type];
    // bind events to node
    events.forEach(function (eventName) {
      window.addEventListener(eventName, this);
    }, this);
    // save these arguments
    this._boundPointerEvents = events;
  };

  proto._unbindPostStartEvents = function () {
    // check for _boundEvents, in case dragEnd triggered twice (old IE8 bug)
    if (!this._boundPointerEvents) {
      return;
    }
    this._boundPointerEvents.forEach(function (eventName) {
      window.removeEventListener(eventName, this);
    }, this);

    delete this._boundPointerEvents;
  };

  // ----- move event ----- //

  proto.onmousemove = function (event) {
    this._pointerMove(event, event);
  };

  proto.onpointermove = function (event) {
    if (event.pointerId == this.pointerIdentifier) {
      this._pointerMove(event, event);
    }
  };

  proto.ontouchmove = function (event) {
    var touch = this.getTouch(event.changedTouches);
    if (touch) {
      this._pointerMove(event, touch);
    }
  };

  /**
   * pointer move
   * @param {Event} event
   * @param {Event or Touch} pointer
   * @private
   */
  proto._pointerMove = function (event, pointer) {
    this.pointerMove(event, pointer);
  };

  // public
  proto.pointerMove = function (event, pointer) {
    this.emitEvent('pointerMove', [event, pointer]);
  };

  // ----- end event ----- //


  proto.onmouseup = function (event) {
    this._pointerUp(event, event);
  };

  proto.onpointerup = function (event) {
    if (event.pointerId == this.pointerIdentifier) {
      this._pointerUp(event, event);
    }
  };

  proto.ontouchend = function (event) {
    var touch = this.getTouch(event.changedTouches);
    if (touch) {
      this._pointerUp(event, touch);
    }
  };

  /**
   * pointer up
   * @param {Event} event
   * @param {Event or Touch} pointer
   * @private
   */
  proto._pointerUp = function (event, pointer) {
    this._pointerDone();
    this.pointerUp(event, pointer);
  };

  // public
  proto.pointerUp = function (event, pointer) {
    this.emitEvent('pointerUp', [event, pointer]);
  };

  // ----- pointer done ----- //

  // triggered on pointer up & pointer cancel
  proto._pointerDone = function () {
    this._pointerReset();
    this._unbindPostStartEvents();
    this.pointerDone();
  };

  proto._pointerReset = function () {
    // reset properties
    this.isPointerDown = false;
    delete this.pointerIdentifier;
  };

  proto.pointerDone = noop;

  // ----- pointer cancel ----- //

  proto.onpointercancel = function (event) {
    if (event.pointerId == this.pointerIdentifier) {
      this._pointerCancel(event, event);
    }
  };

  proto.ontouchcancel = function (event) {
    var touch = this.getTouch(event.changedTouches);
    if (touch) {
      this._pointerCancel(event, touch);
    }
  };

  /**
   * pointer cancel
   * @param {Event} event
   * @param {Event or Touch} pointer
   * @private
   */
  proto._pointerCancel = function (event, pointer) {
    this._pointerDone();
    this.pointerCancel(event, pointer);
  };

  // public
  proto.pointerCancel = function (event, pointer) {
    this.emitEvent('pointerCancel', [event, pointer]);
  };

  // -----  ----- //

  // utility function for getting x/y coords from event
  Unipointer.getPointerPoint = function (pointer) {
    return {
      x: pointer.pageX,
      y: pointer.pageY
    };
  };

  // -----  ----- //

  return Unipointer;
});

/***/ }),
/* 35 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/**
 * EvEmitter v1.1.0
 * Lil' event emitter
 * MIT License
 */

/* jshint unused: true, undef: true, strict: true */

(function (global, factory) {
  // universal module definition
  /* jshint strict: false */ /* globals define, module, window */
  if (true) {
    // AMD - RequireJS
    !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(typeof window != 'undefined' ? window : undefined, function () {

  "use strict";

  function EvEmitter() {}

  var proto = EvEmitter.prototype;

  proto.on = function (eventName, listener) {
    if (!eventName || !listener) {
      return;
    }
    // set events hash
    var events = this._events = this._events || {};
    // set listeners array
    var listeners = events[eventName] = events[eventName] || [];
    // only add once
    if (listeners.indexOf(listener) == -1) {
      listeners.push(listener);
    }

    return this;
  };

  proto.once = function (eventName, listener) {
    if (!eventName || !listener) {
      return;
    }
    // add event
    this.on(eventName, listener);
    // set once flag
    // set onceEvents hash
    var onceEvents = this._onceEvents = this._onceEvents || {};
    // set onceListeners object
    var onceListeners = onceEvents[eventName] = onceEvents[eventName] || {};
    // set flag
    onceListeners[listener] = true;

    return this;
  };

  proto.off = function (eventName, listener) {
    var listeners = this._events && this._events[eventName];
    if (!listeners || !listeners.length) {
      return;
    }
    var index = listeners.indexOf(listener);
    if (index != -1) {
      listeners.splice(index, 1);
    }

    return this;
  };

  proto.emitEvent = function (eventName, args) {
    var listeners = this._events && this._events[eventName];
    if (!listeners || !listeners.length) {
      return;
    }
    // copy over to avoid interference if .off() in listener
    listeners = listeners.slice(0);
    args = args || [];
    // once stuff
    var onceListeners = this._onceEvents && this._onceEvents[eventName];

    for (var i = 0; i < listeners.length; i++) {
      var listener = listeners[i];
      var isOnce = onceListeners && onceListeners[listener];
      if (isOnce) {
        // remove listener
        // remove before trigger to prevent recursion
        this.off(eventName, listener);
        // unset once flag
        delete onceListeners[listener];
      }
      // trigger listener
      listener.apply(this, args);
    }

    return this;
  };

  proto.allOff = function () {
    delete this._events;
    delete this._onceEvents;
  };

  return EvEmitter;
});

/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
var getAbsoluteURL = exports.getAbsoluteURL = function getAbsoluteURL(url) {
  // Check if absolute URL
  if (!url.match(/^https?:\/\//)) {
    var div = document.createElement('div');
    div.innerHTML = '<a href="' + url + '">x</a>';
    url = div.firstChild.href;
  }
  return url;
};

/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

//download.js v4.2, by dandavis; 2008-2016. [MIT] see http://danml.com/download.html for tests/usage
// v1 landed a FF+Chrome compat way of downloading strings to local un-named files, upgraded to use a hidden frame and optional mime
// v2 added named files via a[download], msSaveBlob, IE (10+) support, and window.URL support for larger+faster saves than dataURLs
// v3 added dataURL and Blob Input, bind-toggle arity, and legacy dataURL fallback was improved with force-download mime and base64 support. 3.1 improved safari handling.
// v4 adds AMD/UMD, commonJS, and plain browser support
// v4.1 adds url download capability via solo URL argument (same domain/CORS only)
// v4.2 adds semantic variable names, long (over 2MB) dataURL support, and hidden by default temp anchors
// https://github.com/rndme/download

(function (root, factory) {
	if (true) {
		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
})(undefined, function () {

	return function download(data, strFileName, strMimeType) {

		var self = window,
		    // this script is only for browsers anyway...
		defaultMime = "application/octet-stream",
		    // this default mime also triggers iframe downloads
		mimeType = strMimeType || defaultMime,
		    payload = data,
		    url = !strFileName && !strMimeType && payload,
		    anchor = document.createElement("a"),
		    toString = function toString(a) {
			return String(a);
		},
		    myBlob = self.Blob || self.MozBlob || self.WebKitBlob || toString,
		    fileName = strFileName || "download",
		    blob,
		    reader;
		myBlob = myBlob.call ? myBlob.bind(self) : Blob;

		if (String(this) === "true") {
			//reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
			payload = [payload, mimeType];
			mimeType = payload[0];
			payload = payload[1];
		}

		if (url && url.length < 2048) {
			// if no filename and no mime, assume a url was passed as the only argument
			fileName = url.split("/").pop().split("?")[0];
			anchor.href = url; // assign href prop to temp anchor
			if (anchor.href.indexOf(url) !== -1) {
				// if the browser determines that it's a potentially valid url path:
				var ajax = new XMLHttpRequest();
				ajax.open("GET", url, true);
				ajax.responseType = 'blob';
				ajax.onload = function (e) {
					download(e.target.response, fileName, defaultMime);
				};
				setTimeout(function () {
					ajax.send();
				}, 0); // allows setting custom ajax headers using the return:
				return ajax;
			} // end if valid url?
		} // end if url?


		//go ahead and download dataURLs right away
		if (/^data:([\w+-]+\/[\w+.-]+)?[,;]/.test(payload)) {

			if (payload.length > 1024 * 1024 * 1.999 && myBlob !== toString) {
				payload = dataUrlToBlob(payload);
				mimeType = payload.type || defaultMime;
			} else {
				return navigator.msSaveBlob ? // IE10 can't do a[download], only Blobs:
				navigator.msSaveBlob(dataUrlToBlob(payload), fileName) : saver(payload); // everyone else can save dataURLs un-processed
			}
		} else {
			//not data url, is it a string with special needs?
			if (/([\x80-\xff])/.test(payload)) {
				var i = 0,
				    tempUiArr = new Uint8Array(payload.length),
				    mx = tempUiArr.length;
				for (i; i < mx; ++i) {
					tempUiArr[i] = payload.charCodeAt(i);
				}payload = new myBlob([tempUiArr], { type: mimeType });
			}
		}
		blob = payload instanceof myBlob ? payload : new myBlob([payload], { type: mimeType });

		function dataUrlToBlob(strUrl) {
			var parts = strUrl.split(/[:;,]/),
			    type = parts[1],
			    decoder = parts[2] == "base64" ? atob : decodeURIComponent,
			    binData = decoder(parts.pop()),
			    mx = binData.length,
			    i = 0,
			    uiArr = new Uint8Array(mx);

			for (i; i < mx; ++i) {
				uiArr[i] = binData.charCodeAt(i);
			}return new myBlob([uiArr], { type: type });
		}

		function saver(url, winMode) {

			if ('download' in anchor) {
				//html5 A[download]
				anchor.href = url;
				anchor.setAttribute("download", fileName);
				anchor.className = "download-js-link";
				anchor.innerHTML = "downloading...";
				anchor.style.display = "none";
				document.body.appendChild(anchor);
				setTimeout(function () {
					anchor.click();
					document.body.removeChild(anchor);
					if (winMode === true) {
						setTimeout(function () {
							self.URL.revokeObjectURL(anchor.href);
						}, 250);
					}
				}, 66);
				return true;
			}

			// handle non-a[download] safari as best we can:
			if (/(Version)\/(\d+)\.(\d+)(?:\.(\d+))?.*Safari\//.test(navigator.userAgent)) {
				if (/^data:/.test(url)) url = "data:" + url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
				if (!window.open(url)) {
					// popup blocked, offer direct download:
					if (confirm("Displaying New Document\n\nUse Save As... to download, then click back to return to this page.")) {
						location.href = url;
					}
				}
				return true;
			}

			//do iframe dataURL download (old ch+FF):
			var f = document.createElement("iframe");
			document.body.appendChild(f);

			if (!winMode && /^data:/.test(url)) {
				// force a mime that will download:
				url = "data:" + url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
			}
			f.src = url;
			setTimeout(function () {
				document.body.removeChild(f);
			}, 333);
		} //end saver


		if (navigator.msSaveBlob) {
			// IE10+ : (has Blob, but not a[download] or URL)
			return navigator.msSaveBlob(blob, fileName);
		}

		if (self.URL) {
			// simple fast and modern way using Blob and URL:
			saver(self.URL.createObjectURL(blob), true);
		} else {
			// handle non-Blob()+non-URL browsers:
			if (typeof blob === "string" || blob.constructor === toString) {
				try {
					return saver("data:" + mimeType + ";base64," + self.btoa(blob));
				} catch (y) {
					return saver("data:" + mimeType + "," + encodeURIComponent(blob));
				}
			}

			// Blob but not URL support:
			reader = new FileReader();
			reader.onload = function (e) {
				saver(this.result);
			};
			reader.readAsDataURL(blob);
		}
		return true;
	}; /* end download() */
});

/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var volume = function volume() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var container = void 0,
      slider = void 0,
      bar = void 0,
      selected = void 0,
      icon = void 0;
  function onCanplay() {
    player.volume = _player2.default.sniffer.device === 'mobile' ? 1 : player.config.volume;
    container = player.controls.querySelector('.xgplayer-volume');
    slider = container.querySelector('.xgplayer-slider');
    bar = container.querySelector('.xgplayer-bar');
    selected = container.querySelector('.xgplayer-drag');
    icon = container.querySelector('.xgplayer-icon');
  }
  player.once('canplay', onCanplay);

  function onVolumeBarClick(e) {
    player.video.muted = false;
    slider.focus();
    util.event(e);

    var barRect = bar.getBoundingClientRect();
    var pos = { x: e.clientX, y: e.clientY };
    var height = selected.getBoundingClientRect().height;
    var isMove = false;
    var onMove = function onMove(e) {
      e.preventDefault();
      e.stopPropagation();
      util.event(e);
      isMove = true;
      var w = height - e.clientY + pos.y;
      var now = w / barRect.height;
      selected.style.height = w + 'px';
      player.volume = Math.max(Math.min(now, 1), 0);
    };
    var onUp = function onUp(e) {
      e.preventDefault();
      e.stopPropagation();
      util.event(e);
      window.removeEventListener('mousemove', onMove);
      window.removeEventListener('touchmove', onMove);
      window.removeEventListener('mouseup', onUp);
      window.removeEventListener('touchend', onUp);

      if (!isMove) {
        var w = barRect.height - (e.clientY - barRect.top);
        var now = w / barRect.height;
        selected.style.height = w + 'px';
        if (now <= 0) {
          if (player.volume > 0) {
            selected.volume = player.video.volume;
          } else {
            now = selected.volume;
          }
        }
        player.volume = Math.max(Math.min(now, 1), 0);
      }
      slider.volume = player.volume;
      isMove = false;
    };
    window.addEventListener('mousemove', onMove);
    window.addEventListener('touchmove', onMove);
    window.addEventListener('mouseup', onUp);
    window.addEventListener('touchend', onUp);
    return false;
  }
  player.on('volumeBarClick', onVolumeBarClick);

  function onVolumeIconClick() {
    if (_player2.default.sniffer.device === 'mobile') {
      // util.removeClass(root, 'xgplayer-volume-muted')
      // util.removeClass(root, 'xgplayer-volume-large')
      if (player.video.muted) {
        player.video.muted = false;
        // util.addClass(root, 'xgplayer-volume-large')
      } else {
        player.video.muted = true;
        // util.addClass(root, 'xgplayer-volume-muted')
      }
    } else {
      player.video.muted = false;
      if (player.volume < 0.1) {
        if (slider.volume < 0.1) {
          player.volume = 0.6;
        } else {
          player.volume = slider.volume;
        }
      } else {
        player.volume = 0;
      }
    }
    // onVolumeChange ()
  }
  player.on('volumeIconClick', onVolumeIconClick);

  function onVolumeIconEnter() {
    util.addClass(root, 'xgplayer-volume-active');
    if (container) {
      container.focus();
    }
  }
  player.on('volumeIconEnter', onVolumeIconEnter);

  function onVolumeIconLeave() {
    util.removeClass(root, 'xgplayer-volume-active');
  }
  player.on('volumeIconLeave', onVolumeIconLeave);

  var _changeTimer = null;
  function onVolumeChange() {
    if (_changeTimer) {
      clearTimeout(_changeTimer);
    }
    _changeTimer = setTimeout(function () {
      if (_player2.default.sniffer.device === 'mobile') {
        util.removeClass(root, 'xgplayer-volume-muted');
        util.removeClass(root, 'xgplayer-volume-large');
        if (player.video.muted) {
          util.addClass(root, 'xgplayer-volume-muted');
        } else {
          util.addClass(root, 'xgplayer-volume-large');
        }
      } else {
        util.removeClass(root, 'xgplayer-volume-muted');
        util.removeClass(root, 'xgplayer-volume-small');
        util.removeClass(root, 'xgplayer-volume-large');
        if (player.volume === 0) {
          util.addClass(root, 'xgplayer-volume-muted');
        } else if (player.volume < 0.5) {
          util.addClass(root, 'xgplayer-volume-small');
        } else {
          util.addClass(root, 'xgplayer-volume-large');
        }
        if (!bar) return;
        var containerHeight = bar.getBoundingClientRect().height || 76;
        selected.style.height = player.volume * containerHeight + 'px';
      }
    }, 50);
  }
  player.on('volumechange', onVolumeChange);

  function onDestroy() {
    player.off('canplay', onCanplay);
    player.off('volumeBarClick', onVolumeBarClick);
    player.off('volumeIconClick', onVolumeIconClick);
    player.off('volumeIconEnter', onVolumeIconEnter);
    player.off('volumeIconLeave', onVolumeIconLeave);
    player.off('volumechange', onVolumeChange);
    player.off('destroy', onDestroy);
    if (_changeTimer) {
      clearTimeout(_changeTimer);
      _changeTimer = null;
    }
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('volume', volume);

/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var start = function start() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  function onCanplay() {
    util.removeClass(root, 'xgplayer-is-enter');
  }

  function onPlaying() {
    util.removeClass(root, 'xgplayer-is-enter');
  }

  function onStartBtnClick() {
    if (util.hasClass(root, 'xgplayer-nostart')) {
      util.removeClass(root, 'xgplayer-nostart'); // for ie quick switch
      util.addClass(root, 'xgplayer-is-enter');
      player.on('canplay', onCanplay);
      player.once('playing', onPlaying);
      if (!root.querySelector('video')) {
        player.start();
      }
      var playPromise = player.play();
      if (playPromise !== undefined && playPromise) {
        playPromise.catch(function (err) {});
      }
    } else {
      if (player.paused) {
        util.removeClass(root, 'xgplayer-nostart xgplayer-isloading');
        setTimeout(function () {
          var playPromise = player.play();
          if (playPromise !== undefined && playPromise) {
            playPromise.catch(function (err) {});
          }
        }, 10);
      }
    }
  }
  player.on('startBtnClick', onStartBtnClick);

  function onDestroy() {
    player.off('canplay', onCanplay);
    player.off('playing', onPlaying);
    player.off('startBtnClick', onStartBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('start', start);

/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var screenShot = function screenShot() {
  var player = this;
  var root = player.root;
  var screenShotOptions = player.config.screenShot;
  if (!screenShotOptions) {
    return;
  }

  var encoderOptions = 0.92;
  if (screenShotOptions.quality || screenShotOptions.quality === 0) {
    encoderOptions = screenShotOptions.quality;
  }
  var type = screenShotOptions.type === undefined ? 'image/png' : screenShotOptions.type;
  var format = screenShotOptions.format === undefined ? '.png' : screenShotOptions.format;

  var canvas = document.createElement('canvas');
  var canvasCtx = canvas.getContext('2d');
  var img = new Image();
  canvas.width = this.config.width || 600;
  canvas.height = this.config.height || 337.5;

  var saveScreenShot = function saveScreenShot(data, filename) {
    var saveLink = document.createElement('a');
    saveLink.href = data;
    saveLink.download = filename;
    var event = document.createEvent('MouseEvents');
    event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    saveLink.dispatchEvent(event);
  };

  function onScreenShotBtnClick() {
    var save = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

    canvas.width = player.video.videoWidth || 600;
    canvas.height = player.video.videoHeight || 337.5;
    img.onload = function () {
      canvasCtx.drawImage(player.video, 0, 0, canvas.width, canvas.height);
      img.setAttribute('crossOrigin', 'anonymous');
      img.src = canvas.toDataURL(type, encoderOptions).replace(type, 'image/octet-stream');
      var screenShotImg = img.src.replace(/^data:image\/[^;]+/, 'data:application/octet-stream');
      player.emit('screenShot', screenShotImg);
      save && saveScreenShot(screenShotImg, '截图' + format);
    }();
  }
  player.on('screenShotBtnClick', onScreenShotBtnClick);

  function onDestroy() {
    player.off('screenShotBtnClick', onScreenShotBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('screenShot', screenShot);

/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var rotate = function rotate() {
  var player = this;
  var rotateConfig = player.config.rotate;
  if (!rotateConfig) {
    return;
  }

  function onRotateBtnClick() {
    player.rotate(rotateConfig.clockwise, rotateConfig.innerRotate);
  }
  player.on('rotateBtnClick', onRotateBtnClick);

  function onDestroy() {
    player.off('rotateBtnClick', onRotateBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('rotate', rotate);

/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var replay = function replay() {
  var player = this;
  var util = _player2.default.util;
  var root = player.root;

  function onReplayBtnClick() {
    util.removeClass(root, 'replay');
    player.replay();
  }
  player.on('replayBtnClick', onReplayBtnClick);

  function onEnded() {
    if (!player.config.loop) {
      util.addClass(root, 'replay');
    }
  }
  player.on('ended', onEnded);

  function onDestroy() {
    player.off('replayBtnClick', onReplayBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('replay', replay);

/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var reload = function reload() {
  var player = this;
  var reloadConfig = player.config.reload;
  if (!reloadConfig) {
    return;
  }

  function onReloadBtnClick() {
    _player2.default.util.removeClass(player.root, 'xgplayer-is-error');
    player.src = player.config.url;
  }
  player.on('reloadBtnClick', onReloadBtnClick);

  function onDestroy() {
    player.off('reloadBtnClick', onReloadBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('reload', reload);

/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var playNext = function playNext() {
  var player = this;
  var root = player.root;
  var nextBtn = player.config.playNext;
  player.currentVideoIndex = -1;

  function onPlayNextBtnClick() {
    if (player.currentVideoIndex + 1 < nextBtn.urlList.length) {
      player.currentVideoIndex++;
      player.video.autoplay = true;
      player.src = nextBtn.urlList[player.currentVideoIndex];
      player.emit('playerNext', player.currentVideoIndex + 1);
    } else {
      player.emit('urlList last');
    }
  }
  player.on('playNextBtnClick', onPlayNextBtnClick);

  function onDestroy() {
    player.off('playNextBtnClick', onPlayNextBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('playNext', playNext);

/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var play = function play() {
  var player = this;

  function onPlayBtnClick() {
    if (player.ended) {
      return;
    }
    if (player.paused) {
      var playPromise = player.play();
      if (playPromise !== undefined && playPromise) {
        playPromise.catch(function (err) {});
      }
    } else {
      player.pause();
    }
  }
  player.on('playBtnClick', onPlayBtnClick);

  function onDestroy() {
    player.off('playBtnClick', onPlayBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('play', play);

/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var pip = function pip() {
  var player = this;
  var util = _player2.default.util;
  var root = player.root;
  function onPipBtnClick() {
    if (util.hasClass(root, 'xgplayer-pip-active')) {
      player.exitPIP();
    } else {
      player.getPIP();
    }
  }
  player.on('pipBtnClick', onPipBtnClick);

  function onDestroy() {
    player.off('pipBtnClick', onPipBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('pip', pip);

/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var pc = function pc() {
  var player = this;
  var util = _player2.default.util;var controls = player.controls;var root = player.root;
  var clk = 0;var _click_ = void 0;

  player.onElementClick = function (e, element) {
    e.preventDefault();
    if (!this.config.closeVideoStopPropagation) {
      e.stopPropagation();
    }
    var player = this;
    if (!player.config.closeVideoClick) {
      clk++;
      if (_click_) {
        clearTimeout(_click_);
      }
      if (clk === 1) {
        _click_ = setTimeout(function () {
          if (util.hasClass(player.root, 'xgplayer-nostart')) {
            return false;
          } else if (!player.ended) {
            if (player.paused) {
              var playPromise = player.play();
              if (playPromise !== undefined && playPromise) {
                playPromise.catch(function (err) {});
              }
            } else {
              player.pause();
            }
          }
          clk = 0;
        }, 200);
      } else {
        clk = 0;
      }
    }
  };
  player.video.addEventListener('click', function (e) {
    player.onElementClick(e, player.video);
  }, false);

  player.onElementDblclick = function (e, element) {
    e.preventDefault();
    e.stopPropagation();
    var player = this;
    if (!player.config.closeVideoDblclick) {
      var fullscreen = controls.querySelector('.xgplayer-fullscreen');
      if (fullscreen) {
        var _clk = void 0;
        if (document.createEvent) {
          _clk = document.createEvent('Event');
          _clk.initEvent('click', true, true);
        } else {
          _clk = new Event('click');
        }
        fullscreen.dispatchEvent(_clk);
      }
    }
  };
  player.video.addEventListener('dblclick', function (e) {
    player.onElementDblclick(e, player.video);
  }, false);

  function onMouseEnter() {
    clearTimeout(player.leavePlayerTimer);
    player.emit('focus', player);
  }
  root.addEventListener('mouseenter', onMouseEnter);

  function onMouseLeave() {
    if (!player.config.closePlayerBlur) {
      player.leavePlayerTimer = setTimeout(function () {
        player.emit('blur', player);
      }, player.config.leavePlayerTime || 0);
    }
  }
  root.addEventListener('mouseleave', onMouseLeave);

  function onControlMouseEnter(e) {
    if (player.userTimer) {
      clearTimeout(player.userTimer);
    }
  }
  controls.addEventListener('mouseenter', onControlMouseEnter, false);

  function onControlMouseLeave(e) {
    if (!player.config.closeControlsBlur) {
      player.emit('focus', player);
    }
  }
  controls.addEventListener('mouseleave', onControlMouseLeave, false);

  function onReady(e) {
    if (player.config.autoplay) {
      player.start();
    }
  }
  player.once('ready', onReady);

  function onDestroy() {
    root.removeEventListener('mouseenter', onMouseEnter);
    root.removeEventListener('mouseleave', onMouseLeave);
    player.off('ready', onReady);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('pc', pc);

/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var mobile = function mobile() {
  var player = this;
  var util = _player2.default.util;var controls = player.controls;var root = player.root;

  player.onElementTouchend = function (e, element) {
    e.preventDefault();
    e.stopPropagation();
    var player = this;
    if (util.hasClass(root, 'xgplayer-inactive')) {
      player.emit('focus');
    } else {
      player.emit('blur');
    }
    if (!player.config.closeVideoTouch && !player.isTouchMove) {
      if (util.hasClass(player.root, 'xgplayer-nostart')) {
        return false;
      } else if (!player.ended) {
        if (player.paused) {
          var playPromise = player.play();
          if (playPromise !== undefined && playPromise) {
            playPromise.catch(function (err) {});
          }
        } else {
          player.pause();
        }
      }
    }
  };

  function onReady(e) {
    player.video.addEventListener('touchend', function (e) {
      player.onElementTouchend(e, player.video);
    });
    player.video.addEventListener('touchstart', function () {
      player.isTouchMove = false;
    });
    player.video.addEventListener('touchmove', function () {
      player.isTouchMove = true;
    });
    if (player.config.autoplay) {
      player.start();
    }
  }
  player.once('ready', onReady);

  function onDestroy() {
    player.off('ready', onReady);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('mobile', mobile);

/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var memoryPlay = function memoryPlay() {
  var player = this;
  player.on('memoryPlayStart', function (lastPlayTime) {
    player.currentTime = lastPlayTime;
  });
};

_player2.default.install('memoryPlay', memoryPlay);

/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _sniffer = __webpack_require__(6);

var _sniffer2 = _interopRequireDefault(_sniffer);

var _collect = __webpack_require__(7);

var _collect2 = _interopRequireDefault(_collect);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var logger = function logger() {
  var player = this;
  var util = _player2.default.util;
  if (player.config.noLog !== true) {
    var endedFunc = function endedFunc() {
      var played = player.video.played;
      var watch_dur = computeWatchDur(player.logParams.played);
      var et = new Date().getTime();
      judgePtVt();
      var obj = {
        url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
        vid: player.config.vid,
        bc: player.logParams.bc - 1 > 0 ? player.logParams.bc - 1 : 0,
        bb: player.logParams.bc - 1 > 0 ? 1 : 0,
        bu_acu_t: player.logParams.bu_acu_t,
        pt: player.logParams.pt,
        vt: player.logParams.vt,
        vd: player.logParams.vd * 1000,
        watch_dur: parseFloat((watch_dur * 1000).toFixed(3)),
        cur_play_pos: parseFloat((player.currentTime * 1000).toFixed(3)),
        et: et
      };
      window.__xigua_log_sdk__('c', obj);
    };

    var urlchangeFunc = function urlchangeFunc() {
      var played = player.video.played;
      var watch_dur = computeWatchDur(player.logParams.played);
      var lt = new Date().getTime();
      judgePtVt();
      var obj = {
        url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
        vid: player.config.vid,
        bc: player.logParams.bc - 1 > 0 ? player.logParams.bc - 1 : 0,
        bb: player.logParams.bc - 1 > 0 ? 1 : 0,
        bu_acu_t: player.logParams.bu_acu_t,
        pt: player.logParams.pt,
        vt: player.logParams.vt,
        vd: player.logParams.vd * 1000,
        watch_dur: parseFloat((watch_dur * 1000).toFixed(3)),
        cur_play_pos: parseFloat((player.currentTime * 1000).toFixed(3)),
        lt: lt
      };
      window.__xigua_log_sdk__('d', obj);
    };

    var errorFunc = function errorFunc(err) {
      var played = player.video.played;
      var watch_dur = computeWatchDur(player.logParams.played);
      judgePtVt();
      var et = new Date().getTime();
      if (player.logParams.lastErrLog && et - player.logParams.lastErrLog <= 1000 * 3) {
        return;
      }
      player.logParams.lastErrLog = et;
      var obj = {
        url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
        vid: player.config.vid,
        bc: player.logParams.bc - 1 > 0 ? player.logParams.bc - 1 : 0,
        bb: player.logParams.bc - 1 > 0 ? 1 : 0,
        bu_acu_t: player.logParams.bu_acu_t,
        pt: player.logParams.pt,
        vt: player.logParams.vt,
        vd: player.logParams.vd * 1000,
        watch_dur: parseFloat((watch_dur * 1000).toFixed(3)),
        err_msg: err.errd.msg,
        line: err.errd.line,
        et: et,
        cur_play_pos: parseFloat((player.currentTime * 1000).toFixed(3))
      };
      if (player.logParams.nologFunc && player.logParams.nologFunc(player)) {
        return true;
      } else {
        window.__xigua_log_sdk__('e', obj);
      }
    };

    var destroyFunc = function destroyFunc() {
      if (_sniffer2.default.device === 'pc') {
        window.removeEventListener('beforeunload', userLeave);
      } else if (_sniffer2.default.device === 'mobile') {
        window.removeEventListener('pagehide', userLeave);
      }
      player.off('routechange', userLeave);
      player.off('ended', endedFunc);
      player.off('urlchange', urlchangeFunc);
      player.off('error', errorFunc);
      player.off('destroy', destroyFunc);
    };

    if (!window.__xigua_log_sdk__) {
      window.__xigua_log_sdk__ = new _collect2.default('tracker');
      window.__xigua_log_sdk__.init({
        app_id: 1300,
        channel: 'cn',
        log: false,
        disable_sdk_monitor: true
      });

      window.__xigua_log_sdk__('config', {
        evtParams: {
          log_type: 'logger',
          page_url: document.URL,
          domain: window.location.host,
          pver: player.version,
          ua: navigator.userAgent.toLowerCase()
        },
        disable_auto_pv: true
      });
      window.__xigua_log_sdk__.start();
    }

    if (player.config.uid) {
      window.__xigua_log_sdk__('config', {
        user_unique_id: player.config.uid
      });
    }

    var computeWatchDur = function computeWatchDur() {
      var played = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

      var minBegin = 0;
      var end = 0;
      var arr = [];
      for (var i = 0; i < played.length; i++) {
        if (!played[i].end || played[i].begin < 0 || played[i].end < 0 || played[i].end < played[i].begin) {
          continue;
        }
        if (arr.length < 1) {
          arr.push({ begin: played[i].begin, end: played[i].end });
        } else {
          for (var j = 0; j < arr.length; j++) {
            var begin = played[i].begin;
            var _end = played[i].end;
            if (_end < arr[j].begin) {
              arr.splice(j, 0, { begin: begin, end: _end });
              break;
            } else if (begin > arr[j].end) {
              if (j > arr.length - 2) {
                arr.push({ begin: begin, end: _end });
                break;
              }
            } else {
              var b = arr[j].begin;
              var e = arr[j].end;
              arr[j].begin = Math.min(begin, b);
              arr[j].end = Math.max(_end, e);
              break;
            }
          }
        }
      }
      var watch_dur = 0;
      for (var _i = 0; _i < arr.length; _i++) {
        watch_dur += arr[_i].end - arr[_i].begin;
      }
      return watch_dur;
    };

    var judgePtVt = function judgePtVt() {
      if (!player.logParams.pt || !player.logParams.vt) {
        player.logParams.pt = new Date().getTime();
        player.logParams.vt = player.logParams.pt;
      }
      if (player.logParams.pt > player.logParams.vt) {
        player.logParams.pt = player.logParams.vt;
      }
    };

    var userLeave = function userLeave(event) {
      if (util.hasClass(player.root, 'xgplayer-is-enter')) {
        var lt = new Date().getTime();
        var obj = {
          url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
          vid: player.config.vid,
          pt: player.logParams.pt,
          lt: lt
        };
        window.__xigua_log_sdk__('b', obj);
      } else if (util.hasClass(player.root, 'xgplayer-playing')) {
        var watch_dur = computeWatchDur(player.logParams.played);
        var _lt = new Date().getTime();
        judgePtVt();
        var _obj = {
          url: player.logParams.pluginSrc ? player.logParams.pluginSrc : player.logParams.playSrc,
          vid: player.config.vid,
          bc: player.logParams.bc - 1 > 0 ? player.logParams.bc - 1 : 0,
          bb: player.logParams.bc - 1 > 0 ? 1 : 0,
          bu_acu_t: player.logParams.bu_acu_t,
          pt: player.logParams.pt,
          vt: player.logParams.vt,
          vd: player.logParams.vd * 1000,
          watch_dur: parseFloat((watch_dur * 1000).toFixed(3)),
          cur_play_pos: parseFloat((player.currentTime * 1000).toFixed(3)),
          lt: _lt
        };
        window.__xigua_log_sdk__('d', _obj);
      }
    };
    if (_sniffer2.default.device === 'pc') {
      window.addEventListener('beforeunload', userLeave, false);
    } else if (_sniffer2.default.device === 'mobile') {
      window.addEventListener('pagehide', userLeave, false);
    }
    player.on('routechange', userLeave);

    player.on('ended', endedFunc);

    player.on('urlchange', urlchangeFunc);

    player.on('error', errorFunc);

    player.once('destroy', destroyFunc);
  }
}; /* eslint-disable */


_player2.default.install('logger', logger);

/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var localPreview = function localPreview() {
  var player = this;
  var root = player.root;
  function onUpload(upload) {
    player.uploadFile = upload.files[0];
    var url = URL.createObjectURL(player.uploadFile);
    if (_player2.default.util.hasClass(root, 'xgplayer-nostart')) {
      player.config.url = url;
      player.start();
    } else {
      player.src = url;
      var playPromise = player.play();
      if (playPromise !== undefined && playPromise) {
        playPromise.catch(function (err) {});
      }
    }
  }
  player.on('upload', onUpload);

  function onDestroy() {
    player.off('upload', onUpload);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('localPreview', localPreview);

/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var i18n = function i18n() {
  var player = this;var lang = {};var util = player.constructor.util;
  lang.en = {
    HAVE_NOTHING: 'There is no information on whether audio/video is ready',
    HAVE_METADATA: 'Audio/video metadata is ready ',
    HAVE_CURRENT_DATA: 'Data about the current play location is available, but there is not enough data to play the next frame/millisecond',
    HAVE_FUTURE_DATA: 'Current and at least one frame of data is available',
    HAVE_ENOUGH_DATA: 'The available data is sufficient to start playing',
    NETWORK_EMPTY: 'Audio/video has not been initialized',
    NETWORK_IDLE: 'Audio/video is active and has been selected for resources, but no network is used',
    NETWORK_LOADING: 'The browser is downloading the data',
    NETWORK_NO_SOURCE: 'No audio/video source was found',
    MEDIA_ERR_ABORTED: 'The fetch process is aborted by the user',
    MEDIA_ERR_NETWORK: 'An error occurred while downloading',
    MEDIA_ERR_DECODE: 'An error occurred while decoding',
    MEDIA_ERR_SRC_NOT_SUPPORTED: 'Audio/video is not supported',
    REPLAY: 'Replay',
    ERROR: 'Network is offline',
    PLAY_TIPS: 'Play',
    PAUSE_TIPS: 'Pause',
    PLAYNEXT_TIPS: 'Play next',
    DOWNLOAD_TIPS: 'Download',
    ROTATE_TIPS: 'Rotate',
    RELOAD_TIPS: 'Reload',
    FULLSCREEN_TIPS: "Fullscreen",
    EXITFULLSCREEN_TIPS: 'Exit fullscreen',
    CSSFULLSCREEN_TIPS: 'Cssfullscreen',
    EXITCSSFULLSCREEN_TIPS: 'Exit cssfullscreen',
    TEXTTRACK: 'Caption',
    PIP: 'Pip',
    SCREENSHOT: 'Screenshot',
    LIVE: 'LIVE'
  };
  lang['zh-cn'] = {
    HAVE_NOTHING: '没有关于音频/视频是否就绪的信息',
    HAVE_METADATA: '音频/视频的元数据已就绪',
    HAVE_CURRENT_DATA: '关于当前播放位置的数据是可用的，但没有足够的数据来播放下一帧/毫秒',
    HAVE_FUTURE_DATA: '当前及至少下一帧的数据是可用的',
    HAVE_ENOUGH_DATA: '可用数据足以开始播放',
    NETWORK_EMPTY: '音频/视频尚未初始化',
    NETWORK_IDLE: '音频/视频是活动的且已选取资源，但并未使用网络',
    NETWORK_LOADING: '浏览器正在下载数据',
    NETWORK_NO_SOURCE: '未找到音频/视频来源',
    MEDIA_ERR_ABORTED: '取回过程被用户中止',
    MEDIA_ERR_NETWORK: '当下载时发生错误',
    MEDIA_ERR_DECODE: '当解码时发生错误',
    MEDIA_ERR_SRC_NOT_SUPPORTED: '不支持的音频/视频格式',
    REPLAY: '重播',
    ERROR: '网络连接似乎出现了问题',
    PLAY_TIPS: '播放',
    PAUSE_TIPS: '暂停',
    PLAYNEXT_TIPS: '下一集',
    DOWNLOAD_TIPS: '下载',
    ROTATE_TIPS: '旋转',
    RELOAD_TIPS: '重新载入',
    FULLSCREEN_TIPS: "进入全屏",
    EXITFULLSCREEN_TIPS: '退出全屏',
    CSSFULLSCREEN_TIPS: '进入样式全屏',
    EXITCSSFULLSCREEN_TIPS: '退出样式全屏',
    TEXTTRACK: '字幕',
    PIP: '画中画',
    SCREENSHOT: '截图',
    LIVE: '正在直播'
  };
  lang['jp'] = {
    HAVE_NOTHING: 'オーディオ/ビデオが準備できているか情報がありません',
    HAVE_METADATA: 'オーディオ/ビデオのメタデータは準備できています',
    HAVE_CURRENT_DATA: '現在の再生位置に関するデータは利用可能ですが、次のフレーム/ミリ秒を再生するのに十分なデータがありません',
    HAVE_FUTURE_DATA: '現在、少なくとも次のフレームのデータが利用可能です',
    HAVE_ENOUGH_DATA: '利用可能なデータは再生を開始するのに十分です',
    NETWORK_EMPTY: 'オーディオ/ビデオが初期化されていません',
    NETWORK_IDLE: 'オーディオ/ビデオはアクティブでリソースが選択されていますが、ネットワークが使用されていません',
    NETWORK_LOADING: 'ブラウザーはデータをダウンロードしています',
    NETWORK_NO_SOURCE: 'オーディオ/ビデオ のソースが見つかりません',
    MEDIA_ERR_ABORTED: 'ユーザーによってフェッチプロセスが中止されました',
    MEDIA_ERR_NETWORK: 'ダウンロード中にエラーが発生しました',
    MEDIA_ERR_DECODE: 'デコード中にエラーが発生しました',
    MEDIA_ERR_SRC_NOT_SUPPORTED: 'オーディオ/ビデオ の形式がサポートされていません',
    REPLAY: 'リプレイ',
    ERROR: 'ネットワークの接続に問題が発生しました',
    PLAY_TIPS: 'プレイ',
    PAUSE_TIPS: '一時停止',
    PLAYNEXT_TIPS: '次をプレイ',
    DOWNLOAD_TIPS: 'ダウンロード',
    ROTATE_TIPS: '回転',
    RELOAD_TIPS: '再読み込み',
    FULLSCREEN_TIPS: "フルスクリーン",
    EXITFULLSCREEN_TIPS: 'フルスクリーンを終了',
    CSSFULLSCREEN_TIPS: 'シアターモード',
    EXITCSSFULLSCREEN_TIPS: 'シアターモードを終了',
    TEXTTRACK: '字幕',
    PIP: 'ミニプレーヤー',
    SCREENSHOT: 'スクリーンショット',
    LIVE: '生放送'
  };

  Object.defineProperty(player, 'lang', {
    get: function get() {
      if (player.config) {
        return lang[player.config.lang] || lang['en'];
      } else {
        return lang['en'];
      }
    },
    set: function set(value) {
      if (util.typeOf(value) === 'Object') {
        Object.keys(value).forEach(function (key) {
          lang[key] = value[key];
        });
      }
    }
  });
};

_player2.default.install('i18n', i18n);

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var fullscreen = function fullscreen() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  function onFullscreenBtnClick() {
    if (player.config.rotateFullscreen) {
      if (util.hasClass(root, 'xgplayer-rotate-fullscreen')) {
        player.exitRotateFullscreen();
      } else {
        player.getRotateFullscreen();
      }
    } else {
      if (util.hasClass(root, 'xgplayer-is-fullscreen')) {
        player.exitFullscreen(root);
      } else {
        player.getFullscreen(root);
      }
    }
  }
  player.on('fullscreenBtnClick', onFullscreenBtnClick);

  function onFullscreenChange() {
    var fullscreenEl = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
    if (fullscreenEl && fullscreenEl === root) {
      util.addClass(root, 'xgplayer-is-fullscreen');
      player.emit('requestFullscreen');
    } else {
      util.removeClass(root, 'xgplayer-is-fullscreen');
      player.emit('exitFullscreen');
    }
  };
  ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(function (item) {
    document.addEventListener(item, onFullscreenChange);
  });

  function onDestroy() {
    player.off('fullscreenBtnClick', onFullscreenBtnClick);
    ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(function (item) {
      document.removeEventListener(item, onFullscreenChange);
    });
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('fullscreen', fullscreen);

/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Error retry plugin
 * get config from player.config.errorConfig
 * The Plugin is just deal with the situation that play with video.src,
 * and get the http status of current video.src
 */

var defaultConfig = {
  maxCount: 3, // max number of retries
  backupUrl: '', // the backup url for retry
  isFetch: true, //  is need to check the cdn url statud
  fetchTimeout: 100 // timeout time for get cdn status
};

function errorRetry() {
  var _this = this;

  var player = this;
  // 无设置参数或者是通过扩展播放的不做处理
  if (!player.config.errorConfig || player.src.indexOf('blob:') > -1) {
    return;
  }
  var errorConfig = {};
  var _inConfig = player.config.errorConfig;
  for (var key in defaultConfig) {
    if (_inConfig[key] === undefined) {
      errorConfig[key] = defaultConfig[key];
    } else {
      errorConfig[key] = _inConfig[key];
    }
  }
  player.retryData = {
    count: 0, // 重试次数
    errfTimer: null, // 超时设置定时器
    isFetchReturn: false, // fetch请求是否已经返回
    currentTime: 0 // 出错的时候时间
  };

  function errorfetch(player, url, timeout) {
    var resolveFun = function resolveFun(resolve, data) {
      if (!player.retryData.isFetchReturn) {
        player.retryData.isFetchReturn = true;
        resolve(data);
      }
    };
    return new Promise(function (resolve, reject) {
      try {
        var xhr = new window.XMLHttpRequest();
        xhr.open('get', url);
        xhr.onload = function () {
          resolveFun(resolve, { status: xhr.status, statusText: xhr.statusText, xhr: xhr });
        };
        xhr.onerror = function () {
          resolveFun(resolve, { status: xhr.status, statusText: xhr.statusText || 'The network environment is disconnected or the address is invalid', xhr: xhr });
        };
        xhr.onabort = function () {
          // console.log('task onerror', xhr)
        };
        player.retryData.errfTimer = window.setTimeout(function () {
          var errfTimer = player.retryData.errfTimer;
          window.clearTimeout(errfTimer);
          player.retryData.errfTimer = null;
          resolveFun(resolve, { status: -1, statusText: 'request timeout' });
        }, timeout);
        xhr.send();
      } catch (err) {
        player.retryData.isFetchReturn = true;
        resolveFun(resolve, { status: -2, statusText: 'request error' });
      }
    });
  }

  function retryCanPlay() {
    // console.log(`retryCanPlay this.retryData.currentTime:${this.retryData.currentTime}`)
    this.currentTime = this.retryData.currentTime;
    this.play();
    this.retryData.retryCode = 0;
    this.retryData.isFetchReturn = false;
    this.retryData.currentTime = 0;
  }

  var _originErrorEmit = player._onError;
  player._onError = function (data) {
    var errorCount = _this.retryData.count;
    // console.log(`originErrorEmit:errorCount:${errorCount}`, data)
    if (errorCount > errorConfig.maxCount) {
      if (errorConfig.isFetch) {
        errorfetch(_this, _this.currentSrc, errorConfig.fetchTimeout).then(function (data) {
          _this.emit('error', new _player2.default.Errors({
            type: 'network',
            currentTime: _this.currentTime,
            duration: _this.duration || 0,
            networkState: _this.networkState,
            readyState: _this.readyState,
            currentSrc: _this.currentSrc,
            src: _this.src,
            ended: _this.ended,
            httpCode: data.status,
            httpMsg: data.statusText,
            errd: {
              line: 101,
              msg: _this.error,
              handle: 'plugin errorRetry'
            },
            errorCode: _this.video && _this.video.error.code,
            mediaError: _this.video && _this.video.error
          }));
          _originErrorEmit.call(_this, data);
        });
      } else {
        _originErrorEmit.call(_this, data);
      }
      return;
    }
    if (errorCount === 0) {
      _this.retryData.currentTime = _this.currentTime;
      _this.once('canplay', retryCanPlay.bind(_this));
    }
    var src = '';
    if (errorConfig.count < 2) {
      src = errorConfig.backupUrl ? errorConfig.backupUrl : player.currentSrc;
    } else {
      src = errorConfig.backupUrl && errorCount > 1 ? errorConfig.backupUrl : player.currentSrc;
    }
    _this.retryData.count++;
    _this.src = src;
  };
}

_player2.default.install('errorretry', errorRetry);

/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var download = function download() {
  var player = this;

  function onDownloadBtnClick() {
    // must pass an absolute url for download
    player.download();
  }
  player.on('downloadBtnClick', onDownloadBtnClick);

  function onDestroy() {
    player.off('downloadBtnClick', onDownloadBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('download', download);

/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var definition = function definition() {
  var player = this;
  var root = player.root;

  function onDestroy() {
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('definition', definition);

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var danmu = function danmu() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  function onInitDanmu(danmujs) {
    var container = player.root.querySelector('xg-danmu');
    util.addClass(container, 'xgplayer-has-danmu');
    if (!player.config.danmu.closeDefaultBtn) {
      var onTimeupdate = function onTimeupdate() {
        danmujs.start();
      };

      var onPause = function onPause() {
        if (util.hasClass(player.danmuBtn, 'danmu-switch-active')) {
          danmujs.pause();
        }
      };

      var onPlay = function onPlay() {
        if (util.hasClass(player.danmuBtn, 'danmu-switch-active')) {
          danmujs.play();
        }
      };

      var onSeeked = function onSeeked() {
        if (util.hasClass(player.danmuBtn, 'danmu-switch-active')) {
          danmujs.stop();
          danmujs.start();
        }
      };

      var onDestroy = function onDestroy() {
        player.off('timeupdate', onTimeupdate);
        player.off('pause', onPause);
        player.off('play', onPlay);
        player.off('seeked', onSeeked);
        player.off('destroy', onDestroy);
      };

      player.danmuBtn = util.copyDom(danmujs.bulletBtn.createSwitch(true));
      player.controls.appendChild(player.danmuBtn);

      ['click', 'touchend'].forEach(function (item) {
        player.danmuBtn.addEventListener(item, function (e) {
          e.preventDefault();
          e.stopPropagation();
          util.toggleClass(player.danmuBtn, 'danmu-switch-active');
          if (util.hasClass(player.danmuBtn, 'danmu-switch-active')) {
            player.emit('danmuBtnOn');
            util.addClass(container, 'xgplayer-has-danmu');
            player.once('timeupdate', onTimeupdate);
          } else {
            player.emit('danmuBtnOff');
            util.removeClass(container, 'xgplayer-has-danmu');
            danmujs.stop();
          }
        });
      });

      player.onElementClick && container.addEventListener('click', function (e) {
        player.onElementClick(e, container);
      }, false);
      player.onElementDblclick && container.addEventListener('dblclick', function (e) {
        player.onElementDblclick(e, container);
      }, false);

      player.on('pause', onPause);

      player.on('play', onPlay);

      player.on('seeked', onSeeked);

      player.once('destroy', onDestroy);
    }
  }
  player.on('initDefaultDanmu', onInitDanmu);
};

_player2.default.install('danmu', danmu);

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var cssFullscreen = function cssFullscreen() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  function onCssFullscreenBtnClick() {
    if (util.hasClass(root, 'xgplayer-is-cssfullscreen')) {
      player.exitCssFullscreen();
    } else {
      player.getCssFullscreen();
    }
  }
  player.on('cssFullscreenBtnClick', onCssFullscreenBtnClick);
  player.on('exitFullscreen', function () {
    util.removeClass(root, 'xgplayer-is-cssfullscreen');
  });

  function onDestroy() {
    player.off('cssFullscreenBtnClick', onCssFullscreenBtnClick);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('cssFullscreen', cssFullscreen);

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(60);

__webpack_require__(65);

__webpack_require__(66);

__webpack_require__(69);

__webpack_require__(72);

__webpack_require__(73);

__webpack_require__(74);

__webpack_require__(77);

__webpack_require__(80);

__webpack_require__(84);

__webpack_require__(85);

__webpack_require__(87);

__webpack_require__(88);

__webpack_require__(89);

__webpack_require__(91);

__webpack_require__(92);

__webpack_require__(93);

__webpack_require__(95);

__webpack_require__(99);

__webpack_require__(100);

__webpack_require__(102);

__webpack_require__(104);

__webpack_require__(106);

__webpack_require__(107);

__webpack_require__(108);

__webpack_require__(109);

/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(61);

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(63)(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(62)(false);
// imports


// module
exports.push([module.i, ".xgplayer-skin-default{background:#000;width:100%;height:100%;position:relative;-webkit-user-select:none;-moz-user-select:none;user-select:none;-ms-user-select:none}.xgplayer-skin-default *{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}.xgplayer-skin-default.xgplayer-rotate-fullscreen{position:absolute;top:0;left:100%;bottom:0;right:0;height:100vw!important;width:100vh!important;-webkit-transform-origin:top left;-ms-transform-origin:top left;transform-origin:top left;-webkit-transform:rotate(90deg);-ms-transform:rotate(90deg);transform:rotate(90deg)}.xgplayer-skin-default.xgplayer-is-fullscreen{width:100%!important;height:100%!important;padding-top:0!important;z-index:9999}.xgplayer-skin-default.xgplayer-is-fullscreen.xgplayer-inactive{cursor:none}.xgplayer-skin-default video{width:100%;height:100%;outline:none}.xgplayer-skin-default .xgplayer-none{display:none}@-webkit-keyframes loadingRotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes loadingRotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@-webkit-keyframes loadingDashOffset{0%{stroke-dashoffset:236}to{stroke-dashoffset:0}}@keyframes loadingDashOffset{0%{stroke-dashoffset:236}to{stroke-dashoffset:0}}.xgplayer-skin-default .xgplayer-play,.xgplayer-skin-default .xgplayer-play-img{width:45px;position:relative;-webkit-order:0;-moz-box-ordinal-group:1;order:0;display:block;cursor:pointer;margin-left:3px;margin-right:8px}.xgplayer-skin-default .xgplayer-play-img .xgplayer-icon,.xgplayer-skin-default .xgplayer-play .xgplayer-icon{margin-top:3px;width:32px}.xgplayer-skin-default .xgplayer-play-img .xgplayer-icon div,.xgplayer-skin-default .xgplayer-play .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-play-img .xgplayer-icon .xgplayer-icon-play,.xgplayer-skin-default .xgplayer-play .xgplayer-icon .xgplayer-icon-play{display:block}.xgplayer-skin-default .xgplayer-play-img .xgplayer-icon .xgplayer-icon-pause,.xgplayer-skin-default .xgplayer-play .xgplayer-icon .xgplayer-icon-pause{display:none}.xgplayer-skin-default .xgplayer-play-img .xgplayer-tips .xgplayer-tip-play,.xgplayer-skin-default .xgplayer-play .xgplayer-tips .xgplayer-tip-play{display:block}.xgplayer-skin-default .xgplayer-play-img .xgplayer-tips .xgplayer-tip-pause,.xgplayer-skin-default .xgplayer-play .xgplayer-tips .xgplayer-tip-pause{display:none}.xgplayer-skin-default .xgplayer-play-img:hover,.xgplayer-skin-default .xgplayer-play:hover{opacity:.85}.xgplayer-skin-default .xgplayer-play-img:hover .xgplayer-tips,.xgplayer-skin-default .xgplayer-play:hover .xgplayer-tips{display:block}.xgplayer-skin-default.xgplayer-playing .xgplayer-play-img .xgplayer-icon .xgplayer-icon-play,.xgplayer-skin-default.xgplayer-playing .xgplayer-play .xgplayer-icon .xgplayer-icon-play{display:none}.xgplayer-skin-default.xgplayer-playing .xgplayer-play-img .xgplayer-icon .xgplayer-icon-pause,.xgplayer-skin-default.xgplayer-playing .xgplayer-play .xgplayer-icon .xgplayer-icon-pause{display:block}.xgplayer-skin-default.xgplayer-playing .xgplayer-play-img .xgplayer-tips .xgplayer-tip-play,.xgplayer-skin-default.xgplayer-playing .xgplayer-play .xgplayer-tips .xgplayer-tip-play{display:none}.xgplayer-skin-default.xgplayer-pause .xgplayer-play-img .xgplayer-icon .xgplayer-icon-play,.xgplayer-skin-default.xgplayer-pause .xgplayer-play .xgplayer-icon .xgplayer-icon-play,.xgplayer-skin-default.xgplayer-playing .xgplayer-play-img .xgplayer-tips .xgplayer-tip-pause,.xgplayer-skin-default.xgplayer-playing .xgplayer-play .xgplayer-tips .xgplayer-tip-pause{display:block}.xgplayer-skin-default.xgplayer-pause .xgplayer-play-img .xgplayer-icon .xgplayer-icon-pause,.xgplayer-skin-default.xgplayer-pause .xgplayer-play .xgplayer-icon .xgplayer-icon-pause{display:none}.xgplayer-skin-default.xgplayer-pause .xgplayer-play-img .xgplayer-tips .xgplayer-tip-play,.xgplayer-skin-default.xgplayer-pause .xgplayer-play .xgplayer-tips .xgplayer-tip-play{display:block}.xgplayer-skin-default.xgplayer-pause .xgplayer-play-img .xgplayer-tips .xgplayer-tip-pause,.xgplayer-skin-default.xgplayer-pause .xgplayer-play .xgplayer-tips .xgplayer-tip-pause{display:none}.xgplayer-skin-default .xgplayer-start{border-radius:50%;display:inline-block;width:70px;height:70px;background:rgba(0,0,0,.38);overflow:hidden;text-align:center;line-height:70px;vertical-align:middle;position:absolute;left:50%;top:50%;z-index:115;margin:-35px auto auto -35px;cursor:pointer}.xgplayer-skin-default .xgplayer-start div{position:absolute}.xgplayer-skin-default .xgplayer-start div svg{fill:hsla(0,0%,100%,.7);margin:14px}.xgplayer-skin-default .xgplayer-start .xgplayer-icon-play{display:block}.xgplayer-skin-default .xgplayer-start .xgplayer-icon-pause{display:none}.xgplayer-skin-default .xgplayer-start:hover{opacity:.85}.xgplayer-skin-default.xgplayer-playing .xgplayer-start,.xgplayer-skin-default.xgplayer-playing .xgplayer-start .xgplayer-icon-play{display:none}.xgplayer-skin-default.xgplayer-playing .xgplayer-start .xgplayer-icon-pause{display:block}.xgplayer-skin-default.xgplayer-pause .xgplayer-start{display:inline-block}.xgplayer-skin-default.xgplayer-pause .xgplayer-start .xgplayer-icon-play{display:block}.xgplayer-skin-default.replay .xgplayer-start,.xgplayer-skin-default.xgplayer-pause .xgplayer-start .xgplayer-icon-pause{display:none}.xgplayer-skin-default.replay .xgplayer-start .xgplayer-icon-play{display:block}.xgplayer-skin-default.replay .xgplayer-start .xgplayer-icon-pause{display:none}.xgplayer-skin-default .xgplayer-enter{display:none;position:absolute;left:0;top:0;width:100%;height:100%;background:#000;z-index:120}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner{display:block;position:absolute;left:50%;top:50%;height:100px;width:100px;position:relative;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div{width:12%;height:26%;background-color:hsla(0,0%,100%,.7);position:absolute;left:44%;top:37%;opacity:0;border-radius:30px;-webkit-animation:fade 1s linear infinite;animation:fade 1s linear infinite}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar1{-webkit-transform:rotate(0deg) translateY(-142%);-ms-transform:rotate(0deg) translateY(-142%);transform:rotate(0deg) translateY(-142%);-webkit-animation-delay:0s;animation-delay:0s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar2{-webkit-transform:rotate(30deg) translateY(-142%);-ms-transform:rotate(30deg) translateY(-142%);transform:rotate(30deg) translateY(-142%);-webkit-animation-delay:-.9163s;animation-delay:-.9163s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar3{-webkit-transform:rotate(60deg) translateY(-142%);-ms-transform:rotate(60deg) translateY(-142%);transform:rotate(60deg) translateY(-142%);-webkit-animation-delay:-.833s;animation-delay:-.833s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar4{-webkit-transform:rotate(90deg) translateY(-142%);-ms-transform:rotate(90deg) translateY(-142%);transform:rotate(90deg) translateY(-142%);-webkit-animation-delay:-.7497s;animation-delay:-.7497s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar5{-webkit-transform:rotate(120deg) translateY(-142%);-ms-transform:rotate(120deg) translateY(-142%);transform:rotate(120deg) translateY(-142%);-webkit-animation-delay:-.6664s;animation-delay:-.6664s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar6{-webkit-transform:rotate(150deg) translateY(-142%);-ms-transform:rotate(150deg) translateY(-142%);transform:rotate(150deg) translateY(-142%);-webkit-animation-delay:-.5831s;animation-delay:-.5831s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar7{-webkit-transform:rotate(180deg) translateY(-142%);-ms-transform:rotate(180deg) translateY(-142%);transform:rotate(180deg) translateY(-142%);-webkit-animation-delay:-.4998s;animation-delay:-.4998s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar8{-webkit-transform:rotate(210deg) translateY(-142%);-ms-transform:rotate(210deg) translateY(-142%);transform:rotate(210deg) translateY(-142%);-webkit-animation-delay:-.4165s;animation-delay:-.4165s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar9{-webkit-transform:rotate(240deg) translateY(-142%);-ms-transform:rotate(240deg) translateY(-142%);transform:rotate(240deg) translateY(-142%);-webkit-animation-delay:-.3332s;animation-delay:-.3332s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar10{-webkit-transform:rotate(270deg) translateY(-142%);-ms-transform:rotate(270deg) translateY(-142%);transform:rotate(270deg) translateY(-142%);-webkit-animation-delay:-.2499s;animation-delay:-.2499s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar11{-webkit-transform:rotate(300deg) translateY(-142%);-ms-transform:rotate(300deg) translateY(-142%);transform:rotate(300deg) translateY(-142%);-webkit-animation-delay:-.1666s;animation-delay:-.1666s}.xgplayer-skin-default .xgplayer-enter .xgplayer-enter-spinner div.xgplayer-enter-bar12{-webkit-transform:rotate(330deg) translateY(-142%);-ms-transform:rotate(330deg) translateY(-142%);transform:rotate(330deg) translateY(-142%);-webkit-animation-delay:-.0833s;animation-delay:-.0833s}@-webkit-keyframes fade{0%{opacity:1}to{opacity:.25}}.xgplayer-skin-default.xgplayer-is-enter .xgplayer-enter{display:block}.xgplayer-skin-default .xgplayer-poster{display:none;position:absolute;left:0;top:0;width:100%;height:100%;z-index:100;background-size:cover;background-position:50%}.xgplayer-skin-default.xgplayer-nostart .xgplayer-poster{display:block}.xgplayer-skin-default .xgplayer-placeholder{-webkit-flex:1;-moz-box-flex:1;flex:1;-webkit-order:3;-moz-box-ordinal-group:4;order:3;display:block}.xgplayer-skin-default .xgplayer-fullscreen,.xgplayer-skin-default .xgplayer-fullscreen-img{position:relative;-webkit-order:13;-moz-box-ordinal-group:14;order:13;display:block;cursor:pointer;margin-left:5px;margin-right:3px}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-icon,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-icon{margin-top:3px}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-icon div,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-icon .xgplayer-icon-requestfull,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-icon .xgplayer-icon-requestfull{display:block}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-icon .xgplayer-icon-exitfull,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-icon .xgplayer-icon-exitfull{display:none}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-tips,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-tips{position:absolute;right:0;left:auto}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-tips .xgplayer-tip-requestfull,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-tips .xgplayer-tip-requestfull{display:block}.xgplayer-skin-default .xgplayer-fullscreen-img .xgplayer-tips .xgplayer-tip-exitfull,.xgplayer-skin-default .xgplayer-fullscreen .xgplayer-tips .xgplayer-tip-exitfull{display:none}.xgplayer-skin-default .xgplayer-fullscreen-img:hover,.xgplayer-skin-default .xgplayer-fullscreen:hover{opacity:.85}.xgplayer-skin-default .xgplayer-fullscreen-img:hover .xgplayer-tips,.xgplayer-skin-default .xgplayer-fullscreen:hover .xgplayer-tips{display:block}.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen-img .xgplayer-icon .xgplayer-icon-requestfull,.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen .xgplayer-icon .xgplayer-icon-requestfull{display:none}.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen-img .xgplayer-icon .xgplayer-icon-exitfull,.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen .xgplayer-icon .xgplayer-icon-exitfull{display:block}.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen-img .xgplayer-tips .xgplayer-tip-requestfull,.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen .xgplayer-tips .xgplayer-tip-requestfull{display:none}.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen-img .xgplayer-tips .xgplayer-tip-exitfull,.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-fullscreen .xgplayer-tips .xgplayer-tip-exitfull{display:block}.xgplayer-skin-default .xgplayer-cssfullscreen,.xgplayer-skin-default .xgplayer-cssfullscreen-img{position:relative;-webkit-order:12;-moz-box-ordinal-group:13;order:12;display:block;cursor:pointer}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-icon,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-icon{width:32px;margin-top:5px}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-icon div,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-icon .xgplayer-icon-requestfull,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-icon .xgplayer-icon-requestfull{display:block}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-icon .xgplayer-icon-exitfull,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-icon .xgplayer-icon-exitfull{display:none}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-tips,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-tips{margin-left:-40px}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-tips .xgplayer-tip-requestfull,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-tips .xgplayer-tip-requestfull{display:block}.xgplayer-skin-default .xgplayer-cssfullscreen-img .xgplayer-tips .xgplayer-tip-exitfull,.xgplayer-skin-default .xgplayer-cssfullscreen .xgplayer-tips .xgplayer-tip-exitfull{display:none}.xgplayer-skin-default .xgplayer-cssfullscreen-img:hover,.xgplayer-skin-default .xgplayer-cssfullscreen:hover{opacity:.85}.xgplayer-skin-default .xgplayer-cssfullscreen-img:hover .xgplayer-tips,.xgplayer-skin-default .xgplayer-cssfullscreen:hover .xgplayer-tips{display:block}.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-icon .xgplayer-icon-requestfull,.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-icon .xgplayer-icon-requestfull{display:none}.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-icon .xgplayer-icon-exitfull,.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-icon .xgplayer-icon-exitfull{display:block}.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-tips,.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-tips{margin-left:-47px}.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-tips .xgplayer-tip-requestfull,.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-tips .xgplayer-tip-requestfull{display:none}.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-tips .xgplayer-tip-exitfull,.xgplayer-skin-default.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-tips .xgplayer-tip-exitfull{display:block}.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-cssfullscreen,.xgplayer-skin-default.xgplayer-is-fullscreen .xgplayer-cssfullscreen-img{display:none}.xgplayer-skin-default.xgplayer-is-cssfullscreen{position:fixed!important;left:0!important;top:0!important;width:100%!important;height:100%!important;z-index:99999!important}.lang-is-en .xgplayer-cssfullscreen-img .xgplayer-tips,.lang-is-en .xgplayer-cssfullscreen .xgplayer-tips,.lang-is-en.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-tips,.lang-is-en.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-tips{margin-left:-46px}.lang-is-jp .xgplayer-cssfullscreen-img .xgplayer-tips,.lang-is-jp .xgplayer-cssfullscreen .xgplayer-tips{margin-left:-120px}.lang-is-jp.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen-img .xgplayer-tips,.lang-is-jp.xgplayer-is-cssfullscreen .xgplayer-cssfullscreen .xgplayer-tips{margin-left:-60px}.xgplayer-skin-default .xgplayer-volume{outline:none;-webkit-order:4;-moz-box-ordinal-group:5;order:4;width:40px;height:40px;display:block;position:relative;z-index:18}.xgplayer-skin-default .xgplayer-volume .xgplayer-icon{margin-top:8px;cursor:pointer;position:absolute;bottom:-9px}.xgplayer-skin-default .xgplayer-volume .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-volume .xgplayer-icon .xgplayer-icon-large{display:block}.xgplayer-skin-default .xgplayer-volume .xgplayer-icon .xgplayer-icon-muted,.xgplayer-skin-default .xgplayer-volume .xgplayer-icon .xgplayer-icon-small{display:none}.xgplayer-skin-default .xgplayer-slider{display:none;position:absolute;width:28px;height:92px;background:rgba(0,0,0,.54);border-radius:1px;bottom:42px;outline:none}.xgplayer-skin-default .xgplayer-slider:after{content:\" \";display:block;height:15px;width:28px;position:absolute;bottom:-15px;left:0;z-index:20}.xgplayer-skin-default .xgplayer-bar,.xgplayer-skin-default .xgplayer-drag{display:block;position:absolute;bottom:6px;left:12px;background:hsla(0,0%,100%,.3);border-radius:100px;width:4px;height:76px;outline:none;cursor:pointer}.xgplayer-skin-default .xgplayer-drag{bottom:0;left:0;background:#fa1f41;max-height:76px}.xgplayer-skin-default .xgplayer-drag:after{content:\" \";display:inline-block;width:8px;height:8px;background:#fff;box-shadow:0 0 5px 0 rgba(0,0,0,.26);position:absolute;border-radius:50%;left:-2px;top:-6px}.xgplayer-skin-default.xgplayer-volume-active .xgplayer-slider,.xgplayer-skin-default.xgplayer-volume-large .xgplayer-volume .xgplayer-icon .xgplayer-icon-large{display:block}.xgplayer-skin-default.xgplayer-volume-large .xgplayer-volume .xgplayer-icon .xgplayer-icon-muted,.xgplayer-skin-default.xgplayer-volume-large .xgplayer-volume .xgplayer-icon .xgplayer-icon-small,.xgplayer-skin-default.xgplayer-volume-small .xgplayer-volume .xgplayer-icon .xgplayer-icon-large{display:none}.xgplayer-skin-default.xgplayer-volume-small .xgplayer-volume .xgplayer-icon .xgplayer-icon-small{display:block}.xgplayer-skin-default.xgplayer-volume-muted .xgplayer-volume .xgplayer-icon .xgplayer-icon-large,.xgplayer-skin-default.xgplayer-volume-muted .xgplayer-volume .xgplayer-icon .xgplayer-icon-small,.xgplayer-skin-default.xgplayer-volume-small .xgplayer-volume .xgplayer-icon .xgplayer-icon-muted{display:none}.xgplayer-skin-default.xgplayer-volume-muted .xgplayer-volume .xgplayer-icon .xgplayer-icon-muted{display:block}.xgplayer-skin-default.xgplayer-mobile .xgplayer-volume .xgplayer-slider{display:none}.xgplayer-skin-default .xgplayer-definition{-webkit-order:5;-moz-box-ordinal-group:6;order:5;width:60px;height:42px;z-index:18;position:relative;outline:none;display:none;cursor:default;margin-left:10px;margin-top:-7px}.xgplayer-skin-default .xgplayer-definition ul{display:none;list-style:none;width:78px;background:rgba(0,0,0,.54);border-radius:1px;position:absolute;bottom:42px;left:0;text-align:center;white-space:nowrap;margin-left:-10px;z-index:26;cursor:pointer}.xgplayer-skin-default .xgplayer-definition ul li{opacity:.7;font-family:PingFangSC-Regular;font-size:11px;color:hsla(0,0%,100%,.8);padding:6px 13px}.xgplayer-skin-default .xgplayer-definition ul li.selected,.xgplayer-skin-default .xgplayer-definition ul li:hover{color:#fff;opacity:1}.xgplayer-skin-default .xgplayer-definition .name{text-align:center;font-family:PingFangSC-Regular;font-size:13px;cursor:pointer;color:hsla(0,0%,100%,.8);position:absolute;bottom:5px;width:60px;height:20px;line-height:20px;background:rgba(0,0,0,.38);border-radius:10px;display:inline-block;vertical-align:middle}.xgplayer-skin-default.xgplayer-definition-active .xgplayer-definition ul,.xgplayer-skin-default.xgplayer-is-definition .xgplayer-definition{display:block}.xgplayer-skin-default .xgplayer-time{-webkit-order:2;-moz-box-ordinal-group:3;order:2;font-family:ArialMT;font-size:13px;color:#fff;line-height:40px;height:40px;text-align:center;display:inline-block}.xgplayer-skin-default .xgplayer-time span{color:hsla(0,0%,100%,.5)}.xgplayer-skin-default .xgplayer-time .xgplayer-time-current{color:#fff}.xgplayer-skin-default .xgplayer-time .xgplayer-time-current:after{content:\"/\";display:inline-block;padding:0 3px}.xgplayer-skin-default .xgplayer-controls{display:-webkit-flex;display:-moz-box;display:flex;position:absolute;bottom:0;left:0;right:0;height:40px;background-image:linear-gradient(180deg,transparent,rgba(0,0,0,.37),rgba(0,0,0,.75),rgba(0,0,0,.75));z-index:10}.xgplayer-skin-default.no-controls .xgplayer-controls,.xgplayer-skin-default.xgplayer-inactive .xgplayer-controls,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls>*,.xgplayer-skin-default.xgplayer-nostart .xgplayer-controls{display:none}.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-cssfullscreen,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-definition,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-fullscreen,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-live,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-placeholder,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-play,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-play-img,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-reload,.xgplayer-skin-default.xgplayer-is-live .xgplayer-controls .xgplayer-volume{display:block}.xgplayer-skin-default .xgplayer-live{display:block;font-size:12px;color:#fff;line-height:40px;-webkit-order:1;-moz-box-ordinal-group:2;order:1}.xgplayer-skin-default .xgplayer-loading{display:none;width:100px;height:100px;overflow:hidden;-webkit-transform:scale(.7);-ms-transform:scale(.7);transform:scale(.7);position:absolute;left:50%;top:50%;margin:-50px auto auto -50px}.xgplayer-skin-default .xgplayer-loading svg{border-radius:50%;-webkit-transform-origin:center;-ms-transform-origin:center;transform-origin:center;-webkit-animation:loadingRotate 1s linear infinite;animation:loadingRotate 1s linear infinite}.xgplayer-skin-default .xgplayer-loading svg path{stroke:#ddd;stroke-dasharray:236;-webkit-animation:loadingDashOffset 2s linear infinite;animation:loadingDashOffset 2s linear infinite;animation-direction:alternate-reverse;fill:none;stroke-width:12px}.xgplayer-skin-default.xgplayer-nostart .xgplayer-loading{display:none}.xgplayer-skin-default.xgplayer-pause .xgplayer-loading{display:none!important}.xgplayer-skin-default.xgplayer-isloading .xgplayer-loading{display:block}.xgplayer-skin-default .xgplayer-progress{display:block;position:absolute;height:20px;line-height:20px;left:12px;right:12px;outline:none;top:-15px;z-index:35}.xgplayer-skin-default .xgplayer-progress-outer{background:hsla(0,0%,100%,.3);display:block;height:3px;line-height:3px;margin-top:8.5px;width:100%;position:relative;cursor:pointer}.xgplayer-skin-default .xgplayer-progress-cache,.xgplayer-skin-default .xgplayer-progress-played{display:block;height:100%;line-height:1;position:absolute;left:0;top:0}.xgplayer-skin-default .xgplayer-progress-cache{width:0;background:hsla(0,0%,100%,.5)}.xgplayer-skin-default .xgplayer-progress-played{display:block;width:0;background-image:linear-gradient(-90deg,#fa1f41,#e31106);border-radius:0 1.5px 1.5px 0}.xgplayer-skin-default .xgplayer-progress-btn{display:none;position:absolute;left:0;top:-5px;width:13px;height:13px;border-radius:30px;background:#fff;box-shadow:0 0 2px 0 rgba(0,0,0,.26);left:100%;-webkit-transform:translate(-50%);-ms-transform:translate(-50%);transform:translate(-50%)}.xgplayer-skin-default .xgplayer-progress-point{position:absolute}.xgplayer-skin-default .xgplayer-progress-point.xgplayer-tips{margin-left:0;top:-25px;display:none;z-index:100}.xgplayer-skin-default .xgplayer-progress-dot{display:inline-block;position:absolute;height:3px;width:5px;top:0;background:#fff;border-radius:6px;z-index:16}.xgplayer-skin-default .xgplayer-progress-dot .xgplayer-progress-tip{position:absolute;left:0;top:-40px;height:auto;line-height:30px;width:auto;-webkit-transform:scale(.8);-ms-transform:scale(.8);transform:scale(.8);background:rgba(0,0,0,.3);border-radius:6px;border:1px solid rgba(0,0,0,.8);cursor:default;white-space:nowrap;display:none}.xgplayer-skin-default .xgplayer-progress-dot-show .xgplayer-progress-tip{display:block}.xgplayer-skin-default .xgplayer-progress-thumbnail{position:absolute;-moz-box-sizing:border-box;box-sizing:border-box}.xgplayer-skin-default .xgplayer-progress-thumbnail.xgplayer-tips{margin-left:0;display:none;z-index:99}.xgplayer-skin-default .xgplayer-progress:focus .xgplayer-progress-outer,.xgplayer-skin-default .xgplayer-progress:hover .xgplayer-progress-outer{height:6px;margin-top:7px}.xgplayer-skin-default .xgplayer-progress:focus .xgplayer-progress-dot,.xgplayer-skin-default .xgplayer-progress:hover .xgplayer-progress-dot{height:6px}.xgplayer-skin-default .xgplayer-progress:focus .xgplayer-progress-btn,.xgplayer-skin-default .xgplayer-progress:hover .xgplayer-progress-btn{display:block;top:-3px}.xgplayer-skin-default.xgplayer-definition-active .xgplayer-progress,.xgplayer-skin-default.xgplayer-playbackrate-active .xgplayer-progress,.xgplayer-skin-default.xgplayer-texttrack-active .xgplayer-progress,.xgplayer-skin-default.xgplayer-volume-active .xgplayer-progress{z-index:15}.xgplayer-skin-default.xgplayer-mobile .xgplayer-progress-btn{display:block!important}.xgplayer-skin-default.xgplayer-mobile .xgplayer-progress:focus .xgplayer-progress-outer,.xgplayer-skin-default.xgplayer-mobile .xgplayer-progress:hover .xgplayer-progress-outer{height:3px!important;margin-top:8.5px!important}.xgplayer-skin-default.xgplayer-mobile .xgplayer-progress:focus .xgplayer-progress-btn,.xgplayer-skin-default.xgplayer-mobile .xgplayer-progress:hover .xgplayer-progress-btn{display:block!important;top:-5px!important}.xgplayer-skin-default .xgplayer-replay{position:absolute;left:0;top:0;width:100%;height:100%;z-index:105;display:none;-webkit-justify-content:center;-moz-box-pack:center;justify-content:center;-webkit-align-items:center;-moz-box-align:center;align-items:center;background:rgba(0,0,0,.54);-webkit-flex-direction:column;-moz-box-orient:vertical;-moz-box-direction:normal;flex-direction:column}.xgplayer-skin-default .xgplayer-replay svg{background:rgba(0,0,0,.58);border-radius:100%;cursor:pointer}.xgplayer-skin-default .xgplayer-replay svg path{-webkit-transform:translate(20px,21px);-ms-transform:translate(20px,21px);transform:translate(20px,21px);fill:#ddd}.xgplayer-skin-default .xgplayer-replay svg:hover{background:rgba(0,0,0,.38)}.xgplayer-skin-default .xgplayer-replay svg:hover path{fill:#fff}.xgplayer-skin-default .xgplayer-replay .xgplayer-replay-txt{display:inline-block;font-family:PingFangSC-Regular;font-size:14px;color:#fff;line-height:34px}.xgplayer-skin-default.xgplayer.xgplayer-ended .xgplayer-controls{display:none}.xgplayer-skin-default.xgplayer.xgplayer-ended .xgplayer-replay{display:-webkit-flex;display:-moz-box;display:flex}.xgplayer-skin-default .xgplayer-playbackrate{-webkit-order:8;-moz-box-ordinal-group:9;order:8;width:60px;height:20px;z-index:18;position:relative;display:inline-block;cursor:default}.xgplayer-skin-default .xgplayer-playbackrate ul{display:none;list-style:none;width:78px;background:rgba(0,0,0,.54);border-radius:1px;position:absolute;bottom:20px;left:50%;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);text-align:left;white-space:nowrap;z-index:26;cursor:pointer}.xgplayer-skin-default .xgplayer-playbackrate ul li{opacity:.7;font-family:PingFangSC-Regular;font-size:11px;color:hsla(0,0%,100%,.8);position:relative;padding:4px 0;text-align:center}.xgplayer-skin-default .xgplayer-playbackrate ul li.selected,.xgplayer-skin-default .xgplayer-playbackrate ul li:hover{color:#fff;opacity:1}.xgplayer-skin-default .xgplayer-playbackrate ul li:first-child{position:relative;margin-top:12px}.xgplayer-skin-default .xgplayer-playbackrate ul li:last-child{position:relative;margin-bottom:12px}.xgplayer-skin-default .xgplayer-playbackrate .name{height:20px;position:relative;top:11px;text-align:center;background:rgba(0,0,0,.38);color:hsla(0,0%,100%,.8);border-radius:10px;line-height:20px}.xgplayer-skin-default .xgplayer-playbackrate span{position:relative;top:19px;font-weight:700;text-shadow:0 0 4px rgba(0,0,0,.6)}.xgplayer-skin-default .xgplayer-playbackrate:hover{opacity:1}.xgplayer-skin-default.xgplayer-playbackrate-active .xgplayer-playbackrate ul{display:block}.xgplayer-skin-default .xgplayer-download{position:relative;-webkit-order:9;-moz-box-ordinal-group:10;order:9;display:block;cursor:pointer}.xgplayer-skin-default .xgplayer-download .xgplayer-icon{margin-top:3px}.xgplayer-skin-default .xgplayer-download .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-download .xgplayer-icon svg{position:relative;top:5px;left:5px}.xgplayer-skin-default .xgplayer-download .xgplayer-tips{margin-left:-20px}.xgplayer-skin-default .xgplayer-download .xgplayer-tips .xgplayer-tip-download{display:block}.xgplayer-skin-default .xgplayer-download:hover{opacity:.85}.xgplayer-skin-default .xgplayer-download:hover .xgplayer-tips{display:block}.lang-is-en .xgplayer-download .xgplayer-tips{margin-left:-32px}.lang-is-jp .xgplayer-download .xgplayer-tips{margin-left:-40px}.xgplayer-skin-default .danmu-switch{-webkit-order:6;-moz-box-ordinal-group:7;order:6;z-index:26}.xgplayer-skin-default .xgplayer-danmu{display:none;position:absolute;top:0;left:0;right:0;height:100%;overflow:hidden;z-index:9;outline:none}.xgplayer-skin-default .xgplayer-danmu>*{position:absolute;white-space:nowrap;z-index:9}.xgplayer-skin-default .xgplayer-danmu.xgplayer-has-danmu{display:block}.xgplayer-skin-default .xgplayer-panel{outline:none;-webkit-order:7;-moz-box-ordinal-group:8;order:7;width:40px;height:40px;display:inline-block;position:relative;font-family:PingFangSC-Regular;font-size:13px;color:hsla(0,0%,100%,.8);z-index:36}.xgplayer-skin-default .xgplayer-panel .xgplayer-panel-icon{cursor:pointer;position:absolute;margin-left:5px;top:10px}.xgplayer-skin-default .xgplayer-panel-active{display:block!important;bottom:30px}.xgplayer-skin-default .xgplayer-panel-slider{z-index:36;display:none;position:absolute;width:230px;height:230px;background:rgba(0,0,0,.54);border-radius:1px;padding:10px 20px;outline:none;left:-115px;bottom:40px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-hidemode{padding-bottom:10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-hidemode-radio li{display:inline;list-style:none;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-hidemode ul{display:-webkit-flex;display:-moz-box;display:flex;-webkit-justify-content:space-around;justify-content:space-around}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-hidemode li{margin:0 12px;font-size:11px;color:#aaa}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-hidemode-font{margin-bottom:10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency{display:block;margin-top:10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-line{-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;outline:none;width:150px;height:4px;background:#aaa;border-radius:4px;border-style:none;margin-left:10px;margin-top:-2px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-line::-moz-focus-outer{border:0!important}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-color::-webkit-slider-runnable-track{outline:none;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-color::-moz-range-track{outline:none;background-color:#aaa;border-color:transparent;cursor:pointer;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-color::-ms-track{outline:none;background-color:#aaa;color:transparent;border-color:transparent;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-bar::-webkit-slider-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;margin-top:-4px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-bar::-moz-range-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:0;width:0;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-bar::-ms-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-transparency .xgplayer-transparency-bar::-moz-range-progress{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;height:4px;border-radius:4px;background:linear-gradient(90deg,#f85959,#f85959 100%,#aaa)}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea{display:block;margin-top:8px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-name{display:inline-block;position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-control{display:inline-block}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-control-up{width:150px;margin-left:10px;display:-moz-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between;color:#aaa}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-control-down{position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-control-down-dots{display:-webkit-flex;display:-moz-box;display:flex;width:150px;margin-left:10px;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-threequarters,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-twoquarters{margin-left:-6px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea-full{margin-right:3px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-line{-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;outline:none;width:150px;height:4px;background:#aaa;border-radius:4px;border-style:none;margin-left:10px;margin-top:-2px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-line::-moz-focus-outer{border:0!important}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-color::-webkit-slider-runnable-track{outline:none;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-color::-moz-range-track{outline:none;background-color:#aaa;border-color:transparent;cursor:pointer;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-color::-ms-track{outline:none;background-color:#aaa;color:transparent;border-color:transparent;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-bar::-webkit-slider-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;margin-top:-4px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-bar::-moz-range-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:0;width:0;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-bar::-ms-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-full-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-onequarters-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-threequarters-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-twoquarters-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-showarea .xgplayer-showarea-zero-dot{width:3px;height:3px;border:3px solid #aaa;border-radius:50%;background-color:#aaa;position:relative;top:16px;z-index:-1}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed{display:block}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed-name{display:inline-block;position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed-control{display:inline-block}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed-control-up{width:150px;margin-left:10px;display:-moz-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between;color:#aaa}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed-control-down{position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed-control-down-dots{display:-webkit-flex;display:-moz-box;display:flex;width:150px;margin-left:10px;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-line{-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;outline:none;width:150px;height:4px;background:#aaa;border-radius:4px;border-style:none;margin-left:10px;margin-top:-2px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-line::-moz-focus-outer{border:0!important}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-color::-webkit-slider-runnable-track{outline:none;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-color::-moz-range-track{outline:none;background-color:#aaa;border-color:transparent;cursor:pointer;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-color::-ms-track{outline:none;background-color:#aaa;color:transparent;border-color:transparent;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-bar::-webkit-slider-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;margin-top:-4px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-bar::-moz-range-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:0;width:0;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-bar::-ms-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-large-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-middle-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmuspeed .xgplayer-danmuspeed-small-dot{width:3px;height:3px;border:3px solid #aaa;border-radius:50%;background-color:#aaa;position:relative;top:16px;z-index:-1}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont{display:block}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont-name{display:inline-block;position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont-control{display:inline-block}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont-control-up{width:150px;margin-left:10px;display:-moz-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between;color:#aaa}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont-control-down{position:relative;top:-10px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont-control-down-dots{display:-webkit-flex;display:-moz-box;display:flex;width:150px;margin-left:10px;-webkit-justify-content:space-between;-moz-box-pack:justify;justify-content:space-between}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-line{-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;outline:none;width:150px;height:4px;background:#aaa;border-radius:4px;border-style:none;margin-left:10px;margin-top:-2px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-line::-moz-focus-outer{border:0!important}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-color::-webkit-slider-runnable-track{outline:none;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-color::-moz-range-track{outline:none;background-color:#aaa;border-color:transparent;cursor:pointer;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-color::-ms-track{outline:none;background-color:#aaa;color:transparent;border-color:transparent;width:150px;height:4px;border-radius:4px}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-bar::-webkit-slider-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;margin-top:-4px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-bar::-moz-range-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:0;width:0;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-bar::-ms-thumb{outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;border:6px solid #f85959;height:6px;width:6px;border-radius:6px;cursor:pointer}.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-large-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-middle-dot,.xgplayer-skin-default .xgplayer-panel-slider .xgplayer-danmufont .xgplayer-danmufont-small-dot{width:3px;height:3px;border:3px solid #aaa;border-radius:50%;background-color:#aaa;position:relative;top:16px;z-index:-1}.xgplayer-skin-default .xgplayer-playnext{position:relative;-webkit-order:1;-moz-box-ordinal-group:2;order:1;display:block;cursor:pointer;top:-2px}.xgplayer-skin-default .xgplayer-playnext .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-playnext .xgplayer-tips .xgplayer-tip-playnext{display:block}.xgplayer-skin-default .xgplayer-playnext:hover{opacity:.85}.xgplayer-skin-default .xgplayer-playnext:hover .xgplayer-tips{display:block}.lang-is-en .xgplayer-playnext .xgplayer-tips{margin-left:-25px}.lang-is-jp .xgplayer-playnext .xgplayer-tips{margin-left:-38px}.xgplayer-skin-default .xgplayer-pip{-webkit-order:9;-moz-box-ordinal-group:10;order:9;position:relative;outline:none;display:block;cursor:pointer;height:20px;top:8px}.xgplayer-skin-default .xgplayer-pip .name{text-align:center;font-family:PingFangSC-Regular;font-size:13px;line-height:20px;height:20px;color:hsla(0,0%,100%,.8)}.xgplayer-skin-default .xgplayer-pip .name span{width:60px;height:20px;line-height:20px;background:rgba(0,0,0,.38);border-radius:10px;display:inline-block;vertical-align:middle}.xgplayer-skin-default .xgplayer-pip-lay{position:absolute;top:26px;left:0;width:100%;height:100%;z-index:130;cursor:pointer;background-color:transparent;display:none}.xgplayer-skin-default .xgplayer-pip-lay div{width:100%;height:100%}.xgplayer-skin-default .xgplayer-pip-drag{cursor:move;position:absolute;top:0;left:0;width:100%;height:26px;line-height:26px;background-image:linear-gradient(rgba(0,0,0,.3),transparent);z-index:130;display:none}.xgplayer-skin-default.xgplayer-pip-active{position:fixed;right:0;bottom:200px;width:320px!important;height:180px!important;z-index:110!important}.xgplayer-skin-default.xgplayer-pip-active .xgplayer-controls,.xgplayer-skin-default.xgplayer-pip-active .xgplayer-danmu{display:none}.xgplayer-skin-default.xgplayer-pip-active .xgplayer-pip-lay{display:block}.xgplayer-skin-default.xgplayer-pip-active .xgplayer-pip-drag{display:-webkit-flex;display:-moz-box;display:flex}.xgplayer-skin-default.xgplayer-inactive .xgplayer-pip-drag{display:none}.lang-is-jp .xgplayer-pip .name span{width:70px;height:20px}.xgplayer-skin-default .xgplayer-rotate{position:relative;-webkit-order:10;-moz-box-ordinal-group:11;order:10;display:block;cursor:pointer}.xgplayer-skin-default .xgplayer-rotate .xgplayer-icon{margin-top:7px;width:26px}.xgplayer-skin-default .xgplayer-rotate .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-rotate .xgplayer-tips{margin-left:-22px}.xgplayer-skin-default .xgplayer-rotate .xgplayer-tips .xgplayer-tip-rotate{display:block}.xgplayer-skin-default .xgplayer-rotate:hover{opacity:.85}.xgplayer-skin-default .xgplayer-rotate:hover .xgplayer-tips{display:block}.lang-is-en .xgplayer-rotate .xgplayer-tips{margin-left:-26px}.lang-is-jp .xgplayer-rotate .xgplayer-tips{margin-left:-38px}.xgplayer-skin-default .xgplayer-reload{position:relative;-webkit-order:1;-moz-box-ordinal-group:2;order:1;display:block;width:40px;height:40px;cursor:pointer}.xgplayer-skin-default .xgplayer-reload .xgplayer-icon{margin-top:7px;width:26px}.xgplayer-skin-default .xgplayer-reload .xgplayer-icon div{position:absolute}.xgplayer-skin-default .xgplayer-reload .xgplayer-tips{margin-left:-22px}.xgplayer-skin-default .xgplayer-reload .xgplayer-tips .xgplayer-tip-reload{display:block}.xgplayer-skin-default .xgplayer-reload:hover{opacity:.85}.xgplayer-skin-default .xgplayer-reload:hover .xgplayer-tips{display:block}.lang-is-en .xgplayer-reload .xgplayer-tips{margin-left:-26px}.lang-is-jp .xgplayer-reload .xgplayer-tips{margin-left:-38px}.xgplayer-skin-default .xgplayer-screenshot{-webkit-order:11;-moz-box-ordinal-group:12;order:11;position:relative;outline:none;display:block;cursor:pointer;height:20px;top:8px}.xgplayer-skin-default .xgplayer-screenshot .name{text-align:center;font-family:PingFangSC-Regular;font-size:13px;line-height:20px;height:20px;color:hsla(0,0%,100%,.8)}.xgplayer-skin-default .xgplayer-screenshot .name span{width:60px;height:20px;line-height:20px;background:rgba(0,0,0,.38);border-radius:10px;display:inline-block;vertical-align:middle}.lang-is-en .xgplayer-screenshot .name span,.lang-is-jp .xgplayer-screenshot .name span{width:75px;height:20px}.xgplayer-skin-default .xgplayer-texttrack{-webkit-order:7;-moz-box-ordinal-group:8;order:7;width:60px;height:150px;z-index:18;position:relative;outline:none;display:none;cursor:default;margin-top:-119px}.xgplayer-skin-default .xgplayer-texttrack ul{display:none;list-style:none;min-width:78px;background:rgba(0,0,0,.54);border-radius:1px;position:absolute;bottom:30px;text-align:center;white-space:nowrap;left:50%;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);width:-webkit-fit-content;width:-moz-fit-content;width:fit-content;z-index:26;cursor:pointer}.xgplayer-skin-default .xgplayer-texttrack ul li{opacity:.7;font-family:PingFangSC-Regular;font-size:11px;color:hsla(0,0%,100%,.8);width:-webkit-fit-content;width:-moz-fit-content;width:fit-content;margin:auto;padding:6px 13px}.xgplayer-skin-default .xgplayer-texttrack ul li.selected,.xgplayer-skin-default .xgplayer-texttrack ul li:hover{color:#fff;opacity:1}.xgplayer-skin-default .xgplayer-texttrack .name{text-align:center;font-family:PingFangSC-Regular;font-size:13px;cursor:pointer;color:hsla(0,0%,100%,.8);position:absolute;bottom:0;width:60px;height:20px;line-height:20px;background:rgba(0,0,0,.38);border-radius:10px;display:inline-block;vertical-align:middle}.xgplayer-skin-default.xgplayer-is-texttrack .xgplayer-texttrack,.xgplayer-skin-default.xgplayer-texttrack-active .xgplayer-texttrack ul{display:block}.xgplayer-skin-default .xgplayer-icon{display:block;width:40px;height:40px;overflow:hidden;fill:#fff}.xgplayer-skin-default .xgplayer-icon svg{position:absolute}.xgplayer-skin-default .xgplayer-tips{background:rgba(0,0,0,.54);border-radius:1px;display:none;position:absolute;font-family:PingFangSC-Regular;font-size:11px;color:#fff;padding:2px 4px;text-align:center;top:-30px;left:50%;margin-left:-16px;width:auto;white-space:nowrap}.xgplayer-skin-default.xgplayer-mobile .xgplayer-tips{display:none!important}.xgplayer-skin-default .xgplayer-error{background:#000;display:none;position:absolute;left:0;top:0;width:100%;height:100%;z-index:125;font-family:PingFangSC-Regular;font-size:14px;color:#fff;text-align:center;line-height:100%;-webkit-justify-content:center;-moz-box-pack:center;justify-content:center;-webkit-align-items:center;-moz-box-align:center;align-items:center}.xgplayer-skin-default .xgplayer-error .xgplayer-error-refresh{color:#fa1f41;padding:0 3px;cursor:pointer}.xgplayer-skin-default .xgplayer-error .xgplayer-error-text{line-height:18px;margin:auto 6px}.xgplayer-skin-default.xgplayer-is-error .xgplayer-error{display:-webkit-flex;display:-moz-box;display:flex}.xgplayer-skin-default .xgplayer-memoryplay-spot{position:absolute;height:32px;left:10px;bottom:46px;background:rgba(0,0,0,.5);border-radius:32px;line-height:32px;color:#ddd;z-index:15;padding:0 32px 0 16px}.xgplayer-skin-default .xgplayer-memoryplay-spot .xgplayer-lasttime{color:red;font-weight:700}.xgplayer-skin-default .xgplayer-memoryplay-spot .btn-close{position:absolute;width:16px;height:16px;right:10px;top:2px;cursor:pointer;color:#fff;font-size:16px}", ""]);

// exports


/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function (useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if (item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function (modules, mediaQuery) {
		if (typeof modules === "string") modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for (var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if (typeof id === "number") alreadyImportedModules[id] = true;
		}
		for (i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if (typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if (mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if (mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */';
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}

/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getTarget = function (target) {
  return document.querySelector(target);
};

var getElement = (function (fn) {
	var memo = {};

	return function(target) {
                // If passing function in options, then use it for resolve "head" element.
                // Useful for Shadow Root style i.e
                // {
                //   insertInto: function () { return document.querySelector("#foo").shadowRoot }
                // }
                if (typeof target === 'function') {
                        return target();
                }
                if (typeof memo[target] === "undefined") {
			var styleTarget = getTarget.call(this, target);
			// Special case to return head of iframe instead of iframe itself
			if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
				try {
					// This will throw an exception if access to iframe is blocked
					// due to cross-origin restrictions
					styleTarget = styleTarget.contentDocument.head;
				} catch(e) {
					styleTarget = null;
				}
			}
			memo[target] = styleTarget;
		}
		return memo[target]
	};
})();

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(64);

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton && typeof options.singleton !== "boolean") options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
        if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else if (typeof options.insertAt === "object" && options.insertAt.before) {
		var nextSibling = getElement(options.insertInto + " " + options.insertAt.before);
		target.insertBefore(style, nextSibling);
	} else {
		throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	options.attrs.type = "text/css";

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	options.attrs.type = "text/css";
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = options.transform(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
	// get current location
	var location = typeof window !== "undefined" && window.location;

	if (!location) {
		throw new Error("fixUrls requires window.location");
	}

	// blank or null?
	if (!css || typeof css !== "string") {
		return css;
	}

	var baseUrl = location.protocol + "//" + location.host;
	var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
 This regular expression is just a way to recursively match brackets within
 a string.
 	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
    (  = Start a capturing group
      (?:  = Start a non-capturing group
          [^)(]  = Match anything that isn't a parentheses
          |  = OR
          \(  = Match a start parentheses
              (?:  = Start another non-capturing groups
                  [^)(]+  = Match anything that isn't a parentheses
                  |  = OR
                  \(  = Match a start parentheses
                      [^)(]*  = Match anything that isn't a parentheses
                  \)  = Match a end parentheses
              )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
  \)  = Match a close parens
 	 /gi  = Get all matches, not the first.  Be case insensitive.
  */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function (fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl.trim().replace(/^"(.*)"$/, function (o, $1) {
			return $1;
		}).replace(/^'(.*)'$/, function (o, $1) {
			return $1;
		});

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(unquotedOrigUrl)) {
			return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
			//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};

/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_enter = function s_enter() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  var barStr = '';
  for (var i = 1; i <= 12; i++) {
    barStr += '<div class="xgplayer-enter-bar' + i + '"></div>';
  }
  var enter = util.createDom('xg-enter', '<div class="xgplayer-enter-spinner">\n                                                  ' + barStr + '\n                                                </div>', {}, 'xgplayer-enter');
  root.appendChild(enter);
};

_player2.default.install('s_enter', s_enter);

/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _play = __webpack_require__(67);

var _play2 = _interopRequireDefault(_play);

var _pause = __webpack_require__(68);

var _pause2 = _interopRequireDefault(_pause);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_play = function s_play() {
  var player = this;
  var util = _player2.default.util;
  var playBtn = player.config.playBtn ? player.config.playBtn : {};
  var btn = void 0,
      iconPlay = void 0,
      iconPause = void 0;
  if (playBtn.type === 'img') {
    btn = util.createImgBtn('play', playBtn.url.play, playBtn.width, playBtn.height);
  } else {
    btn = util.createDom('xg-play', '<xg-icon class="xgplayer-icon">\n                                      <div class="xgplayer-icon-play">' + _play2.default + '</div>\n                                      <div class="xgplayer-icon-pause">' + _pause2.default + '</div>\n                                     </xg-icon>', {}, 'xgplayer-play');
  }

  var tipsText = {};
  tipsText.play = player.lang.PLAY_TIPS;
  tipsText.pause = player.lang.PAUSE_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-play">' + tipsText.play + '</span>\n                                        <span class="xgplayer-tip-pause">' + tipsText.pause + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('playBtnClick');
    });
  });
};

_player2.default.install('s_play', s_play);

/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.0320625 0.0320625)\" d=\"M576,363L810,512L576,661zM342,214L576,363L576,661L342,810z\"></path>\n</svg>\n");

/***/ }),
/* 68 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.0320625 0.0320625)\" d=\"M598,214h170v596h-170v-596zM256 810v-596h170v596h-170z\"></path>\n</svg>\n");

/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _startPlay = __webpack_require__(70);

var _startPlay2 = _interopRequireDefault(_startPlay);

var _startPause = __webpack_require__(71);

var _startPause2 = _interopRequireDefault(_startPause);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_start = function s_start() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var btn = util.createDom('xg-start', '<div class="xgplayer-icon-play">' + _startPlay2.default + '</div>\n                                      <div class="xgplayer-icon-pause">' + _startPause2.default + '</div>', {}, 'xgplayer-start');
  function onPlayerReady(player) {
    util.addClass(player.root, 'xgplayer-skin-default');
    if (player.config) {
      player.config.autoplay && !util.isWeiXin() && util.addClass(player.root, 'xgplayer-is-enter');
      if (player.config.lang && player.config.lang === 'en') {
        util.addClass(player.root, 'lang-is-en');
      } else if (player.config.lang === 'jp') {
        util.addClass(player.root, 'lang-is-jp');
      }
      if (!player.config.enableContextmenu) {
        player.video.addEventListener('contextmenu', function (e) {
          e.preventDefault();
          e.stopPropagation();
        });
      }
    }
  }

  if (player.isReady) {
    root.appendChild(btn);
    onPlayerReady(player);
  } else {
    player.once('ready', function () {
      root.appendChild(btn);
      onPlayerReady(player);
    });
  }

  player.once('autoplay was prevented', function () {
    util.removeClass(player.root, 'xgplayer-is-enter');
    util.addClass(player.root, 'xgplayer-nostart');
  });

  player.once('canplay', function () {
    util.removeClass(player.root, 'xgplayer-is-enter');
  });

  btn.onclick = function (e) {
    e.preventDefault();
    e.stopPropagation();
    player.emit('startBtnClick');
  };
};

_player2.default.install('s_start', s_start);

/***/ }),
/* 70 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"70\" height=\"70\" viewBox=\"0 0 70 70\">\n  <path transform=\"scale(0.04,0.04)\" d=\"M576,363L810,512L576,661zM342,214L576,363L576,661L342,810z\"></path>\n</svg>\n");

/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"70\" height=\"70\" viewBox=\"0 0 70 70\">\n  <path transform=\"scale(0.04 0.04)\" d=\"M598,214h170v596h-170v-596zM256 810v-596h170v596h-170z\"></path>\n</svg>\n");

/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_poster = function s_poster() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  if (!player.config.poster) {
    return;
  }
  var poster = util.createDom('xg-poster', '', {}, 'xgplayer-poster');
  poster.style.backgroundImage = 'url(' + player.config.poster + ')';
  root.appendChild(poster);
};

_player2.default.install('s_poster', s_poster);

/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_flex = function s_flex() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var playceholder = util.createDom('xg-placeholder', '', {}, 'xgplayer-placeholder');
  player.controls.appendChild(playceholder);
};

_player2.default.install('s_flex', s_flex);

/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _requestFull = __webpack_require__(75);

var _requestFull2 = _interopRequireDefault(_requestFull);

var _exitFull = __webpack_require__(76);

var _exitFull2 = _interopRequireDefault(_exitFull);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_fullscreen = function s_fullscreen() {
  var player = this;
  var util = _player2.default.util;
  var fullscreenBtn = player.config.fullscreenBtn ? player.config.fullscreenBtn : {};
  var btn = void 0,
      iconRequestFull = void 0,
      iconExitFull = void 0;
  if (fullscreenBtn.type === 'img') {
    btn = util.createImgBtn('fullscreen', fullscreenBtn.url.request, fullscreenBtn.width, fullscreenBtn.height);
  } else {
    btn = util.createDom('xg-fullscreen', '<xg-icon class="xgplayer-icon">\n                                             <div class="xgplayer-icon-requestfull">' + _requestFull2.default + '</div>\n                                             <div class="xgplayer-icon-exitfull">' + _exitFull2.default + '</div>\n                                           </xg-icon>', {}, 'xgplayer-fullscreen');
  }

  var tipsText = {};
  tipsText.requestfull = player.lang.FULLSCREEN_TIPS;
  tipsText.exitfull = player.lang.EXITFULLSCREEN_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-requestfull">' + tipsText.requestfull + '</span>\n                                        <span class="xgplayer-tip-exitfull">' + tipsText.exitfull + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('fullscreenBtnClick');
    });
  });
};

_player2.default.install('s_fullscreen', s_fullscreen);

/***/ }),
/* 75 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.0320625 0.0320625)\" d=\"M598 214h212v212h-84v-128h-128v-84zM726 726v-128h84v212h-212v-84h128zM214 426v-212h212v84h-128v128h-84zM298 598v128h128v84h-212v-212h84z\"></path>\n</svg>\n");

/***/ }),
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.0320625 0.0320625)\" d=\"M682 342h128v84h-212v-212h84v128zM598 810v-212h212v84h-128v128h-84zM342 342v-128h84v212h-212v-84h128zM214 682v-84h212v212h-84v-128h-128z\"></path>\n</svg>\n");

/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _requestCssFull = __webpack_require__(78);

var _requestCssFull2 = _interopRequireDefault(_requestCssFull);

var _exitCssFull = __webpack_require__(79);

var _exitCssFull2 = _interopRequireDefault(_exitCssFull);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_cssFullscreen = function s_cssFullscreen() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.cssFullscreen) {
    return;
  }
  var btn = util.createDom('xg-cssfullscreen', '<xg-icon class="xgplayer-icon">\n                                             <div class="xgplayer-icon-requestfull">' + _requestCssFull2.default + '</div>\n                                             <div class="xgplayer-icon-exitfull">' + _exitCssFull2.default + '</div>\n                                           </xg-icon>', {}, 'xgplayer-cssfullscreen');

  var tipsText = {};
  tipsText.requestfull = player.lang.CSSFULLSCREEN_TIPS;
  tipsText.exitfull = player.lang.EXITCSSFULLSCREEN_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-requestfull">' + tipsText.requestfull + '</span>\n                                        <span class="xgplayer-tip-exitfull">' + tipsText.exitfull + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('cssFullscreenBtnClick');
    });
  });
};

_player2.default.install('s_cssFullscreen', s_cssFullscreen);

/***/ }),
/* 78 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.028 0.028)\" d=\"M843.617212 67.898413 175.411567 67.898413c-61.502749 0-111.367437 49.856501-111.367437 111.367437l0 668.205645c0 61.510936 49.864688 111.367437 111.367437 111.367437L843.617212 958.838931c61.510936 0 111.367437-49.856501 111.367437-111.367437L954.984648 179.26585C954.984648 117.754914 905.12917 67.898413 843.617212 67.898413zM398.146441 736.104057c15.380292 0 27.842115 12.461823 27.842115 27.842115 0 15.379269-12.461823 27.841092-27.842115 27.841092L259.725858 791.787264c-7.785314 0-14.781658-3.217275-19.838837-8.365528-5.383614-4.577249-8.791224-11.228739-8.791224-19.475564L231.095797 624.736621c0-15.371082 12.471033-27.842115 27.842115-27.842115 15.380292 0 27.842115 12.471033 27.842115 27.842115l-0.61603 71.426773 133.036969-133.037992 39.378869 39.378869L324.962651 736.113267 398.146441 736.104057zM419.199942 463.611943 286.162974 330.565764l0.61603 71.435982c0 15.380292-12.461823 27.842115-27.842115 27.842115-15.371082 0-27.842115-12.461823-27.842115-27.842115L231.094774 262.791172c0-8.256034 3.40761-14.908548 8.791224-19.476587 5.057179-5.148253 12.053524-8.374738 19.838837-8.374738l138.420583 0.00921c15.380292 0 27.842115 12.461823 27.842115 27.842115s-12.461823 27.842115-27.842115 27.842115l-73.175603-0.00921 133.607974 133.607974L419.199942 463.611943zM787.932981 763.946172c0 8.247848-3.40761 14.899338-8.791224 19.475564-5.057179 5.148253-12.053524 8.365528-19.839861 8.365528L620.881314 791.787264c-15.379269 0-27.841092-12.461823-27.841092-27.841092 0-15.380292 12.461823-27.842115 27.841092-27.842115l73.185836 0.00921L560.449967 602.50427l39.378869-39.378869L732.875015 696.163393l-0.62524-71.426773c0-15.371082 12.462846-27.842115 27.842115-27.842115 15.380292 0 27.842115 12.471033 27.842115 27.842115L787.934005 763.946172zM787.932981 402.000724c0 15.380292-12.461823 27.842115-27.842115 27.842115-15.379269 0-27.842115-12.461823-27.842115-27.842115l0.62524-71.435982L599.828836 463.611943l-39.378869-39.378869 133.617184-133.607974-73.185836 0.00921c-15.379269 0-27.841092-12.461823-27.841092-27.842115s12.461823-27.842115 27.841092-27.842115l138.421606-0.00921c7.785314 0 14.781658 3.226484 19.839861 8.374738 5.383614 4.568039 8.791224 11.219529 8.791224 19.476587L787.934005 402.000724z\"></path>\n</svg>\n");

/***/ }),
/* 79 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.028 0.028)\" d=\"M834.56 81.92H189.44c-59.392 0-107.52 48.128-107.52 107.52v645.12c0 59.392 48.128 107.52 107.52 107.52h645.12c59.392 0 107.52-48.128 107.52-107.52V189.44c0-59.392-48.128-107.52-107.52-107.52zM458.24 727.04c0 14.848-12.288 26.624-26.624 26.624S404.48 741.888 404.48 727.04v-69.632L289.28 773.12c-10.752 10.24-27.648 10.24-37.888 0-10.24-10.752-10.24-27.648 0-37.888L366.592 619.52H296.96c-14.848 0-26.624-12.288-26.624-26.624s12.288-26.624 26.624-26.624h134.144c14.848 0 26.624 12.288 26.624 26.624V727.04z m0-295.936c0 14.848-12.288 26.624-26.624 26.624H296.96c-14.848 0-26.624-12.288-26.624-26.624S282.112 404.48 296.96 404.48h69.632L251.392 289.28c-10.24-10.752-10.24-27.648 0-37.888 5.12-5.12 12.288-7.68 18.944-7.68 6.656 0 13.824 2.56 18.944 7.68L404.48 366.592V296.96c0-14.848 12.288-26.624 26.624-26.624s26.624 12.288 26.624 26.624v134.144zM773.12 773.12c-10.752 10.24-27.648 10.24-37.888 0L619.52 657.408V727.04c0 14.848-12.288 26.624-26.624 26.624s-26.624-11.776-26.624-26.624v-134.144c0-14.848 12.288-26.624 26.624-26.624H727.04c14.848 0 26.624 12.288 26.624 26.624s-12.288 26.624-26.624 26.624h-69.632l115.2 115.2c10.752 10.752 10.752 27.648 0.512 38.4z m0-483.84L657.408 404.48H727.04c14.848 0 26.624 12.288 26.624 26.624 0 14.848-12.288 26.624-26.624 26.624h-134.144c-14.848 0-26.624-12.288-26.624-26.624V296.96c0-14.848 12.288-26.624 26.624-26.624s26.624 12.288 26.624 26.624v69.632L734.72 250.88c5.12-5.12 12.288-7.68 18.944-7.68s13.824 2.56 18.944 7.68c10.752 10.752 10.752 27.648 0.512 38.4z\"></path>\n</svg>\n");

/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _volumeMuted = __webpack_require__(81);

var _volumeMuted2 = _interopRequireDefault(_volumeMuted);

var _volumeSmall = __webpack_require__(82);

var _volumeSmall2 = _interopRequireDefault(_volumeSmall);

var _volumeLarge = __webpack_require__(83);

var _volumeLarge2 = _interopRequireDefault(_volumeLarge);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_volume = function s_volume() {
  var player = this;
  var util = _player2.default.util;
  var container = util.createDom('xg-volume', '<xg-icon class="xgplayer-icon">\n                                         <div class="xgplayer-icon-large">' + _volumeLarge2.default + '</div>\n                                         <div class="xgplayer-icon-small">' + _volumeSmall2.default + '</div>\n                                         <div class="xgplayer-icon-muted">' + _volumeMuted2.default + '</div>\n                                       </xg-icon>\n                                       <xg-slider class="xgplayer-slider" tabindex="2">\n                                         <xg-bar class="xgplayer-bar">\n                                           <xg-drag class="xgplayer-drag"></xg-drag>\n                                         </xg-bar>\n                                       </xg-slider>', {}, 'xgplayer-volume');
  player.once('ready', function () {
    player.controls.appendChild(container);
  });
  var slider = container.querySelector('.xgplayer-slider');
  var bar = container.querySelector('.xgplayer-bar');
  var selected = container.querySelector('.xgplayer-drag');
  var icon = container.querySelector('.xgplayer-icon');
  selected.style.height = player.config.volume * 100 + '%';
  slider.volume = player.config.volume;

  bar.addEventListener('mousedown', function (e) {
    e.preventDefault();
    e.stopPropagation();
    player.emit('volumeBarClick', e);
  });

  ['click', 'touchend'].forEach(function (item) {
    icon.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('volumeIconClick');
    });
  });

  icon.addEventListener('mouseenter', function (e) {
    e.preventDefault();
    e.stopPropagation();
    player.emit('volumeIconEnter');
  });

  ['blur', 'mouseleave'].forEach(function (item) {
    container.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('volumeIconLeave');
    });
  });
};

_player2.default.install('s_volume', s_volume);

/***/ }),
/* 81 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 28 28\">\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M358.4 358.4h-204.8v307.2h204.8l256 256v-819.2l-256 256z\"></path>\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M920.4 439.808l-108.544-109.056-72.704 72.704 109.568 108.544-109.056 108.544 72.704 72.704 108.032-109.568 108.544 109.056 72.704-72.704-109.568-108.032 109.056-108.544-72.704-72.704-108.032 109.568z\"></path>\n</svg>\n");

/***/ }),
/* 82 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 28 28\">\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M358.4 358.4h-204.8v307.2h204.8l256 256v-819.2l-256 256z\"></path>\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M795.648 693.248l-72.704-72.704c27.756-27.789 44.921-66.162 44.921-108.544s-17.165-80.755-44.922-108.546l0.002 0.002 72.704-72.704c46.713 46.235 75.639 110.363 75.639 181.248s-28.926 135.013-75.617 181.227l-0.021 0.021zM795.648 693.248l-72.704-72.704c27.756-27.789 44.921-66.162 44.921-108.544s-17.165-80.755-44.922-108.546l0.002 0.002 72.704-72.704c46.713 46.235 75.639 110.363 75.639 181.248s-28.926 135.013-75.617 181.227l-0.021 0.021z\"></path>\n</svg>\n");

/***/ }),
/* 83 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 28 28\">\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M358.4 358.4h-204.8v307.2h204.8l256 256v-819.2l-256 256z\"></path>\n  <path transform=\"scale(0.0220625 0.0220625)\" d=\"M940.632 837.632l-72.192-72.192c65.114-64.745 105.412-154.386 105.412-253.44s-40.299-188.695-105.396-253.424l-0.016-0.016 72.192-72.192c83.639 83.197 135.401 198.37 135.401 325.632s-51.762 242.434-135.381 325.612l-0.020 0.020zM795.648 693.248l-72.704-72.704c27.756-27.789 44.921-66.162 44.921-108.544s-17.165-80.755-44.922-108.546l0.002 0.002 72.704-72.704c46.713 46.235 75.639 110.363 75.639 181.248s-28.926 135.013-75.617 181.227l-0.021 0.021z\"></path>\n</svg>\n");

/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_definition = function s_definition() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var sniffer = _player2.default.sniffer;
  var paused = void 0;
  var container = util.createDom('xg-definition', '', { tabindex: 3 }, 'xgplayer-definition');
  if (sniffer.device === 'mobile') {
    player.config.definitionActive = 'click';
  }

  function onCanplayResourceReady() {
    var list = player.definitionList;
    var tmp = ['<ul>'],
        src = player.config.url,
        a = document.createElement('a');
    if (player.switchURL) {
      ['mp4', 'hls', '__flv__', 'dash'].every(function (item) {
        if (player[item]) {
          if (player[item].url) {
            a.href = player[item].url;
          }
          if (item === '__flv__') {
            if (player[item]._options) {
              a.href = player[item]._options.url;
            } else {
              a.href = player[item]._mediaDataSource.url;
            }
          }
          src = a.href;
          return false;
        } else {
          return true;
        }
      });
    } else {
      src = player.currentSrc || player.src;
    }
    if (player['hls']) {
      a.href = player['hls'].url;
      src = a.href;
    }
    list.forEach(function (item) {
      a.href = item.url;
      if (player.dash) {
        tmp.push('<li url=\'' + item.url + '\' cname=\'' + item.name + '\' class=\'' + (item.selected ? 'selected' : '') + '\'>' + item.name + '</li>');
      } else {
        tmp.push('<li url=\'' + item.url + '\' cname=\'' + item.name + '\' class=\'' + (a.href === src ? 'selected' : '') + '\'>' + item.name + '</li>');
      }
    });
    var cursrc = list.filter(function (item) {
      a.href = item.url;
      if (player.dash) {
        return item.selected === true;
      } else {
        return a.href === src;
      }
    });
    tmp.push('</ul><p class=\'name\'>' + (cursrc[0] || { name: '' }).name + '</p>');
    var urlInRoot = root.querySelector('.xgplayer-definition');
    if (urlInRoot) {
      urlInRoot.innerHTML = tmp.join('');
      var cur = urlInRoot.querySelector('.name');
      if (!player.config.definitionActive || player.config.definitionActive === 'hover') {
        cur.addEventListener('mouseenter', function (e) {
          e.preventDefault();
          e.stopPropagation();
          util.addClass(player.root, 'xgplayer-definition-active');
          urlInRoot.focus();
        });
      }
    } else {
      container.innerHTML = tmp.join('');
      var _cur = container.querySelector('.name');
      if (!player.config.definitionActive || player.config.definitionActive === 'hover') {
        _cur.addEventListener('mouseenter', function (e) {
          e.preventDefault();
          e.stopPropagation();
          util.addClass(player.root, 'xgplayer-definition-active');
          container.focus();
        });
      }
      player.controls.appendChild(container);
    }
  }
  function onResourceReady(list) {
    player.definitionList = list;
    if (list && list instanceof Array && list.length > 1) {
      util.addClass(root, 'xgplayer-is-definition');
      player.on('canplay', onCanplayResourceReady);
    }
  }
  player.on('resourceReady', onResourceReady);

  function onCanplayChangeDefinition() {
    player.currentTime = player.curTime;
    if (!paused) {
      var playPromise = player.play();
      if (playPromise !== undefined && playPromise) {
        playPromise.catch(function (err) {});
      }
    }
  };
  ['touchend', 'click'].forEach(function (item) {
    container.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      var list = player.definitionList;
      var li = e.target || e.srcElement,
          a = document.createElement('a');
      if (li && li.tagName.toLocaleLowerCase() === 'li') {
        player.emit('beforeDefinitionChange', a.href);
        var from = void 0,
            to = void 0;
        Array.prototype.forEach.call(li.parentNode.childNodes, function (item) {
          if (util.hasClass(item, 'selected')) {
            from = item.getAttribute('cname');
            util.removeClass(item, 'selected');
          }
        });
        if (player.dash) {
          list.forEach(function (item) {
            item.selected = false;
            if (item.name === li.innerHTML) {
              item.selected = true;
            }
          });
        }

        util.addClass(li, 'selected');
        to = li.getAttribute('cname');
        li.parentNode.nextSibling.innerHTML = '' + li.getAttribute('cname');
        a.href = li.getAttribute('url');
        if (player.switchURL) {
          var curRUL = document.createElement('a');
          ['mp4', 'hls', '__flv__', 'dash'].every(function (item) {
            if (player[item]) {
              if (player[item].url) {
                curRUL.href = player[item].url;
              }
              if (item === '__flv__') {
                if (player[item]._options) {
                  curRUL.href = player[item]._options.url;
                } else {
                  curRUL.href = player[item]._mediaDataSource.url;
                }
              }
              return false;
            } else {
              return true;
            }
          });
          if (curRUL.href !== a.href && !player.ended) {
            player.switchURL(a.href);
          }
        } else {
          if (player['hls']) {
            var _curRUL = document.createElement('a');
            _curRUL = player['hls'].url;
          }
          if (a.href !== player.currentSrc) {
            player.curTime = player.currentTime, paused = player.paused;
            if (!player.ended) {
              player.src = a.href;
              player.once('canplay', onCanplayChangeDefinition);
            }
          }
        }
        player.emit('definitionChange', { from: from, to: to });
        if (sniffer.device === 'mobile') {
          util.removeClass(player.root, 'xgplayer-definition-active');
        }
      } else if (player.config.definitionActive === 'click' && li && (li.tagName.toLocaleLowerCase() === 'p' || li.tagName.toLocaleLowerCase() === 'em')) {
        if (sniffer.device === 'mobile') {
          util.toggleClass(player.root, 'xgplayer-definition-active');
        } else {
          util.addClass(player.root, 'xgplayer-definition-active');
        }
        container.focus();
      }
      player.emit('focus');
    }, false);
  });

  container.addEventListener('mouseleave', function (e) {
    e.preventDefault();
    e.stopPropagation();
    util.removeClass(root, 'xgplayer-definition-active');
  });

  function onBlur() {
    util.removeClass(root, 'xgplayer-definition-active');
  }
  player.on('blur', onBlur);

  function onDestroy() {
    player.off('resourceReady', onResourceReady);
    player.off('canplay', onCanplayResourceReady);
    player.off('canplay', onCanplayChangeDefinition);
    player.off('blur', onBlur);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('s_definition', s_definition);

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _loading = __webpack_require__(86);

var _loading2 = _interopRequireDefault(_loading);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_loading = function s_loading() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var container = util.createDom('xg-loading', '' + _loading2.default, {}, 'xgplayer-loading');
  player.once('ready', function () {
    root.appendChild(container);
  });
};

_player2.default.install('s_loading', s_loading);

/***/ }),
/* 86 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"100\" height=\"100\" viewbox=\"0 0 100 100\">\n  <path d=\"M100,50A50,50,0,1,1,50,0\"></path>\n</svg>\n");

/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var isRotateFullscreen = function isRotateFullscreen(player) {
  return _player2.default.util.hasClass(player.root, 'xgplayer-rotate-fullscreen');
};

var s_progress = function s_progress() {
  var player = this;
  var util = _player2.default.util;
  var container = util.createDom('xg-progress', '<xg-outer class="xgplayer-progress-outer">\n                                                   <xg-cache class="xgplayer-progress-cache"></xg-cache>\n                                                   <xg-played class="xgplayer-progress-played">\n                                                     <xg-progress-btn class="xgplayer-progress-btn"></xg-progress-btn>\n                                                     <xg-point class="xgplayer-progress-point xgplayer-tips"></xg-point>\n                                                     <xg-thumbnail class="xgplayer-progress-thumbnail xgplayer-tips"></xg-thumbnail>\n                                                   </xgplayer-played>\n                                                 </xg-outer>', { tabindex: 1 }, 'xgplayer-progress');
  var containerWidth = void 0;
  player.controls.appendChild(container);
  var progress = container.querySelector('.xgplayer-progress-played');
  var btn = container.querySelector('.xgplayer-progress-btn');
  var outer = container.querySelector('.xgplayer-progress-outer');
  var cache = container.querySelector('.xgplayer-progress-cache');
  var point = container.querySelector('.xgplayer-progress-point');
  var thumbnail = container.querySelector('.xgplayer-progress-thumbnail');
  player.dotArr = {};
  function dotEvent(dotItem, text) {
    dotItem.addEventListener('mouseenter', function (e) {
      if (text) {
        util.addClass(dotItem, 'xgplayer-progress-dot-show');
        util.addClass(container, 'xgplayer-progress-dot-active');
      }
    });
    dotItem.addEventListener('mouseleave', function (e) {
      if (text) {
        util.removeClass(dotItem, 'xgplayer-progress-dot-show');
        util.removeClass(container, 'xgplayer-progress-dot-active');
      }
    });
    dotItem.addEventListener('touchend', function (e) {
      // e.preventDefault()
      e.stopPropagation();
      if (text) {
        if (!util.hasClass(dotItem, 'xgplayer-progress-dot-show')) {
          Object.keys(player.dotArr).forEach(function (key) {
            if (player.dotArr[key]) {
              util.removeClass(player.dotArr[key], 'xgplayer-progress-dot-show');
            }
          });
        }
        util.toggleClass(dotItem, 'xgplayer-progress-dot-show');
        util.toggleClass(container, 'xgplayer-progress-dot-active');
      }
    });
  }
  function onCanplay() {
    if (player.config.progressDot && util.typeOf(player.config.progressDot) === 'Array') {
      player.config.progressDot.forEach(function (item) {
        if (item.time >= 0 && item.time <= player.duration) {
          var dot = util.createDom('xg-progress-dot', item.text ? '<span class="xgplayer-progress-tip">' + item.text + '</span>' : '', {}, 'xgplayer-progress-dot');
          dot.style.left = item.time / player.duration * 100 + '%';
          if (item.duration >= 0) {
            dot.style.width = Math.min(item.duration, player.duration - item.time) / player.duration * 100 + '%';
          }
          outer.appendChild(dot);
          player.dotArr[item.time] = dot;
          dotEvent(dot, item.text);
        }
      });
    }
  }
  player.once('canplay', onCanplay);
  player.addProgressDot = function (time, text, duration) {
    if (player.dotArr[time]) {
      return;
    }
    if (time >= 0 && time <= player.duration) {
      var dot = util.createDom('xg-progress-dot', '', {}, 'xgplayer-progress-dot');
      dot.style.left = time / player.duration * 100 + '%';
      if (duration >= 0) {
        dot.style.width = Math.min(duration, player.duration - time) / player.duration * 100 + '%';
      }
      outer.appendChild(dot);
      player.dotArr[time] = dot;
      dotEvent(dot, text);
    }
  };
  player.removeProgressDot = function (time) {
    if (time >= 0 && time <= player.duration && player.dotArr[time]) {
      var dot = player.dotArr[time];
      dot.parentNode.removeChild(dot);
      dot = null;
      player.dotArr[time] = null;
    }
  };
  player.removeAllProgressDot = function () {
    Object.keys(player.dotArr).forEach(function (key) {
      if (player.dotArr[key]) {
        var dot = player.dotArr[key];
        dot.parentNode.removeChild(dot);
        dot = null;
        player.dotArr[key] = null;
      }
    });
  };
  var tnailPicNum = 0;
  var tnailWidth = 0;
  var tnailHeight = 0;
  var tnailCol = 0;
  var tnailRow = 0;
  var interval = 0;
  var tnailUrls = [];
  if (player.config.thumbnail) {
    tnailPicNum = player.config.thumbnail.pic_num;
    tnailWidth = player.config.thumbnail.width;
    tnailHeight = player.config.thumbnail.height;
    tnailCol = player.config.thumbnail.col;
    tnailRow = player.config.thumbnail.row;
    tnailUrls = player.config.thumbnail.urls;
    thumbnail.style.width = tnailWidth + 'px';
    thumbnail.style.height = tnailHeight + 'px';
  };
  ['touchstart', 'mousedown'].forEach(function (item) {
    if (player.config.disableProgress) return;
    container.addEventListener(item, function (e) {
      // e.preventDefault()
      e.stopPropagation();
      util.event(e);
      if (e._target === point || !player.config.allowSeekAfterEnded && player.ended) {
        return true;
      }
      container.focus();

      var _progress$getBounding = progress.getBoundingClientRect(),
          left = _progress$getBounding.left;

      var isRotate = isRotateFullscreen(player);
      if (isRotate) {
        left = progress.getBoundingClientRect().top;
        containerWidth = container.getBoundingClientRect().height;
      } else {
        containerWidth = container.getBoundingClientRect().width;
        left = progress.getBoundingClientRect().left;
      }

      var move = function move(e) {
        // e.preventDefault()
        e.stopPropagation();
        util.event(e);
        player.isProgressMoving = true;
        var w = (isRotate ? e.clientY : e.clientX) - left;
        if (w > containerWidth) {
          w = containerWidth;
        }
        var now = w / containerWidth * player.duration;
        progress.style.width = w * 100 / containerWidth + '%';

        if (player.videoConfig.mediaType === 'video' && !player.dash && !player.config.closeMoveSeek) {
          player.currentTime = Number(now).toFixed(1);
        } else {
          var time = util.findDom(player.controls, '.xgplayer-time');
          if (time) {
            time.innerHTML = '<span class="xgplayer-time-current">' + util.format(now || 0) + '</span><span>' + util.format(player.duration) + '</span>';
          }
        }
        player.emit('focus');
      };
      var up = function up(e) {
        // e.preventDefault()
        e.stopPropagation();
        util.event(e);
        window.removeEventListener('mousemove', move);
        window.removeEventListener('touchmove', move, { passive: false });
        window.removeEventListener('mouseup', up);
        window.removeEventListener('touchend', up);
        container.blur();
        if (!player.isProgressMoving || player.videoConfig.mediaType === 'audio' || player.dash || player.config.closeMoveSeek) {
          var w = (isRotate ? e.clientY : e.clientX) - left;
          if (w > containerWidth) {
            w = containerWidth;
          }
          var now = w / containerWidth * player.duration;
          progress.style.width = w * 100 / containerWidth + '%';
          player.currentTime = Number(now).toFixed(1);
        }
        player.emit('focus');
        player.isProgressMoving = false;
      };
      window.addEventListener('mousemove', move);
      window.addEventListener('touchmove', move, { passive: false });
      window.addEventListener('mouseup', up);
      window.addEventListener('touchend', up);
      return true;
    });
  });

  container.addEventListener('mouseenter', function (e) {
    if (!player.config.allowSeekAfterEnded && player.ended) {
      return true;
    }
    var isRotate = isRotateFullscreen(player);
    var containerLeft = isRotate ? container.getBoundingClientRect().top : container.getBoundingClientRect().left;
    var containerWidth = isRotate ? container.getBoundingClientRect().height : container.getBoundingClientRect().width;

    var compute = function compute(e) {
      var now = ((isRotate ? e.clientY : e.clientX) - containerLeft) / containerWidth * player.duration;
      now = now < 0 ? 0 : now;
      point.textContent = util.format(now);
      var pointWidth = point.getBoundingClientRect().width;
      if (player.config.thumbnail) {
        interval = player.duration / tnailPicNum;
        var index = Math.floor(now / interval);
        thumbnail.style.backgroundImage = 'url(' + tnailUrls[Math.ceil((index + 1) / (tnailCol * tnailRow)) - 1] + ')';
        var indexInPage = index + 1 - tnailCol * tnailRow * (Math.ceil((index + 1) / (tnailCol * tnailRow)) - 1);
        var tnaiRowIndex = Math.ceil(indexInPage / tnailRow) - 1;
        var tnaiColIndex = indexInPage - tnaiRowIndex * tnailRow - 1;
        thumbnail.style['background-position'] = '-' + tnaiColIndex * tnailWidth + 'px -' + tnaiRowIndex * tnailHeight + 'px';
        var left = (isRotate ? e.clientY : e.clientX) - containerLeft - tnailWidth / 2;
        left = left > 0 ? left : 0;
        left = left < containerWidth - tnailWidth ? left : containerWidth - tnailWidth;
        thumbnail.style.left = left + 'px';
        thumbnail.style.top = -10 - tnailHeight + 'px';
        thumbnail.style.display = 'block';
        point.style.left = left + tnailWidth / 2 - pointWidth / 2 + 'px';
      } else {
        var _left = e.clientX - containerLeft - pointWidth / 2;
        _left = _left > 0 ? _left : 0;
        _left = _left > containerWidth - pointWidth ? containerWidth - pointWidth : _left;
        point.style.left = _left + 'px';
      }
      if (util.hasClass(container, 'xgplayer-progress-dot-active')) {
        point.style.display = 'none';
      } else {
        point.style.display = 'block';
      }
    };
    var move = function move(e) {
      compute(e);
    };
    var leave = function leave(e) {
      container.removeEventListener('mousemove', move, false);
      container.removeEventListener('mouseleave', leave, false);
      compute(e);
      point.style.display = 'none';
      thumbnail.style.display = 'none';
    };
    container.addEventListener('mousemove', move, false);
    container.addEventListener('mouseleave', leave, false);
    compute(e);
  }, false);

  // let lastBtnLeft = false
  var onTimeupdate = function onTimeupdate() {
    if (!containerWidth && container) {
      containerWidth = container.getBoundingClientRect().width;
    }
    if (player.videoConfig.mediaType !== 'audio' || !player.isProgressMoving || !player.dash) {
      var precent = player.currentTime / player.duration;
      var prevPrecent = Number.parseFloat(progress.style.width || '0') / Number.parseFloat(container.style.width || '100');
      if (Math.abs(precent - prevPrecent) <= 1) {
        progress.style.width = player.currentTime * 100 / player.duration + '%';
      }
    }
  };
  player.on('timeupdate', onTimeupdate);

  var onCurrentTimeChange = function onCurrentTimeChange() {
    progress.style.width = player.currentTime * 100 / player.duration + '%';
  };
  player.on('currentTimeChange', onCurrentTimeChange);

  var onSrcChange = function onSrcChange() {
    progress.style.width = '0%';
  };
  player.on('srcChange', onSrcChange);

  var onCacheUpdate = function onCacheUpdate() {
    var buffered = player.buffered;
    if (buffered && buffered.length > 0) {
      var end = buffered.end(buffered.length - 1);
      for (var i = 0, len = buffered.length; i < len; i++) {
        if (player.currentTime >= buffered.start(i) && player.currentTime <= buffered.end(i)) {
          end = buffered.end(i);
          for (var j = i + 1; j < buffered.length; j++) {
            if (buffered.start(j) - buffered.end(j - 1) >= 2) {
              end = buffered.end(j - 1);
              break;
            }
          }
          break;
        }
      }
      cache.style.width = end / player.duration * 100 + '%';
    }
  };
  var cacheUpdateEvents = ['bufferedChange', 'cacheupdate', 'ended', 'timeupdate'];
  cacheUpdateEvents.forEach(function (item) {
    player.on(item, onCacheUpdate);
  });

  function destroyFunc() {
    player.removeAllProgressDot();
    player.off('canplay', onCanplay);
    player.off('timeupdate', onTimeupdate);
    player.off('currentTimeChange', onCurrentTimeChange);
    player.off('srcChange', onSrcChange);
    cacheUpdateEvents.forEach(function (item) {
      player.off(item, onCacheUpdate);
    });
    player.off('destroy', destroyFunc);
  }
  player.once('destroy', destroyFunc);
};

_player2.default.install('s_progress', s_progress);

/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_time = function s_time() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var container = util.createDom('xg-time', '<span class="xgplayer-time-current">' + (player.currentTime || util.format(0)) + '</span>\n                                           <span>' + (player.duration || util.format(0)) + '</span>', {}, 'xgplayer-time');
  player.once('ready', function () {
    player.controls.appendChild(container);
  });
  var onTimeChange = function onTimeChange() {
    // let liveText = player.lang.LIVE
    // if(player.duration === Infinity) {
    //   util.addClass(player.root, 'xgplayer-is-live')
    //   if(!util.findDom(player.root, '.xgplayer-live')) {
    //     const live = util.createDom('xg-live', liveText, {}, 'xgplayer-live')
    //     player.controls.appendChild(live)
    //   }
    // }
    if (player.videoConfig.mediaType !== 'audio' || !player.isProgressMoving || !player.dash) {
      container.innerHTML = '<span class="xgplayer-time-current">' + util.format(player.currentTime || 0) + '</span>' + ('<span>' + util.format(player.duration) + '</span>');
    }
  };
  player.on('durationchange', onTimeChange);
  player.on('timeupdate', onTimeChange);

  function onDestroy() {
    player.off('durationchange', onTimeChange);
    player.off('timeupdate', onTimeChange);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('s_time', s_time);

/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _replay = __webpack_require__(90);

var _replay2 = _interopRequireDefault(_replay);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_replay = function s_replay() {
  var player = this;
  var util = _player2.default.util;
  var root = player.root;

  var replayText = player.lang.REPLAY;
  var btn = util.createDom('xg-replay', _replay2.default + '\n                                         <xg-replay-txt class="xgplayer-replay-txt">' + replayText + '</xg-replay-txt>\n                                        ', {}, 'xgplayer-replay');
  player.once('ready', function () {
    root.appendChild(btn);
  });

  function onEnded() {
    var path = btn.querySelector('path');
    if (path) {
      var transform = window.getComputedStyle(path).getPropertyValue('transform');
      if (typeof transform === 'string' && transform.indexOf('none') > -1) {
        return;
      } else {
        path.setAttribute('transform', transform);
      }
    }
  }
  player.on('ended', onEnded);

  var svg = btn.querySelector('svg');

  ['click', 'touchend'].forEach(function (item) {
    svg.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('replayBtnClick');
    });
  });

  function destroyFunc() {
    player.off('ended', onEnded);
    player.off('destroy', destroyFunc);
  }
  player.once('destroy', destroyFunc);
};

_player2.default.install('s_replay', s_replay);

/***/ }),
/* 90 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg class=\"xgplayer-replay-svg\" xmlns=\"http://www.w3.org/2000/svg\" width=\"78\" height=\"78\" viewbox=\"0 0 78 78\">\n  <path d=\"M8.22708362,13.8757234 L11.2677371,12.6472196 C11.7798067,12.4403301 12.3626381,12.6877273 12.5695276,13.1997969 L12.9441342,14.1269807 C13.1510237,14.6390502 12.9036264,15.2218816 12.3915569,15.4287712 L6.8284538,17.6764107 L5.90126995,18.0510173 C5.38920044,18.2579068 4.80636901,18.0105096 4.5994795,17.49844 L1.97723335,11.0081531 C1.77034384,10.4960836 2.0177411,9.91325213 2.52981061,9.70636262 L3.45699446,9.33175602 C3.96906396,9.12486652 4.5518954,9.37226378 4.75878491,9.88433329 L5.67885163,12.1615783 C7.99551726,6.6766934 13.3983951,3 19.5,3 C27.7842712,3 34.5,9.71572875 34.5,18 C34.5,26.2842712 27.7842712,33 19.5,33 C15.4573596,33 11.6658607,31.3912946 8.87004692,28.5831991 C8.28554571,27.9961303 8.28762719,27.0463851 8.87469603,26.4618839 C9.46176488,25.8773827 10.4115101,25.8794641 10.9960113,26.466533 C13.2344327,28.7147875 16.263503,30 19.5,30 C26.127417,30 31.5,24.627417 31.5,18 C31.5,11.372583 26.127417,6 19.5,6 C14.4183772,6 9.94214483,9.18783811 8.22708362,13.8757234 Z\"></path>\n</svg>\n");

/***/ }),
/* 91 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_playbackRate = function s_playbackRate() {
  var player = this;
  var sniffer = _player2.default.sniffer;
  var util = _player2.default.util;
  if (player.config.playbackRate) {
    player.config.playbackRate.sort(function (a, b) {
      return b - a;
    });
  } else {
    return false;
  }
  var container = util.createDom('xg-playbackrate', " ", {}, 'xgplayer-playbackrate');
  if (sniffer.device === 'mobile') {
    player.config.playbackRateActive = 'click';
  }

  var list = [];
  player.config.playbackRate.forEach(function (item) {
    list.push({ name: '' + item, rate: item + 'x', selected: false });
  });
  var selectedSpeed = 1;
  var tmp = ['<ul>'];
  list.forEach(function (item) {
    if (player.config.defaultPlaybackRate && player.config.defaultPlaybackRate.toString() === item.name) {
      item.selected = true;
      selectedSpeed = player.config.defaultPlaybackRate;
      player.once('playing', function () {
        player.video.playbackRate = player.config.defaultPlaybackRate;
      });
    } else if (item.name === '1.0' || item.name === '1') {
      if (!player.config.defaultPlaybackRate || player.config.defaultPlaybackRate === 1) {
        item.selected = true;
      }
    }
    tmp.push('<li cname=\'' + item.name + '\' class=\'' + (item.selected ? 'selected' : '') + '\'>' + item.rate + '</li>');
  });
  tmp.push('</ul><p class=\'name\'>' + selectedSpeed + 'x</p>');
  var playbackDom = player.root.querySelector('.xgplayer-playbackrate');
  if (playbackDom) {
    playbackDom.innerHTML = tmp.join('');
    var cur = playbackDom.querySelector('.name');
    if (!player.config.playbackRateActive || player.config.playbackRateActive === 'hover') {
      cur.addEventListener('mouseenter', function (e) {
        e.preventDefault();
        e.stopPropagation();
        util.addClass(player.root, 'xgplayer-playbackrate-active');
        playbackDom.focus();
      });
    }
  } else {
    container.innerHTML = tmp.join('');
    var _cur = container.querySelector('.name');
    if (!player.config.playbackRateActive || player.config.playbackRateActive === 'hover') {
      _cur.addEventListener('mouseenter', function (e) {
        e.preventDefault();
        e.stopPropagation();
        util.addClass(player.root, 'xgplayer-playbackrate-active');
        container.focus();
      });
    }
    player.once('ready', function () {
      player.controls.appendChild(container);
    });
  }

  var ev = ['touchend', 'click'];
  ev.forEach(function (item) {
    container.addEventListener(item, function (e) {
      e.stopPropagation();
      e.preventDefault();
      var li = e.target;
      if (li && li.tagName.toLocaleLowerCase() === 'li') {
        var from = void 0,
            to = void 0;
        list.forEach(function (item) {
          item.selected = false;
          if (li.textContent.replace(/\s+/g, "") === item.rate) {
            Array.prototype.forEach.call(li.parentNode.childNodes, function (item) {
              if (util.hasClass(item, 'selected')) {
                from = parseFloat(item.getAttribute('cname'));
                util.removeClass(item, 'selected');
              }
            });
            item.selected = true;
            player.video.playbackRate = item.name * 1;
            selectedSpeed = item.name * 1;
          }
        });
        util.addClass(li, 'selected');
        to = parseFloat(li.getAttribute('cname'));
        li.parentNode.nextSibling.innerHTML = li.getAttribute('cname') + 'x';
        player.emit('playbackrateChange', { from: from, to: to });
        if (sniffer.device === 'mobile') {
          util.removeClass(player.root, 'xgplayer-playbackrate-active');
        }
      } else if (player.config.playbackRateActive === 'click' && li && (li.tagName.toLocaleLowerCase() === 'p' || li.tagName.toLocaleLowerCase() === 'span')) {
        if (sniffer.device === 'mobile') {
          util.toggleClass(player.root, 'xgplayer-playbackrate-active');
        } else {
          util.addClass(player.root, 'xgplayer-playbackrate-active');
        }
        container.focus();
      }
      player.emit('focus');
    }, false);
  });
  container.addEventListener('mouseleave', function (e) {
    e.preventDefault();
    e.stopPropagation();
    util.removeClass(player.root, 'xgplayer-playbackrate-active');
  });

  function onBlur() {
    util.removeClass(player.root, 'xgplayer-playbackrate-active');
  }
  player.on('blur', onBlur);

  player.on('play', function () {
    if (player.video.playbackRate.toFixed(1) !== selectedSpeed.toFixed(1)) {
      player.video.playbackRate = selectedSpeed;
    }
  });
};

_player2.default.install('s_playbackRate', s_playbackRate);

/***/ }),
/* 92 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_localPreview = function s_localPreview() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  if (player.config.preview && player.config.preview.uploadEl) {
    var preview = util.createDom('xg-preview', '<input type="file">', {}, 'xgplayer-preview');
    var upload = preview.querySelector('input');
    player.config.preview.uploadEl.appendChild(preview);
    upload.onchange = function () {
      player.emit('upload', upload);
    };
  }
};

_player2.default.install('s_localPreview', s_localPreview);

/***/ }),
/* 93 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _download = __webpack_require__(94);

var _download2 = _interopRequireDefault(_download);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_download = function s_download() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.download) {
    return;
  }
  var btn = util.createDom('xg-download', '<xg-icon class="xgplayer-icon">' + _download2.default + '</xg-icon>', {}, 'xgplayer-download');

  var tipsText = player.lang.DOWNLOAD_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-download">' + tipsText + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('downloadBtnClick');
    });
  });
};

_player2.default.install('s_download', s_download);

/***/ }),
/* 94 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\">\n  <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">\n    <g transform=\"translate(-488.000000, -340.000000)\" fill=\"#FFFFFF\">\n      <g id=\"Group-2\">\n        <g id=\"volme_big-copy\" transform=\"translate(488.000000, 340.000000)\">\n          <rect id=\"Rectangle-18\" x=\"11\" y=\"4\" width=\"2\" height=\"12\" rx=\"1\"></rect>\n          <rect id=\"Rectangle-2\" x=\"3\" y=\"18\" width=\"18\" height=\"2\" rx=\"1\"></rect>\n          <rect id=\"Rectangle-2\" transform=\"translate(4.000000, 17.500000) rotate(90.000000) translate(-4.000000, -17.500000) \" x=\"1.5\" y=\"16.5\" width=\"5\" height=\"2\" rx=\"1\"></rect><rect id=\"Rectangle-2-Copy-3\" transform=\"translate(20.000000, 17.500000) rotate(90.000000) translate(-20.000000, -17.500000) \" x=\"17.5\" y=\"16.5\" width=\"5\" height=\"2\" rx=\"1\"></rect>\n          <path d=\"M9.48791171,8.26502656 L9.48791171,14.2650266 C9.48791171,14.8173113 9.04019646,15.2650266 8.48791171,15.2650266 C7.93562696,15.2650266 7.48791171,14.8173113 7.48791171,14.2650266 L7.48791171,7.26502656 C7.48791171,6.71274181 7.93562696,6.26502656 8.48791171,6.26502656 L15.4879117,6.26502656 C16.0401965,6.26502656 16.4879117,6.71274181 16.4879117,7.26502656 C16.4879117,7.81731131 16.0401965,8.26502656 15.4879117,8.26502656 L9.48791171,8.26502656 Z\" id=\"Combined-Shape\" transform=\"translate(11.987912, 10.765027) scale(1, -1) rotate(45.000000) translate(-11.987912, -10.765027) \"></path>\n        </g>\n      </g>\n    </g>\n  </g>\n</svg>\n");

/***/ }),
/* 95 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _danmu = __webpack_require__(96);

var _danmu2 = _interopRequireDefault(_danmu);

var _panel = __webpack_require__(98);

var _panel2 = _interopRequireDefault(_panel);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_danmu = function s_danmu() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  if (!player.config.danmu) {
    return;
  }
  var container = util.createDom('xg-danmu', '', {}, 'xgplayer-danmu');
  player.once('ready', function () {
    root.appendChild(container);
  });
  var config = util.deepCopy({
    container: container,
    player: player.video,
    comments: [],
    area: {
      start: 0,
      end: 1
    }
  }, player.config.danmu);
  var panelBtn = void 0;
  if (player.config.danmu.panel) {
    panelBtn = _player2.default.util.createDom('xg-panel', '<xg-panel-icon class="xgplayer-panel-icon">\n                                                ' + _panel2.default + '\n                                              </xg-panel-icon>\n                                              <xg-panel-slider class="xgplayer-panel-slider">\n                                                <xg-hidemode class="xgplayer-hidemode">\n                                                  <p class="xgplayer-hidemode-font">\u5C4F\u853D\u7C7B\u578B</p>\n                                                  <ul class="xgplayer-hidemode-radio">\n                                                    <li class="xgplayer-hidemode-scroll" id="false">\u6EDA\u52A8</li><li class="xgplayer-hidemode-top" id="false">\u9876\u90E8</li><li class="xgplayer-hidemode-bottom" id="false">\u5E95\u90E8</li><li class="xgplayer-hidemode-color" id="false">\u8272\u5F69</li>\n                                                  </ul>\n                                                </xg-hidemode>\n                                                <xg-transparency class="xgplayer-transparency">\n                                                  <span>\u4E0D\u900F\u660E\u5EA6</span>\n                                                  <input class="xgplayer-transparency-line xgplayer-transparency-color xgplayer-transparency-bar xgplayer-transparency-gradient" type="range" min="0" max="100" step="0.1" value="50"></input>\n                                                </xg-transparency>\n                                                <xg-showarea class="xgplayer-showarea">\n                                                  <div class="xgplayer-showarea-name">\u663E\u793A\u533A\u57DF</div>\n                                                  <div class="xgplayer-showarea-control">\n                                                    <div class="xgplayer-showarea-control-up">\n                                                      <span class="xgplayer-showarea-control-up-item xgplayer-showarea-onequarters">1/4</span>\n                                                      <span class="xgplayer-showarea-control-up-item xgplayer-showarea-twoquarters selected-color">1/2</span>\n                                                      <span class="xgplayer-showarea-control-up-item xgplayer-showarea-threequarters">3/4</span>\n                                                      <span class="xgplayer-showarea-control-up-item xgplayer-showarea-full">1</span>\n                                                    </div>\n                                                    <div class="xgplayer-showarea-control-down">\n                                                      <div class="xgplayer-showarea-control-down-dots">\n                                                        <span class="xgplayer-showarea-onequarters-dot"></span>\n                                                        <span class="xgplayer-showarea-twoquarters-dot"></span>\n                                                        <span class="xgplayer-showarea-threequarters-dot"></span>\n                                                        <span class="xgplayer-showarea-full-dot"></span>\n                                                      </div>\n                                                      <input class="xgplayer-showarea-line xgplayer-showarea-color xgplayer-showarea-bar xgplayer-gradient" type="range" min="1" max="4" step="1" value="1">\n                                                    </div>\n                                                  </div>\n                                                </xg-showarea>\n                                                <xg-danmuspeed class="xgplayer-danmuspeed">\n                                                  <div class="xgplayer-danmuspeed-name">\u5F39\u5E55\u901F\u5EA6</div>\n                                                  <div class="xgplayer-danmuspeed-control">\n                                                    <div class="xgplayer-danmuspeed-control-up">\n                                                      <span class="xgplayer-danmuspeed-control-up-item xgplayer-danmuspeed-small">\u6162</span>\n                                                      <span class="xgplayer-danmuspeed-control-up-item xgplayer-danmuspeed-middle selected-color">\u4E2D</span>\n                                                      <span class="xgplayer-danmuspeed-control-up-item xgplayer-danmuspeed-large">\u5FEB</span>\n                                                    </div>\n                                                    <div class="xgplayer-danmuspeed-control-down">\n                                                      <div class="xgplayer-danmuspeed-control-down-dots">\n                                                        <span class="xgplayer-danmuspeed-small-dot"></span>\n                                                        <span class="xgplayer-danmuspeed-middle-dot"></span>\n                                                        <span class="xgplayer-danmuspeed-large-dot"></span>\n                                                      </div>\n                                                      <input class="xgplayer-danmuspeed-line xgplayer-danmuspeed-color xgplayer-danmuspeed-bar xgplayer-gradient" type="range" min="50" max="150" step="50" value="100">\n                                                    </div>\n                                                  </div>\n                                                </xg-danmuspeed>\n                                                <xg-danmufont class="xgplayer-danmufont">\n                                                  <div class="xgplayer-danmufont-name">\u5B57\u4F53\u5927\u5C0F</div>\n                                                  <div class="xgplayer-danmufont-control">\n                                                    <div class="xgplayer-danmufont-control-up">\n                                                      <span class="xgplayer-danmufont-control-up-item xgplayer-danmufont-small">\u5C0F</span>\n                                                      <span class="xgplayer-danmufont-control-up-item xgplayer-danmufont-middle">\u4E2D</span>\n                                                      <span class="xgplayer-danmufont-control-up-item xgplayer-danmufont-large selected-color">\u5927</span>\n                                                    </div>\n                                                    <div class="xgplayer-danmufont-control-down">\n                                                      <div class="xgplayer-danmufont-control-down-dots">\n                                                        <span class="xgplayer-danmufont-small-dot"></span>\n                                                        <span class="xgplayer-danmufont-middle-dot"></span>\n                                                        <span class="xgplayer-danmufont-large-dot"></span>\n                                                      </div>\n                                                      <input class="xgplayer-danmufont-line xgplayer-danmufont-color xgplayer-danmufont-bar xgplayer-gradient" type="range" min="20" max="30" step="5" value="25">\n                                                    </div>\n                                                  </div>\n                                                </xg-danmufont>\n                                              </xg-panel-slider>', { tabindex: 7 }, 'xgplayer-panel');
    player.once('ready', function () {
      player.controls.appendChild(panelBtn);
    });
  }
  player.once('complete', function () {
    var danmujs = new _danmu2.default(config);
    player.emit('initDefaultDanmu', danmujs);
    player.danmu = danmujs;

    if (!player.config.danmu.panel) {
      return;
    }

    var slider = panelBtn.querySelector('.xgplayer-panel-slider');
    var focusStatus = void 0;
    var focusarray = ['mouseenter', 'touchend', 'click'];
    focusarray.forEach(function (item) {
      panelBtn.addEventListener(item, function (e) {
        e.preventDefault();
        e.stopPropagation();
        _player2.default.util.addClass(slider, 'xgplayer-panel-active');
        panelBtn.focus();
        focusStatus = true;
      });
    });
    panelBtn.addEventListener('mouseleave', function (e) {
      e.preventDefault();
      e.stopPropagation();
      _player2.default.util.removeClass(slider, 'xgplayer-panel-active');
      focusStatus = false;
    });
    slider.addEventListener('mouseleave', function (e) {
      e.preventDefault();
      e.stopPropagation();
      if (focusStatus === false) {
        _player2.default.util.removeClass(slider, 'xgplayer-panel-active');
      }
    });

    var danmuConfig = player.config.danmu;
    var hidemodeScroll = panelBtn.querySelector('.xgplayer-hidemode-scroll');
    var hidemodeTop = panelBtn.querySelector('.xgplayer-hidemode-top');
    var hidemodeBottom = panelBtn.querySelector('.xgplayer-hidemode-bottom');
    var hidemodeColor = panelBtn.querySelector('.xgplayer-hidemode-color');
    var hidemodeArray = {
      'scroll': hidemodeScroll,
      'top': hidemodeTop,
      'bottom': hidemodeBottom,
      'color': hidemodeColor
    };

    var _loop = function _loop(key) {
      var keys = key;
      var ev = ['touchend', 'click'];
      ev.forEach(function (item) {
        hidemodeArray[keys].addEventListener(item, function (e) {
          if (hidemodeArray[keys].getAttribute('id') !== 'true') {
            hidemodeArray[keys].style.color = '#f85959';
            hidemodeArray[keys].setAttribute('id', 'true');
            player.danmu.hide(keys);
          } else {
            hidemodeArray[keys].style.color = '#aaa';
            hidemodeArray[keys].setAttribute('id', 'false');
            player.danmu.show(keys);
          }
        });
      });
    };

    for (var key in hidemodeArray) {
      _loop(key);
    }
    var transparency = panelBtn.querySelector('.xgplayer-transparency-line');
    var transparencyGradient = panelBtn.querySelector('.xgplayer-transparency-gradient');
    var transparencyValue = 50;
    transparencyGradient.style.background = 'linear-gradient(to right, #f85959 0%, #f85959 ' + transparencyValue + '%, #aaa ' + transparencyValue + '%, #aaa)';
    transparency.addEventListener('input', function (e) {
      e.preventDefault();
      e.stopPropagation();
      transparencyValue = e.target.value;
      transparencyGradient.style.background = 'linear-gradient(to right, #f85959 0%, #f85959 ' + transparencyValue + '%, #aaa ' + transparencyValue + '%, #aaa)';
      danmuConfig.comments.forEach(function (item) {
        item.style.opacity = transparencyValue / 100;
      });
    });
    var showarea = panelBtn.querySelector('.xgplayer-showarea-line');
    showarea.addEventListener('input', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var showareaValue = e.target.value;
      player.danmu.config.area.end = showareaValue / 100;
      player.config.danmu.area.end = showareaValue / 100;
      player.danmu.bulletBtn.main.channel.resize();
    });
    var danmuspeed = panelBtn.querySelector('.xgplayer-danmuspeed-line');
    danmuspeed.addEventListener('input', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var danmuspeedValue = e.target.value;
      danmuConfig.comments.forEach(function (item) {
        item.duration = (200 - danmuspeedValue) * 100;
      });
    });
    var danmufont = panelBtn.querySelector('.xgplayer-danmufont-line');
    danmufont.addEventListener('input', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var danmufontValue = e.target.value;
      danmuConfig.comments.forEach(function (item) {
        item.style.fontSize = danmufontValue + 'px';
      });
    });
    if (navigator.userAgent.indexOf("Firefox") > -1) {
      for (var i = 0; i < slider.querySelectorAll('input').length; i++) {
        slider.querySelectorAll('input')[i].style.marginTop = '10px';
      }
    }
  });
};

_player2.default.install('s_danmu', s_danmu);

/***/ }),
/* 96 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(module) {var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

!function (t, e) {
  "object" == ( false ? undefined : _typeof(exports)) && "object" == ( false ? undefined : _typeof(module)) ? module.exports = e() :  true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (e),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(window, function () {
  return function (t) {
    var e = {};function n(i) {
      if (e[i]) return e[i].exports;var o = e[i] = { i: i, l: !1, exports: {} };return t[i].call(o.exports, o, o.exports, n), o.l = !0, o.exports;
    }return n.m = t, n.c = e, n.d = function (t, e, i) {
      n.o(t, e) || Object.defineProperty(t, e, { enumerable: !0, get: i });
    }, n.r = function (t) {
      "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(t, "__esModule", { value: !0 });
    }, n.t = function (t, e) {
      if (1 & e && (t = n(t)), 8 & e) return t;if (4 & e && "object" == (typeof t === "undefined" ? "undefined" : _typeof(t)) && t && t.__esModule) return t;var i = Object.create(null);if (n.r(i), Object.defineProperty(i, "default", { enumerable: !0, value: t }), 2 & e && "string" != typeof t) for (var o in t) {
        n.d(i, o, function (e) {
          return t[e];
        }.bind(null, o));
      }return i;
    }, n.n = function (t) {
      var e = t && t.__esModule ? function () {
        return t.default;
      } : function () {
        return t;
      };return n.d(e, "a", e), e;
    }, n.o = function (t, e) {
      return Object.prototype.hasOwnProperty.call(t, e);
    }, n.p = "", n(n.s = 2);
  }([function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i,
        o = n(22),
        r = (i = o) && i.__esModule ? i : { default: i };var a = {};a.domObj = new r.default(), a.createDom = function () {
      var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "div",
          e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "",
          n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {},
          i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : "",
          o = document.createElement(t);return o.className = i, o.innerHTML = e, Object.keys(n).forEach(function (e) {
        var i = e,
            r = n[e];"video" === t || "audio" === t ? r && o.setAttribute(i, r) : o.setAttribute(i, r);
      }), o;
    }, a.hasClass = function (t, e) {
      return t.classList ? Array.prototype.some.call(t.classList, function (t) {
        return t === e;
      }) : !!t.className.match(new RegExp("(\\s|^)" + e + "(\\s|$)"));
    }, a.addClass = function (t, e) {
      t.classList ? e.replace(/(^\s+|\s+$)/g, "").split(/\s+/g).forEach(function (e) {
        e && t.classList.add(e);
      }) : a.hasClass(t, e) || (t.className += " " + e);
    }, a.removeClass = function (t, e) {
      t.classList ? e.split(/\s+/g).forEach(function (e) {
        t.classList.remove(e);
      }) : a.hasClass(t, e) && e.split(/\s+/g).forEach(function (e) {
        var n = new RegExp("(\\s|^)" + e + "(\\s|$)");t.className = t.className.replace(n, " ");
      });
    }, a.toggleClass = function (t, e) {
      e.split(/\s+/g).forEach(function (e) {
        a.hasClass(t, e) ? a.removeClass(t, e) : a.addClass(t, e);
      });
    }, a.findDom = function () {
      var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : document,
          e = arguments[1],
          n = void 0;try {
        n = t.querySelector(e);
      } catch (i) {
        e.startsWith("#") && (n = t.getElementById(e.slice(1)));
      }return n;
    }, a.deepCopy = function (t, e) {
      if ("Object" === a.typeOf(e) && "Object" === a.typeOf(t)) return Object.keys(e).forEach(function (n) {
        "Object" !== a.typeOf(e[n]) || e[n] instanceof Node ? "Array" === a.typeOf(e[n]) ? t[n] = "Array" === a.typeOf(t[n]) ? t[n].concat(e[n]) : e[n] : t[n] = e[n] : t[n] ? a.deepCopy(t[n], e[n]) : t[n] = e[n];
      }), t;
    }, a.typeOf = function (t) {
      return Object.prototype.toString.call(t).match(/([^\s.*]+)(?=]$)/g)[0];
    }, a.copyDom = function (t) {
      if (t && 1 === t.nodeType) {
        var e = document.createElement(t.tagName);return Array.prototype.forEach.call(t.attributes, function (t) {
          e.setAttribute(t.name, t.value);
        }), t.innerHTML && (e.innerHTML = t.innerHTML), e;
      }return "";
    }, a.formatTime = function (t) {
      var e = Math.floor(t);return 1e3 * e + (t - e);
    }, e.default = a, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    var i = n(13)();t.exports = function (t) {
      return t !== i && null !== t;
    };
  }, function (t, e, n) {
    t.exports = n(3);
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i,
        o = n(4),
        r = (i = o) && i.__esModule ? i : { default: i };n(26), e.default = r.default, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }(),
        o = s(n(5)),
        r = s(n(21)),
        a = s(n(0));function s(t) {
      return t && t.__esModule ? t : { default: t };
    }var c = function () {
      function t(e) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), this.config = a.default.deepCopy({ overlap: !1, area: { start: 0, end: 1 }, live: !1, comments: [], direction: "r2l" }, e), this.hideArr = [], (0, o.default)(this);var n = this;if (this.config.comments.forEach(function (t) {
          t.duration = t.duration < 5e3 ? 5e3 : t.duration, t.mode || (t.mode = "scroll");
        }), !this.config.container || 1 !== this.config.container.nodeType) return this.emit("error", "container id can't be empty"), !1;if (this.container = this.config.container, this.config.containerStyle) {
          var i = this.config.containerStyle;Object.keys(i).forEach(function (t) {
            n.container.style[t] = i[t];
          });
        }this.live = this.config.live, this.player = this.config.player, this.direction = this.config.direction, a.default.addClass(this.container, "danmu"), this.bulletBtn = new r.default(this), this.emit("ready");
      }return i(t, [{ key: "start", value: function value() {
          this.bulletBtn.main.start();
        } }, { key: "pause", value: function value() {
          this.bulletBtn.main.pause();
        } }, { key: "play", value: function value() {
          this.bulletBtn.main.play();
        } }, { key: "stop", value: function value() {
          this.bulletBtn.main.stop();
        } }, { key: "sendComment", value: function value(t) {
          t && t.id && t.duration && (t.el || t.txt) && (t.duration = t.duration < 5e3 ? 5e3 : t.duration, this.bulletBtn.main.data.push(t));
        } }, { key: "setCommentID", value: function value(t, e) {
          var n = this.container.getBoundingClientRect();t && e && (this.bulletBtn.main.data.some(function (n) {
            return n.id === t && (n.id = e, !0);
          }), this.bulletBtn.main.queue.some(function (i) {
            return i.id === t && (i.id = e, i.pauseMove(n), i.startMove(n), !0);
          }));
        } }, { key: "setCommentDuration", value: function value(t, e) {
          var n = this.container.getBoundingClientRect();t && e && (e = e < 5e3 ? 5e3 : e, this.bulletBtn.main.data.some(function (n) {
            return n.id === t && (n.duration = e, !0);
          }), this.bulletBtn.main.queue.some(function (i) {
            return i.id === t && (i.duration = e, i.pauseMove(n), i.startMove(n), !0);
          }));
        } }, { key: "setAllDuration", value: function value() {
          var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "scroll",
              e = arguments[1],
              n = this.container.getBoundingClientRect();e && (e = e < 5e3 ? 5e3 : e, this.bulletBtn.main.data.forEach(function (n) {
            t === n.mode && (n.duration = e);
          }), this.bulletBtn.main.queue.forEach(function (i) {
            t === i.mode && (i.duration = e, i.pauseMove(n), i.startMove(n));
          }));
        } }, { key: "hide", value: function value() {
          var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "scroll";this.hideArr.indexOf(t) < 0 && this.hideArr.push(t), this.bulletBtn.main.queue.filter(function (e) {
            return t === e.mode || "color" === t && e.color;
          }).forEach(function (t) {
            return t.remove();
          });
        } }, { key: "show", value: function value() {
          var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "scroll",
              e = this.hideArr.indexOf(t);e > -1 && this.hideArr.splice(e, 1);
        } }, { key: "setDirection", value: function value() {
          var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "r2l";this.emit("changeDirection", t);
        } }]), t;
    }();e.default = c, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    var i,
        o,
        r,
        a,
        s,
        c,
        u,
        l = n(6),
        h = n(20),
        f = Function.prototype.apply,
        d = Function.prototype.call,
        p = Object.create,
        m = Object.defineProperty,
        g = Object.defineProperties,
        v = Object.prototype.hasOwnProperty,
        b = { configurable: !0, enumerable: !1, writable: !0 };o = function o(t, e) {
      var _n, o;return h(e), o = this, i.call(this, t, _n = function n() {
        r.call(o, t, _n), f.call(e, this, arguments);
      }), _n.__eeOnceListener__ = e, this;
    }, s = { on: i = function i(t, e) {
        var n;return h(e), v.call(this, "__ee__") ? n = this.__ee__ : (n = b.value = p(null), m(this, "__ee__", b), b.value = null), n[t] ? "object" == _typeof(n[t]) ? n[t].push(e) : n[t] = [n[t], e] : n[t] = e, this;
      }, once: o, off: r = function r(t, e) {
        var n, i, o, r;if (h(e), !v.call(this, "__ee__")) return this;if (!(n = this.__ee__)[t]) return this;if ("object" == _typeof(i = n[t])) for (r = 0; o = i[r]; ++r) {
          o !== e && o.__eeOnceListener__ !== e || (2 === i.length ? n[t] = i[r ? 0 : 1] : i.splice(r, 1));
        } else i !== e && i.__eeOnceListener__ !== e || delete n[t];return this;
      }, emit: a = function a(t) {
        var e, n, i, o, r;if (v.call(this, "__ee__") && (o = this.__ee__[t])) if ("object" == (typeof o === "undefined" ? "undefined" : _typeof(o))) {
          for (n = arguments.length, r = new Array(n - 1), e = 1; e < n; ++e) {
            r[e - 1] = arguments[e];
          }for (o = o.slice(), e = 0; i = o[e]; ++e) {
            f.call(i, this, r);
          }
        } else switch (arguments.length) {case 1:
            d.call(o, this);break;case 2:
            d.call(o, this, arguments[1]);break;case 3:
            d.call(o, this, arguments[1], arguments[2]);break;default:
            for (n = arguments.length, r = new Array(n - 1), e = 1; e < n; ++e) {
              r[e - 1] = arguments[e];
            }f.call(o, this, r);}
      } }, c = { on: l(i), once: l(o), off: l(r), emit: l(a) }, u = g({}, c), t.exports = e = function e(t) {
      return null == t ? p(u) : g(Object(t), c);
    }, e.methods = s;
  }, function (t, e, n) {
    "use strict";
    var i = n(7),
        o = n(15),
        r = n(16),
        a = n(17);(t.exports = function (t, e) {
      var n, r, s, c, u;return arguments.length < 2 || "string" != typeof t ? (c = e, e = t, t = null) : c = arguments[2], null == t ? (n = s = !0, r = !1) : (n = a.call(t, "c"), r = a.call(t, "e"), s = a.call(t, "w")), u = { value: e, configurable: n, enumerable: r, writable: s }, c ? i(o(c), u) : u;
    }).gs = function (t, e, n) {
      var s, c, u, l;return "string" != typeof t ? (u = n, n = e, e = t, t = null) : u = arguments[3], null == e ? e = void 0 : r(e) ? null == n ? n = void 0 : r(n) || (u = n, n = void 0) : (u = e, e = n = void 0), null == t ? (s = !0, c = !1) : (s = a.call(t, "c"), c = a.call(t, "e")), l = { get: e, set: n, configurable: s, enumerable: c }, u ? i(o(u), l) : l;
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = n(8)() ? Object.assign : n(9);
  }, function (t, e, n) {
    "use strict";
    t.exports = function () {
      var t,
          e = Object.assign;return "function" == typeof e && (e(t = { foo: "raz" }, { bar: "dwa" }, { trzy: "trzy" }), t.foo + t.bar + t.trzy === "razdwatrzy");
    };
  }, function (t, e, n) {
    "use strict";
    var i = n(10),
        o = n(14),
        r = Math.max;t.exports = function (t, e) {
      var n,
          a,
          s,
          c = r(arguments.length, 2);for (t = Object(o(t)), s = function s(i) {
        try {
          t[i] = e[i];
        } catch (t) {
          n || (n = t);
        }
      }, a = 1; a < c; ++a) {
        e = arguments[a], i(e).forEach(s);
      }if (void 0 !== n) throw n;return t;
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = n(11)() ? Object.keys : n(12);
  }, function (t, e, n) {
    "use strict";
    t.exports = function () {
      try {
        return Object.keys("primitive"), !0;
      } catch (t) {
        return !1;
      }
    };
  }, function (t, e, n) {
    "use strict";
    var i = n(1),
        o = Object.keys;t.exports = function (t) {
      return o(i(t) ? Object(t) : t);
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = function () {};
  }, function (t, e, n) {
    "use strict";
    var i = n(1);t.exports = function (t) {
      if (!i(t)) throw new TypeError("Cannot use null or undefined");return t;
    };
  }, function (t, e, n) {
    "use strict";
    var i = n(1),
        o = Array.prototype.forEach,
        r = Object.create;t.exports = function (t) {
      var e = r(null);return o.call(arguments, function (t) {
        i(t) && function (t, e) {
          var n;for (n in t) {
            e[n] = t[n];
          }
        }(Object(t), e);
      }), e;
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = function (t) {
      return "function" == typeof t;
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = n(18)() ? String.prototype.contains : n(19);
  }, function (t, e, n) {
    "use strict";
    var i = "razdwatrzy";t.exports = function () {
      return "function" == typeof i.contains && !0 === i.contains("dwa") && !1 === i.contains("foo");
    };
  }, function (t, e, n) {
    "use strict";
    var i = String.prototype.indexOf;t.exports = function (t) {
      return i.call(this, t, arguments[1]) > -1;
    };
  }, function (t, e, n) {
    "use strict";
    t.exports = function (t) {
      if ("function" != typeof t) throw new TypeError(t + " is not a function");return t;
    };
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }(),
        o = a(n(0)),
        r = a(n(23));function a(t) {
      return t && t.__esModule ? t : { default: t };
    }var s = function () {
      function t(e) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), this.danmu = e, this.main = new r.default(e), e.config.defaultOff || this.main.start();
      }return i(t, [{ key: "createSwitch", value: function value() {
          var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];return this.switchBtn = o.default.createDom("dk-switch", '<span class="txt">弹</span>', {}, "danmu-switch " + (t ? "danmu-switch-active" : "")), this.switchBtn;
        } }]), t;
    }();e.default = s, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }();var o = function () {
      function t(e) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), e = { initDOM: function initDOM() {
            return document.createElement("div");
          }, initSize: 10 }, this.init(e);
      }return i(t, [{ key: "init", value: function value(t) {
          this.idleList = [], this.usingList = [], this._id = 0, this.options = t, this._expand(t.initSize);
        } }, { key: "use", value: function value() {
          this.idleList.length || this._expand(1);var t = this.idleList.shift();return this.usingList.push(t), t;
        } }, { key: "unuse", value: function value(t) {
          var e = this.usingList.indexOf(t);e < 0 || (this.usingList.splice(e, 1), t.innerHTML = "", t.textcontent = "", t.style = "", this.idleList.push(t));
        } }, { key: "_expand", value: function value(t) {
          for (var e = 0; e < t; e++) {
            this.idleList.push(this.options.initDOM(this._id++));
          }
        } }]), t;
    }();e.default = o, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }(),
        o = s(n(24)),
        r = s(n(25)),
        a = s(n(0));function s(t) {
      return t && t.__esModule ? t : { default: t };
    }var c = function () {
      function t(e) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), this.danmu = e, this.container = e.container, this.channel = new o.default(e), this.data = [].concat(e.config.comments), this.queue = [], this.timer = null, this.retryTimer = null, this.interval = 2e3, this.status = "idle", e.on("bullet_remove", this.updateQueue.bind(this));var n = this;this.danmu.on("changeDirection", function (t) {
          n.danmu.direction = t;
        });
      }return i(t, [{ key: "updateQueue", value: function value(t) {
          var e = this;e.queue.some(function (n, i) {
            return n.id === t.bullet.id && (e.queue.splice(i, 1), !0);
          });
        } }, { key: "init", value: function value(t, e) {
          e || (e = this), e.data.sort(function (t, e) {
            return t.start - e.start;
          }), e.retryTimer || (e.retryTimer = setInterval(function () {
            e.readData(), e.dataHandle();
          }, e.interval - 1e3));
        } }, { key: "start", value: function value() {
          this.status = "playing", this.queue = [], this.container.innerHTML = "", this.channel.resetWithCb(this.init, this);
        } }, { key: "stop", value: function value() {
          this.status = "closed", clearInterval(this.retryTimer), this.retryTimer = null, this.channel.reset(), this.queue = [], this.container.innerHTML = "";
        } }, { key: "play", value: function value() {
          this.status = "playing";var t = this.channel.channels,
              e = this.danmu.container.getBoundingClientRect();t && t.length > 0 && ["scroll", "top", "bottom"].forEach(function (n) {
            for (var i = 0; i < t.length; i++) {
              t[i].queue[n].forEach(function (t) {
                t.resized || (t.startMove(e), t.resized = !0);
              });
            }for (var o = 0; o < t.length; o++) {
              t[o].queue[n].forEach(function (t) {
                t.resized = !1;
              });
            }
          });
        } }, { key: "pause", value: function value() {
          this.status = "paused";var t = this.channel.channels,
              e = this.danmu.container.getBoundingClientRect();t && t.length > 0 && ["scroll", "top", "bottom"].forEach(function (n) {
            for (var i = 0; i < t.length; i++) {
              t[i].queue[n].forEach(function (t) {
                t.pauseMove(e);
              });
            }
          });
        } }, { key: "dataHandle", value: function value() {
          var t = this;"paused" !== this.status && "closed" !== this.status && t.queue.length && t.queue.forEach(function (e) {
            "waiting" !== e.status && "paused" !== e.status || e.startMove(t.channel.containerPos);
          });
        } }, { key: "readData", value: function value() {
          var t = this,
              e = this.danmu,
              n = 0;e.player && e.player.currentTime && (n = a.default.formatTime(e.player.currentTime));var i = void 0,
              o = t.interval,
              s = t.channel,
              c = void 0;e.player ? (c = t.data.filter(function (e) {
            return !e.start && t.danmu.hideArr.indexOf(e.mode) < 0 && (!e.color || t.danmu.hideArr.indexOf("color") < 0) && (e.start = n), t.danmu.hideArr.indexOf(e.mode) < 0 && (!e.color || t.danmu.hideArr.indexOf("color") < 0) && e.start - o <= n && n <= e.start + o;
          }), e.live && (t.data = t.data.filter(function (t) {
            return t.start || (t.start = n), t.start > n - 3 * o;
          }))) : c = t.data.filter(function (e) {
            return t.danmu.hideArr.indexOf(e.mode) < 0 && (!e.color || t.danmu.hideArr.indexOf("color") < 0);
          }), c.length > 0 && c.forEach(function (n) {
            (i = new r.default(e, n)).attach(), s.addBullet(i).result ? (t.queue.push(i), i.topInit()) : i.detach();
          });
        } }]), t;
    }();e.default = c, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }();var o = function () {
      function t(e) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), this.danmu = e, this.reset();var n = this;this.danmu.on("bullet_remove", function (t) {
          n.removeBullet(t.bullet);
        }), this.direction = e.direction, this.danmu.on("changeDirection", function (t) {
          n.direction = t;
        }), this.containerPos = this.danmu.container.getBoundingClientRect(), this.containerWidth = this.containerPos.width, this.containerHeight = this.containerPos.height, this.containerLeft = this.containerPos.left, this.containerRight = this.containerPos.right, this.danmu.bulletResizeTimer = setInterval(function () {
          n.containerPos = n.danmu.container.getBoundingClientRect(), (Math.abs(n.containerPos.width - n.containerWidth) >= 2 || Math.abs(n.containerPos.height - n.containerHeight) >= 2 || Math.abs(n.containerPos.left - n.containerLeft) >= 2 || Math.abs(n.containerPos.right - n.containerRight) >= 2) && (n.containerWidth = n.containerPos.width, n.containerHeight = n.containerPos.height, n.containerLeft = n.containerPos.left, n.containerRight = n.containerPos.right, n.resize(!0));
        }, 50);
      }return i(t, [{ key: "resize", value: function value() {
          var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
              e = this.danmu.container,
              n = this;setTimeout(function () {
            n.danmu.bulletBtn.main.data && n.danmu.bulletBtn.main.data.forEach(function (t) {
              t.bookChannelId && delete t.bookChannelId;
            });var i = e.getBoundingClientRect();n.width = i.width, n.height = i.height, n.danmu.config.area && n.danmu.config.area.start >= 0 && n.danmu.config.area.end >= n.danmu.config.area.start && ("b2t" === n.direction ? n.width = n.width * (n.danmu.config.area.end - n.danmu.config.area.start) : n.height = n.height * (n.danmu.config.area.end - n.danmu.config.area.start)), n.container = e;var o = /mobile/gi.test(navigator.userAgent) ? 10 : 12,
                r = void 0;r = "b2t" === n.direction ? Math.floor(n.width / o) : Math.floor(n.height / o);for (var a = [], s = 0; s < r; s++) {
              a[s] = { id: s, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} };
            }if (n.channels && n.channels.length <= a.length) {
              for (var c = function c(e) {
                a[e] = { id: e, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} }, ["scroll", "top"].forEach(function (i) {
                  n.channels[e].queue[i].forEach(function (o) {
                    o.el && (a[e].queue[i].push(o), o.resized || (o.pauseMove(n.containerPos, t), o.startMove(n.containerPos), o.resized = !0));
                  });
                }), n.channels[e].queue.bottom.forEach(function (i) {
                  if (i.el) {
                    if (a[e + a.length - n.channels.length].queue.bottom.push(i), i.channel_id[0] + i.channel_id[1] - 1 === e) {
                      var r = [].concat(i.channel_id);i.channel_id = [r[0] - n.channels.length + a.length, r[1]], i.top = i.channel_id[0] * o, n.danmu.config.area && n.danmu.config.area.start && (i.top += n.containerHeight * n.danmu.config.area.start), i.topInit();
                    }i.resized || (i.pauseMove(n.containerPos, t), i.startMove(n.containerPos), i.resized = !0);
                  }
                });
              }, u = 0; u < n.channels.length; u++) {
                c(u);
              }for (var l = function l(t) {
                ["scroll", "top", "bottom"].forEach(function (e) {
                  a[t].queue[e].forEach(function (t) {
                    t.resized = !1;
                  });
                });
              }, h = 0; h < a.length; h++) {
                l(h);
              }n.channels = a, "b2t" === n.direction ? n.channelWidth = o : n.channelHeight = o;
            } else if (n.channels && n.channels.length > a.length) {
              for (var f = function f(e) {
                a[e] = { id: e, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} }, ["scroll", "top", "bottom"].forEach(function (i) {
                  if ("top" === i && e > Math.floor(a.length / 2)) ;else if ("bottom" === i && e <= Math.floor(a.length / 2)) ;else {
                    var r = "bottom" === i ? e - a.length + n.channels.length : e;n.channels[r].queue[i].forEach(function (s, c) {
                      if (s.el) {
                        if (a[e].queue[i].push(s), "bottom" === i && s.channel_id[0] + s.channel_id[1] - 1 === r) {
                          var u = [].concat(s.channel_id);s.channel_id = [u[0] - n.channels.length + a.length, u[1]], s.top = s.channel_id[0] * o, n.danmu.config.area && n.danmu.config.area.start && (s.top += n.containerHeight * n.danmu.config.area.start), s.topInit();
                        }s.resized || (s.pauseMove(n.containerPos, t), s.startMove(n.containerPos), s.resized = !0);
                      }n.channels[r].queue[i].splice(c, 1);
                    });
                  }
                });
              }, d = 0; d < a.length; d++) {
                f(d);
              }for (var p = function p(t) {
                ["scroll", "top", "bottom"].forEach(function (e) {
                  n.channels[t].queue[e].forEach(function (t) {
                    t.pauseMove(n.containerPos), t.remove();
                  });
                });
              }, m = a.length; m < n.channels.length; m++) {
                p(m);
              }for (var g = function g(t) {
                ["scroll", "top", "bottom"].forEach(function (e) {
                  a[t].queue[e].forEach(function (t) {
                    t.resized = !1;
                  });
                });
              }, v = 0; v < a.length; v++) {
                g(v);
              }n.channels = a, "b2t" === n.direction ? n.channelWidth = o : n.channelHeight = o;
            }
          }, 10);
        } }, { key: "addBullet", value: function value(t) {
          var e = this.danmu,
              n = this.channels,
              i = void 0,
              o = void 0,
              r = void 0;if ("b2t" === this.direction ? (o = this.channelWidth, r = Math.ceil(t.width / o)) : (i = this.channelHeight, r = Math.ceil(t.height / i)), r > n.length) return { result: !1, message: "exceed channels.length, occupy=" + r + ",channelsSize=" + n.length };for (var a = !0, s = void 0, c = -1, u = 0, l = n.length; u < l; u++) {
            if (n[u].queue[t.mode].some(function (e) {
              return e.id === t.id;
            })) return { result: !1, message: "exsited, channelOrder=" + u + ",danmu_id=" + t.id };
          }if ("scroll" === t.mode) for (var h = 0, f = n.length - r; h <= f; h++) {
            a = !0;for (var d = h; d < h + r; d++) {
              if ((s = n[d]).operating.scroll) {
                a = !1;break;
              }if ((s.bookId.scroll || t.prior) && s.bookId.scroll !== t.id) {
                a = !1;break;
              }s.operating.scroll = !0;var p = s.queue.scroll[0];if (p) {
                var m = p.el.getBoundingClientRect();if ("b2t" === this.direction) {
                  if (m.bottom > this.containerPos.bottom) {
                    a = !1, s.operating.scroll = !1;break;
                  }
                } else if (m.right > this.containerPos.right) {
                  a = !1, s.operating.scroll = !1;break;
                }var g,
                    v = void 0,
                    b = void 0,
                    y = void 0,
                    w = void 0;if ("b2t" === this.direction ? (b = (m.top - this.containerPos.top + m.height) / (v = (this.containerPos.height + m.height) / p.duration), y = this.containerPos.height, w = (this.containerPos.height + t.height) / t.duration) : (b = (m.left - this.containerPos.left + m.width) / (v = (this.containerPos.width + m.width) / p.duration), y = this.containerPos.width, w = (this.containerPos.width + t.width) / t.duration), g = y / w, e.config.bOffset || (e.config.bOffset = 0), v < w && b + e.config.bOffset > g) {
                  a = !1, s.operating.scroll = !1;break;
                }
              }s.operating.scroll = !1;
            }if (a) {
              c = h;break;
            }
          } else if ("top" === t.mode) for (var x = 0, k = n.length - r; x <= k; x++) {
            a = !0;for (var _ = x; _ < x + r; _++) {
              if (_ > Math.floor(n.length / 2)) {
                a = !1;break;
              }if ((s = n[_]).operating[t.mode]) {
                a = !1;break;
              }if ((s.bookId[t.mode] || t.prior) && s.bookId[t.mode] !== t.id) {
                a = !1;break;
              }if (s.operating[t.mode] = !0, s.queue[t.mode].length > 0) {
                a = !1, s.operating[t.mode] = !1;break;
              }s.operating[t.mode] = !1;
            }if (a) {
              c = x;break;
            }
          } else if ("bottom" === t.mode) for (var M = n.length - r; M >= 0; M--) {
            a = !0;for (var O = M; O < M + r; O++) {
              if (O <= Math.floor(n.length / 2)) {
                a = !1;break;
              }if ((s = n[O]).operating[t.mode]) {
                a = !1;break;
              }if ((s.bookId[t.mode] || t.prior) && s.bookId[t.mode] !== t.id) {
                a = !1;break;
              }if (s.operating[t.mode] = !0, s.queue[t.mode].length > 0) {
                a = !1, s.operating[t.mode] = !1;break;
              }s.operating[t.mode] = !1;
            }if (a) {
              c = M;break;
            }
          }if (-1 !== c) {
            for (var C = c, j = c + r; C < j; C++) {
              (s = n[C]).operating[t.mode] = !0, s.queue[t.mode].unshift(t), t.prior && delete s.bookId[t.mode], s.operating[t.mode] = !1;
            }if (t.prior) delete t.bookChannelId, e.bulletBtn.main.data.some(function (e) {
              return e.id === t.id && (delete e.bookChannelId, !0);
            });return t.channel_id = [c, r], "b2t" === this.direction ? (t.top = c * o, this.danmu.config.area && this.danmu.config.area.start && (t.top += this.containerWidth * this.danmu.config.area.start)) : (t.top = c * i, this.danmu.config.area && this.danmu.config.area.start && (t.top += this.containerHeight * this.danmu.config.area.start)), { result: t, message: "success" };
          }if (t.prior) if (t.bookChannelId) {
            e.bulletBtn.main.data.some(function (e) {
              return e.id === t.id && (e.start += 2e3, !0);
            });
          } else {
            c = -1;for (var E = 0, P = n.length - r; E <= P; E++) {
              a = !0;for (var T = E; T < E + r; T++) {
                if (n[T].bookId[t.mode]) {
                  a = !1;break;
                }
              }if (a) {
                c = E;break;
              }
            }if (-1 !== c) {
              for (var B = c; B < c + r; B++) {
                n[B].bookId[t.mode] = t.id;
              }e.bulletBtn.main.data.some(function (e) {
                return e.id === t.id && (e.start += 2e3, e.bookChannelId = [c, r], !0);
              });
            }
          }return { result: !1, message: "no surplus will right" };
        } }, { key: "removeBullet", value: function value(t) {
          for (var e = this.channels, n = t.channel_id, i = void 0, o = n[0], r = n[0] + n[1]; o < r; o++) {
            if (i = e[o]) {
              i.operating[t.mode] = !0;var a = -1;i.queue[t.mode].some(function (e, n) {
                return e.id === t.id && (a = n, !0);
              }), a > -1 && i.queue[t.mode].splice(a, 1), i.operating[t.mode] = !1;
            }
          }
        } }, { key: "resetArea", value: function value() {
          var t = this.danmu.container,
              e = this,
              n = t.getBoundingClientRect();e.width = n.width, e.height = n.height, e.danmu.config.area && e.danmu.config.area.start >= 0 && e.danmu.config.area.end >= e.danmu.config.area.start && ("b2t" === e.direction ? e.width = e.width * (e.danmu.config.area.end - e.danmu.config.area.start) : e.height = e.height * (e.danmu.config.area.end - e.danmu.config.area.start)), e.container = t;var i = /mobile/gi.test(navigator.userAgent) ? 10 : 12,
              o = void 0;o = "b2t" === e.direction ? Math.floor(e.width / i) : Math.floor(e.height / i);for (var r = [], a = 0; a < o; a++) {
            r[a] = { id: a, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} };
          }if (e.channels && e.channels.length <= r.length) {
            for (var s = function s(t) {
              r[t] = { id: t, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} }, ["scroll", "top"].forEach(function (n) {
                e.channels[t].queue[n].forEach(function (i) {
                  i.el && (r[t].queue[n].push(i), i.resized || (i.pauseMove(e.containerPos, !1), i.startMove(e.containerPos), i.resized = !0));
                });
              }), e.channels[t].queue.bottom.forEach(function (n) {
                if (n.el) {
                  if (r[t + r.length - e.channels.length].queue.bottom.push(n), n.channel_id[0] + n.channel_id[1] - 1 === t) {
                    var o = [].concat(n.channel_id);n.channel_id = [o[0] - e.channels.length + r.length, o[1]], n.top = n.channel_id[0] * i, e.danmu.config.area && e.danmu.config.area.start && (n.top += e.containerHeight * e.danmu.config.area.start), n.topInit();
                  }n.resized || (n.pauseMove(e.containerPos, !1), n.startMove(e.containerPos), n.resized = !0);
                }
              });
            }, c = 0; c < e.channels.length; c++) {
              s(c);
            }for (var u = function u(t) {
              ["scroll", "top", "bottom"].forEach(function (e) {
                r[t].queue[e].forEach(function (t) {
                  t.resized = !1;
                });
              });
            }, l = 0; l < r.length; l++) {
              u(l);
            }e.channels = r, "b2t" === e.direction ? e.channelWidth = i : e.channelHeight = i;
          } else if (e.channels && e.channels.length > r.length) {
            for (var h = function h(t) {
              r[t] = { id: t, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} }, ["scroll", "top", "bottom"].forEach(function (n) {
                if ("top" === n && t > Math.floor(r.length / 2)) ;else if ("bottom" === n && t <= Math.floor(r.length / 2)) ;else {
                  var o = "bottom" === n ? t - r.length + e.channels.length : t;e.channels[o].queue[n].forEach(function (a, s) {
                    if (a.el) {
                      if (r[t].queue[n].push(a), "bottom" === n && a.channel_id[0] + a.channel_id[1] - 1 === o) {
                        var c = [].concat(a.channel_id);a.channel_id = [c[0] - e.channels.length + r.length, c[1]], a.top = a.channel_id[0] * i, e.danmu.config.area && e.danmu.config.area.start && (a.top += e.containerHeight * e.danmu.config.area.start), a.topInit();
                      }a.resized || (a.pauseMove(e.containerPos, !1), a.startMove(e.containerPos), a.resized = !0);
                    }e.channels[o].queue[n].splice(s, 1);
                  });
                }
              });
            }, f = 0; f < r.length; f++) {
              h(f);
            }for (var d = function d(t) {
              ["scroll", "top", "bottom"].forEach(function (e) {
                r[t].queue[e].forEach(function (t) {
                  t.resized = !1;
                });
              });
            }, p = 0; p < r.length; p++) {
              d(p);
            }e.channels = r, "b2t" === e.direction ? e.channelWidth = i : e.channelHeight = i;
          }
        } }, { key: "reset", value: function value() {
          var t = this.danmu.container,
              e = this;e.channels && e.channels.length > 0 && ["scroll", "top", "bottom"].forEach(function (t) {
            for (var n = 0; n < e.channels.length; n++) {
              e.channels[n].queue[t].forEach(function (t) {
                t.pauseMove(e.containerPos), t.remove();
              });
            }
          }), setTimeout(function () {
            var n = t.getBoundingClientRect();e.width = n.width, e.height = n.height, e.danmu.config.area && e.danmu.config.area.start >= 0 && e.danmu.config.area.end >= e.danmu.config.area.start && ("b2t" === e.direction ? e.width = e.width * (e.danmu.config.area.end - e.danmu.config.area.start) : e.height = e.height * (e.danmu.config.area.end - e.danmu.config.area.start)), e.container = t;var i = /mobile/gi.test(navigator.userAgent) ? 10 : 12,
                o = void 0;o = "b2t" === e.direction ? Math.floor(e.width / i) : Math.floor(e.height / i);for (var r = [], a = 0; a < o; a++) {
              r[a] = { id: a, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} };
            }e.channels = r, "b2t" === e.direction ? e.channelWidth = i : e.channelHeight = i;
          }, 200);
        } }, { key: "resetWithCb", value: function value(t, e) {
          var n = this.danmu.container,
              i = this;i.channels && i.channels.length > 0 && ["scroll", "top", "bottom"].forEach(function (t) {
            for (var e = 0; e < i.channels.length; e++) {
              i.channels[e].queue[t].forEach(function (t) {
                t.pauseMove(i.containerPos), t.remove();
              });
            }
          });var o = n.getBoundingClientRect();i.width = o.width, i.height = o.height, i.danmu.config.area && i.danmu.config.area.start >= 0 && i.danmu.config.area.end >= i.danmu.config.area.start && ("b2t" === i.direction ? i.width = i.width * (i.danmu.config.area.end - i.danmu.config.area.start) : i.height = i.height * (i.danmu.config.area.end - i.danmu.config.area.start)), i.container = n;var r = /mobile/gi.test(navigator.userAgent) ? 10 : 12,
              a = void 0;a = "b2t" === i.direction ? Math.floor(i.width / r) : Math.floor(i.height / r);for (var s = [], c = 0; c < a; c++) {
            s[c] = { id: c, queue: { scroll: [], top: [], bottom: [] }, operating: { scroll: !1, top: !1, bottom: !1 }, bookId: {} };
          }i.channels = s, i.channelHeight = r, t && t(!0, e);
        } }]), t;
    }();e.default = o, t.exports = e.default;
  }, function (t, e, n) {
    "use strict";
    Object.defineProperty(e, "__esModule", { value: !0 });var i,
        o = function () {
      function t(t, e) {
        for (var n = 0; n < e.length; n++) {
          var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
        }
      }return function (e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
      };
    }(),
        r = n(0),
        a = (i = r) && i.__esModule ? i : { default: i };var s = function () {
      function t(e, n) {
        !function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
        }(this, t), this.danmu = e, this.duration = n.duration, this.id = n.id, this.container = e.container, this.start = n.start, this.prior = n.prior, this.color = n.color, this.bookChannelId = n.bookChannelId, this.direction = e.direction;var i = this;this.danmu.on("changeDirection", function (t) {
          i.direction = t;
        });var o = void 0;if (this.domObj = a.default.domObj, n.el && 1 === n.el.nodeType) (o = this.domObj.use()).appendChild(a.default.copyDom(n.el));else if ((o = this.domObj.use()).textContent = n.txt, n.style) {
          var r = n.style;Object.keys(r).forEach(function (t) {
            o.style[t] = r[t];
          });
        }"top" === n.mode || "bottom" === n.mode ? this.mode = n.mode : this.mode = "scroll", this.el = o, this.status = "waiting";var s = this.container.getBoundingClientRect();this.el.style.left = s.width + "px";
      }return o(t, [{ key: "attach", value: function value() {
          this.container.appendChild(this.el), this.elPos = this.el.getBoundingClientRect(), "b2t" === this.direction ? (this.width = this.elPos.height, this.height = this.elPos.width) : (this.width = this.elPos.width, this.height = this.elPos.height);
        } }, { key: "detach", value: function value() {
          this.container && this.el && (this.domObj.unuse(this.el), this.container.removeChild(this.el));var t = this;this.danmu.off("changeDirection", function (e) {
            t.direction = e;
          }), this.el = null;
        } }, { key: "topInit", value: function value() {
          if ("b2t" === this.direction) {
            var t = this.container.getBoundingClientRect();this.el.style.transformOrigin = "left top", this.el.style.transform = "translateX(-" + this.top + "px) translateY(" + t.height + "px) translateZ(0px) rotate(90deg)", this.el.style.transition = "transform 0s linear 0s";
          } else this.el.style.top = this.top + "px";
        } }, { key: "pauseMove", value: function value(t) {
          var e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];if ("paused" !== this.status && (this.status = "paused", clearTimeout(this.removeTimer), this.el)) if (this.el.style.willChange = "auto", "scroll" === this.mode) {
            if (e) {
              var n = (new Date().getTime() - this.moveTime) / 1e3 * this.moveV,
                  i = 0;i = this.moveMoreS - n >= 0 ? "b2t" === this.direction ? (this.moveMoreS - n) / this.moveContainerHeight * t.height : (this.moveMoreS - n) / this.moveContainerWidth * t.width : this.moveMoreS - n, "b2t" === this.direction ? this.el.style.transform = "translateX(-" + this.top + "px) translateY(" + i + "px) translateZ(0px) rotate(90deg)" : this.el.style.left = i + "px";
            } else "b2t" === this.direction ? this.el.style.transform = "translateX(-" + this.top + "px) translateY(" + (this.el.getBoundingClientRect().top - t.top) + "px) translateZ(0px) rotate(90deg)" : this.el.style.left = this.el.getBoundingClientRect().left - t.left + "px";"b2t" === this.direction ? this.el.style.transition = "transform 0s linear 0s" : (this.el.style.transform = "translateX(0px) translateY(0px) translateZ(0px)", this.el.style.transition = "transform 0s linear 0s");
          } else this.pastDuration && this.startTime ? this.pastDuration = this.pastDuration + new Date().getTime() - this.startTime : this.pastDuration = 1;
        } }, { key: "startMove", value: function value(t) {
          var e = this;if (this.el && "start" !== this.status) if (this.status = "start", this.el.style.willChange = "transform", "scroll" === this.mode) {
            if ("b2t" === this.direction) {
              this.moveV = (t.height + this.height) / this.duration * 1e3;var n = (e.el.getBoundingClientRect().bottom - t.top) / this.moveV;this.el.style.transition = "transform " + n + "s linear 0s", setTimeout(function () {
                e.el && (e.el.style.transform = "translateX(-" + e.top + "px) translateY(-" + e.height + "px) translateZ(0px) rotate(90deg)", e.moveTime = new Date().getTime(), e.moveMoreS = e.el.getBoundingClientRect().top - t.top, e.moveContainerHeight = t.height, e.removeTimer = setTimeout(r, 1e3 * n));
              }, 20);
            } else {
              this.moveV = (t.width + this.width) / this.duration * 1e3;var i = (e.el.getBoundingClientRect().right - t.left) / this.moveV;this.el.style.transition = "transform " + i + "s linear 0s", setTimeout(function () {
                e.el && (e.el.style.transform = "translateX(-" + (e.el.getBoundingClientRect().right - t.left) + "px) translateY(0px) translateZ(0px)", e.moveTime = new Date().getTime(), e.moveMoreS = e.el.getBoundingClientRect().left - t.left, e.moveContainerWidth = t.width, e.removeTimer = setTimeout(r, 1e3 * i));
              }, 20);
            }
          } else {
            this.el.style.left = "50%", this.el.style.margin = "0 0 0 -" + this.width / 2 + "px", this.pastDuration || (this.pastDuration = 1);var o = this.duration >= this.pastDuration ? this.duration - this.pastDuration : 0;this.removeTimer = setTimeout(r, o), this.startTime = new Date().getTime();
          }function r() {
            if (e.el) if ("scroll" === e.mode) {
              var t = e.danmu.container.getBoundingClientRect(),
                  n = e.el.getBoundingClientRect();"b2t" === e.direction ? n && n.bottom <= t.top + 100 ? (e.status = "end", e.remove()) : (e.pauseMove(t), e.startMove(t)) : n && n.right <= t.left + 100 ? (e.status = "end", e.remove()) : (e.pauseMove(t), e.startMove(t));
            } else e.status = "end", e.remove();
          }
        } }, { key: "remove", value: function value() {
          var t = this;(this.removeTimer && clearTimeout(this.removeTimer), t.el && t.el.parentNode) && (t.el.style.willChange = "auto", this.danmu.off("changeDirection", function (e) {
            t.direction = e;
          }), this.domObj.unuse(t.el), t.el.parentNode.removeChild(t.el), t.el = null, t.danmu.emit("bullet_remove", { bullet: t }));
        } }]), t;
    }();e.default = s, t.exports = e.default;
  }, function (t, e, n) {
    var i = n(27);"string" == typeof i && (i = [[t.i, i, ""]]);var o = { hmr: !0, transform: void 0, insertInto: void 0 };n(29)(i, o);i.locals && (t.exports = i.locals);
  }, function (t, e, n) {
    (t.exports = n(28)(!1)).push([t.i, ".danmu{overflow:hidden;-webkit-user-select:none;-moz-user-select:none;user-select:none;-ms-user-select:none}.danmu>*{position:absolute;white-space:nowrap}.danmu-switch{width:32px;height:20px;border-radius:100px;background-color:#ccc;-webkit-box-sizing:border-box;box-sizing:border-box;outline:none;cursor:pointer;position:relative;text-align:center;margin:10px auto}.danmu-switch.danmu-switch-active{padding-left:12px;background-color:#f85959}.danmu-switch span.txt{width:20px;height:20px;line-height:20px;text-align:center;display:block;border-radius:100px;background-color:#ffffff;-webkit-box-shadow:-2px 0 0 0 rgba(0, 0, 0, .04);box-shadow:-2px 0 0 0 rgba(0, 0, 0, .04);font-family:PingFangSC;font-size:10px;font-weight:500;color:#f44336}\n", ""]);
  }, function (t, e) {
    t.exports = function (t) {
      var e = [];return e.toString = function () {
        return this.map(function (e) {
          var n = function (t, e) {
            var n = t[1] || "",
                i = t[3];if (!i) return n;if (e && "function" == typeof btoa) {
              var o = (a = i, "/*# sourceMappingURL=data:application/json;charset=utf-8;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(a)))) + " */"),
                  r = i.sources.map(function (t) {
                return "/*# sourceURL=" + i.sourceRoot + t + " */";
              });return [n].concat(r).concat([o]).join("\n");
            }var a;return [n].join("\n");
          }(e, t);return e[2] ? "@media " + e[2] + "{" + n + "}" : n;
        }).join("");
      }, e.i = function (t, n) {
        "string" == typeof t && (t = [[null, t, ""]]);for (var i = {}, o = 0; o < this.length; o++) {
          var r = this[o][0];"number" == typeof r && (i[r] = !0);
        }for (o = 0; o < t.length; o++) {
          var a = t[o];"number" == typeof a[0] && i[a[0]] || (n && !a[2] ? a[2] = n : n && (a[2] = "(" + a[2] + ") and (" + n + ")"), e.push(a));
        }
      }, e;
    };
  }, function (t, e, n) {
    var i,
        o,
        r = {},
        a = (i = function i() {
      return window && document && document.all && !window.atob;
    }, function () {
      return void 0 === o && (o = i.apply(this, arguments)), o;
    }),
        s = function (t) {
      var e = {};return function (t) {
        if ("function" == typeof t) return t();if (void 0 === e[t]) {
          var n = function (t) {
            return document.querySelector(t);
          }.call(this, t);if (window.HTMLIFrameElement && n instanceof window.HTMLIFrameElement) try {
            n = n.contentDocument.head;
          } catch (t) {
            n = null;
          }e[t] = n;
        }return e[t];
      };
    }(),
        c = null,
        u = 0,
        l = [],
        h = n(30);function f(t, e) {
      for (var n = 0; n < t.length; n++) {
        var i = t[n],
            o = r[i.id];if (o) {
          o.refs++;for (var a = 0; a < o.parts.length; a++) {
            o.parts[a](i.parts[a]);
          }for (; a < i.parts.length; a++) {
            o.parts.push(b(i.parts[a], e));
          }
        } else {
          var s = [];for (a = 0; a < i.parts.length; a++) {
            s.push(b(i.parts[a], e));
          }r[i.id] = { id: i.id, refs: 1, parts: s };
        }
      }
    }function d(t, e) {
      for (var n = [], i = {}, o = 0; o < t.length; o++) {
        var r = t[o],
            a = e.base ? r[0] + e.base : r[0],
            s = { css: r[1], media: r[2], sourceMap: r[3] };i[a] ? i[a].parts.push(s) : n.push(i[a] = { id: a, parts: [s] });
      }return n;
    }function p(t, e) {
      var n = s(t.insertInto);if (!n) throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var i = l[l.length - 1];if ("top" === t.insertAt) i ? i.nextSibling ? n.insertBefore(e, i.nextSibling) : n.appendChild(e) : n.insertBefore(e, n.firstChild), l.push(e);else if ("bottom" === t.insertAt) n.appendChild(e);else {
        if ("object" != _typeof(t.insertAt) || !t.insertAt.before) throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var o = s(t.insertInto + " " + t.insertAt.before);n.insertBefore(e, o);
      }
    }function m(t) {
      if (null === t.parentNode) return !1;t.parentNode.removeChild(t);var e = l.indexOf(t);e >= 0 && l.splice(e, 1);
    }function g(t) {
      var e = document.createElement("style");return void 0 === t.attrs.type && (t.attrs.type = "text/css"), v(e, t.attrs), p(t, e), e;
    }function v(t, e) {
      Object.keys(e).forEach(function (n) {
        t.setAttribute(n, e[n]);
      });
    }function b(t, e) {
      var n, i, o, r;if (e.transform && t.css) {
        if (!(r = e.transform(t.css))) return function () {};t.css = r;
      }if (e.singleton) {
        var a = u++;n = c || (c = g(e)), i = x.bind(null, n, a, !1), o = x.bind(null, n, a, !0);
      } else t.sourceMap && "function" == typeof URL && "function" == typeof URL.createObjectURL && "function" == typeof URL.revokeObjectURL && "function" == typeof Blob && "function" == typeof btoa ? (n = function (t) {
        var e = document.createElement("link");return void 0 === t.attrs.type && (t.attrs.type = "text/css"), t.attrs.rel = "stylesheet", v(e, t.attrs), p(t, e), e;
      }(e), i = function (t, e, n) {
        var i = n.css,
            o = n.sourceMap,
            r = void 0 === e.convertToAbsoluteUrls && o;(e.convertToAbsoluteUrls || r) && (i = h(i));o && (i += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(o)))) + " */");var a = new Blob([i], { type: "text/css" }),
            s = t.href;t.href = URL.createObjectURL(a), s && URL.revokeObjectURL(s);
      }.bind(null, n, e), o = function o() {
        m(n), n.href && URL.revokeObjectURL(n.href);
      }) : (n = g(e), i = function (t, e) {
        var n = e.css,
            i = e.media;i && t.setAttribute("media", i);if (t.styleSheet) t.styleSheet.cssText = n;else {
          for (; t.firstChild;) {
            t.removeChild(t.firstChild);
          }t.appendChild(document.createTextNode(n));
        }
      }.bind(null, n), o = function o() {
        m(n);
      });return i(t), function (e) {
        if (e) {
          if (e.css === t.css && e.media === t.media && e.sourceMap === t.sourceMap) return;i(t = e);
        } else o();
      };
    }t.exports = function (t, e) {
      if ("undefined" != typeof DEBUG && DEBUG && "object" != (typeof document === "undefined" ? "undefined" : _typeof(document))) throw new Error("The style-loader cannot be used in a non-browser environment");(e = e || {}).attrs = "object" == _typeof(e.attrs) ? e.attrs : {}, e.singleton || "boolean" == typeof e.singleton || (e.singleton = a()), e.insertInto || (e.insertInto = "head"), e.insertAt || (e.insertAt = "bottom");var n = d(t, e);return f(n, e), function (t) {
        for (var i = [], o = 0; o < n.length; o++) {
          var a = n[o];(s = r[a.id]).refs--, i.push(s);
        }t && f(d(t, e), e);for (o = 0; o < i.length; o++) {
          var s;if (0 === (s = i[o]).refs) {
            for (var c = 0; c < s.parts.length; c++) {
              s.parts[c]();
            }delete r[s.id];
          }
        }
      };
    };var y,
        w = (y = [], function (t, e) {
      return y[t] = e, y.filter(Boolean).join("\n");
    });function x(t, e, n, i) {
      var o = n ? "" : i.css;if (t.styleSheet) t.styleSheet.cssText = w(e, o);else {
        var r = document.createTextNode(o),
            a = t.childNodes;a[e] && t.removeChild(a[e]), a.length ? t.insertBefore(r, a[e]) : t.appendChild(r);
      }
    }
  }, function (t, e) {
    t.exports = function (t) {
      var e = "undefined" != typeof window && window.location;if (!e) throw new Error("fixUrls requires window.location");if (!t || "string" != typeof t) return t;var n = e.protocol + "//" + e.host,
          i = n + e.pathname.replace(/\/[^\/]*$/, "/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function (t, e) {
        var o,
            r = e.trim().replace(/^"(.*)"$/, function (t, e) {
          return e;
        }).replace(/^'(.*)'$/, function (t, e) {
          return e;
        });return (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(r) ? t : (o = 0 === r.indexOf("//") ? r : 0 === r.indexOf("/") ? n + r : i + r.replace(/^\.\//, ""), "url(" + JSON.stringify(o) + ")")
        );
      });
    };
  }]);
});
//# sourceMappingURL=index.js.map
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(97)(module)))

/***/ }),
/* 97 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function (module) {
	if (!module.webpackPolyfill) {
		module.deprecate = function () {};
		module.paths = [];
		// module.parent = undefined by default
		if (!module.children) module.children = [];
		Object.defineProperty(module, "loaded", {
			enumerable: true,
			get: function get() {
				return module.l;
			}
		});
		Object.defineProperty(module, "id", {
			enumerable: true,
			get: function get() {
				return module.i;
			}
		});
		module.webpackPolyfill = 1;
	}
	return module;
};

/***/ }),
/* 98 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 40 40\" width=\"40\" height=\"40\">\n  <path fill=\"#f85959\" transform=\"scale(0.8 0.8)\" d=\"M36.5,18.73a1.19,1.19,0,0,0,1-1.14V16.33a1.2,1.2,0,0,0-1-1.13l-.61-.08a1.75,1.75,0,0,1-1.3-.86l-.21-.36-.2-.36A1.72,1.72,0,0,1,34,12l.23-.58a1.18,1.18,0,0,0-.5-1.42l-1.1-.62a1.18,1.18,0,0,0-1.47.3l-.39.51a1.82,1.82,0,0,1-1.41.72c-.44,0-1.88-.27-2.22-.7l-.39-.49a1.18,1.18,0,0,0-1.48-.28l-1.09.64a1.19,1.19,0,0,0-.47,1.43l.25.59a1.87,1.87,0,0,1-.08,1.58c-.26.37-1.17,1.5-1.71,1.58l-.63.09a1.19,1.19,0,0,0-1,1.14l0,1.27a1.17,1.17,0,0,0,1,1.12l.61.08a1.74,1.74,0,0,1,1.3.87l.21.36.2.35A1.69,1.69,0,0,1,24,22.08l-.23.59a1.19,1.19,0,0,0,.5,1.42l1.1.62a1.19,1.19,0,0,0,1.48-.31l.38-.5a1.83,1.83,0,0,1,1.41-.72c.44,0,1.88.25,2.22.69l.39.49a1.18,1.18,0,0,0,1.48.28L33.86,24a1.19,1.19,0,0,0,.47-1.43L34.09,22a1.84,1.84,0,0,1,.07-1.58c.26-.37,1.17-1.5,1.72-1.58ZM31,18.94a2.76,2.76,0,0,1-4.65-1.2A2.71,2.71,0,0,1,27,15.13a2.76,2.76,0,0,1,4.64,1.2A2.7,2.7,0,0,1,31,18.94Z\"/>\n  <path fill=\"#f85959\" transform=\"scale(0.8 0.8)\" d=\"M32,0H3.59A3.59,3.59,0,0,0,0,3.59v17A3.59,3.59,0,0,0,3.59,24.2H19.72a12.59,12.59,0,0,1-.81-1.2A11.73,11.73,0,0,1,35.54,7.28V3.59A3.59,3.59,0,0,0,32,0ZM13,14.18H4.29a1.52,1.52,0,0,1,0-3H13a1.52,1.52,0,0,1,0,3ZM16.45,8H4.29a1.51,1.51,0,0,1,0-3H16.45a1.51,1.51,0,1,1,0,3Z\"/>\n</svg>\n");

/***/ }),
/* 99 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_pip = function s_pip() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.pip) {
    return;
  }
  var pip = player.lang.PIP;
  var btn = util.createDom('xg-pip', '<p class="name"><span>' + pip + '</span></p>', { tabindex: 9 }, 'xgplayer-pip');

  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('pipBtnClick');
    });
  });
};

_player2.default.install('s_pip', s_pip);

/***/ }),
/* 100 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _playNext = __webpack_require__(101);

var _playNext2 = _interopRequireDefault(_playNext);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_playNext = function s_playNext() {
  var player = this;
  var util = _player2.default.util;
  var nextBtn = player.config.playNext;
  if (!nextBtn || !nextBtn.urlList) {
    return;
  }
  var btn = util.createDom('xg-playnext', '<xg-icon class="xgplayer-icon">' + _playNext2.default + '</xg-icon>', {}, 'xgplayer-playnext');
  var tipsText = player.lang.PLAYNEXT_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-playnext">' + tipsText + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('playNextBtnClick');
    });
  });
};

_player2.default.install('s_playNext', s_playNext);

/***/ }),
/* 101 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">\n  <path transform=\"scale(0.038 0.028)\" d=\"M800 380v768h-128v-352l-320 320v-704l320 320v-352z\"></path>\n</svg>\n");

/***/ }),
/* 102 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _rotate = __webpack_require__(103);

var _rotate2 = _interopRequireDefault(_rotate);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_rotate = function s_rotate() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.rotate) {
    return;
  }
  var btn = util.createDom('xg-rotate', '<xg-icon class="xgplayer-icon">' + _rotate2.default + '</xg-icon>', {}, 'xgplayer-rotate');

  var tipsText = player.lang.ROTATE_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-rotate">' + tipsText + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('rotateBtnClick');
    });
  });
};

_player2.default.install('s_rotate', s_rotate);

/***/ }),
/* 103 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 40 40\" fill=\"none\">\n  <g clip-path=\"url(#clip0)\">\n    <path transform=\"scale(1.5 1.5)\" d=\"M11.6665 9.16663H4.1665C2.78579 9.16663 1.6665 10.2859 1.6665 11.6666V15.8333C1.6665 17.214 2.78579 18.3333 4.1665 18.3333H11.6665C13.0472 18.3333 14.1665 17.214 14.1665 15.8333V11.6666C14.1665 10.2859 13.0472 9.16663 11.6665 9.16663Z\" fill=\"white\"/>\n    <path transform=\"scale(1.5 1.5)\" fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M3.88148 4.06298C3.75371 4.21005 3.67667 4.40231 3.67749 4.61242C3.67847 4.87253 3.79852 5.10435 3.98581 5.25646L6.99111 8.05895C7.32771 8.37283 7.85502 8.35443 8.16891 8.01782C8.48279 7.68122 8.46437 7.15391 8.12778 6.84003L6.62061 5.43457L9.8198 5.4224C9.82848 5.42239 9.8372 5.42221 9.84591 5.4219C10.9714 5.38233 12.0885 5.6285 13.0931 6.13744C14.0976 6.64635 14.957 7.40148 15.5908 8.33234C16.2246 9.2632 16.6122 10.3394 16.7177 11.4606C16.823 12.5819 16.6427 13.7115 16.1934 14.7442C16.0098 15.1661 16.203 15.6571 16.6251 15.8408C17.0471 16.0243 17.5381 15.8311 17.7216 15.4091C18.2833 14.1183 18.5087 12.7063 18.3771 11.3047C18.2453 9.90318 17.7607 8.55792 16.9684 7.39433C16.1761 6.23073 15.1021 5.28683 13.8463 4.65065C12.5946 4.01651 11.203 3.70872 9.80072 3.75583L6.43415 3.76862L7.96326 2.12885C8.27715 1.79225 8.25872 1.26494 7.92213 0.951061C7.58553 0.63718 7.05822 0.655585 6.74433 0.99219L3.90268 4.0395C3.89545 4.04724 3.88841 4.05509 3.88154 4.06303L3.88148 4.06298Z\" fill=\"white\"/>\n  </g>\n  <defs>\n    <clipPath id=\"clip0\">\n      <rect width=\"40\" height=\"40\" fill=\"white\"/>\n    </clipPath>\n  </defs>\n</svg>\n");

/***/ }),
/* 104 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

var _reload = __webpack_require__(105);

var _reload2 = _interopRequireDefault(_reload);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_reload = function s_reload() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.reload) {
    return;
  }
  var btn = util.createDom('xg-reload', '<xg-icon class="xgplayer-icon">' + _reload2.default + '</xg-icon>', {}, 'xgplayer-reload');

  var tipsText = player.lang.RELOAD_TIPS;
  var tips = util.createDom('xg-tips', '<span class="xgplayer-tip-reload">' + tipsText + '</span>', {}, 'xgplayer-tips');
  btn.appendChild(tips);
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('reloadBtnClick');
    });
  });
};

_player2.default.install('s_reload', s_reload);

/***/ }),
/* 105 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 28 28\">\n    <path fill=\"#FFF\" fill-opacity=\"1\" fill-rule=\"nonzero\" d=\"M18.17 19.988a7.182 7.182 0 0 1-4.256 1.318 7.806 7.806 0 0 1-.595-.03c-.08-.008-.16-.021-.242-.031a8.004 8.004 0 0 1-.458-.071c-.094-.018-.185-.042-.276-.063a7.743 7.743 0 0 1-.439-.113c-.068-.022-.136-.047-.205-.07a7.03 7.03 0 0 1-.492-.181c-.037-.015-.072-.032-.108-.049a7.295 7.295 0 0 1-.554-.269l-.025-.012a7.347 7.347 0 0 1-2.111-1.753c-.03-.036-.057-.074-.086-.11a7.305 7.305 0 0 1-1.594-4.557h1.686a.123.123 0 0 0 .108-.064.119.119 0 0 0-.006-.125L5.684 9.532a.123.123 0 0 0-.103-.056.123.123 0 0 0-.102.056l-2.834 4.276a.121.121 0 0 0-.005.125c.022.04.064.064.107.064h1.687c0 2.025.627 3.902 1.693 5.454.013.021.022.044.037.066.11.159.233.305.352.455.043.057.085.116.13.171.175.213.36.413.55.61.02.018.036.038.054.055a9.447 9.447 0 0 0 2.91 1.996c.058.026.115.054.175.079.202.084.41.158.619.228.098.034.196.069.296.1.183.054.37.1.558.145.125.029.249.06.376.085.052.01.102.027.155.035.177.032.355.05.533.071.064.007.128.018.19.026.32.03.639.052.956.052a9.46 9.46 0 0 0 5.47-1.746 1.16 1.16 0 0 0 .282-1.608 1.143 1.143 0 0 0-1.6-.283zm5.397-5.991a9.604 9.604 0 0 0-1.685-5.441c-.016-.027-.026-.054-.043-.078-.132-.19-.276-.366-.419-.543-.017-.022-.032-.044-.05-.065a9.467 9.467 0 0 0-3.571-2.7l-.114-.051a11.2 11.2 0 0 0-.673-.248c-.082-.027-.163-.057-.247-.082a9.188 9.188 0 0 0-.6-.156c-.113-.026-.224-.055-.337-.077-.057-.011-.109-.028-.164-.037-.151-.027-.304-.039-.455-.058-.104-.013-.208-.03-.313-.04a10.05 10.05 0 0 0-.759-.039c-.045 0-.09-.007-.136-.007l-.025.003a9.45 9.45 0 0 0-5.46 1.737 1.16 1.16 0 0 0-.284 1.608c.363.523 1.08.65 1.6.284a7.182 7.182 0 0 1 4.222-1.32c.217.002.429.013.639.033.065.007.129.017.193.025.173.021.344.046.513.08.075.014.149.033.221.05.166.037.331.077.494.127l.152.051c.185.061.366.127.545.201l.054.025a7.308 7.308 0 0 1 2.741 2.067l.013.018a7.302 7.302 0 0 1 1.652 4.633h-1.686a.123.123 0 0 0-.108.064.12.12 0 0 0 .006.124l2.834 4.277c.022.033.06.054.103.054.042 0 .08-.021.102-.054l2.833-4.277a.12.12 0 0 0 .005-.124.123.123 0 0 0-.108-.064h-1.685z\"/>\n</svg>\n");

/***/ }),
/* 106 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_screenShot = function s_screenShot() {
  var player = this;
  var util = _player2.default.util;
  if (!player.config.screenShot) {
    return;
  }
  var screenShotText = player.lang.SCREENSHOT;
  var btn = util.createDom('xg-screenshot', '<p class="name"><span>' + screenShotText + '</span></p>', { tabindex: 11 }, 'xgplayer-screenshot');
  player.once('ready', function () {
    player.controls.appendChild(btn);
  });

  ['click', 'touchend'].forEach(function (item) {
    btn.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      player.emit('screenShotBtnClick');
    });
  });
};

_player2.default.install('s_screenShot', s_screenShot);

/***/ }),
/* 107 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_textTrack = function s_textTrack() {
  if (navigator.userAgent.indexOf('Chrome') < 0) {
    return;
  }
  var player = this;
  var root = player.root;
  var util = _player2.default.util;
  var sniffer = _player2.default.sniffer;
  var controls = player.controls;
  var container = util.createDom('xg-texttrack', '', { tabindex: 7 }, 'xgplayer-texttrack');
  var list = player.config.textTrack;
  if (list && Array.isArray(list) && list.length > 0) {
    util.addClass(player.root, 'xgplayer-is-texttrack');
    player.on('canplay', function () {
      var _this = this;

      var tmp = ['<ul>'];
      tmp.push('<li class=\'' + (this.textTrackShowDefault ? '' : 'selected') + '\'}\'>\u5173\u95ED</li>');
      list.forEach(function (item) {
        tmp.push('<li class=\'' + (item.default && _this.textTrackShowDefault ? 'selected' : '') + '\'>' + item.label + '</li>');
      });
      var controlText = player.lang.TEXTTRACK;
      tmp.push('</ul><p class="name">' + controlText + '</p>');

      var urlInRoot = root.querySelector('.xgplayer-texttrack');
      if (urlInRoot) {
        urlInRoot.innerHTML = tmp.join('');
        var cur = urlInRoot.querySelector('.name');
        if (!player.config.textTrackActive || player.config.textTrackActive === 'hover') {
          cur.addEventListener('mouseenter', function (e) {
            e.preventDefault();
            e.stopPropagation();
            util.addClass(root, 'xgplayer-texttrack-active');
            urlInRoot.focus();
          });
        }
      } else {
        container.innerHTML = tmp.join('');
        var _cur = container.querySelector('.name');
        if (!player.config.textTrackActive || player.config.textTrackActive === 'hover') {
          _cur.addEventListener('mouseenter', function (e) {
            e.preventDefault();
            e.stopPropagation();
            util.addClass(player.root, 'xgplayer-texttrack-active');
            container.focus();
          });
        }
        player.controls.appendChild(container);
      }
    });
  };

  ['touchend', 'click'].forEach(function (item) {
    container.addEventListener(item, function (e) {
      e.preventDefault();
      e.stopPropagation();
      var li = e.target || e.srcElement;
      if (li && li.tagName.toLocaleLowerCase() === 'li') {
        Array.prototype.forEach.call(li.parentNode.childNodes, function (item) {
          util.removeClass(item, 'selected');
        });
        util.addClass(li, 'selected');
        var trackDoms = player.root.getElementsByTagName('Track');
        if (li.innerHTML === '关闭') {
          trackDoms[0].track.mode = 'hidden';
          util.removeClass(player.root, 'xgplayer-texttrack-active');
        } else {
          util.addClass(player.root, 'xgplayer-texttrack-active');
          trackDoms[0].track.mode = 'showing';

          list.some(function (item) {
            if (item.label === li.innerHTML) {
              trackDoms[0].src = item.src;
              if (item.kind) {
                trackDoms[0].kind = item.kind;
              }
              trackDoms[0].label = item.label;
              if (item.srclang) {
                trackDoms[0].srclang = item.srclang;
              }
              return true;
            }
          });
          player.emit('textTrackChange', li.innerHTML);
        }
      } else if (player.config.textTrackActive === 'click' && li && (li.tagName.toLocaleLowerCase() === 'p' || li.tagName.toLocaleLowerCase() === 'em')) {
        util.addClass(player.root, 'xgplayer-texttrack-active');
        container.focus();
      }
    }, false);
  });

  container.addEventListener('mouseleave', function (e) {
    e.preventDefault();
    e.stopPropagation();
    util.removeClass(player.root, 'xgplayer-texttrack-active');
  });
};

_player2.default.install('s_textTrack', s_textTrack);

/***/ }),
/* 108 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var s_error = function s_error() {
  var player = this;
  var root = player.root;
  var util = _player2.default.util;

  var error = util.createDom('xg-error', '<span class="xgplayer-error-text">请<span class="xgplayer-error-refresh">刷新</span>试试</span>', {}, 'xgplayer-error');
  player.once('ready', function () {
    root.appendChild(error);
  });

  var text = error.querySelector('.xgplayer-error-text');
  var refresh = null;

  function onError() {
    // player.controls.style.display = 'none'
    // if (player.error) {
    //   text.innerHTML = player.error
    // } else {
    if (player.config.lang && player.config.lang === 'zh-cn') {
      text.innerHTML = player.config.errorTips || '\u8BF7<span class="xgplayer-error-refresh">\u5237\u65B0</span>\u8BD5\u8BD5';
    } else {
      text.innerHTML = player.config.errorTips || 'please try to <span class="xgplayer-error-refresh">refresh</span>';
    }
    // }
    util.addClass(player.root, 'xgplayer-is-error');
    refresh = error.querySelector('.xgplayer-error-refresh');
    if (refresh) {
      ['touchend', 'click'].forEach(function (item) {
        refresh.addEventListener(item, function (e) {
          e.preventDefault();
          e.stopPropagation();
          player.autoplay = true;
          player.once('playing', function () {
            util.removeClass(player.root, 'xgplayer-is-error');
          });
          player.src = player.config.url;
        });
      });
    }
  }
  player.on('error', onError);
  function onDestroy() {
    player.off('error', onError);
    player.off('destroy', onDestroy);
  }
  player.once('destroy', onDestroy);
};

_player2.default.install('s_error', s_error);

/***/ }),
/* 109 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _player = __webpack_require__(0);

var _player2 = _interopRequireDefault(_player);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var smemoryPlay = function smemoryPlay() {
  var player = this;
  var util = _player2.default.util;
  var lastPlayTime = player.config.lastPlayTime || 0;
  var lastPlayTimeHideDelay = player.config.lastPlayTimeHideDelay || 3;
  var dom = null;
  if (lastPlayTime <= 0) {
    return;
  }
  dom = util.createDom('xg-memoryplay', '<div class="xgplayer-memoryplay-spot"><div class="xgplayer-progress-tip">\u60A8\u4E0A\u6B21\u89C2\u770B\u5230 <span class="xgplayer-lasttime">' + util.format(lastPlayTime) + '</span> \uFF0C\u4E3A\u60A8\u81EA\u52A8\u7EED\u64AD <span class="btn-close"><svg viewBox="64 64 896 896" focusable="false" class="" data-icon="close" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M563.8 512l262.5-312.9c4.4-5.2.7-13.1-6.1-13.1h-79.8c-4.7 0-9.2 2.1-12.3 5.7L511.6 449.8 295.1 191.7c-3-3.6-7.5-5.7-12.3-5.7H203c-6.8 0-10.5 7.9-6.1 13.1L459.4 512 196.9 824.9A7.95 7.95 0 0 0 203 838h79.8c4.7 0 9.2-2.1 12.3-5.7l216.5-258.1 216.5 258.1c3 3.6 7.5 5.7 12.3 5.7h79.8c6.8 0 10.5-7.9 6.1-13.1L563.8 512z"></path></svg></span></div></div>', {}, 'xgplayer-memoryplay');
  dom.addEventListener('mouseover', function (e) {
    e.stopPropagation();
  });
  var removeFunc = function removeFunc() {
    dom && dom.parentNode.removeChild(dom);
    dom = null;
  };
  dom.querySelector('.xgplayer-progress-tip .btn-close').addEventListener('click', removeFunc);
  var handlePlay = function handlePlay() {
    player.root.appendChild(dom);
    player.emit('memoryPlayStart', lastPlayTime);
    if (lastPlayTimeHideDelay > 0) {
      setTimeout(function () {
        removeFunc();
      }, lastPlayTimeHideDelay * 1000);
    }
  };
  player.once('play', handlePlay);
  player.once('ended', removeFunc);
};

_player2.default.install('s_memoryPlay', smemoryPlay);

/***/ })
/******/ ]);
});
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "./node_modules/process/browser.js":
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/setimmediate/setImmediate.js":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/webpack/buildin/global.js"), __webpack_require__("./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/sweetalert/dist/sweetalert.min.js":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(setImmediate, clearImmediate) {!function(t,e){ true?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.swal=e():t.swal=e()}(this,function(){return function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var n={};return e.m=t,e.c=n,e.d=function(t,n,o){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:o})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=8)}([function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o="swal-button";e.CLASS_NAMES={MODAL:"swal-modal",OVERLAY:"swal-overlay",SHOW_MODAL:"swal-overlay--show-modal",MODAL_TITLE:"swal-title",MODAL_TEXT:"swal-text",ICON:"swal-icon",ICON_CUSTOM:"swal-icon--custom",CONTENT:"swal-content",FOOTER:"swal-footer",BUTTON_CONTAINER:"swal-button-container",BUTTON:o,CONFIRM_BUTTON:o+"--confirm",CANCEL_BUTTON:o+"--cancel",DANGER_BUTTON:o+"--danger",BUTTON_LOADING:o+"--loading",BUTTON_LOADER:o+"__loader"},e.default=e.CLASS_NAMES},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.getNode=function(t){var e="."+t;return document.querySelector(e)},e.stringToNode=function(t){var e=document.createElement("div");return e.innerHTML=t.trim(),e.firstChild},e.insertAfter=function(t,e){var n=e.nextSibling;e.parentNode.insertBefore(t,n)},e.removeNode=function(t){t.parentElement.removeChild(t)},e.throwErr=function(t){throw t=t.replace(/ +(?= )/g,""),"SweetAlert: "+(t=t.trim())},e.isPlainObject=function(t){if("[object Object]"!==Object.prototype.toString.call(t))return!1;var e=Object.getPrototypeOf(t);return null===e||e===Object.prototype},e.ordinalSuffixOf=function(t){var e=t%10,n=t%100;return 1===e&&11!==n?t+"st":2===e&&12!==n?t+"nd":3===e&&13!==n?t+"rd":t+"th"}},function(t,e,n){"use strict";function o(t){for(var n in t)e.hasOwnProperty(n)||(e[n]=t[n])}Object.defineProperty(e,"__esModule",{value:!0}),o(n(25));var r=n(26);e.overlayMarkup=r.default,o(n(27)),o(n(28)),o(n(29));var i=n(0),a=i.default.MODAL_TITLE,s=i.default.MODAL_TEXT,c=i.default.ICON,l=i.default.FOOTER;e.iconMarkup='\n  <div class="'+c+'"></div>',e.titleMarkup='\n  <div class="'+a+'"></div>\n',e.textMarkup='\n  <div class="'+s+'"></div>',e.footerMarkup='\n  <div class="'+l+'"></div>\n'},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1);e.CONFIRM_KEY="confirm",e.CANCEL_KEY="cancel";var r={visible:!0,text:null,value:null,className:"",closeModal:!0},i=Object.assign({},r,{visible:!1,text:"Cancel",value:null}),a=Object.assign({},r,{text:"OK",value:!0});e.defaultButtonList={cancel:i,confirm:a};var s=function(t){switch(t){case e.CONFIRM_KEY:return a;case e.CANCEL_KEY:return i;default:var n=t.charAt(0).toUpperCase()+t.slice(1);return Object.assign({},r,{text:n,value:t})}},c=function(t,e){var n=s(t);return!0===e?Object.assign({},n,{visible:!0}):"string"==typeof e?Object.assign({},n,{visible:!0,text:e}):o.isPlainObject(e)?Object.assign({visible:!0},n,e):Object.assign({},n,{visible:!1})},l=function(t){for(var e={},n=0,o=Object.keys(t);n<o.length;n++){var r=o[n],a=t[r],s=c(r,a);e[r]=s}return e.cancel||(e.cancel=i),e},u=function(t){var n={};switch(t.length){case 1:n[e.CANCEL_KEY]=Object.assign({},i,{visible:!1});break;case 2:n[e.CANCEL_KEY]=c(e.CANCEL_KEY,t[0]),n[e.CONFIRM_KEY]=c(e.CONFIRM_KEY,t[1]);break;default:o.throwErr("Invalid number of 'buttons' in array ("+t.length+").\n      If you want more than 2 buttons, you need to use an object!")}return n};e.getButtonListOpts=function(t){var n=e.defaultButtonList;return"string"==typeof t?n[e.CONFIRM_KEY]=c(e.CONFIRM_KEY,t):Array.isArray(t)?n=u(t):o.isPlainObject(t)?n=l(t):!0===t?n=u([!0,!0]):!1===t?n=u([!1,!1]):void 0===t&&(n=e.defaultButtonList),n}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(2),i=n(0),a=i.default.MODAL,s=i.default.OVERLAY,c=n(30),l=n(31),u=n(32),f=n(33);e.injectElIntoModal=function(t){var e=o.getNode(a),n=o.stringToNode(t);return e.appendChild(n),n};var d=function(t){t.className=a,t.textContent=""},p=function(t,e){d(t);var n=e.className;n&&t.classList.add(n)};e.initModalContent=function(t){var e=o.getNode(a);p(e,t),c.default(t.icon),l.initTitle(t.title),l.initText(t.text),f.default(t.content),u.default(t.buttons,t.dangerMode)};var m=function(){var t=o.getNode(s),e=o.stringToNode(r.modalMarkup);t.appendChild(e)};e.default=m},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(3),r={isOpen:!1,promise:null,actions:{},timer:null},i=Object.assign({},r);e.resetState=function(){i=Object.assign({},r)},e.setActionValue=function(t){if("string"==typeof t)return a(o.CONFIRM_KEY,t);for(var e in t)a(e,t[e])};var a=function(t,e){i.actions[t]||(i.actions[t]={}),Object.assign(i.actions[t],{value:e})};e.setActionOptionsFor=function(t,e){var n=(void 0===e?{}:e).closeModal,o=void 0===n||n;Object.assign(i.actions[t],{closeModal:o})},e.default=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(3),i=n(0),a=i.default.OVERLAY,s=i.default.SHOW_MODAL,c=i.default.BUTTON,l=i.default.BUTTON_LOADING,u=n(5);e.openModal=function(){o.getNode(a).classList.add(s),u.default.isOpen=!0};var f=function(){o.getNode(a).classList.remove(s),u.default.isOpen=!1};e.onAction=function(t){void 0===t&&(t=r.CANCEL_KEY);var e=u.default.actions[t],n=e.value;if(!1===e.closeModal){var i=c+"--"+t;o.getNode(i).classList.add(l)}else f();u.default.promise.resolve(n)},e.getState=function(){var t=Object.assign({},u.default);return delete t.promise,delete t.timer,t},e.stopLoading=function(){for(var t=document.querySelectorAll("."+c),e=0;e<t.length;e++){t[e].classList.remove(l)}}},function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"==typeof window&&(n=window)}t.exports=n},function(t,e,n){(function(e){t.exports=e.sweetAlert=n(9)}).call(e,n(7))},function(t,e,n){(function(e){t.exports=e.swal=n(10)}).call(e,n(7))},function(t,e,n){"undefined"!=typeof window&&n(11),n(16);var o=n(23).default;t.exports=o},function(t,e,n){var o=n(12);"string"==typeof o&&(o=[[t.i,o,""]]);var r={insertAt:"top"};r.transform=void 0;n(14)(o,r);o.locals&&(t.exports=o.locals)},function(t,e,n){e=t.exports=n(13)(void 0),e.push([t.i,'.swal-icon--error{border-color:#f27474;-webkit-animation:animateErrorIcon .5s;animation:animateErrorIcon .5s}.swal-icon--error__x-mark{position:relative;display:block;-webkit-animation:animateXMark .5s;animation:animateXMark .5s}.swal-icon--error__line{position:absolute;height:5px;width:47px;background-color:#f27474;display:block;top:37px;border-radius:2px}.swal-icon--error__line--left{-webkit-transform:rotate(45deg);transform:rotate(45deg);left:17px}.swal-icon--error__line--right{-webkit-transform:rotate(-45deg);transform:rotate(-45deg);right:16px}@-webkit-keyframes animateErrorIcon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}to{-webkit-transform:rotateX(0deg);transform:rotateX(0deg);opacity:1}}@keyframes animateErrorIcon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}to{-webkit-transform:rotateX(0deg);transform:rotateX(0deg);opacity:1}}@-webkit-keyframes animateXMark{0%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}50%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}80%{-webkit-transform:scale(1.15);transform:scale(1.15);margin-top:-6px}to{-webkit-transform:scale(1);transform:scale(1);margin-top:0;opacity:1}}@keyframes animateXMark{0%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}50%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}80%{-webkit-transform:scale(1.15);transform:scale(1.15);margin-top:-6px}to{-webkit-transform:scale(1);transform:scale(1);margin-top:0;opacity:1}}.swal-icon--warning{border-color:#f8bb86;-webkit-animation:pulseWarning .75s infinite alternate;animation:pulseWarning .75s infinite alternate}.swal-icon--warning__body{width:5px;height:47px;top:10px;border-radius:2px;margin-left:-2px}.swal-icon--warning__body,.swal-icon--warning__dot{position:absolute;left:50%;background-color:#f8bb86}.swal-icon--warning__dot{width:7px;height:7px;border-radius:50%;margin-left:-4px;bottom:-11px}@-webkit-keyframes pulseWarning{0%{border-color:#f8d486}to{border-color:#f8bb86}}@keyframes pulseWarning{0%{border-color:#f8d486}to{border-color:#f8bb86}}.swal-icon--success{border-color:#a5dc86}.swal-icon--success:after,.swal-icon--success:before{content:"";border-radius:50%;position:absolute;width:60px;height:120px;background:#fff;-webkit-transform:rotate(45deg);transform:rotate(45deg)}.swal-icon--success:before{border-radius:120px 0 0 120px;top:-7px;left:-33px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:60px 60px;transform-origin:60px 60px}.swal-icon--success:after{border-radius:0 120px 120px 0;top:-11px;left:30px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:0 60px;transform-origin:0 60px;-webkit-animation:rotatePlaceholder 4.25s ease-in;animation:rotatePlaceholder 4.25s ease-in}.swal-icon--success__ring{width:80px;height:80px;border:4px solid hsla(98,55%,69%,.2);border-radius:50%;box-sizing:content-box;position:absolute;left:-4px;top:-4px;z-index:2}.swal-icon--success__hide-corners{width:5px;height:90px;background-color:#fff;padding:1px;position:absolute;left:28px;top:8px;z-index:1;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.swal-icon--success__line{height:5px;background-color:#a5dc86;display:block;border-radius:2px;position:absolute;z-index:2}.swal-icon--success__line--tip{width:25px;left:14px;top:46px;-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:animateSuccessTip .75s;animation:animateSuccessTip .75s}.swal-icon--success__line--long{width:47px;right:8px;top:38px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:animateSuccessLong .75s;animation:animateSuccessLong .75s}@-webkit-keyframes rotatePlaceholder{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}to{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@keyframes rotatePlaceholder{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}to{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@-webkit-keyframes animateSuccessTip{0%{width:0;left:1px;top:19px}54%{width:0;left:1px;top:19px}70%{width:50px;left:-8px;top:37px}84%{width:17px;left:21px;top:48px}to{width:25px;left:14px;top:45px}}@keyframes animateSuccessTip{0%{width:0;left:1px;top:19px}54%{width:0;left:1px;top:19px}70%{width:50px;left:-8px;top:37px}84%{width:17px;left:21px;top:48px}to{width:25px;left:14px;top:45px}}@-webkit-keyframes animateSuccessLong{0%{width:0;right:46px;top:54px}65%{width:0;right:46px;top:54px}84%{width:55px;right:0;top:35px}to{width:47px;right:8px;top:38px}}@keyframes animateSuccessLong{0%{width:0;right:46px;top:54px}65%{width:0;right:46px;top:54px}84%{width:55px;right:0;top:35px}to{width:47px;right:8px;top:38px}}.swal-icon--info{border-color:#c9dae1}.swal-icon--info:before{width:5px;height:29px;bottom:17px;border-radius:2px;margin-left:-2px}.swal-icon--info:after,.swal-icon--info:before{content:"";position:absolute;left:50%;background-color:#c9dae1}.swal-icon--info:after{width:7px;height:7px;border-radius:50%;margin-left:-3px;top:19px}.swal-icon{width:80px;height:80px;border-width:4px;border-style:solid;border-radius:50%;padding:0;position:relative;box-sizing:content-box;margin:20px auto}.swal-icon:first-child{margin-top:32px}.swal-icon--custom{width:auto;height:auto;max-width:100%;border:none;border-radius:0}.swal-icon img{max-width:100%;max-height:100%}.swal-title{color:rgba(0,0,0,.65);font-weight:600;text-transform:none;position:relative;display:block;padding:13px 16px;font-size:27px;line-height:normal;text-align:center;margin-bottom:0}.swal-title:first-child{margin-top:26px}.swal-title:not(:first-child){padding-bottom:0}.swal-title:not(:last-child){margin-bottom:13px}.swal-text{font-size:16px;position:relative;float:none;line-height:normal;vertical-align:top;text-align:left;display:inline-block;margin:0;padding:0 10px;font-weight:400;color:rgba(0,0,0,.64);max-width:calc(100% - 20px);overflow-wrap:break-word;box-sizing:border-box}.swal-text:first-child{margin-top:45px}.swal-text:last-child{margin-bottom:45px}.swal-footer{text-align:right;padding-top:13px;margin-top:13px;padding:13px 16px;border-radius:inherit;border-top-left-radius:0;border-top-right-radius:0}.swal-button-container{margin:5px;display:inline-block;position:relative}.swal-button{background-color:#7cd1f9;color:#fff;border:none;box-shadow:none;border-radius:5px;font-weight:600;font-size:14px;padding:10px 24px;margin:0;cursor:pointer}.swal-button:not([disabled]):hover{background-color:#78cbf2}.swal-button:active{background-color:#70bce0}.swal-button:focus{outline:none;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(43,114,165,.29)}.swal-button[disabled]{opacity:.5;cursor:default}.swal-button::-moz-focus-inner{border:0}.swal-button--cancel{color:#555;background-color:#efefef}.swal-button--cancel:not([disabled]):hover{background-color:#e8e8e8}.swal-button--cancel:active{background-color:#d7d7d7}.swal-button--cancel:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(116,136,150,.29)}.swal-button--danger{background-color:#e64942}.swal-button--danger:not([disabled]):hover{background-color:#df4740}.swal-button--danger:active{background-color:#cf423b}.swal-button--danger:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(165,43,43,.29)}.swal-content{padding:0 20px;margin-top:20px;font-size:medium}.swal-content:last-child{margin-bottom:20px}.swal-content__input,.swal-content__textarea{-webkit-appearance:none;background-color:#fff;border:none;font-size:14px;display:block;box-sizing:border-box;width:100%;border:1px solid rgba(0,0,0,.14);padding:10px 13px;border-radius:2px;transition:border-color .2s}.swal-content__input:focus,.swal-content__textarea:focus{outline:none;border-color:#6db8ff}.swal-content__textarea{resize:vertical}.swal-button--loading{color:transparent}.swal-button--loading~.swal-button__loader{opacity:1}.swal-button__loader{position:absolute;height:auto;width:43px;z-index:2;left:50%;top:50%;-webkit-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);text-align:center;pointer-events:none;opacity:0}.swal-button__loader div{display:inline-block;float:none;vertical-align:baseline;width:9px;height:9px;padding:0;border:none;margin:2px;opacity:.4;border-radius:7px;background-color:hsla(0,0%,100%,.9);transition:background .2s;-webkit-animation:swal-loading-anim 1s infinite;animation:swal-loading-anim 1s infinite}.swal-button__loader div:nth-child(3n+2){-webkit-animation-delay:.15s;animation-delay:.15s}.swal-button__loader div:nth-child(3n+3){-webkit-animation-delay:.3s;animation-delay:.3s}@-webkit-keyframes swal-loading-anim{0%{opacity:.4}20%{opacity:.4}50%{opacity:1}to{opacity:.4}}@keyframes swal-loading-anim{0%{opacity:.4}20%{opacity:.4}50%{opacity:1}to{opacity:.4}}.swal-overlay{position:fixed;top:0;bottom:0;left:0;right:0;text-align:center;font-size:0;overflow-y:auto;background-color:rgba(0,0,0,.4);z-index:10000;pointer-events:none;opacity:0;transition:opacity .3s}.swal-overlay:before{content:" ";display:inline-block;vertical-align:middle;height:100%}.swal-overlay--show-modal{opacity:1;pointer-events:auto}.swal-overlay--show-modal .swal-modal{opacity:1;pointer-events:auto;box-sizing:border-box;-webkit-animation:showSweetAlert .3s;animation:showSweetAlert .3s;will-change:transform}.swal-modal{width:478px;opacity:0;pointer-events:none;background-color:#fff;text-align:center;border-radius:5px;position:static;margin:20px auto;display:inline-block;vertical-align:middle;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;z-index:10001;transition:opacity .2s,-webkit-transform .3s;transition:transform .3s,opacity .2s;transition:transform .3s,opacity .2s,-webkit-transform .3s}@media (max-width:500px){.swal-modal{width:calc(100% - 20px)}}@-webkit-keyframes showSweetAlert{0%{-webkit-transform:scale(1);transform:scale(1)}1%{-webkit-transform:scale(.5);transform:scale(.5)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}to{-webkit-transform:scale(1);transform:scale(1)}}@keyframes showSweetAlert{0%{-webkit-transform:scale(1);transform:scale(1)}1%{-webkit-transform:scale(.5);transform:scale(.5)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}to{-webkit-transform:scale(1);transform:scale(1)}}',""])},function(t,e){function n(t,e){var n=t[1]||"",r=t[3];if(!r)return n;if(e&&"function"==typeof btoa){var i=o(r);return[n].concat(r.sources.map(function(t){return"/*# sourceURL="+r.sourceRoot+t+" */"})).concat([i]).join("\n")}return[n].join("\n")}function o(t){return"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(t))))+" */"}t.exports=function(t){var e=[];return e.toString=function(){return this.map(function(e){var o=n(e,t);return e[2]?"@media "+e[2]+"{"+o+"}":o}).join("")},e.i=function(t,n){"string"==typeof t&&(t=[[null,t,""]]);for(var o={},r=0;r<this.length;r++){var i=this[r][0];"number"==typeof i&&(o[i]=!0)}for(r=0;r<t.length;r++){var a=t[r];"number"==typeof a[0]&&o[a[0]]||(n&&!a[2]?a[2]=n:n&&(a[2]="("+a[2]+") and ("+n+")"),e.push(a))}},e}},function(t,e,n){function o(t,e){for(var n=0;n<t.length;n++){var o=t[n],r=m[o.id];if(r){r.refs++;for(var i=0;i<r.parts.length;i++)r.parts[i](o.parts[i]);for(;i<o.parts.length;i++)r.parts.push(u(o.parts[i],e))}else{for(var a=[],i=0;i<o.parts.length;i++)a.push(u(o.parts[i],e));m[o.id]={id:o.id,refs:1,parts:a}}}}function r(t,e){for(var n=[],o={},r=0;r<t.length;r++){var i=t[r],a=e.base?i[0]+e.base:i[0],s=i[1],c=i[2],l=i[3],u={css:s,media:c,sourceMap:l};o[a]?o[a].parts.push(u):n.push(o[a]={id:a,parts:[u]})}return n}function i(t,e){var n=v(t.insertInto);if(!n)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var o=w[w.length-1];if("top"===t.insertAt)o?o.nextSibling?n.insertBefore(e,o.nextSibling):n.appendChild(e):n.insertBefore(e,n.firstChild),w.push(e);else{if("bottom"!==t.insertAt)throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");n.appendChild(e)}}function a(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t);var e=w.indexOf(t);e>=0&&w.splice(e,1)}function s(t){var e=document.createElement("style");return t.attrs.type="text/css",l(e,t.attrs),i(t,e),e}function c(t){var e=document.createElement("link");return t.attrs.type="text/css",t.attrs.rel="stylesheet",l(e,t.attrs),i(t,e),e}function l(t,e){Object.keys(e).forEach(function(n){t.setAttribute(n,e[n])})}function u(t,e){var n,o,r,i;if(e.transform&&t.css){if(!(i=e.transform(t.css)))return function(){};t.css=i}if(e.singleton){var l=h++;n=g||(g=s(e)),o=f.bind(null,n,l,!1),r=f.bind(null,n,l,!0)}else t.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(n=c(e),o=p.bind(null,n,e),r=function(){a(n),n.href&&URL.revokeObjectURL(n.href)}):(n=s(e),o=d.bind(null,n),r=function(){a(n)});return o(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;o(t=e)}else r()}}function f(t,e,n,o){var r=n?"":o.css;if(t.styleSheet)t.styleSheet.cssText=x(e,r);else{var i=document.createTextNode(r),a=t.childNodes;a[e]&&t.removeChild(a[e]),a.length?t.insertBefore(i,a[e]):t.appendChild(i)}}function d(t,e){var n=e.css,o=e.media;if(o&&t.setAttribute("media",o),t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}function p(t,e,n){var o=n.css,r=n.sourceMap,i=void 0===e.convertToAbsoluteUrls&&r;(e.convertToAbsoluteUrls||i)&&(o=y(o)),r&&(o+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");var a=new Blob([o],{type:"text/css"}),s=t.href;t.href=URL.createObjectURL(a),s&&URL.revokeObjectURL(s)}var m={},b=function(t){var e;return function(){return void 0===e&&(e=t.apply(this,arguments)),e}}(function(){return window&&document&&document.all&&!window.atob}),v=function(t){var e={};return function(n){return void 0===e[n]&&(e[n]=t.call(this,n)),e[n]}}(function(t){return document.querySelector(t)}),g=null,h=0,w=[],y=n(15);t.exports=function(t,e){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");e=e||{},e.attrs="object"==typeof e.attrs?e.attrs:{},e.singleton||(e.singleton=b()),e.insertInto||(e.insertInto="head"),e.insertAt||(e.insertAt="bottom");var n=r(t,e);return o(n,e),function(t){for(var i=[],a=0;a<n.length;a++){var s=n[a],c=m[s.id];c.refs--,i.push(c)}if(t){o(r(t,e),e)}for(var a=0;a<i.length;a++){var c=i[a];if(0===c.refs){for(var l=0;l<c.parts.length;l++)c.parts[l]();delete m[c.id]}}}};var x=function(){var t=[];return function(e,n){return t[e]=n,t.filter(Boolean).join("\n")}}()},function(t,e){t.exports=function(t){var e="undefined"!=typeof window&&window.location;if(!e)throw new Error("fixUrls requires window.location");if(!t||"string"!=typeof t)return t;var n=e.protocol+"//"+e.host,o=n+e.pathname.replace(/\/[^\/]*$/,"/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,function(t,e){var r=e.trim().replace(/^"(.*)"$/,function(t,e){return e}).replace(/^'(.*)'$/,function(t,e){return e});if(/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(r))return t;var i;return i=0===r.indexOf("//")?r:0===r.indexOf("/")?n+r:o+r.replace(/^\.\//,""),"url("+JSON.stringify(i)+")"})}},function(t,e,n){var o=n(17);"undefined"==typeof window||window.Promise||(window.Promise=o),n(21),String.prototype.includes||(String.prototype.includes=function(t,e){"use strict";return"number"!=typeof e&&(e=0),!(e+t.length>this.length)&&-1!==this.indexOf(t,e)}),Array.prototype.includes||Object.defineProperty(Array.prototype,"includes",{value:function(t,e){if(null==this)throw new TypeError('"this" is null or not defined');var n=Object(this),o=n.length>>>0;if(0===o)return!1;for(var r=0|e,i=Math.max(r>=0?r:o-Math.abs(r),0);i<o;){if(function(t,e){return t===e||"number"==typeof t&&"number"==typeof e&&isNaN(t)&&isNaN(e)}(n[i],t))return!0;i++}return!1}}),"undefined"!=typeof window&&function(t){t.forEach(function(t){t.hasOwnProperty("remove")||Object.defineProperty(t,"remove",{configurable:!0,enumerable:!0,writable:!0,value:function(){this.parentNode.removeChild(this)}})})}([Element.prototype,CharacterData.prototype,DocumentType.prototype])},function(t,e,n){(function(e){!function(n){function o(){}function r(t,e){return function(){t.apply(e,arguments)}}function i(t){if("object"!=typeof this)throw new TypeError("Promises must be constructed via new");if("function"!=typeof t)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=void 0,this._deferreds=[],f(t,this)}function a(t,e){for(;3===t._state;)t=t._value;if(0===t._state)return void t._deferreds.push(e);t._handled=!0,i._immediateFn(function(){var n=1===t._state?e.onFulfilled:e.onRejected;if(null===n)return void(1===t._state?s:c)(e.promise,t._value);var o;try{o=n(t._value)}catch(t){return void c(e.promise,t)}s(e.promise,o)})}function s(t,e){try{if(e===t)throw new TypeError("A promise cannot be resolved with itself.");if(e&&("object"==typeof e||"function"==typeof e)){var n=e.then;if(e instanceof i)return t._state=3,t._value=e,void l(t);if("function"==typeof n)return void f(r(n,e),t)}t._state=1,t._value=e,l(t)}catch(e){c(t,e)}}function c(t,e){t._state=2,t._value=e,l(t)}function l(t){2===t._state&&0===t._deferreds.length&&i._immediateFn(function(){t._handled||i._unhandledRejectionFn(t._value)});for(var e=0,n=t._deferreds.length;e<n;e++)a(t,t._deferreds[e]);t._deferreds=null}function u(t,e,n){this.onFulfilled="function"==typeof t?t:null,this.onRejected="function"==typeof e?e:null,this.promise=n}function f(t,e){var n=!1;try{t(function(t){n||(n=!0,s(e,t))},function(t){n||(n=!0,c(e,t))})}catch(t){if(n)return;n=!0,c(e,t)}}var d=setTimeout;i.prototype.catch=function(t){return this.then(null,t)},i.prototype.then=function(t,e){var n=new this.constructor(o);return a(this,new u(t,e,n)),n},i.all=function(t){var e=Array.prototype.slice.call(t);return new i(function(t,n){function o(i,a){try{if(a&&("object"==typeof a||"function"==typeof a)){var s=a.then;if("function"==typeof s)return void s.call(a,function(t){o(i,t)},n)}e[i]=a,0==--r&&t(e)}catch(t){n(t)}}if(0===e.length)return t([]);for(var r=e.length,i=0;i<e.length;i++)o(i,e[i])})},i.resolve=function(t){return t&&"object"==typeof t&&t.constructor===i?t:new i(function(e){e(t)})},i.reject=function(t){return new i(function(e,n){n(t)})},i.race=function(t){return new i(function(e,n){for(var o=0,r=t.length;o<r;o++)t[o].then(e,n)})},i._immediateFn="function"==typeof e&&function(t){e(t)}||function(t){d(t,0)},i._unhandledRejectionFn=function(t){"undefined"!=typeof console&&console&&console.warn("Possible Unhandled Promise Rejection:",t)},i._setImmediateFn=function(t){i._immediateFn=t},i._setUnhandledRejectionFn=function(t){i._unhandledRejectionFn=t},void 0!==t&&t.exports?t.exports=i:n.Promise||(n.Promise=i)}(this)}).call(e,n(18).setImmediate)},function(t,e,n){function o(t,e){this._id=t,this._clearFn=e}var r=Function.prototype.apply;e.setTimeout=function(){return new o(r.call(setTimeout,window,arguments),clearTimeout)},e.setInterval=function(){return new o(r.call(setInterval,window,arguments),clearInterval)},e.clearTimeout=e.clearInterval=function(t){t&&t.close()},o.prototype.unref=o.prototype.ref=function(){},o.prototype.close=function(){this._clearFn.call(window,this._id)},e.enroll=function(t,e){clearTimeout(t._idleTimeoutId),t._idleTimeout=e},e.unenroll=function(t){clearTimeout(t._idleTimeoutId),t._idleTimeout=-1},e._unrefActive=e.active=function(t){clearTimeout(t._idleTimeoutId);var e=t._idleTimeout;e>=0&&(t._idleTimeoutId=setTimeout(function(){t._onTimeout&&t._onTimeout()},e))},n(19),e.setImmediate=setImmediate,e.clearImmediate=clearImmediate},function(t,e,n){(function(t,e){!function(t,n){"use strict";function o(t){"function"!=typeof t&&(t=new Function(""+t));for(var e=new Array(arguments.length-1),n=0;n<e.length;n++)e[n]=arguments[n+1];var o={callback:t,args:e};return l[c]=o,s(c),c++}function r(t){delete l[t]}function i(t){var e=t.callback,o=t.args;switch(o.length){case 0:e();break;case 1:e(o[0]);break;case 2:e(o[0],o[1]);break;case 3:e(o[0],o[1],o[2]);break;default:e.apply(n,o)}}function a(t){if(u)setTimeout(a,0,t);else{var e=l[t];if(e){u=!0;try{i(e)}finally{r(t),u=!1}}}}if(!t.setImmediate){var s,c=1,l={},u=!1,f=t.document,d=Object.getPrototypeOf&&Object.getPrototypeOf(t);d=d&&d.setTimeout?d:t,"[object process]"==={}.toString.call(t.process)?function(){s=function(t){e.nextTick(function(){a(t)})}}():function(){if(t.postMessage&&!t.importScripts){var e=!0,n=t.onmessage;return t.onmessage=function(){e=!1},t.postMessage("","*"),t.onmessage=n,e}}()?function(){var e="setImmediate$"+Math.random()+"$",n=function(n){n.source===t&&"string"==typeof n.data&&0===n.data.indexOf(e)&&a(+n.data.slice(e.length))};t.addEventListener?t.addEventListener("message",n,!1):t.attachEvent("onmessage",n),s=function(n){t.postMessage(e+n,"*")}}():t.MessageChannel?function(){var t=new MessageChannel;t.port1.onmessage=function(t){a(t.data)},s=function(e){t.port2.postMessage(e)}}():f&&"onreadystatechange"in f.createElement("script")?function(){var t=f.documentElement;s=function(e){var n=f.createElement("script");n.onreadystatechange=function(){a(e),n.onreadystatechange=null,t.removeChild(n),n=null},t.appendChild(n)}}():function(){s=function(t){setTimeout(a,0,t)}}(),d.setImmediate=o,d.clearImmediate=r}}("undefined"==typeof self?void 0===t?this:t:self)}).call(e,n(7),n(20))},function(t,e){function n(){throw new Error("setTimeout has not been defined")}function o(){throw new Error("clearTimeout has not been defined")}function r(t){if(u===setTimeout)return setTimeout(t,0);if((u===n||!u)&&setTimeout)return u=setTimeout,setTimeout(t,0);try{return u(t,0)}catch(e){try{return u.call(null,t,0)}catch(e){return u.call(this,t,0)}}}function i(t){if(f===clearTimeout)return clearTimeout(t);if((f===o||!f)&&clearTimeout)return f=clearTimeout,clearTimeout(t);try{return f(t)}catch(e){try{return f.call(null,t)}catch(e){return f.call(this,t)}}}function a(){b&&p&&(b=!1,p.length?m=p.concat(m):v=-1,m.length&&s())}function s(){if(!b){var t=r(a);b=!0;for(var e=m.length;e;){for(p=m,m=[];++v<e;)p&&p[v].run();v=-1,e=m.length}p=null,b=!1,i(t)}}function c(t,e){this.fun=t,this.array=e}function l(){}var u,f,d=t.exports={};!function(){try{u="function"==typeof setTimeout?setTimeout:n}catch(t){u=n}try{f="function"==typeof clearTimeout?clearTimeout:o}catch(t){f=o}}();var p,m=[],b=!1,v=-1;d.nextTick=function(t){var e=new Array(arguments.length-1);if(arguments.length>1)for(var n=1;n<arguments.length;n++)e[n-1]=arguments[n];m.push(new c(t,e)),1!==m.length||b||r(s)},c.prototype.run=function(){this.fun.apply(null,this.array)},d.title="browser",d.browser=!0,d.env={},d.argv=[],d.version="",d.versions={},d.on=l,d.addListener=l,d.once=l,d.off=l,d.removeListener=l,d.removeAllListeners=l,d.emit=l,d.prependListener=l,d.prependOnceListener=l,d.listeners=function(t){return[]},d.binding=function(t){throw new Error("process.binding is not supported")},d.cwd=function(){return"/"},d.chdir=function(t){throw new Error("process.chdir is not supported")},d.umask=function(){return 0}},function(t,e,n){"use strict";n(22).polyfill()},function(t,e,n){"use strict";function o(t,e){if(void 0===t||null===t)throw new TypeError("Cannot convert first argument to object");for(var n=Object(t),o=1;o<arguments.length;o++){var r=arguments[o];if(void 0!==r&&null!==r)for(var i=Object.keys(Object(r)),a=0,s=i.length;a<s;a++){var c=i[a],l=Object.getOwnPropertyDescriptor(r,c);void 0!==l&&l.enumerable&&(n[c]=r[c])}}return n}function r(){Object.assign||Object.defineProperty(Object,"assign",{enumerable:!1,configurable:!0,writable:!0,value:o})}t.exports={assign:o,polyfill:r}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(24),r=n(6),i=n(5),a=n(36),s=function(){for(var t=[],e=0;e<arguments.length;e++)t[e]=arguments[e];if("undefined"!=typeof window){var n=a.getOpts.apply(void 0,t);return new Promise(function(t,e){i.default.promise={resolve:t,reject:e},o.default(n),setTimeout(function(){r.openModal()})})}};s.close=r.onAction,s.getState=r.getState,s.setActionValue=i.setActionValue,s.stopLoading=r.stopLoading,s.setDefaults=a.setDefaults,e.default=s},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(0),i=r.default.MODAL,a=n(4),s=n(34),c=n(35),l=n(1);e.init=function(t){o.getNode(i)||(document.body||l.throwErr("You can only use SweetAlert AFTER the DOM has loaded!"),s.default(),a.default()),a.initModalContent(t),c.default(t)},e.default=e.init},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(0),r=o.default.MODAL;e.modalMarkup='\n  <div class="'+r+'" role="dialog" aria-modal="true"></div>',e.default=e.modalMarkup},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(0),r=o.default.OVERLAY,i='<div \n    class="'+r+'"\n    tabIndex="-1">\n  </div>';e.default=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(0),r=o.default.ICON;e.errorIconMarkup=function(){var t=r+"--error",e=t+"__line";return'\n    <div class="'+t+'__x-mark">\n      <span class="'+e+" "+e+'--left"></span>\n      <span class="'+e+" "+e+'--right"></span>\n    </div>\n  '},e.warningIconMarkup=function(){var t=r+"--warning";return'\n    <span class="'+t+'__body">\n      <span class="'+t+'__dot"></span>\n    </span>\n  '},e.successIconMarkup=function(){var t=r+"--success";return'\n    <span class="'+t+"__line "+t+'__line--long"></span>\n    <span class="'+t+"__line "+t+'__line--tip"></span>\n\n    <div class="'+t+'__ring"></div>\n    <div class="'+t+'__hide-corners"></div>\n  '}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(0),r=o.default.CONTENT;e.contentMarkup='\n  <div class="'+r+'">\n\n  </div>\n'},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(0),r=o.default.BUTTON_CONTAINER,i=o.default.BUTTON,a=o.default.BUTTON_LOADER;e.buttonMarkup='\n  <div class="'+r+'">\n\n    <button\n      class="'+i+'"\n    ></button>\n\n    <div class="'+a+'">\n      <div></div>\n      <div></div>\n      <div></div>\n    </div>\n\n  </div>\n'},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(4),r=n(2),i=n(0),a=i.default.ICON,s=i.default.ICON_CUSTOM,c=["error","warning","success","info"],l={error:r.errorIconMarkup(),warning:r.warningIconMarkup(),success:r.successIconMarkup()},u=function(t,e){var n=a+"--"+t;e.classList.add(n);var o=l[t];o&&(e.innerHTML=o)},f=function(t,e){e.classList.add(s);var n=document.createElement("img");n.src=t,e.appendChild(n)},d=function(t){if(t){var e=o.injectElIntoModal(r.iconMarkup);c.includes(t)?u(t,e):f(t,e)}};e.default=d},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(2),r=n(4),i=function(t){navigator.userAgent.includes("AppleWebKit")&&(t.style.display="none",t.offsetHeight,t.style.display="")};e.initTitle=function(t){if(t){var e=r.injectElIntoModal(o.titleMarkup);e.textContent=t,i(e)}},e.initText=function(t){if(t){var e=document.createDocumentFragment();t.split("\n").forEach(function(t,n,o){e.appendChild(document.createTextNode(t)),n<o.length-1&&e.appendChild(document.createElement("br"))});var n=r.injectElIntoModal(o.textMarkup);n.appendChild(e),i(n)}}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(4),i=n(0),a=i.default.BUTTON,s=i.default.DANGER_BUTTON,c=n(3),l=n(2),u=n(6),f=n(5),d=function(t,e,n){var r=e.text,i=e.value,d=e.className,p=e.closeModal,m=o.stringToNode(l.buttonMarkup),b=m.querySelector("."+a),v=a+"--"+t;if(b.classList.add(v),d){(Array.isArray(d)?d:d.split(" ")).filter(function(t){return t.length>0}).forEach(function(t){b.classList.add(t)})}n&&t===c.CONFIRM_KEY&&b.classList.add(s),b.textContent=r;var g={};return g[t]=i,f.setActionValue(g),f.setActionOptionsFor(t,{closeModal:p}),b.addEventListener("click",function(){return u.onAction(t)}),m},p=function(t,e){var n=r.injectElIntoModal(l.footerMarkup);for(var o in t){var i=t[o],a=d(o,i,e);i.visible&&n.appendChild(a)}0===n.children.length&&n.remove()};e.default=p},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(3),r=n(4),i=n(2),a=n(5),s=n(6),c=n(0),l=c.default.CONTENT,u=function(t){t.addEventListener("input",function(t){var e=t.target,n=e.value;a.setActionValue(n)}),t.addEventListener("keyup",function(t){if("Enter"===t.key)return s.onAction(o.CONFIRM_KEY)}),setTimeout(function(){t.focus(),a.setActionValue("")},0)},f=function(t,e,n){var o=document.createElement(e),r=l+"__"+e;o.classList.add(r);for(var i in n){var a=n[i];o[i]=a}"input"===e&&u(o),t.appendChild(o)},d=function(t){if(t){var e=r.injectElIntoModal(i.contentMarkup),n=t.element,o=t.attributes;"string"==typeof n?f(e,n,o):e.appendChild(n)}};e.default=d},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(2),i=function(){var t=o.stringToNode(r.overlayMarkup);document.body.appendChild(t)};e.default=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(5),r=n(6),i=n(1),a=n(3),s=n(0),c=s.default.MODAL,l=s.default.BUTTON,u=s.default.OVERLAY,f=function(t){t.preventDefault(),v()},d=function(t){t.preventDefault(),g()},p=function(t){if(o.default.isOpen)switch(t.key){case"Escape":return r.onAction(a.CANCEL_KEY)}},m=function(t){if(o.default.isOpen)switch(t.key){case"Tab":return f(t)}},b=function(t){if(o.default.isOpen)return"Tab"===t.key&&t.shiftKey?d(t):void 0},v=function(){var t=i.getNode(l);t&&(t.tabIndex=0,t.focus())},g=function(){var t=i.getNode(c),e=t.querySelectorAll("."+l),n=e.length-1,o=e[n];o&&o.focus()},h=function(t){t[t.length-1].addEventListener("keydown",m)},w=function(t){t[0].addEventListener("keydown",b)},y=function(){var t=i.getNode(c),e=t.querySelectorAll("."+l);e.length&&(h(e),w(e))},x=function(t){if(i.getNode(u)===t.target)return r.onAction(a.CANCEL_KEY)},_=function(t){var e=i.getNode(u);e.removeEventListener("click",x),t&&e.addEventListener("click",x)},k=function(t){o.default.timer&&clearTimeout(o.default.timer),t&&(o.default.timer=window.setTimeout(function(){return r.onAction(a.CANCEL_KEY)},t))},O=function(t){t.closeOnEsc?document.addEventListener("keyup",p):document.removeEventListener("keyup",p),t.dangerMode?v():g(),y(),_(t.closeOnClickOutside),k(t.timer)};e.default=O},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r=n(3),i=n(37),a=n(38),s={title:null,text:null,icon:null,buttons:r.defaultButtonList,content:null,className:null,closeOnClickOutside:!0,closeOnEsc:!0,dangerMode:!1,timer:null},c=Object.assign({},s);e.setDefaults=function(t){c=Object.assign({},s,t)};var l=function(t){var e=t&&t.button,n=t&&t.buttons;return void 0!==e&&void 0!==n&&o.throwErr("Cannot set both 'button' and 'buttons' options!"),void 0!==e?{confirm:e}:n},u=function(t){return o.ordinalSuffixOf(t+1)},f=function(t,e){o.throwErr(u(e)+" argument ('"+t+"') is invalid")},d=function(t,e){var n=t+1,r=e[n];o.isPlainObject(r)||void 0===r||o.throwErr("Expected "+u(n)+" argument ('"+r+"') to be a plain object")},p=function(t,e){var n=t+1,r=e[n];void 0!==r&&o.throwErr("Unexpected "+u(n)+" argument ("+r+")")},m=function(t,e,n,r){var i=typeof e,a="string"===i,s=e instanceof Element;if(a){if(0===n)return{text:e};if(1===n)return{text:e,title:r[0]};if(2===n)return d(n,r),{icon:e};f(e,n)}else{if(s&&0===n)return d(n,r),{content:e};if(o.isPlainObject(e))return p(n,r),e;f(e,n)}};e.getOpts=function(){for(var t=[],e=0;e<arguments.length;e++)t[e]=arguments[e];var n={};t.forEach(function(e,o){var r=m(0,e,o,t);Object.assign(n,r)});var o=l(n);n.buttons=r.getButtonListOpts(o),delete n.button,n.content=i.getContentOpts(n.content);var u=Object.assign({},s,c,n);return Object.keys(u).forEach(function(t){a.DEPRECATED_OPTS[t]&&a.logDeprecation(t)}),u}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(1),r={element:"input",attributes:{placeholder:""}};e.getContentOpts=function(t){var e={};return o.isPlainObject(t)?Object.assign(e,t):t instanceof Element?{element:t}:"input"===t?r:null}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.logDeprecation=function(t){var n=e.DEPRECATED_OPTS[t],o=n.onlyRename,r=n.replacement,i=n.subOption,a=n.link,s=o?"renamed":"deprecated",c='SweetAlert warning: "'+t+'" option has been '+s+".";if(r){c+=" Please use"+(i?' "'+i+'" in ':" ")+'"'+r+'" instead.'}var l="https://sweetalert.js.org";c+=a?" More details: "+l+a:" More details: "+l+"/guides/#upgrading-from-1x",console.warn(c)},e.DEPRECATED_OPTS={type:{replacement:"icon",link:"/docs/#icon"},imageUrl:{replacement:"icon",link:"/docs/#icon"},customClass:{replacement:"className",onlyRename:!0,link:"/docs/#classname"},imageSize:{},showCancelButton:{replacement:"buttons",link:"/docs/#buttons"},showConfirmButton:{replacement:"button",link:"/docs/#button"},confirmButtonText:{replacement:"button",link:"/docs/#button"},confirmButtonColor:{},cancelButtonText:{replacement:"buttons",link:"/docs/#buttons"},closeOnConfirm:{replacement:"button",subOption:"closeModal",link:"/docs/#button"},closeOnCancel:{replacement:"buttons",subOption:"closeModal",link:"/docs/#buttons"},showLoaderOnConfirm:{replacement:"buttons"},animation:{},inputType:{replacement:"content",link:"/docs/#content"},inputValue:{replacement:"content",link:"/docs/#content"},inputPlaceholder:{replacement:"content",link:"/docs/#content"},html:{replacement:"content",link:"/docs/#content"},allowEscapeKey:{replacement:"closeOnEsc",onlyRename:!0,link:"/docs/#closeonesc"},allowClickOutside:{replacement:"closeOnClickOutside",onlyRename:!0,link:"/docs/#closeonclickoutside"}}}])});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/timers-browserify/main.js").setImmediate, __webpack_require__("./node_modules/timers-browserify/main.js").clearImmediate))

/***/ }),

/***/ "./node_modules/timers-browserify/main.js":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__("./node_modules/setimmediate/setImmediate.js");
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./resources/assets/h5/js/app.js":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/h5/js/bootstrap.js");

$(function () {
    $('.course-menu-item').tap(function () {
        var page = $(this).attr('data-page');
        $('.' + page).show().siblings().hide();
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('body').on('tap', '.promo-code-check-button', function () {
        var promoCode = $('input[name="promo_code"]').val();
        if (promoCode === '') {
            return;
        }
        var url = $(this).attr('data-url');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            promo_code: promoCode,
            _token: token
        }, function (res) {
            if (res.code === 0) {
                var discount = res.data.discount;
                var total = $('.total-price').attr('data-total');
                var m = total - discount;
                m = m > 0 ? m : 0;
                $('.promo-code-info').text('此邀请码有效，已抵扣' + discount + '元').show();
                $('.promo-code-price-text').text(discount);
                $('.total-price').text(m);
                $('input[name="promo_code_id"]').val(res.data.id);
            } else {
                $('.promo-code-info').text(res.message).show();
                $('.promo-code-price-text').text(0);
                $('.total-price').text($('.total-price').attr('data-total'));
                $('input[name="promo_code_id"]').val('');
            }
        }, 'json');
    }).on('tap', '.captcha', function () {
        var src = $(this).attr('src');
        if (src.indexOf('?') !== -1) {
            src = src + "&1";
        } else {
            src = src + "?" + Date.now();
        }
        $(this).attr('src', src);
        $('input[name="captcha"]').val('');
    }).on('tap', '.send-sms-captcha', function () {
        var _this = this;

        var SMS_CYCLE_TIME = 120;
        var SMS_CURRENT_TIME = 0;

        var imageCaptcha = $('input[name="captcha"]').val();
        var mobile = $('input[name="mobile"]').val();
        if (imageCaptcha === '' || mobile === '') {
            flashWarning('请输入手机号和图形验证码');
            return;
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $(this).attr('disabled', true);
        $.post('/sms/send', {
            mobile: mobile,
            captcha: imageCaptcha,
            method: $('input[name="sms_captcha_key"]').val(),
            _token: token
        }, function (res) {
            if (res.code !== 0) {
                $(_this).attr('disabled', false);
                flashError(res.message);
                $('.captcha').tap();
                return;
            }

            SMS_CURRENT_TIME = SMS_CYCLE_TIME;
            var smsInterval = setInterval(function () {
                if (SMS_CURRENT_TIME <= 1) {
                    $(_this).text('发送验证码');
                    $(_this).attr('disabled', false);
                    clearInterval(smsInterval);
                    return;
                }
                SMS_CURRENT_TIME = SMS_CURRENT_TIME - 1;
                $(_this).text(SMS_CURRENT_TIME + 's');
                $(_this).attr('disabled', true);
            }, 1000);
        }, 'json');
    }).on('tap', '.show-buy-course-model', function () {
        $('.buy-course-model').show();
    }).on('tap', '.buy-course-model .close', function () {
        $('.buy-course-model').hide();
    }).on('tap', '.role-item', function () {
        $(this).addClass('active').siblings().removeClass('active');
        $('.role-subscribe-button').attr('href', $(this).attr('data-url'));
    }).on('tap', '.payment-item', function () {
        $(this).addClass('active').siblings().removeClass('active');
        $('input[name="payment_sign"]').val($(this).attr('data-payment'));
    }).on('tap', '.pay-button', function () {
        $('.create-order-form').submit();
    }).on('submit', '.create-order-form', function () {
        var paymentSign = $('input[name="payment_sign"]').val();
        if (paymentSign.length === 0) {
            flashWarning('请选择支付方式');
            return false;
        }
    });
});

/***/ }),

/***/ "./resources/assets/h5/js/bootstrap.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_sweetalert__ = __webpack_require__("./node_modules/sweetalert/dist/sweetalert.min.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_sweetalert___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_sweetalert__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_xgplayer__ = __webpack_require__("./node_modules/_xgplayer@2.6.15@xgplayer/dist/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_xgplayer___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_xgplayer__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_xgplayer_mp4__ = __webpack_require__("./node_modules/_xgplayer-mp4@1.1.8@xgplayer-mp4/dist/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_xgplayer_mp4___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_xgplayer_mp4__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_xgplayer_hls_js__ = __webpack_require__("./node_modules/_xgplayer-hls.js@2.1.6@xgplayer-hls.js/dist/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_xgplayer_hls_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_xgplayer_hls_js__);






window.Player = __WEBPACK_IMPORTED_MODULE_1_xgplayer___default.a;
window.HlsJsPlayer = __WEBPACK_IMPORTED_MODULE_3_xgplayer_hls_js___default.a;

window.flashSuccess = function (message) {
    __WEBPACK_IMPORTED_MODULE_0_sweetalert___default()('成功', message, 'success');
};
window.flashWarning = function (message) {
    __WEBPACK_IMPORTED_MODULE_0_sweetalert___default()('警告', message, 'warning');
};
window.flashError = function (message) {
    __WEBPACK_IMPORTED_MODULE_0_sweetalert___default()('失败', message, 'error');
};

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/h5/js/app.js");


/***/ })

/******/ });