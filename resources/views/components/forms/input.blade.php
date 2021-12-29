<div class="form-group mr-3 col-12 col-md-2">
    <label for="data-{{$name}}">
        {{$label ?? ucfirst($name)}}
        @if(strlen($info) > 0) <i class="mdi mdi-information" data-toggle="tooltip" title="{{$info}}"></i> @endif
    </label>
    <input type="{{$type}}" @if(!$status) readonly @endif class="form-control" id="data-{{$name}}" name="{{$name}}" value="{{ old($name) ?? $value }}">
    @error($name)
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
