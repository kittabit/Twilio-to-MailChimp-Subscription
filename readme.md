# Twilio to Mailchimp Subscription

## Features
* Extracts emails from incoming text messages and subscribes them to your mailchimp list
* Sets custom merge tag `SOURCE` to `TXT`. If this wasn't set, you wouldn't know which emails were subscribed via a text message or a form using the MC API on your website
* Sets the `PHONE` merge tag on your list to the phone number which sent the text message

## Instructions
1. [Obtain Your Mailchimp API Key](https://us2.admin.mailchimp.com/account/api/)
2. [Find Your Mailchimp List ID](http://kb.mailchimp.com/article/how-can-i-find-my-list-id/)
3. Customize `config.php` + throw on a public host
4. Set your SMS response to the `response.php` on your public host
