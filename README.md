Legal agreement module for Yii2
===============================
Module for adding the legal agreements across dashboard

[![Latest Stable Version](https://poser.pugx.org/black-lamp/yii2-legal-agreement/v/stable)](https://packagist.org/packages/black-lamp/yii2-legal-agreement)
[![Latest Unstable Version](https://poser.pugx.org/black-lamp/yii2-legal-agreement/v/unstable)](https://packagist.org/packages/black-lamp/yii2-legal-agreement)
[![License](https://poser.pugx.org/black-lamp/yii2-legal-agreement/license)](https://packagist.org/packages/black-lamp/yii2-legal-agreement)

Installation
------------
#### Run command
```
composer require black-lamp/yii2-legal-agreement
```
or add
```json
"black-lamp/yii2-legal-agreement": "1.*.*"
```
to the require section of your composer.json.
#### Applying migrations
```
yii migrate --migrationPath=@vendor/black-lamp/yii2-legal-agreement/common/migrations
```
#### Add modules to application config
Frontend module for displaying and accepting the agreement
```php
'modules' => [
     // ...
     'legal' => [
         'class' => bl\legalAgreement\frontend\LegalModule::className(),
     ],
]
```
Backend module for work with the agreements
```php
'modules' => [
     // ...
     'legal' => [
         'class' => bl\legalAgreement\backend\LegalModule::className(),
         'languageProvider' => [
               'class' => bl\legalAgreement\backend\providers\DbLanguageProvider::className(),
               'arModel' => \bl\multilang\entities\Language::className(),
               'idField' => 'id',
               'nameField' => 'name'
         ]
     ],
]
```
#### Add component to application config
Component for work with agreements and users
```php
'components' => 
[
    // ...
    'legal' => [
        'class' => bl\legalAgreement\common\components\LegalAgreement::className()
    ],
]
```