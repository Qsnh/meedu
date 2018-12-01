<div id="editor">{!! $content ?? '' !!}</div>
<div style="display: none">
    <textarea id="editor-content" name="{{$name ?? 'content'}}"></textarea>
</div>
<script>
    require(['wangeditor', 'jquery'], function (E, $) {
        var $editor1 = new E('#editor');
        var $editorContent = $('#editor-content');
        // 上传图片
        $editor1.customConfig.uploadImgServer = '/backend/upload/image';
        $editor1.customConfig.withCredentials = true;
        $editor1.customConfig.uploadFileName = 'file';
        $editor1.customConfig.uploadImgHooks = {
                before: function (xhr, editor, files) {
                },
                success: function (xhr, editor, result) {
                    // 图片上传并返回结果，图片插入成功之后触发
                    // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                },
                fail: function (xhr, editor, result) {
                },
                error: function (xhr, editor) {
                },
                timeout: function (xhr, editor) {
                },
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