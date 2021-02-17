<?php

namespace Tests\Unit\Purchasing;

use App\Purchasing\Package;
use Tests\TestCase;

class SingleTokenPackageTest extends TestCase
{
    /**
     * @test
     */
    public function single_token_package_has_expected_attributes()
    {
        config([
            'packages' => [
                [
                    'id' => 'single_token',
                    'description' => 'Allows you to publish a single job post. Does not expire',
                    'price' => 88,
                    'type' => 'token',
                    'trans_key' => 'pricing.single_post'
                ],
            ]
        ]);

        $package = Package::find('single_token');

        $this->assertInstanceOf(Package::class, $package);
        $this->assertSame(88, $package->getPrice());
        $this->assertSame('Single Token', $package->getName());

        $expected = [
            'Code'         => null,
            'IsDynamic'    => true,
            'PurchaseType' => 'PRODUCT',
            'Tangible'     => false,
            'Name'         => 'Single Token',
            'Price'        => [
                'PriceAmount' => 88.00,
                'PriceType'   => 'CUSTOM',
            ],
        ];

        $this->assertSame($expected, $package->fields());
    }
}
