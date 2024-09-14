/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//Check Old Browser
/*
 * Browser Detect script
 */
var BrowserDetect = (function() {
    // script settings
    var options = {
        osVersion: true,
        minorBrowserVersion: true
    };

    // browser data
    var browserData = {
        browsers: {
            chrome: uaMatch(/Chrome\/([0-9\.]*)/),
            firefox: uaMatch(/Firefox\/([0-9\.]*)/),
            safari: uaMatch(/Version\/([0-9\.]*).*Safari/),
            opera: uaMatch(/Opera\/.*Version\/([0-9\.]*)/, /Opera\/([0-9\.]*)/),
            msie: uaMatch(/MSIE ([0-9\.]*)/, /Trident.*rv:([0-9\.]*)/)
        },
        engines: {
            webkit: uaContains('AppleWebKit'),
            trident: uaMatch(/(MSIE|Trident)/),
            gecko: uaContains('Gecko'),
            presto: uaContains('Presto')
        },
        platforms: {
            win: uaMatch(/Windows NT ([0-9\.]*)/),
            mac: uaMatch(/Mac OS X ([0-9_\.]*)/),
            linux: uaContains('X11', 'Linux')
        }
    };

    // perform detection
    var ua = navigator.userAgent;
    var detectData = {
        platform: detectItem(browserData.platforms),
        browser: detectItem(browserData.browsers),
        engine: detectItem(browserData.engines)
    };

    // private functions
    function uaMatch(regExp, altReg) {
        return function() {
            var result = regExp.exec(ua) || altReg && altReg.exec(ua);
            return result && result[1];
        };
    }
    function uaContains(word) {
        var args = Array.prototype.slice.apply(arguments);
        return function() {
            for (var i = 0; i < args.length; i++) {
                if (ua.indexOf(args[i]) < 0) {
                    return;
                }
            }
            return true;
        };
    }
    function detectItem(items) {
        var detectedItem = null, itemName, detectValue;
        for (itemName in items) {
            if (items.hasOwnProperty(itemName)) {
                detectValue = items[itemName]();
                if (detectValue) {
                    return {
                        name: itemName,
                        value: detectValue
                    };
                }
            }
        }
    }

    // add classes to root element
    (function() {
        // helper functions
        var addClass = function(cls) {
            var html = document.documentElement;
            html.className += (html.className ? ' ' : '') + cls;
        };
        var getVersion = function(ver) {
            return typeof ver === 'string' ? ver.replace(/\./g, '_') : 'unknown';
        };

        // add classes
        if (detectData.platform) {
            addClass(detectData.platform.name);
            if (options.osVersion) {
                addClass(detectData.platform.name + '-' + getVersion(detectData.platform.value));
            }
        }
        if (detectData.engine) {
            addClass(detectData.engine.name);
        }
        if (detectData.browser) {
            addClass(detectData.browser.name);
            addClass(detectData.browser.name + '-' + parseInt(detectData.browser.value, 10));
            if (options.minorBrowserVersion) {
                addClass(detectData.browser.name + '-' + getVersion(detectData.browser.value));
            }
        }
    }());

    // export detection information
    return detectData;
}());

(function($) {
    var browser_name = BrowserDetect.browser.name;
    var browser_version = BrowserDetect.browser.value;
    var os_name = BrowserDetect.platform.name;
    var os_version = BrowserDetect.platform.value;
    var str = browser_name + ' ' + browser_version + ' ' + os_name+ ' '+ os_version;
    //alert(str);
    var url = $(location).attr('href');
    switch (browser_name) {
        case 'firefox':
            var fversion = browser_version.split(".");
            var fint = parseInt(fversion[0]);
            if(fint < 45){
                 if(url.indexOf("https")!=-1){
                    var newurl = url.replace("https","http");
                    window.location.href = newurl; 
                 }
            }
            break;
        case 'chrome':
            var cversion = browser_version.split(".");
            var cint = parseInt(cversion[0]);
            if(cint < 50){
                 if(url.indexOf("https")!=-1){
                   var newurl = url.replace("https","http");
                   window.location.href = newurl; 
                 }
            } 
            break;
        case 'safari':
            var sversion = browser_version.split(".");
            var sint = parseInt(sversion[0]);
            if(sint < 8){ 
                if(url.indexOf("https")!=-1){
                   var newurl = url.replace("https","http");
                    window.location.href = newurl; 
                }
            }
            break;
    }
})(window.jQuery);
//End 