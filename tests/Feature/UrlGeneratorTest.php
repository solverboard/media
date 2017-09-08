<?php namespace Brackets\Media\Test\Feature;

use Brackets\Media\Test\TestCase;
use Brackets\Media\UrlGenerator\LocalUrlGenerator;
use Illuminate\Http\UploadedFile;

class UrlGeneratorTest extends TestCase
{

    public function prepare()
    {
        $this->testModelWithCollections->addMediaCollection('private_documents')->disk('media-private');
        $this->testModelWithCollections->addMediaCollection('public_documents')->disk('media');

        $request = $this->getRequest([
            'private_documents' => [
                [
                    'collection_name' => 'private_documents',
                    'model' => 'Brackets\Media\Test\TestModel',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
            'public_documents' => [
                [
                    'collection_name' => 'public_documents',
                    'model' => 'Brackets\Media\Test\TestModel',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $this->testModelWithCollections->processMedia(collect($request->only($this->testModelWithCollections->getMediaCollections()->map->getName()->toArray())));
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('medialibrary.custom_url_generator_class', LocalUrlGenerator::class);
    }

    /** @test */
    public function user_can_get_url()
    {
        $this->prepare();

        $this->testModelWithCollections->load('media');

        $this->assertEquals('/view?path=1/test.pdf', $this->testModelWithCollections->media->first()->getUrl());

        $this->assertEquals('/media/2/test.txt', $this->testModelWithCollections->media->last()->getUrl());
    }
}