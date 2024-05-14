<?php

namespace TestsFeature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use IlluminateFoundationTestingRefreshDatabase;
use Tests\TestCase;
use TestsTestCase;

class CalculatorTest extends TestCase
{
    use RefreshDatabase; // Если используете SQLite in-memory DB

    public function setUp(): void
    {
        parent::setUp();

        // Выполняем миграции для in-memory базы данных.
        $this->artisan('migrate');

        // Заполняем базу данных данными из сидера.
        $this->seed(DatabaseSeeder::class);
    }

    public function testRouteGetTransportCompaniesReturnsSuccessStatusAndNotEmptyArrayData()
    {
        // Отправляем GET запрос к маршруту
        $response = $this->get('/api/v1/get-transport-companies');

        // Убеждаемся, что статус ответа - 200 OK
        $response->assertStatus(200);

        // Проверяем, что ответ является JSON и содержит ключ data который является массивом
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')->etc()
        );

        // Проверяем, что data является не пустым массивом
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    public function testPositiveCalculation()
    {
        // Позитивный тест на расчет стоимости

        // Мы отправляем POST запрос на наш калькулятор со следующими данными
        $response = $this->postJson('/api/v1/get-calculate-result', [
            'weight' => 200, // вес груза
            'distance' => 20, // расстояние перевозки
            'transportCompany' => 1, // выбранная транспортная компания
            'productType' => 1, // выбранная тип товара
        ]);

        // Ожидаем ответа 200 и проверяем возвращаемое значение стоимости
        $response
            ->assertStatus(200)
            ->assertJson([
                'value' => 1000, // Пример ожидаемого расчета стоимости
            ]);
    }

    public function testNegativeCalculation()
    {
        // Негативный тест на расчет стоимости

        // Отправляем запрос с некорректным весом
        $response = $this->postJson('/api/v1/get-calculate-result', [
            'weight' => 20, // вес меньше минимально допустимого
            'distance' => 100,
            'transportCompany' => 1, // выбранная транспортная компания
            'productType' => 1, // выбранная тип товара
        ]);

        // Ожидаем ошибку валидации
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['weight']);
    }

    public function testRecordCreation()
    {
        // Тест на проверку создания записи о расчете в базе данных

        // Корректные данные
        $data = [
            'weight' => 200,
            'distance' => 100,
            'transportCompany' => 2,
            'productType' => 2,
        ];

        // Отправляем запрос
        $this->postJson('/api/v1/save-calculation', $data);

        // Проверяем, что запись создалась в базе данных
        $this->assertDatabaseHas('calculations', [
            'weight_kg' => $data['weight'],
            'distance_km' => $data['distance'],
            'transport_company_id' => $data['transportCompany'],
            'product_type_id' => $data['productType'],
            'summ'=>5400
        ]);
    }
}
