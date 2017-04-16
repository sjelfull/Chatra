# Chatra plugin for Craft CMS

Integrate Chatra easily with Craft.

# About Chatra
Powerful live chat software that helps to increase revenue and collect feedback providing an easy way for website owners to talk to visitors in real time.

- [Get an account now](https://app.chatra.io/?enroll=&partnerId=eM2oGJzP3nzFXc4ua)
- [Read more about getting started with Chatra](https://chatra.io/help/?enroll=&partnerId=eM2oGJzP3nzFXc4ua)

## Installation

To install Chatra, follow these steps:

1. Download & unzip the file and place the `chatra` directory into your `craft/plugins` directory
2. Install plugin in the Craft Control Panel under Settings > Plugins
3. The plugin folder should be named `chatra` for Craft to see it.

Chatra works on Craft 2.4.x and Craft 2.5.x.

## Configuring Chatra

Add your accounts public and secret API key. You can get them from the bottom of [General -> Setup & customize](https://app.chatra.io/settings/general?enroll=&partnerId=eM2oGJzP3nzFXc4ua)

## Using Chatra

Simply insert the template hook into your main layout file, right before the `</body>` end tag:

  ```twig
  {% hook 'chatra' %}
  ```
It's possible to override any of the [default settings](https://app.chatra.io/settings/general?enroll=&partnerId=eM2oGJzP3nzFXc4ua) in the template.

```twig
{% set chatraSettings = {
    startHidden: false,
    buttonPosition: 'lt',
    colors: {
        buttonText: '#f0f0f0',
        buttonBg: '#565656'
    }
} %}
```

## Roadmap

- Add Commerce stats (order #, LTV, etc.) to users

## Chatra Changelog

### 1.0.2 -- 2017.04.16

* Added section to send user messages through the CP

### 1.0.1 -- 2017.04.04

* Renamed `chatraId` to `publicApiKey`

### 1.0.0 -- 2017.04.02

* Initial release

Brought to you by [Superbig](https://superbig.co)
