<footer class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="container footer-box">
                <div class="row">
                    <div class="col-sm-12 friend-link">
                        <h3>友情链接</h3>
                        <ul>
                            <li><a href="https://baidu.com/">百度</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-4">
                        <h3>关于我们</h3>
                        <p>MeEdu是基于Laravel开发的开源的，免费的在线教育点播系统。</p>
                    </div>
                    <div class="col-sm-4">
                        <h3>帮助</h3>
                        <ul>
                            <li><a href="">关于本站</a></li>
                            <li><a href="">本站收费规则</a></li>
                            <li><a href="">为什么本站收费这个价格？</a></li>
                            <li><a href="">关于新会员注册必须知道的事情</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">

                    </div>

                    <div class="col-sm-12">
                        <p>Copyright MeEdu.TV 2018.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</footer>

<div id="app1"></div>
<!-- Scripts -->
<script src="{{ asset('js/frontend.js') }}"></script>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    new Vue({
        el: '#app1',
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
                return;
            }
            if (this.messageWarning) {
                this.$message.warning(this.messageWarning);
                return;
            }
            if (this.messageError) {
                this.$message.warning(this.messageError);
                return;
            }
        }
    });
</script>