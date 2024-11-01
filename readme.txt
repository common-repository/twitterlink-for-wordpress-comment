=== twitterLink for WordPress comment ===Contributors: Rogi073Tags: comment, twitterRequires at least: 2.0.2Tested up to: 2.7Stable tag: 0.1== Description ==
Twitter for WordPress make twitter as comment for your blog.
**Usage**
To put submit form just add strings as follows.
(You must not change submit form HTML at all. If you change something this plugin will not work correctly.)
`<?php twlink_for_wpcomment_submit("username"); ?>`To put comments which is submitted to you blog through twitterLink for WordPress Comment, just add strings as follows.`<?php twlink_for_wpcomment_recieve(); ?>`If you want to customize, you can add 2 options.First option "display_comment_limit" is the limit number of comments to display (default value is "all").Second option "islist" is boolean value and is the style setting option.If set this option as true then comments are displayed using <UL> <LI> tags,and if set this option as false then comments are displayed without <UL> <LI> tags,`<?php twlink_for_wpcomment_recieve("display_comment_limit","islist"); ?>`example `<?php twlink_for_wpcomment_recieve(5,true); ?>`If you want to add Link to twitterLink site add strings as follows.
`<?php echo twlink_for_wpcomment_link(); ?>`
**Customization**
The plug in provides the following CSS classes:
    * form.tlfc_commentform: the submit form    * ul.twitterlink_fc: the main ul (if list is activated)
== Installation ==
1. Upload `twitterlink-for-wp_comment` folder to the `/wp-content/plugins/` directory1. Activate the plugin through the 'Plugins' menu in WordPress
== Contact ==
Suggestion, fixes, rants, congratulations, gifts et al to help[at]seunze.com