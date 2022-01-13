<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Types;

use Amasty\ThankYouPage\Api\ConfigNewsletterInterface;

class Newsletter extends Basic implements ConfigNewsletterInterface
{

    /**#@+
     * xpath field parts
     */
    const FIELD_TITLE = 'title';
    const FIELD_SUB_TITLE = 'sub_title';
    const FIELD_CONFIRMATION_MESSAGE = 'confirmation_message';
    const FIELD_ALREADY_SUBSCRIBED_TEXT = 'text_subscribed';

    /**#@-*/

    /**
     * @return string
     */
    public function getBlockTitle(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_TITLE);
    }

    /**
     * @return string
     */
    public function getBlockSubTitle(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_SUB_TITLE);
    }

    /**
     * @return string
     */
    public function getConfirmationMessage(): string
    {
        return (string)$this->getValue($this->getGroupPrefix() . self::FIELD_CONFIRMATION_MESSAGE);
    }

    /**
     * @return string
     */
    public function getAlreadySubscribedText(): string
    {
        return $this->getValue($this->getGroupPrefix() . self::FIELD_ALREADY_SUBSCRIBED_TEXT);
    }
}
