<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>任务数据提交</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" type="text/css" media="all" />
    <link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet">
</head>
<body>
<section class="signin-form">
    <div class="overlay">
        <div class="wrapper">
            <div class="logo text-center top-bottom-gap">
                <a class="brand-logo" href="index.html">请填写如下数据</a>
            </div>
            <div class="form34">
                <form action="{{url('/task/add')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="">
                        <span class="text-head">手机号</span>
                        <input type="number" name="username" class="input" placeholder="请输入手机号" />
                    </div>
                    <div class="">
                        <span class="text-head">验证码</span>
                        <input type="number" name="code" class="input" placeholder="请输入验证码"/>
                    </div>
                    <div class="">
                        <span class="text-head">挂号日期</span>
                        <input type="date" name="date" class="input"/>
                    </div>
                    <div class="">
                        <span class="text-head">选择科室</span>
                        <select id="first" onChange="change()" class="input" name="first_dept_code">
                            @foreach(json_decode($data,true)['list'] as $k => $v)
                                <option value="{{$v['code']}}">{{$v['name']}}</option>
                            @endforeach
                        </select>
                        <select id="second" class="input" name="second_dept_code"></select>
                    </div>
                    <div class="">
                        <span class="text-head">挂号时间段</span>
                        <input type="radio" name="duty_code" value="1">上午
                        <input type="radio" name="duty_code" value="2">下午
                        <input type="radio" name="duty_code" value="0">全天
                    </div>
                    <br>
                    <div class="">
                        <span class="text-head">就诊人名称</span>
                        <input type="text" name="patient_name" class="input" placeholder="请输入就诊人名称，需先在 114 平台添加"/>
                    </div>
                    <div class="">
                        <span class="text-head">就诊卡号</span>
                        <input type="text" name="hospital_card_id" class="input" placeholder=""/>
                    </div>
                    <div class="">
                        <span class="text-head">医保卡号</span>
                        <input type="text" name="medicare_card_id" class="input" placeholder=""/>
                    </div>
                    <div class="">
                        <span class="text-head">报销类型</span>
                        <input type="radio" name="reimbursement_type" value="0"/>医保
                        <input type="radio" name="reimbursement_type" value="10"/>自费
                    </div>
                    <br>
                    <div class="">
                        <span class="text-head">是否儿童号</span>
                        <input type="radio" name="children" value="0"/>否
                        <input type="radio" name="children" value="1"/>是
                    </div>
                    <br>
                    <div class="">
                        <span class="text-head">患儿证件</span>
                        <input type="radio" name="cid_type" value="1"/>身份证
                        <input type="radio" name="cid_type" value="2"/>其他
                    </div>
                    <br>
                    <div class="">
                        <span class="text-head">患儿名称</span>
                        <input type="text" name="children_name" class="input"/>
                    </div>
                    <div class="">
                        <span class="text-head">患儿证件号</span>
                        <input type="text" name="children_id_no" class="input"/>
                    </div>
                    <button type="submit" class="signinbutton btn">提交</button>
                </form>
            </div>
        </div>
        <br>
        <div class="wrapper">
            <div class="form34">
                当前执行的任务列表：
                <br>
                @foreach($task_list as $k => $v)
                    用户手机号：<span style="color: red">{{$v['username']}}</span>
                    就诊人名称：<span style="color: red">{{$v['patient_name']}}</span>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
</section>
</body>
<script>
    function change()
    {
        var x = document.getElementById("first");
        var y = document.getElementById("second");
        var list = <?= $data;?>;
        y.options.length = 0; // 清除second下拉框的所有内容
        var select = x.selectedIndex;
        for (var i=0; i< list.valueOf().list[select].subList.length; i++) {
            y.options.add(new Option(list.valueOf().list[select].subList[i].name, list.valueOf().list[select].subList[i].code));
        }
    }
</script>
</html>
