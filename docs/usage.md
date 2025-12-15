## Input Options

The following input options can be set in the template variable settings:

| Setting                  | Key                 | Description                                                                                                                                                                                                                                                                       | Default                |
|--------------------------|---------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------|
| Allow Blank              | allowBlank          | If set to No, MODX will not allow the user to save the Resource until a valid value has been selected.                                                                                                                                                                            | Yes                    |
| Allowed Usergroups       | allowedUsergroups   | **(Type = Users)** Comma-separated list of allowed usergroups.                                                                                                                                                                                                                    | -                      |
| Class Name               | className           | **(Type = Custom Table)** Class name of the xPDO object the data is retrieved from. Use the fully qualified class name, e.g. MyNamespace\MyPackage\MyClass depending on the xPDO package.                                                                                         | No                     |
| Denied Usergroups        | deniedUsergroups    | **(Type = Users)** Comma-separated list of denied usergroups.                                                                                                                                                                                                                     | -                      |
| Depth                    | depth               | **(Type = Resources)** The levels deep that the query to grab the list of Resources will go.                                                                                                                                                                                      | 10                     |
| Field Template           | fieldTpl            | **(System setting superboxselect.advanced = active)** Field template for the SuperBoxSelect (can contain html tags).                                                                                                                                                              | {title} ({id})         |
| Force Selection to List  | forceSelection      | If this is set to Yes, only items already in the list are allowed. If No, new values can be entered a well.                                                                                                                                                                       | No                     |
| Limit to Related Context | limitRelatedContext | **(Type = Resources)** If Yes, will only include the Resources related to the context of the current Resource.                                                                                                                                                                    | No                     |
| Max. Elements            | maxElements         | Maximum number of elements in the list. 0 means no limit                                                                                                                                                                                                                          | 0                      |
| Package Name             | packageName         | **(Type = Custom Table)** Package name of the xPDO package. Not needed in MODX 3.x for packages with a bootstrap.php or for MODX 2.x extension packages.                                                                                                                          | No                     |
| Page Size                | pageSize            | If the page size is greater than 0, a pagination is displayed in the footer of the dropdown list.                                                                                                                                                                                 | 10                     |
| Parents                  | parents             | **(Type = Resources)** A list of IDs to grab children for the list.                                                                                                                                                                                                               | -                      |
| Resource Title Template  | resourceTitleTpl    | **(System setting superboxselect.advanced = active AND Type = Resources)** Resource title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings.                                                                                                                       | @INLINE [[+pagetitle]] |
| Selected Fields          | selectedFields      | **(Type = Custom Table)** Comma-separated list of fields to select from the table. You do not have to add the primary key field, it is always selected. You can use these fields in the field template and sorting column. The first field is automatically used for the sorting. | No                     |
| Sort By                  | sortBy              | The name of the column, the SuperBoxSelect list is sorted by. Default: pagetitle for resource input type, username for user input type.                                                                                                                                           |                        |
| Sort Dir                 | sortDir             | The direction, the SuperBoxSelect list is sorted by.                                                                                                                                                                                                                              | Ascending              |
| Stack Items              | stackItems          | If enabled, the SuperBoxSelect items will be stacked one per line. Per default the items are displayed inline.                                                                                                                                                                    | No                     |
| Type                     | selectType          | Content type of the dropdown list.                                                                                                                                                                                                                                                | Resources              |
| User Title Template      | userTitleTpl        | **(System setting superboxselect.advanced = active AND Type = Users)** User title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings.                                                                                                                               | @INLINE [[+username]]  |
| Where Conditions         | where               | **(Type = Resources)** A JSON object of where conditions to filter by in the query that grabs the list of Resources. (Does not support TV searching.) Examples: `[{"template:=":"4"}]`, `[{"pagetitle:!=":"Home"}]`, `[{"parent:IN":[34,56]}]`                                    | []                     |

## MIGX usage

To use a SuperBoxSelect in `inputTVtype`, you have to add the follwing values in a MIGX edit raw formtabs field (the
JSON in the configs part can be pasted into the Field Configs textarea, when the formtabs field is edited normally):

```json
"inputTVtype": "superboxselect",
"configs": {
    "allowBlank": "1",
    "allowedUsergroups": "",
    "className": "",
    "deniedUsergroups": "",
    "depth": "10",
    "fieldTpl": "{title} ({id})",
    "forceSelection": "0",
    "limitRelatedContext": "0",
    "maxElements": "0",
    "packageName": "",
    "pageSize": "10",
    "parents": "",
    "resourceTitleTpl": "@INLINE [[+pagetitle]]",
    "selectedFields": "",
    "sortBy": "pagetitle",
    "sortDir": "ASC",
    "stackItems": "0",
    "selectType": "resources",
    "userTitleTpl": "@INLINE [[+username]]",
    "where": "[]"
},
```

## System Settings

SuperBoxSelect uses the following system settings in the namespace `superboxselect`:

| Key                     | Name     | Description                                         | Default |
|-------------------------|----------|-----------------------------------------------------|---------|
| superboxselect.advanced | Advanced | Display advanced TV settings (i.e. Field Template). | No      |
| superboxselect.debug    | Debug    | Log debug information in the MODX error log.        | No      |
