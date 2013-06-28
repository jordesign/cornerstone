=== Cornerstone Sermons ===
Contributors: jordesign 
Tags: church, sermon, podcast
Requires at least: 3.5
Tested up to: 3.6
Stable tag: 

Cornerstone Sermons allows you add, manage, and display playable audio of sermons/talks on your site.


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

You will then have an additional menu item on the LHS to add (and manage) sermons.

 
== Frequently Asked Questions ==

Q: How do I show the sermons?

A: Archives of the posts (and single sermons) will automatically display at the /sermons/ url.

Single sermons (and lists of recent sermons) can be inserted using the available widgets, or using a shortcode - or the direct PHP functions.

**Shortcode (display a single sermon)**

[sermon sermon\_id={id-of-the-sermon} sermon\_image={true/false} sermon\_series={true/false} sermon\_speaker={true/false}]

sermon_id: the post ID of the sermon you want to display (find it in the url when you edit that sermon)

sermon_image: Do you want to show the sermon series image? (true/false)

sermon_series: Do you want to display text of the sermon series? (true/false)

sermon_speaker: Do you want to display the speaker name? (true/false)

 

**PHP Functions**

**Display a list of recent sermons:**

cs\_list\_sermons(

    $sermonCount = 1,     //Number of Sermons to show. Defaults to 1

    $sermonSpeaker = false,      //Show Speaker Name (True/False)

    $sermonSeries = false,   //Show Series Title (True/False)

    $sermonImage = false     //Show Series Image (True/False)

)

 

**Display a single sermon**

cs\_single\_sermon(

     $sermonID = 1,     //ID of the sermon to include

     $sermonSpeaker = false,      //Show Speaker Name (True/False)

     $sermonSeries = false,   //Show Series Title (True/False)

     $sermonImage = false     //Show Series Image (True/False)

 )