Module for adding the legal agreements on site
==============================================
Installation
------------
#### Run command
```
composer require black-lamp/yii2-legal-agreement
```
or add
```json
"black-lamp/yii2-legal-agreement": "2.*.*"
```
to the require section of your composer.json.
#### Applying migrations
```
yii migrate --migrationPath=@vendor/black-lamp/yii2-legal-agreement/common/migrations
```
#### Add module to application config
Frontend module
```php
'modules' => [
     // ...
     'legal' => [
         'class' => bl\legalAgreement\frontend\LegalModule::className(),
     ],
]
```
Backend module
```php
'modules' => [
     // ...
     'legal' => [
         'class' => bl\legalAgreement\frontend\LegalModule::className(),
         'languageProvider' => [
               'class' => bl\legalAgreement\backend\providers\DbLanguageProvider::className(),
               'arModel' => \bl\multilang\entities\Language::className(),
               'idField' => 'id',
               'nameField' => 'name'
         ]
     ],
]
```