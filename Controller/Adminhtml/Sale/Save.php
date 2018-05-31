<?php

namespace Tickles\Supersales\Controller\Adminhtml\Sale;

use Magento\Backend\App\Action;

class Save extends Action
{
    /**
     * @var \Tickles\Supersales\Model\Sale
     */
    protected $_model;

    /**
     * @param Action\Context $context
     * @param \Tickles\Supersales\Model\Sale $model
     */
    public function __construct(
        Action\Context $context,
        \Tickles\Supersales\Model\Sale $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Backend::content');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Tickles\Supersales\Model\Sale $model */
            $model = $this->_model;

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            // $this->_eventManager->dispatch(
            //     'YOURMODELPREFIX_prepare_save',
            //    ['YOURMODELPREFIX' => $model, 'request' => $this->getRequest()]
            // );

            try {
                $model->save();
                $this->messageManager->addSuccess(__(' saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the '));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}