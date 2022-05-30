jQuery( document ).ready( function( $ ) {
	
	/*Scroll transition to anchor*/
	$("a.slow-scroll").on('click',function(e) {
		var url = e.target.href;
		var hash = url.substring(url.indexOf("#")+1);
		$('html, body').animate({
			scrollTop: $('#'+hash).offset().top
		}, 250);
		return false;
	});	
	
	$( ".app-nav" ).click(function() {
		event.preventDefault();
		$( ".app-nav" ).removeClass("active");
		$(this).addClass("active");
		console.log("click");
		
		$( ".tab-pane" ).removeClass("active");
		var tab_id = $(this).attr("id");
		$("."+tab_id).addClass("active");
		
	});
	
	//$( "#other" ).click(function() {
	
	$( ".expand.btn" ).click(function() {
		event.preventDefault();
		$( ".contactpanel" ).slideToggle(800, "swing");
	});
	
	// adapt for multiple expanders per page
	// class list should begin with "expand-"
	// the selector of the panel to expand shoudl appear after the -
	// eg expand-panel1
	$( "[class^=expand-]" ).click(function() {

		event.preventDefault();			
		
		var classes = $(this).attr('class');
		var pos = $(this).attr('class').indexOf("expand-");
		var classarray = classes.split(" ");
		var selector = classarray[pos];
		var selarray = selector.split("-");
		var panelselectorname = selarray[1];
		var displayvalue = $("."+panelselectorname).is(':visible');

		if ($(this).text() == "Read More" || $(this).text() == "Read Less") {
		
			if ( displayvalue != true ) {
				$(this).text("Read Less");
			} else {
				$(this).text("Read More");
			}
		
		} else {
			//console.log($(this).children(".faq-symbol").text());
			
			if ($(this).find(".faq-symbol").text() == "+" || $(this).find(".faq-symbol").text() == "-") {
			
				if ( displayvalue != true ) {
					$(this).find(".faq-symbol").text("-");
				} else {
					$(this).find(".faq-symbol").text("+");
				}			
			}
			
		}

		$( "."+panelselectorname ).slideToggle(800, "swing");

	});	
	
	//show List

    $( "[class^=showlist-]" ).click(function() {

		event.preventDefault();			
		
		var classes = $(this).attr('class');
		var pos = $(this).attr('class').indexOf("showlist-");
		var classarray = classes.split(" ");
		var selector = classarray[pos];
		var selarray = selector.split("-");
		var panelselectorname = selarray[1];
		var displayvalue = $("."+panelselectorname).is(':visible');

		console.log(pos);


		$( "."+panelselectorname ).slideToggle(800, "swing");
        
        var a=$(this).text();
		console.log(a);

		if ($(this).text() == "Read More" || $(this).text() == "Read Less") {
		
			if ( displayvalue != true ) {
				$(this).text("Read Less");
			} else {
				$(this).text("Read More");
			}
		
		}

	});
     
	/* 360 viewer */
	
	var productViewer = function(element) {
		this.element = element;
		this.handleContainer = this.element.find('.cd-product-viewer-handle');
		this.handleFill = this.handleContainer.children('.fill');
		this.handle = this.handleContainer.children('.handle');
		this.imageWrapper = this.element.find('.product-viewer');
		this.slideShow = this.imageWrapper.children('.product-sprite');
		this.frames = this.element.data('frame');
		//increase this value to increase the friction while dragging on the image - it has to be bigger than zero
		this.friction = this.element.data('friction');
		this.visibleFrame = 0;
		this.loaded = false;
		this.animating = false;
		this.xPosition = 0;
		this.loadFrames();
	} 

	productViewer.prototype.loadFrames = function() {
		var self = this,
			imageUrl = this.slideShow.data('image'),
			newImg = $('<img/>');
		this.loading('0.5');
		//you need this to check if the image sprite has been loaded
		newImg.attr('src', imageUrl).load(function() {
			$(this).remove();
  			self.loaded = true;
  		}).each(function(){
  			image = this;
			if(image.complete) {
		    	$(image).trigger('load');
		  	}
		});
	}

	productViewer.prototype.loading = function(percentage) {
		var self = this;
		transformElement(this.handleFill, 'scaleX('+ percentage +')');
		setTimeout(function(){
			if( self.loaded ){
				//sprite image has been loaded
				self.element.addClass('loaded');
				transformElement(self.handleFill, 'scaleX(1)');
				self.dragImage();
				if(self.handle) self.dragHandle();
			} else {
				//sprite image has not been loaded - increase self.handleFill scale value
				var newPercentage = parseFloat(percentage) + .1;
				if ( newPercentage < 1 ) {
					self.loading(newPercentage);
				} else {
					self.loading(parseFloat(percentage));
				}
			}
		}, 500);
	}
	//draggable funtionality - credits to http://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/
	productViewer.prototype.dragHandle = function() {
		//implement handle draggability
		var self = this;
		self.handle.on('mousedown vmousedown', function (e) {
	        self.handle.addClass('cd-draggable');
	        var dragWidth = self.handle.outerWidth(),
	            containerOffset = self.handleContainer.offset().left,
	            containerWidth = self.handleContainer.outerWidth(),
	            minLeft = containerOffset - dragWidth/2,
	            maxLeft = containerOffset + containerWidth - dragWidth/2;

	        self.xPosition = self.handle.offset().left + dragWidth - e.pageX;

	        self.element.on('mousemove vmousemove', function (e) {
	        	if( !self.animating) {
	        		self.animating =  true;
		        	( !window.requestAnimationFrame )
		        		? setTimeout(function(){self.animateDraggedHandle(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft);}, 100)
		        		: requestAnimationFrame(function(){self.animateDraggedHandle(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft);});
	        	}
	        }).one('mouseup vmouseup', function (e) {
	            self.handle.removeClass('cd-draggable');
	            self.element.off('mousemove vmousemove');
	        });

	        e.preventDefault();

	    }).on('mouseup vmouseup', function (e) {
	        self.handle.removeClass('cd-draggable');
	    });
	}

	productViewer.prototype.animateDraggedHandle = function(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft) {
		var self = this;
		var leftValue = e.pageX + self.xPosition - dragWidth;
	    // constrain the draggable element to move inside his container
	    if (leftValue < minLeft) {
	        leftValue = minLeft;
	    } else if (leftValue > maxLeft) {
	        leftValue = maxLeft;
	    }

	    var widthValue = Math.ceil( (leftValue + dragWidth / 2 - containerOffset) * 1000 / containerWidth)/10;
	    self.visibleFrame = Math.ceil( (widthValue * (self.frames-1))/100 );

	    //update image frame
	    self.updateFrame();
	    //update handle position
	    $('.cd-draggable', self.handleContainer).css('left', widthValue + '%').one('mouseup vmouseup', function () {
	        $(this).removeClass('cd-draggable');
	    });

	    self.animating = false;
	}

	productViewer.prototype.dragImage = function() {
		//implement image draggability
		var self = this;
		self.slideShow.on('mousedown vmousedown', function (e) {
	        self.slideShow.addClass('cd-draggable');
	        var containerOffset = self.imageWrapper.offset().left,
	            containerWidth = self.imageWrapper.outerWidth(),
	            minFrame = 0,
	            maxFrame = self.frames - 1;

	        self.xPosition = e.pageX;

	        self.element.on('mousemove vmousemove', function (e) {
	        	if( !self.animating) {
	        		self.animating =  true;
		        	( !window.requestAnimationFrame )
		        		? setTimeout(function(){self.animateDraggedImage(e, containerOffset, containerWidth);}, 100)
		        		: requestAnimationFrame(function(){self.animateDraggedImage(e, containerOffset, containerWidth);});
		        }
	        }).one('mouseup vmouseup', function (e) {
	            self.slideShow.removeClass('cd-draggable');
	            self.element.off('mousemove vmousemove');
	            self.updateHandle();
	        });

	        e.preventDefault();

	    }).on('mouseup vmouseup', function (e) {
	        self.slideShow.removeClass('cd-draggable');
	    });
	}

	productViewer.prototype.animateDraggedImage = function(e, containerOffset, containerWidth) {
		var self = this;
		var leftValue = self.xPosition - e.pageX;
        var widthValue = Math.ceil( (leftValue) * 100 / ( containerWidth * self.friction ));
        var frame = (widthValue * (self.frames-1))/100;
        if( frame > 0 ) {
        	frame = Math.floor(frame);
        } else {
        	frame = Math.ceil(frame);
        }
        var newFrame = self.visibleFrame + frame;

        if (newFrame < 0) {
            newFrame = self.frames - 1;
        } else if (newFrame > self.frames - 1) {
            newFrame = 0;
        }

        if( newFrame != self.visibleFrame ) {
        	self.visibleFrame = newFrame;
        	self.updateFrame();
        	self.xPosition = e.pageX;
        }

        self.animating =  false;
	}

	productViewer.prototype.updateHandle = function() {
		if(this.handle) {
			var widthValue = 100*this.visibleFrame/this.frames;
			this.handle.animate({'left': widthValue + '%'}, 200);
		}
	}

	productViewer.prototype.updateFrame = function() {
		var transformValue = - (100 * this.visibleFrame/this.frames);
		transformElement(this.slideShow, 'translateX('+transformValue+'%)');
	}

	function transformElement(element, value) {
		element.css({
			'-moz-transform': value,
		    '-webkit-transform': value,
			'-ms-transform': value,
			'-o-transform': value,
			'transform': value,
		});
	}

	var productToursWrapper = $('.cd-product-viewer-wrapper');
	productToursWrapper.each(function(){
		new productViewer($(this));
	});
	
	
	$('input[value="Draft"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/draft-1.jpg"/>');
	$('input[value="Clear"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/clear.jpg"/>');
	$('input[value="White"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/white.jpg"/>');
	$('input[value="Grey"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/grey.jpg"/>');
	$('input[value="Black"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/black.jpg"/>');
 	$('input[value="Tough"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/tough2-1.png"/>');
 	$('input[value="Tough_2000"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2020/05/tough2000.jpg"/>');
 	$('input[value="Tough_1500"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2020/05/tough1500.jpg"/>'); 	
	$('input[value="Flexible"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/flexible.jpg"/>');
	$('input[value="High_Temp"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/high-temp2-1.png"/>');
	$('input[value="Castable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/castable2-1.png"/>');
	$('input[value="Wax_Castable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/08/castable_wax_sample-2.png"/>');
	$('input[value="Durable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/09/durable2-1.png"/>');
	$('input[value="Rigid"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/07/rigid-sample.png"/>');
	$('input[value="Grey_Pro"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/07/grey-pro-sample.png"/>');
	$('input[value="Nylon_12"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2021/06/nylon12.jpg"/>');
	
	wpcf7.cached = 0; 
	/* 
	$( "[id$=_desc]" ).hide();
	
	$( ".feature" ).hover(function() {
		// get the feature name
		var featurename = $(this).attr('id');
		// add _desc
		
		featurename = featurename + "_desc";
		console.log('xfeaturename = '+featurename);
  		$( '#'+featurename ).toggle( "medium" );
	});
	*/
	
    $(window).on('load', function (e) { iFrameResize({ heightCalculationMethod:'bodyScroll' }, '#calcIframe'); });

});