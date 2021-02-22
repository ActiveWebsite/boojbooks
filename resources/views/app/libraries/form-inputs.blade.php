@php $editing = isset($library) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $library->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="book_id" label="Book" required>
            @php $selected = old('book_id', ($editing ? $library->book_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Book</option>
            @foreach($books as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
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
