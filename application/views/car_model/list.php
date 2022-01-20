<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD APPLICATION</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
</head>

<body>
    <div class="header">
        <div class="container">
            <h3 class="heading">AJAX CRUD APPLICATION</h3>
        </div>
    </div>
    <div class="container">
        <div class="row pt-4">
            <div class="col-md-6">
                <h4>Car Models</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="javascript:void(0);" onclick="showModal();" class="btn btn-primary">Create</a>
            </div>

            <div class="col-md-12 pt-3">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Transmission</th>
                        <th>Price</th>
                        <th>Created Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    <?php if(!empty($rows)){?>
                        <?php foreach($rows as $row){?>
                            <tr>
                                <td><?php echo $row['id'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['color'];?></td>
                                <td><?php echo $row['transmission'];?></td>
                                <td><?php echo $row['price'];?></td>
                                <td><?php echo $row['created_at'];?></td>
                                <td>
                                    <a href="#" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                <a href="#" class="btn btn-danger">Delete</a>
                                </td>

                            </tr>
                    <?php }?>
                    <?php } else{?>
                        <tr>
                            <td>Records not found</td>
                        </tr>
                        <?php }?>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="createCar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div id="response">

                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxResponseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal() {
            $("#createCar").modal("show");

            $.ajax({
                url: '<?php echo base_url() . 'CarModel/showCreateForm' ?>',
                type: 'POST',
                data: {},
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#response').html(response["html"]);
                }
            });
        }

        $("body").on("submit", "#createCarModel", function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url() . 'CarModel/saveModel' ?>',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {

                    if (response['status'] == 0) {
                        if (response['name'] != "") {
                            $(".nameError").html(response['name']).addClass('invalid-feedback d-block');
                            $("#name").addClass('is-invalid');
                        } else {
                            $(".nameError").html("").removeClass('invalid-feedback d-block');
                            $("#name").removeClass('is-invalid');
                        }

                        if (response['color'] != "") {
                            $(".colorError").html(response['color']).addClass('invalid-feedback d-block');
                            $("#color").addClass('is-invalid');
                        } else {
                            $(".colorError").html("").removeClass('invalid-feedback d-block');
                            $("#color").removeClass('is-invalid');
                        }
                        if (response['price'] != "") {
                            $(".priceError").html(response['price']).addClass('invalid-feedback d-block');
                            $("#price").addClass('is-invalid');
                        } else {
                            $(".priceError").html("").removeClass('invalid-feedback d-block');
                            $("#price").removeClass('is-invalid');
                        }
                    } else {

                        $("#createCar").modal("hide");
                        $("#ajaxResponseModal .model-body").html(response["message"]);
                        $("#ajaxResponseModal").modal("show");


                        $(".nameError").html("").removeClass('invalid-feedback d-block');
                        $("#name").removeClass('is-invalid');

                        $(".colorError").html("").removeClass('invalid-feedback d-block');
                        $("#color").removeClass('is-invalid');

                        $(".priceError").html("").removeClass('invalid-feedback d-block');
                        $("#price").removeClass('is-invalid');
                    }


                }
            });
        });
    </script>

</body>

</html>