<?php

use TypiCMS\Modules\Files\Models\File;

class FilesControllerTest extends TestCase
{
    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/files');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreSuccess()
    {
        $object = new File();
        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $this->call('POST', 'admin/files');
        $this->assertRedirectedToRoute('admin.files.edit', ['id' => 1]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new File();
        $object->id = 1;
        File::shouldReceive('create')->once()->andReturn($object);
        $input = ['exit' => true];
        $this->call('POST', 'admin/files', $input);
        $this->assertRedirectedToRoute('admin.files.index');
    }
}
