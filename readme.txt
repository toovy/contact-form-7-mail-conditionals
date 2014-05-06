=== Contact Form 7 Mail Conditions ===
Contributors: Tobias Braner
Tags: contact form 7, dynamic mail, mail condition
Requires at least: 3.0
Tested up to: 3.9
Stable tag: trunk
License: MIT
License URI: http://opensource.org/licenses/MIT

Modify your WPCF7 Mails with conditions.

== Description ==
Note: Complex if statements are not yet supported. Please contact me if you need this.

Before the WP Contact Form 7 Plugin sents a mail this plugin becomes active. It looks for if-conditions written in shortcode-style and evaluates if the condition variable is empty or not. Depending on that the block between [if] and [/if] is inserted into the mail or not.

Example:

[if phone]Phone number: [phone][/if]

== Installation ==
1. Copy the contact-form-7-mail-conditionals into your plugins folder
2. Activate the plugin