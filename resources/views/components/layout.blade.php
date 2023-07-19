<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../resources/css/fonts/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="../resources/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-xxxxx" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</head>

<style>
  .col-end {
    float: right;
  }

  table {
    border: 1px solid #333;
  }

  body {
    font-family: "Odibee Sans", cursive;
  }

  .content {
    margin-top: 100px;
  }

  #list-title {
    font-weight: 500;
    font-size: larger;
    background-color: rgba(0, 0, 0, 0.2);
  }

  .box:hover {
    transform: scale(1.1);
    transition: 0.4s;
  }

  .edit,
  .delete {
    width: 75px;
  }

  .filter {
    float: right;

  }

  .filter li {
    margin: 0 50px;
    display: inline-block;
    list-style-type: none;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropbtn {
    padding: 5px 10px;
    border: none;
    background-color: rgba(0, 0, 0, 0.2);
    box-shadow: 2px 2px 2px gray;
  }

  .add:hover {
    background-color: dodgerblue;
    color: #fff;
  }

  .del:hover {
    background-color: #DD0000;
    color: #fff;
  }

  .del {
    text-decoration: none;
    color: #333;
  }

  .ti-search {
    color: yellow;
  }
</style>

<body>
  <!-- Navbar -->
  <nav class="navbar bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand text-light">Extra Curricular</a>
      <form id="searchForm" class="d-flex" role="search">
        <input id="keyword" name="keyword" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <h1 style="color: #DD0000; margin-top: 100px" id="searchResults"></h1>

  {{ $slot }}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../resources/js/script.js"></script>
  <script>
    $(document).ready(function() {
      $("#keyword").on('keyup', function() {
        var value = $(this).val();
        $.ajax({
          url: "{{ route('extracurriculars.search') }}",
          type: "GET",
          data: {
            'keyword': value
          },
          success: function(data) {
            var extras = data.extracurriculars;
            var html = "";
            if (extras.length > 0) {
              for (let i = 0; i < extras.length; i++) {
                html += `
                <tr id="list" class="ajax">
          <td>
            `+ extras[i]['id'] +` <br>
            <input class="form-check-input" name="ids[]" type="checkbox" value="`+ extras[i]['id'] +`" id="flexCheckDefault">
          </td>
          <td style="max-width: 100%;
  height: auto;"><img style=" width: 100%;
  height: auto;" src="{{URL::asset('img')}}/`+ extras[i]['photo'] +`" class="img-fluid box" alt=""></td>
          <td> <a href="">`+ extras[i]['name'] +`</a></td>
          <td>
          `+ extras[i]['description'] +`
          </td>
          <td> <input type="date" value="`+ extras[i]['start_at'] +`"></td>
          <td>
            <button type="button" class="btn edit btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal`+ extras[i]['id'] +`">
              Edit
            </button>
            <!-- Modal edit -->
            <div class="modal fade" id="exampleModal`+ extras[i]['id'] +`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Extra</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="`+ extras[i]['name'] +`">
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="...">`+ extras[i]['description'] +`</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Start</label>
                        <input type="date" class="form-control" id="start_at" name="start_at" value="`+ extras[i]['start_at'] +`">
                      </div>
                      <div class="row mb-3">
                        <label for="" class="form-label">Upload Image</label>
                        <div class="col-2">
                          <img src="{{URL::asset('img')}}/`+ extras[i]['photo'] +`" alt="" class="preview_img">
                        </div>
                        <div class="col-10">
                          <div class="file-upload clone text-secondary">
                            <input type="file" name="photo" id="photo" class="image" accept="image/*" value="`+ extras[i]['photo'] +`">
                            <span class="fs-4 fw-2">`+ extras[i]['photo'] +`</span>
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
            <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không ?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
                `;
              }
            } else {

            }
            $("#tbody").html(html);
          }
        })
      })
    })
  </script>
</body>

</html>
<!-- tao danh sach category bằng 
ket noi 2 bảng trong categories.php và product.php -->