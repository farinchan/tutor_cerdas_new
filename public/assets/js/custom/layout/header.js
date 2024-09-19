"use strict";

// Class definition
var KTHeader= function () {
	// Private variables
	var navWrapper;
	var projectsCollapse;
	var header;

	var handleMenuScroll = function() {
		var menuActiveItem = navWrapper.querySelector(".menu-link.active");

		if ( !menuActiveItem ) {
			return;
		} 

		if ( KTUtil.isVisibleInContainer(menuActiveItem, navWrapper) === true) {
			return;
		}

		navWrapper.scroll({
			top: KTUtil.getRelativeTopPosition(menuActiveItem, navWrapper),
			behavior: 'smooth'
		});
	}

	var handleProjectsCollapse = function() {
		projectsCollapse.addEventListener('shown.bs.collapse', event => {
			const scrollHeight = parseInt(KTUtil.css(navWrapper, "height"));
			navWrapper.scroll({
				top: scrollHeight,
				behavior: 'smooth'
			});
		})
	}

	var handleProjectsSelection = function() {
		const selected = header.querySelector('[data-kt-element="selected"]');
		const menu = header.querySelector('[data-kt-menu="true"]');

		// Toggle Handler
		KTUtil.on(header, '[data-kt-element="project"]', 'click', function (e) {
			const logo = this.querySelector('[data-kt-element="logo"]');
			const title = this.querySelector('[data-kt-element="title"]');
			const desc = this.querySelector('[data-kt-element="desc"]');		
			const selectedLink = menu.querySelector('.menu-link.active');

			selected.querySelector('[data-kt-element="logo"]').setAttribute("src", logo.getAttribute("src"));
			selected.querySelector('[data-kt-element="title"]').innerText = title.innerText;
			selected.querySelector('[data-kt-element="desc"]').innerText = desc.innerText;

			if (selectedLink) {
				selectedLink.classList.remove('active');
			}

			this.classList.add('active');
		});
	}

	// Public methods
	return {
		init: function () {
			// Elements
			navWrapper = document.querySelector('#kt_header_navs_wrappers');
			projectsCollapse = document.querySelector('#kt_header_menu_projects_collapse');
			header = document.querySelector('#kt_header_header');
			
			if ( navWrapper ) {
				handleMenuScroll();
			}

			if ( projectsCollapse ) {
				handleProjectsCollapse();
			}

			if ( header ) {
				handleProjectsSelection();
			}
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTHeader.init();
});