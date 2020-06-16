/*!
 * number-display-fr
 * Copyright(c) 2016 IDfr
 * MIT Licensed
 */

'use strict';

/**
 * Module exports.
 * @public
 */

Module.exports = formatNumber;

/**
 * Return a well formatted number according to french rules
 * @param value
 * @param options
 */

function formatNumber(value, options) {
	options = options || {};
	value += ''; // must be String Type

	// not a number !!
	if (!__isNumber(value)) {
		return false;
	}

	var valueArr = __splitValue(value),
		integer = valueArr[0],
		negative = integer < 0,
		absInteger = Math.abs(integer) + '',
		formattedValue;

	if (options.reduce) {
		if (absInteger >= 100000 && absInteger <= 999999) {
			options.prefix = 'k' + options.prefix;
			integer = integer.slice(0, -3);
		} else if (absInteger > 999999 && absInteger <= 9999999) {
			options.prefix = 'Mio ' + options.prefix;
			integer = negative ? '-' + absInteger[0] + ',' + absInteger[1] : absInteger[0] + ',' + absInteger[1];
		} else if (absInteger > 9999999 && absInteger <= 999999999) {
			options.prefix = 'Mio ' + options.prefix;
			integer = integer.slice(0, -6);
		} else if (absInteger > 999999999 && absInteger <= 9999999999) {
			options.prefix = 'Mrd ' + options.prefix;
			integer = integer.slice(0, -8);
			integer = negative ? '-' + absInteger[0] + ',' + absInteger[1] : absInteger[0] + ',' + absInteger[1];
		} else if (absInteger > 9999999999) {
			options.prefix = 'Mrd ' + options.prefix;
			integer = integer.slice(0, -9);
		}

		// add spaces
		formattedValue = __addSpacesSeparator(integer);
	} else {
		// add spaces
		valueArr[0] = __addSpacesSeparator(integer);
		formattedValue = valueArr.join(',');
	}

	if (options.prefix) {
		formattedValue += ' ' + options.prefix;
	}

	return formattedValue;
}

/**
 * Check if value contains only number and one/zero coma
 * @param value
 * @returns {boolean}
 * @private
 */
function __isNumber(value) {
	return !!value.match(/^-?[0-9]*,?[0-9]*$/);
}

/**
 * Split number in [integer | decimal] if number is a number
 * else return null
 * @param value
 * @returns {Array|{index: number, input: string}}
 * @private
 */
function __splitValue(value) {
	return value.split(',');
}

/**
 * Add a space every three characters
 * @param val
 * @returns {string}
 * @private
 */
function __addSpacesSeparator(val) {
	var reg = /(\d+)(\d{3})/,
		sep = ' ';
	// val must be a type String
	val += '';

	while (reg.test(val)) {
		val = val.replace(reg, '$1' + sep + '$2');
	}
	return val;
}
