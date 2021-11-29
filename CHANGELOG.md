# Changelog

## [1.0.4] - 2021-11-29

### Fixed
- Windows can't create dirs named `aux`, `prn`, `con`. Subdirs are now 2 chars long. Old: `xxx/xxxxxxxx.jpg`, New: `xx/xx/xxxxxxx.jpg`.

## [1.0.3] - 2021-11-22

### Fixed
- Loading images with http did not work with special chars in the url. The url is now escaped.
