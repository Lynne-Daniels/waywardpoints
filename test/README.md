Web Optimization Project

View project at http://www.waywardpoints.com/test/

Part I Page Speed Insights

ftp'd files to http://www.waywardpoints.com/test/ on a commercial linux web server.

The web server compresses the files and maybe does some other magic.  Just the hosting changed from local DCL: 22192ms, onload: 22229ms to hosted DCL: 165ms, onload: 516ms.

Checked Page Speed Insights

Learned Images are too big.

pizzeria.jpg:

Compressed file and reduced dimesions to 500x375. Files size reduced from 2.25MB to 25KB.
Used Gimp (photo software) to save file with lower quality level (35%?).

profilepic.jpg

Compressed in Gimp, reducing file size to 5.22KB from 15KB.


Hmmm...after uploading the smaller photos, the load stats changed on the hosted page to DCL: 10102ms, onload: 17673ms.  I don't know why it got slower.  The local copy changed from DCL: 22113ms, onload: 22114ms to DCL: 22183ms, onload: 22187ms

I tried to duplicate the change by removing and resending the two image files to the server.  I did not get the same large times.  I did notice a 2.25MB copy of the image in the server dirctory that was replaced earlier.  I deleted that, had some error messages, then uploaded the images.  After that, times were DCL: 155ms, onload: 497ms.

Added asych in index.html <script async src="http://www.google-analytics.com/analytics.js" ></script>

added media="print" to the print style sheet to make it non-blocking

page speed changed from 28/100 to 75/100mobile, 88/100 desktop

noticed the google fonts take much longer than the other stuff to load.
http://fonts.googleapis.com/css?family=Open+Sans:400,700 works, but there is an error in the console from the pizza page.  

Read http://www.google.com/fonts#UsePlace:use/Collection:Open+Sans

In index.html, replaced   broken link 

<link href="//fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">  

with

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

Now the error message is gone and the page is received at about the same time as all the others.

page now says DCL: 93ms, onload: 199ms on local copy, DCL: 130ms, onload: 443ms on hosted copy

pagespeed insights page speed is the same

Removed the link to the fonts.  Grabbed the CCS for the latin fonts only and inlined it on the html page.

General info on FPS
http://www.smashingmagazine.com/2013/06/10/pinterest-paint-performance-case-study/

used https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Media_queries to move css into media query file for small screens, but then got a better page insight score with it inline.

moved all of style.css into inline styles in index.html

Considered minifying the html and css, but have already met page speed requirements. Looks like I should have minified BEFORE inlining the CSS as different programs do each type of file.  The next project is something I want to use IRL.  Will check into minification then.

Part II pizza.html

Grabbed source code from https://www.igvita.com/slides/2012/devtools-tips-and-tricks/jank-demo.html --

Used http://jsbeautifier.org/ to make the js readable.  Found the difference between the heavy scroll and non-heavy scroll is using var cachedScrollTop = document.body.scrollTop; 

http://www.phpied.com/rendering-repaint-reflowrelayout-restyle/ explains how requesting scrollTop messes up the browsers work flow and causes everything to be recalculated.


Pizza Scrolling
moved size computations out of the for loop.  Pizzas are all the same size, can just do that one time.  Changed from over 100ms to a little over 10ms.

  	  var dx = determineDx(document.querySelectorAll(".randomPizzaContainer")[1], size);
      var newwidth = (document.querySelectorAll(".randomPizzaContainer")[1].offsetWidth + dx) + 'px';

for loop was recounting the pizzas.
added var pizzacount = document.querySelectorAll(".randomPizzaContainer").length;
  	
    for (var i = 0; i < pizzacount; i++)

watched https://plus.google.com/u/0/events/c8eah6f0d0t9eretebpm7dqi0ok?authkey=CKaNhtb0quvqKA

added backface-visibility: hidden to css of .mover  This reduced paint time dramatically.

changed number of mover pizzas from 200 to 100

Changed      // document.querySelectorAll(".randomPizzaContainer")[i].style.width = newwidth;

To the faster

     document.getElementsByClassName("randomPizzaContainer")[i].style.width = newwidth;


https://jsperf.com/getelementsbyclassname-vs-queryselectorall/18 shows me to change .randomPizzaContainer to randomPizzaContainer without the leading dot.

from http://stackoverflow.com/questions/7108941/css-transform-vs-position
box.style.transform = "translateX(200px)";
vs
box.style.left = "200px";

article here:  http://www.paulirish.com/2012/why-moving-elements-with-translate-is-better-than-posabs-topleft/

Getting better.  It meets, but just. There are often multiple scroll events happening in a frame when I scroll with the touchpad.  It looks really good if i scroll with the arrow key.  I think the links below show a way to fix that.

http://www.html5rocks.com/en/tutorials/speed/scrolling/
http://www.html5rocks.com/en/tutorials/speed/animations/ - shows how to use requestAnimationFrame to improve timing of redraws.  I dont understand it %100 percent.  Have not tried it.

Reading https://developer.chrome.com/devtools/docs/heap-profiling and https://developer.chrome.com/devtools/docs/memory-analysis-101 now.

I would also like to know why the JS Heap keeps getting bigger.  Is that normal?  I tried to understand the Profiles tab of the dev tools, but I couldn't find problem and was a little worried I was on a wild goose chase.

3/11/15 -- received rejection of first draft.  I had broken the moving pizzas without realizing.  The change from style.left to translateX seems to be the problem.
Changed that back, but now frame rate is sometimes over 60 fps.

  restored items[i].style.left = items[i].basicLeft + 100 * phase + 'px';
 got rid of //items[i].style.transform = "translateX(items[i].basicLeft + 100 * phase + 'px')";
 
looked at console.log(items[i].basicLeft);
   
Changed   //items[i].style.left = items[i].style.left = items[i].basicLeft + 100 * phase + 'px'; + 100 * phase + 'px';
 to items[i].style.left = (i%8)*256 + 100 * phase + 'px';
 
This looks better.  Googled why there are gray outlines on the timeline.  Might be stuff the computer is doing in the background?  I have had a zillion windows open for days.  Restarted.

Under 60 fps now.  Compared items[i].basicLeft vs (i%8)*256. Can't see a difference.  Put it back to original.