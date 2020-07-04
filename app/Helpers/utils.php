<?php

/**********************************************
 *
 * True iff ALL needles exist
 * Here is a solution which returns true if ALL needles are present in the haystack.
 *
 * function in_array_all($needles, $haystack) {
 *    return !array_diff($needles, $haystack);
 * }
 *
 * echo in_array_all( [3,2,5], [5,8,3,1,2] ); //true, all present
 * echo in_array_all( [3,2,5,9], [5,8,3,1,2] ); //false, since 9 is not present
 * You can of course use it directly:
 *
 * if (!array_diff( [3,2,5], [5,8,3,1,2] )) { //true
 * This is also very easy to remember. Same way as you would use in_array($needles, $haystack), except you rename it to array_diff and put ! in front.
 *
 * True iff ANY of the needles exist
 * function in_array_any($needles, $haystack) {
 *    return !!array_intersect($needles, $haystack);
 * }
 *
 * echo in_array_any( [3,9], [5,8,3,1,2] ); //true, since 3 is present
 * echo in_array_any( [4,9], [5,8,3,1,2] ); //false, neither 4 nor 9 is present
 *
 * http://stackoverflow.com/questions/7542694/in-array-multiple-values
 *
 *********************************************/
function inArrayAll($needles, $haystack, $any = false)
{
    if ($any) {
        // True iff ANY of the needles exist
        return !!array_intersect($needles, $haystack);
    }
    //True iff ALL needles exist
    return !array_diff($needles, $haystack);
}
