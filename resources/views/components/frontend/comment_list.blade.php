<div class="col-sm-12 mt-4 mb-4">
    <div class="card">
        <div class="card-header">
            评论区
        </div>
        <div class="card-body">
            <table class="comment-list-box">
                <tbody>
                @forelse($comments as $comment)
                    <tr class="comment-list-item">
                        <td width="70" class="user-info">
                            <p><img class="avatar" src="{{$comment->user->avatar}}" width="50" height="50"></p>
                            <p class="nickname">{{$comment->user->nick_name}}</p>
                        </td>
                        <td class="comment-content">
                            <p>{!! $comment->getContent() !!}</p>
                            <p class="text-right color-gray">{{$comment->created_at->diffForHumans()}}</p>
                        </td>
                    </tr>
                @empty
                    <tr class="no-record">
                        <td class="text-center color-gray" colspan="2">0评论</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if(!$comments->isEmpty())
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                            <a class="page-link comment-prev-page" href="javascript:void(0)">上一页</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link comment-next-page" href="javascript:void(0)">下一页</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>

<script>
    $(function () {
        var render = function (res) {
            $('table.comment-list-box tbody').html('');
            $.each(res, function (index, item) {
                $('table.comment-list-box tbody').append(`<tr class="comment-list-item">
                                   <td width="70" class="user-info">
                                       <p><img class="avatar" src="${item.user.avatar}" width="50" height="50"></p>
                                       <span class="nickname">${item.user.nick_name}</span>
                        </td>
                        <td class="comment-content">
                            <p>${item.content}</p>
                                       <p class="text-right color-gray">${item.created_at}</p>
                                   </td>
                               </tr>`);
            });
        }

        var page = 1,end = false;
        $('.comment-prev-page').click(function () {
            if (page == 1) {
                swal('警告', '已经是第一页啦', 'warning');
            } else {
                page = page - 1;
                $.getJSON('{{$url}}?page='+page, function (res) {
                    render(res);
                });
            }
        });
        $('.comment-next-page').click(function () {
            if (end == true) {
                page = page - 1;
                swal('警告', '没有数据啦', 'warning');
                return;
            }
            page = page + 1;
            $.getJSON('{{$url}}?page='+page, function (res) {
                if (res.length == 0) {
                    end = true;
                    swal('警告', '没有数据啦', 'warning');
                    return;
                }
                render(res);
            });
        });
    });
</script>