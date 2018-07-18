<?php

namespace RevStrat\OAuthButtons;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\HiddenField;
use Bigfork\SilverStripeOAuth\Client\Authenticator\Authenticator;

use SilverStripe\Control\HTTPRequest;

class ProviderLoginButtons extends DataExtension {
    public function LoginButton($backURL = '/', $provider = NULL) {
        
        $authenticator = Injector::inst()->get(Authenticator::class);
        $handler = $authenticator->getLoginHandler(Director::baseURL() . 'Security/login/oauth/');
        $form = $handler->loginForm();

        if ($provider) {
            foreach($form->Actions() as $action) {
                if ($action->Name !== "action_authenticate_$provider") {
                    $form->Actions()->remove($action);
                }
            }
        }

        return $form;
    }
}