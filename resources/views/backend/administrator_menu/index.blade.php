@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '后台菜单'])

    <el-row>
        <el-col :span="12" class="mt-15">
            <p class="lh-30">注意：只支持两级目录，超过两级不显示。</p>
            <p class="lh-30">按住节点可调节顺序和层次。修改顺序或者层次之后请点击保存按钮保存。</p>
            <p><el-button type="primary" @click="save">保存</el-button></p>
            <el-tree
                    :data="menus"
                    node-key="id"
                    default-expand-all
                    :props="defaultProps"
                    draggable>
                @verbatim
                <p class="custom-tree-node" slot-scope="{ node, data }">
                    <span>{{ data.name }}</span>
                    <span>
                      <el-button
                              type="text"
                              size="mini"
                              @click="edit(data)">
                        编辑
                      </el-button>
                      <el-button
                              type="text"
                              size="mini"
                              @click="destroy(data)">
                        删除
                      </el-button>
                    </span>
                  </p>
                @endverbatim
            </el-tree>
        </el-col>
        <el-col :span="12" class="mt-15">
            <el-form action="{{route('backend.administrator_menu.create')}}" label-position="top" method="post">
                @csrf
                <el-form-item label="父菜单">
                    <select name="parent_id">
                        <option value="0">无父菜单</option>
                        @foreach($menus as $menu)
                            <option value="{{$menu->id}}">{{$menu->name}}</option>
                            @foreach($menu->children as $child)
                                <option value="{{$child->id}}" disabled="disabled">|----{{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </el-form-item>
                <el-form-item label="排序（升序）">
                    <el-input name="order" value="{{ old('order') }}" placeholder="请输入整数"></el-input>
                </el-form-item>
                <el-form-item label="链接名">
                    <el-input name="name" value="{{ old('name') }}" placeholder="请输入链接名"></el-input>
                </el-form-item>
                <el-form-item label="链接地址">
                    <el-input name="url" value="{{ old('url') }}" placeholder="请输入链接地址"></el-input>
                </el-form-item>
                <el-form-item label="权限">
                    <select name="permission_id">
                        <option value="0">无</option>
                        <option value="-1">超级管理员专属</option>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                        @endforeach
                    </select>
                </el-form-item>
                <el-button type="primary" native-type="submit">添加</el-button>
            </el-form>
        </el-col>
    </el-row>

    <div style="display: none">
        <form action="{{route('backend.administrator_menu.save_change')}}" method="post" id="form">
            @csrf
            <textarea name="data" id="data-input"></textarea>
        </form>
    </div>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    menus: @json($menus),
                    defaultProps: {
                        children: 'children',
                        label: 'name'
                    }
                }
            },
            methods: {
                edit: function (item) {
                    location.href = item.edit_url;
                },
                destroy: function (item) {
                    this.$confirm('确认删除？')
                        .then(function () {
                            location.href = item.destroy_url;
                        })
                        .catch(function () {});
                },
                save: function () {
                    let form = document.getElementById('data-input');
                    form.innerHTML = JSON.stringify(this.menus);
                    document.getElementById('form').submit();
                }
            }
        });
    </script>
@endsection