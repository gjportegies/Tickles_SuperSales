<?php

namespace Tickles\Supersales\Block\Adminhtml\Sale\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('sale_form');
        $this->setTitle(__(' Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Tickles\Supersales\Model\Sale $model */
        $model = $this->_coreRegistry->registry('current_model');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('sale_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Make/edit SuperSale'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('supersale_id', 'hidden', ['name' => 'supersale_id']);
        }

        $fieldset->addField(
            'product_id',
            'text',
            [
                'name' => 'product_id',
                'label' => __('Product ID'),
                'title' => __('Product ID'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort order'),
                'title' => __('Sort order'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'is_enabled',
            'select',
            [
                'label' => __('Enabled'),
                'title' => __('Enabled'),
                'required' => true,
                'values' => ['1' => __('Yes'), '0' => __('No')],
                'name' => 'is_enabled'
            ]
        );

        $fieldset->addField(
            'start_date',
            'date',
            [
                'name' => 'start_date',
                'required' => true,
                'label' => __('Sale start date'),
                'title' => __('Sale start date'),
                'date_format' => $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT),
                'time_format' => $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT),
                'class' => 'validate-date'
            ]
        );

        $fieldset->addField(
            'end_date',
            'date',
            [
                'name' => 'end_date',
                'required' => true,
                'label' => __('Sale end date'),
                'title' => __('Sale end date'),
                'date_format' => $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT),
                'time_format' => $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT),
                'class' => 'validate-date'
            ]
        );


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}