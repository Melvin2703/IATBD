@props(['options' => []])

<select name="animal" {!! $attributes->merge(['class' => '']) !!}>
    @foreach($options as $animals => $row)
        <option value="{{ $row->name }}">{{ $row->name }}</option>
    @endforeach
</select>