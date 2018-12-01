<div id="editor">{!! $content ?? '' !!}</div>
<div style="display: none">
    <textarea id="editor-content" name="{{$name ?? 'content'}}"></textarea>
</div>
<script>
    $(function () {
        var $editor1 = new window.wangEditor('#editor');
        var $editorContent = $('#editor-content');
        // 上传图片
        $editor1.customConfig.uploadImgServer = '/backend/upload/image';
        $editor1.customConfig.withCredentials = true;
        $editor1.customConfig.uploadFileName = 'file';
        $editor1.customConfig.uploadImgHooks = {
            customInsert: function (insertImg, result, editor) {
                insertImg(result.url);
            }
        }
        $editor1.customConfig.onchange = function (html) {
            $editorContent.val(html)
        };
        $editor1.create();
        $editorContent.val($editor1.txt.html());
    });
</script>