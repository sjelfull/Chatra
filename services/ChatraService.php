<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Chatra Service
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraService extends BaseApplicationComponent
{
    protected $cookieName     = 'chatraSettings';
    protected $settings;
    protected $allowedOptions = [
        // Chat button style. Overrides the style set in widget settings. Possible values: 'tab', 'round'.
        'buttonStyle',
        // Chat button position. Overrides the position set in widget settings. Possible values: See https://chatra.io/help/api/#buttonposition
        'buttonPosition',
        // Round chat button size in px, default is 60. Does not affect the “tab” button.
        'buttonSize',
        // Chat widget width in px, default is 340.
        'chatWidth',
        // Chat widget height in px, default is 480.
        'chatHeight',
        // Chat widget’s z-index value, default is 9999.
        'zIndex',
        // Defines the color scheme of the widget. Colors are set using strings in #fff or #ffffff format:
        'colors',
        // If set to true the widget starts hidden.
        'startHidden',

        // If set to true the widget will show up only on mobile devices.
        'mobileOnly',
        // If set to true the widget won’t show up on mobile devices.
        'disabledOnMobile',
        // Widget language. Overrides the language set in widget settings. Possible values: 'en', 'de', 'fr', 'es', 'nl', and 'ru'.
        'language',
        // Chatra display mode:
        // 'widget' — default widget,
        //'frame' — Chatra is embedded into the block specified in injectTo.
        'mode',
        // String | Array | Object
        // Specifies the element Chatra will be embedded into when launched in frame mode (see mode). Possible values are: element’s id, direct link
        // to the HTML Node or array-like HTML Node collection, including NodeLists and jQuery collections (first element of the collection will be used).
        'injectTo',
        // Unique secret (not available for other users) string. Binds the chat to a signed in user.
        'clientId',
        // Agent group ID. Chats started on the page with specified group ID will be assigned to this group. You can find group’s ID on its page in “Groups” section of the dashboard:
        'groupId',
    ];

    public function init ()
    {
        parent::init();
        $plugin         = craft()->plugins->getPlugin('chatra');
        $this->settings = $plugin->getSettings();
    }

    /**
     */
    public function getWidgetCode ($settings = [ ])
    {
        $oldPath  = craft()->templates->getTemplatesPath();
        $publicApiKey = $this->settings['publicApiKey'];

        if ( empty($publicApiKey) ) {
            return null;
        }

        $widget      = null;
        $chatraSetup = [
            'clientId' => $this->getCurrentClientId(),
        ];

        if ( !empty($settings) ) {
            $chatraSetup = $chatraSetup + $settings;
        }

        //$oldMode  = craft()->templates->getTemplateMode();
        //craft()->templates->setTemplateMode(TemplateMode::CP);

        craft()->templates->setTemplatesPath(CRAFT_PLUGINS_PATH . 'chatra/templates/');

        try {
            $widget = craft()->templates->render('Chatra_Widget', array(
                'publicApiKey'    => $publicApiKey,
                'chatraSetup' => TemplateHelper::getRaw(json_encode($chatraSetup)),
            ));
        }
        catch (\Exception $e) {
            ChatraPlugin::log('Couldn\'t render Chatra widget: ' . $e->getMessage(), LogLevel::Error);
        }

        //craft()->templates->setTemplateMode($oldMode);
        craft()->templates->setTemplatesPath($oldPath);

        return $widget;
    }

    public function getUserPane ($context)
    {
        $publicApiKey = $this->settings['publicApiKey'];
        $user     = $context['account'];
        $clientId = $this->getClientIdForUser($user, $createIfNotExisting = false);

        // TODO: Add secretApiKey
        $pane = craft()->templates->render('chatra/Chatra_UserPane', array(
            'publicApiKey' => $publicApiKey,
            'clientId' => $clientId,
        ));

        return $pane;
    }

    public function getWidgetSettings ()
    {

    }

    public function getCurrentClientId ()
    {
        $currentUser = craft()->userSession->getUser();

        // Check if user is logged in
        if ( $currentUser ) {
            $clientId = $this->getClientIdForUser($currentUser);
        }
        else {
            $clientId = $this->getClientIdFromCookie();

            // Generate new one if not
            if ( !$clientId ) {
                $clientId = $this->generateClientId();
                $this->setClientIdCookie($clientId);
            }
        }

        // Check if a cookie is set

        return $clientId;
    }

    public function getClientIdForUser (UserModel $user, $createIfNotExisting = true)
    {
        $clientRecord = ChatraRecord::model()->findByAttributes(array( 'userId' => $user->id ));
        $userId       = $user->id;

        if ( !$createIfNotExisting && !$clientRecord ) {
            return false;
        }

        if ( !$clientRecord ) {
            $model = new ChatraModel();

            // Check first if we should use clientId from cookie
            $clientId = $this->getClientIdFromCookie();

            if ( !$clientId ) {
                $clientId = $this->generateClientId();
            }

            $model->clientId = $clientId;

            if ( $model->validate() ) {
                $record = new ChatraRecord();

                $record->clientId = $model->getAttribute('clientId');
                $record->userId   = $userId;

                // Create DB record
                if ( !$record->save() ) {
                    ChatraPlugin::log("Problems saving client id for user #$userId: " . json_encode($record->getErrors()));

                }

            }
        }
        else {
            $model = ChatraModel::populateModel($clientRecord);
        }

        return $model->clientId;
    }

    public function getGroups ()
    {

    }

    public function getAgents ()
    {

    }

    public function saveSessionUserId ()
    {

    }


    public function getClientIdFromCookie ()
    {
        $cookie = craft()->request->getCookie($this->cookieName);

        if ( $cookie && !empty($cookie->value) && ($data = craft()->security->validateData($cookie->value)) !== false ) {
            return $data;
        }

        return false;
    }

    private function setClientIdCookie ($clientId)
    {
        $expire = (int)strtotime("+1 month");
        $cookie = new HttpCookie($this->cookieName, '');

        $cookie->value  = craft()->security->hashData($clientId);
        $cookie->expire = $expire;
        $cookie->path   = '/'; // Available to entire domain

        craft()->request->getCookies()->add($cookie->name, $cookie);

    }

    public function generateClientId ()
    {
        $clientId = StringHelper::randomString(26);

        return $clientId;
    }

}