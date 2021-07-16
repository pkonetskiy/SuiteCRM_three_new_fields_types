# Changed 16.07.2021
> Fixed big with default value in function `populateFromRow` of object `CustomTemplateCollection`.

# Changed 05.06.2021
> Fixed bug with field length.

# Changed 20.04.2021
>
> 2 small changes included.
>
> For field type `collection`:
> - Support sort by one field of table (only manually edit `editviewdefs.php` and `detailviewdefs.php`). See format below.
>
> For field type `collection` and `collection_files`:
> - Support different metadata for detail and edit forms which you can select in `view.datail.php` and `view.edit.php`.

## Support sort (part of `editviewdefs.php` or `detailviewdefs.php` file)

```
...
'lbl_panel_connects' => array (
    0 => array (
        0 => array (
            'name' => 'bf_connects',
            'label' => 'LBL_BF_CONNECTS_COLLECTION_DETAILVIEW',
            'type' => 'collection',
            'displayParams' => array (
                'collection_field_list' => array (
                    0 => array (
                        'name' => 'title',
                        'displayParams' => array (
                            'size' => '15%',
                            'sort'=>true,
                        ),
                    ),
...
```

# Changed 22.03.2021
>
> 3 small changes included.
>
> For field type `collection`:
> - Support `customCode` for each fields (only manually edit `editviewdefs.php`). See format below.
> - Support `Duplicate` button.
>
> For field type `collection` and `collection_files`:
> - Change cache directory for support `Quick repair and rebuild`.
>

## Support `customCode`

'customCode' => '<input type=\\"text\\" size=\\"10px\\" class=\\"sugar_field\\" name=\\"field_name\\" id=\\"field_name\\" readonly=\\"readonly\\">',

!Attention - Using symbol backslash (\\) is required for quotes.
