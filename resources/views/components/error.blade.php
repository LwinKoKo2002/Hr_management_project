@props(['name'])
@error($name)
<p class="text-danger error-message">{{ $message }}</p>
@enderror