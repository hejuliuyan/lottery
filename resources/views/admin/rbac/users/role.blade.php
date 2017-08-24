@extends('admin.public.base')
@section('style')
	<style>
		.result-content {
			width: 50%;
			float: left;
		}

		.result-wrap, .result-one {
			overflow: hidden;
		}

		.licence_pic {
			width: 40%;
			float: left;
			height: 60px;
			text-align: center;
		}

		.licence_pic>div>img {
			/* margin-left:100px;*/

		}

		.licence_pic>div>p {
			text-align: center;
		}
	</style>
@stop
@section('title1')
	用户管理
@stop
@section('title2')
	角色分配
@stop
@section('content')
			<form id="formid" name="myform" method='post'>
				<div class="result-wrap result-one">
					<div class="result-content">
						<table class="insert-tab" width="100%">

							<tbody>

								<tr>

									<td>
                                <?php if(!empty($data)): ?>
                                @foreach($data['rolesAll'] as $v)
                                    <span style="margin-right: 20px;">
											{{$v['display_name']}} <input type="checkbox"
											name="role_list[]" value="{{$v['id']}}"
											@if(in_array($v['id'],$data['roles']))
                                                checked
                                                @endif />
									</span>
                                @endforeach


                                <?php endif; ?>
                                {{--权限<input type="checkbox" name="car"
										value="" />--}}
									</td>
								</tr>


								<tr>

									<td><input type="hidden" name="id" value="{{$id}}" /> <input
										class="btn btn-primary btn6 mr10 ws_fb" value="确认"
										type="submit" id="submit"> <input class="btn btn6"
										onclick="history.go(-1)" value="返回" type="button"></td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</form>
@stop
@section('js')
	<script>
    $("#submit").click(function () {
        $.post("/index.php/ad_user_add_r", $("#formid").serialize(), function (data) {
            //console.info(data);
            if (data == '1') {
                window.location.href = "/index.php/ad_user";
            }
        });
        return false;
    });

</script>
@stop