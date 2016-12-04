<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class urlShortnerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_index_should_return_message_when_empty()
    {
        $this->get('/')
            ->seeStatusCode('200')
            ->seeJson([
                'message' => 'no urls found'
            ]);
    }

    public function test_index_should_return_list_of_urls()
    {
        $urls = factory('App\Url', 2)->create();

        $this->get('/')
            ->seeStatusCode('200');

        foreach ($urls as $url) {
            $this->seeJson([
                'desktop_url' => $url->desktop_url,
                'mobile_url' => $url->mobile_url,
                'tablet_url' => $url->tablet_url
            ])
                ->seeJsonStructure([
                    'data' => [['desktop_counter', 'mobile_counter', 'tablet_counter', 'created']]
                ]);
        }
    }

    public function test_create_should_return_error_when_empty_params()
    {
        $this->post('/', [])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The desktop url field is required.']);

        $this->post('/', ['desktop_url' => ''])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The desktop url field is required.']);
    }

    public function test_create_should_return_error_when_desktop_url_param_is_invalid()
    {
        $this->post('/', ['desktop_url' => 'abc123'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The desktop url format is invalid.']);

        $this->post('/', ['desktop_url' => 'http://abc123'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The desktop url format is invalid.']);

    }

    public function test_create_should_return_error_when_mobile_url_param_is_invalid()
    {
        $this->post('/', ['desktop_url' => 'http://www.google.com', 'mobile_url' => 'abc'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The mobile url format is invalid.']);

        $this->post('/', ['desktop_url' => 'http://www.google.com', 'mobile_url' => 'http://abc123'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The mobile url format is invalid.']);

    }

    public function test_create_should_return_error_when_tablet_url_param_is_invalid()
    {
        $this->post('/', ['desktop_url' => 'http://www.google.com', 'tablet_url' => 'abc'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The tablet url format is invalid.']);

        $this->post('/', ['desktop_url' => 'http://www.google.com', 'tablet_url' => 'http://abc123'])
            ->seeStatusCode('400')
            ->seeJson(['message' => 'The tablet url format is invalid.']);

    }

    public function test_create_should_return_short_url_when_params_is_valid()
    {
        $this->postValidRequest(['desktop_url' => 'http://www.google.com']);
        $this->postValidRequest(['desktop_url' => 'https://www.google.com', 'mobile_url' => 'http://www.yahoo.com']);
        $this->postValidRequest(['desktop_url' => 'https://www.google.com', 'tablet_url' => 'http://www.microsoft.com']);
    }

    public function test_update_should_return_error_when_params_is_invalid()
    {
        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com']);
        $this->post($short_url, ['desktop_url' => 'invalid'])
            ->seeStatusCode(400)
            ->seeJson(['message' => 'The desktop url format is invalid.']);

        $this->post($short_url, ['mobile_url' => 'invalid'])
            ->seeStatusCode(400)
            ->seeJson(['message' => 'The mobile url format is invalid.']);

        $this->post($short_url, ['tablet_url' => 'invalid'])
            ->seeStatusCode(400)
            ->seeJson(['message' => 'The tablet url format is invalid.']);

    }

    public function test_update_should_return_updated_url_when_params_is_valid()
    {
        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com']);
        $this->post($short_url, ['desktop_url' => 'http://www.apple.com'])
            ->seeStatusCode(200)
            ->seeJson([
                'desktop_url' => 'http://www.apple.com',
                'mobile_url' => null,
                'tablet_url' => null
            ])
            ->seeJsonStructure([
                'data' => ['desktop_counter', 'mobile_counter', 'tablet_counter', 'created']
            ])
            ->seeInDatabase('urls', ['desktop_url' => 'http://www.apple.com']);

        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com']);
        $this->post($short_url, ['desktop_url' => 'http://www.apple.com', 'mobile_url' => 'http://www.android.com'])
            ->seeStatusCode(200)
            ->seeJson([
                'desktop_url' => 'http://www.apple.com',
                'mobile_url' => 'http://www.android.com',
                'tablet_url' => null
            ])
            ->seeJsonStructure([
                'data' => ['desktop_counter', 'mobile_counter', 'tablet_counter', 'created']
            ])
            ->seeInDatabase('urls', ['desktop_url' => 'http://www.apple.com', 'mobile_url' => 'http://www.android.com']);

        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com']);
        $this->post($short_url, ['desktop_url' => 'http://www.apple.com', 'mobile_url' => 'http://www.android.com', 'tablet_url' => 'http://www.iphone.com'])
            ->seeStatusCode(200)
            ->seeJson([
                'desktop_url' => 'http://www.apple.com',
                'mobile_url' => 'http://www.android.com',
                'tablet_url' => 'http://www.iphone.com'
            ])
            ->seeJsonStructure([
                'data' => ['desktop_counter', 'mobile_counter', 'tablet_counter', 'created']
            ])
            ->seeInDatabase('urls', ['desktop_url' => 'http://www.apple.com', 'mobile_url' => 'http://www.android.com', 'tablet_url' => 'http://www.iphone.com']);
    }

    public function test_redirect_should_return_error_when_short_url_is_invalid()
    {
        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com', 'mobile_url' => 'http://www.yahoo.com', 'tablet_url' => 'http://www.microsoft.com']);
        $parse_url = parse_url($short_url);
        $wrongUrl = $parse_url['scheme'] . '://' . $parse_url['host'] . '/88888';
        $this->get($wrongUrl)
            ->seeStatusCode(400)
            ->seeJson(["message" => "invalid short url"]);
    }

    public function test_redirect_should_redirect_to_url_when_browser_is_desktop()
    {
        $short_url = $this->postValidRequest(['desktop_url' => 'http://www.google.com', 'mobile_url' => 'http://www.yahoo.com', 'tablet_url' => 'http://www.microsoft.com']);
        $this->get($short_url)
            ->seeStatusCode(302)
            ->seeHeader('Location', 'http://www.google.com');

        $this->get($short_url, ['user-agent' => 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-gb; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'])
            ->seeStatusCode(302)
            ->seeHeader('Location', 'http://www.yahoo.com');

        $this->get($short_url, ['user-agent' => 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'])
            ->seeStatusCode(302)
            ->seeHeader('Location', 'http://www.microsoft.com');
    }

    public function postValidRequest($params)
    {
        $this->post('/', $params)
            ->seeStatusCode('200')
            ->seeJsonStructure(['short_url']);
        $content = json_decode($this->response->getContent(), true);
        $this->assertTrue(filter_var($content['short_url'], FILTER_VALIDATE_URL) !== False);
        $this->seeInDatabase('urls', $params);
        return $content['short_url'];
    }


}
