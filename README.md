Module for adding the legal agreements on site
==============================================
Installation
------------
#### Run command
```
composer require black-lamp/yii2-legal
```
or add
```json
"black-lamp/yii2-legal": "*"
```
to the require section of your composer.json.
#### Applying migrations
```
yii migrate --migrationPath=@vendor/black-lamp/yii2-legal/migrations
```
#### Add module to application config
```php
'modules' => [
     // ...
     'legal-agreement' => [
         'class' => bl\legalAgreement\LegalModule::className(),
         // example
         'languageEntity' => [
              'class' => bl\multilang\entities\Language::className(),
              'idField' => 'id',
              'nameField' => 'name'
          ]
     ]
]
```
#### Add component if you need it
Component for manipulations with users and legal agreements
```php
'components' => [
     // ...
     'legalAccept' => [
         'class' => bl\legalAgreement\components\LegalAgreement::className()
     ]
]
```