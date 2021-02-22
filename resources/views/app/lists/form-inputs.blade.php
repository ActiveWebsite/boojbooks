@php $editing = isset($library) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="user_id"
            label="User Id"
            value="{{ old('user_id', ($editing ? $library->user_id : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="book_id"
            label="Book Id"
            value="{{ old('book_id', ($editing ? $library->book_id : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="order"
            label="Order"
            value="{{ old('order', ($editing ? $library->order : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
