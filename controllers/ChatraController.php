<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Chatra Controller
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = [ ];

    public function actionSendMessageToUser ()
    {
        $clientId      = craft()->request->getRequiredParam('clientId');
        $agentId       = craft()->request->getRequiredParam('agentId');
        $chatraMessage = craft()->request->getRequiredParam('chatraMessage');

        $response = craft()->chatra->sendMessageToUser($clientId, $chatraMessage, $agentId);

        $this->returnJson([
            'success' => $response,
        ]);
    }
}