<?php
namespace AHT\CustomFormCheckout\Plugin\Checkout;

class LayoutProcessorPlugin {

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['order_byy'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'AHT_CustomFormCheckout/order_by_init',
                    'options' => [],
                ],
                'dataScope' => 'shippingAddress.order_byy',
                'label' => __('Order Byy'),
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => false, //['required-entry' => $this->_helper->getConfigIsFieldRequired()],
                'sortOrder' => 200,
            ];
        return $jsLayout;
    }
}