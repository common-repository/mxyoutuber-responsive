=== YouTubeR by Maxio lab. ===
Contributors: Maxio lab.
Tags: api, youtube videos, cache, caching, embed youtube, embedding youtube, get_locale, i18n, internationalization, l10n, language, locale, localization, plugin, responsive, short code, shortcode, thumbnail, thumbnail Image, thumbnails, TinyMCE, translate, translator, video, video analytics, video plugin, video shortcode, video thumbnails, view count, volume, wordpress security, wordpress youtube embed, youtube, YouTube API, youtube embed, youtube impressions, youtube player, youtube plugin, youtube shortcode, youtube snippets, youtube takedowns, youtube thumbnails, embed, upload, russian, video, youtube.com, youtu.be
Requires at least: 4.3.0
Tested up to: 4.5.3
Stable tag: 1.0.5

The plugin allows you to upload your videos on YouTube from your website and embed YouTube videos to your website.


== Description ==

The plugin allows you to upload your videos on YouTube from your website and embed YouTube videos to your website. If you posting your videos on your WordPress site you don't neet to go to YouTube website, you can upload your videos directly on YouTube from your website admin panel. And also you can embed YouTube videos to your website with nice visual interface.



== Installation ==

1. Upload "mxyoutuber" folder to the "/wp-content/plugins/" directory of your website;
2. Activate the plugin through the "Plugins" menu in WordPress;
3. That's it.

After installation you need to set the Google API keys:

First of all, go to Settings > YouTubeR.
To use this plugin, you need a valid Google API keys. You can get them with a Google account on Google Developers Console.
The Google API is free with a limit, but for a normal use you don't have to worry at all, currently, for the YouTube API data the limit is of 50,000,000 units/day.
On the Google Developers Console site, click on the Create project button, set any name for it and wait until it's created.
First we need to enable the YouTube Data API so go to APIs & auth > APIs, click on the YouTube Data API and on the Enable API button.
Then go to APIs & auth > Credentials.
Here wee need 2 diferent keys: Browser key and Web application Client ID.

1. Obtaining a Browser key
	Click on the Add credentials button.
	In the modal choose the API key option, then click Browser key button.
	This step is optional, you can set on the HTTP referrers field all the domains you want the API to accept queries from, for example like this: *.example.com/* for the example.com domain.
	In some cases we've found Google will throw an error from the domain even it is correct, in that cases we suggest you to leave the refer field empty to allow from any domain. The API key won't be public anytime in your WordPress so you don't have to worry at all.
	Ok, after all, click on the Create button, your API key will be right there.
	Copy the API key from the Google Developers Console and paste it in the YouTubeR settings page on your WordPress site and save changes.
2. Obtaining a Web application Client ID
	Click on the Add credentials button and choose OAuth 2.0 client ID option.
	This step is optional, click the Configure consent screen. If you don't have this button, then you have already configured "consent screen". Fill in the required fields and press save and you're done configuring consent screen.
	Choose Web application and fill in the name of your application (it can be whatever you want).
	Then fill in Authorized JavaScript origins - these are URLs of the websites where you will use YouTubeR plugin.
	Click "Create" button and you will see your client ID.
	You guessed it! Copy the client ID from the Google Developers Console and paste it in the YouTubeR settings page on your WordPress site and save changes.
	Perfect! You're done! Now you can start with the shortcode.


== Screenshots ==

1. A YouTubeR button above the content editor.
2. When you press a button (1-st screenshot) an YouTubeR window will appear where you can see all your videos and upload new ones
3. Section of YouRubeR where you can upload a new video to YouTube
4. Example of the videos (with different settings) displayed on the website

	
== Shortcode ==

The video shortcode will display a single video with it's info.
To use it you just need the Video ID, to find it just check a normal YouTube url:
https://www.youtube.com/watch?v=oxgnlSbYLSc
In this case the Video ID is oxgnlSbYLSc, and the shortcode is:
[mx_youtuber id="Video ID"]


== Shortcode parameters ==

Parameter		Possible values							Description
id				-										YouTube video ID
display 		title,date,channel,description,meta 	Keys of elements sepparated by commas of the parts of the video to show, set to none to only display the video thumbnail
mode 			lightbox / embed / link 				Type of embeding the video
theme 			Check the themes section 				The template which will be applied
size 			default / medium / high / standard 		The size of the video thumbnail
width 			number 									The width of the video (can be in %). Valid only in embed mode
height 			number 									The height of the video (can be in %). Valid only in embed mode
max_words 		number 									Limit the maximum number of words to show in the video description


== Themes ==

YouTubeR comes with some pretty cool templates, this are the current options: default, dark.
You can create your own custom theme for YouTubeR, to do so let's say you set the parameter theme to custom.
[mx_youtuber theme="custom"]
Then you can add your own styles to the gallery with the base class mxYouTubeR_theme_custom.
If you need to customize/overwrite the code of the template you can create a folder inside your website theme with the name mxyoutuber and another folder inside it with the name of the theme you want, in this case custom.
Copy the original files from themes/default inside the plugin's folder into the mxyoutuber/custom inside your website theme, you just need to copy the files you want to customize.
The logic of the plugin when searching for a file of the template custom template is as it follows:
1. The plugin will look for the file inside the website theme folder
2. The plugin will look for the file inside the plugin folder
3. The plugin will load the default theme file


== Changelog ==

= 1.0.5 =
* version update
= 1.0.4 =
* version update (i'm new to SVN :))
= 1.0.3 =
* version update
= 1.0 =
* initial version
