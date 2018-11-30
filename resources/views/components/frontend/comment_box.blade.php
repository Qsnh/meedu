<div class="col-sm-12">
    <div class="alert alert-primary comment-alert" role="alert">
        <p>1.支持Markdown语法</p>
        <p>2.支持 @ 某个人，格式：<code>@昵称+一个空格</code>，如：<code>@小滕 </code></p>
        <p>3.支持拖拽图片到评论框上传</p>
        <p>4.支持emoji表情</p>
    </div>
</div>

<div class="col-sm-12 comment-box">
    <form action="{{$submitUrl}}" method="post" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="form-group">
                <textarea name="content"
                          class="form-control"
                          rows="5"
                          placeholder="评论内容" {{Auth::check() ? '' : 'disabled'}}></textarea>
        </div>
        @if(Auth::check())
            <div class="form-group text-right">
                <button class="btn btn-primary">提交评论</button>
            </div>
        @endif
    </form>
</div>

<script src="{{ asset('js/vendor/inline-attachment/inline-attachment.js') }}"></script>
<script type="text/javascript">
    window.onload = function () {
        $('textarea[name="content"]').inlineattachment({
            uploadUrl: '{{ route('upload.image') }}',
            jsonFieldName: 'data'
        });
    }
</script>