//Thanks http://stackoverflow.com/questions/1093568/scope-problem-with-nested-getjson


var streams = ["OgamingSC2","ESL_SC2","freecodecamp", "storbeck", "terakilobyte", "habathcx","RobotCaleb","thomasballinger","noobs2ninjas","beohoff", "brunofin", "comster404"];
var i = 0;
var gotStream,
	gotChannel,
	streamData,
	channelData;
var twitchRow = {
	image : 'https://placekitten.com/40/40',
	title : 'Title goes here',
	description : 'description goes here',
	online : '"https://api.twitch.tv/"',
};

function getData(stream){

	
	gotStream = false;
	gotChannel = false;
	$.getJSON('https://api.twitch.tv/kraken/streams/'+ streams[i] +'?callback=?', haveStream );
    $.getJSON('https://api.twitch.tv/kraken/channels/'+ streams[i] +'?callback=?', haveChannel);
    
}

function haveStream(data){
	streamData = data;
	gotStream = true;
	console.log('gotStream');
	if (gotChannel){
		makeRowData();
	}
}
function haveChannel(data){
	channelData = data;
	gotChannel = true;
	console.log('gotChannel');
	if (gotStream){
		makeRowData();
	}
}

function makeRowData(){
	
	console.log(streamData + channelData);
	twitchRow.title = streams[i];
	
	if (channelData.error){
		twitchRow.image = '<img src = "https://placekitten.com/140/140">';
		twitchRow.description = 'Not a valid channel';
		console.log(channelData.error + channelData.status + channelData.message);
		
	} else {
		
		if (channelData.logo == null){
						twitchRow.image = '<img src = "https://placekitten.com/140/140">';
					}else {
						twitchRow.image = '<img src = "' + channelData.logo +'">';
					}
		if (streamData.stream === null){
				twitchRow.description = 'Station Offline';
				console.log(' inside null' + ' ' + twitchRow.title +' ' + twitchRow.description);
			}else {
				//if (data.stream.game == true){
					twitchRow.description = streamData.stream.game + ' -- ' + streamData.stream.channel.status;
					console.log(' inside stream' + ' ' + twitchRow.title +' ' + twitchRow.description);
		}
	}
	makeRow(twitchRow.image, twitchRow.title, twitchRow.description);
	
}

function makeRow(image, title, description){
	//function to append rows to results div
	$('#results').append('<div class = "row"><div class = "col-sm-1 col-xs-3 avatar">'+
	image + '</div><div class = "col-sm-3 col-xs-9 screenname"><h4>' + title + '</h4></div><div class = "col-sm-8 col-xs-12 description">'+ description + '</div>');
	i = i + 1;
	console.log('i is incremented' + i);
	if (i < streams.length){
		getData(streams[i]);
		console.log('hereiam')
	}
}
getData(streams[i]);

/*
 * 
 * 
 for (var i = 0; i < streams.length; i++){
	(function(i) {
		console.log('i is now ' + i);
		getData(streams[i]);
	})(i);
}
for (var i = 0; i < streams.length; i++){
	(function(i) { // protects i in an immediately called function  thanks http://stackoverflow.com/questions/15347750/getjson-and-for-loop-issue
		$.getJSON('https://api.twitch.tv/kraken/streams/'+ streams[i] +'?callback=?', function(data) {
			
			twitchRow.title = streams[i];//all results use title from streams and build links from stream name
			
			if (data.error){
				twitchRow.image = '<img src = "https://placekitten.com/150/150">';
				twitchRow.description = 'not a valid channel';
				console.log(' inside error' + ' ' + twitchRow.title +' ' + twitchRow.description);
				makeRow(twitchRow.image, twitchRow.title, twitchRow.description);
		}else{// if stream name is valid account, get details;
			console.log('stream = ' + data.stream);
			if (data.stream === null){
				twitchRow.description = 'Station Offline';
				console.log(' inside null' + ' ' + twitchRow.title +' ' + twitchRow.description);
			}else {
				//if (data.stream.game == true){
					twitchRow.description = data.stream.game + ' -- ' + data.stream.channel.status;
					console.log(' inside stream' + ' ' + twitchRow.title +' ' + twitchRow.description);
			//	}
			}
			console.log('just before 2nd getJSON ' +  twitchRow.title +' ' + twitchRow.description);
			(function(i, title, description) {$.getJSON('https://api.twitch.tv/kraken/channels/'+ streams[i] +'?callback=?', function(data) {

					if (data.logo == null){
						twitchRow.image = '<img src = "https://placekitten.com/140/140">';
					}else
						twitchRow.image = '<img src = "' + data.logo +'">';
					console.log(' inside' + twitchRow.image + ' ' + twitchRow.title +' ' + twitchRow.description);
					makeRow(twitchRow.image, title, description);
				}); //end inner getJSON and its callback  (Had to add the (i) to make it use the inner value, otherwise it used last val in orig function)
	//	console.log(twitchRow.image + ' outside');
			})(i, twitchRow.title, twitchRow.description); //end the iffy .  without the iffy, loop repeats on last value of outer loop.
		}

	});//end outer getJson and its callback
	
	})(i);// calls the anon function twice? does not work if deleted, wish I understood better
};//end for loop

function makeRow(image, title, description){
	//function to append rows to results div
	$('#results').append('<div class = "row"><div class = "col-sm-1 col-xs-3 avatar">'+
	image + '</div><div class = "col-sm-3 col-xs-9 screenname"><h4>' + title + '</h4></div><div class = "col-sm-8 col-xs-12 description">'+ description + '</div>');
}

	// "https://placekitten.com/40/40	
	// try http://stackoverflow.com/questions/1093568/scope-problem-with-nested-getjson flag for geting 2 JSONS */