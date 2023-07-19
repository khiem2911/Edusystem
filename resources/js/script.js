$(document).ready(function () {
    $("input.image").change(function () {
        var file = this.files[0];
        var url = URL.createObjectURL(file);
        $(this).closest(".row").find(".preview_img").attr("src", url);
    });
});

//
function deleteButton() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire(
                    "Deleted!",
                    "Your file has been deleted.",
                    "success"
                );
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                );
            }
        });
}
//  xử lí delete all
$(function (e) {
    $(".del").click(function (e) {
        e.preventDefault();
        var all_ids = [];
        $("input:checkbox[name=ids]:checked").each(function (e) {
            all_ids.push($(this).val());
        });
        $.ajax({
            url: "{{route('extracurriculars.deleteAll')}}",
            type: "DELETE",
            data: {
                ids: all_ids,
                _token: "{{ csrf_token()}}",
            },
            success: function (response) {
                $.each(all_ids, function (key, val) {
                    $("#flexCheckDefault" + val).remove();
                });
            },
        });
    });
});

// xử lí filter
async function getFilter(){
  const extras = document.querySelector(".ajax");
  extras.innerHTML = "";
  const url = "/extracurriculars/newest";
  const response = await fetch(url);
  const result  = await response.json();
  result.forEach(element => {
    const item = `
         <td>
         ${element.id}<br>
         <input class="form-check-input" name="ids" type="checkbox" value="${element.id}" id="flexCheckDefault">
       </td>
       <td style="max-width: 100%;
 height: auto;"><img style=" width: 100%;
 height: auto;" src="{{URL::asset('img')}}/${element.photo}" class="img-fluid box" alt=""></td>
       <td> <a href="">${element.name}</a></td>
       <td>
       ${element.description}
       </td>
       <td> <input type="date" value="${element.start_at}"></td>
       <td>
         <button type="button" class="btn edit btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal${element.id}">
           Edit
         </button>
         <!-- Modal edit -->
         <div class="modal fade" id="exampleModal${element.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Extra</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                 <form action="{{route('extracurriculars.update', ${element.id})}}" method="post" enctype="multipart/form-data">
                   @csrf
                   @method('PUT')
                   <div class="mb-3">
                     <label for="exampleFormControlInput1" class="form-label">Name</label>
                     <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="${element.name}">
                   </div>
                   <div class="mb-3">
                     <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                     <textarea class="form-control" id="description" name="description" rows="3" placeholder="...">${element.description}</textarea>
                   </div>
                   <div class="mb-3">
                     <label for="exampleFormControlInput1" class="form-label">Start</label>
                     <input type="date" class="form-control" id="start_at" name="start_at" value="${element.start_at}">
                   </div>
                   <div class="row mb-3">
                     <label for="" class="form-label">Upload Image</label>
                     <div class="col-2">
                       <img src="{{URL::asset('img')}}/${element.photo}" alt="" class="preview_img">
                     </div>
                     <div class="col-10">
                       <div class="file-upload clone text-secondary">
                         <input type="file" name="photo" id="photo" class="image" accept="image/*" value="${element.photo}">
                         <span class="fs-4 fw-2">${element.photo}</span>
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
         <form action="{{ route('extracurriculars.destroy', ${element.id}) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không ?')">
           @csrf
           @method('DELETE')
           <button class="btn btn-danger">Delete</button>
         </form>
       </td>
         
         `;
         extras.innerHTML +=item;
  });
}
//xử lí search



