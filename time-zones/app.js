/*Below small section of code is from http://momentjs.com/timezone/docs/ -- Moment.js also provides a hook for the 
long form time zone name. Because these strings are generally localized, Moment Timezone does 
not provide any long names for zones.
To provide long form names, you can override moment.fn.zoneName and use the zz token.*/
var abbrs = {
    EST : 'Eastern Standard Time',
    EDT : 'Eastern Daylight Time',
    CST : 'Central Standard Time',
    CDT : 'Central Daylight Time',
    MST : 'Mountain Standard Time',
    MDT : 'Mountain Daylight Time',
    PST : 'Pacific Standard Time',
    PDT : 'Pacific Daylight Time',
};

moment.fn.zoneName = function () {
    var abbr = this.zoneAbbr();
    return abbrs[abbr] || abbr;
};
/*End of  code from http://momentjs.com/timezone/docs/ */



var mainClock = {
    time: '',
    update: function(timeStr){//called on update to any text box sets main clock to user choice
        this.time = moment(timeStr);
    },
    initialize: function(){
        this.time = Date.now();
    }
};

function validateTime(newTime){
    //TODO make user enter a valid time
}


function renderNYClock(timeStr, abbr, zone, offset){
    document.getElementById('ET').value = timeStr;
    document.getElementById('america-new-york-abbr').innerText = abbr;
    document.getElementById('america-new-york-zone').innerText = zone;
    document.getElementById('america-new-york-offset').innerText = offset;
    if (localStorage.getItem('et-button') === 'hide'){
       showHide('et-button');
    }
}
function renderChicagoClock(timeStr, abbr, zone, offset){
    document.getElementById('CT').value = timeStr;
    document.getElementById('america-chicago-abbr').innerText = abbr;
    document.getElementById('america-chicago-zone').innerText = zone;
    document.getElementById('america-chicago-offset').innerText = offset;
        if (localStorage.getItem('ct-button') === 'hide'){
       showHide('ct-button');
    }
}
function renderDenverClock(timeStr, abbr, zone, offset){
    document.getElementById('MT').value = timeStr;
    document.getElementById('america-denver-abbr').innerText = abbr;
    document.getElementById('america-denver-zone').innerText = zone;
    document.getElementById('america-denver-offset').innerText = offset;
        if (localStorage.getItem('mt-button') === 'hide'){
       showHide('mt-button');
    }
}
function renderLosAngelesClock(timeStr, abbr, zone, offset){
    document.getElementById('PT').value = timeStr;
    document.getElementById('america-los-angeles-abbr').innerText = abbr;
    document.getElementById('america-los-angeles-zone').innerText = zone;
    document.getElementById('america-los-angeles-offset').innerText = offset;
        if (localStorage.getItem('pt-button') === 'hide'){
       showHide('pt-button');
    }
}


function renderAllClocks(){
    renderNYClock(moment.tz(mainClock.time, "America/New_York").format('lll'),
    moment.tz(mainClock.time, "America/New_York").format('z'),
    moment.tz(mainClock.time, "America/New_York").format('zz'),
    moment.tz(mainClock.time, "America/New_York").format('Z'));

    renderChicagoClock(moment.tz(mainClock.time, "America/Chicago").format('lll'),
    moment.tz(mainClock.time, "America/Chicago").format('z'),
    moment.tz(mainClock.time, "America/Chicago").format('zz'),
    moment.tz(mainClock.time, "America/Chicago").format('Z'));

    renderDenverClock(moment.tz(mainClock.time, "America/Denver").format('lll'),
    moment.tz(mainClock.time, "America/Denver").format('z'),
    moment.tz(mainClock.time, "America/Denver").format('zz'),
    moment.tz(mainClock.time, "America/Denver").format('Z'));

    renderLosAngelesClock(moment.tz(mainClock.time, 'America/Los_Angeles').format('lll'),
    moment.tz(mainClock.time, 'America/Los_Angeles').format('z'),
    moment.tz(mainClock.time, 'America/Los_Angeles').format('zz'),
    moment.tz(mainClock.time, 'America/Los_Angeles').format('Z'));
}

/*

For use in myHandler when improving the user input later

<input
   type       = "text" 
   onchange   = "myHandler();"
   onkeypress = "this.onchange();"
   onpaste    = "this.onchange();"
   oninput    = "this.onchange();"
/>*/

function myHandler(zone){

    console.log('onchange fired', zone, document.getElementById(zone).value);
    mainClock.update(document.getElementById(zone).value);
    moment.fn.zoneName = function () {// repeat this here for scope voodoo, w/o zone names dont show
    var abbr = this.zoneAbbr();
    return abbrs[abbr] || abbr;
    };
    renderAllClocks();
}
function showHide(buttonID){
    console.log('CLICKED');
    var section = document.getElementById(buttonID).parentElement;
    if (section.className === "time-zone"){
        section.className = 'shrinky-dink';
        document.getElementById(buttonID).innerHTML = 'show';
        localStorage.setItem(buttonID, 'hide');
        console.log('buttonID.text is: ', document.getElementById(buttonID).innerHTML);
    }else{
        section.className = 'time-zone';
        document.getElementById(buttonID).innerHTML = 'hide';
        localStorage.setItem(buttonID, 'show');
    }
    console.log(section.className);
    //section.className = 'shrinky-dink';
    console.log(document.getElementById("et-button").parentElement.className);
}
mainClock.initialize();
renderAllClocks();

