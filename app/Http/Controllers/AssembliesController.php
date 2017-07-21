<?php

namespace App\Http\Controllers;

use SplTempFileObject;
use League\Csv\Writer;
use App\Models\Assembly;
use Illuminate\Http\Request;

class AssembliesController extends Controller
{
    /**
     * Get the list of assemblies.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $assemblies = Assembly::all();

        if ($request->acceptsHtml()) {
            return view('assemblies.index_html', compact('assemblies'));

        } elseif ($request->accepts('text/xml')) {

            // We use a Blade view to render the XML tree.
            $xml = view('assemblies.index_xml', compact('assemblies'))->render();

            return response($xml, 200, [
                'Content-Type' => 'text/xml',
            ]);

        } elseif ($request->accepts('text/csv')) {

            // Create file in memory.
            $csv = Writer::createFromFileObject(new SplTempFileObject());

            // Insert the CSV headers.
            $csv->insertOne(['identifier', 'name_en', 'name_fr', 'name_nl']);

            // Insert the data.
            $assemblies->each(function ($item) use ($csv) {
                $csv->insertOne(array_values($item->toArray()));
            });

            // Generate a reponse.
            return response((string) $csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Transfer-Encoding' => 'binary',
            ]);
        }

        // Fall back on JSON by default.
        return Assembly::all();
    }

    /**
     * Get a single assembly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  The identifier of the assembly
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection
     */
    public function show(Request $request, $id)
    {
        $assembly = Assembly::find($id);

        if ($request->acceptsHtml()) {
            return view('assemblies.show_html', compact('assembly'));

        } elseif ($request->accepts('text/xml')) {

            // We use a Blade view to render the XML tree.
            $xml = view('assemblies.show_xml', compact('assembly'))->render();

            return response($xml, 200, [
                'Content-Type' => 'text/xml',
            ]);

        } elseif ($request->accepts('text/csv')) {

            // Create file in memory.
            $csv = Writer::createFromFileObject(new SplTempFileObject());

            // Insert the CSV headers.
            $csv->insertOne(['identifier', 'name_en', 'name_fr', 'name_nl']);

            // Insert the data.
            $csv->insertOne(array_values($assembly->toArray()));

            // Generate a reponse.
            return response((string) $csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Transfer-Encoding' => 'binary',
            ]);
        }

        // Fall back on JSON by default.
        return Assembly::find($id);
    }
}
