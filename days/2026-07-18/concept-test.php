// tests/Feature/TranslationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Jetstream\JetstreamTestCase;
use Tests\TestCase;

class TranslationTest extends JetstreamTestCase
{
    use DatabaseMigrations;

    public function test_translation_store()
    {
        $this->assertNull(Lang::get('hello'));

        $response = $this->post('/translation/en', [
            'locale' => 'en',
        ]);

        $response->assertRedirect('/translation');

        $this->assertSessionHas('locale', 'en');
        $this->assertEquals(Lang::get('hello'), 'Hello!');
    }

    public function test_translation_store_invalid_locale()
    {
        $response = $this->post('/translation/en', [
            'locale' => 'invalid-locale',
        ]);

        $response->assertRedirect('/translation');

        $this->assertFalse($this->sessionHas('locale'));
        $this->assertEquals(Lang::get('hello'), 'Hello!');
    }
}