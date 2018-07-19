/**
 * lwt-Slideshow.
 * Version 0.1
 * Copyright (C) 2007 Vassilis Dourdounis.
 * http://projects.littlewebthings.com/slideshow/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

var LWTSlideShow = function() {
	this.initialize.apply(this, arguments);
}

LWTSlideShow.prototype = {
	// private
	it: 0,

	tile_width_prc: 0.05,
	tile_height_prc: 1,

	// private
	tile_width: 0,
	//private
	tile_height: 0,

	preload_next: false,
	preload_all: false,

	slideshow_element_id: 'lwt_slide_show', // DOM id

	// private
	slideshow_element: null,

	image_element_id: null,

	// private
	image_element: null,

	// private
	registered_tiles: null,

	// private
	next_image: null,

	previous_link_id: 'lwt_slideshow_previous',
	next_link_id: 'lwt_slideshow_next',

	loading_element_id: 'lwt_slideshow_loading',

	background_color: '#fff',

	image_list: [],

	transition_function: 'flip',

	image_transition: function (id) { 
		return this.transition_function + '(\'' + id + '\')'; 
	},

	tile_orchestration: function (i, j) {
		return Math.log(Math.abs(i))/Math.log(10) * 400 + j * 50;
	},
		
	initialize: function (images, options) {

		this.image_list = images;

		if (options && options['tiles_x']) {
			this.tile_width_prc = 1/options['tiles_x'];
		}
		if (options && options['tiles_y']) {
			this.tile_height_prc = 1/options['tiles_y'];
		}
		if (options && options['transition']) {
			this.transition_function = options['transition'];
		}
		if (options && options['tile_orchestration']) {
			this.tile_orchestration = options['tile_orchestration'];
		}
		if (options && options['next_link_id']) {
			this.next_link_id = options['next_link_id'];
		}
		if (options && options['previous_link_id']) {
			this.previous_link_id = options['previous_link_id'];
		}
		if (options && options['loading_element_id']) {
			this.loading_element_id = options['loading_element_id'];
		}



		this.itt = 0;

		try {
			this.slideshow_element = document.getElementById(this.slideshow_element_id);
		}
		catch (e) {
			alert('No element defined for slideshow.');
		}

		if (document.getElementById(this.next_link_id)) {
			document.getElementById(this.next_link_id).onclick = function () { return slideShow.next() };
		}

		if (document.getElementById(this.previous_link_id)) {
			document.getElementById(this.previous_link_id).onclick = function () { return slideShow.previous() };
		}

		try {
			if (this.image_element_id) {
				this.image_emelent = document.getElementById(this.image_element_id);
			}
			else {
				for (i = 0; i <this.slideshow_element.childNodes.length; i++) {
					if (this.slideshow_element.childNodes[i].tagName &&
						this.slideshow_element.childNodes[i].tagName.toUpperCase() == 'IMG') 
					{
						this.image_element = this.slideshow_element.childNodes[i];
					}
				}
			}
		}
		catch (e) {
			alert('No image found in slideshow element.');
		}

		w = this.slideshow_element.offsetWidth;
		h = this.slideshow_element.offsetHeight;

		this.slideshow_element.style.overflow = 'hidden';

		this.tile_width = w * this.tile_width_prc;
		this.tile_height = w * this.tile_height_prc;

	},

	next: function() {
		this.itt++;

		if (this.itt >= this.image_list.length) 
			this.itt = 0;

		this.changeImage(this.image_list[this.itt]);

		return false;
	},

	previous: function() {
		this.itt--;

		if (this.itt < 0) 
			this.itt = this.image_list.length-1;

		this.changeImage(this.image_list[this.itt]);

		return false;
	},

	changeImage: function (new_src) {

		this.next_image = new Image;
		this.next_image.src = new_src;

		var self = this;
		setTimeout(function () { self.setup_transition(new_src)}, 100);

	},

	setup_transition: function (new_src) {

		if (!this.next_image.complete || (typeof this.next_image.naturalWidth != "undefined" && this.next_image.naturalWidth == 0)) {
			if (document.getElementById(this.loading_element_id)) {
				document.getElementById(this.loading_element_id).style.visibility = '';
			}
			var self = this;
			setTimeout(function () { self.setup_transition(new_src)}, 100);
			return;
		}

		if (document.getElementById(this.loading_element_id)) {
			document.getElementById(this.loading_element_id).style.visibility = 'hidden';
		}

		this.registered_tiles = new Array;

		// num of horizontal and vertical tiles
		x_i = 1/this.tile_width_prc;
		y_i = 1/this.tile_height_prc;

		for (i = 0; i < x_i; i++)
		{
			for (j = 0; j < y_i; j++)
			{
				if (!(tile = document.getElementById('LWT_slide_show_tile_' + i + '_' + j)))
				{
					tile = document.createElement('div');
				}
				else
				{
				//	tile2 = document.getElementById('LWT_slide_show_i_tile_' + i + '_' + j)
				}

				tile2 = document.createElement('div');

				tile.innerHTML = '';
				tile.className = 'outerGrid';
				tile.style.display = 'block';
				tile.style.width = this.tile_width;
				tile.style.height = this.tile_height;
				tile.style.mozOpacity = 1;
				tile.style.textAlign = 'center';
				tile.style.zIndex = 100;

				tile.style.display = 'block';
				tile2.style.width = this.tile_width;
				tile2.style.height = this.tile_height;
				tile2.style.mozOpacity = 1;
				tile.style.zIndex = 101;

				tile2.style.background = this.background_color + ' url(' + this.image_element.src + ') -' + (i*this.tile_width) + 'px -' + (j*this.tile_height) + 'px no-repeat';

				tile.style.position = 'absolute';
				tile.style.left = this.image_element.offsetLeft + i * this.tile_width;

				tile2.style.margin = 'auto';
				tile.style.top = this.image_element.offsetTop + j * this.tile_height;

				tile.id = 'LWT_slide_show_tile_' + i + '_' + j;
				tile2.id = 'LWT_slide_show_i_tile_' + i + '_' + j;

				tile.appendChild(tile2);
				if (!document.getElementById('LWT_slide_show_tile_' + i + '_' + j)) {
					this.slideshow_element.appendChild(tile);
				}

				tile2.onload = setTimeout(this.image_transition(tile2.id), this.tile_orchestration(i, j));
			}
		}

		this.image_element.src = new_src;
	},

	// private
	createMatrix: function() {

	},

	// private
	loadImage: function () {
	
	}
}

// Basic Effects

function flip(id)
{
	if (parseInt(document.getElementById(id).style.width) < 2)
	{
		document.getElementById(id).style.display = 'none';
		return;
	}

	if (!document.getElementById(id).style.MozOpacity) document.getElementById(id).style.MozOpacity = 1;

	document.getElementById(id).style.width = parseInt(document.getElementById(id).style.width) * 0.6;

	document.getElementById(id).style.MozOpacity = parseFloat(document.getElementById(id).style.MozOpacity) * 0.7;
	document.getElementById(id).style.opacity = parseFloat(document.getElementById(id).style.opacity) * 0.7;
	document.getElementById(id).opacity = parseFloat(document.getElementById(id).opacity) * 0.7;

	setTimeout('flip(\'' + id + '\')', 50);
}

function flip_h(id)
{
	if (parseInt(document.getElementById(id).style.height) < 2)
	{
		document.getElementById(id).style.display = 'none';
		return;
	}

	if (!document.getElementById(id).style.MozOpacity) document.getElementById(id).style.MozOpacity = 1;

	document.getElementById(id).style.height = parseInt(document.getElementById(id).style.height) * 0.6;

	document.getElementById(id).style.MozOpacity = parseFloat(document.getElementById(id).style.MozOpacity) * 0.7;
	document.getElementById(id).style.opacity = parseFloat(document.getElementById(id).style.opacity) * 0.7;

	setTimeout('flip_h(\'' + id + '\')', 50);
}