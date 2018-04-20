<form action="{{ route('statuses.store') }}" method="post">
    @include('shared._errors')
    {{ csrf_field() }}
    <textarea name="content"  rows="3" placeholder="聊聊新鲜事...." class="form-control">{{ old('content') }}</textarea>
    <button type="submit" class="btn btn-success pull-right">发布</button>
</form>