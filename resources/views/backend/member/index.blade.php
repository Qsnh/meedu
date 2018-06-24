@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '会员列表'])

    <el-row>
        <el-col :span="12" :offset="6">
            <el-form action="" method="get">
                <el-form-item label="呢称/手机号">
                    <el-input name="keywords"
                              value="{{ request()->input('keywords', '') }}"
                              placeholder="请输入关键字">
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" native-type="submit">搜索</el-button>
                    <meedu-a :type="'warning'" :name="'重置'" :url="'{{ route('backend.member.index') }}'">
                    </meedu-a>
                </el-form-item>
            </el-form>
        </el-col>

        <el-col :span="24">
            <el-table :data="administrators" style="width: 100%">
                <el-table-column type="expand">
                    @verbatim
                        <template slot-scope="props">
                            <div style="line-height: 26px;">
                                <el-row>
                                    <el-col :span="24">
                                        <p>头像</p>
                                        <p><img :src="props.row.avatar" width="240" height="100" alt=""></p>
                                    </el-col>
                                    <el-col :span="8">
                                        <p><b>{{ props.row.credit1_text }}：</b> {{ props.row.credit1 }}</p>
                                    </el-col>
                                    <el-col :span="8">
                                        <p><b>{{ props.row.credit2_text }}：</b> {{ props.row.credit2 }}</p>
                                    </el-col>
                                    <el-col :span="8">
                                        <p><b>{{ props.row.credit3_text }}：</b> {{ props.row.credit3 }}</p>
                                    </el-col>
                                </el-row>
                            </div>
                        </template>
                    @endverbatim
                </el-table-column>
                <el-table-column
                        prop="nick_name"
                        label="呢称">
                </el-table-column>
                <el-table-column
                        prop="mobile"
                        label="手机号">
                </el-table-column>
                <el-table-column label="激活">
                    @verbatim
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.is_active == 1 ? 'success' : 'warning'"
                                    disable-transitions>{{scope.row.is_active == 1 ? '是' : '否'}}</el-tag>
                        </template>
                    @endverbatim
                </el-table-column>
                <el-table-column label="锁定">
                    @verbatim
                    <template slot-scope="scope">
                        <el-tag :type="scope.row.is_lock == 1 ? 'danger' : 'primary'"
                                disable-transitions>{{scope.row.is_active == 1 ? '是' : '否'}}</el-tag>
                    </template>
                    @endverbatim
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="注册时间">
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <meedu-a :size="'mini'" :name="'详情'" :type="'warning'" :url="scope.row.show_url"></meedu-a>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

    <meedu-pagination :pagination="remoteData"></meedu-pagination>

@endsection

@section('js')
    <script>
        var pagination = JSON.parse('@json($members)');
        Vue.mixin({
            data: function () {
                return {
                    remoteData: pagination
                }
            },
            computed: {
                administrators: function () {
                    var data = this.remoteData.data;
                    return data;
                }
            }
        });
    </script>
@endsection