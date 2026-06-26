# Changelog

All notable changes to `laravel-filament-activity-log` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.0.3] - 2026-06-26

### Added

- **Linked subject in the table and the view page.** The subject column in the activity table and the subject field on the view page now link to the related record's resource edit page. Resource-less child models can map the link onto a parent resource through the existing `HasCustomActivityResource` trait. Links are only rendered when a target can be resolved.
- **Diff section on the view page.** The activity view page now renders the model diff (old → new) in a dedicated "Changes" section, reusing the properties view. The section is hidden when the activity carries no diff.
- The `changes` translation key is now present in all shipped locales (previously only `en`, `es`, `fa`, `pt_BR`).
- Tests covering `getResourceUrl()` returning no link when the activity has no resolvable subject.

### Changed

- **The "Changes" table column is now visible by default.** Its visibility is controlled by the new `resources.hide_properties_column_by_default` config option (defaults to `false`); set it to `true` to restore the previous hidden-by-default behaviour.

## [v0.0.2] - 2026-06-26

### Fixed

- **Compatibility with `spatie/laravel-activitylog` v5.0.0.** Since Spatie v5.0.0, automatic model logging writes the diff to the new `attribute_changes` column and leaves `properties` empty. The plugin only read `properties`, so under v5 the activity timeline and the properties table column showed no changes, and the restore action found nothing to restore. The timeline, the properties column and the restore action now resolve the diff from `attribute_changes`, falling back to `properties` so Spatie v4 and manual `withProperties()` logs keep working.

### Changed

- The properties table column search now spans both the `attribute_changes` and `properties` columns, so model diffs remain searchable on both Spatie v4 and v5.

### Added

- A Pest/Testbench test suite covering the version-tolerant diff resolution and the cross-column search.

## [v0.0.1] - 2026-05-05

- Initial release: upgrade to Filament v5 and Spatie Activity Log v5.

[v0.0.3]: https://github.com/Bestora/laravel-filament-activity-log/compare/v0.0.2...v0.0.3
[v0.0.2]: https://github.com/Bestora/laravel-filament-activity-log/compare/v0.0.1...v0.0.2
[v0.0.1]: https://github.com/Bestora/laravel-filament-activity-log/releases/tag/v0.0.1
