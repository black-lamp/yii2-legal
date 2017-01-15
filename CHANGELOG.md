black-lamp/yii2-legal-agreement commits history
------------------------------------------

## [Under development]

### Added
- Added new action to frontend controller
- Added event `EVENT_AFTER_ACCEPT` to `LegalManager` component
- Added `key` column to `Legal` entity
- (#1) Added TinyMCE instead textarea
- Added config language provider
- Added flash message for actions in frontend module
- Added `getByKey()` method to `LegalManager` component

### Changed
- `LegalAgreement` component renamed to `LegalManager`
- Refactored code

### Removed
- Removed `User` behavior
- Removed SEO data
- Removed `LegalType`, `LegalTypeTranslation` entities
- Removed `sendToEmail` method in `LegalManager` component

### Fixed
- (#3) Fixed bug with saving translations

## [1.0.0] - 2016-11-24

- First stable version

## [1.0.2-beta] - 2016-10-04

- Fixed bug with MySQL

## [1.0.1-beta] - 2016-10-03

- Fixed bugs

## [1.0.0-beta] - 2016-10-03

- First beta version of module

## [Development started] - 2016-09-28