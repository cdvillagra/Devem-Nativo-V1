var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

if (isMobile.any()) {
  $('body').addClass('mobile-device');
}

/**************************************/
/* run this function if window resize */
/**************************************/

var widthLess1024 = function(){
  
  if ($(window).width() < 1024) {
    //make sidebar collapsed
    $('#sidebar, #navbar').addClass('collapsed');
    $('#navigation').find('.dropdown.open').removeClass('open');
    $('#navigation').find('.dropdown-menu.animated').removeClass('animated');

    //move content if navigation is collapsed
    if ($('#sidebar').hasClass('collapsed')) {
      $('#content').animate({left: "0px",paddingLeft: "55px"},150);
    } else {
      $('#content').animate({paddingLeft: "55px"},150);
    };
  }

  else {
    //make navigation not collapsed
    $('#sidebar, #navbar').removeClass('collapsed');

    //move content if navigation is not collapsed
    if ($('#sidebar').hasClass('collapsed')) {
      $('#content').animate({left: "210px",paddingLeft: "265px"},150);
    } else {
      $('#content').animate({paddingLeft: "265px"},150);

    };
  }  

};

var widthLess768 = function(){
  if ($(window).width() < 768) {     
    //paste top navbar objects to sidebar
    if($('.collapsed-content .search').length === 1) {
      $('#main-search').appendTo('.collapsed-content .search');
    }
    if($('.collapsed-content li.user').length === 0) {
      $( ".collapsed-content li.search" ).after($( "#current-user" ));
    }
  }

  else {
    //show content of top navbar
    $('#current-user').show();
    
    //remove top navbar objects from sidebar
    if($('.collapsed-content .search').length === 2) {
      $( ".nav.refresh" ).after($( "#main-search" ));
    }
    if($('.collapsed-content li.user').length === 1) {
      $( ".quick-actions >li:last-child" ).before($( "#current-user" ));
    }
  }  
}

$(function(){

	/********************/
  /* INITIALIZE eENU */
  /********************/

	$("#mmenu").mmenu({
    position: "right",
    zposition: 'next',
    moveBackground: false
  });

	/************************************************/
  /* ADD ANIMATION TO TOP MENU & SUBMENU DROPDOWN */
  /************************************************/

	$('.quick-actions .dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').addClass('animated fadeInDown');
    $(this).find('#user-inbox').addClass('animated bounceIn');
  });

  $('#navigation .dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').addClass('animated fadeInLeft');
  });

  /*********************************/
  /* INITIALIZE SIDEBAR BAR CHARTS */
  /*********************************/


  /****************************/
  /* SIDEBAR PARTS COLLAPSING */
  /****************************/

  $('#sidebar .sidebar-toggle').on('click', function(){
  	var target = $(this).data('toggle');

  	$(target).toggleClass('collapsed');
  });

  /*********************************/
	/* INITIALIZE SIDEBAR NICESCROLL */
	/*********************************/

	if (!isMobile.any()) {
    $("#sidebar").niceScroll({
      cursorcolor: '#000000',
      zindex: 999999,
      bouncescroll: true,
      cursoropacitymax: 0.4,
      cursorborder: '',
      cursorborderradius: 0,
      cursorwidth: '7px',
      railalign: 'left',
      railoffset: {top:45,left:0}
    });
  }

	/*****************************/
  /* INITIALIZE MAIN NICESCROLL*/
  /*****************************/


  if (!isMobile.any()) {

    var initContentScroll = function () {

      $("#content").niceScroll({
        cursorcolor: '#000000',
        zindex: 999999,
        bouncescroll: true,
        cursoropacitymax: 0.4,
        cursorborder: '',
        cursorborderradius: 7,
        cursorwidth: '7px',
        background: 'rgba(0,0,0,.1)',
        autohidemode: false,
        railpadding: {top: 0, right: 2, left: 2, bottom: 0}
      });
    };

    initContentScroll();

  } else {
    $('#content').css({overflow: 'auto'})
  }

  $('#mmenu').on(
    "opened.mm",
    function()
    {
    	$("#content").getNiceScroll().hide();
    }
   );

  $('#mmenu').on(
    "closed.mm",
    function()
    {
    	$("#content").getNiceScroll().show();
    }
  );

  $('.modal')
  .on('show.bs.modal', function(){
    $('body, #content').css({overflow: 'hidden'});
    $("#content").getNiceScroll().remove();
  })
  .on('hide.bs.modal', function(){
    $('body, #content').css({overflow: ''});
    initContentScroll();
  });

  /************************************/
  /* SIDEBAR MENU DROPDOWNS FUNCTIONS */
  /************************************/

  $('#navigation .dropdown.open').data('closable', false);

  $('#navigation .menu >.dropdown').on({
    "shown.bs.dropdown": function() {
      $(this).data('closable', false);
      // resize scrollbar
      $("#sidebar").getNiceScroll().resize();
    },
    "click": function(e) {

      $(this).data('closable', true);

      if (!$(this).hasClass('open')) {
        $('li.dropdown.open').removeClass('open');
      }

      if ($('#sidebar').hasClass('collapsed')) {
        // Avoid having the menu to close when clicking
        e.stopPropagation();
      }

      // resize scrollbar
      $("#sidebar").getNiceScroll().resize();

    },
    "hide.bs.dropdown": function() {
      return $(this).data('closable');
      // resize scrollbar
      $("#sidebar").getNiceScroll().resize();
    }
  });

  /*******************************/
  /* SIDEBAR COLLAPSING FUNCTION */
  /*******************************/

  $('.sidebar-collapse a').on('click', function(){
    // Add or remove class collapsed
    $('#sidebar, #navbar').toggleClass('collapsed');

    $('#navigation').find('.dropdown.open').removeClass('open');
    $('#navigation').find('.dropdown-menu.animated').removeClass('animated');
    $('#sidebar > li.collapsed').removeClass('collapsed');

    if (!isMobile.any()) {
      if ($('#sidebar').hasClass('collapsed')) {
        if ($(window).width() < 1024) {
          //if width is less than 1024px move content to left 0px
          $('#content').animate({left: "0px"},150)
        }
        else {
          //if width is not less than 1024px give padding 55px to content
          $('#content').animate({paddingLeft: "55px"},150)
        }

      } else {

        if ($(window).width() < 1024) {
          //if width is less than 1024px move content to left 210px
          $('#content').animate({left: "210px"},150)
        }
        else {
          //if width is not less than 1024px give padding 265px to content
          $('#content').animate({paddingLeft: "265px"},150)
        }
      }
    } else {
      if ($('#sidebar').hasClass('collapsed')) {
        $('#content').css({paddingLeft: "55px", display: 'block'})
      } else {
        $('#content').css({paddingLeft: "265px", display: 'none'})
      }
    }

  });

  /**************************/
  /* SIDEBAR CLASS TOGGLING */
  /**************************/

  $('#navigation .menu li').hover(function(){
    $(this).addClass('hovered');
    $("#sidebar").addClass('open');
  }, function(e){
    $(e.target).parent().removeClass('hovered');
    $(this).removeClass('hovered');
    $("#sidebar").removeClass('open');
  });

  /**************************************/
  /* run this function after page ready */
  /**************************************/

  widthLess1024();
  widthLess768();

  /***************************************/
  /* run this functions if window resize */
  /***************************************/

  $(window).resize(function() {
    widthLess1024();
    widthLess768();
  });

  /**************/
  /* ANIMATIONS */
  /**************/

  //animate numbers with class .animate-number with data-value attribute
  $(".animate-number").each(function() {
    var value = $(this).data('value');
    var duration = $(this).data('animation-duration');
   
    $(this).animateNumbers(value, true, duration, "linear");
  });
   
  //animate progress bars
  $('.animate-progress-bar').each(function(){
    var progress =  $(this).data('percentage');
   
    $(this).css('width', progress);
  })

  /**********************************/
  /* color scheme changing function */
  /**********************************/

  $('#color-schemes li a').click(function(){
    var scheme = $(this).attr('class');
    var lastClass = $('body').attr('class').split(' ').pop();

    $('body').removeClass(lastClass).addClass(scheme);
  });

  /*******************************/
  /* VIDEO BACKGROUND INITIALIZE */
  /*******************************/

  var loadVideoBg = function(){
    $('body .videocontent').prepend('<div class="video-background video-bg-1"></div>');

    $('.video-background').videobackground({
      videoSource: [['assets/videobg/1.mp4', 'video/mp4'],
        ['assets/videobg/1.webm', 'video/webm'],
        ['assets/videobg/1.ogv', 'video/ogg']],
      //poster: 'assets/images/backgrounds/video/1.jpg',
      controlPosition: '#video',
      loop: true,
      controlText: '',
      loadedCallback: function() {
        $(this).videobackground('mute');
      }
    });
  }

  var changeVideoBg = function() {
    var backgroundNumber = $('.video-background').attr('class').split(' ').pop().split('-').pop();

    $('.video-background').videobackground({
      videoSource: [['assets/videobg/' + backgroundNumber + '.mp4', 'video/mp4'],
        ['assets/videobg/' + backgroundNumber + '.webm', 'video/webm'],
        ['assets/videobg/' + backgroundNumber + '.ogv', 'video/ogg']],
      //poster: 'assets/images/backgrounds/video/' + backgroundNumber + '.jpg',
      controlPosition: '#video',
      loop: true,
      controlText: '',
      loadedCallback: function() {
        $(this).videobackground('mute');
      }
    });
  }

  $('#videobackgrounds li a').click(function(){
    var background = $(this).attr('class');

    $('#video').html('');

    $('body .videocontent').prepend('<div class="video-background"></div>');

    $('.video-background').addClass(background);

    changeVideoBg();

    $('#videobg-check').prop('checked', true);
  });

  if ($('#videobg-check').is(':checked')) { 
    loadVideoBg();
  }

  $('#videobg-check').change(function() {
    if ($(this).is(":checked")) {
      loadVideoBg();
    } else {
      $('#video').html('');
      $(this).prop('checked', false);
    }    
  });

  /*************************/
  /* page refresh function */
  /************************/

  $('.page-refresh').click(function() {
    location.reload();
  });

  /**************************/
  /* block element function */
  /**************************/

  function elBlock(el) {    
    $(el).block({
      message: '<div class="el-reloader"></div>',
      overlayCSS: {
        opacity: 0.6,
        cursor: 'wait',
        backgroundColor: '#000000'
      },
      css: {
        padding: '5px',
        border: '0',
        backgroundColor: 'transparent'
      }
    });
  };
   
  /****************************/
  /* unblock element function */
  /****************************/

  function elUnblock(el) {
    $(el).unblock();
  };

  /*************************/
  /* tile refresh function */
  /*************************/

  $('.tile-header .controls .refresh').click(function() { 
    var el = $(this).parent().parent().parent();
    elBlock(el);
    window.setTimeout(function() {
      elUnblock(el);
    }, 1000);

    return false;
  });

  /************************/
  /* tile remove function */
  /************************/

  $('.tile-header .controls .remove').click(function() {
    $(this).parent().parent().parent().addClass('animated fadeOut');
    $(this).parent().parent().parent().attr('id', 'el_remove');
     setTimeout( function(){      
      $('#el_remove').remove(); 
     },500);

     return false;
  });

  /************************/
  /* tile minimize function */
  /************************/

  $('.tile-header .controls .minimize').click(function() {
    $(this).parent().parent().parent().toggleClass('minimized');

     return false;
  });

  // This entire section makes Bootstrap Modals work with iOS
  if( navigator.userAgent.match(/iPhone|iPad|iPod/i) ) {

    $('.modal').on('show.bs.modal', function() {
      setTimeout(function () {
        scrollLocation = $(window).scrollTop();
        $('.modal')
            .addClass('modal-ios')
            .height($(window).height())
            .css({'margin-top': scrollLocation + 'px'});
      }, 0);
    });

    $('input, textarea').on('blur', function(){
      setTimeout(function() {
        // This causes iOS to refresh, fixes problems when virtual keyboard closes
        $(window).scrollLeft(0);

        var $focused = $(':focus');
        // Needed in case user clicks directly from one input to another
        if(!$focused.is('input')) {
          // Otherwise reset the scoll to the top of the modal
          $(window).scrollTop(scrollLocation);
        }
      }, 0);
    });

  }

})

/******************/
/* page preloader */
/******************/
$(window).load(function() { 
  $("#loader").delay(500).fadeOut(300); 
  $(".mask").delay(800).fadeOut(300, function(){
    widthLess1024();
    widthLess768();
  });
});