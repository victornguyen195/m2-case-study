<?php

namespace Dev\Banner\Controller\Adminhtml\Image;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Dev\Banner\Model\ImageUploader;

/**
 * Class Upload
 * @package Dev\Banner\Controller\Adminhtml\Image
 */
class Upload extends Action
{
    protected $imageUploader;

    public function __construct(
        Action\Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
