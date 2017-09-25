# Changelog
All notable changes to this project will be documented in this file.

##[10.0.2]

### Added

- Added Facebook Pixel Search

##[10.0.1]

### Added

- Cart update tracking (smart addFromCart and removeFromCart)
 
##[9.0.8]

###Added

 - Combined product detail views with Related/Upsells/Cross-Sell impressions

##[9.0.7]

###Added

- Mini Cart update tracking (smart addFromCart and removeFromCart)

##[9.0.6]

###Changed

- Cleanup

##[9.0.5]

###Changed

- Refactored DI() (more)

##[9.0.4]

###Changed

- Refactored DI()

##[9.0.3]

###Changed

 - Added explicit "Adwords Conversion Tracking" activating. All previous versions MUST enable it to continue using AdWords Conversion Tracking

##[9.0.2]

### Fixed

- Non-standard Facebook Pixel ViewCategory event
 
##[9.0.1] 

### Changed

### Fixed

- Unable to continue to Payment if license is invalid
- Removed AEC.checkoutStep() method and created AEC.Checkout() with step() and stepOption() methods

##[9.0.0] - 13.06.2017


## [8.0.9] - 07.06.2017

### Added

- controller_front_send_response_before listener to allow for response modification in FPC

## [8.0.8] - 07.06.2017

### Fixed

data-category attribute in "Remove from cart" event

## [4.0.3 - 8.0.7] - 07.06.2017

### Added

- Contact form submission tracking
- Newsletter submission tracking

## [4.0.3]

### Fixed

- Shipping and payment method options tracking for Magento 2.1.3+

## [4.0.2]

### Added

- Added custom cache for categories, minor improvements

## [2.0.8]

### Changed

- GTM snippet insertion approach to match the new splited GTM code. May affect older versions if upgraded.

## [2.0.1 - 2.0.3]

### Fixed

- Incorrect configuration readings in multi-store environment.

## [2.0.0]

### Added

- "Search results" impressions tracking.

## [1.0.9]

### Fixed

- Fixed bug(s) related to using both double and single quotes in product/category names