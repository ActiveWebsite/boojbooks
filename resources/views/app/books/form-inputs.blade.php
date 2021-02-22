@php $editing = isset($book) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            value="{{ old('title', ($editing ? $book->title : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="subtitle"
            label="Subtitle"
            value="{{ old('subtitle', ($editing ? $book->subtitle : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="isbn13"
            label="Isbn13"
            value="{{ old('isbn13', ($editing ? $book->isbn13 : '')) }}"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="price"
            label="Price"
            value="{{ old('price', ($editing ? $book->price : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="image"
            label="Image"
            value="{{ old('image', ($editing ? $book->image : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="url"
            label="Url"
            value="{{ old('url', ($editing ? $book->url : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>

