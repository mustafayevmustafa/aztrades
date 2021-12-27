<div class="form-group">
    <label for="data-{{$name}}">{{ ucfirst($name)}} {{$label}}</label>
    <input type="{{$type}}" class="form-control" id="data-{{$name}}" name="{{$name}}" value="{{ old($name) ?? $value }}">
    @error($name)
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
