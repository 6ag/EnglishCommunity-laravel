{{-- 提示字符串信息 --}}
@if(is_string($errors))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p>{{ $errors }}</p>
    </div>
@endif

{{-- 提示数组信息 --}}
@if(is_object($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p>{{ $errors->first() }}</p>
    </div>
@endif