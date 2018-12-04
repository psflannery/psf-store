/* globals wc_cart_fragments_params, jQuery */

( function ( $ ) {
	// Definitiions
	var breakpoints = {
		screen_xl: 1200,
		screen_lg: 992,
		screen_md: 768,
		screen_sm: 576,
		screen_xs: 480,
	},
	isSidebarOpen = false;

	
	/**
	 * Utilities
	 * --------------------------------------------------
	 */
	
	// Calculate if screen size is smaller/larger than default breakpoint
	function screenLessThan( breakpoint ) {
		var windowWidth = $(window).width();

		return ( parseInt( windowWidth ) <= parseInt( breakpoint ) );
	}

	// Toogle scroll
	function stopScroll( bool, el ) {
		if ( bool ) {
			el.addClass('stop-scrolling');
		} else {
			el.removeClass('stop-scrolling');
		}
	}

	// Event throttling
	// from http://www.sberry.me/articles/javascript-event-throttling-debouncing
	function throttle( fn, delay ) {
		var allowSample = true;

		return function(e) {
			if ( allowSample ) {
				allowSample = false;

				setTimeout(function() { 
					allowSample = true; 
				}, delay);

				fn(e);
			}
		};
	}

	/**
	 * Components
	 * --------------------------------------------------
	 */

	// Increment Number Inputs
	var numInputBtn = (function() {
		'use strict';

		var DOM = {};

		// =================== private methods =================
		function cacheDom() {
			DOM.$body = $('body');
		}

		function bindEvents() {
			DOM.$body.on('click', '[data-quantity="plus"]', function( e ) {
				doIncrement( e, this );
				inputChanged();
			});

			DOM.$body.on('click', '[data-quantity="minus"]', function( e ) {
				doDecrement( e, this );
				inputChanged();
			});
		}

		function doIncrement( e, target ) {
			e.preventDefault();

			var fieldName = $(target).attr('data-field'),
				$input = $('#' + fieldName),
				currentVal = parseInt( $input.val() );

			if ( !isNaN(currentVal) ) {
				$input.val(currentVal + 1);
			} else {
				$input.val(0);
			}

		}

		function doDecrement( e, target ) {
			e.preventDefault();

			var fieldName = $(target).attr('data-field'),
				$input = $('#' + fieldName),
				currentVal = parseInt( $input.val() );

			if ( !isNaN(currentVal) && currentVal > 0 ) {
				$input.val(currentVal - 1);
			} else {
				$input.val(0);
			}
		}

		function inputChanged() {
			var $btn = $( '.woocommerce-cart-form :input[name="update_cart"]' );

			if( $btn.length ) {
				$btn.prop( 'disabled', false );
			}
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Offcanvas
	var offcanvas = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			ACTIVE:       'active',
			IN:           'in',
			IS_ANIMATING: 'is-animating',
			OFF_CANVAS:   '[data-toggle="offcanvas"]',
		};

		// =================== private methods =================
		function cacheDom() {
			DOM.$window = $(window);
			DOM.$body = $('body');
			DOM.$trigger = $('[data-toggle="offcanvas"]');
		}

		function bindEvents() {
			DOM.$body.on('click', ClassName.OFF_CANVAS, function(e) {
				e.preventDefault();

				var $this = $(this),
					$target = $($this.attr('data-target'));

				// now toggle the offcanvas menu
				isSidebarOpen = !isSidebarOpen;
				doToggle($target);
			});

			// on window resize
			DOM.$window.on('resize', throttle(function() {
				doResize(DOM.$trigger.attr('data-target'));
			}, 200));
		}

		function doToggle ( $target ) {
			var $overlay = $('#overlay');

			$target.addClass(ClassName.IS_ANIMATING);

			if ( isSidebarOpen ) {
				stopScroll( true, DOM.$body );
				DOM.$trigger.addClass(ClassName.ACTIVE).attr('aria-expanded', 'true');
				$target.addClass(ClassName.IN);

				if( $overlay.length ){
					return;
				}

				//DOM.$body.append('<div id="overlay" class="offcanvas-overlay fixed-fs offcanvas--overlay" data-toggle="offcanvas" data-target="' + DOM.$trigger.attr('data-target') + '"></div>');
			} else {
				stopScroll( false, DOM.$body );
				DOM.$trigger.removeClass(ClassName.ACTIVE).attr('aria-expanded', 'false');
				$target.removeClass(ClassName.IN);
				//$overlay.remove();
			}

			// remove animation class
			doTransitionEnd($target);
		}

		function doTransitionEnd ( target ) {
			target.on('transitionend', function() {
				$(this).removeClass(ClassName.IS_ANIMATING);
			});
		}

		function doResize( target ) {
			var $target = $(target);

			if ( ! screenLessThan( breakpoints.screen_sm ) ) {
				isSidebarOpen = false;
				doToggle($target);
			}
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Mobile accordion menu
	var accordionMenu = (function() {
		'use strict';

		var DOM = {};

		// =================== private methods =================
		function cacheDom() {
			DOM.$window = $(window);
			DOM.$heading = $('#primary-menu .menu-item-has-children > a');
			DOM.$content = $('#primary-menu .menu-item-has-children > ul');
		}

		function bindEvents() {
			// note: bootstrap api already prevents default on <a> elements
			DOM.$window.on('resize', throttle(function() {
				doWindowResize();
			}, 200));
		}

		function doWindowResize() {
			if( screenLessThan( breakpoints.screen_md ) ) {
				if( $('.foo').length ) {
					return;
				}

				setElementAttributes();
			} else {
				removeElementAttributes();
			}
		}

		function setElementAttributes() {
			DOM.$heading.each(function( i, el ) {
				var $el = $(el);

				$el.attr({
					'id': 'nav-heading-' + i,
					'data-toggle': 'collapse',
					'data-target': '#nav-collapse-' + i,
					'aria-expanded': 'false',
					'aria-controls': 'nav-collapse-' + i
				});
			});

			DOM.$content.each(function( i, el ) {
				var $el = $(el),
					$link = $el.prev(DOM.$heading);
		
				$el.attr({
					'id': 'nav-collapse-' + i,
					'aria-labelledby': 'nav-heading-' + i,
					'data-parent': '#primary-menu'
				}).addClass('collapse');

				insertListItems( $link, $el );
			});
		}

		function removeElementAttributes() {
			DOM.$heading.each(function( i, el ) {
				var $el = $(el);

				$el.removeAttr('data-toggle data-target aria-expanded aria-controls');
			});

			DOM.$content.each(function( i, el ) {
				var $el = $(el);

				$el.removeAttr('aria-labelledby data-parent').removeClass('collapse');

				$('.foo').remove();
			});
		}

		function insertListItems( $link, $el ) {
			var $text = 'View All',
				$viewAll = $('<li class="foo nav-item"><a href="' + $link.attr('href') +  '" class="nav-link">' + $text + '</a></li>');

			$el.prepend($viewAll);
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();

			if( screenLessThan( breakpoints.screen_md ) ) {
				setElementAttributes();
			}
		}

		// =============== export public methods ===============
		return {
			init: init,
		};

	}());

	// Submenu cover
	// 
	// Seems this is impossible to do in CSS alone, or if it is, it's defeating me.
	// In the meantime, this hack.
	var subMenus = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			IN: 'in',
		};

		// =================== private methods =================
		function cacheDom() {
			DOM.$subMenu = $('.menu-item-has-children');
			DOM.$menu = $('.navigation-menu > .menu-item');
			DOM.$menuMask = $('.menu-mask');
			DOM.$overlay = $('.site-content-overlay');
		}

		function bindEvents() {
			if( screenLessThan( breakpoints.screen_md ) ) {
				DOM.$subMenu.off('mouseenter');
				DOM.$menu.off('mouseleave');
			} else {
				DOM.$subMenu.on('mouseenter', function() {
					var $sub = $(this).find('.sub-menu'),
						menuHeight = $sub.height() + 79; //55

					DOM.$menuMask.height( menuHeight ).addClass(ClassName.IN);
					DOM.$overlay.addClass(ClassName.IN);
				});

				DOM.$menu.on('mouseleave', function() {
					DOM.$menuMask.removeClass(ClassName.IN);
					DOM.$overlay.removeClass(ClassName.IN);
				});
			}			
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Slideshow
	// https://github.com/metafizzy/flickity/issues/115
	var slideShow = (function() {
		'use strict';

		var DOM = {};

		var isProductPage = $('body').hasClass('single-product') ? true : false;

		var flktyProductOptions = {
			cellAlign: 'left',
			contain: true,
			fullscreen: isProductPage,
			imagesLoaded: true,
			lazyLoad: 2
		};

		var flktyWrapOptions = {
			cellAlign: 'left',
			contain: true,
			pageDots: false,
			imagesLoaded: true,
			lazyLoad: 6
		};

		// =================== private methods =================
		function cacheDom() {
			DOM.$carousel = $('.carousel');
			DOM.$carouselWrap = $('.carousel-wrap');
			DOM.$cell = $('.woocommerce-product-gallery__image');
			DOM.$cellImage = $('.woocommerce-product-gallery__image img');
			DOM.$carouselGallery = $('.woocommerce-product-gallery--wrap');
		}

		function createThumbs() {
			if( DOM.$cell.length <= 1 || !isProductPage ) {
				return;
			}

			var $thumbNav = $('<div class="carousel-nav"></div>');

			DOM.$cell.each(function(i, el) {
				var $el = $(el),
					$thumbSrc = $el.data('thumb'),
					$thumb = '<img src="' + $thumbSrc + '">';

				$thumbNav.append('<div class="carousel-nav-cell">' + $thumb + '</div>');
			});
			
			$thumbNav.insertAfter(DOM.$carouselGallery);

			var $carouselNav = $('.carousel-nav'),
				$carouselNavOptions = {
					cellAlign: 'left',
					contain: true,
					asNavFor: '.woocommerce-product-gallery .carousel',
					prevNextButtons: false,
					pageDots: false,
					draggable: false,
				};

			$carouselNav.flickity($carouselNavOptions);
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			createThumbs();

			if( ! (DOM.$carousel.length || DOM.$carouselWrap.length) ) {
				return;
			}

			DOM.$carousel.flickity(flktyProductOptions);
			DOM.$carouselWrap.flickity(flktyWrapOptions);
			DOM.$cellImage.unwrap();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Add to cart
	// http://deepsoul.elartica.com/wp-content/themes/deepsoul/js/woocommerce.js?ver=4.9.8
	// http://deepsoul.elartica.com/wp-content/themes/deepsoul/js/theme.js?ver=4.9.8
	// Ajax add to cart on the product page
	var addToCart = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			UPDATING:        'updating',
			CHECKOUT_ACTIVE: 'checkout--active',
			D_NONE:          'd-none',
		};

		// =================== private methods =================
		function cacheDom(){
			DOM.$cartBtn = $('.single_add_to_cart_button');
			DOM.$checkout = $('.site-header-cart');
			DOM.$cartWidget = $('.widget_shopping_cart');
			DOM.$btnLabel = $('.add_to_cart_label');
			DOM.$btnLoader = $('.loader');
		}

		function bindEvents() {
			DOM.$cartBtn.on('click', function (e) {
				doAddToCart(e);
			});
		}

		function doAddToCart(e) {
			e.preventDefault();

			var $btn = $(e.currentTarget),
				result = $btn.parents('form').serialize() + '&' + encodeURI($btn.attr('name')) + '=' + encodeURI($btn.attr('value'));

			if( $btn.is('.wc-variation-selection-needed') ) {
				return;
			}

			$btn.attr('disabled', true).button('toggle').addClass(ClassName.UPDATING);

			toggleBtnClass( true );

			$.post($btn.attr('action'), result + '&_wp_http_referer=' + $btn.attr('action'), function (result) {
				var cart_dropdown = $('.widget_shopping_cart', result);

				// update dropdown cart
				DOM.$cartWidget.replaceWith(cart_dropdown);

				// update fragments
				$.ajax(fragmentRefresh());

				$btn.removeAttr('disabled').button('toggle').removeClass(ClassName.UPDATING);

				toggleBtnClass( false );
			});
		}

		function toggleBtnClass( bool ) {
			if ( bool ) {
				DOM.$btnLabel.toggleClass(ClassName.D_NONE);
				DOM.$btnLoader.toggleClass(ClassName.D_NONE);
			} else {
				DOM.$btnLabel.toggleClass(ClassName.D_NONE);
				DOM.$btnLoader.toggleClass(ClassName.D_NONE);
			}
		}

		function fragmentRefresh() {
			var $fragment_refresh = {
				url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
				type: 'POST',
				success: function( data ) {
					if ( data && data.fragments ) {

						$.each(data.fragments, function( key, value ) {
							$(key).replaceWith( value );
						});

						$(document.body).trigger( 'wc_fragments_refreshed' );
					}

					// Momentarily show the shopping basket
					DOM.$checkout.addClass(ClassName.CHECKOUT_ACTIVE);
					setTimeout(function(){
						DOM.$checkout.removeClass(ClassName.CHECKOUT_ACTIVE);
					}, 4000);
				}
			};

			return $fragment_refresh;
		}
		
		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};

	}());

	// Product search
	var productSearch = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			IN: 'in',
		};

		var isSearchVisible = false;

		// =================== private methods =================
		function cacheDom() {
			DOM.$trigger = $('[data-toggle="search"]');
		}

		function bindEvents() {
			DOM.$trigger.on('click', function(e) {
				e.preventDefault();

				doSearchToggle(this);
			});
		}

		function doSearchToggle(el) {
			var $el = $(el),
				$target = $($el.data('target'));

			isSearchVisible = !isSearchVisible;

			if ( isSearchVisible ) {
				$target.addClass(ClassName.IN);
				$target.find('.form-control').focus();
			} else {
				$target.removeClass(ClassName.IN);
			}
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Product Filtering
	var productFilters = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			IN: 'in',
		};

		var isOpen = false;

		// =================== private methods =================
		function cacheDom() {
			DOM.$accordionPanel = $('.filter-collapse');
			DOM.$accordionContent = $('.accordion-filter__content'); 
		}

		function bindEvents() {
			DOM.$accordionPanel.on('show.bs.collapse', function() {
				isOpen = !isOpen;

				if ( isOpen ) {
					DOM.$accordionContent.addClass(ClassName.IN);
				}
			});

			DOM.$accordionPanel.on('hide.bs.collapse', function() {
				isOpen = !isOpen;

				if ( !isOpen ) {
					DOM.$accordionContent.removeClass(ClassName.IN);
				}
			});
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Mini Cart Widget
	var miniCartWidget = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			ACTIVE: 'checkout--active',
		};

		// =================== private methods =================
		function cacheDom() {
			DOM.$body = $('body');
			DOM.$checkout = $('.site-header-cart');
			DOM.$checkoutIcon = $('.site-header-cart > li');
		}

		function bindEvents() {
			DOM.$body.on('click', '.cart-contents', function(e) {
				openCartWidget(e);
			});

			DOM.$body.on('click', '.checkout__cancel', function(e){
				closeCartWidget(e);
			});
		}

		function openCartWidget(e) {
			e.preventDefault();

			if ( DOM.$body.is('.woocommerce-cart, .woocommerce-checkout') ) {
				return;
			}

			DOM.$checkout.addClass(ClassName.ACTIVE);
			DOM.$checkoutIcon.tooltip('hide').tooltip('disable');
		}

		function closeCartWidget(e) {
			e.preventDefault();

			DOM.$checkout.removeClass(ClassName.ACTIVE);
			DOM.$checkoutIcon.tooltip('enable');
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			bindEvents();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// Sticky Add To Cart
	var stickyAddToCart = (function() {
		'use strict';

		var DOM = {};

		var ClassName = {
			IN: 'in',
		};

		// =================== private methods =================
		function cacheDom() {
			DOM.$window = $(window);
			DOM.$stickyAddToCart = $('.sticky-add-to-cart');
			DOM.$trigger = $('.entry-summary');
			DOM.$selectOptions = $('.sticky-add-to-cart .btn');
		}

		function bindEvents() {
			DOM.$window.on('scroll', throttle(function() {
				stickyAddToCartToggle();
			}, 200));
		}

		function stickyAddToCartToggle() {		
			if ( ( DOM.$trigger[0].getBoundingClientRect().top + DOM.$trigger[0].scrollHeight ) < 0 ) {
				DOM.$stickyAddToCart.addClass( ClassName.IN );
			} else if ( DOM.$stickyAddToCart.hasClass( ClassName.IN ) ) {
				DOM.$stickyAddToCart.removeClass( ClassName.IN );
			}
		}

		function getProductId() {
			var product_id = null;

			document.body.classList.forEach( function( item ){
				if ( 'postid-' === item.substring( 0, 7 ) ) {
					product_id = item.replace( /[^0-9]/g, '' );
				}
			} );

			if ( product_id ) {
				var $product = $( '#product-' + product_id );

				if ( $product ) {
					if ( $product.hasClass( 'product-type-simple' ) ) {
						DOM.$selectOptions.on('click', function(e) {
							e.preventDefault();

							$('#site-header-cart')[0].scrollIntoView();
							$('.single_add_to_cart_button').trigger('click');
						});
					}

					if ( ! $product.hasClass( 'product-type-simple' ) && ! $product.hasClass( 'product-type-external' ) ) {
						DOM.$selectOptions.on('click', function(e) {
							e.preventDefault();

							$product[0].scrollIntoView();
						} );
					}
				}
			}
		}

		// =================== public methods ==================
		function init() {
			cacheDom();
			
			if ( ! DOM.$stickyAddToCart.length ) {
				return;
			}

			stickyAddToCartToggle();
			bindEvents();
			getProductId();
		}

		// =============== export public methods ===============
		return {
			init: init,
		};
	}());

	// You Ready for this?
	$(document).ready(function() {
		offcanvas.init();
		numInputBtn.init();
		accordionMenu.init();
		subMenus.init();
		slideShow.init();
		addToCart.init();
		productSearch.init();
		productFilters.init();
		miniCartWidget.init();
		stickyAddToCart.init();

		// Init tooltips
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
	});

})( jQuery );

// https://elartica.com/2017/08/03/woocommerce-ajax-add-cart-single-product-page/
// https://stackoverflow.com/questions/25892871/woocommerce-product-page-how-to-create-ajax-on-add-to-cart-button