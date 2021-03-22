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
