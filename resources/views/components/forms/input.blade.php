<div class="form-group mr-3 col-12 col-md-2">
    <label for="data-{{$name}}">{{$label ?? ucfirst($name)}}</label>
    <input type="{{$type}}" @if(!$status) readonly @endif class="form-control" id="data-{{$name}}" name="{{$name}}" value="{{ old($name) ?? $value }}">
    @error($name)
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
