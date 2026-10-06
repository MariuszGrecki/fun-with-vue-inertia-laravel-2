<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RealtorListingImageTest extends TestCase
{
    use RefreshDatabase;

    private User $realtor;

    private Listing $listing;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->realtor = User::factory()->create();
        $this->listing = Listing::factory()->for($this->realtor, 'owner')->create();
    }

    public function test_guest_cannot_upload_images()
    {
        $response = $this->post(route('realtor.listing.image.store', $this->listing), [
            'images' => [UploadedFile::fake()->image('house.jpg')],
        ]);

        $response->assertRedirect(route('auth.login'));
        $this->assertDatabaseCount('listing_images', 0);
    }

    public function test_realtor_can_upload_multiple_images()
    {
        $response = $this->actingAs($this->realtor)
            ->from(route('realtor.listing.image.create', $this->listing))
            ->post(route('realtor.listing.image.store', $this->listing), [
                'images' => [
                    UploadedFile::fake()->image('front.jpg'),
                    UploadedFile::fake()->image('garden.png'),
                ],
            ]);

        $response->assertRedirect(route('realtor.listing.image.create', $this->listing));
        $this->assertCount(2, $this->listing->images);

        foreach ($this->listing->images as $image) {
            Storage::disk('public')->assertExists($image->filename);
        }
    }

    public function test_upload_requires_at_least_one_image()
    {
        $response = $this->actingAs($this->realtor)
            ->post(route('realtor.listing.image.store', $this->listing), []);

        $response->assertSessionHasErrors('images');
    }

    public function test_upload_rejects_files_that_are_not_images()
    {
        $response = $this->actingAs($this->realtor)
            ->post(route('realtor.listing.image.store', $this->listing), [
                'images' => [
                    UploadedFile::fake()->image('front.jpg'),
                    UploadedFile::fake()->create('contract.pdf', 100, 'application/pdf'),
                ],
            ]);

        $response->assertSessionHasErrors('images.1');
        $this->assertDatabaseCount('listing_images', 0);
    }

    public function test_upload_rejects_images_larger_than_the_limit()
    {
        $response = $this->actingAs($this->realtor)
            ->post(route('realtor.listing.image.store', $this->listing), [
                'images' => [UploadedFile::fake()->image('huge.jpg')->size(6000)],
            ]);

        $response->assertSessionHasErrors('images.0');
    }

    public function test_realtor_can_delete_an_image()
    {
        $file = UploadedFile::fake()->image('front.jpg')->store('images', 'public');
        $image = ListingImage::factory()->for($this->listing)->create(['filename' => $file]);

        $response = $this->actingAs($this->realtor)
            ->delete(route('realtor.listing.image.destroy', [$this->listing, $image]));

        $response->assertRedirect();
        $this->assertModelMissing($image);
        Storage::disk('public')->assertMissing($file);
    }
}
