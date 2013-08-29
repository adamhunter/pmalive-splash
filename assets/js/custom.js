/*-----------------------------------------------------------------------------------*/
/*	Document ready stuff
/*-----------------------------------------------------------------------------------*/

$(document).ready(function() {

	$('#mode').children('#' + $('#mode').data('mode')).show();

	/* Handle progress animation */
	var progress = $('.progress').data('progress');
	$('.progress').delay(500).animate({
		width: progress
	}, 2000, 'easeInOutQuart', function() {
		$(this).children('span').text(progress).fadeIn('fast');
	});

	/*	Parse date from a string.
	/*	Add zeros if some elements were not specified
	/*-----------------------------------------------------------------------------------*/
	function parseDate(input) {
		var parts = input.match(/(\d+)/g);

		if (parts.length < 6) {
			var l = 6-parts.length;
			var i = 0;
			while (i <= l) {
				console.log(i);
				parts.push('0');
				i++;
			}
		}
		return new Date(parts[0], parts[1]-1, parts[2], parts[3], parts[4], parts[5]);
	}

	/* jQuery countdown init */
	$('#countdown').countdown({
		layout:	'<div class="span3 counter-block"><span id="days-num">{dn}</span><h4 id="days-desc">{dl}</h4></div>' +
				'<div class="span3 counter-block"><span id="hours-num">{hn}</span><h4 id="hours-desc">{hl}</h4></div>' +
				'<div class="span3 counter-block"><span id="min-num">{mn}</span><h4 id="min-desc">{ml}</h4></div>' +
				'<div class="span3 counter-block"><span id="sec-num">{sn}</span><h4 id="sec-desc">{sl}</h4></div>',
		until: parseDate($('#countdown').data('date'))
	});
});

// $('#subscribe').submit(function() {
// 	$.ajax({
// 		url: 'inc/newsletter.php',
// 		data: 'ajax=true&email=' + escape($('#subscribe-email').val()),
// 		success: function(data) {
// 			var data = jQuery.parseJSON(data);
// 			if (data.success == 1) {
// 				alertMessage(data.message, 'success');
// 				$('#subscribe-submit').addClass('btn-green').val($('#subscribe-submit').data('done'));
// 			}
// 			else {
// 				alertMessage(data.message, 'error');
// 			}
// 		}
// 	});
// 	return false;
// });

function alertMessage(message, type) {
	$bar = $('#alertbar');
	if ($bar.length) {
		$bar.animate({
			top: '-45px'
		}, 150, 'easeOutQuad', function() {
			$bar.removeAttr('class').addClass(type).find('.message').html(message);
			$bar.animate({
				top: 0
			}, 500, 'easeOutBounce')
		});
	}
	else {
		$('body').prepend('<div id="alertbar" class="' + type + '"><span class="message">' + message + '</span><span class="close">&times;</span></div>');
		$('#alertbar').show().animate({
			top: 0
		}, 500, 'easeOutBounce');
	}
}

$('body').on('click', '.close', function() {
	$(this).closest('#alertbar').animate({
		top: '-45px'
	}, 500, 'easeOutExpo', function() {
		$(this).remove();
	});
});

jQuery(function($) {
  $window = $(window);
  $window.on('scroll', function(event) {
    $wrap2 = $('#wrap2');

    offset = 110;
    if ($window.scrollTop() > offset) {
      topPx = offset - $window.scrollTop();
      $wrap2.css('background-position', 'right ' + topPx + 'px');
    } else {
      $wrap2.css('background-position', 'right 0px');
    }
  })
});

