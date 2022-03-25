// source --> https://vizulab.com.au/wp-content/plugins/responsive-menu/v4.0.0/assets/js/rmp-menu.js?ver=4.1.8 
/**
 * This file contain the scrips for menu frontend.
 * @author ExpressTech System
 *
 * @since 4.0.0
 */

jQuery( document ).ready( function( jQuery ) {

	/**
	 * RmpMenu Class
	 * This RMP class is handling the frontend events and action on menu elements.
	 * @since      4.0.0
	 * @access     public
	 *
	 * @class      RmpMenu
	 */
	class RmpMenu {

		/**
		 * This is constructor function which is initialize the elements and options.
		 * @access public
		 * @since 4.0.0
		 * @param {Array} options List of options.
		 */
		constructor( options ) {
			RmpMenu.activeToggleClass        = 'is-active';
			RmpMenu.openContainerClass       = 'rmp-menu-open';
			RmpMenu.activeSubMenuArrowClass  = 'rmp-menu-subarrow-active';
			RmpMenu.subMenuClass             = '.rmp-submenu';

			this.options = options;
			this.menuId  = this.options['menu_id'];
			this.trigger = '#rmp_menu_trigger-' + this.menuId;

			this.isOpen  = false;

			this.container    =  '#rmp-container-' + this.menuId;
			this.headerBar    =  '#rmp-header-bar-' + this.menuId;
			this.menuWrap     =  'ul#rmp-menu-'+ this.menuId;
			this.subMenuArrow = '.rmp-menu-subarrow';
			this.wrapper      = '.rmp-container';
			this.linkElement  = '.rmp-menu-item-link';
			this.pageWrapper  = this.options['page_wrapper'];
			this.use_desktop_menu = this.options['use_desktop_menu'];
			this.originalHeight = '',
			this.animationSpeed        =  this.options['animation_speed'] * 1000;
			this.hamburgerBreakpoint   =  this.options['tablet_breakpoint'];
			this.subMenuTransitionTime =  this.options['sub_menu_speed'] * 1000;

			if ( this.options['button_click_trigger'].length > 0 ) {
				this.trigger = this.trigger +' , '+ this.options['button_click_trigger'];
			}

			//Append hamburger icon inside an element
			if ( this.options['button_position_type'] == 'inside-element' ) {
				var destination = jQuery(this.trigger).attr('data-destination');
				jQuery(this.trigger).appendTo(jQuery(destination).parent());
			}

			this.init();
		}

		/**
		 * This function register the events and initiate the menu settings.
		 */
		init() {
			const self = this;

			/**
			 * Register click event of trigger.
			 * @fires click
			 */
			jQuery( this.trigger ).on( 'click', function( e ) {
				e.stopPropagation();
				self.triggerMenu();
			} );

			// Show/Hide sub menu item when click on item toggle.
			jQuery( self.menuWrap ).find( self.subMenuArrow ).on( 'click', function( e ) {
				e.preventDefault();
				e.stopPropagation();
				self.triggerSubArrow( this );
			});

			if ( 'on' == self.options['menu_close_on_body_click'] ) {
				jQuery( document ).on( 'click', 'body', function ( e ) {
					if ( jQuery( window ).width() < self.hamburgerBreakpoint ) {
						if ( self.isOpen ) {
							if ( jQuery( e.target ).closest( self.container ).length || jQuery( e.target ).closest( self.target ).length ) {
								return;
							}
						}
						self.closeMenu();
					}
				});
			}

			/**
			 * Close the menu when click on menu item link before load.
			 */
			if ( self.options['menu_close_on_link_click'] == 'on') {

				jQuery( self.linkElement ).on( 'click', function(e) {

					if( jQuery(window).width() < self.hamburgerBreakpoint ) {
						e.preventDefault();

						// When close menu on parent clicks is on.
						if ( self.options['menu_item_click_to_trigger_submenu'] == 'on' ) {
							if( jQuery(this).is( '.rmp-menu-item-has-children > ' + self.linkElement ) ) {
								return;
							}
						}

						let _href = jQuery(this).attr('href');
						let _target = ( typeof jQuery(this).attr('target') ) == 'undefined' ? '_self' : jQuery(this).attr('target');

						if( self.isOpen ) {
							if( jQuery(e.target).closest(this.subMenuArrow).length) {
								return;
							}
							if( typeof _href != 'undefined' ) {
								self.closeMenu();
								setTimeout(function() {
									window.open( _href, _target);
								}, self.animationSpeed);
							}
						}
					}
				});
			}

			// Expand Sub items on Parent Item Click.
			if ( 'on' == self.options['menu_item_click_to_trigger_submenu']  ) {
				jQuery( '.rmp-menu-item-has-children > ' + self.linkElement ).on( 'click', function(e) {
					if ( jQuery(window).width() < self.hamburgerBreakpoint ) {
						e.preventDefault();
						self.triggerSubArrow(
							jQuery(this).children( '.rmp-menu-subarrow' ).first()
						);
					}
				});
			}
		}
		/**
		 * Set push translate for toggle and page wrapper.
		 */
		setWrapperTranslate() {
			let translate,translateContainer;
			switch( this.options['menu_appear_from'] ) {
				case 'left':
					translate = 'translateX(' + this.menuWidth() + 'px)';
					translateContainer = 'translateX(-' + this.menuWidth() + 'px)';
					break;
				case 'right':
					translate = 'translateX(-' + this.menuWidth() + 'px)';
					translateContainer = 'translateX(' + this.menuWidth() + 'px)';
					break;
				case 'top':
					translate = 'translateY(' + this.wrapperHeight() + 'px)';
					translateContainer = 'translateY(-' + this.menuHeight() + 'px)';
					break;
				case 'bottom':
					translate = 'translateY(-' + this.menuHeight() + 'px)';
					translateContainer = 'translateY(' + this.menuHeight() + 'px)';
					break;
			}

			if ( this.options['animation_type'] == 'push' ) {
				jQuery(this.pageWrapper).css( { 'transform':translate } );

				//If push Wrapper has body element then handle menu position.
				if	( 'body' == this.pageWrapper ) {
					jQuery( this.container ).css( { 'transform' : translateContainer } );
				}

			}

			if ( this.options['button_push_with_animation'] == 'on' ) {
				jQuery( this.trigger ).css( { 'transform' : translate } );
			}

		}

		/**
		 * Clear push translate on button and page wrapper.
		 */
		clearWrapperTranslate() {

			if ( this.options['animation_type'] == 'push' ) {
				jQuery(this.pageWrapper).css( { 'transform' : '' } );
			}

			if ( this.options['button_push_with_animation'] == 'on' ) {
				jQuery( this.trigger ).css( { 'transform' : '' } );
			}
		}

		/**
		 * Function to fadeIn the hamburger menu container.
		 */
		fadeMenuIn() {
			jQuery(this.container).fadeIn(this.animationSpeed);
		}

		/**
		 * Function to fadeOut the hamburger menu container.
		 */
		fadeMenuOut() {
			jQuery(this.container)
				.fadeOut(this.animationSpeed, function() {
					jQuery(this).css('display', '');
				});
		}

		/**
		 * Function is use to open the hamburger menu.
		 *
		 * @since 4.0.0
		 */
		openMenu() {
			var self = this;
			jQuery(this.trigger).addClass(RmpMenu.activeToggleClass);
			jQuery(this.container).addClass(RmpMenu.openContainerClass);

			//this.pushMenuTrigger();

			if ( this.options['animation_type'] == 'fade'){
				this.fadeMenuIn();
			} else {
				this.setWrapperTranslate();
			}

			this.isOpen = true;
		}

		/**
		 * Function is use to close the hamburger menu.
		 *
		 * @since 4.0.0
		 */
		closeMenu() {
			jQuery(this.trigger).removeClass(RmpMenu.activeToggleClass);
			jQuery(this.container).removeClass(RmpMenu.openContainerClass);

			if ( this.options['animation_type'] == 'fade') {
				this.fadeMenuOut();
			} else {
				this.clearWrapperTranslate();
			}

			this.isOpen = false;
		}

		/**
		 * Function is responsible for checking the menu is open or close.
		 *
		 * @since 4.0.0
		 * @param {Event} e
		 */
		triggerMenu() {
			this.isOpen ? this.closeMenu() : this.openMenu();
		}

		triggerSubArrow( subArrow ) {
			var self = this;
			var sub_menu = jQuery( subArrow ).parent().siblings( RmpMenu.subMenuClass );

			//Accordion animation.
			if ( self.options['accordion_animation'] == 'on' ) {
				// Get Top Most Parent and the siblings.
				var top_siblings   = sub_menu.parents('.rmp-menu-item-has-children').last().siblings('.rmp-menu-item-has-children');
				var first_siblings = sub_menu.parents('.rmp-menu-item-has-children').first().siblings('.rmp-menu-item-has-children');

				// Close up just the top level parents to key the rest as it was.
				top_siblings.children('.rmp-submenu').slideUp(self.subMenuTransitionTime, 'linear').removeClass('rmp-submenu-open');

				// Set each parent arrow to inactive.
				top_siblings.each(function() {
					jQuery(this).find(self.subMenuArrow).first().html(self.options['inactive_toggle_contents']);
					jQuery(this).find(self.subMenuArrow).first().removeClass(RmpMenu.activeSubMenuArrowClass);
				});

				// Now Repeat for the current item siblings.
				first_siblings.children('.rmp-submenu').slideUp(self.subMenuTransitionTime, 'linear').removeClass('rmp-submenu-open');
				first_siblings.each(function() {
					jQuery(this).find(self.subMenuArrow).first().html(self.options['inactive_toggle_contents']);
					jQuery(this).find(self.subMenuArrow).first().removeClass(RmpMenu.activeSubMenuArrowClass);
				});
			}

			// Active sub menu as default behavior.
			if( sub_menu.hasClass('rmp-submenu-open') ) {
				sub_menu.slideUp(self.subMenuTransitionTime, 'linear',function() {
					jQuery(this).css( 'display', '' );
				} ).removeClass('rmp-submenu-open');
				jQuery( subArrow ).html( self.options['inactive_toggle_contents'] );
				jQuery( subArrow ).removeClass(RmpMenu.activeSubMenuArrowClass);
			} else {
				sub_menu.slideDown(self.subMenuTransitionTime, 'linear').addClass( 'rmp-submenu-open' );
				jQuery( subArrow ).html(self.options['active_toggle_contents'] );
				jQuery( subArrow ).addClass(RmpMenu.activeSubMenuArrowClass);
			}

		}

		/**
		 * Function to add tranform style on trigger.
		 *
		 * @version 4.0.0
		 *
		 * @param {Event} e Event object.
		 */
		pushMenuTrigger( e ) {
			if ( 'on' == this.options['button_push_with_animation'] ) {
				jQuery( this.trigger ).css( { 'transform' : this.menuWidth() } );
			}
		}

		/**
		 * Returns the height of container.
		 *
		 * @version 4.0.0
		 *
		 * @return Number
		 */
		menuHeight() {
			return jQuery( this.container ).height();
		}

		/**
		 * Returns the width of the container.
		 *
		 * @version 4.0.0
		 *
		 * @return Number
		 */
		menuWidth() {
			return jQuery( this.container ).width();
		}

		wrapperHeight() {
			return jQuery( this.wrapper ).height();
		}

		backUpSlide( backButton ) {
			let translateTo = parseInt( jQuery( this.menuWrap )[0].style.transform.replace( /^\D+/g, '' ) ) - 100;
			jQuery( this.menuWrap ).css( { 'transform': 'translateX(-' + translateTo + '%)' } );
			let previousSubmenuHeight = jQuery( backButton ).parent( 'ul' ).parent( 'li' ).parent( '.rmp-submenu' ).height();
			if ( ! previousSubmenuHeight ) {
				jQuery( this.menuWrap ).css( { 'height': this.originalHeight } );
			} else {
				jQuery( this.menuWrap + this.menuId ).css( { 'height': previousSubmenuHeight + 'px' } );
			}
		}
	}

	/**
	 * Create multiple instance of menu and pass the options.
	 *
	 * @version 4.0.0
	 */
	for ( let index = 0; index < rmp_menu.menu.length; index++ ) {
		let rmp = new RmpMenu( rmp_menu.menu[index] );
	}

} );
// source --> https://vizulab.com.au/wp-content/plugins/sticky-menu-or-anything-on-scroll/assets/js/jq-sticky-anything.min.js?ver=2.1.1 
/**
* @preserve Sticky Anything 2.22 | @senff | GPL2 Licensed
*/

var stickyAnythingBreakpoint = '' // solely to use as a debugging breakpoint, if needed.

!function(e){function t(t,i){e(".sticky-element-original").clone().insertAfter(e(".sticky-element-original")).addClass("sticky-element-cloned").removeClass("element-is-not-sticky").addClass("element-is-sticky").css("position","fixed").css("top",t+"px").css("margin-left","0").css("z-index",i).removeClass("sticky-element-original").hide()}e.fn.stickThis=function(i){var n,s=e.extend({top:0,minscreenwidth:0,maxscreenwidth:99999,zindex:1,legacymode:!1,dynamicmode:!1,debugmode:!1,pushup:"",adminbar:!1},i),l=e(this).length,r=e(s.pushup).length;return r<1?(1==s.debugmode&&s.pushup&&console.error('STICKY ANYTHING DEBUG: There are no elements with the selector/class/ID you selected for the Push-up element ("'+s.pushup+'").'),s.pushup=""):r>1&&(1==s.debugmode&&console.error("STICKY ANYTHING DEBUG: There are "+r+' elements on the page with the selector/class/ID you selected for the push-up element ("'+s.pushup+'"). You can select only ONE element to push the sticky element up.'),s.pushup=""),l<1?1==s.debugmode&&console.error('STICKY ANYTHING DEBUG: There are no elements with the selector/class/ID you selected for the sticky element ("'+this.selector+'").'):l>1?1==s.debugmode&&console.error("STICKY ANYTHING DEBUG: There There are "+r+' elements with the selector/class/ID you selected for the sticky element ("'+this.selector+'"). You can only make ONE element sticky.'):1==s.legacymode?(e(this).addClass("sticky-element-original").addClass("element-is-not-sticky"),1!=s.dynamicmode&&t(s.top,s.zindex,s.adminbar),checkElement=setInterval(function(){!function(i,n,s,l,o,r,d){var a=e(".sticky-element-original").offset();if(orgElementTop=a.top,o){var c=e(o).offset();pushElementTop=c.top}var m=window,g="inner";"innerWidth"in window||(g="client",m=document.documentElement||document.body);viewport=m[g+"Width"],d&&e("body").hasClass("admin-bar")&&viewport>600?adminBarHeight=e("#wpadminbar").height():adminBarHeight=0;e(window).scrollTop()>=orgElementTop-i-adminBarHeight&&viewport>=n&&viewport<=s?(orgElement=e(".sticky-element-original"),coordsOrgElement=orgElement.offset(),leftOrgElement=coordsOrgElement.left,widthOrgElement=orgElement[0].getBoundingClientRect().width,widthOrgElement||(widthOrgElement=orgElement.css("width")),heightOrgElement=orgElement.outerHeight(),paddingOrgElement=[orgElement.css("padding-top"),orgElement.css("padding-right"),orgElement.css("padding-bottom"),orgElement.css("padding-left")],paddingCloned=paddingOrgElement[0]+" "+paddingOrgElement[1]+" "+paddingOrgElement[2]+" "+paddingOrgElement[3],1==r&&e(".sticky-element-cloned").length<1&&t(i,l),elementHeight=0,heightOrgElement<1?elementHeight=e(".sticky-element-cloned").outerHeight():elementHeight=e(".sticky-element-original").outerHeight(),o&&e(window).scrollTop()>pushElementTop-i-elementHeight-adminBarHeight?stickyTopMargin=pushElementTop-i-elementHeight-e(window).scrollTop():stickyTopMargin=adminBarHeight,e(".sticky-element-cloned").css("left",leftOrgElement+"px").css("top",i+"px").css("width",widthOrgElement).css("margin-top",stickyTopMargin).css("padding",paddingCloned).show(),e(".sticky-element-original").css("visibility","hidden")):(1==r?e(".sticky-element-cloned").remove():e(".sticky-element-cloned").hide(),e(".sticky-element-original").css("visibility","visible"))}(s.top,s.minscreenwidth,s.maxscreenwidth,s.zindex,s.pushup,s.dynamicmode,s.adminbar)},10)):(e(this).addClass("sticky-element-original").addClass("element-is-not-sticky"),orgAssignedStyles=(n=e(this),o={},o.display=n.css("display"),o.float=n.css("float"),o.flex=n.css("flex"),o["box-sizing"]=n.css("box-sizing"),o.clear=n.css("clear"),o.overflow=n.css("overflow"),o.transform=n.css("transform"),o),orgInlineStyles=e(".sticky-element-original").attr("style"),null==orgInlineStyles&&(orgInlineStyles=""),e(".sticky-element-original").addClass("sticky-element-active").before('<div class="sticky-element-placeholder" style="width:0; height:0; margin:0; padding:0; visibility:hidden;"></div>'),checkElement=setInterval(function(){!function(t,i,n,s,l,o,r,d){$listenerElement=e(".sticky-element-active");var a=$listenerElement.offset();if(orgElementTop=a.top,l){var c=e(l).offset();pushElementTop=c.top}var m=window,g="inner";"innerWidth"in window||(g="client",m=document.documentElement||document.body);viewport=m[g+"Width"],o&&e("body").hasClass("admin-bar")&&viewport>600?adminBarHeight=e("#wpadminbar").height():adminBarHeight=0;if(e(window).scrollTop()>=orgElementTop-t-adminBarHeight&&viewport>=i&&viewport<=n){for(var h in coordsOrgElement=$listenerElement.offset(),leftOrgElement=coordsOrgElement.left,widthPlaceholder=$listenerElement[0].getBoundingClientRect().width,widthPlaceholder||(widthPlaceholder=$listenerElement.css("width")),heightPlaceholder=$listenerElement[0].getBoundingClientRect().height,heightPlaceholder||(heightPlaceholder=$listenerElement.css("height")),widthSticky=e(".sticky-element-original").css("width"),"0px"==widthSticky&&(widthSticky=e(".sticky-element-original")[0].getBoundingClientRect().width),heightSticky=e(".sticky-element-original").height(),paddingOrgElement=[e(".sticky-element-original").css("padding-top"),e(".sticky-element-original").css("padding-right"),e(".sticky-element-original").css("padding-bottom"),e(".sticky-element-original").css("padding-left")],paddingSticky=paddingOrgElement[0]+" "+paddingOrgElement[1]+" "+paddingOrgElement[2]+" "+paddingOrgElement[3],marginOrgElement=[$listenerElement.css("margin-top"),$listenerElement.css("margin-right"),$listenerElement.css("margin-bottom"),$listenerElement.css("margin-left")],marginPlaceholder=marginOrgElement[0]+" "+marginOrgElement[1]+" "+marginOrgElement[2]+" "+marginOrgElement[3],assignedStyles="",r)"inline"==r[h]?assignedStyles+=h+":inline-block; ":assignedStyles+=h+":"+r[h]+"; ";elementHeight=0,heightPlaceholder<1?elementHeight=e(".sticky-element-cloned").outerHeight():elementHeight=e(".sticky-element-original").outerHeight(),l&&e(window).scrollTop()>pushElementTop-t-elementHeight-adminBarHeight?stickyTopMargin=pushElementTop-t-elementHeight-e(window).scrollTop():stickyTopMargin=adminBarHeight,assignedStyles+="width:"+widthPlaceholder+"px; height:"+heightPlaceholder+"px; margin:"+marginPlaceholder+";",e(".sticky-element-original").removeClass("sticky-element-active").removeClass("element-is-not-sticky").addClass("element-is-sticky").css("cssText","margin-top: "+stickyTopMargin+"px !important; margin-left: 0 !important").css("position","fixed").css("left",leftOrgElement+"px").css("top",t+"px").css("width",widthSticky).css("padding",paddingSticky).css("z-index",s),e(".sticky-element-original").each(function(){this.style.setProperty("margin-top",stickyTopMargin,"important")}),e(".sticky-element-placeholder").hasClass("sticky-element-active")||e(".sticky-element-placeholder").addClass("sticky-element-active").attr("style",assignedStyles)}else e(".sticky-element-original").addClass("sticky-element-active").removeClass("element-is-sticky").addClass("element-is-not-sticky").attr("style",d),e(".sticky-element-placeholder").hasClass("sticky-element-active")&&e(".sticky-element-placeholder").removeClass("sticky-element-active").removeAttr("style").css("width","0").css("height","0").css("margin","0").css("padding","0")}(s.top,s.minscreenwidth,s.maxscreenwidth,s.zindex,s.pushup,s.adminbar,orgAssignedStyles,orgInlineStyles)},10)),this}}(jQuery);