# The new fields for Studio of SuiteCRM 
>
> The project implements three new types of fields that are available on `EditView` or `DetailView` forms.
> - `Collection` - The block of fields which can be multiply on forms.
> - `Collection files` - The multiply load files on forms.
> - `Dynamicbase` - The one text which can be multiply on forms.
>

## Possibilities

You can use `Studio` for addition the fields to your system or custom module.

## Installation and configuration

1. Install the package through `Module Loader`.
2. The package don't have special configuration.

## Testing

The package was tested in SuiteCRM versions 7.10.x and 7.11.x . The package can be adopted to old versions, including SugarCRM.

## Using

Look at screenshots for details.
1. Check the messages after installation.
![Messages after installation](/screenshots/1.png)
2. New types of fields are avavailable  in `Studio`.
![New type of fields](/screenshots/2.png)
3. `Collection` type use (two screens).
![Collection type](/screenshots/3.png)
![Collection type](/screenshots/4.png)
4. `Collection files` type use.
![Collection files type](/screenshots/5.png)
5. `Dynamicbase` type use.
![Dynamicbase type](/screenshots/6.png)
6. Edit labels.
![Edit labels](/screenshots/7.png)
7. Add the fields to `Edit` or `Detail` to forms.
![Add the fields to form](/screenshots/8.png)
8. `EditView` form before addition of data.
![EditView before addition data](/screenshots/9.png)
9.  `EditView` form during data is being added.
![EditView addition data](/screenshots/10.png)
10. `DetailView` form after addition of data.
![DetailView after addition data](/screenshots/11.png)
11. `EditView` form after addition of data.
![EditView after addition data](/screenshots/12.png)

Before work with forms:
1. make "Quick Repair and Rebuild".
2. clean browser cache before open `EditView` or `DetailView` forms.

## Features

1. The package supports upgrade SuiteCRM versions because it uses standard methods for SuiteCRM only and it uses `custom` directory only.
2. It is recommended  to use custom modules for fields of `Collection` type.
3. You can use `Collection` with system modules but you will see the data in `ListView` of system module.
4. If you delete fields the data and files will not  be deleted from database and filesystem.
5. You can make some fields of one type on form.

## Progress

1. Add support `ListView` and `Search` forms.
2. Clean data after delete fields.
3. Add new types of fields.