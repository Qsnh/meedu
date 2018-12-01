<div class="form-group">
    <div class="form-label">{{$title ?? '选择文件'}}</div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="input-file-{{$name}}">
        <label class="custom-file-label">选择文件</label>
    </div>
    <div class="mt-2 mb-2">
        <img style="{{isset($value) ? '' : 'display: none'}}" src="{{$value ?? ''}}"
             class="input-file-{{$name}}-preview rounded" width="200" height="120">
    </div>
    <div style="display: none">
        <input type="hidden" name="{{$name}}" value="{{$value ?? ''}}">
    </div>
</div>

<script>
    require(['jquery'], function ($) {
        var $key = '#input-file-{{$name}}';
        $($key).change(function () {
            var files = this.files;
            var form = new FormData();
            form.append('file', files[0]);
            $.ajax({
                url:"/backend/upload/image",
                type:"post",
                data:form,
                processData:false,
                contentType:false,
                success:function(res){
                    $('input[name="{{$name}}"]').val(res.url);
                    $('.input-file-{{$name}}-preview').attr('src', res.url).show();
                },
                error:function(err){
                    alert('网络错误');
                    console.log(err);
                }
            })
        });
    })
</script>