@extends('admin.layout')

@php $editing = $item !== null; @endphp

@section('title', ($editing ? 'Edit ' : 'Add ').strtolower($config['singular']))

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.sections.index', $section) }}" class="crumb">← {{ $config['label'] }}</a>
            <h1>{{ $editing ? 'Edit' : 'Add' }} {{ strtolower($config['singular']) }}</h1>
        </div>
    </div>

    <form class="form"
          method="POST"
          enctype="multipart/form-data"
          action="{{ $editing ? route('admin.sections.update', [$section, $item['id']]) : route('admin.sections.store', $section) }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        @foreach ($config['fields'] as $name => $field)
            @php $value = old($name, $item[$name] ?? ''); @endphp

            <div class="field">
                <label for="f-{{ $name }}">
                    {{ $field['label'] }}
                    @if (!empty($field['required'])) <span style="color:var(--orange)">*</span> @endif
                </label>

                @if ($field['type'] === 'textarea')
                    <textarea id="f-{{ $name }}" name="{{ $name }}" rows="4">{{ $value }}</textarea>

                @elseif ($field['type'] === 'select')
                    <select id="f-{{ $name }}" name="{{ $name }}">
                        @foreach ($field['options'] as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @selected((string) $value === (string) $optValue)>{{ $optLabel }}</option>
                        @endforeach
                    </select>

                @elseif ($field['type'] === 'image')
                    <div class="imgfield">
                        @if (!empty($item[$name]))
                            <img class="imgfield__preview" src="{{ asset($item[$name]) }}" alt="">
                        @else
                            <span class="imgfield__preview"></span>
                        @endif
                        <div class="imgfield__ctl">
                            <input id="f-{{ $name }}" type="file" name="{{ $name }}" accept="image/*">
                            <div class="hint">JPG, PNG, WebP or GIF · up to 5&nbsp;MB. Leave empty to keep the current image.</div>
                            @if (!empty($item[$name]))
                                <label class="checkline">
                                    <input type="checkbox" name="remove_{{ $name }}" value="1"> Remove current image
                                </label>
                            @endif
                        </div>
                    </div>

                @elseif ($field['type'] === 'url')
                    <input id="f-{{ $name }}" type="text" name="{{ $name }}" value="{{ $value }}" placeholder="https://…">

                @else
                    <input id="f-{{ $name }}" type="text" name="{{ $name }}" value="{{ $value }}">
                @endif

                @error($name) <div class="err">{{ $message }}</div> @enderror
            </div>
        @endforeach

        <div class="form__actions">
            <button type="submit" class="btn btn--primary">{{ $editing ? 'Save changes' : 'Add '.strtolower($config['singular']) }}</button>
            <a href="{{ route('admin.sections.index', $section) }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection
