<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = app(CategoryRepositoryInterface::class);
    }

    /** @test */
    public function can_get_all_categories()
    {
        $data = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'icon' => "Data.png",
        ];

        foreach (range(1, 10) as $index) {
            $category = $this->categoryRepository->create($data);
        }

        // Mendapatkan semua kategori dari repository
        $categories = $this->categoryRepository->getAll();

        // Memastikan bahwa jumlah kategori yang didapatkan sesuai dengan yang diharapkan
        $this->assertCount(10, $categories);

        // Memastikan bahwa setiap item dalam array $categories adalah instance dari Category
        foreach ($categories as $category) {
            $this->assertInstanceOf(Category::class, $category);
        }
    }

    /** @test */
    public function can_create_category()
    {
        // Membuat instans kategori dengan data dummy menggunakan Faker
        $data = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'icon' => 'Laptop.svg',
        ];

        $category = $this->categoryRepository->create($data);

        // Lakukan pengujian terhadap operasi yang melibatkan database
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }

    /** @test */
    public function can_get_category_by_id()
    {
        // Membuat instans kategori secara manual
        $category = new Category([
            'name' => 'Category Name',
            'slug' => 'category-name',
            'icon' => 'category-icon.svg'
        ]);
        $category->save();

        // Mendapatkan kategori berdasarkan ID
        $foundCategory = $this->categoryRepository->getById($category->id);

        // Membandingkan ID kategori yang diharapkan dengan ID yang ditemukan
        $this->assertEquals($category->id, $foundCategory->id);
    }

    /** @test */
    public function can_update_category()
    {
        // Membuat instans kategori dengan data dummy menggunakan Faker
        $data = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'icon' => 'Icon-laptop-1.svg',
        ];

        $category = $this->categoryRepository->create($data);

        // Update kategori
        $newData = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'icon' => 'Icon-laptop.svg',
        ];

        $this->categoryRepository->update($category->id, $newData);

        // Mendapatkan kategori yang telah diperbarui dari database
        $updatedCategory = $this->categoryRepository->getById($category->id);

        // Membandingkan nama kategori yang diharapkan dengan nama yang ditemukan
        $this->assertEquals($newData['name'], $updatedCategory->name);
    }

    /** @test */
    public function can_delete_category()
    {
        // Membuat instans kategori secara manual
        $category = new Category([
            'name' => 'Category Name',
            'slug' => 'category-name',
            'icon' => 'Category-icon.svg',
        ]);
        $category->save();

        // Mendapatkan kategori berdasarkan ID
        $foundCategory = $this->categoryRepository->delete($category->id);

        // Memastikan bahwa kategori tidak ada lagi dalam database
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
