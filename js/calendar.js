
// COMPATIBILITY FOR INDEXOF JAVASCRIPT FUNCTION
	if (!Array.prototype.indexOf) {
		Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {
			"use strict";
			if (this == null) {
				throw new TypeError();
			}
			var t = Object(this);
			var len = t.length >>> 0;
			if (len === 0) {
				return -1;
			}
			var n = 0;
			if (arguments.length > 1) {
				n = Number(arguments[1]);
				if (n != n) { // shortcut for verifying if it's NaN
					n = 0;
				} else if (n != 0 && n != Infinity && n != -Infinity) {
					n = (n > 0 || -1) * Math.floor(Math.abs(n));
				}
			}
			if (n >= len) {
				return -1;
			}
			var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
			for (; k < len; k++) {
				if (k in t && t[k] === searchElement) {
					return k;
				}
			}
			return -1;
		}
	}


// Global Variables
// ENTER LIST OF IBU EVENT DATES BELOW IN FORMAT: '<MONTH>_<DAY>'
IBU_EVENT_DAYS = ['9_3', '9_4', '9_5', '9_6', '9_7', '9_8', '9_9', '9_10', '9_11', '9_12', '9_13']; 
DAYS_OF_WEEK = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
MONTH_NAME = ['January', 'February', 'March', 'April', 'May', 'June', 
	'July', 'August', 'September', 'October', 'November', 'December'];
LAST_DAY_OF_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

current_date = new Date();

function Calendar(month, year) {
  this.month = (isNaN(month) || month == null) ? current_date.getMonth() : month;
  this.year  = (isNaN(year) || year == null) ? current_date.getFullYear() : year;
  this.html = '';
}

Calendar.prototype.generateHTML = function() {

	var html = '';
	var firstDay = new Date(this.year, this.month, 1);
	var startingDay = firstDay.getDay();
	var monthName = MONTH_NAME[this.month];
	var endingDay = LAST_DAY_OF_MONTH[this.month];

	// Check for leap year for February
	if (this.month == 1) {
		if ((this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0){
			endingDay = 29;
		}
	}

	// Print Month Name
	html += '<div id="cal">'
	html += '<h1>' + monthName + '</h1>';

	// Print Days of Week
	html += '<table cellspacing="0"><thead><tr>'
	for (var day = 0; day < DAYS_OF_WEEK.length; day++) {
		html += '<th>' + DAYS_OF_WEEK[day] + '</th>'				
	}
	html += '</tr></thead><tbody>'
	
	// Print days
	html += '<tr>'
	
	if (startingDay > 0) {
		html += '<td class="padding" colspan="' + startingDay + '"></td>' // Print Column Padding before first day
	}
	
	for (var day = 1; day <= endingDay; day++) {
	
		// Add event attribute if day is an iBU Event Date
		if (IBU_EVENT_DAYS.indexOf((this.month + 1) + '_' + day) > -1) {
			html += '<td class="date_has_event">' + day + '<div class="events">';
		}
		else {
			html += '<td>' + day + '</td>'
		}

		if ((startingDay + day) % 7 == 0) {
				html += '</tr><tr>'
		}
	}
	
	// Close table tags
	html += '</tr>'
	html += '</tbody></table></div>'
	
	this.html = html;
}

Calendar.prototype.getHTML = function() {
	return this.html;
}
