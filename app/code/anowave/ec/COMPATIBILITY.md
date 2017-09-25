# Compatibility
This file contains backwards compatibility notes

### Error / Version 2.0.x

Uncaught Error: cannot call methods on priceBox prior to initialization; attempted to call method 'option'

### Fix

1. Open file vendor\magento\module-configurable-product\view\frontend\web\js\configurable.js
2. Change line 64 from

		priceBoxOptions = $(this.options.priceHolderSelector).priceBox('option').priceConfig || null;

	to

		priceBoxOptions = $(this.options.priceHolderSelector).priceBox().priceBox('option').priceConfig || null;

3. Flush cache