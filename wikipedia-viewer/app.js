/*Freebootcamp Project - take user data and search wikipedia May 2016

Wikipedia urls where search term = zyz, returning up to the number items specified in by limit=
//https://en.wikipedia.org/w/api.php?action=opensearch&search=zyz&limit=10&namespace=0&format=jsonfm - human readable
//https://en.wikipedia.org/w/api.php?action=opensearch&search=zyz&limit=10&namespace=0&format=json - machine readable */
//free code camp used 'https://en.wikipedia.org/w/api.php?format=json&action=query&generator=search&gsrnamespace=0&gsrlimit=10&prop=pageimages|extracts&pilimit=max&exintro&explaintext&exsentences=1&exlimit=max&gsrsearch=zyz&callback=JSON_CALLBACK'
function getWikis(searchTerms)
	{
		$.ajax(
		{
			url: 'https://en.wikipedia.org/w/api.php?action=opensearch&search=' + searchTerms + '&limit=10&namespace=0&format=json&callback=wikiCallback',
			type: 'GET',
			dataType: 'jsonp'
		}).done(function(json)
		{
			//	$('#wiki-search-results').append('stuff lands here');
			//	htmlifyJSON(json);
			console.log("stuff " + json);
			updateresults(json);
		}).fail(function(xhr, status, errorThrown)
		{
			alert("Sorry, there was a problem!");
			console.log("Error: " + errorThrown);
			console.log("Status: " + status);
			console.dir(xhr);
		}).always(function(xhr, status)
		{
			console.log("The request is complete!");
		});
	} //end getWikis
	//reads an object that is an array of four arrays: name, description, link  index in last three arrays identifies search result. first array is single value equal to search term
	// put the wiki search results on the page in 2 columns for large screens and 1 for phones

function updateresults(json)
	{
		var wikiLink1 = '',
			wikiLink2 = ''; // this will appear on the page as link to a search result
		console.log('updating results' + json);
		if (json[1].length < 1)
		{ //No results, add an error message
			$('#wiki-search-results').html('<div class = "err-div">No results found<div>');
		}
		for (var i = 0; i < json[1].length; i += 2)
		{ // build the rows, testing to see if results include a description
			if (json[2][i].length > 0)
			{
				wikiLink1 = '<div class = "link-list"><a href = ' + json[3][i] + '> <b>' + json[1][i] + ': </b> ' + json[2][i] + '</a></div>';
			}
			else
			{
				wikiLink1 = '<div class = "link-list"><a href = ' + json[3][i] + '> <b>' + json[1][i] + ': </b> No description available </a></div>';
			}
			if (json[2][i + 1].length > 0)
			{
				wikiLink2 = '<div class = "link-list"><a href = ' + json[3][i + 1] + '> <b>' + json[1][i + 1] + ': </b> ' + json[2][i + 1] + '</a></div>';
			}
			else
			{
				wikiLink2 = '<div class = "link-list"><a href = ' + json[3][i + 1] + '> <b>' + json[1][i + 1] + ': </b> No description available </a></div>';
			}
			if (i % 2 === 0)
			{ //start a row every two items
				$('#wiki-search-results').append('<div class="wiki-result row"><div class = "col-xs-12 col-sm-6 ff">' + wikiLink1 +
					'</div><div class = "col-xs-12 col-sm-6 ff">' + wikiLink2 + '</div></div>');
			}
		}
	}
	// assign event handlers after the page loads
$(document).ready(function()
{
	$('#searchButton').on('click', function(e)
	{
		var searchTerm = $('#usr').val(); //here an extra time in case it needs that to catch updates?
		$('#wiki-search-results').html(''); // clear any previous search results
		console.log(searchTerm + ' is search term');
		getWikis(searchTerm);
	});
	// Thanks http://stackoverflow.com/questions/6524288/jquery-event-for-user-pressing-enter-in-a-textbox
	$('#usr').bind("enterKey", function(e)
	{
		//do stuff here
		var searchTerm = $('#usr').val(); //here an extra time in case it needs that to catch updates?
		$('#wiki-search-results').html(''); // clear any previous search results
		console.log(searchTerm + ' is search term');
		getWikis(searchTerm);
	});
	$('#usr').keyup(function(e)
	{
		if (e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
}); // end doc ready