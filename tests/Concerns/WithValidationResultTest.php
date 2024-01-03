<?php
declare(strict_types=1);

namespace Maatwebsite\Excel\Tests\Concerns;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidationResult;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\User;
use Maatwebsite\Excel\Tests\TestCase;

class WithValidationResultTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->loadMigrationsFrom(dirname(__DIR__) . '/Data/Stubs/Database/Migrations');
    }


    /**
     * @test
     */
    public function can_validate_rows()
    {
        $import = new class implements ToModel, WithValidationResult
        {
            use Importable;

            public function model(array $row)
            {
                TestCase::assertArrayNotHasKey(0, $row);
                return new User([
                    'name'     => 'unavailable',
                    'email'    => $row[1],
                    'password' => 'secret',
                ]);
            }

            /**
             * @return array
             */
            public function rules(): array
            {
                return [
                    '1' => 'string',
                ];
            }
        };

        $import->import('import-users.xlsx');
        $this->assertDatabaseCount('users', 2);
    }

    /**
     * @test
     */
    public function can_validate_rows_with_headings()
    {
        $import = new class implements ToModel, WithValidationResult, WithHeadingRow
        {
            use Importable;

            public function model(array $row)
            {
                TestCase::assertArrayNotHasKey('name', $row);
                return new User([
                    'name'     => 'test',
                    'email'    => $row['email'],
                    'password' => 'secret',
                ]);
            }

            /**
             * @return array
             */
            public function rules(): array
            {
                return [
                    'email' => 'string',
                ];
            }
        };

        $import->import('import-users-with-headings.xlsx');
        $this->assertDatabaseCount('users', 2);
    }

    /**
     * @test
     */
    public function does_not_work_with_to_array(): void
    {
        // ideally we make this test case work in the future as well but might need big refactor.
        $import = new class implements ToModel, WithValidationResult, WithHeadingRow
        {
            use Importable;

            public function model(array $row)
            {
                TestCase::assertArrayNotHasKey('name', $row);
                return new User([
                    'name'     => 'test',
                    'email'    => $row['email'],
                    'password' => 'secret',
                ]);
            }

            /**
             * @return array
             */
            public function rules(): array
            {
                TestCase::fail('Expect validation rules never called when only reading to array');
            }
        };

        $sheets = $import->toArray('import-users-with-headings.xlsx');
        $this->assertCount(1, $sheets);
        $data = $sheets[0];
        $this->assertCount(2, $data);
        $this->assertArrayHasKey('name', $data[0]);
    }
}
