<table border="5">
    <!-- <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Email</td>
    </tr> -->
    @foreach($data as $item)
        <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
    </tr>
    @endforeach
</table>