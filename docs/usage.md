## Input Options

The following input options can be set in the template variable settings:

| Setting                  | Key                 | Description                                                                                                                                                                                                                                    | Default                |
|--------------------------|---------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------|
| Allow Blank              | allowBlank          | If set to No, MODX will not allow the user to save the Resource until a valid value has been selected.                                                                                                                                         | Yes                    |
| Allowed Usergroups       | allowedUsergroups   | **(Type = Users)** Comma separated list of allowed usergroups.                                                                                                                                                                                 | -                      |
| Denied Usergroups        | deniedUsergroups    | **(Type = Users)** Comma separated list of denied usergroups.                                                                                                                                                                                  | -                      |
| Depth                    | depth               | **(Type = Resources)** The levels deep that the query to grab the list of Resources will go.                                                                                                                                                   | 10                     |
| Field Template           | fieldTpl            | **(System setting superboxselect.advanced = active)** Field template for the SuperBoxSelect (can contain html tags).                                                                                                                           | {title} ({id})         |
| Limit to Related Context | limitRelatedContext | **(Type = Resources)** If Yes, will only include the Resources related to the context of the current Resource.                                                                                                                                 | No                     |
| Max. Elements            | maxElements         | Maximum number of elements in the list. 0 means no limit                                                                                                                                                                                       | 0                      |
| Page Size                | pageSize            | If the page size is greater than 0 and max. elements is 1, a pagination is displayed in the footer of the dropdown list.                                                                                                                       | 10                     |
| Parents                  | parents             | **(Type = Resources)** A list of IDs to grab children for the list.                                                                                                                                                                            | -                      |
| Resource Title Template  | resourceTitleTpl    | **(System setting superboxselect.advanced = active AND Type = Resources)** Resource title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings.                                                                                    | @INLINE [[+pagetitle]] |
| Sort By                  | sortBy              | The name of the column, the SuperBoxSelect list is sorted by. Default: pagetitle for resource input type, username for user input type.                                                                                                        |                        |
| Sort Dir                 | sortDir             | The direction, the SuperBoxSelect list is sorted by.                                                                                                                                                                                           | Ascending              |
| Stack Items              | stackItems          | If enabled, the SuperBoxSelect items will be stacked one per line. Per default the items are displayed inline.                                                                                                                                 | No                     |
| Type                     | selectType          | Content type of the dropdown list.                                                                                                                                                                                                             | Resources              |
| Use Request Values       | useRequest          | Use request values in the SuperBoxSelect getlist processor. Per default the template variable input options are used.                                                                                                                          | No                     |
| User Title Template      | userTitleTpl        | **(System setting superboxselect.advanced = active AND Type = Users)** User title template for the SuperBoxSelect. Can use @FILE, @INLINE bindings.                                                                                            | @INLINE [[+username]]  |
| Where Conditions         | where               | **(Type = Resources)** A JSON object of where conditions to filter by in the query that grabs the list of Resources. (Does not support TV searching.) Examples: `[{"template:=":"4"}]`, `[{"pagetitle:!=":"Home"}]`, `[{"parent:IN":[34,56]}]` | []                     |

## MIGX usage

To use a SuperBoxSelect in `inputTVtype`, you have to add the follwing values in a MIGX edit raw formtabs field (the
JSON in the configs part can be pasted into the Field Configs textarea, when the formtabs field is edited normally):

```json
"inputTVtype": "superboxselect",
"configs": {
    "allowBlank": "1",
    "allowedUsergroups": "",
    "deniedUsergroups": "",
    "depth": "10",
    "fieldTpl": "{title} ({id})",
    "limitRelatedContext": "0",
    "maxElements": "0",
    "pageSize": "10",
    "parents": "",
    "resourceTitleTpl": "@INLINE [[+pagetitle]]",
    "sortBy": "pagetitle",
    "sortDir": "ASC",
    "stackItems": "0",
    "selectType": "resources",
    "useRequest": "1",
    "userTitleTpl": "@INLINE [[+username]]",
    "where": "[]"
},
```


