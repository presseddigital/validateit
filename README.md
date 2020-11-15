<p align="left"><a href="https://github.com/presseddigital/validateit" target="_blank"><img width="100" height="100" src="resources/img/validateit.svg" alt="Validateit"></a></p>

# Validateit plugin for Craft 3

Supercharged text field validation...

> :mega: **A note from the new (well sort of new) owners Pressed Digital:** At the end of 2019 Fruit Studios Ltd was sold to allow it's founders to shift 100% of their focus to the, now not so side project, findarace.com. As a part of the deal we retained ownership of all Craft plugins and are committed to make them even more awesome. With findarace.com being all Craft, this aligns really nicely, and as a little silver lining we should now finally have some time to launch some of our unreleased plugins!

### Requirements

This plugin requires Craft CMS 3.0.0 or later.

### Installation

To install the plugin, follow these steps:

1.  Install with Composer via:

    composer require presseddigital/validateit

2.  In the Control Panel, go to Settings → Plugins and click the “Install” button for Validateit.

## Validateit Overview

This plugin adds a custom fieldtype which allows you to take control of validation on plain text fields. Validate using the following predefined strings or setup your own custom regex rules. Add custom placeholders and error messages.

1.  Email Address
2.  URL
3.  Phone Number
4.  IP Address
5.  IPv4 Address
6.  IPv6 Address
7.  Facebook Link
8.  Twitter Link
9.  LinkedIn Link
10. Instagram Link
11. Custom Regex Rule

## Configuring Validateit

Once installed, create a new field and choose the Validateit fieldtype. You'll then have the option of configuring how you want to validate the text.

<p align="left"><img width="450px" src="resources/img/configure.png" alt="Configure Validateit"></a></p>

Each field has the option to set a custom placeholder and error message

<p align="left"><img width="450px" src="resources/img/settings.png" alt="Setup Validateit"></a></p>

Custom regex rules allow you to validate any string

<p align="left"><img width="450px" src="resources/img/regex.png" alt="Regex with Validateit"></a></p>

## Using Validateit

Use just as you would any native Plain Text field:

    {{ entry.validateitFieldHandle }}

## Roadmap

If you have any super useful validation rules shout and we can look to add them to the core plugin for everyone to use.

*   [ ] Show default error message and placeholder text in field settings.

Brought to you by [Pressed Digital](https://pressed.digital)
