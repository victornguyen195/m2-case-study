<?php

declare(strict_types=1);

namespace Amasty\JetOptimizer\Controller\Adminhtml\ImageOptimizer;

use Amasty\ImageOptimizer\Model\Image\ClearFolders;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class ClearImagesFolder extends Action
{
    const ADMIN_RESOURCE = 'Amasty_JetTheme::config';

    /**
     * @var array
     */
    private $foldersToRemove = [
        ClearFolders::FOLDER_TYPE_MOBILE,
        ClearFolders::FOLDER_TYPE_TABLET,
        ClearFolders::FOLDER_TYPE_WEBP,
    ];

    /**
     * @var ClearFolders
     */
    private $clearFolders;

    public function __construct(
        ClearFolders $clearFolders,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->clearFolders = $clearFolders;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            foreach ($this->foldersToRemove as $folder) {
                $this->clearFolders->execute($folder);
            }

            $this->messageManager->addSuccessMessage(__('Image Folders were successful cleaned.'));
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath($this->_redirect->getRefererUrl());
    }
}
