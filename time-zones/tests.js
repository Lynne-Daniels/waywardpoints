/*not used at present */
var Test = {};
Test.assertEquals = function(actual, expected, testName){
    if (actual === expected){
        console.log('passed [' + testName + ']');
    }else{
        console.log('FAILED [' + testName + ']. Expected "' + expected + '", but got "' + actual + '"');
    }

};
Test.assertSimilar = function(actual, expected, testName){
    actual = JSON.stringify(actual);
    expected = JSON.stringify(expected);
    if (actual === expected){
        console.log('passed [' + testName + ']');
    }else{
        console.log('FAILED [' + testName + ']. Expected "' + expected + '", but got "' + actual + '"');
    }

};
