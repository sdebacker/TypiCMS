# Changelog
All notable changes to TypiCMS will be documented in this file.

## 1.8.8 - 2014-08-

### Added
- Sitemap generator.
- Classes for route filters: Public, Admin and Users.
- Cleaner layout on small screens for login/register/… form views.

### Removed
- Method byUri is now getFirstByUri.

## 1.4.7 - 2014-08-20

### Added
- New gulp task: all.
- Default gulp task now only launch watching of less/js files.
- CHANGELOG.md file.
- .doc, .xls and .ppt are uploadable.

### Deprecated
- Nothing.

### Removed
- Gulp-plumber removed.

### Fixed
- Nothing.
- Small changes in forms.

## 1.4.6 - 2014-08-19

### Added
- Categories can now be children of a menu item.
- Helpers class removed, it is now a simple helpers.php file.

### Deprecated
- Nothing.

### Removed
- Nothing.

### Fixed
- Way/Generators added to local providers

## 1.4.5 - 2014-08-14

### Added
- New relic code in app/start/global.php.
- small tag added to TinyMCE.
- docx, xlsx, pptx, ppsx et sldx are now uploadable.

### Deprecated
- Nothing.

### Removed
- syncGalleries method replaced by more generic syncRelations.

### Fixed
- Small css improvements
