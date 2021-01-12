/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */

/* eslint-disable camelcase */

(function ($) {
  'use strict'

  $(document).ajaxSend(function() {
    $("#overlay").fadeIn(300);　
  });

  $(document).ready(function() {

  
    $('[data-toggle="collapse"]').click(function() {
      $(this).toggleClass( "active" );
      if ($(this).hasClass("active")) {
        $(this).text("Hide");
      } else {
        $(this).text("Show");
      }
    });

    $('.select2').select2();
      
      
    // document ready  
    });
    

})(jQuery)
