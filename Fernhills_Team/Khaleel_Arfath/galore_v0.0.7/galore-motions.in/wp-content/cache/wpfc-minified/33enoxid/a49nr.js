jQuery(".cf7-rfr").each(function(){""==jQuery(this).val()&&jQuery(this).val(document.referrer)});
if(typeof Object.create!=="function"){
Object.create=function(obj){
function F(){};
F.prototype=obj;
return new F();
};}
(function($, window, document, undefined){
var Carousel={
init :function(options, el){
var base=this;
base.$elem=$(el);
base.options=$.extend({}, $.fn.owlCarousel.options, base.$elem.data(), options);
base.userOptions=options;
base.loadContent();
},
loadContent:function(){
var base=this;
if(typeof base.options.beforeInit==="function"){
base.options.beforeInit.apply(this,[base.$elem]);
}
if(typeof base.options.jsonPath==="string"){
var url=base.options.jsonPath;
function getData(data){
if(typeof base.options.jsonSuccess==="function"){
base.options.jsonSuccess.apply(this,[data]);
}else{
var content="";
for(var i in data["owl"]){
content +=data["owl"][i]["item"];
}
base.$elem.html(content);
}
base.logIn();
}
$.getJSON(url,getData);
}else{
base.logIn();
}},
logIn:function(action){
var base=this;
base.$elem.data("owl-originalStyles", base.$elem.attr("style"))
.data("owl-originalClasses", base.$elem.attr("class"));
base.$elem.css({opacity: 0});
base.orignalItems=base.options.items;
base.checkBrowser();
base.wrapperWidth=0;
base.checkVisible;
base.setVars();
},
setVars:function(){
var base=this;
if(base.$elem.children().length===0){return false;}
base.baseClass();
base.eventTypes();
base.$userItems=base.$elem.children();
base.itemsAmount=base.$userItems.length;
base.wrapItems();
base.$owlItems=base.$elem.find(".owl-item");
base.$owlWrapper=base.$elem.find(".owl-wrapper");
base.playDirection="next";
base.prevItem=0;
base.prevArr=[0];
base.currentItem=0;
base.customEvents();
base.onStartup();
},
onStartup:function(){
var base=this;
base.updateItems();
base.calculateAll();
base.buildControls();
base.updateControls();
base.response();
base.moveEvents();
base.stopOnHover();
base.owlStatus();
if(base.options.transitionStyle!==false){
base.transitionTypes(base.options.transitionStyle);
}
if(base.options.autoPlay===true){
base.options.autoPlay=5000;
}
base.play();
base.$elem.find(".owl-wrapper").css("display","block");
if(!base.$elem.is(":visible")){
base.watchVisibility();
}else{
base.$elem.css("opacity",1);
}
base.onstartup=false;
base.eachMoveUpdate();
if(typeof base.options.afterInit==="function"){
base.options.afterInit.apply(this,[base.$elem]);
}},
eachMoveUpdate:function(){
var base=this;
if(base.options.lazyLoad===true){
base.lazyLoad();
}
if(base.options.autoHeight===true){
base.autoHeight();
}
base.onVisibleItems();
if(typeof base.options.afterAction==="function"){
base.options.afterAction.apply(this,[base.$elem]);
}},
updateVars:function(){
var base=this;
if(typeof base.options.beforeUpdate==="function"){
base.options.beforeUpdate.apply(this,[base.$elem]);
}
base.watchVisibility();
base.updateItems();
base.calculateAll();
base.updatePosition();
base.updateControls();
base.eachMoveUpdate();
if(typeof base.options.afterUpdate==="function"){
base.options.afterUpdate.apply(this,[base.$elem]);
}},
reload:function(elements){
var base=this;
setTimeout(function(){
base.updateVars();
},0);
},
watchVisibility:function(){
var base=this;
if(base.$elem.is(":visible")===false){
base.$elem.css({opacity: 0});
clearInterval(base.autoPlayInterval);
clearInterval(base.checkVisible);
}else{
return false;
}
base.checkVisible=setInterval(function(){
if(base.$elem.is(":visible")){
base.reload();
base.$elem.animate({opacity: 1},200);
clearInterval(base.checkVisible);
}}, 500);
},
wrapItems:function(){
var base=this;
base.$userItems.wrapAll("<div class=\"owl-wrapper\">").wrap("<div class=\"owl-item\"></div>");
base.$elem.find(".owl-wrapper").wrap("<div class=\"owl-wrapper-outer\">");
base.wrapperOuter=base.$elem.find(".owl-wrapper-outer");
base.$elem.css("display","block");
},
baseClass:function(){
var base=this;
var hasBaseClass=base.$elem.hasClass(base.options.baseClass);
var hasThemeClass=base.$elem.hasClass(base.options.theme);
if(!hasBaseClass){
base.$elem.addClass(base.options.baseClass);
}
if(!hasThemeClass){
base.$elem.addClass(base.options.theme);
}},
updateItems:function(){
var base=this;
if(base.options.responsive===false){
return false;
}
if(base.options.singleItem===true){
base.options.items=base.orignalItems=1;
base.options.itemsCustom=false;
base.options.itemsDesktop=false;
base.options.itemsDesktopSmall=false;
base.options.itemsTablet=false;
base.options.itemsTabletSmall=false;
base.options.itemsMobile=false;
return false;
}
var width=$(base.options.responsiveBaseWidth).width();
if(width > (base.options.itemsDesktop[0]||base.orignalItems)){
base.options.items=base.orignalItems;
}
if(typeof(base.options.itemsCustom)!=='undefined'&&base.options.itemsCustom!==false){
base.options.itemsCustom.sort(function(a,b){return a[0]-b[0];});
for(var i in base.options.itemsCustom){
if(typeof(base.options.itemsCustom[i])!=='undefined'&&base.options.itemsCustom[i][0] <=width){
base.options.items=base.options.itemsCustom[i][1];
}}
}else{
if(width <=base.options.itemsDesktop[0]&&base.options.itemsDesktop!==false){
base.options.items=base.options.itemsDesktop[1];
}
if(width <=base.options.itemsDesktopSmall[0]&&base.options.itemsDesktopSmall!==false){
base.options.items=base.options.itemsDesktopSmall[1];
}
if(width <=base.options.itemsTablet[0]&&base.options.itemsTablet!==false){
base.options.items=base.options.itemsTablet[1];
}
if(width <=base.options.itemsTabletSmall[0]&&base.options.itemsTabletSmall!==false){
base.options.items=base.options.itemsTabletSmall[1];
}
if(width <=base.options.itemsMobile[0]&&base.options.itemsMobile!==false){
base.options.items=base.options.itemsMobile[1];
}}
if(base.options.items > base.itemsAmount&&base.options.itemsScaleUp===true){
base.options.items=base.itemsAmount;
}},
response:function(){
var base=this,
smallDelay;
if(base.options.responsive!==true){
return false;
}
var lastWindowWidth=$(window).width();
base.resizer=function(){
if($(window).width()!==lastWindowWidth){
if(base.options.autoPlay!==false){
clearInterval(base.autoPlayInterval);
}
clearTimeout(smallDelay);
smallDelay=setTimeout(function(){
lastWindowWidth=$(window).width();
base.updateVars();
},base.options.responsiveRefreshRate);
}};
$(window).resize(base.resizer);
},
updatePosition:function(){
var base=this;
base.jumpTo(base.currentItem);
if(base.options.autoPlay!==false){
base.checkAp();
}},
appendItemsSizes:function(){
var base=this;
var roundPages=0;
var lastItem=base.itemsAmount - base.options.items;
base.$owlItems.each(function(index){
var $this=$(this);
$this
.css({"width": base.itemWidth})
.data("owl-item",Number(index));
if(index % base.options.items===0||index===lastItem){
if(!(index > lastItem)){
roundPages +=1;
}}
$this.data("owl-roundPages",roundPages);
});
},
appendWrapperSizes:function(){
var base=this,
width=base.$owlItems.length * base.itemWidth,
cssObj;
base.options['direction']=="rtl" ? cssObj={"right":0,direction:"rtl"}:cssObj={"left":0};
base.$owlWrapper.css({"width": width});
base.$owlWrapper.css(cssObj);
base.appendItemsSizes();
},
calculateAll:function(){
var base=this;
base.calculateWidth();
base.appendWrapperSizes();
base.loops();
base.max();
},
calculateWidth:function(){
var base=this;
base.itemWidth=Math.round(base.$elem.width()/base.options.items);
},
max:function(){
var base=this;
var maximum=((base.itemsAmount * base.itemWidth) - base.options.items * base.itemWidth) * -1;
if(base.options.items > base.itemsAmount){
base.maximumItem=0;
maximum=0;
base.maximumPixels=0;
}else{
base.maximumItem=base.itemsAmount - base.options.items;
base.maximumPixels=maximum;
}
return maximum;
},
min:function(){
return 0;
},
loops:function(){
var base=this;
base.positionsInArray=[0];
base.pagesInArray=[];
var prev=0;
var elWidth=0;
for(var i=0; i<base.itemsAmount; i++){
elWidth +=base.itemWidth;
base.positionsInArray.push(-elWidth);
if(base.options.scrollPerPage===true){
var item=$(base.$owlItems[i]);
var roundPageNum=item.data("owl-roundPages");
if(roundPageNum!==prev){
base.pagesInArray[prev]=base.positionsInArray[i];
prev=roundPageNum;
}}
}},
buildControls:function(){
var base=this;
if(base.options.navigation===true||base.options.pagination===true){
base.owlControls=$("<div class=\"owl-controls\"/>").toggleClass("clickable", !base.browser.isTouch).appendTo(base.$elem);
}
if(base.options.pagination===true){
base.buildPagination();
}
if(base.options.navigation===true){
base.buildButtons();
}},
buildButtons:function(){
var base=this;
var buttonsWrapper=$("<div class=\"owl-buttons\"/>");
base.owlControls.append(buttonsWrapper);
base.buttonPrev=$("<div/>",{
"class":"owl-prev",
"html":base.options.navigationText[0]||""
});
base.buttonNext=$("<div/>",{
"class":"owl-next",
"html":base.options.navigationText[1]||""
});
buttonsWrapper
.append(base.buttonPrev)
.append(base.buttonNext);
buttonsWrapper.on("touchstart.owlControls mousedown.owlControls", "div[class^=\"owl\"]", function(event){
event.preventDefault();
});
buttonsWrapper.on("touchend.owlControls mouseup.owlControls", "div[class^=\"owl\"]", function(event){
event.preventDefault();
if($(this).hasClass("owl-next")){
base.next();
}else{
base.prev();
}});
},
buildPagination:function(){
var base=this;
base.paginationWrapper=$("<div class=\"owl-pagination\"/>");
base.owlControls.append(base.paginationWrapper);
base.paginationWrapper.on("touchend.owlControls mouseup.owlControls", ".owl-page", function(event){
event.preventDefault();
if(Number($(this).data("owl-page"))!==base.currentItem){
base.goTo(Number($(this).data("owl-page")), true);
}});
},
updatePagination:function(){
var base=this;
if(base.options.pagination===false){
return false;
}
base.paginationWrapper.html("");
var counter=0;
var lastPage=base.itemsAmount - base.itemsAmount % base.options.items;
for(var i=0; i<base.itemsAmount; i++){
if(i % base.options.items===0){
counter +=1;
if(lastPage===i){
var lastItem=base.itemsAmount - base.options.items;
}
var paginationButton=$("<div/>",{
"class":"owl-page"
});
var paginationButtonInner=$("<span></span>",{
"text": base.options.paginationNumbers===true ? counter:"",
"class": base.options.paginationNumbers===true ? "owl-numbers":""
});
paginationButton.append(paginationButtonInner);
paginationButton.data("owl-page",lastPage===i ? lastItem:i);
paginationButton.data("owl-roundPages",counter);
base.paginationWrapper.append(paginationButton);
}}
base.checkPagination();
},
checkPagination:function(){
var base=this;
if(base.options.pagination===false){
return false;
}
base.paginationWrapper.find(".owl-page").each(function(i,v){
if($(this).data("owl-roundPages")===$(base.$owlItems[base.currentItem]).data("owl-roundPages")){
base.paginationWrapper
.find(".owl-page")
.removeClass("active");
$(this).addClass("active");
}});
},
checkNavigation:function(){
var base=this;
if(base.options.navigation===false){
return false;
}
if(base.options.rewindNav===false){
if(base.currentItem===0&&base.maximumItem===0){
base.buttonPrev.addClass("disabled");
base.buttonNext.addClass("disabled");
}else if(base.currentItem===0&&base.maximumItem!==0){
base.buttonPrev.addClass("disabled");
base.buttonNext.removeClass("disabled");
}else if(base.currentItem===base.maximumItem){
base.buttonPrev.removeClass("disabled");
base.buttonNext.addClass("disabled");
}else if(base.currentItem!==0&&base.currentItem!==base.maximumItem){
base.buttonPrev.removeClass("disabled");
base.buttonNext.removeClass("disabled");
}}
},
updateControls:function(){
var base=this;
base.updatePagination();
base.checkNavigation();
if(base.owlControls){
if(base.options.items >=base.itemsAmount){
base.owlControls.hide();
}else{
base.owlControls.show();
}}
},
destroyControls:function(){
var base=this;
if(base.owlControls){
base.owlControls.remove();
}},
next:function(speed){
var base=this;
if(base.isTransition){
return false;
}
base.currentItem +=base.options.scrollPerPage===true ? base.options.items:1;
if(base.currentItem > base.maximumItem + (base.options.scrollPerPage==true ? (base.options.items - 1):0)){
if(base.options.rewindNav===true){
base.currentItem=0;
speed="rewind";
}else{
base.currentItem=base.maximumItem;
return false;
}}
base.goTo(base.currentItem,speed);
},
prev:function(speed){
var base=this;
if(base.isTransition){
return false;
}
if(base.options.scrollPerPage===true&&base.currentItem > 0&&base.currentItem < base.options.items){
base.currentItem=0;
}else{
base.currentItem -=base.options.scrollPerPage===true ? base.options.items:1;
}
if(base.currentItem < 0){
if(base.options.rewindNav===true){
base.currentItem=base.maximumItem;
speed="rewind";
}else{
base.currentItem=0;
return false;
}}
base.goTo(base.currentItem,speed);
},
goTo:function(position,speed,drag){
var base=this;
if(base.isTransition){
return false;
}
if(typeof base.options.beforeMove==="function"){
base.options.beforeMove.apply(this,[base.$elem]);
}
if(position >=base.maximumItem){
position=base.maximumItem;
}
else if(position <=0){
position=0;
}
base.currentItem=base.owl.currentItem=position;
if(base.options.transitionStyle!==false&&drag!=="drag"&&base.options.items===1&&base.browser.support3d===true){
base.swapSpeed(0);
if(base.browser.support3d===true){
base.transition3d(base.positionsInArray[position]);
}else{
base.css2slide(base.positionsInArray[position],1);
}
base.afterGo();
base.singleItemTransition();
return false;
}
var goToPixel=base.positionsInArray[position];
if(base.browser.support3d===true){
base.isCss3Finish=false;
if(speed===true){
base.swapSpeed("paginationSpeed");
setTimeout(function(){
base.isCss3Finish=true;
}, base.options.paginationSpeed);
}else if(speed==="rewind"){
base.swapSpeed(base.options.rewindSpeed);
setTimeout(function(){
base.isCss3Finish=true;
}, base.options.rewindSpeed);
}else{
base.swapSpeed("slideSpeed");
setTimeout(function(){
base.isCss3Finish=true;
}, base.options.slideSpeed);
}
base.transition3d(goToPixel);
}else{
if(speed===true){
base.css2slide(goToPixel, base.options.paginationSpeed);
}else if(speed==="rewind"){
base.css2slide(goToPixel, base.options.rewindSpeed);
}else{
base.css2slide(goToPixel, base.options.slideSpeed);
}}
base.afterGo();
},
jumpTo:function(position){
var base=this;
if(typeof base.options.beforeMove==="function"){
base.options.beforeMove.apply(this,[base.$elem]);
}
if(position >=base.maximumItem||position===-1){
position=base.maximumItem;
}
else if(position <=0){
position=0;
}
base.swapSpeed(0);
if(base.browser.support3d===true){
base.transition3d(base.positionsInArray[position]);
}else{
base.css2slide(base.positionsInArray[position],1);
}
base.currentItem=base.owl.currentItem=position;
base.afterGo();
},
afterGo:function(){
var base=this;
base.prevArr.push(base.currentItem);
base.prevItem=base.owl.prevItem=base.prevArr[base.prevArr.length -2];
base.prevArr.shift(0);
if(base.prevItem!==base.currentItem){
base.checkPagination();
base.checkNavigation();
base.eachMoveUpdate();
if(base.options.autoPlay!==false){
base.checkAp();
}}
if(typeof base.options.afterMove==="function"&&base.prevItem!==base.currentItem){
base.options.afterMove.apply(this,[base.$elem]);
}},
stop:function(){
var base=this;
base.apStatus="stop";
clearInterval(base.autoPlayInterval);
},
checkAp:function(){
var base=this;
if(base.apStatus!=="stop"){
base.play();
}},
play:function(){
var base=this;
base.apStatus="play";
if(base.options.autoPlay===false){
return false;
}
clearInterval(base.autoPlayInterval);
base.autoPlayInterval=setInterval(function(){
base.next(true);
},base.options.autoPlay);
},
swapSpeed:function(action){
var base=this;
if(action==="slideSpeed"){
base.$owlWrapper.css(base.addCssSpeed(base.options.slideSpeed));
}else if(action==="paginationSpeed"){
base.$owlWrapper.css(base.addCssSpeed(base.options.paginationSpeed));
}else if(typeof action!=="string"){
base.$owlWrapper.css(base.addCssSpeed(action));
}},
addCssSpeed:function(speed){
var base=this;
return {
"-webkit-transition": "all "+ speed +"ms ease",
"-moz-transition": "all "+ speed +"ms ease",
"-o-transition": "all "+ speed +"ms ease",
"transition": "all "+ speed +"ms ease"
};},
removeTransition:function(){
return {
"-webkit-transition": "",
"-moz-transition": "",
"-o-transition": "",
"transition": ""
};},
doTranslate:function(pixels){
var base=this;
base.options['direction']=="rtl" ? pixels=-pixels:pixels=pixels ;
return {
"-webkit-transform": "translate3d("+pixels+"px, 0px, 0px)",
"-moz-transform": "translate3d("+pixels+"px, 0px, 0px)",
"-o-transform": "translate3d("+pixels+"px, 0px, 0px)",
"-ms-transform": "translate3d("+pixels+"px, 0px, 0px)",
"transform": "translate3d("+pixels+"px, 0px,0px)"
};},
transition3d:function(value){
var base=this;
base.$owlWrapper.css(base.doTranslate(value));
},
css2move:function(value){
var base=this, cssObj;
base.options['direction']=="rtl" ? cssObj={"right":value}:cssObj={"left":value};
base.$owlWrapper.css(cssObj);
},
css2slide:function(value,speed){
var base=this, cssObj;
base.options['direction']=="rtl" ? cssObj={"right":value}:cssObj={"left":value};
base.isCssFinish=false;
base.$owlWrapper.stop(true,true).animate(cssObj, {
duration:speed||base.options.slideSpeed ,
complete:function(){
base.isCssFinish=true;
}});
},
checkBrowser:function(){
var base=this;
var	translate3D="translate3d(0px, 0px, 0px)",
tempElem=document.createElement("div");
tempElem.style.cssText="  -moz-transform:"    + translate3D +
"; -ms-transform:"     + translate3D +
"; -o-transform:"      + translate3D +
"; -webkit-transform:" + translate3D +
"; transform:"         + translate3D;
var	regex=/translate3d\(0px, 0px, 0px\)/g,
asSupport=tempElem.style.cssText.match(regex),
support3d=(asSupport!==null&&asSupport.length===1);
var isTouch="ontouchstart" in window||navigator.msMaxTouchPoints;
base.browser={
"support3d":support3d,
"isTouch":isTouch
};},
moveEvents:function(){
var base=this;
if(base.options.mouseDrag!==false||base.options.touchDrag!==false){
base.gestures();
base.disabledEvents();
}},
eventTypes:function(){
var base=this;
var types=["s","e","x"];
base.ev_types={};
if(base.options.mouseDrag===true&&base.options.touchDrag===true){
types=[
"touchstart.owl mousedown.owl",
"touchmove.owl mousemove.owl",
"touchend.owl touchcancel.owl mouseup.owl"
];
}else if(base.options.mouseDrag===false&&base.options.touchDrag===true){
types=[
"touchstart.owl",
"touchmove.owl",
"touchend.owl touchcancel.owl"
];
}else if(base.options.mouseDrag===true&&base.options.touchDrag===false){
types=[
"mousedown.owl",
"mousemove.owl",
"mouseup.owl"
];
}
base.ev_types["start"]=types[0];
base.ev_types["move"]=types[1];
base.ev_types["end"]=types[2];
},
disabledEvents:function(){
var base=this;
base.$elem.on("dragstart.owl", function(event){ event.preventDefault();});
base.$elem.on("mousedown.disableTextSelect", function(e){
return $(e.target).is('input, textarea, select, option');
});
},
gestures:function(){
var base=this;
var locals={
offsetX:0,
offsetY:0,
baseElWidth:0,
relativePos:0,
position: null,
minSwipe:null,
maxSwipe: null,
sliding:null,
dargging: null,
targetElement:null
};
base.isCssFinish=true;
function getTouches(event){
if(event.touches){
return {
x:event.touches[0].pageX,
y:event.touches[0].pageY
};}else{
if(event.pageX!==undefined){
return {
x:event.pageX,
y:event.pageY
};}else{
return {
x:event.clientX,
y:event.clientY
};}}
}
function swapEvents(type){
if(type==="on"){
$(document).on(base.ev_types["move"], dragMove);
$(document).on(base.ev_types["end"], dragEnd);
}else if(type==="off"){
$(document).off(base.ev_types["move"]);
$(document).off(base.ev_types["end"]);
}}
function dragStart(event){
var event=event.originalEvent||event||window.event;
if(event.which===3){
return false;
}
if(base.itemsAmount <=base.options.items){
return;
}
if(base.isCssFinish===false&&!base.options.dragBeforeAnimFinish){
return false;
}
if(base.isCss3Finish===false&&!base.options.dragBeforeAnimFinish){
return false;
}
if(base.options.autoPlay!==false){
clearInterval(base.autoPlayInterval);
}
if(base.browser.isTouch!==true&&!base.$owlWrapper.hasClass("grabbing")){
base.$owlWrapper.addClass("grabbing");
}
base.newPosX=0;
base.newRelativeX=0;
$(this).css(base.removeTransition());
var position=$(this).position();
if(base.options['direction']=="rtl"){
positionRight=base.$owlItems.eq(0).width()*base.currentItem;
locals.relativePos=positionRight;
locals.offsetX=-getTouches(event).x + positionRight;
}else{
locals.relativePos=position.left;
locals.offsetX=getTouches(event).x - position.left;
}
locals.offsetY=getTouches(event).y - position.top;
swapEvents("on");
locals.sliding=false;
locals.targetElement=event.target||event.srcElement;
}
function dragMove(event){
var event=event.originalEvent||event||window.event;
if(base.options['direction']=="rtl"){
base.newPosX=-getTouches(event).x - locals.offsetX;
base.newPosY=getTouches(event).y - locals.offsetY;
base.newRelativeX=base.newPosX + locals.relativePos;
}else{
base.newPosX=getTouches(event).x - locals.offsetX;
base.newPosY=getTouches(event).y - locals.offsetY;
base.newRelativeX=base.newPosX - locals.relativePos;
}
if(typeof base.options.startDragging==="function"&&locals.dragging!==true&&base.newRelativeX!==0){
locals.dragging=true;
base.options.startDragging.apply(base,[base.$elem]);
}
if(base.newRelativeX > 8||base.newRelativeX < -8&&base.browser.isTouch===true){
event.preventDefault ? event.preventDefault():event.returnValue=false;
locals.sliding=true;
}
if((base.newPosY > 10||base.newPosY < -10)&&locals.sliding===false){
$(document).off("touchmove.owl");
}
var minSwipe=function(){
return  base.newRelativeX / 5;
};
var maxSwipe=function(){
return  base.maximumPixels + base.newRelativeX / 5;
};
base.newPosX=Math.max(Math.min(base.newPosX, minSwipe()), maxSwipe());
if(base.browser.support3d===true){
base.transition3d(base.newPosX);
}else{
base.css2move(base.newPosX);
}}
function dragEnd(event){
var event=event.originalEvent||event||window.event;
event.target=event.target||event.srcElement;
locals.dragging=false;
if(base.browser.isTouch!==true){
base.$owlWrapper.removeClass("grabbing");
}
if(base.options['direction']=="rtl"){
if(base.newRelativeX < 0){ base.dragDirection=base.owl.dragDirection="right"; }else{ base.dragDirection=base.owl.dragDirection="left"; }}else{
if(base.newRelativeX < 0){ base.dragDirection=base.owl.dragDirection="left"; }else{ base.dragDirection=base.owl.dragDirection="right"; }}
if(base.newRelativeX!==0){
var newPosition=base.getNewPosition();
base.goTo(newPosition,false,"drag");
if(locals.targetElement===event.target&&base.browser.isTouch!==true){
$(event.target).on("click.disable", function(ev){
ev.stopImmediatePropagation();
ev.stopPropagation();
ev.preventDefault();
$(event.target).off("click.disable");
});
var handlers=$._data(event.target, "events")["click"];
var owlStopEvent=handlers.pop();
handlers.splice(0, 0, owlStopEvent);
}}
swapEvents("off");
}
base.$elem.on(base.ev_types["start"], ".owl-wrapper", dragStart);
},
getNewPosition:function(){
var base=this,
newPosition;
newPosition=base.closestItem();
if(newPosition>base.maximumItem){
base.currentItem=base.maximumItem;
newPosition=base.maximumItem;
}else if(base.newPosX >=0){
newPosition=0;
base.currentItem=0;
}
return newPosition;
},
closestItem:function(){
var base=this,
array=base.options.scrollPerPage===true ? base.pagesInArray:base.positionsInArray,
goal=base.newPosX,
closest=null;
$.each(array, function(i,v){
if(goal - (base.itemWidth/20) > array[i+1]&&goal - (base.itemWidth/20)< v&&base.moveDirection()==="left"){
closest=v;
if(base.options.scrollPerPage===true){
base.currentItem=$.inArray(closest, base.positionsInArray);
}else{
base.currentItem=i;
}}
else if(goal + (base.itemWidth/20) < v&&goal + (base.itemWidth/20) > (array[i+1]||array[i]-base.itemWidth)&&base.moveDirection()==="right"){
if(base.options.scrollPerPage===true){
closest=array[i+1]||array[array.length-1];
base.currentItem=$.inArray(closest, base.positionsInArray);
}else{
closest=array[i+1];
base.currentItem=i+1;
}}
});
return base.currentItem;
},
moveDirection:function(){
var base=this,
direction;
if(base.newRelativeX < 0){
direction="right";
base.playDirection="next";
}else{
direction="left";
base.playDirection="prev";
}
return direction
},
customEvents:function(){
var base=this;
base.$elem.on("owl.next",function(){
base.next();
});
base.$elem.on("owl.prev",function(){
base.prev();
});
base.$elem.on("owl.play",function(event,speed){
base.options.autoPlay=speed;
base.play();
base.hoverStatus="play";
});
base.$elem.on("owl.stop",function(){
base.stop();
base.hoverStatus="stop";
});
base.$elem.on("owl.goTo",function(event,item){
base.goTo(item);
});
base.$elem.on("owl.jumpTo",function(event,item){
base.jumpTo(item);
});
},
stopOnHover:function(){
var base=this;
if(base.options.stopOnHover===true&&base.browser.isTouch!==true&&base.options.autoPlay!==false){
base.$elem.on("mouseover", function(){
base.stop();
});
base.$elem.on("mouseout", function(){
if(base.hoverStatus!=="stop"){
base.play();
}});
}},
lazyLoad:function(){
var base=this;
if(base.options.lazyLoad===false){
return false;
}
for(var i=0; i<base.itemsAmount; i++){
var $item=$(base.$owlItems[i]);
if($item.data("owl-loaded")==="loaded"){
continue;
}
var	itemNumber=$item.data("owl-item"),
$lazyImg=$item.find(".lazyOwl"),
follow;
if(typeof $lazyImg.data("src")!=="string"){
$item.data("owl-loaded","loaded");
continue;
}
if($item.data("owl-loaded")===undefined){
$lazyImg.hide();
$item.addClass("loading").data("owl-loaded","checked");
}
if(base.options.lazyFollow===true){
follow=itemNumber >=base.currentItem;
}else{
follow=true;
}
if(follow&&itemNumber < base.currentItem + base.options.items&&$lazyImg.length){
base.lazyPreload($item,$lazyImg);
}}
},
lazyPreload:function($item,$lazyImg){
var base=this,
iterations=0;
if($lazyImg.prop("tagName")==="DIV"){
$lazyImg.css("background-image", "url(" + $lazyImg.data("src")+ ")");
var isBackgroundImg=true;
}else{
$lazyImg[0].src=$lazyImg.data("src");
}
checkLazyImage();
function checkLazyImage(){
iterations +=1;
if(base.completeImg($lazyImg.get(0))||isBackgroundImg===true){
showImage();
}else if(iterations <=100){
setTimeout(checkLazyImage,100);
}else{
showImage();
}}
function showImage(){
$item.data("owl-loaded", "loaded").removeClass("loading");
$lazyImg.removeAttr("data-src");
base.options.lazyEffect==="fade" ? $lazyImg.fadeIn(400):$lazyImg.show();
if(typeof base.options.afterLazyLoad==="function"){
base.options.afterLazyLoad.apply(this,[base.$elem]);
}}
},
autoHeight:function(){
var base=this;
var $currentimg=$(base.$owlItems[base.currentItem]).find("img");
if($currentimg.get(0)!==undefined){
var iterations=0;
checkImage();
}else{
addHeight();
}
function checkImage(){
iterations +=1;
if(base.completeImg($currentimg.get(0))){
addHeight();
}else if(iterations <=100){
setTimeout(checkImage,100);
}else{
base.wrapperOuter.css("height", "");
}}
function addHeight(){
var $currentItem=$(base.$owlItems[base.currentItem]).height();
base.wrapperOuter.css("height",$currentItem+"px");
if(!base.wrapperOuter.hasClass("autoHeight")){
setTimeout(function(){
base.wrapperOuter.addClass("autoHeight");
},0);
}}
},
completeImg:function(img){
if(!img.complete){
return false;
}
if(typeof img.naturalWidth!=="undefined"&&img.naturalWidth==0){
return false;
}
return true;
},
onVisibleItems:function(){
var base=this;
if(base.options.addClassActive===true){
base.$owlItems.removeClass("active");
}
base.visibleItems=[];
for(var i=base.currentItem; i<base.currentItem + base.options.items; i++){
base.visibleItems.push(i);
if(base.options.addClassActive===true){
$(base.$owlItems[i]).addClass("active");
}}
base.owl.visibleItems=base.visibleItems;
},
transitionTypes:function(className){
var base=this;
base.outClass="owl-"+className+"-out";
base.inClass="owl-"+className+"-in";
},
singleItemTransition:function(){
var base=this;
base.isTransition=true;
var outClass=base.outClass,
inClass=base.inClass,
$currentItem=base.$owlItems.eq(base.currentItem),
$prevItem=base.$owlItems.eq(base.prevItem),
prevPos=Math.abs(base.positionsInArray[base.currentItem]) + base.positionsInArray[base.prevItem],
origin=Math.abs(base.positionsInArray[base.currentItem])+base.itemWidth/2;
base.$owlWrapper
.addClass('owl-origin')
.css({
"-webkit-transform-origin":origin+"px",
"-moz-perspective-origin":origin+"px",
"perspective-origin":origin+"px"
});
function transStyles(prevPos,zindex){
return {
"position":"relative",
"left":prevPos+"px"
};}
var animEnd='webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend';
$prevItem
.css(transStyles(prevPos,10))
.addClass(outClass)
.on(animEnd, function(){
base.endPrev=true;
$prevItem.off(animEnd);
base.clearTransStyle($prevItem,outClass);
});
$currentItem
.addClass(inClass)
.on(animEnd, function(){
base.endCurrent=true;
$currentItem.off(animEnd);
base.clearTransStyle($currentItem,inClass);
});
},
clearTransStyle:function(item,classToRemove){
var base=this;
item.css({
"position":"",
"left":""
})
.removeClass(classToRemove);
if(base.endPrev&&base.endCurrent){
base.$owlWrapper.removeClass('owl-origin');
base.endPrev=false;
base.endCurrent=false;
base.isTransition=false;
}},
owlStatus:function(){
var base=this;
base.owl={
"userOptions":base.userOptions,
"baseElement":base.$elem,
"userItems":base.$userItems,
"owlItems":base.$owlItems,
"currentItem":base.currentItem,
"prevItem":base.prevItem,
"visibleItems":base.visibleItems,
"isTouch":base.browser.isTouch,
"browser":base.browser,
"dragDirection":base.dragDirection
};},
clearEvents:function(){
var base=this;
base.$elem.off(".owl owl mousedown.disableTextSelect");
$(document).off(".owl owl");
$(window).off("resize", base.resizer);
},
unWrap:function(){
var base=this;
if(base.$elem.children().length!==0){
base.$owlWrapper.unwrap();
base.$userItems.unwrap().unwrap();
if(base.owlControls){
base.owlControls.remove();
}}
base.clearEvents();
base.$elem
.attr("style", base.$elem.data("owl-originalStyles")||"")
.attr("class", base.$elem.data("owl-originalClasses"));
},
destroy:function(){
var base=this;
base.stop();
clearInterval(base.checkVisible);
base.unWrap();
base.$elem.removeData();
},
reinit:function(newOptions){
var base=this;
var options=$.extend({}, base.userOptions, newOptions);
base.unWrap();
base.init(options,base.$elem);
},
addItem:function(htmlString,targetPosition){
var base=this,
position;
if(!htmlString){return false;}
if(base.$elem.children().length===0){
base.$elem.append(htmlString);
base.setVars();
return false;
}
base.unWrap();
if(targetPosition===undefined||targetPosition===-1){
position=-1;
}else{
position=targetPosition;
}
if(position >=base.$userItems.length||position===-1){
base.$userItems.eq(-1).after(htmlString);
}else{
base.$userItems.eq(position).before(htmlString);
}
base.setVars();
},
removeItem:function(targetPosition){
var base=this,
position;
if(base.$elem.children().length===0){return false;}
if(targetPosition===undefined||targetPosition===-1){
position=-1;
}else{
position=targetPosition;
}
base.unWrap();
base.$userItems.eq(position).remove();
base.setVars();
}};
$.fn.owlCarousel=function(options){
return this.each(function(){
if($(this).data("owl-init")===true){
return false;
}
$(this).data("owl-init", true);
var carousel=Object.create(Carousel);
carousel.init(options, this);
$.data(this, "owlCarousel", carousel);
});
};
$.fn.owlCarousel.options={
direction:'ltr',
items:5,
itemsCustom:false,
itemsDesktop:[1199,4],
itemsDesktopSmall:[979,3],
itemsTablet:[768,2],
itemsTabletSmall:false,
itemsMobile:[479,1],
singleItem:false,
itemsScaleUp:false,
slideSpeed:200,
paginationSpeed:800,
rewindSpeed:1000,
autoPlay:false,
stopOnHover:false,
navigation:false,
navigationText:["prev","next"],
rewindNav:true,
scrollPerPage:false,
pagination:true,
paginationNumbers:false,
responsive:true,
responsiveRefreshRate:200,
responsiveBaseWidth:window,
baseClass:"owl-carousel",
theme:"owl-theme",
lazyLoad:false,
lazyFollow:true,
lazyEffect:"fade",
autoHeight:false,
jsonPath:false,
jsonSuccess:false,
dragBeforeAnimFinish:true,
mouseDrag:true,
touchDrag:true,
addClassActive:false,
transitionStyle:false,
beforeUpdate:false,
afterUpdate:false,
beforeInit:false,
afterInit:false,
beforeMove:false,
afterMove:false,
afterAction:false,
startDragging:false,
afterLazyLoad: false
};})(jQuery, window, document);
;(function(e,t,n){function s(t,n){this.bodyOverflowX;this.callbacks={hide:[],show:[]};this.checkInterval=null;this.Content;this.$el=e(t);this.$elProxy;this.elProxyPosition;this.enabled=true;this.options=e.extend({},i,n);this.mouseIsOverProxy=false;this.namespace="tooltipster-"+Math.round(Math.random()*1e5);this.Status="hidden";this.timerHide=null;this.timerShow=null;this.$tooltip;this.options.iconTheme=this.options.iconTheme.replace(".","");this.options.theme=this.options.theme.replace(".","");this._init()}function o(t,n){var r=true;e.each(t,function(e,i){if(typeof n[e]==="undefined"||t[e]!==n[e]){r=false;return false}});return r}function f(){return!a&&u}function l(){var e=n.body||n.documentElement,t=e.style,r="transition";if(typeof t[r]=="string"){return true}v=["Moz","Webkit","Khtml","O","ms"],r=r.charAt(0).toUpperCase()+r.substr(1);for(var i=0;i<v.length;i++){if(typeof t[v[i]+r]=="string"){return true}}return false}var r="tooltipster",i={animation:"fade",arrow:true,arrowColor:"",autoClose:true,content:null,contentAsHTML:false,contentCloning:true,debug:true,delay:200,minWidth:0,maxWidth:null,functionInit:function(e,t){},functionBefore:function(e,t){t()},functionReady:function(e,t){},functionAfter:function(e){},hideOnClick:false,icon:"(?)",iconCloning:true,iconDesktop:false,iconTouch:false,iconTheme:"tooltipster-icon",interactive:false,interactiveTolerance:350,multiple:false,offsetX:0,offsetY:0,onlyOne:false,position:"top",positionTracker:false,positionTrackerCallback:function(e){if(this.option("trigger")=="hover"&&this.option("autoClose")){this.hide()}},restoration:"current",speed:350,timer:0,theme:"tooltipster-default",touchDevices:true,trigger:"hover",updateAnimation:true};s.prototype={_init:function(){var t=this;if(n.querySelector){var r=null;if(t.$el.data("tooltipster-initialTitle")===undefined){r=t.$el.attr("title");if(r===undefined)r=null;t.$el.data("tooltipster-initialTitle",r)}if(t.options.content!==null){t._content_set(t.options.content)}else{t._content_set(r)}var i=t.options.functionInit.call(t.$el,t.$el,t.Content);if(typeof i!=="undefined")t._content_set(i);t.$el.removeAttr("title").addClass("tooltipstered");if(!u&&t.options.iconDesktop||u&&t.options.iconTouch){if(typeof t.options.icon==="string"){t.$elProxy=e('<span class="'+t.options.iconTheme+'"></span>');t.$elProxy.text(t.options.icon)}else{if(t.options.iconCloning)t.$elProxy=t.options.icon.clone(true);else t.$elProxy=t.options.icon}t.$elProxy.insertAfter(t.$el)}else{t.$elProxy=t.$el}if(t.options.trigger=="hover"){t.$elProxy.on("mouseenter."+t.namespace,function(){if(!f()||t.options.touchDevices){t.mouseIsOverProxy=true;t._show()}}).on("mouseleave."+t.namespace,function(){if(!f()||t.options.touchDevices){t.mouseIsOverProxy=false}});if(u&&t.options.touchDevices){t.$elProxy.on("touchstart."+t.namespace,function(){t._showNow()})}}else if(t.options.trigger=="click"){t.$elProxy.on("click."+t.namespace,function(){if(!f()||t.options.touchDevices){t._show()}})}}},_show:function(){var e=this;if(e.Status!="shown"&&e.Status!="appearing"){if(e.options.delay){e.timerShow=setTimeout(function(){if(e.options.trigger=="click"||e.options.trigger=="hover"&&e.mouseIsOverProxy){e._showNow()}},e.options.delay)}else e._showNow()}},_showNow:function(n){var r=this;r.options.functionBefore.call(r.$el,r.$el,function(){if(r.enabled&&r.Content!==null){if(n)r.callbacks.show.push(n);r.callbacks.hide=[];clearTimeout(r.timerShow);r.timerShow=null;clearTimeout(r.timerHide);r.timerHide=null;if(r.options.onlyOne){e(".tooltipstered").not(r.$el).each(function(t,n){var r=e(n),i=r.data("tooltipster-ns");e.each(i,function(e,t){var n=r.data(t),i=n.status(),s=n.option("autoClose");if(i!=="hidden"&&i!=="disappearing"&&s){n.hide()}})})}var i=function(){r.Status="shown";e.each(r.callbacks.show,function(e,t){t.call(r.$el)});r.callbacks.show=[]};if(r.Status!=="hidden"){var s=0;if(r.Status==="disappearing"){r.Status="appearing";if(l()){r.$tooltip.clearQueue().removeClass("tooltipster-dying").addClass("tooltipster-"+r.options.animation+"-show");if(r.options.speed>0)r.$tooltip.delay(r.options.speed);r.$tooltip.queue(i)}else{r.$tooltip.stop().fadeIn(i)}}else if(r.Status==="shown"){i()}}else{r.Status="appearing";var s=r.options.speed;r.bodyOverflowX=e("body").css("overflow-x");e("body").css("overflow-x","hidden");var o="tooltipster-"+r.options.animation,a="-webkit-transition-duration: "+r.options.speed+"ms; -webkit-animation-duration: "+r.options.speed+"ms; -moz-transition-duration: "+r.options.speed+"ms; -moz-animation-duration: "+r.options.speed+"ms; -o-transition-duration: "+r.options.speed+"ms; -o-animation-duration: "+r.options.speed+"ms; -ms-transition-duration: "+r.options.speed+"ms; -ms-animation-duration: "+r.options.speed+"ms; transition-duration: "+r.options.speed+"ms; animation-duration: "+r.options.speed+"ms;",f=r.options.minWidth?"min-width:"+Math.round(r.options.minWidth)+"px;":"",c=r.options.maxWidth?"max-width:"+Math.round(r.options.maxWidth)+"px;":"",h=r.options.interactive?"pointer-events: auto;":"";r.$tooltip=e('<div class="tooltipster-base '+r.options.theme+'" style="'+f+" "+c+" "+h+" "+a+'"><div class="tooltipster-content"></div></div>');if(l())r.$tooltip.addClass(o);r._content_insert();r.$tooltip.appendTo("body");r.reposition();r.options.functionReady.call(r.$el,r.$el,r.$tooltip);if(l()){r.$tooltip.addClass(o+"-show");if(r.options.speed>0)r.$tooltip.delay(r.options.speed);r.$tooltip.queue(i)}else{r.$tooltip.css("display","none").fadeIn(r.options.speed,i)}r._interval_set();e(t).on("scroll."+r.namespace+" resize."+r.namespace,function(){r.reposition()});if(r.options.autoClose){e("body").off("."+r.namespace);if(r.options.trigger=="hover"){if(u){setTimeout(function(){e("body").on("touchstart."+r.namespace,function(){r.hide()})},0)}if(r.options.interactive){if(u){r.$tooltip.on("touchstart."+r.namespace,function(e){e.stopPropagation()})}var p=null;r.$elProxy.add(r.$tooltip).on("mouseleave."+r.namespace+"-autoClose",function(){clearTimeout(p);p=setTimeout(function(){r.hide()},r.options.interactiveTolerance)}).on("mouseenter."+r.namespace+"-autoClose",function(){clearTimeout(p)})}else{r.$elProxy.on("mouseleave."+r.namespace+"-autoClose",function(){r.hide()})}if(r.options.hideOnClick){r.$elProxy.on("click."+r.namespace+"-autoClose",function(){r.hide()})}}else if(r.options.trigger=="click"){setTimeout(function(){e("body").on("click."+r.namespace+" touchstart."+r.namespace,function(){r.hide()})},0);if(r.options.interactive){r.$tooltip.on("click."+r.namespace+" touchstart."+r.namespace,function(e){e.stopPropagation()})}}}}if(r.options.timer>0){r.timerHide=setTimeout(function(){r.timerHide=null;r.hide()},r.options.timer+s)}}})},_interval_set:function(){var t=this;t.checkInterval=setInterval(function(){if(e("body").find(t.$el).length===0||e("body").find(t.$elProxy).length===0||t.Status=="hidden"||e("body").find(t.$tooltip).length===0){if(t.Status=="shown"||t.Status=="appearing")t.hide();t._interval_cancel()}else{if(t.options.positionTracker){var n=t._repositionInfo(t.$elProxy),r=false;if(o(n.dimension,t.elProxyPosition.dimension)){if(t.$elProxy.css("position")==="fixed"){if(o(n.position,t.elProxyPosition.position))r=true}else{if(o(n.offset,t.elProxyPosition.offset))r=true}}if(!r){t.reposition();t.options.positionTrackerCallback.call(t,t.$el)}}}},200)},_interval_cancel:function(){clearInterval(this.checkInterval);this.checkInterval=null},_content_set:function(e){if(typeof e==="object"&&e!==null&&this.options.contentCloning){e=e.clone(true)}this.Content=e},_content_insert:function(){var e=this,t=this.$tooltip.find(".tooltipster-content");if(typeof e.Content==="string"&&!e.options.contentAsHTML){t.text(e.Content)}else{t.empty().append(e.Content)}},_update:function(e){var t=this;t._content_set(e);if(t.Content!==null){if(t.Status!=="hidden"){t._content_insert();t.reposition();if(t.options.updateAnimation){if(l()){t.$tooltip.css({width:"","-webkit-transition":"all "+t.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-moz-transition":"all "+t.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-o-transition":"all "+t.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-ms-transition":"all "+t.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms",transition:"all "+t.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms"}).addClass("tooltipster-content-changing");setTimeout(function(){if(t.Status!="hidden"){t.$tooltip.removeClass("tooltipster-content-changing");setTimeout(function(){if(t.Status!=="hidden"){t.$tooltip.css({"-webkit-transition":t.options.speed+"ms","-moz-transition":t.options.speed+"ms","-o-transition":t.options.speed+"ms","-ms-transition":t.options.speed+"ms",transition:t.options.speed+"ms"})}},t.options.speed)}},t.options.speed)}else{t.$tooltip.fadeTo(t.options.speed,.5,function(){if(t.Status!="hidden"){t.$tooltip.fadeTo(t.options.speed,1)}})}}}}else{t.hide()}},_repositionInfo:function(e){return{dimension:{height:e.outerHeight(false),width:e.outerWidth(false)},offset:e.offset(),position:{left:parseInt(e.css("left")),top:parseInt(e.css("top"))}}},hide:function(n){var r=this;if(n)r.callbacks.hide.push(n);r.callbacks.show=[];clearTimeout(r.timerShow);r.timerShow=null;clearTimeout(r.timerHide);r.timerHide=null;var i=function(){e.each(r.callbacks.hide,function(e,t){t.call(r.$el)});r.callbacks.hide=[]};if(r.Status=="shown"||r.Status=="appearing"){r.Status="disappearing";var s=function(){r.Status="hidden";if(typeof r.Content=="object"&&r.Content!==null){r.Content.detach()}r.$tooltip.remove();r.$tooltip=null;e(t).off("."+r.namespace);e("body").off("."+r.namespace).css("overflow-x",r.bodyOverflowX);e("body").off("."+r.namespace);r.$elProxy.off("."+r.namespace+"-autoClose");r.options.functionAfter.call(r.$el,r.$el);i()};if(l()){r.$tooltip.clearQueue().removeClass("tooltipster-"+r.options.animation+"-show").addClass("tooltipster-dying");if(r.options.speed>0)r.$tooltip.delay(r.options.speed);r.$tooltip.queue(s)}else{r.$tooltip.stop().fadeOut(r.options.speed,s)}}else if(r.Status=="hidden"){i()}return r},show:function(e){this._showNow(e);return this},update:function(e){return this.content(e)},content:function(e){if(typeof e==="undefined"){return this.Content}else{this._update(e);return this}},reposition:function(){var n=this;if(e("body").find(n.$tooltip).length!==0){n.$tooltip.css("width","");n.elProxyPosition=n._repositionInfo(n.$elProxy);var r=null,i=e(t).width(),s=n.elProxyPosition,o=n.$tooltip.outerWidth(false),u=n.$tooltip.innerWidth()+1,a=n.$tooltip.outerHeight(false);if(n.$elProxy.is("area")){var f=n.$elProxy.attr("shape"),l=n.$elProxy.parent().attr("name"),c=e('img[usemap="#'+l+'"]'),h=c.offset().left,p=c.offset().top,d=n.$elProxy.attr("coords")!==undefined?n.$elProxy.attr("coords").split(","):undefined;if(f=="circle"){var v=parseInt(d[0]),m=parseInt(d[1]),g=parseInt(d[2]);s.dimension.height=g*2;s.dimension.width=g*2;s.offset.top=p+m-g;s.offset.left=h+v-g}else if(f=="rect"){var v=parseInt(d[0]),m=parseInt(d[1]),y=parseInt(d[2]),b=parseInt(d[3]);s.dimension.height=b-m;s.dimension.width=y-v;s.offset.top=p+m;s.offset.left=h+v}else if(f=="poly"){var w=[],E=[],S=0,x=0,T=0,N=0,C="even";for(var k=0;k<d.length;k++){var L=parseInt(d[k]);if(C=="even"){if(L>T){T=L;if(k===0){S=T}}if(L<S){S=L}C="odd"}else{if(L>N){N=L;if(k==1){x=N}}if(L<x){x=L}C="even"}}s.dimension.height=N-x;s.dimension.width=T-S;s.offset.top=p+x;s.offset.left=h+S}else{s.dimension.height=c.outerHeight(false);s.dimension.width=c.outerWidth(false);s.offset.top=p;s.offset.left=h}}var A=0,O=0,M=0,_=parseInt(n.options.offsetY),D=parseInt(n.options.offsetX),P=n.options.position;function H(){var n=e(t).scrollLeft();if(A-n<0){r=A-n;A=n}if(A+o-n>i){r=A-(i+n-o);A=i+n-o}}function B(n,r){if(s.offset.top-e(t).scrollTop()-a-_-12<0&&r.indexOf("top")>-1){P=n}if(s.offset.top+s.dimension.height+a+12+_>e(t).scrollTop()+e(t).height()&&r.indexOf("bottom")>-1){P=n;M=s.offset.top-a-_-12}}if(P=="top"){var j=s.offset.left+o-(s.offset.left+s.dimension.width);A=s.offset.left+D-j/2;M=s.offset.top-a-_-12;H();B("bottom","top")}if(P=="top-left"){A=s.offset.left+D;M=s.offset.top-a-_-12;H();B("bottom-left","top-left")}if(P=="top-right"){A=s.offset.left+s.dimension.width+D-o;M=s.offset.top-a-_-12;H();B("bottom-right","top-right")}if(P=="bottom"){var j=s.offset.left+o-(s.offset.left+s.dimension.width);A=s.offset.left-j/2+D;M=s.offset.top+s.dimension.height+_+12;H();B("top","bottom")}if(P=="bottom-left"){A=s.offset.left+D;M=s.offset.top+s.dimension.height+_+12;H();B("top-left","bottom-left")}if(P=="bottom-right"){A=s.offset.left+s.dimension.width+D-o;M=s.offset.top+s.dimension.height+_+12;H();B("top-right","bottom-right")}if(P=="left"){A=s.offset.left-D-o-12;O=s.offset.left+D+s.dimension.width+12;var F=s.offset.top+a-(s.offset.top+s.dimension.height);M=s.offset.top-F/2-_;if(A<0&&O+o>i){var I=parseFloat(n.$tooltip.css("border-width"))*2,q=o+A-I;n.$tooltip.css("width",q+"px");a=n.$tooltip.outerHeight(false);A=s.offset.left-D-q-12-I;F=s.offset.top+a-(s.offset.top+s.dimension.height);M=s.offset.top-F/2-_}else if(A<0){A=s.offset.left+D+s.dimension.width+12;r="left"}}if(P=="right"){A=s.offset.left+D+s.dimension.width+12;O=s.offset.left-D-o-12;var F=s.offset.top+a-(s.offset.top+s.dimension.height);M=s.offset.top-F/2-_;if(A+o>i&&O<0){var I=parseFloat(n.$tooltip.css("border-width"))*2,q=i-A-I;n.$tooltip.css("width",q+"px");a=n.$tooltip.outerHeight(false);F=s.offset.top+a-(s.offset.top+s.dimension.height);M=s.offset.top-F/2-_}else if(A+o>i){A=s.offset.left-D-o-12;r="right"}}if(n.options.arrow){var R="tooltipster-arrow-"+P;if(n.options.arrowColor.length<1){var U=n.$tooltip.css("background-color")}else{var U=n.options.arrowColor}if(!r){r=""}else if(r=="left"){R="tooltipster-arrow-right";r=""}else if(r=="right"){R="tooltipster-arrow-left";r=""}else{r="left:"+Math.round(r)+"px;"}if(P=="top"||P=="top-left"||P=="top-right"){var z=parseFloat(n.$tooltip.css("border-bottom-width")),W=n.$tooltip.css("border-bottom-color")}else if(P=="bottom"||P=="bottom-left"||P=="bottom-right"){var z=parseFloat(n.$tooltip.css("border-top-width")),W=n.$tooltip.css("border-top-color")}else if(P=="left"){var z=parseFloat(n.$tooltip.css("border-right-width")),W=n.$tooltip.css("border-right-color")}else if(P=="right"){var z=parseFloat(n.$tooltip.css("border-left-width")),W=n.$tooltip.css("border-left-color")}else{var z=parseFloat(n.$tooltip.css("border-bottom-width")),W=n.$tooltip.css("border-bottom-color")}if(z>1){z++}var X="";if(z!==0){var V="",J="border-color: "+W+";";if(R.indexOf("bottom")!==-1){V="margin-top: -"+Math.round(z)+"px;"}else if(R.indexOf("top")!==-1){V="margin-bottom: -"+Math.round(z)+"px;"}else if(R.indexOf("left")!==-1){V="margin-right: -"+Math.round(z)+"px;"}else if(R.indexOf("right")!==-1){V="margin-left: -"+Math.round(z)+"px;"}X='<span class="tooltipster-arrow-border" style="'+V+" "+J+';"></span>'}n.$tooltip.find(".tooltipster-arrow").remove();var K='<div class="'+R+' tooltipster-arrow" style="'+r+'">'+X+'<span style="border-color:'+U+';"></span></div>';n.$tooltip.append(K)}n.$tooltip.css({top:Math.round(M)+"px",left:Math.round(A)+"px"})}return n},enable:function(){this.enabled=true;return this},disable:function(){this.hide();this.enabled=false;return this},destroy:function(){var t=this;t.hide();if(t.$el[0]!==t.$elProxy[0]){t.$elProxy.remove()}t.$el.removeData(t.namespace).off("."+t.namespace);var n=t.$el.data("tooltipster-ns");if(n.length===1){var r=null;if(t.options.restoration==="previous"){r=t.$el.data("tooltipster-initialTitle")}else if(t.options.restoration==="current"){r=typeof t.Content==="string"?t.Content:e("<div></div>").append(t.Content).html()}if(r){t.$el.attr("title",r)}t.$el.removeClass("tooltipstered").removeData("tooltipster-ns").removeData("tooltipster-initialTitle")}else{n=e.grep(n,function(e,n){return e!==t.namespace});t.$el.data("tooltipster-ns",n)}return t},elementIcon:function(){return this.$el[0]!==this.$elProxy[0]?this.$elProxy[0]:undefined},elementTooltip:function(){return this.$tooltip?this.$tooltip[0]:undefined},option:function(e,t){if(typeof t=="undefined")return this.options[e];else{this.options[e]=t;return this}},status:function(){return this.Status}};e.fn[r]=function(){var t=arguments;if(this.length===0){if(typeof t[0]==="string"){var n=true;switch(t[0]){case"setDefaults":e.extend(i,t[1]);break;default:n=false;break}if(n)return true;else return this}else{return this}}else{if(typeof t[0]==="string"){var r="#*$~&";this.each(function(){var n=e(this).data("tooltipster-ns"),i=n?e(this).data(n[0]):null;if(i){if(typeof i[t[0]]==="function"){var s=i[t[0]](t[1],t[2])}else{throw new Error('Unknown method .tooltipster("'+t[0]+'")')}if(s!==i){r=s;return false}}else{throw new Error("You called Tooltipster's \""+t[0]+'" method on an uninitialized element')}});return r!=="#*$~&"?r:this}else{var o=[],u=t[0]&&typeof t[0].multiple!=="undefined",a=u&&t[0].multiple||!u&&i.multiple,f=t[0]&&typeof t[0].debug!=="undefined",l=f&&t[0].debug||!f&&i.debug;this.each(function(){var n=false,r=e(this).data("tooltipster-ns"),i=null;if(!r){n=true}else if(a){n=true}else if(l){console.log('Tooltipster: one or more tooltips are already attached to this element: ignoring. Use the "multiple" option to attach more tooltips.')}if(n){i=new s(this,t[0]);if(!r)r=[];r.push(i.namespace);e(this).data("tooltipster-ns",r);e(this).data(i.namespace,i)}o.push(i)});if(a)return o;else return this}}};var u=!!("ontouchstart"in t);var a=false;e("body").one("mousemove",function(){a=true})})(jQuery,window,document);