<?php

use yii\db\Migration;

class m170316_125425_add_roles_and_permissions extends Migration
{
    public function up()
    {
        /** @var \yii\rbac\ManagerInterface $authManager */
        $authManager = Yii::$app->get('authManager');

        /**Adds roles**/
        $legalAgreementsManager = $authManager->createRole('legalAgreementsManager');
        $legalAgreementsManager->description = 'Legal agreements manager';
        $authManager->add($legalAgreementsManager);

        /**Adds permissions*/
        $manageLegalAgreement = $authManager->createPermission('manageLegalAgreement');
        $manageLegalAgreement->description = 'Manage legal agreement';
        $authManager->add($manageLegalAgreement);
        $authManager->addChild($legalAgreementsManager, $manageLegalAgreement);
    }

    public function down()
    {
        /** @var \yii\rbac\ManagerInterface $authManager */
        $authManager = Yii::$app->get('authManager');

        $manageLegalAgreement = $authManager->getPermission('manageLegalAgreement');
        $authManager->remove($manageLegalAgreement);

        $legalAgreementsManager = $authManager->getRole('legalAgreementsManager');
        $authManager->remove($legalAgreementsManager);

    }
}
