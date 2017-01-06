<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiEndpointsTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test if a main vue router componetnt is there
     *
     * @return void
     */
    public function testBusinessTemplateCheck()
    {

        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/business-locations')
            ->see('<router-view></router-view>');

    }


    /**
     * Test Get Business Locations Api Endpoint
     *
     * @return void
     */
    public function testGetBusinessLocationsApiEndpoint()
    {

        $user = factory(App\User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])->call('GET', '/api/business-locations');

        $this->assertEquals(200, $response->status());


        $this->assertContains('location', $response->getContent());


    }


    /**
     * Test Get Business Location Api Endpoint
     *
     * @return void
     */

    public function testGetBusinessLocationApiEndpoint()
    {

        $user = factory(App\User::class)->create();
        $location = factory(App\Models\BusinessLocations::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])->call('GET', '/api/business-locations/' . $location->id);

        $this->assertEquals(200, $response->status());
        $content = json_decode($response->getContent());

        $this->assertContains('location', $response->getContent());

        $this->assertEquals($location->id, $content->location->id);


    }


    /**
     * Test Create Business Location Api Endpoint
     *
     * @return void
     */

    public function testCreateBusinessLocationApiEndpoint()
    {
        $user = factory(App\User::class)->create();
        $data = [];
        $data['location'] = [
            'name' => 'Cluj Napoca',
            'address_1' => 'Fierului 33',
            'address_2' => 'Alpha Soft 1',
            'postal_code' => '123456fsfsdsfsfsf',
            'pictures' => []
        ];

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])->call('POST', '/api/business-locations', $data);

        $this->assertEquals(200, $response->status());
        $this->assertContains('id', $response->getContent());
        $content = json_decode($response->getContent());
        $this->seeInDatabase('business_locations', ['id' => $content->id]);

    }

    /**
     * Test Update Business Location Api Endpoint
     *
     * @return void
     */

    public function testUpdateBusinessLocationApiEndpoint()
    {

        $user = factory(App\User::class)->create();
        $location = factory(App\Models\BusinessLocations::class)->create();
        $newLocationModel = factory(App\Models\BusinessLocations::class)->make();

        $data = $newLocationModel->toArray();
        $data['id'] = $location->id;

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])->call('PUT', '/api/business-locations', ['location'=>$data]);

        $content = json_decode($response->getContent());


        $this->assertEquals(200, $response->status());

        $this->assertEquals($newLocationModel['name'], $content->location->name);


    }


    /**
     * Test Upload Business Location Photo Api Endpoint
     *
     * @return void
     */

    public function testUploadBusinessLocationPhotoApiEndpoint()
    {

        $user = factory(App\User::class)->create();

        $stub = __DIR__.'/images/test_image.jpg';
        $name = str_random(8).'.jpg';
        $path = sys_get_temp_dir().'/'.$name;

        copy($stub, $path);

        $file =new \Illuminate\Http\UploadedFile($path, $name, filesize($path), 'image/jpg', null, true);
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->call('POST', '/api/upload', [], [], ['file' => $file], ['Accept' => 'application/json']);

         $this->assertResponseOk();
         $content = json_decode($response->getContent());
         $this->assertObjectHasAttribute('image', $content);







    }


}