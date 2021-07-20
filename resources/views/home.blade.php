@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <b>{{ __('Products') }}</b>
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addProductModal" data-backdrop="static" data-keyboard="false">Add Product</button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>Name</th>
                                    <th class="d-none">User</th>                
                                    <th class="d-none">Description</th>
                                    <th>Pricing</th>
                                    <th>Actions</th>
                                </thead>
                            <tbody>
                                @foreach($products as $item)
                                <tr id="product_{{$item->id}}">
                                    <td style="width: 30%">{{$item->Name}}</td>
                                    <td style="width: 30%" class="d-none">{{$item->user->name}}</td>
                                    <td style="width: 30%" class="d-none">{{$item->Description}}</td>
                                    <td style="width: 30%">{{$item->Pricing}}</td>
                                    <td style="width: 30%">
                                        <div class="btn-group" role="group" aria-label="...">
                                            <a data-id="{{ $item->id }}" onclick="viewProduct(event.target)" class="btn btn-info">VIEW</a>
                                            <a data-id="{{ $item->id }}" onclick="editProduct(event.target)" class="btn btn-warning">EDIT</a>
                                            <a class="btn btn-danger" onclick="deleteProduct({{ $item->id }})">DELETE</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Add Product</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name" class="col-sm-2"><b>Name</b></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                            <span id="nameError" class="alert-message text-danger"></span>
                        </div>
                        <label for="name" class="col-sm-2 pt-3"><b>Description</b></label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="description" rows="3" name="description" placeholder="Enter description"></textarea>
                            <span id="descriptionError" class="alert-message text-danger"></span>
                        </div>
                        <label for="name" class="col-sm-2 pt-3"><b>Pricing</b></label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" id="pricing" placeholder="Enter pricing">
                            </div>
                            <span id="pricingError" class="alert-message text-danger"></span>
                        </div>
                    </div>
                </form>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="addProduct()">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="editProductModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Edit Product</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>
			<div class="modal-body">
                <form>
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2"><b>Name</b></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="editName" name="name" placeholder="Enter name">
                            <span id="nameErrorEdit" class="alert-message text-danger"></span>
                        </div>
                        <label for="name" class="col-sm-2 pt-3"><b>Description</b></label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="editDescription" rows="3" name="description" placeholder="Enter description"></textarea>
                            <span id="descriptionErrorEdit" class="alert-message text-danger"></span>
                        </div>
                        <label for="name" class="col-sm-2 pt-3"><b>Pricing</b></label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" id="editPricing" placeholder="Enter pricing">
                            </div>
                            <span id="pricingErrorEdit" class="alert-message text-danger"></span>
                        </div>
                        <label class="col mt-5">Ultima vez modificado por:</label>
                        <label id="userEdit" class="col font-weight-bold""></label>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="updateProduct()">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewProductModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Product:</b></h4><h4 class="modal-title" id="nameView"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>
			<div class="modal-body">
                <div class="container">
                <div class="row">
                        <div class="col">
                            <b>Precio:</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p id="pricingView" class="text-break"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <b>Descripcion:</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p id="descriptionView" class="text-break"></p>
                        </div>
                    </div>
                </div>
                
                <label class="col mt-3">Ultima vez modificado por:</label>
                <label id="userView" class="col font-weight-bold""></label>
                    
               
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        $("#addProductModal").on("hidden.bs.modal", function(){
            $(this).find("form")[0].reset();
        });
    });
   
    function addProduct() {
        var name = $('#name').val();
        var description = $('#description').val();
        var pricing = $('#pricing').val();

        let _url     = `/product`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $('#nameError').text("");
        $('#descriptionError').text("");
        $('#pricingError').text("");

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                name: name,
                description: description,
                pricing: pricing,
                _token: _token
            },
            success: function(data) {
                $('table tbody').append(`
                    <tr id="product_${data.id}">
                        <td style="width: 30%">${data.Name}</td>
                        <td style="width: 30%" class="d-none">${data.user.name}</td>
                        <td style="width: 30%" class="d-none">${data.Description}</td>
                        <td style="width: 30%">${data.Pricing}</td>
                        <td style="width: 30%">
                            <div class="btn-group" role="group" aria-label="...">
                                <a data-id="${ data.id }" onclick="viewProduct(event.target)" class="btn btn-info">VIEW</a>
                                <a data-id="${ data.id }" onclick="editProduct(event.target)" class="btn btn-warning">EDIT</a>
                                <a class="btn btn-danger" onclick="deleteProduct(${ data.id })">DELETE</a>
                            </div>
                        </td>
                    </tr>
                `);

                $('#addProductModal').modal('hide');
            },
            error: function(response) {
                $('#nameError').text(response.responseJSON.errors.name);
                $('#descriptionError').text(response.responseJSON.errors.description);
                $('#pricingError').text(response.responseJSON.errors.pricing);
            }
        });
    }

    function deleteProduct(id) {
        let url = `/product/${id}`;
        let token   = $('meta[name="csrf-token"]').attr('content');

        if(confirm("Do you want to delete?"))
        {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token
                },
                success: function(response) {
                    $("#product_"+id).remove();
                }
            });
        }
    }

    function editProduct(e) {
        var id  = $(e).data("id");
        var name  = $("#product_"+id+" td:nth-child(1)").html();
        var user  = $("#product_"+id+" td:nth-child(2)").html();
        var description  = $("#product_"+id+" td:nth-child(3)").html();
        var price  = $("#product_"+id+" td:nth-child(4)").html();

        $("#product_id").val(id);
        $("#editName").val(name);
        $('#userEdit').html(user); 
        $("#editDescription").val(description);
        $("#editPricing").val(price);

        $('#editProductModal').modal({backdrop: 'static', keyboard: false})  
        $('#editProductModal').modal('show');
    }

    function updateProduct() {
        var id = $('#product_id').val();

        var name = $('#editName').val();
        var description = $('#editDescription').val();
        var pricing = $('#editPricing').val();

        let _url     = `/product/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "PUT",
            data: {
                id: id,
                name: name,
                description: description,
                pricing: pricing,
                _token: _token
            },
            success: function(data) {
                
                $("#product_"+id+" td:nth-child(1)").html(data.Name);
                $("#product_"+id+" td:nth-child(2)").html(data.user.name);
                $("#product_"+id+" td:nth-child(3)").html(data.Description);
                $("#product_"+id+" td:nth-child(4)").html(data.Pricing);

                $('#product_id').val('');
                $('#editName').val('');
                $('#editDescription').val('');
                $('#editPricing').val('');

                $('#editProductModal').modal('hide');
            },
            error: function(response) {
                $('#nameErrorEdit').text(response.responseJSON.errors.name);
                $('#descriptionErrorEdit').text(response.responseJSON.errors.description);
                $('#pricingErrorEdit').text(response.responseJSON.errors.pricing);
            }
        });
    }

    function viewProduct(e) {
        var id  = $(e).data("id");
        var name  = $("#product_"+id+" td:nth-child(1)").html();
        var user  = $("#product_"+id+" td:nth-child(2)").html();
        var description  = $("#product_"+id+" td:nth-child(3)").html();
        var price  = $("#product_"+id+" td:nth-child(4)").html();

        
        $('#userView').html(user);
        $('#nameView').html('&nbsp'+ name);
        $('#descriptionView').html(description);
        $('#pricingView').html('$'+price);
        $('#viewProductModal').modal('show');
    }

</script>
@endsection
