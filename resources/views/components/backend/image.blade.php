@if($field = str_replace('*', '_', $name))@endif
<div data-provide="imageUpload"
     data-name="{{$name}}"
     data-field="{{$field}}" class="form-group">
    <div class="form-label">{{$title ?? '选择文件'}}@include('components.backend.required')</div>
    <div class="file-group file-group-inline">
        <button class="btn btn-info file-browser custom-file-label" type="button">选择图片</button>
        <input type="file" class="custom-file-input" id="input-file-{{$field}}">
    </div>
    <div class="mt-2 mb-2">
        <img style="{{isset($value) ? '' : 'display: none'}}" src="{{$value ?? ''}}"
             class="input-file-{{$field}}-preview rounded" width="200" height="120">
    </div>
    <div style="display: none">
        <input type="hidden" name="{{$name}}" value="{{$value ?? ''}}">
    </div>
</div>