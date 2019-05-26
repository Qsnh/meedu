<div data-provide="wangEditor" data-dom="#editor-content">{!! $content ?? '' !!}</div>
<div style="display: none">
    <textarea id="editor-content" name="{{$name ?? 'content'}}">{{$content ?? ''}}</textarea>
</div>
