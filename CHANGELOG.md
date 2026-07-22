# Changelog


## [1.1.1] - 2026-07-22

### Fixed

- Re-release of version 1.1.0 due to packaging/tagging issue.

## [1.1.0] - 2026-07-22

### Added

- Automatic loading of package migrations using `loadMigrationsFrom()`
- Database index on `shetabit_visits.created_at`

### Improved

- Better dashboard performance when filtering statistics by date range

## [1.0.3] - 2026-05-27
### Changed
- Removed temporary constraint on `mobiledetect/mobiledetectlib`.
- Updated to latest compatible version of `shetabit/visitor`

## [1.0.2] - 2026-05-05
### Fixed
- Temporarily constrained `mobiledetect/mobiledetectlib` to `<4.9` to prevent
  a PHP 8.1+ fatal error caused by a method signature incompatibility
  in `shetabit/visitor` 4.x.

## [1.0.1] - 2025-12-19
### Fixed
- Use the configured user attribute consistently across the package.

## [1.0.0] - 2025-12-15
- First stable release
- Dashboard, filters, CSV export, charts, browser/device stats
- Localization EN/FR
