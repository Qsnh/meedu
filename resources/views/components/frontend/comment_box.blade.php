<div class="col-sm-12">
    <div class="alert alert-primary comment-alert" role="alert">
        <p>1.支持Markdown语法</p>
        <p>2.支持 @ 某个人，格式：<code>@昵称+一个空格</code>，如：<code>@小滕 </code></p>
        <p>3.支持拖拽图片到评论框上传</p>
        <p>4.支持emoji表情</p>
    </div>
</div>

<div class="col-sm-12 comment-box">
    <form method="post" class="form-horizontal" onsubmit="return false">
        {!! csrf_field() !!}
        <div class="form-group">
                <textarea name="content"
                          class="form-control"
                          rows="5"
                          placeholder="评论内容" {{Auth::check() ? '' : 'disabled'}}></textarea>
        </div>
        @if(Auth::check())
            <div class="form-group text-right">
                <button class="btn btn-primary submit-comment" type="button">提交评论</button>
            </div>
        @endif
    </form>
</div>

<script src="{{ asset('js/vendor/inline-attachment/inline-attachment.js') }}"></script>
<script type="text/javascript">
    window.onload = function () {
        $('.submit-comment').click(function () {
            $(this).attr('disabled', true);
            $.post("{{$submitUrl}}", {
                'content': $('textarea[name="content"]').val(),
                '_token': '{{csrf_token()}}'
            }, function (res) {
                $('.submit-comment').removeAttr('disabled');
                if (typeof res.status !== 'undefined' || typeof res.code !== 'undefined') {
                    swal("失败", res.message, "error");
                } else {
                    $('textarea[name="content"]').val('');
                    $('tr.no-record').remove();
                    $('table.comment-list-box tbody').prepend(`<tr class="comment-list-item">
                                   <td width="70" class="user-info">
                                       <p><img class="avatar" src="${res.user.avatar}" width="50" height="50"></p>
                                       <span class="nickname">${res.user.nick_name}</span>
                        </td>
                        <td class="comment-content">
                            <p>${res.content}</p>
                                       <p class="text-right color-gray">${res.created_at}</p>
                                   </td>
                               </tr>`);
                }
            }, 'json');
        });

        $('textarea[name="content"]').inlineAttachment({
            uploadUrl: '{{ route('upload.image') }}',
            jsonFieldName: 'data'
        });
    }
</script>