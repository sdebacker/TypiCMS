# HTMLObject

## 1.4.0

- Added `TreeObject::prepend` and `TreeObject::append` to set childs before/after other children
- Fixed case where `nest` would create invalid tags from strings

## 1.3.0

- Added `Table` element
- Fixed a bug in the rendering of children

## 1.2.0

- Children are now rendered via their `render` method instead of toString
- Added Tag::removeAttribute

## 1.1.2

- Bugfixes

## 1.1.1

- Fixed a bug in classes removing

## 1.1.0

- Allow camelCased setting of attributes
- Fix a bug in numerical attributes (min, max, etc)
- Fix JSON attributes being encoded on rendering
- Allow flat fetching of children (ie. ignore dot notation)
- Added `getAttribute` method

## 1.0.0

- Initial release