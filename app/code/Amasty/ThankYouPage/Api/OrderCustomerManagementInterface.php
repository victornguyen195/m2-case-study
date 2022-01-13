<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface OrderCustomerManagementInterface
{

    /**
     * Create customer account for order
     *
     * @param int $orderId
     * @param null|string $email
     * @param null|string $password
     * @param null|string $dateOfBirth
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function create(
        int $orderId,
        ?string $email = null,
        ?string $password = null,
        ?string $dateOfBirth = null
    ): CustomerInterface;
}
