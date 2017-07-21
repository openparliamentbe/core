<?xml version="1.0" encoding="UTF-8"?>
<assemblies>
@foreach ($assemblies as $assembly)
    <assembly
        id="{{ $assembly->id }}"
        name_en="{{ $assembly->name_en }}"
        name_fr="{{ $assembly->name_fr }}"
        name_nl="{{ $assembly->name_nl }}"
    />
@endforeach
</assemblies>
