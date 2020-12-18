# Changelog

All notable changes to `buildy-wp` will be documented in this file

## 2.6.33

- Few more property checks/fixes

## 2.6.32

- Fix imageID not being removed from JSON (only image URL was)
- Went through everything and made sure there were no exceptions being thrown in WP_DEBUG anymore

## 2.6.30 - ## 2.6.31

- Add col-gap option to bmcb-settings

## 2.6.29

- Add col-gap root var by default bundled with buildy

## 2.6.28

- Remove camel case for data attributes (in js)
- Remove attributes from adding if they're '' and showing "false" if they're false

## 2.6.27

- Fix missing endif
- Fix autoplay setting in wrong spot

## 2.6.26

- Clean up slider options with toggles where appropriate

## 2.6.12 - ## 2.6.25

- Add slider module
- Improve UX of accordions (sliders, accordions, tabs)
- Add JS for slider
- Add basic styles for slider
- Add blade output for slider

## 2.6.11

- Add inline style attributes to common.blade so modules can use bg-image and options

## 2.6.10

- Swap col-gap to css variables -- We now have fine-grain control over column-gaps. Both globally and individually.

## 2.6.8 - 2.6.9

- Add "Button Class" to blurb buttons.

## 2.6.7

- Move conversion of module styles value to blade instead of JS (lowercase and hyphen)

## 2.6.4 - 2.6.6

- Fixing space select not allowing the value of 0
- Removing previous toubleshooting markers

## 2.6.3

- Adding troubleshooting markers for space select boxes to nail down an issue

## 2.6.2

- Small refactor to space select boxes

## 1.0.0 - 201X-XX-XX

- initial release
