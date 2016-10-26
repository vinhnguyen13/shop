<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */

$enc = $this->encoder();

?>
<?php $this->block()->start( 'checkout/standard/summary/option' ); ?>
<div class="checkout-standard-summary-option container">
	<h2 class="header"><?php echo $enc->html( $this->translate( 'client', 'Options' ), $enc::TRUST ); ?></h2>
<?php echo $this->get( 'optionBody' ); ?>
</div>
<?php $this->block()->stop(); ?>
<?php echo $this->block()->get( 'checkout/standard/summary/option' ); ?>
