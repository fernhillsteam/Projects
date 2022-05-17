$(document).ready(function() { 
	// 顶部搜索栏
	$(function(){
		$('.top-search > a').click(function(e){
			e.stopPropagation(e);
			$(this).parent().addClass('unfold');
			$('#header .side-wrap .maps').addClass('hides');
		})

		$('.top-search').click(function(e){
		    e.stopPropagation(e);
		})

		$('body').click(function(e){
		    e.stopPropagation(e);
		    $('.top-search').removeClass('unfold');
		    $('#header .side-wrap .maps').removeClass('hides');
		})
	});

	// 顶部搜索提交
	$('#header .top-search').submit(function(){
        var text_val = $('#header .top-search .text').val();
        if(text_val!=''){
        	window.location.href = "/search/Keyword-"+text_val+'/';
        	return false;
        }
    })

    // 顶部搜索提交
	$('#header-mobile .top-search').submit(function(){
        var text_val = $('#header-mobile .top-search .text').val();
        if(text_val!=''){
        	window.location.href = "/search/Keyword-"+text_val+'/';
        	return false;
        }
    })

    $('#header .side-wrap .shares').click(function(e){
    	e.stopPropagation(e);
    	if($(this).hasClass('on')){
    		$(this).removeClass('on');
    		$(this).find('.posit-share').hide();
    	}else{
    		$(this).addClass('on');
    		$(this).find('.posit-share').show();
    	}
    })

    $('body').click(function(e){
    	e.stopPropagation(e);
    	$('#header .side-wrap .shares').removeClass('on');
    	$('#header .side-wrap .shares').find('.posit-share').hide();
    })

	// // pc头部下拉
	// $(function(){
	// 	$('#header .nav-wrap .nav').hover(function(){
	// 		var indexs = $(this).index();
	// 		$('#header .nav-wraps .nav-menu').eq(indexs).show().siblings('.nav-menu').hide();
	// 	})

	// 	$('#header .nav-wraps').hover(function(){

	// 	},function(){
	// 		$('#header .nav-wraps .nav-menu').hide();
	// 	})
	// })

	// 侧边栏弹框弹窗
	// $(function(){
	// 	$('#side .sides').click(function(){
	// 		$('.contact-code').show();
	// 		$('#drak_big3').show();
	// 	})

	// 	$('.contact-code .close').click(function(){
	// 		$('.contact-code').hide();
	// 		$('#drak_big3').hide();
	// 	})
	// })

	// 侧边栏弹框弹窗
	$(function(){
		$('#side .sides').click(function(e){
			e.stopPropagation(e);
			$('.side-main').addClass('on');
		})

		$('.side-main .close').click(function(){
			$('.side-main').removeClass('on');
		})

		$('body').click(function(e){
			e.stopPropagation(e);
			$('.side-main').removeClass('on');
		})

		var w =  $(window).width();
		$('.side-main .big').css({width:w});

		$('.side-main .big .contact .item').click(function(e){
			e.stopPropagation(e);
			$('.side-main').addClass('on');
		})

		$('.side-main .big .contact').click(function(e){
			e.stopPropagation(e);
			$('.side-main').addClass('on');
		})
	})
	
	// 用户协议
	$(function(){
		$('#protocol').click(function(){
			$('#resume').show();
			$('#drak_big').show();
		})
	})

	// 手机版头部下拉
	$(function(){
		 $('#header-mobile .header-mobile .nav .bignav').click(function(){
		    $(this).next('.header2').slideToggle();
		    $(this).toggleClass('on');
		})

		$('#header-mobile .header-mobile .top .right .closes').click(function(){
		    $('#header-mobile .header-mobile').hide();
		})

		$('#header-mobile .mobile-wrap .right .mobilenav').click(function(){
		    $('#header-mobile .header-mobile').show();
		})
	})

	// 我们的客户
	// $(function(){
	// 	$('#main .client-wrap .cate-row .category').click(function(){
	// 		var client_row = $('#main .client-wrap .client-row');
	// 		var CateId = $(this).attr('CateId');
	// 		$(this).addClass('on').siblings('#main .client-wrap .cate-row .category').removeClass('on');
	// 		$.post(
 //                '/ajax/client.php',
 //                {
 //                	CateId:CateId,
 //                },
 //                function(data){
 //                    if(data){
 //                        client_row.html(data);
 //                    }
 //                }
 //            )
	// 	})
	// })
	
	// 热门新闻轮播
	$(function(){
		var swiper = new Swiper('.info-hot .swiper-container', {
		    // nextButton: '.info-hot .swiper-button-next',
		    // prevButton: '.info-hot .swiper-button-prev',
		    // pagination : '.info-hot .swiper-pagination',
		    // paginationClickable :true,
		    autoplay: 3000,
		    slidesPerView: 3,
		    autoplayDisableOnInteraction: false,
		    speed:1200,
		    loop:true,
		    spaceBetween: 25,
		    breakpoints: { 
				//当宽度小于等于480
				480: {
				  slidesPerView: 1,
				  spaceBetween: 10
				},
				//当宽度小于等于1080
				1080: {
				  slidesPerView: 2,
				  spaceBetween: 15
				}
			}
		});	
	})

	// 市场活动报名表单
	$(function(){
		$('#message .close').click(function(){
			$('#drak_big').hide();
			$('#message').hide();
		})

		$('.apply-btn').click(function(){
			if($(this).attr('href')=='javascript:;'){
				$('#drak_big').show();
				$('#message').show();
			}
		})
	})

	// 简历投递表单
	$(function(){
		$('#resume .close').click(function(){
			$('#drak_big').hide();
			$('#resume').hide();
		})

		$('#main .join-wrap .join-row .box_2 .content .white .btn').click(function(){
			$('#drak_big').show();
			$('#resume').show();
			var casename = $(this).attr('casename');
			var CaseId = $(this).attr('caseid');
			$('#caseids').val(CaseId);
			$('#resume .title2').text(casename);
		})

		$('#resume .meg .file-input').change(function(){
			var str = $(this).val();
			var arr=str.split('\\');//注split可以用字符或字符串分割
			var my=arr[arr.length-1];//这就是要取得的图片名称
			$('#resume .meg .file-left').text(my);
		})
	})

	// 常见问题
	$(function(){
		// var wow=new WOW().init();
		$(".f_box").click(function(){
			if($(this).parents("li").hasClass("on")){
				$(this).parents("li").removeClass("on");
			}else{
				$('#main .common-wrap .f_list li').removeClass('on');
				$(this).parents("li").addClass("on");	
			}	
		})	
	})

	// 产品轮播
	$(function(){
		var sync1 = $(".products-top #sync1");
	    var sync2 = $(".products-top #sync2");

	    sync1.owlCarousel({
	      singleItem : true,
	      slideSpeed : 800,
	      navigation: true,
	      pagination:false,
	      afterAction : syncPosition,
	      responsiveRefreshRate : 200,
	      navigationText : ['',''],
	    });

	    sync2.owlCarousel({
	      items : 5,
	      itemsDesktop      : [1199,5],
	      itemsDesktopSmall     : [979,5],
	      itemsTablet       : [768,5],
	      itemsMobile       : [479,3],
	      pagination:false,
	      responsiveRefreshRate : 100,
	      afterInit : function(el){
	        el.find(".owl-item").eq(0).addClass("synced");
	      }
	    });

	    function syncPosition(el){
	      var current = this.currentItem;
	      $("#sync2")
	        .find(".owl-item")
	        .removeClass("synced")
	        .eq(current)
	        .addClass("synced")
	      if($("#sync2").data("owlCarousel") !== undefined){
	        center(current)
	      }

	    }

	    $("#sync2").on("click", ".owl-item", function(e){
	      e.preventDefault();
	      var number = $(this).data("owlItem");
	      sync1.trigger("owl.goTo",number);
	    });

	    function center(number){
	      var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

	      var num = number;
	      var found = false;
	      for(var i in sync2visible){
	        if(num === sync2visible[i]){
	          var found = true;
	        }
	      }

	      if(found===false){
	        if(num>sync2visible[sync2visible.length-1]){
	          sync2.trigger("owl.goTo", num - sync2visible.length+2)
	        }else{
	          if(num - 1 === -1){
	            num = 0;
	          }
	          sync2.trigger("owl.goTo", num);
	        }
	      } else if(num === sync2visible[sync2visible.length-1]){
	        sync2.trigger("owl.goTo", sync2visible[1])
	      } else if(num === sync2visible[0]){
	        sync2.trigger("owl.goTo", num-1)
	      }
	    }
    })

}); 

// 产品列表
function prolist(){
	var height = $('#main .products-wrap .products-list').height()-80;
	$('#main .products-wrap .products-list-posit').height(height);

	$('#main .products-wrap .products-list .item')

	$('#main .products-wrap .products-list .products .ratio').click(function(){
		$('#products-box').show();
		$('#drak_big').show();
		return false;
	})

	$('#products-box .top .close').click(function(){
		$('#products-box').hide();
		$('#drak_big').hide();
	})
}

// 产品列表选中比较
function proCheckboxClick(obj){
	var checkedProp = obj.prop("checked");
	var	checkedValue = obj.val();

	var strs = $("input[type='checkbox']:checked").length;
	
	if(strs<4){
		if(checkedProp){
			$('#main .products-wrap .products-list .products .ratio').removeClass('on');
			obj.parent('.item').find('.ratio').addClass('on');
			obj.addClass('che')
		}else{
			obj.parent('.item').find('.ratio').removeClass('on');
			obj.removeClass('che')
		}

		var che = $('#main .products-wrap .products-list .item');
		var che_len = che.children('.che').length;

		var che_arr =new Array();
		for(var i=0;i<che_len;i++) {
			che_arr[i] = che.children('.che').eq(i).attr("value");
		    select_pro=che_arr.join();
		}

		$('.sp').text(che_len);
		$.post(
				'/ajax/products-box.php',
				{
					ProId:select_pro
				},
				function(data){
					$('#products-box .bot').html(data);
				}
		); 
	}else{
		alert('最多选择三个产品进行对比');
		obj.prop('checked',false);
	}
}

// 我们的客户
function IndexClient(obj,CateId){
	obj.addClass('on').siblings('.category').removeClass('on');
	$.post(
			'/ajax/client.php',
			{
				CateId:CateId
			},
			function(data){
				obj.parents('.cw1400').find('.client-row').html(data);
			}
	); 
}


// 公司简介数字跳转特效
function ShowCountUp(Obj){          //元素进入浏览器可视区域后运行数值变化
    var Demos = SetCountUp(Obj);
    ScrollShow(Obj,false,function(){
        for(i = 0; i < Demos.length; i++){
            Demos[i].start();
        }
    });
}
function SetCountUp(Obj){      //设置数值变化     Obj:对象需要拥有ID
    var Demo = [],
        DefauitOptions = {
            useEasing : false,
            useGrouping : true,
            separator : '',
            decimal : '.',
            prefix : '',
            suffix : ''
        };

    Obj.each(function(i,e){
        if(jQuery(e).attr('id')){
            var Id = jQuery(e).attr('id'),
                Start = jQuery(e).attr('data-start'),
                End = jQuery(e).attr('data-end'),
                Decimals = jQuery(e).attr('data-decimals'),
                Duration = jQuery(e).attr('data-duration'),
                useEasing = jQuery(e).attr('data-useEasing'),
                useGrouping = jQuery(e).attr('data-useGrouping'),
                separator = jQuery(e).attr('data-separator'),
                decimal = jQuery(e).attr('data-decimal'),
                prefix = jQuery(e).attr('data-prefix'),
                suffix = jQuery(e).attr('data-suffix'),
                Options = {
                    useEasing : useEasing != undefined ? useEasing : DefauitOptions.useEasing,
                    useGrouping : useGrouping != undefined ? useGrouping : DefauitOptions.useGrouping,
                    separator : separator != undefined ? separator : DefauitOptions.separator,
                    decimal : decimal != undefined ? decimal : DefauitOptions.decimal,
                    prefix : prefix != undefined ? prefix : DefauitOptions.prefix,
                    suffix : suffix != undefined ? suffix : DefauitOptions.suffix
                };

            Demo[i] = new CountUp(Id, Start, End, Decimals, Duration, Options);
        }
    });

    return Demo;
}

var options = {
  useEasing : true,
  useGrouping : true,
  separator : ',',
  decimal : '.',
  prefix : '',
  suffix : ''
};

function ScrollShow(Obj,Repeat,Callbacks){          //对象滚动到浏览器可视区域时执行回调函数
    if(Obj.length){
        Obj.each(function(i,e){
            var Site = jQuery(e).offset(),
                Height = jQuery(e).outerHeight(true),
                WinTop = jQuery(this).scrollTop(),         //滚动条位置
                WinHeight = jQuery(this).height(),      //窗口高度
                WinArea = WinTop+WinHeight,        //浏览器可视区域
                IsRepeat = Repeat === true ? true : false,      //重复执行
                Switch = true;                                  //开关
            if(Site.top <= WinArea && (Height+Site.top) >= WinTop && Switch){
                jQuery.isFunction(Callbacks) && Callbacks();
                Switch = false;
            }else{
                if(IsRepeat === true && Switch === false){
                    Switch = true
                }
            }

            jQuery(window).scroll(function(){
                Site = jQuery(e).offset();
                Height = jQuery(e).outerHeight(true);
                WinTop = jQuery(this).scrollTop();
                WinHeight = jQuery(this).height();
                WinArea = WinTop+WinHeight;
                //document.title = parseInt(Site.top)+' '+WinArea+' | '+parseInt(Height+Site.top)+' '+WinTop;
                if(Site.top <= WinArea && (Height+Site.top) >= WinTop && Switch){
                    jQuery.isFunction(Callbacks) && Callbacks();
                    Switch = false;
                    var num1 = new CountUp("loadingNum_1", 0, $('#loadingNum_1').attr('data-end'), 0, 3, options);
                    var num2 = new CountUp("loadingNum_2", 0, $('#loadingNum_2').attr('data-end'), 0, 3, options);
                    var num3 = new CountUp("loadingNum_3", 0, $('#loadingNum_3').attr('data-end'), 0, 3, options);
                    var num4 = new CountUp("loadingNum_4", 0, $('#loadingNum_4').attr('data-end'), 0, 3, options);
                    
                    num1.start();
                    num2.start();
                    num3.start();
                    num4.start();
                }else{
                    if(IsRepeat === true && Switch === false){
                        Switch = true
                    }
                }
            });
        });
    }
    return;
}

$(function(){
	// ShowCountUp(jQuery('.positcon'));
})


// 发展历程
!function(w,$){

    var about = {
        menu : '.history-wrap',
        yearItem : '.year-list .item',
        pathItem : '.path-list .item',
        yearIndex : 0,
        menuSwiper : new Object,
        yearSwiper : new Object,
        honorSwiper : new Object,
        menuMove : function(){
            var self = this,
            item = $('.item[for]',self.menu),
            isiOS = !!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if(!item.length) return false;

            item.click(function(){
                var forObj = $(this).attr('for'),
                targetObj = $('.about-'+forObj),
                headSize = $(header.h).outerHeight(true),
                menuSize = $(self.menu).outerHeight(true),
                objSite = targetObj.offset().top - parseFloat(headSize) - parseFloat(menuSize);
                $('html,body').animate({scrollTop:objSite},400);
            });

            if(isiOS && (navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))){
                item.hover(function(){
                    var forObj = $(this).attr('for'),
                    targetObj = $('.about-'+forObj),
                    headSize = $(header.h).outerHeight(true),
                    menuSize = $(self.menu).outerHeight(true),
                    objSite = targetObj.offset().top - parseFloat(headSize) - parseFloat(menuSize);
                    $('html,body').animate({scrollTop:objSite},400);
                });
            }
        },
        changePath : function(i){
            var self = this;
            $(self.yearItem).eq(i).addClass('on').siblings(self.yearItem).removeClass('on');
            $(self.pathItem).eq(i).addClass('on').siblings(self.pathItem).removeClass('on');
        },
        init : function(){
            var self = this,
            yearPrev = $('.prev','.year-list'),
            yearNext = $('.next','.year-list'),
            honorPrev = $('.prev','.honor-list'),
            honorNext = $('.next','.honor-list')

            self.menuMove();

            self.menuSwiper = new Swiper('.about-menu .swiper-container',{
                slidesPerView: 'auto',
                freeMode: true,
            });

            self.yearSwiper = new Swiper('.year-swiper',{
                slidesPerView: 6,
                breakpoints: {
                    768: {
                        slidesPerView: 5
                    },
                    580: {
                        slidesPerView: 3
                    }
                }
            });

            self.changePath(self.yearIndex);
            $(self.yearItem).mouseover(function(){
                self.yearIndex = $(this).index();
                self.changePath(self.yearIndex);
            });

            yearPrev.click(function(){
                if(self.yearIndex > 0){
                    self.yearIndex--;
                    self.changePath(self.yearIndex);
                    if(self.yearIndex==(self.yearSwiper.activeIndex*self.yearSwiper.params.slidesPerGroup)-self.yearSwiper.params.slidesPerGroup){
                        self.yearSwiper.slidePrev();
                    }
                }
            });

            yearNext.click(function(){
                if(self.yearIndex < self.yearSwiper.slides.length-1){
                    self.yearIndex++;
                    self.changePath(self.yearIndex);
                    if(self.yearIndex==self.yearSwiper.activeIndex*self.yearSwiper.params.slidesPerGroup+self.yearSwiper.params.slidesPerView){
                        self.yearSwiper.slideNext();
                    }
                }
            });
        }
    }

    w.onload = function(){
        // about.init();
        prolist();

        $('[custom-item]').each(function(){
		    custom($(this));
		})

		$('.custom-wrap .custom-list .item').hover(function(){
		    $(this).addClass('on');
		    $(this).siblings('.item').removeClass('on');
		    var sw = $('.custom-wrap .custom-list').width()*0.2;
		    var hsw = sw*0.5;
		    if($(this).hasClass('on')){
		        $(this).find('.con').css({left:'-'+'0'+'px'});
		        $(this).siblings('.item').find('.con').css({left:'-'+hsw+'px'});
		    }

		    var i = $(this).index();
		    var l = i*sw+i;
		    $(this).css({left:l});
		    $(this).nextAll('.item').each(function(){
		        var ni = $(this).index()+1;
		        var nl = sw*ni-ni-1;
		        $(this).css({left:nl});
		    })
		    $(this).prevAll('.item').each(function(){
		        var ni = $(this).index();
		        var nl = sw*ni;
		        $(this).css({left:nl});
		    })
		})
    }

    w.onresize = function(){

    }
    
}(window,jQuery);

// 人才招聘
// function talent(){
// 	var btn = $('.join-row .item .jia');
// 	btn.click(function(){
// 		$(this).parent().siblings('.item').removeClass('on');
// 		$(this).parent().siblings('.item').find('.jia').removeClass('jian');
// 		$(this).parent().siblings('.content').hide();

// 		content = $(this).parent('.item').next();
// 		$(this).toggleClass('jian');
// 		$(this).parent('.item').toggleClass('on');
// 		content.toggleClass('open');
// 		if($(this).parent('.item').hasClass('on')){
// 			content.show();
// 		}else{
// 			content.hide();
// 		}
// 	})
// }

function talent(){
	var btn = $('.join-wrap .join-row .item_2');
	btn.click(function(){
		$(this).siblings('.item').removeClass('on');
		$(this).siblings('.item').find('.jia').removeClass('jian');
		$(this).siblings('.content').hide();

		content = $(this).next();
		$(this).find('.jia').toggleClass('jian');
		$(this).toggleClass('on');
		content.toggleClass('open');
		if($(this).hasClass('on')){
			content.show();
		}else{
			content.hide();
		}
	})
}

function custom(obj){
    var sw = $('.custom-wrap .custom-list').width()*0.2;
    var hsw = sw*0.5;
    var i = obj.index();
    var w = (i*sw);
    obj.css({left:w});
    obj.find('.con').css({left:'-'+hsw+'px'});
}

$(function(){
	talent();

	$('[custom-item]').each(function(){
	    custom($(this));
	})
	
	$('.custom-wrap .custom-list .item').hover(function(){
	    $(this).addClass('on');
	    $(this).siblings('.item').removeClass('on');
	    var sw = $('.custom-wrap .custom-list').width()*0.2;
	    var hsw = sw*0.5;
	    if($(this).hasClass('on')){
	        $(this).find('.con').css({left:'-'+'0'+'px'});
	        $(this).siblings('.item').find('.con').css({left:'-'+hsw+'px'});
	    }
	
	    var i = $(this).index();
	    var l = i*sw+i;
	    $(this).css({left:l});
	    $(this).nextAll('.item').each(function(){
	        var ni = $(this).index()+1;
	        var nl = sw*ni-ni-1;
	        $(this).css({left:nl});
	    })
	    $(this).prevAll('.item').each(function(){
	        var ni = $(this).index();
	        var nl = sw*ni;
	        $(this).css({left:nl});
	    })
	})
})

$(function(){
	var myscroll;
    function loaded(){
        myscroll=new iScroll("wrapper",{
            mouseWheel: true,
            scrollbars: false,
            shrinkScrollbars : 'clip',
            probeType: 2,
            click: true,
            disableMouse: true,
            disablePointer: true,
            onBeforeScrollStart:null,
            hScroll: true,
            onBeforeScrollStart: function ( e ) {
                if ( this.absDistX > (this.absDistY + 5 ) ) {
                    // user is scrolling the x axis, so prevent the browsers' native scrolling
                    e.preventDefault();
                }
            },
            //解决第一次无法滑动的问题
            onTouchEnd: function () {
                var self = this;
                if (self.touchEndTimeId) {
                        clearTimeout(self.touchEndTimeId);
                }

                self.touchEndTimeId = setTimeout(function () {
                        self.absDistX = 0;
                        self.absDistY = 0;
                }, 600);
            }
        });
    }
    window.addEventListener("DOMContentLoaded",loaded,false);
})