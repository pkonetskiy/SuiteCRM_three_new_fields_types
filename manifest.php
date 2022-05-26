<?php
/*********************************************************************************
 * "Powered by BizForce"
 * BFtool new_Fields_types 1.0 2021-01-28
 *  
 ********************************************************************************/
$manifest = array (
    'readme' => '',
    'key' => 'BF',
    'author' => 'BizForce',
    'description' => 'Three new fields types add to Studio',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'BFtool new fields type',
    'published_date' => '2021-01-29',
    'type' => 'module',
    'version' => '1.0 alpha',
    'remove_tables' => 'prompt',
);
$installdefs = array (
    'id' => 'BFtool_Fields',
    'beans' => array (
        0 => array (
            'module' => 'BF_Dynamicbases',
            'class' => 'BF_Dynamicbases',
            'path' => 'modules/BF_Dynamicbases/BF_Dynamicbases.php',
            'tab' => false,
        ),
        1 => array (
            'module' => 'BF_Multi_Files',
            'class' => 'BF_Multi_Files',
            'path' => 'modules/BF_Multi_Files/BF_Multi_Files.php',
            'tab' => false,
        )
    ),
    'copy' => array (
        0 => array (
            'from' => '<basepath>/SugarModules/modules/BF_Dynamicbases',
            'to' => 'modules/BF_Dynamicbases',
        ),
        1 => array (
            'from' => '<basepath>/SugarModules/modules/BF_Multi_Files',
            'to' => 'modules/BF_Multi_Files',
        ),
        2 => array (
            'from' => '<basepath>/SugarModules/custom/include/SugarFields/Fields/Collection',
            'to' => 'custom/include/SugarFields/Fields/Collection',
        ),
        3 => array (
            'from' => '<basepath>/SugarModules/custom/include/SugarFields/Fields/Collection_files',
            'to' => 'custom/include/SugarFields/Fields/Collection_files',
        ),
        4 => array (
            'from' => '<basepath>/SugarModules/custom/include/SugarFields/Fields/Dynamicbase',
            'to' => 'custom/include/SugarFields/Fields/Dynamicbase',
        ),
        5 => array (
            'from' => '<basepath>/SugarModules/custom/include/SugarFields/Fields/Link_file',
            'to' => 'custom/include/SugarFields/Fields/Link_file',
        ),
        6 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/newCustomFields.php',
            'to' => 'custom/Extension/application/Ext/JSGroupings/newCustomFields.php',
        ),
        7 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/ActionFileMap',
            'to' => 'custom/Extension/application/Ext/ActionFileMap',
        ),
        8 => array (
            'from' => '<basepath>/SugarModules/custom/modules/DynamicFields/templates',
            'to' => 'custom/modules/DynamicFields/templates',
        ),
        9 => array (
            'from' => '<basepath>/SugarModules/custom/modules/DynamicFields/ConfigCollection.php',
            'to' => 'custom/modules/DynamicFields/ConfigCollection.php',
        ),
/*        10 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/Language/ru_RU.collection_files.php',
            'to' => 'custom/Extension/application/Ext/Language/ru_RU.collection_files.php',
        ),
        11 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/Language/en_us.collection_files.php',
            'to' => 'custom/Extension/application/Ext/Language/en_us.collection_files.php',
        ) */
    ),
    'language' => array (
        0 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/modules/DynamicFields/Ext/Language/ru_RU.customfields.php',
            'to_module' => 'DynamicFields',
            'language' => 'ru_RU',
        ),
        1 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/modules/DynamicFields/Ext/Language/en_us.customfields.php',
            'to_module' => 'DynamicFields',
            'language' => 'en_us',
        ),
        2 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/modules/ModuleBuilder/Ext/Language/ru_RU.customfields.php',
            'to_module' => 'ModuleBuilder',
            'language' => 'ru_RU',
        ),
        3 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/modules/ModuleBuilder/Ext/Language/en_us.customfields.php',
            'to_module' => 'ModuleBuilder',
            'language' => 'en_us',
        ),
        4 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/Language/ru_RU.new_fields_types.php',
            'to_module' => 'application',
            'language' => 'ru_RU',
        ),
        5 => array (
            'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/Language/en_us.new_fields_types.php',
            'to_module' => 'application',
            'language' => 'en_us',
        )
    ),
);