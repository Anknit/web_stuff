/**
 * Description of a test function using JS doc
 * @author Ankit Agarwal
 * @version 1.0
 * @function test
 * @param {integer} arg1 First argument for test function
 * @param {integer} arg2 First argument for test function
 * @returns {integer} Sum of both arguments
 */
function test (arg1,arg2){
	var trust = '';
	trust = arg1+arg2;
	return trust;
}
/**
 * Global Variable to be accessed by different functions
 * @global
 * @default
 */
var globalTestVar1 = 'Defaultval';

/**
* @author Ankit Agarwal
* @version 1.0
* @function objFunc
* @return {object} value of [globalTestVar1]{@link globalTestVar1}
*/
function objFunc(){
	return {'out':globalTestVar1};
}