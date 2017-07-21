<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Assembly;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssemblyTest extends TestCase
{
    use DatabaseMigrations;

    function setUp()
    {
        parent::setUp();

        // Create two test assemblies.
        $chamber = factory(Assembly::class)->create([
            'id' => 'k',
            'name_en' => 'Chamber of Representatives',
            'name_fr' => 'Chambre des représentants',
            'name_nl' => 'Kamer van Volksvertegenwoordigers',
        ]);
        $senate = factory(Assembly::class)->create([
            'id' => 's',
            'name_en' => 'Senate',
            'name_fr' => 'Sénat',
            'name_nl' => 'Senaat',
        ]);
    }

    /** @test */
    function can_get_the_list_of_assemblies_as_json()
    {
        // Make the request.
        $response = $this->get('/assemblies', [
            'accept' => 'application/json',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('application/json')
            ->assertContentEquals(__DIR__.'/fixtures/assemblies.json');
    }

    /** @test */
    function can_get_the_list_of_assemblies_as_csv()
    {
        // Make the request.
        $response = $this->get('/assemblies', [
            'accept' => 'text/csv',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/csv')
            ->assertContentEquals(__DIR__.'/fixtures/assemblies.csv');
    }

    /** @test */
    function can_get_the_list_of_assemblies_as_html()
    {
        // Make the request.
        $response = $this->get('/assemblies', [
            'accept' => 'text/html',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/html')
            ->assertSeeText('Chambre des représentants')
            ->assertSeeText('Sénat');
    }

    /** @test */
    function can_get_the_list_of_assemblies_as_xml()
    {
        // Make the request.
        $response = $this->get('/assemblies', [
            'accept' => 'text/xml',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/xml')
            ->assertContentEquals(__DIR__.'/fixtures/assemblies.xml');
    }

    /** @test */
    function can_get_a_single_assembly_as_json()
    {
        // Make the request.
        $response = $this->get('/assemblies/k', [
            'accept' => 'application/json',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('application/json')
            ->assertContentEquals(__DIR__.'/fixtures/single_assembly.json');
    }

    /** @test */
    function can_get_a_single_assembly_as_csv()
    {
        // Make the request.
        $response = $this->get('/assemblies/k', [
            'accept' => 'text/csv',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/csv')
            ->assertContentEquals(__DIR__.'/fixtures/single_assembly.csv');
    }

    /** @test */
    function can_get_a_single_assembly_as_html()
    {
        // Make the request.
        $response = $this->get('/assemblies/k', [
            'accept' => 'text/html',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/html')
            ->assertSeeText('Chambre des représentants')
            ->assertDontSeeText('Sénat');
    }

    /** @test */
    function can_get_a_single_assembly_as_xml()
    {
        // Make the request.
        $response = $this->get('/assemblies/k', [
            'accept' => 'text/xml',
        ]);

        // Verify the response.
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertContentType('text/xml')
            ->assertContentEquals(__DIR__.'/fixtures/single_assembly.xml');
    }
}
