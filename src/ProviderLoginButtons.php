<?php

use Bigfork\SilverStripeOAuth\Client\Authenticator\Authenticator as OAuthenticator;

class ProviderLoginButtons extends DataExtension {
    public function LoginButton($provider = NULL, $textOverride = NULL) {
        $form =  OAuthenticator::get_login_form(Controller::curr());
        $backURLField = $form->HiddenFields()->fieldByName('BackURL');
        if ($backURLField) {
            $backURLField->setValue($this->owner->Link());
        } else {
            $form->HiddenFields()->add(HiddenField::create('BackURL', $this->owner->Link()));
        }
        $form->setFormAction('/Security/LoginForm');
        if ($provider) {
            foreach ($form->Actions() as $action) {
                if ($action->Name !== "action_authenticate_$provider") {
                    $form->Actions()->remove($action);
                } elseif ($textOverride) {
                    $action->setTitle($textOverride);
                }
            }
        }
        return $form;
    }
}