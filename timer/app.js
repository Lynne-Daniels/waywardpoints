/*was using below to animate in a bootstrap version.  don't know if discard or use yet. 

*/
/* Thank you to:
 * https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/
 * https://www.sitepoint.com/creating-accurate-timers-in-javascript/
 * <a href="http://cliparts.co">ClipArts</a>
 */

var numIntervals = 8,
goDuration = 30,  
restDuration = 90,
goTimeRemaining = 30,
restTimeRemaining = 90,
elapsed,
timer,
//totalReps = 8,
reps =0;
going = false;

document.addEventListener("DOMContentLoaded", function(event) {// don't do anything until page loads
	console.log("DOM fully loaded and parsed");
	
	assignEventHandlers();
	
	function assignEventHandlers(){
		

		document.getElementById("reset").addEventListener("click", function(event){
			event.preventDefault(); // prevents iphone from resizing on doubleclick
			reset();
			console.log('reset clicked');
		});
		document.getElementById("go-plus").addEventListener("click", function(event){ //TODO prevent negative or 0 values, fix screen shut down
			event.preventDefault();
			if (restDuration < 5930){//test that time does not go over 99:99
				goDuration = goDuration + 5;
				document.getElementById('go-duration').innerHTML = formatTime(goDuration);
				if (!going){
					console.log('not going');
					document.getElementById('time-remaining').innerHTML = formatTime(goDuration);
				}
				console.log('go-plus clicked');
			}
		});
		document.getElementById("go-minus").addEventListener("click", function(event){
			event.preventDefault();
			if (goDuration > 5){ // work time must be 5 sec or more
				goDuration = goDuration - 5;
				document.getElementById('go-duration').innerHTML = formatTime(goDuration);
				if (!going){
					console.log('not going');
					document.getElementById('time-remaining').innerHTML = formatTime(goDuration);
				}
				console.log('go-minus clicked');
			}
		});
		document.getElementById("rest-plus").addEventListener("click", function(event){
			event.preventDefault();
			if (restDuration < 5930){//test that time does not go over 99:99
				restDuration = restDuration + 5;
				document.getElementById('rest-duration').innerHTML = formatTime(restDuration);
				console.log('rest-plus clicked');
			}
		});
		document.getElementById("rest-minus").addEventListener("click", function(event){
			event.preventDefault();
			if (restDuration > 5){ // rest time must be 5 sec or more
				restDuration = restDuration - 5;
				document.getElementById('rest-duration').innerHTML = formatTime(restDuration);
				console.log('rest-minus clicked');
			}
		});
		document.getElementById("rep-plus").addEventListener("click", function(event){
			event.preventDefault();
			if (numIntervals < 99){ // no more than 99 or layout has to be updated - no sane person does 99 intervals anyway
				numIntervals = numIntervals + 1;
				document.getElementById('intervals').textContent = numIntervals + " REPS";
				document.getElementById('todo').textContent = numIntervals - reps;
				document.getElementById('done').textContent = reps;
				console.log('rest-minus clicked');
			}
		});
		document.getElementById("rep-minus").addEventListener("click", function(event){
			event.preventDefault();
			if (numIntervals > 1){ // must have at least one interval
				numIntervals = numIntervals - 1;
				document.getElementById('intervals').textContent = numIntervals + " REPS";
				document.getElementById('todo').textContent = numIntervals - reps;
				document.getElementById('done').textContent = reps;
				console.log('rep-minus clicked');
			}
		});
	}
	
	function formatTime(seconds){ 
		var mmss;
		mmss = ('0' + (Math.floor((seconds)/60))).slice(-2) + ':' + ('0' + ((seconds) % 60)).slice(-2);
		return mmss;		
	}
	
	function reset(){ // starts or restarts timer 
		
		clearInterval(timer);
		document.getElementById('go').style.border = '5px solid gold';
		reps = 0;
		going = true;
		document.getElementById('rest').style.border = '5px solid black';
		document.getElementById('runner').innerHTML = '<img  id = "runner1" src = "runner-30x35.png"></img>';
		document.getElementById('todo').textContent = numIntervals;
		document.getElementById('done').textContent = 0;
		changeTimer(new Date().getTime(), 0);  // get system time to use as start time for each period
	}
	
	function changeTimer(start, elapsed){// start is sysclock time when user starts, duration is global b/c user changes it anytime
		//var start = new Date().getTime(),
		
		var duration;
		
		console.log("change timer called, going = " + going + "restDuration = " + restDuration);
		moveRunner(707, 0);
		timer = window.setInterval(function()
			{if (going){ // test to see if user currently resting or in an interval
				duration = goDuration;
				console.log("goDuration = " + goDuration);
			} else{
				duration = restDuration;
				console.log("restDuration = " + restDuration);
			}//end else
				
			if (duration - elapsed > 0){
			    var timeRemaining = new Date().getTime() - start;
				elapsed = Math.floor(timeRemaining / 1000);// number of seconds elapsed
			//	format timeRemaining as string MM:SS
				timeRemaining =  formatTime(duration-elapsed);
				document.getElementById('time-remaining').innerHTML = timeRemaining;
				
				if (going){
					moveRunner(44, 0, elapsed);
				}
			} //end if
			else{
				going = !going;//toggle timer to measure rest time/work time
				if (going){
					document.getElementById('time-remaining').innerHTML = formatTime(goDuration);
					document.getElementById('go').style.border = '5px solid gold';
					document.getElementById('rest').style.border = '5px solid black';
					//moveRunner(0,0,0); -- that was off by 30 px
					document.getElementById('runner1').style.transform =  'translate(0px, 0px)';
				}else {
					document.getElementById('time-remaining').innerHTML = formatTime(restDuration);
					document.getElementById('go').style.border = '5px solid black';
					document.getElementById('rest').style.border = '5px solid gold';
					document.getElementById('todo').innerHTML = numIntervals - reps -1;
					document.getElementById('done').innerHTML = reps + 1;
					reps +=1;
					moveRunner(0,5,goDuration);
					console.log("runner rests: ");
				}
			
				clearInterval(timer);
				console.log("here reps = "+ reps + "numIntervals = " + numIntervals);
				if (reps < numIntervals){
					changeTimer(new Date().getTime(), 0);
					console.log(reps + " is reps");
				}else{//-- stop the program when all reps completed
					reps = 0;
					var stuff;
					stuff = '<img  id = "runner1" src = "runner-30x35.png"></img>' +  'Workout Complete!'
					document.getElementById('runner').innerHTML = stuff;
					document.getElementById('time-remaining').innerHTML = '00:00';
				}
			} //end else
		}, 1000); // end setInterval
	}	//end ChangeTimer
});// end DOMContentLoaded

function moveRunner(x, y, timeDone){
	var position, totalWidth, fractionComplete;
	totalWidth = document.getElementById('runner').offsetWidth;
	fractionComplete = (timeDone/goDuration*totalWidth) - 30; //image is 30 px wide
	position = 'translate(' + fractionComplete +'px, ' + y + 'px)';
	console.log(totalWidth);
	if (going){
	document.getElementById('runner1').style.transform = position;
		}else{
			position = 'translate(' + (totalWidth - 30) +'px, 0px) rotate(255deg)';
			document.getElementById('runner1').style.transform =  position;
			console.log(position);
		}
	/* TODO maybe?  need to add prefixes to transform
	 * such as...
	* 	-ms-transform: translate(50px, 0px);  //IE 9 
    -webkit-transform: translate(50px, 0px); //Safari 
    transform: translate(50px, 0px);
	 * 
	 * 
	 */
}

