(function($){
    "use strict"; // Start of use strict
    var stickyHeaderTop =0;

    if( $('#header .main-menu').length > 0){
      stickyHeaderTop = $('#header .main-menu').offset().top;
    }

    jQuery.fn.extend({
        menuCarousel : function() {
            var $this = jQuery(this);
            var $child = $this.find( '.' + $this.data( 'child' ) );
            if( $child.length == 0 ){
                $child = $this;
            }
            var config = $this.data();
            $child.owlCarousel(config);
        }
    });
     /* ---------------------------------------------
     Stick menu
     --------------------------------------------- */
     function kt_stick_menu(){

      if($('#header .main-menu').length >0){
        var h = $(window).scrollTop();
          var width = $(window).width();
          if(width > 991){
              if((h > stickyHeaderTop) ){
                  $('#header-ontop').addClass('on-sticky');
                  $('#header-ontop').find('.header').addClass('ontop');
              }else{
                  $('#header-ontop').removeClass('on-sticky');
                  $('#header-ontop').find('.header').removeClass('ontop');
              }
          }else{
              $('#header-ontop').find('.header').removeClass('ontop');
              $('#header-ontop').removeClass('on-sticky');
          }
      }
     }
    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.owl-carousel').each(function(){
          var config = $(this).data();
          var animateOut = $(this).data('animateout');
          var animateIn = $(this).data('animatein');
          if(typeof animateOut != 'undefined' ){
            config.animateOut = animateOut;
          }
          if(typeof animateIn != 'undefined' ){
            config.animateIn = animateIn;
          }
          var owl = $(this);
          owl.owlCarousel(config);
        });
    }
    /* ---------------------------------------------
     Owl carousel mobile
     --------------------------------------------- */
    function init_carousel_mobile(){
        var window_size = jQuery('body').innerWidth();
        window_size += kt_get_scrollbar_width();
        if( window_size < 768 ){
          $('.owl-carousel-mobile').each(function(){
            var config = $(this).data();
            var animateOut = $(this).data('animateout');
            var animateIn = $(this).data('animatein');
            if(typeof animateOut != 'undefined' ){
              config.animateOut = animateOut;
            }
            if(typeof animateIn != 'undefined' ){
              config.animateIn = animateIn;
            }
            var owl = $(this);
            owl.owlCarousel(config);
          });
        }
        
    }
    /* ---------------------------------------------
     MENU REPONSIIVE
     --------------------------------------------- */
     function init_menu_reposive(){
          var kt_is_mobile = (Modernizr.touch) ? true : false;
          if(kt_is_mobile === true){
            $(document).on('click', '.boutique-nav .menu-item-has-children > a', function(e){
              var licurrent = $(this).closest('li');
              var liItem = $('.boutique-nav .menu-item-has-children');
              if ( !licurrent.hasClass('show-submenu') ) {
                liItem.removeClass('show-submenu');
                licurrent.parents().each(function (){
                    if($(this).hasClass('menu-item-has-children')){
                     $(this).addClass('show-submenu');   
                    }
                      if($(this).hasClass('main-menu')){
                          return false;
                      }
                })
                licurrent.addClass('show-submenu');
                // Close all child submenu if parent submenu is closed
                if ( !licurrent.hasClass('show-submenu') ) {
                  licurrent.find('li').removeClass('show-submenu');
                  }
                  return false;
                  e.preventDefault();
              }else{
                var href = $this.attr('href');
                  if ( $.trim( href ) == '' || $.trim( href ) == '#' ) {
                      licurrent.toggleClass('show-submenu');
                  }
                  else{
                      window.location = href;
                  } 
              }
              // Close all child submenu if parent submenu is closed
                  if ( !licurrent.hasClass('show-submenu') ) {
                      //licurrent.find('li').removeClass('show-submenu');
                  }
                  e.stopPropagation();
          });
        $(document).on('click', function(e){
              var target = $( e.target );
              if ( !target.closest('.show-submenu').length || !target.closest('.boutique-nav').length ) {
                  $('.show-submenu').removeClass('show-submenu');
              }
          }); 
          // On Desktop
          }else{
            
              $(document).on('mousemove','.boutique-nav .menu-item-has-children',function(){
                  $(this).addClass('show-submenu');
              })

              $(document).on('mouseout','.boutique-nav .menu-item-has-children',function(){
                  $(this).removeClass('show-submenu');
              })
          }
     }
    /* ---------------------------------------------
     Resize mega menu
     --------------------------------------------- */
     function kt_resizeMegamenu(){
        var window_size = jQuery('body').innerWidth();
        window_size += kt_get_scrollbar_width();
        if( window_size > 767 ){
          if( $('#header .main-menu-wapper').length >0){
            var container = $('#header .main-menu-wapper');
            if( container!= 'undefined'){
              var container_width = 0;
              container_width = container.innerWidth();
              var container_offset = container.offset();
              setTimeout(function(){
                  $('.main-menu .item-megamenu').each(function(index,element){
                      $(element).children('.megamenu').css({'max-width':container_width+'px'});
                      var sub_menu_width = $(element).children('.megamenu').outerWidth();
                      var item_width = $(element).outerWidth();
                      $(element).children('.megamenu').css({'left':'-'+(sub_menu_width/2 - item_width/2)+'px'});
                      var container_left = container_offset.left;
                      var container_right = (container_left + container_width);
                      var item_left = $(element).offset().left;
                      var overflow_left = (sub_menu_width/2 > (item_left - container_left));
                      var overflow_right = ((sub_menu_width/2 + item_left) > container_right);
                      if( overflow_left ){
                        var left = (item_left - container_left);
                        $(element).children('.megamenu').css({'left':-left+'px'});
                      }
                      if( overflow_right && !overflow_left ){
                        var left = (item_left - container_left);
                        left = left - ( container_width - sub_menu_width );
                        $(element).children('.megamenu').css({'left':-left+'px'});
                      }
                  })
              },100);
            }
          }
        }
     }
     function kt_get_scrollbar_width() {
        var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),
            $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),
            inner = $inner[0],
            outer = $outer[0];
        jQuery('body').append(outer);
        var width1 = inner.offsetWidth;
        $outer.css('overflow', 'scroll');
        var width2 = outer.clientWidth;
        $outer.remove();
        return (width1 - width2);
    }
    /* ---------------------------------------------
     Height Full
     --------------------------------------------- */
    function js_height_full(){
        (function($){
            var height = $(window).outerHeight();
            $(".full-height").css("height",height);
        })(jQuery);
    }
    function js_width_full(){
        (function($){
            var width = $(window).outerWidth();
            $(".full-width").css("width",width);
        })(jQuery);
    }

    function scrollbar_header_sidebar(){
      //  Scrollbar
      if($('.sidebar-menu').length >0 ){
          $(".sidebar-menu").mCustomScrollbar();
      }
      if($('.header-categoy-menu .inner').length >0 ){
          $(".header-categoy-menu .inner").mCustomScrollbar();
      }
    }
    /* ---------------------------------------------
     POSITION SIDEBAR FOOTER
     --------------------------------------------- */
    function heightheader_categoy_menu(){
        var height2 = $('.header-categoy-menu').outerHeight(),
            height1 = (height2 -140);

        $('.header-categoy-menu .inner').css('height',height1+'px');
    }

    /* ---------------------------------------------
     POSITION SIDEBAR FOOTER
     --------------------------------------------- */
    function positionFootersidebar(){
        var height2 = $('.header.sidebar').outerHeight(),
            height1 = (height2 - 45);
        $('.header.sidebar .sidebar-menu').css('height',height1+'px');
    }

    function clone_main_menu(){
        if( $('.clone-main-menu').length > 0 && $('#box-mobile-menu').length >0){
          $( ".clone-main-menu" ).clone().appendTo( "#box-mobile-menu .box-inner" );
        }
    }

    function clone_header_ontop(){
        if( $('#header.is-sticky').length > 0 && $('#header-ontop').length >0 && $('#header-ontop').hasClass('is-sticky')){
          var content = $( "#header" ).clone();
          content.removeAttr('id');
          content.appendTo( "#header-ontop" );
        }
    }

    /* ---------------------------------------------
     Woocommerce Quantily
     --------------------------------------------- */
     function woo_quantily(){
        $('body').on('click','.quantity .quantity-plus',function(){
            var obj_qty  = $(this).closest('.quantity').find('input.qty'),
                val_qty  = parseInt(obj_qty.val()),
                min_qty  = parseInt(obj_qty.data('min')),
                max_qty  = parseInt(obj_qty.data('max')),
                step_qty = parseInt(obj_qty.data('step'));
            val_qty = val_qty + step_qty;
            if(max_qty && val_qty > max_qty){ val_qty = max_qty; }
            obj_qty.val(val_qty);
            return false;
        });

        $('body').on('click','.quantity .quantity-minus',function(){
            var obj_qty  = $(this).closest('.quantity').find('input.qty'), 
                val_qty  = parseInt(obj_qty.val()),
                min_qty  = parseInt(obj_qty.data('min')),
                max_qty  = parseInt(obj_qty.data('max')),
                step_qty = parseInt(obj_qty.data('step'));
            val_qty = val_qty - step_qty;
            if(min_qty && val_qty < min_qty){ val_qty = min_qty; }
            if(!min_qty && val_qty < 0){ val_qty = 0; }
            obj_qty.val(val_qty);
            return false;
        });
    }
    /* ---------------------------------------------
     OWL TAB EFFECT
     --------------------------------------------- */
    function kt_tab_fade_effect(){
      // effect first tab
      var sleep = 0;
      $('.kt-tabs-animate .kt-tab.vc_active a').each(function(){
        var tabElement = $(this);
        setTimeout(function() {
            tabElement.trigger('click');
        }, sleep);
        sleep += 10000
      })
      // effect click
      $(document).on('click','.kt-tabs-animate .kt-tab a',function(){
        var tab_id = $(this).attr('href');
        var tab_animated = $(this).data('animate');
        tab_animated = ( tab_animated == undefined || tab_animated =="" ) ? '' : tab_animated;
        if( tab_animated ==""){
          return  false;
        }

        $(tab_id).find('.product-list-grid > .product-item, .owl-item.active ').each(function(i){
            var t = $(this);
            var style = $(this).attr("style");
            style     = ( style == undefined ) ? '' : style;
            var delay  = i * 400;
            t.attr("style", style +
                      ";-webkit-animation-delay:" + delay + "ms;"
                    + "-moz-animation-delay:" + delay + "ms;"
                    + "-o-animation-delay:" + delay + "ms;"
                    + "animation-delay:" + delay + "ms;"
            ).addClass(tab_animated+' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                t.removeClass(tab_animated+' animated');
                t.attr("style", style);
            });
        })
      })
    }
    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    $(window).load(function() {
      // Resize Megamenu
        kt_resizeMegamenu();
        init_carousel_mobile();
        js_height_full();
        js_width_full();
        scrollbar_header_sidebar();
        positionFootersidebar();
        clone_main_menu();
        heightheader_categoy_menu();
        kt_stick_menu();
        clone_header_ontop();
        
        //Group banner
        if( $('.group-banner-masonry').length >0 ){
          $('.group-banner-masonry').isotope(
            {
              itemSelector: '.banner-masonry-item',
              percentPosition: true,
              masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-sizer'
              }
            }
          );
        }
    });
    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).on("resize", function() {
      // Resize Megamenu
        kt_resizeMegamenu();
        init_carousel_mobile();
        js_height_full();
        scrollbar_header_sidebar();
        positionFootersidebar();
        js_height_full();
        js_width_full();
        heightheader_categoy_menu();
    });
    /* ---------------------------------------------
     Scripts scroll
     --------------------------------------------- */
    $(window).scroll(function(){
      // Resize Megamenu
      kt_resizeMegamenu();
      kt_stick_menu();
      // Show hide scrolltop button
        if( $(window).scrollTop() == 0 ) {
            $('.scroll_top').stop(false,true).fadeOut(600);
        }else{
            $('.scroll_top').stop(false,true).fadeIn(600);
        }
    });
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        // OWL CAROUSEL
        init_carousel();
        //MENU REPONSIIVE
        init_menu_reposive();
        //SELECT CHOSEN
        $("select").chosen();
        // Resize Megamenu
        kt_resizeMegamenu();

        init_carousel_mobile();
        scrollbar_header_sidebar();
        positionFootersidebar();
        heightheader_categoy_menu();
        kt_stick_menu();
        woo_quantily();
        kt_tab_fade_effect();
        
        //VIDEO LIGHTBOX
        if ( $('.video-lightbox .link-lightbox').length ){
          $('.video-lightbox .link-lightbox').simpleLightboxVideo();
        }

        //
        $(document).on('click','.box-search.show-icon .icon',function(){
          $(this).closest('.box-search').find('.inner').toggle();
        })

       // MENU SIDEBAR

       $(document).on('click','#header .close-header-sidebar',function(){
          $(this).closest('#header').addClass('closed').removeClass('opened');
       })
       $(document).on('click','#header .open-header-sidebar',function(){
          $(this).closest('#header').removeClass('closed').addClass('opened');
       });

        $(document).on('click','.header-categoy-menu .close-header-sidebar',function(){
          $(this).closest('.header-categoy-menu').addClass('closed').removeClass('opened');
       })
       $(document).on('click','.header-categoy-menu .open-header-sidebar',function(){
          $(this).closest('.header-categoy-menu').removeClass('closed').addClass('opened');
       });


       //SLIDE FULL SCREEN
       var slideSection = $(".slide-fullscreen .item-slide");
        slideSection.each(function(){
            if ($(this).data("background")){
              $(this).css("background-image", "url(" + $(this).data("background") + ")");
            }
        });


        // PRODUCT DETAIL IMAGE
        $(document).on('click','.product-detail-image .thumbnails a',function(){
          var url = $(this).data('url');
          $(this).closest('.product-detail-image .thumbnails').find('a').each(function(){
            $(this).removeClass('active');
          })
          $(this).addClass('active');
          $(this).closest('.product-detail-image').find('.main-image').attr('src',url);
          return false;
        })
        //parallax
        $('.bg-parallax').each(function(){
              $(this).parallax('50%', 0.3);
        });

        // TESTANIAL STYLE 1
        $('.testimonials-owl-3').each(function(){
          var owl = $(this).find('.testimonial-owl');
          owl.owlCarousel(
            {
                margin:0,
                autoplay:true,
                dots:false,
                loop:true,
                nav:true,
                smartSpeed:1000,
                margin:15,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                responsive : {
                // breakpoint from 0 up
                0 : {
                    items : 2
                },
                // breakpoint from 480 up
                480 : {
                    items : 2
                },
                // breakpoint from 768 up
                768 : {
                    items : 3
                },
                1000 : {
                    items : 3
                }
            }
            }
          );
          owl.trigger('next.owl.carousel');
          owl.on('changed.owl.carousel', function(event) {
              owl.find('.owl-item.active').removeClass('item-center');
              var caption = owl.find('.owl-item.active').first().next().find('.inner').html();

              var t = owl.closest('.testimonials-owl-3').find('.testimonial-info');
              var animated = t.data('animated');
              t.html(caption).addClass('animated '+animated).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                       $(this).removeClass('animated '+animated);
              });;
              setTimeout(function(){
                  owl.find('.owl-item.active').first().next().addClass('item-center');
              }, 100);
          })

        });

        // BOX MOBILE MENU
        $(document).on('click','.mobile-navigation',function(){
          $('#box-mobile-menu').addClass('open');
        });
        // Close box menu
        $(document).on('click','#box-mobile-menu .close-menu',function(){
            $('#box-mobile-menu').removeClass('open');
        });
        //  Box mobile menu
        if($('#box-mobile-menu').length >0 ){
            $("#box-mobile-menu").mCustomScrollbar();
        }

        // Box Setting
        var kt_is_mobile = (Modernizr.touch) ? true : false;
        if(kt_is_mobile === true){
          $(document).on('click','.box-settings .icon',function(){
            $(this).closest('.box-settings').toggleClass('open');
          })
        }else{
           $(document).on('mousemove','.box-settings',function(){
                $(this).addClass('open');
            })

            $(document).on('mouseout','.box-settings',function(){
                $(this).removeClass('open');
            })
        }
        
        // Scroll top 
        $(document).on('click','.scroll_top',function(){
          $('body,html').animate({scrollTop:0},400);
          return false;
        });

        jQuery( '*[data-carousel="on-carousel"]' ).menuCarousel();

        // View grid list product 
        $(document).on('click','.show-grid-list .display-mode',function(){
            var mode = $(this).data('mode');
            var current_url  = window.location.href;   
            var data = {
                action: 'fronted_set_products_view_style',
                security : kt_ajax_fontend.security,
                mode: mode
            };
            $.post(kt_ajax_fontend.ajaxurl, data, function(response){
               window.location.replace(current_url);
            })
            return false;
        });
        // Custom post nav owl

        $('.owl-custom-nav-postion').each(function(){

            var margin = $(this).data('navigation_margin');
            var top = '-'+margin+'px';
            if( typeof margin != undefined && margin >=0 ){
                $(this).find('.owl-nav .owl-prev, .owl-nav .owl-next').css({'top':top});
            }
        })
    });

})(jQuery); // End of use strict