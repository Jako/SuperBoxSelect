<?php
/**
 * Default Lexicon Entries for SuperBoxSelect
 *
 * @package superboxselect
 * @subpackage lexicon
 */
$_lang['superboxselect'] = 'SuperBoxSelect';
$_lang['superboxselect.allowedUsergroups'] = 'Allowed Usergroups';
$_lang['superboxselect.allowedUsergroups_desc'] = 'Comma-separated list of allowed usergroups';
$_lang['superboxselect.className'] = 'Class Name';
$_lang['superboxselect.className_desc'] = 'Class name of the xPDO object the data is retrieved from. Use the fully qualified class name, e.g. MyNamespace\MyPackage\MyClass depending on the xPDO package.';
$_lang['superboxselect.customtable'] = 'Custom Table';
$_lang['superboxselect.deniedUsergroups'] = 'Denied Usergroups';
$_lang['superboxselect.deniedUsergroups_desc'] = 'Comma-separated list of denied usergroups';
$_lang['superboxselect.fieldTpl'] = 'Field Template';
$_lang['superboxselect.fieldTpl_desc'] = 'Field template for the SuperBoxSelect (could contain html tags). Default: <code>{title} ({id})</code>.';
$_lang['superboxselect.maxElements'] = 'Max. Elements';
$_lang['superboxselect.maxElements_desc'] = 'Maximum number of elements in the list. 0 means no limit';
$_lang['superboxselect.maxElements_label'] = 'max. {maxElements}';
$_lang['superboxselect.maxElements_msg'] = 'Reached maximum number of elements.';
$_lang['superboxselect.packageName'] = 'Package Name';
$_lang['superboxselect.packageName_desc'] = 'Package name of the xPDO package. Not needed in MODX 3.x for packages with a bootstrap.php or for MODX 2.x extension packages.';
$_lang['superboxselect.pageSize'] = 'Page Size';
$_lang['superboxselect.pageSize_desc'] = 'If the page size is greater than 0, a pagination is displayed in the footer of the dropdown list.';
$_lang['superboxselect.resources'] = 'Resources';
$_lang['superboxselect.resourceTitleTpl'] = 'Resource Title Template';
$_lang['superboxselect.resourceTitleTpl_desc'] = 'Resource title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings. Default: <code>@INLINE [[+pagetitle]]</code>.';
$_lang['superboxselect.selectedFields'] = 'Selected Fields';
$_lang['superboxselect.selectedFields_desc'] = 'Comma-separated list of fields to select from the table. You do not have to add the primary key field, it is always selected. You can use these fields in the field template and sorting column. The first field is automatically used for the sorting.';
$_lang['superboxselect.selectType'] = 'Type';
$_lang['superboxselect.selectType_desc'] = 'Content type of the dropdown list.';
$_lang['superboxselect.sortBy'] = 'Sort By';
$_lang['superboxselect.sortBy_desc'] = 'The name of the column, the SuperBoxSelect list is sorted by. Default: pagetitle for resource input type, username for user input type.';
$_lang['superboxselect.sortDir'] = 'Sort Dir';
$_lang['superboxselect.sortDir_desc'] = 'The direction, the SuperBoxSelect list is sorted by. Default: Ascending.';
$_lang['superboxselect.stackItems'] = 'Stack Items';
$_lang['superboxselect.stackItems_desc'] = 'If enabled, the SuperBoxSelect items will be stacked one per line. Per default the items are displayed inline.';
$_lang['superboxselect.users'] = 'Users';
$_lang['superboxselect.userTitleTpl'] = 'User Title Template';
$_lang['superboxselect.userTitleTpl_desc'] = 'User title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings. Default: <code>@INLINE [[+username]]</code>.';
