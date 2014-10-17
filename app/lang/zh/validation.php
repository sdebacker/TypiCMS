<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "The :属性必须被接受。",
    "active_url"       => "The :属性不是一个有效的URL。",
    "after"            => "The :attribute must be a date after :date.",
    "alpha"            => "The :attribute may only contain letters.",
    "alpha_dash"       => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num"        => "The :attribute may only contain letters and numbers.",
    "array"            => "The :attribute must be an array.",
    "before"           => "The :attribute must be a date before :date.",
    "between"          => array(
        "numeric" => "The :attribute must be between :min - :max.",
        "file"    => "The :attribute must be between :min - :max kilobytes.",
        "string"  => "The :attribute must be between :min - :max characters.",
        "array"   => "The :attribute must have between :min - :max items.",
    ),
    "confirmed"        => "The :attribute confirmation does not match.",
    "date"             => "The :attribute is not a valid date.",
    "date_format"      => "The :attribute does not match the format :format.",
    "different"        => "The :attribute and :other must be different.",
    "digits"           => "The :attribute must be :digits digits.",
    "digits_between"   => "The :attribute must be between :min and :max digits.",
    "email"            => "The :attribute format is invalid.",
    "exists"           => "The selected :attribute is invalid.",
    "image"            => "The :attribute must be an image.",
    "in"               => "The selected :attribute is invalid.",
    "integer"          => "The :attribute must be an integer.",
    "ip"               => "The :attribute must be a valid IP address.",
    "max"              => array(
        "numeric" => "The :attribute may not be greater than :max.",
        "file"    => "The :attribute may not be greater than :max kilobytes.",
        "string"  => "The :attribute may not be greater than :max characters.",
        "array"   => "The :attribute may not have more than :max items.",
    ),
    "mimes"            => "The :attribute must be a file of type: :values.",
    "min"              => array(
        "numeric" => "The :attribute must be at least :min.",
        "file"    => "The :attribute must be at least :min kilobytes.",
        "string"  => "The :attribute must be at least :min characters.",
        "array"   => "The :attribute must have at least :min items.",
    ),
    "not_in"           => "The selected :attribute is invalid.",
    "numeric"          => "The :attribute must be a number.",
    "regex"            => "The :attribute format is invalid.",
    "required"         => "The :attribute field is required.",
    "required_if"      => "The :attribute field is required when :other is :value.",
    "required_with"    => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "same"             => "The :attribute and :other must match.",
    "size"             => array(
        "numeric" => "The :attribute must be :size.",
        "file"    => "The :attribute must be :size kilobytes.",
        "string"  => "The :attribute must be :size characters.",
        "array"   => "The :attribute must contain :size items.",
    ),
    "unique"           => "The :attribute has already been taken.",
    "url"              => "The :attribute format is invalid.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
        // General
        'name' => 'Name',
        'username' => 'Username',
        'password' => 'Password',
        'age' => 'Age',
        'sex' => 'Sex',
        'gender' => 'Gender',
        'day' => 'Day',
        'month' => 'Month',
        'year' => 'Year',
        'hour' => 'Hour',
        'minute' => 'Minute',
        'second' => 'Second',
        'title' => 'Title',
        'websiteTitle' => 'Website title',
        'content' => 'Content',
        'description' => 'Description',
        'excerpt' => 'Excerpt',
        'date' => 'Date',
        'time' => 'Time',
        'available' => 'Available',
        'size' => 'Size',
        'slug' => 'Slug',
        'url' => 'URL',
        'body' => 'Body',
        'meta_keywords' => 'Meta keywords',
        'meta_title' => 'Meta title',
        'meta_description' => 'Meta description',
        'summary' => 'Summary',
        'uri' => 'Uri',
        'online' => 'Online',
        'status' => 'Status',

        // Contacts
        'created_at' => 'Created at',
        'email' => 'Email',
        'mr' => 'Mr',
        'mrs' => 'Mrs',
        'website' => 'Website',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'company' => 'Company',
        'city' => 'City',
        'country' => 'Country',
        'address' => 'Address',
        'postcode' => 'Post code',
        'phone' => 'Phone',
        'mobile' => 'Mobile',
        'fax' => 'Fax',
        'language' => 'Language',
        'message' => 'Message',
        'send' => 'Send',
        'generate' => 'Generate',

        // Pages
        'rss_enabled' => 'Rss enabled',
        'comments_enabled' => 'Comments enabled',
        'is_home' => 'Is home',
        'template' => 'Template',
        'css' => 'Css',
        'js' => 'Js',

        // Places
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'fax' => 'Fax',
        'info' => 'Info',
        'Show on map' => 'Show on map',
        'category_id' => 'Category',
        'info' => 'Info',

        // Partners
        'logo' => 'Logo',
        'homepage' => 'On homepage',

        // Events
        'start_date' => 'Start date',
        'end_date' => 'End date',
        'start_time' => 'Start time',
        'end_time' => 'End time',
        'HH:MM' => 'HH:MM',
        'DDMMYYYY' => 'DD.MM.YYYY',
        'DDMMYYYY HHMM' => 'DD.MM.YYYY HH:MM',

        // Projects
        'category_id' => 'Category',

        // Mots-clés
        'tags' => 'Tags',
        'tag' => 'Tag',
        'uses' => 'Uses',

        // Menulinks
        'page_id' => 'Page',
        'menu_id' => '菜单',
        'module_name' => '模块名称',
        'target' => '目录',
        'class' => 'Class',
        'icon_class' => 'Icon class',
        'restricted_to' => 'Restricted to',
        'link_type' => '链接类型',
        'has_categories' => 'Show categories',
        'side' => 'Side',
        'Front office' => 'Front office',
        'Back office' => 'Back office',

        // Users
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'groups' => '组',
        'email' => '邮箱',
        'password' => '密码',
        'password_confirmation' => '确认密码',
        'reset password' => '重置密码',
        'register' => '注册',
        'Change password (if not empty)' => 'Change password (if not empty)',
        'save' => '保存',
        'save and exit' => '保存并退出',
        'exit' => '退出',
        'log in' => '登录',
        'modify' => '修改',
        'permissions' => 'Permissions',
        'isSuperUser' => 'Superuser',
        'isActivated' => 'Activated',
        'getMergedPermissions' => 'Get merged permissions',

        // Settings
        'webmasterEmail' => 'Webmaster email',
        'typekitCode' => 'Typekit Code',
        'googleAnalyticsCode' => 'Google Analytics Code',
        'langChooser' => 'Lang chooser',
        'welcomeMessage' => '管理欢迎信息',
        'adminLocale' => '管理语言',
        'welcomeMessageURL' => '管理欢迎信息URL',
        'authPublic' => '验证以查看网站',
        'registration allowed' => '允许注册',

        // Galleries
        'galleries' => '相册',

        // Translations
        'key' => '键',
        'translations' => '翻译',

        // Files
        'alt_attribute' => 'Alt attribute',
        'keywords' => '关键字',
        'folder_id' => '文件夹',
        'user_id' => '用户',
        'type' => '类型',
        'position' => '位置',
        'name' => '名称',
        'path' => '路径',
        'files' => '文件',
        'filename' => '文件名',
        'extension' => '扩展',
        'mimetype' => 'Mimetype',
        'width' => '宽',
        'height' => '高',
        'download_count' => '下载次数',
        'file information' => '文件信息',
        'image' => '图片',
        'replace image' => '替换图片',
        'file' => '文件',
        'replace file' => '替换文件',
        'max' => '最大',
        'max :size MB' => 'Maximum :size MB',
        'KB' => 'KB',
        'MB' => 'MB',
        'size (px)' => 'Size (px)',
        'preview' => '预览',

        'Submit' => '提交',
        'Reset' => '重置',
        'Cancel' => '取消',
    ),

    // Values, for example for select menus
    'values' => array(
        'Active tab' => 'Active tab',
        'New tab' => '新建标签',
    ),

);
