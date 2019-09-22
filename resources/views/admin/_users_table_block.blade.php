<table class="table datatable-basic table-items">
    <tr>
        <th class="id">id</th>
        <th class="text-center">E-mail</th>
        <th class="text-center">Имя</th>
        <th class="text-center">Телефон</th>
        <th class="text-center">Адрес</th>
        @if (Auth::user()->is_admin)
            <th class="text-center">Статус</th>
            <th class="text-center">Администратор</th>
            <th class="text-center">Удалить</th>
        @else
            <th class="text-center">Дата регистрации</th>
            <th class="text-center">Дата последнего изменения</th>
            <th class="text-center">Количество заказов</th>
        @endif
    </tr>
    @foreach ($users as $item)
        <tr role="row" id="{{ 'user_'.(isset($item->user) ? $item->user->id : $item->id) }}">
            <td class="id">{{ $item->id }}</td>
            <td class="text-center"><a href="/admin/users?id={{ isset($item->user) ? $item->user->id : $item->id }}">{{ isset($item->user) ? $item->user->email : $item->email }}</a></td>
            <td class="text-center">@include('admin._exist_or_not_block',['property' => isset($item->user) ? $item->user->name : $item->name])</td>
            <td class="text-center">@include('admin._exist_or_not_block',['property' => isset($item->user) ? $item->user->phone : $item->phone])</td>
            <td class="text-center">@include('admin._exist_or_not_block',['property' => isset($item->user) ? $item->user->address : $item->address])</td>
            @if (Auth::user()->is_admin)
                <td class="text-center">@include('admin._status_block',['status' => isset($item->user) ? $item->user->active : $item->active, 'trueLabel' => 'активен', 'falseLabel' => 'не активен'])</td>
                <td class="text-center">@include('admin._status_block',['status' => isset($item->user) ? $item->user->is_admin : $item->is_admin, 'trueLabel' => 'Админ', 'falseLabel' => 'Пользователь'])</td>
                <td class="delete"><span del-data="{{ isset($item->user) ? $item->user->id : $item->id }}" modal-data="delete-user-modal" class="glyphicon glyphicon-remove-circle"></span></td>
            @else
                <td class="text-center">{{ isset($item->user) ? $item->user->created_at : $item->created_at }}</td>
                <td class="text-center">{{ isset($item->user) ? $item->user->updated_at : $item->updated_at }}</td>
                <td class="text-center">{{ isset($item->user) ? count($item->user->orders) : count($item->orders) }}</td>
            @endif
        </tr>
    @endforeach
</table>