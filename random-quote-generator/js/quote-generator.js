$(document).ready(function() //delay everything until page has loaded.
{
    //	automagically makes the Twitter Button
    ! function(d, s, id)
    {
        var js, fjs = d.getElementsByTagName(s)[0],
            p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id))
        {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'twitter-wjs');
    //function provided by quotesondesign.com 
    $('#get-another-quote-button').on('click', function(e)
    {
        $('body').css("background-color", '#' + Math.floor(Math
            .random() * 16777215).toString(16)); //change background color
        e.preventDefault(); // no idea what that does, looks important
        $.ajax(
        {
            url: 'http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1',
            success: function(data)
            { //assigns values *after* the quote json is downloaded.
                var post = data.shift(); // The data is an array of posts. Grab the first one.
                $('#quote-title').text(post.title); // is actually the author of the quote
                $('#quote-content').html(post.content);
                //Delete any existing tweeter button
                $('#tweeter').empty();
                // Make a new twitter share button specific to the quote https://dev.twitter.com/web/tweet-button/javascript-create
                //I tried to change the text property only, but twitter made some sort of security error.
                twttr.widgets.createShareButton(
                    'http://waywardpoints.com/random-quote-generator/',
                    document.getElementById('tweeter'),
                    {
                        text: $('#quote-content > p').text(),
                        size: "large" //28px x 75px
                    });
                // If the Source is available, use it. Otherwise hide it.  Not using this right now.  Left here in case I should
                if (typeof post.custom_meta !==
                    'undefined' && typeof post.custom_meta.Source !== 'undefined')
                {
                    $('#quote-source').html(
                        'Source:' + post.custom_meta.Source);
                }
                else
                {
                    $('#quote-source').text('');
                }
            },
            error: function(req, status, error) {
                $('#quote-title').text(error);
                $('#quote-content').html(status.toUpperCase() + ': ' + $.parseJSON(req.responseText)[0].message);
            },
            cache: false
        });
    });
    //Load initial quote -- Thanks http://stackoverflow.com/questions/2060019/how-to-trigger-click-on-page-load
    setTimeout(function()
    {
        $('#get-another-quote-button').trigger('click');
    }, 10);
}); //end document ready function