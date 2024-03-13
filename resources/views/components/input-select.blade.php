@props(['options' => []])

<select name="animal" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    @foreach($options as $animals => $row)
        <option value="{{ $row->name }}">{{ $row->name }}</option>
    @endforeach
</select>