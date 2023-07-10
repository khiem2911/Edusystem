<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Content</th>
            <th>Time start</th>
            <th>Time end</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td class="text-center"><input name='id[]' type="checkbox" id="checkItem" 
                value="{{$item->id}}">
            <td class="align-middle">{{$item->id}}</td>
            <td class="align-middle">{{$item->name}}</td>
            <td class="align-middle">{{$item->content}}</td>
            <td class="align-middle">{{$item->timestart}}</td>
            <td class="align-middle">{{$item->timeend}}</td>
            <td class="align-middle">
                <div class="btn-group" role="group" aria-label="Basic example">
                     <a  href="{{route("editSeminar",$item->id)}}" class="btn btn-warning">Edit</a>
                     <a onclick="return confirm('are you sure you want to delete this ')" href="{{route("deleteSeminar",$item->id)}}" class="btn btn-danger">Delete</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <div class="pagination">
    {!! $data->render()!!}
  </div>