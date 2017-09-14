define([
		"jquery"
	],
	function($) {
		"use strict";
		
		$(document).ready(function($){
			$('.video-block').append('<span class="video-trigger"></span>')
			$('.video-trigger').click(function () {
				var $videoBlock = $(this).parent();
				$videoBlock.append('<iframe width="560" height="315" src="https://www.youtube.com/embed/' +
					$videoBlock.attr('data-video-id') + '?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>');
			});

			if ($('body').hasClass('customer-account-create')) {
				$('#password').blur(function() {
					$('#password-confirmation').val($('#password').val());
				});
			}
		});
		
		return;
	}
);