<x-layout>
  <!-- sidebar -->



  <div class="content">
    @if($success=Session::get('success'))
    <script>
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: '{{$success}}',
        showConfirmButton: false,
        timer: 1500
      })
    </script>
  </div>
  @endif
  <div class="container">
    <ul class="filter">
      <li>
        <select class="dropbtn">
          <option>Tất cả</option>
          <option>Gần đây nhất</option>
          <option>Cũ nhất</option>
        </select>
      </li>

      <li><button data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" class="dropbtn add"><i class="ti-plus"></i>Add</button> </li>
      <li><a href="#" class="dropbtn del">Delete All Selected</a></li>
      <!-- Modal button Add -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add Extra</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <form action="{{route('extracurriculars.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Name</label>
              <input type="name" class="form-control" id="name" name="name" placeholder="Name">
            </div>
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="..."></textarea>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Start</label>
              <input type="date" class="form-control" id="start_at" name="start_at">
            </div>
            <div class="row mb-3">
              <label for="" class="form-label">Upload Image</label>
              <div class="col-2">
                <img src="{{URL::asset('img')}}/default_user.png" alt="" class="preview_img">
              </div>
              <div class="col-10">
                <div class="file-upload text-secondary">
                  <input type="file" name="photo" id="photo" class="image" accept="image/*">
                  <span class="fs-4 fw-2">Choose file...</span>
                  <span>Kéo thả ảnh vào đây</span>
                </div>
              </div>
            </div>
            <div class="mb-3 end-box">
              <button type="submit" class="btn btn-primary me-1" id="inputBtn">Submit</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </ul>
    <table class="table">
      <thead id="list-title">
        <td>Id</td>
        <td style="width: 200px;">Photo</td>
        <td>Name</td>
        <td>Description</td>
        <td>Start</td>
        <td>Edit Extra</td>
        <td>Delete Extra</td>
      </thead>
      <tbody id="tbody">
        @foreach($extracurriculars as $extracurricular)
        <tr id="list" class="ajax">
          <td>
            {{$extracurricular->id}} <br>
            <input class="form-check-input" name="ids[]" type="checkbox" value="{{$extracurricular->id}}" id="flexCheckDefault">
          </td>
          <td style="max-width: 100%;
  height: auto;"><img style=" width: 100%;
  height: auto;" src="{{URL::asset('img')}}/{{$extracurricular->photo}}" class="img-fluid box" alt=""></td>
          <td> <a href="">{{$extracurricular->name}}</a></td>
          <td>
            {{$extracurricular->description}}
          </td>
          <td> <input type="date" value="{{$extracurricular->start_at}}"></td>
          <td>
            <button type="button" class="btn edit btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal{{$extracurricular->id}}">
              Edit
            </button>
            <!-- Modal edit -->
            <div class="modal fade" id="exampleModal{{$extracurricular->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Extra</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('extracurriculars.update', $extracurricular->id)}}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="{{$extracurricular->name}}">
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="...">{{$extracurricular->description}}</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Start</label>
                        <input type="date" class="form-control" id="start_at" name="start_at" value="{{$extracurricular->start_at}}">
                      </div>
                      <div class="row mb-3">
                        <label for="" class="form-label">Upload Image</label>
                        <div class="col-2">
                          <img src="{{URL::asset('img')}}/{{$extracurricular->photo}}" alt="" class="preview_img">
                        </div>
                        <div class="col-10">
                          <div class="file-upload clone text-secondary">
                            <input type="file" name="photo" id="photo" class="image" accept="image/*" value="{{$extracurricular->photo}}">
                            <span class="fs-4 fw-2">{{$extracurricular->photo}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4 modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
          </td> 
          <td>
            <form action="{{ route('extracurriculars.destroy', $extracurricular->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không ?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>
  <div style="margin-left: 50%; transform: translateX(-50px)">
    {{$extracurriculars->links() }}
  </div>
  </div>
</x-layout>