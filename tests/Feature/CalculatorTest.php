<?php

namespace TestsFeature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use IlluminateFoundationTestingRefreshDatabase;
use Tests\TestCase;
use TestsTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CalculatorTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testRouteGetTransportCompanies()
    {
        $response = $this->get('/api/v1/get-transport-companies');

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')->etc()
        );

        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    public static function calculationPositiveProvider(): array
    {
        return [
            [200, 20, 1, 1, 1000],
            [500, 150, 2, 1, 20250],
            [100, 10, 3, 1, 210],

            // [weight, distance, transportCompany, productType, expectedValue]
        ];
    }

    #[DataProvider('calculationPositiveProvider')]
    public function testPositiveCalculation(
        int|null $weight,
        int|null $distance,
        int|null $transportCompany,
        int|null $productType,
        int $expectedValue
    )
    {
        $response = $this->postJson('/api/v1/get-calculate-result', compact(
            'weight',
            'distance',
            'transportCompany',
            'productType',
        ));

        $response
            ->assertOk()
            ->assertJson([
                'value' => $expectedValue,
            ]);
    }

    public static function calculationNegativeProvider():array
    {
        return [
            [20, 100, 1, 1, ['weight']],
            [null, null, null, null, ['weight','distance','transportCompany', 'productType']],
            [29, 0, 1, 2, ['weight','distance',]],

            // [weight, distance, transportCompany, productType, errorField]
        ];
    }

    #[DataProvider('calculationNegativeProvider')]
    public function testNegativeCalculation(
        int|null $weight,
        int|null $distance,
        int|null $transportCompany,
        int|null $productType,
        array $errorFieldsCode
    )
    {
        $response = $this->postJson('/api/v1/get-calculate-result', compact(
            'weight',
            'distance',
            'transportCompany',
            'productType',
        ));

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors($errorFieldsCode);
    }

    public static function calculationRecordProvider():array
    {
        return [
            [200, 100, 2, 2, 5400],
            [1000, 20, 3, 1, 4200],
            [100000, 200, 1, 1, 5000000],

            // [weight, distance, transportCompany, productType, errorField]
        ];
    }

    #[DataProvider('calculationRecordProvider')]
    public function testRecordCreation(
        int|null $weight,
        int|null $distance,
        int|null $transportCompany,
        int|null $productType,
        int $summ
    )
    {
        $data = compact(
            'weight',
            'distance',
            'transportCompany',
            'productType',
        );

        $this->postJson('/api/v1/save-calculation', $data);
        
        $this->assertDatabaseHas('calculations', [
            'weight_kg' => $data['weight'],
            'distance_km' => $data['distance'],
            'transport_company_id' => $data['transportCompany'],
            'product_type_id' => $data['productType'],
            'summ'=>$summ
        ]);
    }
}
