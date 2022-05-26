# Change log

## [2.0.2](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/2.0.2) - 2022-05-26

### Security
- General testing to ensure compatibility with latest WordPress version (6.0)

## [2.0.1](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/2.0.1) - 2021-01-15

### Updated
- Documentation and Support links / text.

### Security
- General testing to ensure compatibility with latest WordPress version (5.6)

## [2.0.0](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/2.0.0) - 2020-11-04

### New Features

- WooCommerce Memberships Integration
- New Plans templates
- New Workouts templates
- New Exercises templates
- New Meals templates
- New Recipe templates
- Various Shortcodes
- WooCommerce Integration
- Multi-plan Functionality
- Integrate related blog posts on all Single HP pages
- Integrate LSX Team on all Single HP pages
- Integrate LSX Search on all archive templates
- Integrate LSX Sharing on Single Plans
- Add support for the LSX Customizer colour options [#124](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/124)
- Enable Hierarchical post types for plans, workouts & meals
- Update Plans, Meals, Workouts menus in WP-Admin
- Added support for the cover block on the Edit My Account page.

### Added

- Added support for the cover block on the Edit My Account page.
- Refactored the post type class locations.
- Added in settings to control the link destination, the content display and the columns of the grid layout.
- Added support for LSX color customizer.
- A "Connected Plans" FacetWP source was added which creates a connection to meals, recipes, workouts and exercises.
- Added default WP 5.5 lazy loading.
- Added support for multiple plans.
- Added support for multiple subscriptions.

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

### Security

- Updating dependencies to prevent vulnerabilities.
- Updating PHPCS options for better code.
- General testing to ensure compatibility with latest WordPress version (5.5).
- General testing to ensure compatibility with latest LSX Theme version (2.9).

### Settings

- Migrate settings to use CMB2
- Move the settings under Plans menu in WP-Admin
- Remove the LSX Search settings
- Move the search & filtering options to the LSX Search extension settings page

### My Plans

- My Plans Dashboard [#137](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/137)
- My Plans Account Details
- Add a section to "My Plans Account Details" for "My Stats" with a BMI Calculator
- Add a progress bar to the active plan and grey out inactive plans
- My Plan Weeks order not working [#131](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/131)
- My Plan - Title / URL Enhancements [#90](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/90)
- My Plan Weeks order not working [#131](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/131)

### Plans

- Plans Landing page [#140](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/140), [#141](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/141)
- Single Plan [#139](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/139], [#138](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/138)
- Plan main tab [#144](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/144)
- Workout tab [#146](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/146)
- Meal tab [#147](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/147)
- Warmup tab [#145](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/145)
- Add "Plan Type" custom taxonomy.
- Add support for LSX Sharing icons to display on a single plan
- Added in a setting to allow the translation of the `plan` single slug.
- Added tips for single plans.
- Updated layout.

### Meals

- Meals landing page archive template
- Integrate tips post type into meals
- Single Meal template with & without tips displaying
- Add support for LSX Search options and filtering to the Meals post type and taxonomy archives
- Added in a field to connected additional recipes for breakfast, lunch and dinner.
- Updated layout.

### Recipes

- Integrate tips post type into recipes
- Add support for LSX Search options and filtering to the Recipes post type and taxonomy archives
- Add Cuisines taxonomy & frontend templates
- Extend the current single recipe post type to display additional fields.
- Added placeholder image for recipes.
- Added tips for single recipes.
- Updated layout.

### Workouts

- Integrate tips post type into workouts
- Add support for LSX Search options and filtering to the Workouts post type and taxonomy archives
- Add Workout Type Category
- Enhance styling for workout singles [#106](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/106)
- Workout Single page [#119](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/119)
- Loading workouts does not save all fields from the exercise groups [#118](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/118)
- Workouts landing page [#121](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/121)
- Added a template for the single workout pages.
- Added in a connections box to allows news posts and pages to be attached to workouts.
- Added in settings to control the link destination, the content display and the columns of the grid layout.
- Added support and styling for a Grid and List views on the workout tab.
- Added tips for single workouts.
- Updated layout.

### Exercises

- Integrate tips post type into exercises
- Exercise Landing Page [#86](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/86)
- Exercise Taxonomy Landing (muscle group, equipment etc) [#87](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/87)
- Exercise - Single / Modal [#88](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/144)
- Add options to show full content, excerpt or no content for exercise modals [#130](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/130)
- Exercise Single page [#114](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/114)
- Workout Tab - Exercise layout options [#112](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/112)
- Items shortcode needs to be available when exercise is not active too #107](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/107)
- Exercise - Translations [#89](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/89)
- Add Items Shortcode [#92](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/92)
- Added in the exercise post type which connects to the workouts, this replaces the "video" post type.
- Added a "side" field for exercises that displays left, right or nothing if left blank.
- Added the exercise shortcode `lsx_health_plan_items`.
- Added tips for single exercises.
- Updated layout.

### WooCommerce Integration

- WC Membership - Restricted Content not restricted from REST + WP Query [#111](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/111)
- Single Plan Add to Cart Button
- WooCommerce Health Plan Product Type
- WooCommerce Plugin Integration [#154](https://github.com/lightspeeddevelopment/lsx-health-plan/issues/154)
- Single Plan "Add to Cart" or "Signup Now" Button

## [[1.3.0]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.3.0) - 2020-05-31

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

## [[1.3.0]](https://github.com/lightspeeddevelopment/lsx-health-plan/releases/tag/1.3.0) - 2020-02-20

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
