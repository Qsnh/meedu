<script src="{{ asset('js/vendor/inline-attachment/inline-attachment.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('textarea[name="content"]').inlineattachment({
            uploadUrl: '{{ route('upload.image') }}',
            jsonFieldName: 'data'
        });
    });
</script>