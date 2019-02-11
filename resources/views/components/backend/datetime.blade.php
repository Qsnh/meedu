<input type="text" name="{{$name}}" id="input-{{$name}}" value="{{$value ?? ''}}" class="form-control" required>
<script>
$(function () {
    flatpickr("#input-{{$name}}", {
        enableTime: true,
        dateFormat: "Y-m-d H:i"
    });
});
</script>