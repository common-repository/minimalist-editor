jQuery(document).ready(function($){

	if (options.darkmode_0 !== undefined) {
		darkmode = true;
		$("body").addClass("minimalist-editor-darkmode");
	} else {
		darkmode = false;
		$("body").addClass("minimalist-editor-no-darkmode");
	}

	$(document).keyup(function(e){
		if (e.which === 27) {
			$("body").removeClass("focus-on");
		}
	})

	// select the the body as a target to listen for changes (in order to trigger the darkmode within the Tiny MCE iframe)
	var target = document.querySelector('body');

	// create an mutation observer instance
	var observer = new MutationObserver(function(mutations) {
	  mutations.forEach(function(mutation) { // every time a change happens to the body element, trigger darkmode
	      if ($('body').hasClass("focus-on")) {
	      	trigger_darkmode();
	      } else {
	      	remove_darkmode();
	      }
	  });
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };

	// pass in the target node, as well as the observer options
	observer.observe(target, config);


	// on window load, pass the sans-serif option to the iframe editor body
	$(window).load(function() {
		if (options.sans_serif_2 !== undefined) {
			sans_serif = true;
			$("#content_ifr").contents().find("body").addClass("minimalist-editor-sans-serif");
		} else {
			sans_serif = false;
		}
	});	

}); 
// ————— Document ready end ————— //


// scroll document function
function scroll_text() {
	if ($("body").hasClass("focus-on")) { // if the Distraction Free Writing mode is on
		$("body").stop(true, false); // cancel any running animation 
		$("html, body").stop(true, false).animate({ // and animate to the new position
    		scrollTop: $("#wp-content-wrap").offset().top + $("#wp-content-wrap").outerHeight(true) - $(window).innerHeight() * 0.55
		}, 1000); // scroll for one second
	}
}

function trigger_darkmode() {
	if (darkmode) {
		// add darkmode class from Tiny MCE editor body
		$("#content_ifr").contents().find('body').addClass("minimalist-editor-darkmode-on");
	}
}

function remove_darkmode() {
	if (darkmode) {
		// remove darkmode class from Tiny MCE editor body
		$("#content_ifr").contents().find('body').removeClass("minimalist-editor-darkmode-on");
	}
}
