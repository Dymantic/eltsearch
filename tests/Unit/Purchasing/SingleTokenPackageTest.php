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
                    'name' => 'Single Job Post Token',
                    'description' => 'Allows you to publish a single job post. Does not expire',
                    'price' => 88,
                    'type' => 'token'
                ],
            ]
        ]);

        $package = Package::find('single_token');

        $this->assertInstanceOf(Package::class, $package);
        $this->assertSame(88, $package->getPrice());
        $this->assertSame('Single Job Post Token', $package->getName());

        $expected = [
            'Code'         => null,
            'IsDynamic'    => true,
            'PurchaseType' => 'PRODUCT',
            'Tangible'     => false,
            'Name'         => 'Single Job Post Token',
            'Price'        => [
                'PriceAmount' => 88.00,
                'PriceType'   => 'CUSTOM',
            ],
        ];

        $this->assertSame($expected, $package->fields());
    }
}
