<?php

namespace App\Http\Controllers;

use SplTempFileObject;
use League\Csv\Writer as CsvWriter;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send a response in a format based on content-negotiation.
     *
     * The `$keyMappings` parameter can be used to replace key names coming from
     * Eloquent by keys that can be more appropriate for a given context.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $resource
     * @param  array|null  $keyMappings
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection
     */
    protected function renderResource($resource, $keyMappings = null)
    {
        $resourceName = $this->findResourceName($resource);

        $renderMethod = 'render'.Request::getRequestFormat();

        if (!method_exists($this, $renderMethod)) {
            throw new Exception("There is no [{$renderMethod}] method.");
        }

        return $this->$renderMethod($resourceName, $resource, $keyMappings);
    }

    /**
     * Retrieve the (plural) name of a resource, based on which controller was called.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $resource
     *
     * @return string
     */
    protected function findResourceName($resource)
    {
        // Use ‘late static binding’ to retrieve the controller the method
        // was called in (instead of getting this very class).
        $controllerClass = class_basename(get_called_class());

        return str_replace('controller', '', strtolower($controllerClass));
    }

    /**
     * Render the given data as a JSON object or array.
     *
     * @param  string  $resourceName
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $data
     * @param  array|null  $keyMappings
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     */
    protected function renderJson($resourceName, $data, $keyMappings = null)
    {
        return $data;
    }

    /**
     * Render the given data as a CSV string.
     *
     * @param  string  $resourceName
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $data
     * @param  array|null  $keyMappings
     *
     * @return \Illuminate\Http\Response
     */
    protected function renderCsv($resourceName, $data, $keyMappings = null)
    {
        // Create a temporary file in memory.
        $csv = CsvWriter::createFromFileObject(new SplTempFileObject());

        // Get the CSV headers.
        if ($data instanceof EloquentCollection) {
            $headers = array_keys($data->first()->toArray());
        } else {
            $headers = array_keys($data->toArray());
        }

        // Apply key mappings if needed. This is useful to replace
        // normal keys coming from Eloquent by keys that can be
        // tailored for a specific purpose.
        foreach (array_wrap($keyMappings) as $oldKeyName => $newKeyName) {
            if (($pos = array_search($oldKeyName, $headers)) !== false) {
                $headers[$pos] = $newKeyName;
            }
        }

        // Insert the CSV headers.
        $csv->insertOne($headers);

        // Insert the data.
        if ($data instanceof EloquentCollection) {
            $data->each(function ($item) use ($csv) {
                $csv->insertOne(array_values($item->toArray()));
            });
        } else {
            $csv->insertOne(array_values($data->toArray()));
        }

        // Generate a reponse.
        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
        ]);
    }

    /**
     * Render the given data as an HTML view.
     *
     * @param  string  $resourceName
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $data
     * @param  array|null  $keyMappings
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function renderHtml($resourceName, $data, $keyMappings = null)
    {
        if ($data instanceof EloquentCollection) {
            return view("{$resourceName}.index_html", [$resourceName => $data]);
        }

        return view("{$resourceName}.show_html", [
            str_singular($resourceName) => $data
        ]);
    }

    /**
     * Render the given data as an XML view.
     *
     * @param  string  $resourceName
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection  $data
     * @param  array|null  $keyMappings
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function renderXml($resourceName, $data, $keyMappings = null)
    {
        // We use a Blade view to render the XML tree.
        if ($data instanceof EloquentCollection) {
            $view = view("{$resourceName}.index_xml", [$resourceName => $data]);
        } else {
            $view = view("{$resourceName}.show_xml", [
                str_singular($resourceName) => $data
            ]);
        }

        return response($view->render(), 200, [
            'Content-Type' => 'text/xml',
        ]);
    }
}
