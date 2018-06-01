<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaLibraryTests extends TestCase
{

    use RefreshDatabase;

    /**
     * Setup the test class authenticating a user with all the permissions on clien model
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->authUser()
        ->withPermissions([
            'task_create',
            ]);

    }

    /** @test */
    public function it_upload_files_asociting_to_task_and_project()
    {
       // Given I do POST a file to media library endpoint
       $project = factory(\App\Project::class)->create(['client_id' => 1]);
       $task = factory(\App\Task::class)->create([
           'user_id' => 1,
           'assigned_user' => 1,
           'project_id' => $project->id,
           'priority_id' => 1,
           'status_id' => 1,
           ]);

       $response = $this->post(route('taskMediaLibrary', ['taskId' => $task->id]), [
           'file' => UploadedFile::fake()->image('test.png')
       ]);

       $response->assertSuccessful();
       $response->assertJsonFragment(['name' => 'test']);


       // Then I have file in database asociated whit the task and the project
       $this->assertContains('test.png', $task->fresh()->getFirstMediaUrl($task->project_id));
    }

    /** @test */
    public function it_delete_fisical_file_when_delete_file_records()
    {
        // Given
        // When
        // Then
    }

    /** @test */
    public function if_task_is_deleted_file_is_deleted()
    {
        // Given
        // When
        // Then
    }

    /** @test */
    public function it_delete_files_when_project_is_archived()
    {
        // Given
        // When
        // Then
    }
}
