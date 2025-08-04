# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.1.2] - TBA

### Fixed

- Fix searching for a zero in the search fields, when the query does not contain an integer

## [3.1.1] - 2025-06-11

### Fixed

- Fix the Custom Table select type processor in MODX 3 only packages
- Fix the resource title template staying empty in some conditions

## [3.1.0] - 2025-05-24

### Added

- Add Custom Table select type - thanks to Matic Šulc (https://github.com/MaticSulc)
- Allow searching parts of the ID [#41]

### Fixed

- Fix paging of results is broken [#42]

## [3.0.7] - 2022-06-17

### Fixed

- Fix editing template variable properties in MODX 3.0.1

## [3.0.6] - 2022-05-18

### Added

- sortBy and sortDir for custom sorting of the SuperboxSelect rows

### Fixed

- Fix limitRelatedContext property for the resource list

## [3.0.5] - 2022-05-17

### Added

- resourceTitleTpl and userTitleTpl for custom title in the SuperboxSelect row

## [3.0.4] - 2022-03-23

### Fixed

- Fix removing plugin events

## [3.0.3] - 2022-02-12

### Fixed

- Fix not allowed maxElements = 0

## [3.0.2] - 2022-02-05

### Fixed

- Fix OnDocFormRender was not found!

## [3.0.1] - 2021-01-20

### Fixed

- Fix compatibility with MIGX inputTVtype

## [3.0.0] - 2022-01-07

### Added

- Extend external select types with plugins 

### Changed

- Code refactoring
- Full MODX 3 compatibility

### Removed

- selectPackage option to add external select types

## [2.4.2] - 2021-02-08

### Changed

- Fix retrieving resrources from a different context deeper than one level [#24].
- Prevent E_NOTICE errors from smarty.
- Fix drag & drop issues [#25].

## [2.4.1] - 2020-08-26

### Fixed

- Fix not working boolean template variable options [#23].

## [2.4.0] - 2020-03-22

### Added

- Allow other values to be saved in the SuperBoxSelect than the resource id

### Fixed

- Restore pageSize for multi selects disabled in SuperBoxSelect 2.3.8
- Fix showing 'The changes you made may not be saved' alert, even when the SuperBoxSelect value was not changed.

## [2.3.8] - 2020-01-28

### Fixed

- Fix a limit/pageSize issue

## [2.3.7] - 2020-01-14

### Fixed

- Fix autocomplete is not working on user list

## [2.3.6] - 2020-01-04

### Fixed

- Fix sorting of user selector [#15]. Thanks to @hugopeek

## [2.3.5] - 2019-10-19

### Fixed

- Fix an issue that stack items option can't be disabled

## [2.3.4] - 2019-09-29

### Changed

- Update Sortable.js to 1.10.0 to fix drag & drop ordering

## [2.3.3] - 2019-05-06

### Fixed

- Fix drag & drop ordering after deleting a list element

## [2.3.2] - 2019-04-27

### Fixed

- Fix an issue, when an external package does not exist
- Fix drag & drop ordering

## [2.3.1] - 2019-03-20

### Changed

- Use less space in input options
- 
### Fixed

- Fix input options for MODX Revolution 2.7+

## [2.3.0] - 2019-02-17

### Added

- Enable stacking of the SuperBoxSelect values per template variable option

## [2.2.2] - 2017-02-03

### Fixed

- Fixing limit to related context option

## [2.2.1] - 2017-01-29

### Fixed

- Fixing disabling the pagination

## [2.2.0] - 2016-12-21

### Added

- Sort the items by drag & drop

## [2.1.2] - 2016-10-13

### Fixed

- Fix backwards compatibility issue

## [2.1.1] - 2016-10-11

### Fixed

- Fix single value combo not saving the value

## [2.1.0] - 2016-09-08

### Added

- The superboxselect is not restricted anymore to list only resources
- Single value
- Two default select types (resources, users)
- Add own package based select types

## [2.0.0] - 2016-06-27

### Added

- Input options for template variables
- Pagination of the superboxselect
- Maximum number of selectable resources
- Lexicon
- Complete refactored code
- Strictly separate the extra folders from the MODX core

## [1.0.1-pl2] - 2012-06-16

### Fixed

- Fix fetch resource bug

## [1.0.1-pl1] - 2012-06-16

### Fixed

- Fix height component to display properly multiple rows

## [1.0.1-rc2] - 2012-02-01

### Fixed

- Fix installation when manager directory name was changed

## [1.0.1-rc1] - 2012-01-11

### Changed

- Refactor for MODx Revo 2.2

## [1.0.0-rc1] - 2011-11-16

### Changed

- Packaged for Revo
- Use Ext JS SuperBoxSelect type included in MODx Revolution

## [1.0.0-b1] - 2011-11-01

### Added

- Initial Version
