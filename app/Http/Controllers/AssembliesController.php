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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $assemblies = Assembly::all();

        return $this->renderResource($assemblies, ['id' => 'identifier']);
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
        $assembly = Assembly::findOrFail($id);

        return $this->renderResource($assembly, ['id' => 'identifier']);
    }
}
