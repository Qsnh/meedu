<input type="text" name="{{$name}}" id="input-{{$name}}" value="{{$value ?? ''}}" class="form-control">
<script>
require(['flatpickr'], function (i) {
    i("#input-{{$name}}", {
        enableTime: true,
        dateFormat: "Y-m-d H:i"
    });
})
</script>