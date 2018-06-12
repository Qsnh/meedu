<div id="flashMessage"></div>

<script>
    new Vue({
        el: '#flashMessage',
        data: function () {
            return {
                messageSuccess: '{{ get_first_flash('success') }}',
                messageWarning: '{{ get_first_flash('warning') }}',
                messageError: '{{ get_first_flash('errors') }}'
            }
        },
        created: function () {
            if (this.messageSuccess) {
                this.$message.success(this.messageSuccess);
            } else if (this.messageWarning) {
                this.$message.warning(this.messageWarning);
            } else if (this.messageError) {
                this.$message.error(this.messageError);
            }
        }
    });
</script>