<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>User Management</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#userModal">Add New User</button>

        <!-- User Table -->
        <div class="container">
            <h1>User List</h1>
            <div id="userTable"></div>  <!-- User table will be rendered here -->
            <div id="paginationLinks"></div>  <!-- Pagination links will be rendered here -->
        </div>

        <!-- User Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" id="closeModel" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="userForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="userId" name="user_id">

                            <!-- Other fields -->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" id="firstName" class="form-control">
                                    <span id="first_name_error" class="text-danger validation-errors"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" id="lastName" class="form-control">
                                    <span id="last_name_error" class="text-danger validation-errors"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                    <span id="email_error" class="text-danger validation-errors"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <span id="gender_error" class="text-danger validation-errors"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hobbies</label><br>
                                <input type="checkbox" name="hobbies[]" value="Reading"> Reading
                                <input type="checkbox" name="hobbies[]" value="Travelling"> Travelling
                                <span id="hobbies_error" class="text-danger validation-errors"></span>
                            </div>

                            <!-- Country Dropdown -->
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label>Country</label><br>
                                    <select id="country" name="country" class="form-control">
                                        <option value="">Select Country</option>
                                    </select>
                                    <span id="country_error" class="text-danger validation-errors" style="font-size: 12px;"></span>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-md-4 mb-3">
                                    <label>State</label><br>
                                    <select id="state" name="state" class="form-control">
                                        <option value="">Select State</option>
                                    </select>
                                    <span id="state_error" class="text-danger validation-errors" style="font-size: 12px;"></span>
                                </div>

                                <!-- City Dropdown -->
                                <div class="col-md-4 mb-3">
                                    <label>City</label><br>
                                    <select id="city" name="city" class="form-control">
                                        <option value="">Select City</option>
                                    </select>
                                    <span id="city_error" class="text-danger validation-errors" style="font-size: 12px;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Technologies</label>
                                <select name="technologies[]" id="technologies" class="form-control" multiple>
                                    <option value="php">PHP</option>
                                    <option value="javascript">JavaScript</option>
                                </select>
                                <span id="technologies_error" class="text-danger validation-errors"></span>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <!-- <img id="userImagePreview" src="" alt="User Image" style="max-width: 100px;" /> -->
                                <div id="show_image"></div>
                                <input type="file" name="image" id="image" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closeModel" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        $(document).ready(function () {
            fetchUsers();

            // Function to fetch users using AJAX
function fetchUsers(page = 1) {
    $.ajax({
        url: '/get-users?page=' + page,  // Adjust the route accordingly
        type: 'GET',
        success: function (response) {
            renderTable(response);  // Render the table with the fetched data
            setupPagination(response);  // Handle pagination
        },
        error: function (xhr) {
            alert('An error occurred while fetching the data');
        }
    });
}

// Render user table
function renderTable(users) {
    var table = '<table class="table table-bordered">';
    table += '<thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>Hobbies</th><th>Country</th><th>State</th><th>City</th><th>Technologies</th><th>Actions</th></tr></thead><tbody>';
    $.each(users.data, function (index, user) {
        table += '<tr>';
        table += '<td>' + user.first_name + '</td>';
        table += '<td>' + user.last_name + '</td>';
        table += '<td>' + user.email + '</td>';
        table += '<td>' + user.gender + '</td>';
        table += '<td>' + user.hobbies.join(", ") + '</td>';
        table += '<td>' + (user.country ? user.country.name : 'N/A') + '</td>';  // Show country name or N/A
        table += '<td>' + (user.state ? user.state.name : 'N/A') + '</td>';    // Show state name or N/A
        table += '<td>' + (user.city ? user.city.name : 'N/A') + '</td>';     // Show city name or N/A
        table += '<td>' + user.technologies.join(", ") + '</td>';
        table += '<td>';
        table += '<button class="btn btn-info btn-sm edit" data-id="' + user.id + '" data-toggle="modal" data-target="#userModal">Edit</button> ';
        table += '<button class="btn btn-danger btn-sm delete" data-id="' + user.id + '">Delete</button>';
        table += '</td>';
        table += '</tr>';
    });
    table += '</tbody></table>';
    $('#userTable').html(table);
}

// Setup pagination links
function setupPagination(users) {
    var pagination = '';
    if (users.last_page > 1) {
        pagination += '<nav><ul class="pagination justify-content-center">';
        for (var i = 1; i <= users.last_page; i++) {
            var activeClass = (i === users.current_page) ? 'active' : '';
            pagination += '<li class="page-item ' + activeClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
        }
        pagination += '</ul></nav>';
    }
    $('#paginationLinks').html(pagination);
}

// Handle pagination click
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    var page = $(this).data('page');
    fetchUsers(page);
});

// Fetch users on page load
$(document).ready(function () {
    fetchUsers();
});



            // Handle form submit
            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var userId = $('#userId').val();
                var url = userId ? '/users/' + userId : '/users';
                var method = userId ? 'POST' : 'POST';

                if (userId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alert(response.success);
                        $('#userForm')[0].reset();
                        $('#userId').val('');
                        $('#userModal').modal('hide');
                        fetchUsers();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            // Clear previous error messages
                            $('.validation-errors').html('');

                            // Loop through and display validation messages
                            $.each(errors, function(key, value) {
                                $('#' + key + '_error').html(value[0]);
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.edit', function () {
            var userId = $(this).data('id');

            // Get the user details
            $.get('/users/' + userId, function (user) {
                $('#userId').val(user.id);
                $('#firstName').val(user.first_name);
                $('#lastName').val(user.last_name);
                $('#email').val(user.email);
                $('#gender').val(user.gender);
                $('#technologies').val(user.technologies).change();
                let hobbies = user.hobbies;  // user.hobbies is an array of selected hobbies
                if (hobbies && hobbies.length > 0) {
                    // Assuming the hobbies are checkboxes with the name 'hobbies[]'
                    $('input[name="hobbies[]"]').each(function () {
                        if (hobbies.includes($(this).val())) {
                            $(this).prop('checked', true);  // Check the hobby if it matches
                        } else {
                            $(this).prop('checked', false); // Uncheck others
                        }
                    });
                }
                $('#userModalLabel').text('Edit User');

                // Set the country value and trigger the change event to load states
                $('#country').val(user.country).change();
                var urls = window.location.origin
                var imageUrl = urls + '/storage/' + user.image; // Only use the relative path, e.g., 'images/...'
                $("#show_image").html('<img src="' + imageUrl + '" width="50" class="img-fluid img-thumbnail">');

                // Load the states once the country is set
                loadStates(user.country, user.state, user.city);
            });
        });

        // Function to load states and cities dynamically
        function loadStates(countryId, selectedStateId, selectedCityId) {
            if (countryId) {
                // Load states based on selected country
                $.get('/get-states/' + countryId, function (data) {
                    $('#state').html('<option value="">Select State</option>');
                    $.each(data, function (index, state) {
                        $('#state').append('<option value="' + state.id + '">' + state.name + '</option>');
                    });

                    // Set the selected state after the states are loaded
                    $('#state').val(selectedStateId).change();

                    // Load the cities for the selected state
                    loadCities(selectedStateId, selectedCityId);
                });
            }
        }

        // Function to load cities based on selected state
        function loadCities(stateId, selectedCityId) {
            if (stateId) {
                // Load cities based on the selected state
                $.get('/get-cities/' + stateId, function (data) {
                    $('#city').html('<option value="">Select City</option>');
                    $.each(data, function (index, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });

                    // Set the selected city after cities are loaded
                    $('#city').val(selectedCityId);
                });
            }
        }

        // Handle update user
        $(document).on('click', '#updateUser', function (e) {
            e.preventDefault();
            var userId = $('#userId').val();
            var formData = new FormData($('#userForm')[0]); // Use FormData for file uploads

            $.ajax({
                url: '/users/' + userId,
                type: 'PUT',
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                success: function (response) {
                    alert(response.success);
                    $('#userModal').modal('hide');
                    fetchUsers(); // Refresh user list
                },
                error: function (xhr) {
                    alert('An error occurred while updating the user.');
                }
            });
        });



    // Handle delete user
    $(document).on('click', '.delete', function () {
        var userId = $(this).data('id');
        if (confirm('Are you sure to delete?')) {
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Add CSRF token here
                },
                success: function (response) {
                    alert(response.success);
                    fetchUsers(); // Refresh user list after deletion
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    });


    // Fetch countries on page load
    $.get('/get-countries', function (data) {
        $('#country').html('<option value="">Select Country</option>');
        $.each(data, function (index, country) {
            $('#country').append('<option value="' + country.id + '">' + country.name + '</option>');
        });
    });

    // Fetch states when country changes
    $('#country').change(function () {
        var countryId = $(this).val();
        if (countryId) {
            $.get('/get-states/' + countryId, function (data) {
                $('#state').html('<option value="">Select State</option>');
                $.each(data, function (index, state) {
                    $('#state').append('<option value="' + state.id + '">' + state.name + '</option>');
                });
                $('#city').html('<option value="">Select City</option>');
            });
        } else {
            $('#state').html('<option value="">Select State</option>');
            $('#city').html('<option value="">Select City</option>');
        }
    });

    // Fetch cities when state changes
    $('#state').change(function () {
        var stateId = $(this).val();
        if (stateId) {
            $.get('/get-cities/' + stateId, function (data) {
                $('#city').html('<option value="">Select City</option>');
                $.each(data, function (index, city) {
                    $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                });
            });
        } else {
            $('#city').html('<option value="">Select City</option>');
        }
    });

    $("#closeModel").click(function() {
        $('#userForm').trigger("reset");
        $('.validation-errors').html('');
    })
});


</script>
</body>
</html>
