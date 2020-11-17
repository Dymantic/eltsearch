<?php


namespace Tests\Unit\Purchasing;


use App\Purchasing\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function find_package_by_id()
    {
        config([
            'packages' => [
                [
                    'id' => 'my_package',
                    'name' => 'test name',
                    'description' => 'test description',
                    'price' => 33,
                    'quantity' => 10,
                    'type' => 'token'
                ],
            ],
        ]);

        $package = Package::find('my_package');
        $this->assertSame('my_package', $package->getId());
    }

    /**
     *@test
     */
    public function package_has_name()
    {
        $package = $this->makePackage(['name' => 'package name']);
        $this->assertSame('package name', $package->getName());
    }

    /**
     *@test
     */
    public function package_has_type()
    {
        $package = $this->makePackage(['type' => 'package type']);
        $this->assertSame('package type', $package->getType());
    }

    /**
     *@test
     */
    public function package_has_description()
    {
        $package = $this->makePackage(['description' => 'package description']);
        $this->assertSame('package description', $package->getDescription());
    }

    /**
     *@test
     */
    public function package_has_quantity_with_default_of_one()
    {
        $package = $this->makePackage(['quantity' => null]);
        $this->assertSame(1, $package->getQuantity());

        $package = $this->makePackage(['quantity' => 88]);
        $this->assertSame(88, $package->getQuantity());
    }

    /**
     *@test
     */
    public function package_has_a_price()
    {
        $package = $this->makePackage(['price' => 88]);
        $this->assertSame(88, $package->getPrice());
    }

    /**
     *@test
     */
    public function package_has_an_expiry_date_counted_in_days_with_default_of_century()
    {
        $package = $this->makePackage(['expires' => 45]);
        $this->assertTrue($package->getExpiry()->isSameDay(now()->addDays(45)));
    }



    private function makePackage($attributes = []): Package
    {
        $valid = [
            'id' => 'test_package',
            'name' => 'test name',
            'description' => 'test description',
            'price' => 33,
            'quantity' => 10,
            'type' => 'token'
        ];
        return new Package(array_merge($valid, $attributes));
    }
}
