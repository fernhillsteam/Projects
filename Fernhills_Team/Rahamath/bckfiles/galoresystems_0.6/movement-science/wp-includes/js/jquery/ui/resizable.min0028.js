/*!
 * jQuery UI Resizable 1.13.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./mouse","./core"],t):t(jQuery)}(function(z){"use strict";return z.widget("ui.resizable",z.ui.mouse,{version:"1.13.1",widgetEventPrefix:"resize",options:{alsoResize:!1,animate:!1,animateDuration:"slow",animateEasing:"swing",aspectRatio:!1,autoHide:!1,classes:{"ui-resizable-se":"ui-icon ui-icon-gripsmall-diagonal-se"},containment:!1,ghost:!1,grid:!1,handles:"e,s,se",helper:!1,maxHeight:null,maxWidth:null,minHeight:10,minWidth:10,zIndex:90,resize:null,start:null,stop:null},_num:function(t){return parseFloat(t)||0},_isNumber:function(t){return!isNaN(parseFloat(t))},_hasScroll:function(t,i){if("hidden"===z(t).css("overflow"))return!1;var e=i&&"left"===i?"scrollLeft":"scrollTop",i=!1;if(0<t[e])return!0;try{t[e]=1,i=0<t[e],t[e]=0}catch(t){}return i},_create:function(){var t,i=this.options,e=this;this._addClass("ui-resizable"),z.extend(this,{_aspectRatio:!!i.aspectRatio,aspectRatio:i.aspectRatio,originalElement:this.element,_proportionallyResizeElements:[],_helper:i.helper||i.ghost||i.animate?i.helper||"ui-resizable-helper":null}),this.element[0].nodeName.match(/^(canvas|textarea|input|select|button|img)$/i)&&(this.element.wrap(z("<div class='ui-wrapper'></div>").css({overflow:"hidden",position:this.element.css("position"),width:this.element.outerWidth(),height:this.element.outerHeight(),top:this.element.css("top"),left:this.element.css("left")})),this.element=this.element.parent().data("ui-resizable",this.element.resizable("instance")),this.elementIsWrapper=!0,t={marginTop:this.originalElement.css("marginTop"),marginRight:this.originalElement.css("marginRight"),marginBottom:this.originalElement.css("marginBottom"),marginLeft:this.originalElement.css("marginLeft")},this.element.css(t),this.originalElement.css("margin",0),this.originalResizeStyle=this.originalElement.css("resize"),this.originalElement.css("resize","none"),this._proportionallyResizeElements.push(this.originalElement.css({position:"static",zoom:1,display:"block"})),this.originalElement.css(t),this._proportionallyResize()),this._setupHandles(),i.autoHide&&z(this.element).on("mouseenter",function(){i.disabled||(e._removeClass("ui-resizable-autohide"),e._handles.show())}).on("mouseleave",function(){i.disabled||e.resizing||(e._addClass("ui-resizable-autohide"),e._handles.hide())}),this._mouseInit()},_destroy:function(){this._mouseDestroy(),this._addedHandles.remove();function t(t){z(t).removeData("resizable").removeData("ui-resizable").off(".resizable")}var i;return this.elementIsWrapper&&(t(this.element),i=this.element,this.originalElement.css({position:i.css("position"),width:i.outerWidth(),height:i.outerHeight(),top:i.css("top"),left:i.css("left")}).insertAfter(i),i.remove()),this.originalElement.css("resize",this.originalResizeStyle),t(this.originalElement),this},_setOption:function(t,i){switch(this._super(t,i),t){case"handles":this._removeHandles(),this._setupHandles();break;case"aspectRatio":this._aspectRatio=!!i}},_setupHandles:function(){var t,i,e,s,h,n=this.options,o=this;if(this.handles=n.handles||(z(".ui-resizable-handle",this.element).length?{n:".ui-resizable-n",e:".ui-resizable-e",s:".ui-resizable-s",w:".ui-resizable-w",se:".ui-resizable-se",sw:".ui-resizable-sw",ne:".ui-resizable-ne",nw:".ui-resizable-nw"}:"e,s,se"),this._handles=z(),this._addedHandles=z(),this.handles.constructor===String)for("all"===this.handles&&(this.handles="n,e,s,w,se,sw,ne,nw"),e=this.handles.split(","),this.handles={},i=0;i<e.length;i++)s="ui-resizable-"+(t=String.prototype.trim.call(e[i])),h=z("<div>"),this._addClass(h,"ui-resizable-handle "+s),h.css({zIndex:n.zIndex}),this.handles[t]=".ui-resizable-"+t,this.element.children(this.handles[t]).length||(this.element.append(h),this._addedHandles=this._addedHandles.add(h));this._renderAxis=function(t){var i,e,s;for(i in t=t||this.element,this.handles)this.handles[i].constructor===String?this.handles[i]=this.element.children(this.handles[i]).first().show():(this.handles[i].jquery||this.handles[i].nodeType)&&(this.handles[i]=z(this.handles[i]),this._on(this.handles[i],{mousedown:o._mouseDown})),this.elementIsWrapper&&this.originalElement[0].nodeName.match(/^(textarea|input|select|button)$/i)&&(e=z(this.handles[i],this.element),s=/sw|ne|nw|se|n|s/.test(i)?e.outerHeight():e.outerWidth(),e=["padding",/ne|nw|n/.test(i)?"Top":/se|sw|s/.test(i)?"Bottom":/^e$/.test(i)?"Right":"Left"].join(""),t.css(e,s),this._proportionallyResize()),this._handles=this._handles.add(this.handles[i])},this._renderAxis(this.element),this._handles=this._handles.add(this.element.find(".ui-resizable-handle")),this._handles.disableSelection(),this._handles.on("mouseover",function(){o.resizing||(this.className&&(h=this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)),o.axis=h&&h[1]?h[1]:"se")}),n.autoHide&&(this._handles.hide(),this._addClass("ui-resizable-autohide"))},_removeHandles:function(){this._addedHandles.remove()},_mouseCapture:function(t){var i,e,s=!1;for(i in this.handles)(e=z(this.handles[i])[0])!==t.target&&!z.contains(e,t.target)||(s=!0);return!this.options.disabled&&s},_mouseStart:function(t){var i,e,s=this.options,h=this.element;return this.resizing=!0,this._renderProxy(),i=this._num(this.helper.css("left")),e=this._num(this.helper.css("top")),s.containment&&(i+=z(s.containment).scrollLeft()||0,e+=z(s.containment).scrollTop()||0),this.offset=this.helper.offset(),this.position={left:i,top:e},this.size=this._helper?{width:this.helper.width(),height:this.helper.height()}:{width:h.width(),height:h.height()},this.originalSize=this._helper?{width:h.outerWidth(),height:h.outerHeight()}:{width:h.width(),height:h.height()},this.sizeDiff={width:h.outerWidth()-h.width(),height:h.outerHeight()-h.height()},this.originalPosition={left:i,top:e},this.originalMousePosition={left:t.pageX,top:t.pageY},this.aspectRatio="number"==typeof s.aspectRatio?s.aspectRatio:this.originalSize.width/this.originalSize.height||1,s=z(".ui-resizable-"+this.axis).css("cursor"),z("body").css("cursor","auto"===s?this.axis+"-resize":s),this._addClass("ui-resizable-resizing"),this._propagate("start",t),!0},_mouseDrag:function(t){var i=this.originalMousePosition,e=this.axis,s=t.pageX-i.left||0,i=t.pageY-i.top||0,e=this._change[e];return this._updatePrevProperties(),e&&(i=e.apply(this,[t,s,i]),this._updateVirtualBoundaries(t.shiftKey),(this._aspectRatio||t.shiftKey)&&(i=this._updateRatio(i,t)),i=this._respectSize(i,t),this._updateCache(i),this._propagate("resize",t),i=this._applyChanges(),!this._helper&&this._proportionallyResizeElements.length&&this._proportionallyResize(),z.isEmptyObject(i)||(this._updatePrevProperties(),this._trigger("resize",t,this.ui()),this._applyChanges())),!1},_mouseStop:function(t){this.resizing=!1;var i,e,s,h=this.options,n=this;return this._helper&&(s=(i=(e=this._proportionallyResizeElements).length&&/textarea/i.test(e[0].nodeName))&&this._hasScroll(e[0],"left")?0:n.sizeDiff.height,e=i?0:n.sizeDiff.width,i={width:n.helper.width()-e,height:n.helper.height()-s},e=parseFloat(n.element.css("left"))+(n.position.left-n.originalPosition.left)||null,s=parseFloat(n.element.css("top"))+(n.position.top-n.originalPosition.top)||null,h.animate||this.element.css(z.extend(i,{top:s,left:e})),n.helper.height(n.size.height),n.helper.width(n.size.width),this._helper&&!h.animate&&this._proportionallyResize()),z("body").css("cursor","auto"),this._removeClass("ui-resizable-resizing"),this._propagate("stop",t),this._helper&&this.helper.remove(),!1},_updatePrevProperties:function(){this.prevPosition={top:this.position.top,left:this.position.left},this.prevSize={width:this.size.width,height:this.size.height}},_applyChanges:function(){var t={};return this.position.top!==this.prevPosition.top&&(t.top=this.position.top+"px"),this.position.left!==this.prevPosition.left&&(t.left=this.position.left+"px"),this.size.width!==this.prevSize.width&&(t.width=this.size.width+"px"),this.size.height!==this.prevSize.height&&(t.height=this.size.height+"px"),this.helper.css(t),t},_updateVirtualBoundaries:function(t){var i,e,s=this.options,h={minWidth:this._isNumber(s.minWidth)?s.minWidth:0,maxWidth:this._isNumber(s.maxWidth)?s.maxWidth:1/0,minHeight:this._isNumber(s.minHeight)?s.minHeight:0,maxHeight:this._isNumber(s.maxHeight)?s.maxHeight:1/0};(this._aspectRatio||t)&&(i=h.minHeight*this.aspectRatio,e=h.minWidth/this.aspectRatio,s=h.maxHeight*this.aspectRatio,t=h.maxWidth/this.aspectRatio,i>h.minWidth&&(h.minWidth=i),e>h.minHeight&&(h.minHeight=e),s<h.maxWidth&&(h.maxWidth=s),t<h.maxHeight&&(h.maxHeight=t)),this._vBoundaries=h},_updateCache:function(t){this.offset=this.helper.offset(),this._isNumber(t.left)&&(this.position.left=t.left),this._isNumber(t.top)&&(this.position.top=t.top),this._isNumber(t.height)&&(this.size.height=t.height),this._isNumber(t.width)&&(this.size.width=t.width)},_updateRatio:function(t){var i=this.position,e=this.size,s=this.axis;return this._isNumber(t.height)?t.width=t.height*this.aspectRatio:this._isNumber(t.width)&&(t.height=t.width/this.aspectRatio),"sw"===s&&(t.left=i.left+(e.width-t.width),t.top=null),"nw"===s&&(t.top=i.top+(e.height-t.height),t.left=i.left+(e.width-t.width)),t},_respectSize:function(t){var i=this._vBoundaries,e=this.axis,s=this._isNumber(t.width)&&i.maxWidth&&i.maxWidth<t.width,h=this._isNumber(t.height)&&i.maxHeight&&i.maxHeight<t.height,n=this._isNumber(t.width)&&i.minWidth&&i.minWidth>t.width,o=this._isNumber(t.height)&&i.minHeight&&i.minHeight>t.height,a=this.originalPosition.left+this.originalSize.width,l=this.originalPosition.top+this.originalSize.height,r=/sw|nw|w/.test(e),e=/nw|ne|n/.test(e);return n&&(t.width=i.minWidth),o&&(t.height=i.minHeight),s&&(t.width=i.maxWidth),h&&(t.height=i.maxHeight),n&&r&&(t.left=a-i.minWidth),s&&r&&(t.left=a-i.maxWidth),o&&e&&(t.top=l-i.minHeight),h&&e&&(t.top=l-i.maxHeight),t.width||t.height||t.left||!t.top?t.width||t.height||t.top||!t.left||(t.left=null):t.top=null,t},_getPaddingPlusBorderDimensions:function(t){for(var i=0,e=[],s=[t.css("borderTopWidth"),t.css("borderRightWidth"),t.css("borderBottomWidth"),t.css("borderLeftWidth")],h=[t.css("paddingTop"),t.css("paddingRight"),t.css("paddingBottom"),t.css("paddingLeft")];i<4;i++)e[i]=parseFloat(s[i])||0,e[i]+=parseFloat(h[i])||0;return{height:e[0]+e[2],width:e[1]+e[3]}},_proportionallyResize:function(){if(this._proportionallyResizeElements.length)for(var t,i=0,e=this.helper||this.element;i<this._proportionallyResizeElements.length;i++)t=this._proportionallyResizeElements[i],this.outerDimensions||(this.outerDimensions=this._getPaddingPlusBorderDimensions(t)),t.css({height:e.height()-this.outerDimensions.height||0,width:e.width()-this.outerDimensions.width||0})},_renderProxy:function(){var t=this.element,i=this.options;this.elementOffset=t.offset(),this._helper?(this.helper=this.helper||z("<div></div>").css({overflow:"hidden"}),this._addClass(this.helper,this._helper),this.helper.css({width:this.element.outerWidth(),height:this.element.outerHeight(),position:"absolute",left:this.elementOffset.left+"px",top:this.elementOffset.top+"px",zIndex:++i.zIndex}),this.helper.appendTo("body").disableSelection()):this.helper=this.element},_change:{e:function(t,i){return{width:this.originalSize.width+i}},w:function(t,i){var e=this.originalSize;return{left:this.originalPosition.left+i,width:e.width-i}},n:function(t,i,e){var s=this.originalSize;return{top:this.originalPosition.top+e,height:s.height-e}},s:function(t,i,e){return{height:this.originalSize.height+e}},se:function(t,i,e){return z.extend(this._change.s.apply(this,arguments),this._change.e.apply(this,[t,i,e]))},sw:function(t,i,e){return z.extend(this._change.s.apply(this,arguments),this._change.w.apply(this,[t,i,e]))},ne:function(t,i,e){return z.extend(this._change.n.apply(this,arguments),this._change.e.apply(this,[t,i,e]))},nw:function(t,i,e){return z.extend(this._change.n.apply(this,arguments),this._change.w.apply(this,[t,i,e]))}},_propagate:function(t,i){z.ui.plugin.call(this,t,[i,this.ui()]),"resize"!==t&&this._trigger(t,i,this.ui())},plugins:{},ui:function(){return{originalElement:this.originalElement,element:this.element,helper:this.helper,position:this.position,size:this.size,originalSize:this.originalSize,originalPosition:this.originalPosition}}}),z.ui.plugin.add("resizable","animate",{stop:function(i){var e=z(this).resizable("instance"),t=e.options,s=e._proportionallyResizeElements,h=s.length&&/textarea/i.test(s[0].nodeName),n=h&&e._hasScroll(s[0],"left")?0:e.sizeDiff.height,o=h?0:e.sizeDiff.width,h={width:e.size.width-o,height:e.size.height-n},o=parseFloat(e.element.css("left"))+(e.position.left-e.originalPosition.left)||null,n=parseFloat(e.element.css("top"))+(e.position.top-e.originalPosition.top)||null;e.element.animate(z.extend(h,n&&o?{top:n,left:o}:{}),{duration:t.animateDuration,easing:t.animateEasing,step:function(){var t={width:parseFloat(e.element.css("width")),height:parseFloat(e.element.css("height")),top:parseFloat(e.element.css("top")),left:parseFloat(e.element.css("left"))};s&&s.length&&z(s[0]).css({width:t.width,height:t.height}),e._updateCache(t),e._propagate("resize",i)}})}}),z.ui.plugin.add("resizable","containment",{start:function(){var e,s,h=z(this).resizable("instance"),t=h.options,i=h.element,n=t.containment,o=n instanceof z?n.get(0):/parent/.test(n)?i.parent().get(0):n;o&&(h.containerElement=z(o),/document/.test(n)||n===document?(h.containerOffset={left:0,top:0},h.containerPosition={left:0,top:0},h.parentData={element:z(document),left:0,top:0,width:z(document).width(),height:z(document).height()||document.body.parentNode.scrollHeight}):(e=z(o),s=[],z(["Top","Right","Left","Bottom"]).each(function(t,i){s[t]=h._num(e.css("padding"+i))}),h.containerOffset=e.offset(),h.containerPosition=e.position(),h.containerSize={height:e.innerHeight()-s[3],width:e.innerWidth()-s[1]},t=h.containerOffset,i=h.containerSize.height,n=h.containerSize.width,n=h._hasScroll(o,"left")?o.scrollWidth:n,i=h._hasScroll(o)?o.scrollHeight:i,h.parentData={element:o,left:t.left,top:t.top,width:n,height:i}))},resize:function(t){var i=z(this).resizable("instance"),e=i.options,s=i.containerOffset,h=i.position,n=i._aspectRatio||t.shiftKey,o={top:0,left:0},a=i.containerElement,t=!0;a[0]!==document&&/static/.test(a.css("position"))&&(o=s),h.left<(i._helper?s.left:0)&&(i.size.width=i.size.width+(i._helper?i.position.left-s.left:i.position.left-o.left),n&&(i.size.height=i.size.width/i.aspectRatio,t=!1),i.position.left=e.helper?s.left:0),h.top<(i._helper?s.top:0)&&(i.size.height=i.size.height+(i._helper?i.position.top-s.top:i.position.top),n&&(i.size.width=i.size.height*i.aspectRatio,t=!1),i.position.top=i._helper?s.top:0),e=i.containerElement.get(0)===i.element.parent().get(0),h=/relative|absolute/.test(i.containerElement.css("position")),e&&h?(i.offset.left=i.parentData.left+i.position.left,i.offset.top=i.parentData.top+i.position.top):(i.offset.left=i.element.offset().left,i.offset.top=i.element.offset().top),h=Math.abs(i.sizeDiff.width+(i._helper?i.offset.left-o.left:i.offset.left-s.left)),s=Math.abs(i.sizeDiff.height+(i._helper?i.offset.top-o.top:i.offset.top-s.top)),h+i.size.width>=i.parentData.width&&(i.size.width=i.parentData.width-h,n&&(i.size.height=i.size.width/i.aspectRatio,t=!1)),s+i.size.height>=i.parentData.height&&(i.size.height=i.parentData.height-s,n&&(i.size.width=i.size.height*i.aspectRatio,t=!1)),t||(i.position.left=i.prevPosition.left,i.position.top=i.prevPosition.top,i.size.width=i.prevSize.width,i.size.height=i.prevSize.height)},stop:function(){var t=z(this).resizable("instance"),i=t.options,e=t.containerOffset,s=t.containerPosition,h=t.containerElement,n=z(t.helper),o=n.offset(),a=n.outerWidth()-t.sizeDiff.width,n=n.outerHeight()-t.sizeDiff.height;t._helper&&!i.animate&&/relative/.test(h.css("position"))&&z(this).css({left:o.left-s.left-e.left,width:a,height:n}),t._helper&&!i.animate&&/static/.test(h.css("position"))&&z(this).css({left:o.left-s.left-e.left,width:a,height:n})}}),z.ui.plugin.add("resizable","alsoResize",{start:function(){var t=z(this).resizable("instance").options;z(t.alsoResize).each(function(){var t=z(this);t.data("ui-resizable-alsoresize",{width:parseFloat(t.width()),height:parse��s&V  ��s&V                  ���r&V          P�s&V  (�s&V          ��s&V  	      ��s&V          var i=z(this).resizable("instance"),s=i.options,h=i.originalSize,n=i.originalPosition,o={height:i.size.height-h.height||0,width:i.size.width-h.width||0,top:i.position.top-n.top||0,left:i.position.left-n.left||0};z(s.alsoResize).each(function(){var t=z(this),s=z(this).data("ui-resizable-alsoresize"),h={},i=t.parents(e.originalElement[0]).length?["width","height"]:["width","height","top","left"];z.each(i,function(t,i){var e=(s[i]||0)+(o[i]||0);e&&0<=e&&(h[i]=e||null)}),t.css(h)})},stop:function(){z(this).removeData("ui-resizable-alsoresize")}}),z.ui.plugin.add("resizable","ghost",{start:function(){var t=z(this).resizable("instance"),i=t.size;t.ghost=t.originalElement.clone(),t.ghost.css({opacity:.25,display:"block",position:"relative",height:i.height,width:i.width,margin:0,left:0,top:0}),t._addClass(t.ghost,"ui-resizable-ghost"),!1!==z.uiBackCompat&&"string"==typeof t.options.ghost&&t.ghost.addClass(this.options.ghost),t.ghost.appendTo(t.helper)},resize:function(){var t=z(this).resizable("instance");t.ghost&&t.ghost.css({position:"relative",height:t.size.height,width:t.size.width})},stop:function(){var t=z(this).resizable("instance");t.ghost&&t.helper&&t.helper.get(0).removeChild(t.ghost.get(0))}}),z.ui.plugin.add("resizable","grid",{resize:function(){var t,i=z(this).resizable("instance"),e=i.options,s=i.size,h=i.originalSize,n=i.originalPosition,o=i.axis,a="number"==typeof e.grid?[e.grid,e.grid]:e.grid,l=a[0]||1,r=a[1]||1,p=Math.round((s.width-h.width)/l)*l,d=Math.round((s.height-h.height)/r)*r,g=h.width+p,u=h.height+d,c=e.maxWidth&&e.maxWidth<g,f=e.maxHeight&&e.maxHeight<u,m=e.minWidth&&e.minWidth>g,s=e.minHeight&&e.minHeight>u;e.grid=a,m&&(g+=l),s&&(u+=r),c&&(g-=l),f&&(u-=r),/^(se|s|e)$/.test(o)?(i.size.width=g,i.size.height=u):/^(ne)$/.test(o)?(i.size.width=g,i.size.height=u,i.position.top=n.top-d):/^(sw)$/.test(o)?(i.size.width=g,i.size.height=u,i.position.left=n.left-p):((u-r<=0||g-l<=0)&&(t=i._getPaddingPlusBorderDimensions(this)),0<u-r?(i.size.height=u,i.position.top=n.top-d):(u=r-t.height,i.size.height=u,i.position.top=n.top+h.height-u),0<g-l?(i.size.width=g,i.position.left=n.left-p):(g=l-t.width,i.size.width=g,i.position.left=n.left+h.width-g))}}),z.ui.resizable});