<?php

namespace Tickles\Supersales\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Tickles\Supersales\Config\Model\Config\Source\Sales;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetup;

    public function __construct(EavSetup $eavSetupFactory)
    {
        $this->eavSetup = $eavSetupFactory;
    }

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface   $context
     */
    public function install(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->eavSetup->addAttribute(
            Product::ENTITY,
            'tickles_supersales',
            [
                'type' => 'varchar',
                'backend' => ArrayBackend::class,
                'frontend' => '',
                'label' => 'Sale',
                'input' => 'multiselect',
                'class' => '',
                'source' => Sales::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => 0,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        $setup->endSetup();
    }
}