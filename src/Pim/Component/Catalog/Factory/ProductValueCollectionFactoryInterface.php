<?php

namespace Pim\Component\Catalog\Factory;

use Pim\Component\Catalog\Model\ProductValueCollectionInterface;

/**
 * Interface for factory to create product value collection
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface ProductValueCollectionFactoryInterface
{
    /**
     * Create product values from raw values described in the storage format.
     *
     * @param array $rawValues
     *
     * @return ProductValueCollectionInterface
     */
    public function createFromStorageFormat(array $rawValues);
}
