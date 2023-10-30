# Change log

## [[1.4.0]] - Unreleased

### Added

- Extend the current single recipe post type to display additional fields.
- Added placeholder image for recipes.
- Added in a connections box to allows news posts and pages to be attached to workouts.
- Added in a setting to allow the translation of the `plan` single slug.
- Added in the exercise post type.
- Added the exercise shortcode `lsx_health_plan_items`.
- Added support for the cover block on the Edit My Account page.
- Added support and styling for a Grid and List views on the workout tab.
- Added a "side" field for exercises that displays left, right or nothing if left blank.
- Refactored the post type class locations.
- Added in settings to control the link destination, the content display and the columns of the grid layout.
- Added a template for the single workout pages.
- Added support for LSX color customizer.

### Updated

- Updated the translation files.
- Updated the options for the workout grids, to have excerpts or full text for each exercise modal.

### Changed

- Changed the styling for the single exercise image depending if it is a slider of a gallery or a single image.

### Fixed

- Added in a statement to to check a video exists before outputting the video play button.
- Thumbnail sizes for all archive and shortcodes are improved.

### Removed

- "View Cart" Message removed on Checkout.

## [[1.3.1]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.3.1) - 2020-03-31

### Added

- New checkout page with simplified design.
- Adding new `lsx-hp-simple-checkout` body class if its the checkout page.

### Fixed

- Adding in Fix to translate breadcrumbs if endpoints where translated.
- Fixed issue `Undefined variable: intro_text`.
- Fixed issue `Undefined variable: post_id`.
- Fixed banner for the Lost Password page.
- Fixed the login/logout links on the tab and menu.

### Security

- Updating dependencies to prevent vulnerabilities.
- General testing to ensure compatibility with latest WordPress version (5.4).
- General testing to ensure compatibility with latest LSX Theme version (2.7).

## [[1.3.0]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/untagged-5ce7408d3f5c6aaeda32) - 2020-02-20

### Added

- Separated the "Snack" boxes from the Meal Plan columns.
- Added in an archive description field for the recipes post type archive.
- Integrated the recipes archive with the LSX Search plugin.
- Added in the structure and styling for the Recipes Type taxonomy to match the post type archive.
- Added a `show_downloads` parameter to the weekly plan shortcode, which displays a list of the downloads added to the downloads category.
- Refactored single plan tabs and the tab output, so they are passed through filters to allow 3rd Party changes.
- Design Updates to Recipes Cards.
- Download button on the workout tab will only appear if there is a pdf attached.
- Adding Pre Workout Snack and the Recovery Snack to Workout.

### Fixed

- Fixed the un-prefixed functions
- Refactored the recipes functions
- Changing all the kg's and cm's in the detail boxes to just kg and cm (no plural).
- Making sure the wrapper for the tip carousel doesn't output if there are not tips assigned.
- Fixed the integration with CMB2, and detecting when it is active.
- Pre and Post workout snack titles can be translated individually.

## [[1.2.0]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.2) - 2019-12-19

### Added

- Added in translatable endpoint settings.
- Added in placeholder image for Tips.
- Improved the search results for Health Plan items.
- Added in Settings to assign a default workout, recipe, warm up and meal type post.
- Adding in a setting to assign the default post type connections.
- General testing to ensure compatibility with latest WordPress version (5.3).
- Checking compatibility with LSX 2.6 release.

### Fixed

- Spacing and margins fixes in general.
- Styling fixes for the Daily Plan list on tablet view.
- Changed the setting id to mimic the meta_key, and added in a check for `hs_attachment`.
- Made sure that connected ids in the "trash" do not show.

## [[1.1.1]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.1.1) - 2019-10-30

### Fixed

- Added in a function to filters downloads that do not exist.
- Applied the_content filters to the meal plan paragraphs and the workouts text #18.
- Fixed the string translations.

## [[1.1.0]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.1) - 2019-10-23

### Added

- Added drag-able Days in the back-end to re-order them #16.

### Fixed

- Day Ordering.
- HTML not displaying on Workouts.
- Updated placeholder text in fields on profile #10 & #9.
- Video modal not closing on mobile devices #13.
- Tips images distorting.

## [[1.0.5]]()

### Fixed

- Placeholder for Waist changed to cm on Edit Account Page.
- Added a space between the value to make it neater and also change the Kg's to kg on my account page.

## [[1.0.4]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.0.4) - 2019-09-13

### Added

- Activating github actions.

### Fixed

- Downloads box will not have duplicated links.
- Removing the display non for the EFT page.
- Added in Fix for Recipe details on Mobile View.

## [[1.0.3]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.0.3) - 2019-08-23

### Added

- Removed Peach Payments and added in Payfast on Checkout.

### Fixed

- Removed unnecessary link on Tips.

## [[1.0.2]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.0.1.2) - 2019-08-07

### Added

- Dev - Changing icons to be inline svgs.

### Fixed

- Fixing the week view order to be by date.
- Recipes and shopping list box only appear if they are not empty on the Meal Plan Tab.

## [[1.0.1]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.0.1) - 2019-08-05

### Fixed

- Style fixes and improvements on desktop and mobile.

## [[1.0.0]]()

### Added

- Initial release
