<?php
/**
 * Chatra plugin for Craft CMS
 *
 * Chatra Record
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */

namespace Craft;

class ChatraRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName ()
    {
        return 'chatra';
    }

    /**
     * @access protected
     * @return array
     */
    protected function defineAttributes ()
    {
        return array(
            'clientId' => array( AttributeType::String, 'default' => null, 'required' => true ),
        );
    }

    /**
     * @return array
     */
    public function defineRelations ()
    {
        return [
            'user' => [ static::BELONGS_TO, 'UserRecord', 'onDelete' => static::CASCADE ],
        ];
    }
}