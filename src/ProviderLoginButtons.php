<?php

namespace RevStrat\OAuthButtons;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\HiddenField;
use Bigfork\SilverStripeOAuth\Client\Authenticator\Authenticator;

class ProviderLoginButtons extends DataExtension {
    public function LoginButton($backURL = '/', $provider = NULL) {
        $authenticator = Injector::inst()->get(Authenticator::class);
        $handler = $authenticator->getLoginHandler('/Security/login/oauth/');
        $form = $handler->loginForm();

        if ($provider) {
            foreach($form->Actions() as $action) {
                if ($action->Name !== "action_authenticate_$provider") {
                    $form->Actions()->remove($action);
                }
            }
        }
        
        $form->Fields()->replaceField('BackURL', HiddenField::create('BackURL', null, $backURL));
        return $form;
    }
}