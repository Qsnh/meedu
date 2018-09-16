@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '充值列表'])

    <el-row>
        <el-col :span="12" :offset="6">
            <el-form action="" method="get">
                <el-form-item label="用户呢称/手机号/支付凭证/支付方法">
                    <el-input name="keywords"
                              value="{{ request()->input('keywords', '') }}"
                              placeholder="请输入关键字">
                    </el-input>
                </el-form-item>
                <el-form-item label="状态">
                    <el-select name="status" v-model="status" placeholder="请选择">
                        <el-option
                                v-for="item in statusArr"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" native-type="submit">搜索</el-button>
                    <meedu-a :type="'warning'" :name="'重置'" :url="'{{ route('backend.recharge') }}'"></meedu-a>
                    <el-button type="danger" name="export" native-type="submit">导出当前记录</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <el-col :span="24">
            <el-table :data="records" style="width: 100%">
                <el-table-column
                        prop="user.nick_name"
                        label="呢称">
                </el-table-column>
                <el-table-column
                        prop="user.mobile"
                        label="手机号">
                </el-table-column>
                <el-table-column
                        prop="money"
                        label="充值金额">
                </el-table-column>
                <el-table-column
                        prop="pay_method"
                        label="支付方法">
                </el-table-column>
                <el-table-column
                        prop="third_id"
                        label="支付凭证">
                </el-table-column>
                <el-table-column label="状态">
                    @verbatim
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.status == 9 ? 'success' : 'default'"
                                    disable-transitions>{{scope.row.status == 1 ? '已充值' : '未充值'}}</el-tag>
                        </template>
                    @endverbatim
                </el-table-column>
                <el-table-column
                        prop="updated_at"
                        label="时间">
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

    <meedu-pagination :pagination="remoteData"></meedu-pagination>

@endsection

@section('js')
    <script>
        var pagination = @json($records);
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    statusArr: [
                        {
                            label: '9:已支付',
                            value: '9:已支付'
                        },
                        {
                            label: '1:未支付',
                            value: '1:未支付'
                        }
                    ],
                    remoteData: pagination,
                    status: '{{request()->input('status', '')}}'
                }
            },
            computed: {
                records: function () {
                    return this.remoteData.data;
                }
            }
        });
        (new Page).$mount('#app');
    </script>
@endsection