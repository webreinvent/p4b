<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    design
 * @package     default_modern
 * @copyright   Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 * Product view template
 *
 * @see Mage_Catalog_Block_Product_View
 * @see Mage_Review_Block_Product_View
 */


?>
<?php $_helper = $this->helper('catalog/output'); ?>
<?php $_product = $this->getProduct(); ?>
<script type="text/javascript">
    var optionsPrice = new Product.OptionsPrice(<?php echo $this->getJsonConfig() ?>);
</script>
<div id="messages_product_view"><?php echo $this->getMessagesBlock()->toHtml() ?></div>
<div class="product-view">
    <div class="product-essential">
    <form action="<?php echo $this->getSubmitUrl($_product) ?>" method="post" id="product_addtocart_form"<?php if($_product->getOptions()): ?> enctype="multipart/form-data"<?php endif; ?>>
        <?php echo $this->getBlockHtml('formkey') ?>
        <div class="no-display">
            <input type="hidden" name="product" value="<?php echo $_product->getId() ?>" />
            <input type="hidden" name="related_product" id="related-products-field" value="" />
        </div>

        <div class="product-shop">
            <div class="product-name">
                <h1><?php echo $_helper->productAttribute($_product, $_product->getName(), 'name') ?></h1>
            </div>

            <?php if ($this->canEmailToFriend()): ?>
                <p class="email-friend"><a href="<?php echo $this->helper('catalog/product')->getEmailToFriendUrl($_product) ?>"><?php echo $this->__('Email to a Friend') ?></a></p>
            <?php endif; ?>

            <?php echo $this->getReviewsSummaryHtml($_product, false, true)?>
            <?php echo $this->getChildHtml('alert_urls') ?>
            <?php echo $this->getChildHtml('product_type_data') ?>
            <?php echo $this->getTierPriceHtml() ?>
            <?php echo $this->getChildHtml('extrahint') ?>

            <?php if (!$this->hasOptions()):?>
                <div class="add-to-box">
                    <?php if($_product->isSaleable()): ?>
                        <?php echo $this->getChildHtml('addtocart') ?>
                        <?php if( $this->helper('wishlist')->isAllow() || $_compareUrl=$this->helper('catalog/product_compare')->getAddUrl($_product)): ?>
                            <span class="or"><?php echo $this->__('OR') ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php echo $this->getChildHtml('addto') ?>
                </div>
            <?php endif; ?>

            <?php if ($_product->getShortDescription()):?>
                <div class="short-description">
                    <h2><?php echo $this->__('Quick Overview') ?></h2>
                    <div class="std"><?php echo $_helper->productAttribute($_product, nl2br($_product->getShortDescription()), 'short_description') ?></div>
                </div>
            <?php endif;?>

            <?php echo $this->getChildHtml('other');?>
            <?php if ($_product->isSaleable() && $this->hasOptions()):?>
                <?php echo $this->getChildChildHtml('container1', '', true, true) ?>
            <?php endif;?>

        </div>

        <div class="product-img-box">
            <?php echo $this->getChildHtml('media') ?>
        </div>

        <div class="clearer"></div>
        <?php if ($_product->isSaleable() && $this->hasOptions()):?>
            <?php echo $this->getChildChildHtml('container2', '', true, true) ?>
        <?php endif;?>
    </form>
    <script type="text/javascript">
    //<![CDATA[
        var productAddToCartForm = new VarienForm('product_addtocart_form');
        productAddToCartForm.submit = function(button, url) {
            if (this.validator.validate()) {
                var form = this.form;
                var oldUrl = form.action;

                if (url) {
                   form.action = url;
                }
                var e = null;
                try {
                    this.form.submit();
                } catch (e) {
                }
                this.form.action = oldUrl;
                if (e) {
                    throw e;
                }

                if (button && button != 'undefined') {
                    button.disabled = true;
                }
            }
        }.bind(productAddToCartForm);

        productAddToCartForm.submitLight = function(button, url){
            if(this.validator) {
                var nv = Validation.methods;
                delete Validation.methods['required-entry'];
                delete Validation.methods['validate-one-required'];
                delete Validation.methods['validate-one-required-by-name'];
                // Remove custom datetime validators
                for (var methodName in Validation.methods) {
                    if (methodName.match(/^validate-datetime-.*/i)) {
                        delete Validation.methods[methodName];
                    }
                }

                if (this.validator.validate()) {
                    if (url) {
                        this.form.action = url;
                    }
                    this.form.submit();
                }
                Object.extend(Validation.methods, nv);
            }
        }.bind(productAddToCartForm);
    //]]>
    </script>
    </div>

    <div class="product-collateral">
        <?php echo $this->getChildHtml('info_tabs') ?>
        <?php echo $this->getChildHtml('product_additional_data') ?>
    </div>
</div>
