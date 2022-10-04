@props(['name','type'=>'text','id'=>'','value'=>''])
<x-input_wrapper>
    <x-label :name="$name" />
    <input type="{{$type}}" class="form-control @error('{{$name}}') is-invalid @enderror" id="
    {{$id}}" name="{{$name}}" value="{{old($name,$value)}}" autocomplete="off">
    <x-error :name="$name" />
</x-input_wrapper>